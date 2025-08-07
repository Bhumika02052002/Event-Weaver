<?php
session_start();
include 'db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['shopkeeper_id'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

$shopkeeper_id = $_SESSION['shopkeeper_id'];

$sql = "SELECT * FROM product WHERE shopkeeper_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $shopkeeper_id);
$stmt->execute();

$result = $stmt->get_result();
$products = [];

while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products);
?>
