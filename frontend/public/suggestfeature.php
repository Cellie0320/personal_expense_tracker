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
    <title>Suggest a Feature</title>
    <link rel="stylesheet" href="suggestfeature.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="white-text">Suggest a Feature</h1>
        <form id="suggest-feature-form" method="get" action="mailto:marceldelange20@gmail.com" enctype="text/plain">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $username; ?>" readonly>
            <label for="title">Feature Title:</label>
            <input type="text" id="title" name="subject" required>
            <label for="description">Feature Description:</label>
            <textarea id="description" name="body" rows="4" required></textarea>
            <button type="submit">Submit</button>
        </form>
        <a href="dashboard.php" class="back-link">Back to Dashboard</a>
    </div>
</body>
</html>