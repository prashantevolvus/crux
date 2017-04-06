<?php
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
<!DOCTYPE html>
<head>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script>
  $(function() {
    $( "#tabs" ).tabs({
      beforeLoad: function( event, ui ) {
        ui.jqXHR.error(function() {
          ui.panel.html(
            "A process is running. " +
            "Please click after sometime." );
        });
      }
    });
  });
  </script>
</head>
<body>
<? include 'header.php'; 

$repid=$_GET["rep_id"];

$coned=getConnection();
$sqled="
select 
a.id rep_id,a.tlr,b.id project_id,project_manager_id,project_director_id
from project_report a
inner join project_details b on b.id = a.project_id
where a.id = ".$repid ;


$resulted = mysqli_query($coned,$sqled) or d($sqled."   failed  <br/><br/>".mysql_error());
$rowed = mysqli_fetch_array($resulted);

?>
<tr>
<br>
<td>
<font size="3"><b>View Project Report</b></font>
</td>
<?
 if($rowed[tlr]=="GREEN")
                echo "<td ><img src='images/green.jpg' alt='red' width='40' height='40'</img></td>";

        if($rowed[tlr]=="RED")
                echo "<td ><img src='images/red.jpg' alt='red' width='40' height='40'</img></td>";


        if($rowed[tlr]=="AMBER")
                echo "<td ><img src='images/amber.jpg' alt='red' width='40' height='40'</img></td>";
if($_GET['redirect'] == "success")
{
		echo "<td style='color:red;font-size:50px;'>&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;Successfully updated</td>";			
}

$projid = $rowed[project_id];
$_GET['projid']=$rowed[project_id];
$_GET['nobr'] = "true";
?>
</tr>
<form name="projectForm"  method="post" onsubmit="return formSubmit();" >
<div id="tabs">
<ul>
<li><a href='viewrepdetailsinfo.php?rep_id=<?echo $repid?>'>Information</a> </li>
<li><a href='viewrepdetailsfin.php?rep_id=<?echo $repid?>'>Financials</a> </li>
<li><a href='viewrepdetailsqlt.php?rep_id=<?echo $repid?>'>Quality</a> </li>
<li><a href='viewrepdetailsscope.php?rep_id=<?echo $repid?>'>Scope</a> </li>
<li><a href='viewrepdetailsdet.php?rep_id=<?echo $repid?>'>Details</a> </li>
<li><a href='getinvoicelist.php?q2=<?echo $rowed[project_id]?>&rep=true'>Invoice</a> </li>
<li><a href='viewprojtimebookedreport.php?proj_id=<?echo $rowed[project_id]?>&q1=Last Week'>Time Booked</a> </li>
<li><a href='getrisklist.php?q=<?echo $rowed[project_id]?>&rep=true'>Risk</a> </li>
<li><a href='getexplist.php?q=<?echo $rowed[project_id]?>&rep=true'>Expenses</a> </li>
<?
if($rowed[project_manager_id]==$_SESSION["userempno"])					
	echo "<li><a href='fillprojrep.php?rep_id=$repid'>Fill Report</a> </li>";
if($rowed[project_director_id]==$_SESSION["userempno"])					
	echo "<li><a href='authprojrep.php?rep_id=$repid'>Authorise Report</a> </li>";
if(1==$_SESSION["userempno"])					
	echo "<li><a href='apprprojrep.php?rep_id=$repid>'>Approve Report</a> </li>";
?>
</ul>
</div>
</form>
</body>
</html>
