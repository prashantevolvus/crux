<?php
session_name("Project");
session_start();
require_once('dbconn.php');
if(!checkUserSession($_SESSION["user"]))
{
	header("Location:login.php");
}
if(checkProjectPermission("GENREP") == false)
{

        header("Location:error.php");
}

?>
<html>
<head>

<script>

</script>
</head>
<body>
<? include 'header.php'; ?>
<h3>Generate Project Status Report</h3>
<form name="timesheetListForm" >
<table>
<td>Status : </td>
<td>
<select id='tsstatus' name='tsstatus' value='' multiple='multiple' >
        <option value='All' selected='selected'>All</option>
        <option value='NOT SUBMITTED' >NOT SUBMITTED</option>
        <option value='SUBMITTED' >SUBMITTED</option>
        <option value='REJECTED' >REJECTED</option>
</select>
</td>
		<td>Supervisor : </td>
		<td>
                        <? 
$_GET['q']='all';
include 'getemp.php'; ?>
		</td>
		<td>Employee : </td>
		<td>
                        <? 

include 'getemp1.php'; ?>
		</td>
</tr>
</table>
<td><input type="button"  value="Fetch" onClick="showDetails();"></td>
<td><input type="button"  value="Summary" onClick="showSummary();"></td>

<tr>
<td><div id="txtDetails"><b></b></div></td>
</tr>
</form>
</body>
</html>
