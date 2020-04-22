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

// $fld = '2B1';
// $val = 'UK DM DMDM DMDM DM';
// $oppid =12;
//Array mapping of UI field to database field
$arr = array("2B1"=>"name", "3B1"=>"description",
             "1B1"=>"region_id", "4B1"=>"is_deleted");

$sql = "update hr_mysql_live.ohrm_customer set ";
$sql .= $arr[$fld]." = '".$val."' where customer_id = ".$custid;

 // error_log($sql);



$con=getConnection();

$result = mysqli_query($con, $sql) or debug($sql."   failed  <br/><br/>");
