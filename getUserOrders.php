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

$data = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {

        // image path
        $row['product_image'] = ($row['sub_catid'] <= 3)
            ? "Uploads/Mens/" . $row['image']
            : "Uploads/Womens/" . $row['image'];

        // safety fallback
        $row['discount_amount'] = $row['discount_amount'] ?? 0;
        $row['final_price']     = $row['final_price'] ?? $row['total_price'];
        $row['you_saved']       = $row['discount_amount'];

        $data[] = $row;
    }

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