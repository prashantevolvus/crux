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
<?php
echo $q=$_GET["redirectproject"];
$riskid=$_GET["projectid"];
if($q != "")
{

	header("Location:viewprojdetails.php?proj_id=".$q."&redirect=success");
	
}
include 'header.php'; ?>



<h2>Successfully updated the details....</h2>
<?php 

if($riskid !='')
{
   // echo "<form action='updateacceptcr.php' method='post' onsubmit="return formSubmit();" >";
    echo "<a href='createrisk.php'><button>Continue</button></a>";
}
?>

</body>
</html>
