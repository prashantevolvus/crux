<?php
session_name("Project");
session_start();
if(!checkUserSession($_SESSION["user"]))
{
        echo "<script>window.top.location.href='login.php'</script>";
        //header("Location:login.php");
}

require 'dbconn.php';

$con=getConnection();

	$page = checkUserSession($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = checkUserSession($_POST['rows']) ? intval($_POST['rows']) : 50;
	$offset = ($page-1)*$rows;
	
	$result = array();
$sql="select count(*) from project_invoice  ";

$rs = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
	
	
	$row = mysqli_fetch_row($rs);
	$result["total"] = $row[0];
	
$sql="
select milestone_type mile_stone, lcy_amount, project_ccy_amount, status from project_invoice a
inner join milestone b on a.mile_stone = b.id";

$rs = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
	
	$rows = array();
	while($row = mysqli_fetch_object($rs)){
		array_push($rows, $row);
	}
	$result["rows"] = $rows;
	
	echo json_encode($result);
?>
