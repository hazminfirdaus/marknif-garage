# Auto Service Booking System: Marknif Garage

## Overview

The Auto Service Booking System is a web-based application designed to streamline the process of booking and managing auto service appointments. This system allows customers to book appointments with mechanics, mechanics to manage their schedules, and admins to oversee the entire operation.

## Features

- **Admin**: Manage mechanics, view all bookings, manage customers, and oversee schedules.
- **Mechanic**: View and manage their own schedules, appointments, account settings, and email notifications.
- **Customer**: View available sessions, book appointments, manage their bookings, account settings, and email notifications.

## Live Demo
The website is accesible at: [Marknif Garage](https://marknif.com/)

## Installation Guide

### Prerequisites

- XAMPP (or any similar local server environment like WAMP, MAMP, or LAMP) which includes:
   - A web server (e.g., Apache, Nginx).
   - PHP (version 7.4 or higher).
   - MySQL or MariaDB database.
- Composer (for dependency management).
- Git (optional, for cloning the repository).

### Steps

1. **Download and Install XAMPP**:
   Download XAMPP from Apache Friends and install it.
   Start the Apache and MySQL modules from the XAMPP Control Panel.

2. **Clone the Repository (optional)**:
   If you have Git installed, you can clone the repository using:
   ```sh
   git clone https://github.com/hazminfirdaus/marknif-garage.git
   ```

3. **Download the Repository**:
   If you don't use Git, you can download the repository as a ZIP file from GitHub and extract it.

4. **Move to the Project Directory**:
   ```sh
   cd marknif-garage
   ```

5. **Install Dependencies**:
   Run Composer to install the necessary PHP dependencies:
   ```sh
   composer install
   ```

6. **Database Setup**:
   - Open phpMyAdmin by navigating to http://localhost/phpmyadmin in your web browser.
   - Create a new database, e.g., marknif_garage.
   - Import the provided SQL file to set up the database schema and initial data:
     ```sh
     mysql -u username -p database_name < database/marknif_garage.sql
     ```
   
7. **Configuration**:
   - Rename the `example-connection.php` file to `connection.php`.
   - Update the `connection.php` file with your database credentials and other configuration settings.

8. **Set Up Your Web Server**:
   - Configure your web server to serve the project directory.
   - Make sure the document root is set to the public directory of the project.
   - Typically, for XAMPP, you can move the project folder to C:\xampp\htdocs\ (Windows) or /Applications/XAMPP/htdocs/ (macOS).

9. **Access the Application**:
   - Open your web browser and navigate to the URL where you set up the application.
   - For instance, `http://localhost/marknif-garage`

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
- **Profile Settings**: Update their personal information, delete account.
- **Email Notifications**: Receive confirmation emails upon successful appointment booking or booking cancellation.

### Customer

Customers have the following functionalities:

- **Dashboard**: Overview of their upcoming appointments.
- **View Available Sessions**: Search and view available sessions for booking up to 2 weeks in prior.
- **Book Appointments**: Book an appointment with a mechanic.
- **Manage Bookings**: View, retrieve booking history or cancel their appointments.
- **Profile Settings**: Update their personal information, delete account.
- **Email Notifications**: Receive confirmation emails upon successful appointment booking or booking cancellation.

## Future Enhancements

In general, improve security with user authentication for instance; password hashing and encryption.

### Mechanic

Customers to have the following functionalities:

- **Appointment Management**: Update the status of appointments (e.g., completed, cancelled).
- **Communication**: Communicate with customers regarding their appointments.

### Customer

Customers to have the following functionalities:

- **Service Reminder**: Send a SMS or email reminder a day before appointment.
- **In-App Inbox & Notifications**: Inbox with updates and reminders.
- **24 hours Cancellation Policy**: Limit cancellation 24 hours before appointment, cancellation fee if customers wish to proceed with cancellation.

## Support

For any issues or support, please contact the project maintainers or create an issue in the GitHub repository.

---

Thank you for using the Auto Service Booking System!
