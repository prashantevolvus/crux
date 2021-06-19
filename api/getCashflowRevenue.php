<?php
  require_once('../dbconn.php');


  $con=getConnection();
  $sql="
  select * from (
  select concat('I',a.invoice_id) idkey,b.project_name,a1.milestone_type,a.description,ifnull(region_name,'TOTAL') region_name , 'WON' Opp_Status,lcy_amount,expected_paid_date,
  '' change_paid_date,
  concat('M',
  -1*TIMESTAMPDIFF(MONTH,
  date_add(date_add(LAST_DAY(expected_paid_date),interval 1 DAY),interval -1 MONTH)  ,
  date_add(date_add(LAST_DAY(current_time),interval 1 DAY),interval -1 MONTH)) + 1) MX
  from project_invoice a
  inner join milestone a1 on a.mile_stone = a1.id
  inner join project_details b on a.project_id = b.id
  inner join hr_mysql_live.ohrm_customer c on b.ohrm_customer_id = c.customer_id
  inner join opp_region d on c.region_id = d.id
  inner join cgl_region_grp d1 on d.cgl_grp_id = d1.id
  where a.status <> 'PAID' and lcy_amount <> 0 and
  date_add(date_add(LAST_DAY(expected_paid_date),interval 1 DAY),interval -1 MONTH)  >=
  date_add(date_add(LAST_DAY(current_time),interval 1 DAY),interval -1 MONTH)
  union all
  select concat('O',b.id) idkey,opp_name,milestone,milestone_desc,region_grp, sales_stage, invoice_amount, payment_date,
  '' change_paid_date,
  concat('M',
  -1*TIMESTAMPDIFF(MONTH,
  date_add(date_add(LAST_DAY(payment_date),interval 1 DAY),interval -1 MONTH)  ,
  date_add(date_add(LAST_DAY(current_time),interval 1 DAY),interval -1 MONTH)) + 1) MX
   from opp_details a
  inner join opp_sales_stage a1 on a.sales_stage_id = a1.id
  inner join hr_mysql_live.ohrm_customer a2 on a.customer_id = a2.customer_id
  inner join opp_region d on a2.region_id = d.id
  inner join cgl_region_grp d1 on d.cgl_grp_id = d1.id
  inner join opp_invoices b on a.id = b.opp_id
  where sales_stage not in ('WON','LOST')
  and invoice_amount <> 0 and
  date_add(date_add(LAST_DAY(payment_date),interval 1 DAY),interval -1 MONTH)  >=
  date_add(date_add(LAST_DAY(current_time),interval 1 DAY),interval -1 MONTH)
  ) a where 1=1
   ";
   $sql .= (!empty($_GET["month"])  ? "and a.MX = '".$_GET["month"] ."'" : "");
   $sql .= (!empty($_GET["region"])  ? "and region_name in ( ".$_GET["region"] .")" : "");
   $sql .= (!empty($_GET["oppStatus"])  ? "and Opp_Status in ( ".$_GET["oppStatus"] .")" : "");

  // $sql .= (!empty($_GET["invid"])  ? "and a.id = ".$_GET["invid"] : "");



  //echo $sql;

  $result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");
  $return_arr = array();
  $enc_arr = array();
  $final_arr=array();
  while($row = mysqli_fetch_array($result))
  {

     $enc_arr = $row;
     $return_arr[]=$enc_arr;

  }
  $final_arr['data']=$return_arr;

  header('Content-Type: application/json');

  echo json_encode($return_arr);

?>
