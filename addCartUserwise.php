<?php
include 'connection.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$product_id = $_POST['product_id'] ?? 0;
$user_id    = $_POST['user_id'] ?? 0;

if ($product_id == 0 || $user_id == 0) {
    echo json_encode([
        "status" => "false",
        "message" => "Invalid data"
    ]);
    exit;
}

$check = "SELECT * FROM tbl_cart 
          WHERE user_id = '$user_id' 
          AND product_id = '$product_id'";

$result = mysqli_query($conn, $check);
$cartCount = mysqli_num_rows($result);


if ($cartCount > 0) {

    $update = "UPDATE tbl_cart 
               SET quantity = quantity + 1
               WHERE user_id = '$user_id'
               AND product_id = '$product_id'";

    if (mysqli_query($conn, $update)) {
        echo json_encode([
            "status" => "true",
            "message" => "Quantity updated"
        ]);
    } else {
        echo json_encode([
            "status" => "false",
            "message" => mysqli_error($conn)
        ]);
    }

    exit;
}



$sql = "INSERT INTO tbl_cart (user_id, product_id, quantity)
        VALUES ('$user_id', '$product_id', 1)";

if (mysqli_query($conn, $sql)) {
    echo json_encode([
        "status" => "true",
        "message" => "Product added to cart"
    ]);
} else {
    echo json_encode([
        "status" => "false",
        "message" => mysqli_error($conn)
    ]);
}

$conn->close();
