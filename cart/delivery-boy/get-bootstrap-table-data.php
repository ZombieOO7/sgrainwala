<?php
	session_start();
    
    // set time for session timeout
    $currentTime = time() + 25200;
    $expired = 3600;
    
    // if session not set go to login page
    if(!isset($_SESSION['id']) && !isset($_SESSION['name'])){
    	header("location:index.php");
    }else{
		$id = $_SESSION['id'];	
    }
    
    // if current time is more than session timeout back to login page
    if ($currentTime > $_SESSION['timeout']) {
        session_destroy();
        header("location:index.php");
    }
    
    // destroy previous session timeout and create new one
    unset($_SESSION['timeout']);
    $_SESSION['timeout'] = $currentTime + $expired;
    
	header("Content-Type: application/json");
    header("Expires: 0");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
	
	
	include_once('../includes/custom-functions.php');
	$fn = new custom_functions;
	include_once('../includes/crud.php');
	include_once('../includes/variables.php');
	$db = new Database();
	$db->connect();
	$config = $fn->get_configurations();
		if(isset($config['system_timezone']) && isset($config['system_timezone_gmt'])){
			date_default_timezone_set($config['system_timezone']);
			$db->sql("SET `time_zone` = '".$config['system_timezone_gmt']."'");
		}else{
	date_default_timezone_set('Asia/Kolkata');
	$db->sql("SET `time_zone` = '+05:30'");
}
	
	//data of 'ORDERS' table goes here
	if(isset($_GET['table']) && $_GET['table'] == 'orders'){
		$offset = 0; $limit = 10;
		$sort = 'o.id'; $order = 'DESC';
		$where = '';
		if(!empty($_GET['start_date']) && !empty($_GET['end_date'])){
			$where .= " where DATE(date_added)>=DATE('".$_GET['start_date']."') AND DATE(date_added)<=DATE('".$_GET['end_date']."')";
		}
		if(isset($_GET['sort']))
			$sort = $_GET['sort'];
		if(isset($_GET['offset']))
			$offset = $_GET['offset'];
		if(isset($_GET['limit']))
			$limit = $_GET['limit'];
		if(isset($_GET['order']))
			$order = $_GET['order'];
		if(isset($_GET['search']) && !empty($_GET['search'])){
			$search = $_GET['search'];
			if(!empty($_GET['start_date']) && !empty($_GET['end_date'])){
				$where .= " AND (name like '%".$search."%' OR o.id like '%".$search."%' OR o.mobile like '%".$search."%' OR address like '%".$search."%' OR `payment_method` like '%".$search."%' OR `delivery_charge` like '%".$search."%' OR `delivery_time` like '%".$search."%' OR o.`status` like '%".$search."%' OR `date_added` like '%".$search."%')";
			} else{
				$where .= " where (name like '%".$search."%' OR o.id like '%".$search."%' OR o.mobile like '%".$search."%' OR address like '%".$search."%' OR `payment_method` like '%".$search."%' OR `delivery_charge` like '%".$search."%' OR `delivery_time` like '%".$search."%' OR o.`status` like '%".$search."%' OR `date_added` like '%".$search."%')";
			}
		}

        if(isset($_GET['filter_order']) && $_GET['filter_order']!=''){
            $filter_order=$db->escapeString($_GET['filter_order']);
            if(isset($_GET['search']) && $_GET['search']!='' ){
                $where .=" and `active_status`='".$filter_order."'";
            }elseif(isset($_GET['start_date']) && $_GET['start_date']!=''){
                 $where .=" and `active_status`='".$filter_order."'";
            }else{
                  $where .=" where `active_status`='".$filter_order."'";
            }
            
  
        }
		if(empty($where)){
			$where .= " WHERE delivery_boy_id = ".$id;
		}else{
			$where .= " AND delivery_boy_id = ".$id;
		}
		$sql = "SELECT COUNT(*) as total FROM `orders` o JOIN users u ON u.id=o.user_id".$where;
// 		echo $sql;
		$db->sql($sql);
		$res = $db->getResult();
		foreach($res as $row){
			$total = $row['total'];
		}
		$sql="select o.*,u.name FROM orders o JOIN users u ON u.id=o.user_id".$where." ORDER BY ".$sort." ".$order." LIMIT ".$offset.", ".$limit;
// 		echo $sql;
		$db->sql($sql);
		$res = $db->getResult();
		// print_r($res);
		$i=0;
		foreach ($res as $row) {
				$sql="select *,u.name as uname,(SELECT short_code FROM unit un where un.id=v.measurement_unit_id)as mesurement_unit_name,(SELECT status FROM orders o where o.id=oi.order_id)as order_status from order_items oi join product_variant v on oi.product_variant_id=v.id join products p on p.id=v.product_id JOIN users u ON u.id=oi.user_id where oi.order_id=".$row['id'];
		$db->sql($sql);
		$res[$i]['items']=$db->getResult();
		// print_r($res[$i]['items'][0]['price']);
		$i++;
	}
		$bulkData = array();
		$bulkData['total'] = $total;
		$rows = array();
		$tempRow = array();
		// print_r($res);
		foreach($res as $row){
			$items = $row['items'];
			// print_r($items);
			$items1='';
			$temp = '';
			$total_amt=0;
			foreach($items as $item){
				$temp .= "<b>ID :</b>".$item['id']."<b> Product Variant Id :</b> ".$item['product_variant_id']."<b> Name : </b>".$item['name']." <b>Unit : </b>".$item['measurement'].$item['mesurement_unit_name']." <b>Price : </b>".$item['price']." <b>QTY : </b>".$item['quantity']." <b>Subtotal : </b>".$item['quantity']*$item['price']."<br>------<br>";
				$total_amt+=$item['discounted_price']*$item['quantity'];
			}
			// print_r($total_amt);
			// print_r($item);
			// print_r($items1);

			$items1 = $temp;
			$temp = '<br>';
			$status=json_decode($row['items'][0]['order_status']);
			foreach($status as $st){
				$temp .= "<b>".ucwords($st[0])."</b> : ".date('h:iA d-m-Y',strtotime($st[1]))."<br>------<br>";
			}
			// print_r($res[0]['items']);
			$total=$total_amt+$row['delivery_charge'];
			$discounted_amount=$total*$row['items'][0]['discount']/100;
			$status = $temp;
			$operate = "<a class='btn btn-sm btn-primary edit-fees' data-id='".$row['id']."' data-toggle='modal' data-target='#editFeesModal'>Edit</a>";
			
			$operate .= "<a onclick='return conf(\"delete\");' class='btn btn-sm btn-danger' href='../public/db_operations.php?id=".$row['id']."&delete_order=1' target='_blank'>Delete</a>";
			$tempRow['id'] = $row['id'];
			$tempRow['user_id'] = $row['user_id'];
			$tempRow['name'] = $row['items'][0]['uname'];
			$tempRow['mobile'] = $row['mobile'];
			$tempRow['delivery_charge'] = $row['delivery_charge'];
			$tempRow['items']=$items1;
			$tempRow['total']=$total_amt;
			$tempRow['discount'] = $row['items'][0]['discount'];
			$tempRow['qty'] = $row['items'][0]['quantity'];
			// 	$tempRow['final_total'] = $row['final_total'];
			$tempRow['final_total'] = ceil($total-$discounted_amount);
			$tempRow['deliver_by'] = $row['items'][0]['deliver_by'];
			$tempRow['payment_method'] = $row['payment_method'];
			$tempRow['address'] = $row['address'];
			$tempRow['delivery_time'] = $row['delivery_time'];
			// $tempRow['items'] = $items;
			$tempRow['status'] = $status;
			$tempRow['active_status'] = $row['active_status'];
			$tempRow['date_added'] = date('d-m-Y h:ia',strtotime($row['date_added']));
			$tempRow['operate'] = '<br><a href="order-detail.php?id='.$row['id'].'"><i class="fa fa-eye"></i> View</a>
			<br><a data-fancybox="" data-options="{&quot;iframe&quot; : {&quot;css&quot; : {&quot;width&quot; : &quot;80%&quot;, &quot;height&quot; : &quot;80%&quot;}}}" href="https://www.google.com/maps/search/?api=1&amp;query='.$row['latitude'].', '.$row['longitude'].'&hl=es;z=14&amp;output=embed"><i class="fa fa-map-marker"></i> Locate</a><br><a href="delete-order.php?id='.$row['id'].'"><i class="fa fa-trash"></i> Delete</a><br>';
			
			$rows[] = $tempRow;
		}
		$bulkData['rows'] = $rows;
		print_r(json_encode($bulkData));
	}
	
	// data of 'Fund Transfer' table goes here
	if(isset($_GET['table']) && $_GET['table'] == 'fund-transfers'){
		
		$offset = 0; $limit = 10;
		$sort = 'id'; $order = 'DESC';
		$where = '';
		if(isset($_GET['offset']))
			$offset = $_GET['offset'];
		if(isset($_GET['limit']))
			$limit = $_GET['limit'];
		
		if(isset($_GET['sort']))
			$sort = $_GET['sort'];
		if(isset($_GET['order']))
			$order = $_GET['order'];
		
		if(isset($_GET['search']) && $_GET['search'] !=''){
			$search = $_GET['search'];
			$where = " Where f.`id` like '%".$search."%' OR f.`delivery_boy_id` like '%".$search."%' OR d.`name` like '%".$search."%' OR f.`message` like '%".$search."%' OR d.`mobile` like '%".$search."%' OR d.`address` like '%".$search."%' OR f.`opening_balance` like '%".$search."%' OR f.`closing_balance` like '%".$search."%' OR d.`balance` like '%".$search."%' OR f.`date_created` like '%".$search."%'" ;
		}
		if(empty($where)){
			$where .= " WHERE delivery_boy_id = ".$id;
		}else{
			$where .= " AND delivery_boy_id = ".$id;
		}
		
		$sql = "SELECT COUNT(*) as total FROM `fund_transfers` f JOIN `delivery_boys` d ON f.delivery_boy_id=d.id".$where;
//  		echo $sql;
		$db->sql($sql);
		$res = $db->getResult();
		foreach($res as $row)
			$total = $row['total'];
		
		$sql = "SELECT f.*,d.name,d.mobile,d.address FROM `fund_transfers` f JOIN `delivery_boys` d ON f.delivery_boy_id=d.id ".$where." ORDER BY ".$sort." ".$order." LIMIT ".$offset.", ".$limit;
// 		echo $sql;
		$db->sql($sql);
		$res = $db->getResult();
		
		$bulkData = array();
		$bulkData['total'] = $total;
		$rows = array();
		$tempRow = array();
		
		foreach($res as $row){
			
			
			$tempRow['id'] = $row['id'];
			$tempRow['name'] = $row['name'];
			$tempRow['mobile'] = $row['mobile'];
			$tempRow['address'] = $row['address'];
			$tempRow['delivery_boy_id'] = $row['delivery_boy_id'];
			$tempRow['opening_balance'] = $row['opening_balance'];
			$tempRow['closing_balance'] = $row['closing_balance'];
			$tempRow['status'] = $row['status'];
			$tempRow['message'] = $row['message'];
			$tempRow['date_created'] = $row['date_created'];
			// $tempRow['mobile'] = $row['mobile'];
			// $tempRow['address'] = $row['address'];
			// $tempRow['bonus'] = $row['bonus'];
			// if($row['status']==0)
			//     $tempRow['status']="<label class='label label-danger'>Deactive</label>";
   //          else
   //              $tempRow['status']="<label class='label label-success'>Active</label>";
			// $tempRow['operate'] = $operate;
			$rows[] = $tempRow;
		}
		$bulkData['rows'] = $rows;
		print_r(json_encode($bulkData));
	}
?>