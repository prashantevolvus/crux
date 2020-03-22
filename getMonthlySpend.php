<?php
session_name("Project");
session_start();
setlocale(LC_MONETARY, 'en_IN');

require_once 'dbconn.php';
if(!checkUserSession($_SESSION["user"]))
{
        echo "<script>window.top.location.href='login.php'</script>";
        //header("Location:login.php");
}

$q=$_GET["q"];
$rep=$_GET["rep"];

$con=getConnection();
//$sql="select license_val, base_labour_cost,UnitLabourCost , budget , contract, received, budget_to_go ,excess_budget, cashflow,expense_cost from project_summary where project_id = (select ohrm_project_id from project_details where id = ".$q.")";
/*
$sql="
select project_id, Project,report_month,sum(cost) labour_cost,sum(a.expense_amt) expense_amt , 
sum(cost) +sum(a.expense_amt) total_cost from monthly_timesheet a 
left join project_details b on b.ohrm_project_id = a.project_id 
where DATE_ADD(report_month, INTERVAL 12 MONTH) > now() and b.id = ".$q.
 " group by project_id, Project,report_month order by report_month desc" ;
*/

$sql="
SET @runtotcost:=0,@runpaid:=0;
select * from 
(
	select id, Project,base_date, labour_cost, expense_amt, total_cost, m_paid_amt,
 		(@runtotcost := @runtotcost + X.total_cost) run_cost,  (@runpaid := @runpaid + X.m_paid_amt) run_paid , 
 		(@runpaid - @runtotcost) cashflow
 	from 
 	(
		select b.id,project , base_date ,
			sum(ifnull(unifiedcost,0)-ifnull(c.expense_amt,0)) labour_cost,sum(ifnull(c.expense_amt,0)) expense_amt , 
			sum(ifnull(unifiedcost,0)-ifnull(c.expense_amt,0)) +sum(ifnull(c.expense_amt,0)) total_cost,
			max(ifnull(paid_amt,0)) m_paid_amt
		from 
		months a
		inner join project_details b on b.id = ".$q." and base_date between (actual_start_date - INTERVAL DAYOFMONTH(actual_start_date)-1 DAY) and
			(last_day(current_date)+1)
		left join monthly_timesheet c on b.ohrm_project_id = c.project_id and base_date = report_month
		left join
		(
			select project_id , (lcy_cr_date - interval(dayofmonth(lcy_cr_date)-1) day) inv_date,
			sum(lcy_cr_amount) paid_amt from 
			project_invoice x
			where x.status = 'PAID' and dateformat(lcy_cr_date) is not null 
			group by project_id ,  (lcy_cr_date - interval(dayofmonth(lcy_cr_date)-1) day)
		) d on b.id = d.project_id and base_date = inv_date
		where report_month is not null or inv_date is not null
		group by  b.id,project , base_date 
		order by base_date
	)X
) Y 
order by base_date desc


";





echo "<table class='gridtable'  id='spendlist' name='spendlist'>";
echo "<br><thead><tr>";


echo "<th><b>Month</b></th>";
echo "<th><b>Total Labour Cost</b></th>";
echo "<th><b>Expense</b></th>";
echo "<th><b>Total Cost</b></th>";
echo "<th><b>Amount Received</b></th>";
echo "<th><b>Cumulative Cost</b></th>";
echo "<th><b>Cumulative Received</b></th>";
echo "<th><b>Cashflow</b></th>";
	
echo "</tr></thead><tbody>";


if(mysqli_multi_query($con,$sql))
{

	do 
	{
        /* store first result set */
        if ($result = mysqli_use_result($con)) 
        {
            while ($row = mysqli_fetch_row($result)) 
            {
                echo "<tr>";
		
				$dt = date("F-o", strtotime($row[2]));
				echo "<td>$dt</td>";
	
				$amt=money_format('%!.0n', $row[3]);
	    		echo "<td align='right'>$amt</td>";
    
    			$amt=money_format('%!.0n', $row[4]);
	    		echo "<td align='right'>$amt</td>";
    
    			$amt=money_format('%!.0n', $row[5]);
	    		echo "<td align='right'>$amt</td>";
	    		
	    		$amt=money_format('%!.0n', $row[6]);
	    		echo "<td align='right'>$amt</td>";
	    		
	    		$amt=money_format('%!.0n', $row[7]);
	    		echo "<td align='right'>$amt</td>";
	    		
	    		$amt=money_format('%!.0n', $row[8]);
	    		echo "<td align='right'>$amt</td>";
	    		
	    		$amt=money_format('%!.0n', $row[9]);
	    		echo "<td align='right'>$amt</td>";
    
    			echo "</tr>";
            }
            mysqli_free_result($result);
        }
        /* print divider */
        if (mysqli_more_results($con)) {
            
        }
    } while (mysqli_next_result($con));
	
}
else 
{
	debug($sql."<br/><br/>".mysql_error());
}


/*
	
$resultChk = mysqli_use_result($con);

if($resultChk == FALSE)
	die('FAILED 2');

if(mysqli_more_results($con) == FALSE)
	die('FAILED 3');
	
	$result = mysqli_use_result($con);


	while($row = mysqli_fetch_array($result))
	{
		echo "<tr>";
		
		$dt = date("F-o", strtotime($row[report_month]));
		echo "<td>$dt</td>";
	
		$amt=money_format('%!.0n', $row[labour_cost]);
	    echo "<td align='right'>$amt</td>";
    
    	$amt=money_format('%!.0n', $row[expense_amt]);
	    echo "<td align='right'>$amt</td>";
    
    	$amt=money_format('%!.0n', $row[total_cost]);
	    echo "<td align='right'>$amt</td>";
    
    	echo "</tr>";
	}
}
 */
echo "</tbody></table>";
