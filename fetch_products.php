<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
$host = "localhost";
$user = "root";
$pass = "";
$db = "event_weaver"; // Update if your DB name is different

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$main = $_GET['main_category'] ?? '';
$sub = $_GET['sub_category'] ?? '';

$sql = "SELECT * FROM product WHERE main_category = ? AND sub_category = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $main, $sub);
$stmt->execute();

$result = $stmt->get_result();
$products = [];

while ($row = $result->fetch_assoc()) {
  $products[] = $row;
}

header('Content-Type: application/json');
echo json_encode($products);
?>

