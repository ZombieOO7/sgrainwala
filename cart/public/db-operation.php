<?php
session_start();
include('../includes/crud.php');
$db = new Database();
$db->connect();
$db->sql("SET NAMES 'utf8'");
$auth_username = $db->escapeString($_SESSION["user"]);

include_once('../includes/custom-functions.php');
$fn = new custom_functions;
$config = $fn->get_configurations();
if(isset($config['system_timezone']) && isset($config['system_timezone_gmt'])){
    date_default_timezone_set($config['system_timezone']);
    $db->sql("SET `time_zone` = '".$config['system_timezone_gmt']."'");
}else{
    date_default_timezone_set('Asia/Kolkata');
    $db->sql("SET `time_zone` = '+05:30'");
}
function checkadmin($auth_username){
    $db = new Database();
    $db->connect();
    $db->sql("SELECT `username` FROM `admin` WHERE `username`='$auth_username' LIMIT 1");
    $res = $db->getResult();
    if(!empty($res)){
        
            return true;
        }
        else{
            return false;
        }
    }

if(isset($_POST['change_category'])){
    if($_POST['category_id']==''){
        $sql = "SELECT * FROM subcategory";
    }else{
        $sql = "SELECT * FROM subcategory WHERE category_id=".$_POST['category_id'];
    }
   
    $db->sql($sql);
    $res = $db->getResult();
    if(!empty($res)){
        foreach($res as $row){
            echo "<option value=".$row['id'].">".$row['name']."</option>";
        }
    }else{
        echo "<option value=''>--No Sub Category is added--</option>";
    }
}

if(isset($_POST['category'])){
    if($_POST['category_id']==''){
        $sql = "SELECT * FROM subcategory";
    }else{
         $sql = "SELECT * FROM subcategory WHERE category_id=".$_POST['category_id'];
    }
   
    $db->sql($sql);
    $res = $db->getResult();
    if(!empty($res)){
        echo "<option value=''>All</option>";
        foreach($res as $row){
            echo "<option value=".$row['id'].">".$row['name']."</option>";
        }
    }else{
        echo "<option value=''>--No Sub Category is added--</option>";
    }
}

if(isset($_POST['find_subcategory'])){
   
    $sql = "SELECT * FROM subcategory WHERE category_id=".$_POST['category_id'];
    $db->sql($sql);
    $res = $db->getResult();
    if(!empty($res)){
        foreach($res as $row){
            echo "<option value=".$row['id'].">".$row['name']."</option>";
        }
    }else{
        echo "<option value=''>--No Sub Category is added--</option>";
    }
}

if(isset($_POST['delete_variant'])){
    $id=$_POST['id'];
    $sql="DELETE FROM product_variant WHERE id=".$id;
    $db->sql($sql);
}

if(isset($_POST['delete_order'])){
    $id=$_POST['id'];
    $db->delete($orders,id==$id);
}

if(isset($_POST['system_configurations'])){    
    $date = $db->escapeString(date('Y-m-d'));
    
    $sql = "UPDATE settings SET value='". json_encode($_POST) ."' WHERE id=13";
    $db->sql($sql);
    $res = $db->getResult();
    $sql_logo="SELECT * FROM settings WHERE id=6";
    $db->sql($sql_logo);
    $res_logo = $db->getResult();
    // print_r($res_logo[0]['value']);  
    $file_name=$_FILES['logo']['name'];
    // if($_FILES['logo']['size'] > 0){
          // print_r($res_logo[0]['value']); 
    $allowedExts = array("gif", "jpeg", "jpg", "png");
    $tmp = explode('.', $file_name);
    $ext = end($tmp);
    
    if(!(in_array($ext, $allowedExts))){
            $message = "Image type is invalid! Please upload proper image!<br/>";
        }else{
            $old_image = $res_logo[0]['value'];
            $path = dirname(__DIR__).'/'.$res_logo[0]['value'];
            if(file_exists($path)){
                unlink($path);
            }
            // echo $old_img;
            $target_path = 'dist/img/';
            $filename = "logo.".strtolower($ext);
            $full_path = $target_path.''.$filename;
            $full_path2 = dirname(__DIR__).'/'.$target_path.''.$filename;
            // echo $full_path;
            if(!move_uploaded_file($_FILES["logo"]["tmp_name"], $full_path2)){
                $message = "Image could not be uploaded<br/>";
            }else{
                //Update Logo - id = 5
                $sql = "UPDATE `settings` SET `value`='".$full_path."' WHERE `id` = 6";
                $db->sql($sql);
            }
        }
            
        // }

echo "<p class='alert alert-success'>Settings Saved!</p>";
}
if(isset($_POST['add_delivery_boy']) && $_POST['add_delivery_boy']==1){
    if(!checkadmin($auth_username)){
        echo "<label class='alert alert-danger'>Access denied - You are not authorized to access this page.</label>";
        return false;
    }
    $name = $db->escapeString($_POST['name']);
    $mobile = $db->escapeString($_POST['mobile']);
    $address = $db->escapeString($_POST['address']);
    $bonus = $db->escapeString($_POST['bonus']);
    $password = $db->escapeString($_POST['password']);
    $password = md5($password);
    $sql='SELECT id FROM delivery_boys WHERE mobile='.$mobile;
    $db->sql($sql);
    $res=$db->getResult();
    $count=$db->numRows($res);
        if($count>0){
            echo '<label class="alert alert-danger">Mobile Number Already Exists!</label>';
            return false;
        }
    $sql = "INSERT INTO delivery_boys (name,mobile,password,address,bonus)
                        VALUES('$name', '$mobile', '$password', '$address','$bonus')";
    if($db->sql($sql)){
        echo '<label class="alert alert-success">Delivery Boy Added Successfully!</label>';
    }else{
        echo '<label class="alert alert-danger">Some Error Occrred! please try again.</label>';
    }
    

}
if(isset($_POST['update_delivery_boy']) && $_POST['update_delivery_boy']==1){
    if(!checkadmin($auth_username)){
        echo "<label class='alert alert-danger'>Access denied - You are not authorized to access this page.</label>";
        return false;
    }
    $id = $db->escapeString($_POST['delivery_boy_id']);
    $name = $db->escapeString($_POST['update_name']);
    $password = !empty($_POST['update_password'])?$db->escapeString($_POST['update_password']):'';
    $address = $db->escapeString($_POST['update_address']);
    $bonus = $db->escapeString($_POST['update_bonus']);
    $status = $db->escapeString($_POST['status']);
    $password = !empty($password)?md5($password):'';
    if(!empty($password)){
        $sql = "Update delivery_boys set `name`='".$name."',password='".$password."',`address`='".$address."',`bonus`='".$bonus."',`status`='".$status."' where `id`=".$id;
    }else{
         $sql = "Update delivery_boys set `name`='".$name."',`address`='".$address."',`bonus`='".$bonus."',`status`='".$status."' where `id`=".$id;
    }
    if($db->sql($sql)){
        echo "<label class='alert alert-success'>Information Updated Successfully.</label>";
    }else{
        echo "<label class='alert alert-danger'>Some Error Occurred! Please Try Again.</label>";

    }
}
if(isset($_GET['delete_delivery_boy']) && $_GET['delete_delivery_boy']==1){
    $id=$db->escapeString($_GET['id']);
    $sql = "DELETE FROM `delivery_boys` WHERE id=".$id;
    if($db->sql($sql)){
        echo 0;
    }else{
        echo 1;
    }

}
if(isset($_POST['update_payment_request']) && $_POST['update_payment_request']==1){
    if(!checkadmin($auth_username)){
        echo "<label class='alert alert-danger'>Access denied - You are not authorized to access this page.</label>";
        return false;
    }
    $id = $db->escapeString($_POST['payment_request_id']);
    $remarks = $db->escapeString($_POST['update_remarks']);
    $status = $db->escapeString($_POST['status']);
    if($status=='2'){
        $sql = "SELECT user_id,amount_requested FROM payment_requests WHERE id=".$id;
        $db->sql($sql);
        $res = $db->getResult();
        $user_id = $res[0]['user_id'];
        $amount = $res[0]['amount_requested'];

        $sql = "UPDATE users SET balance = balance + $amount WHERE id=".$user_id;
        $db->sql($sql);

    }
    $sql = "Update payment_requests set `remarks`='".$remarks."',`status`='".$status."' where `id`=".$id;
    if($db->sql($sql)){
        echo "<label class='alert alert-success'>Updated Successfully.</label>";
    }else{
        echo "<label class='alert alert-danger'>Some Error Occurred! Please Try Again.</label>";

    }
}
if(isset($_POST['boy_id']) && isset($_POST['transfer_fund'])){
    if(!checkadmin($auth_username)){
        echo "<label class='alert alert-danger'>Access denied - You are not authorized to access this page.</label>";
        return false;
    }
    $id=$db->escapeString($_POST['boy_id']);
    $balance=$db->escapeString($_POST['delivery_boy_balance']);
    $amount=$db->escapeString($_POST['amount']);
    $message=(!empty($_POST['message']))?$db->escapeString($_POST['message']):'Fund Transferred By Admin';
    $bal=$balance-$amount;
    $sql = "Update delivery_boys set `balance`='".$bal."' where `id`=".$id;
    $db->sql($sql);
    $sql = "INSERT INTO `fund_transfers` (`delivery_boy_id`,`amount`,`opening_balance`,`closing_balance`,`status`,`message`) VALUES ('".$id."','".$amount."','".$balance."','".$bal."','SUCCESS','".$message."')";
    $db->sql($sql);
    echo "<p class='alert alert-success'>Amount Transferred Successfully!</p>";
}
if(isset($_POST['add_promo_code']) && $_POST['add_promo_code']==1){
    if(!checkadmin($auth_username)){
        echo "<label class='alert alert-danger'>Access denied - You are not authorized to access this page.</label>";
        return false;
    }
    $promo_code = $db->escapeString($_POST['promo_code']);
    $message = $db->escapeString($_POST['message']);
    $start_date = $db->escapeString($_POST['start_date']);
    $end_date = $db->escapeString($_POST['end_date']);
    $no_of_users = $db->escapeString($_POST['no_of_users']);
    $minimum_order_amount = $db->escapeString($_POST['minimum_order_amount']);
    $discount = $db->escapeString($_POST['discount']);
    $discount_type = $db->escapeString($_POST['discount_type']);
    $max_discount_amount = $db->escapeString($_POST['max_discount_amount']);
    $repeat_usage = $db->escapeString($_POST['repeat_usage']);
    $no_of_repeat_usage = $db->escapeString($_POST['no_of_repeat_usage']);
    $status = $db->escapeString($_POST['status']);
        $product = $db->escapeString($_POST['free_product']);
    $product_var = $db->escapeString($_POST['product_varient']);
    $chkbox = $_POST['pay'];
 
 $chkNew = ""; 
 
 foreach($chkbox as $chkNew1) 
 { 
 $chkNew .= $chkNew1 . ","; 
 } 
    
   $sql = "INSERT INTO promo_codes (promo_code,message,start_date,end_date,no_of_users,minimum_order_amount,discount,discount_type,max_discount_amount,repeat_usage,no_of_repeat_usage,status,free_product,product_varient,type)
                        VALUES('$promo_code', '$message', '$start_date', '$end_date','$no_of_users','$minimum_order_amount','$discount','$discount_type','$max_discount_amount','$repeat_usage','$no_of_repeat_usage','$status','$product','$product_var','$chkNew')";
                         //echo $sql; exit;
    if($db->sql($sql)){
        echo '<label class="alert alert-success">Promo Code Added Successfully!</label>';
    }else{
        echo '<label class="alert alert-danger">Some Error Occrred! please try again.</label>';
    }
    

}
if(isset($_POST['update_promo_code']) && $_POST['update_promo_code']==1){
    if(!checkadmin($auth_username)){
        echo "<label class='alert alert-danger'>Access denied - You are not authorized to access this page.</label>";
        return false;
    }
    $id = $db->escapeString($_POST['promo_code_id']);
    $promo_code = $db->escapeString($_POST['update_promo']);
    $message = $db->escapeString($_POST['update_message']);
    $start_date = $db->escapeString($_POST['update_start_date']);
    $end_date = $db->escapeString($_POST['update_end_date']);
    $no_of_users = $db->escapeString($_POST['update_no_of_users']);
    $minimum_order_amount = $db->escapeString($_POST['update_minimum_order_amount']);
    $discount = $db->escapeString($_POST['update_discount']);
    $discount_type = $db->escapeString($_POST['update_discount_type']);
    $f_product = $db->escapeString($_POST['update_free_product']);
    $product_var = $db->escapeString($_POST['update_product_varient']);
    $max_discount_amount = $db->escapeString($_POST['update_max_discount_amount']);
    $repeat_usage = $db->escapeString($_POST['update_repeat_usage']);
    $no_of_repeat_usage = $repeat_usage==0?'0':$db->escapeString($_POST['update_no_of_repeat_usage']);
    $status = $db->escapeString($_POST['status']);
    
    $sql = "Update promo_codes set `promo_code`='".$promo_code."',`message`='".$message."',`start_date`='".$start_date."',`end_date`='".$end_date."',`no_of_users`='".$no_of_users."',`minimum_order_amount`='".$minimum_order_amount."',`discount`='".$discount."',`discount_type`='".$discount_type."',`max_discount_amount`='".$max_discount_amount."',`repeat_usage`='".$repeat_usage."',`no_of_repeat_usage`='".$no_of_repeat_usage."',`status`='".$status."', `free_product`='".$f_product."', `product_varient`='".$product_var."' where `id`=".$id;
    
    if($db->sql($sql)){
        echo "<label class='alert alert-success'>Promo Code Updated Successfully.</label>";
    }else{
        echo "<label class='alert alert-danger'>Some Error Occurred! Please Try Again.</label>";

    }
}
if(isset($_GET['delete_promo_code']) && $_GET['delete_promo_code']==1){
    $id=$db->escapeString($_GET['id']);
    $sql = "DELETE FROM `promo_codes` WHERE id=".$id;
    if($db->sql($sql)){
        echo 0;
    }else{
        echo 1;
    }

}


?>