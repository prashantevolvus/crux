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
$sql="SELECT expense_id,expense_type FROM expense_type ";
$result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>".mysql_error());

echo "<td><select class='field select' id='expense' name='expense' value=''  onchange=showEMP()> <option value='Choose..' selected='selected'>Choose...</option>";

while($row = mysqli_fetch_array($result))
  {
	$opt="<option value='" . $row[expense_id] . "'>" . $row[expense_type] . "</option>";
       echo $opt;
  }
echo "</select></td></tr>";
closeConnection($con);
?>
