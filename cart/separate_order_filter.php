<?php
// including the connection file
include('includes/connection.php');
echo '<pre>';
print_r($_POST);

if($_POST['order_id'] == '' && $_POST['active_status'] == '' && $_POST['customer_name'] == '') {
    echo "Please select values before submit";
    exit;
}
if($_POST['order_id'] != '') {
    if($_POST['order_id'] != '' && $_POST['active_status'] == '') {
        $sql = "SELECT * FROM orders where id = ". $_POST['order_id'];    
    } 
    
    if($_POST['order_id'] != '' && $_POST['active_status'] != '' && $_POST['customer_name'] == '') {
        $sql = "SELECT * FROM orders where id = ". $_POST['order_id'] ." AND active_status=". "'".$_POST['active_status']."'";    
    }
    
    if($_POST['order_id'] != '' && $_POST['active_status'] != '' && $_POST['customer_name'] != '') {
        $sql = "SELECT  orders.*, users.name FROM orders INNER JOIN users ON orders.user_id = users.id where orders.id = ". $_POST['order_id'] ." AND orders.active_status=". "'".$_POST['active_status']."' AND users.name=". "'".$_POST['customer_name']."'";
    }
    
    $result = mysqli_query($conn, $sql);
    
    while($row = mysqli_fetch_array($result)) {
        print_r($row);  
    }
}





?>



