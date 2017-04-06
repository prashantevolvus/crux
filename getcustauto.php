<?php
require_once 'dbconn.php';

$searchTerm = strtoupper($_GET['query']);

$con=getOrangeConnection();

$sql="SELECT customer_id,name FROM ohrm_customer where is_deleted = 0 and name like '%".$searchTerm."%' ";
$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());

$return_arr = array();

while($row = mysqli_fetch_array($result))
  {
	
	$return_arr[] = array (
            'value' => $row['name'],
            'id' => $row['customer_id']
    );
  }

echo json_encode($return_arr);

closeConnection($con);
?>
