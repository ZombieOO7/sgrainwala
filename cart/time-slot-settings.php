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
    <title>Time Slots Settings | <?=$settings['app_name']?> - Dashboard</title>
    </head>
<body>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <?php 
        $fn = new custom_functions();
        $db = new Database();
        $db->connect();
        $data = $fn->get_settings('time_slots',true);
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
                $sql = "INSERT INTO `settings`(`variable`, `value`) VALUES ('time_slots','$json_data')";
                $db->sql($sql);
                $message = "<div class='alert alert-success'> Settings created successfully!</div>";
            }else{
                $data = $_POST;
                $json_data = json_encode($data);
                $sql = "UPDATE `settings` SET `value`='$json_data' WHERE `variable`='time_slots'";
                $db->sql($sql);
                $message = "<div class='alert alert-success'> Settings updated successfully!</div>";
            }
            $db->disconnect();
        }

        ?>
            <section class="content-header">

                <h2>Time Slot Settings</h2>
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
                                <h3 class="box-title">Time Slots Settings</h3>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <div class="box-body">
                                <div class="col-md-4">
                                    <form method="post" enctype="multipart/form-data">
                                        
                                        <h5>9AM to 1PM </h5><hr>
                                        <div class="form-group">
                                            <label for="ninetoone_slot">9AM to 1PM <small>[ Enable / Disable ] </small></label><br>
                                            <input type="checkbox" id="ninetoone_slot_btn" class="js-switch" <?php if(!empty($data['ninetoone_slot']) && $data['ninetoone_slot'] == '1'){ echo 'checked'; }?>>
                                            <input type="hidden" id="ninetoone_slot" name="ninetoone_slot" value="<?=(isset($data['ninetoone_slot']) && !empty($data['ninetoone_slot']))?$data['ninetoone_slot']:0;?>">
                                        </div>
                                        
                                        <h5>5PM to 8PM </h5><hr>
                                        <div class="form-group">
                                            <label for="fivetoeight_slot">5PM to 8PM <small>[ Enable / Disable ] </small></label><br>
                                            <input type="checkbox" id="fivetoeight_slot_btn" class="js-switch" <?php if(!empty($data['fivetoeight_slot']) && $data['fivetoeight_slot'] == '1'){ echo 'checked'; }?>>
                                            <input type="hidden" id="fivetoeight_slot" name="fivetoeight_slot" value="<?=(isset($data['fivetoeight_slot']) && !empty($data['fivetoeight_slot']))?$data['fivetoeight_slot']:0;?>">
                                        </div>
                                        <!------------->
                                        <hr>
                                        <h5>10AM to 7PM </h5>
                                        <hr>
                                        <div class="form-group">
                                            <label for="tentoseven_slot">10AM to 7PM <small>[ Enable / Disable ] </small></label><br>
                                            <input type="checkbox" id="tentoseven_slot_btn" class="js-switch" <?php if(!empty($data['tentoseven_slot']) && $data['tentoseven_slot'] == '1'){ echo 'checked'; }?>>
                                            <input type="hidden" id="tentoseven_slot" name="tentoseven_slot" value="<?=(isset($data['tentoseven_slot']) && !empty($data['tentoseven_slot']))?$data['tentoseven_slot']:0;?>">
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
    var changeCheckbox1 = document.querySelector('#ninetoone_slot_btn');
    var changeCheckbox2 = document.querySelector('#fivetoeight_slot_btn');
    var changeCheckbox3 = document.querySelector('#tentoseven_slot_btn');
        var init1 = new Switchery(changeCheckbox1);
        var init2 = new Switchery(changeCheckbox2);
        var init3 = new Switchery(changeCheckbox3);
        changeCheckbox1.onchange = function() {
            if(changeCheckbox1.checked)
                $('#ninetoone_slot').val(1);
            else
                $('#ninetoone_slot').val(0);
        };
        changeCheckbox2.onchange = function() {
            if(changeCheckbox2.checked)
                $('#fivetoeight_slot').val(1);
            else
                $('#fivetoeight_slot').val(0);
        };
        changeCheckbox3.onchange = function() {
            if(changeCheckbox3.checked)
                $('#tentoseven_slot').val(1);
            else
                $('#tentoseven_slot').val(0);
        };
</script>