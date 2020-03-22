<?php
session_name("Project");
session_start();
require_once 'dbconn.php';
if(!checkUserSession($_SESSION["user"]))
{
        echo "<script>window.top.location.href='login.php'</script>";
        //header("Location:login.php");
}

$q=$_GET["q"];
$q1=$_GET["q1"];
$con=getConnection();
//Please uncomment once old expense has been entered
$sql="
select expense_det_id, expense_type , left(expense_details,150) description, a.expense_amt, ifnull(getEmpname(for_emp),'') emp, expense_date,a.status 
from expense_details a
inner join expense_type c on a.expense_id = c.expense_id
inner join project_details b on a.project_id = b.ohrm_project_id where b.id = ".$q."
order by expense_date";
$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
echo "<table class='gridtable'>";

echo "<br><tr>";
echo "<th><b>Expense ID</b></th>";

echo "<th><b>Expense Type</b></th>";

echo "<th><b>Description</b></th>";

echo "<th><b>Expense Amount</b></th>";
echo "<th><b>Expense On</b></th>";

echo "<th><b>Expense Date</b></th>";

	
echo "<th><b>Status</b></th>";


echo "<th align='left'><b>Operations</b></th>";
echo "</tr>";
while($row = mysqli_fetch_array($result))
  {
	echo "<tr>";

        echo "<td>$row[expense_det_id]</td>";

        echo "<td>$row[expense_type]</td>";
        echo "<td>$row[description]</td>";

		$amt=number_format($row[expense_amt],2);
        echo "<td align='right'>$amt</td>";
        echo "<td>$row[emp]</td>";

	$dt = date("d-M-Y", strtotime($row[expense_date]));

        echo "<td>$dt</td>";

	
        echo "<td>$row[status]</td>";
	echo "<td><a href='vwexpense.php?exp_id=$row[expense_det_id]'>View</a></td>  ";
	echo "</tr>";
  }
echo "</table>";
closeConnection($con);
?>
