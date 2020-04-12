<?php
$permission = "VIEW";

require_once('common.php');

require_once 'dbconn.php';
if(!checkUserSession($_SESSION["user"]))
{
        echo "<script>window.top.location.href='login.php'</script>";
        //header("Location:login.php");
}

$q = isset($_GET["q"]) ? $_GET["q"] : '';
$q1= isset($_GET["q1"]) ? $_GET["q1"] : '';



$con=getConnection();
$sql =
"select a.id, opp_name, b.name,current_quote,no_regret_quote,start_date,expected_close_date,sales_stage
from opp_details a
inner join hr_mysql_live.ohrm_customer b on a.customer_id = b.customer_id
inner join opp_sales_stage c on a.sales_stage_id = c.id
where 1=1 "
.(!empty($q)? " and active = 1":" ")
.(!empty($q1)? " and sales_stage_id in (".$q1.")" : " ")
." order by start_date desc";

$result = mysqli_query($con,$sql) ;

$reportid="TBL";

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
} );
} );
</script>

<div class="row">

<input type="button" class="btn btn-default" onclick="tableToExcel('<?php echo $reportid;?>', 'Crux Report', 'cruxReport.xls')" value="Export to MS Excel">

<a id="dlink"  style="display:none;"></a>

</div>
<br>
<div class="row">

<div class='table-responsive'>
<table class='table table-bordered'  id=<?php echo $reportid;?> width='100%'>
<br>
<thead>
  <tr>
    <th><b>Customer Name</b></th>
    <th><b>Opportunity Name</b></th>
    <th><b>Current Quote</b></th>
    <th><b>No Regret Quote</b></th>
    <th><b>Start Date</b></th>
    <th><b>Expected Close Date</b></th>
    <th><b>Sales Stage</b></th>
 </tr>
</thead>
<tbody>
<?php
while($row = mysqli_fetch_array($result))
{
	echo "<tr>";
  echo "<td>".$row['name']."</td>";
  echo "<td> <a href='viewopportunity.php?oppid=".$row['id']."'>".$row['opp_name']."</a></td>";

  setlocale(LC_MONETARY, 'en_US');
  $amt=number_format($row['current_quote'],0);
  echo "<td align='right'>".$amt."</td>";

  setlocale(LC_MONETARY, 'en_US');
  $amt=number_format($row['no_regret_quote'],0);
  echo "<td align='right'>".$amt."</td>";

  $sortDate = strtotime($row['start_date']);
  $dt = date("d-M-Y", strtotime($row['start_date']));
  echo "<td data-sort='".$sortDate."'>$dt</td>";

  $sortDate = strtotime($row['expected_close_date']);
  $dt = date("d-M-Y", strtotime($row['expected_close_date']));
  echo "<td data-sort='".$sortDate."'>$dt</td>";


  echo "<td>".$row['sales_stage']."</td>";

  echo "</tr>";
}

?>

</tbody>
