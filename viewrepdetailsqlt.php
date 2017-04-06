<?php
session_name("Project");
session_start();
require_once('dbconn.php');
if(!checkUserSession($_SESSION["user"]))
{
	header("Location:login.php");
}
if(checkProjectPermission("VIEW") == false)
{

        header("Location:error.php");
}


$repid=$_GET["rep_id"];

$coned=getConnection();
$sqled="
select a.id curr_id,b.id prev_id,
ifnull(a.issue_critical_count,0)  curr_critical_issue,
ifnull(a.issue_high_count,0)  curr_high_issue,
ifnull(a.issue_medium_count,0)  curr_medium_issue,
ifnull(a.issue_low_count,0)  curr_low_issue,
ifnull(b.issue_critical_count,0)  prev_critical_issue,
ifnull(b.issue_high_count,0)  prev_high_issue,
ifnull(b.issue_medium_count,0)  prev_medium_issue,
ifnull(b.issue_low_count,0)  prev_low_issue
from project_report a
left join project_report b on a.prev_report_id = b.id
where a.id = ".$repid ;

$resulted = mysqli_query($coned,$sqled) or debug($sqled."   failed  <br/><br/>".mysql_error());
$rowed = mysqli_fetch_array($resulted);
$prev_total_issue = $rowed[prev_critical_issue] + $rowed[prev_high_issue] 
					+ $rowed[prev_medium_issue] + $rowed[prev_low_issue];
$curr_total_issue = $rowed[curr_critical_issue] + $rowed[curr_high_issue] 
					+ $rowed[curr_medium_issue] + $rowed[curr_low_issue];
					
?>
<form name="projectForm"  method="post" onsubmit="return formSubmit();" >
<table>
<tr>
<td>
<table class='gridtable' style="width:500px">
<tr>
<th>Open Issue Information</th>
<th>Previous Report
<?if($rowed[prev_id] =="") 
		echo "(Report not generated)";
?>
</th>
<th>Current Report</th>
<th>This Week</th>
</tr>
<tr>
	<td>CRITICAL</td>
	<td align='right'><?echo number_format($rowed[prev_critical_issue],0); ?> </td>
	<td align='right'><?echo number_format($rowed[curr_critical_issue],0); ?> </td>
	<td align='right'><?echo number_format($rowed[curr_critical_issue]-$rowed[prev_critical_issue],0); ?> </td>
</tr>
	
<tr>
	<td>HIGH</td>
	<td align='right'><?echo number_format($rowed[prev_high_issue],0); ?> </td>
	<td align='right'><?echo number_format($rowed[curr_high_issue],0); ?> </td>
	<td align='right'><?echo number_format($rowed[curr_high_issue]-$rowed[prev_high_issue],0); ?> </td>
</tr>
	
<tr>
	<td>MEDIUM</td>
	<td align='right'><?echo number_format($rowed[prev_medium_issue],0); ?> </td>
	<td align='right'><?echo number_format($rowed[curr_medium_issue],0); ?> </td>
	<td align='right'><?echo number_format($rowed[curr_medium_issue]-$rowed[prev_medium_issue],0); ?> </td>
</tr>
	
<tr>
	<td>LOW</td>
	<td align='right'><?echo number_format($rowed[prev_low_issue],0); ?> </td>
	<td align='right'><?echo number_format($rowed[curr_low_issue],0); ?> </td>
	<td align='right'><?echo number_format($rowed[curr_low_issue]-$rowed[prev_low_issue],0); ?> </td>
</tr>

<tr>
	<td>TOTAL</td>
	<td align='right'><?echo number_format($prev_total_issue,0); ?> </td>
	<td align='right'><?echo number_format($curr_total_issue,0); ?> </td>
	<td align='right'><?echo number_format($curr_total_issue-$prev_total_issue,0); ?> </td>
</tr>
</table>
</td>

</tr>
</table>
</form>

