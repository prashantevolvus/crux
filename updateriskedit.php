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
$det2 = mysqli_real_escape_string($con,$_POST[Containment]);
$det3 = mysqli_real_escape_string($con,$_POST[Contingent]);
	$sql=
"
update project_risk set 
project_id = '$_POST[proj]',
likelihood = '$_POST[likelihood]',
impact = '$_POST[impact]',
risk_desc = '$det1',
risk_cost = '$_POST[riskcost]',
containment_plan = '$det2',
contingent_plan = '$det3',
modified_by = $user,
modified_on = CURRENT_TIMESTAMP
where risk_id=$_POST[riskid]";

	$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
closeConnection($con);
closeConnection($conor);
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'success.php';
header("Location: http://$host$uri/$extra");
exit;
?>
