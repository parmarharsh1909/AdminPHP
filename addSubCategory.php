<?php

include 'connection.php';



header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$response = array();

$catName = $_POST["CatName"];
$catDesc = $_POST["CatDescription"];
$mainCatId = $_POST["MainCatId"];


$sql = "INSERT INTO tbl_subcategory (name, description, maincat_id)
VALUES ('$catName','$catDesc','$mainCatId')";



$result = mysqli_query($conn, $sql);


$response['status'] = "true";

echo json_encode($response);

$conn->close();
