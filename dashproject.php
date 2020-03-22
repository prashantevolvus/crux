<?php
$con=getConnection();
$sql="
select c.name customer_name,project_name,status ,a.id project_id,
actual_start_date,date_add(ifnull(Actual_start_date,Planned_start_date),interval datediff(Planned_End_date,Planned_start_date)+ifnull(extension,0) day ) forecast_end_date,
datediff(curdate(),date_add(ifnull(Actual_start_date,Planned_start_date),interval datediff(Planned_End_date,Planned_start_date)+ifnull(extension,0) day )) ageing,
extension
 from project_details a
inner join hr_mysql_live.ohrm_customer c on a.ohrm_customer_id = c.customer_id 
where status in ('ACTIVE','DEACTIVATED','WARRANTY','DELIVERED','PENDING INVOICE') and
date_add(ifnull(Actual_start_date,Planned_start_date),interval datediff(Planned_End_date,Planned_start_date)+ifnull(extension,0)-5 day ) < curdate()"; 

$result = mysqli_query($con,$sql) or die($sql."<br/><br/>".mysql_error());


echo "<h4>Duration Overrun</h4>";

echo "<div class='table-responsive'>";
echo "<table class='table table-bordered' id='inv'>";
echo "<br><tr>";
echo "<th><b>Project Name</b></th>";


echo "<th><b>Status</b></th>";

echo "<th><b>Actual Start Date</b></th>";

echo "<th><b>Forecast End Date</b></th>";
echo "<th><b>Ageing</b></th>";

echo "</tr>";

while($row = mysqli_fetch_array($result))
  {
  
	echo "<tr>";
	$project = $row[customer_name]." - ".$row[project_name]; 
	echo "<td><a href='viewprojdetails.php?proj_id=$row[project_id]'>$project</a></td>";
    
	
		echo "<td>$row[status]</td>";
		        $dt = date("d-M-Y", strtotime($row[actual_start_date]));

        echo "<td>$dt</td>";

			        $dt = date("d-M-Y", strtotime($row[forecast_end_date]));

        echo "<td>$dt</td>";

    echo "<td>$row[ageing]</td>";
	
	
	echo "</tr>";
	
}

echo "</table> </div>";

?>
