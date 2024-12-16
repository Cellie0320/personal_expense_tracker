const ctx = document.getElementById('expenseChart').getContext('2d');
const expenseChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [], // Dynamically loaded categories
        datasets: [{
            label: 'Expenses',
            data: [], // Dynamically loaded expense amounts
            backgroundColor: ['#ff6384', '#36a2eb', '#cc65fe']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

// Fetch and update chart data
function loadChartData() {
    $.ajax({
        url: "../../backend/expense.php?action=view", // Adjusted path
        method: "GET",
        success: function (response) {
            const data = JSON.parse(response); // Parse data from backend
            expenseChart.data.labels = data.labels; // Example: ['Food', 'Transport']
            expenseChart.data.datasets[0].data = data.values; // Example: [200, 300]
            expenseChart.update();
        }
    });
}
loadChartData();
