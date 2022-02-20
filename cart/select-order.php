<?php
ini_set('max_execution_time', 2000);
ini_set('memory_limit', '100M');
set_time_limit(0);
error_reporting(1);
    $root = $_SERVER["DOCUMENT_ROOT"];
    include($root.'/cart/includes/connection.php');
    include_once($root.'/cart/includes/custom-functions.php');
    $fn = new custom_functions;
    include_once($root.'/cart/includes/crud.php');
    include_once($root.'/cart/includes/variables.php');
    include_once($root.'/cart/includes/functions.php');
    $db = new Database();
    $db->connect();
    $con = $conn;
    require($root.'/cart/dompdf/autoload.inc.php');
    $html = '<!DOCTYPE html>';
    $html .= '<html>';
    $html .= '<head>';
    $html .= '<title>SGrainwala - Invoice</title>';
    $html .= '    <link type="text/css" href="admin_new/assets/invoice/in.css" rel="stylesheet" media="all" />';
    $html .= '    <link type="text/css" href="admin_new/assets/invoice/bootstrap.css" rel="stylesheet" media="all" />';
    $html .= '    <meta charset="utf-8" /><style>
    @import url("https://fonts.googleapis.com/css2?family=Hind+Vadodara:wght@300&display=swap");
    body {font-family: "Hind Vadodara", sans-serif;font-size: 14px;}
    
    </style>';
    $html .= '   </head>';
    $html .= '<body>';
    $html .= '<div class="container">';
    $html .= '              <center>';
    if(isset($_POST['ids']))
    {  
        $exportData = $_POST['ids'];
        if(!empty($exportData))
        {
            $numItems = count($exportData);
            $nc = 0;
            foreach ($exportData as $key=>$value)
            {
              //  $sql_outer= "SELECT oi.*,u.*,p.*,v.*,o.*,u.name as uname,d.name as delivery_boy,o.status as order_status,oi.active_status as order_item_status,p.name as pname,o.promo_code as o_promo_code,(SELECT short_code FROM unit un where un.id=v.measurement_unit_id)as mesurement_unit_name FROM `order_items` oi JOIN users u ON u.id=oi.user_id JOIN product_variant v ON oi.product_variant_id=v.id JOIN products p ON p.id=v.product_id JOIN orders o ON o.id=oi.order_id LEFT JOIN delivery_boys d ON o.delivery_boy_id=d.id WHERE o.id=".$value;
            $sql_outer= " SELECT oi.*,u.*,p.*,v.*,o.*,u.name as uname,d.name as delivery_boy,o.status as order_status,oi.active_status as order_item_status,p.name as pname,o.promo_code as o_promo_code,(SELECT short_code FROM unit un where un.id=v.measurement_unit_id)as mesurement_unit_name FROM `order_items` oi JOIN users u ON u.id=oi.user_id
                    JOIN product_variant v ON oi.product_variant_id=v.id 
                    
                    
                    JOIN products p ON p.id=v.product_id 
                    JOIN orders o ON o.id=oi.order_id
                    
                    LEFT JOIN delivery_boys d ON o.delivery_boy_id=d.id WHERE o.id=".$value;
                // Execute query
                $db->sql($sql_outer);
                // store result 
                
                $res_outer=$db->getResult();
                  $items=[];
                foreach($res_outer as $row){
                        $data=array($row['product_id'],$row['pname'],$row['quantity'],$row['measurement'],$row['mesurement_unit_name'],$row['discounted_price']*$row['quantity'],$row['discount'],$row['sub_total'],$row['order_item_status'],$row['discounted_price'],$row['o_promo_code']);//,$row['pro_discount_type'],$row['pro_discount'],$row['pro_free_product']);
                        array_push($items, $data);
                    }
                     //print_r($items);
                    $encoded_items=$db->escapeString(json_encode($items));
    
    $html .= '  <h1 style="margin-top:10px">Invoice #'.$res_outer[0]["order_id"].'</h1>
                <table width="100%" class="table table-bordered" style="border-collapse: collapse; table-layout: fixed;">
                 <thead>
                        <tr>
                             <td style="border:1px solid #848282;" colspan="2"><strong>Order Details</strong></td>
                        </tr>
                 </thead>
                 <tbody>
                        <tr>
                             <td style="border:1px solid #848282;width: 50%;">
                                    <address>
                                         <strong>SGrainwala</strong><br>
                                         6 - Jalaram Park,  Ajawa Road, Vadodara,<br>
                                         Gujarat, India. - 390019<br>
                                         GSTIN No. :- 24CLQPK9620l1ZL 
                                    </address>
                                    <b>Telephone</b> +91 8140002400<br>
                                    <b>E-Mail</b> Info@sgrainwala.com<br>
                                    <b>Web Site:</b> <a href="https://www.sgrainwala.com">https://www.sgrainwala.com</a>
                             </td>
                             <td style="border:1px solid #848282;vertical-align: top;width: 50%;"><b>Date Added:</b> '.date("d-m-Y",strtotime($res_outer[0]["date_added"])).'<br>
                                    <b>Order ID:</b> '.$res_outer[0]["order_id"].'<br>';
                                    
                                    $delivery_date = "";
                                     $datetime = explode('-', $res_outer[0]["delivery_time"]);
                                    // if(trim($datetime[0]) == "Tomorrow")
                                    // {
                                    //     $delivery_date = date("d-m-Y",strtotime($res_outer[0]["date_added"]. " +1 day"));
                                    // }
                                    // elseif (trim($datetime[0]) == "Today") {
                                    //     $delivery_date = date("d-m-Y",strtotime($res_outer[0]["date_added"]));
                                    // }
$html .= '                          
                                    <b>Delivery Date: </b> '.$datetime[0].'-'.$datetime[1].'-'.$datetime[2].'<br>
                                    <b>Delivery Time: </b> '.$datetime[3].'<br>
                                    <b>Payment Method:</b> '.$res_outer[0]["payment_method"].'<br>
                                    <b>Shipping Method</b> Flat Shipping Rate<br>
                             </td>
                        </tr>
                 </tbody>
            </table>
            <table width="100%" class="table table-bordered" style="border-collapse: collapse; table-layout: fixed;">
                 <thead>
                        <tr>
                             <td style="border:1px solid #848282;" colspan="2"><b>Shipping Address</b></td>
                        </tr>
                 </thead>
                 <tbody>
                        <tr>
                             <td style="border:1px solid #848282;width: 50%;">
                                    <address>
                                         '.$res_outer[0]["uname"].'<br>
                                         <b>E-Mail:</b>'.$res_outer[0]["email"].'<br>
                                         <b>Telephone:</b>'.$res_outer[0]["mobile"].'
                                    </address>
                             </td>
                             <td style="border:1px solid #848282;width: 50%;">
                                    <address>
                                         '.$res_outer[0]["address"].'
                                    </address>
                             </td>
                        </tr>
                 </tbody>
            </table>
            <table  width="100%" class="table table-bordered" style="border-collapse: collapse; table-layout: fixed;text-align:right">
                 <thead>
                        <tr>
                            <td style="border:1px solid #848282;text-align:left" width="55%" ><b>Product</b></td>
                            <td style="border:1px solid #848282;"  width="15%" class="text-right"><b>Quantity</b></td>
                            <td style="border:1px solid #848282;"  width="15%" class="text-right"><b>Unit Price</b></td>
                            <td style="border:1px solid #848282;"  width="15%" class="text-right"><b>Total</b></td>
                        </tr>
                 </thead>
                 <tbody>';
                    // var_dump($encoded_items);
                        $decoded_items=json_decode(stripSlashes($encoded_items));
                        $qty = 0;
                        $i=1;
                        $total=0;
                        foreach ($decoded_items as $item) {
                            // if($item[8]!='cancelled' && $item[8]!='returned'){
                            $unitPrice = $item[7]/$item[2];
        $html .= '          <tr>
                                 <td style="border:1px solid #848282;text-align:left;" >'.$item[1].'
                                        <br>
                                        <small style="font-size:12px"> - Quantity: '.$item[3]." ".$item[4].'</small>
                                 </td>
                                 <td style="border:1px solid #848282;"  class="text-right">'.$item[2].'</td>
                                 <td style="border:1px solid #848282;"  class="text-right">';
        $html .= '              '.$unitPrice.'</td>
                                 <td style="border:1px solid #848282;"  class="text-right">';
                                         
        $html .= '               '.$item[7].'</td>
                            </tr>';
                            $qty = $qty+$item[2];
                            $i++;
                        $total+=$item[7];
                        // }
                    }
                    $sql_total = "select total from orders where id=".$value;
                    $db->sql($sql_total);
                    $res_total = $db->getResult();
                    if($res_outer[0]['discount']>0){
                        $discounted_amount = $res_total[0]['total'] * $res_outer[0]['discount'] / 100; /*  */
                        $final_total = $res_total[0]['total'] - $discounted_amount;
                        $discount_in_rupees = $res_total[0]['total']-$final_total;
                        $discount_in_rupees = floor($discount_in_rupees);
                        // echo $discount_in_rupees;
                    } else {
                        $discount_in_rupees = 0;
                    }
                   
                    $finaltotal = $total+$res_outer[0]["delivery_charge"]-$res_outer[0]["discount"]-$res_outer[0]['wallet_balance'];
                    
                    
                    
        $html .= '     <tr>
                             <td style="border:1px solid #848282;" class="text-right" colspan="3"><b>Sub-Total</b></td>
                             <td style="border:1px solid #848282;" class="text-right">'.number_format($total,2).'</td>
                        </tr>
                        <tr>
                             <td style="border:1px solid #848282;" class="text-right" colspan="3"><b>Delivery Charge</b></td>
                             <td style="border:1px solid #848282;" class="text-right">'.number_format($res_outer[0]["delivery_charge"],2).'</td>
                        </tr>
                        <tr>
                             <td style="border:1px solid #848282;" class="text-right" colspan="3"><b>Discount (%)</b></td>
                             <td style="border:1px solid #848282;" class="text-right">'.number_format($res_outer[0]["discount"],2).'</td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #848282;" class="text-right" colspan="3"><b>Promocode</b></td>
                            <td style="border:1px solid #848282;" class="text-right">'.$res_outer[0]["promo_code"].'</td>
                        
                        </tr>
                         <tr>
                             <td style="border:1px solid #848282;" class="text-right" colspan="3"><b>Used Wallet Balance</b></td>
                             <td style="border:1px solid #848282;" class="text-right">'.number_format($res_outer[0]['wallet_balance'],2).'
                                     </td>
                        </tr>
                        <tr>
                             <td style="border:1px solid #848282;" class="text-right" colspan="3"><b>Total</b></td>
                             <td style="border:1px solid #848282;" class="text-right">'.number_format($finaltotal,2).'</td>
                        </tr>
                 </tbody>
            </table>';

                if(++$nc !== $numItems) {
                    $html .= '<div style="page-break-before: always;"></div>';
                }
            }
           
        }
    }
    $html .= '              </center>';
    $html .= '</div>';
    $html .= '</body>';
    $html .= '</html>';
    // exit();
              
    // Reference the Dompdf namespace 
    use Dompdf\Dompdf;
    // Instantiate and use the dompdf class 
    $dompdf = new Dompdf();
    // Load HTML content 
    $dompdf->loadHtml($html);
    // (Optional) Setup the paper size and orientation 
    $dompdf->setPaper('A4', 'portrait');
    
    // Render the HTML as PDF 
    $dompdf->render(); 
    ob_end_clean();
    // Output the generated PDF to Browser 
    $dompdf->stream('OrderReport', array("Attachment" => 0));
    exit();
    ?>

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
    
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<?php include"header.php";?>
<html>
<head>
<title>Orders | <?=$settings['app_name']?> - Dashboard</title>
</head>
</body>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <?php include('public/select-order-table.php'); ?>
    

    </div><!-- /.content-wrapper -->
  </body>
  
</html>
<?php include"footer.php";?>