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
    <title>Login - ZARWise</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="script.js"></script>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Login to ZARWise</h1>
            <?php if ($message): ?>
                <p class="error-message"><?php echo $message; ?></p>
            <?php endif; ?>
            <form action="../../backend/authenticate.php" method="post" onsubmit="return handleRememberMe()">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <br>
                <label for="password">Password:</label>
                <div class="password-container">
                    <input type="password" id="password" name="password" required>
                    <i class="fas fa-eye" id="togglePassword" onclick="togglePasswordVisibility('password')"></i>
                </div>
                <button type="submit">Login</button>
                <br>
                <div class="remember-me-container">
                    <input type="checkbox" id="remember-me" name="remember-me">
                    <label for="remember-me">Remember Me</label>
                    <a href="forgot_password.php" class="forgot-password-link">Forgot Password?</a>
                </div>
                <p class="register-link">New user? <a href="register.php">Register here</a></p>
            </form>
        </div>
    </div>
</body>
</html>