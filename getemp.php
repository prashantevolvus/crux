<?php
require_once('dbconn.php');
session_name("Project");
session_start();
if(!checkUserSession($_SESSION["user"]))
{
        echo "<script>window.top.location.href='login.php'</script>";
        //header("Location:login.php");
}

$x=$_GET['q'];

$con=getOrangeConnection();
$sql="SELECT emp_number , concat(emp_firstname,' ',emp_lastname) emp_name FROM hs_hr_employee where emp_status not in (4,6) ";
if($x=="pm")
	$where=" and custom4 in('All','Manager','Authoriser') order by emp_firstname";
else if($x=="pd")
	$where=" and custom4 in('All','Authoriser') order by emp_firstname";
else if($x=="all")
	$where=" and custom4 in('All','Authoriser','Manager') order by emp_firstname";

$result = mysqli_query($con,$sql.$where) or debug($sql.$where."   failed  <br/><br/>".mysql_error());
echo "<select id='$x' name='$x' value=''  > <option value='Choose..' selected='selected'>Choose...</option> ";

while($row = mysqli_fetch_array($result))
  {
	$opt="<option value='" . $row[emp_number] . "'>" . $row[emp_name] . "</option>";
       echo $opt;
  }
echo "</select>";
closeConnection($con);

?>
