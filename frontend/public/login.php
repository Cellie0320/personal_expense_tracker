<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ZARWise</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to external stylesheet -->
</head>
<body>
    <h1>Login to ZARWise</h1>
    <form action="../../backend/authenticate.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Login</button>
        <p class="register-link">New user? <a href="register.php">Register here</a></p>
    </form>
</body>
</html>