# Personal Expense Tracker Project Structure

## Frontend
```
frontend/
│
├── public/
│   ├── index.php          # Main dashboard page
│   ├── login.php          # Login page
│   ├── register.php       # User registration page
│   └── logout.php         # Logout page
│
├── assets/
│   ├── css/
│   │   ├── styles.css     # Custom CSS (Bootstrap overrides)
│   │   └── bootstrap.min.css  # Bootstrap CSS
│   │
│   ├── js/
│   │   ├── script.js      # Main JavaScript file
│   │   ├── ajax.js        # AJAX handling
│   │   └── chart-config.js  # Chart.js visualization config
│   │
│   └── images/            # Optional images and icons
│       └── logo.png
│
└── templates/             # Reusable HTML components
    ├── header.php         # Common page header
    ├── footer.php         # Common page footer
    └── navbar.php         # Navigation menu
```

## Backend
```
backend/
│
├── config/
│   ├── database.php       # Database connection configuration
│   └── config.php         # Application-wide settings
│
├── controllers/
│   ├── ExpenseController.php  # Handles expense-related operations
│   ├── UserController.php     # Manages user authentication
│   └── ExportController.php   # Manages data export functionality
│
├── models/
│   ├── Expense.php        # Expense model (database interactions)
│   └── User.php           # User model (authentication, registration)
│
└── services/
    ├── ValidationService.php  # Input validation
    ├── AuthenticationService.php  # Authentication logic
    └── ExportService.php      # CSV/JSON export logic
```

## Database
```
database/
│
├── schema/
│   ├── init.sql           # Initial database schema creation
│   └── sample-data.sql    # Optional sample data for testing
│
└── migrations/            # Optional database version control
    ├── 001_create_users_table.sql
    ├── 002_create_expenses_table.sql
    └── 003_add_categories.sql
```

## Project Root
```
personal-expense-tracker/
│
├── .gitignore             # Git ignore configurations
├── README.md              # Project documentation
├── composer.json          # Dependency management (if using Composer)
└── LICENSE                # Project licensing information
```
