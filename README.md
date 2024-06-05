# Auto Service Scheduling System

## Overview

The Auto Service Scheduling System is a web-based application designed to streamline the process of booking and managing auto service appointments. This system allows customers to book appointments with mechanics, mechanics to manage their schedules, and admins to oversee the entire operation.

## Features

- **Admin**: Manage mechanics, view all bookings, manage customers, and oversee schedules.
- **Mechanic**: View and manage their own schedules, appointments, and account settings.
- **Customer**: View available sessions, book appointments, manage their bookings, and account settings.

## Installation Guide

### Prerequisites

- XAMPP (or any similar local server environment like WAMP, MAMP, or LAMP).
- A web server (e.g., Apache, Nginx).
- PHP (version 7.4 or higher).
- MySQL or MariaDB database.
- Composer (for dependency management).
- Git (optional, for cloning the repository).

### Steps

1. **Clone the Repository (optional)**:
   If you have Git installed, you can clone the repository using:
   ```sh
   git clone https://github.com/hazminfirdaus/auto-service-scheduling-system.git
   ```

2. **Download the Repository**:
   If you don't use Git, you can download the repository as a ZIP file from GitHub and extract it.

3. **Move to the Project Directory**:
   ```sh
   cd auto-service-scheduling-system
   ```

4. **Install Dependencies**:
   Run Composer to install the necessary PHP dependencies:
   ```sh
   composer install
   ```

5. **Database Setup**:
   - Create a new database in your MySQL server.
   - Import the provided SQL file to set up the database schema and initial data:
     ```sh
     mysql -u username -p database_name < database/auto_service.sql
     ```
   
6. **Configuration**:
   - Rename the `example-connection.php` file to `connection.php`.
   - Update the `connection.php` file with your database credentials and other configuration settings.

7. **Set Up Your Web Server**:
   - Configure your web server to serve the project directory.
   - Make sure the document root is set to the public directory of the project.

8. **Access the Application**:
   - Open your web browser and navigate to the URL where you set up the application.
   - For instance, `http://localhost/8000 or your-own-port-number`

## Functionality

### Admin

Admins have the following functionalities:

- **Dashboard**: Overview of all activities and statistics.
- **Manage Mechanics**: Add, edit, and delete mechanics.
- **Manage Customers**: View customer details and manage their accounts.
- **Manage Schedules**: View and modify schedules for all mechanics.
- **Manage Appointments**: View all appointments and their statuses.
- **Settings**: Update system settings and configurations.

### Mechanic

Mechanics have the following functionalities:

- **Dashboard**: Overview of their schedule and appointments.
- **Manage Schedule**: View their schedule and update availability.

### Customer

Customers have the following functionalities:

- **Dashboard**: Overview of their upcoming appointments.
- **View Available Sessions**: Search and view available sessions for booking up to 2 weeks in prior.
- **Book Appointments**: Book an appointment with a mechanic.
- **Manage Bookings**: View, reschedule, or cancel their appointments.
- **Profile Settings**: Update their personal information, delete account.

## Future Enhancements

### Mechanic

- **Appointment Management**: Update the status of appointments (e.g., completed, cancelled).
- **Communication**: Communicate with customers regarding their appointments.

### Customer

Customers have the following functionalities:

- **Dashboard**: Overview of their upcoming appointments.
- **View Available Sessions**: Search and view available sessions for booking up to 2 weeks in prior.
- **Book Appointments**: Book an appointment with a mechanic.
- **Manage Bookings**: View, reschedule, or cancel their appointments.
- **Profile Settings**: Update their personal information, delete account.

## Support

For any issues or support, please contact the project maintainers or create an issue in the GitHub repository.

---

Thank you for using the Auto Service Scheduling System!
