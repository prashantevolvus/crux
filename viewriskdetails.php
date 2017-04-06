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
$riskid=$_GET["risk_id"];

$coned=getConnection();

$sqled="
select a.risk_id,risk_cost,customer_id,project_id,d.risk_type_id,c.name customer , b.project_name project_name , risk_desc,getEmpName(created_by) created_by,created_on,d.risk_type,
containment_plan,contingent_plan,likelihood,impact
from project_risk a
inner join project_details b on a.project_id = b.id
inner join risk_type d on a.risk_type = d.risk_type_id
inner join hr_mysql_live.ohrm_customer c on ohrm_customer_id = c.customer_id where risk_id=".$riskid;
$resulted = mysqli_query($coned,$sqled) or debug($sqled."   failed  <br/><br/>".mysql_error());
$rowed = mysqli_fetch_array($resulted);


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
	
	var statusT = document.forms["projectForm"]["status"];
	statusT.style.background="white";
	var tlr = document.forms["projectForm"]["tlr"];
	tlr.style.background="white";
	
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


	var chk = tlr;
	if(chk.value=="Choose..")
	{
		alert('Traffic Light not selected');
		chk.style.background="pink";
		chk.focus();
                return false;
	}



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
		alert('Actual End Date not entered');
		chk.style.background="pink";
		chk.focus();
                return false;
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
<? include 'header.php'; ?>


<h3>View Risk for a Project</h3>
<?
$_GET['projid']=$rowed[project_id];
include 'operproj.php';
?>

<form name="projectForm" action="updateriskedit.php" method="post" onsubmit="return formSubmit();" >
<table>
<tr>
 <td>Risk Type : </td>
                <td>

            <?
include 'getrisktype.php'; 

echo "<script>document.getElementById('risk').value = '$rowed[risk_type_id]';</script>";
?>
                </td>
</tr>

	<tr>
		<td>Customer : </td>
		<td>

                        <? 
include 'getcustomer.php'; 
echo "<script>document.getElementById('cust').value = '$rowed[customer_id]';</script>";

echo "<script>document.getElementById('cust').disabled=true;</script>";

echo "<script>document.getElementById('risk').disabled=true;</script>";
echo "<b><input name='riskid' id='riskid' type='hidden' value='$riskid'></b>";
?>
		</td>

		<td>Project : </td>
<td>
<?php
$_GET['q'] = $rowed[customer_id];
include 'getprojectnewv.php';
echo "<script>document.getElementById('proj').value = '$rowed[project_id]';</script>";
echo "<script>document.getElementById('proj').disabled=true;</script>";
?>
</td>
	</tr>

<tr>

<td>Likelihood : </td>
<td>
<select id='likelihood' name='likelihood' value='' > <option value='Choose..' selected='selected'>Choose...</option>
	<option value='HIGH'>HIGH</option>
	<option value='MEDIUM'>MEDIUM</option>
	<option value='LOW'>LOW</option>
	<option value='MITIGATED'>MITIGATED</option>
	<option value='OCCURRED'>OCCURRED</option>
</select>
</td>

<td>Impact : </td>
<td>
<select id='impact' name='impact' value='' > <option value='Choose..' selected='selected'>Choose...</option>
	<option value='HIGH'>HIGH</option>
	<option value='MEDIUM'>MEDIUM</option>
	<option value='LOW'>LOW</option>
	<option value='PASS'>PASS</option>
</select>
</td>
<?
echo "<script>document.getElementById('likelihood').value = '$rowed[likelihood]';</script>";
echo "<script>document.getElementById('impact').value = '$rowed[impact]';</script>";
echo "<script>document.getElementById('likelihood').disabled=true;</script>";
echo "<script>document.getElementById('impact').disabled=true;</script>";
?>
<tr>
<td>Risk Description : </td>
<td>  <textarea rows=5 cols=40 id="Desc" name="Desc" required><?echo $rowed[risk_desc]?></textarea>
 </td>
</tr>
<tr>
<td>Containment Plan : </td>
<td>  <textarea rows=5 cols=40 id="Containment" name="Containment" required><?echo $rowed[containment_plan]?></textarea>
 </td>

<td>Contingent Plan : </td>
<td>  <textarea rows=5 cols=40 id="Contingent" name="Contingent" required><?echo $rowed[contingent_plan]?></textarea>
 </td>
</tr>
<tr>
<td>Cost of Risk : </td>
<td><input type="number" id="riskcost" name="riskcost" step=""></td>
<td>Risk Value : </td>
<?

if($rowed[likelihood] == "HIGH" )
{
	$riskvalue = number_format($rowed[risk_cost]*0.7,2);
	echo "<td>High Impact Risk @ 70%  &nbsp  <b>".$riskvalue."</b></td>";
}

if($rowed[likelihood] == "MEDIUM") 
{
	$riskvalue = number_format($rowed[risk_cost]*0.5,2);
	echo "<td>Medium Impact Risk @ 50%  &nbsp  <b>".$riskvalue."</b></td>";
}

if($rowed[likelihood] == "LOW") 
{
	$riskvalue = number_format($rowed[risk_cost]*0.2,2);
	echo "<td>Low Impact Risk @ 20%  &nbsp  <b>".$riskvalue."</b></td>";
}
?>
</tr>


<?
echo "<script>document.getElementById('Desc').disabled=true;</script>";
echo "<script>document.getElementById('riskcost').value = '$rowed[risk_cost]';</script>";
echo "<script>document.getElementById('Containment').disabled=true;</script>";
echo "<script>document.getElementById('Contingent').disabled=true;</script>";
echo "<script>document.getElementById('riskcost').disabled=true;</script>";
?>
</table>

</form>
</body>
</html>
