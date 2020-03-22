<?php
session_name("Project");
session_start();
require 'dbconn.php';

$con=getConnection();
$conor=getOrangeConnection();
$user=$_SESSION["userempno"];
$empname=$_SESSION["user_name"];
$det1 = mysqli_real_escape_string($con,$_POST[pdreport]);
$det2 = mysqli_real_escape_string($con,$_POST[pdriskpercept]);
$sql=
"
update project_report
set 
status='AUTHORISED',
pd_report = '$det1',
pd_risk_perception = '$det1',
authorised_by=$user,
authorised_on = CURRENT_TIMESTAMP
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
