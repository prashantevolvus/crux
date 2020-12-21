<?php

$input = json_decode(base64_decode($_POST["q"]));
$input->invNO = $_POST["inv_no"];
$_GET["q"] = base64_encode(json_encode($input));
$x = include "invoice.php";

echo base64_decode($x);

?>
