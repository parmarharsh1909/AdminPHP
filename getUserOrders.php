<?php
include 'connection.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$user_id = $_GET['user_id'] ?? '';

if ($user_id == '') {
    echo json_encode([
        "status" => false,
        "message" => "user_id required"
    ]);
    exit;
}

$sql = "SELECT 
    o.*, 
    p.product_name, 
    p.image, 
    p.sub_catid,
    u.name AS customer_name,
    u.email AS customer_email,
    u.phone AS customer_phone,
    u.address AS customer_address
FROM tbl_orders o
LEFT JOIN tbl_products p ON o.product_id = p.id
LEFT JOIN tbl_signup u ON o.user_id = u.id
WHERE o.user_id = '$user_id'
ORDER BY o.id DESC";

$result = mysqli_query($conn, $sql);

$orders = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {

        $order_id = $row['order_id'];

        // image path
        $product_image = ($row['sub_catid'] <= 3)
            ? "Uploads/Mens/" . $row['image']
            : "Uploads/Womens/" . $row['image'];

        // 🔥 safe values
        $discount_amount = $row['discount_amount'] ?? 0;
        $final_price     = $row['final_price'] ?? $row['total_price'];

        // 🔥 GROUP BY order_id
        if (!isset($orders[$order_id])) {
            $orders[$order_id] = [
                "order_id" => $row['order_id'],
                "user_id" => $row['user_id'],
                "order_status" => $row['order_status'],
                "payment_status" => $row['payment_status'],
                "payment_method" => $row['payment_method'],
                "payment_id" => $row['payment_id'],
                "order_date" => $row['order_date'],
                "shipping_address" => $row['shipping_address'],

                // 🔥 ORDER LEVEL (will calculate properly below)
                "final_price" => 0,
                "total_price" => 0,
                "discount_amount" => 0,

                "promocode" => $row['promocode'],
                "customer_name" => $row['customer_name'],
                "customer_email" => $row['customer_email'],
                "customer_phone" => $row['customer_phone'],
                "customer_address" => $row['customer_address'],
                "products" => []
            ];
        }

        // 🔥 ADD PRODUCT WITH DISCOUNT
        $orders[$order_id]["products"][] = [
            "product_id" => $row['product_id'],
            "product_name" => $row['product_name'],
            "product_image" => $product_image,
            "quantity" => $row['quantity'],
            "price" => $row['price'],

            // 🔥 IMPORTANT FIELDS
            "item_total" => $row['total_price'],
            "item_discount" => $discount_amount,
            "item_final_price" => $final_price
        ];

        // 🔥 CALCULATE ORDER TOTALS (SAFE)
        $orders[$order_id]["total_price"] += $row['total_price'];
        $orders[$order_id]["discount_amount"] += $discount_amount;
        $orders[$order_id]["final_price"] += $final_price;
    }

    // reset indexing
    $data = array_values($orders);

    echo json_encode([
        "status" => true,
        "data" => $data
    ]);
} else {
    echo json_encode([
        "status" => false,
        "message" => "Query Failed"
    ]);
}

mysqli_close($conn);
?>