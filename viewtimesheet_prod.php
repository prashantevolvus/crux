<?php
$permission = "VIEW";

session_name("Project");
session_start();
$_SESSION['url'] = $_SERVER['REQUEST_URI']; 
require_once('dbconn.php');
if(!checkUserSession($_SESSION["user"]))
{
	header("Location:login.php");
}
?>
<html>
<head>


<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="jss/jquery-3.1.0.min.js"></script>  
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script>

<script>

var showDetailsJQ = function ()
{
  		
		var stat=""; 
		$('#tsstatus :selected').each(function(i, sel){ 
			stat="'"+$(sel).val()+"' "+stat;   		
    	});
		s = stat.search("All") != -1 ? "" : stat.trim().replace(' ',',').replace('NS','NOT SUBMITTED');
		
		s2=$('select[name=all]').val();
		s2=s2=="Choose.."?"":s2;

		s3=$('select[name=emp]').val();
		s3=s3=="Choose.."?"":s3;
		//alert(s+" : "+s2);
		//JQuery
		$.ajax({
  			method:'get', //Or get
  			url:'gettimesheetlist.php?q='+s+'&q1='+s2+'&q2='+s3,
  			success:function(result){
    			$('#txtDetails').html(result);
  			},
  			error:function(){
    			alert("Something went wrong");
			}
			});
}

$(document).ready( function () {
$('#det').click(function () {
	showDetailsJQ();
});
});

$(document).ready(showDetailsJQ);




$(document).ready( function () {
   $( '#sum').click(function() {
  		//JQuery
	$.ajax({
  		method:'get', //Or get
  		url:'gettimesheetgroup.php',
  		success:function(result){
    		$('#txtDetails').html(result);
  		},
  		error:function(){
    		alert("Something went wrong");
		}
		});
});
} );





</script>
</head>
<body>
<?php include 'header.php'; ?>
<h3>View Pending Timesheet</h3>
<form name="timesheetListForm" >
<table>
<td>Status : </td>
<td>
<select id='tsstatus' name='tsstatus' value='' multiple='multiple' >
        <option value='All' selected='selected'>All</option>
        <option value='NS' >NOT SUBMITTED</option>
        <option value='SUBMITTED' >SUBMITTED</option>
        <option value='REJECTED' >REJECTED</option>
</select>
</td>
		<td>Supervisor : </td>
		<td>
                        <?php
$_GET['q']='all';
include 'getemp.php'; ?>
		</td>
		<td>Employee : </td>
		<td>
                        <?php

include 'getemp1.php'; ?>
		</td>
</tr>
</table>
<td><input type="button"  id='det' value="Fetch"></td>
<td><input type="button"  id='sum' value="Summary"></td>

<tr>
<td><div id=txtDetails></div></td>
</tr>
</form>
</body>
</html>
