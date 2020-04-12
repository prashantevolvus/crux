<?php
// <img alt="Brand"  style="width:30%" src="images/crux70.png">
?>
<script>

$(document).ready(function() {

    $('.navbar a.dropdown-toggle').on('click', function(e) {
        var $el = $(this);
        var $parent = $(this).offsetParent(".dropdown-menu");
        $(this).parent("li").toggleClass('open');

        if(!$parent.parent().hasClass('nav')) {
            $el.next().css({"top": $el[0].offsetTop, "left": $parent.outerWidth() - 4});
        }

        $('.nav li.open').not($(this).parents("li")).removeClass("open");

        return false;
    });
});

</script>

<style>
@media (min-width: 767px) {
    .navbar-nav .dropdown-menu .caret {
	transform: rotate(-90deg);
    }
}


</style>

<nav class="navbar navbar-default">
<div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">
       CRUX
      </a>
    </div>
      <ul class="nav navbar-nav navbar-left">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Projects<span class="caret"></span></a>
          <ul class="dropdown-menu  multi-level">
            <li><a href="projects.php">Enquire Projects</a></li>
            <li><a href="viewproject.php">View Projects</a></li>
            <li><a href="initproj.php">Initiate Project</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="addchangerequest.php">Add Change Request</a></li>
            <li><a href="viewchangerequest.php">View Change Request</a></li>
            <li role="separator" class="divider"></li>
        	<li class="dropdown-submenu">
             	<a class="dropdown-toggle" data-toggle="dropdown" href="#">Budget <b class="caret"></b></a>
             	<ul class="dropdown-menu">
            		<li><a href="initebudget.php">Initiate Project Budget</a></li>
            		<li><a href="viewebudget.php">View Project Budget</a></li>
            	</ul>
            </li>
          </ul>
        </li>
      </ul>

    <!-- <ul class="nav navbar-nav navbar-left">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Project Risks<span class="caret"></span></a>
          <ul class="dropdown-menu">
			<li><a href='createrisk.php'><span>New Risk</span></a></li>
           <li class='last'><a href='viewrisk.php'><span>View Risk</span></a></li>
          </ul>
        </li>
    </ul> -->

    <!-- <ul class="nav navbar-nav navbar-left">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Project Status Report<span class="caret"></span></a>
          <ul class="dropdown-menu">
             	<li><a href='generateprojreport.php'><span>Generate Report</span></a></li>
         		<li><a href='viewprojectreport.php'><span>View Report</span></a></li>
          </ul>
        </li>
    </ul> -->

    <ul class="nav navbar-nav navbar-left">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Analytics<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href='date_cost.php'><span>Cost Trend</span></a></li>
        	<li><a href='activity.php'><span>Activity Trend</span></a></li>
		 	<li><a href='date_invoice.php'><span>Invoice Trend</span></a></li>
		 	<li><a href='monthlystats.php'><span>Monthly Statistics</span></a></li>
          </ul>
        </li>
    </ul>

      <ul class="nav navbar-nav navbar-left">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Finance<span class="caret"></span></a>
          <ul class="dropdown-menu">
            	<li><a href='getconsolidated.php'><span>Consolidated Financials</span></a></li>
            	<li role="separator" class="divider"></li>
         		<li><a href='createexpense.php'><span>Create Expense</span></a></li>
         		<li><a href='viewexpense.php'><span>View Expense</span></a></li>

			<li role="separator" class="divider"></li>
			<li><a href='addinvoice.php'><span>Add Invoice</span></a></li>
         		<li class='last'><a href='viewinvoice.php'><span>View Invoice</span></a></li>


          </ul>
        </li>
    </ul>

    <ul class="nav navbar-nav navbar-left">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Timesheet<span class="caret"></span></a>
          <ul class="dropdown-menu">
             	<li><a href='viewtimesheet.php?STATUS=CURRENT'><span>Pending Timesheets</span></a></li>
<li><a href='viewtimesheet.php?STATUS=PAST'><span>Pending Past Employee Timesheets</span></a></li>
             	<li><a href='vieworgchart.php'><span>Organisation Structure</span></a></li>
          </ul>
        </li>
    </ul>

    <ul class="nav navbar-nav navbar-left">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Sales Opportunities<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href='opportunities.php'><span>Opportunities</span></a></li>
        	<li><a href='addopportunities.php'><span>Add Opportunity</span></a></li>
          </ul>
        </li>
    </ul>

     <ul class="nav navbar-nav navbar-left">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Reports<span class="caret"></span></a>
          <ul class="dropdown-menu">


           		<?php
           				$menuGroup = "±";
           				$con1=getConnection();
						$sql1= "select id,menu_group,menu_name from dynamic_reports where incl_report_menu = 1 order by menu_group , id";
						$result = mysqli_query($con1,$sql1) or debug($sql1."   failed  <br/><br/>".mysql_error());
						while($row = mysqli_fetch_array($result))
  						{
  							if($menuGroup != $row['menu_group'] and $row['menu_group'] != "")
  							{
  								if($menuGroup != "±")
  								{
  									echo "</li>";
  									echo "</ul>";
  								}
  								else
  									echo "<li role='separator' class='divider'></li>";

				         		echo "<li class='dropdown-submenu'>";
             					echo "<a class='dropdown-toggle' data-toggle='dropdown' href='#'>".$row['menu_group']."<b class='caret'></b></a>";
             					echo "<ul class='dropdown-menu'>";
             					echo "<li><a href='dynamicreport.php?rep_id=".$row['id']."'><span>".$row['menu_name']."</span></a></li>";


             					$menuGroup = $row['menu_group'];
				         	}
				         	else
				         		echo "<li><a href='dynamicreport.php?rep_id=".$row['id']."'><span>".$row['menu_name']."</span></a></li>";

  						}
  						if($menuGroup != "±")
  						{
  									echo "</li>";
  									echo "</ul>";
  						}

           		?>


        	</li>


          </ul>
        </li>
    </ul>



     <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Welcome : <?php echo $_SESSION["user_name"]; ?><span class="caret"></span></a>
          <ul class="dropdown-menu">
             	<li><a href='logout.php'><span>Logout</span></a></li>
             	<li><a href='#'><span>Dashboard Setting</span></a></li>

          </ul>
        </li>
    </ul>



</div>
</nav>
