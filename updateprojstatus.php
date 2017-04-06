<?php
session_name("Project");
session_start();
require 'dbconn.php';

$con=getConnection();

$orcon=getOrangeConnection();
$user=$_SESSION["userempno"];
$empname=$_SESSION["user_name"];
$newid = "";
/*
if($_POST[statuschg] == "ACTIVE" && $_POST[prevstatus] =="APPROVED")
{

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
	$_POST[custPost],
	'$_POST[projPost]',
	'$_POST[ObjectivesPost]',
	$_POST[BudgetValPost],
	$_POST[ContractValPost],
	$_POST[LicenseValPost],
	0)
	";
	$result = mysqli_query($orcon,$inssql) or debug($inssql."<br/><br/>".mysql_error());
	$newid = mysqli_insert_id($orcon);
	
	$inssql = "	insert into ohrm_project_admin values ($newid,$_POST[pmPost])";
	$result = mysqli_query($orcon,$inssql) or debug($inssql."<br/><br/>".mysql_error());
		
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

	
*/
$is_deleted = 1;
if($_POST[statuschg] =="ACTIVE")
	$is_deleted = 0;
	

	$sqlx="select ohrm_project_id from project_details where id=".$_POST[proj_id];
	$result = mysqli_query($con,$sqlx) or debug($sqlx."<br/><br/>".mysql_error());
	$rowx = mysqli_fetch_array($result);
	$ohrmpid = $rowx[ohrm_project_id];
	$updsql = "update ohrm_project set is_deleted = ".$is_deleted." where project_id = ".$ohrmpid;

	$result = mysqli_query($orcon,$updsql) or debug($updsql."<br/><br/>".mysql_error());
	

$det = mysqli_real_escape_string($con,$_POST[remAction]);
$sql="
UPDATE project_details set 
status = '$_POST[statuschg]',
$_POST[byFld] = $user,
$_POST[onFld] = CURRENT_TIMESTAMP";
if($_POST[tlr] != "")
        $sql=$sql.", tlr  = '$_POST[tlr]'";
if($_POST[Extension] != "")
        $sql=$sql.", Extension = Extension + '$_POST[Extension]'";
if($_POST[statusFld] != "")
	$sql=$sql.", $_POST[statusFld] = '$_POST[statusAction]'";
if($_POST[remFld] != "")
	$sql=$sql.", $_POST[remFld] = '$det'";
if($newid!="")
	$sql=$sql.", ohrm_project_id = $newid";
if($_POST[ActualEndDate]!="")
        $sql=$sql.", actual_end_date = '$_POST[ActualEndDate]'";
$sql= $sql." where id=$_POST[proj_id]";

$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
/*Send Email*/
$sql="
select * from project_emails where email is not null and id =".$_POST[proj_id];
$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
 $mails="";
while($row=mysqli_fetch_array($result))
{
	$mails.=$row[email].",";
	$name=$row[project_name];
	$custname=$row[cust_name];
}


$_GET['emails']=$mails;
$_GET['projid1']=$_POST[proj_id];
$_GET['statuschg']=$_POST[statuschg];
$_GET['prevstatuschg']=$_POST[prevstatus];
$_GET['projname']=$name;
$_GET['custname']=$custname;
$_GET['empname']=$empname;

include 'mail.php';
closeConnection($con);
closeConnection($orcon);
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'success.php';
header("Location:".$extra."?redirectproject=".$_POST[proj_id]);
exit;
?>
