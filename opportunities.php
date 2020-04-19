<?php
$permission = "VIEW";
require_once('head.php');

require_once('bodystart.php');
?>

<script type="text/javascript">


var tableToExcel = (function () {
        var uri = 'data:application/vnd.ms-excel;base64,'
        , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
        , base64 = function (s) { return window.btoa(unescape(encodeURIComponent(s))) }
        , format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }
        return function (table, name, filename) {
            if (!table.nodeType) table = document.getElementById(table)
            var ctx = { worksheet: name || 'Worksheet', table: table.innerHTML }

            document.getElementById("dlink").href = uri + base64(format(template, ctx));
            document.getElementById("dlink").download = filename;
            document.getElementById("dlink").click();

        }
    })()

  var table;
  var active;
  var stage;
    $(document).ready(function(){
      //refreshTable();
      fillDropDown("api/getSalesStage.php","#salesStage",true);
    });

    $(document).ready( function () {
    $('#det').click(function () {
    	refreshTable();
    });
    });

  $(document).ready( function () {
   table =  $('#opportunity').DataTable({
      "pagingType": "full_numbers",
      "lengthMenu": [ [10, 25, 50, 100,-1], [10, 25, 50, 100,"All"] ],
      "pageLength": 50,
      "autoWidth": true,
       "order": [],
      "orderMulti": true,
      "ajax": {
          url: "api/getOpportunityList.php",
          data: function(d){
            d.active = active;
            d.salesstage = stage;
          }
        }
        ,
      "columns": [
            { "data": "name"} ,
            { "data": "opp_name"} ,
            { "data": "current_quote"} ,
            { "data": "no_regret_quote"} ,
            { "data": "start_date"} ,
            { "data": "expected_close_date"} ,
            { "data": "sales_stage"}
            ,
            {
               "data": "id",
               "render": function(data, type, row, meta){
                  if(type === 'display'){
                      data = '<a href="viewopportunity.php?oppid=' + data + '">View</a>';
                  }
                  return data;
                }
            }
          ]

    });



  });


    function refreshTable(){
      var checkBox = document.getElementById("oppCheck");
      if (checkBox.checked == true){
        active=1;
      } else {
        active='';
      }
      var stat="";
      $('#salesStage :selected').each(function(i, sel){
        stat=""+$(sel).val()+" "+stat;

        });
        stage = stat.search("0") != -1 ? "" : stat.trim().replace(/ /g,',');
        console.log("param 1 - " + stage);
        console.log("param 0 - " + active);

        table.ajax.reload();



    }

    jQuery.ajaxSetup({
      beforeSend: function() {
         $('#loader').show();
         $('#tableholder').hide();

      },
      complete: function(){
         $('#loader').hide();
         $('#tableholder').show();

      },
      success: function() {}
    });


</script>

<legend>Sales Opportunities Information</legend>

<div class="row">
<form id="opportunity-search">
  <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
    <label class="control-label" for="status">Status</label>
    <select id="salesStage" name="salesStage" class="form-control" multiple="multiple">
      <option value="0">All</option>
    </select>
  </div>
  <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
    <label for="Active-0">
      <input type="checkbox" name="Active" id="oppCheck" value="1">
        Active
    </label>
  </div>
  <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                <a href="addopportunities.php"  class="btn btn-primary btn-lg float-right"
                        type="button">
                        <span class="glyphicon glyphicon-plus"></span>
                     Add Opportunities
                </a>
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

      <div id="loader1">
        <img id="loader" src="images/spinner.gif" style="display:none;"/>
      </div>
      <div id="tableholder">
        <input type="button" class="btn btn-default" onclick="tableToExcel('opportunity', 'Crux Report', 'cruxReport.xls')" value="Export to MS Excel">
        <a id="dlink"  style="display:none;"></a>
        <div class="clearfix"></div><br>
        <table id="opportunity" class="table table-striped"  width="100%">
          <thead>
            <tr>
              <th>Customer Name</th>
              <th>Opportunity Name</th>
              <th>Current Quote</th>
              <th>No Regret Quote</th>
              <th>Start Date</th>
              <th>Expected Close Date</th>
              <th>Sales Stage</th>
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
