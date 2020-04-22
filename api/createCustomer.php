<?php
require_once('../dbconn.php');

$errorMessage = 'There was an error while adding the Customer. Please try again.';
$okMessage = 'Customer successfully submitted.';

$insert_arr = array();


foreach ($_POST as $key => $value) {
    // If the field exists in the $fields array, include it in the email
    $insert_arr[$key] = $value;
}






$con=getOrangeConnection();
  $sql="
  insert into ohrm_customer (
    name,description,region_id,is_deleted
    )
    values ('{$insert_arr["customer"]}','{$insert_arr["custdet"]}',{$insert_arr["region"]},0)
      ";



$result = mysqli_query($con, $sql) or debug($sql."   failed  <br/><br/>");

$newid=0;
$newid = mysqli_insert_id($con);

$responseArray = array('type' => 'success', 'message' => 'Customer Successfully created. ','navigate' =>'viewCustomer.php?custid='.$newid);

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
