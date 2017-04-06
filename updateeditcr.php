<?php
session_name("Project");
session_start();
require 'dbconn.php';

$con=getConnection();

$user=$_SESSION["userempno"];
$empname=$_SESSION["user_name"];



	$sql=
"
update project_cr
set 
	cr_name = '".$_POST[crname]."',
	cr_amount = ".$_POST[cramount].",
	cr_start_date = '".$_POST[ExpectedStartDate]."',
	description = '".$_POST[Desc]."'
where cr_id = 
". $_POST[cr_id];
	$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
	

	
closeConnection($con);

$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'success.php';
header("Location: http://$host$uri/$extra");
exit;
?>
