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
	var project = document.forms["projectForm"]["proj"];
	if(project)
                project.style.background="white";
	var chk = project;
        if(typeof chk === "undefined")
        {
                alert('Project not Entered');
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
xmlhttp.open("GET","getprojectnewinvoice.php?q="+str,true);
xmlhttp.send();

}



function showCR(str)
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
    document.getElementById("txtCR").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","getcr.php?q="+str,true);
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
<body >
<?php include 'header.php'; ?>


<h3>Add Invoice</h3>

<form name="projectForm" action="updateinvoice.php" method="post" onsubmit="return formSubmit();" >
<table>
<tr>
 <td> Milestone : </td>
                <td>

            <?php
include 'getmilestone.php'; ?>
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
<td>Change Request</td>
<td>
 <div id="txtCR"><b></b></div>
                </td>
				</tr>
<td>Status : </td>
<td>
<select id='status' name='status' value='' >
	<option value='PENDING' selected='selected'>PENDING</option>
</select>
</td>
<td>Contract Percentage : </td>
<td><input type="number" text-align="right" step="any" id="pcnt" name="pcnt" required><td><b>%</b>
</tr>
<tr>
<td>Invoice Amount (Contract Currency) : </td>
<td><input type="number" text-align="right" step="any" id="prjccyamount" name="prjccyamount" required></td>
<td>Invoice Amount (INR) : </td>
<td><input type="number" text-align="right" step="any" id="amount" name="amount" required><td>
</tr>
<!--
<tr>
<td>Invoice No : </td>
<td> <input type = "text" id="InvoiceNo" name="InvoiceNo"></td>
<td>Invoiced Date : </td>
<td> <input type = "date" id="InvoiceDate" name="InvoiceDate" ></td>
 </td>
</tr>
-->
<tr>
<td>Expected Invoice date : </td>
<td> <input type = "date" id="ExpectedInvDate" name="ExpectedInvDate" required></td>
<td>Expected Pay Date : </td>
<td> <input type = "date" id="ExpectedPayDate" name="ExpectedPayDate" required></td>
 </td>
</tr>

<tr>
<td>Description : </td>
<td>  <textarea rows=5 cols=40 id="Desc" name="Desc" required></textarea>
 </td>
</tr>

</table>

<td> 
<input type="submit"  value="Submit"> 
</td>
</form>
</body>
</html>
