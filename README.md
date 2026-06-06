# Visa_final  

A lightweight PHP web application for managing visa‑related workflows. It provides separate portals for administrators and employees to handle applications, schedules, feedback, and user management.

---

## Overview  

Visa_final streamlines the visa application process within an organization. Administrators can add and edit employees/HR staff, view applications, manage schedules, and generate printable forms. Employees can submit personal details, give feedback, view their schedules, and update their profiles.

---

## Features  

| Admin Portal | Employee Portal |
|--------------|-----------------|
| Secure login (`admin_login.php`) | Secure login (`employee_login.php`) |
| Add / edit employees and HR users | Add personal details & feedback |
| View / print applications | View personal schedule |
| Manage and view schedules | Update profile |
| Export feedback reports | Logout functionality |
| Centralised navigation (`admin_navbar.php`) | Centralised navigation (`navbar.php`) |
| Comprehensive data view (employees, HR, feedback, schedules) |  |

*All pages share a common CSS stylesheet (`css/style.css`).*  

---

## Tech Stack  

| Layer | Technology |
|-------|------------|
| Backend | PHP 7.4+ |
| Database | MySQL (see `Database/visa_db.sql`) |
| Front‑end | HTML5, CSS3 |
| Server | Apache / Nginx (LAMP or LEMP stack) |

---

## Installation  

1. **Clone the repository**  
   ```bash
   git clone https://github.com/yourusername/Visa_final.git
   cd Visa_final
   ```

2. **Set up the database**  
   - Create a new MySQL database (e.g., `visa_db`).  
   - Import the schema:  
     ```bash
     mysql -u root -p visa_db < Database/visa_db.sql
     ```

3. **Configure connection settings**  
   - Open `config.php` (root) and `admin/config.php` / `employee/config.php`.  
   - Replace the placeholder values with your own credentials:  

     ```php
     define('DB_HOST', 'localhost');
     define('DB_NAME', 'visa_db');
     define('DB_USER', 'YOUR_DB_USER');
     define('DB_PASS', 'YOUR_DB_PASSWORD');
     ```

4. **Deploy**  
   - Place the project inside your web server’s document root (e.g., `/var/www/html/Visa_final`).  
   - Ensure the `css/` folder is readable by the web server.  

5. **Optional – Composer (if future dependencies are added)**  
   ```bash
   composer install
   ```

---

## Usage  

### Administrator  

1. Navigate to `admin/admin_login.php`.  
2. Log in with admin credentials (default can be set in the DB).  
3. Use the navigation bar to:  
   - **Add Employee / HR** – `add_employee.php`, `add_hr.php`  
   - **View / Edit** – `view_employees.php`, `edit_employee.php`, `view_hrs.php`, `edit_hr.php`  
   - **Applications** – `view_applications.php`, `print_application.php`  
   - **Schedules** – `view_schedule.php`, `view_schedule_details.php`  
   - **Feedback** – `view_feedbacks.php`  

### Employee  

1. Open `employee_login.php`.  
2. After logging in, the dashboard (`employee_dashboard.php`) provides shortcuts to:  
   - **Add Details** – `add_details.php`  
   - **Submit Feedback** – `add_feedback.php`  
   - **View Schedule** – `view_schedule.php`  
   - **Update Profile** – `update_profile.php`  

### Common  

- **Logout** – `admin/logout.php`