<!DOCTYPE html>
<?php
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
<?php
include 'header.php';
?>
  
<!-- Example scripts go here -->
<table>
<tr>
<td>
    <?php  include 'activity_effort.php';?>
</td>
<td>
	<?php  include 'activity_cost.php';?>
</td>	
</tr>
	
<tr>
<td>
    <?php //include 'activity_effort_last_qtr.php';?>
</td>
<td>
	<?php //include 'activity_cost_last_qtr.php';?>
</td>	
</tr>
</table>

</body>


</html>
