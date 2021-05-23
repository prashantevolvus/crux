<?php
$permission = "VIEW";
require_once('head.php');

require_once('bodystart.php');
?>

<style>
   .modal {
    display:    none;
    position:   fixed;
    z-index:    1000;
    top:        0;
    left:       0;
    height:     100%;
    width:      100%;
    background: rgba( 255, 255, 255, .8 )
                url('images/FhHRx.gif')
                50% 50%
                no-repeat;
}
   /* When the body has the loading class, we turn
   the scrollbar off with overflow:hidden */
   body.loading .modal {
    overflow: hidden;
}
   /* Anytime the body has the loading class, our
   modal element will be visible */
   body.loading .modal {
    display: block;
}
</style>
<script type="text/javascript">


  $(document).ready(function() {

    $body = $("body");
    $(document).on({
      ajaxStart: function() { $body.addClass("loading");    },
      ajaxStop: function() { $body.removeClass("loading"); }
    });



    let qry = 2;


    let chkBox = new Map();
    chkBox.set('indiaCHK',true);
    chkBox.set('meCHK',true);
    chkBox.set('poCHK',true);
    chkBox.set('hpCHK',true);
    chkBox.set('pCHK',false);
    chkBox.set('sCHK',false);
    chkBox.set('lCHK',false);
    chkBox.set('pastCHK',false);

    var cfTable1RemArr = [];
    var cfTable2RemArr = [];
    var cfTable3RemArr = [];
    var revenueArr = [];
    var expenseArr = [];


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
          //,
          // "render": function(data, type, row, meta) {
          //   if (type === 'display') {
          //     if(data === "TOTAL")
          //       return data;
          //     data =  '<button type="button" class="btn btn-link" id="' + data +
          //       '" ><span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span> '+ data+'</button>';
          //   }
          //   return data;
          // }
        },
        // {
        //   "data": "expense_det"
        // },
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

    cfTable3 = $('#cfl-3').DataTable({
      "searching": false,
      "bInfo" : false,
      "ordering": false,
      "paging": false,
      "cache": true,
      "ajax": {
        url: "api/getGLData.php?qryid="+3,
        "dataSrc": ""
      },
      "footerCallback": function(row, data, start, end, display) {
        var api = this.api();
        //$(this).deleteTFoot();
        //var footer = $(this).append('<tfoot><tr></tr></tfoot>');
        revenueArr.splice(0, revenueArr.length);
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
          revenueArr.push(x);

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
          //,
          // "render": function(data, type, row, meta) {
          //   if (type === 'display') {
          //     if(data === "TOTAL")
          //       return data;
          //     data =  '<button type="button" class="btn btn-link" id="' + data +
          //       '" ><span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span> '+ data+'</button>';
          //   }
          //   return data;
          // }
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


    qry = 1;
    cfTable2 = $('#cfl-2').DataTable({
      "searching": true,
      "bInfo" : false,
      "ordering": false,
      "paging": false,
      "cache": true,
      "ajax": {
        url: "api/getGLData.php?qryid="+qry,
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



     updateData(expenseArr,revenueArr,chkBox);
     //setTimeout(updateData(),3200);

    //set map  to hide or show a row based on check box abd then redraw all tables
    $('#cashflow-form :checkbox').change(function() {
      chkBox.set($(this).attr('id') , $(this).is(':checked'));
      updateData(expenseArr,revenueArr,chkBox);


    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
      updateData(expenseArr,revenueArr,chkBox);
    });

    //When draw is done add a row for sum
    // cfTable3.on( 'draw', function () {
    //   console.log($(this).DataTable());
    // } );

    // cfTable3.column( 3 ).data().sum();


    //This fellow changes the header from M1, M2.... Current month, current month + 1.....
    $("table").each(function(){
      $(this).find('thead th').each((th_idx,th) => {
        if($(th).text().slice(0,1) == "M") {
             const dt = new Date();
             var a = $(th).text().slice(1);
             dt.setMonth(  dt.getMonth()+parseInt(a)-1 );
             const month = dt.toLocaleString('default', { month: 'long' });
             const year = String(dt.getFullYear());
             $(th).text(month.slice(0,3)+'-'+year.substr(-2,2));
             //console.log(month.slice(0,3)+'-'+year.substr(-2,2));

        }
      });
    });


  });




function updateData(expenseArr,revenueArr,chkBox){
  $body.addClass("loading");
  $("table").each(function(){
    if($(this).attr('id') != "cfl-0"){
      $(this).DataTable().draw();
    }
  });

  setTimeout(function(){
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


    markup = "<tr><th>Total Revenue</th><td></td>";
    markup += markupRev + "</tr>";
    $("#cfl-3 tbody").parent().append(markup);
    $body.removeClass("loading");
  },1250);//SetTimeout ends here with 250 ms
}

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
        <table id="cfl-3" class="table table-striped" width="100%">
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
    <p>
      <div class="form-group col-xs-5 col-sm-8 col-md-8 col-lg-8">
        <table id="cfl-0" class="table table-striped" width="100%">
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
        <table id="cfl-1" class="table table-striped" width="100%">
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
        <table id="cfl-2" class="table table-striped" width="100%">
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


<div class="modal"><!-- Place at bottom of page --></div>

<?php

require_once('bodyend.php');

?>
