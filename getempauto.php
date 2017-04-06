<?php
require_once('dbconn.php');

$searchTerm = strtoupper($_GET['query']);

$supervisor = $_GET['supervisor'];

if($supervisor == "Y")
	$jobSQL = " and custom4 is not null";
else 
	$jobSQL = ""; 

$con=getOrangeConnection();
$sql="SELECT emp_number , concat(emp_firstname,' ',emp_lastname) emp_name, custom4  FROM hs_hr_employee 
where emp_status not in (4,6) and upper(concat(emp_firstname,' ',emp_lastname)) like '%".$searchTerm."%' ".$jobSQL;

$result = mysqli_query($con,$sql.$where) or debug($sql.$where."   failed  <br/><br/>".mysql_error());
$return_arr = array();
while($row = mysqli_fetch_array($result))
{
	
	 $return_arr[] = array (
            'value' => $row['emp_name'],
            'empno' => $row['emp_number'],
            'desig' => $row['custom4']
        );
	
}
    echo json_encode($return_arr);
closeConnection($con);

?>
