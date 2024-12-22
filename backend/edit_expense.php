<?php
require_once 'DBConnection.php'; // Ensure $pdo connection is available

session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo "Unauthorized: User not logged in.";
    exit;
}

$id = $_POST['id'];
$category_id = $_POST['category_id'];
$amount = $_POST['amount'];
$date = $_POST['date'];
$description = $_POST['description'];
$other_category = $_POST['other_category'];

// Check if the category is "Other"
if ($category_id === 'other') {
    // Insert the new category into the categories table
    $category_query = "INSERT INTO categories (name) VALUES (:name)";
    $category_stmt = $pdo->prepare($category_query);
    $category_stmt->execute(['name' => $other_category]);

    // Get the ID of the newly inserted category
    $category_id = $pdo->lastInsertId();
}

// Update the expense
$query = "UPDATE expenses SET category_id = :category_id, amount = :amount, date = :date, description = :description WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute([
    'category_id' => $category_id,
    'amount' => $amount,
    'date' => $date,
    'description' => $description,
    'id' => $id
]);

echo "Expense updated successfully.";
?>