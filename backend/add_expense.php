<?php
require_once 'DBConnection.php';
session_start();

// Check if the user is authenticated
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(["success" => false, "error" => "Unauthorized"]);
    exit();
}

// Handle POST request to add a new expense
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Prepare the SQL statement to insert a new expense
        $stmt = $pdo->prepare("INSERT INTO expenses (user_id, category_id, amount, date, description) VALUES (?, ?, ?, ?, ?)");
        
        // Execute the statement with the provided data
        $result = $stmt->execute([
            $_SESSION['user_id'],
            $_POST['category_id'],
            $_POST['amount'],
            $_POST['date'],
            $_POST['description']
        ]);

        // Check if the insertion was successful
        if ($result) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => "Failed to add expense"]);
        }
    } catch (PDOException $e) {
        // Handle any errors that occur during the insertion
        http_response_code(500);
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
}