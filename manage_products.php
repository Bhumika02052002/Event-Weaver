<?php
include 'db_connect.php';

$sql = "SELECT * FROM products";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row["product_name"]."</td>
                <td>".$row["product_description"]."</td>
                <td>".$row["product_price"]."</td>
                <td>".$row["product_category"]."</td>
                <td>
                    <button onclick='editProduct(this)'>Edit</button>
                    <button onclick='deleteProduct(this)'>Delete</button>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No products found</td></tr>";
}
$conn->close();
?>