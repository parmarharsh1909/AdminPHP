<?php
include 'connection.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$response = array();

// GET or POST dono support
$user_id = $_GET['user_id'] ?? $_POST['user_id'] ?? '';
$email   = $_GET['email'] ?? $_POST['email'] ?? '';

if (!empty($user_id) || !empty($email)) {

    if (!empty($user_id)) {
        $stmt = $conn->prepare("SELECT id, name, email, phone, address FROM tbl_signup WHERE id = ?");
        $stmt->bind_param("i", $user_id);
    } else {
        $stmt = $conn->prepare("SELECT id, name, email, phone, address FROM tbl_signup WHERE email = ?");
        $stmt->bind_param("s", $email);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $response['status'] = true;
        $response['data'] = $row;
    } else {
        $response['status'] = false;
        $response['message'] = "User not found";
    }

    $stmt->close();

} else {
    $response['status'] = false;
    $response['message'] = "user_id or email required";
}

echo json_encode($response);
$conn->close();
?>