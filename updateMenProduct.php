<?php
include 'connection.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$response = array();

$id = $_POST["id"];
$product_name = $_POST["product_name"];
$sub_catid = $_POST["sub_catid"];
$description = $_POST["description"];
$price = $_POST["price"];
$purity = $_POST["purity"];
$offer_id = $_POST["offer_id"];

if ($offer_id === "") {
    $offer_id = "NULL";
}

if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {

    $exe = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $filename = time() . random_int(1000, 9999) . '.' . $exe;

    move_uploaded_file($_FILES['image']['tmp_name'], './Uploads/Mens/' . $filename);
} else {

    $sql_img = "SELECT image FROM tbl_products WHERE id='$id'";
    $res = mysqli_query($conn, $sql_img);
    $row = mysqli_fetch_assoc($res);
    $filename = $row['image'];
}

$sql = "UPDATE tbl_products SET
product_name='$product_name',
sub_catid='$sub_catid',
description='$description',
price='$price',
purity='$purity',
offer_id=$offer_id,
image='$filename'
WHERE id='$id'";

$result = mysqli_query($conn, $sql);

if ($result) {

    $response["status"] = true;
    $response["message"] = "Product Updated Successfully";
} else {

    $response["status"] = false;
    $response["message"] = mysqli_error($conn);
}

echo json_encode($response);
$conn->close();
