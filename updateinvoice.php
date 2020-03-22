<?php
session_name("Project");
session_start();
require 'dbconn.php';

$con=getConnection();
$conor=getOrangeConnection();

//Please uncomment once old expense has been entered
$sql="select emp_number,user_name from ohrm_user where deleted = 0 and user_name = '".$_SESSION['user']."'";

$result = mysqli_query($conor,$sql) or debug($sql."<br/><br/>".mysql_error());

$row = mysqli_fetch_array($result);
$user=$row[emp_number];
$det1 = mysqli_real_escape_string($con,$_POST[Desc]);
	$sql=
"Insert into project_invoice (
project_id,
mile_stone,
milestone_pcnt,
project_ccy_amount,
lcy_amount,
status,
expected_invoice_date,
expected_paid_date,
cr_id,
Description,
created_by
)
values
(
'$_POST[proj]',
'$_POST[mile]',
'$_POST[pcnt]',
'$_POST[prjccyamount]',
'$_POST[amount]',
'$_POST[status]',
'$_POST[ExpectedInvDate]',
'$_POST[ExpectedPayDate]',
'$_POST[crid]',
'$det1',
$user)";
	$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
closeConnection($con);
closeConnection($conor);
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'success.php';
header("Location: http://$host$uri/$extra");
exit;
?>
