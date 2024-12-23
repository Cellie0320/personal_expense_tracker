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
/*Contact form reset*/
function resetForm() {
    document.getElementById('contactForm').reset();
}

document.getElementById('category_id').addEventListener('change', function() {
    var otherCategoryGroup = document.getElementById('other-category-group');
    if (this.value === 'other') {
      otherCategoryGroup.style.display = 'block';
    } else {
      otherCategoryGroup.style.display = 'none';
    }
  });

  document.getElementById('add-expense-form').addEventListener('submit', function(event) {
    var categorySelect = document.getElementById('category_id');
    var otherCategoryInput = document.getElementById('other_category');
    if (categorySelect.value === 'other' && otherCategoryInput.value.trim() === '') {
      event.preventDefault();
      alert('Please specify the category.');
    }
  });

  document.addEventListener('DOMContentLoaded', function () {
    // Fetch total expenses
    function fetchTotalExpenses() {
        $.ajax({
            url: '../../backend/fetch_total_expenses.php',
            method: 'GET',
            success: function (response) {
                const data = JSON.parse(response);
                const totalExpenses = data.total_expenses;
                $('#total-expenses').text(`R${totalExpenses}`);
                calculateSavings(totalExpenses);
            },
            error: function (xhr, status, error) {
                console.error('Failed to fetch total expenses:', error);
            }
        });
    }

    // Calculate savings
    function calculateSavings(totalExpenses) {
        const budget = parseFloat($('#budget-input').val()) || 0;
        const savings = budget - totalExpenses;
        $('#savings').text(`R${savings}`);
    }

    // Event listener for budget input change
    $('#budget-input').on('input', function () {
        const totalExpenses = parseFloat($('#total-expenses').text().replace('R', '')) || 0;
        calculateSavings(totalExpenses);
    });

    // Event listener for OK button
    $('#budget-ok').on('click', function () {
        const totalExpenses = parseFloat($('#total-expenses').text().replace('R', '')) || 0;
        calculateSavings(totalExpenses);
    });

    // Event listener for Cancel button
    $('#budget-cancel').on('click', function () {
        $('#budget-input').val('');
        $('#savings').text('R0');
    });

    // Initial fetch of total expenses
    fetchTotalExpenses();
});