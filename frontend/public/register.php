<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ZARWise</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Register for ZARWise</h1>
    <form action="../../backend/create_account.php" method="post">
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
    </form>

    <script src="assets/js/script.js"></script>
</body>
</html>