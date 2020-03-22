<?php
session_name("Project");
session_start();
require 'dbconn.php';

$con=getConnection();
$conor=getOrangeConnection();
$user=$_SESSION["userempno"];
$empname=$_SESSION["user_name"];



	$sql=
"
update project_cr
set 
status = 'ACCEPTED'
where cr_id = 
". $_POST[cr_id];
	$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
	
$sql=
"update project_details set cr_amt = 
(select sum(cr_amount) from project_cr 
where project_cr.status = 'ACCEPTED' and id = project_id
group by `Project_id`)
where exists 
(select sum(cr_amount) from project_cr 
where project_cr.status = 'ACCEPTED' and id = project_id
group by `Project_id`) and project_details.status not in ('DELETED','CLOSED');
";
	$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());	
	
$updsql = "update ohrm_project set invoice_val = invoice_val + ".$_POST[cramount1]." where project_id = ".$_POST[ohrm_project_id];
$result = mysqli_query($conor,$updsql) or die($updsql."<br/><br/>".mysql_error());
	
	
closeConnection($con);
closeConnection($conor);
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'success.php';
header("Location: http://$host$uri/$extra");
exit;
?>
