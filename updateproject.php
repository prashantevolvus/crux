<?php
session_name("Project");
session_start();
require 'dbconn.php';

$con=getConnection();
$orcon=getOrangeConnection();

//Please uncomment once old expense has been entered


$user=$_SESSION["userempno"];
$empname=$_SESSION["user_name"];
//print_r($_POST);
$det1 = mysqli_real_escape_string($con,$_POST[Objectives]);
$det2 = mysqli_real_escape_string($con,$_POST[Scope]);
$det3 = mysqli_real_escape_string($con,$_POST[Success]);
$det4 = mysqli_real_escape_string($con,$_POST[PMRemarks]);
$actEndDate = $_POST[ActualEndDate];
if($_POST[ActualEndDate]==''){
$actEndDate='0000-00-00';
}

$inssql = "
	insert into ohrm_project (
	customer_id,
	name,
	description,
	max_budget_val,
	invoice_val,
	license_val,
	is_deleted)
	values (
	'$_POST[cust]',
	'$_POST[proj]',
	'$det1',
	'$_POST[BudgetVal]',
	'$_POST[ContractVal]',
	'$_POST[LicenseVal]',
	1)
	";
	$result = mysqli_query($orcon,$inssql) or debug($inssql."<br/><br/>".mysql_error());
	$newid = mysqli_insert_id($orcon);
	
	$inssql = "	insert into ohrm_project_admin values ($newid,$_POST[pm])";
	$result = mysqli_query($orcon,$inssql) or debug($inssql."<br/><br/>".mysql_error());
		

	$sql=
"Insert into project_details (
project_name,
project_type_id,
ohrm_customer_id,
project_manager_id,
project_director_id,
Status,
tlr,
amc_pcnt,
Planned_start_date,
Planned_End_date,
Actual_Start_Date,
Actual_End_Date,
Contract_value,
Budget,
License_value,
Report_type,
Objectives,
Scope,
success_factor,
project_manager_remarks,
docurl,
purchase_order,
base_product,
Project_created_by,
ohrm_project_id,
pc_id)
values
(
trim('$_POST[proj]'),
'$_POST[projtype]',
'$_POST[cust]',
'$_POST[pm]',
'$_POST[pd]',
'$_POST[status]',
'$_POST[tlr]',
'$_POST[AMC]',
'$_POST[PlannedStartDate]',
'$_POST[PlannedEndDate]',
'$_POST[ActualStartDate]',
'$actEndDate',
'$_POST[ContractVal]',
'$_POST[BudgetVal]',
'$_POST[LicenseVal]',
'$_POST[rpttype]',
'$det1',
'$det2',
'$det3',
'$det4',
'$_POST[docurl]',
'$_POST[PO]',
'$_POST[prod]',
'$user',
'$newid',
'$_POST[profit_centers]')";

	$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
/*Send Email*/
$newid=0;
$newid = mysqli_insert_id($con);
$sql="
select * from project_emails where email is not null and id =".$newid;
$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
 $mails="";
while($row=mysqli_fetch_array($result))
{
        $mails.=$row[email].",";
        $name=$row[project_name];
		$custname=$row[cust_name];
}


$_GET['emails']=$mails;
$_GET['projid1']=$newid;
$_GET['projname']=$name;
$_GET['custname']=$custname;

$_GET['statuschg']='INITIATED';
$_GET['prevstatuschg']=$_POST[prevstatus];
$_GET['empname']=$empname;



include 'mail.php';

closeConnection($con);
closeConnection($orcon);
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'success.php';
header("Location: http://$host$uri/$extra");
exit;
?>
