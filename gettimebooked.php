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
$con=getConnection();
$sqlcol="
select compare,employee_status,employee_name,date_format(reported_date ,'%d-%b-%Y') book_date , date_format(reported_date ,'%W') book_weekday , activity, work_hours ";
$sql="
 from project_details a 
left join  monthly_timesheet b on  a.ohrm_project_id = b.project_id
where 1=1 ";
if($q1!="All")
	$sql .= " and compare = '".$q1."' ";
$sql .= " and id = ".$q;
$sqltot = "select sum(work_hours) tot ";
$sqlsummary = $sqltot.$sql." group by b.project_id";

$sql .=" order by reported_date desc,employee_name";
/*echo "
<label class='desc'><b>Financial details in INR</label>
";*/
$result = mysqli_query($con,$sqlcol.$sql) or debug($sql."<br/><br/>".mysql_error());
$labour_cost = 0;
$expense_cost = 0;
$budget = 0;
$total_cost = 0;
$budget_togo = 0;
$result1 = mysqli_query($con,$sqlsummary) or debug($sqlsummary."<br/><br/>".mysql_error());
$rowed = mysqli_fetch_array($result1);
echo "<br>";
echo "<td><b>Total - </b></td>";
$hr = number_format($rowed[tot],2);
$days = number_format($hr/8,2);
echo "<td><b>".$hr." Hours</b></td>";
echo "<td>&nbsp&nbsp<b>".$days." Person days</b></td>";
echo "<br>";
echo "<table id='data'>";
echo "<tr>";
echo "<td> <b>Employee Status </td";
echo "<td></td>";
echo "<td> <b>Employee Name </td";
echo "<td></td>";
echo "<td> <b>Booked Date </td";
	echo "<td></td>";
echo "<td> <b>Weekday </td";
echo "<td></td>";
echo "<td> <b>Period </td";
echo "<td></td>";
echo "<td> <b>&nbsp; Activity &nbsp;</td";
echo "<td></td>";
echo "<td> <b> Number of Hours </b></td";
echo "</tr>";

while($row = mysqli_fetch_array($result))
{
	echo "<tr>";
	echo "<td> $row[employee_status] </td";
	echo "<td></td>";
	echo "<td> $row[employee_name] </td";
	echo "<td></td>";
	echo "<td> $row[book_date] </td";
	echo "<td></td>";
	echo "<td> $row[book_weekday] </td";
	echo "<td></td>";
	echo "<td> $row[compare] </td";
	echo "<td></td>";
	echo "<td> &nbsp; $row[activity] &nbsp;</td";
	echo "<td></td>";
	echo "<td>". number_format($row[work_hours],2)."</td";
	echo "</tr>";

}

	
/*	
//	if ($togo > 0)
//		echo "<tr><td> <input type="submit" value="Submit"> </td> </tr>";
*/

	echo "</table>";
closeConnection($con);
/*
<style type = "text/css">
.percentbar { background:#CCCCCC; border:1px solid #666666; height:10px; }
.percentbar div { background: #28B8C0; height: 10px; }
</style>
<tr>
<td>
<div class="percentbar" style="width:<?php echo round(100 * 1.0); ?>px;">
  <div style="width:<?php echo round(27 * 1.0); ?>px;"></div> 
</div>
<?php echo 27;?>%
</td>


<td>
<div class="percentbar" style="width:<?php echo round(100 * 1.0); ?>px;">
  <div style="width:<?php echo round(27 * 1.0); ?>px;"></div>
<?php echo 27; ?>%
</div>
</td>
</tr>
*/
?>
