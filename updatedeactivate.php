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
$newid = "";

if($_POST[statuschg] == "ACTIVE" && $_POST[prevstatus] !="DEACTIVATED")
{
//This is commented for now
/*	$inssql = "
	insert into ohrm_project (
	customer_id,
	name,
	description,
	budget_val,
	invoice_val,
	license_val,
	is_deleted)
	values (
	$_POST[custPost],
	'$_POST[projPost]',
	'$_POST[ObjectivesPost]',
	$_POST[BudgetValPost],
	$_POST[ContractValPost],
	$_POST[LicenseValPost],
	0)
	";
	$result = mysqli_query($orcon,$inssql) or debug($inssql."<br/><br/>".mysql_error());
	$newid = mysqli_insert_id($orcon);*/
}
if($_POST[statuschg] == "ACTIVE" && $_POST[prevstatus] =="DEACTIVATED")
{
        $sqlx="select ohrm_project_id from project_details where id=".$_POST[proj_id];
        $result = mysqli_query($con,$sqlx) or debug($sqlx."<br/><br/>".mysql_error());
        $rowx = mysqli_fetch_array($result);
        $ohrmpid = $rowx[ohrm_project_id];
        $updsql = "update ohrm_project set is_deleted = 0 where project_id = ".$ohrmpid;

        $result = mysqli_query($orcon,$updsql) or debug($updsql."<br/><br/>".mysql_error());

}

	

if($_POST[statuschg] == "CLOSED" || $_POST[statuschg] =="DEACTIVATED")
{
	$sqlx="select ohrm_project_id from project_details where id=".$_POST[proj_id];
	$result = mysqli_query($con,$sqlx) or debug($sqlx."<br/><br/>".mysql_error());
	$rowx = mysqli_fetch_array($result);
	$ohrmpid = $rowx[ohrm_project_id];
	$updsql = "update ohrm_project set is_deleted = 1 where project_id = ".$ohrmpid;

	$result = mysqli_query($orcon,$updsql) or debug($updsql."<br/><br/>".mysql_error());
	
}

$det = mysqli_real_escape_string($con,$_POST[remAction]);
$sql="
UPDATE project_details set 
status = '$_POST[statuschg]',
$_POST[byFld] = $user,
$_POST[onFld] = CURRENT_TIMESTAMP";
if($_POST[statusFld] != "")
	$sql=$sql.", $_POST[statusFld] = '$_POST[statusAction]'";
if($_POST[remFld] != "")
	$sql=$sql.", $_POST[remFld] = '$det'";
if($newid!="")
	$sql=$sql.", ohrm_project_id = $newid";
$sql= $sql." where id=$_POST[proj_id]";
	
$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
closeConnection($con);
closeConnection($orcon);
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'success.php';
header("Location: http://$host$uri/$extra");
exit;
?>
