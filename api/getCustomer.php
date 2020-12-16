<?php
require_once('../dbconn.php');


$con=getConnection();
$sql="
select customer_id,
name cust_name	, description cust_det, region_id ,is_deleted,
name_on_invoice, to_add1, to_add2, to_add3, ship_add1, ship_add2, ship_add3,
trn_no, gst_no
 from hr_mysql_live.ohrm_customer a
inner join opp_region b on a.region_id = b.id
left join cust_details c on a.customer_id = c.ohrm_customer_id
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
