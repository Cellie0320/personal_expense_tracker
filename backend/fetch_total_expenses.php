<?php
require_once 'DBConnection.php'; // Ensure $pdo connection is available

session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized: User not logged in."]);
    exit;
}

$userId = $_SESSION['user_id'];

// Fetch total expenses for the logged-in user
$query = "SELECT SUM(amount) as total_expenses FROM expenses WHERE user_id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['user_id' => $userId]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$totalExpenses = $result['total_expenses'] ?? 0;

echo json_encode(['total_expenses' => $totalExpenses]);
?>