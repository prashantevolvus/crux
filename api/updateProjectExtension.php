<?php
session_name("Project");
session_start();

require_once('../dbconn.php');

 // $log_file = "/Users/prashantm/development/GitHub/crux/my-errors.log";
 // ini_set("log_errors", TRUE);
 // ini_set('error_log', $log_file);
 $extension = $_POST['extension'];
 $projid = $_POST['projid'];

 if(checkProjectPermission("UPDATE") == false){
   $errtx = 'No permission for employee no '.session_id() ;
   $responseArray = array('type' => 'danger', 'message' =>  $errtx, 'projid'=>$projid, 'Extension'=>extension);
   // if requested by AJAX request return JSON response
   if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
       $encoded = json_encode($responseArray);

       header('Content-Type: application/json');
       // error_log($encoded);

       echo $encoded;
   }

   return;

 }

$errorMessage = 'There was an error while editing the project. Please try again.';
$okMessage = 'Project successfully Edited';


$con=getConnection();




$sql = "update project_details set extension = '{$extension}' where id = {$projid}" ;

 // error_log($sql);


if (mysqli_query($con, $sql)) {
    $dt =  "Extension updated successfully";
    $typ = "success";
} else {
  $dt = "Error updating Extension: " . mysqli_error($conO);
  $typ = "danger";
}


mysqli_close($con);
$responseArray = array('type' => $typ, 'message' => $dt , 'projid'=>$projid, 'extension'=>$extension);
// if requested by AJAX request return JSON response
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');
    // error_log($encoded);

    echo $encoded;
}
