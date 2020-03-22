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
select a.id curr_id,a.status,project_manager_id,project_director_id,
pm_report, pd_report,pd_risk_perception
from project_report a
inner join project_details b on a.project_id = b.id
where a.id  = ".$repid ;

$resulted = mysqli_query($coned,$sqled) or debug($sqled."   failed  <br/><br/>".mysql_error());
$rowed = mysqli_fetch_array($resulted);

if($rowed[project_director_id]!=$_SESSION["userempno"] || !($rowed[status]=="AUTHORISED" ||$rowed[status]=="FILLED" ))					
	die('You do not have permission to fill this report');
?>
<script>
formSubmit(){
return true;
}
</script>
<form name="projectFormAuth"  action="updateauthrep.php" method="post" onsubmit="return formSubmit();" >
<table>
<tr>
<td><b>Project Director's Report</td>
<td><b>Project Director's Risk Perception</td>
</tr>
<?php echo "<b><input name='repid' id='repid' type='hidden' value='$repid'></b>";
?>
<tr>
<td>  <textarea rows=10 cols=80 id='pdreport' autofocus name='pdreport' requried><?echo $rowed[pd_report];?></textarea>
<td>  <textarea rows=10 cols=80 id='pdriskpercept' name='pdriskpercept' requried><?echo $rowed[pd_risk_perception];?></textarea>
</tr>
<tr>
<td>
<input type="submit"  value="Submit Report">
</td>

</tr>
</table>
</form>
