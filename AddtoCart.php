<?php
include 'connection.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
$response = [];
$id = $_POST['id'] ?? '';

$userid = 1;


$sql = "update tbl_products 
SET AddToCart = 1 ,
user_id = '$userid'


where id='241'";

if (mysqli_query($conn, $sql)) {
    $response['status'] = "true";
    $response['message'] = "Product added to cart successfully";
} else {
    $response['status'] = "false";
    $response['message'] = "Failed to add product to cart";
}
echo json_encode($response);
$conn->close();
