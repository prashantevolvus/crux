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
select expense_type , a.status, sum(a.expense_amt) expense_amt
from expense_details a
inner join expense_type c on a.expense_id = c.expense_id
inner join project_details b on a.project_id = b.ohrm_project_id where b.id = ".$q."
group by expense_type,a.status WITH ROLLUP";

$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
echo "<table class='table table-bordered'>";

echo "<br><tr>";


echo "<th><b>Expense Type</b></th>";
echo "<th><b>Status</b></th>";
echo "<th><b>Expense Amount</b></th>";
while($row = mysqli_fetch_array($result))
  {
	echo "<tr>";


        echo "<td>$row[expense_type]</td>";
		if($row[status] == "")
			echo "<b><td><b>Total</b></td></b>";
		else
			echo "<td>$row[status]</td>";
		$amt=number_format($row[expense_amt],2);
        echo "<td align='right'>$amt</td>";
	echo "</tr>";
  }
echo "</table>";
closeConnection($con);
?>
