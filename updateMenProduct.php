<?php
include 'connection.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');
$response = array();
$id          = $_POST["id"];
$product_name  = $_POST["product_name"];
$sub_catid       = $_POST["sub_catid"];
$description        = $_POST["description"];
$price        = $_POST["price"];
$purity        = $_POST["purity"];

$exe = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

$filename = time() . random_int(1000, 9999) . '.' . $exe;
move_uploaded_file($_FILES['image']['tmp_name'], './Uploads/Mens/' . $filename);

$sql = "update tbl_products set
    product_name = '$product_name',sub_catid='$sub_catid',description='$description',price='$price',purity='$purity',image='$filename'
      where id = '$id'";
$result = mysqli_query($conn, $sql);
if ($result) {
    $response["status"] = "true";

    $response["message"] = "Product Updated Successfully";
} else {
    $response["status"] = "false";
    $response["message"] = "Error";
}
echo json_encode($response);
$conn->close();
