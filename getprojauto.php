<?php
require_once('dbconn.php');

$searchTerm = strtoupper($_GET['query']);


$con=getConnection();
$sql="
SELECT a1.id , a1.project_name,
       o.name,
       Status,
	   concat(o.name,' ',a1.project_name ) searchValue     
  FROM project_details a1
       INNER JOIN hr_mysql_live.ohrm_customer o
          ON a1.ohrm_customer_id = o.customer_id
          where concat(o.name,a1.project_name,' ' )
like '%".$searchTerm."%' order by a1.id desc";
//echo $sql;
$result = mysqli_query($con,$sql.$where) or debug($sql.$where."   failed  <br/><br/>".mysql_error());
$return_arr = array();
while($row = mysqli_fetch_array($result))
{
	//echo $row['emp_name'];
	//$data[] = array($row['emp_number'],$row['emp_name']);
	  // $row_array['id'] = $row['emp_number'];
       // $row_array['label'] = $row['emp_name'];
	//$data[] = $row['emp_name'];
	//array_push($return_arr,$row_array);
	 $return_arr[] = array (
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
