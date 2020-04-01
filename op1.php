

<!DOCTYPE html>
<html lang="en">

<link rel="shortcut icon" href="favicon.ico">
<head>
	<title>Crux - Project tool</title>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

 	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.13/datatables.min.css"/>
	<link rel="stylesheet" https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/css/bootstrapValidator.css"/>


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

<body>
	<div class="container">
	<div class="row">
	  <form role="form">
        <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
        </div>
        <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Name">
        </div>
        <div class="clearfix"></div>
        <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
        </div>
        <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
            <label for="exampleInputPassword1">Confirm Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Confirm Password">
        </div>
        <div class="clearfix"></div>
        <div class="form-group col-xs-10 col-sm-10 col-md-4 col-lg-4">
            <label for="exampleInputFile">File input</label>
            <input type="file" id="exampleInputFile">
            <p class="help-block">Example block-level help text here.</p>
        </div>
        <div class="col-xs-10 col-sm-10 col-md-4 col-lg-4">
            <label>
                <input type="radio"> Check me out<input type="radio"> Check me out<input type="radio"> Check me out
            </label>
        </div>
        <div class="clearfix"></div>
        <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
            <button type="submit" class="btn btn-default">Submit</button>
        </div>
    </form>
    <div class="clearfix"></div>

    <br /><br />
	</div>
</div>
<div class="container">


	<form class="form-horizontal">
	<fieldset>

	<!-- Form Name -->
	<legend>Search Opportunities</legend>



	<!-- Select Multiple -->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="status">Status</label>
	  <div class="col-md-4">
	    <select id="status" name="status" class="form-control" multiple="multiple">
	      <option value="All">All</option>
	      <option value="Hot Prospect">Hot Prospect</option>
	      <option value="Prospect">Prospect</option>
	      <option value="Suspect">Suspect</option>
	      <option value="Lead">Lead</option>
	      <option value="Won">Won</option>
	      <option value="Lost">Lost</option>
	    </select>
	  </div>
	</div>

	<!-- Multiple Checkboxes -->
	<div class="form-group">
		<label class="col-md-4 control-label" for="Active"></label>
		<div class="col-md-4">
		<div class="checkbox">
			<label for="Active-0">
				<input type="checkbox" name="Active" id="Active-0" value="1">
				Active
			</label>
		</div>
		</div>
	</div>

	<!-- Button -->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="singlebutton"></label>
	  <div class="col-md-4">
	    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Submit</button>
	  </div>
	</div>

	</fieldset>
	</form>



	<form>
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationServer013">First name</label>
      <input type="text" class="form-control is-valid" id="validationServer013" placeholder="First name"
        value="Mark" required>
      <div class="valid-feedback">
        Looks good!
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationServer023">Last name</label>
      <input type="text" class="form-control is-valid" id="validationServer023" placeholder="Last name"
        value="Otto" required>
      <div class="valid-feedback">
        Looks good!
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationServerUsername33">Username</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text" id="inputGroupPrepend33">@</span>
        </div>
        <input type="text" class="form-control is-invalid" id="validationServerUsername33" placeholder="Username"
          aria-describedby="inputGroupPrepend33" required>
        <div class="invalid-feedback">
          Please choose a username.
        </div>
      </div>
    </div>
  </div>
  <div class="form-row">
    <div class="col-md-6 mb-3">
      <label for="validationServer033">City</label>
      <input type="text" class="form-control is-invalid" id="validationServer033" placeholder="City"
        required>
      <div class="invalid-feedback">
        Please provide a valid city.
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <label for="validationServer043">State</label>
      <input type="text" class="form-control is-invalid" id="validationServer043" placeholder="State"
        required>
      <div class="invalid-feedback">
        Please provide a valid state.
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <label for="validationServer053">Zip</label>
      <input type="text" class="form-control is-invalid" id="validationServer053" placeholder="Zip"
        required>
      <div class="invalid-feedback">
        Please provide a valid zip.
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input is-invalid" id="invalidCheck33" required>
      <label class="custom-control-label" for="invalidCheck33">Agree to terms and conditions</label>
      <div class="invalid-feedback">
        You must agree before submitting.
      </div>
    </div>
    <div class="invalid-feedback">
      You must agree before submitting.
    </div>
  </div>
  <button class="btn btn-primary" type="submit">Submit form</button>
</form>

</div>
</body>
</html>
