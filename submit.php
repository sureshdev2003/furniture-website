<?php
// Database connection
$host = "localhost";
$user = "root";       // Default for XAMPP
$password = "";       // Default for XAMPP
$dbname = "user_auth";

// Connect to MySQL
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// When form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function sanitize($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    $name = sanitize($_POST['name']);
    $phone = sanitize($_POST['phone']);
    $address = sanitize($_POST['address']);
    $pincode = sanitize($_POST['pincode']);
    $district = sanitize($_POST['district']);
    $state = sanitize($_POST['state']);
    $nearby = sanitize($_POST['nearby']);
    $password = sanitize($_POST['password']);
    $confirm_password = sanitize($_POST['confirm_password']);

    $errors = [];

    // Validation
    if ($password !== $confirm_password) {
        $errors[] = "Password and Confirm Password do not match.";
    }

    if (!preg_match('/^\d{10}$/', $phone)) {
        $errors[] = "Phone number must be 10 digits.";
    }

    if (!preg_match('/^\d{6}$/', $pincode)) {
        $errors[] = "Pincode must be 6 digits.";
    }

    if (!empty($errors)) {
        echo "<h2>Errors:</h2><ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul><a href='javascript:history.back()'>Go Back</a>";
        exit;
    }

    // Hash password before storing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert data
    $stmt = $conn->prepare("INSERT INTO details (name, phone, address, pincode, district, state, nearby, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $name, $phone, $address, $pincode, $district, $state, $nearby, $hashed_password);

    if ($stmt->execute()) {
        echo "<h2>Details submitted successfully!</h2>";
        echo "<a href='GREENWOOD FURNITURES1.html'>Go to Home</a>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
