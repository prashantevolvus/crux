<?php
require_once('dbconn.php');



$con=getConnection();
$sql="
select emp.emp_number emp_no,concat(emp.emp_firstname  ,' ' ,emp.emp_lastname) employee,
 sup.emp_number supervisor,job_title,concat('http://localhost/cruxa/getEmpPic.php?emp=',emp.emp_number) pic_url
from hr_mysql_live.hs_hr_employee emp
left join hr_mysql_live.hs_hr_emp_reportto on emp.emp_number = erep_sub_emp_number and erep_reporting_mode = 1
left join  hr_mysql_live.hs_hr_employee sup on sup.emp_number = erep_sup_emp_number
left join hr_mysql_live.ohrm_job_title tt on tt.id = emp.job_title_code
left join hr_mysql_live.hs_hr_emp_picture tp on emp.emp_number = tp.emp_number
where emp.emp_status not in (6,4)
";
//echo $sql;

$result = mysqli_query($con,$sql) or debug($sql.$where."   failed  <br/><br/>".mysql_error());
$return_arr = array();
while($row = mysqli_fetch_array($result))
{
//echo $row['project_name'];
 $return_arr[]  = array (

              'id' => $row['emp_no'],
            'pid' => $row['supervisor'],
             'name' => $row['employee'],
             'title' => $row['job_title'],
             'img' => $row['pic_url']
        );
}
    echo json_encode($return_arr);

?>
