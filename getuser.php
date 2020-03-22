<?php
session_name("Project");
session_start();
require_once('dbconn.php');

if(!checkUserSession($_SESSION["user"]))
{
        echo "<script>window.top.location.href='login.php'</script>";
        //header("Location:login.php");
}
$q=$_GET["q"];
$con=mysqli_connect("localhost","root","root","hr_mysql_live");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$sql="SELECT * FROM ohrm_project where name like '%".$q."%'";
$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());

echo "<table border='1'>
<tr>
<th>Name</th>
<th>Desc</th>
<th>Budget_val</th>
<th>Invoice_val</th>
<th>Recieved_val</th>
</tr>";
echo $sql;
while($row = mysqli_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['name'] . "</td>";
  echo "<td>" . $row['description'] . "</td>";
  echo "<td>" . $row['budget_val'] . "</td>";
  echo "<td>" . $row['invoice_val'] . "</td>";
  echo "<td>" . $row['received_val'] . "</td>";
  echo "</tr>";
  }
echo "</table>";
mysqli_close($con);
?>
