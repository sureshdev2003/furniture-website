<?php
session_start();
require_once 'config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get and sanitize form data
    $name = sanitize_input($_POST['name']);
    $phone = sanitize_input($_POST['phone']);
    $address = sanitize_input($_POST['address']);
    $pincode = sanitize_input($_POST['pincode']);
    $district = sanitize_input($_POST['district']);
    $state = sanitize_input($_POST['state']);
    $nearby = sanitize_input($_POST['nearby']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate input
    if (empty($name) || empty($phone) || empty($address) || empty($pincode) || 
        empty($district) || empty($state) || empty($password)) {
        redirect_with_message('GWF SIGNUP DETAILS PAGE.html', 'Please fill in all required fields', 'error');
        exit();
    }
    
    // Validate password
    if (strlen($password) < 6) {
        redirect_with_message('GWF SIGNUP DETAILS PAGE.html', 'Password must be at least 6 characters long', 'error');
        exit();
    }
    
    // Check if passwords match
    if ($password !== $confirm_password) {
        redirect_with_message('GWF SIGNUP DETAILS PAGE.html', 'Passwords do not match', 'error');
        exit();
    }
    
    // Generate a unique email (you might want to add email field to your form)
    $email = strtolower(str_replace(' ', '', $name)) . '@greenwood.com';
    
    // Check if email already exists
    $check_sql = "SELECT id FROM users WHERE email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        // Email exists, generate a unique one
        $counter = 1;
        while ($check_result->num_rows > 0) {
            $email = strtolower(str_replace(' ', '', $name)) . $counter . '@greenwood.com';
            $check_stmt->bind_param("s", $email);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
            $counter++;
        }
    }
    $check_stmt->close();
    
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // Insert into users table
        $user_sql = "INSERT INTO users (email, password) VALUES (?, ?)";
        $user_stmt = $conn->prepare($user_sql);
        $user_stmt->bind_param("ss", $email, $hashed_password);
        
        if (!$user_stmt->execute()) {
            throw new Exception("Error creating user account");
        }
        
        $user_id = $conn->insert_id;
        
        // Insert into user_details table
        $details_sql = "INSERT INTO user_details (user_id, name, phone, address, pincode, district, state, nearby) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $details_stmt = $conn->prepare($details_sql);
        $details_stmt->bind_param("isssssss", $user_id, $name, $phone, $address, $pincode, $district, $state, $nearby);
        
        if (!$details_stmt->execute()) {
            throw new Exception("Error saving user details");
        }
        
        // Commit transaction
        $conn->commit();
        
        // Create session for the new user
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_email'] = $email;
        $_SESSION['logged_in'] = true;
        
        // Redirect with success message
        redirect_with_message('GREENWOOD-FURNITURES1.html', 'Registration successful! Welcome to Greenwood Furnitures.', 'success');
        
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        redirect_with_message('GWF SIGNUP DETAILS PAGE.html', 'Registration failed: ' . $e->getMessage(), 'error');
    }
    
    $user_stmt->close();
    $details_stmt->close();
    
} else {
    // If not POST request, redirect to signup page
    header("Location: GWF SIGNUP DETAILS PAGE.html");
    exit();
}

$conn->close();
?>