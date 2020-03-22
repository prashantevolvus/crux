<?php
require_once('common.php');

$con=getConnection();
$sql="select * from (
select invoice_id, b.id projectid,'To be Invoiced' action_type, 
		c.name customer_name,b.project_name , lcy_amount , milestone_type , 
		ifnull(upper(cr_name),'CONTRACT MILESTONE') cr_name,ifnull(e.cr_id,0) cr_id, 
		datediff(curdate(), expected_invoice_date) ageing 
from project_invoice a 
inner join project_details b on a.project_id = b.id 
inner join hr_mysql_live.ohrm_customer c on b.ohrm_customer_id = c.customer_id 
inner join milestone d on d.id = a.mile_stone 
		left join project_cr e on e.project_id = a.project_id and e.cr_id = a.cr_id
		where expected_invoice_date <= date_add(curdate(), interval 3 day) and a.status = 'PENDING' 
union 
select invoice_id, b.id projectid,'To be Paid' action_type, c.name ,
		b.project_name , lcy_amount , milestone_type , 
		ifnull(upper(cr_name),'CONTRACT MILESTONE') cr_name,ifnull(e.cr_id,0) cr_id,
datediff(curdate(), expected_paid_date) ageing 
from project_invoice a 
inner join project_details b on a.project_id = b.id 
inner join hr_mysql_live.ohrm_customer c on b.ohrm_customer_id = c.customer_id 
inner join milestone d on d.id = a.mile_stone 
		left join project_cr e on e.project_id = a.project_id and e.cr_id = a.cr_id 
where expected_paid_date <= date_add(curdate(),interval 3 day) and a.status = 'INVOICED') a
order by action_type,ageing desc"; 

$result = mysqli_query($con,$sql) or die($sql."<br/><br/>".mysql_error());


echo "<h4>Invoice Ageing</h4>";

echo "<div class='table-responsive'>";
echo "<table class='table table-bordered' id='inv'>";

echo "<br><tr>";
echo "<th><b>Action</b></th>";
	
echo "<th><b>Project Name</b></th>";
echo "<th><b>CR Name</b></th>";
echo "<th><b>Invoice Amount</b></th>";

echo "<th><b>Milestone</b></th>";


echo "<th><b>Ageing in Days</b></th>";
echo "</tr>";

while($row = mysqli_fetch_array($result))
  {
  
	echo "<tr>";
	echo "<td><a href='viewinvoicedetails.php?invoice_id=$row[invoice_id]'>$row[action_type]</a></td>";
$project = $row[customer_name]." - ".$row[project_name]; 
	echo "<td><a href='viewprojdetails.php?proj_id=$row[projectid]'>$project</a></td>";
	if($row[cr_id] == 0)
		echo "<td>$row[cr_name]</td>";
	else 
		echo "<td><a href='viewcrdetails.php?cr_id=$row[cr_id]'>$row[cr_name]</a></td>";
	
        
    $amt=number_format($row[lcy_amount],2);
        echo "<td align='right'>$amt</td>";
    echo "<td>$row[milestone_type]</td>";
    echo "<td>$row[ageing]</td>";
	
	echo "</tr>";
	
}

echo "</table> </div> ";

?>
