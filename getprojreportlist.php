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
	    alert('hello');

        }
    })()
</script>

<?php
session_name("Project");
session_start();

require 'dbconn.php';
if(!checkUserSession($_SESSION["user"]))
//if(!isset($_SESSION["user"]))
{
        echo "<script>window.top.location.href='login.php'</script>";
        //header("Location:login.php");
}
$q=$_GET["q"];

$q1=$_GET["q1"];
$q2=$_GET["q2"];
$q3=$_GET["q3"];
$q4=$_GET["q4"];
$q5=$_GET["q5"];
$q6=$_GET["q6"];
$q7=$_GET["q7"];

$con=getConnection();

$sql = " 
select 
a.id rep_id,
report_date,
b1.name customer,
project_name,
a.status, 
getEmpName(b.project_manager_id) pm,
ifnull(getEmpName(a.filled_by),' ') report_filled_by
from project_report a
inner join project_details b on b.id = a.project_id
inner join hr_mysql_live.ohrm_customer b1 on customer_id = ohrm_customer_id
 
";
$sql .= " where 1=1 ";
if($q!="")
	$sql .= " and b.ohrm_customer_id = '".$q."' ";
if($q1!="")
        $sql .= " and a.status in (".$q1.") ";
if($q2!="")
        $sql .= " and base_product = '".$q2."' ";
if($q3!="")
        $sql .= " and project_manager_id = '".$q3."' ";
if($q6=="true")
        $sql .= " and a.status not in ('APPROVED') ";
		
if($q4!="")
        $sql .= " and a.tlr = '".$q4."' ";
if($q7 == true)
        $sql .= " and a.project_type_id = '".$q7."' ";
$sql .= " order by report_date desc";
$result =    mysqli_query($con,$sql) or die($sql."<br/><br/>".mysql_error());

?>
<tr>
<td>
<a id="dlink"  style="display:none;"></a>
<br>
</td>
</tr>
<?
echo "<tr><td><b>Number of Projects Reports : ".mysqli_num_rows($result)."</b></td></tr>";
echo "<table id='detailsProj' class='gridtable' border='0'>";

echo "<br><tr>";
echo "<th><b>Report Date</b></th>";


echo "<th><b>Customer</b></th>";
	
echo "<th><b>Project Name</b></td>";
echo "<th><b>Project Manager</b></th>";
	

echo "<th><b>Report Filled By</b></th>";
echo "<th><b>Status</b></th>";
	
echo "<th ><b>Operations</b></th>";
echo "</tr>";
while($row = mysqli_fetch_array($result))
  {
	$q1=$row[status];
	echo "<tr>";

    $dt = date("d-M-Y", strtotime($row[report_date]));

        echo "<td>$dt</td>";
    echo "<td>$row[customer]</td>";
	    echo "<td>$row[project_name]</td>";
	    echo "<td>$row[pm]</td>";
		echo "<td>$row[report_filled_by]</td>";
		
	
	echo "<td>$q1</td>";
	
	echo "<td><a href='viewrepdetails.php?rep_id=$row[rep_id]'>View</a> </td> ";
	echo "</tr>";
  }
echo "</table>";
closeConnection($con);
?>
