<?php
include 'connection.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// ================= INPUTS =================
$user_id          = $_POST['user_id'] ?? '';
$shipping_address = $_POST['shipping_address'] ?? '';
$payment_method   = $_POST['payment_method'] ?? '';
$payment_status   = $_POST['payment_status'] ?? '';
$payment_id       = $_POST['payment_id'] ?? '';
$itemsRaw         = $_POST['items'] ?? '';

$items = json_decode($itemsRaw, true);

// ================= VALIDATION =================
if (!$user_id || !is_array($items)) {
    echo json_encode([
        "status" => false,
        "message" => "Invalid data"
    ]);
    exit;
}

// ================= ORDER INFO =================
$order_date = date('Y-m-d H:i:s');
$order_id   = time() . rand(1000, 9999);

// ================= LOOP =================
foreach ($items as $item) {

    $product_id = $item['product_id'];

    // ✅ price fix
    $price = isset($item['price']) ? floatval($item['price']) : 0;

    // ✅ qty fix (VERY IMPORTANT)
    $qty = isset($item['qty']) 
        ? intval($item['qty']) 
        : (isset($item['quantity']) ? intval($item['quantity']) : 1);

    // ✅ discount fix
    $discount_value = isset($item['discount_value']) 
        ? floatval($item['discount_value']) 
        : 0;

    $promocode = $item['promocode'] ?? '';

    // ================= CALCULATION =================
    $original_price = $price * $qty;

    $discount_amount = ($original_price * $discount_value) / 100;

    $final_price = $original_price - $discount_amount;

    if ($final_price < 0) {
        $final_price = 0;
    }

    // ================= INSERT =================
    $sql = "INSERT INTO tbl_orders 
    (product_id, quantity, price, total_price, discount_amount, final_price, promocode, payment_method, payment_status, payment_id, order_date, order_id, user_id, shipping_address)
    VALUES
    ('$product_id', '$qty', '$price', '$original_price', '$discount_amount', '$final_price', '$promocode', '$payment_method', '$payment_status', '$payment_id', '$order_date', '$order_id', '$user_id', '$shipping_address')";

    $res = mysqli_query($conn, $sql);

    if (!$res) {
        echo json_encode([
            "status" => false,
            "error" => mysqli_error($conn)
        ]);
        exit;
    }
}

// ================= RESPONSE =================
echo json_encode([
    "status" => true,
    "order_id" => $order_id,
    "message" => "Order placed with product-wise offers"
]);

$conn->close();
?>