<?php function sendSms($mobile, $message)
{
    
    //Your message to send, Add URL encoding here.
    // $message = urlencode("Your OTP for Om Fruits & Veg is : $otp. Please enter the same to complete verification.");
    // $message = strip_tags($message);
    /*$message = urlencode($message);
    
	//Prepare post parameters
    $postData = array(
        'authkey' => '3f68f1411ee572c3a726f833cd2c8437',
        'sender' => 'APNDKN'
    );
    //API URL
    $url = "http://msg.icloudsms.com/rest/services/sendSMS/sendGroupSms?";
    $url .= "AUTH_KEY=".$postData['authkey']."&message=".$message."&senderId=".$postData['sender']."&routeId=1&mobileNos=".$mobile."&smsContentType=english";
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$output = curl_exec($ch); 
    if (curl_errno($ch)) {
        echo 'error:' . curl_error($ch);
    }
	curl_close($ch);*/
	
	/*require __DIR__ . '/twilio-php-4.11.0/Services/Twilio.php';
	$sid = 'AC6353e05b0357204a831001bbda9f4e6a';
    $token = 'fa52de8a4104bf38ee45069dce8fda7d';
    $client = new Services_Twilio($sid, $token);
    $message = $client->account->messages->sendMessage(
      '+17606663949', // From a valid Twilio number
      '+91'.$mobile, // Text this number
      $message
    );*/
    $apiKey = urlencode('S4Rtb9gIX4E-GaMSbF1r8BfpVVWfgvQ7xkcouFfI5K');
    $numbers = array('91'.$mobile);
    $sender = urlencode('TXTLCL');
     
    $numbers = implode(',', $numbers);
    
    $data = array('apikey' => $apiKey, 'numbers' => $numbers, 'sender' => $sender, 'message' => $message);
    $ch = curl_init('https://api.textlocal.in/send/');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    echo $response;
}
?>