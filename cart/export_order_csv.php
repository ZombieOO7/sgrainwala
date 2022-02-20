<?php
// including the connection file
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Customers.csv');

include('includes/connection.php');
include_once('includes/custom-functions.php');
$fn = new custom_functions;
include_once('includes/crud.php');
include_once('includes/variables.php');
$db = new Database();
$db->connect();
 
// set headers of csv format and force download
$exportData = $_POST['data'];
//print_r($exportData);exit;
if(count($exportData) > 0){
    $output = "Order ID,Customer Name,Product Variant Id,Unit,Product Name, QTY,Price\n";
    foreach ($exportData as $key=>$value){
        $sql="select oi.*,p.name as name, u.name as uname,v.measurement, (SELECT short_code FROM unit un where un.id=v.measurement_unit_id)as mesurement_unit_name,(SELECT status FROM orders o where o.id=oi.order_id)as order_status from `order_items` oi 
    			    join product_variant v on oi.product_variant_id=v.id 
    			    join products p on p.id=v.product_id 
    			    JOIN users u ON u.id=oi.user_id 
    			    where oi.order_id=".$value['Order ID'];
    	$db->sql($sql);
    	$res = $db->getResult();
    	foreach($res as $item){
    	    $output .= $item['order_id'].",".$item['uname'].",".$item['product_variant_id'].",".$item['measurement'].$item['mesurement_unit_name'].",".$item['name'].",".$item['quantity'].",".$item['quantity']*$item['discounted_price']."\n";   
    	}
    }
}
echo $output;
exit;
?>