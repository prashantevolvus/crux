<?php
require_once('../dbconn.php');

ini_set("log_errors", 1);
ini_set("error_log", "/tmp/myphp-error.log");



$q = isset($_GET["status"]) ? $_GET["status"] : '';
$q1= isset($_GET["expensetype"]) ? $_GET["expensetype"] : '';
$q2= isset($_GET["start"]) ? $_GET["start"] : '';
$q3= isset($_GET["end"]) ? $_GET["end"] : '';
$q4= isset($_GET["region"]) ? $_GET["region"] : '';


error_log( time()."GET q ".$q);
error_log( time()."GET q1 ".$q1);


$con=getConnection();
$sql =
"select region_grp,expense_type,gen_date,expense_det,expense_ccy,expense_amt_ccy,expense_amt_lcy,tran_status,a.id FROM
cgl_transaction_expense a
inner join opp_region b on a.opp_region_id = b.id
inner join cgl_region_grp d1 on b.cgl_grp_id = d1.id
inner join expense_type c on  a.expense_type_id = c.expense_id
where 1=1 "
.(!empty($q)? " and tran_status in (".$q.")" : " ")
.(!empty($q1)? " and expense_type_id in (".$q1.")" : " ")
.(!empty($q2)? " and gen_date >= '".$q2."'" : " ")
.(!empty($q3)? " and gen_date <= '".$q3."'" : " ")
.(!empty($q4)? " and d1.id in (".$q4.")" : " ")
." order by gen_date";

error_log( time()."GET ".$sql);

$result = mysqli_query($con,$sql) ;

$return_arr = array();
$enc_arr = array();
$final_arr=array();
while($row = mysqli_fetch_array($result))
{
  $enc_arr = $row;
  $return_arr[]=$enc_arr;


}

header('Content-Type: application/json');

echo json_encode($return_arr);

?>
