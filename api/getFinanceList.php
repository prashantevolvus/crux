<?php
require_once('../dbconn.php');

$projID = $_GET["projectid"];
$retType = $_GET["type"];

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
