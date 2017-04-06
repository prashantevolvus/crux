<?php
session_name("Project");
session_start();
$_SESSION['url'] = $_SERVER['REQUEST_URI']; 
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
var tableToExcel = (function () {
        var uri = 'data:application/vnd.ms-excel;base64,'
        , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
        , base64 = function (s) { return window.btoa(unescape(encodeURIComponent(s))) }
        , format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }
        return function (table, name, filename) {
            if (!table.nodeType) table = document.getElementById(table)
            var ctx = { worksheet: name || 'Worksheet', table: table.innerHTML }

            document.getElementById("dlink").href = uri + base64(format(template, ctx));
            document.getElementById("dlink").download = filename;
            document.getElementById("dlink").click();

        }
    })()

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
<body onload="showDetails(true);">
<? include 'header.php'; ?>
<h3>View Projects</h3>
<form name="projectListForm" >
<table>
<tr>
	<td>Status : </td>
	<td>
		<select id='status' autofocus multiple='multiple'>
		<option selected='selected' >All</option>
		<option>INITIATED</option>
		<option>AUTHORISED</option>
		<option>APPROVED</option>
		<option>ACTIVE</option>
		<option>PENDING INVOICE</option>
		<option>WARRANTY</option>
		<option>DELIVERED</option>
		<option>DEACTIVATED</option>
		<option>CLOSED</option>
		<option>INITIATE CLOSURE</option>
		<option>AUTHORISE CLOSURE</option>
		<option>DELETED</option>
		</select>
	</td>
	<!--<td><input type="checkbox" id = 'closed' name='closed' value="closed">Display Closed</td> -->
 <td>Base Product : </td>
                <td>
                        <?
include 'getprodtype.php'; ?>
                </td>
		<td>Project Type : </td>
		<td>
<?include 'getprojtype.php'; ?>

		</td>
 <td>

<td>Traffic Light : </td>
<td>
<select id='tlr' name='tlr' value =''>
<option value='Choose..' selected='selected'>Choose...</option>
<option value='GREEN'>GREEN</option>
<option value='AMBER'>AMBER</option>
<option value='RED'>RED</option>
</select>
</td>


</tr>
	<tr>
		<td>Customer : </td>
		<td>
<?include 'getcustomer.php'; ?>

		</td>
 <td>
Project Manager</td>
<td>                        <?
$_GET['q']='pm';
include 'getemp.php'; ?>
                </td>
<td>Budget Exceeded : </td>
<td>
<select id='bdgt' name='bdgt' value =''>
<option value='Choose..' selected='selected'>Choose...</option>
<option value='YES'>YES</option>
<option value='NO'>NO</option>
</select>
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
