<?php
require_once('../dbconn.php');



$con=getConnection();

if($_GET["type"] == "EXP")//Company Expense Type
  $sql="select expense_id id, expense_type value from expense_type o ";

if($_GET["type"] == "RGNGRP")//Region Group
    $sql="select id, region_grp value from cgl_region_grp o ";

if($_GET["type"] == "RGN")//Region
    $sql="select id, region_name value from opp_region o ";

if($_GET["type"] == "PNL")//PNL Line item
    $sql="select id, pnl_desc value from cgl_pnl_line o ";

if($_GET["type"] == "PC")//Profit Centre
    $sql="select pc_id id, pc_name value from profit_centers o ";


//echo $sql;

$result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");
$return_arr = array();
while($row = mysqli_fetch_array($result))
{
   $row_array['value'] = $row['id'];
   $row_array['text'] = $row['value'];
   array_push($return_arr,$row_array);
}
header('Content-Type: application/json');

    echo json_encode($return_arr);

?>
