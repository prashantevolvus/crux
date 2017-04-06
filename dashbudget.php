<?php
$con=getConnection();
$sql="
select c.name customer_name,project_name,status ,
b.budget,b.excess_budget,b.budget_to_go,a.id project_id
from project_details a
inner join project_summary b on b.project_id = a.ohrm_project_id
inner join hr_mysql_live.ohrm_customer c on a.ohrm_customer_id = c.customer_id 
where status in ('ACTIVE','DEACTIVATED','PENDING INVOICE','WARRANTY','DELIVERED') and b.budget_to_go/(b.budget+b.excess_budget) < 0.1 and c.name <> 'Management'
order by status,b.budget_to_go 
"; 

$result = mysqli_query($con,$sql) or die($sql."<br/><br/>".mysql_error());

echo "<h4>Budget Overrun</h4>";

echo "<div class='table-responsive'>";
echo "<table class='table table-bordered' id='inv'>";
echo "<br><tr>";
echo "<th><b>Project Name</b></th>";


echo "<th><b>Status</b></th>";

echo "<th><b>Budget</b></th>";

echo "<th><b>Excess Budget</b></th>";
echo "<th><b>Budget to go</b></th>";

echo "</tr>";

while($row = mysqli_fetch_array($result))
  {
   
	echo "<tr>";
	$project = $row[customer_name]." - ".$row[project_name]; 
	echo "<td><a href='viewprojdetails.php?proj_id=$row[project_id]'>$project</a></td>";
    	
	echo "<td>$row[status]</td>";
		$amt=number_format($row[budget],2);
        echo "<td align='right'>$amt</td>";
		

		$amt=number_format($row[excess_budget],2);
        echo "<td align='right'>$amt</td>";
		

		$amt=number_format($row[budget_to_go],2);
    echo "<td align='right'>$amt</td>";
		
	
	echo "</tr>";
	
}

echo "</table> </div>";

?>
