<?php
session_name("Project");
session_start();

require_once 'dbconn.php';
if(!checkUserSession($_SESSION["user"]))
{
        echo "<script>window.top.location.href='login.php'</script>";
        //header("Location:login.php");
}

$q=$_GET["q"];

$con=getConnection();
//Please uncomment once old expense has been entered
$sql="
select id , ohrm_project_id,project_name from project_details where ohrm_customer_id=".$q." order by project_name ";

$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
echo "<select id='proj' name='proj' value=''onchange=showBudget(this.value)>   <option value='Choose..' selected='selected'>Choose...</option>";

while($row = mysqli_fetch_array($result))
  {
	$opt="<option value='" . $row[id] . "'>" . $row[project_name] . "</option>";
       echo $opt;
  }
echo "</select>";
closeConnection($con);
?>
