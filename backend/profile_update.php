<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../frontend/public/login.php"); // Redirect to login if not logged in
    exit();
}
$username = htmlspecialchars($_SESSION['username']); // Retrieve and sanitize the username

include 'DBConnection.php'; // Included the database connection file

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ensure the session password is set
if (!isset($_SESSION['password'])) {
    // Retrieve the password from the database and set it in the session
    $query = "SELECT password FROM users WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $_SESSION['username']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $_SESSION['password'] = $user['password'];
    } else {
        $_SESSION['message'] = "Session password not set.";
        $_SESSION['messageType'] = "error";
        header("Location: ../frontend/public/profile.php");
        exit();
    }
}

$new_username = isset($_POST['username']) ? $_POST['username'] : '';
$new_password = isset($_POST['password']) ? $_POST['password'] : '';
$update_success = false;

// Check if the new username is the same as the current username
if (!empty($new_username) && $new_username === $_SESSION['username']) {
    $_SESSION['message'] = "New username cannot be the same as the current username.";
    $_SESSION['messageType'] = "error";
    header("Location: ../frontend/public/profile.php");
    exit();
}

// Update the user's username in the database if provided
if (!empty($new_username) && isset($_POST['update_username'])) {
    $query = "UPDATE users SET username = :username WHERE username = :current_username";
    $stmt = $pdo->prepare($query);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($pdo->errorInfo()[2]));
    }
    $stmt->bindParam(':username', $new_username);
    $stmt->bindParam(':current_username', $_SESSION['username']);
    if ($stmt->execute()) {
        $_SESSION['username'] = $new_username; // Update the session username
        $_SESSION['message'] = "Username updated successfully.";
        $_SESSION['messageType'] = "success";
        $update_success = true;
    } else {
        $_SESSION['message'] = "Error updating username.";
        $_SESSION['messageType'] = "error";
    }
}

//work in progress for password update functionality on the profile page

// Debugging
error_log("New password (plain): " . $new_password);
error_log("Session password (hashed): " . $_SESSION['password']);
error_log("password_verify result: " . (password_verify($new_password, $_SESSION['password']) ? "true" : "false"));

// Check if new password is the same as the current hashed password
if (!empty($new_password) && password_verify($new_password, $_SESSION['password'])) {
    $_SESSION['message'] = "New password cannot be the same as the current password.";
    $_SESSION['messageType'] = "error";
    header("Location: ../frontend/public/profile.php");
    exit();
}

// Update the user's password in the database if provided
if (!empty($new_password) && isset($_POST['update_password'])) {
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT); // Hash the new password

    $query = "UPDATE users SET password = :password WHERE username = :current_username";
    $stmt = $pdo->prepare($query);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($pdo->errorInfo()[2]));
    }
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':current_username', $_SESSION['username']);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Password updated successfully. Please log in again.";
        $_SESSION['messageType'] = "success";
        $_SESSION['redirect'] = true; // Set a flag to indicate redirection
        header("Location: ../frontend/public/profile.php");
        exit();
    } else {
        $_SESSION['message'] = "Error updating password.";
        $_SESSION['messageType'] = "error";
        header("Location: ../frontend/public/profile.php");
        exit();
    }
}

if ($update_success) {
    header("Location: ../frontend/public/profile.php");
    exit();
}
?>