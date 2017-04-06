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
$q2=$_GET["q2"];
$con=getConnection();
//Please uncomment once old expense has been entered
$sql="
select cr_id , cr_name,c.name customer , b.project_name, cr_amount,cr_start_date,a.status,cr_start_date 
from project_cr a
inner join project_details b on a.project_id = b.id
inner join hr_mysql_live.ohrm_customer c on ohrm_customer_id = c.customer_id";
$sql .= " where 1=1 ";
if($q1!="")
        $sql .= " and ohrm_customer_id = '".$q1."' ";
if($q2!="")
        $sql .= " and project_id = '".$q2."' ";
if($q!="")
        $sql .= " and a.status = '".$q."' ";
$sql .= " order by b.id";
$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
echo "<table class='table table-bordered'>";

echo "<br><tr>";
echo "<th><b>Customer</b></th>";

echo "<th><b>Project Name</b></th>";

echo "<th><b>CR Name</b></th>";
	
echo "<th><b>Expected Start Date</b></th>";

	
echo "<th><b>CR Amount</b></th>";
echo "<th><b>Status</b></th>";


echo "<th align='left'><b>Operations</b></th>";
echo "</tr>";
while($row = mysqli_fetch_array($result))
  {
	echo "<tr>";

        echo "<td>$row[customer]</td>";
        echo "<td>$row[project_name]</td>";

        echo "<td>$row[cr_name]</td>";
	
	$dt = date("d-M-Y", strtotime($row[cr_start_date]));

        echo "<td>$dt</td>";
        $amt=number_format($row[cr_amount],2);
        echo "<td align='right'>$amt</td>";

        echo "<td>$row[status]</td>";
	echo "<td>";
	if($row[status] != 'ACCEPTED')
	{
		echo "<a href='acceptchangerequest.php?cr_id=$row[cr_id]'>Accept CR</a> |  ";
		echo "<a href='editchangerequest.php?cr_id=$row[cr_id]'>Edit CR</a> |  ";
	}
	echo "<a href='viewcrdetails.php?cr_id=$row[cr_id]'>View</a></td>  ";
	echo "</tr>";
  }
echo "</table>";
closeConnection($con);
?>
