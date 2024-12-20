<?php
require_once 'DBConnection.php'; // Ensure $pdo connection is available

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo "Unauthorized";
    exit;
}

$userId = $_SESSION['user_id'];

// Export all expenses as CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=expenses.csv');

$query = "SELECT * FROM expenses WHERE user_id = :user_id ORDER BY date DESC";
$stmt = $pdo->prepare($query);
$stmt->execute(['user_id' => $userId]);
$expenses = $stmt->fetchAll(PDO::FETCH_ASSOC);

$output = fopen('php://output', 'w');
fputcsv($output, ['Category', 'Amount', 'Description', 'Date']);
foreach ($expenses as $expense) {
    fputcsv($output, [$expense['category'], $expense['amount'], $expense['description'], $expense['date']]);
}
fclose($output);
exit;
?>