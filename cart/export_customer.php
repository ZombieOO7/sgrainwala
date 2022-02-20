<?php
// including the connection file
include('includes/connection.php');

$sql = 'SELECT * FROM users ORDER BY id ';
$result = mysqli_query($conn, $sql);
require('fpdf/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$width_cell=array(20,40,30,30,20,50);
$pdf->SetFont('Arial','B',10);


//Background color of header//
$pdf->SetFillColor(193,229,252);

 
$pdf->Cell(190,10,'Customer List',1,0,'C');
// Line break
    $pdf->Ln(20);
    
    
$pdf->Cell($width_cell[0],10,'ID',1,0,C,true);
//Second header column//
$pdf->Cell($width_cell[1],10,'NAME',1,0,C,true);
//Third header column//
$pdf->Cell($width_cell[2],10,'Mobile',1,0,C,true); 
//Fourth header column//
$pdf->Cell($width_cell[3],10,'City Name',1,0,C,true);
//Third header column//
$pdf->Cell($width_cell[4],10,'Status',1,0,C,true); 

$pdf->Cell($width_cell[5],10,'created_at',1,1,C,true); 

$pdf->SetFont('Arial','',14);
//Background color of header//
$pdf->SetFillColor(235,236,236); 
//to give alternate background fill color to rows// 
$fill=false;
//// header ends ///////

while($row = mysqli_fetch_array($result)) {
  
    
$pdf->Cell($width_cell[0],10,$row['id'],1,0,C,$fill);
$pdf->Cell($width_cell[1],10,$row['name'],1,0,L,$fill);
$pdf->Cell($width_cell[2],10,$row['mobile'],1,0,C,$fill);

$pdf->Cell($width_cell[3],10,$row['street'],1,0,C,$fill);

$pdf->Cell($width_cell[4],10,$row['status'],1,0,C,$fill);
$pdf->Cell($width_cell[5],10,$row['created_at'],1,1,C,$fill);


//to give alternate background fill  color to rows//
$fill = !$fill;

 
    
}


    
 $pdf->Output();  






?>



