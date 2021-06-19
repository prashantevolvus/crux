<?php
$permission = "VIEW";
require_once('head.php');

require_once('bodystart.php');
?>


<script type="text/javascript">

let invoiceChangedList = [];
let invoiceList = [];

  $(document).ready(function() {
    let chkBox = new Map();
    chkBox.set('indiaCHK',true);
    chkBox.set('meCHK',true);
    chkBox.set('poCHK',true);
    chkBox.set('hpCHK',true);
    chkBox.set('pCHK',false);
    chkBox.set('sCHK',false);
    chkBox.set('lCHK',false);
    chkBox.set('pastCHK',false);
    chkBox.set('modified',false);//Not checkbox but using the map


    var cfTable1RemArr = [];
    var cfTable2RemArr = [];
    var cfTable3RemArr = [];
    var revenueArr = Array(12).fill(0);
    var expenseArr = [];




    // Initialize popover component
    $(function () {
      $('[data-toggle="popover"]').popover({
        html: true,
        trigger: 'manual'
      }).click(function(e) {
        $(this).popover('toggle');
        e.preventDefault();
      });
    });



    //Draw Summary Expense table
    cfTable1 = $('#cfl-1').DataTable({
      "searching": false,
      "bInfo" : false,
      "ordering": false,
      "paging": false,
      "cache": true,
      "ajax": {
        url: 'api/getGLData.php?qryid=2',
        "dataSrc": ""
      },
      rowCallback: function( row, data, index ) {
        cfTable1RemArr[index]=true;
        $(row).show();
        if (chkBox.get('indiaCHK') == false && (data['region_name'] == "India" || data['region_name'] == "TOTAL")  ) {
          $(row).hide();
          cfTable1RemArr[index]=false;
          //api.row(index).remove().draw();
        }
        if (chkBox.get('meCHK')    == false && (data['region_name'] == "Middle East" || data['region_name'] == "TOTAL") ) {
          $(row).hide();
          cfTable1RemArr[index]=false;
        }
      },
      "columns": [{
          "data": "region_name"
        },
        {
          "className": "text-right",
          "data": "M0",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M1",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M2",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M3",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M4",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M5",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M6",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M7",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M8",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M9",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M10",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M11",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M12",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        }

      ]
    });

    //Draw Revenue Table
    cfTable3 = $('#cfl-3').DataTable({
      "searching": false,
      "bInfo" : false,
      "ordering": false,
      "paging": false,
      "cache": true,
      "ajax": {
        url: "api/getGLData.php?qryid=3",
        "dataSrc": ""
      },
      "footerCallback": function(row, data, start, end, display) {
        var api = this.api();
        //$(this).deleteTFoot();
        //var footer = $(this).append('<tfoot><tr></tr></tfoot>');
        //revenueArr.splice(0, revenueArr.length);
        for(var m = 2; m<14;m++) {
          var i = 0;
          var x = api.column(m).data().reduce( function ( a, b ) {
              if(cfTable3RemArr[i] == true){
                i++;
                return parseFloat(a) + parseFloat(b);
              }
              else {
                i++;
                return parseFloat(a);
              }
          }, 0 );
          //revenueArr.push(x);

        }

      },
      rowCallback: function( row, data, index ) {
        cfTable3RemArr[index]=true;
        $(row).show();
        if (chkBox.get('indiaCHK') == false && (data['region_name'] == "India" || data['region_name'] == "TOTAL")  ) {
          $(row).hide();
          cfTable3RemArr[index]=false;
        }
        if (chkBox.get('meCHK')    == false && (data['region_name'] == "Middle East" || data['region_name'] == "TOTAL") ) {
          $(row).hide();
          cfTable3RemArr[index]=false;
        }
        if (chkBox.get('poCHK')    == false && (data['Opp_Status'] == "AWAITING PO" ) ) {
          $(row).hide();
          cfTable3RemArr[index]=false;
        }
        if (chkBox.get('hpCHK')    == false && (data['Opp_Status'] == "HOT PROSPECT" ) ) {
          $(row).hide();
          cfTable3RemArr[index]=false;
        }
        if (chkBox.get('pCHK')    == false && (data['Opp_Status'] == "PROSPECT" ) ) {
          $(row).hide();
          cfTable3RemArr[index]=false;
        }
        if (chkBox.get('sCHK')    == false && (data['Opp_Status'] == "SUSPECT" ) ) {
          $(row).hide();
          cfTable3RemArr[index]=false;
        }
        if (chkBox.get('lCHK')    == false && (data['Opp_Status'] == "LEAD" ) ) {
          $(row).hide();
          cfTable3RemArr[index]=false;
        }
      },
      "columns": [{
          "data": "region_name"
        },
        {
          "data": "Opp_Status"
        },
        {
          "className": "text-right",
          "data": "M1",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M2",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M3",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M4",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M5",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M6",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M7",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M8",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M9",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M10",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M11",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M12",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        }

      ]
    });

    //Draw Detailed Expense table
    cfTable2 = $('#cfl-2').DataTable({
      "searching": true,
      "bInfo" : false,
      "ordering": false,
      "paging": false,
      "cache": true,
      "ajax": {
        url: "api/getGLData.php?qryid=1",
        "dataSrc": ""
      },
      rowCallback: function( row, data, index ) {
        cfTable2RemArr[index]=true;
        $(row).show();
        if (chkBox.get('indiaCHK') == false && (data['region_name'] == "India" || data['region_name'] == "TOTAL")  ) {
          $(row).hide();
          cfTable2RemArr[index]=false;
        }
        if (chkBox.get('meCHK')    == false && (data['region_name'] == "Middle East" || data['region_name'] == "TOTAL") ) {
          $(row).hide();
          cfTable2RemArr[index]=false;
        }
      },
      "columns": [{
          "data": "region_name"
        },
        {
          "data": "expense_det"
        },
        {
          "className": "text-right",
          "data": "M0",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M1",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M2",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M3",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M4",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M5",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M6",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M7",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M8",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M9",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M10",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M11",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        },
        {
          "className": "text-right",
          "data": "M12",
          "render": function(data, type, row, meta) {
            return amtFormat(data);
          }
        }

      ]
    });


    //set map  to hide or show a row based on check box abd then redraw all tables
    $('#cashflow-form :checkbox').change(function() {
      chkBox.set($(this).attr('id') , $(this).is(':checked'));
      $.when( getInvoiceList(chkBox)).then(function(){
        fillRevenueArray(revenueArr);
        updateData(expenseArr,revenueArr,chkBox);
      });
    });

    //When Tab is changed
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
      updateCashflowTable(expenseArr,revenueArr,chkBox);
    });


    //This fellow changes the header from M1, M2.... Current month, current month + 1.....
    $(".mnthTBL").each(function(){
      $(this).find('thead th').each((th_idx,th) => {
        if($(th).text().slice(0,1) == "M") {
             const dt = new Date();
             var a = $(th).text().slice(1);
             dt.setMonth(  dt.getMonth()+parseInt(a)-1 );
             const month = dt.toLocaleString('default', { month: 'long' });
             const year = String(dt.getFullYear());
             $(th).text(month.slice(0,3)+'-'+year.substr(-2,2));

        }
      });
    });


    //Show the list of invoice on double click of revenue cells
    $('#cfl-0').on( 'dblclick', 'tr', function (e) {
      if(e.currentTarget.rowIndex!=1)
        return;

      showInvoiceList(invoiceList.filter(item => item["MX"] == "M"+e.target.cellIndex));
    });


    //When the date is changed
    $(document).on('input', ".testdate", function (e) {

      var x1 = new Date(e.target.value);
      var newDate = new Date(x1.getFullYear(),x1.getMonth(),1);
      var x1 = new Date(e.target.dataset["prevdate"]);
      var prevDate = new Date(x1.getFullYear(),x1.getMonth(),1);
      var x1 = new Date();
      var currDate = new Date(x1.getFullYear(),x1.getMonth(),1);

      newMonth = newDate.getMonth() - currDate.getMonth() + (12 * (newDate.getFullYear() - currDate.getFullYear()));
      prevMonth = prevDate.getMonth() - currDate.getMonth() + (12 * (prevDate.getFullYear() - currDate.getFullYear()));

      var x = invoiceChangedList.find(item => item["idkey"]===e.target.id);
      if(x){
        x["change_paid_date"] = e.target.value;
        x["MX"] = "M"+(newMonth+1);
      }
      else{
        var x = {
          "idkey" : e.target.id,
          "change_paid_date" : e.target.value,
          "MX" : "M"+(newMonth+1)
        };
        invoiceChangedList.push(x);
        chkBox.set('modified',true);

      }
      var y = invoiceList.find(item => item["idkey"]===e.target.id);
      if(y){
        y["change_paid_date"] = e.target.value;
        y["MX"] = "M"+(newMonth+1);
      }
    });

    //When the invoice list modal dialog is closed
    $('#invoicelist').on('hidden.bs.modal', function () {
      fillRevenueArray(revenueArr);
      updateCashflowTable(expenseArr,revenueArr,chkBox,);
    });

    //call Invoicelist and then draw tables
    $.when( getInvoiceList(chkBox)).then(function(){
      fillRevenueArray(revenueArr);
      updateData(expenseArr,revenueArr,chkBox);
    });

    //Click on reset button to clear all what Ifs
    $('#resettbl').on('click', function(event) {
        invoiceChangedList.splice(0);
        $.when( getInvoiceList(chkBox)).then(function(){
          fillRevenueArray(revenueArr);
          updateData(expenseArr,revenueArr,chkBox);
        });
        $( "#modified" ).hide();
        chkBox.set('modified',false);

    });

  });//End of ready

//From the invoicelist array build revenue array
function fillRevenueArray(revenueArr){
  revenueArr.forEach(function(item,index){
    x = invoiceList.reduce(function(total,value){
            t = parseFloat(total);

            if("M"+(index+1) === value["MX"]){
              t += parseFloat(value["lcy_amount"]);
            }
            return t;
         },0);

    revenueArr[index] = x;
  });
}

//For the check boxes get all the invoices and keep in array.
//Better than going to server
function getInvoiceList(chkBox){
  var dfd = jQuery.Deferred();
  var rgnArr = [];
  var stsArr = ['WON'];

  if(chkBox.get('indiaCHK')) rgnArr.push('India');
  if(chkBox.get('meCHK')) rgnArr.push('Middle East');

  if(chkBox.get('poCHK')) stsArr.push('Awaiting PO');
  if(chkBox.get('hpCHK')) stsArr.push('Hot Prospect');
  if(chkBox.get('pCHK')) stsArr.push('Prospect');
  if(chkBox.get('sCHK')) stsArr.push('Suspect');
  if(chkBox.get('lCHK')) stsArr.push('Lead');

  var OnSuccess = function(data){
    invoiceChangedList.forEach(function(chgItem){
        var x = data.find(item => item["idkey"]===chgItem["idkey"]);
        if(x){
          x["change_paid_date"] = chgItem["change_paid_date"];
          x["MX"] = chgItem["MX"];
        }

    });
    invoiceList = data;
    dfd.resolve( "Done" );

  }
  $.getJSON( "api/getCashflowRevenue.php",
    {
      oppStatus:"'" + stsArr.join("','") + "'",
      region:"'" + rgnArr.join("','") + "'"
    },OnSuccess);
  return dfd.promise();
}

//Render tables in all the the tabs
function updateData(expenseArr,revenueArr,chkBox){
  $( ".srvTBL" ).each(function(){
    $(this).DataTable().draw();
  });
  updateCashflowTable(expenseArr,revenueArr,chkBox,true);

}

//table in the Cashflow tab gets rendered here
function updateCashflowTable(expenseArr,revenueArr,chkBox,updRev=false){

  //SHow/hide modified
  if(chkBox.get('modified') ){
    $( "#modified" ).show();
    $( "#chgpopup").attr("data-content",$( "#changestbl").html());
  }
  else{
    $( "#modified" ).hide();
  }

  //This will delete all elements
  expenseArr.splice(0, expenseArr.length);
  var clone = jQuery("#cfl-1").clone(true);
  clone[0].setAttribute('id', 'cfl-1A');
  clone.appendTo('#cloneexp');

  $("tr:visible:last",$("#cfl-1A")).map(function(){
    return [$("td",this).map(function() {
      return this.innerHTML;
    }).get()];
  }).get().forEach((item, i) => {
    var retArr1 = item.slice(1).map((val) => {
      return parseFloat(val.replace(/,/g,''));
    });
    if(chkBox.get('pastCHK') == false)
      retArr1[1] +=  retArr1[0];
    expenseArr =  retArr1.slice(1);
  });

  $('#cloneexp').empty();
  $("#cfl-0 > tbody").empty();
  markup = "<tr><th>Total Revenue</th>";
  markupRev = "";

  revenueArr.forEach((item, i) => {
    markupRev += "<td class='text-right'>"+amtFormat(item)+"</td>";
  });
  markup += markupRev + "</tr>";

  markup += "<tr><th>Total Expense</th>";
  expenseArr.forEach((item, i) => {
    markup += "<td class='text-right'>"+amtFormat(item)+"</td>";
  });
  markup += "</tr>";

  markup += "<tr><th>Total Cashflow</th>";
  expenseArr.forEach((item, i) => {
    markup += "<td class='text-right'>"+amtFormat(parseFloat(revenueArr[i]-item))+"</td>";
  });
  markup += "</tr>";

  markup += "<tr><th>Cumulative Cashflow</th>";
  prevCashflow = 0;

  expenseArr.forEach((item, i) => {
    prevCashflow = parseFloat(prevCashflow + revenueArr[i]-item)
    if(prevCashflow >= 0) {
      markup += "<td class='text-right'>"+amtFormat(prevCashflow)+"</td>";
    }
    else {
      markup += "<td class='text-right danger'>"+amtFormat(prevCashflow)+"</td>";
    }
  });

  markup += "</tr>";
  $("#cfl-0 tbody").parent().append(markup);

  if(updRev){
    markup = "<tr><th>Total Revenue</th><td></td>";
    markup += markupRev + "</tr>";
    $("#cfl-3 tbody").parent().append(markup);
  }


}//end of updateCashflowTable

//Render the Invoice list modalbox
function showInvoiceList(data){
  $('#invoicelist').modal('show');
  var x ;
  if ( $.fn.DataTable.isDataTable( '#cfinvList' ) ) {
    $('#cfinvList').DataTable().destroy();
  }
  $('#cfinvList').DataTable({
    "data": data,
    "columns" : [
      { "data" : "region_name" },
      { "data" : "project_name" },
      { "data" : "Opp_Status" },
      { "data" : "milestone_type" },
      {
      "data" : "lcy_amount",
      "className": "text-right",
      "render": function(data, type, row, meta) {
      return amtFormat(data);
      }
      },
      { "data" : "expected_paid_date" },
      {
      "className": "text-center",
      "data" : "expected_paid_date" ,
      "render": function(data, type, row, meta) {
      if (type === 'display') {
        x = row['idkey'];
        y = row['change_paid_date']||row['expected_paid_date'];
        datax = '<input type="date"  class="testdate" id="'+x+'" data-prevdate='+y+' data-amount='+row['lcy_amount']+' required value="'+y+'">';
      }
      return datax;
      }
      }
    ]
  });
}//End of Function




</script>


<legend>View Cashflow</legend>



<div class="row">
  <form id="cashflow-form" role="form">

    <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
      <label class="checkbox-inline">
        <input type="checkbox" checked data-toggle="toggle" data-size="mini" data-onstyle="default" id="indiaCHK"> India
      </label>
      <label class="checkbox-inline">
        <input type="checkbox" checked data-toggle="toggle" data-size="mini" data-onstyle="default" id="meCHK"> Middle East
      </label>
    </div>
    <div >
      <label class="checkbox-inline">
        <input type="checkbox" checked data-toggle="toggle" data-size="mini" data-onstyle="default" id="poCHK"> Awaiting PO
      </label>
      <label class="checkbox-inline">
        <input type="checkbox" checked data-toggle="toggle" data-size="mini" data-onstyle="default" id="hpCHK"> Hot Prospect
      </label>
      <label class="checkbox-inline">
        <input type="checkbox" unchecked data-toggle="toggle" data-size="mini" data-onstyle="default" id="pCHK">  Prospect
      </label>
      <label class="checkbox-inline">
        <input type="checkbox" unchecked data-toggle="toggle" data-size="mini" data-onstyle="default" id="sCHK">  Suspect
      </label>
      <label class="checkbox-inline">
        <input type="checkbox" unchecked data-toggle="toggle" data-size="mini" data-onstyle="default" id="lCHK">  Lead
      </label>
    </div>
    <div class="clearfix"></div>
    <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
      <label class="checkbox-inline">
        <input type="checkbox" unchecked data-toggle="toggle" data-size="mini" data-onstyle="default" id="pastCHK"> Do Not Consider Past Payment
      </label>
    </div>
    <div class="clearfix"></div>
  </form>
</div>
<!-- Tab palce holder -->
<div>
  <ul class='nav nav-pills  split-button-nav'>
    <li class='active'>
      <a data-toggle='tab' href='#REV'>REVENUE</a>
    </li>
    <li>
      <a data-toggle='tab' href='#EXP'>EXPENSE</a>
    </li>
    <li >
      <a data-toggle='tab' href='#CASH'>CASHFLOW</a>
    </li>
  </ul>
</div>


<!-- tab content -->
<div class='tab-content'>

  <!-- Revenue  -->
  <div class="tab-pane fade in active" id="REV">
    <p>
      <div class="form-group col-xs-5 col-sm-8 col-md-8 col-lg-8">
        <table id="cfl-3" class="table table-striped srvTBL mnthTBL" width="100%">
          <thead>
            <tr>
              <th>REGION</th>
              <th>STATUS</th>
              <th>M1</th>
              <th>M2</th>
              <th>M3</th>
              <th>M4</th>
              <th>M5</th>
              <th>M6</th>
              <th>M7</th>
              <th>M8</th>
              <th>M9</th>
              <th>M10</th>
              <th>M11</th>
              <th>M12</th>
            </tr>
          </thead>
          <tfoot>
          </tfoot>
        </table>
      </div>
    </p>
  </div>

  <!-- cashflow  -->
  <div class="tab-pane fade " id="CASH">
    <div id="modified" class="pull-right" hidden>
      <div class="row">
        <div class="col-xs-7">
          <a id = "chgpopup" class="bg-warning font-weight-bold"
            data-toggle="popover" data-trigger="click"
            data-html="true" data-placement="left"
            data-content="<div id='popcontent'>Loading...</div>">
            Modified
          </a>
        </div>
        <div class="col-xs-5">
          <button type="button" class="btn btn-primary btn-circle align-top btn-md " id="resettbl">
              <i class="glyphicon glyphicon-remove"></i>
          </button>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
    <p>
      <div class="form-group col-xs-5 col-sm-8 col-md-8 col-lg-8">
        <table id="cfl-0" name="cfl-0" class="table table-striped  mnthTBL" width="100%">
          <thead>
            <tr>
              <th>LINES</th>
              <th>M1</th>
              <th>M2</th>
              <th>M3</th>
              <th>M4</th>
              <th>M5</th>
              <th>M6</th>
              <th>M7</th>
              <th>M8</th>
              <th>M9</th>
              <th>M10</th>
              <th>M11</th>
              <th>M12</th>
            </tr>
          </thead>
          <tbody>
          <tbody>
        </table>
      </div>
      <div class="clearfix"></div>
    </p>
    <div id="cloneexp"></div>
  </div>


  <!-- Expense  -->
  <div class="tab-pane fade" id="EXP">
    <p>
      <div class="form-group col-xs-5 col-sm-8 col-md-8 col-lg-8">
        <table id="cfl-1" class="table table-striped  srvTBL mnthTBL" width="100%">
          <thead>
            <tr>
              <th>REGION</th>
                <!-- <th>EXPENSE DETAILS</th> -->
                <th>PAST UNPAID</th>
                <th id="M1">M1</th>
                <th>M2</th>
                <th>M3</th>
                <th>M4</th>
                <th>M5</th>
                <th>M6</th>
                <th>M7</th>
                <th>M8</th>
                <th>M9</th>
                <th>M10</th>
                <th>M11</th>
                <th>M12</th>
            </tr>
          </thead>
        </table>
      </div>
      <div class="clearfix"></div>
      <div id="dcfl-2" class="form-group col-xs-5 col-sm-8 col-md-8 col-lg-8">
        <table id="cfl-2" class="table table-striped  srvTBL mnthTBL" width="100%">
          <thead>
            <tr>
              <th>REGION</th>
              <th>EXPENSE DETAILS</th>
              <th>PAST UNPAID</th>
              <th id="M1">M1</th>
              <th>M2</th>
              <th>M3</th>
              <th>M4</th>
              <th>M5</th>
              <th>M6</th>
              <th>M7</th>
              <th>M8</th>
              <th>M9</th>
              <th>M10</th>
              <th>M11</th>
              <th>M12</th>
            </tr>
          </thead>
        </table>
      </div>
    </p>
  </div>
</div>


<!-- Modal for showing Invoice list -->
<div class="modal fade" id="invoicelist" tabindex="-1" role="dialog" aria-labelledby="invoicelistLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="invoicelistLabel">Invoice Details</h4>
      </div>
      <div class="modal-body">
        <table id="cfinvList" name="cfinvList" class="table table-striped"  width="100%">
          <thead>
            <tr>
              <th>Region</th>
              <th>Project</th>
              <th>Status</th>
              <th>Project Milestone</th>
              <th>Invoice Amount</th>
              <th>Expected Pay Date</th>
              <th>Changed Date</th>

            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>

      </div>

    </div>
  </div>
</div>

<!-- show changes -->
<div id="changestbl" class="hidden">
  <table id="changelist" name="changelist" class="table table-striped" width="100%">
    <thead>
      <tr>
        <th>Detail</th>
        <th>Original value</th>
        <th>Changed value</th>

      </tr>
    </thead>
    <tbody>
    <tbody>
  </table>
</div>

<?php

require_once('bodyend.php');

?>
