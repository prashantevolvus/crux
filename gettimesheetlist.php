<?php
$permission = "VIEW";

require_once('common.php');


$q=$_GET["q"];
$q1=$_GET["q1"];
$q2=$_GET["q2"];
$q3=$_GET["q3"];
$con=getConnection();


$sql="
select
mon_date, a.emp_number,concat(a.emp_firstname,' ',a.emp_lastname) AS Employee_Name,
supervisor, ifnull(state,'NOT SUBMITTED') state,sup_id,
b.timesheet_Id
 from
mondays
join hr_mysql_live.hs_hr_employee a on (case when (a.emp_status in (6,4)) then 'PAST' else 'CURRENT' end) = '$q3'
and mon_date > joined_date
left join (
select concat(a.emp_firstname,' ',a.emp_lastname) supervisor , erep_sub_emp_number sub,sup_id
from(
select erep_sub_emp_number,max(erep_sup_emp_number) sup_id
 from hr_mysql_live.hs_hr_emp_reportto
group by erep_sub_emp_number) s1
join hr_mysql_live.hs_hr_employee a on a.emp_number = s1.sup_id) sup on sup.sub = a.emp_number
left join hr_mysql_live.ohrm_emp_termination t on a.emp_number = t.emp_number
left join hr_mysql_live.ohrm_timesheet b on a.emp_number = b.employee_id and mon_date=start_date
where  mon_date between DATE_SUB(NOW(), INTERVAL 1 YEAR) and
date_sub(curdate(), interval WEEKDAY(curdate()) + 1 day) and a.emp_number not in (31,260)
and (b.employee_id is null or b.state <> 'APPROVED')
    
";
$sql .= " and 1=1 ";
if($q!="" and strpos($q,"NOT SUBMITTED")==FALSE)
    $sql .= " and state in (".$q.") ";
    if(strpos($q,"NOT SUBMITTED")!=FALSE)
        $sql .= " and (state in (".$q.") or state is null)";
        if($q1!="")
            $sql .= " and sup_id in (".$q1.")";
            if($q2!="")
                $sql .= " and a.emp_number in (".$q2.")";
if($q3=="PAST")
	$sql .= " and t.termination_date > mon_date ";
                $sql .= " order by employee_name,mon_date desc ";
                //die($sql);
                //echo $sql;
                //exit;
                $result = mysqli_query($con,$sql) or die($sql."<br/><br/>".mysql_error());
                ?>

<script>
  $(document).ready( function () {
    $('#timesheet').DataTable({
  "pagingType": "full_numbers",
  "lengthMenu": [ [10, 25, 50, 100,-1], [10, 25, 50, 100,"All"] ],
  "pageLength": 50
} );
} );

</script>
<?php 
echo "<div class='table-responsive'>";

echo "<table class='table table-bordered'  id='timesheet' width='100%'";
echo "<br><thead><tr>";
echo "<th><b>Date</b></th>";

echo "<th><b>Employee Name</b></th>";
	
	echo "<th><b>Supervisor</b></th>";
echo "<th><b>Status</b></th>";


echo "</tr></thead><tbody>";
while($row = mysqli_fetch_array($result))
  {
	echo "<tr>";
		$dt = date("d-M-Y", strtotime($row[mon_date]));

        echo "<td>$dt</td>";
        echo "<td>$row[Employee_Name]</td>";

	    echo "<td>$row[supervisor]</td>";
	    if($row[state] != "SUBMITTED")
	    	echo "<td>$row[state]</td>";
	    else
	    {
	    	$url = "http://www.evolvus.com/orangehrm/symfony/web/index.php/time/viewPendingApprovelTimesheet?";
	    	$url = $url . "timesheetId=".$row[timesheet_Id];
	    	$url = $url . "&employeeId=".$row[emp_number];
	    	$url = $url . "&timesheetStartday=".date("Y-m-d", strtotime($row[mon_date]));
	    	echo "<td><a href = '".$url."' target='_blank'>".$row[state]."</a></td>";
	    }
	    	
	
	echo "</tr>";
  }
echo "</tbody></table>";



closeConnection($con);
?>

