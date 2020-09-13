<?php
require_once('../dbconn.php');


$con=getConnection();
$sql =
"select region_grp,expense_type,gen_date,expense_det,expense_ccy,expense_amt_ccy,expense_amt_lcy,tran_status,a.id FROM
cgl_transaction_expense a
inner join opp_region b on a.opp_region_id = b.id
inner join cgl_region_grp d1 on b.cgl_grp_id = d1.id
inner join expense_type c on  a.expense_type_id = c.expense_id

where 1=1 ".(!empty($_GET["expid"])  ? "and a.id = ".$_GET["expid"] : "and a.id = 1");


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
