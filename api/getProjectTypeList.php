<?php
require_once('../dbconn.php');



$con=getConnection();
$sql="
select project_type_id, project_type from project_type order by project_type ";


//echo $sql;

$result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");
$return_arr = array();
while($row = mysqli_fetch_array($result))
{
   $row_array['value'] = $row['project_type_id'];
   $row_array['text'] = $row['project_type'];
   array_push($return_arr,$row_array);
}
header('Content-Type: application/json');

    echo json_encode($return_arr);

?>
