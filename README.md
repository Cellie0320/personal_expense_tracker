<img src="frontend/public/img/logo.ico" alt="ZARWISE logo" width="50" height="50">

# ZARWISE Setup Guide 

## Table of Contents
1. [Introduction](#introduction)
2. [Prerequisites](#prerequisites)
3. [Installation and Setup](#installation-and-setup)
    - [Install UniServer](#install-uniserver)
    - [Clone the Repository](#clone-the-repository)
    - [Import MySQL Database](#import-mysql-database)
      -[Troubleshooting phpMyAdmin Access](#troubleshooting-phpmyadmin-access)
4. [Running the Project](#running-the-project)
5. [Conclusion](#conclusion)

## 1. Introduction
This guide provides step-by-step instructions to set up and run the ZARWISE personal_expense tracker
project using UniServer. It includes installing UniServer, cloning the repository, and importing the MySQL database.

## 2. Prerequisites
- A computer with Windows OS
- Internet connection
- Basic knowledge of PHP and MySQL

## 3. Installation and Setup

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
   - **Note:** The created password must be used in the `DBConnection.php` file:
     ```php
    $dsn = 'mysql:host=localhost;dbname=expensetracker';
     $dbusername = 'root';
     $dbpassword = 'your_password'; // Replace 'your_password' with the password you created in the config.inc.php file
        ```

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
   - Click "Choose File" and select the [expensetracker-db_sql.sql](database/expensetracker-db_sql.sql) file from the database directory of the cloned repository.
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
- Restart UniServer for the changes to take effect, by stopping the apache and mysql servers then starting it again

- **Note:** The username and password set in the `config.inc.php` file must also be used in the `DBConnection.php` file.

## 4. Running the Project
1. **Start UniServer:**
   - Run the `UniController.exe` file, then start Apache and MySQL.

2. **Access the Project:**
   - After starting Apache and MYSQL the UniServer test page will appear (`http://localhost`).
   - Under the "Served Subdirectories" section, click on the `personal_expense_tracker` folder.
   - Navigate to the frontend folder, then open the `public` folder.

3. **Login or Register:**
   - Use the index page to access your account or register a new ZARWISE account.

## 5. Conclusion
You have successfully set up and run the Personal Expense Tracker project using UniServer. If you encounter any issues, please refer to the project's repository or contact the maintainer for support. 
If you have any questions or need further assistance, you can contact the maintainer at [marceldelange20@gmail.com](mailto:marceldelange20@gmail.com).

## License
This project is licensed under the Apache License. See the [LICENSE](LICENSE) file for more details.



