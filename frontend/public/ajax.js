$(document).ready(function () {
    // Load Expenses
    const loadExpenses = function () {
        $.ajax({
            url: "../../backend/fetch_expenses.php",
            method: "GET",
            dataType: 'json',
            success: function (data) {
                console.log("Expenses fetched successfully:", data); // Debugging statement
                var expenseList = $('#expense-list');
                expenseList.empty();
                if (data.expenses.length === 0) {
                    expenseList.html("<tr><td colspan='8' class='text-center'>No expenses found. Please add your expenses.</td></tr>");
                } else {
                    data.expenses.forEach(function (expense) {
                        var row = '<tr>' +
                            '<td>' + expense.id + '</td>' +
                            '<td>' + expense.user_id + '</td>' +
                            '<td>' + expense.category_name + '</td>' +
                            '<td>' + expense.amount + '</td>' +
                            '<td>' + expense.date + '</td>' +
                            '<td>' + expense.description + '</td>' +
                            '<td>' + expense.created_at + '</td>' +
                            '<td>' +
                            '<button class="btn btn-primary edit-btn" data-id="' + expense.id + '">Edit</button> ' +
                            '<button class="btn btn-danger delete-btn" data-id="' + expense.id + '">Delete</button>' +
                            '</td>' +
                            '</tr>';
                        expenseList.append(row);
                    });
                }
                refreshChartData(); // Refresh chart data after loading expenses
            },
            error: function (xhr, status, error) {
                console.error("Failed to load expenses:", error);
                $("#expense-list").html("<tr><td colspan='8' class='text-center text-danger'>Failed to load expenses. Please try again later or manually add them</td></tr>");
            }
        });
    };

    // Load expenses when the modal is opened
    $('#expenseModal').on('show.bs.modal', function () {
        loadExpenses();
    });

    // Initial load of expenses
    loadExpenses();

    // Edit Expense
    $(document).on("click", ".edit-btn", function () {
        const id = $(this).data("id");

        // Fetch the expense details
        $.ajax({
            url: "../../backend/get_expense.php",
            method: "GET",
            data: { id: id },
            dataType: 'json',
            success: function (expense) {
                // Populate the edit form with the expense details
                $('#edit_expense_id').val(expense.id);
                $('#edit_category_id').val(expense.category_id);
                $('#edit_amount').val(expense.amount);
                $('#edit_date').val(expense.date);
                $('#edit_description').val(expense.description);

                // Show/hide the "Other" category input
                if (expense.category_id === 'other') {
                    $('#edit-other-category-group').show();
                    $('#edit_other_category').val(expense.other_category);
                } else {
                    $('#edit-other-category-group').hide();
                }

                // Show the modal
                $('#editExpenseModal').modal('show');
            },
            error: function (xhr, status, error) {
                console.error("Failed to fetch expense details:", error);
                alert("Failed to fetch expense details. Please try again.");
            }
        });
    });

    // Save Changes
    $('#edit-expense-form').on('submit', function (e) {
        e.preventDefault();

        const id = $('#edit_expense_id').val();
        const category_id = $('#edit_category_id').val();
        const amount = $('#edit_amount').val();
        const date = $('#edit_date').val();
        const description = $('#edit_description').val();
        const other_category = $('#edit_other_category').val();

        $.ajax({
            url: "../../backend/edit_expense.php",
            method: "POST",
            data: {
                id: id,
                category_id: category_id,
                amount: amount,
                date: date,
                description: description,
                other_category: other_category
            },
            success: function () {
                alert("Expense updated successfully!");
                $('#editExpenseModal').modal('hide');
                loadExpenses();
            },
            error: function (xhr, status, error) {
                console.error("Failed to update expense:", error);
                alert("Failed to update expense. Please try again.");
            }
        });
    });

    // Add Expense
    $('#add-expense-form').on('submit', function (e) {
        e.preventDefault();

        const category_id = $('#category_id').val();
        const amount = $('#amount').val();
        const date = $('#date').val();
        const description = $('#description').val();
        const other_category = $('#other_category').val();

        $.ajax({
            url: "../../backend/add_expense.php",
            method: "POST",
            data: {
                category_id: category_id,
                amount: amount,
                date: date,
                description: description,
                other_category: other_category
            },
            success: function () {
                $('#addExpenseModal').modal('hide');
                $('#expenseAddedModal').modal('show'); // Show the expense added modal
            },
            error: function (xhr, status, error) {
                console.error("Failed to add expense:", error);
                alert("Failed to add expense. Please try again.");
            }
        });
    });

    // Show Delete Confirmation Modal
    $(document).on("click", ".delete-btn", function () {
        const id = $(this).data("id");
        $('#delete_expense_id').val(id);
        $('#deleteExpenseModal').modal('show');
    });

    // Confirm Delete Expense
    $('#confirm-delete-expense').on('click', function () {
        const id = $('#delete_expense_id').val();

        $.ajax({
            url: `../../backend/delete_expense.php?id=${id}`,
            method: "POST",
            success: function () {
                alert("Expense deleted successfully!");
                $('#deleteExpenseModal').modal('hide');
                loadExpenses();
            },
            error: function (xhr, status, error) {
                console.error("Failed to delete expense:", error);
                alert("Failed to delete expense. Please try again.");
            }
        });
    });

    // Export Expenses
    $(document).on("click", ".btn.export", function () {
        window.location.href = "../../backend/export_expense.php";
    });

    // Select row in the expense table
    $(document).on("click", "#expense-list tr", function () {
        $(this).addClass('selected').siblings().removeClass('selected');
    });

    // Refresh chart data when expenses are loaded or modified
    function refreshChartData() {
        const filter = $('#filter-select').val();
        loadChartData(filter);
    }

    // Event listener for filter change
    $('#filter-select').on('change', function () {
        refreshChartData();
    });
});