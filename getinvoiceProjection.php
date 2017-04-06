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
$con=getConnection();

$sql="select month base_month,expected_invoice , invoiced , 
case when base_date > (curdate()) then 0 else 
 invoiced - expected_invoice  end invoice_variance , expected_payment, paid , 
case when base_date > (curdate()) then 0 else paid - expected_payment end paid_variance
from invoice_projection"; 
$sql1 .= " where 1=1 ";

if($q4!="")
        $sql1 .= " and base_date >= dateformat('".$q4."')" ;
if($q5!="")
        $sql1 .= " and base_date >= dateformat('".$q5."')" ;
if($q6!="")
        $sql1 .= " and base_date >= dateformat('".$q6."')" ;
if($q7!="")
        $sql1 .= " and base_date >= dateformat('".$q7."')" ;

$result = mysqli_query($con,$sql.$sql1) or die($sql.$sql1."<br/><br/>".mysql_error());
echo "<table class='gridtable' id='inv'>";
echo "<br><tr>";
echo "<th><b>Month</b></th>";

echo "<th><b>Expected Invoice Amount</b></th>";


echo "<th><b>Invoiced Amount</b></th>";

echo "<th><b>Variance Invoiced</b></th>";


echo "<th><b>Expected Payment Amount</b></th>";

	

	echo "<th><b>Paid Amount</b></th>";

	
	
	
	echo "<th><b>Variance in Paid</b></th>";
	
	
	echo "</tr>";
	$invoice_variance = 0;
	$paid_variance = 0;
while($row = mysqli_fetch_array($result))
  {
	echo "<tr>";

        echo "<td>$row[base_month]</td>";
	
		$amt=money_format('%!.0n', $row[expected_invoice]);
		//$amt=number_format($row[expected_invoice],2);
        echo "<td align='right'>$amt</td>";
		
		$amt=money_format('%!.0n', $row[invoiced]);
		//$amt=number_format($row[invoiced],2);
        echo "<td align='right'>$amt</td>";
		
		$amt=money_format('%!.0n', $row[invoice_variance]);
		//$amt=number_format($row[invoice_variance],2);
        echo "<td align='right'>$amt</td>";
		
		$amt=money_format('%!.0n', $row[expected_payment]);
		//$amt=number_format($row[expected_payment],2);
        echo "<td align='right'>$amt</td>";
		
		$amt=money_format('%!.0n', $row[paid]);
		//$amt=number_format($row[paid],2); 
        echo "<td align='right'>$amt</td>";
		
		$amt=money_format('%!.0n', $row[paid_variance]);
		//$amt=number_format($row[paid_variance],2);
        echo "<td align='right'>$amt</td>";
		echo "</tr>";
		$invoice_variance = $invoice_variance + $row[invoice_variance];
		$paid_variance = $paid_variance + $row[paid_variance];
  }
echo "</table>";
echo "<table>";
echo "<tr>";
echo "<td><b>Invoice Variance Total = </td>";
$amt=money_format('%!.0n', $invoice_variance);
//$amt = number_format($invoice_variance,2);
echo "<td>$amt</td>";
echo "</tr>";
echo "<tr>";
echo "<td><b>Paid Variance Total    = </td>";

$amt=money_format('%!.0n', $paid_variance);//
//$amt = number_format($paid_variance,2);
echo "<td>$amt</td>";
echo "</tr>";
echo "</table>";
closeConnection($con);
?>
