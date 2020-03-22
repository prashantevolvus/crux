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
//Testing
$crid=$_GET["cr_id"];

$coned=getConnection();
$sqled="
select cr_name,a.project_id,b.ohrm_project_id,c.customer_id,cr_id , c.name customer , b.project_name, 
cr_amount,cr_start_date,a.status ,a.description,a.po_name,a.po_date
from project_cr a
inner join project_details b on a.project_id = b.id
inner join hr_mysql_live.ohrm_customer c on ohrm_customer_id = c.customer_id
where cr_id = ".$crid ;

$resulted = mysqli_query($coned,$sqled) or debug($sqled."   failed  <br/><br/>".mysql_error());
$rowed = mysqli_fetch_array($resulted);

if($rowed[status] != "PENDING")
        header("Location:error1.php");


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
<body >
<?php include 'header.php'; ?>


<h3>Accept Change Request</h3>
<?php
$_GET['projid']=$rowed[project_id];
include 'operproj.php';
?>

<form name="projectForm" action="updateacceptcr.php" method="post" onsubmit="return formSubmit();" >
<table>


	<tr>
		<td>Customer : </td>
		<td>
<?php
include 'getcustomer.php';
echo "<script>document.getElementById('cust').value = '$rowed[customer_id]';</script>";
echo "<script>document.getElementById('cust').disabled=true;</script>";
?>
</td>
                       

		<td>Project : </td>

		<td> 
<?php			
$_GET['q'] = $rowed[customer_id];
include 'getprojectnewex.php';
echo "<script>document.getElementById('proj').value = '$rowed[project_id]';</script>";
echo "<script>document.getElementById('proj').disabled=true;</script>";
?>	
		</td>
	</tr>
<tr>
		<td>Change Request Name : </td>

		<td> <input type = "text" id='crname' name='crname' size='50' required></td>
		</tr>
<tr>
<td>Status : </td>
<td>
<select id='status' name='status' value='' >
	<option value='PENDING' selected='selected'>PENDING</option>
 <option value='INVOICED' selected='selected'>INVOICED</option>
        <option value='PAID' selected='selected'>PAID</option>

</select>
</td>
<td>CR Amount : </td>
<td><input type="number" text-align="right" step="any" id="cramount" name="cramount" required><td><b>%</b>
</tr>
<tr>
<td>Expected Start date : </td>
<td> <input type = "date" id="ExpectedStartDate" name="ExpectedStartDate" required></td>
</tr>

<tr>
<td>PO Name : </td>
<td> <input type = "text" id="POName" name="POName" required></td>
</tr>

<tr>
<td>PO Date: </td>
<td> <input type = "date" id="PODate" name="PODate" required></td>
</tr>

<tr>
<td>Description : </td>
<td>  <textarea rows=10 cols=60 id="Desc" name="Desc" required><?echo $rowed[description];?></textarea>
 </td>
</tr>

<?php
echo "<script>document.getElementById('crname').value = '$rowed[cr_name]';</script>";
echo "<script>document.getElementById('crname').disabled=true;</script>";

echo "<script>document.getElementById('status').value = '$rowed[status]';</script>";
echo "<script>document.getElementById('status').disabled=true;</script>";
echo "<script>document.getElementById('cramount').value = '$rowed[cr_amount]';</script>";
echo "<script>document.getElementById('cramount').disabled=true;</script>";


echo "<script>document.getElementById('ExpectedStartDate').value = '$rowed[cr_start_date]';</script>";
echo "<script>document.getElementById('ExpectedStartDate').disabled=true;</script>";

echo "<script>document.getElementById('POName').value = '$rowed[po_name]';</script>";
echo "<script>document.getElementById('POName').disabled=true;</script>";

echo "<script>document.getElementById('PODate').value = '$rowed[po_date]';</script>";
echo "<script>document.getElementById('PODate').disabled=true;</script>";

echo "<script>document.getElementById('Desc').value = '$rowed[description]';</script>";
echo "<script>document.getElementById('Desc').disabled=true;</script>";

echo "<b><input name='cr_id' id='cr_id' type='hidden' value='$crid'></b>";
echo "<b><input name='ohrm_project_id' id='ohrm_project_id' type='hidden' value='$rowed[ohrm_project_id]'></b>";

echo "<b><input name='cramount1' id='cramount1' type='hidden' value='$rowed[cr_amount]'></b>";
?>

</table>
<td> 
<input type="submit"  value="Submit"> 
</td>
</form>
</body>
</html>
