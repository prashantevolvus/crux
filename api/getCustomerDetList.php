<?php
  require_once('../dbconn.php');
  // $log_file = "/Users/prashantm/development/GitHub/crux/my-errors.log";
  // ini_set("log_errors", TRUE);
  // ini_set('error_log', $log_file);

  $con=getConnection();
  $sql="
  select customer_id, name, description , region_name,case when is_deleted = 1 then 'DELETED' else 'ACTIVE' end active
    from hr_mysql_live.ohrm_customer a
   inner join opp_region b on a.region_id = b.id
  where
  1=1 ";

  $sql .= (!empty($_GET["region"])  ? " and a.region_id = ".$_GET["region"] : "");
  $sql .= ((!empty($_GET["delStatus"]) && $_GET["delStatus"] = "A") ? " and is_deleted = 0"  : "");

// error_log((!empty($_GET["delStatus"]) && $_GET["delStatus"] == "A" ? "and is_deleted = 0"  : "EMPTY"));
//   error_log($sql);

  //echo $sql;

  $result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");
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
