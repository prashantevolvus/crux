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
pm_report, pd_report,pm_risk_perception,
estimated_budget_to_go,
issue_critical_count,
issue_high_count,
issue_medium_count,
issue_low_count,
userstory_complex_total_count,
userstory_high_total_count,
userstory_medium_total_count,
userstory_low_total_count,
userstory_complex_cmpltd_count,
userstory_high_cmpltd_count,
userstory_medium_cmpltd_count,
userstory_low_cmpltd_count,
customer_delight_quotient
from project_report a
inner join project_details b on a.project_id = b.id
where a.id  = ".$repid ;

$resulted = mysqli_query($coned,$sqled) or debug($sqled."   failed  <br/><br/>".mysql_error());
$rowed = mysqli_fetch_array($resulted);

if($rowed[project_manager_id]!=$_SESSION["userempno"] || !($rowed[status]=="GENERATED" || $rowed[status]=="FILLED") )					
	die('You do not have permission to fill this report');
?>
<form name="projectForm"  method="post" action = 'updatefillrep.php' onsubmit="return formSubmit();" >
<table>
<tr>
<td>
<table class='gridtable' style="width:500px">
<tr>
<th>User Story</th>
<th>Total</th>
<th>Completed</th>
</tr>
<tr>
	<td>COMPLEX</td>
	<td align='right'>
	<input type="number" text-align="right" step="1" autofocus
	id="uct" name="uct" 
	required value='<?echo number_format($rowed[userstory_complex_total_count],0);?>'> 
	</td>
	<td align='right'>
	<input type="number" text-align="right" step="1" 
	id="ucc" name="ucc" 
	required value='<?echo number_format($rowed[userstory_complex_cmpltd_count],0);?>'> 
	</td>
</tr>
	
<tr>
	<td>HIGH</td>
	<td align='right'>
	<input type="number" text-align="right" step="1" 
	id="uht" name="uht" 
	required value='<?echo number_format($rowed[userstory_high_total_count],0);?>'> 
	</td>
	<td align='right'>
	<input type="number" text-align="right" step="1" 
	id="uhc" name="uhc" 
	required value='<?echo number_format($rowed[userstory_high_cmpltd_count],0);?>'> 
	</td>
	</tr>
	
<tr>
	<td>MEDIUM</td>
	<td align='right'>
	<input type="number" text-align="right" step="1" 
	id="umt" name="umt" 
	required value='<?echo number_format($rowed[userstory_medium_total_count],0);?>'> 
	</td>
	<td align='right'>
	<input type="number" text-align="right" step="1" 
	id="umc" name="umc" 
	required value='<?echo number_format($rowed[userstory_medium_cmpltd_count],0);?>'> 
	</td>
</tr>
	
<tr>
	<td>LOW</td>
		<td align='right'>
	<input type="number" text-align="right" step="1" 
	id="ult" name="ult" 
	required value='<?echo number_format($rowed[userstory_low_total_count],0);?>'> 
	</td>
	<td align='right'>
	<input type="number" text-align="right" step="1" 
	id="ulc" name="ulc" 
	required value='<?echo number_format($rowed[userstory_low_cmpltd_count],0);?>'> 
	</td>
</tr>

</table>
</td>
<td>
<table class='gridtable' style="width:500px">
<tr>
<th>Issues</th>
<th>Total</th>
</tr>
<tr>
	<td>CRITICAL</td>
	<td align='right'>
	<input type="number" text-align="right" step="1" 
	id="ic" name="ic" 
	required value='<?echo number_format($rowed[issue_critical_count],0);?>'> 
	</td>
	
</tr>
	
<tr>
	<td>HIGH</td>
	<td align='right'>
	<input type="number" text-align="right" step="1" 
	id="ih" name="ih" 
	required value='<?echo number_format($rowed[issue_high_count],0);?>'> 
	</td>
	
	
<tr>
	<td>MEDIUM</td>
	<td align='right'>
	<input type="number" text-align="right" step="1" 
	id="im" name="im" 
	required value='<?echo number_format($rowed[issue_medium_count],0);?>'> 
	</td>
	
</tr>
	
<tr>
	<td>LOW</td>
		<td align='right'>
	<input type="number" text-align="right" step="1" 
	id="il" name="il" 
	required value='<?echo number_format($rowed[issue_low_count],0);?>'> 
	</td>
	</tr>

</table>
</td>
</tr>
<tr>
<td><b>Project Manager's Report</td>
<td><b>Project Manager's Risk Perception</td>
</tr>
<tr>
<td>  <textarea rows=10 cols=80 id='pmreport' name='pmreport' requried><?echo $rowed[pm_report];?></textarea>
<td>  <textarea rows=10 cols=80 id='pmriskpercept' name='pmriskpercept' requried><?echo $rowed[pm_risk_perception];?></textarea>
</tr>
<? echo "<b><input name='repid' id='repid' type='hidden' value='$repid'></b>";
?>
</table>
<table>

<td><b>Customer Exuberance Quotient</td>
<td>
	<select id='custq' name='custq' value ='HIGH'>
	<option value='HIGH' selected='selected'>HIGH</option>
	<option value='MEDIUM'>MEDIUM</option>
	<option value='LOW'>LOW</option>
</select>
</td>
</tr>
<tr>
<td><b>Estimated Budget to Go (INR)</td>
<td><input type="number" text-align="right" step="any" id="estimatedbudget" name="estimatedbudget" value='<?echo $rowed[estimated_budget_to_go];?>' required></td>

</tr>
<tr>
<td>
<input type="submit"  value="Submit Report">
</td>

</tr>
</table>
</form>
<?
echo "<script>document.getElementById('custq').value = '$rowed[customer_delight_quotient]';</script>";
?>
