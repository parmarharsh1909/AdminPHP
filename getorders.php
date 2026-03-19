<?php
include 'connection.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');
$response = [];

$sql = "SELECT * FROM tbl_orders order by id desc";
$result = mysqli_query($conn, $sql);
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}
$response['data'] = $data;
$response['status'] = true;
echo json_encode($response);
$conn->close();
