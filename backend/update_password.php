<?php
require_once 'DBConnection.php'; // Ensure $pdo connection is available

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $new_password = $_POST['new_password'];

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the password in the database
    $query = "UPDATE users SET password = :password WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['password' => $hashed_password, 'username' => $username]);

    // Redirect back to the login page
    $_SESSION['message'] = 'Password updated successfully. Please login with your new password.';
    header('Location: ../frontend/public/login.php');
    exit();
}
?>