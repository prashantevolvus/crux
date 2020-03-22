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

<?
require_once('../../dbconn.php');
$con=getConnection();

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
	
  $date_exp_pay[] = $i+0;
  $date_paid[] = $i1;
  $x_axis[] = $row[0];
  
  //$activities[] = $row;
  
}
?>

<script class="code" type="text/javascript">
<?

	$js_array_cost = json_encode($date_exp_pay);
    echo "var tempArr_exp_pay = ". $js_array_cost . ";\n";
	
	$js_array_cost = json_encode($date_paid);
    echo "var tempArr_paid = ". $js_array_cost . ";\n";
	
	$js_array_cost = json_encode($x_axis);
    echo "var tempArr_xaxis = ". $js_array_cost . ";\n";


?>

$(document).ready(function(){
$.jqplot.config.enablePlugins = true;
        
		var ticks = tempArr_xaxis;//['a', 'b', 'c', 'd'];
        
        plot2 = $.jqplot('chart1', [tempArr_exp_pay,tempArr_paid], {
            seriesDefaults: {
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                }
				
            },
			legend: {
                show: true,
                location: 'e',
                placement: 'outside'
            } ,
			series:[
				{ label: 'Expected Payment' },
				{ label: 'Actual Paid' }
			]			
        });
    
        $('#chart1').bind('jqplotDataHighlight', 
            function (ev, seriesIndex, pointIndex, data) {
                $('#info2').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
            }
        );
            
        $('#chart1').bind('jqplotDataUnhighlight', 
            function (ev) {
                $('#info2').html('Nothing');
            }
        );
    });	
	
</script>


<!-- Don't touch this! -->


    <script class="include" type="text/javascript" src="../jquery.jqplot.min.js"></script>
    <script type="text/javascript" src="syntaxhighlighter/scripts/shCore.min.js"></script>
    <script type="text/javascript" src="syntaxhighlighter/scripts/shBrushJScript.min.js"></script>
    <script type="text/javascript" src="syntaxhighlighter/scripts/shBrushXml.min.js"></script>
<!-- End Don't touch this! -->

<!-- Additional plugins go here -->

  <script class="include" type="text/javascript" src="../plugins/jqplot.barRenderer.min.js"></script>
  <script class="include" type="text/javascript" src="../plugins/jqplot.pieRenderer.min.js"></script>
  <script class="include" type="text/javascript" src="../plugins/jqplot.categoryAxisRenderer.min.js"></script>
  <script class="include" type="text/javascript" src="../plugins/jqplot.pointLabels.min.js"></script>

   
<!-- End additional plugins -->

</body>


</html>
