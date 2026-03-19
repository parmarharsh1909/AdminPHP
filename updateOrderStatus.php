<?php
include 'connection.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if (isset($_POST['order_id']) && isset($_POST['order_status'])) {

    $order_id = $_POST['order_id'];
    $order_status = $_POST['order_status'];

    $query = "UPDATE tbl_orders 
              SET order_status='$order_status' 
              WHERE order_id='$order_id'";

    if (mysqli_query($conn, $query)) {
        echo json_encode([
            "status" => true,
            "message" => "Whole Order Status Updated"
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "Update Failed"
        ]);
    }

} else {
    echo json_encode([
        "status" => false,
        "message" => "Missing Data"
    ]);
}

mysqli_close($conn);
?>