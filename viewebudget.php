<?php
session_name("Project");
session_start();
$_SESSION['url'] = $_SERVER['REQUEST_URI']; 
require_once('dbconn.php');
if(!checkUserSession($_SESSION["user"]))
{
	header("Location:login.php");
}
?>
<html>
<head>

<script>

function showDetails()
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
    document.getElementById("txtDetails").innerHTML=xmlhttp.responseText;
    }
  }
var e = document.getElementById("status");
var sts = e.options[e.selectedIndex].text;
var e = document.getElementById("proj");
if(e)
{
	var str = e.options[e.selectedIndex].value;
	if( e.options[e.selectedIndex].text == "Choose...")
	{
		str="";
	}
}
else
	str="";
var e = document.getElementById("cust");
if(e)
{
	var str1 = e.options[e.selectedIndex].value;
	if( e.options[e.selectedIndex].text == "Choose...")
	{
		str1="";
	}
}
else
	str1="";

xmlhttp.open("GET","getebudgetlist.php?q="+str+"&q1="+sts+"&q2="+str1,true);
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
xmlhttp.open("GET","getprojectnewex.php?q="+str,true);
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
<body onload="showDetails();">
<?php include 'header.php';?>
<h3>View Project Budget Proposals</h3>
<form name="projectListForm" >
<table>
<tr>
	<td>Status : </td>
	<td>
		<select id='status'>
		<option>INITIATED</option>
		<option>AUTHORISED</option>
		<option>CANCELLED</option>
		</select>
	</td>
</tr>
	<tr>
		<td>Customer:</td>
		<td>
			<?php include 'getcustomer.php';?>
		</td>

		<td>Project :</td>
		<td>
			<div id="txtProj"><b></b></div>
		</td>
		
<td><input type="button"  value="Fetch" onClick="showDetails();"></td>
</tr>
</table>
<table>
<tr>

<td><div id="txtDetails"><b></b></div></td>
</tr>
</table>

</form>
</body>
</html>
