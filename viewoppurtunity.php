<?php
$permission = "VIEW";
require_once('head.php');

require_once('bodystart.php');
?>

<script type="text/javascript">
var amtFormat = function(num){
    var str = num.toString().replace("$", ""), parts = false, output = [], i = 1, formatted = null;
    if(str.indexOf(".") > 0) {
        parts = str.split(".");
        str = parts[0];
    }
    str = str.split("").reverse();
    for(var j = 0, len = str.length; j < len; j++) {
        if(str[j] != ",") {
            output.push(str[j]);
            if(i%3 == 0 && j < (len - 1)) {
                output.push(",");
            }
            i++;
        }
    }
    formatted = output.reverse().join("");
    return(formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
};

$(document).ready(function() {

  var url = new URL(document.URL);
  var search_params = url.searchParams;

  var oppId = search_params.get('oppid');

  $.getJSON("api/getOppurtunity.php?oppid="+oppId, function (data) {

    $('#1B1').text((data[0]['change_request']== 1 ? "Change Request" : "New Project"));
    $('#2B1').text(data[0]['opp_name']);
    $('#3B1').text(data[0]['customer_name']);
    $('#4B1').text(data[0]['active'] == 1 ? 'ACTIVE' : 'INACTIVE');
    var lnk = data[0]['proposal_set_path'];
    console.log('<a href = "' + lnk + '">' + lnk + '</a>');
    var a = document.getElementById('5B1H'); //or grab it by tagname etc
    a.href = lnk;
    //$('#5B1').innerHTML = '<a href = "' + lnk + '">' + lnk + '</a>';

    $('#1B4').text(data[0]['opp_det']);

    $('#1B2').text(amtFormat(data[0]['initial_quote']));
    $('#2B2').text(amtFormat(data[0]['current_quote']));
    $('#3B2').text(amtFormat(data[0]['no_regret_quote']));

    $('#1B5').text((data[0]['sales_stage']));
    $('#2B5').text((data[0]['social_stage']));
    $('#3B5').text((data[0]['emp_name']));
    $('#4B5').text((data[0]['start_date']));
    $('#5B5').text((data[0]['expected_close_date']));



    if(data[0]['change_request']== 0) {
      $("#project").toggleClass('hidden');
      $('#1B3A').text(data[0]['project_type']);
      $('#2B3A').text(data[0]['product_name']);
      $('#3B3A').text((data[0]['new_business'] == 1 ? "New" : "Existing"));
    }
    else {
      $("#changerequest").toggleClass('hidden');
      $('#1B3B').text(data[0]['project_name']);

    }

  });

       $('#invoices').DataTable({
         "searching": false,
         "ordering": false,
         "paging": false,
        "ajax": "api/getOppInvoices.php?oppid="+oppId
         });






});



</script>


<legend>View Sales Oppurtunities</legend>




<div class="row">
  <form id="oppurtunity-form" role="form">
    <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">

      <table class="table table-striped">
        <tr>
          <th id="1A1">Oppurtunity Type</th>
          <td id="1B1"></td>
        </tr>
        <tr>
          <th id="2A1">Oppurtunity Name</th>
          <td id="2B1"></td>
        </tr>
        <tr>
          <th id="3A1">Customer</th>
          <td id="3B1"></td>
        </tr>
        <tr>
          <th id="4A1">Status</th>
          <td id="4B1"></td>
        </tr>
        <tr>
          <th id="5A1">Proposal Link</th>
          <td id="5B1"><a id = '5B1H'>Proposal Documents</a> </td>
        </tr>
      </table>
    </div>

    <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">

      <table class="table table-striped">
        <tr>
          <th id="1A5">Sales Stage</th>
          <td id="1B5"></td>
        </tr>
        <tr>
          <th id="2A5">Social Stage</th>
          <td id="2B5"></td>
        </tr>
        <tr>
          <th id="3A5">Assigned To</th>
          <td id="3B5"></td>
        </tr>
        <tr>
          <th id="4A5">Start Date</th>
          <td id="4B5"></td>
        </tr>
        <tr>
          <th id="5A5">Expected Date of Closure</th>
          <td id="5B5"></td>
        </tr>
      </table>
    </div>
    <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
      <table class="table table-striped">
        <tr>
          <th id="1A4">Oppurtunity Details</th>
          <td id="1B4"></td>
        </tr>
      </table>
    </div>
    <div class="clearfix"></div>
    <div id="project" class="togglehid hidden">
      <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
        <table class="table table-striped">
          <tr>
            <th id="1A3A">Project Type</th>
            <td id="1B3A"></td>
          </tr>
          <tr>
            <th id="2A3A">Base Product</th>
            <td id="2B3A"></td>
          </tr>
          <tr>
            <th id="3A3A">Business</th>
            <td id="3B3A"></td>
          </tr>
        </table>
      </div>
  </div>
  <div id="changerequest" class="togglehid hidden">
    <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
      <table class="table table-striped">
        <tr>
          <th id="1A3B">Project</th>
          <td id="1B3B"></td>
        </tr>
      </table>
    </div>
</div>
<div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">

  <table class="table table-striped">
    <tr>
      <th id="1A2">Initial Proposed Amount</th>
      <td id="1B2"></td>
    </tr>
    <tr>
      <th id="2A2">Current Proposed Amount</th>
      <td id="2B2"></td>
    </tr>
    <tr>
      <th id="3A2">No Regret Amount</th>
      <td id="3B2"></td>
    </tr>
  </table>
</div>


<div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
  <table id="invoices" class="table table-striped"  width="100%">
    <thead>
    <tr>
      <th>Milestone</th>
      <th>Invoice Date</th>
      <th>Payment Date</th>
      <th>Invoice Amount</th>
    </tr>
  </thead>
  </table>
</div>
  </form>
</div>


<?php

require_once('bodyend.php');

?>
