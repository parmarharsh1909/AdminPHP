<?php
include 'connection.php';


header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$response = array();

$result = mysqli_query($conn, query: "SELECT 
    o.id,
    o.order_number,
    o.product_id,
    o.sub_catid,
    o.product_name,
    s.name AS subcategory_name,
    o.quantity,
    o.price,
    o.total_price,
    o.customer_name,
    o.customer_phone,
    o.customer_address,
    o.status,
    o.order_date
FROM tbl_orders o
JOIN tbl_subcategory s ON o.sub_catid = s.id
ORDER BY o.id DESC;
");

while ($row = mysqli_fetch_assoc(result: $result))  {
    $rresponse['status'] = "true";
    $response['data'][] = $row;
}

echo json_encode(value: $response);

$conn->close();