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

$exe = pathinfo($_FILES['ProductImg']['name'], PATHINFO_EXTENSION);

$filename = time() . random_int(1000, 9999) . '.' . $exe;


$sql = "INSERT INTO tbl_products (product_name, description, sub_catid, price, purity, image)
VALUES ('$product_name','$description','$sub_catid','$price','$purity','$filename')";

move_uploaded_file($_FILES['ProductImg']['tmp_name'], './Uploads/Mens/' . $filename);
$result = mysqli_query($conn, $sql);

$response['status'] = "true";

echo json_encode($response);

$conn->close();
