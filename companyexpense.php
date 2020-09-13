<?php
$permission = "VIEW";
require_once('head.php');

require_once('bodystart.php');
?>



<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


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
    fillDropDown("api/getGLLookups.php?type=RGN", "#region", true);

  });

  $(document).ready(function() {

    $(function () {
      $('[data-toggle="tooltip"]').tooltip();
    });



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
  });

  $(document).ready(function() {
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
        {
          "className": "text-right",
          "data": "expense_amt_lcy",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "data": "tran_status"
        },
        {
          "data": "id",
          "render": function(data, type, row, meta) {
            if (type === 'display') {
              // data =
              // '<span data-toggle="modal" data-target="modal">' +
              // '<button type="button" data-toggle="tooltip" data-placement="top" title="Edit Transaction Status" class="btn btn-default" data-dttype="Edit" data-dtinvid="' + data +
              //   '"  data-toggle="modal" data-target="#transtatusdlg" aria-label="Left Align">' +
              //   '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>'+
              //   '</span>';
              //
              data =
              '<div data-toggle="tooltip" data-placement="top" title="Edit Transaction Status">' +
              '<button type="button" data-placement="top"  class="btn btn-default" data-dttype="EditStatus" data-dtexpid="' + data +
                '"  data-toggle="modal" data-target="#transtatusdlg" aria-label="Left Align">' +
                '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>'
                '</div>';
            }
            return data;
          }
        }
      ]

    });


    $('#transtatusdlg').on('show.bs.modal', function(event) {
      console.log('transtatusdlg-show.bs.modal');
      var button = $(event.relatedTarget); // Button that triggered the modal
      var expid = button.data('dtexpid');
      var dttype = button.data('dttype');
      $.getJSON("api/getTransaction.php?expid=" + expid, function(data) {
        $(".modal-body #region").val(data[0]['region_grp']);
        $(".modal-body #expense-date").val(data[0]['gen_date']);
        $(".modal-body #expense-detail").val(data[0]['expense_det']);
        $(".modal-body #expense-ccy").val(data[0]['expense_ccy']);
        $(".modal-body #expense-amount").val(data[0]['expense_amt_ccy']);
        $(".modal-body #transtatus").val(data[0]['tran_status']);
        $(".modal-body #operation").val(dttype);
        $(".modal-body #expense-id").val(expid);

      });


    });


    $('#transtatusdlg').on('submit', '#transtatusfrm', function(e) {
      console.log('transtatusdlg-submit');
      if (!e.isDefaultPrevented()) {
        var url = "api/editExp.php";

      }

    });



  });


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

    console.log("param 1 - " + status);
    console.log("param 0 - " + ExpenseType);

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
          <option value="POST">POST</option>
          <option value="PAID">PAID</option>
          <option value="DELETED">DELETED</option>
        </select>
      </label>
    </div>
    <div class="col-xs-10 col-sm-4 col-md-8 col-lg-4">
      <a href="addcompanyexpense.php" class="btn btn-primary btn-lg float-right" type="button">
        <span class="glyphicon glyphicon-plus"></span>
        Add Company Expenses
      </a>
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
          <th>Expense Amount in LCY</th>
          <th>Transaction Status</th>
          <th>Operations</th>
        </tr>
      </thead>
    </table>
  </div>
  </div>
</form>


<div class="modal fade" id="transtatusdlg" tabindex="-1" role="dialog" aria-labelledby="transtatusdlgLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="transtatusdlgLabel">Edit Transaction Status</h4>
      </div>
      <div class="modal-body">
        <div class="row">
        <form id="transtatusfrm" method="post" action="api/updateExp.php" role="form">
        <table>
          <tr>
          <td>
          <div class="form-group col-md-8">
            <label for="region" class="control-label">Region</label>
            <input type="text" class="form-control" id="region" name="region" readonly>
          </div>
        </td>
        <td>
          <div class="form-group col-md-8">
            <label for="expense-date" class="control-label">Expense Date</label>
            <input type="text" class="form-control" id="expense-date" name="expense-date" readonly>
          </div>
        </td>


      <td>
          <div class="form-group col-md-8">
            <label for="expense-detail" class="control-label">Expense details</label>
            <textarea  class="form-control" id="expense-detail" name="expense-detail" readonly ></textarea>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="form-group col-md-8">
            <label for="expense-ccy" class="control-label">Expense Currency</label>
            <input type="text" class="form-control" id="expense-ccy" name="expense-ccy" readonly>
          </div>
        </td>
        <td>
          <div class="form-group col-md-8">
            <label for="expense-amount" class="control-label">Expense Amount</label>
            <input type="number" class="form-control text-right" id="expense-amount" name="expense-amount" readonly>
          </div>
        </td>

      </tr>
      <tr>
        <td>
          <div class="form-group col-md-8">
            <label for="transtatus" class="control-label">Transaction Status</label>
            <select id="transtatus" name="transtatus" class="form-control" required>
              <option value="ENTERED">ENTERED</option>
              <option value="POST">POST</option>
              <option value="PAID">PAID</option>
              <option value="DELETED">DELETED</option>
            </select>
          </div>
        </td>
        </tr>
      </table>

          <div class="form-group">
            <input type="hidden" class="form-control" id="expense-id" name="expense-id">
          </div>
          <div class="form-group">
            <input type="hidden" class="form-control" id="operation" name="operation">
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
</div>

<?php

require_once('bodyend.php');

?>
