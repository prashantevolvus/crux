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
update project_invoice
set 
status = 'INVOICED',
invoiced_date = '$_POST[InvoiceDate]',
invoice_no = '$_POST[InvoiceNo]',
invoiced_by = $user,
invoiced_on = CURRENT_TIMESTAMP
where invoice_id = 
". $_POST[inv_id];
	$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
closeConnection($con);
closeConnection($conor);
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'success.php';
header("Location: http://$host$uri/$extra");
exit;
?>
