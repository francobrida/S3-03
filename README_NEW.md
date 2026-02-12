# TODO APP - Task Management System

**Description**: A custom MVC PHP application for managing users, tasks and categories. It features a role-based system with Admin and Member access levels, utilizing JSON files for data persistence without a traditional database.

## 🛠 Technologies
- **Frontend**: HTML5, Tailwind CSS (via CDN).
- **Backend**: Native PHP (Custom MVC Architecture), JSON Data Storage.

## 🚀 Installation & Setup
1.  **Clone the repository**:
    https://github.com/francobrida/S3-03.git

2.  **Server Setup**:
    - Ensure you have XAMPP, WAMP, or a similar PHP local server environment installed.
    - Place the project folder in your server's root directory (e.g., `htdocs` for XAMPP).
    
3.  **Configuration**:
    - The application uses `config/db.inc.php` and `data/` json files. No SQL database import is required as it uses local JSON storage.
    - Ensure the `data/` folder has write permissions so the application can save users and tasks.

## 🔑 Login & Access
To explore the full functionality, including Admin-only views, use the following credentials:

- **Admin User**:
    - **Username**: `raven`
    - **Password**: `pass1`

*Note: The system distinguishes between 'Admin' and 'Member' roles. The Admin role allows management of all users, tasks and categories.*

## 📊 MER Diagram
![MER DIAGRAM](<docs/MER to_do v1.3.png>)

