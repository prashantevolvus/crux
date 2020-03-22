<?php
require_once '../PHPWord.php';
$PHPWord = new PHPWord();
require_once '../google/src/Google/Client.php';
require_once '../google/src/Google/Service/Drive.php';

$document = $PHPWord->loadTemplate('Template.docx');
$document->setValue('Value1', 'Sun');
$document->setValue('Value2', 'Mercury');
$document->setValue('Value3', 'Venus');
$document->setValue('Value4', 'Earth');
$document->setValue('Value5', 'Mars');
$document->setValue('Value6', 'Jupiter');
$document->setValue('Value7', 'Saturn');
$document->setValue('Value8', 'Uranus');
$document->setValue('Value9', 'Neptun');
$document->setValue('Value10', 'Pluto');

$document->setValue('weekday', date('l'));
$document->setValue('time', date('H:i'));
$document->save('Solarsystem.docx');

/*
header("Cache-Control: public");     
header("Content-Description: File Transfer");     
header("Content-Disposition: attachment; filename=Solarsystem.docx");
header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");     
header("Content-Transfer-Encoding: binary");         

readfile('Solarsystem.docx'); 
*/


$client = new Google_Client();
// Get your credentials from the console
$client->setClientId('<YOUR_CLIENT_ID>');
$client->setClientSecret('<YOUR_CLIENT_SECRET>');
$client->setRedirectUri('<YOUR_REGISTERED_REDIRECT_URI>'); 
$client->setScopes(array('https://www.googleapis.com/auth/drive.file'));

session_start();

if (isset($_GET['code']) || (isset($_SESSION['access_token']) && $_SESSION['access_token'])) {
    if (isset($_GET['code'])) {
        $client->authenticate($_GET['code']);
        $_SESSION['access_token'] = $client->getAccessToken();
    } else
        $client->setAccessToken($_SESSION['access_token']);

    $service = new Google_Service_Drive($client);

    //Insert a file
    $file = new Google_Service_Drive_DriveFile();
    $file->setTitle(uniqid().'.jpg');
    $file->setDescription('A test document');
    $file->setMimeType('image/jpeg');

    $data = file_get_contents('a.jpg');

    $createdFile = $service->files->insert($file, array(
          'data' => $data,
          'mimeType' => 'image/jpeg',
          'uploadType' => 'multipart'
        ));

    print_r($createdFile);

} else {
    $authUrl = $client->createAuthUrl();
    header('Location: ' . $authUrl);
    exit();
}
		exit;
?>