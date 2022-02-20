<?php
if (isset($_GET['id'])) {
    $ID = $_GET['id'];
} else {
    $ID = "";
}
// create array variable to handle error
$error = array();
if (isset($_POST['update_order_status'])) {
    $process = $_POST['status'];
}
    $sql="SELECT oi.*,u.*,p.*,v.*,o.*,u.name as uname,o.status as order_status,p.name as pname,(SELECT short_code FROM unit un where un.id=v.measurement_unit_id)as mesurement_unit_name FROM `order_items` oi JOIN users u ON u.id=oi.user_id JOIN product_variant v ON oi.product_variant_id=v.id JOIN products p ON p.id=v.product_id JOIN orders o ON o.id=oi.order_id WHERE o.id=".$ID;
    $db->sql($sql);
    $res=$db->getResult();
    $items=[];
    foreach($res as $row){
            $data=array($row['product_id'],$row['product_variant_id'],$row['pname'],$row['measurement'],$row['mesurement_unit_name'],$row['quantity'],$row['discounted_price'],$row['discounted_price']*$row['quantity']);
            array_push($items, $data);
        }
       
?>
<section class="content-header">
    <h1>Order Detail</h1>
    <?php echo isset($error['update_data']) ? $error['update_data'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Order Detail</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
<!--                    <form  id="update_status_form">-->
                        <table class="table table-bordered">
                            <tr>
                                <input type="hidden" name="hidden" id="order_id" value="<?php echo $res[0]['id']; ?>">
                                <th style="width: 10px">ID</th>
                                <td><?php echo $res[0]['id']; ?></td>
                            </tr>
                            <tr>
                                <th style="width: 10px">Name</th>
                                <td><?php echo $res[0]['uname']; ?></td>
                            </tr>
                            <tr>
                                <th style="width: 10px">Email</th>
                                <td><?php echo $res[0]['email']; ?></td>
                            </tr>
                            <tr>
                                <th style="width: 10px">Contact</th>
                                <td><?php echo $res[0]['mobile']; ?></td>
                            </tr>
                             <tr>
                                <th style="width: 10px">Items</th>
                                <td><?php
                                    foreach ($items as $item) {
                                        echo "<b>Product Id : </b>" . $item[0];
                                        echo "<b> Product Variant Id : </b>" . $item[1];
                                        echo " <b>Name : </b>" . $item[2];
                                        echo " <b>Unit : </b>" . $item[3]." ".$item[4];
                                        echo " <b>Quantity : </b>" . $item[5];
                                        echo " <b>Price : </b>" . $item[6];
                                        echo " <b>Subtotal : </b>" . $item[5]*$item[6]."<br>";
                                    }
                                    
                                    ?>

                                </td>
                            </tr>
                            <tr>

                                <?php 
                                   $total=0;
                                    foreach($items as $item){
                                        
                                      $total+=$item[7];

                                    }
                                ?>
                                <th style="width: 10px">Total(<?=$settings['currency']?>)</th>
                                <td ><?php echo $total; ?></td>
                            </tr>
                            
                            <tr>
                                <th style="width: 10px">Delivery Charge(<?=$settings['currency']?>)</th>
                                <td ><?php echo $res[0]['delivery_charge']; ?></td>

                            </tr>
                            <input type="hidden" name="total_amount" id="total_amount" value="<?php echo $total+$res[0]['delivery_charge']?>">
                            
                             <tr style="display: none">
                                <th style="width: 10px">Discount %</th>
                                <td ><input type="number" class="form-control" id="input_discount" name="input_discount" value="<?php echo $res[0]['discount']; ?>" min=0></td>
                                <td><a href="#" title='save_discout' class="btn btn-primary form-control update_order_total_payable" data-id='<?=$row['id'];?>'>Save</a></td>
                            </tr>
                            
                            <tr>
                                <th style="width: 10px">Payable Total(<?=$settings['currency']?>)</th>
                                <td ><input type="text" class="form-control" id="final_total" name="final_total" value="<?php echo $res[0]['final_total'];?>" disabled ></td>
                            </tr>
                            <tr>
                                <th >Deliver By</th>
                                <td>
                                    <p>You.</p>

                                </td>
                            </tr>
                            
                            <tr>
                                <th style="width: 10px">Payment Method</th>
                                <td ><?php echo $res[0]['payment_method']; ?></td>
                            </tr>
                            <tr>
                                <th style="width: 10px">Address</th>
                                <td ><?php echo $res[0]['address']; ?></td>
                            </tr>
                            <tr>
                                <th style="width: 10px">Order Date</th>
                                <td ><?php echo date('d-m-Y h:ia',strtotime($res[0]['date_added'])); ?></td>
                            </tr>
                            <tr>
                                <th >Status</th>
                                <td>
                                <?php
                                    $status = json_decode($res[0]['order_status']);
                                    // print_r($status);
                                    $i = sizeof($status);
                                    $currentStatus = $status[$i - 1][0];
                                    ?>

                                    <select name="status" id="status" class="form-control">
                                        <option value="received">Received</option>
                                        <option value="processed" >Processed</option>
                                        <option value="shipped" >Shipped</option>
                                        <option value="delivered" >Delievered</option>
                                        <option value="cancelled">Cancel</option>
                                        <option value="returned">Returned</option>
                                    </select>
                                </td>
                            </tr>
                            
                        </table>

                        <!-- /.box-body -->
                        <div class="alert alert-danger" id="result_fail" style="display:none"></div>
                        <div class="alert alert-success" id="result_success" style="display:none"></div>
                        <div class="box-footer clearfix">
                            <a href="#" title='update' class="btn btn-primary update_order_status" id="submit_btn" data-id='<?=$res[0]['id'];?>'>Update</a>
                            <a class="btn btn-primary" data-fancybox="" data-options="{&quot;iframe&quot; : {&quot;css&quot; : {&quot;width&quot; : &quot;80%&quot;, &quot;height&quot; : &quot;80%&quot;}}}" href="https://www.google.com/maps/search/?api=1&amp;query=<?=$res[0]['latitude'];?>,<?=$res[0]['longitude'];?>&hl=es;z=14&amp;output=embed">Locate</a>
                        </div>

                        
<!--                    </form>-->
                </div>
                
               <?php if ($currentStatus == "received") { ?>
                    <button class="btn btn-primary pull-right" onclick="myfunction()"  style="margin-right: 5px; margin-top: -45px;"><i class="fa fa-download"></i>Generate Invoice</button>
                <?php } elseif ($currentStatus == "processed") { ?>
                    <button class="btn btn-primary pull-right" onclick="myfunction()" style="margin-right: 5px; margin-top: -45px;"><i class="fa fa-download"></i> Generate Invoice</button>
                <?php } elseif ($currentStatus == "shipped") { ?>
                    <button class="btn btn-primary pull-right" onclick="myfunction()" style="margin-right: 5px; margin-top: -45px;"><i class="fa fa-download"></i> Generate Invoice</button>
                <?php } elseif ($currentStatus == "delivered") { ?>
                    <button class="btn btn-primary pull-right" onclick="myfunction()" style="margin-right: 5px; margin-top: -45px;"><i class="fa fa-download"></i> Generate Invoice</button>
                <?php } else { ?>
                    <button class="btn btn-primary disabled pull-right" style="margin-right: 5px; margin-top: -45px;"><i class="fa fa-download"></i> Generate Invoice</button>
                <?php } ?>
            </div>
            <!-- /.box -->
        </div>
               <div class="col-md-6">
            <ul class="timeline">
            <?php foreach($status as $s){ ?>
                <!-- timeline time label -->
                <li class="time-label">
                    <span class="bg-blue">
                        <?=$s[0];?>
                    </span>
                </li>
                <!-- /.timeline-label -->
                <!-- timeline item -->
                <li>
                    <!-- timeline icon -->
                    <i class="fa fa-circle bg-blue"></i>
                    <div class="timeline-item">
                        <!--<span class="time"><i class="fa fa-clock-o"></i> 12:05</span>-->
                        <h3 class="timeline-header"><?=$s[1];?></h3>
                        <div class="timeline-body">
                        </div>
                    </div>
                </li>
                <!-- timeline time label -->
            <!-- /.timeline-label -->
            <!-- timeline item -->
            <!-- END timeline item -->
        <?php } ?>
        </ul>
        </div>
    </div>
</section>
<!-- <script>
    var total_amount=$('#total_amount').val();
    $("#final_total").val(total_amount);
</script> -->
<script>
    
$(document).on('click','.update_order_status',function(e){
	e.preventDefault();
        var status = $('#status').val();
		var id = $('#order_id').val();
		var dataString ='update_order_status=true&id='+id+'&status='+status+'&ajaxCall=1';
	$.ajax({        
        url: "../api/order-process.php",
        type: "POST",
        data: dataString,
       beforeSend: function(){$(this).html('...');},
        dataType: "json",
        success: function (data) {
            var result = $.map(data, function(value, index) {
                return [value];
			});
			if(result[1][0]=='C'){
			    $('#result_fail').html(result[1]);
			    $('#result_fail').show().delay(3000).fadeOut();
			}else{
			    $('#result_success').html(result[1]);
			    $('#result_success').show().delay(3000).fadeOut();
			}
			
			
			$('#submit_btn').attr('disabled',false);
			$('#submit_btn').html('Update');
			 //alert(result[1]);
// 			if(!result[0])
// 				location.reload();
        }

    });
});
</script>

<script>
$(document).on('click','.update_order_total_payable',function(e){
	e.preventDefault();
        var discount = $('#input_discount').val();
        var total_payble = $('#final_total').val();
        // alert(total_payble);
        var deliver_by = $('#deliver_by').val();
		var id = $('#order_id').val();
		var dataString ='update_order_total_payable=true&id='+id+'&discount='+discount+'&total_payble='+total_payble+'&deliver_by='+deliver_by;
	$.ajax({        
        url: "api/order-process.php" ,
        type: "POST",
        data: dataString,
        beforeSend: function(){$(this).html('...');},
        dataType: "json",
        success: function (data) {
			var result = $.map(data, function(value, index) {
				return [value];
			});
			 alert(result[1]);
			if(!result[0]){}
				location.reload();
        }

    });
});
</script>


<script type="text/javascript">


/* function sendMail(){
    var process = $('#status').val();
    window.location.href = './public/send-message.php?process='+process+'&id=<?php //echo $data['id']; ?>';
} */
</script>

<script>
    $(document).ready(function () {
        $("#status").val("<?= $GLOBALS['currentStatus'] ?>");
    });
</script>
<script>
    function myfunction() {
        window.location.href = 'invoice.php?id=<?php echo $res[0]['id']; ?>';
    }
</script>

<script>
$('#input_discount').on('input',function() {
    var total=$("#total_amount").val();
	      var discount = $('#input_discount').val();
	      if(discount >= 0){
    	      var discounted_amount = total * discount / 100; /*  */
    	      var final_total = total - discounted_amount;
    	      $("#final_total").val(final_total);
	      }
});

</script>

<?php $db->disconnect(); ?>