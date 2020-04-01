<?php
session_name("Project");
session_start();
$_SESSION['url'] = $_SERVER['REQUEST_URI'];
require_once('dbconn.php');
require_once('db_inc.php');

if(!checkUserSession($_SESSION["user"]))
{
	header("Location:login.php");
}

if(checkProjectPermission($permission) == false)
{

        header("Location:error.php");
}

?>
