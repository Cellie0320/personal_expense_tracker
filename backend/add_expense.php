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

// Add a new expense
$category = $_POST['category'];
$amount = $_POST['amount'];
$description = $_POST['description'];

$query = "INSERT INTO expenses (user_id, category, amount, description, date) 
          VALUES (:user_id, :category, :amount, :description, NOW())";
$stmt = $pdo->prepare($query);
$stmt->execute([
    'user_id' => $userId,
    'category' => $category,
    'amount' => $amount,
    'description' => $description,
]);

echo "Expense added successfully!";
?>