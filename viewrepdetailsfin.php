<?php
session_name("Project");
session_start();
require_once('dbconn.php');
if(!checkUserSession($_SESSION["user"]))
{
	header("Location:login.php");
}
if(checkProjectPermission("VIEW") == false)
{

        header("Location:error.php");
}


$repid=$_GET["rep_id"];

$coned=getConnection();
$sqled="
select a.id curr_id,b.id prev_id,
ifnull(a.budget,0)  curr_budget,
ifnull(a.excess_budget,0)  curr_excess_budget,
ifnull(a.contract_value,0)  curr_contract_value,
ifnull(a.cashflow,0)  curr_cashflow,
ifnull(a.labour,0)  curr_labour,
ifnull(a.unified_labour,0)  curr_unified_labour,
ifnull(a.expense,0)  curr_expense,
ifnull(a.invoice_pending,0)  curr_invoice_pending,
ifnull(a.invoice_invoiced,0)  curr_invoice_invoiced,
ifnull(a.invoice_paid,0)  curr_invoice_paid,
ifnull(a.invoice_invoiced_pastdue,0)  curr_invoice_invoiced_pastdue,
ifnull(a.invoice_payment_pastdue,0)  curr_invoice_payment_pastdue,
ifnull(a.cr_raised,0)  curr_cr_raised,
ifnull(a.cr_approved,0)  curr_cr_approved,
ifnull(a.estimated_budget_to_go,0)  curr_estimated_budget_to_go,
ifnull(b.budget,0)  prev_budget,
ifnull(b.excess_budget,0)  prev_excess_budget,
ifnull(b.contract_value,0)  prev_contract_value,
ifnull(b.cashflow,0)  prev_cashflow,
ifnull(b.labour,0)  prev_labour,
ifnull(b.unified_labour,0)  prev_unified_labour,
ifnull(b.expense,0)  prev_expense,
ifnull(b.invoice_pending,0)  prev_invoice_pending,
ifnull(b.invoice_invoiced,0)  prev_invoice_invoiced,
ifnull(b.invoice_paid,0)  prev_invoice_paid,
ifnull(b.invoice_invoiced_pastdue,0)  prev_invoice_invoiced_pastdue,
ifnull(b.invoice_payment_pastdue,0)  prev_invoice_payment_pastdue,
ifnull(b.cr_raised,0)  prev_cr_raised,
ifnull(b.cr_approved,0)  prev_cr_approved,
ifnull(b.estimated_budget_to_go,0)  prev_estimated_budget_to_go
from project_report a
left join project_report b on a.prev_report_id = b.id
where a.id = ".$repid ;


$resulted = mysqli_query($coned,$sqled) or debug($sqled."   failed  <br/><br/>".mysql_error());
$rowed = mysqli_fetch_array($resulted);
$tot_prev_expense = $rowed[prev_unified_labour] + $rowed[prev_expense];
$tot_curr_expense = $rowed[curr_unified_labour] + $rowed[curr_expense];
$prev_profit = $rowed[prev_contract_value] - $tot_prev_expense ;
$curr_profit = $rowed[curr_contract_value] - $tot_curr_expense ;
if($rowed[prev_contract_value] == 0)
	$prev_profit_pcnt = 0;
else
	$prev_profit_pcnt = $prev_profit *100.0/$rowed[prev_contract_value];
if($rowed[curr_contract_value] == 0)
	$curr_profit_pcnt = 0;	
else
	$curr_profit_pcnt = $curr_profit *100.0/$rowed[curr_contract_value];
$prev_tot_budget = $rowed[prev_excess_budget]+$rowed[prev_budget];
$curr_tot_budget = $rowed[curr_excess_budget]+$rowed[curr_budget];
$prev_pend_budget = $prev_tot_budget -$tot_prev_expense;
$curr_pend_budget = $curr_tot_budget -$tot_curr_expense;

?>

<form name="projectForm"  method="post" onsubmit="return formSubmit();" >
<table>
<tr>
<td>  
<table class='gridtable' style="width:500px">
<tr>
<th>Budget Information</th>
<th>Previous Report
<?if($rowed[prev_id] =="") 
		echo "(Report not generated)";
?>
</th>
<th>Current Report</th>
<th>This Week</th>
</tr>

	<tr><td>BUDGET</td>
	<td align='right'><?echo number_format($rowed[prev_budget],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_budget],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_budget]-$rowed[prev_budget],2) ?> </td>

	</tr>
	<tr><td>EXCESS BUDGET</td>
	<td align='right'><?echo number_format($rowed[prev_excess_budget],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_excess_budget],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_excess_budget]-$rowed[prev_excess_budget],2) ?> </td>

	</tr>
	<tr><td>TOTAL BUDGET</td>
	<td align='right'><?echo number_format($prev_tot_budget,2) ?> </td>
	<td align='right'><?echo number_format($curr_tot_budget,2) ?> </td>
	<td align='right'><?echo number_format($curr_tot_budget-$curr_tot_budget,2) ?> </td>
	</tr>
	<tr><td>PENDING BUDGET</td>
	<td align='right'><?echo number_format($prev_pend_budget,2) ?> </td>
	<td align='right'><?echo number_format($curr_pend_budget,2) ?> </td>
	<td align='right'><?echo number_format($curr_pend_budget-$prev_pend_budget,2) ?> </td>
	</tr>
	<tr><td>ESTIMATED BUDGET TO GO</td>
	<td align='right'><?echo number_format($rowed[prev_estimated_budget_to_go],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_estimated_budget_to_go],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_estimated_budget_to_go]-$rowed[prev_estimated_budget_to_go],2) ?> </td>
	</tr>

	</table>
</td>
<td>  
<table  class='gridtable' style="width:500px">
<tr>
<th>Expense Information</th>
<th>Previous Report
<?if($rowed[prev_id] =="") 
		echo "(Report not generated)";
?>
</th>
<th>Current Report</th>
<th>This Week</th>
</tr>

<tr>
	<td>LABOUR</td>
	<td align='right'><?echo number_format($rowed[prev_labour],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_labour],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_labour]-$rowed[prev_labour],2) ?> </td>

</tr>


	
<tr>
	<td>OVERHEADS</td>
	<td align='right'><?echo number_format($rowed[prev_unified_labour]-$rowed[prev_labour],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_unified_labour]-$rowed[curr_labour],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_unified_labour]-$rowed[curr_labour]-($rowed[prev_unified_labour]-$rowed[prev_labour]),2) ?> </td>

</tr>


<tr>
	<td>UNIFIED LABOUR</td>
	<td align='right'><?echo number_format($rowed[prev_unified_labour],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_unified_labour],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_unified_labour]-$rowed[prev_unified_labour],2) ?> </td>
</tr>


<tr>
	<td>EXPENSE</td>
	<td align='right'><?echo number_format($rowed[prev_expense],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_expense],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_expense]-$rowed[prev_expense],2) ?> </td>
</tr>


<tr>
	<td><b>TOTAL</b></td>
	<td align='right'><b><?echo number_format($rowed[prev_unified_labour] + $rowed[prev_expense],2) ?> </b></td>
	<td align='right'><b><?echo number_format($rowed[curr_unified_labour] + $rowed[curr_expense],2) ?> </b></td>
	<td align='right'><b><?echo number_format($rowed[curr_unified_labour] + $rowed[curr_expense]-($rowed[prev_unified_labour] + $rowed[prev_expense]),2) ?> </b></td>
	
</tr>



	
</table>
</td>

<tr>
<td>  
<table  class='gridtable' style="width:500px">
<tr>
<th>Invoice Information</th>
<th>Previous Report
<?if($rowed[prev_id] =="") 
		echo "(Report not generated)";
?>
</th>
<th>Current Report</th>
<th>This Week</th>
</tr>
<tr>

	<td>INVOICE PENDING</td>
	<td align='right'><?echo number_format($rowed[prev_invoice_pending],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_invoice_pending],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_invoice_pending]-$rowed[prev_invoice_pending],2) ?> </td>

</tr>
	<tr><td>INVOICE INVOICED</td>
	<td align='right'><?echo number_format($rowed[prev_invoice_invoiced],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_invoice_invoiced],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_invoice_invoiced]-$rowed[prev_invoice_invoiced],2) ?> </td>



	</tr>
	<tr><td>INVOICE PAID</td>
	<td align='right'><?echo number_format($rowed[prev_invoice_paid],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_invoice_paid],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_invoice_paid]-$rowed[prev_invoice_paid],2) ?> </td>

	</tr>
	<tr><td>INVOICED PASTDUE</td>
	<td align='right'><?echo number_format($rowed[prev_invoice_invoiced_pastdue],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_invoice_invoiced_pastdue],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_invoice_invoiced_pastdue]-$rowed[prev_invoice_invoiced_pastdue],2) ?> </td>
	
	</tr>
	<tr><td>PAYMENT PASTDUE</td>
	<td align='right'><?echo number_format($rowed[prev_invoice_payment_pastdue],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_invoice_payment_pastdue]-$rowed[prev_invoice_payment_pastdue],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_invoice_payment_pastdue]-$rowed[prev_invoice_payment_pastdue],2) ?> </td>
	
	</tr>
	<tr><td>CR RAISED</td>
	<td align='right'><?echo number_format($rowed[prev_cr_raised],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_cr_raised],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_cr_raised]-$rowed[prev_cr_raised],2) ?> </td>
	
	</tr>
	<tr><td>CR APPROVED</td>
	<td align='right'><?echo number_format($rowed[prev_cr_approved],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_cr_approved],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_cr_approved]-$rowed[prev_cr_approved],2) ?> </td>
	
	</tr>
	

	
	
	</table>
</td>	


<td>  
<table  class='gridtable' style="width:500px">
<tr>
<th>Revenue Information</th>
<th>Previous Report
<?if($rowed[prev_id] =="") 
		echo "(Report not generated)";
?>
</th>
<th>Current Report</th>
<th>This Week</th>
</tr>
<tr>

	<td>ORIGINAL CONTRACT</td>
	<td align='right'><?echo number_format($rowed[prev_contract_value]-$rowed[prev_cr_approved],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_contract_value]-$rowed[curr_cr_approved],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_contract_value]-$rowed[curr_cr_approved] -($rowed[prev_contract_value]-$rowed[prev_cr_approved] ),2) ?> </td>
</tr>


	<tr>
	<td>ADDITIONAL CR</td>
	<td align='right'><?echo number_format($rowed[prev_cr_approved],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_cr_approved],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_cr_approved]-$rowed[prev_cr_approved],2) ?> </td>
</tr>

	<td>TOTAL CONTRACT</td>
	<td align='right'><?echo number_format($rowed[prev_contract_value],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_contract_value],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_contract_value]-$rowed[prev_contract_value],2) ?> </td>
</tr>


	<tr>
	<td>TOTAL RECEIVED</td>
	<td align='right'><?echo number_format($rowed[prev_invoice_paid],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_invoice_paid],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_invoice_paid]-$rowed[prev_invoice_paid],2) ?> </td>
</tr>

	<tr>
	<td>CASHFLOW</td>
	<td align='right'><?echo number_format($rowed[prev_cashflow],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_cashflow],2) ?> </td>
	<td align='right'><?echo number_format($rowed[curr_cashflow]-$rowed[prev_cashflow],2) ?> </td>
</tr>

	<tr><td>PROFIT</td>
	<td align='right'><?echo number_format($prev_profit,2) ?> </td>
	<td align='right'><?echo number_format($curr_profit,2) ?> </td>
	<td align='right'><?echo number_format($curr_profit-$prev_profit,2) ?> </td>
</tr>
	
	<tr><td>PROFIT %</td>
	<td align='right'><?echo number_format($prev_profit_pcnt,2) ?> %</td>
	<td align='right'><?echo number_format($curr_profit_pcnt,2) ?> %</td>
	<td align='right'><?echo number_format($curr_profit_pcnt-$prev_profit_pcnt,2) ?> %</td>
</tr>




</table>
</td>
  
</tr>
</table>


