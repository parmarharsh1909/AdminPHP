<?php

include 'connection.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$response = array();

$product_name = $_POST["ProductName"];
$description  = $_POST["Description"];
$sub_catid    = $_POST["SubCatId"];
$price        = $_POST["Price"];
$purity       = $_POST["Purity"];

$sql = "INSERT INTO tbl_products (product_name, description, sub_catid, price, purity)
VALUES ('$product_name','$description','$sub_catid','$price','$purity')";

$result = mysqli_query($conn, $sql);

$response['status'] = "true";

echo json_encode($response);

$conn->close();
