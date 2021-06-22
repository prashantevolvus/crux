<?php
$permission = "VIEW";
require_once('head.php');

require_once('bodystart.php');
?>

<style>
.popover{
    max-width: 100%; /* Max Width of the popover (depending on the container!) */
}
</style>

<script type="text/javascript">

  let invoiceChangedList = [];
  let invoiceList = [];

  let expenseChangedList = [];
  let expenseList = [];

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
      var expenseArr1 = Array(12).fill(0);




      // Initialize popover component
      // $(function () {
      //   $('[data-toggle="popover"]').popover();
      // });
      $('[data-toggle="tooltip"]').tooltip();

      $('[data-toggle="popover"]').popover({
        container: 'body'
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
        drawEverything(expenseArr1,revenueArr,chkBox);
      });

      //When Tab is changed
      $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        updateCashflowTable(expenseArr1,revenueArr,chkBox);
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

        if(e.currentTarget.rowIndex === 1){
            showInvoiceList(invoiceList.filter(item => item["MX"] == "M"+e.target.cellIndex));
        }
        if(e.currentTarget.rowIndex === 2){
            showExpenseList(expenseList.filter(item => item["MX"] == "M"+e.target.cellIndex));
        }

      });


      //When the date is changed
      $(document).on('input', ".testdate", function (e) {

        var date_field ="";
        var mainList = [];
        var changedList = [];

        if(e.target.dataset["type"] == "invoice"){
          date_field="change_paid_date";
          mainList = invoiceList;
          changedList = invoiceChangedList;
        }
        else if(e.target.dataset["type"] == "expense"){
          date_field="change_expense_date";
          mainList =  expenseList;
          changedList = expenseChangedList;
        }
        else {
          console.error("This should not happen");
          return;

        }

        var x1 = new Date(e.target.value);
        var newDate = new Date(x1.getFullYear(),x1.getMonth(),1);
        var x1 = new Date(e.target.dataset["prevdate"]);
        var prevDate = new Date(x1.getFullYear(),x1.getMonth(),1);
        var x1 = new Date();
        var currDate = new Date(x1.getFullYear(),x1.getMonth(),1);

        newMonth = newDate.getMonth() - currDate.getMonth() + (12 * (newDate.getFullYear() - currDate.getFullYear()));
        prevMonth = prevDate.getMonth() - currDate.getMonth() + (12 * (prevDate.getFullYear() - currDate.getFullYear()));

        var x = changedList.find(item => item["idkey"]===e.target.id);
        if(x){
          x[date_field] = e.target.value;
          x["MX"] = "M"+(newMonth+1);
          x["modified_time"] = Date.now();
        }
        else{
          var x = {
            "idkey" : e.target.id,
            "MX" : "M"+(newMonth+1),
            "modified_time" : Date.now()
          };
          x[date_field] = e.target.value;
          changedList.push(x);
          chkBox.set('modified',true);

        }
        var y = mainList.find(item => item["idkey"]===e.target.id);
        if(y){
          y[date_field] = e.target.value;
          y["MX"] = "M"+(newMonth+1);
        }
        changedList.sort(function(first,second){
          if(first["modified_time"] > second["modified_time"]){
            return 1;
          }
          else {
            return -1;
          }
        });

      });

      //When the invoice list modal dialog is closed
      $('#invoicelist').on('hidden.bs.modal', function () {
        drawEverything(expenseArr1,revenueArr,chkBox);
      });

      //When the expense list modal dialog is closed
      $('#expenselist').on('hidden.bs.modal', function () {
        drawEverything(expenseArr1,revenueArr,chkBox);
      });



      //Click on reset button to clear all what Ifs
      $('#resettbl').on('click', function(event) {
          invoiceChangedList.splice(0);
          expenseChangedList.splice(0);
          chkBox.set('modified',false);
          drawEverything(expenseArr1,revenueArr,chkBox);

      });

      //Click on undo button to clear all what Ifs
      $('#undotbl').on('click', function(event) {
          invLen = invoiceChangedList.length;
          expLen = expenseChangedList.length;

          if(invLen != 0 && expLen === 0 ){
            invoiceChangedList.pop();
          }
          else if(invLen === 0 && expLen != 0 ){
            expenseChangedList.pop();
          }
          else if(invoiceChangedList[invoiceChangedList.length-1]["modified_time"]
            <= expenseChangedList[expenseChangedList.length-1]["modified_time"]){
              expenseChangedList.pop();
          }
          else if(invoiceChangedList[invoiceChangedList.length-1]["modified_time"]
            > expenseChangedList[expenseChangedList.length-1]["modified_time"]){
            invoiceChangedList.pop();
          }
          if(invoiceChangedList.length === 0 && expenseChangedList.length === 0 ){
            chkBox.set('modified',false);
          }
          drawEverything(expenseArr1,revenueArr,chkBox);
      });

      drawEverything(expenseArr1,revenueArr,chkBox);
    });//End of ready

  //Draw everything from
  function drawEverything(expenseArr,revenueArr,chkBox){
    //Get Invoice and wait till we get it  only then call functions to fill revenue and
    //update tables
    $.when( getInvoiceList(chkBox)).then(function(){
      fillRevenueArray(revenueArr);
      //Get Invoice and wait till we get it  only then call functions to fill exepnse and
      //update tables
      $.when( getExpenseList(chkBox)).then(function(){
        fillExpenseArray(expenseArr,chkBox.get('pastCHK'));
        updateData(expenseArr,revenueArr,chkBox);

      });
    });
  }
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


  //From the invoicelist array build expense array
  function fillExpenseArray(expenseArr,ignorePast=false){
    expenseArr.forEach(function(item,index){
      x = expenseList.reduce(function(total,value){
              t = parseFloat(total);
              if(ignorePast){
                if("M"+(index+1) === value["MX"]){
                  t += parseFloat(value["expense_amt_lcy"]);
                }
              }
              else{
                if("M"+(index+1) === (value["MX"] === "M0"?"M1" :value["MX"])){
                  t += parseFloat(value["expense_amt_lcy"]);
                }
              }
          return t;
      },0);

      expenseArr[index] = x;
    });

  }

  //This fellow gets invoicelist from server
  //For the check boxes get all the invoices and keep in array. Better than going to server
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


  //This fellow gets Expenselist  from server
  //For the check boxes get all the invoices and keep in array. Better than going to server
  function getExpenseList(chkBox){
    var dfd = jQuery.Deferred();
    var rgnArr = [];

    if(chkBox.get('indiaCHK')) rgnArr.push('India');
    if(chkBox.get('meCHK')) rgnArr.push('Middle East');



    var OnSuccess = function(data){

      if(!chkBox.get('pastCHK')){
        data.forEach(function(item,index,arr){
          if(item["MX"]==="M0"){
            arr[index]["MX"] = "M1";
          }
        });
      }

      expenseChangedList.forEach(function(chgItem){
        var x = data.find(item => item["idkey"]===chgItem["idkey"]);
        if(x){
          x["change_expense_date"] = chgItem["change_expense_date"];
          x["MX"] = chgItem["MX"];
        }
      });
      expenseList = data;
      dfd.resolve( "Done" );

    }

    $.getJSON( "api/getCashflowExpense.php",
      {
        ignorePast:"'" + chkBox.get('pastCHK')  + "'",
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
      $( "#bdgCt").text(invoiceChangedList.length+expenseChangedList.length);
      $("#changestbl tbody").empty();
      markup="";

      invoiceChangedList.forEach((item, ix) => {
        invoiceList.filter(itemList => itemList["idkey"] == item["idkey"]).forEach((moditem, iy) => {
          markup += "<tr>";
          markup += "<td class='text-truncate'>Invoice</td>";
          markup += "<td class='text-truncate'>"+moditem["project_name"]+": "+moditem["milestone_type"]+"</td>";
          markup += "<td class='text-right'>"+amtFormat(moditem["lcy_amount"])+"</td>";
          markup += "<td>"+moditem["expected_paid_date"]+"</td>";
          markup += "<td>"+moditem["change_paid_date"]+"</td>";
          markup += "</tr>";
        });
      });
      expenseChangedList.forEach((item, ix) => {
        expenseList.filter(itemList => itemList["idkey"] == item["idkey"]).forEach((moditem, iy) => {
          markup += "<tr>";
          markup += "<td class='text-truncate'>Expense</td>";
          markup += "<td class='text-truncate'>"+moditem["expense_det"]+" : " +moditem["remarks"]+"</td>";
          markup += "<td class='text-right'>"+amtFormat(moditem["expense_amt_lcy"])+"</td>";
          markup += "<td>"+moditem["gen_date"]+"</td>";
          markup += "<td>"+moditem["change_expense_date"]+"</td>";
          markup += "</tr>";
        });


      });

      $("#changestbl tbody").parent().append(markup);
      $( "#chgpopup").attr("data-content",$( "#changestbl").html());
    }
    else{
      $( "#modified").hide();
    }

    //This will delete all elements
    //expenseArr.splice(0, expenseArr.length);
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
      //expenseArr =  retArr1.slice(1);
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
      "pageLength": 5,
      "lengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
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
          datax = '<input type="date"  class="testdate" id="'+x+'" data-type="invoice" data-prevdate='+y+' data-amount='+row['lcy_amount']+' required value="'+y+'">';
        }
        return datax;
        }
        }
      ]
    });
  }//End of Function

  //Render the Expense list modalbox
  function showExpenseList(data){
    $('#expenselist').modal('show');
    var x ;
    if ( $.fn.DataTable.isDataTable( '#cfexpList' ) ) {
      $('#cfexpList').DataTable().destroy();
    }
    $('#cfexpList').DataTable({
      "pageLength": 5,
      "lengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
      "data": data,
      "columns" : [
        { "data" : "region_name" },
        { "data" : "expense_det" },
        { "data" : "tran_status" },
        { "data" : "remarks" },
        {
        "data" : "expense_amt_lcy",
        "className": "text-right",
        "render": function(data, type, row, meta) {
        return amtFormat(data);
        }
        },
        { "data" : "gen_date" },
        {
        "className": "text-center",
        "data" : "gen_date" ,
        "render": function(data, type, row, meta) {
        if (type === 'display') {
          x = row['idkey'];
          y = row['change_expense_date']||row['gen_date'];
          datax = '<input type="date"  class="testdate" id="'+x+'" data-type="expense" data-prevdate='+y+' data-amount='+row['expense_amt_lcy']+' required value="'+y+'">';
        }
        return datax;
        }
        }
      ]
    });
  }//End of Function


</script>


<legend>View Cashflow</legend>


<!-- Form for the check boxes -->
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
        <div class="col-md-8">
          <a id = "chgpopup" class="bg-warning font-weight-bold"
            data-toggle="popover" data-trigger="hover"
            data-html="true" data-placement="left"
            data-title="Items Changed"
            data-content="<div id='popcontent'>Loading...</div>">
            Modified
            <span id="bdgCt" class="badge">0</span>
          </a>
        </div>
        <div class="col-md-2">
          <button type="button" class="btn btn-primary btn-circle  btn-md " data-toggle="tooltip" title="Undo all Changes!" name="resettbl" id="resettbl">
              <i class="glyphicon glyphicon-remove"></i>
          </button>
        </div>
        <div class="col-md-2">
          <button type="button" class="btn btn-primary btn-circle btn-md " data-toggle="tooltip" title="Undo Last Changes!" name="undotbl" id="undotbl">
              <i class="glyphicon glyphicon-repeat"></i>
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
        <span class="label label-info">
          <i class="glyphicon glyphicon-info-sign"></i>
          Double Click on numbers for details
        </span>
      </div>
      <div class="clearfix"></div>


    </p>
    <!-- <div id="cloneexp"></div> -->
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



<!-- Modal for showing Expense list -->
<div class="modal fade" id="expenselist" tabindex="-1" role="dialog" aria-labelledby="expenselistLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="expenselistLabel">Expense Details</h4>
      </div>
      <div class="modal-body">
        <table id="cfexpList" name="cfexpList" class="table table-striped"  width="100%">
          <thead>
            <tr>
              <th>Region</th>
              <th>Expense Details</th>
              <th>Status</th>
              <th>Remarks</th>
              <th>Expense Amount</th>
              <th>Expected Payment</th>
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



<!-- popover for showing changes -->
<div id="changestbl" class="hidden">
  <table id="changelist" name="changelist" class="table table-striped" width="100%">
    <thead>
      <tr>
        <th>Type</th>
        <th>Detail</th>
        <th>Amount</th>
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
