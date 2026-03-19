<?php
include 'connection.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");


$order_id = $_POST['order_id'] ?? $_GET['order_id'] ?? '';
$user_id = $_POST['user_id'] ?? $_GET['user_id'] ?? '';
$product_id = $_POST['product_id'] ?? $_GET['product_id'] ?? '';

$update_sql = "UPDATE tbl_orders 
               SET order_status='Cancelled' 
               WHERE order_id='$order_id' 
               AND user_id='$user_id' 
               AND product_id='$product_id'";

$update_result = mysqli_query($conn, $update_sql);

if ($update_result) {

    echo json_encode([
        "status" => true,
        "message" => "Order cancelled successfully"
    ]);
} else {

    echo json_encode([
        "status" => false,
        "message" => "Failed to cancel order"
    ]);
}

mysqli_close($conn);
