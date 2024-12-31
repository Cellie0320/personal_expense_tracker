<?php
// Destroys the session and redirects the user back to the login page

session_start(); // Start the session
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

header("Location: login.php"); // Redirect to login page
exit(); // Ensure no further code is executed
?>