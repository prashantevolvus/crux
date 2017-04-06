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
select a.id curr_id,a.status,approver_report
from project_report a
inner join project_details b on a.project_id = b.id
where a.id  = ".$repid ;

$resulted = mysqli_query($coned,$sqled) or debug($sqled."   failed  <br/><br/>".mysql_error());
$rowed = mysqli_fetch_array($resulted);

if(1!=$_SESSION["userempno"]|| !($rowed[status]=="AUTHORISED" ))					
	die('You do not have permission to fill this report');
?>
<form name="projectFormAppr"  action="updateapprrep.php" method="post" onsubmit="return formSubmit();" >
<table>
<tr>
<td><b>Approver's Report</td>
<? echo "<b><input name='repid' id='repid' type='hidden' value='$repid'></b>";
?>
</tr>
<tr>
<td>  <textarea rows=10 cols=80 id='pdreport' name='pdreport' autofocus name='pdreport' requried><?echo $rowed[approver_report];?></textarea>
</tr>
</table>
<tr>
<td>

<input type="submit"  value="Submit Report">
</td>

</tr>

</table>
</form>
