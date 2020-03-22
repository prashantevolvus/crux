<?php
session_name("Project");
session_start();
require_once 'dbconn.php';
setlocale(LC_MONETARY, 'en_IN');
if(!checkUserSession($_SESSION["user"]))
{
        echo "<script>window.top.location.href='login.php'</script>";
        //header("Location:login.php");
}
$q=$_GET["q"];
$q1=$_GET["q1"];
$q2=$_GET["q2"];
$q3=$_GET["q3"];
$q4=$_GET["q4"];
$q5=$_GET["q5"];
$q6=$_GET["q6"];
$q7=$_GET["q7"];
$rep=$_GET["rep"];

$con=getConnection();
//Please uncomment once old expense has been entered
$sqlsum = "select a.status, sum(lcy_amount) totalval";
$sqlcol="
select cr_name,milestone_pcnt ,lcy_cr_date,cr_name,purchase_order,invoiced_date,invoice_id , invoice_no,c.name customer , b.project_name, milestone_type , 
expected_invoice_date, expected_paid_date,lcy_cr_date ,lcy_amount ,a.status ,
case     when a.status = 'PENDING'  then datediff(now(),expected_invoice_date) 
        when a.status = 'INVOICED'  then datediff(now(),invoiced_date) 
        when a.status = 'PAID'  then datediff(invoiced_date,expected_invoice_date) 
        else '0'
end ageing
";
$sql1=" 
from project_invoice a
inner join project_details b on a.project_id = b.id
inner join milestone d on a.mile_stone = d.id
left join project_cr e on a.cr_id = e.cr_id
inner join hr_mysql_live.ohrm_customer c on ohrm_customer_id = c.customer_id";
$sql1 .= " where 1=1 and lcy_amount<>0";
if($q1!="")
        $sql1 .= " and ohrm_customer_id = '".$q1."' ";
if($q2!="")
        $sql1 .= " and a.project_id = '".$q2."' ";
if($q!="")
        $sql1 .= " and a.status in (".$q.") ";
if($q3!="")
        $sql1 .= " and b.project_manager_id = '".$q3."' ";
if($q4!="")
        $sql1 .= " and date_format(expected_invoice_date,'%b-%Y') = date_format('".$q4."','%b-%Y')" ;
if($q5!="")
        $sql1 .= " and date_format(expected_paid_date,'%b-%Y') = date_format('".$q5."','%b-%Y')" ;
if($q6!="")
        $sql1 .= " and date_format(invoiced_date,'%b-%Y') = date_format('".$q6."','%b-%Y')" ;
if($q7!="")
        $sql1 .= " and date_format(lcy_cr_date,'%b-%Y') = date_format('".$q7."','%b-%Y')" ;
		
$sqlorder .= " order by b.id,e.cr_id";
$sql= $sqlcol.$sql1.$sqlorder; 

$sqlgroup .= " group by a.status WITH ROLLUP";
//die($sql);
$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
$result1 = mysqli_query($con,$sqlsum.$sql1.$sqlgroup) or debug($sqlsum.$sql1."<br/><br/>".mysql_error());
?>
<input type="button" onclick="tableToExcel('invoiceTab', 'Invoice Details', 'invoice.xls')" value="Export to Excel">

<?php
echo "<table class='gridtable'  id='inv'>";
echo "<tr>";
echo "<th><b>Status</b></th>";
echo "<th><b>Total Value</b></th>";
echo "</tr>";

while($row1 = mysqli_fetch_array($result1))
{
	echo "<tr>";
	$amt=money_format('%!.0n', $row1[totalval]);
	//$amt=number_format($row1[totalval],2);
	if ($row1[status] == "" )
	{
		echo "<td ><b>Total</b></td>";
		echo "<td align='right'><b>$amt</b></td>";
	}
	else
		echo "<td >$row1[status]</td>";
	if ($row1[status] != "" )
	    echo "<td align='right'>$amt</td>";
	echo "</tr>";
}
echo "</table>";
?>

<?php
echo "<table class='gridtable' id='inv'>";
echo "<br><tr>";
if($rep!='true')
{
	echo "<th><b>Project Name</b></th>";
}

	echo "<th><b>CR Name</b></th>";
	echo "<th><b>Purchase Order</b></th>";
	echo "<th><b>Milestone</b></th>";
	echo "<th><b>Invoice No.</b></th>";
	echo "<th><b>Expected Invoice Date</b></th>";
	echo "<th><b>Actual Invoice Date</b></th>";
	echo "<th><b>Expected Pay Date</b></th>";
	echo "<th><b>Amount</b></th>";
	echo "<th><b>Status</b></th>";
	echo "<th><b>Ageing</b></th>";
if($rep!='true')
{
	echo "<th align='left'><b>Operations</b></th>";
}
echo "</tr>";
while($row = mysqli_fetch_array($result))
{
	echo "<tr>";
	if($rep!='true')
	{	

        echo "<td>$row[customer] - $row[project_name]</td>";
	}
	echo "<td>$row[cr_name]</td>";
	echo "<td>$row[purchase_order]</td>";
	echo "<td>$row[milestone_type]</td>";
	echo "<td>$row[invoice_no]</td>";
	
	$dt = date("d-M-Y", strtotime($row[expected_invoice_date]));
	echo "<td>$dt</td>";
	$dt = date("d-M-Y", strtotime($row[invoiced_date]));
    echo "<td>$dt</td>";
	
	$dt = date("d-M-Y", strtotime($row[expected_paid_date]));
    echo "<td>$dt</td>";
	
		$amt=money_format('%!.0n', $row[lcy_amount]);
        //$amt=number_format($row[lcy_amount],2);
        echo "<td align='right'>$amt</td>";

	
	    echo "<td>$row[status]</td>";
	    echo "<td>$row[ageing]</td>";

if($rep!='true')
{
	
	echo "<td>";
	if($row[status] == "PENDING")
	{
		echo "<a href='generateinvoice.php?invoice_id=$row[invoice_id]'>Generate Invoice</a> |  ";
	}
	if($row[status] == "INVOICED")	
	{
		echo "<a href='payinvoice.php?invoice_id=$row[invoice_id]'>Mark Payment</a> |  ";
	}
	echo "<a href='viewinvoicedetails.php?invoice_id=$row[invoice_id]'>View</a> |  ";
	echo "<a href='editinvoice.php?invoice_id=$row[invoice_id]'>Edit</a>  ";
	echo "</td>";
}
echo "</tr>";
  }
echo "</table>";



$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());

?>

<tr>
<td>
<a id="dlink"  style="display:none;"></a>

</td>
</tr>
<?php
echo "<table border='0' id='invoiceTab' style='display:none;'>";
echo "<tr>";
echo "<td><b>Customer</b></td>";
	echo "<td><b>Project Name</b></td>";

echo "<td><b>Milestone</b></td>";
echo "<td><b>Invoice No.</b></td>";

echo "<td><b>Expected Invoice Date</b></td>";

	
echo "<td><b>Expected Pay Date</b></td>";

	
	echo "<td><b>Amount</b></td>";
echo "<td><b>Status</b></td>";
echo "<td><b>Milestone %</b></td>";
echo "<td><b>Invoiced Date</b></td>";
echo "<td><b>Credit Date</b></td>";
echo "<td><b>CR Name</b></td>";
echo "</tr>";
while($row = mysqli_fetch_array($result))
  {
	echo "<tr>";

        echo "<td>$row[customer]</td>";
        echo "<td>$row[project_name]</td>";

        echo "<td>$row[milestone_type]</td>";
        echo "<td>$row[invoice_no]</td>";

	$dt = date("d-M-Y", strtotime($row[expected_invoice_date]));

        echo "<td>$dt</td>";
	$dt = date("d-M-Y", strtotime($row[expected_paid_date]));

        echo "<td>$dt</td>";
    	$amt=money_format('%!.0n', $row[lcy_amount]);
        //$amt=number_format($row[lcy_amount],2);
        echo "<td align='right'>$amt</td>";

        echo "<td>$row[status]</td>";
echo "<td>$row[milestone_pcnt]</td>"; 
echo "<td>$row[invoiced_date]</td>";
echo "<td>$row[lcy_cr_date]</td>";
echo "<td>$row[cr_name]</td>";

	echo "</tr>";
  }
echo "</table>";
closeConnection($con);
?>
