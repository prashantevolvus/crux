<?php
require_once('../dbconn.php');


$con=getConnection();
$sql="
select
milestone, invoice_date, payment_date,invoice_amount
 from opp_invoices a
where 1=1 ".(!empty($_GET["oppid"])  ? "and a.opp_id = ".$_GET["oppid"] : "and a.opp_id = 1");


//echo $sql;

$result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");
$return_arr = array();
$enc_arr = array();
$final_arr=array();
while($row = mysqli_fetch_array($result))
{
   $enc_arr[0] = $row['milestone'];
   $enc_arr[1] = $row['invoice_date'];
   $enc_arr[2] = $row['payment_date'];
   $enc_arr[3] = $row['invoice_amount'];
   $return_arr[]=$enc_arr;


}
$final_arr['data']=$return_arr;

header('Content-Type: application/json');

    echo json_encode($final_arr);
  // echo('
  // {
  // "data":[
  //     [
  //       "M1",
  //       "2020-04-10",
  //       "2020-04-30",
  //       "20000.000"
  //     ],
  //     [
  //       "M2",
  //       "2020-05-10",
  //       "2020-05-30",
  //       "120000.000"
  //     ],
  //     [
  //       "M3",
  //       "2020-06-15",
  //       "2020-06-30",
  //       "120000.000"
  //     ]
  //   ]
  // }');

?>
