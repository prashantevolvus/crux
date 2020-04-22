<?php
require_once('../dbconn.php');


$con=getConnection();
$sql="
select a.id,
opp_name	,b.name	customer_name, a.customer_id , opp_det	,
    initial_quote	,current_quote	,no_regret_quote	,
    start_date	, expected_close_date	,
    concat(emp_firstname,' ',emp_middle_name,' ',emp_lastname) emp_name	, assigned_to,
    sales_stage, sales_stage_id,social_stage , social_stage_id	,
    project_type, 	f.project_type_id , product_name	, a.base_product_id , project_name	, a.project_id ,
    change_request	,new_business	,
    proposal_set_path	, active , invoice_amount,proposal_doc,estimation_sheet
 from opp_details a
inner join hr_mysql_live.ohrm_customer b on a.customer_id = b.customer_id
inner join opp_sales_stage c on a.sales_stage_id = c.id
inner join opp_social_stage d on a.social_stage_id = d.id
inner join hr_mysql_live.hs_hr_employee e on a.assigned_to = e.emp_number
left join project_type f on f.project_type_id = a.project_type_id
left join products g on g.id = a.base_product_id
left join project_details h on h.id = a.project_id
LEFT JOIN (SELECT OPP_ID,SUM(INVOICE_AMOUNT) INVOICE_AMOUNT FROM opp_invoices GROUP BY OPP_ID) j on j.opp_id = a.id
where 1=1 ".(!empty($_GET["oppid"])  ? "and a.id = ".$_GET["oppid"] : "and a.id = 1");


//echo $sql;

$result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");
$return_arr = array();
while($row = mysqli_fetch_assoc($result))
{
   $return_arr[] = $row;

}
header('Content-Type: application/json');

    echo json_encode($return_arr);

?>
