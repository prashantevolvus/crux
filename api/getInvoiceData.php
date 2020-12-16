<?php
require_once('../dbconn.php');

/* Migration
project_details --> ssn_no varchar(10) DEFAULT NULL,

CREATE TABLE cust_details (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  ohrm_customer_id int(11) DEFAULT NULL,
  name_on_invoice varchar(100) DEFAULT NULL,
  to_add1 varchar(100) DEFAULT NULL,
  to_add2 varchar(100) DEFAULT NULL,
  to_add3 varchar(100) DEFAULT NULL,
  ship_add1 varchar(100) DEFAULT NULL,
  ship_add2 varchar(100) DEFAULT NULL,
  ship_add3 varchar(100) DEFAULT NULL,
  trn_no varchar(50) DEFAULT NULL,
  gst_no varchar(50) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

insert into cust_details(ohrm_customer_id,name_on_invoice)
select customer_id , concat('M/S ',name) from hr_mysql_live.ohrm_customer where is_deleted = 0 and (name not like 'PC%' and name not like 'Sales%'
and name not like 'Prod%' and name not like 'Manage%'
)
*/
$fmtID = empty($_GET["formatID"])?1: $_GET["formatID"];
$con=getConnection();
$sql="
select project_details , ssn_no,name_on_invoice,to_add1,to_add2,to_add3,
ship_add1,ship_add2,ship_add3,b.trn_no,b.gst_no, tax1,tax2,tax3,vendor_name,
vendor_add1, vendor_add2, vendor_add3, c.trn_no vendor_trn, c.gst_no vendor_gst
 from
project_details a
join cust_details b on a.ohrm_customer_id = b.ohrm_customer_id
join invoice_format c on c.id = {$fmtID} ";
error_log("hello there 1 ".$sql);

$sql .=" where 1=1  ".(!empty($_GET["projID"])  ? "and a.id = ".$_GET["projID"] : "");

error_log("hello there 2 ".$sql);
//echo $sql;

$result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");
$return_arr = array();
while($row = mysqli_fetch_assoc($result))
{
   $return_arr[] = $row;

}
header('Content-Type: application/json');

    echo json_encode($return_arr);

?>
