
<div id="content" class="container col-md-12">
	<?php 
		
		if(isset($_POST['btnDelete'])){
		
			if(isset($_GET['id'])){
				$ID = $_GET['id'];
			}else{
				$ID = "";
			}
		
			// get image file from menu table
			
			
			// delete data from menu table
			$sql_query = "DELETE FROM area 
					WHERE id =".$ID;
				// Execute query
				$db->sql($sql_query);
				// store result 
				$delete_result = $db->getResult();
				if(!empty($delete_result)){
					$delete_result=0;
				}else{
					$delete_result=1;
				}
			// if delete data success back to reservation page
			if($delete_result==1){
				header("location: areas.php");
			}
		}		

		if(isset($_POST['btnNo'])){
			header("location: areas.php");
		}

	?>
	<h1>Confirm Action</h1>
	<hr />
	<form method="post">
		<p>Are you sure want to delete this Area?</p>
		<input type="submit" class="btn btn-primary" value="Delete" name="btnDelete"/>
		<input type="submit" class="btn btn-danger" value="Cancel" name="btnNo"/>
	</form>
	<div class="separator"> </div>
</div>
			
<?php $db->disconnect(); ?>