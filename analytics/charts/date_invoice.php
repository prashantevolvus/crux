<!DOCTYPE html>

<html>
<head>

    <title>Activity</title>

    <link class="include" rel="stylesheet" type="text/css" href="../jquery.jqplot.min.css" />
    <link rel="stylesheet" type="text/css" href="examples.min.css" />
    <link type="text/css" rel="stylesheet" href="syntaxhighlighter/styles/shCoreDefault.min.css" />
    <link type="text/css" rel="stylesheet" href="syntaxhighlighter/styles/shThemejqPlot.min.css" />
  
    <!--[if lt IE 9]><script language="javascript" type="text/javascript" src="../excanvas.js"></script><![endif]-->
    <script class="include" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    
   
</head>
<body>
        <div class="colmask leftmenu">
      <div class="colleft"> 
        <div class="col1" id="example-content">

  
<!-- Example scripts go here -->

	<div id="chart1" style="height:400px; width:850px;"></div>
	<div id="chart2" style="height:400px; width:850px;"></div>

<?
require_once('../../dbconn.php');
$con=getConnection();

$sql1 = "
select base_date,
expected_invoice/100000.0,invoiced/100000.0
from invoice_projection

";


$result = mysqli_query($con,$sql1) or die($sql."<br/><br/>".mysql_error());
while($row = mysqli_fetch_array($result))
{
	$i = $row[1]+0;
	$i1 = $row[2]+0;
	
	
  $date_exp_inv[] = array($row[0],$i+0);
  $date_inv[] = array($row[0],$i1+0);
  
  //$activities[] = $row;
  
}

$sql1 = "
select Month,
expected_payment/100000.0,paid/100000.0
from invoice_projection
where expected_payment <> 0 or paid <> 0
order by base_date
";


$result = mysqli_query($con,$sql1) or die($sql."<br/><br/>".mysql_error());
while($row = mysqli_fetch_array($result))
{
	$i = $row[1]+0;
	$i1 = $row[2]+0;
	
	
  $date_exp_pay[] = array($row[0],$i+0);
  $date_pay[] = array($row[0],$i1+0);
  //$activities[] = $row;
  
}


//echo json_encode($date_labour);	
?>

<script class="code" type="text/javascript">
<?
	$js_array_cost = json_encode($date_exp_inv);
    echo "var tempArr_exp_inv = ". $js_array_cost . ";\n";
	
	$js_array_cost = json_encode($date_inv);
    echo "var tempArr_inv = ". $js_array_cost . ";\n";
	
	$js_array_cost = json_encode($date_exp_pay);
    echo "var tempArr_exp_pay = ". $js_array_cost . ";\n";
	
	$js_array_cost = json_encode($date_pay);
    echo "var tempArr_pay = ". $js_array_cost . ";\n";
	

?>

$(document).ready(function(){
	    $.jqplot.config.enablePlugins = true;

  var plot1 = $.jqplot('chart1', [tempArr_exp_inv,tempArr_inv], {
    title:'Invoice Trend',
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
		legend: { show: true },
        series:[
		{ label: 'Expected Invoice' },
        { label: 'Invoiced' },
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

$(document).ready(function(){
	    $.jqplot.config.enablePlugins = true;

  var plot1 = $.jqplot('chart2', [tempArr_exp_inv,tempArr_inv], {
    title:'Payment Trend',
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
		legend: { show: true },
        series:[
		{ label: 'Expected Payment' },
        { label: 'Paid' },
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


    <script class="include" type="text/javascript" src="../jquery.jqplot.min.js"></script>
    <script type="text/javascript" src="syntaxhighlighter/scripts/shCore.min.js"></script>
    <script type="text/javascript" src="syntaxhighlighter/scripts/shBrushJScript.min.js"></script>
    <script type="text/javascript" src="syntaxhighlighter/scripts/shBrushXml.min.js"></script>
<!-- End Don't touch this! -->

<!-- Additional plugins go here -->

    <!-- to render rotated axis ticks, include both the canvasText and canvasAxisTick renderers -->
    <script language="javascript" type="text/javascript" src="../plugins/jqplot.canvasTextRenderer.min.js"></script>
	<script language="javascript" type="text/javascript" src="../plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
	<script language="javascript" type="text/javascript" src="../plugins/jqplot.enhancedLegendRenderer.min.js"></script>
	

    <script language="javascript" type="text/javascript" src="../plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
    <script language="javascript" type="text/javascript" src="../plugins/jqplot.dateAxisRenderer.min.js"></script>
    <script language="javascript" type="text/javascript" src="../plugins/jqplot.cursor.min.js"></script>
<!-- End additional plugins -->

</body>


</html>
