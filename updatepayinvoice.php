<?php
session_name("Project");
session_start();
require 'dbconn.php';

$con=getConnection();
$conx=getConnection();
$conor=getOrangeConnection();
$user=$_SESSION["userempno"];
$empname=$_SESSION["user_name"];


$det = mysqli_real_escape_string($con,$_POST[paydet]);

	$sql=
"
update project_invoice
set 
status = 'PAID',
lcy_cr_amount = '$_POST[paidamount]',
pay_det = '$det1',
lcy_cr_date = '$_POST[CRPayDate]',
paid_by = $user,
paid_on = CURRENT_TIMESTAMP
where invoice_id = 
". $_POST[inv_id];
	$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
closeConnection($con);
$sqlx="
select ohrm_project_id from project_details a
inner join project_invoice b on a.id = b.project_id 
where invoice_id = ".$_POST[inv_id];

$resultx = mysqli_query($conx,$sqlx) or debug($sqlx."<br/><br/>".mysql_error());
$rowx = mysqli_fetch_array($resultx);
$ohrmpid = $rowx[ohrm_project_id];
$updsql = "update ohrm_project set received_val = ifnull(received_val,0) + $_POST[paidamount] where project_id = ".$ohrmpid;
$result = mysqli_query($conor,$updsql) or debug($updsql."<br/><br/>".mysql_error());



closeConnection($conor);
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'success.php';
header("Location: http://$host$uri/$extra");
exit;
?>
