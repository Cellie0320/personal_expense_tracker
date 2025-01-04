// Function to show feedback messages using Toasts
function showFeedbackToast(message, alertClass) {
    const toastBody = $('#toast-body');

    // Set the message and alert class
    toastBody.text(message)
             .removeClass('alert-success alert-danger')
             .addClass(alertClass);

    // Show the toast
    $('#feedbackToast').toast('show');
}

// Function to show feedback messages after updating an expense
function showUpdateFeedbackMessage(message, alertClass) {
    showFeedbackToast(message, alertClass);
}

// Function to show feedback messages after adding an expense
function showAddFeedbackMessage(message, alertClass) {
    showFeedbackToast(message, alertClass);
}

// Function to show feedback messages after deleting an expense
function showDeleteFeedbackMessage(message, alertClass) {
    showFeedbackToast(message, alertClass);
}

$(document).ready(function() {
    let expenseTable;

    /**
     * Initializes the DataTable for the expense table.
     * Called once when the document is ready.
     */
    function initializeDataTable() {
        expenseTable = $('#expense-table').DataTable({
            pageLength: 10,
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
            order: [[4, 'desc']], // Order by date column descending
            responsive: true
        });
    }

    /**
     * Loads all expenses from the backend and populates the expense table.
     */
    function loadExpenses() {
        $.ajax({
            url: '../../backend/get_expenses.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success && response.expenses) {
                    const expenseTableInstance = $('#expense-table').DataTable();

                    expenseTableInstance.clear(); // Clear existing expenses

                    // Iterate through each expense and add to the table
                    response.expenses.forEach(function(expense) {
                        expenseTableInstance.row.add([
                            expense.id,
                            expense.user_id,
                            expense.category_name || 'N/A',
                            `R${parseFloat(expense.amount).toFixed(2)}`,
                            expense.date,
                            expense.description,
                            expense.created_at,
                            `<button class="btn btn-sm btn-primary edit-btn" data-id="${expense.id}">Edit</button>
                             <button class="btn btn-sm btn-danger delete-btn" data-id="${expense.id}">Delete</button>`
                        ]);
                    });

                    expenseTableInstance.draw(); // Redraw the DataTable to reflect changes
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading expenses:', error);
                $('#expense-list').html('<tr><td colspan="8" class="text-center">Error loading expenses</td></tr>');
            }
        });
    }

    /**
     * Handles the click event on the Edit button.
     * Fetches the specific expense details and populates the edit form.
     */
    $(document).on("click", ".edit-btn", function () {
        const id = $(this).data("id"); // Get the expense ID from the data attribute
        $.ajax({
            url: "../../backend/get_expenses.php", // Endpoint to get expense details
            method: "GET",
            data: { id: id }, // Send the expense ID as a parameter
            dataType: 'json',
            success: function (response) {
                if (response.success && response.expenses && response.expenses.length > 0) {
                    const expense = response.expenses[0];
                    $('#edit_expense_id').val(expense.id);
                    $('#edit_category_id').val(expense.category_id);
                    $('#edit_amount').val(parseFloat(expense.amount).toFixed(2));
                    $('#edit_date').val(expense.date);
                    $('#edit_description').val(expense.description);
                    $('#editExpenseModal').modal('show'); // Show the edit modal
                } else {
                    showUpdateFeedbackMessage("Failed to load expense details.", 'alert-danger');
                }
            },
            error: function () {
                showUpdateFeedbackMessage("Failed to fetch expense details. Please try again.", 'alert-danger');
            }
        });
    });

    /**
     * Handles the submission of the Edit Expense form.
     * Sends the updated expense data to the backend for processing.
     */
    $('#edit-expense-form').on('submit', function (e) {
        e.preventDefault(); // Prevent the default form submission

        // Gather form data
        const id = $('#edit_expense_id').val();
        const category_id = $('#edit_category_id').val();
        const amount = $('#edit_amount').val();
        const date = $('#edit_date').val();
        const description = $('#edit_description').val();

        // Send the updated data to the backend
        $.ajax({
            url: "../../backend/edit_expense.php",
            method: "POST",
            data: {
                id: id,
                category_id: category_id,
                amount: amount,
                date: date,
                description: description
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    showUpdateFeedbackMessage("Expense updated successfully!", 'alert-success');
                    $('#editExpenseModal').modal('hide'); // Hide the edit modal
                    loadExpenses(); // Reload the expenses to reflect changes
                } else {
                    showUpdateFeedbackMessage(response.error, 'alert-danger');
                }
            },
            error: function (xhr, status, error) {
                console.error("Failed to update expense:", error);
                showUpdateFeedbackMessage("Failed to update expense. Please try again.", 'alert-danger');
            }
        });
    });

    /**
     * Handles the submission of the Add Expense form.
     * Sends the new expense data to the backend for processing.
     */
    $('#add-expense-form').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission
        
        // Send the new expense data to the backend
        $.ajax({
            url: $(this).attr('action'), // The form's action attribute contains the backend URL
            method: 'POST',
            data: $(this).serialize(), // Serialize the form data
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showAddFeedbackMessage('Expense added! Refresh the dashboard to see changes.', 'alert-success');
                    $('#addExpenseModal').modal('hide'); // Hide the add expense modal
                    $('#add-expense-form')[0].reset(); // Reset the form fields
                    loadExpenses(); // Reload the expenses to include the new entry
                } else {
                    showAddFeedbackMessage(response.error, 'alert-danger');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error adding expense:', error);
                showAddFeedbackMessage('Error adding expense. Please try again.', 'alert-danger');
            }
        });
    });

    /**
     * Handles the click event on the Delete button.
     * Opens the delete confirmation modal with the selected expense ID.
     */
    $(document).on("click", ".delete-btn", function () {
        const id = $(this).data("id"); // Get the expense ID from the data attribute
        $('#delete_expense_id').val(id); // Set the expense ID in the hidden input of the delete modal
        $('#deleteExpenseModal').modal('show'); // Show the delete confirmation modal
    });

    /**
     * Handles the confirmation of deleting an expense.
     * Sends a request to the backend to delete the specified expense.
     */
    $('#confirm-delete-expense').on('click', function () {
        const id = $('#delete_expense_id').val(); // Get the expense ID to delete

        // Send the delete request to the backend
        $.ajax({
            url: `../../backend/delete_expense.php?id=${id}`,
            method: "POST",
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    showDeleteFeedbackMessage("Expense deleted successfully!", 'alert-success');
                    $('#deleteExpenseModal').modal('hide'); // Hide the delete confirmation modal
                    loadExpenses(); // Reload the expenses to reflect deletion
                } else {
                    showDeleteFeedbackMessage(response.error, 'alert-danger');
                }
            },
            error: function (xhr, status, error) {
                console.error("Failed to delete expense:", error);
                showDeleteFeedbackMessage("Failed to delete expense. Please try again.", 'alert-danger');
            }
        });
    });

    /**
     * Handles the click event on the Export button.
     * Redirects the user to the export script to download expenses.
     */
    $(document).on("click", ".btn.export", function () {
        window.location.href = "../../backend/export_expense.php"; // Redirect to the export endpoint
    });

    /**
     * Handles the click event on any row in the expense table.
     * Highlights the selected row.
     */
    $(document).on("click", "#expense-list tr", function () {
        $(this).addClass('selected').siblings().removeClass('selected'); // Highlight the selected row and remove highlighting from others
    });

    // Initial load of expenses when the document is ready
    initializeDataTable(); // Initialize DataTable once
    loadExpenses();
});

