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

$sql="SELECT id,product_name FROM products ";
$result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>".mysql_error());

echo "<select id='prod' name='prod' value=''  > <option value='Choose..' selected='selected'>Choose...</option>";

while($row = mysqli_fetch_array($result))
  {
        $opt="<option value='" . $row[id] . "'>" . $row[product_name] . "</option>";
       echo $opt;
  }
echo "</select>";




closeConnection($con);

?>
