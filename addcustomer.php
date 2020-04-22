<?php
$permission = "VIEW";
require_once('head.php');

require_once('bodystart.php');
?>

<script type="text/javascript">




$(document).ready(function() {

  fillDropDown("api/getRegionList.php", "#region");


  $('#customer-form').on('submit', function(e) {

    // if the validator does not prevent form submit
    if (!e.isDefaultPrevented()) {
      var url = "api/createCustomer.php";

      // POST values in the background the the script URL
      $.ajax({
        type: "POST",
        url: url,
        data: $(this).serialize(),
        success: function(data) {
          // data = JSON object that contact.php returns

          // we recieve the type of the message: success x danger and apply it to the
          var messageAlert = 'alert-' + data.type;
          var messageText = data.message;

          // let's compose Bootstrap alert box HTML
          var alertBox = '<div class="alert ' + messageAlert + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + messageText + '<a class="alert-link" href="' + data.navigate + '">Click to view Details</a></div>';
          // If we have messageAlert and messageText
          if (messageAlert && messageText) {
            // inject the alert to .messages div in our form
            $('#customer-form').find('.messages').html(alertBox);
            // empty the form
            $('#customer-form')[0].reset();
          } // if messageAlert check
        }//Close Success
      }); //Close Ajax
      return false;
    }
  }) //Close On Submit

}); //Close Ready
</script>


<legend>Add Customer</legend>


<div class="row">
  <form id="customer-form" method="post" action="api/createCustomer.php" role="form">
    <div class="messages"></div>

    <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
      <!-- Multiple Radios (inline) -->
      <label for="region">Region</label>
      <select id="region" name="region" class="form-control">
      </select>
    </div>

    <div class="clearfix"></div>
    <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
      <label for="customer">Customer Name</label>
      <input type="text" class="form-control" id="customer" name="customer" placeholder="Enter Customer Name" required>
      <div class="form-control-feedback"></div>
    </div>

    <div class="clearfix"></div>

    <div class="form-group col-xm-10 col-sm-4 col-md-4 col-lg-4">
      <label for="custdet">Customer Details</label>
      <textarea class="form-control" id="custdet" name="custdet" rows="5" placeholder="Enter Customer Details" required></textarea>
    </div>


    <div class="clearfix"></div>
    <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
      <button class="btn btn-primary btn-md" type="submit">Add Customer</button>
    </div>
  </form>
</div>

<?php

require_once('bodyend.php');

?>
