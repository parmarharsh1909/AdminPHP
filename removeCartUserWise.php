<?php
include 'connection.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$response = [];

// MATCH REACT FIELD NAMES
$product_id = $_POST['product_id'] ?? '';
$user_id    = $_POST['user_id'] ?? '';

if (empty($product_id) || empty($user_id)) {
    $response['status'] = "false";
    $response['message'] = "Product ID and User ID are required";
    echo json_encode($response);
    exit;
}

$sql = "DELETE FROM tbl_cart WHERE product_id = '$product_id' AND user_id = '$user_id'";

if (mysqli_query($conn, $sql)) {
    $response['status'] = "true";
    $response['message'] = "Product removed from cart successfully";
} else {
    $response['status'] = "false";
    $response['message'] = "Failed to remove product from cart";
}

echo json_encode($response);
$conn->close();
