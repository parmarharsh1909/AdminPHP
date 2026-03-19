<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// require('vendor/autoload.php');

require_once "razorpay-php/Razorpay.php";

use Razorpay\Api\Api;

$amount=isset($_GET['amount']) ? (int)$_GET['amount'] : 0;

$keyId = "rzp_test_aro7DmNCYha043";
$keySecret = "WbMUfLsVEcKVp7IF1nJpNU3a";

$api = new Api($keyId, $keySecret);

$orderData = [
    'receipt'         => 'rcptid_11',
    'amount'          => $amount*100, // 500 rs in paise
    'currency'        => 'INR'
];

$order = $api->order->create($orderData);

echo json_encode($order->toArray());
