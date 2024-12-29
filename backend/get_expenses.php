<?php
require_once 'DBConnection.php';
session_start();

// Check if the user is authenticated
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(["success" => false, "error" => "Unauthorized access."]);
    exit();
}

$userId = $_SESSION['user_id'];

// Check if an 'id' parameter is provided to fetch a single expense
if (isset($_GET['id'])) {
    $expenseId = $_GET['id'];

    // Prepare the SQL query to fetch a specific expense
    $query = "SELECT e.*, c.name AS category_name
              FROM expenses e
              LEFT JOIN categories c ON e.category_id = c.id
              WHERE e.user_id = :user_id AND e.id = :expense_id
              LIMIT 1";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'user_id' => $userId,
            'expense_id' => $expenseId
        ]);
        $expense = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($expense) {
            echo json_encode(['success' => true, 'expenses' => [$expense]]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Expense not found.']);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    // If no 'id' is provided, fetch all expenses for the user
    $query = "SELECT e.*, c.name AS category_name
              FROM expenses e
              LEFT JOIN categories c ON e.category_id = c.id
              WHERE e.user_id = :user_id
              ORDER BY e.date DESC";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute(['user_id' => $userId]);
        $expenses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'expenses' => $expenses]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
    }
}
?>