<?php
session_name("Project");
session_start();
require_once('dbconn.php');
if(isset($_SESSION['user']) && checkUserSession($_SESSION['user']))
{
	header("Location:index.php");
    //header("Location:dashboard.php");
}



?>
<!DOCTYPE html>
<html lang="en">
<link rel="shortcut icon" href="favicon.ico">
<head>
	<title>Crux - Project tool</title>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

 	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.13/datatables.min.css"/>


  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


	<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.13/datatables.min.js"></script>


<style>
.panel-heading {
    padding: 5px 15px;
}

.panel-footer {
	padding: 1px 15px;
	color: #A0A0A0;
}

.profile-img {
	width: 96px;
	height: 96px;
	margin: 0 auto 10px;
	display: block;
	-moz-border-radius: 50%;
	-webkit-border-radius: 50%;
	border-radius: 50%;
}
</style>

</head>
<body>
<div class="container">



<div class="container" style="margin-top:40px">
		<div class="row">
			<div class="col-sm-6 col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong> Sign in to continue</strong>
					</div>
					<div class="panel-body">
						<form role="form" action="checklogin.php" method="POST">
							<fieldset>
								<div class="row">
									<div class="center-block">
										<img class="profile-img"
											src="crux70.png?sz=120" alt="">
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12 col-md-10  col-md-offset-1 ">
										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon">
													<i class="glyphicon glyphicon-user"></i>
												</span>
												<input class="form-control" placeholder="Username" name="myusername" type="text" autofocus>
											</div>
										</div>
										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon">
													<i class="glyphicon glyphicon-lock"></i>
												</span>
												<input class="form-control" placeholder="Password" name="mypassword" type="password" value="">
											</div>
										</div>
										<div class="form-group">
											<input type="submit" class="btn btn-lg btn-primary btn-block" value="Sign in">
										</div>
									</div>
								</div>
							</fieldset>
						</form>
					</div>
</div>
</body>
</html>
