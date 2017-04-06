<?php
session_name("Project");
session_start();
if(!checkUserSession($_SESSION["user"]))
{
        echo "<script>window.top.location.href='login.php'</script>";
        //header("Location:login.php");
}
$qx=$_GET["projid"];
$nobr=$_GET["nobr"];
require_once 'dbconn.php';
$conoper=getConnection();
//Please uncomment once old expense has been entered
$sqlx="
select id,b.project_type,c.name customer,project_name,Actual_Start_Date std,planned_start_date,
concat(d.emp_firstname,' ',d.emp_lastname) pm,
ifnull(Budget,0)+ifnull(Excess_budget,0) total_budget,
contract_value,tlr,
concat(e.emp_firstname,' ',e.emp_lastname) crt_by,
a.status
 from project_details a
inner join project_type b on a.project_type_id = b.project_type_id
inner join hr_mysql_live.ohrm_customer c on a.ohrm_customer_id= c.customer_id
inner join hr_mysql_live.hs_hr_employee d on a.project_manager_id= d.emp_number
inner join hr_mysql_live.hs_hr_employee e on a.Project_created_by= e.emp_number where a.id=".$qx;
$result = mysqli_query($conoper,$sqlx) or debug($sqlx."<br/><br/>".mysql_error());
$rowoper = mysqli_fetch_array($result);
	$qx1=$rowoper[status];

	if($nobr != "true")
		echo "</tr><br><br><tr>";
	echo " <font size='2' color='orange'> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ";
	if($qx1 == "INITIATED")
	{
		echo "<td><a href='editprojdetails.php?proj_id=$rowoper[id]'>Edit</a> |  ";
		echo "<a href='authprojdetails.php?proj_id=$rowoper[id]'>Authorise</a> | ";
		echo "<a href='viewprojdetails.php?proj_id=$rowoper[id]'>View</a> | ";
		echo "<a href='delprojdetails.php?proj_id=$rowoper[id]'>Delete</a> </td>";
	}
	if($qx1 == "AUTHORISED")
	{
		echo "<td><a href='apprprojdetails.php?proj_id=$rowoper[id]'>Approve</a> |  ";
		echo "<a href='viewprojdetails.php?proj_id=$rowoper[id]'>View</a> | ";
		echo "<a href='delprojdetails.php?proj_id=$rowoper[id]'>Delete</a> </td>";
	}
	if($qx1 == "APPROVED")
        {
                echo "<td><a href='actprojdetails.php?proj_id=$rowoper[id]'>Activate</a> |  ";
                echo "<a href='viewprojdetails.php?proj_id=$rowoper[id]'>View</a> | ";
                echo "<a href='delprojdetails.php?proj_id=$rowoper[id]'>Delete</a> </td>";
        }
	if($qx1 == "ACTIVE")
	{
		echo "<td><a href='viewprojdetails.php?proj_id=$rowoper[id]'>View</a> | ";
		echo "<td><a href='updprojdetails.php?proj_id=$rowoper[id]'>Update Status</a> | ";
		echo "<a href='warprojdetails.php?proj_id=$rowoper[id]'>Warranty</a> | ";
		echo "<a href='deactprojdetails.php?proj_id=$rowoper[id]'>Deactivate</a> | ";
		echo "<a href='closeprojdetails.php?proj_id=$rowoper[id]'>Initiate Closure</a> </td>";
	}
	if($qx1 == "DEACTIVATED" || $qx1 == "PENDING INVOICE")
        {
                echo "<td><a href='actprojdetails.php?proj_id=$rowoper[id]'>Activate</a> |  ";
                echo "<a href='viewprojdetails.php?proj_id=$rowoper[id]'>View</a> </td> ";
        }
	if($qx1 == "INITIATE CLOSURE")
        {
                echo "<td><a href='closeauthprojdetails.php?proj_id=$rowoper[id]'>Authorise Closure</a> |  ";
                echo "<a href='viewprojdetails.php?proj_id=$rowoper[id]'>View</a> </td> ";
        }
	if($qx1 == "AUTHORISE CLOSURE")
        {
                echo "<td><a href='closeapprprojdetails.php?proj_id=$rowoper[id]'>Approve Closure</a> |  ";
                echo "<a href='viewprojdetails.php?proj_id=$rowoper[id]'>View</a> </td> ";
        }

	if($qx1 == "WARRANTY")
        {
                echo "<td><a href='viewprojdetails.php?proj_id=$rowoper[id]'>View</a> | ";
		echo "<a href='deactprojdetails.php?proj_id=$rowoper[id]'>Deactivate</a> | ";
                echo "<a href='closeprojdetails.php?proj_id=$rowoper[id]'>Initiate Closure</a> </td>";
        }
	if($qx1 == "DELIVERED")
        {
                echo "<td><a href='viewprojdetails.php?proj_id=$rowoper[id]'>View</a> | ";
		echo "<a href='deactprojdetails.php?proj_id=$rowoper[id]'>Deactivate</a> | ";
        echo "<a href='closeprojdetails.php?proj_id=$rowoper[id]'>Initiate Closure</a> </td>";
        }
	if($qx1 == "CLOSED")
	{
		echo "<td><a href='viewprojdetails.php?proj_id=$rowoper[id]'>View</a> </td> ";
	}
	if($qx1 == "DELETED")
	{
		echo "<td><a href='viewprojdetails.php?proj_id=$rowoper[id]'>View</a> </td> ";
	}
	
	echo "<td> | <a href='viewprojaudit.php?proj_id=$rowoper[id]'>Audit</a> </td> ";
	echo "<td> | <a href='viewprojexpdetails.php?proj_id=$rowoper[id]'>Financial Details</a> </td> ";
	echo "<td> | <a href='viewprojrisk.php?proj_id=$rowoper[id]'>Risks</a> </td> ";
	echo "<td> | <a href='viewprojtimebooked.php?proj_id=$rowoper[id]'>Time Booked</a> </td> ";
	if(checkProjectPermission("MASTEREDIT") == true)
	{
        echo "<td> | <a href='mastereditprojdetails.php?proj_id=$rowoper[id]'>Master Edit</a> </td> ";
	}
	echo "</font></tr><br><br>";
closeConnection($conoper);
?>
