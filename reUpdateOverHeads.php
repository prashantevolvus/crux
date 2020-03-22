<?php
$permission = "VIEW";
require_once('common.php');
?>

<?php

require_once('dbconn.php'); 

function updateRecs($rm,$basis,$amt,$param,$id,$mainHead,$userName){
$connection= getConnection();
if(strpos($mainHead, "|") !== false)
$mainHead = explode("|",$mainHead)[1];
$sql = "update project_management.txn_overheads set to_heads='$rm',to_alloc_basis='$basis',to_alloc_param='$param',to_amount=$amt,to_mod_user='$userName',to_auth_sts='0',to_main_heads='$mainHead' where to_id=$id";
if($result = mysqli_query($connection,$sql))
		{
		$_SESSION['message'] = 'Overheads updated successfully';
		}else{
		$_SESSION['message'] = 'Overheads didn\'t update ';
		}


}


if($_POST['action'] == 'UPDATE') {
	updateRecs($_POST['rm'],$_POST['basis'],$_POST['amt'],$_POST['param'],$_POST['id'],$_POST['mainHead'],$_POST['userName']);
}
?>
