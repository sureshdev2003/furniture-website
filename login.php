<?php
session_start();
require_once 'config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get and sanitize form data
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password']; // Don't sanitize password before verification
    
    // Validate input
    if (empty($email) || empty($password)) {
        redirect_with_message('GWF  SIGNIN.html', 'Please fill in all fields', 'error');
        exit();
    }
    
    // Check if email exists and verify password
    $sql = "SELECT id, email, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password is correct, create session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['logged_in'] = true;
            
            // Redirect to main page
            redirect_with_message('GREENWOOD-FURNITURES1.html', 'Login successful! Welcome back.', 'success');
        } else {
            // Password is incorrect
            redirect_with_message('GWF  SIGNIN.html', 'Invalid email or password', 'error');
        }
    } else {
        // Email not found
        redirect_with_message('GWF  SIGNIN.html', 'Invalid email or password', 'error');
    }
    
    $stmt->close();
} else {
    // If not POST request, redirect to login page
    header("Location: GWF  SIGNIN.html");
    exit();
}

$conn->close();
?>