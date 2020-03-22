<?php
session_name("Project");
session_start();

require 'dbconn.php';
if(!checkUserSession($_SESSION["user"]))
{
        echo "<script>window.top.location.href='login.php'</script>";
        //header("Location:login.php");
}

$q=$_GET["q"];

$con=getConnection();
echo "<table cellspacing='5'>";
echo "<tr valign=top>";

echo "<td>";
$sql="
select category , status, sum(excess_budget) excess_budget
from project_excess_budget
where project_id = ".$q." group by category , status with rollup";

$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
echo "<table class='gridtable'>";
echo "<caption>Budget Summary</caption>";
echo "<tr>";
echo"<th><b>Category</th>";
echo"<th><b>Status</th>";
echo"<th><b>Budget</th>";
echo "</tr>";
while($row = mysqli_fetch_array($result))
{
	echo "<tr>";
	echo "<td>$row[category]</td>";
	if($row[status] == "") 
		echo "<td><b>TOTAL</b></td>";
	else
		echo "<td>$row[status]</td>";
	
	echo "<td align='right'> <label class='desc'>";
    echo number_format($row[excess_budget],2);
	echo "</td>";
	echo "</tr>";

}
echo "</table>";
echo "<td>";



$sql="
select category,id,getEmpName(initiated_by) initiated_by,initiated_on,excess_budget, budget_name,status, 
authorised_by,authorised_on
from project_excess_budget
where project_id = ".$q;

$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
echo "<td>";

echo "<table class='gridtable'>";

echo "<caption>Budget Details</caption>";

echo "<tr>";
echo"<th><b>Category</th>";
echo"<th><b>Initiated By</th>";
echo"<th><b>Initiated On</th>";
echo"<th><b>Budget</th>";
echo"<th><b>Name</th>";
echo"<th><b>Status</th>";
echo"<th><b>View</th>";

echo "</tr>";
while($row = mysqli_fetch_array($result))
{
	echo "<tr>";
	echo "<td>$row[category]</td>";
	echo "<td>$row[initiated_by]</td>";
	echo "<td>$row[initiated_on]</td>";
	echo "<td align='right'> <label class='desc'>";
        echo number_format($row[excess_budget],2);
	echo "</td>";
	echo "<td>$row[budget_name]</td>";
		echo "<td>$row[status]</td>";
	echo "<td><a href='viewebudgetdetails.php?bud_id=$row[id]'>Details</a> </td>";

	echo "</tr>";

}
echo "</table>";
echo "</td>";
echo "</tr>";

echo "</table>";

closeConnection($con);
?>
