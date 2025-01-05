
# Frontend Overview
The ZARWISE frontend is a web application designed to help users manage their personal finances by tracking expenses, setting budgets, and viewing financial summaries. The frontend is built using HTML, CSS, and JavaScript, and it interacts with a backend server to store and retrieve data.

## File Descriptions

### HTML/PHP Files

- [Index page](./public/index.php)
  - The landing page of the application. It provides options for users to log in or register.
   ![Index Page](public/img/index.png)

- [login page](./public/login.php)
  - The login page where users can enter their credentials to access their accounts. It includes form validation a "Remember Me" feature and a "Forgot Password" feature.
  ![Login Page](public/img/login.png)

- [register page](./public/register.php)
  - The registration page where new users can create an account. It includes form validation for username, email, and password.
    ![Register Page](public/img/register.png)

-[dashboard page](./public/dashboard.php)
  - The main dashboard page where users can view their expenses, set budgets, and see financial summaries. It includes charts and tables for data visualization.
  ![Dashboard Page](public/img/dashboard.png)

- [profile page](./public/profile.php)
  - The profile page where users can update their username and password. It also includes an option to delete the account.
  ![Profile Page](public/img/profile-edit.png)

- [forgot password page](./public/forgot_password.php)
  - The page where users can reset their password if they have forgotten it. It includes form validation for the new password.
  ![Forgot Password](public/img/forgot-password.png)

-[suggest-a-feature-page](./public/suggestfeature.php)
  - The page where users can suggest new features for the application. It includes a form to submit suggestions via email.
  ![Suggest a Feature](public/img/suggest-a-feature.png)

- [contact-form](./public/contactform.php)
  - The contact form page where users can send queries or feedback. It includes form validation for the email field.
  ![Contact Form Page](public/img/contact-form.png)

- [logout](./public/logout.php)
  - The script that handles user logout by destroying the session and redirecting to the login page.

### CSS Files

- [style.css](./public/style.css)
  - The main stylesheet for the application. It includes general styling for the body, forms, buttons, and links.

- [dashboard.css](./public/dashboard.css)
  - The stylesheet specifically for the dashboard page. It includes styling for the sidebar, charts, tables, and various sections of the dashboard.

- [profile.css](./public/profile.css)
  - The stylesheet for the profile page. It includes styling for the form and buttons used to update the profile.

- [suggest-a-feature.css](./public/suggestfeature.css)
  - The stylesheet for the suggest feature page. It includes styling for the form and buttons used to submit feature suggestions.

- [contact-form.css](./public/contactform.css)
  - The stylesheet for the contact form page. It includes styling for the form and buttons used to send queries.

### JavaScript Files

- [script.js](./public/script.js)
  - The main JavaScript file for the application. It includes functions for form validation, password visibility toggle, and handling "Remember Me" functionality.

- [chart.js](./public/chart.js)
  - The JavaScript file for handling the expense chart on the dashboard. It includes functions to fetch and update chart data, and to show expense details in a modal.

- [ajax.js](./public/ajax.js)
  - The JavaScript file for handling AJAX requests. It includes functions to load expenses, handle form submissions, and show feedback messages using toasts.

## Contact and Support
For contact and support refer to the [Support Section](../README.md#6-conclusion-and-support) for more details