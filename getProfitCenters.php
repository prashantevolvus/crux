<?php
require_once 'dbconn.php';
session_name("Project");
session_start();
if(!checkUserSession($_SESSION["user"]))
{
        echo "<script>window.top.location.href='login.php'</script>";
}
$con=getConnection();

$sql="select pc_id,pc_name from profit_centers";
$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());

echo "</td><td><select id='profitCenters' name='oh_alloc_param[]' value='' required> 
<option value='' selected='selected'>Choose...</option>";

while($row = mysqli_fetch_array($result))
  {
      
	$opt="<option value='" . $row['pc_id'] . "'> ".$row['pc_name']."</option>";
	
       echo $opt;
       
  }
  
echo "</select>";
closeConnection($con);
?>
