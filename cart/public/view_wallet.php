<?php 
    
session_start();
    
    // set time for session timeout
    $currentTime = time() + 25200;
    $expired = 3600;
    
    // if session not set go to login page
    if(!isset($_SESSION['user'])){
        header("location:index.php");
    }
    
    // if current time is more than session timeout back to login page
    if($currentTime > $_SESSION['timeout']){
        session_destroy();
        header("location:index.php");
    }
    
    // destroy previous session timeout and create new one
    unset($_SESSION['timeout']);
    $_SESSION['timeout'] = $currentTime + $expired;
    include 'header.php';?>
<head>
<title>Wallet | <?=$settings['app_name']?> - Dashboard</title>
</head>
<?php
   
	
    if(isset($_GET['id'])){
    	$ID = $_GET['id'];
    }else{
    	$ID = "";
    }
    // get image file from table
    
    