<?php
require_once('../dbconn.php');
$log_file = "/Users/prashantm/development/GitHub/crux/my-errors.log";
ini_set("log_errors", TRUE);
ini_set('error_log', $log_file);

$insert_arr = array();


foreach ($_POST as $key => $value) {
        // If the field exists in the $fields array, include it in the email
        $insert_arr[$key] = $value;
    }

if($insert_arr["operation"] == "Add"){
    $sql = "INSERT INTO opp_invoices (
              opp_id, milestone, milestone_desc,
              invoice_date, payment_date, invoice_pcnt,
              invoice_amount
            )
            VALUES (
              '{$insert_arr["opportunity-id"]}','{$insert_arr["milestone"]}','{$insert_arr["milestone-desc"]}',
              '{$insert_arr["invoice-date"]}','{$insert_arr["payment-date"]}',
              '{$insert_arr["invoice-pcnt"]}','{$insert_arr["invoice-amount"]}')";
}
else if($insert_arr["operation"] == "Edit"){
  $sql = "UPDATE opp_invoices SET
            OPP_ID = '{$insert_arr["opportunity-id"]}',
            milestone = '{$insert_arr["milestone"]}',
            milestone_desc = '{$insert_arr["milestone-desc"]}',
            invoice_date =  '{$insert_arr["invoice-date"]}',
            payment_date = '{$insert_arr["payment-date"]}',
            invoice_pcnt = '{$insert_arr["invoice-pcnt"]}',
            invoice_amount = '{$insert_arr["invoice-amount"]}'
            WHERE id = '{$insert_arr["invoice-id"]}'
  ";

}
else if($insert_arr["operation"] == "Remove"){
    $sql = "delete from opp_invoices where id = '{$insert_arr["invoice-id"]}'";
}


error_log($sql);


$con=getConnection();


$result = mysqli_query($con,$sql) or error_log($sql."   failed  <br/><br/>");


$responseArray = array('type' => 'success', 'message' => 'Invoice Details Updated. ');

// if requested by AJAX request return JSON response
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}
// else just display the message
else {
    echo $responseArray['message'];
}
?>
