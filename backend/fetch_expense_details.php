<?php
require_once 'DBConnection.php';  // imports the $pdo variable and database connection functionality

session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized: User not logged in."]);
    exit;
}

$userId = $_SESSION['user_id'];
$category = $_GET['category'] ?? ''; // Get the category from the query parameter

// Validate category input
if (empty($category)) {
    echo json_encode(["error" => "Invalid category specified."]);
    exit;
}

// Fetch expense details for the specified category
$query = "SELECT description, amount, date 
          FROM expenses e
          JOIN categories c ON e.category_id = c.id
          WHERE e.user_id = :user_id AND c.name = :category
          ORDER BY date DESC";
$stmt = $pdo->prepare($query);
$stmt->execute(['user_id' => $userId, 'category' => $category]);
$expenses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if expenses exist
if (!$expenses) {
    echo json_encode([]);
    exit;
}

echo json_encode($expenses);
?>