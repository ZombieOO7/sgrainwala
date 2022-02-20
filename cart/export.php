<?php
// including the connection file
include('includes/connection.php');
$sql = 'SELECT * FROM orders ORDER BY id ';
$result = mysqli_query($conn, $sql);
require('fpdf/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$width_cell=array(20,20,30,20,20,20,30,20,20);
$pdf->SetFont('Arial','B',10);

//Background color of header//
$pdf->SetFillColor(193,229,252);

$pdf->Cell($width_cell[0],10,'ID',1,0,C,true);
//Second header column//
$pdf->Cell($width_cell[1],10,'NAME',1,0,C,true);
//Third header column//
$pdf->Cell($width_cell[2],10,'Mobile',1,0,C,true); 
//Fourth header column//
$pdf->Cell($width_cell[3],10,'Total',1,0,C,true);
//Third header column//
$pdf->Cell($width_cell[4],10,'D.charge',1,0,C,true); 

$pdf->Cell($width_cell[5],10,'Final-total',1,0,C,true); 
$pdf->Cell($width_cell[6],10,'Payment-method',1,0,C,true); 
$pdf->Cell($width_cell[7],10,'Address',1,0,C,true); 
$pdf->Cell($width_cell[8],10,'Status',1,1,C,true); 



$pdf->SetFont('Arial','',10);
//Background color of header//
$pdf->SetFillColor(235,236,236); 
//to give alternate background fill color to rows// 
$fill=false;
//// header ends ///////

while($row = mysqli_fetch_array($result)) {
  
    
$pdf->Cell($width_cell[0],10,$row['id'],1,0,C,$fill);
$pdf->Cell($width_cell[1],10,$row['name'],1,0,L,$fill);
$pdf->Cell($width_cell[2],10,$row['mobile'],1,0,C,$fill);
$pdf->Cell($width_cell[3],10,$row['total'],1,0,C,$fill);
$pdf->Cell($width_cell[4],10,$row['delivery_charge'],1,0,C,$fill);
$pdf->Cell($width_cell[5],10,$row['final_total'],1,0,C,$fill);


$pdf->Cell($width_cell[6],10,$row['payment_method'],1,0,C,$fill);
$pdf->Cell($width_cell[5],10,$row[''],1,0,C,$fill);



$pdf->Cell($width_cell[8],10,$row['active_status'],1,1,C,$fill);



//to give alternate background fill  color to rows//
$fill = !$fill;

  $pdf->Output();  
    
}
 
 
 
 
 
 
 
 //new 
/*
// set headers of csv format and force download
header('Content-Type: text/pdf; charset=utf-8');
header('Content-Disposition: attachment; filename=order.pdf');
 
    $output = "Id,user id,delivery_boy_id,Mobile,Total,Delivery charge,wallet balance,final total,discount,payment_method,delivery_time,active_status,date_added,latitude,longitude,promo_code\n";

$sql = 'SELECT * FROM orders ORDER BY id desc';
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)) {
  // $addr = implode(", ", $row['address']);
    $output .= $row['id'].",".$row['user_id'].",".$row['delivery_boy_id'].",".$row['mobile'].",".$row['total'].",".$row['delivery_charge'].",".$row['wallet_balance'].",".$row['final_total'].",".$row['discount'].",".$row['payment_method'].",".$row['delivery_time'].",".$row['active_status'].",".$row['date_added'].",".$row['latitude'].",".$row['longitude'].",".$row['promo_code']."\n";
}
echo $output;
exit;

*/
?>