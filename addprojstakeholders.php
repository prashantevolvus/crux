<?php
session_name("Project");
session_start();
require_once('dbconn.php');
if(!checkUserSession($_SESSION["user"]))
{
	header("Location:login.php");
}
if(checkProjectPermission("STAKE") == false)
{

        header("Location:error.php");
}

$projid=$_GET["proj_id"];

$coned=getConnection();
$sqled="
select id,b.project_type,c.name customer,project_name,
concat(d.emp_firstname,' ',d.emp_lastname) pm,base_product,
ifnull(Budget,0) budget , ifnull(Excess_budget,0) excess_budget,
Contract_value,License_value,
tlr,extension,
concat(e.emp_firstname,' ',e.emp_lastname) crt_by,
a.status, c.customer_id,report_type,b.project_type_id,project_manager_id,project_director_id,
Planned_start_date,Planned_End_date,Actual_Start_Date sdt,Actual_End_Date edt,
Objectives, Scope, success_factor, docurl
 from project_details a
inner join project_type b on a.project_type_id = b.project_type_id
inner join hr_mysql_live.ohrm_customer c on a.ohrm_customer_id= c.customer_id
inner join hr_mysql_live.hs_hr_employee d on a.project_manager_id= d.emp_number
inner join hr_mysql_live.hs_hr_employee e on a.Project_created_by= e.emp_number
where id = ".$projid ;
$resulted = mysqli_query($coned,$sqled) or debug($sqled."   failed  <br/><br/>".mysql_error());
$rowed = mysqli_fetch_array($resulted);


?>
<html>
<head>

<script>
function show()
{
alert('hello');
return;

document.getElementById('txtDetails').removeChild(document.getElementById('finance'));


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
xmlhttp.open("GET","getrisklist.php?q="+str,true);

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


function showProjectType()
{
alert('hello');
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
<body>
<?

include 'header.php';
?>
<tr>
<br>
<td>
<font size="3" face="arial"><b>Update Project Stakeholders</b></font>
</td>
<?
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
<form name="projectForm"  action="updateprojstake.php" method="post" onsubmit="return formSubmit();" >
<table>
<tr>
<td>Project Type : </td>
<td>
<?
include 'getprojtype.php'; ?>

</td>
<td>Base Product : </td>
	<td>
		<?
include 'getprodtype.php'; ?>
	</td>
</tr>
<tr>

<td>Report Period : </td>
<td>
<select id='rpttype' name='rpttype' value =''>
<option value='Choose..' selected='selected'>Choose...</option>
<option value='WEEKLY'>WEEKLY</option>
<option value='FORTNIGHTLY'>FORTNIGHTLY</option>
<option value='MONTHLY'>MONTHLY</option>
<option value='QUARTERLY'>QUARTERLY</option>
</select>
<?
echo "<b><input name='proj_id' id='proj_id' type='hidden' value='$projid'></b>";
echo "<b><input name='prevstatus' id='prevstatus' type='hidden' value='$rowed[status]'></b>";
echo "<b><input name='byFld' id='byFld'  type='hidden' value='project_modified_by'></b>";
echo "<b><input name='statuschg' id='statuschg'  type='hidden' value='ACTIVE'></b>";
echo "<b><input name='onFld' id='onFld'  type='hidden' value='project_modified_on'></b>";
?>

</td>

</tr>
<?
echo "<script>document.getElementById('projtype').value = '$rowed[project_type_id]';</script>";
echo "<script>document.getElementById('projtype').disabled=true;</script>";
echo "<script>document.getElementById('rpttype').value = '$rowed[report_type]';</script>";
echo "<script>document.getElementById('rpttype').disabled=true;</script>";
echo "<script>document.getElementById('prod').value = '$rowed[base_product]';</script>";
echo "<script>document.getElementById('prod').disabled=true;</script>";

?>

<tr>
	<td>Customer : </td>
	<td>

		<? 
include 'getcustomer.php'; ?>
	</td>

	<td>Project : </td>

	<td> <input type = "text" id='proj' name='proj' size='50'></td>
</tr>

<tr>
</tr>
<?
echo "<script>document.getElementById('cust').value = '$rowed[customer_id]';</script>";
echo "<script>document.getElementById('cust').disabled=true;</script>";
echo "<script>document.getElementById('proj').value = '$rowed[project_name]';</script>";
echo "<script>document.getElementById('proj').disabled=true;</script>";
?>

<tr>
	<td>Project Manager : </td>
	<td>
		<? 
$_GET['q']='pm';
include 'getemp.php'; ?>
	</td>

	<td>Project Director : </td>
	<td>

		<? 
$_GET['q']='pd';
include 'getemp.php'; ?>
	</td>
</tr>
<?
echo "<script>document.getElementById('pm').value = '$rowed[project_manager_id]';</script>";
echo "<script>document.getElementById('pm').disabled=true;</script>";
echo "<script>document.getElementById('pd').value = '$rowed[project_director_id]';</script>";
echo "<script>document.getElementById('pd').disabled=true;</script>";
?>


<tr>
<td>Project Status : </td>
<td> 
<select id='statusx' name='statusx' value =''>
<option value='Choose..' selected='selected'>Choose...</option>
<option value='INITIATED'>INITIATED</option>
<option value='ACTIVE'>ACTIVE</option>
<option value='CLOSED'>CLOSED</option>
<option value='INITIATE CLOSURE'>INITIATE CLOSURE</option>
<option value='AUTHORISE CLOSURE'>AUTHORISE CLOSURE</option>
<option value='WARRANTY'>WARRANTY</option>
<option value='DELIVERED'>DELIVERED</option>
<option value='AUTHORISED'>AUTHORISED</option>
<option value='APPROVED'>APPROVED</option>
</select>
</td>

<?

echo "<script>document.getElementById('statusx').value = '$rowed[status]';</script>";
echo "<script>document.getElementById('statusx').disabled=true;</script>";
?>

</tr>
<tr>

<td>Project Stakeholder : </td>
 <td>

                        <?
$_GET['q']='';
include 'getemp1.php'; ?>
                </td>
<td>
<input type="submit"  value="Update Stakeholder">
</td>
</tr>
<tr>
<td><div id="txtDetails"><b></b></div></td>
<?php echo"<script>show();</script>";?>
</tr>

</table>
<td> 
</td>
</form>
</body>
</html>
