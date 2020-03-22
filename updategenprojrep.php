<?php
session_name("Project");
session_start();
require 'dbconn.php';

$con=getConnection();

//Please uncomment once old expense has been entered


$user=$_SESSION["userempno"];
$empname=$_SESSION["user_name"];

	$sql=
"
insert into project_report
(
project_id,report_date,prev_report_id,status,tlr,budget,excess_budget,contract_value,cashflow,labour,unified_labour,expense,invoice_pending,invoice_invoiced,invoice_paid,invoice_invoiced_pastdue,invoice_payment_pastdue,cr_raised,cr_approved,generated_by
)
select
b.id,mon_date,c.id,'GENERATED',b.tlr,
ifnull(d.budget,0), ifnull(d.excess_budget,0), ifnull(d.contract,0), ifnull(d.cashflow,0), 
ifnull(base_labour_cost,0), ifnull(unitLabourCost,0),
ifnull(expense_cost,0),  ifnull(i1.lcy_amount,0), ifnull(i2.lcy_amount,0), ifnull(i3.lcy_amount,0),
ifnull(i4.lcy_amount,0), ifnull(i5.lcy_amount,0), ifnull(cr1.cr_amount,0), ifnull(cr2.cr_amount,0), ".
'$user'.
" 
from mondays a
inner join project_details b on mon_date between actual_start_date and current_date
left join 
(
	select x.* from project_report x
	inner join (select project_id , max(report_date) report_date from project_report group by project_id ) m 
		on x.project_id = m.project_id and x.report_date=m.report_date
) c on b.id = c.project_id
inner join KeyValue on KeyName = 'report_start_date'
inner join project_summary d on d.project_id = b.ohrm_project_id 
left join 
(	select project_id , sum(ifnull(lcy_amount,0)) lcy_amount 
	from project_invoice where status = 'PENDING' group by project_id
) i1 on i1.project_id = b.id
left join 
(	select project_id , sum(ifnull(lcy_amount,0)) lcy_amount 
	from project_invoice where status = 'INVOICED' group by project_id
) i2 on i2.project_id = b.id
left join 
(	select project_id , sum(ifnull(lcy_amount,0)) lcy_amount 
	from project_invoice where status = 'PAID' group by project_id
) i3 on i3.project_id = b.id
left join 
(	select project_id , sum(ifnull(lcy_amount,0)) lcy_amount 
	from project_invoice where status = 'PENDING' and  expected_invoice_date < current_date
	group by project_id
) i4 on i4.project_id = b.id
left join 
(	select project_id , sum(ifnull(lcy_amount,0)) lcy_amount 
	from project_invoice where status in('PENDING','INVOICED') and  expected_paid_date < current_date
	group by project_id
) i5 on i5.project_id = b.id
left join 
(	select project_id , sum(ifnull(cr_amount,0)) cr_amount 
	from project_cr where status in('PENDING')
	group by project_id
) cr1 on cr1.project_id = b.id
left join 
(	select project_id , sum(ifnull(cr_amount,0)) cr_amount 
	from project_cr where status in('ACCEPTED')
	group by project_id
) cr2 on cr2.project_id = b.id
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
order by b.id
";
//die($sql);
	$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
/*Send Email
$newid=0;
$newid = mysqli_insert_id($con);
$sql="
select * from project_emails where email is not null and id =".$newid;
$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
 $mails="";
while($row=mysqli_fetch_array($result))
{
        $mails.=$row[email].",";
        $name=$row[project_name];
}


$_GET['emails']=$mails;
$_GET['projid1']=$newid;
$_GET['projname']=$name;

$_GET['statuschg']='INITIATED';
$_GET['empname']=$empname;



include 'mail.php';

closeConnection($con);
*/
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'success.php';
header("Location: http://$host$uri/$extra");
exit;
?>
