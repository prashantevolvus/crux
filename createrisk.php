<?php
session_name("Project");
session_start();
require_once('dbconn.php');
if(!checkUserSession($_SESSION["user"]))
{
	header("Location:login.php");
}
if(checkProjectPermission("INITIATE") == false)
{

        header("Location:error.php");
}

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
xmlhttp.open("GET","getprojectnewr.php?q="+str,true);
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
<?php include 'header.php';?>


<h3>Define Risk for a Project</h3>

<form name="projectForm" action="updaterisk.php" method="post" onsubmit="return formSubmit();" >
<table>
<tr>
 <td>Risk Type : </td>
                <td>

            <?php
include 'getrisktype.php';?>
                </td>
</tr>

	<tr>
		<td>Customer : </td>
		<td>

                        <?php 
include 'getcustomer.php'; ?>
		</td>

		<td>Project : </td>

		<td> 
			<div id="txtProj"><b></b></div>	
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
<tr>
<td>Risk Description : </td>
<td>  <textarea rows=5 cols=40 name="Desc" required></textarea>
 </td>
</tr>
<tr>
<td>Containment Plan : </td>
<td>  <textarea rows=5 cols=40 name="Containment" required></textarea>
 </td>

<td>Contingent Plan : </td>
<td>  <textarea rows=5 cols=40 name="Contingent" required></textarea>
 </td>
</tr>
<tr>
<td>Cost of Risk : </td>
<td><input type="number" id="riskcost" name="riskcost" step=""></td>
</tr>


</table>

<td> 
<input type="submit"  value="Submit"> 
</td>
</form>
</body>
</html>
