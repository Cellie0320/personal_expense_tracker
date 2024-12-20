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

// Edit an existing expense
$id = $_POST['id'];
$category = $_POST['category'];
$amount = $_POST['amount'];
$description = $_POST['description'];

$query = "UPDATE expenses SET category = :category, amount = :amount, description = :description WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute([
    'category' => $category,
    'amount' => $amount,
    'description' => $description,
    'id' => $id,
]);

echo "Expense updated successfully!";
?>