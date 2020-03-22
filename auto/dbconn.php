<?php

function getOrangeConnection()
{

require 'db_inc.php';
	$con=mysqli_connect($db_host,$db_user,$db_password,$db_orangehrm,$db_port);
// Check connection
	if (mysqli_connect_errno())
  	{
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
  	}
	return $con;
}

function getConnection()
{

require 'db_inc.php';
//.$db_user.$db_password.$db_proj.$port;
	$con=mysqli_connect($db_host,$db_user,$db_password,$db_proj,$db_port);
// Check connection
	if (mysqli_connect_errno())
  	{
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
  	}
	return $con; 

}
function debug($str)
{
	
require 'db_inc.php';
	if($debugger =="yes")
	{
		echo "SQL Error ";
		die($str);		
	}
	else
	{
		die("There has been an error");

	}

}

function closeConnection($con)
{
	mysqli_close($con);
}

function checkUserSession($loggedinuser)
{

	return !(!isset($loggedinuser) || ($loggedinuser)=="");
}
?>
