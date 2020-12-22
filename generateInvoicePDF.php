<?php

require_once('dbconn.php');
  $input = json_decode(base64_decode($_POST["q"]));

  $fmt = $_POST["inv_fmt"];
  $con=getConnection();


   $x1 = "";
   $arr = array();
   foreach($input->invList as $invl){
     $sql = "update project_invoice set status = 'INVOICED' where invoice_id = {$invl->id}";
     $result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");
   }
   foreach(explode("$" , $fmt) as $x){
     $y = substr($x,0,2);
     if($y == "TX"){
       $x1 .= explode("#",substr($x,2))[1];
     }
     if($y == "FY"){
       if(date("m") <= 3 ){
         $x1 .=strval(date("y") - 1)."-".strval(date("y"));
       }
       else{
         $x1 .=strval(date("y"))."-".strval(date("y")+1);

       }
     }
     if($y == "RN"){
       $a = explode("#",substr($x,2))[1];

       $sql="
          select seq_no from inc_seq where seq_code = '{$a}'
       ";
       $result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");
       $row = mysqli_fetch_array($result);

       $x1 .= substr("000".strval($row[seq_no]),-3);

       $sql = "update inc_seq set seq_no = seq_no + 1 where seq_code = '{$a}'";
       $result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");
     }

   }


  $input->invNO = $x1 ;
  $_GET["q"] = base64_encode(json_encode($input));
  $xpdf = include "invoice.php";

  echo base64_decode($xpdf);

?>
