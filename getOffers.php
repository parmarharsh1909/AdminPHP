<?php
include 'connection.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');
$response = [];
$id = $_POST['id'];
$sql = "SELECT * FROM tbl_offers WHERE offer_id = '$id'";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);
if ($row) {
    $response['data'] = $row;
    $response['status'] = true;
} else {
    $response['status'] = false;
    $response['error'] = 'Order not found';
}
$conn->close();
echo json_encode($response);    