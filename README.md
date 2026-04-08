# TODO APP - Task Management System
**Description**: A custom MVC PHP application for managing users, tasks, and categories. It features a role-based system with Admin and Member access levels. This version of the project utilizes a MySQL database for data persistence.

[!IMPORTANT]
The main development branch for this project is develop-MySQL. Please ensure you switch to this branch after cloning the repository.

## 🛠 Technologies
- **Frontend**: HTML5, Tailwind CSS (via CDN).
- **Backend**: Native PHP (Custom MVC Architecture).
- **Database**: MySQL.

## 🚀 Installation & Setup
1. **Clone the repository**:
- git clone https://github.com/francobrida/S3-03.git
- git checkout develop-MySQL

2. **Server Setup**:

- Ensure you have XAMPP, WAMP, or a similar PHP local server environment installed.
- Place the project folder in your server's root directory (e.g., htdocs for XAMPP).
- Enable PHP "intl" Extension:
If the application crashes due to IntlDateFormatter, you must enable the internationalization extension in your PHP configuration:
Open your php.ini file (e.g., in XAMPP: Apache > Config > PHP (php.ini)).
Search for the following line: ;extension=intl.
Remove the semicolon (;) at the beginning to uncomment it: extension=intl.
Restart your Apache server to apply the changes.

3. **Database Configuration**:

- Open phpMyAdmin or your preferred MySQL client.
- Create a new database (e.g., todo_db).
- Import the .sql file located in the /docs or /database folder.
- Configure your connection credentials (host, db_name, user, password) in the config/db.inc.php file.

Access the Application:
Once the server is running, the main entry point is located at:
http://localhost/(your-local-path)/web/index

## 🔑 Login & Access
To explore the full functionality, including Admin-only views, use the following credentials:

**Admin User:**
    - **Username**: 'raven'
    - **Password**: 'pass1'

Note: The system distinguishes between 'Admin' and 'Member' roles. 
The Admin role allows management of all users, tasks, and categories.

## Persistence & Adapter Pattern
The application is designed using the Strategy Pattern, allowing for a flexible data persistence layer. You can easily switch the entire system between MySQL (SQL) and JSON files without modifying the core business logic.

This implementation is present in the following models:
User.php
Task.php
Category.php

How to Switch Persistence:
To change how the data is stored, change the persistent tag of the config.php file

PHP
// config.php
return [
    'persistence' => 'sql' // 'json' o 'sql'
];
[!NOTE]

By default, the develop-MySQL branch is configured to use SQL. If you switch to JSON, ensure the data/ folder has the necessary write permissions.

##📊 MER Diagram
![MER DIAGRAM](<docs/MER to_do v1.3.png>)
