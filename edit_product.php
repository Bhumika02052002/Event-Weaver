<?php
session_start();
include('db_connect.php');

$shopkeeper_id = $_SESSION["shopkeeper_id"];
$product_id = $_POST["product_id"];

$name = mysqli_real_escape_string($conn, $_POST["name"]);
$description = mysqli_real_escape_string($conn, $_POST["description"]);
$price = mysqli_real_escape_string($conn, $_POST["price"]);
$main_category = mysqli_real_escape_string($conn, $_POST["main_category"]);
$sub_category = mysqli_real_escape_string($conn, $_POST["sub_category"]);

if (!empty($_FILES["image_path"]["name"])) {
    $image_name = $_FILES["image_path"]["name"];
    $image_tmp = $_FILES["image_path"]["tmp_name"];
    $upload_dir = "uploads/";
    move_uploaded_file($image_tmp, $upload_dir . $image_name);
    $image_path = $upload_dir . $image_name;

    $sql = "UPDATE product SET name=?, description=?, price=?, main_category=?, sub_category=?, image_path=? WHERE id=? AND shopkeeper_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdsssii", $name, $description, $price, $main_category, $sub_category, $image_path, $product_id, $shopkeeper_id);
} else {
    $sql = "UPDATE product SET name=?, description=?, price=?, main_category=?, sub_category=? WHERE id=? AND shopkeeper_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdssii", $name, $description, $price, $main_category, $sub_category, $product_id, $shopkeeper_id);
}

if ($stmt->execute()) {
    header("Location: Shopkeeper_Dashboard.html");
    exit();
} else {
    echo "Error: " . $conn->error;
}
?>
