<?php
$permission = "VIEW";
require_once('head.php');

require_once('bodystart.php');
?>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script type="text/javascript">

$(function() {

    var start = moment().startOf('year').add(3,'month');
    var end = moment().endOf('year').add(3,'month');

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
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

  var table;
  var status;
  var ExpenseType;
  $(document).ready(function() {
    //refreshTable();
    fillDropDown("api/getGLLookups.php?type=EXP", "#expenseType", true);
  });

  $(document).ready(function() {
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
          "data": "expense_amt_ccy"
        },
        {
          "data": "expense_amt_lcy"
        },
        {
          "data": "tran_status"
        },
        {
          "data": "id",
          "render": function(data, type, row, meta) {
            if (type === 'display') {
              data = '<a href="viewtransaction.php?tran_id=' + data + '">View</a>';
            }
            return data;
          }
        }
      ]

    });



  });


  function refreshTable() {

    var stat = "";
    $('#expenseType :selected').each(function(i, sel) {
      stat = "" + $(sel).val() + " " + stat;

    });
    ExpenseType = stat.search("999") != -1 ? "" : stat.trim().replace(/ /g, ',');


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
    <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
      <label class="control-label" for="status">Expense Type</label>
      <select id="expenseType" name="expenseType" class="form-control" multiple="multiple">
        <option value="999">ALL</option>
      </select>
    </div>
    <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
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
    <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
      <a href="addcompanyexpense.php" class="btn btn-primary btn-lg float-right" type="button">
        <span class="glyphicon glyphicon-plus"></span>
        Add Company Expenses
      </a>
    </div>
    <div class="clearfix"></div>
    <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
      <label class="control-label" for="reportrange">Value Date Range</label>

    <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
      <i class="fa fa-calendar"></i>&nbsp;
      <span></span> <i class="fa fa-caret-down"></i>
    </div>
  </div>
<div class="clearfix"></div>

    <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">

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

<?php

require_once('bodyend.php');

?>
