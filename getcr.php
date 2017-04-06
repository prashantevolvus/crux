<?php
session_name("Project");
session_start();
require_once('dbconn.php');
if(!checkUserSession($_SESSION["user"]))
{
        echo "<script>window.top.location.href='login.php'</script>";
        //header("Location:login.php");
}
$q=$_GET["q"];

$con=getConnection();
$sql="SELECT cr_id, cr_name FROM project_cr where status = 'ACCEPTED' and project_id = ".$q;
$result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>".mysql_error());

echo "<select id='crid' name='crid' value='' autofocus> <option value='' selected='selected'>Choose...</option>";

while($row = mysqli_fetch_array($result))
  {
	$opt="<option value='" . $row[cr_id] . "'>" . $row[cr_name] . "</option>";
       echo $opt;
  }
echo "</select>";



closeConnection($con);

?>
