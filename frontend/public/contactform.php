<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Retrieve and sanitize the username from the session
$username = htmlspecialchars($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <!-- Link to the CSS file for styling -->
    <link rel="stylesheet" href="contactform.css">
    <!-- Link to the JavaScript file for form validation -->
    <script src="script.js"></script>
</head>
<body>
    <div class="container">
        <h1>Contact Us</h1>
        <!-- Display a message if it is set -->
        <?php if (isset($message)) { echo "<p class='message'>$message</p>"; } ?>
        
        <!-- Contact form -->
        <form id="contactForm" action="mailto:marceldelange20@gmail.com" method="post" enctype="text/plain" onsubmit="return validateEmail()">
            <!-- Username field (read-only) -->
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $username; ?>" readonly>
            
            <!-- Email field -->
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required oninput="validateEmail()">
            <span id="emailMessage"></span> <!-- Message to display the email validation message -->
            
            <!-- Query field -->
            <label for="query">Your Query:</label>
            <textarea id="query" name="query" rows="4" required></textarea>
            
            <!-- Submit button -->
            <button type="submit">Send Query</button>
        </form>
        
        <!-- Link to navigate back to the dashboard -->
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>