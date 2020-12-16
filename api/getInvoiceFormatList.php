<?php
require_once('../dbconn.php');



$con=getConnection();
$sql="
select id, format_name from invoice_format order by id  ";


//echo $sql;

$result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");
$return_arr = array();
while($row = mysqli_fetch_array($result))
{
   $row_array['value'] = $row['id'];
   $row_array['text'] = $row['format_name'];
   array_push($return_arr,$row_array);
}
header('Content-Type: application/json');

    echo json_encode($return_arr);

?>
