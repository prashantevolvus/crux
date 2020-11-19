<?php
require_once('../dbconn.php');

$projID = $_GET["projectid"];
$retType = $_GET["type"];

$latest = !empty($_GET["latest"])?$_GET["latest"]:"";

$con=getConnection();
if ($retType == "MonthLabour") {
    $sql="
  SELECT ifnull(REPORT_MONTH,'TOTAL') REPORT_MONTH,  SUM(WORK_HOURS) WORK_HOURS,SUM(LABOURCOST) LABOURCOST, SUM(UNIFIEDCOST) UNIFIEDCOST
  FROM dw_monthly_sheets A
  JOIN project_details B ON A.PROJECT_ID = OHRM_PROJECT_ID
  WHERE ID = {$projID} and EMPLOYEE_NAME <> 'Expense'
  GROUP BY REPORT_MONTH desc
  WITH ROLLUP
  ";
}


if ($retType == "MonthLabourXX") {
    $sql="
    SELECT B.ID,REPORT_MONTH, SUM(UNIFIEDCOST) UNIFIEDCOST FROM DW_MONTHLY_SHEETS A
    JOIN PROJECT_DETAILS B ON A.PROJECT_ID = OHRM_PROJECT_ID
    GROUP BY B.ID,REPORT_MONTH
    ORDER BY REPORT_MONTH
  ";
}

if ($retType == "FinSummary") {
    $sql="
      select project_name,
      contract_value+cr_amt price,
      budget_approved+excess_budget_approved budget,
      unified_labour_cost+expense_amt cost,
      received_lcy_amt received,
      case when contract_value+cr_amt = 0 then 0 else received_lcy_amt-(unified_labour_cost+expense_amt) end cashflow,
      budget_approved+excess_budget_approved-(unified_labour_cost+expense_amt) budget_to_go
      from project_details WHERE ID = {$projID}
    ";
}
if ($retType == "EmpMonthLabour") {
    $sql="
  SELECT REPORT_MONTH, EMPLOYEE_NAME , SUM(WORK_HOURS) WORK_HOURS FROM dw_monthly_sheets A
  JOIN project_details B ON A.PROJECT_ID = OHRM_PROJECT_ID
  WHERE ID = {$projID} and EMPLOYEE_NAME <> 'Expense'
  GROUP BY REPORT_MONTH DESC, EMPLOYEE_NAME
  WITH ROLLUP
  ";
}
if ($retType == "EmpLabour") {
    $sql="
  SELECT EMPLOYEE_NAME , SUM(WORK_HOURS) WORK_HOURS,SUM(UNIFIEDCOST) UNIFIEDCOST FROM dw_monthly_sheets A
  JOIN project_details B ON A.PROJECT_ID = OHRM_PROJECT_ID
  WHERE ID = {$projID} and EMPLOYEE_NAME <> 'Expense'
  GROUP BY EMPLOYEE_NAME
  order by 2 desc
  ";
}

if ($retType == "MonthExpense") {
    $sql="
  SELECT ifnull(REPORT_MONTH,'TOTAL') REPORT_MONTH,  SUM(A.EXPENSE_AMT) EXPENSE_AMOUNT
  FROM dw_monthly_sheets A
  JOIN project_details B ON A.PROJECT_ID = OHRM_PROJECT_ID
  WHERE ID = {$projID} and EMPLOYEE_NAME = 'Expense'
  GROUP BY REPORT_MONTH
  WITH ROLLUP
  ";
}

if ($retType == "TypeExpense") {
    $sql="
  SELECT ACTIVITY EXPENSE_TYPE, SUM(A.EXPENSE_AMT) EXPENSE_AMOUNT FROM dw_monthly_sheets A
  JOIN project_details B ON A.PROJECT_ID = OHRM_PROJECT_ID
  WHERE ID = {$projID} and EMPLOYEE_NAME = 'Expense'
  GROUP BY ACTIVITY
  order by 2 desc
  ";
}

if ($retType == "InvoiceSummary") {
    $sql="
    SELECT IFNULL(A.STATUS,'TOTAL') INVOICE_STATUS , SUM(LCY_AMOUNT) LCY_AMOUNT FROM project_invoice A
  INNER JOIN project_details B ON A.PROJECT_ID = B.ID
  WHERE B.ID = {$projID}
  GROUP BY A.STATUS
  WITH ROLLUP
  ";
}

if ($retType == "InvoiceDetail") {
    $sql="
    SELECT INVOICE_ID,A.STATUS , MILESTONE_DESC,INVOICE_NO,
  CASE WHEN INVOICED_DATE IS NULL OR INVOICED_DATE = '0000-00-00' THEN EXPECTED_INVOICE_DATE ELSE INVOICED_DATE END INVOICE_DATE ,
  CASE WHEN LCY_CR_DATE IS NULL OR LCY_CR_DATE = '0000-00-00' THEN EXPECTED_PAID_DATE ELSE LCY_CR_DATE END PAY_DATE ,
  CASE
    WHEN A.STATUS = 'PENDING' THEN
        DATEDIFF(CURDATE() , CASE WHEN INVOICED_DATE IS NULL OR INVOICED_DATE = '0000-00-00' THEN EXPECTED_INVOICE_DATE ELSE INVOICED_DATE END)
    WHEN A.STATUS = 'INVOICED' THEN
        DATEDIFF(CURDATE() ,   CASE WHEN LCY_CR_DATE IS NULL OR LCY_CR_DATE = '0000-00-00' THEN EXPECTED_PAID_DATE ELSE LCY_CR_DATE END)
    ELSE 0
  END AGEING,
  LCY_AMOUNT
  FROM project_invoice A
  INNER JOIN project_details B ON A.PROJECT_ID = B.ID
  INNER JOIN milestone C ON C.ID = A.MILE_STONE
  WHERE B.ID = {$projID}
  ORDER BY INVOICE_DATE
  ";
}

if ($retType == "Budget") {
    $sql="
      SELECT A.STATUS , BUDGET_NAME , CATEGORY,
        A.EXCESS_BUDGET
        FROM project_excess_budget A
        INNER JOIN project_details B ON A.PROJECT_ID = B.ID
        WHERE B.ID = {$projID}
  ";
}

if ($retType == "Change") {
    $sql="
      SELECT CR_NAME, CR_START_DATE,A.STATUS, CR_AMOUNT,PO_NAME,A.PO_DATE
      FROM project_cr A
      INNER JOIN project_details B ON A.PROJECT_ID = B.ID
      WHERE B.ID = {$projID}
  ";
}


if ($retType == "Document") {
    $sql="
      select   ifnull(cr_name,'PROJECT') CR_NAME,
      FILE_TYPE,VERSION,FILE_NAME,FILE_DESC,concat(emp_firstname,' ',emp_lastname) UPLOADED_BY,UPLOADED_ON,
      a.id FILE_ID
      from  file_data a
      inner join file_type b on a.file_type_id = b.id
      inner join hr_mysql_live.hs_hr_employee c on a.uploaded_by = c.emp_number
      left join project_cr d on a.entity_id = d.cr_id and entity_name = 'CR'
      where ((entity_id = {$projID} and a.entity_name = 'PROJECT') or
      (project_id = {$projID} and a.entity_name = 'CR')   )
    ";

    if(!empty($latest))
      $sql .= " and latest = 1 ";

    $sql .= " order by uploaded_on desc";

}

if ($retType == "OppDocument") {
    $sql="
      select
      FILE_TYPE,VERSION,FILE_NAME,FILE_DESC,concat(emp_firstname,' ',emp_lastname) UPLOADED_BY,UPLOADED_ON,
      a.id FILE_ID
      from  file_data a
      inner join file_type b on a.file_type_id = b.id
      inner join hr_mysql_live.hs_hr_employee c on a.uploaded_by = c.emp_number
      where (entity_id = {$projID} and a.entity_name = 'OPP')     ";

    if(!empty($latest))
      $sql .= " and latest = 1 ";

    $sql .= " order by uploaded_on desc";

}



$result = mysqli_query($con, $sql) or debug($sql."   failed  <br/><br/>");
$return_arr = array();
$enc_arr = array();
$final_arr=array();
while ($row = mysqli_fetch_array($result)) {
    $enc_arr = $row;
    $return_arr[]=$enc_arr;
}
$final_arr['data']=$return_arr;

header('Content-Type: application/json');

echo json_encode($final_arr);
