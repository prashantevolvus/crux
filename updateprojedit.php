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
$det1 = mysqli_real_escape_string($con,$_POST[Objectives]);
$det2 = mysqli_real_escape_string($con,$_POST[Scope]);
$det3 = mysqli_real_escape_string($con,$_POST[Success]);
$det4 = mysqli_real_escape_string($con,$_POST[PMRemarks]);

	$sql="
UPDATE project_details set 
project_name = '$_POST[proj]',
project_type_id = '$_POST[projtype]',
ohrm_customer_id = '$_POST[cust]',
project_manager_id = '$_POST[pm]',
project_director_id = '$_POST[pd]',
status = '$_POST[status]',
tlr = '$_POST[tlr]',
amc_pcnt = '$_POST[AMC]',
Planned_start_date = '$_POST[PlannedStartDate]',
Planned_End_date = '$_POST[PlannedEndDate]',
Actual_Start_Date = '$_POST[ActualStartDate]',
Actual_End_Date = '$_POST[ActualEndDate]',
Contract_value = '$_POST[ContractVal]',
Budget = '$_POST[BudgetVal]',
License_value = '$_POST[LicenseVal]',
Report_type = '$_POST[rpttype]',
Objectives = '$det1',
Scope = '$det2',
success_factor = '$det3',
project_manager_remarks = '$det4',
purchase_order = '$_POST[PO]',
po_date = '$_POST[PODate]',
docurl = '$_POST[docurl]',
base_product = '$_POST[prod]',
project_modified_by = $user,
project_modified_on =CURRENT_TIMESTAMP
where id=$_POST[projid]";
	$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
closeConnection($con);
closeConnection($orcon);
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'success.php';
header("Location: http://$host$uri/$extra");
exit;
?>
