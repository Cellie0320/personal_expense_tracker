<?php
require_once 'DBConnection.php'; // Ensure $pdo connection is available

session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized: User not logged in."]);
    exit;
}

$id = $_GET['id'];

if (!$id) {
    http_response_code(400);
    echo json_encode(["error" => "Bad Request: Missing expense ID."]);
    exit;
}

// Fetch the expense details
$query = "SELECT id, category_id, amount, date, description FROM expenses WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $id]);
$expense = $stmt->fetch(PDO::FETCH_ASSOC);

if ($expense) {
    echo json_encode($expense);
} else {
    http_response_code(404);
    echo json_encode(["error" => "Expense not found."]);
}
?>