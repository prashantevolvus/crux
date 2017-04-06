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

$det = mysqli_real_escape_string($con,$_POST[Desc]);

	$sql=
"Insert into project_cr (
project_id,
cr_name,
status,
cr_amount,
cr_start_date,
description,
created_by
)
values
(
'$_POST[proj]',
'$_POST[crname]',
'$_POST[status]',
'$_POST[cramount]',
'$_POST[ExpectedStartDate]',
'$det',
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
