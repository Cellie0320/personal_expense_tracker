$(document).ready(function () {
    // Load Expenses
    const loadExpenses = function () {
        $.ajax({
            url: "../../backend/view_expenses.php",
            method: "GET",
            success: function (data) {
                if (data.trim() === "") {
                    $("#expense-list").html("<tr><td colspan='8' class='text-center'>No expenses found. Please add your expenses.</td></tr>");
                } else {
                    $("#expense-list").html(data);
                }
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

    // Add Expense
    $(document).on("click", ".btn.add", function () {
        const category = prompt("Enter category:");
        const amount = prompt("Enter amount:");
        const description = prompt("Enter description:");
        const user_id = "<?php echo $user_id; ?>"; // Autofill user_id
        const date = new Date().toISOString().split('T')[0]; // Autofill current date

        if (category && amount) {
            $.ajax({
                url: "../../backend/add_expense.php",
                method: "POST",
                data: { user_id, category, amount, description, date },
                success: function () {
                    alert("Expense added successfully!");
                    loadExpenses();
                },
                error: function (xhr, status, error) {
                    console.error("Failed to add expense:", error);
                    alert("Failed to add expense. Please try again.");
                }
            });
        }
    });

    // Edit Expense
    $(document).on("click", ".edit-btn", function () {
        const id = $(this).data("id");
        const category = prompt("Enter new category:");
        const amount = prompt("Enter new amount:");
        const description = prompt("Enter new description:");

        if (category && amount) {
            $.ajax({
                url: "../../backend/edit_expense.php",
                method: "POST",
                data: { id, category, amount, description },
                success: function () {
                    alert("Expense updated successfully!");
                    loadExpenses();
                },
                error: function (xhr, status, error) {
                    console.error("Failed to edit expense:", error);
                    alert("Failed to edit expense. Please try again.");
                }
            });
        }
    });

    // Delete Expense
    $(document).on("click", ".delete-btn", function () {
        const id = $(this).data("id");

        if (confirm("Are you sure you want to delete this expense?")) {
            $.ajax({
                url: `../../backend/delete_expense.php?id=${id}`,
                method: "POST",
                success: function () {
                    alert("Expense deleted successfully!");
                    loadExpenses();
                },
                error: function (xhr, status, error) {
                    console.error("Failed to delete expense:", error);
                    alert("Failed to delete expense. Please try again.");
                }
            });
        }
    });

    // Export Expenses
    $(document).on("click", ".btn.export", function () {
        window.location.href = "../../backend/export_expense.php";
    });
});