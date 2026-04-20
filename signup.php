<?php
include 'connection.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');
$response = array();


$name_value = $_POST["name"];

$email_value = $_POST["email"];

$password_value = $_POST["password"];

$phone_value = $_POST["phone"];

$address_value = $_POST["address"];

// $role_value=$_POST["role"];

$sql = "INSERT INTO tbl_signup (name, email , password,phone,address) VALUES ('$name_value', '$email_value'   , '$password_value', '$phone_value', '$address_value')";


// echo $sql;die;
$result = mysqli_query($conn, $sql);
if ($result) {
    $response['status'] = "true";
}
echo json_encode($response);
$conn->close();
