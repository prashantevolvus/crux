<?php
session_name("Project");
session_start();
$_SESSION['url'] = $_SERVER['REQUEST_URI']; 
require_once('dbconn.php');
if(!checkUserSession($_SESSION["user"]))
{
	header("Location:login.php");
}
/*Here set all the values*/
//Set the Header
$head="Product Capitlisation";

//Specify the query. Ensure the output columns are ordered first
$sql="
select financial_year,ifnull(product_name,'TOTAL FOR YEAR') product_name,base_labour_cost,labour_cost,expense_cost,total_cost from (
select financial_year,product_name,sum(a.Cost) base_labour_cost,sum(a.labourCost)
labour_cost,sum(a.expense_amt) expense_cost, ifnull(sum(ifnull(a.unifiedCost,0)),0) total_cost FROM `monthly_timesheet` a
inner join project_details b on a.`project_id` = b.`ohrm_project_id`
inner join products c on c.`id` = b.`base_product`
where   project_type_id = 1
group by financial_year,product_name with rollup) aa
order by financial_year desc,ifnull(product_name,'ZTOTAL FOR YEAR') 
 ";

/*Provide the header in array
 *First Column in array = Header Name
 *Second Column in array = Header Type currently supported string, amount, project_ref
 *Third column in array = Only for project_ref; the php name of the project view to be opened
 *Fourth column in array = Only for project_ref; the column number in the sql query to get project id
 *Ensure the order of output field matches with the sql column order
 **/
$col=array(
			array("Financial Year","string"),
			array("Product","string"),
			array("Base Labour Cost","amount"),
			array("Actual Labour Cost","amount"),
			array("Expense","amount"),
			array("Total Cost for Capitalisation","amount")
			);

/*
 * Use this field to limit the number of rows. A value of zero is get the full list
 */
$rowcount = 0;

//End of Configuration


if($rowcount <> 0)
	$sql .= " limit ".$rowcount;

$noofcol=count($col);
?>
<html>
<head>

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
</head>
<body>
<? include 'header.php';
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
