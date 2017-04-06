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
select invoice_id , c.name customer , b.project_name, milestone_type , expected_invoice_date, lcy_amount ,a.status from project_invoice a
inner join project_details b on a.project_id = b.id
inner join milestone d on a.mile_stone = d.id
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
echo "<table id='inv' border='0'>";

echo "<br><tr>";
echo "<td><b>Customer</b></td>";

	echo "<td>&nbsp;</td>";
echo "<td><b>Project Name</b></td>";

	echo "<td>&nbsp;</td>";
echo "<td><b>Milestone</b></td>";
	echo "<td>&nbsp;</td>";
echo "<td><b>Invoice No.</b></td>";

	echo "<td>&nbsp;</td>";
echo "<td><b>Expected Invoice Date</b></td>";

	
	echo "<td>&nbsp;</td>";
echo "<td><b>Amount</b></td>";
	echo "<td>&nbsp;</td>";
echo "<td><b>Status</b></td>";


	echo "<td>&nbsp;</td>";
echo "<td align='left'><b>Operations</b></td>";
echo "</tr>";
while($row = mysqli_fetch_array($result))
  {
	echo "<tr>";

        echo "<td>$row[customer]</td>";
	echo "<td>&nbsp;</td>";
        echo "<td>$row[project_name]</td>";

	echo "<td>&nbsp;</td>";
        echo "<td>$row[milestone_type]</td>";
	echo "<td>&nbsp;</td>";
        echo "<td>$row[invoice_no]</td>";

	echo "<td>&nbsp;</td>";
	$dt = date("d-M-Y", strtotime($row[expected_invoice_date]));

        echo "<td>$dt</td>";
	echo "<td>&nbsp;</td>";
        $amt=number_format($row[lcy_amount],2);
        echo "<td align='right'>$amt</td>";

	echo "<td>&nbsp;</td>";
        echo "<td>$row[status]</td>";

	
	echo "<td>&nbsp;</td>";
	echo "<td><a href='generateinvoice.php?invoice_id=$row[invoice_id]'>Generate Invoice</a> |  ";
	echo "<td><a href='payinvoice.php?invoice_id=$row[invoice_id]'>Mark Payment</a> |  ";
	echo "<a href='viewinvoicedetails.php?invoice_id=$row[invoice_id]'>View</a></td>  ";
	echo "</tr>";
  }
echo "</table>";
closeConnection($con);
?>
