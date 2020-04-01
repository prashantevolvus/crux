<?php

require_once('common.php');

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
$order =$row['order_on'];

$col=array();
$i = 0;
foreach($col_names as $col_name)
{
	$col[]= array($col_name,
									$col_types[$i]   ??  '',
									$col_phps[$i]    ??  '',
									$col_ref_ids[$i] ??  ''
									);

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

  $(document).ready( function () {
    $('#<?php echo $reportid;?>').DataTable({
  "pagingType": "full_numbers",
  "lengthMenu": [ [10, 25, 50, 100,-1], [10, 25, 50, 100,"All"] ],
  "pageLength": 50,
	"autoWidth": true,
	 "orderMulti": true
  <?php
  	if($order != "")
  		echo ", 'order':[[".$order.",'desc']]";
  	else
  		echo ",  'order': []";
  ?>
} );
} );

</script>



<?php echo "<h4>".$head."</h4>";?>
 <div class="row">

<input type="button" class="btn btn-default" onclick="tableToExcel('<?php echo $reportid;?>', 'Crux Report', 'cruxReport.xls')" value="Export to MS Excel">

<a id="dlink"  style="display:none;"></a>

</div>
<br>
<div class="row">

<?php
$con=getConnection();


$result = mysqli_query($con,$sql) or debug($sql."<br/><br/>".mysql_error());
echo "<div class='table-responsive'>";

echo "<table class='table table-bordered' id='".$reportid."' >";
echo "<thead><tr>";
	for($i=0;$i<$noofcol;$i++)
	{
		echo "<th><div>".$col[$i][0]."</div></th>";
	}

echo "</tr></thead><tbody>";
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
			setlocale(LC_MONETARY, 'en_US');
			//$amt=money_format('%!.0n', $row[$i]);
			$amt=number_format($row[$i],0);
			echo "<td align='right'>".$amt."</td>";
		}
		if($col[$i][1]=="project_ref")
		{
			//echo $row[$col[$i][3]];
			echo "<td><a href='".$col[$i][2]."?proj_id=".$row[$col[$i][3]]."'>".$row[$i]."</a></td>";
		}
		if($col[$i][1]=="date")
		{
			$dt = date("d-M-Y", strtotime($row[$i]));
			echo "<td>$dt</td>";
		}
		if($col[$i][1]=="amount_ref")
		{
			$data = explode(":",$row[$i]);
			if(count($data) == 2)
			{
				$gets = explode(",",$data[1]);
				$qstr  = "&f1_id=".($gets[0] ?? '');
				$qstr .= "&f2_id=".($gets[1] ?? '');
				$qstr .= "&f3_id=".($gets[2] ?? '');
				$qstr .= "&f4_id=".($gets[3] ?? '');
				$qstr .= "&f5_id=".($gets[4] ?? '');
				$ref = "dynamicdrilldown.php?qry_id=".$col[$i][2].$qstr;
 				setlocale(LC_MONETARY, 'en_US');
				$amt=money_format('%!.0n', $data[0]);
				echo "<td align='right'>";
				echo "<a href='".$ref."'>";
				echo $amt."</a></td>";
			}
			else
			{
				setlocale(LC_MONETARY, 'en_US');
				$amt=money_format('%!.0n', $row[$i]);//
			 	echo "<td align='right'>".$amt."</td>";
			}
		}
	}
	echo "</tr>";
}
echo "</tbody></table> </div>";
closeConnection($con);

?>
</div>
