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
$con_mth=getConnection();
$sql="select date_format(base_date,'%M-%Y') show_date, base_date from months where base_date  >= '2014-01-01' and base_date < curdate()";
$result_mth = mysqli_query($con_mth,$sql) or debug($sql."   failed  <br/><br/>".mysql_error());

?>
<html>
<head>
       <link class="include" rel="stylesheet" type="text/css" href="analytics/jquery.jqplot.min.css" />
    <link rel="stylesheet" type="text/css" href="analytics/charts/examples.min.css" />
    <link type="text/css" rel="stylesheet" href="analytics/charts/syntaxhighlighter/styles/shCoreDefault.min.css" />
    <link type="text/css" rel="stylesheet" href="analytics/charts/syntaxhighlighter/styles/shThemejqPlot.min.css" />
  
    <!--[if lt IE 9]><script language="javascript" type="text/javascript" src="../excanvas.js"></script><![endif]-->
    <script class="include" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

</head>
<body>
<? include 'header.php'; ?>
<h3>Month Statistics</h3>
<form name="projectListForm"  action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<table>
<tr>
<?

echo "<td>Month</td>";
echo "<td><select id='month' name='month' value=''  autofocus> ></option>";

while($row = mysqli_fetch_array($result_mth))
  {
	$opt="<option value='" . $row[base_date] . "'>" . $row[show_date] . "</option>";
       echo $opt;
  }
echo "</select><td>";

closeConnection($con_mth);

?>
<tr>
	<!---->
 <td>Base Product : </td>
                <td>
                        <?
include 'getprodtype.php'; ?>
                </td>
		<td>Project Type : </td>
		<td>
<?include 'getprojtype.php'; ?>

		</td>
 <td>

		<td>Customer : </td>
		<td>
<?include 'getcustomer.php'; ?>

		</td>
 

	</tr>
</table>
<tr>
<td><input type="submit"  name="Submit" value="Submit"></td>
	</tr>
</form>

<?
if(isset($_POST["Submit"]))
{
	
	$cust = $_POST["cust"];
	$projtype = $_POST["projtype"];
	$prod = $_POST["prod"];
	$month = $_POST["month"];
	echo "<script>document.getElementById('cust').value = '$cust';</script>";
	echo "<script>document.getElementById('projtype').value = '$projtype';</script>";
	echo "<script>document.getElementById('prod').value = '$prod';</script>";
	echo "<script>document.getElementById('month').value = '$month';</script>";

	
	echo "<div id='chart1' style='margin-top:20px; margin-left:20px; width:800px; height:400px;'></div>";
	
	$where = "base_date ='$month'";
	if($cust!="Choose..")
		$where .= " and ohrm_customer_id = $cust";
	if($prod!="Choose..")
		$where .= " and base_product = $prod";
	if($projtype!="Choose..")
		$where .= " and project_type_id = $projtype";
	
	
	
	$sql = "
	select  sum(ifnull(e.lcy_amount,0)) amt_uninvoiced,
sum(ifnull(d.lcy_amount,0)) amt_invoiced ,
sum(case when 
date_add(date_add(LAST_DAY(date(a.project_created_on)),interval 1 DAY),interval -1 MONTH)
 = m.base_date then contract_value else 0 end) contract_value, sum(ifnull(c.lcy_cr_amount,0)) amt_received ,
sum(ifnull(f.cr_amount,0)) cr_pending  , sum(ifnull(g.cr_amount,0)) cr_accepted  ,
sum(ifnull(unifiedcost,0)) unifiedcost, sum(ifnull(h.expense_amt,0)) expense_amt 
from project_details a
inner join hr_mysql_live.ohrm_customer b on a.ohrm_customer_id = b.customer_id
inner join months m 
left join (select * from project_invoice where status = 'PAID') c on a.id = c.project_id and m.base_date = 
date_add(date_add(LAST_DAY(paid_on),interval 1 DAY),interval -1 MONTH) 
left join (select * from project_invoice where status = 'INVOICED') d on a.id = d.project_id and m.base_date = 
date_add(date_add(LAST_DAY(d.invoiced_on),interval 1 DAY),interval -1 MONTH) 
left join (select * from project_invoice where status = 'PENDING') e on a.id = e.project_id and m.base_date >=
date_add(date_add(LAST_DAY(e.created_on),interval 1 DAY),interval -1 MONTH) 
left join (select * from project_cr where status = 'PENDING') f on a.id = f.project_id and m.base_date =
date_add(date_add(LAST_DAY(f.cr_start_date),interval 1 DAY),interval -1 MONTH) 
left join (select * from project_cr where status = 'ACCEPTED') g on a.id = g.project_id and m.base_date =
date_add(date_add(LAST_DAY(g.cr_start_date),interval 1 DAY),interval -1 MONTH) 
left join (select project_id, report_month , sum(ifnull(unifiedcost,0)) unifiedcost, sum(ifnull(expense_amt,0)) expense_amt from monthly_timesheet
group by project_id, report_month ) h on h.project_id = a.ohrm_project_id and m.base_date = report_month
where " .$where;
$con=getConnection();
$result1 = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>".mysql_error());
$row1 = mysqli_fetch_array($result1);

}  
 

?>

<script class="code" type="text/javascript">$(document).ready(function(){
        plot5 = $.jqplot('chart1', [[[<?echo $row1[cr_pending];?>,'CR Pending'],
[<?echo $row1[cr_accepted];?>,'CR Accepted'],
[<?echo $row1[contract_value];?>,'contract_value'],
[<?echo $row1[amt_uninvoiced];?>,'Uninvoiced'], 
[<?echo $row1[amt_invoiced];?>,'Invoiced'],
[<?echo $row1[amt_received];?>,'Received'],
[<?echo $row1[unifiedcost]+$row1[ expense_amt];?>,'Cost']]], {
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
				pointLabels: { show: true, location: 'e', edgeTolerance: -15 },
                shadowAngle: 135,
                rendererOptions: {
                    barDirection: 'horizontal',
                    highlightMouseDown: true    
                }
				
                
            },
            title:'Month Statistics',
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
