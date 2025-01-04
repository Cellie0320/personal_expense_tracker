<p align="center">
  <img src="frontend/public/img/logo.png" alt="ZARWISE Banner" width="100%" height="auto">
</p>

# ZARWISE Setup Guide 

## Table of Contents
1. [Introduction](#introduction)
2. [Key Features](#key-features)
3. [Prerequisites](#prerequisites)
4. [Installation and Setup](#installation-and-setup)
    - [Install UniServer](#install-uniserver)
    - [Clone the Repository](#clone-the-repository)
    - [Import MySQL Database](#import-mysql-database)
      - [Troubleshooting phpMyAdmin Access](#troubleshooting-phpmyadmin-access)
5. [Running the Project](#running-the-project)
6. [Conclusion](#conclusion)

## 1. Introduction
This guide provides step-by-step instructions to set up and run the ZARWISE project using UniServer. It includes installing UniServer, cloning the repository, and importing the MySQL database.

## 2. Key Features
- **User Authentication:** Secure login and registration with password hashing.
- **Expense Management:** Add, edit, delete, and view expenses.
- **Data Retrieval:** Fetch expenses, total expenses, and detailed expense information.
- **Data Export:** Export expenses as a CSV file.
- **Profile Management:** Update user profile information and delete user profile.
- **Chart Data:** Retrieve data for generating expense charts.

## 3. Prerequisites
- A computer with Windows OS
- Internet connection
- Basic knowledge of PHP and MySQL

## 4. Installation and Setup

### Install UniServer
1. **Download UniServer:**
   - Visit the [UniServer website](https://www.uniformserver.com/) and download the latest version of UniServer.

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
   > **Note:** Ensure that the MySQL password set here matches the password specified in the `config.php` file for database connectivity.

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

### Import MySQL Database
1. **Open phpMyAdmin:**
   - Run the `UniController.exe` file, then start Apache and MySQL.
   - Open your web browser and go to the UniServer test page (`http://localhost`).
   - Click on the "phpMyAdmin" link on the UniServer test page.

2. **Create a New Database:**
   - In phpMyAdmin, click on the "Databases" tab.
   - Enter `expense_tracker` as the database name and click "Create".

3. **Import the Database:**
   - Select the `expense_tracker` database from the left sidebar.
   - Click on the "Import" tab.
   - Click "Choose File" and select the [SQL File](./database/expensetracker-db_sql.sql) file from the database directory of the cloned repository.
   - Click "Go" to import the database.

#### Troubleshooting phpMyAdmin Access
- If you encounter an error when opening phpMyAdmin, search the UniServer directory for a file named `config.inc.php`.
- Use VSCode or another text editor to open it.
- Under the authentication section, set your username and password:
  ```php
  /* Authentication section */
  $cfg['Servers'][$i]['auth_type']       = 'config';  // Authentication method (config, http or cookie based)?
  $cfg['Servers'][$i]['user']            = 'root';    // MySQL user
  $cfg['Servers'][$i]['password']        = 'your_password'; // MySQL password (only needed with 'config' auth_type)
  $cfg['Servers'][$i]['AllowNoPassword'] = false;     // Must use password
  ```
- To apply these changes, save and close the file then restart UniServer by stopping and then starting the Apache and MySQL servers.
> **Note:** The username and password set in the `config.inc.php` file must also be used in the `config.php` file.
### Database Configuration
1. **Create the `config.php` file:**
   - In the backend directory, create a new file named `config.php`.

2. **Add the following content to the `config.php` file and update the database connection settings with your own credentials:**
   ```php
   <?php
   return [
       'dsn' => 'mysql:host=localhost;dbname=expensetracker',
       'username' => 'your_username',
       'password' => 'your_password',
   ];
   ```

3. **Save the `config.php` file.**
4. After creating and saving the `config.php` file, ensure that the database connection is correctly configured by verifying the [DB Connection](./backend/DBConnection.php) file.

## 5. Running the Project
1. **Start UniServer:**
   - Run the `UniController.exe` file, then start Apache and MySQL.

2. **Access the Project:**
   - After starting Apache and MySQL, the UniServer test page will appear (`http://localhost`).
   - Under the "Served Subdirectories" section, click on the `personal_expense_tracker` folder.
   - Navigate to the frontend folder, then open the `public` folder.

3. **Login or Register:**
   - Use the index page to access your account or register a new ZARWISE account.

   ## 6. Conclusion and Support
   You have successfully set up and run the Personal Expense Tracker project using UniServer.
   If you have any questions or need further assistance, you can contact the maintainer at [marceldelange20@gmail.com](mailto:marceldelange20@gmail.com).

## License
This project is licensed under the Apache License. See the [LICENSE](LICENSE.md) file for more details.
