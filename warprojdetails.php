<?php
$permission = "VIEW";
require_once('head.php');



require_once('bodystart.php');
?>


<tr>
<br>
<td>
<font size="3"><b>Make Project Phase Warranty</b></font>
</td>
<?php

	$projid = $_GET['proj_id'];
$_GET['projid']=$projid;

$coned=getConnection();
$sqled="
select id,b.project_type,c.name customer,project_name,
concat(d.emp_firstname,' ',d.emp_lastname) pm,
ifnull(Budget,0) budget , ifnull(Excess_budget,0) excess_budget,
Contract_value,License_value,
tlr,base_product,
concat(e.emp_firstname,' ',e.emp_lastname) crt_by,
a.status, c.customer_id,report_type,b.project_type_id,project_manager_id,project_director_id,
Planned_start_date,Planned_End_date,Actual_Start_Date sdt,Actual_End_Date edt,
Objectives, Scope, success_factor, docurl
 from project_details a
inner join project_type b on a.project_type_id = b.project_type_id
inner join hr_mysql_live.ohrm_customer c on a.ohrm_customer_id= c.customer_id
inner join hr_mysql_live.hs_hr_employee d on a.project_manager_id= d.emp_number
inner join hr_mysql_live.hs_hr_employee e on a.Project_created_by= e.emp_number
where id = ".$projid ;
$resulted = mysqli_query($coned,$sqled) or debug($sqled."   failed  <br/><br/>".mysql_error());
$rowed = mysqli_fetch_array($resulted);

 if($rowed[tlr]=="GREEN")
                echo "<td ><img src='images/green.jpg' alt='red' width='40' height='40'</img></td>";

        if($rowed[tlr]=="RED")
	echo "<td ><img src='images/red.jpg' alt='red' width='40' height='40'</img></td>";


if($rowed[tlr]=="AMBER")
	echo "<td ><img src='images/amber.jpg' alt='red' width='40' height='40'</img></td>";
	
include 'operproj.php';

?>
</tr>
<form name="projectForm"  action="" method="post" onsubmit="return formSubmit();" >
<table>
<tr>
	<td>Project Type : </td>
	<td>
 <?php
include 'getprojtype.php'; ?>
	
</td>
        <td>Base Product : </td>
                <td>
                        <?php
include 'getprodtype.php'; ?>
                </td>
</tr>
<tr>


	<td>Report Period : </td>
	<td>
	<select id='rpttype' name='rpttype' value =''>
	<option value='Choose..' selected='selected'>Choose...</option>
	<option value='WEEKLY'>WEEKLY</option>
	<option value='FORTNIGHTLY'>FORTNIGHTLY</option>
<option value='MONTHLY'>MONTHLY</option>
<option value='QUARTERLY'>QUARTERLY</option>
</select>
<?php
echo "<b><input name='proj_id' id='proj_id' type='hidden' value='$projid'></b>";
echo "<b><input name='byFld' id='byFld'  type='hidden' value='project_warranty_by'></b>";
echo "<b><input name='statuschg' id='statuschg'  type='hidden' value='WARRANTY'></b>";
echo "<b><input name='onFld' id='onFld'  type='hidden' value='project_warranty_on'></b>";
?>

</td>

</tr>
<?php
echo "<script>document.getElementById('projtype').value = '$rowed[project_type_id]';</script>";
echo "<script>document.getElementById('projtype').disabled=true;</script>";
echo "<script>document.getElementById('rpttype').value = '$rowed[report_type]';</script>";
echo "<script>document.getElementById('rpttype').disabled=true;</script>";
echo "<script>document.getElementById('prod').value = '$rowed[base_product]';</script>";
echo "<script>document.getElementById('prod').disabled=true;</script>";

?>

	<tr>
		<td>Customer : </td>
		<td>

                        <?php
include 'getcustomer.php'; ?>
		</td>

		<td>Project : </td>

		<td> <input type = "text" id='proj' name='proj' size='50'></td>
	</tr>

<tr>
</tr>
<?php
echo "<script>document.getElementById('cust').value = '$rowed[customer_id]';</script>";
echo "<script>document.getElementById('cust').disabled=true;</script>";
echo "<script>document.getElementById('proj').value = '$rowed[project_name]';</script>";
echo "<script>document.getElementById('proj').disabled=true;</script>";
?>

	<tr>
		<td>Project Manager : </td>
		<td>
                        <?php
$_GET['q']='pm';
include 'getemp.php'; ?>
		</td>

		<td>Project Director : </td>
		<td>

                        <?php
$_GET['q']='pd';
include 'getemp.php'; ?>
		</td>
	</tr>
<?php
echo "<script>document.getElementById('pm').value = '$rowed[project_manager_id]';</script>";
echo "<script>document.getElementById('pm').disabled=true;</script>";
echo "<script>document.getElementById('pd').value = '$rowed[project_director_id]';</script>";
echo "<script>document.getElementById('pd').disabled=true;</script>";
?>


<tr>
<td>Project Status : </td>
<td> 
<select id='statusx' name='statusx' value =''>
<option value='Choose..' selected='selected'>Choose...</option>
<option value='INITIATED'>INITIATED</option>
<option value='ACTIVE'>ACTIVE</option>
<option value='CLOSED'>CLOSED</option>
<option value='INITIATE CLOSURE'>INITIATE CLOSURE</option>
<option value='AUTHORISE CLOSURE'>AUTHORISE CLOSURE</option>
<option value='WARRANTY'>WARRANTY</option>
<option value='DELIVERED'>DELIVERED</option>
<option value='AUTHORISED'>AUTHORISED</option>
<option value='APPROVED'>APPROVED</option>
</select>
</td>
<?php
echo "<script>document.getElementById('statusx').value = '$rowed[status]';</script>";
echo "<script>document.getElementById('statusx').disabled=true;</script>";
?>

</tr>

<tr>
<td>Planned Start date : </td>
<td> <input type = "date" id="PlannedStartDate" name="PlannedStartDate"></td>
<td>Planned End Date : </td>
<td> <input type = "date" id="PlannedEndDate" name="PlannedEndDate"></td>
</tr>
<?php
echo "<script>document.getElementById('PlannedStartDate').value = '$rowed[Planned_start_date]';</script>";
echo "<script>document.getElementById('PlannedStartDate').disabled=true;</script>";
echo "<script>document.getElementById('PlannedEndDate').value = '$rowed[Planned_End_date]';</script>";
echo "<script>document.getElementById('PlannedEndDate').disabled=true;</script>";
?>

<tr>
<td>Actual Start date : </td>
<td> <input type = "date" id="ActualStartDate" name="ActualStartDate"></td>
<td> Actual End Date : </td>
<td> <input type = "date" id="ActualEndDate" name="ActualEndDate"></td>
</tr>
<tr><td><b>Financial Details (in INR)</b></td></tr>
<tr>
<td>Contract Value : </td>
<td>  <input type="text" name="ContractVal" id="ContractVal">
 </td>
<td>License Value : </td>
<td>  <input type="text" name="LicenseVal" id="LicenseVal">
 </td>
</tr>
<?php
echo "<script>document.getElementById('ContractVal').value = '$rowed[Contract_value]';</script>";
echo "<script>document.getElementById('ContractVal').disabled=true;</script>";
echo "<script>document.getElementById('LicenseVal').value = '$rowed[License_value]';</script>";
echo "<script>document.getElementById('LicenseVal').disabled=true;</script>";

echo "<script>document.getElementById('ActualStartDate').value = '$rowed[sdt]';</script>";
echo "<script>document.getElementById('ActualStartDate').disabled=true;</script>";
echo "<script>document.getElementById('ActualEndDate').value = '$rowed[edt]';</script>";
echo "<script>document.getElementById('ActualEndDate').disabled=true;</script>";

?>


<tr>
<td>Original Budget : </td>
<td>  <input type="text" id="BudgetVal" name="BudgetVal">
 </td>

</tr>
<?php
echo "<script>document.getElementById('BudgetVal').value = '$rowed[budget]';</script>";
echo "<script>document.getElementById('BudgetVal').disabled=true;</script>";
echo "<script>document.getElementById('ExcessBudgetVal').value = '$rowed[excess_budget]';</script>";
echo "<script>document.getElementById('ExcessBudgetVal').disabled=true;</script>";

?>
<tr><td><b>Project Details</b></td></tr>
<tr>
<td>Objectives : </td>
<?php echo "
<td>  <textarea rows=5 cols=40 id='Objectives' name='Objectives' requried>$rowed[Objectives]</textarea> </td>";
?>


<td>Scope : </td>
<?php echo "<td>  <textarea rows=5 cols=40 id='Scope' name='Scope' required>$rowed[Scope]</textarea> </td>";?>

</tr>

<tr>
<td>Success Factor : </td>
<?php echo "
<td>  <textarea rows=5 cols=40 id='Success' name='Success' requried>$rowed[success_factor]</textarea>";?>
 </td>


<?php
echo "<script>document.getElementById('Objectives').value = '$rowed[Objectives]';</script>";
echo "<script>document.getElementById('Objectives').disabled=true;</script>";
echo "<script>document.getElementById('Scope').value = '$rowed[Scope]';</script>";
echo "<script>document.getElementById('Scope').disabled=true;</script>";

echo "<script>document.getElementById('Success').value = '$rowed[success_factor]';</script>";
echo "<script>document.getElementById('Success').disabled=true;</script>";
echo "<td><a href='$rowed[docurl]'>Links to Documentation and Estimation</a></td>";
?>
</tr>
<tr>
<td>			<div id="txtBudget"><table id="finance"></table></div> </td>
</tr>
<tr>
<td>
<input type="submit"  value="Set Warranty Phase">
</td>
</tr>
</table>
</form>

<script>
var formSubmit = function ()
{
	var x = JSON.stringify($("form").serializeArray());
	alert(x);
	//var formData = JSON.stringify($("#projectForm").serializeArray());
	//alert(formData);
  
}

</script>

<?php
require_once('bodyend.php');

?>

