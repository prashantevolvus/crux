<?php
  require_once('../dbconn.php');


  $con=getConnection();
  $sql="
  select id,
  milestone, invoice_date, payment_date,ifnull(invoice_pcnt,0) invoice_pcnt,invoice_amount,milestone_desc
   from opp_invoices a
  where 1=1 ";

  $sql .= (!empty($_GET["oppid"])  ? "and a.opp_id = ".$_GET["oppid"] : "");
  $sql .= (!empty($_GET["invid"])  ? "and a.id = ".$_GET["invid"] : "");



  //echo $sql;

  $result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");
  $return_arr = array();
  $enc_arr = array();
  $final_arr=array();
  while($row = mysqli_fetch_array($result))
  {
     $enc_arr['milestone'] = $row['milestone'];
     $enc_arr['invoice_date'] = $row['invoice_date'];
     $enc_arr['payment_date'] = $row['payment_date'];
     $enc_arr['invoice_amount'] = $row['invoice_amount'];
     $enc_arr['invoice_pcnt'] = $row['invoice_pcnt'];
     $enc_arr['id'] = $row['id'];
     $enc_arr['milestone_desc'] = $row['milestone_desc'];


     $return_arr[]=$enc_arr;


  }
  $final_arr['data']=$return_arr;

  header('Content-Type: application/json');

  echo json_encode($final_arr);

?>
