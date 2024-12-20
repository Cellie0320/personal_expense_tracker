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

// Delete an expense
$id = $_GET['id'];

$query = "DELETE FROM expenses WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $id]);

echo "Expense deleted successfully!";
?>