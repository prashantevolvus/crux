<html>
<?php 
session_name("Project");
session_start();
require_once('dbconn.php');
if(checkUserSession($_SESSION['user']))
{
	header("Location:index.php");
}

?>
<script>
function start(){
	document.getElementById('myusername').focus();
}
</script>
<head>
</head>
<body  onload="start;">
<tr>
<td>
<img align="middle" src="images/logo.png">
</td>
</tr>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
<tr>
<form name="form1" method="post" action="checklogin.php">
<td>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
<?php
$fail=$_GET['fail'];
if($fail=="yes")
	echo "<b>WRONG CREDENTIALS. Try Again...</b>";
?>
<tr>
<td colspan="3"><strong>Member Login </strong></td>
</tr>
<tr>
<td width="78">Username</td>
<td width="6">:</td>
<td width="294"><input name="myusername" type="text" id="myusername" autofocus required></td>
</tr>
<tr>
<td>Password</td>
<td>:</td>
<td><input name="mypassword" type="password" id="mypassword" required></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Login"></td>
</tr>
</table>
</td>
</form>
</tr>
</table>
</body>
</html>
