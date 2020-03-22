<?php
session_name("Project");
session_start();

require 'dbconn.php';
if(!checkUserSession($_SESSION["user"]))
{
        echo "<script>window.top.location.href='login.php'</script>";
        //header("Location:login.php");
}


$con=getConnection();

	
$sql="select id, milestone_type from milestone";

$rs = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
	
	$rows = array();
	while($row = mysqli_fetch_object($rs)){
		array_push($rows, $row);
	}
	
	echo json_encode($rows);
?>
