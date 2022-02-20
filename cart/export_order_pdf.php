<?php
// including the connection file
include('includes/connection.php');

// set headers of csv format and force download
//$exportData = $_POST['data'];


require('fpdf/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$width_cell=array(20,20,30,20,20,20,30,20,20);
$pdf->SetFont('Arial','B',10);
//Background color of header//
$pdf->SetFillColor(193,229,252);
 
$pdf->Cell(190,10,'Order List',1,0,'C');
// Line break
    $pdf->Ln(20);
    
$pdf->Cell($width_cell[0],10,'Order ID',1,0,C,true);
$pdf->Cell($width_cell[1],10,'User Name',1,0,C,true);
$pdf->Cell($width_cell[2],10,'Mobile',1,0,C,true); 
// $pdf->Cell($width_cell[3],10,'Total(RS.)',1,0,C,true);
// $pdf->Cell($width_cell[4],10,'D.Charge',1,0,C,true);
// $pdf->Cell($width_cell[5],10,'Final Total(RS.)',1,0,C,true); 

// $pdf->Cell($width_cell[6],10,'Payment Method',1,0,C,true);
// $pdf->Cell($width_cell[7],10,'Address',1,0,C,true);
// $pdf->Cell($width_cell[8],10,'Delivery Time',1,0,C,true); 
// $pdf->Cell($width_cell[9],10,'Active Status',1,0,C,true);
// $pdf->Cell($width_cell[10],10,'Order Date',1,0,C,true);
$pdf->Ln(10);



$pdf->SetFont('Arial','',10);
//Background color of header//
$pdf->SetFillColor(235,236,236); 
//to give alternate background fill color to rows// 
$fill=false;
//// header ends ///////
/*
foreach ($exportData as $key => $value)
{     
$pdf->Cell($width_cell[0],10,$value['Order ID'],1,0,L,$fill);
$pdf->Cell($width_cell[1],10,$value['User Name'],1,0,L,$fill);
$pdf->Cell($width_cell[2],10,$value['Mobile'],1,0,L,$fill);

// $pdf->Cell($width_cell[3],10,$value['Total(RS.)'],1,0,C,$fill);
// $pdf->Cell($width_cell[4],10,$value['D.Charge'],1,0,L,$fill);
// $pdf->Cell($width_cell[5],10,$value['Final Total(RS.)'],1,0,C,$fill);
// $pdf->Cell($width_cell[6],10,$value['Payment Method'],1,0,C,$fill);
// $pdf->Cell($width_cell[7],10,$value['Address'],1,0,L,$fill);
// $pdf->Cell($width_cell[8],10,$value['Delivery Time'],1,0,C,$fill);
// $pdf->Cell($width_cell[9],10,$value['Active Status'],1,0,C,$fill);
// $pdf->Cell($width_cell[10],10,$value['Order Date'],1,0,L,$fill);
$pdf->Ln(10);
//to give alternate background fill  color to rows//
// $fill = !$fill;

 $fill = !$fill;
    //$filename="temp_orders.pdf";
    
    
}
*/
  $pdf->Output(); 

?>



