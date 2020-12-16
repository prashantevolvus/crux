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



      $('#1B2').editable({
        sourceCache: false,
        pk: gCustId,
        value: data[0]['name_on_invoice'],
        title: "Enter Customer Name On Invoice",
        validate: function(value) {
          if ($.trim(value) == '') {
            return 'This field is required';
          }
        },
        params: function(params) {
          params.db = "crux";
          return params;
        }
      });

      $('#2B2').editable({
        sourceCache: false,
        pk: gCustId,
        value: data[0]['gst_no'],
        title: "Enter India GST Number",
        params: function(params) {
          params.db = "crux";
          return params;
        }
      });

      $('#3B2').editable({
        sourceCache: false,
        pk: gCustId,
        value: data[0]['trn_no'],
        title: "Enter UAE TRN Number",
        params: function(params) {
          params.db = "crux";
          return params;
        }
      });

      $('#1B3').editable({
        sourceCache: false,
        pk: gCustId,
        value: data[0]['to_add1'],
        title: "Enter  Address Line 1",
        validate: function(value) {
          if ($.trim(value) == '') {
            return 'This field is required';
          }
        },
        params: function(params) {
          params.db = "crux";
          return params;
        }
      });

      $('#2B3').editable({
        sourceCache: false,
        pk: gCustId,
        value: data[0]['to_add2'],
        title: "Enter Address Line 2",
        validate: function(value) {
          if ($.trim(value) == '') {
            return 'This field is required';
          }
        },
        params: function(params) {
          params.db = "crux";
          return params;
        }
      });

      $('#3B3').editable({
        sourceCache: false,
        pk: gCustId,
        value: data[0]['to_add3'],
        title: "Enter Address Line 3",
        validate: function(value) {
          if ($.trim(value) == '') {
            return 'This field is required';
          }
        },
        params: function(params) {
          params.db = "crux";
          return params;
        }
      });


      $('#1B4').editable({
        sourceCache: false,
        pk: gCustId,
        value: data[0]['ship_add1'],
        title: "Enter Shipping Address Line 1",
        params: function(params) {
          params.db = "crux";
          return params;
        }
      });

      $('#2B4').editable({
        sourceCache: false,
        pk: gCustId,
        value: data[0]['ship_add2'],
        title: "Enter Shipping Address Line 2",
        params: function(params) {
          params.db = "crux";
          return params;
        }
      });

      $('#3B4').editable({
        sourceCache: false,
        pk: gCustId,
        value: data[0]['ship_add3'],
        title: "Enter Shipping Address Line 3",
        params: function(params) {
          params.db = "crux";
          return params;
        }
      });



    });

    $.fn.editable.defaults.mode = 'popup';
    $.fn.editable.defaults.toggle = 'dblclick';
    $.fn.editable.defaults.url = 'api/editCustomer.php';
  });
</script>


<legend>View Customer</legend>
<p><i>[Double Click to Edit]</i></p>


<div class="container">
  <form id="customer-form" role="form">
    <div class="row">
      <div class="form-group col-lg-6">
        <table class="table table-striped">
          <tr>
            <th id="1A1">Region</th>
            <td id="1B1"></td>
          </tr>
          <tr>
            <th id="2A1">Customer Name</th>
            <td id="2B1">
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
      <div class="form-group col-lg-6">
        <table class="table table-striped">
          <tr>
            <th id="1A2">Name on Invoice</th>
            <td id="1B2"></td>
          </tr>
          <tr>
            <th id="2A2">India GST Number</th>
            <td id="2B2"></td>
          </tr>
          <tr>
            <th id="3A2">UAE TRN Number</th>
            <td id="3B2"></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="form-group col-lg-6">
        <table class="table table-striped">
          <tr>
            <th id="1A3">Address Line 1</th>
            <td id="1B3"></td>
          </tr>
          <tr>
            <th id="2A3">Address Line 2</th>
            <td id="2B3">
          </tr>
          <tr>
            <th id="3A3">Address Line 3</th>
            <td id="3B3"></td>
          </tr>
        </table>
      </div>
      <div class="form-group col-lg-6">
        <table class="table table-striped">
          <tr>
            <th id="1A4">Shipping Address Line 1</th>
            <td id="1B4"></td>
          </tr>
          <tr>
            <th id="2A4">Shipping Address Line 2</th>
            <td id="2B4">
          </tr>
          <tr>
            <th id="3A4">Shipping Address Line 3</th>
            <td id="3B4"></td>
          </tr>
        </table>
      </div>
    </div>
  </form>
</div>  <!-- end of container -->



<?php

require_once('bodyend.php');

?>
