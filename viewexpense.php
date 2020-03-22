<?php
session_name("Project");
session_start();
require_once('dbconn.php');
if(!checkUserSession($_SESSION["user"]))
{
	header("Location:login.php");
}
?>
<html>
<head>

<script>

function showDetails(str)
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
    document.getElementById("txtDetails").innerHTML=xmlhttp.responseText;
    }
  }
  if(document.getElementById("proj"))
  {
  	var e = document.getElementById("proj");
	var stprj = e.options[e.selectedIndex].value;
	if( e.options[e.selectedIndex].text == "Choose...")
	{
        stprj="0";
	}
  }
  else
  {
        stprj="0";
  }
var e = document.getElementById("status");
var sts = e.options[e.selectedIndex].text;

var e = document.getElementById("expID");
var sid = e.value;


var e = document.getElementById("expDesc");
var sdesc = e.value;

//+"&expid="+sid+"&desc="+sdesc
xmlhttp.open("GET","getdetails.php?q="+stprj+"&q1="+sts+"&expid="+sid+"&desc="+sdesc,true);
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
function loadStuff()
{
	showDetails();
	//showCustomer();
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
<body onload="loadStuff();">
<?php include 'header.php'; ?>
<div class="section first">
<h3>View Expense</h3>
</div>
<form name="expenseForm" >
<table>
<tr>
	<td><label class="desc">Status </label></td>
	<td>
		<select class='field select' id='status' onChange='showCustomer();' autofocus>
		<option>SUBMITTED</option>
		<option>ALL</option>
		<option>AUTHORISED</option>
		<option>PAID</option>
		<option>HOLD</option>
		<option>DELETED</option>
		</select>
<?php
if($_GET['x'] !="")
	echo "<script>document.getElementById('status').value = '".$_GET['x']."';</script>";
else

	echo "<script>document.getElementById('status').value = 'SUBMITTED';</script>";
?>
	</td>

</tr>
	<tr>
		<td><label class="desc">Customer </label> </td>
		<td>
			<div id="txtCust"><b></b></div>
		</td>

		<td><label class="desc">Project </label> </td>
		<td>
			<div id="txtProj"><b></b></div>
		</td>
	</tr>
	<tr>
		<td><label class="desc">Expense ID </label> </td>
		
			<td><input type="number"  id="expID" name="expID"></td>
		

		<td><label class="desc">Expense Description </label> </td>
		
			<td><input type="text" id="expDesc" name="expDesc"></td>
		
	</tr>
	<td><input type="button"  value="Fetch" onClick="showDetails();"></td>
</table>
<tr>
<td><div id="txtDetails"><b></b></div></td>
</tr>

</form>
</body>
</html>
