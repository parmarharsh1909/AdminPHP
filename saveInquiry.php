<?php
include 'connection.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Get data
$data = json_decode(file_get_contents("php://input"), true);

$username = $data['username'] ?? '';
$email = $data['email'] ?? '';
$mobile = $data['mobile'] ?? '';
$product_name = $data['product_name'] ?? '';
$message = $data['message'] ?? '';

if ($username == '' || $email == '' || $message == '') {
    echo json_encode(["status" => false, "message" => "Missing fields"]);
    exit;
}

// ✅ Save in DB
$stmt = $conn->prepare("INSERT INTO tbl_inquiries (username,email,mobile,product_name,message) VALUES (?,?,?,?,?)");
$stmt->bind_param("sssss", $username, $email, $mobile, $product_name, $message);
$stmt->execute();

// ✅ Send Email
$mail = new PHPMailer(true);

try {
    // SMTP config
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'yourgmail@gmail.com';
    $mail->Password   = 'your_app_password'; // Gmail app password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // From & To
    $mail->setFrom('yourgmail@gmail.com', 'HP Jewels');
    $mail->addAddress('yourgmail@gmail.com'); // YOU (admin)

    // Email content (admin)
    $mail->isHTML(true);
    $mail->Subject = "New Inquiry from $username";
    $mail->Body = "
        <h3>New Inquiry Received</h3>
        <p><b>Name:</b> $username</p>
        <p><b>Email:</b> $email</p>
        <p><b>Mobile:</b> $mobile</p>
        <p><b>Product:</b> $product_name</p>
        <p><b>Message:</b> $message</p>
    ";

    $mail->send();

    // ✅ Auto-reply to user
    $mail->clearAddresses();
    $mail->addAddress($email);

    $mail->Subject = "We received your inquiry";
    $mail->Body = "
        <h3>Thank you, $username!</h3>
        <p>We have received your inquiry regarding <b>$product_name</b>.</p>
        <p>Our team will contact you soon.</p>
        <br>
        <p>— HP Jewels</p>
    ";

    $mail->send();

    echo json_encode([
        "status" => true,
        "message" => "Inquiry sent & email delivered"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => true,
        "message" => "Saved, but email failed"
    ]);
}
?>