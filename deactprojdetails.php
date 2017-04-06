<?php
session_name("Project");
session_start();
require_once('dbconn.php');
if(!checkUserSession($_SESSION["user"]))
{
	header("Location:login.php");
}
if(checkProjectPermission("DELIVER") == false)
{

        header("Location:error.php");
}
$projid=$_GET["proj_id"];

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
if(!($rowed[status] == "ACTIVE" || $rowed[status] == "DELIVERED" ||$rowed[status] == "WARRANTY" ))
        header("Location:error1.php");


?>
<html>
<head>

<script>

function formSubmit()
{
	var projType = 	document.forms["projectForm"]["projtype"];
	projType.style.background="white";

	var rptType = document.forms["projectForm"]["rpttype"];
        rptType.style.background="white";

	
	var cust = document.forms["projectForm"]["cust"];
	if(cust)
		cust.style.background="white";

	
	var project = document.forms["projectForm"]["proj"];
	if(project)
		project.style.background="white";

	var pm = document.forms["projectForm"]["pm"];
	pm.style.background="white";
	var pd = document.forms["projectForm"]["pd"];
	pd.style.background="white";
	
	var statusT = document.forms["projectForm"]["statusx"];
	statusT.style.background="white";

	/*var tlr = document.forms["projectForm"]["tlr"];
	tlr.style.background="white";*/
	
	var psdt = document.forms["projectForm"]["PlannedStartDate"];
	psdt.style.background="white";
	
	var pedt = document.forms["projectForm"]["PlannedEndDate"];
	pedt.style.background="white";
	var asdt = document.forms["projectForm"]["ActualStartDate"];
	asdt.style.background="white";
	
	var ardt = document.forms["projectForm"]["ActualEndDate"];
	ardt.style.background="white";
	
	var cval = document.forms["projectForm"]["ContractVal"];
	cval.style.background="white";
	var lval = document.forms["projectForm"]["LicenseVal"];
	lval.style.background="white";
	var bval = document.forms["projectForm"]["BudgetVal"];
	bval.style.background="white";
	var ebval = document.forms["projectForm"]["ExcessBudgetVal"];
	ebval.style.background="white";

	
	var obj = document.forms["projectForm"]["Objectives"];
	obj.style.background="white";
	var scope = document.forms["projectForm"]["Scope"];
	scope.style.background="white";
	var suc = document.forms["projectForm"]["Success"];
	suc.style.background="white";


	var ua = window.navigator.userAgent;
	var msie = ua.indexOf ( "MSIE " );
	if(msie > 0)
	{
		alert("Not Supported in IE. Please use chrome");
		return false;
	}

	
	var chk = projType;
	if(chk.value=="Choose..")
	{
		alert('Project Type not selected');
		chk.style.background="pink";
		chk.focus();
                return false;
	}

        var chk = rptType;
        if(chk.value=="Choose..")
        {
                alert('Report Type not selected');
                chk.style.background="pink";
                chk.focus();
                return false;
        }


	var chk = cust;
	if(chk.value=="Choose..")
	{
		alert('Customer not selected');
		chk.style.background="pink";
		chk.focus();
                return false;
	}

	var chk = project;
	if(chk.value=="Choose..")
	{
		alert('Project not selected');
		chk.style.background="pink";
		chk.focus();
                return false;
	}
	
	var chk = pm;
	if(chk.value=="Choose..")
	{
		alert('Project Manager not selected');
		chk.style.background="pink";
		chk.focus();
                return false;
	}


	var chk = pd;
	if(chk.value=="Choose..")
	{
		alert('Project Director not selected');
		chk.style.background="pink";
		chk.focus();
                return false;
	}

	var chk = statusT;
	if(chk.value=="Choose..")
	{
		alert('Status not selected');
		chk.style.background="pink";
		chk.focus();
                return false;
	}

/*
	var chk = tlr;
	if(chk.value=="Choose..")
	{
		alert('Traffic Light not selected');
		chk.style.background="pink";
		chk.focus();
                return false;
	}
*/


	var chk = psdt;
	if(chk.value=="")
	{
		alert('Planned Start Date not entered');
		chk.style.background="pink";
		chk.focus();
                return false;
	}


	var chk = pedt;
	if(chk.value=="")
	{
		alert('Planned End Date not entered');
		chk.style.background="pink";
		chk.focus();
                return false;
	}

	var chk = asdt;
	if(chk.value=="")
	{
		alert('Actual Start End Date not entered');
		chk.style.background="pink";
		chk.focus();
                return false;
	}


	var chk = ardt;
	if(chk.value=="")
	{
		//alert('Actual End Date not entered');
		chk.style.background="pink";
		chk.focus();
                return true;
	}

	
	var chk = cval;
	if(chk.value=="" || isNaN(parseInt(chk.value)) )
	{
		alert('Contract Value not correctly entered');
		chk.style.background="pink";
		chk.focus();
                return false;
	}


	var chk = lval;
	if(chk.value=="" || isNaN(parseInt(chk.value)) )
	{
		alert('License Value not correctly entered');
		chk.style.background="pink";
		chk.focus();
                return false;
	}


	var chk = bval;
	if(chk.value=="" || isNaN(parseInt(chk.value)) || chk.value == 0)
	{
		alert('Budget not correctly entered');
		chk.style.background="pink";
		chk.focus();
                return false;
	}

	
	var chk = ebval;
	if(isNaN(parseInt(chk.value)) )
	{
		alert('Excess Budget not correctly entered');
		chk.style.background="pink";
		chk.focus();
                return false;
	}


	var chk = obj;
	if(chk.value=="")
	{
		alert('Project Objectives not entered');
		chk.style.background="pink";
		chk.focus();
                return false;
	}


	var chk = scope;
	if(chk.value=="")
	{
		alert('Project Scope not entered');
		chk.style.background="pink";
		chk.focus();
                return false;
	}


	var chk = suc;
	if(chk.value=="")
	{
		alert('Success factor not entered');
		chk.style.background="pink";
		chk.focus();
                return false;
	}
	return true;
	
}

function showBudget(str)
{
//Not requrired for define. Required for others
return;
if(str=='Choose..')
        return;
        document.getElementById('txtBudget').removeChild(document.getElementById('finance'));

if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
        document.getElementById('txtBudget').removeChild(document.getElementById('ajaxloader'));
        document.getElementById("txtBudget").innerHTML=xmlhttp.responseText;
    }
  }

xmlhttp.open("GET","getbudget.php?q="+str,true);

function BeginLoading(){
    var eLoader = document.createElement("img");

    eLoader.src = "images/loader.gif";
    eLoader.alt = "";
    eLoader.id = "ajaxloader";

    document.getElementById('txtBudget').appendChild(eLoader);


    xmlhttp.send();
}

BeginLoading();

}



function showProjectType()
{
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtType").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","getprojtype.php",true);
xmlhttp.send();
}

function showPM()
{
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtProjMan").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","getemp.php?emptype=empPM",true);
xmlhttp.send();
}

function showPD()
{
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtProjDir").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","getemp.php?emptype=empPD",true);
xmlhttp.send();
}

function showProject(str)
{
if(str=='Choose..')
	return;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtProj").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","getprojectnew.php?q="+str,true);
xmlhttp.send();

}

function showCustomer()
{
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtCust").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","getcustomer.php",true);
xmlhttp.send();
}
</script>
</head>
<body onload="showProjectType();">
<? include 'header.php'; 
?>
<tr>
<br>
<td>
<font size="3"><b>Deactivate Project</b></font>
</td>
<?
 if($rowed[tlr]=="GREEN")
                echo "<td ><img src='images/green.jpg' alt='red' width='40' height='40'</img></td>";

        if($rowed[tlr]=="RED")
	echo "<td ><img src='images/red.jpg' alt='red' width='40' height='40'</img></td>";


if($rowed[tlr]=="AMBER")
	echo "<td ><img src='images/amber.jpg' alt='red' width='40' height='40'</img></td>";
$_GET['projid']=$projid;
include 'operproj.php';

?>
</tr>
<form name="projectForm"  action="updateprojstatus.php" method="post" onsubmit="return formSubmit();" >
<table>
<tr>
	<td>Project Type : </td>
	<td>
 <?
include 'getprojtype.php'; ?>
	
</td>
        <td>Base Product : </td>
                <td>
                        <?
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
<?
echo "<b><input name='proj_id' id='proj_id' type='hidden' value='$projid'></b>";
echo "<b><input name='prevstatus' id='prevstatus' type='hidden' value='ACTIVE'></b>";
echo "<b><input name='byFld' id='byFld'  type='hidden' value='project_deactivated_by'></b>";
echo "<b><input name='statuschg' id='statuschg'  type='hidden' value='DEACTIVATED'></b>";
echo "<b><input name='onFld' id='onFld'  type='hidden' value='project_deactivated_on'></b>";
?>

</td>

</tr>
<?
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

                        <? 
include 'getcustomer.php'; ?>
		</td>

		<td>Project : </td>

		<td> <input type = "text" id='proj' name='proj' size='50'></td>
	</tr>

<tr>
</tr>
<?
echo "<script>document.getElementById('cust').value = '$rowed[customer_id]';</script>";
echo "<script>document.getElementById('cust').disabled=true;</script>";
echo "<script>document.getElementById('proj').value = '$rowed[project_name]';</script>";
echo "<script>document.getElementById('proj').disabled=true;</script>";
?>

	<tr>
		<td>Project Manager : </td>
		<td>
                        <? 
$_GET['q']='pm';
include 'getemp.php'; ?>
		</td>

		<td>Project Director : </td>
		<td>

                        <? 
$_GET['q']='pd';
include 'getemp.php'; ?>
		</td>
	</tr>
<?
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
<option value='APPROVED'>AUTHORISED</option>
</select>
</td>
<?
echo "<script>document.getElementById('statusx').value = '$rowed[status]';</script>";
echo "<script>document.getElementById('statusx').disabled=true;</script>";
?>

</tr>

<tr>
<td>Planned Start date : </td>
<td> <input type = "date" id="PlannedStartDate" name="PlannedStartDate"></td>
<td>Planned End Date : </td>
<td> <input type = "date" id="PlannedEndDate" name="PlannedEndDate"></td>
 </td>
</tr>
<?
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
 </td>
</tr>
<?/*
<tr><td><b>Financial Details (in INR)</b></td></tr>
<tr>
<td>Contract Value : </td>
<td>  <input type="text" name="ContractVal" id="ContractVal">
 </td>
<td>License Value : </td>
<td>  <input type="text" name="LicenseVal" id="LicenseVal">
 </td>
</tr>
<?
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
<?
echo "<script>document.getElementById('BudgetVal').value = '$rowed[budget]';</script>";
echo "<script>document.getElementById('BudgetVal').disabled=true;</script>";
echo "<script>document.getElementById('ExcessBudgetVal').value = '$rowed[excess_budget]';</script>";
echo "<script>document.getElementById('ExcessBudgetVal').disabled=true;</script>";

?>
<tr><td><b>Project Details</b></td></tr>
<tr>
<td>Objectives : </td>
<? echo "
<td>  <textarea rows=5 cols=40 id='Objectives' name='Objectives' requried>$rowed[Objectives]</textarea>";
?>
 </td>

<td>Scope : </td>
<? echo "<td>  <textarea rows=5 cols=40 id='Scope' name='Scope' required>$rowed[Scope]</textarea>";?>
 </td>
</tr>

<tr>
<td>Success Factor : </td>
<? echo "
<td>  <textarea rows=5 cols=40 id='Success' name='Success' requried>$rowed[success_factor]</textarea>";?>
 </td>


<?
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
*/?>
<tr>
<td>
<input type="submit"  value="Deactivate Project">
</td>
</tr>
</table>
<td> 
</td>
</form>
</body>
<? closeConnection($coned); ?>

</html>
