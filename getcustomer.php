<?php
require_once 'dbconn.php';
session_name("Project");
session_start();
if(!checkUserSession($_SESSION["user"]))
{
        echo "<script>window.top.location.href='login.php'</script>";
}
$con=getOrangeConnection();

$sql="SELECT customer_id,name FROM ohrm_customer where is_deleted = 0 order by name";
$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());

echo "<select id='cust' name='cust' value=''onchange=showProject(this.value)> <option value='Choose..' selected='selected'>Choose...</option>";

while($row = mysqli_fetch_array($result))
  {
      
	$opt="<option value='" . $row[customer_id] . "'> " . $row[name] . "</option>";
	
       echo $opt;
       
  }
  
echo "</select>";
closeConnection($con);
?>
