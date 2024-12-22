<?php
require_once 'DBConnection.php'; // Ensure $pdo connection is available

session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized: User not logged in."]);
    exit;
}

$userId = $_SESSION['user_id'];

// Fetch expenses for the logged-in user
$query = "SELECT id, user_id, category_id, amount, date, description, created_at FROM expenses WHERE user_id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['user_id' => $userId]);
$expenses = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($expenses);
?>