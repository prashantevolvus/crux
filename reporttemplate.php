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
$head="View Invoice Mismatch";

//Specify the query. Ensure the output columns are ordered first
$sql="
select * from
(select  
d.name cust_name,
project_name proj_name,
contract_value,
CR_value ,
contract_value + CR_value  'total_val',
invoice_amt,
contract_value + CR_value - invoice_amt as 'diff',
a.id 
from project_details a 
left join
(select project_id , sum(ifnull(CR_amount ,0)) CR_value from project_cr group by project_id) b on a.id=b.project_id
left join (select project_id , sum(lcy_amount) as 'invoice_amt' from project_invoice group by project_id) c on a.id=c.project_id
join hr_mysql_live.ohrm_customer d on a.ohrm_customer_id = d.customer_id
order by d.name desc) e where e.diff <> 0 
 ";

/*Provide the header in array
 *First Column in array = Header Name
 *Second Column in array = Header Type currently supported string, amount, project_ref
 *Third column in array = Only for project_ref; the php name of the project view to be opened
 *Fourth column in array = Only for project_ref; the column number in the sql query to get project id
 *Ensure the order of output field matches with the sql column order
 **/
$col=array(
			array("Customer Name","string"),
			array("Project","project_ref","viewprojexpdetails.php",7),
			array("Contract Value","amount"),
			array("CR Value","amount"),
			array("Total Value","amount"),
			array("Invoice Amount","amount"),
			array("Difference","amount")
			);

/*
 * Use this field to limit the number of rows. A value of zero is get the full list
 */
$rowcount = 10;

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
