<?php
require_once('dbconn.php');

$id = strtoupper($_GET['projid']);


$con=getConnection();
$sql="
select concat(emp.emp_firstname  ,' ' ,emp.emp_lastname) employee,
 concat(sup.emp_firstname  ,' ' ,sup.emp_lastname) supervisor,job_title
from hr_mysql_live.hs_hr_employee emp
left join hr_mysql_live.hs_hr_emp_reportto on emp.emp_number = erep_sub_emp_number and erep_reporting_mode = 1
left join  hr_mysql_live.hs_hr_employee sup on sup.emp_number = erep_sup_emp_number
left join hr_mysql_live.ohrm_job_title tt on tt.id = emp.job_title_code
where emp.emp_status not in (6,4)
";
//echo $sql;

$result = mysqli_query($con,$sql) or debug($sql.$where."   failed  <br/><br/>".mysql_error());
$return_arr = array();
while($row = mysqli_fetch_array($result))
{
//echo $row['project_name'];
 $return_arr[]  = array (
            
             $row['employee'],
             $row['supervisor'],
             $row['job_title']
        );
}
    echo json_encode($return_arr);

?>