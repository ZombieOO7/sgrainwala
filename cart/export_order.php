<?php
// including the connection file
include('includes/connection.php');

$sql = 'SELECT * FROM orders';
// $sql = 'SELECT * FROM orders CROSS JOIN order_item ';
$result = mysqli_query($conn, $sql); 
require('fpdf/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$width_cell=array(20,40,30,30,20,50);
$pdf->SetFont('Arial','B',10);


//Background color of header//
$pdf->SetFillColor(193,229,252);

 
$pdf->Cell(190,10,'SGrainwala - Order List',1,0,'C');
// Line break
    $pdf->Ln(20);
    
$pdf->Cell($width_cell[0],10,'ORDER ID',1,0,C,true);
//Second header column//
$pdf->Cell($width_cell[1],10,'CUSTOMER NAME',1,0,C,true);
//Third header column//
$pdf->Cell($width_cell[2],10,'MOBILE',1,0,C,true); 
//Fourth header column//
$pdf->Cell($width_cell[3],10,'TOTAL',1,0,C,true);
//Third header column//
// $pdf->Cell($width_cell[4],10,'ADDRESS',1,0,C,true); 

$pdf->Cell($width_cell[4],10,'STATUS',1,1,C,true); 
// $pdf->Cell($width_cell[5],10,'DATE',1,1,C,true); 

$pdf->SetFont('Arial','',14);
//Background color of header//
$pdf->SetFillColor(235,236,236); 
//to give alternate background fill color to rows// 
$fill=false;
//// header ends ///////

while($row = mysqli_fetch_array($result)) {
  
$sqlu = 'SELECT * FROM users where id= '.$row['user_id'];

$result_user = mysqli_query($conn, $sqlu); 
$row_user = mysqli_fetch_array($result_user);
    
$pdf->Cell($width_cell[0],10,$row['id'],1,0,C,$fill);
$pdf->Cell($width_cell[1],10,$row_user['name'],1,0,L,$fill);
$pdf->Cell($width_cell[2],10,$row['mobile'],1,0,C,$fill);
$pdf->Cell($width_cell[3],10,$row['final_total'],1,0,C,$fill);
// $pdf->Cell($width_cell[4],10,$row['address'],1,0,C,$fill);
$pdf->Cell($width_cell[4],10,$row['active_status'],1,1,C,$fill);
// $pdf->Cell($width_cell[5],10,$row['date_added'],1,1,C,$fill);

//to give alternate background fill  color to rows//
$fill = !$fill;

 
    
}


    
 $pdf->Output();  






?>



