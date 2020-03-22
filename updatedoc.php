<?php
session_name("Project");
session_start();
$_SESSION['url'] = $_SERVER['REQUEST_URI']; 
require_once('dbconn.php');
if(!checkUserSession($_SESSION["user"]))
{
	header("Location:login.php");
}
?>
<html>
<head>
</head>
<body>
<? include 'header.php';
?>
<h3>Upload Project Document</h3>

<form action="updatedoc.php" method="POST" enctype="multipart/form-data">
<tr>
<td>
<input type="file" name="file">
</td>
</tr>

<tr>
<td>
<input type="submit" name="submit" value="Search">
</tr>
</td>
</form>

</body>

</html>
