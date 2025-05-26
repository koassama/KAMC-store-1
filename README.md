📊 Admin Device Management System
This is a PHP-based admin dashboard system to manage outgoing and incoming devices within an IT or facilities management environment. The system supports device tracking, maintenance handling, reporting, and inventory management.

🌐 Live Features
🔐 Admin Authentication

📋 Manage Incoming & Outgoing Devices (comming.php, products.php, returns.php)

🧾 Generate & Download Word Reports (download_word.php)

👤 User Management (users.php)

📊 Dashboard Overview (dashboard.php)

📦 Inventory Management (piece.php, consumers.php)

📁 Styled with Bootstrap 4 and Google Fonts

🧱 Project Structure
bash
Copy
Edit
admin/
├── comming.php              # Device management page
├── products.php             # Inventory page
├── returns.php              # Devices in maintenance
├── users.php                # Admin user management
├── dashboard.php            # Admin dashboard page
├── includes/
│   ├── functions/functions.php
│   └── templates/           # Shared layout
│       ├── header.php
│       ├── footer.php
│       └── navbar.php
├── layout/
│   ├── css/
│   └── js/
├── imgs/                    # UI logos/icons
├── init.php                 # Bootstrap file (includes DB, session, etc.)
├── connect.php              # DB Connection
├── logout.php               # Admin logout
├── download_word.php        # Generate Word reports
├── insert_user.php          # Add users
├── index.php                # Login page
├── .htaccess                # Rewrite rules
⚙️ Installation  

🧪 Requirements
PHP 7.x or later

MySQL/MariaDB

Apache/Nginx

📝 Customization
Update UI assets in /layout/css and /imgs

Add more device types or statuses in the database

Extend role-based permissions via $_SESSION['type']
