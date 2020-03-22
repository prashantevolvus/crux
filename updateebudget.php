<?php
session_name("Project");
session_start();
require 'dbconn.php';

$con=getConnection();
$conor=getOrangeConnection();


//Please uncomment once old expense has been entered
$sql="select emp_number,user_name from ohrm_user where deleted = 0 and user_name = '".$_SESSION['user']."'";

$result = mysqli_query($conor,$sql) or debug($sql."<br/><br/>".mysql_error());
$det = mysqli_real_escape_string($con,$_POST[Reason]);
$det1 = mysqli_real_escape_string($con,$_POST[budgetname]);

$row = mysqli_fetch_array($result);
$user=$row[emp_number];
	$sql=
"Insert into project_excess_budget (
project_id,
excess_budget,
reason,
status,
docurl,
category,
crvalue,
budget_name,
initiated_by)
values
(
'$_POST[proj]',
'$_POST[excess]',
'$det',
'INITIATED',
'$_POST[docurl]',
'$_POST[category]',
$_POST[crvalue],
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
