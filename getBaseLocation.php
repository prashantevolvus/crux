<?php
require_once 'dbconn.php';
session_name("Project");
session_start();
if(!checkUserSession($_SESSION["user"]))
{
        echo "<script>window.top.location.href='login.php'</script>";
}
$con=getOrangeConnection();

$sql="SELECT name,id from ohrm_location;";
$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());

echo "</td><td><select id='baseLocationSel' name='oh_alloc_param[]' value='' required> <option value='' selected='selected'>Choose...</option>";

while($row = mysqli_fetch_array($result))
  {
      
	$opt="<option value='" . $row['id'] . "'> " . $row['name'] . "</option>";
	
       echo $opt;
       
  }
  
echo "</select>";
closeConnection($con);

?>
<!--onchange=getProjectParam()-->
