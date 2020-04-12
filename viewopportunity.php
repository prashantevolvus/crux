<?php
$permission = "VIEW";
require_once('head.php');

require_once('bodystart.php');
?>

<script type="text/javascript">

function getCustomer() {
    console.log($("Trying "+'#3B1').text());
    return $('#3B1').text();
}

$(document).ready(function() {

  var url = new URL(document.URL);
  var search_params = url.searchParams;

  var oppId = search_params.get('oppid');
  var cust;
  var invTable;

  $.getJSON("api/getOpportunity.php?oppid="+oppId, function (data) {

    console.log(data);

    //This is not allowed to change. Create a new opportunity if you want
    $('#1B1').text((data[0]['change_request']== 1 ? "Change Request" : "New Project"));

    cust=data[0]['customer_id'];



    //Opportunity Name
    $('#2B1').editable({
       sourceCache: false,
       pk: oppId,
       value: data[0]['opp_name'],
       title: "Enter Opportunity Name",
       validate: function(value) {
         if($.trim(value) == '') {
          return 'This field is required';
         }
       }
    });

    //Customer
    $('#3B1').editable({
        type: 'select',
        sourceCache: false,
        pk: oppId,
        value: data[0]['customer_id'],
        title: "Enter Customer Name",
        source: 'api/getCustomerList.php',
        success: function(response, newValue) {
              console.log(" After " + newValue + '\n' + cust)
              cust=newValue;

              setTimeout(function() {
                $('#1B3B').editable('show');
              }, 200);
            }
    });


    //Opputunity ACTIVE or INACTIVE
    $('#4B1').editable({
        type: 'select',
        sourceCache: false,
        pk: oppId,
        value: data[0]['active'],
        title: "Is the Opportunity Active?",
        source: '[{"value":"1","text":"ACTIVE"},{"value":"0","text":"INACTIVE"}]'
    });

    //Proposal URL
    $('#5B1').editable({
        type: 'url',
        sourceCache: false,
        pk: oppId,
        value: data[0]['proposal_set_path'],
        title: "Enter Proposal URL",
        validate: function(value) {
          if($.trim(value) == '') {
           return 'This field is required';
          }
        }
    });

    //Opportunity Details
    $('#1B4').editable({
              type: 'textarea',
              sourceCache: false,
              pk: oppId,
              mode:'inline',
              title: "Enter Opportunity Details",
              value: data[0]['opp_det'],
              validate: function(value) {
                if($.trim(value) == '') {
                 return 'This field is required';
                }
              }
    });

    //Initial Quote
    $('#1B2').editable({
        type: 'number',
        sourceCache: false,
        pk: oppId,
        value: data[0]['initial_quote'],
        title: "Enter Initial Quote",
        validate: function(value) {
          if($.trim(value) == '') {
           return 'This field is required';
          }
        }
    });

    //Current Quote
    $('#2B2').editable({
        type: 'number',
        sourceCache: false,
        pk: oppId,
        value: data[0]['current_quote'],
        title: "Enter Current Quote",
        validate: function(value) {
          if($.trim(value) == '') {
           return 'This field is required';
          }
        }
    });

    //No Regret Quote
    $('#3B2').editable({
        type: 'number',
        sourceCache: false,
        pk: oppId,
        value: data[0]['no_regret_quote'],
        title: "Enter No Regret Quote",
        validate: function(value) {
          if($.trim(value) == '') {
           return 'This field is required';
          }
        }
    });


    //Sales Stage
    $('#1B5').editable({
        type: 'select',
        sourceCache: false,
        pk: oppId,
        value: data[0]['sales_stage_id'],
        title: "Enter Sales Stage",
        source: 'api/getSalesStage.php'
    });

    //Social Stage
    $('#2B5').editable({
        type: 'select',
        sourceCache: false,
        pk: oppId,
        value: data[0]['social_stage_id'],
        title: "Enter Social Stage",
        source: 'api/getSocialStage.php'
    });

    //Assigned to
    $('#3B5').editable({
        type: 'select',
        sourceCache: false,
        pk: oppId,
        value: data[0]['assigned_to'],
        title: "Enter Opportunity Assigned To",
        source: 'api/getEmpList.php'
    });

    //Start Date
    $('#4B5').editable({
        type: 'date',
        sourceCache: false,
        pk: oppId,
        value: data[0]['start_date'],
        title: "Enter Opportunity Start Date",
        placement:'right',
        datepicker: {
               weekStart: 1
        },
        validate: function(value) {
          if($.trim(value) == '') {
           return 'This field is required';
          }
        }
    });

    //Expected Close
    $('#5B5').editable({
        type: 'date',
        sourceCache: false,
        pk: oppId,
        value: data[0]['expected_close_date'],
        title: "Enter Opportunity Expected Close Date",
        placement:'right',
        datepicker: {
               weekStart: 1
        },
        validate: function(value) {
          if($.trim(value) == '') {
           return 'This field is required';
          }
        }
    });



    if(data[0]['change_request']== 0) {
      $("#project").toggleClass('hidden');

      //project_type
      $('#1B3A').editable({
          type: 'select',
          sourceCache: false,
          pk: oppId,
          value: data[0]['project_type_id'],
          title: "Enter Project Type",
          source: 'api/getProjectTypeList.php'
      });

      //product_name
      $('#2B3A').editable({
          type: 'select',
          sourceCache: false,
          pk: oppId,
          value: data[0]['base_product_id'],
          title: "Enter Base Product",
          source: 'api/getProductList.php'
        });
      //New Business
      $('#3B3A').editable({
          type: 'select',
          sourceCache: false,
          pk: oppId,
          value: data[0]['new_business'],
          title: "Is this New Business or Existing?",
          source: '[{"value":"1","text":"New Business"},{"value":"0","text":"Existing"}]'
      });
    }
    else {
      $("#changerequest").toggleClass('hidden');
  //    $('#1B3B').text(data[0]['project_name']);
      //project_name
      $('#1B3B').editable({
          type: 'select',
          sourceCache: false,
          pk: oppId,
          value: data[0]['project_id'],
          title: "Enter Project",
          source: 'api/getProjectList.php?cust=' + cust
      });
    }

    });

  invTable = $('#invoices').DataTable({
    "searching": false,
    "ordering": false,
    "paging": false,
    "ajax": {
        url: "api/getOppInvoices.php",
        data: function(d){
          d.oppid = oppId;
        }
      },
      "columns": [
          { "data": "milestone"} ,
          { "data": "invoice_date"} ,
          { "data": "payment_date"} ,
          { "data": "invoice_amount"},
          {
             "data": "id",
             "render": function(data, type, row, meta){
                if(type === 'display'){
                    data = '<button type="button" class="btn btn-default" data-dttype="Edit" data-dtinvid="'+data+'"  data-toggle="modal" data-target="#invoicelist" aria-label="Left Align"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>' +
                    '<button type="button" class="btn btn-default" data-dttype="Remove" data-dtinvid="'+data+'" data-toggle="modal" data-target="#invoicelist"  aria-label="Left Align"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>' +
                    '<button type="button" class="btn btn-default" data-dttype="View" data-dtinvid="'+data+'" data-toggle="modal" data-target="#invoicelist"  aria-label="Left Align"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></button>';
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
  $('#refresh').on('click', function (e) {
      console.log("refresh");
      invTable.ajax.reload();
      return;
  })
    //Operation buttons [Add, Edit and Remove] for Invoices
    $('#invoicelist').on('show.bs.modal', function (event) {

      var button = $(event.relatedTarget); // Button that triggered the modal
      var invid = button.data('dtinvid'); // Extract info from data-* attributes
      var dttype = button.data('dttype'); // Extract info from data-* attributes

      //This is needed since same model is shown previous values remain
      $(".modal-body #milestone").val('');
      $(".modal-body #milestone-desc").val('');
      $(".modal-body #invoice-date").val('');
      $(".modal-body #payment-date").val('');
      $(".modal-body #invoice-amount").val('');
      $(".modal-body #invoice-id").val('');
      $(".modal-body #operation").val('');
      $(".modal-body #opportunity-id").val('');



      var modal = $(this);
      modal.find('.modal-title').text('Invoice Details - ' + dttype);
      if(dttype==="Remove" || dttype==="View") {

        $(".modal-body #milestone").attr('disabled', 'disabled');
        $(".modal-body #milestone-desc").attr('disabled', 'disabled');
        $(".modal-body #invoice-date").attr('disabled', 'disabled');
        $(".modal-body #payment-date").attr('disabled', 'disabled');
        $(".modal-body #invoice-amount").attr('disabled', 'disabled');
      }
      else {
        $(".modal-body #milestone").removeAttr('disabled');
        $(".modal-body #milestone-desc").removeAttr('disabled');
        $(".modal-body #invoice-date").removeAttr('disabled');
        $(".modal-body #payment-date").removeAttr('disabled');
        $(".modal-body #invoice-amount").removeAttr('disabled');
      }

      if(dttype!="Add") {
        $.getJSON("api/getOppInvoices.php?invid="+invid, function (data) {


         $(".modal-body #milestone").val(data['data'][0]['milestone']);
         $(".modal-body #milestone-desc").val(data['data'][0]['milestone_desc']);
         $(".modal-body #invoice-date").val(data['data'][0]['invoice_date']);
         $(".modal-body #payment-date").val(data['data'][0]['payment_date']);
         $(".modal-body #invoice-amount").val(data['data'][0]['invoice_amount']);
         $(".modal-body #invoice-id").val(invid);
         $(".modal-body #operation").val(dttype);
         $(".modal-body #opportunity-id").val(oppId);

       });
     }
     else {
       $(".modal-body #invoice-id").val(invid);
       $(".modal-body #operation").val(dttype);
       $(".modal-body #opportunity-id").val(oppId);

     }

    });

    $('#invoicelist').on('submit', '#invoicefrm' , function (e) {
    //$('#invoicefrm').submit(function() {
        console.log('submit');
        if (!e.isDefaultPrevented()) {
          console.log('submit1');

          var url = "api/updateOppInv.php";
          console.log($('#invoicefrm').serialize());
          if($(".modal-body #operation") === "View"){
            $('#invoicefrm')[0].reset();
            $('#invoicelist').modal( 'hide' );
            return false;
          }

          $.ajax({
              type: "POST",
              url: url,
              data: $('#invoicefrm').serialize(),
              success: function (data)
              {
                  // data = JSON object that contact.php returns
                  console.log("Success");

                  // we recieve the type of the message: success x danger and apply it to the
                  var messageAlert = 'alert-' + data.type;
                  var messageText = data.message;
                  console.log(messageText);

                  // let's compose Bootstrap alert box HTML
                  var alertBox = '<div class="alert ' + messageAlert + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + messageText + '</div>';
                  console.log(alertBox);
                  // If we have messageAlert and messageText
                  if (messageAlert && messageText) {
                      // inject the alert to .messages div in our form
                      $('#opportunity-form').find('.messages').html(alertBox);
                      $(".alert-dismissable").fadeTo(2000, 500).slideUp(500, function(){
                          $(".alert-dismissable").alert('close');
                        });
                        invTable.ajax.reload();
                      // empty the form

                  }
              }
          });
          $('#invoicefrm')[0].reset();
          $('#invoicelist').modal( 'hide' );
          console.log(invTable);

          return false;

        }
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
          <td id="2B1"></div>
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
      <table class="table table-striped">
        <tr>
          <th id="1A4">Opportunity Details</th>
          <td id="1B4" data-type="textarea"></td>
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

<div class="clearfix"></div>
<div class="form-group col-xs-5 col-sm-8 col-md-8 col-lg-8">
  <div class="messages">
  </div>
  <table id="invoices" class="table table-striped"  width="100%">
    <thead>
    <tr>
      <th>Milestone</th>
      <th>Invoice Date</th>
      <th>Payment Date</th>
      <th>Invoice Amount</th>
      <th>
        Action
        <button type="button"  class="btn btn-default pull-right" data-dttype="Add" data-dtinvid="0" data-toggle="modal" data-target="#invoicelist"  aria-label="Left Align">
          <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
        <button type="button" float="right" class="btn btn-default pull-right"  aria-label="Left Align" id="refresh">
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
            <label for="invoice-amount" class="control-label">Invoice Amount</label>
            <input type="number" class="form-control" id="invoice-amount" name="invoice-amount" required>
          </div>
          <div class="form-group">
            <input type="hidden" class="form-control" id="invoice-id" name="invoice-id" >
          </div>
          <div class="form-group">
            <input type="hidden" class="form-control" id="operation" name="operation"  >
          </div>
          <div class="form-group">
            <input type="hidden" class="form-control" id="opportunity-id" name="opportunity-id"  >
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary"  form="invoicefrm">Submit</button>

          </div>
        </form>
      </div>

    </div>
  </div>
</div>


<!-- Invoice Modal  -->
<div class="modal fade" id="fileUpload" tabindex="-1" role="dialog" aria-labelledby="fileUploadLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="fileUploadLabel">Upload Sales Files</h4>
      </div>
      <div class="modal-body">
        <form id="invoicefrm" method="post" action="api/uploadFiles.php" role="form">
          <div class="form-group">
            <label for="milestone" class="control-label">Upload Proposal Document</label>
            <input type="file" class="form-control" id="proposal" name="proposal" required>
          </div>
          <div class="form-group">
            <label for="milestone" class="control-label">Upload Proposal Estimation</label>
            <input type="file" class="form-control" id="estimate" name="estimate" required>
          </div>
          <div class="form-group">
            <input type="hidden" class="form-control" id="opportunity-id" name="opportunity-id"  >
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary"  form="invoicefrm">Submit</button>

          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<?php

require_once('bodyend.php');

?>
