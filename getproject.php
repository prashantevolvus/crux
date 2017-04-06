<?php
$q=$_GET["q"];
require_once 'dbconn.php';

$con=getOrangeConnection();
//Please uncomment once old expense has been entered
$sql="select project_id , name from ohrm_project where is_deleted = 0 and customer_id = ".$q." order by name ";
//$sql="select project_id , name from ohrm_project where  customer_id = ".$q." order by name ";

$result = mysqli_query($con,$sql) or die($sql."<br/><br/>".mysql_error());
echo "<select class='field select' id='proj' name='proj' value='' onchange=showBudget(this.value)>   <option value='Choose..' selected='selected'>Choose...</option>";

while($row = mysqli_fetch_array($result))
  {
	$opt="<option value='" . $row[project_id] . "'>" . $row[name] . "</option>";
       echo $opt;
  }
echo "</select>";
closeConnection($con);
?>
