<?php
require_once 'DBConnection.php';  // imports the $pdo variable and database connection functionality

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$userId = $_SESSION['user_id'];
$filter = $_GET['filter'];

// Fetch chart data based on the filter
$query = "SELECT category, SUM(amount) as total_amount FROM expenses WHERE user_id = :user_id GROUP BY category";
$stmt = $pdo->prepare($query);
$stmt->execute(['user_id' => $userId]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$labels = [];
$values = [];

foreach ($results as $row) {
    $labels[] = $row['category'];
    $values[] = $row['total_amount'];
}

echo json_encode(['labels' => $labels, 'values' => $values]);
?>