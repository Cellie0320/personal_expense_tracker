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
