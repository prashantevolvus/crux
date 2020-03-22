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

$q1=$_GET["q1"];

$q2=$_GET["q2"];

$con=getConnection();
//Please uncomment once old expense has been entered
$sql="
select a.id,c.name customer , b.project_name project_name , a.excess_budget, initiated_by, initiated_on,budget_name
from project_excess_budget a
inner join project_details b on a.project_id = b.id
inner join hr_mysql_live.ohrm_customer c on ohrm_customer_id = c.customer_id where 1=1 ";
if($q<>"")
	$sql .= " and a.project_id = '".$q."' ";
if($q1<>"")
	$sql .= " and a.status = '".$q1."' ";
if($q2<>"")
	$sql .= " and b.ohrm_customer_id = '".$q2."' ";

	$sql .= "  order by initiated_on desc";
	
$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
echo "<table class='gridtable'>";

echo "<br><tr>";
echo "<th><b>Customer</b></th>";

echo "<th><b>Project Name</b></th>";
echo "<th><b>Budget Name</b></th>";

echo "<th><b>Initiated On</b></th>";

echo "<th><b>Excess Budget</b></th>";
	


echo "<th align='left'><b>Operations</b></th>";
echo "</tr>";
while($row = mysqli_fetch_array($result))
  {
	echo "<tr>";

        echo "<td>$row[customer]</td>";
        echo "<td>$row[project_name]</td>";
		echo "<td>$row[budget_name]</td>";
	$dt = date("d-M-Y", strtotime($row[initiated_on]));

        echo "<td>$dt</td>";


	$amt=number_format($row[excess_budget],2);
        echo "<td align='right'>$amt</td>";
	
	if($q1 == "INITIATED")
	{
		echo "<td><a href='editebudget.php?bud_id=$row[id]'>Edit</a> |  ";
		echo "<a href='authebudget.php?bud_id=$row[id]'>Authorise</a> | ";
		echo "<a href='viewebudgetdetails.php?bud_id=$row[id]'>View</a> | ";
		echo "<a href='canebudget.php?bud_id=$row[id]'>Cancel</a> </td>";
	}
	if($q1 == "AUTHORISED")
	{
		echo "<td><a href='viewebudgetdetails.php?bud_id=$row[id]'>View</a> </td>";
	}
	if($q1 == "CANCELLED")
	{
		echo "<td><a href='canebudget.php?bud_id=$row[id]'>View</a> </td> ";
	}
	echo "</tr>";
  }
echo "</table>";
closeConnection($con);
?>
