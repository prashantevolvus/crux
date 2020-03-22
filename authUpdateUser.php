<?php 
$permission = "VIEW";
	if($_GET['action']=='AUTH'){
	$permission = $_GET['perm'];
	}
	require_once('common.php');
	echo $_SESSION["user"];
?>
