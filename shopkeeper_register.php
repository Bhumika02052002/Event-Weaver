<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// DB connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "event_weaver";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Password match check
if ($_POST['password'] !== $_POST['confirm-password']) {
    echo "<script>alert('Passwords do not match'); window.history.back();</script>";
    exit;
}

// Collect data
$business_name = $_POST['business_name'];
$main_category = $_POST['main_category'];
$sub_category = $_POST['sub_category'];
$business_desc = $_POST['business_desc'];
$tax_id = $_POST['tax_id'];
$years_operating = !empty($_POST['years_operating']) ? $_POST['years_operating'] : 0;
$owner_name = $_POST['owner_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$alt_phone = $_POST['alt_phone'];
$business_address = $_POST['business_address'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$agreed_terms = isset($_POST['agreed_terms']) ? 1 : 0;
$marketing_option = isset($_POST['marketing_option']) ? 1 : 0;

// File handling
$business_license = $_FILES['business_license']['name'];
$additional_docs = "";

if (!file_exists("uploads")) {
    mkdir("uploads", 0777, true);
}

move_uploaded_file($_FILES['business_license']['tmp_name'], "uploads/" . $business_license);

if (!empty($_FILES['additional_docs']['name'][0])) {
    foreach ($_FILES['additional_docs']['tmp_name'] as $key => $tmp_name) {
        $filename = $_FILES['additional_docs']['name'][$key];
        move_uploaded_file($tmp_name, "uploads/" . $filename);
    }
    $additional_docs = implode(",", $_FILES['additional_docs']['name']);
}

// Insert query
$sql = "INSERT INTO shopkeepers (
    business_name, main_category, sub_category, business_desc, tax_id,
    years_operating, owner_name, email, phone, alt_phone,
    business_address, city, state, zip, password,
    business_license, additional_docs, agreed_terms, marketing_option, created_at
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssissssssssssiii",
    $business_name, $main_category, $sub_category, $business_desc, $tax_id,
    $years_operating, $owner_name, $email, $phone, $alt_phone,
    $business_address, $city, $state, $zip, $password,
    $business_license, $additional_docs, $agreed_terms, $marketing_option
);


if ($stmt->execute()) {
    echo "<script>
        alert('Registration successful!');
        window.location.href = 'shopkeeper-login.html';
    </script>";
} else {
    echo "Database error: " . $stmt->error;
}

$conn->close();
?>

