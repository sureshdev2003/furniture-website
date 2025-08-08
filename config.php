<?php
// Database configuration
$servername = "localhost";
$username = "root"; // default username for XAMPP/LAMP
$password = "";     // default password (keep blank if using XAMPP/LAMP)
$dbname = "user_auth";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8
$conn->set_charset("utf8");

// Function to sanitize input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to redirect with message
function redirect_with_message($url, $message, $type = 'success') {
    echo "<script>
        alert('$message');
        window.location.href = '$url';
    </script>";
}
?> 