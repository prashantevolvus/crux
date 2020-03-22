<?php
require_once('dbconn.php');

$searchTerm = $_GET['query'];

$con=getOrangeConnection();
$sql="SELECT emp_number , concat(emp_firstname,' ',emp_lastname) emp_name, custom4  FROM hs_hr_employee 
where emp_status not in (4,6) and concat(emp_firstname,' ',emp_lastname) like '%".$searchTerm."%'";
//echo $sql;
$result = mysqli_query($con,$sql.$where) or debug($sql.$where."   failed  <br/><br/>".mysql_error());
$return_arr = array();
while($row = mysqli_fetch_array($result))
{
	//echo $row['emp_name'];
	//$data[] = array($row['emp_number'],$row['emp_name']);
	  // $row_array['id'] = $row['emp_number'];
       // $row_array['label'] = $row['emp_name'];
	//$data[] = $row['emp_name'];
	//array_push($return_arr,$row_array);
	 $return_arr[] = array (
            'value' => $row['emp_name'],
            'empno' => $row['emp_number'],
            'desig' => $row['custom4']
        );
	
}
//return json data
    echo json_encode($return_arr);

?>
