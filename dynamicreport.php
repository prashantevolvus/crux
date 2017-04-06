<?php
$permission = "VIEW";
require_once('head.php');

require_once('bodystart.php');
?>



<?php

$reportid=$_GET["rep_id"];
$org = $reportid;
$con=getConnection();
$sql=
"select * from dynamic_reports where id = ".$reportid;

$result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>".mysql_error());
$row = mysqli_fetch_array($result);
$head=$row['summary_enabled'];
closeConnection($con);

if($head == "Y") 
{
	$con1=getConnection();
	$sql=
	"select * from dynamic_summary_map where rep_id = ".$reportid;

	$result1 = mysqli_query($con1,$sql) or debug($sql."   failed  <br/><br/>".mysql_error());
	while($row1 = mysqli_fetch_array($result1))
	{
		$_GET["rep_id"] = $row1['summary_id'];
		include 'getdynamicreport.php';
	
	}

	closeConnection($con1);
}
$_GET["rep_id"] = $org;
include 'getdynamicreport.php';

?>


<?php

require_once('bodyend.php');
?>

