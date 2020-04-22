<?php
$permission = "VIEW";
require_once('head.php');

require_once('bodystart.php');
?>

<script type="text/javascript">


  $(document).ready(function() {

    var url = new URL(document.URL);
    var search_params = url.searchParams;

    var gOppId = search_params.get('oppid');
    var cust;
    var invTable;

    var gAmtForPcnt = 1;

    $('#href-proposal a').click(function(e) {
      e.preventDefault(); //stop the browser from following
      //console.log("api/getOppFiles.php?file=proposal&oppid=" + gOppId);
      window.location.href = "api/getOppFile.php?file=proposal&oppid=" + gOppId;
    });

    $('#href-estimate a').click(function(e) {
      e.preventDefault(); //stop the browser from following
      window.location.href = "api/getOppFile.php?file=estimation&oppid=" + gOppId;
    });

    $('#invoice-pcnt').blur(function() {
      $('#invoice-amount').val(gAmtForPcnt * $('#invoice-pcnt').val() / 100);
    });

    $.getJSON("api/getOpportunity.php?oppid=" + gOppId, function(data) {

      //This is not allowed to change. Create a new opportunity if you want
      $('#1B1').text((data[0]['change_request'] == 1 ? "Change Request" : "New Project"));

      cust = data[0]['customer_id'];

      //Opportunity Name
      $('#2B1').editable({
        sourceCache: false,
        pk: gOppId,
        value: data[0]['opp_name'],
        title: "Enter Opportunity Name",
        validate: function(value) {
          if ($.trim(value) == '') {
            return 'This field is required';
          }
        }
      });

      //Customer
      $('#3B1').editable({
        type: 'select',
        sourceCache: false,
        pk: gOppId,
        value: data[0]['customer_id'],
        title: "Enter Customer Name",
        source: 'api/getCustomerList.php',
        success: function(response, newValue) {
          cust = newValue;

          setTimeout(function() {
            $('#1B3B').editable('show');
          }, 200);
        }
      });


      //Opputunity ACTIVE or INACTIVE
      $('#4B1').editable({
        type: 'select',
        sourceCache: false,
        pk: gOppId,
        value: data[0]['active'],
        title: "Is the Opportunity Active?",
        source: '[{"value":"1","text":"ACTIVE"},{"value":"0","text":"INACTIVE"}]'
      });

      //Proposal URL
      $('#5B1').editable({
        type: 'url',
        sourceCache: false,
        pk: gOppId,
        value: data[0]['proposal_set_path'],
        title: "Enter Proposal URL",
        validate: function(value) {
          if ($.trim(value) == '') {
            return 'This field is required';
          }
        }
      });

      //Opportunity Details
      $('#1B4').editable({
        type: 'textarea',
        sourceCache: false,
        rows: 10,
        pk: gOppId,
        mode: 'inline',
        title: "Enter Opportunity Details",
        value: data[0]['opp_det'],
        validate: function(value) {
          if ($.trim(value) == '') {
            return 'This field is required';
          }
        }
      });

      //Initial Quote
      $('#1B2').editable({
        type: 'number',
        sourceCache: false,
        pk: gOppId,
        value: data[0]['initial_quote'],
        title: "Enter Initial Quote",
        validate: function(value) {
          if ($.trim(value) == '') {
            return 'This field is required';
          }
        },
        display: function(value) {
          $(this).text(amtFormat(value));
        }
      });

      //Current Quote
      $('#2B2').editable({
        type: 'number',
        sourceCache: false,
        pk: gOppId,
        value: data[0]['current_quote'],
        title: "Enter Current Quote",
        validate: function(value) {
          if ($.trim(value) == '') {
            return 'This field is required';
          }
        },
        display: function(value) {
          $(this).text(amtFormat(value));
        }
      });

      //No Regret Quote
      $('#3B2').editable({
        type: 'number',
        sourceCache: false,
        pk: gOppId,
        value: data[0]['no_regret_quote'],
        title: "Enter No Regret Quote",
        validate: function(value) {
          if ($.trim(value) == '') {
            return 'This field is required';
          }
        },
        display: function(value) {
          $(this).text(amtFormat(value));
          gAmtForPcnt = value;
        }
      });


      //Sales Stage
      $('#1B5').editable({
        type: 'select',
        sourceCache: false,
        pk: gOppId,
        value: data[0]['sales_stage_id'],
        title: "Enter Sales Stage",
        source: 'api/getSalesStage.php'
      });

      //Social Stage
      $('#2B5').editable({
        type: 'select',
        sourceCache: false,
        pk: gOppId,
        value: data[0]['social_stage_id'],
        title: "Enter Social Stage",
        source: 'api/getSocialStage.php'
      });

      //Assigned to
      $('#3B5').editable({
        type: 'select',
        sourceCache: false,
        pk: gOppId,
        value: data[0]['assigned_to'],
        title: "Enter Opportunity Assigned To",
        source: 'api/getEmpList.php'
      });

      //Start Date
      $('#4B5').editable({
        type: 'date',
        sourceCache: false,
        pk: gOppId,
        value: data[0]['start_date'],
        title: "Enter Opportunity Start Date",
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

      //Expected Close
      $('#5B5').editable({
        type: 'date',
        sourceCache: false,
        pk: gOppId,
        value: data[0]['expected_close_date'],
        title: "Enter Opportunity Expected Close Date",
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

      if(!data[0]['proposal_doc']){
        console.log("proposal_doc");
        $("#href-proposal").hide();
      }

      console.log("bbbb "+ data[0]['estimation_sheet'] );
      if(!data[0]['estimation_sheet']){
        console.log("estimation");
        $("#href-estimate").hide();
      }


      if (data[0]['change_request'] == 0) {
        $("#project").toggleClass('hidden');

        //project_type
        $('#1B3A').editable({
          type: 'select',
          sourceCache: false,
          pk: gOppId,
          value: data[0]['project_type_id'],
          title: "Enter Project Type",
          source: 'api/getProjectTypeList.php'
        });

        //product_name
        $('#2B3A').editable({
          type: 'select',
          sourceCache: false,
          pk: gOppId,
          value: data[0]['base_product_id'],
          title: "Enter Base Product",
          source: 'api/getProductList.php'
        });
        //New Business
        $('#3B3A').editable({
          type: 'select',
          sourceCache: false,
          pk: gOppId,
          value: data[0]['new_business'],
          title: "Is this New Business or Existing?",
          source: '[{"value":"1","text":"New Business"},{"value":"0","text":"Existing"}]'
        });
      } else {
        $("#changerequest").toggleClass('hidden');
        //    $('#1B3B').text(data[0]['project_name']);
        //project_name
        $('#1B3B').editable({
          type: 'select',
          sourceCache: false,
          pk: gOppId,
          value: data[0]['project_id'],
          title: "Enter Project",
          source: 'api/getProjectList.php?cust=' + cust
        });
      }

      if (data[0]['no_regret_quote'] != data[0]['invoice_amount']) {
        var alertBox = '<div class="alert alert-danger  alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Mismatch between Invoice Amount Mismatch and No Regret Amount</div>';
        $('#opportunity-form').find('.inv-messages').html(alertBox);
      }

    });

    invTable = $('#invoices').DataTable({

      "searching": false,
      "ordering": false,
      "paging": false,
      "ajax": {
        url: "api/getOppInvoices.php",
        data: function(d) {
          d.oppid = gOppId;
        }
      },
      "columns": [{
          "data": "milestone"
        },
        {
          "data": "invoice_date"
        },
        {
          "data": "payment_date"
        },
        {
          "className": "text-right",
          "data": "invoice_pcnt",
          "render": function(data, type, row, meta) {
            return amtFormat(data) + '%';
          }

        },
        {
          "className": "text-right",
          "data": "invoice_amount",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }

        },
        {
          "data": "id",
          "className": "text-right",
          "render": function(data, type, row, meta) {
            if (type === 'display') {
              data = '<button type="button" class="btn btn-default" data-dttype="Edit" data-dtinvid="' + data +
                '"  data-toggle="modal" data-target="#invoicelist" aria-label="Left Align"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>' +
                '<button type="button" class="btn btn-default" data-dttype="Remove" data-dtinvid="' + data +
                '" data-toggle="modal" data-target="#invoicelist"  aria-label="Left Align"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>' +
                '<button type="button" class="btn btn-default" data-dttype="View" data-dtinvid="' + data +
                '" data-toggle="modal" data-target="#invoicelist"  aria-label="Left Align"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></button>';
            }
            return data;
          }
        }
      ]
    });


    $.fn.editable.defaults.mode = 'popup';
    $.fn.editable.defaults.toggle = 'dblclick';
    $.fn.editable.defaults.url = 'api/editOpp.php';
    //$('#2B1').editable();
    $('#refresh').on('click', function(e) {
      invTable.ajax.reload();
      return;
    })
    //Operation buttons [Add, Edit and Remove] for Invoices
    $('#invoicelist').on('show.bs.modal', function(event) {
      console.log('invoicelist-show.bs.modal');

      var button = $(event.relatedTarget); // Button that triggered the modal
      var invid = button.data('dtinvid'); // Extract info from data-* attributes
      var dttype = button.data('dttype'); // Extract info from data-* attributes

      //This is needed since same model is shown previous values remain
      $(".modal-body #milestone").val('');
      $(".modal-body #milestone-desc").val('');
      $(".modal-body #invoice-date").val('');
      $(".modal-body #payment-date").val('');
      $(".modal-body #invoice-pcnt").val('');
      $(".modal-body #invoice-amount").val('');
      $(".modal-body #invoice-id").val('');
      $(".modal-body #operation").val('');
      $(".modal-body #opportunity-id").val('');



      var modal = $(this);
      modal.find('.modal-title').text('Invoice Details - ' + dttype);
      if (dttype === "Remove" || dttype === "View") {

        $(".modal-body #milestone").attr('disabled', 'disabled');
        $(".modal-body #milestone-desc").attr('disabled', 'disabled');
        $(".modal-body #invoice-date").attr('disabled', 'disabled');
        $(".modal-body #payment-date").attr('disabled', 'disabled');
        $(".modal-body #invoice-pcnt").attr('disabled', 'disabled');
        $(".modal-body #invoice-amount").attr('disabled', 'disabled');

      } else {
        $(".modal-body #milestone").removeAttr('disabled');
        $(".modal-body #milestone-desc").removeAttr('disabled');
        $(".modal-body #invoice-date").removeAttr('disabled');
        $(".modal-body #payment-date").removeAttr('disabled');
        $(".modal-body #invoice-pcnt").removeAttr('disabled');
        //$(".modal-body #invoice-amount").removeAttr('disabled');
      }

      if (dttype != "Add") {
        $.getJSON("api/getOppInvoices.php?invid=" + invid, function(data) {


          $(".modal-body #milestone").val(data['data'][0]['milestone']);
          $(".modal-body #milestone-desc").val(data['data'][0]['milestone_desc']);
          $(".modal-body #invoice-date").val(data['data'][0]['invoice_date']);
          $(".modal-body #payment-date").val(data['data'][0]['payment_date']);
          $(".modal-body #invoice-pcnt").val(data['data'][0]['invoice_pcnt']);
          $(".modal-body #invoice-amount").val(data['data'][0]['invoice_amount']);
          $(".modal-body #invoice-id").val(invid);
          $(".modal-body #operation").val(dttype);
          $(".modal-body #opportunity-id").val(gOppId);

        });
      } else {
        $(".modal-body #invoice-id").val(invid);
        $(".modal-body #operation").val(dttype);
        $(".modal-body #opportunity-id").val(gOppId);

      }

    });

    $('#invoicelist').on('submit', '#invoicefrm', function(e) {
      console.log('invoicelist-submit');

      //$('#invoicefrm').submit(function() {
      if (!e.isDefaultPrevented()) {

        var url = "api/updateOppInv.php";
        if ($(".modal-body #operation") === "View") {
          $('#invoicefrm')[0].reset();
          $('#invoicelist').modal('hide');
          return false;
        }


        $.ajax({
          type: "POST",
          url: url,
          data: $('#invoicefrm').serialize(),
          success: function(data) {

            var messageAlert = 'alert-' + data.type;
            var messageText = data.message;

            // let's compose Bootstrap alert box HTML
            var alertBox = '<div class="alert ' + messageAlert + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + messageText + '</div>';
            // If we have messageAlert and messageText
            if (messageAlert && messageText) {
              // inject the alert to .messages div in our form
              console.log(alertBox);
              $('#opportunity-form').find('.inv-messages').html(alertBox);
              $(".alert-dismissable").fadeTo(2000, 500).slideUp(500, function() {
                $(".alert-dismissable").alert('close');
              });
              invTable.ajax.reload();
              // empty the form

            }
          }
        });
        $('#invoicefrm')[0].reset();
        $('#invoicelist').modal('hide');

        return false;

      }
    });

    $('#fileUpload').on('show.bs.modal', function(event) {
      console.log('fileUpload-show.bs.modal');


      $(".modal-body #opportunity-id").val(gOppId);


    });

    $('#fileUpload').on('submit', '#uploadFilefrm', function(e) {
      console.log('fileUpload-submit');

      //$('#invoicefrm').submit(function() {
      if (!e.isDefaultPrevented()) {

        var url = "api/updateOppFile.php";
        var formData = new FormData(this);
        console.log(formData);
        $.ajax({
          type: "POST",
          url: url,
          data: formData,
          processData: false,
          contentType: false,
          success: function(data) {
            console.log("SUCCESS " + data);
            var alertBox = '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + 'Files Uploaded' + '</div>';
            console.log(alertBox);

            $('#opportunity-form').find('.upld-messages').html(alertBox);
            $(".alert-dismissable").fadeTo(2000, 500).slideUp(500, function() {
              $(".alert-dismissable").alert('close');
            });
            invTable.ajax.reload();
            $("#href-proposal").show();
            $("#href-estimate").show();



          },
          error: function(data) {
            console.log("FAIL " + data);

          }
        });
        $('#uploadFilefrm')[0].reset();
        $('#fileUpload').modal('hide');

        return false;

      }
      return false;

    });


  });
</script>


<legend>View Sales Opportunities</legend>
<p><i>[Double Click to Edit]</i></p>



<div class="row">
  <form id="opportunity-form" role="form">
    <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">

      <table class="table table-striped">
        <tr>
          <th id="1A1">Opportunity Type</th>
          <td id="1B1"></td>
        </tr>
        <tr>
          <th id="2A1">Opportunity Name</th>
          <td id="2B1">
    </div>
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
      <td id="5B1"></td>
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

  <div id="project" class="togglehid hidden">
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
  <!-- </div> -->
  <div id="changerequest" class="togglehid hidden">

    <!-- <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4"> -->

    <table class="table table-striped">

      <tr>
        <th id="1A3B">Project</th>
        <td id="1B3B"></td>
      </tr>
    </table>

  </div>
  <div class="upld-messages"></div>

  <table class="table table-striped">
    <tr>
      <th id="6A1">Files</th>
      <td id="href-proposal">
        <a class="btn btn-default btn-sm" target="_blank">
          <span class="glyphicon glyphicon-download" aria-hidden="true">Proposal</span>
        </a>
      </td>
      <td id="href-estimate">
        <a class="btn btn-default btn-sm">
          <span class="glyphicon glyphicon-download" aria-hidden="true">Estimate</span>
        </a>
      </td>
      <td id="6B1">
        <button type="button" id="uploadBtn" class="btn btn-default btn-sm" data-dttype="upload" data-toggle="modal" data-target="#fileUpload" aria-label="Left Align">
          <span class="glyphicon glyphicon-upload" aria-hidden="true">Upload</span>
        </button>
      </td>

    </tr>
  </table>
</div>


<div class="clearfix"></div>

<div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">

  <table class="table table-striped">
    <tr>
      <th id="1A2">Initial Proposed Amount</th>
      <td id="1B2" class="text-right"></td>
    </tr>
    <tr>
      <th id="2A2">Current Proposed Amount</th>
      <td id="2B2" class="text-right"></td>
    </tr>
    <tr>
      <th id="3A2">No Regret Amount</th>
      <td id="3B2" class="text-right"></td>
    </tr>
  </table>
</div>

<div class="form-group col-xs-5 col-sm-8 col-md-8 col-lg-8">
  <table class="table table-striped">
    <tr>
      <th id="1A4">Opportunity Details</th>
      <td id="1B4" data-type="textarea"></td>
    </tr>
  </table>
</div>




<div class="clearfix"></div>
<div class="form-group col-xs-5 col-sm-8 col-md-8 col-lg-8">
  <div class="inv-messages">
  </div>
  <table id="invoices" class="table table-striped" width="100%">
    <thead>
      <tr>
        <th>Milestone</th>
        <th>Invoice Date</th>
        <th>Payment Date</th>
        <th>Milestone Percent</th>
        <th>Invoice Amount</th>
        <th>
          Action&nbsp
          <button type="button" class="btn btn-default pull-right" data-dttype="Add" data-dtinvid="0" data-toggle="modal" data-target="#invoicelist" aria-label="Left Align">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
          </button>
          <button type="button" float="right" class="btn btn-default pull-right" aria-label="Left Align" id="refresh">
            <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
          </button>
        </th>
      </tr>
    </thead>
  </table>
</div>
</form>
</div>

<!-- Invoice Modal  -->
<div class="modal fade" id="invoicelist" tabindex="-1" role="dialog" aria-labelledby="invoicelistLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="invoicelistLabel">Invoice Details</h4>
      </div>
      <div class="modal-body">
        <form id="invoicefrm" method="post" action="api/updateOppInv.php" role="form">
          <div class="form-group">
            <label for="milestone" class="control-label">Milestone</label>
            <input type="text" class="form-control" id="milestone" name="milestone" required>
          </div>
          <div class="form-group">
            <label for="milestone-desc" class="control-label">Milestone Description</label>
            <input type="text" class="form-control" id="milestone-desc" name="milestone-desc" required>
          </div>
          <div class="form-group">
            <label for="invoice-date" class="control-label">Invoice Date</label>
            <input type="date" class="form-control" id="invoice-date" name="invoice-date" required>
          </div>
          <div class="form-group">
            <label for="payment-date" class="control-label">Payment Date</label>
            <input type="date" class="form-control" id="payment-date" name="payment-date" required>
          </div>
          <div class="form-group">
            <label for="invoice-pcnt" class="control-label">Milestone Percentage</label>
            <input type="number" class="form-control" min="1" max="100" id="invoice-pcnt" name="invoice-pcnt" required>
          </div>
          <div class="form-group">
            <label for="invoice-amount" class="control-label">Invoice Amount</label>
            <input type="number" class="form-control" id="invoice-amount" name="invoice-amount" readonly>
          </div>
          <div class="form-group">
            <input type="hidden" class="form-control" id="invoice-id" name="invoice-id">
          </div>
          <div class="form-group">
            <input type="hidden" class="form-control" id="operation" name="operation">
          </div>
          <div class="form-group">
            <input type="hidden" class="form-control" id="opportunity-id" name="opportunity-id">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" form="invoicefrm">Submit</button>

          </div>
        </form>
      </div>

    </div>
  </div>
</div>


<!-- File Upload Modal  -->
<div class="modal fade" id="fileUpload" tabindex="-1" role="dialog" aria-labelledby="fileUploadLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="fileUploadLabel">Upload Sales Files</h4>
      </div>
      <div class="modal-body">
        <form id="uploadFilefrm" enctype="multipart/form-data" method="post" action="api/uploadFiles.php" role="form">
          <div class="form-group">
            <label for="proposal" class="control-label">Upload Proposal Document</label>
            <input type="file" class="form-control" id="proposal" name="proposal" required>
          </div>
          <div class="form-group">
            <label for="estimate" class="control-label">Upload Proposal Estimation</label>
            <input type="file" class="form-control" id="estimate" name="estimate" required>
          </div>
          <div class="form-group">
            <input type="hidden" class="form-control" id="opportunity-id" name="opportunity-id">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" form="uploadFilefrm">Submit</button>

          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<?php

require_once('bodyend.php');

?>
