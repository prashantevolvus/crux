<?php
session_name("Project");
session_start();
require_once('dbconn.php');

$permission = "VIEW";
//require_once('head.php');

//equire_once('bodystart.php');


?>

<html>
<head>
	<!-- JQUERY -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


  <!-- BOOTSRTAP -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css" />

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

	<script src="https://alcdn.msauth.net/browser/2.7.0/js/msal-browser.js" integrity="sha384-5Fqyq1ncNYhL2mXCdWAFXkf2wWtKeA0mXYp++ryAX1lowD0ctAHFdity37L/ULXh" crossorigin="anonymous"></script>

	<script type="text/javascript" src="./script/authConfig.js"></script>
	<script type="text/javascript" src="./script/authRedirect.js"></script>




	<script type="text/javascript">

	// const myMSALObj = new msal.PublicClientApplication(msalConfig);
	// let username = "";

	function processLogin(response){
	  console.log(response.account.username);

		if(response.account.username){
			$("#before").hide();
			$("#after").show();
			$("#usrName").html(response.account.username);

			$("#after").html('Successfully Loggedin '+response.account.username);
			window.location.replace("checktoken.php?user="+response.account.username);
		}
		else{
			$("#before").show();
			$("#after").hide();
		}

	}

	$(document).ready(function() {

		console.log("before signin");
		signIn() ;
		console.log("after signin");
		setTokenHandler(processLogin);


	});


	</script>
</head>
<body>
<h1>Welcome to Crux</h1>
<div id="usrName"></div>
<div id="before">
Please wait while you will be redirected
</div>

<div id="after" hidden>
Successfully logged in
</div>



<?php

require_once('bodyend.php');

?>
