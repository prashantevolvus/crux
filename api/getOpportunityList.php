<?php
require_once('../dbconn.php');




$q = isset($_GET["active"]) ? $_GET["active"] : '';
$q1= isset($_GET["salesstage"]) ? $_GET["salesstage"] : '';



$con=getConnection();
$sql =
"select a.id, opp_name, b.name,current_quote,no_regret_quote,start_date,expected_close_date,
sales_stage, concat(emp_firstname,' ',emp_middle_name,' ',emp_lastname) opp_owner
from opp_details a
inner join hr_mysql_live.ohrm_customer b on a.customer_id = b.customer_id
inner join hr_mysql_live.hs_hr_employee e on a.assigned_to = e.emp_number
inner join opp_sales_stage c on a.sales_stage_id = c.id
where 1=1 "
.(!empty($q)? " and a.active = 1":" ")
.(is_numeric($q1)? " and sales_stage_id in (".$q1.")" : " ")
." order by c.id,current_quote desc";

$result = mysqli_query($con,$sql) ;

$return_arr = array();
$enc_arr = array();
$final_arr=array();
while($row = mysqli_fetch_array($result))
{
   $enc_arr['name'] = $row['name'];
   $enc_arr['opp_name'] = $row['opp_name'];

   setlocale(LC_MONETARY, 'en_US');
   $amt=number_format($row['current_quote'],0);
   $enc_arr['current_quote'] = $amt;

   setlocale(LC_MONETARY, 'en_US');
   $amt=number_format($row['no_regret_quote'],0);
   $enc_arr['no_regret_quote'] = $amt;

   $sortDate = strtotime($row['start_date']);
   $dt = date("d-M-Y", strtotime($row['start_date']));
   $enc_arr['start_date'] = $dt;

   $sortDate = strtotime($row['expected_close_date']);
   $dt = date("d-M-Y", strtotime($row['expected_close_date']));
   $enc_arr['expected_close_date'] = $dt;
   $enc_arr['opp_owner'] = $row['opp_owner'];


   $enc_arr['sales_stage'] = $row['sales_stage'];
   $enc_arr['id'] = $row['id'];



   $return_arr[]=$enc_arr;


}
$final_arr['data']=$return_arr;

header('Content-Type: application/json');

echo json_encode($final_arr);

?>
