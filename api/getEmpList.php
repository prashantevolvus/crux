<?php
require_once('../dbconn.php');



$con=getConnection();
$sql="
select emp_number, concat(emp_firstname,' ',emp_middle_name,' ',emp_lastname) emp_name from hr_mysql_live.hs_hr_employee where emp_status in (3,7)  order by 1
";
//echo $sql;

$result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");
$return_arr = array();
while($row = mysqli_fetch_array($result))
{
   $row_array['value'] = $row['emp_number'];
   $row_array['text'] = $row['emp_name'];
   array_push($return_arr,$row_array);
}
header('Content-Type: application/json');

    echo json_encode($return_arr);

?>
