<?php
include 'connection.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$response = array();

$sql = "SELECT p.product_name, p.description, p.price, p.purity, p.image, s.name AS subcategory_name, m.maincatname AS maincategory_name FROM tbl_products p JOIN tbl_subcategory s ON p.sub_catid = s.id JOIN tbl_maincategory m ON s.maincat_id = m.id WHERE m.maincatname = 'Women Jewellery'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $response['status'] = "true";
    while ($row = mysqli_fetch_assoc($result)) {
        $response['data'][] = $row;
    }
} else {
    $response['status'] = "false";
    $response['data'] = [];
}

echo json_encode($response);

$conn->close();
