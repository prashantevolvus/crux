<?php
$q=$_GET["q"];
require_once 'dbconn.php';
require 'db_inc.php';
//$con=getOrangeConnection();
$con=mysqli_connect($db_host,$db_user,$db_password);
$sql ="select o.project_id,o.name from hr_mysql_live.ohrm_project o join (select a.project_name from project_management.project_details a join hr_mysql_live.ohrm_customer d on a.ohrm_customer_id=d.customer_id where status in ('Active', 'Deactivated')) pd on o.name=pd.project_name where customer_id = ".$q." order by name;";
//Please uncomment once old expense has been entered
//$sql="select project_id , name from ".$db_orangehrm.".ohrm_project where customer_id = ".$q." order by name ";
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

