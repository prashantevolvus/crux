<?php
session_name("Project");
session_start();

require_once('../dbconn.php');

 // $log_file = "/Users/prashantm/development/GitHub/crux/my-errors.log";
 // ini_set("log_errors", TRUE);
 // ini_set('error_log', $log_file);
 $status = $_POST['status'];
 $projid = $_POST['projid'];

 if(checkProjectPermission("UPDATE") == false){
   $errtx = 'No permission for employee no '.session_id() ;
   $responseArray = array('type' => 'danger', 'message' =>  $errtx, 'projid'=>$projid, 'status'=>$status);
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

$sql = "select ohrm_project_id from project_details where id = {$projid}" ;
$result = mysqli_query($con,$sql);
if ($row = mysqli_fetch_array($result)) {
    $ohrmid = $row['ohrm_project_id'];
}



$sql = "update project_details set status = '{$status}' where id = {$projid}" ;

 // error_log($sql);


$ostatus = 1;

if (mysqli_query($con, $sql)) {
  if($status == "ACTIVE")
    $ostatus = 0;
  $osql = "update ohrm_project set  is_deleted='{$ostatus}' where project_id = {$ohrmid}";
  $conO=getOrangeConnection();
  if (mysqli_query($conO, $osql)) {
    $dt =  "Status updated successfully";
    $typ = "success";
  } else {
    $dt = "Error updating Status: " . mysqli_error($conO);
    $typ = "danger";
  }
  mysqli_close($conO);

} else {
      $dt = "Error updating Status: " . mysqli_error($con);
      $typ = "danger";

}

mysqli_close($con);
$responseArray = array('type' => $typ, 'message' => $dt , 'projid'=>$projid, 'status'=>$status);
// if requested by AJAX request return JSON response
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');
    // error_log($encoded);

    echo $encoded;
}
