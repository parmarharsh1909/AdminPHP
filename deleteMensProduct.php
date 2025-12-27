<?php

include 'connection.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$response = array();
$id = $_POST["id"];

$sql = "delete from tbl_products where id='$id'";
$result = mysqli_query($conn, $sql);

if($result) {
    $response['status'] = "true";
    $response['message'] = "Product Deleted";
} else {
    $response['status'] = "false";
    $response['message'] = "Failed to Delete Product";
}
echo json_encode($response);

$conn->close();
