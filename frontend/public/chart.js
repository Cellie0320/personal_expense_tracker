document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('expenseChart').getContext('2d');
    window.expenseChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [], // Dynamically loaded categories
            datasets: [{
                label: 'Amount (R)',
                data: [], // Dynamically loaded expense amounts
                backgroundColor: [
                    '#ff6384', '#36a2eb', '#cc65fe', '#ffce56',
                    '#4bc0c0', '#9966ff', '#ff9f40', '#c9cbcf',
                    '#ffcd56', '#4bc0c0'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Categories'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Amount (R)'
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            onClick: function (event, elements) {
                if (elements.length > 0) {
                    const index = elements[0].index;
                    const category = expenseChart.data.labels[index];
                    showExpenseDetails(category);
                }
            }
        }
    });

    // Fetch and update chart data
    function loadChartData(filter = 'monthly') {
        $.ajax({
            url: `../../backend/fetch_expenses.php?filter=${filter}`, // Adjusted path
            method: "GET",
            dataType: 'json', // Ensure the response is parsed as JSON
            success: function (response) {
                console.log("Fetch Expenses Response:", response); // Debugging line
                if (response.error) {
                    console.error(response.error);
                    return;
                }

                const labels = response.labels;
                const values = response.values;

                console.log("Labels:", labels); // Debugging line
                console.log("Values:", values); // Debugging line

                expenseChart.data.labels = labels;
                expenseChart.data.datasets[0].data = values;
                expenseChart.update();
            },
            error: function (xhr, status, error) {
                console.error("Failed to load chart data:", error);
            }
        });
    }

    // Initial load of chart data
    loadChartData();

    // Function to refresh chart data
    function refreshChartData() {
        const filter = $('#filter-select').val();
        loadChartData(filter);
    }

    // Event listener for filter change
    $('#filter-select').on('change', function () {
        refreshChartData();
    });

    // Function to show expense details in a modal
    function showExpenseDetails(category) {
        $.ajax({
            url: `../../backend/fetch_expense_details.php?category=${encodeURIComponent(category)}`, // Adjusted path and encoded parameter
            method: "GET",
            dataType: 'json', // Expecting JSON response
            success: function (response) {
                console.log("Fetch Expense Details Response:", response); // Debugging line
                if (response.error) {
                    console.error(response.error);
                    return;
                }

                const data = response;
                let detailsHtml = '<div class="expense-details">';
                data.forEach(expense => {
                    detailsHtml += `
                        <div class="expense-item">
                            <div class="expense-description">${escapeHtml(expense.description)}</div>
                            <div class="expense-amount">R${parseFloat(expense.amount).toFixed(2)}</div>
                            <div class="expense-date">${escapeHtml(expense.date)}</div>
                        </div>
                        <hr>`;
                });
                detailsHtml += '</div>';
                $('#expenseDetailsModal .modal-body').html(detailsHtml);
                $('#expenseDetailsModal').modal('show');
            },
            error: function (xhr, status, error) {
                console.error("Failed to load expense details:", error);
            }
        });
    }

    // Utility function to escape HTML
    function escapeHtml(text) {
        return text
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
});