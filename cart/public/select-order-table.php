<?php

$root = $_SERVER["DOCUMENT_ROOT"];
//print_r($_POST);exit;
    include($root.'/cart/includes/connection.php');
include_once($root.'/cart/includes/custom-functions.php');
$fn = new custom_functions;
include_once($root.'/cart/includes/crud.php');
include_once($root.'/cart/includes/variables.php');
include_once($root.'/cart/includes/functions.php');
$db = new Database();
$db->connect();
 //include_once('includes/functions.php');
    ?>
<section class="content-header">
    <h1>Selected  Order</h1>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
    <hr/>
</section>
<style>
.uppercase {
  text-transform: uppercase;
}
</style>
<style>
.btnx {
  background-color: DodgerBlue;
  border: none;
  color: white;
  padding: 4px 18px;
  cursor: pointer;margin-bottom:10px;
  font-size: 18px;float:right;
}
.btnx:hover{color: white;}

/* Darker background on mouse-over */
 
</style>
<?php

$exportData = $_POST['data'];
if(count($exportData) > 0){
    
   
     foreach ($exportData as $key=>$value){
        $sql="select oi.*,p.name as name, u.name as uname,v.measurement, (SELECT short_code FROM unit un where un.id=v.measurement_unit_id)as mesurement_unit_name,(SELECT status FROM orders o where o.id=oi.order_id)as order_status from `order_items` oi 
    			    join product_variant v on oi.product_variant_id=v.id 
    			    join products p on p.id=v.product_id 
    			    JOIN users u ON u.id=oi.user_id 
    			    where oi.order_id=".$value['Order ID'];
    			
    	$db->sql($sql);
    	$res = $db->getResult();
    //	print_r($res);exit;
    	    ?>
    	    
    	    
    	    <div class="row">
            <!-- Left col -->
				<div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Selected Order</h3>
                
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                  <table class="table table-hover">
                    <tr>
						<th>Order ID</th>
						<th>Customer Name</th>
						<th>Product Variant Id</th>
						<th>Unit</th>
						<th>Product Name</th>
						<th>QTY</th>
						<th>Price</th>
                    </tr>
					<?php
					$count=1;
					
					foreach($res as $item){
					    ?>
                    <tr>
						<td><?=$count;?></td>
                      <td><?php echo $item['order_id'];?></td>
                      <td><?php echo $item['uname']; ?></td>
                      <td><?php echo $item['product_variant_id']; ?></td>
                      <td><?php echo $item['measurement']; ?></td>
                      <td><?php echo $item['mesurement_unit_name']; ?></td>
                      <td><?php echo $item['name']; ?></td>
                      <td><?php echo $item['quantity']; ?></td>
                      <td><?php echo $item['quantity']*$item['price']; ?></td>
                      
                    </tr>
					<?php $count++; }   ?>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
    	    
    	    
    	    
    	    
    	    
    	    
   <?php  	    
    	    
   } 	
}
?>