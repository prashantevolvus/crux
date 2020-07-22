<?php
  require_once('../dbconn.php');


  $con=getConnection();
  $sql="
    select query_string from cgl_query where id = {$_GET['qryid']}";


  $result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");
  while($row = mysqli_fetch_array($result))
  {
    $glQry = $row['query_string'];
  }

  $result = mysqli_query($con,$glQry) or debug($glQry."   failed  <br/><br/>");



  $return_arr = array();
  $enc_arr = array();
  $final_arr=array();
  while($row = mysqli_fetch_array($result))
  {

     $enc_arr = $row;
     $return_arr[]=$enc_arr;

  }
  $final_arr['data']=$return_arr;

  header('Content-Type: application/json');

  echo json_encode($final_arr);

?>
