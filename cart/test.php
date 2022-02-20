<?php 
ini_set('display_errors', 1);
//importing required files


$url = 'https://fcm.googleapis.com/fcm/send';
$fields = array (
        'to' => 'e9VAT8j_TSqlL575injxzO:APA91bGViCex-5PEqnL3QdRlOcSRDmv-jfgvUbXc-45LwieKa3BLIajS4EPyQPvcpebJQILYiKkjglHfj8PbRpIDspS2bPOaL3O0_ObqoA1SJL5tvUHYNz5nZbyy0PVGqibvVL5aGYPu',
        'notification' => array (
                "body" => 'test',
                "title" => "Title",
                "icon" => "myicon"
        )
);
$fields = json_encode ( $fields );
$headers = array (
        'Authorization: key=' . "AAAA2s7Ixbs:APA91bHnMFoO_B6YgrZzeFRKQeljEOSyirSlJumjcoUpmLHES8tSLFJw80-YObHe_jj19y_AerkkT4FuMxiHufzyI_5B-UUNkDPKww09IdCKrz_m56y4XsH3fNdCsQigSQuOsN8iygnS",
        'Content-Type: application/json'
);

$ch = curl_init ();
curl_setopt ( $ch, CURLOPT_URL, $url );
curl_setopt ( $ch, CURLOPT_POST, true );
curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

$result = curl_exec ( $ch ); print_r($result);
 
  if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        } else { echo'send';}
 
        //Now close the connection
        curl_close($ch);
 
?>
