<?php
include 'DBConnection.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    if (user_exists($username, $email, $pdo)) {
        echo "Error: Username or email already exists.  <a href='../frontend/public/login.php'>Login here</a>";
    } else {
        if (create_user($username, $email, $password, $pdo)) {
            echo "Account created successfully. <a href='../frontend/public/login.php'>Login here</a>";
        } else {
            echo "Error: Could not create account.";
        }
    }
}

function user_exists($username, $email, $pdo) {
    $query = "SELECT * FROM users WHERE username = :username OR email = :email";
    $stmt = $pdo->prepare($query);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($pdo->errorInfo()[2]));
    }
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
}

function create_user($username, $email, $password, $pdo) {
    $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
    $stmt = $pdo->prepare($query);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($pdo->errorInfo()[2]));
    }
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    return $stmt->execute();
}
?>