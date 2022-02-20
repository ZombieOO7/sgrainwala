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
    include 'header.php';?>
<head>
<title>Wallet | <?=$settings['app_name']?> - Dashboard</title>
</head>
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
                           
                            $db->select('wallet_transactions','',null,'id='.$ID);
                            $category_name=$db->getResult();
                            // echo $sql;
                        ?>
                        <h2 class="box-title">Wallet History</h2>
                        <div class="box-tools">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table class="table table-hover">
                            <tr>
                                <th>No.</th>
                                <th>Date </th>
                                <th>Message</th>
                                <th>Type</th>
                                <th>Amount</th>
                                
                            </tr>
                            <?php 
                                // get all data using while loop
                                $count=1;
                            // print_r($res);
                                foreach($res as $row){
                                 ?>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $row['date_created']; ?></td>
                                <td><?php echo $row['message'];?></td>
                                
                                <td><?php echo $row['type'];?></td>
                                
                               <td>₹<?php echo $row['amount'];?>.00</td>
                               
                               
                                
                            </tr>
                           
                            <?php $count++; } ?>
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
<?php include 'footer.php'; ?>