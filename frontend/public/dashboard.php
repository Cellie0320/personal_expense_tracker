<?php
// Starting the session to check if the user is authenticated
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}
$username = htmlspecialchars($_SESSION['username']); // Retrieve and sanitize the username
$currentYear = date("Y"); // Get the current year
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Expense Dashboard</title>
  <link rel="stylesheet" href="dashboard.css">
  <!-- External CSS and JS Libraries -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  
  <!-- External JS Files -->
  <script src="chart.js"></script>
  <script src="ajax.js"></script>
  <script src="script.js"></script>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="logo">
      <img src="img/logo.png" alt="Expense Tracker Logo" class="logo-img">
    </div>

    <nav>
      <ul>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="contactform.php">Contact Us</a></li>
        <li><a href="suggestfeature.php">Suggest a Feature</a></li>
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
          <h3 class="expenses-overview-title">Expenses Overview</h3>
          <select id="filter-select" class="form-control mb-3">
            <option value="daily">Daily</option>
            <option value="weekly">Weekly</option>
            <option value="monthly" selected>Monthly</option>
            <option value="yearly">Yearly</option>
          </select>
          <div class="chart-container">
            <canvas id="expenseChart"></canvas>
          </div>
        </div>
      </div>

      <!-- Vertical Stats -->
      <div class="vertical-stats">
        <div class="stat-card">
          <h3>Total Expenses</h3>
          <p id="total-expenses">R0</p>
        </div>
        <div class="stat-card">
          <h3>Budget</h3>
          <input type="number" id="budget-input" placeholder="Enter your budget" />
          <div class="budget-buttons">
            <!--<button id="budget-ok" class="btn">OK</button>-->
            <!--<button id="budget-cancel" class="btn">Cancel</button>-->
          </div>
        </div>
        <div class="stat-card">
          <h3>Savings</h3>
          <p id="savings">R0</p>
        </div>
      </div>
    </div>

    <!-- Buttons for Expense Management -->
    <div class="expense-management">
      <div class="buttons">
        <button class="btn export">Export to CSV</button>
        <button class="btn view" data-toggle="modal" data-target="#expenseModal">View Expenses</button>
      </div>
    </div>

    <!-- Table Modal -->
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
            <div class="table-container">
              <table id="expense-table" class="table table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Created At</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody id="expense-list">
                  <!-- Expenses will be dynamically loaded here -->
                </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn-primary-add" data-toggle="modal" data-target="#addExpenseModal">Add Expense</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Add Expense Modal -->
    <div class="modal fade" id="addExpenseModal" tabindex="-1" role="dialog" aria-labelledby="addExpenseModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addExpenseModalLabel">Add Expense</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="add-expense-form" action="../../backend/add_expense.php" method="POST">
              <div class="form-group">
                <label for="category_id">Category</label>
                <select class="form-control" id="category_id" name="category_id" required>
                  <option value="1">Food</option>
                  <option value="2">Transport</option>
                  <option value="3">Entertainment</option>
                  <option value="4">Groceries</option>
                  <option value="5">Utilities</option>
                  <option value="6">Clothing</option>
                  <option value="7">Healthcare</option>
                </select>
              </div>
              <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" class="form-control" id="amount" name="amount" required>
              </div>
              <div class="form-group">
                <label for="date">Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
              </div>
              <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
              </div>
              <button type="submit" class="btn-primary-add">Add Expense</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Expense Modal -->
    <div class="modal fade" id="editExpenseModal" tabindex="-1" role="dialog" aria-labelledby="editExpenseModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editExpenseModalLabel">Edit Expense</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="edit-expense-form" action="../../backend/edit_expense.php" method="POST">
              <input type="hidden" id="edit_expense_id" name="id">
              <div class="form-group">
                <label for="edit_category_id">Category</label>
                <select class="form-control" id="edit_category_id" name="category_id" required>
                  <option value="1">Food</option>
                  <option value="2">Transport</option>
                  <option value="3">Entertainment</option>
                  <option value="4">Groceries</option>
                  <option value="5">Utilities</option>
                  <option value="6">Clothing</option>
                  <option value="7">Healthcare</option>
                </select>
              </div>
              <div class="form-group">
                <label for="edit_amount">Amount</label>
                <input type="number" class="form-control" id="edit_amount" name="amount" required>
              </div>
              <div class="form-group">
                <label for="edit_date">Date</label>
                <input type="date" class="form-control" id="edit_date" name="date" required>
              </div>
              <div class="form-group">
                <label for="edit_description">Description</label>
                <textarea class="form-control" id="edit_description" name="description" required></textarea>
              </div>
              <button type="submit" class="btn-primary-add">Save Changes</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete Expense Modal -->
    <div class="modal fade" id="deleteExpenseModal" tabindex="-1" role="dialog" aria-labelledby="deleteExpenseModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteExpenseModalLabel">Confirm Delete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Are you sure you want to delete this expense?
            <input type="hidden" id="delete_expense_id" name="id">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" id="confirm-delete-expense" class="btn btn-danger">Delete</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Toast Notification -->
    <div aria-live="polite" aria-atomic="true" style="position: fixed; top: 20px; right: 20px; min-width: 250px; z-index: 1060;">
      <div id="feedbackToast" class="toast" data-delay="3000">
        <div class="toast-header">
          <strong class="mr-auto">Notification</strong>
          <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="toast-body" id="toast-body">
          <!-- Feedback message will be added here -->
        </div>
      </div>
    </div>

    <!-- Expense Details Modal for viewing expense in the chart when clicking on a specific data bar -->
    <div class="modal fade" id="expenseDetailsModal" tabindex="-1" role="dialog" aria-labelledby="expenseDetailsModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="expenseDetailsModalLabel">Expense Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- Expense details will be loaded here -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer>
      <p>&copy; <?php echo $currentYear; ?> ZARWISE. All rights reserved.</p>
    </footer>
  </div>
</body>
</html>