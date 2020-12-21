<?php
require_once('common.php');

?>
<!DOCTYPE html>
<html lang="en">

<link rel="shortcut icon" href="favicon.ico">
<head>
	<title>Crux - Project tool</title>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">


	<!-- JQUERY -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


	<!-- BOOTSRTAP -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"/>

	<!-- <link rel="stylesheet" href="script/superhero.css"/> -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<!-- SELECT -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.min.js"></script>

<!-- DATATABLE -->
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.21/kt-2.5.2/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.21/kt-2.5.2/datatables.min.js"></script> -->

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.22/sl-1.3.1/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.22/sl-1.3.1/datatables.min.js"></script>

<!-- X-EDITABLE -->
<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

<!-- LOCAL -->
<script type="text/javascript" src="script/typeahead.bundle.min.js"></script>

<script type="text/javascript" src="script/crux.js"></script>



	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<!-- sweet alert -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

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

.side-by-side {
  display: -webkit-flex;
  display: flex;
  flex-wrap: nowrap; // force buttons not line-break
}



.btn-circle {
  width: 30px;
  height: 30px;
  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.428571429;
  border-radius: 15px;
}
.btn-circle.btn-lg {
  width: 50px;
  height: 50px;
  padding: 10px 16px;
  font-size: 18px;
  line-height: 1.33;
  border-radius: 25px;
}
.btn-circle.btn-xl {
  width: 70px;
  height: 70px;
  padding: 10px 16px;
  font-size: 24px;
  line-height: 1.33;
  border-radius: 35px;
}

.swal2-popup {
  font-size: 1.1rem !important;
}

.top5 { margin-top:5px; }
.top7 { margin-top:7px; }
.top10 { margin-top:10px; }
.top15 { margin-top:15px; }
.top17 { margin-top:17px; }
.top30 { margin-top:30px; }

.bottom5 { margin-bottom:5px; }
.bottom7 { margin-bottom:7px; }
.bottom10 { margin-bottom:10px; }
.bottom15 { margin-bottom:15px; }
.bottom17 { margin-bottom:17px; }
.bottom30 { margin-bottom:30px; }

.right10 { margin-right:10px; }

.right20 { margin-right:20px; }


.left15 { margin-right:10px; }


@media (min-width: 768px) {
    .h-md-100 { height: 100vh; }
}
.btn-round { border-radius: 15px; }
.bg-indigo { background: indigo; }
.text-cyan { color: #35bdff; }


.divborder {
    outline: 1px solid orange;
}

.divborder1 {
    outline: 1px solid blue;
}

.divborder2 {
    outline: 1px solid green;
}

.divborder3 {
    outline: 1px solid black;
}

.no-gutters {
  margin-right: 0;
  margin-left: 0;

  > .col,
  > [class*="col-"] {
    padding-right: 0;
    padding-left: 0;
  }
}

</style>



</head>
