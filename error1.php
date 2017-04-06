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
<? include 'header.php'; ?>
<h2>This operation cannot be performed</h2>
</body>
</html>
