<?php
session_name("Project");
session_start();
require 'dbconn.php';

$con=getConnection();


$user=$_SESSION["userempno"];
$empname=$_SESSION["user_name"];

$det = mysqli_real_escape_string($con,$_POST[Reason]);
$det1 = mysqli_real_escape_string($con,$_POST[budgetname]);
	$sql=
"
update project_excess_budget set 
project_id = '$_POST[proj]',
excess_budget = '$_POST[excess]',
reason = '$det',
budget_name = '$det1',
status = 'INITIATED',
docurl = '$_POST[docurl]',
modified_by = $user,
modified_on = CURRENT_TIMESTAMP
where id=$_POST[bud_id]";

	$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
closeConnection($con);
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'success.php';
header("Location: http://$host$uri/$extra");
exit;
?>
