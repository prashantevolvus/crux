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

function display($fld,$fldName,$con,$q)
{
	echo "<td>";
	$sqlcol="
	select ".$fld." ,sum(work_hours) work_hours, sum(cost) cost, sum(unifiedcost) unifiedcost";
	$sql="
	 from project_details a 
	left join  monthly_timesheet b on  a.ohrm_project_id = b.project_id
	where 1=1 ";
	$sql .= " and id = ".$q;
	$sql .=" group by ".$fld." with rollup ";
	/*echo "
	<label class='desc'><b>Financial details in INR</label>
	";*/
	
	$result = mysqli_query($con,$sqlcol.$sql) or debug($sql."<br/><br/>".mysql_error());
	echo "<table  class='gridtable'>";
	echo "<tr>";
	echo "<th> <b>".$fldName." </th>";
	echo "<th> <b> Number of Hours </b></th>";
	echo "<th> <b> Base Labour Cost </b></th>";
	echo "<th> <b> Unified Labour Cost </b></th>";
	echo "</tr>";

	while($row = mysqli_fetch_array($result))
	{
		echo "<tr>";
		
		if($row[$fld]=="")
			echo "<td> <b>TOTAL </b></td>";
		else
			echo "<td> $row[$fld] </td>";
		
		echo "<td>". number_format($row[work_hours],0)."</td>";
		echo "<td>". number_format($row[cost],2)."</td>";
		echo "<td>". number_format($row[unifiedcost],2)."</td>";
		echo "</tr>";

	}
	echo "</tr></table> ";
	echo "</td>";



}
echo "<table> ";
echo "<tr valign=top>";
 display('reported_date','Period',$con,$q); 
 display('employee_name','Employee Name',$con,$q);
 echo "</tr>" ;
echo "</table> ";

closeConnection($con);
?>
