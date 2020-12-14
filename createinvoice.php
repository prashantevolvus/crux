<?php
$permission = "VIEW";
require_once('head.php');

require_once('bodystart.php');
?>

<script type="text/javascript">
var projSelected=false;
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
      populateForm(datum.projid);
    }); //end of typeahead

    $( "#format" ) .change(function () {
      updatePDF();
    });

    $('input').focusout(function(){
      updatePDF();
    });

    $('textarea').focusout(function(){
      updatePDF();
    });

    $(document).on('click', '.invcheck', function () {
      updatePDF();
    });



  });//End of ready

  function updatePDF(){
    if(!projSelected){
      return false;
    }
    var arrInv = [];
    if ($.fn.dataTable.isDataTable('#invoiceList')) {
      var data = $('#invoiceList').DataTable().data().toArray();
      $.each( data, function(i, row){
        // if(row())
        inv = {
          desc:row[2],
          amt:row[3]
        };
        arrInv.push(inv);
      });
    }
    console.log(arrInv);
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
           style:    'os',
           selector: 'td:first-child'
       },
      "columns": [
          {
            "data": "INVOICE_ID",
            "render": function(data, type, row, meta) {
              if (type === 'display') {
                data = "";
              }
              return data;
            }
          },
          {"data": "INVOICE_DATE"},
          {"data": "INVOICE_DESCRIPTION"},
          {
            "data": "INVOICE_AMT",
            "render": function(data, type, row, meta) {
              if (type === 'display') {
                data = amtFormat(data);
              }
              return data;
            }
          }
          // ,
          // {
          //   "data": "INVOICE_ID",
          //   "render": function(data, type, row, meta) {
          //     if (type === 'display') {
          //       data = "<input type='hidden' class='invcheck' data-invid='"+data+"'></input>"
          //     }
          //     return data;
          //   }
          // }
      ]
    });
    //End of table

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
    <div class="row row-no-gutters" >
      <div class="table-responsive col-lg-3 right10">
        <label for="format">Invoice Format</label>
        <select id="format" name="format" class="form-control">
          <option>India - Karnataka </option>
          <option>India - Non Karnataka</option>
          <option>Middle East - UAE </option>
          <option>Middle East - Non UAE </option>
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
        <label for="invoicessn">PROJECT DETAILS</label>
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

<input type="hidden" id="invoicecur" value="GBP"/>
<input type="hidden" id="invoiceno" value="NOT GENERATED"/>


<input type="hidden" id="vendorname" value="M/s. Evolvus Solutions Pvt Ltd (DMCC Dubai Branch)"/>
<input type="hidden" id="vendoradd1" value="Cluster M, JLT"/>
<input type="hidden" id="vendoradd2" value="Dubai"/>
<input type="hidden" id="vendoradd3" value="UAE"/>
<input type="hidden" id="customertrn" value="100338349200003"/>


<input type="hidden" id="customername" value="M/s. EmiratesNBD PJSC"/>
<input type="hidden" id="customeradd1" value="Baniyas Road"/>
<input type="hidden" id="customeradd2" value="Deira"/>
<input type="hidden" id="customeradd3" value="Dubai, UAE"/>
<input type="hidden" id="vendortrn" value="100035307600003"/>


<input type="hidden" id="customershipadd1" value="Cluster M, JLT"/>
<input type="hidden" id="customershipadd2" value="Dubai, UAE"/>
<input type="hidden" id="customershipadd3" value="Dubai, UAE"/>





  </div>
  <div class="col-xs-4" >
    <iframe id="pdf-preview" src="" height="500" width="100%"></iframe>
  </div>
</div>
</div>



<?php

require_once('bodyend.php');

?>
