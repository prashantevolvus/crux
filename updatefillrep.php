<?php
session_name("Project");
session_start();
require 'dbconn.php';

$con=getConnection();
$conor=getOrangeConnection();
$user=$_SESSION["userempno"];
$empname=$_SESSION["user_name"];

$det1 = mysqli_real_escape_string($con,$_POST[pmreport]);
$det2 = mysqli_real_escape_string($con,$_POST[pmriskpercept]);
$sql=
"
update project_report
set 
status='FILLED',
pm_report = '$det1',
pm_risk_perception = '$det2' ,
estimated_budget_to_go = $_POST[estimatedbudget] ,
issue_critical_count = $_POST[ic] ,
issue_high_count = $_POST[ih] ,
issue_medium_count = $_POST[im] ,
issue_low_count = $_POST[il] ,
userstory_complex_total_count = $_POST[uct] ,
userstory_high_total_count = $_POST[uht] ,
userstory_medium_total_count = $_POST[umt] ,
userstory_low_total_count = $_POST[ult] ,
userstory_complex_cmpltd_count = $_POST[ucc] ,
userstory_high_cmpltd_count = $_POST[uhc] ,
userstory_medium_cmpltd_count = $_POST[umc] ,
userstory_low_cmpltd_count = $_POST[ulc] ,
customer_delight_quotient = '$_POST[custq]',
filled_by=$user,
filled_on = CURRENT_TIMESTAMP
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
