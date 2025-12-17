<?php
include 'connection.php';


header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$response = array();

$result = mysqli_query($conn, query: "SELECT s.id,s.name,s.description,s.maincat_id,m.maincatname as categories_id FROM tbl_subcategory s LEFT JOIN tbl_maincategory m ON s.maincat_id = m.id;");

while ($row = mysqli_fetch_assoc(result: $result)) {
    $rresponse['status'] = "true";
    $response['data'][] = $row;
}

echo json_encode(value: $response);

$conn->close();
