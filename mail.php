<?php
require_once('dbconn.php');
 
require('db_inc.php');
require_once('phpmailer/phpmailer.php');

//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail             = new PHPMailer();
$body             =file_get_contents('mail_templ.html');
$body             = eregi_replace("[\]",'',$body);
$body             = eregi_replace("%PROJNAME%",$_GET['projname'],$body);
$body             = eregi_replace("%CUSTNAME%",$_GET['custname'],$body);
$body             = eregi_replace("%EMPNAME%",$_GET['empname'],$body);
$body             = eregi_replace("%STATUSCHG%",$_GET['statuschg'],$body);
$body             = eregi_replace("%PREVSTATUSCHG%",$_GET['prevstatuschg'],$body);
$body             = eregi_replace("%PROJID%",$_GET['projid1'],$body);
$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host       = $mail_host; // SMTP server
$mail->SMTPSecure = $mail_secure;
$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->Port       = $mail_port;                    // set the SMTP port for the GMAIL server
$mail->Username   = $mail_from; // SMTP account username
$mail->Password   = $mail_pass;        // SMTP account password

$mail->SetFrom($mail_from, 'Project Management');

$mail->AddReplyTo($mail_from,"noreply");

$mail->Subject    = "Update to Project ".$_GET['projname'];

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($body);
$x=$_GET["emails"];
$values = explode(",", $x.$mail_default_addr);
$val=count($values);
for ($i = 0; $i < $val; $i++) {
	if($values[$i] != "")
	{
		$mail->AddAddress($values[$i]);
	}
}
if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
}

?>
