<?php
require_once('dbconn.php');

$id = strtoupper($_GET['projid']);


$con=getConnection();
$sql="
SELECT a1.id , a1.project_name,
       o.name,
       Status
     FROM project_details a1
       INNER JOIN hr_mysql_live.ohrm_customer o
          ON a1.ohrm_customer_id = o.customer_id
          where  id = ".$id;
//echo $sql;

$result = mysqli_query($con,$sql) or debug($sql.$where."   failed  <br/><br/>".mysql_error());
$row = mysqli_fetch_array($result);
//echo $row['project_name'];
$return_arr = array (
            
            'projid' => $row['id'],
            'projname' => $row['project_name'],
            'cust' => $row['name'],
            'status' => $row['Status']
        );
	

    echo json_encode($return_arr);

?>
