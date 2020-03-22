<?php
require_once 'dbconn.php';
session_name("Project");
session_start();
if(!checkUserSession($_SESSION["user"]))
{
        echo "<script>window.top.location.href='login.php'</script>";
}
$con=getConnection();
$id = $_GET['id'];
$sql="SELECT mh_code,mh_name from main_heads;";
$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());

echo "</td><td><select id='mh$id' name='oh_main_head[]' value=''  onchange=showSubheads(this.value.split('|')[0],'$id'); required> <option value='' selected='selected'>Choose...</option>";

while($row = mysqli_fetch_array($result))
  {
      
	$opt="<option value='" . $row['mh_code'].'|'.$row['mh_name'] . "'> " . $row['mh_name'] . "</option>";
	
       echo $opt;

  }
  
echo "</select>";
closeConnection($con);

?>
<!--onchange=getProjectParam()-->
