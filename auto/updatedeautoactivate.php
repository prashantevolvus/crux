<?php
require 'dbconn.php';

$con=getConnection();

$orcon=getOrangeConnection(); 
$user=0;

$sql = "call deactivate_project";
$result = mysqli_query($con,$sql) or die($sql."<br/><br/>".mysql_error());


$sql = "select project_name , ohrm_project_id , id,reason,alerted from audit_alert where alerted = 0";
$result = mysqli_query($con,$sql) or die($sql."<br/><br/>".mysql_error());
 
while($row = mysqli_fetch_array($result))
{
/*Send Email*/
$sqlemail="
select id,email,project_name from project_emails where email is not null and id =".$row[id];
$resultemail = mysqli_query($con,$sqlemail) or die($sqlemail."<br/><br/>".mysql_error());
 $mails="";
while($rowemail=mysqli_fetch_array($resultemail))
{
	$mails.=$rowemail[email].",";
	$name=$rowemail[project_name];
}


$_GET['emails']=$mails;
$_GET['projid1']=$row[id];
$_GET['statuschg']='AUTO DEACTIVATED due to '.$row[reason];
$_GET['projname']=$row[project_name];
$_GET['empname']='ADMIN';
include 'mail.php';

	
}
$sql = "update audit_alert set alerted = 1 where alerted = 0";
$result = mysqli_query($con,$sql) or die($sql."<br/><br/>".mysql_error());

	
closeConnection($con);
closeConnection($orcon);

exit;
?>
