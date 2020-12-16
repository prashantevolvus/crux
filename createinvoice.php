<?php
$permission = "VIEW";
require_once('head.php');

require_once('bodystart.php');
?>

<script type="text/javascript">
var projSelected=false;
var gProjID;
var supList = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: 'getprojauto.php',
  remote: {
    url: 'getprojauto.php?query=%QUERY',
    wildcard: '%QUERY'
  }
});

  $(document).ready(function() {

    fillDropDown("api/getInvoiceFormatList.php", "#format");

    $('#projSearch .typeahead').typeahead(null, {
      display: 'projname',
      highlight: true,
      minLength: 1,
      source: supList,
      templates: {
        empty: [
          '<div class="empty-message">',
          'No Project Found',
          '</div>'
        ].join('\n'),
        suggestion: function(data) {
          return '<p>' + data.cust + ' : <strong>' + data.projname + '</strong> – ' + ' [Status : ' + data.status + ']</p>';
        }
      }
    }).bind('typeahead:selected', function(obj, datum, name) {
      projSelected=true;
      gProjID = datum.projid;
      populateForm(datum.projid);
    }); //end of typeahead

    $( "#format" ) .change(function () {
      if(projSelected){
        getInvoiceInformation(gProjID);
      }
      updatePDF();
    });

    $('input').focusout(function(){
      updatePDF();
    });

    $('textarea').focusout(function(){
      updatePDF();
    });

    var oTable = $('#invoiceList').dataTable();
    oTable.on( 'select', function ( e, dt, type, indexes ) {
      if ( type === 'row' ) {
        updatePDF();
      }
    });



  });//End of ready

  function updatePDF(){
    if(!projSelected){
      return false;
    }
    var arrInv = [];
    if ($.fn.dataTable.isDataTable('#invoiceList')) {
      var oTable = $('#invoiceList').dataTable().api();

      oTable.rows({selected: true}).data().toArray().forEach(function (item, index) {
        inv = {
            desc:item.INVOICE_DESCRIPTION,
            amt:item.INVOICE_AMT
          };
        arrInv.push(inv);
      });

    }
    var reqJSON  = {
      projID: 23,
      invList: arrInv,
      invFormat : $('#format').val(),
      invNO:$('#invoiceno').val(),
      invDate: $('#invoicedate').val(),
      invJob: $('#invoicejob').val(),
      invCur:$('#invoicecur').val(),


      projDet:$('#invoiceproj').val(),
      projSSN:$('#invoicessn').val(),

      venName:$('#vendorname').val(),
      venAdd1:$('#vendoradd1').val(),
      venAdd2:$('#vendoradd2').val(),
      venAdd3:$('#vendoradd3').val(),
      venTRN:$('#vendortrn').val(),
      venGST:$('#vendorgst').val(),




      custName:$('#customername').val(),
      custAdd1:$('#customeradd1').val(),
      custAdd2:$('#customeradd2').val(),
      custAdd3:$('#customeradd3').val(),
      custShipAdd1:$('#customershipadd1').val(),
      custShipAdd2:$('#customershipadd2').val(),
      custShipAdd3:$('#customershipadd3').val(),
      custTRN:$('#customertrn').val(),
      custGST:$('#customergst').val()

    }
    $.ajax({
        type: "GET",
        url: "invoice.php",
        async: false,
        //convert JSON to string and then encode it with base64
        data: {q: btoa(JSON.stringify(reqJSON))},
        dataType:"application/pdf",
        complete: function(data){
          $('#pdf-preview').attr('src',data.responseText);
        }
    });


  }

  function getInvoiceInformation(projid){

    $.ajax({
      dataType: "json",
      async:false,
      url: "api/getInvoiceData.php?projID=" + projid+"&formatID="+$("#format").val(),
      success: function(data) {
        $('#invoiceproj').val(data[0]['project_details']);
        $('#invoicessn').val(data[0]['ssn_no']);
        $('#customername').val(data[0]['name_on_invoice']);
        $('#customeradd1').val(data[0]['to_add1']);
        $('#customeradd2').val(data[0]['to_add2']);
        $('#customeradd3').val(data[0]['to_add3']);
        $('#customertrn').val(data[0]['trn_no']);
        $('#customergst').val(data[0]['gst_no']);
        $('#vendorname').val(data[0]['vendor_name']);
        $('#vendoradd1').val(data[0]['vendor_add1']);
        $('#vendoradd2').val(data[0]['vendor_add2']);
        $('#vendoradd3').val(data[0]['vendor_add3']);
        $('#vendortrn').val(data[0]['vendor_trn']);
        $('#vendorgst').val(data[0]['vendor_gst']);
        $('#customershipadd1').val(data[0]['ship_add1']);
        $('#customershipadd2').val(data[0]['ship_add2']);
        $('#customershipadd3').val(data[0]['ship_add3']);
      }
  });
    // $.getJSON(, );
  }

  function populateForm(projid) {
    if ($.fn.dataTable.isDataTable('#invoiceList')) {
      $('#invoiceList').DataTable().destroy();
    }

    table = $('#invoiceList').DataTable({
      "paging": false,
      "ordering": false,
      "info": false,
      "searching": false,
      "ajax": {
        url: "api/getFinanceList.php",
        data: function(d) {
          d.projectid = projid;
          d.type = "invoiceCustList";
        }
      },
      "columnDefs": [ {
          orderable: false,
          className: 'select-checkbox',
          targets:   0
      } ],
      "select": {
          style:    'multi+shift',
          selector: 'td:first-child'
      },
      order: [[ 1, 'asc' ]],
      "columns": [
          {
            "data": "INVOICE_ID",
            "render": function(data, type, row, meta) {
              if (type === 'display') {
                data = ""
              }
              return data;
            }
          },
          {"data": "INVOICE_DATE"},
          {"data": "INVOICE_DESCRIPTION"},
          {
            "data": "INVOICE_AMT",
            "className": "text-right",
            "render": function(data, type, row, meta) {
              if (type === 'display') {
                data = amtFormat(data);
              }
              return data;
            }
          }

      ]
    });
    //End of table
    table.on( 'select', function ( e, dt, type, indexes ) {
      if ( type === 'row' ) {
        updatePDF();
      }
    });
    table.on( 'deselect', function ( e, dt, type, indexes ) {
      if ( type === 'row' ) {
        updatePDF();
      }
    });

    getInvoiceInformation(projid);

    updatePDF();

  }

</script>

<div class="container ">

  <div class="row row-no-gutters" >
  <div class="col-xs-8">
    <div class="row row-no-gutters" >
      <div class="input-group col-lg-6" id="projSearch">
        <label for="prj">Choose Project</label>
        <input id="prj" name="prj" type="input" placeholder="Enter Project Name" class="form-control input-md typeahead" required=""  autocomplete="sprcatre">
      </div>
    </div>
    <div class="row row-no-gutters top15" >
      <div class="table-responsive col-lg-3 right10">
        <label for="format">Invoice Format</label>
        <select id="format" name="format" class="form-control">
        </select>
      </div>
      <div class="table-responsive col-lg-3  right10">
        <label for="invoicedate">Invoice Date</label>
        <input type="date" class="form-control" id="invoicedate" name="invoicedate"></input>
      </div>
      <div class="table-responsive col-lg-3">
        <label for="invoicejob">Job</label>
        <input type="text" class="form-control" id="invoicejob" name="invoicejob"></input>
      </div>
    </div>
    <div class="row row-no-gutters">
      <div class="table-responsive col-lg-6 top15 right10" >
        <label for="invoiceproj">PROJECT DETAILS</label>
        <textarea class="form-control" id="invoiceproj" name="invoiceproj"></textarea>
      </div>
      <div class="table-responsive col-lg-3 top15" >
        <label for="invoicessn">SAC/HSN CODE</label>
        <input type="text" class="form-control" id="invoicessn" name="invoicessn"></input>
      </div>
    </div>
    <div class="row row-no-gutters">
      <div class="table-responsive col-lg-9 top15" >
        <table id="invoiceList" class="table table-striped" >
          <thead>
            <tr>
              <th>Select</th>
              <th>Invoice Date</th>
              <th>Invoice Description</th>
              <th>Invoice Amount</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>

<input type="hidden" id="invoicecur" value="DEF"/>
<input type="hidden" id="invoiceno" value="NOT GENERATED"/>


<input type="hidden" id="vendorname" value="DEFAULT vendorname"/>
<input type="hidden" id="vendoradd1" value="DEFAULT ADD1"/>
<input type="hidden" id="vendoradd2" value="DEFAULT ADD2"/>
<input type="hidden" id="vendoradd3" value="DEFAULT ADD3"/>
<input type="hidden" id="vendortrn" value="DEFAULT TRN1"/>
<input type="hidden" id="vendorgst" value="DEFAULT VEND GST"/>



<input type="hidden" id="customername" value="DEFAULT CUST NAME"/>
<input type="hidden" id="customeradd1" value="DEFAULT ADD1"/>
<input type="hidden" id="customeradd2" value="DEFAULT Add2"/>
<input type="hidden" id="customeradd3" value="DEFAULT ADD3"/>

<input type="hidden" id="customertrn" value="DEFAULT TRN CUST"/>
<input type="hidden" id="customergst" value="DEFAULT GST"/>



<input type="hidden" id="customershipadd1" value="DEFAULT ADD1"/>
<input type="hidden" id="customershipadd2" value="DEFAULT ADD1"/>
<input type="hidden" id="customershipadd3" value="DEFAULT ADD1"/>





  </div>
  <div class="col-xs-4" >
    <iframe id="pdf-preview" src="" height="500" width="100%"></iframe>
  </div>
</div>
</div>



<?php

require_once('bodyend.php');

?>
