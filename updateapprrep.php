<?php
session_name("Project");
session_start();
require 'dbconn.php';

$con=getConnection();
$conor=getOrangeConnection();
$user=$_SESSION["userempno"];
$empname=$_SESSION["user_name"];
$det = mysqli_real_escape_string($con,$_POST[pdreport]);
$sql=
"
update project_report
set 
status='APPROVED',
approver_report = '$det',
approved_by=$user,
approved_on = CURRENT_TIMESTAMP
where id = $_POST[repid]
";
	$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
closeConnection($con);
closeConnection($conor); 
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'viewrepdetails.php?rep_id='.$_POST[repid];
header("Location: http://$host$uri/$extra");
exit;
?>
