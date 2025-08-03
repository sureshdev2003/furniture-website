<?php
$host = "localhost";
$dbname = "santhanam";
$user = "Details";
$pass = "";
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $address = htmlspecialchars($_POST['address']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $whatsapp = htmlspecialchars($_POST['whatsapp']);

    echo "<h2>Submitted Details:</h2>";
    echo "Name: " . $name . "<br>";
    echo "Address: " . $address . "<br>";
    echo "Email: " . $email . "<br>";
    echo "Phone Number: " . $phone . "<br>";
    echo "WhatsApp: " . $whatsapp . "<br>";
} else {
    echo "Form not submitted correctly.";
}
?>