<?php
session_start();

require 'dbconn.php';
if(!checkUserSession($_SESSION["user"]))
{
        echo "<script>window.top.location.href='login.php'</script>";
        //header("Location:login.php");
}
$q=$_GET["q"];
$con=getConnection();
$sql="select license_val, base_labour_cost,UnitLabourCost , budget , contract, received, budget_to_go ,excess_budget, cashflow,expense_cost from project_summary where project_id = (select ohrm_project_id from project_details where ohrm_project_id = ".$q.")";

/*echo "
<label class='desc'><b>Financial details in INR</label>
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
	$budget = $row[budget];
	$excess_budget = $row[excess_budget];
	$total_cost = $labour_cost + $expense_cost;
	$budget_togo = $row[budget_to_go];
	$contract = $row[contract];
	$license = $row[license_val];
	$received = $row[received];
	$current_profit = $row[contract]-$total_cost;
	$profit = $contract==0?0:$current_profit/$contract*100;
	$cashflow = $received - $total_cost;
	$pending = $contract - $received;

}

	echo "<table id='finance' border ='1'<b>";
	echo "<tr>";
        echo "<td> <label class='desc'>";
        echo "<b>Contract Value ";
        echo "</label></td>";
        echo "<td align='right'> <label class='desc'>";
        echo number_format($contract,2);
        echo "</td>";

        echo "<td> <label class='desc'><b>";
        echo "License Value ";
        echo "</label></td>";
        echo "<td align='right'> <label class='desc'>";
        echo number_format($license,2);
        echo "</td>";

        echo "</tr>";

	echo "<tr><td><br></td></tr>";
	echo "<tr>";
	echo "<td> <label class='desc'>";
	echo "<b>Budget ";
	echo "</label></td>";
	echo "<td align='right'> <label class='desc'>";
        echo number_format($budget,2);
	echo "</td>";	
	
	echo "<td> <label class='desc'><b>";
	echo "Excess Budget ";
	echo "</label></td>";
	echo "<td align='right'> <label class='desc'>";
        echo number_format($excess_budget,2);
	echo "</td>";	

	echo "</tr>";
	echo "<tr>";
        echo "<td> <label class='desc'><b>";
        echo "Total Budget ";
        echo "</label></td>";
        echo "<td align='right'> <label class='desc'><b>";
        echo number_format($excess_budget+$budget,2);
        echo "</label></td>";
        echo "</tr>";

	echo "<tr><td><br></td></tr>";
	
	echo "<tr>";
	echo "<td> <label class='desc'><b>";
	echo "Base Labour Cost";
	echo "</td>";
	echo "<td align='right'> <label class='desc'>";
        echo number_format($base_labour_cost,2);
	echo "</td>";	

        echo "<td> <label class='desc'><b>";
        echo "Total Labour Cost";
        echo "</td>";
        echo "<td align='right'> <label class='desc'>";
        echo number_format($labour_cost,2);
        echo "</td>";
	echo "</tr>";

	echo "<td> <label class='desc'><b>";
	echo "Expense Cost ";
	echo "</td>";
	echo "<td align='right'> <label class='desc'>";
        echo number_format($expense_cost,2);
	echo "</td>";	
	echo "</tr>";


	echo "<tr>";
	echo "<td> <label class='desc'><b>";
	echo "Total Cost ";
	echo "</td>";
	echo "<td align='right'> <label class='desc'><b>";
        echo number_format($total_cost,2);
	echo "</td>";	
	echo "</tr>";

	echo "<tr>";
	echo "<td> <label class='desc'><b>";
        echo "Received ";
        echo "</td>";
        echo "<td align='right'> <label class='desc'>";
        echo number_format($received,2);
        echo "</td>";

	echo "<td> <label class='desc'><b>";
        echo "Pending to be Received ";
        echo "</td>";

        echo "<td align='right'> <label class='desc'>";
        echo number_format($pending,2);
        echo "</td>";

        echo "</tr>";

	echo "<tr><td><br></td></tr>";
	echo "<tr>";
	echo "<td> <label class='desc'><b>";
	echo "Budget to Go ";
	echo "</td>";
	
	echo "<td align='right'> <label class='desc'><b>";
        echo number_format($budget_togo,2);
	
	echo "</td>";	
        echo "<td> <label class='desc'><b>";
        echo "Profit So Far";
        echo "</td>";

        echo "<td align='right'> <label class='desc'>";
        echo number_format($current_profit,2);

        echo "</td>";

	
	echo "<td> <label class='desc'><b>";
	echo "Cashflow";
	echo "</td>";
	
	echo "<td align='right'> <label class='desc'>";
        echo number_format($cashflow,2);
	
	echo "</td>";	
	
	


	echo "<input type='hidden' id='budgettogo' name='budgettogo' disbaled='disabled' value='".$budget_togo."'";
	echo "</tr>";
	
/*	
//	if ($togo > 0)
//		echo "<tr><td> <input type="submit" value="Submit"> </td> </tr>";
*/

	echo "</table>";
closeConnection($con);
/*
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
