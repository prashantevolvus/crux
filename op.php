<?php
session_name("Project");
session_start();
$_SESSION['url'] = $_SERVER['REQUEST_URI'];
require_once('dbconn.php');
require_once('db_inc.php');


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
<!-- <link rel="stylesheet" type="text/css" href="script/jquery.magicsearch.css"> -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  	<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>

	<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.13/datatables.min.js"></script>

	<script type="text/javascript" src="script/typeahead.bundle.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.min.js"></script>
	
<script>
$(".tt-hint").addClass("form-control");
</script>

<style>
/*********** backend solve --sri ***/
.tt-menu {
    overflow: auto;
    height: 400px;
}

.tt-menu {    /* used to be tt-dropdown-menu in older versions */
  width: 422px;
  margin-top: 4px;
  padding: 4px 0;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  -webkit-border-radius: 4px;
     -moz-border-radius: 4px;
          border-radius: 4px;
  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
     -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
          box-shadow: 0 5px 10px rgba(0,0,0,.2);
}


.tt-query {
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
     -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}

.tt-hint {
  color: #999
}

.tt-suggestion {
  padding: 3px 20px;
  line-height: 24px;
}

.tt-suggestion.tt-cursor,.tt-suggestion:hover {
  color: #fff;
  background-color: #0097cf;

}

.twitter-typeahead {
  width: 100%;
}

.input-group .input-group-addon {
     line-height: 1!important;
 }


#custom-templates .empty-message {
  padding: 5px 10px;
 text-align: center;
}


</style>



</head>
<?php
require_once('bodystart.php');
?>

<form>
  <div class="form-row align-items-center">
    <div class="col-auto my-1">
      <label class="mr-sm-2" for="inlineFormCustomSelect">Preference</label>
      <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
        <option selected>Choose...</option>
        <option value="1">One</option>
        <option value="2">Two</option>
        <option value="3">Three</option>
      </select>
    </div>
    <div class="col-auto my-1">
      <div class="custom-control custom-checkbox mr-sm-2">
        <input type="checkbox" class="custom-control-input" id="customControlAutosizing">
        <label class="custom-control-label" for="customControlAutosizing">Remember my preference</label>
      </div>
    </div>
    <div class="col-auto my-1">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </div>
</form>



<?php
//<div id='loader'><img src="images/loader.gif"/></div>
/*


<div class="form-group" id="projDetails" >
	<div class="col-md-5">
  	  <div class="input-group">
  	      	<input id="projid" name="projid" type="input" class="form-control input-md" value="909" disabled >
  	        <input id="projname" name="projname" type="input" class="form-control input-md" disabled >
  	        <input id="cust" name="cust" type="input" class="form-control input-md" disabled >
  	        <input id="status" name="status" type="input" class="form-control input-md" disabled >


  	  </div>
  	</div>

</div>

*/
require_once('bodyend.php');

?>
