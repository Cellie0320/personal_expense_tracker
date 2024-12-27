function validateEmail() {
    const emailInput = document.getElementById('email');
    const emailMessage = document.getElementById('emailMessage');
    const email = emailInput.value;
    const emailPattern = /^[a-zA-Z0-9._-]+@gmail\.com$/;
    if (emailPattern.test(email)) {
        emailInput.style.borderColor = 'green';
        emailMessage.textContent = 'Email is correct';
        emailMessage.style.color = 'green';
        return true;
    } else {
        emailInput.style.borderColor = 'red';
        emailMessage.textContent = 'Invalid email address. Only @gmail.com addresses are allowed.';
        emailMessage.style.color = 'black';
        return false;
    }
}

function validatePassword() {
    const passwordInput = document.getElementById('password') || document.getElementById('new_password');
    const passwordMessage = document.getElementById('passwordMessage');
    const password = passwordInput.value;
    const strongPasswordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

    if (strongPasswordPattern.test(password)) {
        passwordInput.style.borderColor = 'green';
        passwordMessage.textContent = 'Password is strong';
        passwordMessage.style.color = 'green';
        return true;
    } else {
        passwordInput.style.borderColor = 'red';
        passwordMessage.textContent = 'Password is weak. It must be at least 8 characters long, include uppercase and lowercase letters, a number, and a special character';
        passwordMessage.style.color = 'black';
        return false;
    }
}

function validateForm() {
    const emailValid = validateEmail();
    const passwordValid = validatePassword();
    if (!emailValid || !passwordValid) {
        alert('Please ensure all fields are correctly filled out and the password is strong.');
    }
    return emailValid && passwordValid;
}

function togglePasswordVisibility(passwordFieldId) {
    const passwordField = document.getElementById(passwordFieldId);
    const togglePassword = passwordField.nextElementSibling;
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        togglePassword.classList.remove('fa-eye');
        togglePassword.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        togglePassword.classList.remove('fa-eye-slash');
        togglePassword.classList.add('fa-eye');
    }
}

function handleRememberMe() {
    const rememberMeCheckbox = document.getElementById('remember-me');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');

    if (rememberMeCheckbox.checked) {
        document.cookie = `username=${usernameInput.value}; max-age=604800; path=/`; // 7 days
        document.cookie = `password=${passwordInput.value}; max-age=604800; path=/`; // 7 days
    } else {
        document.cookie = `username=; max-age=0; path=/`;
        document.cookie = `password=; max-age=0; path=/`;
    }
    return true;
}

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}

document.addEventListener('DOMContentLoaded', function () {
    // Check if the current page is login.php
    if (window.location.pathname.includes('login.php')) {
        const savedUsername = getCookie('username');
        const savedPassword = getCookie('password');

        if (savedUsername && savedPassword) {
            document.getElementById('username').value = savedUsername;
            document.getElementById('password').value = savedPassword;
            document.getElementById('remember-me').checked = true;
        }
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
        const savings = Math.max(budget, totalExpenses) - Math.min(budget, totalExpenses);
        $('#savings').text(`R${savings}`);
        if (budget < totalExpenses) {
            alert('Warning: Your budget is less than your total expenses.');
        }
        refreshChartData(); // Refresh chart data after calculating savings
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

function resetForm() {
    document.getElementById('contactForm').reset();
}