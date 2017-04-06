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


  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.13/datatables.min.js"></script>


<script>
  $(document).ready( function () {
    $('#invlist').DataTable({
  "pagingType": "full_numbers",
  "lengthMenu": [ [10, 25, 50, 100,-1], [10, 25, 50, 100,"All"] ],
  "pageLength": 50
} );
} );

</script>


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
var s = "";
var stat1 = "";
var e = document.getElementById("invstatus");
s = e.options[e.selectedIndex].text;
if( e.options[e.selectedIndex].text == "All")
{
        s="";
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
	s=stat;
	
	
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
s3="";
var e = document.getElementById("pm");
if(e != null )
{
	var s3 = e.options[e.selectedIndex].value;
	if( e.options[e.selectedIndex].text == "Choose...")
	{
        	s3="";
	}
}

s4="";
var e = document.getElementById("ExpectedInvoiceDate");
if(e != null )
{
	var s4 = e.value;
	
}

s5="";
var e = document.getElementById("ExpectedPayDate");
if(e != null )
{
	var s5 = e.value;
	
}

s6="";
var e = document.getElementById("ActualInvoiceDate");
if(e != null )
{
	var s6 = e.value;
	
}

s7="";
var e = document.getElementById("ActualPayDate");
if(e != null )
{
	var s7 = e.value;
	
}
//xmlhttp.open("GET","getinvoicelist.php?q="+s+"&q1="+s1+"&q2="+s2+"&q3="+s3,true);

xmlhttp.open("GET","getinvoicelist.php?q="+s+"&q1="+s1+"&q2="+s2+"&q3="+s3+"&q4="+s4+"&q5="+s5+"&q6="+s6+"&q7="+s7,true);
xmlhttp.send();
}

function showProjection()
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
var s = "";
var stat1 = "";
var e = document.getElementById("invstatus");
s = e.options[e.selectedIndex].text;
if( e.options[e.selectedIndex].text == "All")
{
        s="";
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
	s=stat;
	
	
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
s3="";
var e = document.getElementById("pm");
if(e != null )
{
	var s3 = e.options[e.selectedIndex].value;
	if( e.options[e.selectedIndex].text == "Choose...")
	{
        	s3="";
	}
}

s4="";
var e = document.getElementById("ExpectedInvoiceDate");
if(e != null )
{
	var s4 = e.value;
	
}

s5="";
var e = document.getElementById("ExpectedPayDate");
if(e != null )
{
	var s5 = e.value;
	
}

s6="";
var e = document.getElementById("ActualInvoiceDate");
if(e != null )
{
	var s6 = e.value;
	
}

s7="";
var e = document.getElementById("ActualPayDate");
if(e != null )
{
	var s7 = e.value;
	
}

//xmlhttp.open("GET","getinvoicelist.php?q="+s+"&q1="+s1+"&q2="+s2+"&q3="+s3,true);

xmlhttp.open("GET","getinvoiceProjection.php?q="+s+"&q1="+s1+"&q2="+s2+"&q3="+s3+"&q4="+s4+"&q5="+s5+"&q6="+s6+"&q7="+s7,true);
//xmlhttp.open("GET","getinvoiceProjection..php",true);
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
<? include 'header.php'; ?>
<h3>View Project InvoiceX</h3>
<form name="projectListForm" >
<table>
<td>Status : </td>
<td>
<select id='invstatus' name='invstatus' value='' multiple='multiple' >
        <option value='All' selected='selected'>All</option>
        <option value='PENDING' >PENDING</option>
        <option value='INVOICED' >INVOICED</option>
        <option value='PAID' >PAID</option>
</select>
</td>
		<td>Project Manager : </td>
		<td>
                        <? 
$_GET['q']='pm';
include 'getemp.php'; ?>
		</td>
				<td>Customer : </td>
		<td>
			<?include 'getcustomer.php'; ?>
			
		</td>

		<td>Project : </td>

		<td>

			<div id="txtProj"><b></b></div>
		</td>

	</table>
<table>
<b class='floating'>Only Month and Year will be considered for Search</b>
	<td>Expected Invoice : </td>
		<td>
<td> <input type = "date" id="ExpectedInvoiceDate" name="ExpectedInvoiceDate" ></td>
<td>Expected Payment : </td>
		<td>
<td> <input type = "date" id="ExpectedPayDate" name="ExpectedPayDate" ></td>

</tr>

<tr>
	<td>Actual Invoice : </td>
		<td>
<td> <input type = "date" id="ActualInvoiceDate" name="ActualInvoiceDate" ></td>
<td>Actual Payment : </td>
		<td>
<td> <input type = "date" id="ActualPayDate" name="ActualPayDate" ></td>

</tr>
</table>
<table>
<tr>
	<tr>
<tr>

<td><input type="button"  value="Fetch" onClick="showDetails();"></td>
<td><input type="button"  value="Projection" onClick="showProjection();"></td>

	</tr>
</table>
<tr>
<td><div id="txtDetails"><b></b></div></td>
</tr>
</form>
</body>
</html>
