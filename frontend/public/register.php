<?php
session_start();
if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
    unset($_SESSION['message']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ZARWise</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<form action="../../backend/create_account.php" method="post">
    <header>
        <h1>Register for ZARWise</h1>
    </header>
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" placeholder="Enter your email" oninput="validateEmail()" required>
    <span id="emailMessage"></span>
    <br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <button type="submit">Register</button>
    <p class="login-link">Already a user? <a href="login.php">Login here</a></p>
</form>

    <script src="script.js"></script>
</body>
</html>