<?php
/*
session_start();
if(!checkUserSession($_SESSION["user"]))
{
        echo "<script>window.top.location.href='login.php'</script>";
        //header("Location:login.php");
}
*/
/*Database settings*/
$db_host="evolvus.com";
$db_port="3306";
$db_user="orangehrm";
$db_password="orangehrm*code@098";
$db_orangehrm="hr_mysql_live";
$db_proj="project_management";


/* LDAP SETTINGS*/
$ldap_host   = 'evolvus.com';
$ldap_suffix = '@evolvus.com';
$ldap_port   = 389;


/* GENERAL SETTINGS*/
$debugger="yes";


/* SMTP SETTINGS*/
$mail_host="smtp.gmail.com";
$mail_port=465;
$mail_from="noreply@evolvussolutions.com";
$mail_pass="sprento";
$mail_secure="ssl";
//$mail_default_addr="prashant.maroli@evolvussolutions.com";
$mail_default_addr="pubc.c@evolvussolutions.com";

$orange_timesheet_url="http://www.evolvus.com/orangehrm/symfony/web/index.php/time/viewPendingApprovelTimesheet?";
?>
