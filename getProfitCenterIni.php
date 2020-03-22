<?php
session_name("Project");
session_start();
require_once('dbconn.php');
if(!checkUserSession($_SESSION["user"]))
{
        echo "<script>window.top.location.href='login.php'</script>";
        //header("Location:login.php");
}

$con=getConnection();

$sql="select pc_id,pc_name from profit_centers";
$result = mysqli_query($con,$sql) or debug($sql."failed<br/><br/>".mysql_error());

echo "<select id='profit_centers' name='profit_centers' value=''> <option value='' selected='selected'>Choose...</option>";

while($row = mysqli_fetch_array($result))
  {
       $opt="<option value='" . $row['pc_id'] . "'> ".$row['pc_name']."</option>";
       echo $opt;
  }
echo "</select>";




closeConnection($con);

?>
