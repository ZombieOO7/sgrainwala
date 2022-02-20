<?php
include('includes/connection.php');
// set headers of csv format and force download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Customers.csv');
 
    $output = "id,name,email,Mobile,street,area ,city,created_at\n";

$sql = 'SELECT * FROM users ORDER BY id desc';
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)) {
  // $addr = implode(", ", $row['address']);
    $output .= $row['id'].",".$row['name'].",".$row['email'].",".$row['mobile'].",".$row['street'].",".$row['area'].",".$row['city'].",".$row['created_at']."\n";
}
echo $output;
exit;

?>