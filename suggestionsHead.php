<?php
require_once 'dbconn.php';
session_name("Project");
session_start();
if(!checkUserSession($_SESSION["user"]))
{
        echo "<script>window.top.location.href='login.php'</script>";
}
$con=getConnection();
$q=$_REQUEST["q"]; 
$sql="select distinct(to_heads) from txn_overheads where to_heads like '%$q%'";
$json=array();
$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
while($row = mysqli_fetch_array($result))
  {
	array_push($json, $row['to_heads']);
  }
    echo json_encode($json);
  
closeConnection($con);
?>
