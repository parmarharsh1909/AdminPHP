<?php
include 'connection.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$data = json_decode(file_get_contents("php://input"), true);

// safe fetch
$order_id = $data['order_id'] ?? $_POST['order_id'] ?? '';
$payment_id = $data['payment_id'] ?? $_POST['payment_id'] ?? '';

if ($order_id == '' || $payment_id == '') {
    echo json_encode([
        "status" => false,
        "message" => "order_id or payment_id missing"
    ]);
    exit;
}

// update orders
mysqli_query($conn, "
    UPDATE tbl_orders 
    SET payment_status='Paid', payment_id='$payment_id' 
    WHERE order_id='$order_id'
");

// insert purchase
$getOrders = mysqli_query($conn, "SELECT * FROM tbl_orders WHERE order_id='$order_id'");

while ($row = mysqli_fetch_assoc($getOrders)) {

    $product_id = $row['product_id'];

    mysqli_query($conn, "
        INSERT INTO tbl_purchase (status, paymentid, timestamp, productid)
        VALUES ('success', '$payment_id', NOW(), '$product_id')
    ");
}

echo json_encode([
    "status" => true
]);
?>