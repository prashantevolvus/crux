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
//Please uncomment once old expense has been entered
$col1 = "select 
a.id,b.project_type,c.name customer,project_name,Planned_Start_Date std,planned_start_date, 
concat(d.emp_firstname,' ',d.emp_lastname) pm, 
ifnull(f.Budget,0)+ifnull(f.Excess_budget,0) total_budget,
ifnull(f.budget_to_go,0) budget_to_go, 
f.contract contract_value,tlr,case when ifnull(f.budget_to_go,0) < 0 then 'YES' else 'NO' end excessed, 
concat(e.emp_firstname,' ',e.emp_lastname) crt_by, a.status  ";
$sql = " from project_details a
inner join project_type b on a.project_type_id = b.project_type_id
inner join hr_mysql_live.ohrm_customer c on a.ohrm_customer_id= c.customer_id
inner join hr_mysql_live.hs_hr_employee d on a.project_manager_id= d.emp_number
inner join hr_mysql_live.hs_hr_employee e on a.Project_created_by= e.emp_number
left join project_summary f on f.project_id = a.ohrm_project_id 
";

	$sql .= " where 1=1 ";
if($q!="")
	$sql .= " and ohrm_customer_id = '".$q."' ";
if($q1!="")
        $sql .= " and status in (".$q1.") ";
if($q2!="")
        $sql .= " and base_product = '".$q2."' ";
if($q3!="")
        $sql .= " and project_manager_id = '".$q3."' ";
if($q4!="")
        $sql .= " and tlr = '".$q4."' ";
if($q5!="") 
        $sql .= " and  (case when f.budget_to_go < 0 then 'YES' else 'NO' end) = '".$q5."' ";
if($q6 == "true")
{
	$sql .= " and status not in ('CLOSED','DELETED')";
}
if($q7 != "")
        $sql .= " and a.project_type_id = '".$q7."' ";

$order = ' order by a.project_type_id,status desc';		
$sqlfull = $col1.$sql.$order;
$result =    mysqli_query($con,$sqlfull) or die($sqlfull."<br/><br/>".mysql_error());

?>
<tr>
<td>
<a id="dlink"  style="display:none;"></a>

<input type="button" onclick="tableToExcel('exportProj', 'projects', 'project.xls')" value="Export to Excel">
</td>
</tr>
<?
echo "<tr><td><b class='floating'>Number of Projects : ".mysqli_num_rows($result)."</b></td></tr>";

echo "<table id='detailsProj' class='gridtable' border='0'>";
echo "<thead>";
echo "<br><tr>";
//echo "<th><b>Project Type</b></th>";

echo "<th><b>Customer</b></th>";
	
echo "<th><b>Project Name</b></th>";
echo "<th><b>Project Manager</b></th>";
	
echo "<th><b>Planned Start Date</b></th>";

	
echo "<th><b>Total Budget</b></th>";

echo "<th><b>Budget to go</b></th>";

echo "<th><b>Traffic Light</b></th>";
echo "<th><b>Status</b></th>";
echo "<th ><b>Operations</b></th>";
echo "</tr>";
echo "</thead>";
$grp="";
echo "<tbody>";
while($row = mysqli_fetch_array($result))
  {
	$q1=$row[status];
	if($grp!=$row[project_type])
	{
		echo "<tr>";
		echo "<th class='grp'>Project Type - $row[project_type]</th>"; 
		echo "</tr>";
		$grp=$row[project_type];
	}
		
	echo "<tr>";

        //echo "<td>$row[project_type]</td>";
	    echo "<td>$row[customer]</td>";
	    echo "<td>$row[project_name]</td>";
	    echo "<td>$row[pm]</td>";
	$dt = date("d-M-Y", strtotime($row[std]));

        echo "<td>$dt</td>";


	$amt=number_format($row[total_budget],2);
        echo "<td align='right'>$amt</td>";

	$amt=number_format($row[budget_to_go],2);
        echo "<td align='right'>$amt</td>";
	if($row[tlr]=="GREEN")
		echo "<td align='middle'><img src='images/green.jpg' alt='red' width='30' height='30'</img></td>";
	
	if($row[tlr]=="RED")
		echo "<td align='middle'><img src='images/red.jpg' alt='red' width='30' height='30'</img></td>";
	

	if($row[tlr]=="AMBER")
		echo "<td align='middle'><img src='images/amber.jpg' alt='red' width='30' height='30'</img></td>";
	echo "<td>$q1</td>";
	
	echo "<td><a href='viewprojdetails.php?proj_id=$row[id]'>View</a> </td> ";
	echo "</tr>";
  }
echo "</tbody>";
  
echo "</table>";
$result = mysqli_query($con,$sqlfull) or debug($sqlfull."<br/><br/>".mysql_error());

echo "<table id='exportProj' border='0' style='display:none;'>";

echo "<br><tr>";
echo "<td><b>Project Type</b></td>";

echo "<td><b>Customer</b></td>";

echo "<td><b>Project Name</b></td>";

echo "<td><b>Project Manager</b></td>";

echo "<td><b>Planned Start Date</b></td>";


echo "<td><b>Total Budget</b></td>";

echo "<td><b>Contract Value</b></td>";
echo "<td><b>Traffic Light</b></td>";

echo "<td><b>Status</b></td>";
echo "</tr>";
$grp="";
while($row = mysqli_fetch_array($result))
  {
        $q1=$row[status]; 
        echo "<tr>";
		
        echo "<td>$row[project_type]</td>";
        echo "<td>$row[customer]</td>";
        echo "<td>$row[project_name]</td>";
        echo "<td>$row[pm]</td>";
        $dt = date("d-M-Y", strtotime($row[std]));

        echo "<td>$dt</td>";


        $amt=number_format($row[total_budget],2);
        echo "<td align='right'>$amt</td>";

        $amt=number_format($row[contract_value],2);
        echo "<td align='right'>$amt</td>";
        echo "<td>$row[tlr]</td>";
        echo "<td>$q1</td>";

        echo "</tr>";
  }

echo "</table>";
closeConnection($con);
?>
