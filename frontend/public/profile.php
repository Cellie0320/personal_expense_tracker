<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}
$username = htmlspecialchars($_SESSION['username']); // Retrieve and sanitize the username

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Retrieve message from session if it exists
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
$messageType = isset($_SESSION['messageType']) ? $_SESSION['messageType'] : '';
$redirect = isset($_SESSION['redirect']) ? $_SESSION['redirect'] : false;
unset($_SESSION['message']);
unset($_SESSION['messageType']);
unset($_SESSION['redirect']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <!-- Link to the CSS file for styling -->
    <link rel="stylesheet" href="profile.css">
    <!-- Link to Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Link to Bootstrap for styling -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Link to jQuery and Bootstrap JS for modal functionality -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Link to the JavaScript file for form validation and password visibility toggle -->
    <script src="script.js"></script>
    <!-- Link to Toastify for toast notifications -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</head>
<body>
    <div class="container">
        <h1>Edit Profile</h1>
        <!-- Display notification message -->
        <?php if ($message) { ?>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Toastify({
                        text: "<?php echo $message; ?>",
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "<?php echo $messageType === 'success' ? 'green' : 'red'; ?>",
                    }).showToast();
                    <?php if ($redirect) { ?>
                        setTimeout(function() {
                            window.location.href = 'login.php';
                        }, 3000);
                    <?php } ?>
                });
            </script>
        <?php } ?>
        <!-- Form for updating username -->
        <form action="../../backend/profile_update.php" method="post">
            <label for="username">New Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $username; ?>" required>
            <button type="submit" name="update_username">Update Username</button>
        </form>
        <br>
        <!-- Form for updating password -->
        <form action="../../backend/profile_update.php" method="post" onsubmit="return validatePassword()">
            <label for="password">New Password:</label>
            <div class="password-container">
                <input type="password" id="password" name="password" required oninput="validatePassword()">
                <i class="fas fa-eye" id="togglePassword" onclick="togglePasswordVisibility('password')"></i>
            </div>
            <div id="passwordMessage"></div>
            <button type="submit" name="update_password">Update Password</button>
        </form>
        <br>
        <!-- Form for deleting profile -->
        <form id="delete-profile-form" action="../../backend/delete_profile.php" method="post">
            <button type="button" class="delete-btn btn btn-danger" data-toggle="modal" data-target="#deleteProfileModal">Delete Profile</button>
        </form>
        <a href="dashboard.php" class="back-to-dashboard">Back to Dashboard</a>
    </div>

    <!-- Delete Profile Modal -->
    <div class="modal fade" id="deleteProfileModal" tabindex="-1" role="dialog" aria-labelledby="deleteProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteProfileModalLabel">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete your profile? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirm-delete-profile">Delete</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>