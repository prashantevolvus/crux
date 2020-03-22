<?php

require_once('common.php');


	$con=getConnection();
	$sql=
		"select * from dynamic_reports where dashboard = 1 order by id";

	$resultdash = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>".mysql_error());
	$rowdash = mysqli_fetch_array($resultdash);


	echo "<ul class='nav nav-tabs'>";
	echo "<li class='active'><a data-toggle='tab' href=#TABX".$rowdash['id'].">".$rowdash['name']."</a></li>";

  	while($rowdash = mysqli_fetch_array($resultdash))
  	{
  		echo "<li><a data-toggle='tab' href=#TABX".$rowdash['id'].">".$rowdash['name']."</a></li>";
  	}

  	echo " </ul>";

	//Call again
 	$resultdash = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>".mysql_error());
	$rowdash = mysqli_fetch_array($resultdash);

 	echo "<div class='tab-content'>";
 		echo "<div id='TABX".$rowdash['id']."' class='tab-pane fade in active'>";
 			echo "<p>";
 				$_GET["rep_id"] = $rowdash['id'];
				include 'getdynamicreport.php';

			echo "</p>";
		echo "</div>";




		while($rowdash = mysqli_fetch_array($resultdash))
  		{


  			echo "<div id='TABX".$rowdash['id']."' class='tab-pane fade'>";
  				echo "<p>";
  					$_GET["rep_id"] = $rowdash['id'];
					include 'getdynamicreport.php';

				echo "</p>";
			echo "</div>";
  		}


	echo "</div>";






?>
