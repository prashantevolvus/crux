<?php
require_once('../dbconn.php');



$con=getConnection();

if($_GET["type"] == "EXP")
  $sql="select expense_id id, expense_type value from expense_type o ";
if($_GET["type"] == "RGN")
    $sql="select id, region_grp value from cgl_region_grp o ";


//echo $sql;

$result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");
$return_arr = array();
while($row = mysqli_fetch_array($result))
{
   $row_array['value'] = $row['id'];
   $row_array['text'] = $row['value'];
   array_push($return_arr,$row_array);
}
header('Content-Type: application/json');

    echo json_encode($return_arr);

?>
