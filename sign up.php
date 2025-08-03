<?php
$servername = "localhost"; 
$username = "root";
$password = ""; 
$dbname = "user_auth";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Collect form data
$name = $_POST['name'];
$phone = $_POST['tel'];
$address=$_POST['address'];
$pincode=$_POST['pincode'];
$district=$_POST['district'];
$state=$_POST['state'];
$nearby=$_POST['nearby']
$password = $_POST['psw'];

// Optional: Hash the password for security
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
 
// Insert data into database
$sql = "INSERT INTO details ( name, tel,address,pincode,district,state,nearby, psw, ) 
        VALUES ('$name', '$phone', '$address','$pincode','$district','$state','$nearby','$password','$hashedPassword')";

if ($conn->query($sql) === TRUE) {
  echo "Registration successful!";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>