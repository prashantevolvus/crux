<?php
session_name("Project");
session_start();
require_once('dbconn.php');
if(!checkUserSession($_SESSION["user"]))
{
	header("Location:login.php");
}
if(checkPermission("CREATE") == false)
{

        header("Location:error.php");
}

?>
<html>
<head>


<script>

function formSubmit()
{
	document.forms["expenseForm"]["ExpenseDet"].style.background="white";
	document.forms["expenseForm"]["ExpenseAmt"].style.background="white";
	document.forms["expenseForm"]["ExpenseDate"].style.background="white";

	var ua = window.navigator.userAgent;
	var msie = ua.indexOf ( "MSIE " );
	if(msie > 0)
	{
		alert("Not Supported in IE. Please use chrome");
		return false;
	}
	
	var bdg = document.forms["expenseForm"]["budgettogo"];
	if(!bdg)
	{
		alert('Project details not selected');
                return false;
	}
	
	var details = document.forms["expenseForm"]["ExpenseDet"].value;
	if(!details)
	{
		alert('Details cannot be blank');
		
		document.forms["expenseForm"]["ExpenseDet"].style.background="pink";
		document.forms["expenseForm"]["ExpenseDet"].focus();
                return false;
	}
	
	var dt =document.forms["expenseForm"]["ExpenseDate"].value;	

	if(!dt)
	{
		alert("Date cannot be blank");
		document.forms["expenseForm"]["ExpenseDate"].style.background="pink";
		document.forms["expenseForm"]["ExpenseDate"].focus();
		return false;
	}
	if(new Date(dt)>new Date()){
		alert('Date must not be in the future!');
		document.forms["expenseForm"]["ExpenseDate"].style.background="pink";
		document.forms["expenseForm"]["ExpenseDate"].focus();
		return false;
	}
	var i1 = (document.forms["expenseForm"]["budgettogo"].value);
	var i2 = (document.forms["expenseForm"]["ExpenseAmt"].value);
	
	if (i2=="" || parseInt(i2) == 0)
	{
		alert('Amount cannot be blank or zero');
		document.forms["expenseForm"]["ExpenseAmt"].style.background="pink";
		document.forms["expenseForm"]["ExpenseAmt"].focus();
		return false;
	}
	var ix1 = (document.forms["expenseForm"]["cust"].value);	
	//Bypass budget for customer = Internal(9) for now
	if (parseInt(i1) < parseInt(i2) && parseInt(ix1) !=9 && parseInt(ix1) !=8)
	{
		//alert('No budget for this expense. Please get an approval for excess Budget');
	//	document.forms["expenseForm"]["ExpenseAmt"].style.background="pink";
	//	document.forms["expenseForm"]["ExpenseAmt"].focus();
		return true;
	}

	
	return true;
	
}
function showBudget(str)
{
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

xmlhttp.open("GET","getohrmbudget.php?q="+str,true);

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

function showExpense()
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
    	document.getElementById("txtExp").innerHTML=xmlhttp.responseText;
	document.forms["expenseForm"]["expense"].focus();
    }
  }
xmlhttp.open("GET","getexpense.php",true);
xmlhttp.send();

}

function showEMP()
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
    document.getElementById("txtEmp").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","getemp1.php",true);
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
xmlhttp.open("GET","getproject.php?q="+str,true);
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
<body id="public" onload="showExpense();">
<div id="container">

<?php include 'header.php'; ?>

<div class="section first">
<h3>Create Expense</h3>
</div>
<form  name="expenseForm" action="update.php" method="post" enctype="multipart/form-data" onsubmit="return formSubmit();" >
<table>
<tr>
	<td><label class="desc" >Expense Type <span class="req">*</span> </td> 
<td>		<div id="txtExp"></div> </td>
</tr>
<tr>
        <td><label class="desc">On Behalf of <span class="req">*</span> </td>
<td>            <div id="txtEmp"></div> </td>
</tr>

	<tr>
<td><label class="desc">Customer<span class="req">*</span></label> </td>
		<td>
			<div id="txtCust"></div>
		</td>

<td><label class="desc">Project<span class="req">*</span></label> </td>
		<td>
			<div id="txtProj"></div>
		</td>
	</tr>
<tr>
<td><span><label class="desc">Expense Details<span class="req">*</span></label> </span></td>
<td>  <textarea  class="field textarea medium" name="ExpenseDet" rows="4" cols="50" required></textarea>
 </td>
</tr>

<tr>
<td><label class="desc">Expense Amount (in INR)<span class="req">*</span></label> </td>
<td>  <input class="field text currency" type="number" name="ExpenseAmt" required>
 </td>
</tr>
<tr>

<td><label class="desc">Expense date <span class="req">*</span></label> </td>
<td> <input class="field text" type = "date" id="ExpenseDate" name="ExpenseDate" required></td>
</tr>
</table>

<tr>
<td class="desc">			<div  id="txtBudget"><table id="finance"></table></div> </td>
</tr>
<td> 
<input type="submit"  value="Submit Expense"> 
</td>
</form>
</div>
</body>
</html>