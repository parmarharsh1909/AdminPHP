<?php
include 'connection.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$productId = $_POST['product_id'] ?? 0;
$userId    = $_POST['user_id'] ?? 0;
$qty    = $_POST['quantity'] ?? 0;



if ($productId == 0 || $userId == 0) {
    echo json_encode([
        "status" => "false",
        "message" => "Invalid data"
    ]);
    exit;
}

$check = "update tbl_cart
set quantity = $qty
          WHERE user_id = '$userId' 
          AND product_id = '$productId'";
if ($qty == 0) {
    $check = "delete from tbl_cart
          WHERE user_id = '$userId' 
          AND product_id = '$productId'";
}

$result = mysqli_query($conn, $check);

if ($result) {
    echo json_encode([
        "status" => "true",
        "message" => "cart Qty updated"
    ]);
} else {
    echo json_encode([
        "status" => "false",
        "message" => mysqli_error($conn)
    ]);
}

$conn->close();
