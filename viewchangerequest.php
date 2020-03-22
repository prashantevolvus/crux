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

var e = document.getElementById("crstatus");
var s = e.options[e.selectedIndex].text;
if( e.options[e.selectedIndex].text == "Choose...")
{
        s="";
}

var e = document.getElementById("cust");
var s1 = e.options[e.selectedIndex].value;
if( e.options[e.selectedIndex].text == "Choose...")
{
        s1="";
}
s2="";
var e = document.getElementById("proj");
if(e != null )
{
	var s2 = e.options[e.selectedIndex].value;
	if( e.options[e.selectedIndex].text == "Choose...")
	{
        	s2="";
	}
}
xmlhttp.open("GET","getchangerequestlist.php?q="+s+"&q1="+s1+"&q2="+s2,true);
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
<body onLoad="showDetails();">
<?php include 'header.php'; ?>
<h3>View Project Change Request</h3>
<form name="projectListForm" >
<table>
<tr>
	<tr>
		<td>Customer : </td>
		<td>
			<?php include 'getcustomer.php'; ?>
		</td>

		<td>Project : </td>

		<td>

			<div id="txtProj"><b></b></div>
		</td>
<tr>
<td>Status : </td>
<td>
<select id='crstatus' name='crstatus' value='' >
        <option value='Choose...' selected='selected'>Choose...</option>
        <option value='PENDING' >PENDING</option>
        <option value='ACCEPTED' >ACCEPTED</option>
</select>
</td>

</tr>

<td><input type="button"  value="Fetch" onClick="showDetails();"></td>
	</tr>
</table>
<tr>
<td><div id="txtDetails"><b></b></div></td>
</tr>
</form>
</body>
</html>
