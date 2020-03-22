<?php
session_name("Project");
session_start();
$_SESSION['url'] = $_SERVER['REQUEST_URI']; 
require_once('dbconn.php');
if(!checkUserSession($_SESSION["user"]))
{
	header("Location:login.php");
}

/*Get the data from MySQL*/
$reportid=$_GET["rep_id"];
$con=getConnection();
$sql=
"select * from dynamic_reports where id = ".$reportid;

$result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>".mysql_error());
$row = mysqli_fetch_array($result);

$head=$row['name'];
$sql=$row['query'];

$col_names=explode(';',$row['column_names']);
$col_types=explode(';',$row['column_type']);
$col_phps=explode(';',$row['column_ref_php']);
$col_ref_ids=explode(';',$row['column_ref_proj_id']);

$col=array();
$i = 0;
foreach($col_names as $col_name)
{
	$col[]= array($col_name,$col_types[$i],$col_phps[$i],$col_ref_ids[$i]);
	
	$i=$i+1;
}



/*
 * Use this field to limit the number of rows. A value of zero is get the full list
 */
$rowcount = $row['no_of_rows'];

//End of Configuration


if($rowcount <> 0)
	$sql .= " limit ".$rowcount;

$noofcol=count($col);
?>
<body>

<script>
var tableToExcel = (function () {
        var uri = 'data:application/vnd.ms-excel;base64,'
        , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
        , base64 = function (s) { return window.btoa(unescape(encodeURIComponent(s))) }
        , format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }
        return function (table, name, filename) {
            if (!table.nodeType) table = document.getElementById(table)
            var ctx = { worksheet: name || 'Worksheet', table: table.innerHTML }

            document.getElementById("dlink").href = uri + base64(format(template, ctx));
            document.getElementById("dlink").download = filename;
            document.getElementById("dlink").click();

        }
    })()

</script>



<?php
echo "<h3>".$head."</h3>";
?>
<input type="button" onclick="tableToExcel('outputTab', 'Crux Report', 'cruxReport.xls')" value="Export to Excel">
<tr>
<td>
<a id="dlink"  style="display:none;"></a>

</td>
</tr>

<?php
$con=getConnection();


$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());

echo "<table class='gridtable' id='outputTab'>";
echo "<br><tr>";
	for($i=0;$i<$noofcol;$i++)
	{
		echo "<th><b>".$col[$i][0]."</b></th>";
	}
	
echo "</tr>";
while($row = mysqli_fetch_array($result))
{
	echo "<tr>";
	for($i=0;$i<$noofcol;$i++)
	{
		if($col[$i][1]=="string")
		{
			echo "<td>$row[$i]</td>";
		}
		if($col[$i][1]=="amount")
		{
			$amt=number_format($row[$i],2);
			echo "<td align='right'>$amt</td>";
		}
		if($col[$i][1]=="project_ref")
		{
			//echo $row[$col[$i][3]];
			echo "<td><a href='".$col[$i][2]."?proj_id=".$row[$col[$i][3]]."'>".$row[$i]."</a></td>";
		}		
	}
	echo "</tr>";
}
echo "</table>";
closeConnection($con);

?>
</body>
</html>
