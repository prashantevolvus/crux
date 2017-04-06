<script src="jss/a.js">
$(function() {
  $('Hello').balloon();
});
</script>
<br><br type="_moz">
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
$sqlcol="
select compare,comment,employee_status,employee_name,date_format(reported_date ,'%d-%b-%Y') book_date , date_format(reported_date ,'%W') book_weekday , activity, work_hours, cost, labourcost ,unifiedcost";
$sql="
 from project_details a 
left join  monthly_timesheet b on  a.ohrm_project_id = b.project_id
where 1=1 ";
$sql .= " and id = ".$q;
$sql .=" order by reported_date desc,employee_name";
/*echo "
<label class='desc'><b>Financial details in INR</label>
";*/

$result = mysqli_query($con,$sqlcol.$sql) or debug($sql."<br/><br/>".mysql_error());

echo "<table  class='table table-bordered'>";
echo "<tr>";
echo "<th> <b>Employee Status </th>";

echo "<th> <b>Employee Name </th>";
echo "<th> <b>Booked Date </th>";
echo "<th> <b>Weekday </th>";
echo "<th> <b>Period </th>";
echo "<th> <b>&nbsp; Activity &nbsp;</th>";
echo "<th> <b> Comments </b></th>";
echo "<th> <b> Number of Hours </b></th>";
echo "<th> <b> Base Labour Cost </b></th>";
echo "<th> <b> Unified Labour Cost </b></th>";
echo "</tr>";

while($row = mysqli_fetch_array($result))
{
	echo "<tr>";
	echo "<td> $row[employee_status] </td>";
	echo "<td> $row[employee_name] </td>";
	echo "<td> $row[book_date] </td>";
	echo "<td> $row[book_weekday] </td>";
	echo "<td> $row[compare] </td>";
	echo "<td> &nbsp; $row[activity] &nbsp;</td>";
	//echo "<td>  $(".$row[comment].").balloon(); </td>";
	echo "<td>  $row[comment]</td>";
	echo "<td>". number_format($row[work_hours],0)."</td>";
	echo "<td>". number_format($row[cost],2)."</td>";
	echo "<td>". number_format($row[unifiedcost],2)."</td>";
	echo "</tr>";

}

	
	echo "</table>";
closeConnection($con);
?>
