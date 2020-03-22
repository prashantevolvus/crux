<?php
session_name("Project");
session_start();
require 'dbconn.php';

$con=getConnection();

$orcon=getOrangeConnection();
//Please uncomment once old expense has been entered
$sql="select emp_number,user_name from ohrm_user where deleted = 0 and user_name = '".$_SESSION['user']."'";

$result = mysqli_query($orcon,$sql) or debug($sql."<br/><br/>".mysql_error());

$row = mysqli_fetch_array($result);
$user=$row[emp_number];
if($_POST[statuschg] == "AUTHORISED")
{
	$sqlohrm = "
	update hr_mysql_live.ohrm_project ";
	if($_POST[bud_cat] == "MILESTONE")
		$sqlohrm .= " set budget_val = budget_val + $_POST[excessPost] ";
	else
		$sqlohrm .= " set excess_val = excess_val + $_POST[excessPost] ";
	 $sqlohrm .= " where project_id = (
	select ohrm_project_id from project_details where id = (
	select project_id from project_excess_budget where id = $_POST[bud_id]) )
	";
	$result = mysqli_query($con,$sqlohrm) or debug($sqlohrm."<br/><br/>".mysql_error());
}

	$sql="
UPDATE project_excess_budget set 
status = '$_POST[statuschg]',
$_POST[byFld] = $user,
$_POST[onFld] = CURRENT_TIMESTAMP
where id=$_POST[bud_id]
";

	$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
closeConnection($con);
closeConnection($orcon);
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'success.php';
header("Location: http://$host$uri/$extra");
exit;
?>
