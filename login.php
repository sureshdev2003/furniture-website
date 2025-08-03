<?php
$servername = "localhost";
$username = "root"; // default username
$password = "";     // default password (keep blank if using XAMPP/LAMP)
$dbname = "user_auth";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get form data
$email = $_POST['email'];
$raw_password = $_POST['password'];

// Hash the password before storing (SECURE)
$hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

// Insert into database
$sql = "INSERT INTO users (email, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $hashed_password);

if ($stmt->execute()) {
  echo "<script>alert('Login successful!'); window.location.href='projdetails.html';</script>";
} else {
  echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>