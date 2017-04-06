<!
<?php

require_once('dbconn.php');

$searchTerm = strtoupper($_GET['query']);
/*
$customer = strtoupper($_GET['cust']);

$custSQl = "";
if ($customer != "") 
{
    $custSQl = "and o.customer_id = " . $customer;
}
*/
$con = getConnection();
$sql = "
SELECT a1.id , a1.project_name,
       o.name,
       Status,
	   concat(o.name,' ',a1.project_name ) searchValue     
  FROM project_details a1
       INNER JOIN hr_mysql_live.ohrm_customer o
          ON a1.ohrm_customer_id = o.customer_id
          where upper(concat(o.name,a1.project_name,' ' ))
  like '%" . $searchTerm . "%'  order by a1.id desc";
//like '%" . $searchTerm . "%'".$custSQl. " order by a1.id desc";

echo "<script>console.log(' ".$sql." ');</script>";
echo $sql;
$result = mysqli_query($con, $sql . $where) or debug($sql . $where . "   failed  <br/><br/>" . mysql_error());
$return_arr = array();
while ($row = mysqli_fetch_array($result)) {
    $return_arr[] = array(
        'value' => $row['searchValue'],
        'projid' => $row['id'],
        'projname' => $row['project_name'],
        'cust' => $row['name'],
        'status' => $row['Status']
    );
}
//return json data
echo json_encode($return_arr);
?>
