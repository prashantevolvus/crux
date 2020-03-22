<?php
session_name("Project");
session_start();

require 'dbconn.php';
if(!checkUserSession($_SESSION["user"]))
{
        echo "<script>window.top.location.href='login.php'</script>";
        //header("Location:login.php");
}

?>
<html>
<head>
       <link class="include" rel="stylesheet" type="text/css" href="analytics/jquery.jqplot.min.css" />
    <link rel="stylesheet" type="text/css" href="analytics/charts/examples.min.css" />
    <link type="text/css" rel="stylesheet" href="analytics/charts/syntaxhighlighter/styles/shCoreDefault.min.css" />
    <link type="text/css" rel="stylesheet" href="analytics/charts/syntaxhighlighter/styles/shThemejqPlot.min.css" />
  
    <!--[if lt IE 9]><script language="javascript" type="text/javascript" src="../excanvas.js"></script><![endif]-->
    <script class="include" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
 <!--FOR PDF --> 
  <script type='text/javascript' src='http://code.jquery.com/jquery-git2.js'></script>
  <script type="text/javascript" src="jspdf.debug.js"></script>
<script type="text/javascript">
        function genPDF() {
            var pdf = new jsPDF('p', 'pt', 'letter');
            // source can be HTML-formatted string, or a reference
            // to an actual DOM element from which the text will be scraped.
            source = $('#pdf')[0];

            // we support special element handlers. Register them with jQuery-style 
            // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
            // There is no support for any other type of selectors 
            // (class, of compound) at this time.
            specialElementHandlers = {
                // element with id of "bypass" - jQuery style selector
                '#bypassme': function(element, renderer) {
                    // true = "handled elsewhere, bypass text extraction"
                    return true
                }
            };
            margins = {
                top: 80,
                bottom: 60,
                left: 40,
                width: 522
            };
            // all coords and widths are in jsPDF instance's declared units
            // 'inches' in this case
            pdf.fromHTML(
                    source, // HTML string or DOM elem ref.
                    margins.left, // x coord
                    margins.top, {// y coord
                        'width': margins.width, // max width of content on PDF
                        'elementHandlers': specialElementHandlers
                    },
            function(dispose) {
                // dispose: object with X, Y of the last line add to the PDF 
                //          this allow the insertion of new lines after html
                pdf.save('Consolidated.pdf');
            }
            , margins);
        }
    </script>

</head>
<body">
<?php include 'header.php'; ?>
<h3>View Consolidated</h3>
<form method='get'>
<td>
Search :
</td>
<td>
<input type="text" name="inputText"autofocus/> 
</td>
<input type="submit"  name="Submit" value="Submit"/> 
<button onclick="javascript:genPDF();">Generate Bad PDF</button>
</td>

</form>
<?php
   
$q=$_GET['inputText'];
if($q=="")
	$q1="All";
else
	$q1=$q;
echo "<tr>";
echo "<td><b class='floating'>Consolidated Financial Figures for - ".$q1." </b></td>";
echo "<br>";
echo "</tr>";



$con=getConnection();
/*$sql="
select sum(a.license_val) license_val, 
sum(a.base_labour_cost) base_labour_cost,
sum(UnitLabourCost) UnitLabourCost , 
sum(a.budget) budget , 
sum(contract) contract, 
sum(received) received, sum(a.budget_to_go) budget_to_go  ,
sum(a.excess_budget) excess_budget, sum(cashflow) cashflow , sum(expense_cost) expense_cost  
 from project_summary a
inner join  hr_mysql_live.ohrm_project b on a.project_id = b.project_id 
inner join hr_mysql_live.ohrm_customer c on b.customer_id = c.customer_id
left join project_details d on b.project_id = d.ohrm_project_id
left join products e on d.base_product = e.id
where concat(ifnull(e.product_name,''),' ',c.name,' ',b.name) like
'%".$q."%'"; */

$sql="
select sum(a.License_value) license_val, 
sum(a.base_labour_cost) base_labour_cost,
sum(unified_labour_cost) UnitLabourCost , 
sum(a.budget_approved) budget , 
sum(Contract_value+cr_amt) contract, 
sum(received_lcy_amt) received, 
sum(a.excess_budget_approved) excess_budget, 
sum(received_lcy_amt) - (sum(unified_labour_cost)+sum(expense_amt))  cashflow , 
sum(expense_amt) expense_cost  
 from project_all a
inner join hr_mysql_live.ohrm_customer c on a.ohrm_customer_id = c.customer_id
left join products e on a.base_product = e.id
where a.status <> 'DELETED' and c.is_deleted = 0 and concat(ifnull(e.product_name,''),' ',c.name,' ',a.project_name) like
'%".$q."%'"; 




/*echo "
<label ><b>Financial details in INR</label>
";*/
$result = mysqli_query($con,$sqlcol.$sql) or debug($sql."<br/><br/>".mysql_error());
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
	$budget_togo = $budget+$excess_budget - $total_cost ;
	$contract = $row[contract];
	$license = $row[license_val];
	$received = $row[received];
	$current_profit = $row[contract]-$total_cost;
	$profit = $contract==0?0:$current_profit/$contract*100;
	$cashflow = $received - $total_cost;
	$pending = $contract - $received;

}
echo "<div id='pdf'>";
echo "<table><tr>";
echo "<td>";
	
	echo "<table class='gridtable' id='finance' border='1' style='width:500px'><b>";
	echo "<tr>";
        echo "<td> <label >";
        echo "<b>Contract Value ";
        echo "</label></td>";
        echo "<td align='right'> <label>";
        echo number_format($contract,2);
        echo "</td>";

        echo "<td> <label ><b>";
        echo "License Value ";
        echo "</label></td>";
        echo "<td align='right'> <label >";
        echo number_format($license,2);
        echo "</td>";

        echo "</tr>";

	echo "<tr>";
	echo "<td> <label >";
	echo "<b>Budget ";
	echo "</label></td>";
	echo "<td align='right'> <label >";
        echo number_format($budget,2);
	echo "</td>";	
	
	echo "<td> <label ><b>";
	echo "Excess Budget ";
	echo "</label></td>";
	echo "<td align='right'> <label >";
        echo number_format($excess_budget,2);
	echo "</td>";	

	echo "</tr>";
	echo "<tr>";
        echo "<td> <label ><b>";
        echo "Total Budget ";
        echo "</label></td>";
        echo "<td align='right'> <label ><b>";
        echo number_format($excess_budget+$budget,2);
        echo "</label></td>";
        echo "</tr>";

	
	echo "<tr>";
	echo "<td> <label ><b>";
	echo "Base Labour Cost";
	echo "</td>";
	echo "<td align='right'> <label >";
        echo number_format($base_labour_cost,2);
	echo "</td>";	

        echo "<td> <label ><b>";
        echo "Total Labour Cost";
        echo "</td>";
        echo "<td align='right'> <label >";
        echo number_format($labour_cost,2);
        echo "</td>";

	echo "<td> <label ><b>";
	echo "Expense Cost ";
	echo "</td>";
	echo "<td align='right'> <label >";
        echo number_format($expense_cost,2);
	echo "</td>";	
	echo "</tr>";


	echo "<tr>";
	echo "<td> <label ><b>";
	echo "Total Cost ";
	echo "</td>";
	echo "<td align='right'> <label ><b>";
        echo number_format($total_cost,2);
	echo "</td>";	
	echo "</tr>";

	echo "<tr>";
	echo "<td> <label ><b>";
        echo "Received ";
        echo "</td>";
        echo "<td align='right'> <label >";
        echo number_format($received,2);
        echo "</td>";

	echo "<td> <label ><b>";
        echo "Pending to be Received ";
        echo "</td>";

        echo "<td align='right'> <label >";
        echo number_format($pending,2);
        echo "</td>";

		echo "<td> <label ><b>";
        echo "Cashflow ";
        echo "</td>";

        echo "<td align='right'> <label >";
        echo number_format($cashflow,2);
        echo "</td>";
        echo "</tr>";

	echo "<tr>";
	echo "<td> <label ><b>";
	echo "Budget to Go ";
	echo "</td>";
	
	echo "<td align='right'> <label ><b>";
        echo number_format($budget_togo,2);
	
	echo "</td>";	
        echo "<td> <label ><b>";
        echo "Profit So Far";
        echo "</td>";

        echo "<td align='right'> <label >";
        echo number_format($current_profit,2);

        echo "</td>";

	
	echo "<td> <label ><b>";
	echo "Profit % ";
	echo "</td>";
	
	echo "<td align='right'> <label >";
        echo number_format($profit,2);
	
	echo "%</td>";	
	
	


	echo "<input type='hidden' id='budgettogo' name='budgettogo' disbaled='disabled' value='".$budget_togo."'";
	echo "</tr>";
	
/*	
//	if ($togo > 0)
//		echo "<tr><td> <input type="submit" value="Submit"> </td> </tr>";
*/

	echo "</table>";
	echo "</td>";
	echo "<td>";
	echo "<div id='chart1' style='margin-top:20px; margin-left:20px; width:600px; height:300px;'></div>";
	echo "</td>";
	echo "</tr></table>";
	
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
$sqlcol="
select c.name customer,a.project_name project , License_value, cr_amt,
a.base_labour_cost, unified_labour_cost , a.budget_approved , Contract_value, 
received_lcy_amt, a.budget_to_go , a.excess_budget_approved, 
received_lcy_amt-unified_labour_cost+expense_amt cashflow, expense_amt,a.status ";

$sql = 
"  from project_all a 
inner join hr_mysql_live.ohrm_customer c on a.ohrm_customer_id = c.customer_id 
left join products e on a.base_product = e.id where a.status <> 'DELETED' 
and c.is_deleted = 0 and concat(ifnull(e.product_name,''),' ',c.name,' ',a.project_name) like
'%".$q."%' order by a.status, a.id desc";

/*echo "
<label ><b>Financial details in INR</label>
";*/
$result = mysqli_query($con,$sqlcol.$sql) or debug($sqlcol.$sql."<br/><br/>".mysql_error());
echo "<table class='gridtable' >";
echo "<br>";
echo "<tr>";
echo "<b>";
echo "<th><b>Customer</b></th>";

echo "<th><b>Project</th>";

echo "<th><b>Contract</th>";

echo "<th><b>Total Cost</th>";

echo "<th><b>Profit</th>";

echo "<th><b>Profit%</th>";

echo "<th><b>Received</th>";

echo "<th><b>Cashflow</th>";

echo "<th><b>Project Status</th>";
echo "</b>";
echo "</tr>";

while($row = mysqli_fetch_array($result))
{
	$base_labour_cost = $row[base_labour_cost];
	$labour_cost = $row[unified_labour_cost];
	$expense_cost = $row[expense_amt];
	$budget1 = $row[budget_approved];
	$excess_budget1 = $row[excess_budget_approved];
	$total_cost1 = $labour_cost + $expense_cost;
	$budget_togo = $budget1 + $excess_budget1 - $total_cost1;
	$contract1 = $row[Contract_value] +$row[cr_amt];
	$license = $row[License_value];
	$received1 = $row[received_lcy_amt];
	$current_profit1 = $contract1-$total_cost1;
	$profit1 = $contract1==0?0:$current_profit1/$contract1*100;
	$cashflow = $received1 - $total_cost1;
	$pending = $contract1 - $received1;

	echo "<tr>";
	echo "<td>$row[customer]</td>";

	echo "<td>$row[project]</td>";

	$amt = number_format($contract1,2);
	echo "<td align='right'>$amt</td>";

	$amt = number_format($total_cost1,2);
	echo "<td align='right'>$amt</td>";

	$amt = number_format($current_profit1,2);
	echo "<td align='right'>$amt</td>";

	$amt = number_format($profit1,2);
	echo "<td align='right'>$amt%</td>";

	$amt = number_format($received1,2);
	echo "<td align='right'>$amt</td>";
	
	$amt = number_format($row[cashflow],2);
	echo "<td align='right'>$amt</td>";
	
	echo "<td>$row[status]</td>";
	echo "</tr>";
}

echo "</table>";
echo "</div>";
closeConnection($con);




?>
<script class="code" type="text/javascript">$(document).ready(function(){
        plot5 = $.jqplot('chart1', [[[<?php echo $contract;?>,'Contract'], [<?php echo $received;?>,'Received'], [<?php echo $excess_budget+$budget;?>,'Budget'],[<?php echo $total_cost;?>,'Total Cost']]], {
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                shadowAngle: 135,
                rendererOptions: {
                    barDirection: 'horizontal',
                    highlightMouseDown: true    
                }
                
            },
            
            axes: {
                yaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer
                }
            }
        });
    });</script>
<!-- Don't touch this! -->


    <script class="include" type="text/javascript" src="analytics/jquery.jqplot.min.js"></script>
    <script type="text/javascript" src="analytics/charts/syntaxhighlighter/scripts/shCore.min.js"></script>
    <script type="text/javascript" src="analytics/charts/syntaxhighlighter/scripts/shBrushJScript.min.js"></script>
    <script type="text/javascript" src="analytics/charts/syntaxhighlighter/scripts/shBrushXml.min.js"></script>
<!-- Additional plugins go here -->

  <script class="include" type="text/javascript" src="analytics/plugins/jqplot.barRenderer.min.js"></script>
  <script class="include" type="text/javascript" src="analytics/plugins/jqplot.pieRenderer.min.js"></script>
  <script class="include" type="text/javascript" src="analytics/plugins/jqplot.categoryAxisRenderer.min.js"></script>
  <script class="include" type="text/javascript" src="analytics/plugins/jqplot.pointLabels.min.js"></script>

<!-- End additional plugins -->
</body>
</html>
