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
select 
a.id rep_id,a.tlr,
report_date,
b1.name customer,
b1.customer_id,
project_name,
a.status report_status, 
getEmpName(b.project_manager_id) pm,
project_manager_id,
filled_by,
ifnull(getEmpName(a.filled_by),' ') report_filled_by,
project_id,report_type,
b.status status,customer_delight_quotient,
planned_start_date,actual_start_date,planned_end_date,extension
from project_report a
inner join project_details b on b.id = a.project_id
inner join hr_mysql_live.ohrm_customer b1 on customer_id = ohrm_customer_id
where a.id = ".$repid ;


$resulted = mysqli_query($coned,$sqled) or debug($sqled."   failed  <br/><br/>".mysql_error());
$rowed = mysqli_fetch_array($resulted);

?>
<form name="projectForm"  method="post" onsubmit="return formSubmit();" >
<table>
<tr>
<td>Report Date : </td>
<td> <input type = "date" id="ReportDate" name="ReportDate"></td>

	<td>Report Period : </td>
	<td>
	<select id='rpttype' name='rpttype' value =''>
	<option value='Choose..' selected='selected'>Choose...</option>
	<option value='WEEKLY'>WEEKLY</option>
	<option value='FORTNIGHTLY'>FORTNIGHTLY</option>
<option value='MONTHLY'>MONTHLY</option>
<option value='QUARTERLY'>QUARTERLY</option>
</select>

</td>
<td>Report Status : </td>
<td> <input type = "text" id="ReportStatus" name="ReportStatus"></td>

</tr>

	<tr>
		<td>Customer : </td>
		<td>

                        <? 
include 'getcustomer.php'; ?>
		</td>

		<td>Project : </td>

		<td> <input type = "text" id='proj' name='proj' size='50'></td>

<td>Project Status : </td>
<td> 
<select id='status' name='status' value =''>
<option value='Choose..' selected='selected'>Choose...</option>
<option value='INITIATED'>INITIATED</option>
<option value='ACTIVE'>ACTIVE</option>
<option value='DEACTIVATED'>DEACTIVATED</option>
<option value='CLOSED'>CLOSED</option>
<option value='INITIATE CLOSURE'>INITIATE CLOSURE</option>
<option value='AUTHORISE CLOSURE'>AUTHORISE CLOSURE</option>
<option value='WARRANTY'>WARRANTY</option>
<option value='DELIVERED'>DELIVERED</option>
<option value='DELETED'>DELETED</option>
<option value='AUTHORISED'>AUTHORISED</option>
<option value='APPROVED'>APPROVED</option>
</select>
</td>

		</tr>


	<tr>
		<td>Project Manager : </td>
		<td>
                        <? 
$_GET['q']='pm';
include 'getemp.php'; ?>
		</td>
<td>Report Filled By : </td>
<td> <input type = "text" id="report_filled_by" name="report_filled_by"></td>
<td>Planned Start date : </td>
<td> <input type = "date" id="PlannedStartDate" name="PlannedStartDate"></td>

 </td>

	</tr>


<tr>
<td>Actual Start date : </td>
<td> <input type = "date" id="ActualStartDate" name="ActualStartDate"></td>
<td>Extension in Days</td>
<td> <input type = "number" id="Extension" name="Extension" value=0></td>

<td>Planned End Date : </td>
<td> <input type = "date" id="PlannedEndDate" name="PlannedEndDate"></td>

</tr>

<?
echo "<script>document.getElementById('PlannedStartDate').value = '$rowed[planned_start_date]';</script>";
echo "<script>document.getElementById('PlannedStartDate').disabled=true;</script>";
echo "<script>document.getElementById('PlannedEndDate').value = '$rowed[planned_end_date]';</script>";
echo "<script>document.getElementById('ActualStartDate').disabled=true;</script>";
echo "<script>document.getElementById('ActualStartDate').value = '$rowed[actual_start_date]';</script>";
echo "<script>document.getElementById('PlannedEndDate').disabled=true;</script>";
echo "<script>document.getElementById('Extension').value = '$rowed[extension]';</script>";
echo "<script>document.getElementById('Extension').disabled=true;</script>";
echo "<script>document.getElementById('rpttype').value = '$rowed[report_type]';</script>";
echo "<script>document.getElementById('rpttype').disabled=true;</script>";
echo "<script>document.getElementById('status').value = '$rowed[status]';</script>";
echo "<script>document.getElementById('status').disabled=true;</script>";
echo "<script>document.getElementById('pm').value = '$rowed[project_manager_id]';</script>";
echo "<script>document.getElementById('pm').disabled=true;</script>";
echo "<script>document.getElementById('report_filled_by').value = '$rowed[report_filled_by]';</script>";
echo "<script>document.getElementById('report_filled_by').disabled=true;</script>";
echo "<script>document.getElementById('cust').value = '$rowed[customer_id]';</script>";
echo "<script>document.getElementById('cust').disabled=true;</script>";
echo "<script>document.getElementById('proj').value = '$rowed[project_name]';</script>";
echo "<script>document.getElementById('proj').disabled=true;</script>";
echo "<b><input name='projid' id='projid' type='hidden' value='$projid'></b>";
echo "<script>document.getElementById('projid').disabled=true;</script>";
echo "<script>document.getElementById('ReportDate').disabled=true;</script>";
echo "<script>document.getElementById('ReportDate').value = '$rowed[report_date]';</script>";
echo "<script>document.getElementById('ReportStatus').disabled=true;</script>";
echo "<script>document.getElementById('ReportStatus').value = '$rowed[report_status]';</script>";

if($im!="")
if($rowed[customer_delight_quotient]=="HIGH")
		$im="happy.jpg";

if($rowed[customer_delight_quotient]=="LOW")
		$im="sad.jpg";

if($rowed[customer_delight_quotient]=="MEDIUM")
		$im="ok.jpg";
if($im!="")
{
	echo "<td>Customer Exuberance</td>";		
	echo "<td ><img src='images/".$im."' width='60' height='60'</img></td>";
}
echo "<tr>";
echo "<td><a href='viewprojdetails.php?proj_id=$rowed[project_id]'>View Project Details</a> <td> ";
echo "</tr>";
		
?>

</table>

