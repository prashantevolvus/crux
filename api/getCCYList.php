<?php
require_once('../dbconn.php');



$con=getConnection();
$sql="
select ccy_code, ccy_desc from currency order by ccy_code  ";


//echo $sql;

$result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");
$return_arr = array();
while($row = mysqli_fetch_array($result))
{
   $row_array['value'] = $row['ccy_code'];
   $row_array['text'] = $row['ccy_desc'];
   array_push($return_arr,$row_array);
}
header('Content-Type: application/json');

    echo json_encode($return_arr);

?>
