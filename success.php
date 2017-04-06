<html>
<?php
session_name("Project");
session_start();
require_once('dbconn.php');
if(!checkUserSession($_SESSION["user"]))
{
        header("Location:login.php");
}

?>

<body>
<? 
$q=$_GET["redirectproject"];
if($q != "")
{

	header("Location:viewprojdetails.php?proj_id=".$q."&redirect=success");
	
}
include 'header.php'; ?>



<h2>Successfully updated the details....</h2>

</body>
</html>
