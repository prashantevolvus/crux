<?php
session_name("Project");
session_start();
require_once('../dbconn.php');
 // $log_file = "/Users/prashantm/development/GitHub/crux/my-errors.log";
 // ini_set("log_errors", TRUE);
 // ini_set('error_log', $log_file);


$errorMessage = 'There was an error while editing the opportunity. Please try again.';
$okMessage = 'Opportunity successfully Edited';



$expid =  $_POST["expense-id-cr"];
$transtatus = $_POST["transtatus-cr"];

$expAmt = $_POST["expense-amount-cr"];
$expAmtLCY = $_POST["expense-amount-lcy-cr"];
$expDt = $_POST["expense-date-cr"];
$expDet = $_POST["expense-detail-cr"];
$region = $_POST["region-cr"];

$expType = $_POST["expense-type-cr"];
$expPNL = $_POST["pnl-line-cr"];
$expPC = $_POST["profit-centre-cr"];
$expDE = $_POST["direct-expense-cr"]=="on"?1:0;
$expCapex = $_POST["capex-cr"]=="on"?1:0;
$expRemarks = $_POST["remarks-cr"];
$expCCY = $_POST["expense-ccy-cr"];


if($_POST["operation"] == "EditStatus"){

  $sql = "update cgl_transaction_expense set tran_status = '{$transtatus}' where id = {$expid}";
}
if($_POST["operation"] == "CreateTran"){
  $sql = "
    insert into cgl_transaction_expense
      (
        expense_type_id, expense_det, expense_ccy , expense_amt_ccy , expense_amt_lcy,
        pnl_line_id,direct_expense,capex,opp_region_id, pc_id,remarks,gen_date, tran_status
      )
    values
    (
      {$expType},'{$expDet}','{$expCCY}',{$expAmt},{$expAmtLCY},
      {$expPNL},{$expDE},{$expCapex} , {$region},{$expPC},'{$expRemarks}','{$expDt}','{$transtatus}'
    )
  ";
}
if($_POST["operation"] == "EditTran"){


  $sql = "update cgl_transaction_expense
            set
              expense_type_id = {$expType} ,
              expense_ccy     = '{$expCCY}' ,
              expense_det     = '{$expDet}' ,
              gen_date        = '{$expDt}',
              expense_amt_ccy = {$expAmt},
              expense_amt_lcy = {$expAmtLCY},
              tran_status     = '{$transtatus}',
              opp_region_id   = {$region},
              pnl_line_id     = {$expPNL},
              direct_expense  = {$expDE},
              capex           = {$expCapex},
              pc_id           = {$expPC},
              remarks         = '{$expRemarks}'

      where id = {$expid}";

}

$con=getConnection();

$result = mysqli_query($con,$sql) ;

if($result){
  echo "SUCCESS";
}
else{
  echo "FAIL".$sql;
}



?>
