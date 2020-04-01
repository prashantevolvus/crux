<?php
require_once('../dbconn.php');

$errorMessage = 'There was an error while adding the oppurtunity. Please try again.';
$okMessage = 'Oppurtunity successfully submitted.';

$insert_arr = array();


foreach ($_POST as $key => $value) {
        // If the field exists in the $fields array, include it in the email
        $insert_arr[$key] = $value;
    }






$con=getConnection();
  $sql='
  insert into opp_details (
    opp_name	,customer_id	, opp_det	,
    initial_quote	,current_quote	,no_regret_quote	,
    start_date	, expected_close_date	,
    Assigned_to	,sales_stage	,social_stage	,
    project_type_id	,base_product_id	,project_id	,
    change_request	,new_business	,
    proposal_set_path	, active
    )
    values (';

$chk = "'".
$insert_arr["oppname"]  ."',". $insert_arr["customer"]  .",'". $insert_arr["opptext"]    ."',".
$insert_arr["initAmt"]  .",". $insert_arr["currAmt"]   .",". $insert_arr["noRegAmt"]   .",'".
$insert_arr["startDate"]."','". $insert_arr["startDate"] ."',".
$insert_arr["assigned"] .",". $insert_arr["salesStage"].",". $insert_arr["socialStage"].",".
($insert_arr["projType"] ?? "null") .",". ($insert_arr["baseProd"] ?? "null") .",". ($insert_arr["proj"] ?? "null")      .",".
($insert_arr["typeOppur"] == 1? 0 : 1).",". ($insert_arr["newExisting"] == 1? 1 : 0).",'".
$insert_arr["propPath"]."',1)";
$sql .= $chk;


$result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");

$newid=0;
$newid = mysqli_insert_id($con);

$responseArray = array('type' => 'success', 'message' => 'Oppurtunity Successfully created. ','navigate' =>'viewOppurtunity.php?oppid='.$newid);

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
