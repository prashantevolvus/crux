<!DOCTYPE html>
<?
session_name("Project");
session_start();
require_once('dbconn.php');
if(!checkUserSession($_SESSION["user"]))
{
	header("Location:login.php");
}
if(checkProjectPermission("VIEW") == false)
{

        header("Location:error.php");
}
?>
<html>
<head>

    <title>Activity</title>

  
</head>
<body>
<? 
include 'header.php';
?>
  
<!-- Example scripts go here -->
<table>
<tr>
<td>
    <?include 'activity_effort.php';?>
</td>
<td>
	<?include 'activity_cost.php';?>
</td>	
</tr>
<br>	
<tr>
<td>
    <?//include 'activity_effort_last_qtr.php';?>
</td>
<td>
	<?//include 'activity_cost_last_qtr.php';?>
</td>	
</tr>
<table>

</body>


</html>
