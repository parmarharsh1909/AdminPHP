<?php
include 'connection.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');
$response = array();

$email_value        = $_POST["email"];
$password_value     = $_POST["password"];

$sql = "SELECT * FROM tbl_signup WHERE email='$email_value' AND password='$password_value'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if ($row) {
    // print_r($row);
    // die;


    $response['status'] = "true";
    $response['userId'] = $row['id'];
    $response['email'] = $row['email'];
    // $response['name'] = $row['name'];
} else {
    $response['status'] = "false";
}
echo json_encode($response);
$conn->close();
