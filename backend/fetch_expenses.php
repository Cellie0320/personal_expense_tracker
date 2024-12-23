<?php
require_once 'DBConnection.php'; // Ensure $pdo connection is available

session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized: User not logged in."]);
    exit;
}

$userId = $_SESSION['user_id'];
$filter = $_GET['filter'] ?? 'month'; // Default to 'month' if no filter is provided

// Determine the date range based on the filter
switch ($filter) {
    case 'week':
        $dateRange = "DATE_SUB(CURDATE(), INTERVAL 1 WEEK)";
        break;
    case 'year':
        $dateRange = "DATE_SUB(CURDATE(), INTERVAL 1 YEAR)";
        break;
    case 'month':
    default:
        $dateRange = "DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
        break;
}

// Fetch expenses for the logged-in user within the date range
$query = "SELECT e.id, e.user_id, e.category_id, c.name as category_name, e.amount, e.date, e.description, e.created_at, SUM(e.amount) as total_amount 
          FROM expenses e
          JOIN categories c ON e.category_id = c.id
          WHERE e.user_id = :user_id AND e.date >= $dateRange 
          GROUP BY e.id, e.user_id, e.category_id, c.name, e.amount, e.date, e.description, e.created_at";
$stmt = $pdo->prepare($query);
$stmt->execute(['user_id' => $userId]);
$expenses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare data for the chart
$labels = [];
$values = [];
foreach ($expenses as $expense) {
    $labels[] = $expense['category_name']; // Use category names as labels
    $values[] = $expense['total_amount'];
}

echo json_encode(['labels' => $labels, 'values' => $values, 'expenses' => $expenses]);
?>