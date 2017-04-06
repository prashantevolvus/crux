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
$expdet = mysqli_real_escape_string($con,$_POST[ExpenseDet]);



$user=$row[emp_number];

	$sql="insert into expense_details (project_id,expense_id,expense_details,expense_amt,expense_date,entry_by,for_emp,status,submitted_on) 
	values
	('$_POST[proj]','$_POST[expense]','$expdet','$_POST[ExpenseAmt]','$_POST[ExpenseDate]',$user,'$_POST[emp]','SUBMITTED',CURRENT_TIMESTAMP)";

	$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
	$newid = mysqli_insert_id($con);
closeConnection($con);
closeConnection($orcon);

//Send Mail
/*
$to  = 'mahesh.babu@evolvussolutions.com' . ', '; // note the comma
$to  = 'prashant.maroli@evolvussolutions.com' . ', '; // note the comma
$to .= 'balaji.jagannathan@evolvussolutions.com';
$subject = 'Expense Created';
// message
$message = "
<html>
<head>
  <title>Expense Details Created</title>
</head>
<body>
  <p>Please check the link below for details</p>
  <a href='http://evolvus.com/expense/vwexpense.php?exp_id=".$newid."'>Expense Details</a>
</body>
</html>
";

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Mail it
if(!mail($to, $subject, $message, $headers))
	echo "Mail delivery failed";
else
	echo "mail successfully sent";
debug;
*/





//End mail
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'success.php';
header("Location: http://$host$uri/$extra");
exit;
?>
