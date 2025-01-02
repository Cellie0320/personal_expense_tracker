<?php
session_start();
include 'DBConnection.php';  // imports the $pdo variable and database connection functionality

// Constants for error messages
define('USER_EXISTS_ERROR', 'Username or email already exists. <a href="login.php">Login here</a>');
define('ACCOUNT_CREATION_ERROR', 'Error: Could not create account.');
define('PREPARE_FAILED', 'Database query preparation failed.');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Check if the user already exists
    if (userExists($username, $email, $pdo)) {
        $_SESSION['message'] = USER_EXISTS_ERROR;
        header("Location: ../frontend/public/register.php");
        exit();
    } else {
        // Creates the user
        if (createUser($username, $email, $password, $pdo)) {
            header("Location: ../frontend/public/login.php");
            exit();
        } else {
            $_SESSION['message'] = ACCOUNT_CREATION_ERROR;
            header("Location: ../frontend/public/register.php");
            exit();
        }
    }
}

/**
 * Check if a user with the given username or email already exists.
 *
 * @param string $username
 * @param string $email
 * @param PDO $pdo
 * @return bool
 */
function userExists($username, $email, $pdo) {
    $query = "SELECT * FROM users WHERE username = :username OR email = :email";
    $stmt = $pdo->prepare($query);
    if ($stmt === false) {
        error_log('Prepare failed: ' . htmlspecialchars($pdo->errorInfo()[2]));
        die(PREPARE_FAILED);
    }
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
}

/**
 * Create a new user with the given username, email, and password.
 *
 * @param string $username
 * @param string $email
 * @param string $password
 * @param PDO $pdo
 * @return bool
 */
function createUser($username, $email, $password, $pdo) {
    $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
    $stmt = $pdo->prepare($query);
    if ($stmt === false) {
        error_log('Prepare failed: ' . htmlspecialchars($pdo->errorInfo()[2]));
        die(PREPARE_FAILED);
    }
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    return $stmt->execute();
}
?>