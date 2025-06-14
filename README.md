# Rental Management System

A comprehensive web-based rental management system built with PHP for managing properties, tenants, payments, and expenses.

## Features

- **Property Management**
  - Property listing and details
  - Unit management
  - Property categories and subcategories

- **Tenant Management**
  - Tenant registration and profiles
  - Tenant reports
  - Request handling

- **Financial Management**
  - Monthly payments tracking
  - Condominium payments
  - Expense tracking and reporting
  - Payment history
  - Pending payments monitoring

- **Reporting**
  - Tenant reports
  - Expense reports
  - Condominium reports
  - Financial analytics

- **User Management**
  - User authentication
  - Role-based access control
  - User settings

## System Requirements

- PHP 7.4 or higher
- MySQL/MariaDB
- Web server (Apache/Nginx)
- PHPMailer for email functionality

## Installation

1. Clone the repository to your web server directory
2. Import the database schema from `rental_management.sql`
3. Configure your database connection in the settings
4. Set up your web server to point to the project directory
5. Ensure proper permissions are set for file uploads and logs

### Default Login Credentials

For first-time access, use the following credentials:
- Username: `admin`
- Password: `allow`

**Important:** Please change the default password immediately after your first login for security purposes.

## Directory Structure

- `assets/` - Contains CSS, JavaScript, and image files
- `includes/` - Core PHP includes and functions
- `models/` - Database models and business logic
- `PHPMailer/` - Email functionality
- `settings/` - Configuration files

## Main Components

- `Dashboard.php` - Main dashboard interface
- `properties.php` - Property management
- `Tenants.php` - Tenant management
- `Payments.php` - Payment processing
- `Expenses.php` - Expense tracking
- `Reports/` - Various reporting modules

## Security

- Password hashing
- SQL injection prevention
- XSS protection
- CSRF protection
- Input validation

## Support

For support and queries, please contact the system administrator.

## License

This project is proprietary software. All rights reserved. 