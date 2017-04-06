<?php
session_name("Project");
session_start();
require_once('dbconn.php');
if( !checkUserSession($_SESSION["user"]))
{
	echo "<script>window.top.location.href='login.php'</script>";
	//header("Location:login.php");
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

	var prod =  document.forms["projectForm"]["prod"];
        prod.style.background="white";


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
	
	var cval = document.forms["projectForm"]["ContractVal"];
	cval.style.background="white";
	var lval = document.forms["projectForm"]["LicenseVal"];
	
	lval.style.background="white";
	var bval = document.forms["projectForm"]["BudgetVal"];
	bval.style.background="white";


	
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
	var chk = prod;
        if(chk.value=="Choose..")
        {
                alert('Base Product not selected');
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
	if(chk.value=="")
	{
		alert('Project not Entered');
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
	/*
	alert(pedt.value);
	var d1 = new date('2013-12-12');

	var d2 = new date('2012-12-12');

	alert(pedt.value);
	if(d2 > d1)
	{
	 	alert('Planned End Date cannot be greater than Start Date');
                chk.style.background="pink";
                chk.focus();
                return false;
        }

	*/	


	
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
<? include 'header.php'; ?>


<h3>Initiate Project</h3>

<form name="projectForm" action="updateproject.php" method="post" onsubmit="return formSubmit();" >
<table>
<tr>
	<td>Project Type : </td>
	<td>
		<div id="txtType"><b></b></div>
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
</td>

</tr>
	<tr>
		<td>Customer : </td>
		<td>

                        <? 
include 'getcustomer.php'; ?>
		</td>

		<td>Project : </td>

		<td> <input type = "text" id='proj' name='proj' size='50' maxlength='45' required></td>
	</tr>

<tr>
</tr>
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
<tr>
<td>Project Status : </td>
<td> 
<select id='status' name='status' value =''>
<option value='Choose..' selected='selected'>Choose...</option>
<option value='INITIATED'>INITIATED</option>
</select>
</td>
<td>Traffic Light Report : </td>

<td> 
<select id='tlr' name='tlr' value =''>
<option value='Choose..' selected='selected'>Choose...</option>
<option value='GREEN'>GREEN</option>
<option value='AMBER'>AMBER</option>
<option value='RED'>RED</option>
</select>
</td>
</tr>
 <b><input name='prevstatus' id='prevstatus' type='hidden' value='NONE'></b>
<tr>
<td>Planned Start date : </td>
<td> <input type = "date" id="PlannedStartDate" name="PlannedStartDate" required></td>
<td>Planned End Date : </td>
<td> <input type = "date" id="PlannedEndDate" name="PlannedEndDate" required></td>
 </td>
</tr>

<tr>
<td>Actual Start date : </td>
<td> <input type = "date" id="ActualStartDate" name="ActualStartDate" required></td>
<td> Actual End Date : </td>
<td> <input type = "date" id="ActualEndDate" name="ActualEndDate" requried></td>
 </td>
</tr>
<tr><td><b>Financial Details (in INR)</b></td></tr>
<tr>
<td>Contract Value : </td>
<td>  <input type="text" name="ContractVal">
 </td>
<td>License Value : </td>
<td>  <input type="text" name="LicenseVal">
 </td>
</tr>


<tr>
<td>Original Budget : </td>
<td>  <input type="text" name="BudgetVal" required>
 </td>
<td>AMC % : </td>
<td>  <input type="text" name="AMC" id="AMC" required>
 </td>
</tr>
<tr>
<td>Purchase Order : </td>
<td>  <input type="text" name="PO" id="PO" >
 </td>
 <td>Purchase Order : </td>
<td>  <input type="date" name="PODate" id="PODate" >
 </td>
</tr>

<tr><td><b>Project Details</b></td></tr>
<tr>
<td>Objectives : </td>
<td>  <textarea rows=5 cols=40 name="Objectives" required></textarea>
 </td>

<td>Scope : </td>
<td>  <textarea rows=5 cols=40 name="Scope" required></textarea>
 </td>
</tr>

<tr>
<td>Success Factor : </td>
<td>  <textarea rows=5 cols=40 name="Success" required></textarea>
 </td>

<td>Project Manager Remarks : </td>
<td>  <textarea rows=5 cols=40 name="PMRemarks" required></textarea>
 </td>
</tr>
<tr>

 <td>Links to Documentation and Estimation : </td>
<td>  <input type='url'name="docurl" size=50 required></textarea>
 </td>
</tr>

<tr>
<td>			<div id="txtBudget"><table id="finance"></table></div> </td>
</tr>

</table>
<td> 
<input type="submit"  value="Submit"> 
</td>
</form>
</body>
</html>
