<?php
	ob_start();
	// start session
	
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
	
?>
<?php include"header.php";?>
<html>
<head>
<title>Edit Customer | <?=$settings['app_name']?> - Dashboard</title>
</head>
</body>


	<?php 
		if(isset($_GET['id'])){
			$ID = $_GET['id'];
		}else{
			$ID = "";
		}
		
		
		
		
		//wallet code //
		
		
		       if(isset($_POST['btnAdd'])){
			$msg = $_POST['msg'];
			$amount_c = $_POST['amount_c'];
			$type = $_POST['type'];
			$status = $_POST['status'];
			$expd = $_POST['expd'];
			//$user = $_POST['user'];
			
			// create array variable to handle error
			$error = array();
			
			if(empty($msg)){
				$error['msg'] = " <span class='label label-danger'>Required!</span>";
			}
			if(empty($amount_c)){
				$error['amount_c'] = " <span class='label label-danger'>Required!</span>";
			}
				if(empty($type)){
				$error['type'] = " <span class='label label-danger'>Required!</span>";
			}
			
			
		
				$sql_query = "INSERT INTO wallet_transactions (message,amount,type,user_id,last_updated)
						VALUES('$msg', '$amount_c', '$type','$ID','$expd')";
					// Execute query
					$db->sql($sql_query);
					// store result 
					$result = $db->getResult();
					if(!empty($result)){
						$result=0;
					}else{
						$result=1;
					}
				
				
				if($result==1){
				    //	header("location:wallet.php");
					$error['add_wallet'] = " <section class='content-header'>
												<span class='label label-success'>Wallet Added Successfully</span>
												
												
												</section>";
				}else{
					$error['add_wallet'] = " <span class='label label-danger'>Failed add Wallet</span>";
				}
			}
			
		

		if(isset($_POST['btnCancel'])){
			header("location:wallet.php");
		}

	
		//wallet code end//
		
		
		// create array variable to store user data
		$category_data = array();
			
		$sql_query = "SELECT * FROM users WHERE id =".$ID;
			// Execute query
			$db->sql($sql_query);
			// store result 
			$res=$db->getResult();
		if(isset($_POST['btnEdit'])){
		    
			$name = $_POST['name'];
			$email = $_POST['email'];
			$mobile = $_POST['mobile'];
			$password = $_POST['password'];
			$pincode = $_POST['pincode']; 
			$balance = $_POST['balance']; 
			$street = $_POST['street']; 
			 	
			// create array variable to handle error
			$error = array();
				
			if(empty($name)){
				$error['name'] = " <span class='label label-danger'>Required!</span>";
			}
			if(empty($email)){
				$error['email'] = " <span class='label label-danger'>Required!</span>";
			}
			if(empty($mobile)){
				$error['mobile'] = " <span class='label label-danger'>Required!</span>";
			}
			if(empty($password)){
				$error['password'] = " <span class='label label-danger'>Required!</span>";
			}
			if(empty($street)){
				$error['street'] = " <span class='label label-danger'>Required!</span>";
			}
			 
				
			if(!empty($name) && !empty($email) && !empty($mobile) && !empty($password) && !empty($street)) {
									 
				$sql_query = "UPDATE users SET name = '".$name."', email = '".$email."',
				mobile = '".$mobile."', password = '".$password."', street = '".$street."', pincode = '".$pincode."', balance = '".$balance."'
							WHERE id =".$ID;
						// Execute query
						$db->sql($sql_query);
						// store result 
						$update_result = $db->getResult();
				 

						if(!empty($update_result)){
							$update_result=0;
						}
						else{
							$update_result=1;
						}
				
				// check update result
				if($update_result==1){
					$error['update_users'] = " <section class='content-header'>
												<span class='label label-success'>user updated Successfully</span>
												<h4><small><a  href='customers.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to User</a></small></h4>
												</section>";
				}else{
					$error['update_users'] = " <span class='label label-danger'>Failed update user</span>";
				}
			}
				
		}
			
		// create array variable to store previous data
		$data = array();
		
		$sql_query = "SELECT * FROM users WHERE id =".$ID;
			// Execute query
			$db->sql($sql_query);
			// store result 
			$res=$db->getResult();
	

		if(isset($_POST['btnCancel'])){?>
			<script>
			window.location.href = "customers.php";
		</script>
		<?php } ?>
		 



 
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper"> 
		<?php
		include_once('includes/functions.php'); 
		?>
		<section class="content-header">
		<h1>
		Edit Customer</h1>
		<small><?php echo isset($error['update_users']) ? $error['update_users'] : '';?></small>
		<ol class="breadcrumb">
		  <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
		</ol>
	  </section>





  <section class="content">
		<!-- Main row -->
	   
		<div class="row">
		<div class="col-md-6">
			<!-- general form elements -->
			<div class="box box-primary">
			  <div class="box-header with-border">
				<h3 class="box-title">Edit Customer</h3>
			  </div><!-- /.box-header -->
			  <!-- form start -->
			  <form  method="post"
		  enctype="multipart/form-data">
				<div class="box-body">
				  <div class="form-group">
					<label for="exampleInputEmail1">User Name</label><?php echo isset($error['name']) ? $error['name'] : '';?>
					<input type="text" class="form-control"  name="name" value="<?php echo $res[0]['name']; ?>">
				  </div>
				  <div class="form-group">
					<label for="exampleInputEmail1">Email Address</label><?php echo isset($error['email']) ? $error['email'] : '';?>
					<input type="text" class="form-control"  name="email" value="<?php echo $res[0]['email']; ?>">
				  </div>

				  <div class="form-group">
					<label for="exampleInputEmail1">Mobile Number</label><?php echo isset($error['mobile']) ? $error['mobile'] : '';?>
					<input type="text" class="form-control"  name="mobile" value="<?php echo $res[0]['mobile']; ?>">
				  </div>

				  <div class="form-group">
					<label for="exampleInputEmail1">Password</label><?php echo isset($error['password']) ? $error['password'] : '';?>
					<input type="text" class="form-control"  name="password" value="<?php echo trim($res[0]['password']); ?>">
				  </div>
				  <div class="form-group">
					<label for="exampleInputEmail1">Street</label><?php echo isset($error['street']) ? $error['street'] : '';?>
					<input type="text" class="form-control"  name="street" value="<?php echo trim($res[0]['street']); ?>">
				  </div>
				  <div class="form-group">
					<label for="exampleInputEmail1">pincode</label><?php echo isset($error['pincode']) ? $error['pincode'] : '';?>
					<input type="text" class="form-control"  name="pincode" value="<?php echo trim($res[0]['pincode']); ?>">
				  </div>
				  <?php /* <div class="form-group">
					<label for="exampleInputEmail1">Balance</label><?php echo isset($error['balance']) ? $error['balance'] : '';?>
					<input type="text" class="form-control"  name="balance" value="<?php echo trim($res[0]['balance']); ?>">
				  </div> */ ?>
				 
				</div><!-- /.box-body -->

				<div class="box-footer">
				  <button type="submit" class="btn btn-primary" name="btnEdit">Update</button>
				  <button type="submit" class="btn btn-danger" name="btnCancel">Cancel</button>
				</div>
			  </form>
			</div><!-- /.box -->
		   </div>
		   
		   
		   	<section class="content-header">
         

			<?php echo isset($error['add_wallet']) ? $error['add_wallet'] : '';?>
			
		<hr />
        </section>
		   <div class="col-md-6">
		     
		        <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Add Wallet</h3>

                </div><!-- /.box-header -->
                <!-- form start -->
                <form  method="post"
			enctype="multipart/form-data">
                  <div class="box-body">
                     
                    <div class="form-group">
                      <label for="exampleInputEmail1">Massege</label><?php echo isset($error['msg']) ? $error['msg'] : '';?>
                      <input type="text" class="form-control"  name="msg" required>
                    </div>
                   
					<div class="form-group">
                      <label for="exampleInputEmail1">Amount</label><?php echo isset($error['amount_c']) ? $error['amount_c'] : '';?>
                      <input type="text" class="form-control"  name="amount_c" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Type</label><?php echo isset($error['type']) ? $error['type'] : '';?>
                     <select name="type" class="form-control">
                         <option>--Please Select--</option>
                         <option>Credit</option>
                         <option>Debit</option>
                         
                     </select>
                      
                    </div>
                
                	<div class="form-group">
                      <label for="exampleInputEmail1">Expiry date</label>
                      <input type="date" class="form-control"  name="expd" >
                    </div>
                    
                    <?php /*<div class="form-group ">
                        <label for="">Status</label>
                        <select name="status" class="form-control">
                            <option value="">Select</option>
                            <option value="1">Eneble</option>
                            <option value="0">Disabled</option>
                        </select>
                    </div> */?>
                   
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="btnAdd">Add</button>
					<input type="reset" class="btn-warning btn" value="Clear"/>
				
                  </div>
                </form>
              </div><!-- /.box -->
		       
		   </div>
		</div>
  </section>
   <?php
   
	
    if(isset($_GET['id'])){
    	$ID = $_GET['id'];
    }else{
    	$ID = "";
    }
    // get image file from table
    
    $db->select('wallet_transactions','*',null,'user_id='.$ID);
    $res=$db->getResult();
    ?>
<?php
    if($db->numRows($result)==0)
    {?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            No Wallet Available
            <small><a  href='wallet.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Wallet</a></small>
        </h1>
    </section>
</div>
<?php }
    else{
    ?>
<div class="content-wrapper">
    <section class="content">
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <?php
                        
                        
                           //$sql_query1 = "SELECT wallet_transactions.`user_id`,wallet_transactions.`date_created`,wallet_transactions.`amount`,wallet_transactions.`message`,wallet_transactions.`type` ,orders.id FROM wallet_transactions CROSS JOIN orders WHERE wallet_transactions.`user_id` =".$ID;
                           	$sql_query1 = "SELECT * FROM `wallet_transactions` WHERE user_id =".$ID;
		                	// Execute query
                    			$db->sql($sql_query1);
                    			// store result 
                    			$res=$db->getResult();
                             //echo $sql_query1;
                        ?>
                        <h2 class="">Wallet -History</h2>
                        <div class="box-tools">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table class="table table-hover" >
                        
                                               <tr>
                                <th>No.</th>
                                <th>Date </th>
                                <th>Message</th>
                                <th>Type</th>
                                <th align="right">Amount</th>
                                
                            </tr>
                            <?php 
                                // get all data using while loop
                                $count=1;
                            // print_r($res);
                                foreach($res as $row){
                                    
                                     if(strtolower($row['type']) == 'credit'){
                            $amount = $amount + $row['amount'];
                        }
                        if(strtolower($row['type']) == 'debit'){
                            $amount = $amount - $row['amount'];
                        }
                       
                                 ?>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $row['date_created']; ?></td>
                                <td><?php echo $row['message'];?></td>
                                
                                <td><?php echo $row['type'];?></td>
                               
                               <td align="right">₹<?php echo $row['amount'];?>.00</td>
                              
                               
                               
                              
                            </tr>
                           
                            <?php $count++; } ?>
                            <tr>
                                <td align="right" colspan="4">Active Balance (Customer Can Use)</td>
                                <td align="right">₹<?php echo $amount; ?>.00</td>
                            </tr>
                            <tr>
                                <td align="right" colspan="4">Balance</td>
                                <td align="right">₹<?php echo $amount; ?>.00</td>
                            </tr>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
        </div>
        <!-- /.row (main row) -->
    </section>
    <!-- /.content -->
</div>
<?php }?>
<?php $db->disconnect(); ?>
  </body>
</html>
<?php include"footer.php";?>
    	