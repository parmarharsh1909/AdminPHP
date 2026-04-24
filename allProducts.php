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
        "status" => false,
        "message" => "user_id required"
    ]);
    exit;
}

$response['status'] = true;

$menResult = mysqli_query($conn, "
  SELECT p.id, p.product_name, p.description, p.price, p.purity, p.image,
  IFNULL(AVG(r.rating), 0) AS average_rating,
  COUNT(r.id) AS total_reviews,
  s.name AS subcategory_name,
  m.maincatname AS maincategory_name,
  tbl_offers.promocode,
  tbl_offers.offerdescription
  FROM tbl_products p
  JOIN tbl_subcategory s ON p.sub_catid = s.id
  JOIN tbl_maincategory m ON s.maincat_id = m.id
  LEFT JOIN tbl_offers ON p.offer_id = tbl_offers.offer_id
  LEFT JOIN tbl_review r ON p.id = r.product_id
  WHERE m.maincatname = 'Men Jewellery'
  GROUP BY p.id
");

$response['men'] = [];

while ($row = mysqli_fetch_assoc($menResult)) {

    $productId = $row['id'];

    $cartResult = mysqli_query($conn, "
        SELECT id
        FROM tbl_cart
        WHERE product_id = $productId
          AND user_id = $user_id
        LIMIT 1
    ");

    if (mysqli_num_rows($cartResult) > 0) {
        $row['cartStatus'] = 1;
    } else {
        $row['cartStatus'] = 0;
    }

    $response['men'][] = $row;
}

$womenResult = mysqli_query($conn, "
  SELECT p.id, p.product_name, p.description, p.price, p.purity, p.image,
  IFNULL(AVG(r.rating), 0) AS average_rating,
  COUNT(r.id) AS total_reviews,
  s.name AS subcategory_name,
  m.maincatname AS maincategory_name,
  tbl_offers.promocode,
  tbl_offers.offerdescription
  FROM tbl_products p
  JOIN tbl_subcategory s ON p.sub_catid = s.id
  JOIN tbl_maincategory m ON s.maincat_id = m.id
  LEFT JOIN tbl_offers ON p.offer_id = tbl_offers.offer_id
  LEFT JOIN tbl_review r ON p.id = r.product_id
  WHERE m.maincatname = 'Women Jewellery'
  GROUP BY p.id
");

$response['women'] = [];

while ($row = mysqli_fetch_assoc($womenResult)) {

    $productId = $row['id'];

    $cartResult = mysqli_query($conn, "
        SELECT id
        FROM tbl_cart
        WHERE product_id = $productId
          AND user_id = $user_id
        LIMIT 1
    ");

    if (mysqli_num_rows($cartResult) > 0) {
        $row['cartStatus'] = 1;
    } else {
        $row['cartStatus'] = 0;
    }

    $response['women'][] = $row;
}


echo json_encode($response);
exit;
