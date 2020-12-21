<?php
require_once('../dbconn.php');

/* Migration
project_details -->
  ssn_no varchar(10) DEFAULT NULL,
  ccy_code char(3) DEFAULT NULL,

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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

insert into cust_details(ohrm_customer_id,name_on_invoice)
select customer_id , concat('M/S ',name) from hr_mysql_live.ohrm_customer where is_deleted = 0 and (name not like 'PC%' and name not like 'Sales%'
and name not like 'Prod%' and name not like 'Manage%'
)


CREATE TABLE invoice_format (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  format_name varchar(50) DEFAULT NULL,
  format_desc varchar(500) DEFAULT '',
  tax1 float DEFAULT NULL,
  tax2 float DEFAULT NULL,
  tax3 float DEFAULT NULL,
  vendor_name varchar(50) DEFAULT NULL,
  vendor_add1 varchar(200) DEFAULT NULL,
  vendor_add2 varchar(200) DEFAULT NULL,
  vendor_add3 varchar(200) DEFAULT NULL,
  trn_no varchar(50) DEFAULT NULL,
  gst_no varchar(50) DEFAULT NULL,
  pan_no varchar(50) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO invoice_format (id, format_name, format_desc, tax1, tax2, tax3, vendor_name, vendor_add1, vendor_add2, vendor_add3, trn_no, gst_no, pan_no)
VALUES
	(1, 'India - Karnataka', 'Customer within karnataka for cst and sst', 9, 9, 0, 'M/s. Evolvus Solutions Pvt Ltd,', '#9/36, Vaishanavi Sapphire Centre, ', '2nd Floor, Tumkur Road, Yeshwanthpur, ', 'Karnataka 560022', NULL, '29AABCE7935L1Z4', 'AABCE7935L'),
	(2, 'India - Non Karnataka', 'Customer within karnataka for GST', 18, 9, 0, 'M/s. Evolvus Solutions Pvt Ltd,', '#9/36, Vaishanavi Sapphire Centre, ', '2nd Floor, Tumkur Road, Yeshwanthpur, ', 'Karnatakar 560022', NULL, '29AABCE7935L1Z4', 'AABCE7935L'),
	(3, 'Middle East - UAE', 'For All DMCC based customer within UAE for VAT', 5, 0, 0, 'M/s. Evolvus Solutions Pvt Ltd (DMCC Dubai Branch)', '3902, HDS Business Centre', 'Cluster M, JLT, Dubai UAE', NULL, '100035307600003', NULL, NULL),
	(4, 'Middle East - NON UAE', 'For All DMCC based customer within UAE for VAT', 0, 0, 0, 'M/s. Evolvus Solutions Pvt Ltd (DMCC Dubai Branch)', '3902, HDS Business Centre', 'Cluster M, JLT, Dubai UAE', NULL, '100035307600003', NULL, NULL);

*/
$fmtID = empty($_GET["formatID"])?1: $_GET["formatID"];
$con=getConnection();
$sql="
select project_details , ssn_no,name_on_invoice,to_add1,to_add2,to_add3,
ship_add1,ship_add2,ship_add3,b.trn_no,b.gst_no, tax1,tax2,tax3,vendor_name,
vendor_add1, vendor_add2, vendor_add3, c.trn_no vendor_trn, c.gst_no vendor_gst,
a.ccy_code,pan_no, a1.inv_bank, inv_branch, inv_ifsc, inv_acct_no, inv_iban, inv_swift,
amt_format,inv_no_format
 from
project_details a
join cust_details b on a.ohrm_customer_id = b.ohrm_customer_id
join invoice_format c on c.id = {$fmtID}
left join currency a1 on a.ccy_code = a1.ccy_code
";

$sql .=" where 1=1  ".(!empty($_GET["projID"])  ? "and a.id = ".$_GET["projID"] : "");

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
