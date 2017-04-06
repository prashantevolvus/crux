<?php
session_name("Project");
session_start();
require_once('dbconn.php');
if(!checkUserSession($_SESSION["user"]))
{
	header("Location:login.php");
}
if(checkProjectPermission("GENREP") == false)
{

        header("Location:error.php");
}


$coned=getConnection();
$sqled="
select mon_date , c.report_date ,  b1.name customer,b.id proj_id,
b.project_name,mon_date,c.id,'GENERATED',b.tlr,getEmpName(project_manager_id) project_manager,
getEmpName(project_director_id) project_director,report_type
from mondays a
inner join project_details b on mon_date between actual_start_date and current_date
inner join hr_mysql_live.ohrm_customer b1 on customer_id = ohrm_customer_id
left join 
(
	select x.* from project_report x
	inner join (select project_id , max(report_date) report_date from project_report group by project_id) m 
		on x.project_id = m.project_id and x.report_date=m.report_date
) c on b.id = c.project_id 
inner join KeyValue on KeyName = 'report_start_date'
where 
b.status in ('ACTIVE','DEACTIVATED') and mon_date >=  valueName 
and 
mon_date = (
	case when c.report_date is null then date_sub(current_date, interval  weekday(current_date) day)
	     when b.Report_type = 'WEEKLY' then date_add(c.report_date, interval 1 week)
	     when b.Report_type = 'FORTNIGHTLY' then date_add(c.report_date, interval 2 week)
	     when b.Report_type = 'MONTHLY' then date_add(c.report_date, interval 1 month)
	     when b.Report_type = 'QUARTERLY' then date_add(c.report_date, interval 3 month)
end) and mon_date <> ifnull(report_date,'DEFAULT')  and mon_date <= date_sub(curdate(), interval WEEKDAY(curdate()) day)
order by b.id " ;
$resulted = mysqli_query($coned,$sqled) or debug($sqled."   failed  <br/><br/>".mysql_error());

?>
<html>
<head>

<script>

function formSubmit()
{
return true;
	var project = document.forms["projectForm"]["proj"];
	if(project)
                project.style.background="white";
	var chk = project;
        if(typeof chk === "undefined")
        {
                alert('Project not Entered');
                chk.style.background="pink";
                chk.focus();
                return false;
        }


	return true;
	
}


</script>
</head>
<body >
<? include 'header.php'; ?>


<h3>Generate All Project Report</h3>
<form name="projectForm" action="updategenprojrep.php" method="post" onsubmit="return formSubmit();" >

<?
if(mysqli_num_rows($resulted) != 0)
{
	echo "<td>"; 
	echo "<input type='submit'  value='Generate'> ";
	echo "</td>";
}
?>
</form>
<?
echo "<tr><td><b class='floating'>Number of Project reports to be generated : ".mysqli_num_rows($resulted)."</b></td></tr>";

echo "<table id='ProjReport' class='gridtable' border='0'>";
if(mysqli_num_rows($resulted) != 0)
{

echo "<br><tr>";
echo "<th><b>Customer Name</b></th>";
echo "<th><b>Project  Name</b></th>";
echo "<th><b>Report Date</b></th>";
echo "<th><b>Project Manager</b></th>";
echo "<th><b>Project Director</b></th>";
echo "<th><b>Report Type</b></th>";

echo "</tr>";
while($row = mysqli_fetch_array($resulted))
{
	echo "<tr>";
	echo "<td>$row[customer]</td>";
    echo "<td><a href='viewprojdetails.php?proj_id=$row[proj_id]'>$row[project_name]</a></td>";
		$dt = date("d-M-Y", strtotime($row[mon_date]));

        echo "<td>$dt</td>";

	echo "<td>$row[project_manager]</td>";
	echo "<td>$row[project_director]</td>";
	echo "<td>$row[report_type]</td>";
	
	echo "</tr>";
}

echo "</table>";

}
?>
</form>
</body>
</html>
