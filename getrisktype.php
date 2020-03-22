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
$sql="SELECT risk_type_id,risk_type FROM risk_type ";
$result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>".mysql_error());

echo "<select id='risk' name='risk' value='' autofocus> <option value='Choose..' selected='selected'>Choose...</option>";

while($row = mysqli_fetch_array($result))
  {
	$opt="<option value='" . $row[risk_type_id] . "'>" . $row[risk_type] . "</option>";
       echo $opt;
  }
echo "</select>";



closeConnection($con);

?>
