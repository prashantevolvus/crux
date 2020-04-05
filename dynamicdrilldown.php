<?php
$permission = "VIEW";
require_once('head.php');

require_once('bodystart.php');
?>



<?php

$qryid=$_GET["qry_id"];
$f1=$_GET["f1_id"];
$f2=$_GET["f2_id"];
$f3=$_GET["f3_id"];
$f4=$_GET["f4_id"];
$f5=$_GET["f5_id"];

$con=getConnection();
$sql=
"select * from dynamic_drilldown where id = ".$qryid;

$result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>".mysql_error());
$row = mysqli_fetch_array($result);
$query=$row['query_str'];

$query = str_replace("QR1",$f1,$query);
$query = str_replace("QR2",$f2,$query);
$query = str_replace("QR3",$f3,$query);
$query = str_replace("QR4",$f4,$query);
$query = str_replace("QR5",$f5,$query);

$col_names=explode(';',$row['column_names']);
$col_types=explode(';',$row['column_type']);

$filter_names=explode(';',$row['filter_names']);

$href_text=explode(';',$row['href_text']);
$href_val=explode(';',$row['href_val']);

$head=$row['query_name'];

$col=array();
$i = 0;
foreach($col_names as $col_name)
{
	$col[]= array($col_name,(isset($col_types[$i]) ? $col_types[$i] : ''),
		(isset($href_text[$i]) ? $href_text[$i] : ''),
		(isset($href_val[$i]) ? $href_val[$i] : '')
	);

	$i=$i+1;
}
$noofcol=count($col);


echo "<h4>".$head."</h4>";
$i = 1;
echo "<div class='table-responsive'>";

echo "<table class='table table-bordered' id='filter' >";

foreach($filter_names as $filter)
{
        $sec = "f".$i;
        echo "<tr>";
        echo "<td>".$filter." : </td>";
        echo "<td>".$$sec."  </td>";
        echo "</tr>";
        $i=$i+1;
}
echo "</table> </div>";




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
    $('#<?php echo $qryid;?>').DataTable({

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
  ,buttons: [
        'colvis',
        'excel',
        'print'
    ]
} );
} );

</script>

 <div class="row">

<input type="button" class="btn btn-default" onclick="tableToExcel('<?php echo $qryid;?>', 'Crux Report', 'cruxReport.xls')" value="Export to MS Excel">

<a id="dlink"  style="display:none;"></a>

</div>
<br>


<div class="row">



<?php

$result = mysqli_query($con,$query) or debug($query."<br/><br/>".mysql_error());

echo "<div class='table-responsive'>";

echo "<table class='table table-bordered' id='".$qryid."' >";
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
			$amt=money_format('%!.0n', $row[$i]);//
			//$amt=number_format($row[$i],2);
			echo "<td align='right'>".$amt."</td>";
		}
		if($col[$i][1]=="date")
		{
			$dt = date("d-M-Y", strtotime($row[$i]));
			echo "<td>$dt</td>";
		}
		if($col[$i][1]=="href")
		{
			//echo $row[$col[$i][3]];
			echo "<td><a href='".$col[$i][2].$row[$col[$i][3]]."'>".$row[$i]."</a></td>";

		}
	}
	echo "</tr>";
}
echo "</tbody></table> </div>";
closeConnection($con);

?>
</div>


<?php

require_once('bodyend.php');
?>
