<?php
session_start();
include 'DBConnection.php'; // imports the $pdo variable and database connection functionality

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Constants for error messages
define('INVALID_CREDENTIALS', 'Invalid username or password. Please try again.');
define('PASSWORD_VERIFICATION_FAILED', 'Password verification failed.');
define('USER_NOT_FOUND', 'No user found with that username.');
define('PREPARE_FAILED', 'Database query preparation failed.');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Authenticate the user
    $user = authenticateUser($username, $password, $pdo);
    if ($user) {
        // Regenerate session ID to prevent session fixation attacks
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: ../frontend/public/dashboard.php"); // Redirect to the dashboard
        exit();
    } else {
        $_SESSION['message'] = INVALID_CREDENTIALS;
        header("Location: ../frontend/public/login.php");
        exit();
    }
}

/**
 * Authenticate the user with the provided username and password.
 *
 * @param string $username
 * @param string $password
 * @param PDO $pdo
 * @return array|false
 */
function authenticateUser($username, $password, $pdo) {
    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($query);
    if ($stmt === false) {
        error_log('Prepare failed: ' . htmlspecialchars($pdo->errorInfo()[2]));
        die(PREPARE_FAILED);
    }
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            return $user; // Return the user data upon successful authentication
        } else {
            error_log(PASSWORD_VERIFICATION_FAILED);
        }
    } else {
        error_log(USER_NOT_FOUND);
    }
    return false;
}
?>