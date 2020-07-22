<?php
require_once('dbconn.php');
$con=getConnection();
$emp=$_GET['emp'];
$sql="
select emp.emp_number , epic_picture, concat(emp.emp_firstname  ,emp.emp_lastname) employee
from hr_mysql_live.hs_hr_employee emp
left join hr_mysql_live.hs_hr_emp_picture tp on emp.emp_number = tp.emp_number
where emp.emp_status not in (6,4) and emp.emp_number =  {$emp}
";

$result = mysqli_query($con,$sql) or debug($sql.$where."   failed  <br/><br/>".mysql_error());
$row = mysqli_fetch_array($result);
header('Content-Type: image/jpeg');
echo $row['epic_picture'];
// echo "Started Downloading Images";
// echo "<br>";
// while($row = mysqli_fetch_array($result))
// {
//   $filename = "./images/emp/PRXT".$row['emp_number'].".jpg";
//   echo "Downloading Images for ".$row['employee']." File name : ".$filename;
//   echo "<br>";
//   $imgfile = fopen($filename, "x");
//   fwrite($imgfile, $row['epic_picture']);
//   fclose($imgfile);
//
// }
// echo "Completed Downloading Images";
// echo "<br>";
?>
