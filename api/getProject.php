<?php
require_once('../dbconn.php');


$con=getConnection();
$sql="
SELECT a.id ,a.project_type_id, customer_id,a.project_name,
       o.name,base_product,planned_start_date,planned_end_date,
       actual_start_date, actual_end_date,region_id,report_type,extension,
       status,pc_id profit_centre_id, project_manager_id,project_director_id,
       Contract_value, cr_amt,a.budget,
       budget_initiated,budget_approved,excess_budget_initiated,excess_budget_approved,
       invoice_pending_lcy_amt,invoiced_lcy_amt,received_lcy_amt,
       base_labour_cost, unified_labour_cost,expense_amt,
       project_details,objectives,scope,success_factor,
       case when status not in('DELETED', 'CLOSED')
          then datediff(planned_end_date,CURRENT_DATE)+ifnull(extension,0) else 0 end noofdays,
          datediff(a.planned_end_date,a.planned_start_date) planned_duration,
          datediff(curdate(),a.actual_start_date) duration_so_far
     FROM project_details a
       INNER JOIN hr_mysql_live.ohrm_customer o
          ON a.ohrm_customer_id = o.customer_id
where 1=1 ".(!empty($_GET["projid"])  ? "and a.id = ".$_GET["projid"] : "and a.id = 1");


//echo $sql;

$result = mysqli_query($con, $sql) or debug($sql."   failed  <br/><br/>");
$return_arr = array();
while ($row = mysqli_fetch_assoc($result)) {
    $return_arr[] = $row;
}
header('Content-Type: application/json');

        echo json_encode($return_arr);
?>
