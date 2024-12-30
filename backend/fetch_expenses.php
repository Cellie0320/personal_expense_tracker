<?php
// filepath: /c:/Users/User/Downloads/server/UniServerZ/www/personal_expense_tracker/backend/fetch_expenses.php
require_once 'DBConnection.php'; // Ensure $pdo connection is available

session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized: User not logged in."]);
    exit;
}

$userId = $_SESSION['user_id'];
$filter = $_GET['filter'] ?? 'monthly'; // Default to 'monthly' if no filter is provided

// Determine the date range based on the filter
switch ($filter) {
    case 'daily':
        $dateRange = "CURDATE()";
        break;
    case 'weekly':
        $dateRange = "DATE_SUB(CURDATE(), INTERVAL 1 WEEK)";
        break;
    case 'yearly':
        $dateRange = "DATE_SUB(CURDATE(), INTERVAL 1 YEAR)";
        break;
    case 'monthly':
    default:
        $dateRange = "DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
        break;
}

// Fetch expenses for the logged-in user within the date range, aggregated by category
$query = "SELECT c.name AS category_name, SUM(e.amount) AS total_amount 
          FROM expenses e
          JOIN categories c ON e.category_id = c.id
          WHERE e.user_id = :user_id AND e.date >= $dateRange 
          GROUP BY c.name";

$stmt = $pdo->prepare($query);
$stmt->execute(['user_id' => $userId]);
$expenses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare data for the chart
$labels = [];
$values = [];
foreach ($expenses as $expense) {
    $labels[] = htmlspecialchars($expense['category_name'], ENT_QUOTES, 'UTF-8'); // Sanitize category names
    $values[] = floatval($expense['total_amount']); // Convert total_amount to float
}

echo json_encode(['labels' => $labels, 'values' => $values, 'expenses' => $expenses]);
?>