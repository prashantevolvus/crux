<?php
session_name("Project");
session_start();
require 'dbconn.php';

$con=getConnection();
$conor=getOrangeConnection();
$det1 = mysqli_real_escape_string($con,$_POST[Desc]);
$det2 = mysqli_real_escape_string($con,$_POST[Containment]);
$det3 = mysqli_real_escape_string($con,$_POST[Contingent]);

//Please uncomment once old expense has been entered
$sql="select emp_number,user_name from ohrm_user where deleted = 0 and user_name = '".$_SESSION['user']."'";

$result = mysqli_query($conor,$sql) or debug($sql."<br/><br/>".mysql_error());
$row = mysqli_fetch_array($result);
$user=$row[emp_number];
	$sql=
"Insert into project_risk (
project_id,
risk_desc,
containment_plan,
contingent_plan,
likelihood,
risk_type,
risk_cost,
impact,
created_by
)
values
(
'$_POST[proj]',
'$det1',
'$det2',
'$det3',
'$_POST[likelihood]',
'$_POST[risk]',
'$_POST[riskcost]',
'$_POST[impact]',
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
