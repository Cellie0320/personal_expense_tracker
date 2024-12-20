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

// Fetch all expenses for the logged-in user
$query = "SELECT * FROM expenses WHERE user_id = :user_id ORDER BY date DESC";
$stmt = $pdo->prepare($query);
$stmt->execute(['user_id' => $userId]);
$expenses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Render expenses as HTML for the frontend
foreach ($expenses as $expense) {
    echo "<li data-id='{$expense['id']}'>
            {$expense['category']} <span>R {$expense['amount']}</span>
            <button class='edit-btn' data-id='{$expense['id']}'>Edit</button>
            <button class='delete-btn' data-id='{$expense['id']}'>Delete</button>
          </li>";
}
?>