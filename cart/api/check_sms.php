<?php
// Account details
$apiKey = urlencode('S4Rtb9gIX4E-GaMSbF1r8BfpVVWfgvQ7xkcouFfI5K');
// Message details
$numbers = array('919099242819');
$sender = urlencode('TXTLCL');
$message = rawurlencode('Your OTP is');
 
$numbers = implode(',', $numbers);
 
// Prepare data for POST request
$data = array('apikey' => $apiKey, 'numbers' => $numbers, 'sender' => $sender, 'message' => $message);
// Send the POST request with cURL
$ch = curl_init('https://api.textlocal.in/send/');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
// Process your response here
echo $response;
?>