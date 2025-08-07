<?php
session_start();
include('db_connect.php');

$_SESSION["shopkeeper_id"] = 1;
$shopkeeper_id = $_SESSION["shopkeeper_id"];

$name = mysqli_real_escape_string($conn, $_POST["name"]);
$description = mysqli_real_escape_string($conn, $_POST["description"]);
$price = mysqli_real_escape_string($conn, $_POST["price"]);
$main_category = mysqli_real_escape_string($conn, $_POST["main_category"]);
$sub_category = mysqli_real_escape_string($conn, $_POST["sub_category"]);

$image_name = $_FILES["image_path"]["name"];
$image_tmp = $_FILES["image_path"]["tmp_name"];
$upload_dir = "uploads/";
move_uploaded_file($image_tmp, $upload_dir . $image_name);
$image_path = $upload_dir . $image_name;

$sql = "INSERT INTO product (shopkeeper_id, name, description, price, image_path, main_category, sub_category)
        VALUES ('$shopkeeper_id', '$name', '$description', '$price', '$image_path', '$main_category', '$sub_category')";

if (mysqli_query($conn, $sql)) {
    //  Redirect to dashboard
    header("Location: Shopkeeper_Dashboard.html");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
