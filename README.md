<p align="center">
<img src="frontend/public/img/logo.png" alt="ZARWISE Banner" width="100%" height="auto">
</p>

# ZARWISE Setup Guide 

## Table of Contents
1. [Prerequisites](#1-prerequisites)
2. [Key Features](#2-key-features)
3. [Introduction](#3-introduction)
4. [Installation and Setup](#4-installation-and-setup)
   - [Install UniServer](#install-uniserver)
   - [Clone the Repository](#clone-the-repository)
   - [Import MySQL Database](#import-mysql-database)
     - [Troubleshooting phpMyAdmin Access](#troubleshooting-phpmyadmin-access)
5. [Running the Project](#5-running-the-project)
6. [Conclusion and Support](#6-conclusion-and-support)
7. [License](#license)
8. [Acknowledgements](#acknowledgements)
9. [Future Improvements](#future-improvements)

## 1. Prerequisites
- A Windows 10 (or 11) Computer
- Stable Internet connection
- [Visual Studio Code (VS Code)(if not already installed)](https://code.visualstudio.com/download)
- [Git Bash](https://gitforwindows.org/)

## 2. Key Features
- **User Authentication:**
  - Secure user registration and login with password hashing.
  - Session management to ensure secure access to user data.

- **Expense Management:**
  - Add, edit, and delete expenses with detailed descriptions.
  - Categorize expenses for better organization.
  - View expenses in a tabular format with sorting and filtering options.

- **Financial Summaries:**
  - Visualize expenses through interactive charts.
  - View total expenses, budget, and savings.
  - Filter expenses by daily, weekly, monthly, and yearly views.

- **Data Export:**
  - Export expenses to a CSV file for offline analysis.

- **Profile Management:**
  - Update username and password.
  - Delete user profile and associated data.

- **Contact and Feedback:**
  - Contact form for user queries and feedback.
  - Suggest a feature form to gather user suggestions for future improvements.

## 3. Introduction
This guide provides step-by-step instructions to set up and run the ZARWISE personal expense tracker project using UniServer. It covers installing UniServer, cloning the repository, and importing the MySQL database.

## 4. Installation and Setup

### Install UniServer
1. **Download UniServer:**
   - Visit the [UniServer website](https://www.uniformserver.com/) and download the latest version.

2. **Move UniServer:**
   - Move the downloaded UniServer EXE file to a directory of your choice (e.g., `C:\server`).

3. **Extract UniServer:**
   - Run the UniServer EXE file to extract its contents into the `C:\server` directory.
   - If prompted for access during the installation process, click "Allow Access".
   - If Windows Defender SmartScreen prompts "Windows protected your PC", click "More info" and then "Run anyway".

4. **Start UniServer:**
   - Navigate to the extracted UniServer directory and run `UniController.exe`.
   - Click on the "Start Apache" and "Start MySQL" buttons to start the web server and database server.
   - If prompted for a new MySQL password, choose an easy-to-remember secure password.
   > **Note:** Ensure that the MySQL password you set here is consistent with the password specified in the `config.php` file for database connectivity. For detailed instructions, refer to the [Database Configuration](#database-configuration) section.

### Clone the Repository
1. **Install Git Bash (if not already installed):**
   - Visit the [Git Bash download page](https://gitforwindows.org/) and download the installer.
   - Run the installer and follow the setup instructions to install Git Bash.

2. **Open File Explorer:**
   - Press `Win + E` to open File Explorer.

3. **Navigate to UniServer's www Directory:**
   - In File Explorer, navigate to the `www` directory inside the UniServer directory (e.g., `C:\server\www`).

4. **Clone the Repository:**
   - Right-click inside the `www` directory and select "Open Git Bash Here".
   - Run the following command to clone the repository:
    ```sh
    git clone https://github.com/Cellie0320/personal_expense_tracker
    ```

5. **Restart Apache and MySQL Servers:**
   - After cloning the repository, restart the Apache and MySQL servers using the UniController:
    - Open the `UniController.exe` file.
    - Click on the "Stop Apache" and "Stop MySQL" buttons.
    - Then click on the "Start Apache" and "Start MySQL" buttons to restart the servers.

### Import MySQL Database
1. **Open phpMyAdmin:**
   - Run the `UniController.exe` file, then start Apache and MySQL.
   - Your default browser will automatically open and navigate to the UniServer test page (`http://localhost`).
   - Click on the "phpMyAdmin" link on the UniServer test page.

2. **Create a New Database:**
   - In phpMyAdmin, click on the "Databases" tab.
   - Enter `expense_tracker` as the database name and click "Create".

3. **Import the Database:**
   - Select the `expense_tracker` database from the left sidebar.
   - Click on the "Import" tab.
   - Click "Choose File" and select the expensetracker-db_sql.sql file from the database directory of the cloned repository.
   - Click "Go" to import the database.

#### Troubleshooting phpMyAdmin Access
- If you encounter an error when opening phpMyAdmin, search the UniServer directory for a file named `config.inc.php`.
- Use VSCode or another code editor to open it.
- Under the authentication section, set your username and password:
  ```php
  /* Authentication section */
  $cfg['Servers'][$i]['auth_type']       = 'config';  // Authentication method (config, http or cookie based)?
  $cfg['Servers'][$i]['user']            = 'root';    // MySQL user
  $cfg['Servers'][$i]['password']        = 'your_password'; // MySQL password (only needed with 'config' auth_type)
  $cfg['Servers'][$i]['AllowNoPassword'] = false;     // Must use password
  ```
- To apply these changes, save and close the file then restart UniServer by stopping and then starting the Apache and MySQL servers.
- Alternatively, you can just close the phpMyAdmin browser tab and open it again via the test page link if the error is not password related.
> **Note:** The username and password set in the `config.inc.php` file must also be used in the `config.php` file.

### Database Configuration
1. **Create the `config.php` file:**
   - In the backend directory, create a new file named `config.php`.

2. **Update the `config.php` file with the following content, ensuring that the database connection settings reflect your credentials. Use 'root' as the username for now, and set the password according to your database configuration or the password specified in the `config.inc.php` file. For further details, refer to the Troubleshooting phpMyAdmin Access section for instructions on setting a custom password:**
   ```php
   <?php
   return [
       'dsn' => 'mysql:host=localhost;dbname=expense_tracker',
       'username' => 'root',
       'password' => 'your_password',
   ];
   ?>
   ```
   4. After creating and saving the `config.php` file, verify the database connection by ensuring that the DBConnection.php file is correctly configured.

   5. **Restart UniServer:**
      - Open `UniController.exe`.
      - Click "Stop Apache" and "Stop MySQL".
      - Then click "Start Apache" and "Start MySQL" to restart the servers.
      > **Note:** This step ensures that the newly created file is properly stored on the server.

## 5. Running the Project
1. **Start UniServer:**
   - Run the `UniController.exe` file, then start Apache and MySQL. (If it's not already started)

2. **Access the Project:**
   - After starting Apache and MySQL, the UniServer test page will appear (`http://localhost`).
   - Under the "Served Subdirectories" section, click on the `personal_expense_tracker` folder.
   - Navigate to the frontend folder, then open the `public` folder.

3. **Login or Register:**
   - Use the index page to access your account or register a new ZARWISE account.
   - If you are a new user, just click on the "View Expenses" to start adding expenses to your account.

## 6. Conclusion and Support
You have successfully set up and run the ZARWISE project using UniServer.
If you have any questions or need further assistance, you can contact the maintainer at [marceldelange20@gmail.com](mailto:marceldelange20@gmail.com).

## License
This project is licensed under the Apache License. See the LICENSE file for more details.

## Acknowledgements
- [dbdiagram.io](https://dbdiagram.io) - For database diagramming.
- [UniServer Setup YouTube Tutorial](https://youtu.be/OP2Jrda6yIY?si=oNo9NkaMTKFhMVvq) - For guidance to setup and install UniServer

## Future Improvements
> **Note:** In-app mail functionality is in development and will be implemented once it is fully developed and tested. This will be applicable to the contact form and suggest a feature form.

We encourage fellow developers to assist with the development and suggest more features. Feel free to fork the repository, make improvements, and submit pull requests.
