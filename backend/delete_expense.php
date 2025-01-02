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

// Delete an expense
$id = $_GET['id'];

$query = "DELETE FROM expenses WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $id]);
// Check if the expense was deleted
echo json_encode(["success" => "Expense deleted successfully!"]);
?>