<?php
require_once('../dbconn.php');



$con=getConnection();
$sql="
select id, social_stage from opp_social_stage o ";


//echo $sql;

$result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");
$return_arr = array();
while($row = mysqli_fetch_array($result))
{
   $row_array['value'] = $row['id'];
   $row_array['text'] = $row['social_stage'];
   array_push($return_arr,$row_array);
}

header('Content-Type: application/json');

    echo json_encode($return_arr);

?>
