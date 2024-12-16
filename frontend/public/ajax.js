$(document).ready(function () {
    // Load Expenses
    function loadExpenses() {
        $.ajax({
            url: "/backend/expense.php?action=view",
            method: "GET",
            success: function (data) {
                $("#expense-list").html(data);
            }
        });
    }
    loadExpenses();

    // Add Expense
    $("#add-expense-btn").click(function () {
        const category = prompt("Enter category:");
        const amount = prompt("Enter amount:");
        const description = prompt("Enter description:");

        if (category && amount) {
            $.ajax({
                url: "/backend/expense.php?action=add",
                method: "POST",
                data: { category, amount, description },
                success: function () {
                    alert("Expense added successfully!");
                    loadExpenses();
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
                url: "/backend/expense.php?action=edit",
                method: "POST",
                data: { id, category, amount, description },
                success: function () {
                    alert("Expense updated successfully!");
                    loadExpenses();
                }
            });
        }
    });

    // Delete Expense
    $(document).on("click", ".delete-btn", function () {
        const id = $(this).data("id");

        if (confirm("Are you sure you want to delete this expense?")) {
            $.ajax({
                url: `/backend/expense.php?action=delete&id=${id}`,
                method: "POST",
                success: function () {
                    alert("Expense deleted successfully!");
                    loadExpenses();
                }
            });
        }
    });

    // Export Expenses
    $("#export-csv-btn").click(function () {
        window.location.href = "/backend/expense.php?action=export";
    });
});
