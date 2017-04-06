<?php
session_name("Project");
session_start();
require('dbconn.php');
if(!checkUserSession($_SESSION["user"]))
//if(!isset($_SESSION["user"]))
{
        header("Location:login.php");
}
$q=$_GET["q"];

$q1=$_GET["q1"];

$inpexpid=$_GET["expid"];
$inpdesc=$_GET["desc"];
$con=getConnection();
//Please uncomment once old expense has been entered
$sql="
select expense_det_id,status,
concat(c.emp_firstname,' ',c.emp_lastname) created_by,
ifnull(concat(d.emp_firstname,' ',d.emp_lastname),' ') created_for,
expense_type, expense_details, expense_amt, expense_date 
from expense_details a
inner join expense_type b on a.expense_id = b.expense_id  
left join hr_mysql_live.hs_hr_employee c on c.emp_number = entry_by 
left join hr_mysql_live.hs_hr_employee d on d.emp_number = for_emp where 
( ".$_SESSION['userempno']." in (select emp_id from expense_perm_matrix) or ". 
    $_SESSION['userempno']." in (select emp_id from expense_perm_matrix) or
c.emp_number = ".$_SESSION['userempno']." or
d.emp_number = ".$_SESSION['userempno']." 
) and  
";
$where=" 1=1 ";
if($inpexpid!="")
	$where .= " and expense_det_id ='".$inpexpid."' ";
if($inpdesc!="")
	$where .= " and expense_details like '%".$inpdesc."%' ";
if($q1!="ALL")
	$where .= " and status ='".$q1."' ";
if($q!=0)
	$where .= " and project_id = ".$q." ";
$sql = $sql.$where." order by expense_date desc ";
//$sql="select project_id , name from ohrm_project where  customer_id = ".$q." order by name ";
$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
echo "<table class='gridtable'>";

echo "<br><tr>";
echo "<th><b><label class='desc'>Expense ID</label></b></th>";

echo "<th><b><label class='desc'>Expense Type</label></b></th>";

echo "<th><b><label class='desc'>Expense Details</label></b></th>";

echo "<th><b><label class='desc'>Expense Date</label></b></th>";

echo "<th><b><label class='desc'>Created By</label></b></th>";
	
echo "<th><b><label class='desc'>Created For</label></b></th>";

echo "<th><b><label class='desc'>Expense Amount</label></b></th>";
echo "<th><b><label class='desc'>Status</label></b></th>";

echo "<th><b><label class='desc'>Operations</label></b></th>";
echo "</b></tr>";
while($row = mysqli_fetch_array($result))
  {
	$q1=$row[status];
	$det=substr(ltrim($row[expense_details]),0,25)."...";
	echo "<tr>";
        echo "<td> <label class='desc'>$row[expense_det_id]</label></b></td>";
        echo "<td> <label class='field text '>$row[expense_type]</label></b></td>";
        echo "<td><label class='field text small'>$det</td>";
	$dt = date("d-M-Y", strtotime($row[expense_date]));

        echo "<td><label class='field text small'>$dt</td>";

        echo "<td>$row[created_by]</td>";

        echo "<td>$row[created_for]</td>";

	$amt=number_format($row[expense_amt],2);
        echo "<td align='right'>$amt</td>";
       echo $opt;
	echo "<td>$q1</td>";
	
	if($q1 == "SUBMITTED")
	{
		echo "<td><a href='editexpense.php?exp_id=$row[expense_det_id]'>Edit</a> |  ";
		echo "<a href='authexpense.php?exp_id=$row[expense_det_id]'>Authorise</a> | ";
		echo "<a href='vwexpense.php?exp_id=$row[expense_det_id]'>View</a> | ";
		echo "<a href='holdexpense.php?exp_id=$row[expense_det_id]'>Hold</a> | ";
		echo "<a href='delexpense.php?exp_id=$row[expense_det_id]'>Delete</a> </td>";
	}
	if($q1 == "AUTHORISED")
	{
		echo "<td><a href='payexpense.php?exp_id=$row[expense_det_id]'>Pay</a> |  ";
		echo "<a href='vwexpense.php?exp_id=$row[expense_det_id]'>View</a> | ";
		echo "<a href='delexpense.php?exp_id=$row[expense_det_id]'>Delete</a> </td>";
	}
	if($q1 == "HOLD")
	{
		echo "<td><a href='resubmitexpense.php?exp_id=$row[expense_det_id]'>Resubmit</a> |  ";
		echo "<a href='vwexpense.php?exp_id=$row[expense_det_id]'>View</a> | ";
		echo "<a href='delexpense.php?exp_id=$row[expense_det_id]'>Delete</a> </td>";
	}
	if($q1 == "PAID")
	{
		echo "<td><a href='vwexpense.php?exp_id=$row[expense_det_id]'>View</a> | ";
		echo "<a href='delexpense.php?exp_id=$row[expense_det_id]'>Delete</a> </td>";
	}
	if($q1 == "DELETED")
	{
		echo "<td><a href='vwexpense.php?exp_id=$row[expense_det_id]'>View</a></td>";
	}
	echo "</tr>";
  }
echo "</table>";
closeConnection($con);
?>
