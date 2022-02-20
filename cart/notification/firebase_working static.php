<?php 
include_once('includes/crud.php');

class Firebase {
    protected $db;
        function __construct(){
            $this->db = new Database();
            $this->db->connect();
            date_default_timezone_set('Asia/Kolkata');
            }

    public function send($registration_ids, $message) { 
        $fields = array(
            //'registration_ids' => 'e9VAT8j_TSqlL575injxzO:APA91bGViCex-5PEqnL3QdRlOcSRDmv-jfgvUbXc-45LwieKa3BLIajS4EPyQPvcpebJQILYiKkjglHfj8PbRpIDspS2bPOaL3O0_ObqoA1SJL5tvUHYNz5nZbyy0PVGqibvVL5aGYPu',
            'to' => 'AAAA2s7Ixbs:APA91bHudJhEXq1bDXJQlhypC4UrrXJjDb2mGcVu8YQhZO0itXaoo72Qq2tHIGrjzIhQF6g1zgjHJ2r9tNAqscetxIcosB5nvwwBtZU8SVSpZJq1jm5XQ2RVT5PXoFFCC9Gx6eLF1_BF',
            'data' => $message,
        );
        return $this->sendPushNotification($fields);
    }
    
    /*
    * This function will make the actuall curl request to firebase server
    * and then the message is sent 
    */
    private function sendPushNotification($fields) {  
        
        //firebase server url to send the curl request
        $url = 'https://fcm.googleapis.com/fcm/send';
        $sql="SELECT value FROM settings WHERE id=11";
        $this->db->sql($sql);
        $res=$this->db->getResult();
        //define("FIREBASE_API_KEY",$res[0]['value']);
        //building headers for the request
        $headers = array(
            //'Authorization: key=' . FIREBASE_API_KEY,
             'Authorization: key=' . "AAAA2s7Ixbs:APA91bHnMFoO_B6YgrZzeFRKQeljEOSyirSlJumjcoUpmLHES8tSLFJw80-YObHe_jj19y_AerkkT4FuMxiHufzyI_5B-UUNkDPKww09IdCKrz_m56y4XsH3fNdCsQigSQuOsN8iygnS",
             'Content-Type: application/json'
        );

        //Initializing curl to open a connection
        $ch = curl_init();
 
        //Setting the curl url
        curl_setopt($ch, CURLOPT_URL, $url);
        
        //setting the method as post
        curl_setopt($ch, CURLOPT_POST, true);

        //adding headers 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        //disabling ssl support
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        //adding the fields in json format 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        //finally executing the curl request 
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        } else { echo 'send successfully';}
 
        //Now close the connection
        curl_close($ch);
 
        //and return the result 
        return $result;
    }
}