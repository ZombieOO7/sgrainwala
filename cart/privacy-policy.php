<?php 
    
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
    include"header.php";?>
<html>
<head>
<title>Privacy-Policy | <?=$settings['app_name']?> - Dashboard</title>
</head>
</body>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <?php 
            	$sql = "SELECT * FROM settings";
                $db->sql($sql);
                $res = $db->getResult();
            	$message = '';
            	if(isset($_POST['btn_update'])){
            		if(!empty($_POST['privacy_policy']) && !empty($_POST['terms_conditions'])){

            			$privacy_policy = $db->escapeString($_POST['privacy_policy']);
                        $terms_conditions=$db->escapeString($_POST['terms_conditions']);
            			
            			
            			//Update privacy_policy - id = 9
            			$sql = "UPDATE `settings` SET `value`='".$privacy_policy."' WHERE `id` = 9";
            // 			echo $sql;
                        
            			$db->sql($sql);
                        
                        $sql = "UPDATE `settings` SET `value`='".$terms_conditions."' WHERE `id` = 10";
                       
                        $db->sql($sql);
                        
            			
            			
            			$sql = "SELECT * FROM settings";
            			$db->sql($sql);
            			$res = $db->getResult();
            			$message .= "Information Updated Successfully";
            			
            		}
            	}
            ?>
            <section class="content-header">
                <h1>Privacy Policy And Terms & Conditions</h1>
            	<h4><?=$message?></h4>
                <ol class="breadcrumb">
                    <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
                </ol>
                <hr />
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Update Privacy Policy</h3>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <form  method="post" enctype="multipart/form-data">
                                <div class="box-body">
                                    
                                    <div class="form-group">
                                        <label for="app_name">Privacy Policy:</label>
                                        <textarea rows="10" cols="10" class="form-control" name="privacy_policy" id="privacy_policy" required><?=$res[1]['value']?></textarea>
                                    </div>
                                    <div class="box-header with-border">
                                <h3 class="box-title">Update Terms Conditions</h3>
                            </div>
                            <div class="box-body">
                                    <div class="form-group">
                                        <label for="app_name">Terms & Conditions:</label>
                                        <textarea rows="10" cols="10" class="form-control" name="terms_conditions" id="terms_conditions" required><?=$res[2]['value']?></textarea>
                                    </div>
                                </div>
                                    
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <input type="submit" class="btn-primary btn" value="Update" name="btn_update"/>
                                </div>
                            </form>
                           
                        </div>
                        <!-- /.box -->
                        
                        <!-- /.box -->
                    </div>
                    </div>
                </div>
            </section>
            <div class="separator"> </div>
      </div><!-- /.content-wrapper -->
  </body>
</html>
<?php include"footer.php";?>
<script type="text/javascript" src="css/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript">CKEDITOR.replace('privacy_policy');CKEDITOR.replace('terms_conditions');</script>
