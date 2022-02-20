
<?php 
	include_once('includes/functions.php'); 
	$function = new functions;
	
?>
	<?php 
	/*	if(isset($_POST['btnAdd'])){
			$msg = $_POST['msg'];
			$amount_c = $_POST['amount_c'];
			$type = $_POST['type'];
			$status = $_POST['status'];
			$user = $_POST['user'];
			
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
			
			
		
				$sql_query = "INSERT INTO wallet_transactions (message,amount,type,status,user_id)
						VALUES('$msg', '$amount_c', '$type',$status,$user)";
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

	?>
	<section class="content-header">
          <h1>Wallet <small><a  href='wallet.php'> <i class='fa fa-angle-double-left'></i></a></small></h1>

			<?php echo isset($error['add_wallet']) ? $error['add_wallet'] : '';?>
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
                  <h3 class="box-title">Add Wallet</h3>

                </div><!-- /.box-header -->
                <!-- form start -->
                <form  method="post"
			enctype="multipart/form-data">
                  <div class="box-body">
                      <?php
                      $sql = "SELECT * FROM users";
                		//echo $sql;
                		$db->sql($sql);
                		$res = $db->getResult();
		
                      
                      ?>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Massege</label><?php echo isset($error['msg']) ? $error['msg'] : '';?>
                      <input type="text" class="form-control"  name="msg" required>
                    </div>
                   
                   
                    <div class="form-group">
                     <label for="exampleInputEmail1">User</label>
                    <select name="user" class="form-control">
                         <option>--Please select User--</option>
                        <?php	foreach($res as $row){ ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                         <?php } ?>
                     </select>
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
                    <div class="form-group ">
                        <label for="">Status</label>
                        <select name="status" class="form-control">
                            <option value="">Select</option>
                            <option value="1">Eneble</option>
                            <option value="0">Disabled</option>
                        </select>
                    </div>
                   
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
	*/?>
	<div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Wallet</h3>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-hover" data-toggle="table" id="wallet"
                        data-url="api/get-bootstrap-table-data.php?table=wallet"
                        data-page-list="[5, 10, 20, 50, 100, 200]"
                        data-show-refresh="true" data-show-columns="true"
                        data-side-pagination="server" data-pagination="true"
                        data-search="true" data-trim-on-search="false"
                        data-sort-name="id" data-sort-order="desc">
                        <thead>
                        <tr>
                           
                            <th data-field="id" data-sortable="true">Id</th>
                             <th data-field="name" data-sortable="true">User Name</th>
                            
                            <th data-field="message" data-sortable="true">Message</th>
                            <th data-field="amount" data-sortable="true"> Amount</th>
                            <th data-field="status">Status</th>
                            <th data-field="date_created">Date Created</th>
                            <th data-field="operate">Action</th>
                            
                            
                        </tr>
                        
                        </thead>
                    </table>
                </div>
            </div>
        </div>

	<div class="separator"> </div>
	
<?php $db->disconnect(); ?>
	