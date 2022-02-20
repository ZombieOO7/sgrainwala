<?php
 $dbhost = 'localhost';
 $dbuser = 'barodqb5_cart';
 $dbpass = 'deepak@123';
 $dbname = 'barodqb5_cart';
 $conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);

 if(! $conn ) {
	die('Could not connect: ' . mysqli_error());
 }
?>