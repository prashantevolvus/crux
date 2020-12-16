<?php
require_once('../dbconn.php');

 // $log_file = "/Users/prashantm/development/GitHub/crux/my-errors.log";
 // ini_set("log_errors", TRUE);
 // ini_set('error_log', $log_file);

$errorMessage = 'There was an error while editing the opportunity. Please try again.';
$okMessage = 'Opportunity successfully Edited';

$fld = $_POST['name'];
$val = $_POST['value'];
$custid = $_POST['pk'];
$db = isset($_POST['db'])?$_POST['db']:"orange";

// $fld = '2B1';
// $val = 'UK DM DMDM DMDM DM';
// $oppid =12;
//Array mapping of UI field to database field
$arr = array("2B1"=>"name", "3B1"=>"description",
             "1B1"=>"region_id", "4B1"=>"is_deleted",
             "2B2"=>"gst_no", "3B2"=>"trn_no", "1B2"=>"name_on_invoice",
             "2B3"=>"to_add2", "3B3"=>"to_add3", "1B3"=>"to_add1",
             "2B4"=>"ship_add2", "3B4"=>"ship_add3", "1B4"=>"ship_add1"

           );

if($db == "orange"){
  $sql = "update hr_mysql_live.ohrm_customer set ";
  $sql .= $arr[$fld]." = '".$val."' where customer_id = ".$custid;
}
if($db == "crux"){
  $sql = "update cust_details set ";
  $sql .= $arr[$fld]." = '".$val."' where ohrm_customer_id = ".$custid;
}


 // error_log($sql);



$con=getConnection();

$result = mysqli_query($con, $sql) or debug($sql."   failed  <br/><br/>");
