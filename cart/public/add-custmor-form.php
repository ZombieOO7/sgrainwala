<?php 
	include_once('includes/functions.php'); 
	$function = new functions;
	
?>
	<?php 
		if(isset($_POST['btnAdd'])){
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
			
		
				$sql_query = "INSERT INTO users (name,email,mobile,password,street,pincode,balance)
						VALUES('$name', '$email', '$mobile','$password','$street','$pincode','$balance')";
					
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
					$error['add_customers'] = " <section class='content-header'>
												<span class='label label-success'>Customers Added Successfully</span>
												
												
												</section>";
				}else{
					$error['add_customers'] = " <span class='label label-danger'>Failed add Customers</span>";
				}
			}
			
		

		if(isset($_POST['btnCancel'])){
			header("location:customers.php");
		}

	?>
	<section class="content-header">
          <h1>Add Customers <small><a  href='customers.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Customers</a></small></h1>

			<?php echo isset($error['add_customers']) ? $error['add_customers'] : '';?>
			<ol class="breadcrumb">
            <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
          </ol>
		<hr />
        </section>
	<section class="content">
	 <div class="row">
		  <div class="col-md-6">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Add Customers</h3>

                </div><!-- /.box-header -->
                <!-- form start -->
                <form  method="post"
			enctype="multipart/form-data">
                  <div class="box-body">
				  <div class="form-group">
					<label for="exampleInputEmail1">User Name</label><?php echo isset($error['name']) ? $error['name'] : '';?>
					<input type="text" class="form-control"  name="name" >
				  </div>
				  <div class="form-group">
					<label for="exampleInputEmail1">Email Address</label><?php echo isset($error['email']) ? $error['email'] : '';?>
					<input type="text" class="form-control"  name="email" >
				  </div>

				  <div class="form-group">
					<label for="exampleInputEmail1">Mobile Number</label><?php echo isset($error['mobile']) ? $error['mobile'] : '';?>
					<input type="text" class="form-control"  name="mobile" >
				  </div>

				  <div class="form-group">
					<label for="exampleInputEmail1">Password</label><?php echo isset($error['password']) ? $error['password'] : '';?>
					<input type="text" class="form-control"  name="password" >
				  </div>
				  <div class="form-group">
					<label for="exampleInputEmail1">Street</label><?php echo isset($error['street']) ? $error['street'] : '';?>
					<input type="text" class="form-control"  name="street" >
				  </div>
				  <div class="form-group">
					<label for="exampleInputEmail1">pincode</label><?php echo isset($error['pincode']) ? $error['pincode'] : '';?>
					<input type="text" class="form-control"  name="pincode">
				  </div>
				  <div class="form-group">
					<label for="exampleInputEmail1">Balance</label><?php echo isset($error['balance']) ? $error['balance'] : '';?>
					<input type="text" class="form-control"  name="balance" >
				  </div>

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="btnAdd">Add</button>
					<input type="reset" class="btn-warning btn" value="Clear"/>
				
                  </div>
                </form>
              </div><!-- /.box -->
			 </div>
		  </div>
	</section>

	<div class="separator"> </div>
	
<?php $db->disconnect(); ?>
	