<?php
$permission = "VIEW";
require_once('common.php');
?>
<?php

require_once('dbconn.php');

function valueMap($key)
{
	if ($key == 'BL') {
		return 'Location';
	} elseif ($key == 'STB') {
		return 'Salary/Time Booked';
	} elseif ($key == 'PC') {
		return 'Profit Centre';
	}
}
function htmlData($mon)
{
	$basis = array("BL", "STB", "PC");
	echo "<div style='height:400px;' class='table-responsive'>";
	echo "<form name='editOverHeads' id='editOverHeads' action='editViewOverHeads.php' method='post' enctype='multipart/form-data'>";
	echo "<table id='viewEditOverheads' border='0' style='border-collapse: separate; border-spacing: 10px' class='table-responsive table table-hover table-striped' >";
	$conRs = getConnection();
	$query = "select to_id,to_main_heads,to_heads,
			case 
  			when to_alloc_basis = 'BL' then 'Location'
  			when to_alloc_basis = 'STB' then 'Salary/Time Booked'
  			when to_alloc_basis = 'PC' then 'Profit Centre'
			end as alloc_basis,
			case 
  			when to_alloc_basis = 'BL' then hl.name
  			when to_alloc_basis = 'STB' then 'Not Required'
  			when to_alloc_basis = 'PC' then pc.pc_name
  			end as
			to_alloc_param,
			to_alloc_param as param_value,
			to_amount,
			case
			when to_auth_sts = '0' then 'Not Approved' 
			when to_auth_sts = '1' then 'Approved' 
			end as status,
			to_auth_sts
			from txn_overheads left join profit_centers pc on pc.pc_id=txn_overheads.to_alloc_param left join  hr_mysql_live.ohrm_location hl on hl.id=txn_overheads.to_alloc_param where to_mon_year='$mon' order by to_crtd_dt desc;";
	$result = mysqli_query($conRs, $query) or debug($query . " failed  <br/><br/>" . mysql_error());
	//echo mysqli_num_rows($result);
	if (mysqli_num_rows($result) > 0) {
		$numOfRows = mysqli_num_rows($result);

		echo "<input type ='hidden' name='numOfRows' value='$numOfRows'>";

		echo "<thead>";
		echo "<tr>";
		echo "<th>Edit</th>";
		echo "<th>Heads</th>";
		echo "<th>Sub-Heads</th>";
		echo "<th>Allocation Basis</th>";
		echo "<th>Allocation Param</th>";
		echo "<th>Amount</th>";
		echo "<th>Status</th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
		$rm = 0;
		while ($row = mysqli_fetch_array($result)) {
				$to_id = $row['to_id'];
				$alloc_basis = $row['alloc_basis'];
				$to_alloc_param = $row['to_alloc_param'];
				$param_value = $row['param_value'];
				$to_amount = $row['to_amount'];
				$status = $row['status'];
				$to_auth_sts = $row['to_auth_sts'];
				$to_main_head = $row['to_main_heads'];
				$to_heads = $row['to_heads'];

				echo "<input id='id$rm' disabled='true' type ='hidden' name='to_id[]' value='$to_id'>";
				echo "<tr>";
				echo "<td>";
				echo "<input id='editChktag$rm' type ='checkbox' value='$to_id'>";
				echo "</td>";
				echo "<td id='moh$rm' >
			<select id='mh$rm' name='to_main_heads[]' onclick=eventBinderForMainOverhead('moh$rm',event) value='$to_main_head' disabled  >
			<option value='$to_main_head' selected='selected'>$to_main_head</option> </select></td>";
				//echo "<td><input id='mh$rm' type ='text' name='to_main_heads[]' style='text-align:center;' value='$to_main_head' onkeyup=showSuggestionHead(this.id); required disabled=true><td>";
				echo "<td id='subHead$rm'>";
				echo "<select id='rm$rm' name='oh_name[]' value='' required disabled>";
				echo "<option value='$to_heads' selected='selected'>$to_heads</option>";
				echo "</select>";
				# echo "<input id='rm$rm' type ='text' name='to_heads[]' style='text-align:center;' value='$to_heads' onkeyup=showSuggestionHead(this.id); required disabled=true>";
				echo "</td>";

				echo "<td>";

				echo "<select id ='basis$rm' name='alloc_basis[]' required value=''disabled onfocus=getAllocationParam(this.value,$rm) onchange=getAllocationParam(this.value,$rm)>";
				echo "<option value='' selected='selected'>Choose..</option>";
				foreach ($basis as $value) {
					echo valueMap($value);
					if ($alloc_basis == valueMap($value)) {
						echo "<option value='$value' selected='selected' >" . valueMap($value) . "</option>";
					} else {
						echo "<option value='$value' >" . valueMap($value) . "</option>";
					}
				}
				echo "</select>";
				echo "</td>";

				echo "<td id='drop$rm'>";

				echo "<div id='replace$rm'><select id ='param$rm' name='oh_alloc_param[]' required disabled>";
				echo "<option value='$param_value' selected='selected'>$to_alloc_param</option>";
				echo "</select></div>";
				echo "</td>";
				echo "</td>";

				echo "<td>";

				echo "<input id='amt$rm' type ='text' style='text-align:right;' name='to_amount[]' value='$to_amount' required disabled>";
				echo "</td>";

				echo "<td id='status$rm'>";
				echo "<label for='chktag$rm' id = 'lab$rm' style='word-wrap:nowrap'>";


				if (strcmp($to_auth_sts, "1")) {
					echo "<input id='chktag$rm' type ='checkbox' value='$to_id'>";
				}
				echo " $status ";


				echo "</label>";

				echo "</td>";
				echo "</tr>";
				echo "</tbody>";
				++$rm;
			}
	} else {
		echo "<thead>";
		echo "</thead>";
		echo "<tbody>";
		echo "<tr>";
		echo "<td>";
		echo "No Data is present for the given month";
		echo "</td>";
		echo "</tr>";
		echo "</tbody>";
	}

	closeConnection($conRs);

	echo "</table>";
	echo "</form>";
	echo "</div>";
}
if ($_POST['action'] == 'VIEW') {
	htmlData($_POST['mon']);
}
?> 
