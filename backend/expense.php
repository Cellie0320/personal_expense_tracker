<?php
require_once 'DBConnection.php'; // Ensure $pdo connection is available

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo "Unauthorized";
    exit;
}

$userId = $_SESSION['user_id'];

// Handle different expense operations
$action = $_GET['action'] ?? '';
if ($action === 'view') {
    // Fetch all expenses for the logged-in user
    $query = "SELECT * FROM expenses WHERE user_id = :user_id ORDER BY date DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['user_id' => $userId]);
    $expenses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Render expenses as HTML for the frontend
    foreach ($expenses as $expense) {
        echo "<li data-id='{$expense['id']}'>
                {$expense['category']} <span>R {$expense['amount']}</span>
                <button class='edit-btn' data-id='{$expense['id']}'>Edit</button>
                <button class='delete-btn' data-id='{$expense['id']}'>Delete</button>
              </li>";
    }
} elseif ($action === 'add') {
    // Add a new expense
    $category = $_POST['category'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];

    $query = "INSERT INTO expenses (user_id, category, amount, description, date) 
              VALUES (:user_id, :category, :amount, :description, NOW())";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'user_id' => $userId,
        'category' => $category,
        'amount' => $amount,
        'description' => $description,
    ]);
    echo "Expense added successfully!";
} elseif ($action === 'edit') {
    // Edit an existing expense
    $id = $_POST['id'];
    $category = $_POST['category'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];

    $query = "UPDATE expenses SET category = :category, amount = :amount, description = :description WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'category' => $category,
        'amount' => $amount,
        'description' => $description,
        'id' => $id,
    ]);
    echo "Expense updated successfully!";
} elseif ($action === 'delete') {
    // Delete an expense
    $id = $_GET['id'];

    $query = "DELETE FROM expenses WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $id]);
    echo "Expense deleted successfully!";
} elseif ($action === 'export') {
    // Export all expenses as CSV
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=expenses.csv');

    $query = "SELECT * FROM expenses WHERE user_id = :user_id ORDER BY date DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['user_id' => $userId]);
    $expenses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $output = fopen('php://output', 'w');
    fputcsv($output, ['Category', 'Amount', 'Description', 'Date']);
    foreach ($expenses as $expense) {
        fputcsv($output, [$expense['category'], $expense['amount'], $expense['description'], $expense['date']]);
    }
    fclose($output);
    exit;
} else {
    echo "Invalid action!";
}
