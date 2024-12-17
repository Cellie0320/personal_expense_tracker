<?php 
$dsn = 'mysql:host=localhost;dbname=expensetracker';
$dbusername = 'root';
$dbpassword = 'root'; 

/*Created a new PDO instance and assigned it to the $pdo variable, 
which allows me to see if I'm connected to my database */
try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // echo 'Connection successful!'; // just a success message to see if I'm connected to the database
} catch (PDOException $e) {
    //echo 'Connection failed: ' . $e->getMessage();
}
?>

