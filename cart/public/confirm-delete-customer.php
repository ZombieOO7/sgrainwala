<div id="content" class="container col-md-12">
	<?php 
		
		if(isset($_POST['btnDelete'])){
		    
			if(isset($_GET['id'])){
				$ID = $_GET['id'];
			}else{
				$ID = "";
			}
		
			
			// delete data from menu table
			//$sql_query = "DELETE FROM users WHERE id =".$ID;
					 $sql_query = "DELETE users, orders FROM users INNER JOIN orders INNER JOIN order_items
WHERE users.id=$ID OR orders.user_id=$id OR order_items.user_id=$id";
				
				// Execute query
				$db->sql($sql_query);
				// store result 
				$delete_category_result = $db->getResult();
				if(!empty($delete_category_result)){
					$delete_category_result=0;
				}
				else{
					$delete_category_result=1;
				}
				
		
			if($delete_category_result==1 ){
				header("location: customers.php");
			} else {
			    
			 //   echo "This customer is not deleted because it's used in another table, so first delete user in below table.<br>
			 //   1.order <br>
			 //   2.order_item <br>
			 //   3.transactions.";
			}
		}		
		
		if(isset($_POST['btnNo'])){
			header("location: customers.php");
		}
		
	?>
	<h1>Confirm Action</h1>
	<hr />
	<form method="post">
		<p>Are you sure want to delete this User?</p>
		<input type="submit" class="btn btn-primary" value="Delete" name="btnDelete"/>
		<input type="submit" class="btn btn-danger" value="Cancel" name="btnNo"/>
	</form>
	<div class="separator"> </div>
</div>
			
<?php $db->disconnect(); ?>