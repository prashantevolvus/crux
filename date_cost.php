<!DOCTYPE html>
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
?>
<html>
<head>

    <title>Activity</title>

    <link class="include" rel="stylesheet" type="text/css" href="analytics/jquery.jqplot.min.css" />
    <link rel="stylesheet" type="text/css" href="analytics/charts/examples.min.css" />
    <link type="text/css" rel="stylesheet" href="analytics/charts/syntaxhighlighter/styles/shCoreDefault.min.css" />
    <link type="text/css" rel="stylesheet" href="analytics/charts/syntaxhighlighter/styles/shThemejqPlot.min.css" />
  
    <!--[if lt IE 9]><script language="javascript" type="text/javascript" src="../excanvas.js"></script><![endif]-->
    <script class="include" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    
   
</head>
<body>
<?php 
include 'header.php';
?>
<br>
        <div class="colmask leftmenu">
      <div class="colleft"> 
        <div class="col1" id="example-content">

  
<!-- Example scripts go here -->

	<div id="chart1" style="height:550px; width:950px;"></div>

<?php
require_once('dbconn.php');
$con=getConnection();

$sql1 = "
select report_month,s1,s2,s3,s4,ifnull(amt,0)/100000 from (
select report_month,sum(
case when customer not in ('Internal','Management') then UnifiedCost else 0 end/100000.0)
+sum(expense_amt/100000.0) s1,
sum(
case when customer not in ('Internal','Management') then UnifiedCost else 0 end/100000.0) s2,sum(ifnull(expense_amt,0)/100000) s3,
sum(cost/100000.0) s4
from monthly_timesheet 
where date_sub(current_timestamp,interval 24 month) < report_month 
group by report_month
) a 
left join invoice_paid b on a.report_month = b.month 
order by report_month asc

";


$result = mysqli_query($con,$sql1) or die($sql."<br/><br/>".mysql_error());
while($row = mysqli_fetch_array($result))
{
	$i = $row[1]+0;
	$i1 = $row[2]+0;
	$i2 = $row[3]+0;
	$i3 = $row[4]+0;
	$i4 = $row[5]+0;
	
  $date_cost[] = array($row[0],$i+0);
  $date_labour[] = array($row[0],$i1+0);
  $date_expense[] = array($row[0],$i2+0);
  $date_base_cost[] = array($row[0],$i3+0);
  $date_paid[] = array($row[0],$i4+0);
  
  //$activities[] = $row;
  
}
//echo json_encode($date_base_cost);	
?>

<script class="code" type="text/javascript">
<?php
	$js_array_cost = json_encode($date_cost);
    echo "var tempArr_cost = ". $js_array_cost . ";\n";
	
	$js_array_cost = json_encode($date_labour);
    echo "var tempArr_labour = ". $js_array_cost . ";\n";
	
	$js_array_cost = json_encode($date_expense);
    echo "var tempArr_expense = ". $js_array_cost . ";\n";

	$js_array_cost = json_encode($date_base_cost);
    echo "var tempArr_base = ". $js_array_cost . ";\n";
	
	$js_array_cost = json_encode($date_paid);
    echo "var tempArr_paid = ". $js_array_cost . ";\n";


?>

$(document).ready(function(){
	    $.jqplot.config.enablePlugins = true;

  var plot1 = $.jqplot('chart1', [tempArr_cost,tempArr_labour,tempArr_base,tempArr_paid,tempArr_expense], {
    title:'Cost Trend',
        axes:{
            xaxis:{
                renderer:$.jqplot.DateAxisRenderer, 
				label:"Months",
				labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
                rendererOptions:{
                    tickRenderer:$.jqplot.CanvasAxisTickRenderer
                },
                tickOptions:{ 
                    fontSize:'10pt', 
                    fontFamily:'Tahoma',
					formatString:'%b-%Y',	
                    angle:-40
                }
            },
            yaxis:{
                rendererOptions:{
                    tickRenderer:$.jqplot.CanvasAxisTickRenderer},
					label:"Cost in Lakhs(INR)",
					labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
					/*labelOptions: {
					fontFamily: 'Georgia, Serif',
					fontSize: '12pt'
					},*/
                    tickOptions:{
                        fontSize:'10pt', 
                        fontFamily:'Tahoma', 
						formatString:"%'.2f",	
                        angle:30
                    }
            }
        },
		legend: { 
			show: true ,
			location: 'e',
                placement: 'outside'
		},
		 seriesDefaults: {
            rendererOptions: {
				smooth: true
			},
			pointLabels: { show:true } 
		},
        series:[
		{ label: 'Total Cost' },
        { label: 'Unified Labour Cost' },
		{ label: 'Base Labour Cost' },
		{ label: 'Payment Received' },
		{ label: 'Project Expense Cost' },
		{ 
			lineWidth:4, markerOptions:{ style:'circle' } 
		}
		],
        cursor:{
            zoom:true,
            looseZoom: true
        }
    });

});
</script>


<!-- Don't touch this! -->


    <script class="include" type="text/javascript" src="analytics/jquery.jqplot.min.js"></script>
    <script type="text/javascript" src="analytics/charts/syntaxhighlighter/scripts/shCore.min.js"></script>
    <script type="text/javascript" src="analytics/charts/syntaxhighlighter/scripts/shBrushJScript.min.js"></script>
    <script type="text/javascript" src="analytics/charts/syntaxhighlighter/scripts/shBrushXml.min.js"></script>
<!-- End Don't touch this! -->

<!-- Additional plugins go here -->

    <!-- to render rotated axis ticks, include both the canvasText and canvasAxisTick renderers -->
    <script language="javascript" type="text/javascript" src="analytics/plugins/jqplot.canvasTextRenderer.min.js"></script>
	<script language="javascript" type="text/javascript" src="analytics/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
	<script language="javascript" type="text/javascript" src="analytics/plugins/jqplot.enhancedLegendRenderer.min.js"></script>
	<script language="javascript" type="text/javascript" src="analytics/plugins/jqplot.pointLabels.min.js"></script>
	

    <script language="javascript" type="text/javascript" src="analytics/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
    <script language="javascript" type="text/javascript" src="analytics/plugins/jqplot.dateAxisRenderer.min.js"></script>
    <script language="javascript" type="text/javascript" src="analytics/plugins/jqplot.cursor.min.js"></script>
<!-- End additional plugins -->

</body>


</html>
