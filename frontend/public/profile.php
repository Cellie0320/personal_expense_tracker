<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}
$username = htmlspecialchars($_SESSION['username']); // Retrieve and sanitize the username

include '../../backend/DBConnection.php'; // Include your database connection file

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = $_POST['username'];
    $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the new password

    // Update the user's information in the database
    $query = "UPDATE users SET username = :username, password = :password WHERE username = :current_username";
    $stmt = $pdo->prepare($query);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($pdo->errorInfo()[2]));
    }
    $stmt->bindParam(':username', $new_username);
    $stmt->bindParam(':password', $new_password);
    $stmt->bindParam(':current_username', $_SESSION['username']);
    if ($stmt->execute()) {
        $_SESSION['username'] = $new_username; // Update the session username
        $message = "Profile updated successfully.";
    } else {
        $message = "Error updating profile.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <div class="container">
        <h1>Edit Profile</h1>
        <?php if (isset($message)) { echo "<p class='message'>$message</p>"; } ?>
        <form action="profile.php" method="post">
            <label for="username">New Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $username; ?>" required>
            <label for="password">New Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Update Profile</button>
            <a href="dashboard.php">Back to Dashboard</a>
        </form>
    </div>
</body>
</html>