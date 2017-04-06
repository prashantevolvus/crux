<!DOCTYPE html>
<?
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
  
    <!--[if lt IE 9]><script language="javascript" type="text/javascript" src="analytics/excanvas.js"></script><![endif]-->
    <script class="include" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  
   
</head>
<body>
        
  
<!-- Example scripts go here -->

    <div id="pie11" style="margin-top:20px; margin-left:20px; width:400px; height:400px;"></div>
<?
require_once('dbconn.php');
$con=getConnection();
$activities_effort = array();
$activities_cost = array();
$sql = "select activity,sum(work_hours) from monthly_timesheet
where activity is not null
group by activity
having sum(work_hours) <> 0
order by sum(work_hours) desc
LIMIT 10
";


$result = mysqli_query($con,$sql) or die($sql."<br/><br/>".mysql_error());
while($row = mysqli_fetch_array($result))
{
	$i = number_format($row[1],0);
	
  $activities_effort[] = array($row[0],$i+0);
  //$activities[] = $row;
  
}
?>

<script class="code" type="text/javascript">
<?
$js_array_effort = json_encode($activities_effort);
    echo "var tempArr_effort = ". $js_array_effort . ";\n";

?>
$(document).ready(function(){ 
       
    var plot8 = $.jqplot('pie11', [tempArr_effort], {
        grid: {
            drawBorder: true, 
            drawGridlines: true,
            background: '#ffffff',
            shadow:true
        },
        axesDefaults: {
            
        },
        seriesDefaults:{
            renderer:$.jqplot.PieRenderer,
            rendererOptions: {
                showDataLabels: true,
				diameter: undefined
            }
        },
		title: {
			text: 'Top 10 Activities - Effort',
			show: true
		},
        legend: {
            show: true,
           
            location: 'e'
        },
		highlighter: {
			show: true,
			useAxesFormatters: false, // must be false for piechart   
			tooltipLocation: 'sw',
			formatString:'%s'
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

  <script class="include" type="text/javascript" src="analytics/plugins/jqplot.pieRenderer.min.js"></script>

<!-- End additional plugins -->
</body>


</html>
