<?php
include 'connection.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$response = array();

// Check if specific user requested
if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {

    $user_id = $_POST['user_id'];

    $sql = "SELECT id, name, email, phone, address 
            FROM tbl_signup 
            WHERE id = '$user_id'";

    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        $response['status'] = true;
        $response['data'] = $row;
    } else {
        $response['status'] = false;
        $response['message'] = "User not found";
    }

} else {

    // Fetch all users
    $sql = "SELECT id, name, email, phone, address ,password FROM tbl_signup";
    $result = mysqli_query($conn, $sql);

    $response['status'] = true;
    $response['data'] = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $response['data'][] = $row;
    }
}

echo json_encode($response);

$conn->close();
?>
