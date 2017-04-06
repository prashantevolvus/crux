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
a.pm_report curr_pm_report,
a.pd_report curr_pd_report,
a.pm_risk_perception curr_pm_risk_perception,
a.pd_risk_perception curr_pd_risk_perception,
a.approver_report curr_approver_report,
b.pm_report prev_pm_report,
b.pd_report prev_pd_report,
b.pm_risk_perception prev_pm_risk_perception,
b.pd_risk_perception prev_pd_risk_perception,
b.approver_report prev_approver_report
from project_report a
left join project_report b on a.prev_report_id = b.id
where a.id = ".$repid ;

$resulted = mysqli_query($coned,$sqled) or debug($sqled."   failed  <br/><br/>".mysql_error());
$rowed = mysqli_fetch_array($resulted);
					
?>
<form name="projectForm"  method="post" onsubmit="return formSubmit();" >
<table>
<tr>
<td><b>Previous Report of Project Manager</td>
<td><b>Current Report of Project Manager</td>
<td><b>Previous Report of PM's Risk Perception</td>
<td><b>Current Report of PM's Risk Perception</td>
</tr>
<tr>
<td>  <textarea rows=10 cols=45 id='prev_pm_report'  name='prev_pm_report' requried><?echo $rowed[prev_pm_report];?></textarea>
<td>  <textarea rows=10 cols=45 id='curr_pm_report'  name='curr_pm_report' requried><?echo $rowed[curr_pm_report];?></textarea>
<td>  <textarea rows=10 cols=45 id='prev_pm_risk_perception'  name='prev_pm_risk_perception' requried><?echo $rowed[prev_pm_risk_perception];?></textarea>
<td>  <textarea rows=10 cols=45 id='curr_pm_risk_perception'  name='curr_pm_risk_perception' requried><?echo $rowed[curr_pm_risk_perception];?></textarea>
</tr>

<tr>
<td><b>Previous Report of Project Director</td>
<td><b>Current Report of Project Director</td>
<td><b>Previous Report of Project Director's Risk Perception</td>
<td><b>Current Report of Project Director's Risk Perception</td>
</tr>
<tr>
<td>  <textarea rows=10 cols=45 id='prev_pd_report'  name='prev_pd_report' requried><?echo $rowed[prev_pd_report];?></textarea>
<td>  <textarea rows=10 cols=45 id='curr_pd_report'  name='curr_pd_report' requried><?echo $rowed[curr_pd_report];?></textarea>
<td>  <textarea rows=10 cols=45 id='prev_pd_risk_perception'  name='prev_pd_risk_perception' requried><?echo $rowed[prev_pd_risk_perception];?></textarea>
<td>  <textarea rows=10 cols=45 id='curr_pd_risk_perception'  name='curr_pd_risk_perception' requried><?echo $rowed[curr_pd_risk_perception];?></textarea>
</tr>

<tr>
<td><b>Previous Report of Approver</td>
<td><b>Current Report of Approver</td>
</tr>
<tr>
<td>  <textarea rows=10 cols=45 id='prev_approver_report'  name='prev_approver_report' requried><?echo $rowed[prev_approver_report];?></textarea>
<td>  <textarea rows=10 cols=45 id='curr_approver_report'  name='curr_approver_report' requried><?echo $rowed[curr_approver_report];?></textarea>

</tr>

</table>
</form>
<?
echo "<script>document.getElementById('prev_pm_report').disabled=true;</script>";
echo "<script>document.getElementById('curr_pm_report').disabled=true;</script>";
echo "<script>document.getElementById('prev_pm_risk_perception').disabled=true;</script>";
echo "<script>document.getElementById('curr_pm_risk_perception').disabled=true;</script>";

echo "<script>document.getElementById('prev_pd_report').disabled=true;</script>";
echo "<script>document.getElementById('curr_pd_report').disabled=true;</script>";
echo "<script>document.getElementById('prev_pd_risk_perception').disabled=true;</script>";
echo "<script>document.getElementById('curr_pd_risk_perception').disabled=true;</script>";

echo "<script>document.getElementById('prev_approver_report').disabled=true;</script>";
echo "<script>document.getElementById('curr_approver_report').disabled=true;</script>";

?>
