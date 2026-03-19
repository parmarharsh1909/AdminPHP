<?php
include 'connection.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$response = array();
$response['status'] = false;

// Get POST values safely
$promocode        = $_POST['promocode'] ?? '';
$offername        = $_POST['offername'] ?? '';
$discount_value   = $_POST['discount_value'] ?? '';
$offerdescription = $_POST['offerdescription'] ?? '';
$validity         = $_POST['validity'] ?? '';
$status           = $_POST['status'] ?? 'Active';

// INSERT (without offer_id)
$sql = "INSERT INTO tbl_offers 
(promocode, offername, discount_value, offerdescription, validity, status)
VALUES 
('$promocode', '$offername', '$discount_value', '$offerdescription', '$validity', '$status')";

$result = mysqli_query($conn, $sql);

if ($result) {
    $response['status'] = true;
} else {
    $response['error'] = mysqli_error($conn);
}

echo json_encode($response);

$conn->close();
?>