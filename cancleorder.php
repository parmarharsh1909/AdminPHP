<?php
include 'connection.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$order_id = $_POST['order_id'] ?? $_GET['order_id'] ?? '';
$user_id  = $_POST['user_id'] ?? $_GET['user_id'] ?? '';

if ($order_id == '' || $user_id == '') {
    echo json_encode([
        "status" => false,
        "message" => "order_id and user_id required"
    ]);
    exit;
}

// 🔥 UPDATE ALL PRODUCTS OF SAME ORDER
$update_sql = "UPDATE tbl_orders 
               SET order_status='Cancelled' 
               WHERE order_id='$order_id' 
               AND user_id='$user_id'";

$update_result = mysqli_query($conn, $update_sql);

if ($update_result && mysqli_affected_rows($conn) > 0) {

    echo json_encode([
        "status" => true,
        "message" => "Full order cancelled successfully"
    ]);

} else {

    echo json_encode([
        "status" => false,
        "message" => "No order found or already cancelled"
    ]);
}

mysqli_close($conn);
?>