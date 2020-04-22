<?php
$permission = "VIEW";
require_once('head.php');

require_once('bodystart.php');
?>

<script type="text/javascript">
  $(document).ready(function() {

    var url = new URL(document.URL);
    var search_params = url.searchParams;

    var gCustId = search_params.get('custid');

    $.getJSON("api/getCustomer.php?custid=" + gCustId, function(data) {

      //Customer
      $('#1B1').editable({
        type: 'select',
        sourceCache: false,
        pk: gCustId,
        value: data[0]['region_id'],
        title: "Enter Region",
        source: 'api/getRegionList.php'
      });

      //Customer Name
      $('#2B1').editable({
        sourceCache: false,
        pk: gCustId,
        value: data[0]['cust_name'],
        title: "Enter Customer Name",
        validate: function(value) {
          if ($.trim(value) == '') {
            return 'This field is required';
          }
        }
      });

      //Customer Details
      $('#3B1').editable({
        type: 'textarea',
        sourceCache: false,
        rows: 10,
        pk: gCustId,
        mode: 'inline',
        title: "Enter Customer Details",
        value: data[0]['cust_det'],
        validate: function(value) {
          if ($.trim(value) == '') {
            return 'This field is required';
          }
        }
      });

      //CUSTOMER ACTIVE or DELETED
      $('#4B1').editable({
        type: 'select',
        sourceCache: false,
        pk: gCustId,
        value: data[0]['is_deleted'],
        title: "Is the Customer Deleted?",
        source: '[{"value":"1","text":"DELETED"},{"value":"0","text":"ACTIVE"}]'
      });

    });

    $.fn.editable.defaults.mode = 'popup';
    $.fn.editable.defaults.toggle = 'dblclick';
    $.fn.editable.defaults.url = 'api/editCustomer.php';
  });
</script>


<legend>View Customer</legend>
<p><i>[Double Click to Edit]</i></p>



<div class="row">
  <form id="customer-form" role="form">
    <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">

      <table class="table table-striped">
        <tr>
          <th id="1A1">Region</th>
          <td id="1B1"></td>
        </tr>
        <tr>
          <th id="2A1">Customer Name</th>
          <td id="2B1">
    </div>
    </tr>
    <tr>
      <th id="3A1">Customer Details</th>
      <td id="3B1"></td>
    </tr>
    <tr>
      <th id="4A1">Status</th>
      <td id="4B1"></td>
    </tr>

    </table>
</div>


</form>
</div>



<?php

require_once('bodyend.php');

?>
