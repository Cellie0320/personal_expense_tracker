<?php
session_start();
include 'DBConnection.php'; // Include your database connection file

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (authenticate_user($username, $password, $pdo)) {
        $_SESSION['username'] = $username;
        header("Location: ../frontend/public/dashboard.php"); // Redirect to the dashboard
        exit();
    } else {
        echo "Invalid username or password.";
    }
}

function authenticate_user($username, $password, $pdo) {
    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($query);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($pdo->errorInfo()[2]));
    }
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            return true;
        } else {
            echo "Password verification failed.";
        }
    } else {
        echo "No user found with that username.";
    }
    return false;
}
?>