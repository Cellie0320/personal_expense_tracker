<?php
require_once 'DBConnection.php'; // Ensure $pdo connection is available

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$userId = $_SESSION['user_id'];
$id = $_POST['id'];
$category_id = $_POST['category_id'];
$amount = $_POST['amount'];
$date = $_POST['date'];
$description = $_POST['description'];
$other_category = isset($_POST['other_category']) ? $_POST['other_category'] : null;

$query = "UPDATE expenses SET category_id = :category_id, amount = :amount, date = :date, description = :description, other_category = :other_category WHERE id = :id AND user_id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->execute([
    'category_id' => $category_id,
    'amount' => $amount,
    'date' => $date,
    'description' => $description,
    'other_category' => $other_category,
    'id' => $id,
    'user_id' => $userId
]);

if ($stmt->rowCount() > 0) {
    echo json_encode(["success" => "Expense updated successfully!"]);
} else {
    echo json_encode(["error" => "Failed to update expense."]);
}
?>