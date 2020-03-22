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

$projid=$_GET["proj_id"];

$coned=getConnection();
$sqled="
select id,b.project_type,c.name customer,project_name,
getEmpName(project_manager_id) pm,base_product,
tlr,ohrm_project_id,
getEmpName(project_created_by) crt_by,
a.status, c.customer_id,report_type,b.project_type_id,project_manager_id,project_director_id,
Planned_start_date,Planned_End_date,Actual_Start_Date sdt,Actual_End_Date edt,
project_created_on,
getEmpName(project_modified_by) mod_by,
project_modified_on,
getEmpName(project_authorised_by) auth_by,
project_authorised_on,
getEmpName(project_activated_by) act_by,
project_activated_on,
getEmpName(project_closed_by) close_by,
project_closed_on,
getEmpName(project_delivered_by) delv_by,
project_delivered_on,
getEmpName(project_warranty_by) war_by,
project_warranty_on,
getEmpName(project_deleted_by) del_by,
project_deleted_on,
getEmpName(project_deleted_by) del_by,
project_deleted_on,
getEmpName(project_deactivated_by) deact_by,
project_deactivated_on
 from project_details a
inner join project_type b on a.project_type_id = b.project_type_id
inner join hr_mysql_live.ohrm_customer c on a.ohrm_customer_id= c.customer_id
where id = ".$projid ;
$resulted = mysqli_query($coned,$sqled) or debug($sqled."   failed  <br/><br/>".mysql_error());
$rowed = mysqli_fetch_array($resulted);


?>
<html>
<style type="text/css">
table.gridtable {
	font-family: verdana,arial,sans-serif;
	font-size:11px;
	color:#333333;
	border-width: 1px;
	border-color: #666666;
	border-collapse: collapse;
}
table.gridtable th {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #dedede;
}
table.gridtable td {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #ffffff;
}
</style>
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



function showInvoice(str)
{
//Not requrired for define. Required for others
if(str=='Choose..')
        return;
document.getElementById('txtInvoice').removeChild(document.getElementById('inv'));

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
        document.getElementById('txtInvoice').removeChild(document.getElementById('ajaxloader1'));
        document.getElementById("txtInvoice").innerHTML=xmlhttp.responseText;
    }
  }
var e = document.getElementById("invstatus");
var s = e.options[e.selectedIndex].text;
if( e.options[e.selectedIndex].text == "Choose...")
{
        s="";
}
xmlhttp.open("GET","getinvoicelist.php?q="+s+"&q2="+str,true);

function BeginLoading(){
    var eLoader = document.createElement("img");

    eLoader.src = "images/loader.gif";
    eLoader.alt = "";
    eLoader.id = "ajaxloader1";

    document.getElementById('txtInvoice').appendChild(eLoader);


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
<?php echo "<body>"?>
<?php
 include 'header.php'; 


?>
<tr>
<br>
<td>
<font size="3"><b>View Financial Details</b></font>
</td>
<?php
 if($rowed[tlr]=="GREEN")
                echo "<td ><img src='images/green.jpg' alt='red' width='40' height='40'</img></td>";

        if($rowed[tlr]=="RED")
echo "<td ><img src='images/red.jpg' alt='red' width='40' height='40'</img></td>";


if($rowed[tlr]=="AMBER")
echo "<td ><img src='images/amber.jpg' alt='red' width='40' height='40'</img></td>";
$_GET['projid']=$projid;
include 'operproj.php';
?>
</tr>
<form name="projectForm"  method="post" onsubmit="return formSubmit();" >
<table>

<?php echo "<b><inputname='projid' id='projid' type='hidden' value='$projid'></b>";
echo "<script>document.getElementById('projid').disabled=true;</script>";
?>

</td>

</tr>

	<tr>
		<td>Customer : </td>
		<td>

                        <?php
include 'getcustomer.php'; ?>
		</td>

		<td>Project : </td>

		<td> <input type = "text" id='proj' name='proj' size='50'></td>
	</tr>

<tr>
</tr>
<?php
echo "<script>document.getElementById('cust').value = '$rowed[customer_id]';</script>";
echo "<script>document.getElementById('cust').disabled=true;</script>";
echo "<script>document.getElementById('proj').value = '$rowed[project_name]';</script>";
echo "<script>document.getElementById('proj').disabled=true;</script>";
?>

</tr>



</table>
<tr>
<h4>Financial Details</h4>
</tr>
<tr>
<td>                    <div id="txtBudget"><table id="finance"></table></div> </td>
</tr>

<tr>
<h4>Invoice List</h4>
</tr>
<tr>
<td>Status : </td>
<td>
<select id='invstatus' name='invstatus' value='' >
        <option value='Choose...' selected='selected'>Choose...</option>
        <option value='PENDING' >PENDING</option>
        <option value='INVOICED' >INVOICED</option>
        <option value='PAID' >PAID</option>
</select>
</td>
<?php
echo "<td><input type='button'  id='fetch' name='fetch' value='Get Invoices' onClick=showInvoice($rowed[id]);></td>";
?>

</tr>

<tr>
<td>                    <div id="txtInvoice"><table id="inv"></table></div> </td>
<?php 
echo "<script>showBudget($rowed[id]);</script>";
?>

</form>
</body>
</html>
