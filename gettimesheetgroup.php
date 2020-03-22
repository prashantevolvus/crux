<?php
session_name("Project");
session_start();
require_once 'dbconn.php';
if(!checkUserSession($_SESSION["user"]))
{
        echo "<script>window.top.location.href='login.php'</script>";
        //header("Location:login.php");
}
$con=getConnection();

$sql=" 
select pending_type , name , pending_no_of_weeks from (
select 'Supervisor' pending_type , supervisor name, count(*) pending_no_of_weeks
from(
select 
mon_date, a.emp_number,concat(a.emp_firstname,' ',a.emp_lastname) AS Employee_Name, supervisor, ifnull(state,'NOT SUBMITTED') state,sup_id
 from 
mondays 
join hr_mysql_live.hs_hr_employee a on (case when (a.emp_status in (6,4)) then 'PAST' else 'CURRENT' end) = 'CURRENT'
and mon_date > joined_date
left join (
select concat(a.emp_firstname,' ',a.emp_lastname) supervisor , erep_sub_emp_number sub,sup_id
from(
select erep_sub_emp_number,max(erep_sup_emp_number) sup_id
 from hr_mysql_live.hs_hr_emp_reportto
group by erep_sub_emp_number) s1 
join hr_mysql_live.hs_hr_employee a on a.emp_number = s1.sup_id) sup on sup.sub = a.emp_number  
left join hr_mysql_live.ohrm_timesheet b on a.emp_number = b.employee_id and mon_date=start_date
where  mon_date between DATE_SUB(NOW(), INTERVAL 1 YEAR) and
date_sub(curdate(), interval WEEKDAY(curdate()) + 1 day) and emp_number not in (31,260) 
and (b.employee_id is null or b.state <> 'APPROVED')) a
group by supervisor 
union
select 'Employee' Pending_type , employee_name , count(*)
from(
select 
mon_date, a.emp_number,concat(a.emp_firstname,' ',a.emp_lastname) AS Employee_Name, supervisor, ifnull(state,'NOT SUBMITTED') state,sup_id
 from 
mondays 
join hr_mysql_live.hs_hr_employee a on (case when (a.emp_status in (6,4)) then 'PAST' else 'CURRENT' end) = 'CURRENT'
and mon_date > joined_date
left join (
select concat(a.emp_firstname,' ',a.emp_lastname) supervisor , erep_sub_emp_number sub,sup_id
from(
select erep_sub_emp_number,max(erep_sup_emp_number) sup_id
 from hr_mysql_live.hs_hr_emp_reportto
group by erep_sub_emp_number) s1 
join hr_mysql_live.hs_hr_employee a on a.emp_number = s1.sup_id) sup on sup.sub = a.emp_number  
left join hr_mysql_live.ohrm_timesheet b on a.emp_number = b.employee_id and mon_date=start_date
where  mon_date between DATE_SUB(NOW(), INTERVAL 1 YEAR) and
date_sub(curdate(), interval WEEKDAY(curdate()) + 1 day) and emp_number not in (31,260)
and (b.employee_id is null or b.state <> 'APPROVED')) a
group by employee_name
) a
order by Pending_type , pending_no_of_weeks desc
";

$result = mysqli_query($con,$sql) or die($sql."<br/><br/>".mysql_error());

?>

<script>
  $(document).ready( function () {
    $('#timesheetgroup').DataTable({
  "pagingType": "full_numbers",
  "lengthMenu": [ [10, 25, 50, 100,-1], [10, 25, 50, 100,"All"] ],
  "pageLength": 50
} );
} );

</script>

<?php

echo "<div class='table-responsive'>";

echo "<table class='table table-bordered'  id='timesheetgroup' width='100%'";
echo "<br><thead><tr>";

echo "<th><b>Type</b></th>";

	
	echo "<th><b>Name</b></th>";

	
echo "<th><b>No of Weeks Pending</b></th>";


echo "</tr></thead><tbody>";
while($row = mysqli_fetch_array($result))
  {
	echo "<tr>";
		echo "<td>$row[pending_type]</td>";

	    echo "<td>$row[name]</td>";
	    echo "<td>$row[pending_no_of_weeks]</td>";

	
	echo "</tr>";
  }
  
echo "</tbody></table></div>";



closeConnection($con);
?>
