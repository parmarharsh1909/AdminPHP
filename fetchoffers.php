<?php
include 'connection.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');
$response = array();

$result = mysqli_query($conn, "SELECT * FROM tbl_offers");
if (mysqli_num_rows($result) > 0) {
    $response['status'] = "true";
    $response['message'] = 'Offers Found';
    $response['data'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $response['status'] = "false";
    $response['message'] = 'Offers Not Found';
    $response['data'] = null;
}
echo json_encode($response);
$conn->close();

