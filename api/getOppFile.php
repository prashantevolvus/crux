<?php
require_once('../dbconn.php');

$oppid=isset($_GET["oppid"]) ? $_GET["oppid"] : '';
$file=isset($_GET["file"]) ? $_GET["file"] : '';

$con=getConnection();


$sql="
select
file_name,mime_type,file_size, file_content from file_data a
inner join opp_details b on
case
	when '{$file}' = 'estimation' then estimation_sheet
	when '{$file}' = 'proposal' then proposal_doc
end = a.id
where is_deleted = 0 and b.id = {$oppid}
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
