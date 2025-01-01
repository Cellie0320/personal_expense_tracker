<?php
$username = isset($_GET['username']) ? htmlspecialchars($_GET['username']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - ZARWise</title>
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
            <h1>Reset Your Password</h1>
            <!-- Form for resetting the password -->
            <form action="../../backend/update_password.php" method="post" onsubmit="return validateForm()">
                <!-- Username field -->
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $username; ?>" required>
                <br>
                <!-- New Password field with visibility toggle -->
                <label for="new_password">New Password:</label>
                <div class="password-container">
                    <input type="password" id="new_password" name="new_password" placeholder="Enter your new password" oninput="validatePassword()" required>
                    <i class="fas fa-eye" id="togglePassword" onclick="togglePasswordVisibility('new_password')"></i>
                </div>
                <span id="passwordMessage"></span>
                <br>
                <!-- Submit button -->
                <button type="submit">Update Password</button>
            </form>
        </div>
    </div>
</body>
</html>