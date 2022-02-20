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
<title>Payment Gateways & Payment Methods Settings | <?=$settings['app_name']?> - Dashboard</title>
</head>
</body>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <?php 
        $fn = new custom_functions();
        $db = new Database();
        $db->connect();
        $data = $fn->get_settings('payment_methods',true);
        //print_r($data);
        $message = '';
        
        if(isset($_POST) && isset($_POST['btn_update'])){
            unset($_POST['btn_update']);
            // print_r(json_encode($_POST));
            /*echo '<pre>';
            print_r($_POST);
            echo '</pre>';*/
            if(empty($data)){
                $data = $_POST;
                $json_data = json_encode($data);
                $sql = "INSERT INTO `settings`(`variable`, `value`) VALUES ('payment_methods','$json_data')";
                $db->sql($sql);
                $message = "<div class='alert alert-success'> Settings created successfully!</div>";
            }else{
                $data = $_POST;
                $json_data = json_encode($data);
                $sql = "UPDATE `settings` SET `value`='$json_data' WHERE `variable`='payment_methods'";
                $db->sql($sql);
                $message = "<div class='alert alert-success'> Settings updated successfully!</div>";
            }
            $db->disconnect();
        }

        ?>
            <section class="content-header">

                <h2>Payment Gateways & Methods Settings</h2>
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
                                <h3 class="box-title">Payment Methods Settings</h3>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <div class="box-body">
                                <div class="col-md-4">
                                    <form method="post" enctype="multipart/form-data">
                                        
                                        <h5>Cash On Dilivery </h5><hr>
                                        <div class="form-group">
                                            <label for="cod_payment_method">COD Payments <small>[ Enable / Disable ] </small></label><br>
                                            <input type="checkbox" id="cod_payment_method_btn" class="js-switch" <?php if(!empty($data['cod_payment_method']) && $data['cod_payment_method'] == '1'){ echo 'checked'; }?>>
                                            <input type="hidden" id="cod_payment_method" name="cod_payment_method" value="<?=(isset($data['cod_payment_method']) && !empty($data['cod_payment_method']))?$data['cod_payment_method']:0;?>">
                                        </div>
                                        
                                        <h5>Paypal Payments </h5><hr>
                                        <div class="form-group">
                                            <label for="paypal_payment_method">Paypal Payments <small>[ Enable / Disable ] </small></label><br>
                                            <input type="checkbox" id="paypal_payment_method_btn" class="js-switch" <?php if(!empty($data['paypal_payment_method']) && $data['paypal_payment_method'] == '1'){ echo 'checked'; }?>>
                                            <input type="hidden" id="paypal_payment_method" name="paypal_payment_method" value="<?=(isset($data['paypal_payment_method']) && !empty($data['paypal_payment_method']))?$data['paypal_payment_method']:0;?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Payment Mode <small>[ sandbox / live ]</small></label>
                                            <select name="paypal_mode" class="form-control" required>
                                                <option value="">Select Mode </option>
                                                <option value="sandbox" <?=(isset($data['paypal_mode']) && $data['paypal_mode']=='sandbox')?"selected":""?> >Sandbox ( Testing )</option>
                                                <option value="production" <?=(isset($data['paypal_mode']) && $data['paypal_mode']=='production')?"selected":""?>>Production ( Live )</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="paypal_business_email">Paypal Business Email</label>
                                            <input type="text" class="form-control" name="paypal_business_email" value="<?=(isset($data['paypal_business_email']))?$data['paypal_business_email']:''?>" placeholder="Paypal Business Email"/>
                                        </div>
                                        <!------------->
                                        <hr>
                                        <h5>Google Pay Payments </h5>
                                        <hr>
                                        <div class="form-group">
                                            <?php /*<label for="googlepay_payment_method">Google Pay Payments <small>[ Enable / Disable ] </small></label><br>
                                            <input type="checkbox" id="googlepay_payment_method_btn" name="googlepay_payment_method" class="js-switch" value="1" <?php if(!empty($data['googlepay_payment_method']) && $data['googlepay_payment_method'] == '1'){ echo 'checked'; }?>>
                                            <input type="hidden" id="googlepay_payment_method" name="googlepay_payment_method" value="<?=(isset($data['googlepay_payment_method']) && !empty($data['googlepay_payment_method']))?$data['googlepay_payment_method']:0;?>">*/ ?>
                                            
                                            <label for="googlepay_payment_method">Google Pay Payments <small>[ Enable / Disable ] </small></label><br>
                                            <input type="checkbox" id="googlepay_payment_method_btn" class="js-switch" <?php if(!empty($data['googlepay_payment_method']) && $data['googlepay_payment_method'] == '1'){ echo 'checked'; }?>>
                                            <input type="hidden" id="googlepay_payment_method" name="googlepay_payment_method" value="<?=(isset($data['googlepay_payment_method']) && !empty($data['googlepay_payment_method']))?$data['googlepay_payment_method']:0;?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Payment Mode <small>[ sandbox / live ]</small></label>
                                            <select name="googlepay_mode" class="form-control" required>
                                                <option value="">Select Mode </option>
                                                <option value="sandbox" <?=(isset($data['googlepay_mode']) && $data['googlepay_mode']=='sandbox')?"selected":""?> >Sandbox ( Testing )</option>
                                                <option value="production" <?=(isset($data['googlepay_mode']) && $data['googlepay_mode']=='production')?"selected":""?>>Production ( Live )</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="googlepay_gateway">Gateway</label>
                                            <input type="text" class="form-control" name="googlepay_gateway" value="<?=(isset($data['googlepay_gateway']))?$data['googlepay_gateway']:''?>" placeholder="Google Pay Gateway"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="googlepay_merchant_key">Gateway Merchant key</label>
                                            <input type="text" class="form-control" name="googlepay_merchant_key" value="<?=(isset($data['googlepay_merchant_key']))?$data['googlepay_merchant_key']:''?>" placeholder="Google Pay Gateway Merchant Key"/>
                                        </div>
                                        <!------------->
                                        <hr>
                                        <h5>PayUMoney Payments </h5>
                                        <hr>
                                        <div class="form-group">
                                            <label for="payumoney_payment_method">PayUMoney Payments <small>[ Enable / Disable ] </small></label><br>
                                            <input type="checkbox" id="payumoney_payment_method_btn" class="js-switch" <?php if(!empty($data['payumoney_payment_method']) && $data['payumoney_payment_method'] == '1'){ echo 'checked'; }?>>
                                            <input type="hidden" id="payumoney_payment_method" name="payumoney_payment_method" value="<?=(isset($data['payumoney_payment_method']) && !empty($data['payumoney_payment_method']))?$data['payumoney_payment_method']:0;?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Payment Mode <small>[ sandbox / live ]</small></label>
                                            <select name="paypal_mode" class="form-control" required>
                                                <option value="">Select Mode </option>
                                                <option value="sandbox" <?=(isset($data['paypal_mode']) && $data['paypal_mode']=='sandbox')?"selected":""?> >Sandbox ( Testing )</option>
                                                <option value="production" <?=(isset($data['paypal_mode']) && $data['paypal_mode']=='production')?"selected":""?>>Production ( Live )</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="payumoney_merchant_key">Merchant key</label>
                                            <input type="text" class="form-control" name="payumoney_merchant_key" value="<?=(isset($data['payumoney_merchant_key']))?$data['payumoney_merchant_key']:''?>" placeholder="PayUMoney Merchant Key"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="payumoney_merchant_id">Merchant ID</label>
                                            <input type="text" class="form-control" name="payumoney_merchant_id" value="<?=(isset($data['payumoney_merchant_id']))?$data['payumoney_merchant_id']:''?>" placeholder="PayUMoney Merchant ID"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="payumoney_salt">Salt</label>
                                            <input type="text" class="form-control" name="payumoney_salt" value="<?=(isset($data['payumoney_salt']))?$data['payumoney_salt']:''?>" placeholder="PayUMoney Merchant ID"/>
                                        </div>
                                        
                                        
                                        
                                        
                                        <hr>
                                        <h5>Paytm Payments </h5>
                                        <hr>
                                        <div class="form-group">
                                            <?php /*<label for="googlepay_payment_method">Google Pay Payments <small>[ Enable / Disable ] </small></label><br>
                                            <input type="checkbox" id="googlepay_payment_method_btn" name="googlepay_payment_method" class="js-switch" value="1" <?php if(!empty($data['googlepay_payment_method']) && $data['googlepay_payment_method'] == '1'){ echo 'checked'; }?>>
                                            <input type="hidden" id="googlepay_payment_method" name="googlepay_payment_method" value="<?=(isset($data['googlepay_payment_method']) && !empty($data['googlepay_payment_method']))?$data['googlepay_payment_method']:0;?>">*/ ?>
                                            
                                            <label for="paytm_payment_method">Paytm Payments <small>[ Enable / Disable ] </small></label><br>
                                            <input type="checkbox" id="paytm_payment_method_btn" class="js-switch" <?php if(!empty($data['paytm_payment_method']) && $data['paytm_payment_method'] == '1'){ echo 'checked'; }?>>
                                            <input type="hidden" id="paytm_payment_method" name="paytm_payment_method" value="<?=(isset($data['paytm_payment_method']) && !empty($data['paytm_payment_method']))?$data['paytm_payment_method']:0;?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Payment Mode <small>[ sandbox / live ]</small></label>
                                            <select name="paytm_mode" class="form-control" required>
                                                <option value="">Select Mode </option>
                                                <option value="sandbox" <?=(isset($data['paytm_mode']) && $data['paytm_mode']=='sandbox')?"selected":""?> >Sandbox ( Testing )</option>
                                                <option value="production" <?=(isset($data['paytm_mode']) && $data['paytm_mode']=='production')?"selected":""?>>Production ( Live )</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="paytm_gateway">Secrate key</label>
                                            <input type="text" class="form-control" name="paytm_gateway" value="<?=(isset($data['paytm_gateway']))?$data['paytm_gateway']:''?>" placeholder="Paytm secrate key"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="paytm_merchant_key">Gateway Merchant key</label>
                                            <input type="text" class="form-control" name="paytm_merchant_key" value="<?=(isset($data['paytm_merchant_key']))?$data['paytm_merchant_key']:''?>" placeholder="Paytm  Merchant Key"/>
                                        </div>
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        <input type="submit" class="btn-primary btn" value="Update" name="btn_update"/>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
            </section>
            <div class="separator"> </div>
      </div><!-- /.content-wrapper -->
  </body>
</html>
<?php include"footer.php";?>
<script type="text/javascript" src="css/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript">CKEDITOR.replace('contact_us');</script>
<script type="text/javascript">
    var changeCheckbox1 = document.querySelector('#paypal_payment_method_btn');
    var changeCheckbox2 = document.querySelector('#payumoney_payment_method_btn');
    var changeCheckbox3 = document.querySelector('#googlepay_payment_method_btn');
    var changeCheckbox5 = document.querySelector('#paytm_payment_method_btn');
    
    var changeCheckbox4 = document.querySelector('#cod_payment_method_btn');
        var init1 = new Switchery(changeCheckbox1);
        var init2 = new Switchery(changeCheckbox2);
        var init3 = new Switchery(changeCheckbox3);
        var init4 = new Switchery(changeCheckbox4);
        var init5 = new Switchery(changeCheckbox5);
        changeCheckbox1.onchange = function() {
            if(changeCheckbox1.checked)
                $('#paypal_payment_method').val(1);
            else
                $('#paypal_payment_method').val(0);
        };
        changeCheckbox2.onchange = function() {
            if(changeCheckbox2.checked)
                $('#payumoney_payment_method').val(1);
            else
                $('#payumoney_payment_method').val(0);
        };
        changeCheckbox3.onchange = function() {
            if(changeCheckbox3.checked)
                $('#googlepay_payment_method').val(1);
            else
                $('#googlepay_payment_method').val(0);
        };
        changeCheckbox4.onchange = function() {
            if(changeCheckbox4.checked)
                $('#cod_payment_method').val(1);
            else
                $('#cod_payment_method').val(0);
        };
        
         changeCheckbox5.onchange = function() {
            if(changeCheckbox5.checked)
                $('#paytm_payment_method').val(1);
            else
                $('#paytm_payment_method').val(0);
        };
        
        
</script>