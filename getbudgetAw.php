<?php
session_name("Project");
session_start();

require 'dbconn.php';
if(!checkUserSession($_SESSION["user"]))
{
        echo "<script>window.top.location.href='login.php'</script>";
        //header("Location:login.php");
}
$q=$_GET["q"];
$con=getConnection();
//$sql="select license_val, base_labour_cost,UnitLabourCost , budget , contract, received, budget_to_go ,excess_budget, cashflow,expense_cost from project_summary where project_id = (select ohrm_project_id from project_details where id = ".$q.")";

$sql="select License_value license_val, 
	base_labour_cost,
	unified_labour_cost UnitLabourCost , 
	budget_initiated,
	budget_approved  , 
	excess_budget_approved,
	excess_budget_initiated,
	ifnull(Contract_value,0) contract,
	 cr_amt , 
	 invoice_pending_lcy_amt pending_invoice,
	 invoiced_lcy_amt invoiced,
	received_lcy_amt received, 	
	(budget_approved + excess_budget_approved) - (unified_labour_cost+expense_amt) budget_to_go ,
	excess_budget_approved excess_budget, 
	received_lcy_amt - (unified_labour_cost+expense_amt) cashflow,
	expense_amt expense_cost from project_details where id = ".$q;
	
/*echo "
<label ><b>Financial details in INR</label>
";*/
$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
$labour_cost = 0;
$expense_cost = 0;
$budget = 0;
$total_cost = 0;
$budget_togo = 0;
$row = mysqli_fetch_array($result);
if($row )
{
	$base_labour_cost = $row[base_labour_cost];
	$labour_cost = $row[UnitLabourCost];
	$expense_cost = $row[expense_cost];
	$budget = $row[budget_approved];
	$excess_budget = $row[excess_budget_approved];
	
	$budget_initiated = $row[budget_initiated];
	$excess_budget_initiated = $row[excess_budget__initiated];
	
	$total_cost = $labour_cost + $expense_cost;
	$budget_togo = $row[budget_to_go];
	$contract = $row[contract];
	$cr_amt = $row[cr_amt];
	$license = $row[license_val];
	$received = $row[received];
	$current_profit = $contract+$cr_amt-$total_cost;
	$profit = $contract+$cr_amt==0?0:$current_profit/($contract+$cr_amt)*100;
	$cashflow = $received - $total_cost;
	$pending = $contract - $received;
	
	$pending_invoice = $row[pending_invoice]; 
	$invoiced = $row[invoiced]; 

}

echo "<table  id='finance' border='0'>"; 
if(($contract+$cr_amt)!=0)
{
echo "<tr>";
	echo "<td>";

echo "<table class='gridtable' id='revenue' width='300' border='1'>";
echo "<th colspan='2'>Revenue</th>";
echo "<tr>";
	echo "<td> <label >";
        echo "<b>Original Contract Value ";
        echo "</label></td>";
        echo "<td align='right'> <label>";
        echo number_format($contract,2);
    echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td> <label >";
        echo "<b>License ";
        echo "</label></td>";
        echo "<td align='right'> <label>";
        echo number_format($license,2);
    echo "</td>";
  echo "</tr>";	
echo "<tr>";
	echo "<td> <label >";
        echo "<b>Change Request Value ";
        echo "</label></td>";
        echo "<td align='right'> <label>";
        echo number_format($cr_amt,2);
    echo "</td>";
  echo "</tr>";
echo "<tr>";
echo "<td> <label >";
        echo "<b>Total Value ";
        echo "</label></td>";
        echo "<td align='right'> <label>";
        echo number_format($contract+$cr_amt,2);
    echo "</td>";
  echo "</tr>";	
  
echo "</table>";

echo "<td>";
echo "<table class='gridtable' id='invoice'  border='1'>";
echo "<th colspan='2'>Invoice</th>";
echo "<tr>";
	echo "<td> <label >";
        echo "<b>Pending to be Invoiced ";
        echo "</label></td>";
        echo "<td align='right'> <label>";
        echo number_format($pending_invoice,2);
    echo "</td>";
echo "</tr>";
echo "<tr>";
	echo "<td> <label >";
        echo "<b>Invoiced ";
        echo "</label></td>";
        echo "<td align='right'> <label>";
        echo number_format($invoiced,2);
    echo "</td>";
  echo "</tr>";
  
  echo "<tr>";
	echo "<td> <label >";
        echo "<b>Received ";
        echo "</label></td>";
        echo "<td align='right'> <label>";
        echo number_format($received,2);
    echo "</td>";
  echo "</tr>";
echo "<tr>";
echo "<td> <label >";
        echo "<b>Total Value ";
        echo "</label></td>";
        echo "<td align='right'> <label>";
        echo number_format($pending_invoice+$invoiced+$received,2);
    echo "</td>";
  echo "</tr>";	
echo "</table>";


echo "</td>";

echo "</tr>";
}
echo "<tr>";
    echo "<td>";
echo "<table class='gridtable' id='expense' width='300' border='1'>";
echo "<th colspan='2'>Expense</th>";
echo "<tr>";
	echo "<td> <label >";
        echo "<b>Base Labour Cost ";
        echo "</label></td>";
        echo "<td align='right'> <label>";
        echo number_format($base_labour_cost,2);
    echo "</td>";
echo "</tr>";
echo "<tr>";
	echo "<td> <label >";
        echo "<b>Unified Labour Cost  ";
        echo "</label></td>";
        echo "<td align='right'> <label>";
        echo number_format($labour_cost,2);
    echo "</td>";
  echo "</tr>";
echo "<tr>";
echo "<td> <label >";
        echo "<b>Expense Cost ";
        echo "</label></td>";
        echo "<td align='right'> <label>";
        echo number_format($expense_cost,2);
    echo "</td>";
  echo "</tr>";	
  echo "<tr>";
echo "<td> <label >";
        echo "<b>Total Cost ";
        echo "</label></td>";
        echo "<td align='right'> <label>";
        echo number_format($total_cost,2);
    echo "</td>";
  echo "</tr>";	

echo "</table>";
echo "</td>";

    echo "<td>";
echo "<table class='gridtable' id='budget' border='1'>";
echo "<th colspan='4'>Budget</th>";
echo "<tr>";
	echo "<td> <label >";
        echo "<b>Normal Budget Initiated ";
        echo "</label></td>";
        echo "<td align='right'> <label>";
        echo number_format($budget_initiated,2);
    echo "</td>";

	echo "<td> <label >";
        echo "<b>Normal Budget Approved ";
        echo "</label></td>";
        echo "<td align='right'> <label>";
        echo number_format($budget,2);
    echo "</td>";
  echo "</tr>";
  echo "<tr>";
	echo "<td> <label >";
        echo "<b>Excess Budget Initiated ";
        echo "</label></td>";
        echo "<td align='right'> <label>";
        echo number_format($excess_budget_initiated,2);
    echo "</td>";

	echo "<td> <label >";
        echo "<b>Excess Budget Approved ";
        echo "</label></td>";
        echo "<td align='right'> <label>";
        echo number_format($excess_budget,2);
    echo "</td>";
  echo "</tr>";
echo "<tr>";
echo "<td colspan='2'> <label >";
        echo "<b>Total Budget  Awaiting Approval ";
        echo "</label></td>";
        echo "<td colspan='2' align='right'> <label>";
        echo number_format($excess_budget_initiated+$budget_initiated,2);
    echo "</td>";
  echo "</tr>";	
echo "<tr>";
echo "<td colspan='2'> <label >";
        echo "<b>Total Approved Budget ";
        echo "</label></td>";
        echo "<td colspan='2' align='right'> <label>";
        echo number_format($excess_budget+$budget,2);
    echo "</td>";
 echo "</table>";   
  echo "</tr>";	
  echo "</td>";
  
echo "</tr>";
echo "<table class='gridtable' id='overall' width='500' border='1'>";
echo "<th colspan='5'>Overall</th>";
echo "<tr>";
	echo "<td> <label >";
        echo "<b>Budget to Go  ";
        echo "</label></td>";
        echo "<td align='right'> <label>";
        echo number_format($budget_togo,2);
    echo "</td>";
    echo "<td align='right'> <label>";
    if($budget+$excess_budget != 0)
        echo number_format(100*$budget_togo/($budget+$excess_budget),2)."%";
   else 
    	echo "0.00";
    echo "</td>";
    echo "<td> ";
    if($budget+$excess_budget == 0)
    {
    	echo "<b>There is no Budget for a project. Immediately start the budgetting process.";
        echo "</td> <td align='middle'><img src='images/red.jpg' alt='red' width='30' height='30'</img></td>";
    	
    }
    elseif(100*$budget_togo/($budget+$excess_budget) <= 10 && 100*$budget_togo/($budget+$excess_budget) > 0)
    {
        echo "<b>Start the Budgetting process. It is running low.";
        echo "</td> <td align='middle'><img src='images/amber.jpg' alt='red' width='30' height='30'</img></td>";

    }
    elseif(100*$budget_togo/($budget+$excess_budget) < 0)
    {
        echo "<b>Immediately Start the Budgetting process.";
        echo "</td> <td align='middle'><img src='images/red.jpg' alt='red' width='30' height='30'</img></td>";

    }
    elseif(100*$budget_togo/($budget+$excess_budget) > 10)
    {
    	echo "<b>This is Fine."; 
    	echo "</td> <td align='middle'><img src='images/green.jpg' alt='red' width='30' height='30'</img></td>";
    }
  echo "</tr>";

if(($contract+$cr_amt)!=0)
{
	echo "<tr>";
		echo "<td> <label >";
        echo "<b>Difference between Contract and Invoices ";
        echo "</label></td>";
        echo "<td align='right'> <label>";
        echo number_format($contract+$cr_amt-($pending_invoice+$invoiced+$received),2);
    	echo "</td>";
  	  echo "<td align='right'> <label>";
 	       echo number_format(100*($contract+$cr_amt-($pending_invoice+$invoiced+$received))/($contract+$cr_amt),2)."%";
 		   echo "</td>";
    	echo "<td> ";
    	if(100*($contract+$cr_amt-($pending_invoice+$invoiced+$received))/($contract+$cr_amt) <> 0)
    	{
    		echo "<b>Urgently reconcile this difference with Finance department.";
        	echo "</td> <td align='middle'><img src='images/red.jpg' alt='red' width='30' height='30'</img></td>";
    	}
    	else
    	{
    		echo "<b>This is Fine."; 
    		echo "</td> <td align='middle'><img src='images/green.jpg' alt='red' width='30' height='30'</img></td>";
    	}
        
	echo "</tr>";


echo "<tr>";
echo "<td> <label >";
        echo "<b>Cashflow ";
        echo "</label></td>";
        echo "<td align='right'> <label>";
        echo number_format($cashflow,2);
    echo "</td>";
    echo "<td align='right'> <label>";
        echo number_format(100*$cashflow/($contract+$cr_amt),2)."%";
    echo "</td>";
    echo "<td> ";
    if(100*$cashflow/($contract+$cr_amt) < 0)
    {
        echo "<b>Either you are burning too fast or Focus on recievables is poor.";
        echo "</td> <td align='middle'><img src='images/red.jpg' alt='red' width='30' height='30'</img></td>";

    }
    elseif(100*$cashflow/($contract+$cr_amt) <= 10)
    {
        echo "<b>Either you are burning too fast or Focus on recievables is poor.";
        echo "</td> <td align='middle'><img src='images/amber.jpg' alt='red' width='30' height='30'</img></td>";

    }
    elseif(100*$cashflow/($contract+$cr_amt) > 10)
    {
    	echo "<b>This is Fine."; 
    	echo "</td> <td align='middle'><img src='images/green.jpg' alt='red' width='30' height='30'</img></td>";
    }
  echo "</tr>";	
    echo "<tr>";
echo "<td> <label >";
        echo "<b>Running Profit ";
        echo "</label></td>";
        echo "<td align='right'> <label>";
        echo number_format($current_profit,2);
    echo "</td>";
    echo "<td align='right'> <label>";
        echo number_format($profit,2)."%";
    echo "</td>";
    echo "<td> ";
    if($profit <= 35)
    {
        echo "<b>This is dangerously Low. We need to put brake on all expenses.";
        echo "</td> <td align='middle'><img src='images/red.jpg' alt='red' width='30' height='30'</img></td>";

    }
    elseif($profit < 45)
    {
        echo "<b>This is dangerously Low. We need to put brake on all expenses.";
        echo "</td> <td align='middle'><img src='images/amber.jpg' alt='red' width='30' height='30'</img></td>";

    }
    elseif($profit > 45)
    {
    	echo "<b>This is Fine."; 
    	echo "</td> <td align='middle'><img src='images/green.jpg' alt='red' width='30' height='30'</img></td>";
    }
  echo "</tr>";	
  echo "<tr>";
echo "<td> <label >";
        echo "<b>Total Pending to be Received ";
        echo "</label></td>";
        echo "<td align='right'> <label>";
        echo number_format($pending_invoice+$invoiced,2);
    echo "</td>";
    echo "<td align='right'> <label>";
    if(($pending_invoice+$invoiced+$received)!=0)
        echo number_format(100*($pending_invoice+$invoiced)/($pending_invoice+$invoiced+$received),2)."%";
    else 
    	echo "0.0";
    echo "</td>";
    echo "<td> ";
    if(($pending_invoice+$invoiced+$received) == 0)
    {
    	echo "<b>Get Finance to urgently input all Invoices.";
        echo "</td> <td align='middle'><img src='images/red.jpg' alt='red' width='30' height='30'</img></td>";   
    }
    elseif(100*($pending_invoice+$invoiced)/($pending_invoice+$invoiced+$received) > 30)
	{
        echo "<b>If it is not too early, start working on your Receivables.";
        echo "</td> <td align='middle'><img src='images/amber.jpg' alt='red' width='30' height='30'</img></td>";        
    }
    else
    {
    	echo "<b>This is Fine."; 
    	echo "</td> <td align='middle'><img src='images/green.jpg' alt='red' width='30' height='30'</img></td>";
    }
  echo "</tr>";	
  
}

echo "</table>";

 echo "<tr>";
 echo "<td>";


 echo "</td>";

 echo "</tr>";
  


echo "</table>";
closeConnection($con);
/*

  echo "<tr>";
echo "<td> <label >";
        echo "<b>Cashflow ";
        echo "</label></td>";
        echo "<td align='right'> <label>";
        echo number_format($cashflow,2);
    echo "</td>";
  echo "</tr>";	

echo "<tr>";
echo "<td colspan='2'> <label >";
        echo "<b>Budget To Go (Negative Amount Means Overrun)";
        echo "</label></td>";
        echo "<td colspan='2' align='right'> <label>";
        echo number_format(($excess_budget+$budget)-$total_cost,2);
    echo "</td>";
  echo "</tr>";	
echo "</table>";
echo "</td>";
echo "</tr>";



<style type = "text/css">
.percentbar { background:#CCCCCC; border:1px solid #666666; height:10px; }
.percentbar div { background: #28B8C0; height: 10px; }
</style>
<tr>
<td>
<div class="percentbar" style="width:<?php echo round(100 * 1.0); ?>px;">
  <div style="width:<?php echo round(27 * 1.0); ?>px;"></div> 
</div>
<?php echo 27;?>%
</td>


<td>
<div class="percentbar" style="width:<?php echo round(100 * 1.0); ?>px;">
  <div style="width:<?php echo round(27 * 1.0); ?>px;"></div>
<?php echo 27; ?>%
</div>
</td>
</tr>
*/
?>
