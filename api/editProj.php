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

$projid = $_POST['pk'];

// $fld = '2B1';
// $val = 'UK DM DMDM DMDM DM';
// $oppid =12;
//Array mapping of UI field to database field
$arr = array("G1B1"=>"project_details", "G2B1"=>"objectives",
             "G1B2"=>"scope", "G2B2"=>"success_factor",
             "G4B1"=>"ssn_no","G5B1"=>"ccy_code"

          );




$sql = "update project_details set ";
$sql .= $arr[$fld]." = '".$val."' , project_modified_on = CURRENT_TIMESTAMP , project_modified_by = ".$_SESSION["userempno"]." where id = ".$projid;

error_log($sql);


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
