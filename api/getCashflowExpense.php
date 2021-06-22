<?php
  require_once('../dbconn.php');


  $con=getConnection();
  $sql="
  SELECT a.id idkey,gen_date,
concat('M',
  -1*TIMESTAMPDIFF(MONTH,
  date_add(date_add(LAST_DAY(gen_date),interval 1 DAY),interval -1 MONTH)  ,
  date_add(date_add(LAST_DAY(current_time),interval 1 DAY),interval -1 MONTH)) + 1) MX,
region_name,
expense_det,expense_amt_lcy,remarks,tran_status,'' change_expense_date
  FROM
cgl_transaction_expense a
join opp_region b on a.opp_region_id = b.id
where tran_status not in ('DELETED','PAID') and  1=1
   ";
   $sql .= (!empty($_GET["month"])  ? "and a.MX = '".$_GET["month"] ."'" : "");
   $sql .= (!empty($_GET["region"])  ? "and region_name in ( ".$_GET["region"] .")" : "");
   if(!empty($_GET["ignorePast"]) && $_GET["ignorePast"]=="true"){
     $sql .= "and gen_date >= date_add(date_add(LAST_DAY(current_time),interval 1 DAY),interval -1 MONTH)";
   }
  // $sql .= (!empty($_GET["invid"])  ? "and a.id = ".$_GET["invid"] : "");

$sql .= " order by gen_date ";

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
