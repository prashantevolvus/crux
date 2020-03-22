<?php
session_name("Project");
session_start();
require 'dbconn.php';

$con=getConnection();
$conor=getOrangeConnection();
$user=$_SESSION["userempno"];
$empname=$_SESSION["user_name"];


$det1 = mysqli_real_escape_string($con,$_POST[Desc]);
$det2 = mysqli_real_escape_string($con,$_POST[paydet]);
	$sql=
"
update project_invoice
set 
mile_stone = '$_POST[mile]',
lcy_amount = '$_POST[amount]',
project_ccy_amount = '$_POST[prjccyamount]',
milestone_pcnt = '$_POST[pcnt]',
expected_invoice_date = '$_POST[ExpectedInvDate]',
expected_paid_date = '$_POST[ExpectedPayDate]',
Description = '$det1',
cr_id = '$_POST[crid]',
lcy_cr_amount = '$_POST[paidamount]',
pay_det = '$det2',
lcy_cr_date = '$_POST[CRPayDate]',
invoiced_date = '$_POST[InvoiceDate]',
invoice_no = '$_POST[InvoiceNo]',
invoiced_by = $user,
invoiced_on = CURRENT_TIMESTAMP
where invoice_id = 
". $_POST[inv_id];

	$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
closeConnection($con);
closeConnection($conor);
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'success.php';
header("Location: http://$host$uri/$extra");
exit;
?>
