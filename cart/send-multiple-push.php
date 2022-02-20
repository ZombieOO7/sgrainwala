<?php 
ini_set('display_errors', 1);
//importing required files
require_once 'includes/crud.php';
$db_con=new Database();
$db_con->connect();
require_once 'includes/functions.php';
require_once 'notification/firebase.php';
require_once 'notification/push.php'; 

$fn = new functions;

$response = array(); 

if($_SERVER['REQUEST_METHOD']=='POST'){	
	//hecking the required params 
	if(isset($_POST['title']) and isset($_POST['message'])) {
		//creating a new push
		$title = $db_con->escapeString($_POST['title']);
		$message = $db_con->escapeString($_POST['message']);
		$type = $db_con->escapeString($_POST['type']);
		$id = ($type != 'default')?$_POST[$type]:"0";
		/*dynamically getting the domain of the app*/
		$url  = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
		$url .= $_SERVER['SERVER_NAME'];
		$url .= $_SERVER['REQUEST_URI'];
		$server_url = dirname($url).'/';
		
		$push = null;
		$include_image = (isset($_POST['include_image']) && $_POST['include_image'] == 'on') ? TRUE : FALSE;
		if($include_image){
			// common image file extensions
			$allowedExts = array("gif", "jpeg", "jpg", "png");
			$extension = explode(".", $_FILES["image"]["name"]);
			$extension = end($extension);
			if(!(in_array($extension, $allowedExts))){
				$response['error']=true;
				$response['message']='Image type is invalid';
				echo json_encode($response);
				return false;
			}
			$target_path = 'upload/notifications/';
			$filename = microtime(true).'.'. strtolower($extension);
			$full_path = $target_path."".$filename;
			if(!move_uploaded_file($_FILES["image"]["tmp_name"], $full_path)){
				$response['error']=true;
				$response['message']='Image type is invalid';
				echo json_encode($response);
				return false;
			}
			$sql = "INSERT INTO `notifications`(`title`, `message`,  `type`, `type_id`, `image`) VALUES 
			('".$title."','".$message."','".$type."','".$id."','".$full_path."')";
		}else{
			$sql = "INSERT INTO `notifications`(`title`, `message`, `type`, `type_id`) VALUES 
			('".$title."','".$message."','".$type."','".$id."')";
		}
		$db_con->sql($sql);
		$db_con->getResult();
		//first check if the push has an image with it
		if($include_image){
			$push = new Push(
				$_POST['title'],
				$_POST['message'],
				$server_url.''.$full_path,
				$type,
				$id
			);
		}else{
			//if the push don't have an image give null in place of image
			$push = new Push(
				$_POST['title'],
				$_POST['message'],
				null,
				$type,
				$id
			);
		}

		//getting the push from push object
		$mPushNotification = $push->getPush();
		
		//getting the token from database object 
		$devicetoken = $fn->getAllTokens();
		
		//creating firebase class object 
		$firebase = new Firebase(); 

		//sending push notification and displaying result 
		$nwqq=array_chunk($devicetoken,1000);
		
		$response['error']=false;
		
		foreach($nwqq as $vluuu){
		$response['message']=$firebase->send($vluuu, $mPushNotification);
		}
 		$response['message']="Successfully Send";
		
	}else{
		$response['error']=true;
		$response['message']='Parameters missing';
	}
}else{
	$response['error']=true;
	$response['message']='Invalid request';
}
// echo str_replace("\\/","/",json_encode($response['message']));
echo(json_encode($response));

?>
