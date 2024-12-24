<?php
session_start();
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']); // Clear the message after displaying it
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ZARWise</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="script.js"></script>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Register for ZARWise</h1>
            <?php if ($message): ?>
                <p class="error-message"><?php echo $message; ?></p>
            <?php endif; ?>
            <form action="../../backend/create_account.php" method="post" onsubmit="return validateForm()">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" oninput="validateEmail()" required>
                <span id="emailMessage"></span>
                <br>
                <label for="password">Password:</label>
                <div class="password-container">
                    <input type="password" id="password" name="password" placeholder="Enter your password" oninput="validatePassword()" required>
                    <i class="fas fa-eye" id="togglePassword" onclick="togglePasswordVisibility('password')"></i>
                </div>
                <span id="passwordMessage"></span>
                <br>
                <button type="submit">Register</button>
                <p class="login-link">Already a user? <a href="login.php">Login here</a></p>
            </form>
        </div>
    </div>
</body>
</html>