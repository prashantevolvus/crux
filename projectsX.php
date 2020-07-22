<?php
$permission = "VIEW";
require_once('head.php');

require_once('bodystart.php');
?>

<script>

//Retrieve and set DATA
var supList = new Bloodhound({
  	datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
  	queryTokenizer: Bloodhound.tokenizers.whitespace,
  	prefetch: 'getprojauto.php',
  	remote: {
    	url: 'getprojauto.php?query=%QUERY',
    	wildcard: '%QUERY'
  	}
});

//Autocomplete for Project Search
$(document).ready(function() {

  $("#proj-info").hide();

  $('#1B1').editable({
    type: 'select',
    sourceCache: false,
    pk: 0,
    value: '',
    title: "Enter Project Type",
    source: 'api/getProjectTypeList.php'
  });

  $('#1B1').editable('option', 'disabled', true);

  $('#3B1').editable({
    type: 'select',
    sourceCache: false,
    pk: 0,
    value: '',
    title: "Enter Customer Name",
    source: 'api/getCustomerList.php',
    success: function(response, newValue) {
      cust = newValue;
      //
      // setTimeout(function() {
      //   $('#1B3B').editable('show');
      // }, 200);
    }
  });

  $('#3B1').editable('option', 'disabled', true);


  //Opportunity Name
  $('#2B1').editable({
    sourceCache: false,
    pk: 0,
    value: '',
    title: "Enter Project Name",
    validate: function(value) {
      if ($.trim(value) == '') {
        return 'This field is required';
      }
    }
  });

  $('#2B1').editable('option', 'disabled', true);


  $('#5B1').editable({
    type: 'select',
    sourceCache: false,
    pk: 0,
    value: '',
    title: "Enter Project Status",
    source:['ACTIVE','CLOSED','WARRANTY','DELIVERED','INITIATED','AUTHORISED','APPROVED','DELETED','DEACTIVATED','INITIATE CLOSURE','AUTHORISE CLOSURE','PENDING INVOICE'],
    validate: function(value) {
      if ($.trim(value) == '') {
        return 'This field is required';
      }
    }
  });

  $('#5B1').editable('option', 'disabled', true);


  $('#1B2').editable({
    type: 'select',
    sourceCache: false,
    pk: 0,
    value: '',
    title: "Enter Profit Centre",
    source: 'api/getProfitCentre.php'
  });

  $('#1B2').editable('option', 'disabled', true);

  $('#2B2').editable({
    type: 'select',
    sourceCache: false,
    pk: 0,
    value: '',
    title: "Enter Product",
    source: 'api/getProductList.php'
  });

  $('#2B2').editable('option', 'disabled', true);

  $('#3B2').editable({
    type: 'select',
    sourceCache: false,
    pk: 0,
    value: '',
    title: "Enter Project Manager",
    source: 'api/getEmpList.php'
  });

  $('#3B2').editable('option', 'disabled', true);

  $('#4B2').editable({
    type: 'select',
    sourceCache: false,
    pk: 0,
    value: '',
    title: "Enter Project Director",
    source: 'api/getEmpList.php'
  });

  $('#4B2').editable('option', 'disabled', true);

  $('#5B2').editable({
    type: 'select',
    sourceCache: false,
    pk: 0,
    value: '',
    title: "Enter Reporting Period",
    source: ['WEEKLY','FORTNIGHTLY','MONTHLY','QUARTERLY']
  });

  $('#5B2').editable('option', 'disabled', true);

  $('#1B3').editable({
    type: 'date',
    sourceCache: false,
    pk: 0,
    value: '',
    title: "Enter Planned Start Date",
    placement: 'right',
    datepicker: {
      weekStart: 1
    },
    validate: function(value) {
      if ($.trim(value) == '') {
        return 'This field is required';
      }
    }
  });

  $('#1B3').editable('option', 'disabled', true);

  $('#2B3').editable({
    type: 'date',
    sourceCache: false,
    pk: 0,
    value: '',
    title: "Enter Planned End Date",
    placement: 'right',
    datepicker: {
      weekStart: 1
    },
    validate: function(value) {
      if ($.trim(value) == '') {
        return 'This field is required';
      }
    }
  });

  $('#2B3').editable('option', 'disabled', true);


  $('#3B3').editable({
    type: 'date',
    sourceCache: false,
    pk: 0,
    value: '',
    title: "Enter Actual Start Date",
    placement: 'right',
    datepicker: {
      weekStart: 1
    },
    validate: function(value) {
      if ($.trim(value) == '') {
        return 'This field is required';
      }
    }
  });

  $('#3B3').editable('option', 'disabled', true);

  $('#4B3').editable({
    type: 'date',
    sourceCache: false,
    pk: 0,
    value: '',
    title: "Enter Actual End Date",
    placement: 'right',
    datepicker: {
      weekStart: 1
    },
    validate: function(value) {
      if ($.trim(value) == '') {
        return 'This field is required';
      }
    }
  });

  $('#4B3').editable('option', 'disabled', true);

  $('#4B1').editable({
    type: 'select',
    sourceCache: false,
    pk: 0,
    value: '',
    title: "Enter Region Type",
    source: 'api/getRegionList.php'
  });

  $('#4B1').editable('option', 'disabled', true);

  $('#5B3').editable({
    type: 'number',
    sourceCache: false,
    pk: 0,
    value: '',
    title: "Enter Extension in Days",
    placement: 'right',
    validate: function(value) {
      if ($.trim(value) == '') {
        return 'This field is required';
      }
    }
  });

  $('#5B3').editable('option', 'disabled', true);

  $('#G1B1').editable({
    type: 'textarea',
    sourceCache: false,
    pk: 0,
    value: '',
    title: "Enter Project Details",
    placement: 'right',
    datepicker: {
      weekStart: 1
    },
    validate: function(value) {
      if ($.trim(value) == '') {
        return 'This field is required';
      }
    }
  });

  $('#G1B2').editable({
    type: 'textarea',
    sourceCache: false,
    pk: 0,
    value: '',
    title: "Enter Project Scope",
    placement: 'right',
    datepicker: {
      weekStart: 1
    },
    validate: function(value) {
      if ($.trim(value) == '') {
        return 'This field is required';
      }
    }
  });

  $('#G2B1').editable({
    type: 'textarea',
    sourceCache: false,
    pk: 0,
    value: '',
    title: "Enter Project Objectives",
    placement: 'right',
    datepicker: {
      weekStart: 1
    },
    validate: function(value) {
      if ($.trim(value) == '') {
        return 'This field is required';
      }
    }
  });

  $('#G2B2').editable({
    type: 'textarea',
    sourceCache: false,
    pk: 0,
    value: '',
    title: "Enter Success Factor",
    placement: 'right',
    datepicker: {
      weekStart: 1
    },
    validate: function(value) {
      if ($.trim(value) == '') {
        return 'This field is required';
      }
    }
  });

	$('#projSearch .typeahead').typeahead(null,{
    	display: 'projname',
 		highlight: true,
 		minLength: 1,
  		source: supList,
  		templates: {
    		empty: [
      					'<div class="empty-message">',
        					'No Project Found',
      					'</div>'
    		].join('\n'),
    		suggestion: function(data) {
    			return '<p>'+data.cust + ' : <strong>' + data.projname + '</strong> – ' +  ' [Status : ' + data.status+']</p>';
			}
  		}
	}).bind('typeahead:selected', function(obj, datum, name) {
            	console.log("selected");
				populateForm(datum.projid);
				//alert( "http://www.evolvus.com/project/viewprojdetails.php?proj_id="+datum.projid);
				//window.location  = "viewprojdetails.php?proj_id="+datum.projid;
	});
})



function populateForm(projid){
	// grab the correct input and output elements
  console.log("selected "+projid);
  $("#proj-info").show();
	var url = "api/getProject.php?projid="+projid ;
	var dataJSON = "";

  $.getJSON(url , function(data) {
    console.log(data[0]['project_name']);


    $('#1B1').editable('setValue',data[0]['project_type_id']);
    $('#1B1').editable('option', 'pk', projid);

    $('#3B1').editable('setValue',data[0]['customer_id']);
    $('#3B1').editable('option', 'pk', projid);

    $('#4B1').editable('setValue',data[0]['region_id']);
    $('#4B1').editable('option', 'pk', projid);

    $('#2B1').editable('setValue',data[0]['project_name']);
    $('#2B1').editable('option', 'pk', projid);

    $('#5B1').editable('setValue',data[0]['status']);
    $('#5B1').editable('option', 'pk', projid);

    $('#1B2').editable('setValue',data[0]['profit_centre_id']);
    $('#1B2').editable('option', 'pk', projid);

    $('#2B2').editable('setValue',data[0]['base_product']);
    $('#2B2').editable('option', 'pk', projid);

    $('#3B2').editable('setValue',data[0]['project_manager_id']);
    $('#3B2').editable('option', 'pk', projid);

    $('#4B2').editable('setValue',data[0]['project_director_id']);
    $('#4B2').editable('option', 'pk', projid);

    $('#5B2').editable('setValue',data[0]['report_type']);
    $('#5B2').editable('option', 'pk', projid);

    $('#1B3').editable('setValue',data[0]['planned_start_date'],true);
     $('#1B3').editable('option', 'pk', projid);
    //
    $('#2B3').editable('setValue',data[0]['planned_end_date'],true);
    $('#2B3').editable('option', 'pk', projid);

    $('#3B3').editable('setValue',data[0]['actual_start_date'],true);
     $('#3B3').editable('option', 'pk', projid);
    //
    $('#4B3').editable('setValue',data[0]['actual_end_date'],true);
    $('#4B3').editable('option', 'pk', projid);

    $('#5B3').editable('setValue',data[0]['extension']);
    $('#5B3').editable('option', 'pk', projid);

    $('#G1B1').editable('setValue',data[0]['project_details']);
    $('#G1B1').editable('option', 'pk', projid);

    $('#G2B1').editable('setValue',data[0]['objectives']);
    $('#G2B1').editable('option', 'pk', projid);

    $('#G1B2').editable('setValue',data[0]['scope']);
    $('#G1B2').editable('option', 'pk', projid);

    $('#G2B2').editable('setValue',data[0]['success_factor']);
    $('#G2B2').editable('option', 'pk', projid);

    totalRevenue =
      parseFloat(data[0]['invoice_pending_lcy_amt']) +
      parseFloat(data[0]['invoiced_lcy_amt']) +
      parseFloat(data[0]['received_lcy_amt']);

    totalBudgetApproved =
        parseFloat(data[0]['budget_approved']) +
        parseFloat(data[0]['excess_budget_approved']);

    totalExpense =
        parseFloat(data[0]['unified_labour_cost']) +
        parseFloat(data[0]['expense_amt']);



    $('#F1B1').html(amtFormat(data[0]['Contract_value']));
    $('#F2B1').html(amtFormat(data[0]['cr_amt']));
    $('#F3B1').html(amtFormat(parseFloat(data[0]['Contract_value']) + parseFloat(data[0]['cr_amt'])));

    $('#F1B2').html(amtFormat(data[0]['budget_initiated']));
    $('#F2B2').html(amtFormat(data[0]['excess_budget_initiated']));
    $('#F3B2').html(amtFormat(parseFloat(data[0]['budget_initiated']) + parseFloat(data[0]['excess_budget_initiated'])));

    $('#F1B3').html(amtFormat(data[0]['budget_approved']));
    $('#F2B3').html(amtFormat(data[0]['excess_budget_approved']));
    $('#F3B3').html(amtFormat(totalBudgetApproved));

    $('#F1B4').html(amtFormat(data[0]['base_labour_cost']));
    $('#F2B4').html(amtFormat(data[0]['unified_labour_cost']));
    $('#F3B4').html(amtFormat(data[0]['expense_amt']));
    $('#F4B4').html(amtFormat(totalExpense));

    $('#F1B5').html(amtFormat(totalRevenue));
    $('#F2B5').html(amtFormat(data[0]['invoice_pending_lcy_amt']));
    $('#F3B5').html(amtFormat(data[0]['invoiced_lcy_amt']));
    $('#F4B5').html(amtFormat(data[0]['received_lcy_amt']));


    $('#F1B6').html(amtFormat(totalBudgetApproved-totalExpense));
    $('#F2B6').html(amtFormat(parseFloat(data[0]['received_lcy_amt'])-totalExpense));
    $('#F3B6').html(amtFormat(totalRevenue - totalExpense));
    $('#F4B6').html( amtFormat(100*(totalRevenue-totalExpense)/totalRevenue)+"%");


    if(100*(totalRevenue-totalExpense)  < 0.0) {
      $('#F3A6').addClass('alert alert-danger');
      $('#F3B6').addClass('alert alert-danger');

      $('#F3A6').removeClass('alert alert-warning');
      $('#F3B6').removeClass('alert alert-warning');

      $('#F3A6').removeClass('alert alert-success');
      $('#F3B6').removeClass('alert alert-success');
    }
    else if (100*(totalRevenue-totalExpense)/totalRevenue < 50.0) {
      $('#F3A6').addClass('alert alert-warning');
      $('#F3B6').addClass('alert alert-warning');

      $('#F3A6').removeClass('alert alert-success');
      $('#F3B6').removeClass('alert alert-success');

      $('#F3A6').removeClass('alert alert-danger');
      $('#F3B6').removeClass('alert alert-danger');

    }
    else {
      $('#F3A6').addClass('alert alert-success');
      $('#F3B6').addClass('alert alert-success');

      $('#F3A6').removeClass('alert alert-warning');
      $('#F3B6').removeClass('alert alert-warning');

      $('#F3A6').removeClass('alert alert-danger');
      $('#F3B6').removeClass('alert alert-danger');
    }

    if(100*(totalRevenue-totalExpense)/totalRevenue < 40.0) {
      $('#F4A6').addClass('alert alert-danger');
      $('#F4B6').addClass('alert alert-danger');

      $('#F4A6').removeClass('alert alert-warning');
      $('#F4B6').removeClass('alert alert-warning');

      $('#F4A6').removeClass('alert alert-success');
      $('#F4B6').removeClass('alert alert-success');
    }
    else if (100*(totalRevenue-totalExpense)/totalRevenue < 50.0) {
      $('#F4A6').addClass('alert alert-warning');
      $('#F4B6').addClass('alert alert-warning');

      $('#F4A6').removeClass('alert alert-danger');
      $('#F4B6').removeClass('alert alert-danger');

      $('#F4A6').removeClass('alert alert-success');
      $('#F4B6').removeClass('alert alert-success');
    }
    else {
      $('#F4A6').addClass('alert alert-success');
      $('#F4B6').addClass('alert alert-success');

      $('#F4A6').removeClass('alert alert-danger');
      $('#F4B6').removeClass('alert alert-danger');

      $('#F4A6').removeClass('alert alert-warning');
      $('#F4B6').removeClass('alert alert-warning');
    }

    if(parseFloat(data[0]['received_lcy_amt'])-totalExpense < 0) {
      $('#F2A6').addClass('alert alert-danger');
      $('#F2B6').addClass('alert alert-danger');

      $('#F2A6').removeClass('alert alert-success');
      $('#F2B6').removeClass('alert alert-success');

      $('#F2A6').removeClass('alert alert-warning');
      $('#F2B6').removeClass('alert alert-warning');
    }
    else if (100*(data[0]['received_lcy_amt']-totalExpense)/data[0]['received_lcy_amt'] < 10.0) {
      $('#F2A6').addClass('alert alert-warning');
      $('#F2B6').addClass('alert alert-warning');

      $('#F2A6').removeClass('alert alert-success');
      $('#F2B6').removeClass('alert alert-success');

      $('#F2A6').removeClass('alert alert-danger');
      $('#F2B6').removeClass('alert alert-danger');
    }
    else {
      $('#F2A6').addClass('alert alert-success');
      $('#F2B6').addClass('alert alert-success');

      $('#F2A6').removeClass('alert alert-warning');
      $('#F2B6').removeClass('alert alert-warning');

      $('#F2A6').removeClass('alert alert-danger');
      $('#F2B6').removeClass('alert alert-danger');
    }

    if(100*(totalBudgetApproved-totalExpense)/totalBudgetApproved < 0) {
      $('#F1A6').addClass('alert alert-danger');
      $('#F1B6').addClass('alert alert-danger');

      $('#F1A6').removeClass('alert alert-warning');
      $('#F1B6').removeClass('alert alert-warning');

      $('#F1A6').removeClass('alert alert-success');
      $('#F1B6').removeClass('alert alert-success');
    }
    else if (100*(totalBudgetApproved-totalExpense)/totalBudgetApproved < 10.0) {
      $('#F1A6').addClass('alert alert-warning');
      $('#F1B6').addClass('alert alert-warning');

      $('#F1A6').removeClass('alert alert-danger');
      $('#F1B6').removeClass('alert alert-danger');

      $('#F1A6').removeClass('alert alert-success');
      $('#F1B6').removeClass('alert alert-success');
    }
    else {
      $('#F1A6').addClass('alert alert-success');
      $('#F1B6').addClass('alert alert-success');

      $('#F1A6').removeClass('alert alert-danger');
      $('#F1B6').removeClass('alert alert-danger');

      $('#F1A6').removeClass('alert alert-warning');
      $('#F1B6').removeClass('alert alert-warning');
    }

    if(data[0]['noofdays'] < 0) {
      $('#5A4').removeClass('alert alert-success');
      $('#5B4').removeClass('alert alert-success');
      $('#5A4').addClass('alert alert-danger');
      $('#5B4').addClass('alert alert-danger');
      $('#5A4').html("Delayed by");
      $('#5B4').html(Math.abs(data[0]['noofdays'])+" Days");
    }
    else {
      $('#5A4').removeClass('alert alert-danger');
      $('#5B4').removeClass('alert alert-danger');
      $('#5A4').addClass('alert alert-success');
      $('#5B4').addClass('alert alert-success');
      $('#5A4').html("Duration Left");
      $('#5B4').html(data[0]['noofdays']+" Days");
    }


	});
}


</script>
	<script type="text/javascript" src="script/jquery.populate.pack.js"></script>

<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Project Information</legend>

<!-- Search input-->
  <div id="projSearch" class="form-group">

  	<div class="col-md-5">
  	  <div class="input-group">
    	<input id="prj" name="prj" type="input" placeholder="Enter Project Name" class="form-control input-md typeahead" required="" aria-describedby="glph" autocomplete="sprcatre">
    	<span class="input-group-addon" id="glph"><span class="glyphicon glyphicon-search"></span></span>
  	</div>
  	<div>
  </div>
</div>
</div>
</fieldset>
</form>

<div id="proj-info">
<div>
<ul class='nav nav-pills  split-button-nav'>
  <li class='active'>
    <a data-toggle='tab' href='#GEN'>GENERAL</a>
  </li>
  <li>
    <a data-toggle='tab' href='#FIN'>FINANCE</a>
  </li>
  <li>
    <a data-toggle='tab' href='#DET'>DETAILS</a>
  </li>
  <li>

  </li>
</ul>
</div>
<br/>




<div class='tab-content'>
  <div class="tab-pane fade in active" id="GEN">
    <p>
  <div class="row">
  <form id="gen-form" role="form">
    <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
      <table class="table table-striped">
        <tr>
          <th id="1A1">Project Type</th>
          <td id="1B1"></td>
        </tr>
        <tr>
          <th id="2A1">Project Name</th>
          <td id="2B1">
        </tr>
    <tr>
      <th id="3A1">Customer</th>
      <td id="3B1"></td>
    </tr>
    <tr>
      <th id="4A1">Region</th>
      <td id="4B1"></td>
    </tr>
    <tr>
      <th id="5A1">Status</th>
      <td id="5B1"></td>
    </tr>
    </table>
</div>
<div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
  <table class="table table-striped">
    <tr>
      <th id="1A2">Profit Centre</th>
      <td id="1B2"></td>
    </tr>
    <tr>
      <th id="2A2">Product</th>
      <td id="2B2">
    </tr>
<tr>
  <th id="3A2">Project Manager</th>
  <td id="3B2"></td>
</tr>
<tr>
  <th id="4A2">Project Director</th>
  <td id="4B2"></td>
</tr>
<tr>
  <th id="5A2">Report Period</th>
  <td id="5B2"></td>
</tr>
</table>
</div>
<div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
  <table class="table table-striped">
    <tr>
      <th id="1A3">Planned Start Date</th>
      <td id="1B3"></td>
    </tr>
    <tr>
      <th id="2A3">Planned End Date</th>
      <td id="2B3">
    </tr>
<tr>
  <th id="3A3">Actual Start Date</th>
  <td id="3B3"></td>
</tr>
<tr>
  <th id="4A3">Actual End Date</th>
  <td id="4B3"></td>
</tr>
<tr>
  <th id="5A3">Extension</th>
  <td id="5B3"></td>
</tr>
<tr>
  <th id="5A4"></th>
  <td id="5B4"></td>
</tr>
</table>
</div>
</form>
</div>

  </p>
  </div> <!--End of general content -->

  <div class="tab-pane fade" id="FIN">
    <p>
      <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
        <table class="table table-striped">
          <tr>
            <th id="F1A1">Contract Amount</th>
            <td id="F1B1" class="text-right"></td>
          </tr>
          <tr>
            <th id="F2A1">Change Request</th>
            <td id="F2B1" class="text-right"></td>
          </tr>
          <tr>
            <th id="F3A1">Total Value</th>
            <td id="F3B1" class="text-right"></td>
          </tr>
      </table>
      </div>
      <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
        <table class="table table-striped">
          <tr>
            <th id="F1A2">Normal Budget Initated</th>
            <td id="F1B2" class="text-right"></td>
          </tr>
          <tr>
            <th id="F2A2">Excess Budget Initated</th>
            <td id="F2B2" class="text-right"></td>
          </tr>
          <tr>
            <th id="F3A2">Total Budget Initated</th>
            <td id="F3B2" class="text-right"></td>
          </tr>
        </table>
      </div>
        <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
          <table class="table table-striped">
          <tr>
            <th id="F1A3">Normal Budget Approved</th>
            <td id="F1B3" class="text-right"></td>
          </tr>
          <tr>
            <th id="F2A3">Excess Budget Approved</th>
            <td id="F2B3" class="text-right"></td>
          </tr>
          <tr>
            <th id="F3A3">Total Budget Approved</th>
            <td id="F3B3" class="text-right"></td>
          </tr>

      </table>
      </div>
      <div class="clearfix"></div>
      <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
        <table class="table table-striped">
        <tr>
          <th id="F1A4">Base Labour Cost</th>
          <td id="F1B4" class="text-right"></td>
        </tr>
        <tr>
          <th id="F2A4">Unified Labour Cost</th>
          <td id="F2B4" class="text-right"></td>
        </tr>
        <tr>
          <th id="F3A4">Expense</th>
          <td id="F3B4" class="text-right"></td>
        </tr>
        <tr>
          <th id="F4A4">Total Cost</th>
          <td id="F4B4" class="text-right"></td>
        </tr>
    </table>
    </div>
    <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
      <table class="table table-striped">
      <tr>
        <th id="F2A5">Pending to be Invoiced</th>
        <td id="F2B5" class="text-right"></td>
      </tr>
      <tr>
        <th id="F3A5">Invoiced Amount</th>
        <td id="F3B5" class="text-right"></td>
      </tr>
      <tr>
        <th id="F4A5">Paid Amount</th>
        <td id="F4B5" class="text-right"></td>
      </tr>
      <tr>
        <th id="F1A5">Total Invoice</th>
        <td id="F1B5" class="text-right"></td>
      </tr>
  </table>
  </div>
  <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
    <table class="table table-striped">
    <tr>
      <th id="F1A6">Budget To Go</th>
      <td id="F1B6" class="text-right"></td>
    </tr>
    <tr>
      <th id="F2A6">Cashflow</th>
      <td id="F2B6" class="text-right"></td>
    </tr>
    <tr>
      <th id="F3A6">Running Profit</th>
      <td id="F3B6" class="text-right"></td>
    </tr>
    <tr>
      <th id="F4A6">Running Profit Percentage</th>
      <td id="F4B6" class="text-right"></td>
    </tr>
</table>
</div>

      </p>
  </div>

  <div class="tab-pane fade" id="DET">
    <p>
      <div class="form-group col-xs-5 col-sm-6 col-md-6 col-lg-6">
        <table class="table table-striped">
          <tr>
            <th id="G1A1">Project Details</th>
            <td id="G1B1"></td>
          </tr>
          <tr>
            <th id="G2A1">Objectives</th>
            <td id="G2B1"></td>
          </tr>
        </table>
      </div>
      <div class="form-group col-xs-5 col-sm-6 col-md-6 col-lg-6">
        <table class="table table-striped">
          <tr>
            <th id="G1A2">Scope</th>
            <td id="G1B2"></td>
          </tr>
          <tr>
            <th id="G2A2">Success Factor</th>
            <td id="G2B2"></td>
          </tr>
        </table>
      </div>
  </p>
  </div>

</div> <!--End of tab content -->



</div> <!--End of proj-info -->







<?php

require_once('bodyend.php');

?>
