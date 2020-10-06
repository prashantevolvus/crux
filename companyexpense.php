<?php
$permission = "VIEW";
require_once('head.php');

require_once('bodystart.php');
?>





<script type="text/javascript">


  var table;
  var status;
  var ExpenseType;
  var region;
  var startDT;
  var endDT;
  $(document).ready(function() {
    //refreshTable();
    fillDropDown("api/getGLLookups.php?type=EXP", "#expenseType", true);
    fillDropDown("api/getGLLookups.php?type=RGNGRP", "#region", true);

    fillDropDown("api/getGLLookups.php?type=RGN", "#region-cr", true);
    fillDropDown("api/getGLLookups.php?type=EXP", "#expense-type-cr", true);
    fillDropDown("api/getGLLookups.php?type=PNL", "#pnl-line-cr", true);
    fillDropDown("api/getGLLookups.php?type=PC", "#profit-centre-cr", true);




    $(function () {
      $('[data-toggle="tooltip"]').tooltip({
        trigger : 'hover'
      });
    });


    //Datepicker code
    $(function() {

        var start = moment().startOf('year').add(3,'month');
        var end = moment().endOf('year').add(3,'month');

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            startDT = start.format('YYYY-MM-DD');
            endDT = end.format('YYYY-MM-DD');

        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
               'Today': [moment(), moment()],
               'This Financial Year': [moment().startOf('year').add(3,'month'), moment().endOf('year').add(3,'month')],
               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

    });

    //Export Excel
    var tableToExcel = (function() {
        var uri = 'data:application/vnd.ms-excel;base64,',
          template =
          '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
          base64 = function(s) {
            return window.btoa(unescape(encodeURIComponent(s)))
          },
          format = function(s, c) {
            return s.replace(/{(\w+)}/g, function(m, p) {
              return c[p];
            })
          }
        return function(table, name, filename) {
          if (!table.nodeType) table = document.getElementById(table)
          var ctx = {
            worksheet: name || 'Worksheet',
            table: table.innerHTML
          }

          document.getElementById("dlink").href = uri + base64(format(template, ctx));
          document.getElementById("dlink").download = filename;
          document.getElementById("dlink").click();

        }
      })()

    $('#det').click(function() {
      refreshTable();
    });

    createOrShowTable();


    $('#transcreatedlg').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget); // Button that triggered the modal
      var expid = button.data('dtexpid');
      var dttype = button.data('dttype');
      $.getJSON("api/getTransaction.php?expid=" + expid, function(data) {

        $(".modal-body #expense-type-cr").val(data[0]['expense_type_id']);
        $(".modal-body #pnl-line-cr").val(data[0]['pnl_line_id']);
        $(".modal-body #profit-centre-cr").val(data[0]['pc_id']);

        $(".modal-body #direct-expense-cr").prop("checked",data[0]['direct_expense']==="1");
        $(".modal-body #capex-cr").prop("checked",data[0]['capex']==="1");


        $(".modal-body #region-cr").val(data[0]['opp_region_id']);
        $(".modal-body #expense-date-cr").val(data[0]['gen_date']);
        $(".modal-body #expense-detail-cr").val(data[0]['expense_det']);
        $(".modal-body #remarks-cr").val(data[0]['remarks']);

        $(".modal-body #expense-ccy-cr").val(data[0]['expense_ccy']);
        $(".modal-body #expense-amount-cr").val(data[0]['expense_amt_ccy']);
        $(".modal-body #expense-amount-lcy-cr").val(data[0]['expense_amt_lcy']);
        $(".modal-body #transtatus-cr").val(data[0]['tran_status']);
        $(".modal-body #operation").val(dttype);
        $(".modal-body #expense-id-cr").val(expid);

      });
      var modal = $(this);
      if(dttype == "EditStatus"){
        disbableForm(true);
        $(".modal-body #transtatus-cr").removeAttr("disabled");
        modal.find('.modal-title').text('Edit Transaction Status');
        setTimeout(function (){
                $(".modal-body #transtatus-cr").focus();
            }, 1000);

      }
      if(dttype == "EditTran"){
        disbableForm(false);
        modal.find('.modal-title').text('Edit Transaction Details');
        setTimeout(function (){
                $('#region-cr').focus();
            }, 500);


      }
      if(dttype == "CreateTran"){
        disbableForm(false);
        modal.find('.modal-title').text('Create New Transaction Details');
        setTimeout(function (){
                $('#region-cr').focus();
            }, 500);

      }





    });

    function disbableForm(disable){
      if(disable===true){
        $("#expense-type-cr").attr("disabled", "disabled");
        $("#pnl-line-cr").attr("disabled", "disabled");
        $("#profit-centre-cr").attr("disabled", "disabled");
        $("#direct-expense-cr").attr("disabled", "disabled");
        $("#capex-cr").attr("disabled", "disabled");
        $("#region-cr").attr("disabled", "disabled");
        $("#expense-date-cr").attr("disabled", "disabled");
        $("#expense-detail-cr").attr("disabled", "disabled");
        $("#remarks-cr").attr("disabled", "disabled");
        $("#expense-ccy-cr").attr("disabled", "disabled");
        $("#expense-amount-cr").attr("disabled", "disabled");
        $("#expense-amount-lcy-cr").attr("disabled", "disabled");
        $("#transtatus-cr").attr("disabled", "disabled");
      }
      else{
        $("#expense-type-cr").removeAttr("disabled");
        $("#pnl-line-cr").removeAttr("disabled");
        $("#profit-centre-cr").removeAttr("disabled");
        $("#direct-expense-cr").removeAttr("disabled");
        $("#capex-cr").removeAttr("disabled");
        $("#region-cr").removeAttr("disabled");
        $("#expense-date-cr").removeAttr("disabled");
        $("#expense-detail-cr").removeAttr("disabled");
        $("#remarks-cr").removeAttr("disabled");
        $("#expense-ccy-cr").removeAttr("disabled");
        $("#expense-amount-cr").removeAttr("disabled");
        $("#expense-amount-lcy-cr").removeAttr("disabled");
        $("#transtatus-cr").removeAttr("disabled");
      }

    }

    //Create Transaction details dialog on submit
    $('#transcreatedlg').on('submit', '#transcrfrm', function(e) {
      /* Get input values from form */
      disbableForm(false);
      values = jQuery("#transcrfrm").serializeArray();
      console.log("values  "+values);
      /* Because serializeArray() ignores unset checkboxes and radio buttons: */
      values = values.concat(
              jQuery('#transcrfrm input[type=checkbox]:not(:checked)').map(
                      function() {
                          return {"name": this.name, "value": "off"}
                      }).get()
      );
      if (!e.isDefaultPrevented()) {
        var url = "api/editExp.php";
        $.ajax({
          type: "POST",
          url: url,
          data: values,
          success: function(data) {
            console.log(data);
            if(data.trim() === "SUCCESS"){
              ic = 'success';
              txt = 'Transaction Details Updated Successfully';
            }
            else {
              ic = 'error';
              txt = 'Transaction Details Update Failed';
            }
            Swal.fire({
              // position: 'top-end',
              icon: ic,
              title: txt,
              showConfirmButton: false,
              timer: 2000
            });
          }
        });
        $('#transcreatedlg').modal("hide");
        $('#transcrfrm')[0].reset();
        refreshTable();
        return false;

      }

    });

  });


  function createOrShowTable() {
    table = $('#transaction').DataTable({
      "pagingType": "full_numbers",
      "lengthMenu": [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, "All"]
      ],
      "pageLength": 50,
      "autoWidth": true,
      "order": [],
      "orderMulti": true,
      "ajax": {
        url: "api/getTransactionList.php",
        "dataSrc": "",
        data: function(d) {
           d.status = status;
           d.expensetype = ExpenseType;
           d.start = startDT;
           d.end = endDT;
           d.region = region;
        }
      },
      "columns": [{
          "data": "region_grp"
        },
        {
          "data": "expense_type"
        },
        {
          "data": "gen_date"
        },
        {
          "data": "expense_det"
        },
        {
          "data": "expense_ccy"
        },
        {
          "className": "text-right",
          "data": "expense_amt_ccy",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        // {
        //   "className": "text-right",
        //   "data": "expense_amt_lcy",
        //   "render": function(data, type, row, meta) {
        //     return amtFormat(data);
        //   }
        // },
        {

          "data": "tran_status"
        },
        {
          "className": "side-by-side",
          "data": "id",
          "render": function(data, type, row, meta) {
            if (type === 'display') {

              data =
              '<span data-toggle="tooltip" data-placement="left" title="Edit Transaction Status">'+
              '<button type="button"   class="btn btn-default" data-dttype="EditStatus" '+
              ' data-dtexpid="' + data +
                '"  data-toggle="modal" data-target="#transcreatedlg" aria-label="Left Align">' +
                '<span class="glyphicon glyphicon-check" aria-hidden="true">' +
                '</span>'+
                '</button> </span>'+
                '<span data-toggle="tooltip" data-placement="left" title="Edit Transaction Details">'+
                '<button type="button" data-placement="top"  class="btn btn-default" data-dttype="EditTran" '+
                'data-dtexpid="' + data +
                  '"  data-toggle="modal" data-target="#transcreatedlg" aria-label="Left Align">' +
                  '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>'+
                  '</button> </span>'+
                  '<span data-toggle="tooltip" data-placement="right" title="Copy Transaction Details">'+
                  '<button type="button" data-placement="top"  class="btn btn-default" data-dttype="CreateTran" '+
                  'data-dtexpid="' + data +
                    '"  data-toggle="modal" data-target="#transcreatedlg" aria-label="Left Align">' +
                    '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>'+
                    '</button> </span>';

            }
            return data;
          }
        }
      ]

    });

  }


  function refreshTable() {

    var stat = "";
    $('#expenseType :selected').each(function(i, sel) {
      stat = "" + $(sel).val() + " " + stat;

    });
    ExpenseType = stat.search("999") != -1 ? "" : stat.trim().replace(/ /g, ',');

    stat = "";
    $('#region :selected').each(function(i, sel) {
      stat = "" + $(sel).val() + " " + stat;

    });
    region = stat.search("999") != -1 ? "" : stat.trim().replace(/ /g, ',');


    stat = "";
    $('#status :selected').each(function(i, sel) {
      stat = "'" + $(sel).val() + "' " + stat;

    });
    status = stat.search("999") != -1 ? "" : stat.trim().replace(/ /g, ',');



    table.ajax.reload();



  }


</script>

<legend>Company Expense Information</legend>

<div class="row">
  <form id="opportunity-search">
    <div class="form-group col-xs-10 col-sm-4 col-md-8 col-lg-4">
      <label class="control-label" for="status">Expense Type</label>
      <select id="expenseType" name="expenseType" class="form-control" multiple="multiple">
        <option value="999">ALL</option>
      </select>
    </div>
    <div class="form-group col-xs-10 col-sm-4 col-md-8 col-lg-4">
      <label class="control-label" for="status">Status</label>
        <select id="status" name="status" class="form-control" multiple="multiple">
          <option value="999">ALL</option>
          <option value="ENTERED">ENTERED</option>
          <option value="POSTED">POSTED</option>
          <option value="PAID">PAID</option>
          <option value="DELETED">DELETED</option>
        </select>
      </label>
    </div>

    <div class="clearfix"></div>
    <div class="form-group col-xs-10 col-sm-4 col-md-8 col-lg-4">
      <label class="control-label" for="status">Region</label>
      <select id="region" name="region" class="form-control" multiple="multiple">
        <option value="999">ALL</option>
      </select>
    </div>
    <div class="form-group col-xs-10 col-sm-4 col-md-8 col-lg-4">
      <label class="control-label" for="reportrange">Value Date Range</label>

      <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
      <i class="fa fa-calendar glyphicon glyphicon-calendar"></i>&nbsp;
      <span></span> <i class="fa fa-caret-down"></i>
  </div>
  </div>

<div class="clearfix"></div>

    <div class="col-xs-10 col-sm-4 col-md-8 col-lg-4">

      <button id="det" name="det" type="button" class="btn btn-primary btn-sm">
        <span class="glyphicon glyphicon-search"></span>
        Search
      </button>


    </div>
  </form>
</div>



<br>
<form>


  <div id="tableholder">
    <input type="button" class="btn btn-default" onclick="tableToExcel('opportunity', 'Crux Report', 'cruxReport.xls')" value="Export to MS Excel">
    <a id="dlink" style="display:none;"></a>
    <div class="clearfix"></div><br>
    <table id="transaction" class="table table-striped" width="100%">
      <thead>
        <tr>
          <th>Region</th>
          <th>Expense Type</th>
          <th>Value Date</th>
          <th>Expense Details</th>
          <th>Expense Currency</th>
          <th>Expense Amount</th>
          <!-- <th>Expense Amount in LCY</th> -->
          <th>Transaction Status</th>
          <th>Operations</th>
        </tr>
      </thead>
    </table>
  </div>
  </div>
</form>



<div class="modal fade" id="transcreatedlg" tabindex="-1" role="dialog" aria-labelledby="transcreatedlgLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="transcreatedlgLabel">Create Transaction</h4>
      </div>
      <div class="modal-body">
        <div class="row">
        <form id="transcrfrm" method="post" action="api/editExp.php" role="form">

          <div class="table-responsive col-md-4 form-group">
            <label for="region-cr" class="control-label">Region</label>
            <select  class="form-control" id="region-cr" name="region-cr"></select>
          </div>

          <div class="table-responsive col-md-4 form-group">
            <label for="expense-type-cr" class="control-label">Expense Type</label>
            <select  class="form-control" id="expense-type-cr" name="expense-type-cr" ></select>
          </div>

          <div class="table-responsive col-md-4 form-group">
            <label for="profit-centre-cr" class="control-label">Profit Centre</label>
            <select  class="form-control" id="profit-centre-cr" name="profit-centre-cr"></select>
          </div>

          <div class="clearfix"></div>

          <div class="table-responsive col-md-6 form-group">
            <label for="pnl-line-cr" class="control-label">PNL Line</label>
            <select  class="form-control" id="pnl-line-cr" name="pnl-line-cr"></select>
          </div>

          <div class="container">
            <div class="row">
              <div class="table-responsive col-md-2 form-group">
                <input type="checkbox"  class="form-check-input" id="direct-expense-cr" name="direct-expense-cr" >
                <label for="direct-expense-cr" class="control-label">Direct Expense</label>
              </div>

              <div class="table-responsive col-md-2 form-group">
                <input type="checkbox"  class="form-check-input" id="capex-cr" name="capex-cr" >
                <label for="capex-cr" class="control-label">CAPEX</label>
              </div>
            </div>
          </div>



          <div class="clearfix"></div>




          <div class="table-responsive col-md-4 form-group">
            <label for="expense-date-cr" class="control-label">Expense Date</label>
            <input type="date" class="form-control" id="expense-date-cr" name="expense-date-cr" required>
          </div>

          <div class="table-responsive col-md-4 form-group">
            <label for="expense-detail-cr" class="control-label">Expense details</label>
            <textarea  class="form-control" id="expense-detail-cr" name="expense-detail-cr"  required></textarea>
          </div>

          <div class="table-responsive col-md-4 form-group">
            <label for="remarks-cr" class="control-label">Remarks</label>
            <textarea  class="form-control" id="remarks-cr" name="remarks-cr"  required></textarea>
          </div>

          <div class="table-responsive col-md-4 form-group">
            <label for="expense-ccy-cr" class="control-label">Expense Currency</label>
            <select class="form-control" id="expense-ccy-cr" name="expense-ccy-cr" >
              <option value="INR">Indian Rupees</option>
              <option value="AED">United Arab Dhirams</option>
              <option value="USD">US Dollars</option>
            </select>
          </div>
          <div class="table-responsive col-md-4 form-group">
            <label for="expense-amount-cr" class="control-label">Expense Amount</label>
            <input type="number" step=".01"  class="form-control text-right" id="expense-amount-cr" name="expense-amount-cr" required>
          </div>
          <div class="table-responsive col-md-4 form-group">
            <label for="expense-lcy-amount-cr" class="control-label">Expense Amount in LCY</label>
            <input type="number" step=".01" class="form-control text-right" id="expense-amount-lcy-cr" name="expense-amount-lcy-cr" required>
          </div>
          <div class="clearfix"></div>

          <div class="table-responsive col-md-4 form-group">
            <label for="transtatus-cr" class="control-label">Transaction Status</label>
            <select id="transtatus-cr" name="transtatus-cr" class="form-control" required>
              <option value="ENTERED">ENTERED</option>
              <option value="POSTED">POSTED</option>
              <option value="PAID">PAID</option>
              <option value="DELETED">DELETED</option>
            </select>
          </div>
          <div class="clearfix"></div>


          <div class="form-group">
            <input type="hidden" class="form-control" id="expense-id-cr" name="expense-id-cr">
          </div>
          <div class="form-group">
            <input type="hidden" class="form-control" id="operation" name="operation">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" form="transcrfrm">Submit</button>

          </div>
        </form>
      </div>
    </div>

    </div>
  </div>
</div>

<?php

require_once('bodyend.php');

?>
