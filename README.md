# Greenwood Furnitures - User Authentication System

This project implements a complete user authentication system for Greenwood Furnitures website with MySQL database integration.

## Features

- User registration with detailed information
- Secure login system with password hashing
- Session management
- Database-driven user storage
- Form validation and security measures

## Setup Instructions

### 1. Database Setup

1. **Install XAMPP/LAMP** (if not already installed)
   - Download from: https://www.apachefriends.org/
   - Install and start Apache and MySQL services

2. **Create Database**
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Import the `database_setup.sql` file or run the SQL commands manually
   - This will create the `user_auth` database with required tables

### 2. File Structure

```
internshipSS/
├── config.php              # Database configuration
├── login.php               # Login processing
├── sign up.php             # Registration processing
├── logout.php              # Logout functionality
├── check_session.php       # Session management
├── database_setup.sql      # Database structure
├── GWF  SIGNIN.html        # Login form
├── GWF SIGNUP DETAILS PAGE.html  # Registration form
└── README.md               # This file
```

### 3. Configuration

1. **Database Settings** (in `config.php`):
   ```php
   $servername = "localhost";
   $username = "root";        // Default XAMPP username
   $password = "";           // Default XAMPP password (blank)
   $dbname = "user_auth";
   ```

2. **Update these values** if your MySQL setup is different

### 4. Testing

1. **Start your web server** (XAMPP/LAMP)
2. **Navigate to**: `http://localhost/internshipSS/`
3. **Test Registration**:
   - Go to signup page
   - Fill in all required fields
   - Submit the form
4. **Test Login**:
   - Use the email generated during registration
   - Use the password you set
   - Should redirect to main page on success

### 5. Default Admin Account

A default admin account is created during database setup:
- **Email**: admin@greenwood.com
- **Password**: admin123

## Security Features

- **Password Hashing**: All passwords are hashed using PHP's `password_hash()`
- **SQL Injection Prevention**: Prepared statements used throughout
- **Input Sanitization**: All user inputs are sanitized
- **Session Management**: Secure session handling
- **Form Validation**: Client and server-side validation

## Database Schema

### Users Table
- `id` (Primary Key)
- `email` (Unique)
- `password` (Hashed)
- `created_at`
- `updated_at`

### User Details Table
- `id` (Primary Key)
- `user_id` (Foreign Key to users.id)
- `name`
- `phone`
- `address`
- `pincode`
- `district`
- `state`
- `nearby`
- `created_at`

## Troubleshooting

### Common Issues:

1. **Connection Failed**
   - Ensure MySQL service is running
   - Check database credentials in `config.php`
   - Verify database `user_auth` exists

2. **Form Not Submitting**
   - Check file paths are correct
   - Ensure PHP is enabled in your web server
   - Check for syntax errors in PHP files

3. **Registration Issues**
   - Verify all required fields are filled
   - Check password length (minimum 6 characters)
   - Ensure passwords match

## File Descriptions

- **login.php**: Handles user authentication
- **sign up.php**: Processes user registration
- **config.php**: Database connection and utility functions
- **check_session.php**: Session management functions
- **logout.php**: Handles user logout
- **database_setup.sql**: Database structure and initial data

## Next Steps

1. Add email verification
2. Implement password reset functionality
3. Add user profile management
4. Implement role-based access control
5. Add more security features (CSRF protection, rate limiting)

## Support

For issues or questions, check the troubleshooting section above or review the PHP error logs in your web server configuration. 