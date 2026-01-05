<?php
include 'connection.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$response = array();

$id          = $_POST['id'] ?? '';
$name        = $_POST['name'] ?? '';
$description = $_POST['description'] ?? '';
$mainCatId   = $_POST['maincat_id'] ?? '';

if ($id == '' || $name == '' || $mainCatId == '') {
    echo json_encode([
        "status" => "false",
        "message" => "Required fields missing"
    ]);
    exit;
}

$sql = "UPDATE tbl_subcategory 
        SET name='$name',
            Description='$description',
            maincat_id='$mainCatId'
        WHERE id='$id'"; 

$result = mysqli_query($conn, $sql);

if ($result) {
    $response["status"] = "true";
    $response["message"] = "SubCategory Updated Successfully";
} else {
    $response["status"] = "false";
    $response["message"] = mysqli_error($conn);
}

echo json_encode($response);
$conn->close();
