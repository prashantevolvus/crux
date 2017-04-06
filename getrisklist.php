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
$q1=$_GET["q1"];
$rep=$_GET["rep"];
$con=getConnection();
//Please uncomment once old expense has been entered
$sql="
select a.risk_id,b.status,c.name customer , b.project_name project_name , 
left(risk_desc,50) risk_desc,getEmpName(created_by) created_by,created_on,d.risk_type,
likelihood,impact
from project_risk a
inner join project_details b on a.project_id = b.id
inner join risk_type d on a.risk_type = d.risk_type_id
inner join hr_mysql_live.ohrm_customer c on ohrm_customer_id = c.customer_id";
if($q=="")
	$sql .= " order by created_on desc";
else
	$sql .= " where a.project_id = '".$q."' order by created_on desc";
$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
echo "<table class='gridtable' >";

echo "<br><tr>";
if($rep!="true")
{
	echo "<th><b>Customer</b></th>";

	echo "<th><b>Project Name</b></th>";

}
echo "<th><b>Risk Type</b></th>";

echo "<th><b>Risk Description</b></th>";

echo "<th><b>Created By</b></th>";

	
echo "<th><b>Created On</b></th>";

	
echo "<th><b>Risk Likelihood</b></th>";


echo "<th><b>Risk Impact</b></th>";
	echo "<th align='left'><b>Operations</b></th>";
echo "</tr>";
while($row = mysqli_fetch_array($result))
  {
	echo "<tr>";
if($rep!="true")
{

        echo "<td>$row[customer]</td>";
	
    echo "<td>$row[project_name]</td>";

}
        echo "<td>$row[risk_type]</td>";
        echo "<td>$row[risk_desc]</td>";
        echo "<td>$row[created_by]</td>";

	$dt = date("d-M-Y", strtotime($row[created_on]));

        echo "<td>$dt</td>";
	
echo "<td>$row[likelihood]</td>";
	
	
echo "<td>$row[impact]</td>";

echo "<td>";
	
if($rep!="true")
{

	if(!($row[status] == "CLOSED" || $row[status] == "DELETED"))
 	{
		echo "<a href='editrisk.php?risk_id=$row[risk_id]'>Edit</a> |  ";
	}
}
	echo "<a href='viewriskdetails.php?risk_id=$row[risk_id]'>View</a>  ";
	echo "</td>";

	echo "</tr>";
  }
echo "</table>";
closeConnection($con);
?>
