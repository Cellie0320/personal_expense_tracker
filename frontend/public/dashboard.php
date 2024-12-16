<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZarWise Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery -->
</head>
<body>
    <!-- Header -->
    <?php include 'templates/header.php'; ?>

    <!-- Navbar -->
    <?php include 'templates/navbar.php'; ?>

    <!-- Dashboard Layout -->
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <?php include 'templates/sidebar.php'; ?>
        </aside>

<!-- Main Content -->
<main class="main-content">
    <!-- Expense Chart Section -->
    <section class="card chart-section">
        <h2>Expense Overview</h2>
        <div class="chart-container">
            <canvas id="expenseChart"></canvas>
        </div>
    </section>

    <!-- Expense List Section -->
    <section class="card expense-list">
        <h2>Your Expenses</h2>
        <ul id="expense-list">
            <!-- Dynamic Expense Items -->
        </ul>
        <button id="add-expense-btn" class="action-btn">Add Expense</button>
        <button id="export-csv-btn" class="action-btn">Export CSV</button>
    </section>
</main>
    </div>

    <!-- Feedback Form Section -->
    <footer class="feedback-form card">
        <h2>Submit Feedback</h2>
        <form id="feedback-form" action="/backend/controllers/FeedbackController.php" method="POST">
            <label for="feedback">Your Message:</label>
            <textarea id="feedback" name="feedback" rows="3" required></textarea>
            <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" required>
            <button type="submit" class="action-btn">Submit</button>
        </form>
    </footer>
    <?php include 'templates/footer.php'; ?>
</body>

<script src="chart.config.js"></script> <!-- Correct path to chart.config.js -->
<script src="ajax.js"></script> <!-- Correct path to ajax.js -->
</html>