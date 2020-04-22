<?php
require_once('../dbconn.php');


$con=getConnection();
$sql="
select customer_id,
name cust_name	, description cust_det, region_id ,is_deleted
 from hr_mysql_live.ohrm_customer a
inner join opp_region b on a.region_id = b.id
where 1=1 ".(!empty($_GET["custid"])  ? "and customer_id = ".$_GET["custid"] : "and customer_id = 1");


//echo $sql;

$result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");
$return_arr = array();
while($row = mysqli_fetch_assoc($result))
{
   $return_arr[] = $row;

}
header('Content-Type: application/json');

    echo json_encode($return_arr);

?>
