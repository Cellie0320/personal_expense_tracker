<?php
require_once 'DBConnection.php'; // Ensure $pdo connection is available

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

// Retrieve and sanitize input data
$userId = $_SESSION['user_id'];
$id = $_POST['id'];
$category_id = $_POST['category_id'];
$amount = $_POST['amount'];
$date = $_POST['date'];
$description = $_POST['description'];

// Prepare the SQL query to update the expense
$query = "UPDATE expenses SET category_id = :category_id, amount = :amount, date = :date, description = :description WHERE id = :id AND user_id = :user_id";
$stmt = $pdo->prepare($query);

// Execute the query with the provided data
$stmt->execute([
    'category_id' => $category_id,
    'amount' => $amount,
    'date' => $date,
    'description' => $description,
    'id' => $id,
    'user_id' => $userId
]);

// Check if the update was successful
if ($stmt->rowCount() > 0) {
    echo json_encode(["success" => "Expense updated successfully! Please refresh the page to see the changes."]);
} else {
    echo json_encode(["error" => "Failed to update expense."]);
}
?>