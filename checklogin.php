<?php
session_name("Project");
session_start();
require 'db_inc.php';
$ldap['user']=$_POST['myusername'];
$ldap['pass']=$_POST['mypassword'];

$ldap['host']   = $ldap_host;
$ldap['suffix'] = $ldap_suffix;

$ldap['port']   = $ldap_port;
$redir = isset($_POST['red1']) ? $_POST['red1'] :'';
$ldap['conn'] = ldap_connect( $ldap['host'], $ldap['port'] )or debug("Could not conenct to {$ldap['host']}");
$ldap['bind'] = ldap_bind($ldap['conn'], $ldap['user'].$ldap['suffix'], $ldap['pass']);

if( !$ldap['bind'] )
{
	echo "Wrong Username or Password";
        header("location:login.php?fail=yes");
}
else
{
	$_SESSION["user"]=$ldap['user'];
	$_SESSION["pass"]=$ldap['pass'];
require 'dbconn.php';

$orcon=getOrangeConnection();
//Please uncomment once old expense has been entered
$sql="
select a.emp_number emp_number, user_name , concat(emp_firstname,' ',emp_lastname) emp_name from ohrm_user a
inner join hs_hr_employee b on a.emp_number = b.emp_number
where deleted = 0 and user_name =  '".$_SESSION['user']."'";

$result = mysqli_query($orcon,$sql) or debug($sql."<br/><br/>".mysql_error());

$row = mysqli_fetch_array($result);

	$_SESSION["userempno"]=$row[emp_number];
	$_SESSION["user_name"]=$row[emp_name];

	if(isset($_SESSION['url']))
		$url = $_SESSION['url']; // holds url for last page visited.
	else
		$url = "index.php";

        header("location:".$url);

}





?>
