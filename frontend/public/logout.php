<?php
//destroys the session and redirects the user back to login page
session_start();
session_unset();
session_destroy();
header("Location: login.php");
exit();
?>