<?php
session_name("Project");
session_start();
require_once 'dbconn.php';
if(!checkUserSession($_SESSION["user"]))
{
        echo "<script>window.top.location.href='login.php'</script>";
        //header("Location:login.php");
}

$q=$_GET["q"];
$con=getConnection();
//Please uncomment once old expense has been entered
$sql="
select getempname(stakeholder_emp_id) stake_name from project_stakeholder a";
	$sql .= " where a.project_id = '".$q."' ";
$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
echo "<table border='0' id='stake'>";

echo "<br><tr>";
echo "<td><b>Stake Holder</b></td>";
echo "<td align='left'><b>Operations</b></td>";
echo "</tr>";
while($row = mysqli_fetch_array($result))
  {
	echo "<tr>";

        echo "<td>$row[stake_name]</td>";
	echo "</tr>";
  }
echo "</table>";
closeConnection($con);
?>
