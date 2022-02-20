<?php
if(isset($_POST['data'])){
    $ids = json_decode($_POST['data']);
    //print_r($ids);
    $ids = join(',',$ids);
    //echo $ids;
    include('includes/connection.php');
    $sql = 'SELECT * FROM orders WHERE id IN ('.$ids.') ORDER BY id ';
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
    //$filename="temp_orders.pdf";
      $pdf->Output();  
        
    }
}