<?php
require_once 'DBConnection.php'; // Ensure $pdo connection is available

session_start();
// Debugging: Check session variables
//var_dump($_SESSION);

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo "Unauthorized: User not logged in.";
    exit;
}

$userId = $_SESSION['user_id'];

if (empty($userId)) {
    http_response_code(403);
    echo "Unauthorized: User ID not found in session.";
    exit;
}

// Add a new expense
$category_id = $_POST['category_id'];
$amount = $_POST['amount'];
$date = $_POST['date'];
$description = $_POST['description'];

// Check if the category is "Other"
if ($category_id === 'other') {
    $other_category = $_POST['other_category'];

    // Insert the new category into the categories table
    $category_query = "INSERT INTO categories (name) VALUES (:name)";
    $category_stmt = $pdo->prepare($category_query);
    $category_stmt->execute(['name' => $other_category]);

    // Get the ID of the newly inserted category
    $category_id = $pdo->lastInsertId();
}

// Debugging: Check the final category_id
//var_dump($category_id);

$query = "INSERT INTO expenses (user_id, category_id, amount, date, description, created_at) 
          VALUES (:user_id, :category_id, :amount, :date, :description, NOW())";
$stmt = $pdo->prepare($query);
$stmt->execute([
    'user_id' => $userId,
    'category_id' => $category_id,
    'amount' => $amount,
    'date' => $date,
    'description' => $description,
]);

echo "Expense added successfully!";
?>