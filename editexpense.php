<?php
session_name("Project");
session_start();
require_once('dbconn.php');
if(!checkUserSession($_SESSION["user"]))
{
	header("Location:login.php");
}

if(checkPermission("EDIT") == false)
{
	
	header("Location:error.php");
}
$expid=$_GET["exp_id"];

$coned=getConnection();
$sqled="
SELECT status,for_emp, a.expense_id,expense_type,a.project_id project_id, c.customer_id customer_id, c.name project_name,d.name customer_name,expense_details, expense_date,expense_amt FROM expense_details a
inner join expense_type b on a.expense_id = b.expense_id
inner join hr_mysql_live.ohrm_project c on a.project_id = c.project_id
inner join hr_mysql_live.ohrm_customer d on d.customer_id = c.customer_id
where expense_det_id  = ".$expid;
$resulted = mysqli_query($coned,$sqled) or debug($sqled."   failed  <br/><br/>".mysql_error());
$rowed = mysqli_fetch_array($resulted);
if($rowed[status]!="SUBMITTED")
        header("Location:error1.php");

?>
<html>
<head>

<script>

function formSubmit()
{
	document.forms["expenseForm"]["ExpenseDet"].style.background="white";
	document.forms["expenseForm"]["ExpenseAmt"].style.background="white";
	document.forms["expenseForm"]["ExpenseDate"].style.background="white";

	var ua = window.navigator.userAgent;
	var msie = ua.indexOf ( "MSIE " );
	if(msie > 0)
	{
		alert("Not Supported in IE. Please use chrome");
		return false;
	}
	
	var bdg = document.forms["expenseForm"]["budgettogo"];
	if(!bdg)
	{
		alert('Project details not selected');
                return false;
	}
	
	var details = document.forms["expenseForm"]["ExpenseDet"].value;
	if(!details)
	{
		alert('Details cannot be blank');
		
		document.forms["expenseForm"]["ExpenseDet"].style.background="pink";
		document.forms["expenseForm"]["ExpenseDet"].focus();
                return false;
	}
	
	var dt =document.forms["expenseForm"]["ExpenseDate"].value;	

	if(!dt)
	{
		alert("Date cannot be blank");
		document.forms["expenseForm"]["ExpenseDate"].style.background="pink";
		document.forms["expenseForm"]["ExpenseDate"].focus();
		return false;
	}
	if(new Date(dt)>new Date()){
		alert('Date must not be in the future!');
		document.forms["expenseForm"]["ExpenseDate"].style.background="pink";
		document.forms["expenseForm"]["ExpenseDate"].focus();
		return false;
	}
	var i1 = (document.forms["expenseForm"]["budgettogo"].value);
	var i2 = (document.forms["expenseForm"]["ExpenseAmt"].value);
	
	if (i2=="" || parseInt(i2) == 0)
	{
		alert('Amount cannot be blank or zero');
		document.forms["expenseForm"]["ExpenseAmt"].style.background="pink";
		document.forms["expenseForm"]["ExpenseAmt"].focus();
		return false;
	}
	
	if (parseInt(i1) < parseInt(i2))
	{
		alert('No budget for this expense for now this will be passed.');
	//	document.forms["expenseForm"]["ExpenseAmt"].style.background="pink";
	//	document.forms["expenseForm"]["ExpenseAmt"].focus();
		return true;
	}

	
	return true;
	
}
function showBudget(str)
{

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

xmlhttp.open("GET","getohrmbudget.php?q="+str,true);

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

function showExpense()
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
    document.getElementById("txtExp").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","getexpense.php",true);
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
<body >
<?php include 'header.php'; 
?>
<h3>Edit Expense</h3>
<form name="expenseForm" action="updateedit.php" method="post" onsubmit="return formSubmit();" >
<?php
echo "<table>";
echo "<tr>";
echo "<td>";

echo "Expense ID for future reference ";

echo "</td>";
echo "<td>";
echo "<b><input name='expensedetid' id='expensedetid' type='text' value='$expid'></b>";
echo "<input name='expensedetidhid' id='expensedetidhid' type='hidden' value='$expid'>";
echo "<script>document.getElementById('expensedetid').disabled=true;</script>";

echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo "Status ";
echo "</td>";

echo "<td>";
echo "<b><input name='expensestatus' id='expensestatus' type='text' value='$rowed[status]'></b>";
echo "<script>document.getElementById('expensestatus').disabled=true;</script>";
echo "</td>";
echo "</tr>";
?>

<tr>
	<td>Expense Type : </td>
<?php include 'getexpense.php'; 

echo "<script>document.getElementById('expense').value = '$rowed[expense_id]';</script>";
?>
</tr>
<tr>
	<td>Expense For : </td>
<td>
<?php include 'getemp1.php'; 

echo "<script>document.getElementById('emp').value = '$rowed[for_emp]';</script>";
?>
</td>
</tr>
	<tr>
		<td>Customer : </td>
		<td>
		
<?php
include 'getcustomer.php';
echo "<script>document.getElementById('cust').value = '$rowed[customer_id]';</script>";
?>

</td>

		<td>Project : </td>
<td>	<div id="txtProj">	

<?php
$_GET['q'] = $rowed[customer_id];
include 'getprojectnewinvoice.php';
echo "<script>document.getElementById('proj').value = '$rowed[project_id]';</script>";
?>
	</div>	</td>
	</tr>

<tr>
<td>Expense Details: </td>
<?php
echo "<td>  <textarea  name='ExpenseDet' rows='4' cols='50'>$rowed[expense_details]</textarea></td>";
?>
</tr>

<tr>
<td>Expense Amount (in INR): </td>
<?php echo"<td>  <input type='text' name='ExpenseAmt' value='$rowed[expense_amt]'></td>";?>
</tr>
<tr>

<td>Expense date : </td>
<?php 
$dt = date("Y-m-d", strtotime($rowed[expense_date]));
echo"<td> <input type = 'date' id='ExpenseDate' name='ExpenseDate' value='$dt' ></td>";?>
</tr>

</table>
<tr>
<td>			<div id="txtBudget"><table id="finance"></table></div> </td>
<?php echo"<script>showBudget($rowed[project_id]);</script>";?>
</tr>

<td> 
<input type="submit"  value="Submit Expense"> 
</td>
</form>
</body>
</html>
