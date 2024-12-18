function validateEmail() {
    const emailInput = document.getElementById('email');
    const emailMessage = document.getElementById('emailMessage');
    const email = emailInput.value;
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (emailPattern.test(email)) {
        emailInput.style.borderColor = 'green';
        emailMessage.textContent = 'Email is correct';
        emailMessage.style.color = 'green';
    } else {
        emailInput.style.borderColor = 'red';
        emailMessage.textContent = 'Invalid email address';
        emailMessage.style.color = 'red';
    }
}

$(document).ready(function () {
    /**
     * Load expenses dynamically on page load.
     */
    function loadExpenses() {
        $.ajax({
            url: "/backend/expense.php?action=view",
            method: "GET",
            success: function (data) {
                $("#expense-list").html(data); // Populate the expense list dynamically
            },
            error: function () {
                alert("Failed to load expenses.");
            }
        });
    }

    // Initial load of expenses
    loadExpenses();

    /**
     * Add a new expense.
     */
    $("#add-expense-btn").click(function () {
        const category = prompt("Enter expense category:");
        const amount = prompt("Enter expense amount:");
        const description = prompt("Enter expense description:");

        if (category && amount) {
            $.ajax({
                url: "/backend/expense.php?action=add",
                method: "POST",
                data: { category, amount, description },
                success: function () {
                    alert("Expense added successfully!");
                    loadExpenses(); // Refresh the expense list
                },
                error: function () {
                    alert("Failed to add expense.");
                }
            });
        }
    });

    /**
     * Edit an existing expense.
     */
    $(document).on("click", ".edit-btn", function () {
        const expenseId = $(this).data("id");
        const newCategory = prompt("Enter new category:");
        const newAmount = prompt("Enter new amount:");
        const newDescription = prompt("Enter new description:");

        if (newCategory && newAmount) {
            $.ajax({
                url: "/backend/expense.php?action=edit",
                method: "POST",
                data: {
                    id: expenseId,
                    category: newCategory,
                    amount: newAmount,
                    description: newDescription
                },
                success: function () {
                    alert("Expense updated successfully!");
                    loadExpenses(); // Refresh the expense list
                },
                error: function () {
                    alert("Failed to update expense.");
                }
            });
        }
    });

    /**
     * Delete an expense.
     */
    $(document).on("click", ".delete-btn", function () {
        const expenseId = $(this).data("id");

        if (confirm("Are you sure you want to delete this expense?")) {
            $.ajax({
                url: `/backend/expense.php?action=delete&id=${expenseId}`,
                method: "POST",
                success: function () {
                    alert("Expense deleted successfully!");
                    loadExpenses(); // Refresh the expense list
                },
                error: function () {
                    alert("Failed to delete expense.");
                }
            });
        }
    });

    /**
     * Export expenses as CSV.
     */
    $("#export-csv-btn").click(function () {
        window.location.href = "/backend/expense.php?action=export";
    });
});

/*Contact form reset*/
function resetForm() {
    document.getElementById('contactForm').reset();
}
