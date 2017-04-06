<?php 

?>
<tr valign="bottom">
<td>
<a href="index.php"><img align="left" height="30" src="images/crux70.png"></a>
</td>
<td>
<h2 align="middle">Project Management (UAT)</h2>
</td>
<td>
<h5 align="right">Welcome : <?php echo $_SESSION["user_name"]; ?></h5>
</td>
</tr>
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" type="text/css" href="tablestyle.css">


<div id='cssmenu'>
<ul>
   <li class='has-sub'><a href='#'><span>Projects</span></a>
      <ul>
         <li><a href='viewproject.php'><span>View Project</span></a></li>
         <li><a href='initproj.php'><span>Initiate Project</span></a></li>
		 <li><a href='addchangerequest.php'><span>Add Change Request</span></a></li>
		 <li><a href='viewchangerequest.php'><span>View Change Request</span></a></li>
         <li><a href='initebudget.php'><span>Initiate Project Budget</span></a></li>
         <li class='last'><a href='viewebudget.php'><span>View Project Budget</span></a></li>
      </ul>
   </li>

   <li class='has-sub'><a href='#'><span>Project Risk</span></a>
      <ul>
         <li><a href='createrisk.php'><span>New Risk</span></a></li>
         <li class='last'><a href='viewrisk.php'><span>View Risk</span></a></li>
      </ul>
   </li>
   <li class='has-sub'><a href='#'><span>Project Status Report</span></a>
      <ul>
         <li><a href='generateprojreport.php'><span>Generate Report</span></a></li>
         <li><a href='viewprojectreport.php'><span>View Report</span></a></li>
      </ul>
   </li>
   <li class='has-sub'><a href='#'><span>Analytics</span></a>
      <ul>
         <li><a href='date_cost.php'><span>Cost Trend</span></a></li>
         <li><a href='activity.php'><span>Activity Trend</span></a></li>
		 <li><a href='date_invoice.php'><span>Invoice Trend</span></a></li>
		 <li><a href='monthlystats.php'><span>Monthly Statistics</span></a></li>
	</ul>
   </li>
   <li class='has-sub'><a href='#'><span>Finance</span></a>
      <ul>
		 <li><a href='getconsolidated.php'><span>Consolidated Financials</span></a></li>
         <li><a href='createexpense.php'><span>Create Expense</span></a></li>
         <li><a href='viewexpense.php'><span>View Expense</span></a></li>
         <li><a href='addinvoice.php'><span>Add Invoice</span></a></li>
         <li class='last'><a href='viewinvoice.php'><span>View Invoice</span></a></li>
      </ul>
   </li>
   <li class='last'><a href='viewtimesheet.php'><span>Pending Timesheet</span></a></li>

   <li class='has-sub'><a href='#'><span>Reports</span></a>
      <ul>
      <?php
      	$con1=getConnection();
		$sql1= "select id,menu_name from dynamic_reports where incl_report_menu = 1 order by id";
		$result = mysqli_query($con1,$sql1) or debug($sql1."   failed  <br/><br/>".mysql_error());
		
		while($row = mysqli_fetch_array($result))
  		{
  			echo "<li><a href='dynamicreport.php?rep_id=".$row[id]."'><span>".$row[menu_name]."</span></a></li>";
  			
  		/*	<li><a href='psrreport.php'><span>PSR Report</span></a></li>
         <li><a href='invoicemismatch.php'><span>Invoice Mismatch</span></a></li>
         <li><a href='topprojects.php'><span>Top 10 Projects</span></a></li>
         <li><a href='productcap.php'><span>Product Capitalisation</span></a></li>
         <li class='last'><a href='#'><span>To be decided</span></a></li>?*/
  			
		}
		closeConnection($con1);
      ?>
      	 
      </ul>
   </li>
   <li class='last'><a href='logout.php'><span>Logout</span></a></li>
</ul>
</div>
