<?php
require_once 'dbconn.php';
session_name("Project");
session_start();
if(!checkUserSession($_SESSION["user"]))
{
        echo "<script>window.top.location.href='login.php'</script>";
}
$con=getConnection();
$iden = $_GET['iden'];
$typeCode = $_GET['typeCode'];
$sql="select msh_sub_name from main_sub_heads where mh_code = '$typeCode'";
$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());

echo "</td><td><select id='rm$iden' name='oh_name[]' value='' required> 
<option value='' selected='selected'>Choose...</option>";

while($row = mysqli_fetch_array($result))
  {
      
	$opt="<option value='" . $row['msh_sub_name'] . "'> ".$row['msh_sub_name']."</option>";
	
       echo $opt;
       
  }
  
echo "</select>";
closeConnection($con);
?>
