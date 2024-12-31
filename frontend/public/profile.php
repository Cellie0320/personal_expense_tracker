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
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
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
</head>
<body>
    <div class="container">
        <h1>Edit Profile</h1>
        <!-- Display message if it exists -->
        <?php if (isset($message)) { echo "<p class='message'>$message</p>"; } ?>
        <!-- Form for updating profile -->
        <form action="profile.php" method="post">
            <label for="username">New Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $username; ?>" required>
            <label for="password">New Password:</label>
            <div class="password-container">
                <input type="password" id="password" name="password" required>
                <i class="fas fa-eye" id="togglePassword" onclick="togglePasswordVisibility('password')"></i>
            </div>
            <button type="submit" name="update_profile">Update Profile</button>
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