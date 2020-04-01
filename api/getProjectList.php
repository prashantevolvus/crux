<?php
require_once('../dbconn.php');

$custid=$_GET["cust"] ?? '';

$con=getConnection();
$sql="
select id, project_name from project_details
inner join hr_mysql_live.ohrm_customer on customer_id = ohrm_customer_id
where status <> 'CLOSED' ";

$sql .= empty($custid) ? "" : " and customer_id = ".$custid;


$sql .= " order by project_name";
//echo $sql;

$result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");
$return_arr = array();
while($row = mysqli_fetch_array($result))
{
   $row_array['id'] = $row['id'];
   $row_array['name'] = $row['project_name'];
   array_push($return_arr,$row_array);
}
header('Content-Type: application/json');

    echo json_encode($return_arr);

?>
