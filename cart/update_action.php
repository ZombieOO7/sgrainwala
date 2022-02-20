<?php
include_once('includes/crud.php');
include_once('includes/functions.php');

$db = new Database();
$db->connect();
if(isset($_POST['action']) && $_POST['action'] != ''){
    $sql = "UPDATE `orders` SET active_status='" . $_POST['action'] . "' WHERE id=". $_POST['id'];
    // echo $sql;
	echo $db->sql($sql);  
}
exit;
//print_r($_POST);exit;