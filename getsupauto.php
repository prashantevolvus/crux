
<?php
require_once('dbconn.php');

$searchTerm = strtoupper($_GET['query'] ?? '');

$supervisor = ($_GET['supervisor'] ?? '')."asdfsdf";

if($supervisor == "Y")
	$jobSQL = " and custom4 is not null";
else
	$jobSQL = "";

$con=getOrangeConnection();
$sql="SELECT emp_number , concat(emp_firstname,' ',emp_lastname) emp_name, custom4  FROM hs_hr_employee
where emp_status not in (4,6) and upper(concat(emp_firstname,' ',emp_lastname)) like '%".$searchTerm."%' ".$jobSQL;
//echo $sql;
$result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>".mysql_error());
//$return_arr = array();
echo "<div class='jf-form'><form name='sd' id='sd' autocomplete='on'><select class='form-control' id='supervisor' name='supervisor' value=''  multiple >";
while($row = mysqli_fetch_array($result))
{

    $opt="<option value='" . $row['emp_number'] . "'>" . $row['emp_name'] . "</option>";
    echo $opt;
	//echo $row['emp_name'];
	//$data[] = array($row['emp_number'],$row['emp_name']);
	  // $row_array['id'] = $row['emp_number'];
       // $row_array['label'] = $row['emp_name'];
	//$data[] = $row['emp_name'];
	//array_push($return_arr,$row_array);
	/*  $return_arr[] = array (
            'value' => $row['emp_name'],
            'empno' => $row['emp_number'],
            'desig' => $row['custom4']
        );
	 */
}
echo "</select></form></div>";
//return json data
   // echo json_encode($return_arr);

?>
