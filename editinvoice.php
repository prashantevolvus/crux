<?php
session_name("Project");
session_start();
require_once('dbconn.php');
if(!checkUserSession($_SESSION["user"]))
{
	header("Location:login.php");
}
if(checkProjectPermission("INVEDIT") == false)
{

        header("Location:error.php");
}

$invid=$_GET["invoice_id"];

$coned=getConnection();
$sqled="
select invoice_id,lcy_cr_date,pay_det,lcy_cr_amount,cr_id,project_id, ohrm_customer_id customer_id, mile_stone,lcy_amount,project_ccy_amount,a.status,expected_invoice_date,
expected_paid_date,description,milestone_pcnt pcnt,invoiced_date, invoice_no
from project_invoice a
inner join project_details b on a.project_id = b.id
where invoice_id = ".$invid ;
$resulted = mysqli_query($coned,$sqled) or debug($sqled."   failed  <br/><br/>".mysql_error());
$rowed = mysqli_fetch_array($resulted);



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
<? include 'header.php'; ?>


<h3>Mark Invoice Paid</h3>
<?
$_GET['projid']=$rowed[project_id];
include 'operproj.php';
echo "<tr><font size='2' color='orange'><td>Invoice : ";
	if($rowed[status] == "PENDING")
	{
		echo "<a href='generateinvoice.php?invoice_id=$rowed[invoice_id]'>Generate Invoice</a> |  ";
	}
	if($rowed[status] == "INVOICED")	
	{
		echo "<a href='payinvoice.php?invoice_id=$rowed[invoice_id]'>Mark Payment</a> |  ";
	}
	echo "<a href='viewinvoicedetails.php?invoice_id=$rowed[invoice_id]'>View</a>  ";
	echo "</td></tr>";
?>

<form name="projectForm" action="updateeditinvoice.php" method="post" onsubmit="return formSubmit();" >
<table>
<tr>
 <td> Milestone : </td>
                <td>

            <?
include 'getmilestone.php'; ?>
                </td>
</tr>
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
include 'getprojectnewinvoice.php';
echo "<script>document.getElementById('proj').value = '$rowed[project_id]';</script>";
echo "<script>document.getElementById('proj').disabled=true;</script>";
echo "<script>document.getElementById('mile').value = '$rowed[mile_stone]';</script>";
?>
</td>
        </tr>

<tr>
<td>Change Request</td>
<td>
<?php
$_GET['q'] = $rowed[project_id];
include 'getcr.php';
echo "<script>document.getElementById('crid').value = '$rowed[cr_id]';</script>";
?> 
 
                </td>
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
<td>Contract Percentage : </td>
<td><input type="number" text-align="right" step="any" id="pcnt" name="pcnt" required><td><b>%</b>
</tr>
<tr>
<td>Invoice Amount (Contract Currency): </td>
<td><input type="number" text-align="right" step="any" id="prjccyamount" name="prjccyamount" required></td>
<td>Invoice Amount (INR): </td>
<td><input type="number" text-align="right" step="any" id="amount" name="amount" required><td>
</tr>
<!--
<tr>
<td>Invoice No : </td>
<td> <input type = "text" id="InvoiceNo" name="InvoiceNo"></td>
<td>Invoiced Date : </td>
<td> <input type = "date" id="InvoiceDate" name="InvoiceDate" ></td>
 </td>
</tr>
-->
<tr>
<td>Expected Invoice date : </td>
<td> <input type = "date" id="ExpectedInvDate" name="ExpectedInvDate" required></td>
<td>Expected Pay Date : </td>
<td> <input type = "date" id="ExpectedPayDate" name="ExpectedPayDate" required></td>
 </td>
</tr>

<tr>
<td>Description : </td>
<td>  <textarea rows=5 cols=40 id="Desc" name="Desc" required></textarea>
 </td>
</tr>
<tr>
<td>Invoice No : </td>
<td> <input type = "text" id="InvoiceNo" name="InvoiceNo"  ></td>
<td>Invoiced Date : </td>
<td> <input type = "date" id="InvoiceDate" name="InvoiceDate" ></td>
 </td>
</tr>
<tr>
<td>Local Currency Amount Credited : </td>
<td><input type="number" text-align="right" step="any" id="paidamount" name="paidamount" ></td>
<td>Payment Credit Date : </td>
<td> <input type = "date" id="CRPayDate" name="CRPayDate" ></td>
</tr>
<tr>
<td>Payment Details </td>
<td>  <textarea rows=5 cols=40 id="paydet" name="paydet" ></textarea>
 </td>
</tr>

<?
echo "<script>document.getElementById('status').value = '$rowed[status]';</script>";
echo "<script>document.getElementById('status').disabled=true;</script>";
echo "<script>document.getElementById('pcnt').value = '$rowed[pcnt]';</script>";
echo "<script>document.getElementById('prjccyamount').value = '$rowed[project_ccy_amount]';</script>";
echo "<script>document.getElementById('amount').value = '$rowed[lcy_amount]';</script>";

echo "<script>document.getElementById('ExpectedInvDate').value = '$rowed[expected_invoice_date]';</script>";
echo "<script>document.getElementById('ExpectedPayDate').value = '$rowed[expected_paid_date]';</script>";
echo "<script>document.getElementById('Desc').value = '$rowed[description]';</script>";
echo "<b><input name='inv_id' id='inv_id' type='hidden' value='$invid'></b>";


echo "<script>document.getElementById('InvoiceNo').value = '$rowed[invoice_no]';</script>";
echo "<script>document.getElementById('InvoiceDate').value = '$rowed[invoiced_date]';</script>";

echo "<script>document.getElementById('paidamount').value = '$rowed[lcy_cr_amount]';</script>";
echo "<script>document.getElementById('paydet').value = '$rowed[pay_det]';</script>";
echo "<script>document.getElementById('CRPayDate').value = '$rowed[lcy_cr_date]';</script>";

?>

</table>

<td> 
<input type="submit"  value="Submit"> 
</td>
</form>
</body>
</html>
