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

?>
<html>
<head>

<script>
function showDetails(loading)
{
if(document.getElementById('detailsProj'))
	document.getElementById('txtDetails').removeChild(document.getElementById('detailsProj'));
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
	document.getElementById('txtDetails').removeChild(document.getElementById('ajaxloader'));
    document.getElementById("txtDetails").innerHTML=xmlhttp.responseText;
    }
  }
if(loading == true)
	stxload = true;
else
	stxload = false;
	
//var closed = document.getElementById("closed").checked;
var e = document.getElementById("status");
var sts = e.options[e.selectedIndex].text;
if( e.options[e.selectedIndex].text == "All")
{
        sts="";
}
else
{
	var stat="''";
	var x = 0;
	
	for (x=0;x<e.length;x++)
	{
		//alert(e[x].selected + e[x].value);
		if(e[x].selected == true)
		{
			stat="'"+e[x].value+"',"+stat;
			
		}
		
	}
	sts=stat;

}
var e = document.getElementById("cust");
var str = e.options[e.selectedIndex].value;
if( e.options[e.selectedIndex].text == "Choose...")
{
	str="";
}
var e = document.getElementById("prod");
var stt = e.options[e.selectedIndex].value;
if( e.options[e.selectedIndex].text == "Choose...")
{
        stt="";
}
var e = document.getElementById("pm");
var stpm = e.options[e.selectedIndex].value;
if( e.options[e.selectedIndex].text == "Choose...")
{
        stpm="";
}
var e = document.getElementById("tlr");
var sttlr = e.options[e.selectedIndex].value;
if( e.options[e.selectedIndex].text == "Choose...")
{
        sttlr="";
}
var e = document.getElementById("bdgt");
var stbdgt = e.options[e.selectedIndex].value;
if( e.options[e.selectedIndex].text == "Choose...")
{
        stbdgt="";
}

var e = document.getElementById("projtype");
var stprojtype = e.options[e.selectedIndex].value;
if( e.options[e.selectedIndex].text == "Choose...")
{
        stprojtype="";
}


xmlhttp.open("GET","getprojlist.php?q="+str+"&q1="+sts+"&q2="+stt+"&q3="+stpm+"&q4="+sttlr+"&q5="+stbdgt+"&q6="+stxload+"&q7="+stprojtype,true);

function BeginLoading(){
    var eLoader = document.createElement("img");

    eLoader.src = "images/loader.gif";
    eLoader.alt = "";
    eLoader.id = "ajaxloader";

    document.getElementById('txtDetails').appendChild(eLoader);


    xmlhttp.send();
}

BeginLoading();

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
xmlhttp.open("GET","getproject1.php?q="+str,true);
xmlhttp.send();
}

function showCustomer(first)
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
<body>
<?php include 'header.php'; ?>
<h3>Month Statistics</h3>
<form name="projectListForm" >
<table>
<tr>
	<!--<td><input type="checkbox" id = 'closed' name='closed' value="closed">Display Closed</td> -->
 <td>Base Product : </td>
                <td>
                        <?php
include 'getprodtype.php'; ?>
                </td>
		<td>Project Type : </td>
		<td>
<?php include 'getprojtype.php'; ?>

		</td>
 <td>

</tr>
	<tr>
		<td>Customer : </td>
		<td>
<?php include 'getcustomer.php'; ?>

		</td>
 <td>
Project Manager</td>
<td>                        <?php
$_GET['q']='pm';
include 'getemp.php'; ?>
                </td>

	</tr>
</table>
<tr>
<td><input type="button"  value="Fetch" onClick="showDetails(false);"></td>
	</tr>
<tr>
<td><div id="txtDetails"><b></b></div></td>
</tr>
</form>
</body>
</html>
