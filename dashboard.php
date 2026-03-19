<?php
include 'connection.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$response = array();


$result = mysqli_query($conn, "SELECT * FROM tbl_maincategory");
$response['totalMainCategories'] = $result->num_rows;

$result = mysqli_query($conn, "SELECT * FROM tbl_subcategory");
$response['totalSubCategories'] = $result->num_rows;

$result = mysqli_query($conn, "SELECT * FROM tbl_products");
$response['totalProducts'] = $result->num_rows;

$result = mysqli_query($conn, "SELECT * FROM tbl_signup");
$response['totalUsers'] = $result->num_rows;

$result = mysqli_query($conn, "SELECT * FROM tbl_orders");
$response['totalOrders'] = $result->num_rows;

$result = mysqli_query($conn, "SELECT * FROM tbl_offers");
$response['totalOffers'] = $result->num_rows;

$result = mysqli_query($conn, "SELECT * FROM tbl_inquiries");
$response['totalInquiries'] = $result->num_rows;

$result = mysqli_query($conn, "SELECT * FROM tbl_purchase");
$response['totalPurchases'] = $result->num_rows;

echo json_encode($response);
$conn->close();
?>
