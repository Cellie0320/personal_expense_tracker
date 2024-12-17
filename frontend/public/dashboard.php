<?php
//starting the session to check if the user is authenticated
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
        <li><a href="#">Expenses</a></li>
        <li><a href="#">Reports</a></li>
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
      <div class="user-profile">
      <i class="fa fa-user-circle user-icon"></i>
      <button class="edit-profile-btn">Edit Profile</button>
      </div>
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
        <button class="btn view">View Expenses</button>
        <button class="btn add">Add</button>
        <button class="btn edit">Edit</button>
        <button class="btn delete">Delete</button>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    <p>&copy; 2024 Expense Tracker. All rights reserved.</p>
  </footer>
</body>
</html>
