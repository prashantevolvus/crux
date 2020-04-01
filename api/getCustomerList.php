<?php
require_once('../dbconn.php');



$con=getConnection();
$sql="
select customer_id, name from hr_mysql_live.ohrm_customer where is_deleted = 0 order by name
";
//echo $sql;

$result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");
$return_arr = array();
while($row = mysqli_fetch_array($result))
{
   $row_array['id'] = $row['customer_id'];
   $row_array['name'] = $row['name'];
   array_push($return_arr,$row_array);
}

header('Content-Type: application/json');

    echo json_encode($return_arr);

?>
