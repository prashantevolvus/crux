<?php
require_once('../dbconn.php');



$con=getConnection();
$sql="
select id, file_type from file_type o ";


//echo $sql;

$result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");
$return_arr = array();
while($row = mysqli_fetch_array($result))
{
   $row_array['value'] = $row['id'];
   $row_array['text'] = $row['file_type'];
   array_push($return_arr,$row_array);
}
header('Content-Type: application/json');

    echo json_encode($return_arr);

?>
