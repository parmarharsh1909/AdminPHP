<?php
include 'connection.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$product_name = $_POST["ProductName"];
$description  = $_POST["Description"];
$sub_catid    = $_POST["SubCatId"];
$price        = $_POST["Price"];
$purity       = $_POST["Purity"];

$sql = "INSERT INTO tbl_products 
        (product_name, description, sub_catid, price, purity)
        VALUES 
        ('$product_name','$description','$sub_catid','$price','$purity')";

mysqli_query($conn, $sql);

/* MEN STYLE RESPONSE */
echo json_encode([
  "status" => "true"
]);

$conn->close();
