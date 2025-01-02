## Backend Overview

The backend of the Personal Expense Tracker application is built using PHP and MySQL. It handles user authentication, expense management, and data retrieval for various functionalities. The backend interacts with the database through PDO (PHP Data Objects) to ensure secure and efficient database operations.

### Key Features:
- **User Authentication:** Secure login and registration with password hashing.
- **Expense Management:** Add, edit, delete, and view expenses.
- **Data Retrieval:** Fetch expenses, total expenses, and detailed expense information.
- **Data Export:** Export expenses as a CSV file.
- **Profile Management:** Update user profile information and delete user profile.
- **Chart Data:** Retrieve data for generating expense charts.

### Security Considerations:
- **Password Hashing:** Passwords are hashed using `password_hash` before storing in the database.
- **Session Management:** User sessions are managed securely to prevent unauthorized access.
- **Input Validation:** User inputs are validated and sanitized to prevent SQL injection and other attacks.
- **Error Handling:** Errors are logged, and appropriate messages are returned to the client.

## File Descriptions

### 1. [`DBConnection.php`](DBConnection.php)
- **Description:** Establishes a connection to the MySQL database using PDO.
- **Details:** 
  - Defines the DSN, username, and password for the database connection.
  - Sets the PDO error mode to exception for better error handling.

### 2. [`authenticate.php`](authenticate.php)
- **Description:** Handles user authentication by verifying the provided username and password.
- **Details:**
  - Checks if the request method is POST.
  - Retrieves the username and password from the POST request.
  - Authenticates the user by verifying the password against the hashed password stored in the database.
  - Sets session variables upon successful authentication and redirects to the dashboard.

### 3. [`create_account.php`](create_account.php)
- **Description:** Handles user registration by creating a new account with a username, email, and hashed password.
- **Details:**
  - Checks if the request method is POST.
  - Retrieves the username, email, and password from the POST request.
  - Hashes the password and stores the user details in the database.
  - Checks if the username or email already exists before creating a new account.

### 4. [`update_password.php`](update_password.php)
- **Description:** Allows users to update their password.
- **Details:**
  - Checks if the request method is POST.
  - Retrieves the username and new password from the POST request.
  - Hashes the new password and updates it in the database.
  - Redirects the user to the login page with a success message.

### 5. [`profile_update.php`](profile_update.php)
- **Description:** Handles updating the user's profile information, including username and password.
- **Details:**
  - Checks if the user is logged in.
  - Retrieves the new username and password from the POST request.
  - Updates the username and password in the database after validation.
  - Sets session variables and redirects to the profile page with appropriate messages.

### 6. [`add_expense.php`](add_expense.php)
- **Description:** Handles adding a new expense for the authenticated user.
- **Details:**
  - Checks if the user is authenticated.
  - Retrieves the expense details from the POST request.
  - Inserts the new expense into the database and returns a success or error message.

### 7. [`edit_expense.php`](edit_expense.php)
- **Description:** Handles editing an existing expense for the authenticated user.
- **Details:**
  - Checks if the user is authenticated.
  - Retrieves the updated expense details from the POST request.
  - Updates the expense in the database and returns a success or error message.

### 8. [`delete_expense.php`](delete_expense.php)
- **Description:** Handles deleting an expense for the authenticated user.
- **Details:**
  - Checks if the user is authenticated.
  - Retrieves the expense ID from the GET request.
  - Deletes the expense from the database and returns a success message.

### 9. [`view_expenses.php`](view_expenses.php)
- **Description:** Fetches and displays all expenses for the authenticated user.
- **Details:**
  - Checks if the user is authenticated.
  - Retrieves all expenses for the user from the database and renders them as HTML.

### 10. [`get_expenses.php`](get_expenses.php)
- **Description:** Fetches expenses for the authenticated user, either all expenses or a specific expense by ID.
- **Details:**
  - Checks if the user is authenticated.
  - Retrieves expenses from the database and returns them as JSON.

### 11. [`fetch_total_expenses.php`](fetch_total_expenses.php)
- **Description:** Fetches the total expenses for the authenticated user.
- **Details:**
  - Checks if the user is authenticated.
  - Calculates the total expenses from the database and returns the result as JSON.

### 12. [`fetch_expenses.php`](fetch_expenses.php)
- **Description:** Fetches expenses for the authenticated user based on a specified filter (daily, weekly, monthly, yearly).
- **Details:**
  - Checks if the user is authenticated.
  - Retrieves expenses within the specified date range and returns them as JSON.

### 13. [`fetch_expense_details.php`](fetch_expense_details.php)
- **Description:** Fetches detailed expense information for a specified category.
- **Details:**
  - Checks if the user is authenticated.
  - Retrieves expenses for the specified category and returns them as JSON.

### 14. [`get_chart_data.php`](get_chart_data.php)
- **Description:** Fetches data for generating charts based on user expenses.
- **Details:**
  - Checks if the user is authenticated.
  - Retrieves expense data grouped by category and returns it as JSON for chart generation.

### 15. [`export_expense.php`](export_expense.php)
- **Description:** Exports all expenses for the authenticated user as a CSV file.
- **Details:**
  - Checks if the user is authenticated.
  - Retrieves all expenses from the database and outputs them as a CSV file for download.

### 16. [`delete_profile.php`](delete_profile.php)
- **Description:** Deletes the authenticated user's profile and all associated data.
- **Details:**
  - Checks if the user is authenticated.
  - Deletes the user profile from the database.
  - Destroys the session and redirects to the index page.

---

For any issues or contributions, please refer to the project's repository or contact the maintainer.