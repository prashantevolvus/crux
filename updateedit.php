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
$det = mysqli_real_escape_string($con,$_POST[ExpenseDet]);
$user=$row[emp_number];
	$sql="
UPDATE expense_details set 
project_id =$_POST[proj] ,
expense_id =$_POST[expense] ,
expense_details = '$det',
expense_amt =$_POST[ExpenseAmt] ,
expense_date = '$_POST[ExpenseDate]',
edited_by =$user ,
edited_on = CURRENT_TIMESTAMP,
for_emp = $_POST[emp]
where expense_det_id=$_POST[expensedetidhid]
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
