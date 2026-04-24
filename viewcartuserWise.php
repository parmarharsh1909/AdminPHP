<?php
include 'connection.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$response = [];
$user_id = $_POST['user_id'] ?? 0;

if ($user_id == 0) {
    echo json_encode([
        "status" => "false",
        "message" => "User ID required"
    ]);
    exit;
}

$sql = "
   SELECT 
  c.id AS cart_id,
  p.id AS product_id,
  p.product_name,
  p.description,
  p.price,
  p.purity,
  p.image,
  c.quantity,
  m.maincatname,
  tbl_offers.promocode,
  tbl_offers.offerdescription,
  tbl_offers.discount_value

FROM tbl_cart c

JOIN tbl_products p ON c.product_id = p.id
JOIN tbl_subcategory s ON p.sub_catid = s.id
JOIN tbl_maincategory m ON s.maincat_id = m.id

LEFT JOIN tbl_offers ON p.offer_id = tbl_offers.offer_id

WHERE c.user_id = $user_id;
";


$result = mysqli_query($conn, $sql);

$response['men'] = [];
$response['women'] = [];

while ($row = mysqli_fetch_assoc($result)) {
    if ($row['maincatname'] === 'Men Jewellery') {
        $response['men'][] = $row;
    } else if ($row['maincatname'] === 'Women Jewellery') {
        $response['women'][] = $row;
    }
}

$response['status'] = "true";
echo json_encode($response);
$conn->close();
