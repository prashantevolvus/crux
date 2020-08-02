<?php
require_once('../dbconn.php');



$con=getConnection();

if($_GET["type"] == "EXP")
  $sql="select expense_id, expense_type from expense_type o ";


//echo $sql;

$result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");
$return_arr = array();
while($row = mysqli_fetch_array($result))
{
   $row_array['value'] = $row['expense_id'];
   $row_array['text'] = $row['expense_type'];
   array_push($return_arr,$row_array);
}
header('Content-Type: application/json');

    echo json_encode($return_arr);

?>
