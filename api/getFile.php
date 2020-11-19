<?php
require_once('../dbconn.php');

$fileid=isset($_GET["fileid"]) ? $_GET["fileid"] : '';

$con=getConnection();


$sql="
select
file_name,mime_type,file_size, file_content from file_data a
where a.id = {$fileid}
";



$result = mysqli_query($con,$sql) or debug($sql."   failed  <br/><br/>");

list($filename, $type,$size, $content) = mysqli_fetch_array($result);

if(empty($filename)){
  die;

}


header("Content-length: $size");
header("Content-type: $type");
header("Content-Disposition: attachment; filename=$filename");
ob_clean();
flush();
echo $content;

?>
