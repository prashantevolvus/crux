<?php
$permission = "VIEW";
require_once('common.php');
?>
<?php
require_once('dbconn.php');
function authRecs($id, $user)
{
    $connection = getConnection();
    $today = new Datetime();
    $query = "update txn_overheads set to_auth_sts='1',to_auth_usr='$user',to_auth_dt='" . date('Y-m-d H:i:s') . "' where to_id=$id";
    echo $query;
    $result = mysqli_query($connection, $query) or debug($query . " failed  <br/><br/>" . mysql_error());
    closeConnection($connection);
}
if ($_POST['action'] == 'VIEW') {
    authRecs($_POST['id'], $_POST['user']);
}
?> 