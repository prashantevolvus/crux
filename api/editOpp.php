<?php
session_name("Project");
session_start();
require_once('../dbconn.php');
 // $log_file = "/Users/prashantm/development/GitHub/crux/my-errors.log";
 // ini_set("log_errors", TRUE);
 // ini_set('error_log', $log_file);


$errorMessage = 'There was an error while editing the opportunity. Please try again.';
$okMessage = 'Opportunity successfully Edited';

$fld = $_POST['name'];
$val = $_POST['value'];
$originalVal = $_POST['originalValue'];

$oppid = $_POST['pk'];

// $fld = '2B1';
// $val = 'UK DM DMDM DMDM DM';
// $oppid =12;
//Array mapping of UI field to database field
$arr = array("2B1"=>"opp_name", "1B4"=>"opp_det",
             "4B1"=>"active", "44B1"=>"watch", "3B1"=>"customer_id",
             "5B1"=>"proposal_set_path", "1B2"=>"initial_quote",
             "2B2"=>"current_quote", "3B2"=>"no_regret_quote",
             "1B5"=>"sales_stage_id", "2B5"=>"social_stage_id",
             "3B5"=>"assigned_to",
             "4B5"=>"start_date", "5B5"=>"expected_close_date",
             "1B3A"=>"project_type_id", "2B3A"=>"base_product_id",
             "3B3A"=>"new_business", "1B3B"=>"project_id"

          );




$sql = "update opp_details set ";
$sql .= $arr[$fld]." = '".$val."' , modified_on = CURRENT_TIMESTAMP , modified_by = ".$_SESSION["userempno"]." where id = ".$oppid;



$con=getConnection();

$result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");

//IF THE SALES STAGE IS CHANGED THEN WE MUST CHANGE THE ACTIVE STATE AS WELL
if($arr[$fld] == "sales_stage_id") {


  $sql = "select active_stage , watch from opp_sales_stage a
   inner join opp_details b on a.id = b.sales_stage_id and b.id = {$oppid}
  where a.id = {$val}";


  $result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");
  list($active, $watch) = mysqli_fetch_array($result);

  if(!$active)
    $watch = $active;

  $sql = "update opp_details set active = {$active} , watch = {$watch} where id = {$oppid}";

  $result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");

  $responseArray = array('active' => $active,'watch' => $watch);

  $encoded = json_encode($responseArray);
  header('Content-Type: application/json');
  echo $encoded;

}

//IF THE NO REGRET AMOUNT IS CHANGED THEN WE MUST CHANGE THE MILESTONE AMOUNT AS WELL
if($arr[$fld] == "no_regret_quote") {
  $sql = "update opp_invoices set invoice_amount=invoice_pcnt*{$val}/100 where opp_id = {$oppid}";
  $result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");

  $responseArray = array('update' => 'success');
  $encoded = json_encode($responseArray);
  header('Content-Type: application/json');
  echo $encoded;

}


//IF THE EXPECTED CLOSE DATE  IS CHANGED THEN WE MUST CHANGE THE MILESTONE DATE AS WELL
if($arr[$fld] == "expected_close_date") {
  $diff = round((strtotime($val) - strtotime($originalVal))/86400);

  $sql = "update opp_invoices set
      invoice_date = DATE_ADD(invoice_date, INTERVAL {$diff} DAY),
      payment_date = DATE_ADD(payment_date, INTERVAL {$diff} DAY)
   where opp_id = {$oppid}";
  $result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");



}


?>
