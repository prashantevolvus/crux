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

ifnull(a.userstory_complex_total_count,0)  curr_userstory_complex_total_count,
ifnull(a.userstory_high_total_count,0)  curr_userstory_high_total_count,
ifnull(a.userstory_medium_total_count,0)  curr_userstory_medium_total_count,
ifnull(a.userstory_low_total_count,0)  curr_userstory_low_total_count,

ifnull(a.userstory_complex_cmpltd_count,0)  curr_userstory_complex_cmpltd_count,
ifnull(a.userstory_high_cmpltd_count,0)  curr_userstory_high_cmpltd_count,
ifnull(a.userstory_medium_cmpltd_count,0)  curr_userstory_medium_cmpltd_count,
ifnull(a.userstory_low_cmpltd_count,0)  curr_userstory_low_cmpltd_count,

ifnull(a.userstory_complex_total_count,0) - ifnull(a.userstory_complex_cmpltd_count,0)  curr_userstory_complex_diff_count,
ifnull(a.userstory_high_total_count,0) - ifnull(a.userstory_high_cmpltd_count,0)  curr_userstory_high_diff_count,
ifnull(a.userstory_medium_total_count,0) - ifnull(a.userstory_medium_cmpltd_count,0)  curr_userstory_medium_diff_count,
ifnull(a.userstory_low_total_count,0) - ifnull(a.userstory_low_cmpltd_count,0)  curr_userstory_low_diff_count,


ifnull(b.userstory_complex_total_count,0)  prev_userstory_complex_total_count,
ifnull(b.userstory_high_total_count,0)  prev_userstory_high_total_count,
ifnull(b.userstory_medium_total_count,0)  prev_userstory_medium_total_count,
ifnull(b.userstory_low_total_count,0)  prev_userstory_low_total_count,

ifnull(b.userstory_complex_cmpltd_count,0)  prev_userstory_complex_cmpltd_count,
ifnull(b.userstory_high_cmpltd_count,0)  prev_userstory_high_cmpltd_count,
ifnull(b.userstory_medium_cmpltd_count,0)  prev_userstory_medium_cmpltd_count,
ifnull(b.userstory_low_cmpltd_count,0)  prev_userstory_low_cmpltd_count,

ifnull(b.userstory_complex_total_count,0) - ifnull(b.userstory_complex_cmpltd_count,0)  prev_userstory_complex_diff_count,
ifnull(b.userstory_high_total_count,0) - ifnull(b.userstory_high_cmpltd_count,0)  prev_userstory_high_diff_count,
ifnull(b.userstory_medium_total_count,0) - ifnull(b.userstory_medium_cmpltd_count,0)  prev_userstory_medium_diff_count,
ifnull(b.userstory_low_total_count,0) - ifnull(b.userstory_low_cmpltd_count,0)  prev_userstory_low_diff_count

from project_report a
left join project_report b on a.prev_report_id = b.id
where a.id = ".$repid ;

$resulted = mysqli_query($coned,$sqled) or debug($sqled."   failed  <br/><br/>".mysql_error());
$rowed = mysqli_fetch_array($resulted);
$prev_total_total_userstory = $rowed[prev_userstory_complex_total_count] + $rowed[prev_userstory_high_total_count] 
					+ $rowed[prev_userstory_medium_total_count] + $rowed[prev_userstory_low_total_count];

$curr_total_total_userstory = $rowed[curr_userstory_complex_total_count] + $rowed[curr_userstory_high_total_count] 
					+ $rowed[curr_userstory_medium_total_count] + $rowed[curr_userstory_low_total_count];

$prev_total_cmpltd_userstory = $rowed[prev_userstory_complex_cmpltd_count] + $rowed[prev_userstory_high_cmpltd_count] 
					+ $rowed[prev_userstory_medium_cmpltd_count] + $rowed[prev_userstory_low_cmpltd_count];

$curr_total_cmpltd_userstory = $rowed[curr_userstory_complex_cmpltd_count] + $rowed[curr_userstory_high_cmpltd_count] 
					+ $rowed[curr_userstory_medium_cmpltd_count] + $rowed[curr_userstory_low_cmpltd_count];
$prev_total_pending_userstory
=
$rowed[prev_userstory_complex_total_count]-$rowed[prev_userstory_complex_cmpltd_count]
+
$rowed[prev_userstory_high_total_count]-$rowed[prev_userstory_high_cmpltd_count]
+
$rowed[prev_userstory_medium_total_count]-$rowed[prev_userstory_medium_cmpltd_count]
+
$rowed[prev_userstory_low_total_count]-$rowed[prev_userstory_low_cmpltd_count];					

$curr_total_pending_userstory
=
$rowed[curr_userstory_complex_total_count]-$rowed[curr_userstory_complex_cmpltd_count]
+
$rowed[curr_userstory_high_total_count]-$rowed[curr_userstory_high_cmpltd_count]
+
$rowed[curr_userstory_medium_total_count]-$rowed[curr_userstory_medium_cmpltd_count]
+
$rowed[curr_userstory_low_total_count]-$rowed[curr_userstory_low_cmpltd_count];

if($prev_total_total_userstory != 0)
	$prev_pcnt_completion = number_format(100.0 * $prev_total_cmpltd_userstory / $prev_total_total_userstory,0);
else
	$prev_pcnt_completion = 0;

if($curr_total_total_userstory != 0)
	$curr_pcnt_completion = number_format(100.0 * $curr_total_cmpltd_userstory / $curr_total_total_userstory,0);
else
	$curr_pcnt_completion = 0;

?>
<form name="projectForm"  method="post" onsubmit="return formSubmit();" >
<table>
<tr>
<td>
<table class='gridtable' style="width:500px">
<tr>
<th>Total User Story</th>
<th>Previous Report
<?php if($rowed[prev_id] =="") 
		echo "(Report not generated)";
?>
</th>
<th>Current Report</th>
<th>This Week</th>
</tr>
<tr>
	<td>COMPLEX</td>
	<td align='right'><?php echo number_format($rowed[prev_userstory_complex_total_count],0); ?> </td>
	<td align='right'><?php echo number_format($rowed[curr_userstory_complex_total_count],0); ?> </td>
	<td align='right'><?php echo number_format($rowed[curr_userstory_complex_total_count]-$rowed[prev_userstory_complex_total_count],0); ?> </td>
</tr>
	
<tr>
	<td>HIGH</td>
	<td align='right'><?php echo number_format($rowed[prev_userstory_high_total_count],0); ?> </td>
	<td align='right'><?php echo number_format($rowed[curr_userstory_high_total_count],0); ?> </td>
	<td align='right'><?php echo number_format($rowed[curr_userstory_high_total_count]-$rowed[prev_userstory_high_total_count],0); ?> </td>
</tr>
	
<tr>
	<td>MEDIUM</td>
	<td align='right'><?php echo number_format($rowed[prev_userstory_medium_total_count],0); ?> </td>
	<td align='right'><?php echo number_format($rowed[curr_userstory_medium_total_count],0); ?> </td>
	<td align='right'><?php echo number_format($rowed[curr_userstory_medium_total_count]-$rowed[prev_userstory_medium_total_count],0); ?> </td>
</tr>
	
<tr>
	<td>LOW</td>
	<td align='right'><?php echo number_format($rowed[prev_userstory_low_total_count],0); ?> </td>
	<td align='right'><?php echo number_format($rowed[curr_userstory_low_total_count],0); ?> </td>
	<td align='right'><?php echo number_format($rowed[curr_userstory_low_total_count]-$rowed[prev_userstory_low_total_count],0); ?> </td>
</tr>

<tr>
	<td>TOTAL</td>
	<td align='right'><?php echo number_format($prev_total_total_userstory,0); ?> </td>
	<td align='right'><?php echo number_format($curr_total_total_userstory,0); ?> </td>
	<td align='right'><?php echo number_format($curr_total_total_userstory-$prev_total_total_userstory,0); ?> </td>
</tr>
</table>
</td>
<td>
<table class='gridtable' style="width:500px">
<tr>
<th>User Story Completed</th>
<th>Previous Report
<?php if($rowed[prev_id] =="") 
		echo "(Report not generated)";
?>
</th>
<th>Current Report</th>
<th>This Week</th>
</tr>
<tr>
	<td>COMPLEX</td>
	<td align='right'><?php echo number_format($rowed[prev_userstory_complex_cmpltd_count],0); ?> </td>
	<td align='right'><?php echo number_format($rowed[curr_userstory_complex_cmpltd_count],0); ?> </td>
	<td align='right'><?php echo number_format($rowed[curr_userstory_complex_cmpltd_count]-$rowed[prev_userstory_complex_cmpltd_count],0); ?> </td>
</tr>
	
<tr>
	<td>HIGH</td>
	<td align='right'><?php echo number_format($rowed[prev_userstory_high_cmpltd_count],0); ?> </td>
	<td align='right'><?php echo number_format($rowed[curr_userstory_high_cmpltd_count],0); ?> </td>
	<td align='right'><?php echo number_format($rowed[curr_userstory_high_cmpltd_count]-$rowed[prev_userstory_high_cmpltd_count],0); ?> </td>
</tr>
	
<tr>
	<td>MEDIUM</td>
	<td align='right'><?php echo number_format($rowed[prev_userstory_medium_cmpltd_count],0); ?> </td>
	<td align='right'><?php echo number_format($rowed[curr_userstory_medium_cmpltd_count],0); ?> </td>
	<td align='right'><?php echo number_format($rowed[curr_userstory_medium_cmpltd_count]-$rowed[prev_userstory_medium_cmpltd_count],0); ?> </td>
</tr>
	
<tr>
	<td>LOW</td>
	<td align='right'><?php echo number_format($rowed[prev_userstory_low_cmpltd_count],0); ?> </td>
	<td align='right'><?php echo number_format($rowed[curr_userstory_low_cmpltd_count],0); ?> </td>
	<td align='right'><?php echo number_format($rowed[curr_userstory_low_cmpltd_count]-$rowed[prev_userstory_low_cmpltd_count],0); ?> </td>
</tr>

<tr>
	<td>TOTAL</td>
	<td align='right'><?php echo number_format($prev_total_cmpltd_userstory,0); ?> </td>
	<td align='right'><?php echo number_format($curr_total_cmpltd_userstory,0); ?> </td>
	<td align='right'><?php echo number_format($curr_total_cmpltd_userstory-$prev_total_cmpltd_userstory,0); ?> </td>
</tr>
</table>
</td>
</tr>
<tr>
<td>
<table class='gridtable' style="width:500px">
<tr>
<th>User Story Pending</th>
<th>Previous Report
<?php if($rowed[prev_id] =="") 
		echo "(Report not generated)";
?>
</th>
<th>Current Report</th>
<th>This Week</th>
</tr>
<tr>
	<td>COMPLEX</td>
	<td align='right'><?php echo number_format($rowed[prev_userstory_complex_total_count]-$rowed[prev_userstory_complex_cmpltd_count],0); ?> </td>
	<td align='right'><?php echo number_format($rowed[curr_userstory_complex_total_count]-$rowed[curr_userstory_complex_cmpltd_count],0); ?> </td>
	<td align='right'><?php echo number_format($rowed[curr_userstory_complex_total_count]-$rowed[curr_userstory_complex_cmpltd_count]-($rowed[prev_userstory_complex_total_count]-$rowed[prev_userstory_complex_cmpltd_count]),0); ?> </td>
</tr>
	
<tr>
	<td>HIGH</td>
	<td align='right'><?php echo number_format($rowed[prev_userstory_high_total_count]-$rowed[prev_userstory_high_cmpltd_count],0); ?> </td>
	<td align='right'><?php echo number_format($rowed[curr_userstory_high_total_count]-$rowed[curr_userstory_high_cmpltd_count],0); ?> </td>
	<td align='right'><?php echo number_format($rowed[curr_userstory_high_total_count]-$rowed[curr_userstory_high_cmpltd_count]-($rowed[prev_userstory_complex_total_count]-$rowed[prev_userstory_complex_cmpltd_count]),0); ?> </td>
</tr>
	
<tr>
	<td>MEDIUM</td>
	<td align='right'><?php echo number_format($rowed[prev_userstory_medium_total_count]-$rowed[prev_userstory_medium_cmpltd_count],0); ?> </td>
	<td align='right'><?php echo number_format($rowed[curr_userstory_medium_total_count]-$rowed[curr_userstory_medium_cmpltd_count],0); ?> </td>
	<td align='right'><?php echo number_format($rowed[curr_userstory_medium_total_count]-$rowed[curr_userstory_medium_cmpltd_count]-($rowed[prev_userstory_complex_total_count]-$rowed[prev_userstory_complex_cmpltd_count]),0); ?> </td>
</tr>
	
<tr>
	<td>LOW</td>
	<td align='right'><?php echo number_format($rowed[prev_userstory_low_total_count]-$rowed[prev_userstory_low_cmpltd_count],0); ?> </td>
	<td align='right'><?php echo number_format($rowed[curr_userstory_low_total_count]-$rowed[curr_userstory_low_cmpltd_count],0); ?> </td>
	<td align='right'><?php echo number_format($rowed[curr_userstory_low_total_count]-$rowed[curr_userstory_low_cmpltd_count]-($rowed[prev_userstory_complex_total_count]-$rowed[prev_userstory_complex_cmpltd_count]),0); ?> </td>
</tr>

<tr>
	<td>TOTAL</td>
	<td align='right'><?php echo number_format($prev_total_pending_userstory,0); ?> </td>
	<td align='right'><?php echo number_format($curr_total_pending_userstory,0); ?> </td>
	<td align='right'><?php echo number_format($curr_total_pending_userstory-$prev_total_pending_userstory,0); ?> </td>
</tr>
</table>
</td>
<td>
<table>
<tr>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td><b>
Percentage Completion
</b></td>
<td>&nbsp</td>
</tr>
<tr>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td><b>
Previous
</b></td>
<td>&nbsp</td>
<td><b>
Current
</b></td>
</tr>
<tr>
<td>&nbsp</td>
</tr>
<tr>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td>&nbsp</td>
<td><b>
<font size="6"><?php echo $prev_pcnt_completion;?>%</font>
</b></td>
<td>&nbsp</td>
<td><b>
<font size="6"><?php echo $curr_pcnt_completion;?>%</font>

</b></td>
</tr>
</table>
</td>
</tr>
</table>
</form>

