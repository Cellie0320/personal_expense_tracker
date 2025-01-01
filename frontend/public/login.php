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
    <!-- Link to the CSS file for styling -->
    <link rel="stylesheet" href="style.css">
    <!-- Link to Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Link to the JavaScript file for form validation and password visibility toggle -->
    <script src="script.js"></script>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Login to ZARWise</h1>
            <!-- Display error message if it exists -->
            <?php if ($message): ?>
                <p class="error-message"><?php echo $message; ?></p>
            <?php endif; ?>
            <!-- Login form -->
            <form action="../../backend/authenticate.php" method="post" onsubmit="return handleRememberMe()">
                <!-- Username field -->
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <br>
                <!-- Password field with visibility toggle -->
                <label for="password">Password:</label>
                <div class="password-container">
                    <input type="password" id="password" name="password" required>
                    <i class="fas fa-eye" id="togglePassword" onclick="togglePasswordVisibility('password')"></i>
                </div>
                <button type="submit">Login</button>
                <br>
                <!-- Remember Me and Forgot Password links -->
                <div class="remember-forgot-container">
                    <div class="remember-me-container">
                        <input type="checkbox" id="remember-me" name="remember-me">
                        <label for="remember-me">Remember Me</label>
                    </div>
                    <a href="#" class="forgot-password-link" onclick="redirectToForgotPassword()">Forgot Password?</a>
                </div>
                <!-- Register link for new users -->
                <p class="register-link">New user? <a href="register.php">Register here</a></p>
            </form>
        </div>
    </div>
</body>
</html>