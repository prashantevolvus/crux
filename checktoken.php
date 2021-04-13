<?php
session_name("Project");
session_start();
require_once('dbconn.php');




$orcon=getOrangeConnection();
//Please uncomment once old expense has been entered
$sql="
select a.emp_number emp_number, user_name , concat(emp_firstname,' ',emp_lastname) emp_name from ohrm_user a
inner join hs_hr_employee b on a.emp_number = b.emp_number
where deleted = 0 and emp_work_email =  '".$_GET["user"]."'";

$result = mysqli_query($orcon,$sql) or debug($sql."<br/><br/>".mysql_error());

$row = mysqli_fetch_array($result);

	$_SESSION["userempno"]=$row[emp_number];
	$_SESSION["user_name"]=$row[emp_name];
	$_SESSION["user"] = $row[user_name];

	if(isset($_SESSION['url']))
		$url = $_SESSION['url']; // holds url for last page visited.
	else
		$url = "index.php";

$url = "index.php";
 header("location:".$url);


?>
<!DOCTYPE html>
<html lang="en">
<head>



<!-- <script type="text/javascript" src="./script/authConfig.js"></script>
	<script type="text/javascript" src="./script/authRedirect.js"></script>
 -->
	<title>Crux - Project tool</title>

	<script type="text/javascript">



	</script>

</head>
<body>
<h1>Welcome</h1>
<div id=usrName>Welcome Check token <?php echo $qx;?>
</div>

<div id="user">
<?php echo $_SESSION["user_name"];?>
</div>
</body>
</html>
