<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}
$username = htmlspecialchars($_SESSION['username']); // Retrieve and sanitize the username
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="contactform.css">
</head>
<body>
    <div class="container">
        <h1>Contact Us</h1>
        <?php if (isset($message)) { echo "<p class='message'>$message</p>"; } ?>
        <form id="contactForm" action="mailto:marceldelange20@gmail.com" method="post" enctype="text/plain" onsubmit="resetForm()">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $username; ?>" readonly>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="query">Your Query:</label>
            <textarea id="query" name="query" rows="4" required></textarea>
            <button type="submit">Send Query</button>
        </form>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
    <script src="script.js"></script>
</body>
</html>