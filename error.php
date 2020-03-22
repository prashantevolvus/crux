<?php
session_name("Project");
session_start();
require_once('dbconn.php');

if(!checkUserSession($_SESSION["user"]))
{
	header("Location:login.php");
}
?>
<html>
<head>
<title>Project Management</title>
</head>
<body>
<?php include 'header.php'; ?>
<h2>You do not have permission for that operation</h2>
</body>
</html>
