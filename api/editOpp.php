<?php
require_once('../dbconn.php');

$errorMessage = 'There was an error while editing the opportunity. Please try again.';
$okMessage = 'Opportunity successfully Edited';

$fld = $_POST['name'];
$val = $_POST['value'];
$oppid = $_POST['pk'];

// $fld = '2B1';
// $val = 'UK DM DMDM DMDM DM';
// $oppid =12;
//Array mapping of UI field to database field
$arr = array("2B1"=>"opp_name", "1B4"=>"opp_det",
             "4B1"=>"active", "3B1"=>"customer_id",
             "5B1"=>"proposal_set_path", "1B2"=>"initial_quote",
             "2B2"=>"current_quote", "3B2"=>"no_regret_quote",
             "1B5"=>"sales_stage_id", "2B5"=>"social_stage_id",
             "3B5"=>"assigned_to",
             "5B5"=>"start_date", "5B5"=>"expected_close_date",
             "1B3A"=>"project_type_id", "2B3A"=>"base_product_id",
             "3B3A"=>"new_business", "1B3B"=>"project_id"

          );

$sql = "update opp_details set ";
$sql .= $arr[$fld]." = '".$val."' where id = ".$oppid;




$con=getConnection();

$result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");


?>
