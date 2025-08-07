<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "event_weaver");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get values from form
$full_name = $_POST['full-name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$dob = $_POST['dob'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure hash
$address = $_POST['address'];

// Insert into database
$sql = "INSERT INTO customers (full_name, email, phone, dob, password, address)
        VALUES ('$full_name', '$email', '$phone', '$dob', '$password', '$address')";

if ($conn->query($sql) === TRUE) {
    // Redirect to login page
    header("Location: customer_login.html");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
