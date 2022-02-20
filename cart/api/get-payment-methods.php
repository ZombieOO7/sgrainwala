<?php
include_once('../includes/variables.php');
include_once('../includes/crud.php');
include_once('../includes/custom-functions.php');
$db = new Database();
$db->connect();
date_default_timezone_set('Asia/Kolkata');
$accesskey = $_POST['accesskey'];
$response = array();
if(isset($accesskey)) {
    $access_key_received = isset($accesskey) && !empty($accesskey)?$accesskey:'';
    if($access_key_received == $access_key){
        $fn = new custom_functions();
        $data = $fn->get_settings('payment_methods',true);
        if(empty($data)){
            die('no payment method found.');
        }else{
            $payment_type = array();
            $response["error"]   = false;
			$response["message"] = "Data Return.";
			/*if($data['paypal_payment_method'] == '1' || $data['googlepay_payment_method'] == '1' || $data['payumoney_payment_method'] == '1' || $data['cod_payment_method'] == '1'){
			    $payment_mode = '1';
			}else{
			    $payment_mode = '0';
			}*/
			
			    $object_paypal = new stdClass();
                $object_paypal->payment_mode = $data['paypal_payment_method'];
                $object_paypal->payment_type = 'paypal';
                //$payment_list['payment_list'] = $object;
			
			
			    $object_googlepay = new stdClass();
                $object_googlepay->payment_mode = $data['googlepay_payment_method'];
                $object_googlepay->payment_type = 'googlepay';
			
			
			    $object_payumoney = new stdClass();
                $object_payumoney->payment_mode = $data['payumoney_payment_method'];
                $object_payumoney->payment_type = 'payumoney';
                
                
                $object_paytm = new stdClass();
                $object_paytm->payment_mode = $data['paytm_payment_method'];
                $object_paytm->payment_type = 'paytm';
                
			
			    $object_cod = new stdClass();
                $object_cod->payment_mode = $data['cod_payment_method'];
                $object_cod->payment_type = 'cod';
			
			$response['data']['payment_list'] = array(
                $object_paypal,$object_googlepay,$object_payumoney,$object_paytm,$object_cod
              );
			$output = json_encode($response);
        }
    }else{
		die('accesskey is incorrect.');
	}
}else {
	die('accesskey is required.');
}
//Output the output.
echo $output;
$db->disconnect();