<?php
// Starting the session to check if the user is authenticated
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
  <title>Expense Dashboard</title>
  <link rel="stylesheet" href="dashboard.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="logo">
      <img src="img/logo.png" alt="Expense Tracker Logo" class="logo-img">
    </div>

    <nav>
      <ul>
        <li><a href="#">Dashboard</a></li>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="contactform.php">Contact Us</a></li>
        <li><a href="#">Settings</a></li>
      </ul>
    </nav>
    <form action="logout.php" method="post" style="display:inline;">
      <button type="submit" class="logout-btn">Logout</button>
    </form>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <!-- Header -->
    <header class="header">
      <h1>Welcome Back <?php echo $username; ?></h1>
    </header>

    <!-- Chart and Vertical Stats -->
    <div class="content-area">
      <!-- Chart Section -->
      <div class="chart-section">
        <div class="chart">
          <h3>Expenses Overview</h3>
          <p>[Chart Placeholder]</p>
        </div>
      </div>

      <!-- Vertical Stats -->
      <div class="vertical-stats">
        <div class="stat-card">
          <h3>Total Expenses</h3>
          <p>$1,234</p>
        </div>
        <div class="stat-card">
          <h3>Budget</h3>
          <p>$5,000</p>
        </div>
        <div class="stat-card">
          <h3>Savings</h3>
          <p>$3,766</p>
        </div>
      </div>
    </div>
  <!-- Buttons for Expense Management -->
  <div class="expense-management">
      <h3>Manage Expenses</h3>
      <div class="buttons">
      <button class="btn export">Export to CSV</button>
      <button class="btn view" data-toggle="modal" data-target="#expenseModal">View Expenses</button>
        </div>
   <!-- Expense Modal -->
  <div class="modal fade" id="expenseModal" tabindex="-1" role="dialog" aria-labelledby="expenseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="expenseModalLabel">Manage Expenses</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table id="expense-table" class="table table-striped">
            <thead>
              <tr>
              <th>ID</th>
                <th>User ID</th>
                <th>Category ID</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Description</th>
                <th>Created At</th>
              </tr>
            </thead>
            <tbody id="expense-list">
              <!-- Expenses will be dynamically loaded here -->
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary add">Add Expense</button>
          <button type="button" class="btn btn-primary edit">Edit Expense</button>
          <button type="button" class="btn btn-danger delete">Delete Expense</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Footer -->
  <footer>
    <p>&copy; 2024 Expense Tracker. All rights reserved.</p>
  </footer>
</body>
  <script src="ajax.js"></script>
  <script src="script.js"></script>
</html>