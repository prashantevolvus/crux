<?php
require_once('../dbconn.php');



$con=getConnection();
$sql="
select cr_id, cr_name from project_cr o where project_id = {$_GET['projid']}";


//echo $sql;

$result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");
$return_arr = array();
while($row = mysqli_fetch_array($result))
{
   $row_array['value'] = $row['cr_id'];
   $row_array['text'] = $row['cr_name'];
   array_push($return_arr,$row_array);
}

header('Content-Type: application/json');

    echo json_encode($return_arr);

?>
