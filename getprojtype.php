<?php
session_start();
require_once('dbconn.php');
if(!checkUserSession($_SESSION["user"]))
{
        echo "<script>window.top.location.href='login.php'</script>";
        //header("Location:login.php");
}

$con=getConnection();
$sql="SELECT project_type_id,project_type FROM project_type ";
$result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>".mysql_error());

echo "<select id='projtype' name='projtype' value=''  onchange=showCustomer() autofocus> <option value='Choose..' selected='selected'>Choose...</option>";

while($row = mysqli_fetch_array($result))
  {
	$opt="<option value='" . $row[project_type_id] . "'>" . $row[project_type] . "</option>";
       echo $opt;
  }
echo "</select>";



closeConnection($con);

?>
