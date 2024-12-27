<?php
require_once 'DBConnection.php'; // Ensure $pdo connection is available

session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo "Unauthorized: User not logged in.";
    exit;
}

$user_id = $_SESSION['user_id'];

// Delete the user profile
$query = "DELETE FROM users WHERE id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['user_id' => $user_id]);

// Destroy the session
session_destroy();

// Ensure no output before redirection
ob_start();

// Redirect to the index page
header("Location: ../frontend/public/index.php");
ob_end_flush();
exit;
?>