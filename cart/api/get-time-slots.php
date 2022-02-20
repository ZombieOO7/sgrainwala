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
        $data = $fn->get_settings('time_slots',true);
        if(empty($data)){
            die('no payment method found.');
        }else{
            $response["error"]   = false;
			$response["message"] = "Data Return.";
			/*if($data['paypal_payment_method'] == '1' || $data['googlepay_payment_method'] == '1' || $data['payumoney_payment_method'] == '1' || $data['cod_payment_method'] == '1'){
			    $payment_mode = '1';
			}else{
			    $payment_mode = '0';
			}*/
			
			    $object_9to1 = new stdClass();
                $object_9to1->timeslot_mode = $data['ninetoone_slot'];
                $object_9to1->timeslot_type = '9AM to 1PM';
                //$payment_list['payment_list'] = $object;
			
			
			    $object_5to8 = new stdClass();
                $object_5to8->timeslot_mode = $data['fivetoeight_slot'];
                $object_5to8->timeslot_type = '5PM to 8PM';
			
			
			    $object_10to7 = new stdClass();
                $object_10to7->timeslot_mode = $data['tentoseven_slot'];
                $object_10to7->timeslot_type = '10AM to 7PM';
			
			$response['data']['time_slots'] = array(
                $object_9to1,$object_5to8,$object_10to7
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