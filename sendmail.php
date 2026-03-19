<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$response = array();

$email = $_POST['email'] ?? '';
$type  = $_POST['type'] ?? ''; // register | login | order

try {

  $mail = new PHPMailer(true);

  // Server settings
  $mail->isSMTP();
  $mail->Host       = 'smtp.gmail.com';
  $mail->SMTPAuth   = true;
  $mail->Username   = 'd23amtics066@gmail.com';
  $mail->Password   = 'xunyulwxtfimljmz';
  $mail->SMTPSecure = 'tls';
  $mail->Port       = 587;

  // Recipients
  $mail->setFrom('d23amtics066@gmail.com', 'HP Jewelles');
  $mail->addAddress($email);

  $mail->isHTML(true);

  /* =========================
        1️⃣ REGISTER MAIL
     ========================= */
  if ($type == "register") {

    $mail->Subject = 'Welcome to HP Jewelles ✨';

    $mail->Body = "
    <div style='font-family: Arial, sans-serif; background:#f9f6f2; padding:20px;'>
      <div style='max-width:600px; margin:auto; background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.1);'>
        
        <div style='background:#b08d57; color:#fff; padding:20px; text-align:center;'>
          <h1 style='margin:0;'>Welcome to HP Jewelles ✨</h1>
        </div>
        
        <div style='padding:20px; color:#333;'>
          <p style='font-size:16px;'>Hello,</p>
          
          <p>
            Thank you for registering with us 💍  
            We’re excited to have you in our jewellery family.
          </p>
          
          <p>
            Start exploring our premium collection now!
          </p>

          <p style='margin-top:30px;'>
            Regards,<br/>
            <b>HP Jewelles Team</b>
          </p>
        </div>

        <div style='background:#f1f1f1; text-align:center; padding:10px; font-size:12px; color:#777;'>
          © " . date("Y") . " HP Jewelles. All rights reserved.
        </div>

      </div>
    </div>";
  }

  /* =========================
        2️⃣ LOGIN MAIL
     ========================= */
  elseif ($type == "login") {

    $mail->Subject = 'Login Alert - HP Jewelles';

    $mail->Body = "
    <div style='font-family: Arial, sans-serif; background:#f9f6f2; padding:20px;'>
      <div style='max-width:600px; margin:auto; background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.1);'>
        
        <div style='background:#222; color:#fff; padding:20px; text-align:center;'>
          <h2 style='margin:0;'>Login Notification 🔐</h2>
        </div>
        
        <div style='padding:20px; color:#333;'>
          <p>Hello,</p>
          
          <p>
            You have successfully logged into your HP Jewelles account.
          </p>
          
          <p>
            If this was not you, please reset your password immediately.
          </p>

          <p style='margin-top:30px;'>
            Stay Secure,<br/>
            <b>HP Jewelles Team</b>
          </p>
        </div>

        <div style='background:#f1f1f1; text-align:center; padding:10px; font-size:12px; color:#777;'>
          © " . date("Y") . " HP Jewelles. All rights reserved.
        </div>

      </div>
    </div>";
  }

  /* =========================
        3️⃣ ORDER MAIL
     ========================= */
  elseif ($type == "order") {

    $mail->Subject = 'Order Confirmation - HP Jewelles 🛍️';

    $mail->Body = "
    <div style='font-family: Arial, sans-serif; background:#f9f6f2; padding:20px;'>
      <div style='max-width:600px; margin:auto; background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.1);'>
        
        <div style='background:#28a745; color:#fff; padding:20px; text-align:center;'>
          <h2 style='margin:0;'>Order Confirmed 🎉</h2>
        </div>
        
        <div style='padding:20px; color:#333;'>
          <p>Hello,</p>
          
          <p>
            Your order has been successfully placed and payment received.
          </p>
          
          <p>
            Thank you for shopping with HP Jewelles 💎  
            We will notify you once your order is shipped.
          </p>

          <p style='margin-top:30px;'>
            Happy Shopping,<br/>
            <b>HP Jewelles Team</b>
          </p>
        </div>

        <div style='background:#f1f1f1; text-align:center; padding:10px; font-size:12px; color:#777;'>
          © " . date("Y") . " HP Jewelles. All rights reserved.
        </div>

      </div>
    </div>";
  }

  else {
    throw new Exception("Invalid mail type");
  }

  $mail->send();

  $response["Status"] = "Success";
  $response["MailStatus"] = "Mail sent successfully.";

} catch (Exception $e) {

  $response["Status"] = "Fail";
  $response["MailStatus"] = "Failed to send email. Error: {$mail->ErrorInfo}";
}

echo json_encode($response);
?>