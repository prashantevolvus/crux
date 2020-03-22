<?php 
function echoRow($counter)
{
    $allocationPramID = "allocationPram$counter";
    echo '<tr id="rm' . $counter . '">
<td>
<span id="main_head_options' . $counter . '">
<select id = "oh_main_head' . $counter . '" name="oh_main_head[]" onmouseover=getMainheads("main_head_options' . $counter . '") required>
<option value="" selected="selected">Choose..</option>
</select>
</span>
</td>
<td id = "subHead' . $counter . '">
Select any head first
</td>
<td>
<select required id="oh_alloc_basis" name="oh_alloc_basis[]" value="" onchange=getAllocationParam(this.value,"' . $allocationPramID . '") >
<option value="" selected="selected">Choose..</option>
<option value="BL" >Location</option>
<option value="STB" >Salary/Time Booked</option>
<option value="PC" >Profit Center</option>
</select>
</td>
<td>
<div id="' . $allocationPramID . '">Select an Allocation Basis</div>
</td>
<td>
<input  type="number" min="1" step="0.10" placeholder="000000.00" name="oh_amount[]" class="usd_input" required>
</td>
</tr>
';
}
if ($_POST['action'] == 'call_this') {
    echoRow($_POST['counter']);
}
