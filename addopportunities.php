<?php
$permission = "VIEW";
require_once('head.php');

require_once('bodystart.php');
?>

<script type="text/javascript">
  $(document).ready(function() {
    //Fill all the drop downs from look up API
    fillDropDown("api/getSalesStage.php", "#salesStage");
    fillDropDown("api/getSocialStage.php", "#socialStage");
    fillDropDown("api/getEmpList.php", "#assigned");
    fillDropDown("api/getCustomerList.php", "#customer");
    fillDropDown("api/getProjectTypeList.php", "#projType");
    fillDropDown("api/getProductList.php", "#baseProd");

    //If Change request then fill  project whenever customer is changing
    $("#customer").on("change", function(event, value) {
      if ($('#typeOppor-1').is(":checked")) {
        fillDropDown("api/getProjectList.php?cust=" + $('#customer').val(), "#proj");
      }
    });

    //Datepicker does not cose on out of focus
    $(".datepicker").datepicker({
      autoclose: true
    });

    //Whenever change request selected then project control
    //WHenever New project selected then show project type product etc
    $('input[name="typeOppor"]').click(function() {

      $('.togglehid').addClass('hidden');
      // code changed here --> add the class hidden to all div's with class togglehid

      if ($(this).attr('id') == 'typeOppor-0') {
        $("#typeOppor-0-container").toggleClass('hidden');
        emptyDropDown("#proj");
        fillDropDown("api/getProjectTypeList.php", "#projType");
        fillDropDown("api/getProductList.php", "#baseProd");

      } else if ($(this).attr('id') == 'typeOppor-1') {
        $("#typeOppor-1-container").toggleClass('hidden');
        emptyDropDown("#projType");
        emptyDropDown("#baseProd");
        fillDropDown("api/getProjectList.php?cust=" + $('#customer').val(), "#proj");
        document.getElementById("newExisting-1").checked = true;
        document.getElementById("newExisting-0").checked = false;

      }
    }); //Close radio [Change request/Mew project]


    //Full Submit
    $('#opportunity-form').on('submit', function(e) {

      // if the validator does not prevent form submit
      if (!e.isDefaultPrevented()) {
        var url = "api/createOpp.php";

        // POST values in the background the the script URL
        $.ajax({
          type: "POST",
          url: url,
          data: $(this).serialize(),
          success: function(data) {

            var messageAlert = 'alert-' + data.type;
            var messageText = data.message;

            var alertBox = '<div class="alert ' + messageAlert + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + messageText + '<a class="alert-link" href="' + data
              .navigate + '">Click to view Details</a></div>';
            // If we have messageAlert and messageText
            if (messageAlert && messageText) {
              // inject the alert to .messages div in our form
              $('#opportunity-form').find('.messages').html(alertBox);
              // empty the form
              $('#opportunity-form')[0].reset();
            }
          } //CLose Success
        }); //Close Ajax
        return false;
      } //close if isDefaultPrevented
    }) //Close on Submit


  }); //Close ondocument ready
</script>

<legend>Add Sales Opportunities</legend>


<div class="row">
  <form id="opportunity-form" method="post" action="api/createOpp.php" role="form">
    <div class="messages"></div>

    <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
      <!-- Multiple Radios (inline) -->
      <label for="newExisting">Opportunity Type</label>
      <br>
      <label for="typeOppor-0">
        <input type="radio" name="typeOppor" id="typeOppor-0" value="1" checked="checked">
        New Project
      </label>
      <label class="radio-inline" for="typeOppor-1">
        <input type="radio" name="typeOppor" id="typeOppor-1" value="2">
        Change Request
      </label>
    </div>
    <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
      <label for="salesStage">Sales Stage</label>
      <select id="salesStage" name="salesStage" class="form-control">
      </select>
    </div>
    <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
      <label for="socialStage">Social Stage</label>
      <select id="socialStage" name="socialStage" class="form-control">
      </select>
    </div>

    <div class="clearfix"></div>

    <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
      <label for="customer">Customer</label>
      <select id="customer" name="customer" class="form-control">
      </select>
    </div>
    <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
      <label for="oppname">Opportunity Name</label>
      <input type="text" class="form-control" id="oppname" name="oppname" placeholder="Enter Opportunity Name" required>
      <div class="form-control-feedback"></div>
    </div>
    <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
      <label for="oppname">Proposal Document Path</label>
      <input type="url" class="form-control" id="propPath" name="propPath" placeholder="Enter Proposal Document Path [URL LINK]" required>
    </div>
    <div class="clearfix"></div>

    <div class="form-group col-xm-10 col-sm-4 col-md-4 col-lg-4">
      <label for="oppname">Opportunity Details</label>

      <textarea class="form-control" id="opptext" name="opptext" rows="5" placeholder="Enter Opportunity Details" required></textarea>
    </div>
    <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
      <label for="assigned">Assigned to</label>
      <select id="assigned" name="assigned" class="form-control">
      </select>
    </div>
    <div class="clearfix"></div>
    <div id="typeOppor-0-container" class="togglehid ">
      <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
        <label for="projType">Project Type</label>
        <select id="projType" name="projType" class="form-control">
        </select>
      </div>
      <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">

        <label for="baseProd">Base Product</label>
        <select id="baseProd" name="baseProd" class="form-control">
        </select>
      </div>
      <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
        <!-- Multiple Radios (inline) -->
        <label for="newExisting">Customer</label>
        <br>
        <label for="newExisting-0">
          <input type="radio" name="newExisting" id="newExisting-0" value="1" checked="checked">
          New
        </label>
        <label class="radio-inline" for="newExisting-1">
          <input type="radio" name="newExisting" id="newExisting-1" value="2">
          Existing
        </label>
      </div>
    </div>
    <div class="clearfix"></div>

    <div id="typeOppor-1-container" class="togglehid hidden">
      <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
        <label for="proj">Project</label>
        <select id="proj" name="proj" class="form-control">
        </select>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
      <label for="initAmt">Initial Proposed Amount</label>
      <input type="number" class="form-control" id="initAmt" name="initAmt" placeholder="Enter Initial Proposed Amount" required>

    </div>
    <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
      <label for="currAmt">Current Proposed Amount</label>
      <input type="number" class="form-control" id="currAmt" name="currAmt" placeholder="Enter Current Proposed Amount" required>

    </div>
    <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
      <label for="noRegAmt">No Regret Amount</label>
      <input type="number" class="form-control" id="noRegAmt" name="noRegAmt" placeholder="Enter No Regret Amount" required>
    </div>
    <div class="clearfix"></div>
    <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
      <label for="startDate">Start Date</label>
      <input type="text" data-provide="datepicker" data-date-orientation="right" data-date-format="yyyy-mm-dd" class="form-control datepicker" id="startDate" name="startDate" placeholder="Enter State Date (YYYY-MM-DD)" required>
    </div>
    <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
      <label for="closureDate">Expected Closure Date</label>
      <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control datepicker" id="closureDate" name="closureDate" placeholder="Enter Expected Closure Date (YYYY-MM-DD)" required>
    </div>

    <div class="clearfix"></div>
    <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
      <button class="btn btn-primary btn-md" type="submit">Add Opportunity</button>
    </div>
  </form>
</div>

<?php

require_once('bodyend.php');

?>
