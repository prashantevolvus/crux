<?php
session_name("Project");
session_start();
require_once('dbconn.php');
if(!checkUserSession($_SESSION["user"]))
{
        echo "<script>window.top.location.href='login.php'</script>";
        //header("Location:login.php");
}


$con=getConnection();

$con=getOrangeConnection();
$sql="SELECT emp_number , concat(emp_firstname,' ',emp_lastname) emp_name FROM hs_hr_employee where emp_status not in (4,6) order by emp_firstname";
$result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>".mysql_error());

echo "<select class='field select' id='emp' name='emp' value='' onChange=showCustomer() >  <option value='Choose..' selected='selected'>Choose...</option>";

while($row = mysqli_fetch_array($result))
  {
	$opt="<option value='" . $row[emp_number] . "'>" . $row[emp_name] . "</option>";
       echo $opt;
  }
echo "</select>";
closeConnection($con);

?>
