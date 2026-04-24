<?php
include 'connection.php';
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// query
$sql = "SELECT * FROM tbl_purchase ORDER BY purchase_id DESC";
$result = mysqli_query($conn, $sql);

$data = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    echo json_encode([
        "status" => true,
        "data" => $data
    ]);
} else {
    echo json_encode([
        "status" => false,
        "message" => "Query failed"
    ]);
}
?>