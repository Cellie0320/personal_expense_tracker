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