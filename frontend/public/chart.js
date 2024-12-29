document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('expenseChart').getContext('2d');
    window.expenseChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [], // Dynamically loaded categories
            datasets: [{
                label: 'Amount (R)',
                data: [], // Dynamically loaded expense amounts
                backgroundColor: ['#ff6384', '#36a2eb', '#cc65fe', '#ffce56', '#4bc0c0', '#9966ff', '#ff9f40']
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
    function loadChartData(filter = 'month') {
        $.ajax({
            url: `../../backend/fetch_expenses.php?filter=${filter}`, // Adjusted path
            method: "GET",
            success: function (response) {
                const data = JSON.parse(response); // Parse data from backend
                const aggregatedData = {};

                // Aggregate expenses by category
                data.expenses.forEach(expense => {
                    if (aggregatedData[expense.category_name]) {
                        aggregatedData[expense.category_name] += parseFloat(expense.amount);
                    } else {
                        aggregatedData[expense.category_name] = parseFloat(expense.amount);
                    }
                });

                // Prepare data for the chart
                const labels = Object.keys(aggregatedData);
                const values = Object.values(aggregatedData);

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
            url: `../../backend/fetch_expense_details.php?category=${category}`, // Adjusted path
            method: "GET",
            success: function (response) {
                const data = JSON.parse(response); // Parse data from backend
                let detailsHtml = '<div class="expense-details">';
                data.forEach(expense => {
                    detailsHtml += `
                        <div class="expense-item">
                            <div class="expense-description">${expense.description}</div>
                            <div class="expense-amount">R${expense.amount}</div>
                            <div class="expense-date">${expense.date}</div>
                        </div>`;
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
});