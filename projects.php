<?php
$permission = "VIEW";
require_once('head.php');

require_once('bodystart.php');
?>

<script type="text/javascript">
  //Retrieve and set DATA
  var supList = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: 'getprojauto.php',
    remote: {
      url: 'getprojauto.php?query=%QUERY',
      wildcard: '%QUERY'
    }
  });

  //Autocomplete for Project Search
  $(document).ready(function() {


    $("#proj-info").hide();




    $('#1B1').editable({
      type: 'select',
      sourceCache: false,
      pk: 0,
      value: '',
      title: "Enter Project Type",
      source: 'api/getProjectTypeList.php'
    });

    $('#1B1').editable('option', 'disabled', true);

    $('#3B1').editable({
      type: 'select',
      sourceCache: false,
      pk: 0,
      value: '',
      title: "Enter Customer Name",
      source: 'api/getCustomerList.php',
      success: function(response, newValue) {
        cust = newValue;
        //
        // setTimeout(function() {
        //   $('#1B3B').editable('show');
        // }, 200);
      }
    });

    $('#3B1').editable('option', 'disabled', true);


    //Opportunity Name
    $('#2B1').editable({
      sourceCache: false,
      pk: 0,
      value: '',
      title: "Enter Project Name",
      validate: function(value) {
        if ($.trim(value) == '') {
          return 'This field is required';
        }
      }
    });

    $('#2B1').editable('option', 'disabled', true);


    $('#5B1').editable({
      type: 'select',
      sourceCache: false,
      pk: 0,
      value: '',
      title: "Enter Project Status",
      source: ['ACTIVE', 'CLOSED', 'WARRANTY', 'DELIVERED', 'INITIATED', 'AUTHORISED', 'APPROVED', 'DELETED', 'DEACTIVATED', 'INITIATE CLOSURE', 'AUTHORISE CLOSURE', 'PENDING INVOICE'],
      validate: function(value) {
        if ($.trim(value) == '') {
          return 'This field is required';
        }
      }
    });

    $('#5B1').editable('option', 'disabled', true);


    $('#1B2').editable({
      type: 'select',
      sourceCache: false,
      pk: 0,
      value: '',
      title: "Enter Profit Centre",
      source: 'api/getProfitCentre.php'
    });

    $('#1B2').editable('option', 'disabled', true);

    $('#2B2').editable({
      type: 'select',
      sourceCache: false,
      pk: 0,
      value: '',
      title: "Enter Product",
      source: 'api/getProductList.php'
    });

    $('#2B2').editable('option', 'disabled', true);

    $('#3B2').editable({
      type: 'select',
      sourceCache: false,
      pk: 0,
      value: '',
      title: "Enter Project Manager",
      source: 'api/getEmpList.php'
    });

    $('#3B2').editable('option', 'disabled', true);

    $('#4B2').editable({
      type: 'select',
      sourceCache: false,
      pk: 0,
      value: '',
      title: "Enter Project Director",
      source: 'api/getEmpList.php'
    });

    $('#4B2').editable('option', 'disabled', true);

    $('#5B2').editable({
      type: 'select',
      sourceCache: false,
      pk: 0,
      value: '',
      title: "Enter Reporting Period",
      source: ['WEEKLY', 'FORTNIGHTLY', 'MONTHLY', 'QUARTERLY']
    });

    $('#5B2').editable('option', 'disabled', true);

    $('#1B3').editable({
      type: 'date',
      sourceCache: false,
      pk: 0,
      value: '',
      title: "Enter Planned Start Date",
      placement: 'right',
      datepicker: {
        weekStart: 1
      },
      validate: function(value) {
        if ($.trim(value) == '') {
          return 'This field is required';
        }
      }
    });

    $('#1B3').editable('option', 'disabled', true);

    $('#2B3').editable({
      type: 'date',
      sourceCache: false,
      pk: 0,
      value: '',
      title: "Enter Planned End Date",
      placement: 'right',
      datepicker: {
        weekStart: 1
      },
      validate: function(value) {
        if ($.trim(value) == '') {
          return 'This field is required';
        }
      }
    });

    $('#2B3').editable('option', 'disabled', true);


    $('#3B3').editable({
      type: 'date',
      sourceCache: false,
      pk: 0,
      value: '',
      title: "Enter Actual Start Date",
      placement: 'right',
      datepicker: {
        weekStart: 1
      },
      validate: function(value) {
        if ($.trim(value) == '') {
          return 'This field is required';
        }
      }
    });

    $('#3B3').editable('option', 'disabled', true);

    $('#4B3').editable({
      type: 'date',
      sourceCache: false,
      pk: 0,
      value: '',
      title: "Enter Actual End Date",
      placement: 'right',
      datepicker: {
        weekStart: 1
      },
      validate: function(value) {
        if ($.trim(value) == '') {
          return 'This field is required';
        }
      }
    });

    $('#4B3').editable('option', 'disabled', true);

    $('#4B1').editable({
      type: 'select',
      sourceCache: false,
      pk: 0,
      value: '',
      title: "Enter Region Type",
      source: 'api/getRegionList.php'
    });

    $('#4B1').editable('option', 'disabled', true);

    $('#5B3').editable({
      type: 'number',
      sourceCache: false,
      pk: 0,
      value: '',
      title: "Enter Extension in Days",
      placement: 'right',
      validate: function(value) {
        if ($.trim(value) == '') {
          return 'This field is required';
        }
      }
    });

    $('#5B3').editable('option', 'disabled', true);

    $('#G1B1').editable({
      type: 'textarea',
      sourceCache: false,
      pk: 0,
      value: '',
      title: "Enter Project Details",
      placement: 'right',
      datepicker: {
        weekStart: 1
      },
      validate: function(value) {
        if ($.trim(value) == '') {
          return 'This field is required';
        }
      }
    });

    $('#G1B2').editable({
      type: 'textarea',
      sourceCache: false,
      pk: 0,
      value: '',
      title: "Enter Project Scope",
      placement: 'right',
      datepicker: {
        weekStart: 1
      },
      validate: function(value) {
        if ($.trim(value) == '') {
          return 'This field is required';
        }
      }
    });

    $('#G2B1').editable({
      type: 'textarea',
      sourceCache: false,
      pk: 0,
      value: '',
      title: "Enter Project Objectives",
      placement: 'right',
      datepicker: {
        weekStart: 1
      },
      validate: function(value) {
        if ($.trim(value) == '') {
          return 'This field is required';
        }
      }
    });

    $('#G2B2').editable({
      type: 'textarea',
      sourceCache: false,
      pk: 0,
      value: '',
      title: "Enter Success Factor",
      placement: 'right',
      datepicker: {
        weekStart: 1
      },
      validate: function(value) {
        if ($.trim(value) == '') {
          return 'This field is required';
        }
      }
    });

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
      populateForm(datum.projid);
      //alert( "http://www.evolvus.com/project/viewprojdetails.php?proj_id="+datum.projid);
      //window.location  = "viewprojdetails.php?proj_id="+datum.projid;
    });

    var url = new URL(document.URL);
    var search_params = url.searchParams;

    projectid = search_params.get('projid');
    if (projectid)
      populateForm(projectid);

    $('button[id^="ACT"]').on("click", function(event) {
      $.post(
        "api/updateProjectStatus.php", {
          status: $(this).attr("data-status"),
          projid: $(this).attr("data-projectid")
        },
        function(data) {
          var alertBox = '<div id="status-alert" class="alert alert-' + data.type + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + data.message + '</div>';
          $('#update-status').html(alertBox);
          $("#status-alert").fadeTo(2000, 500).slideUp(500, function() {
            $("#status-alert").slideUp(500);
          });
          populateForm(data.projid);
          showActionButton(data.status, data.projid)
        }
      );
    });


  });

  function showActionButton(status, projid) {
    $("#ACT-1").attr('data-projectid', projid);
    $("#ACT-2").attr('data-projectid', projid);
    $("#ACT-3").attr('data-projectid', projid);

    $("#ACT-1").show();
    $("#ACT-2").show();
    $("#ACT-3").show();

    if (status == "ACTIVE") {
      $("#ACT-1").html('DEACTIVATE'),
        $("#ACT-1").attr('data-status', 'DEACTIVATED');

      $("#ACT-2").html('INITIATE CLOSURE'),
        $("#ACT-2").attr('data-status', 'INITIATE CLOSURE');

      $("#ACT-3").html('PENDING INVOICE'),
        $("#ACT-3").attr('data-status', 'PENDING INVOICE');
    }

    if (status == "DEACTIVATED") {
      $("#ACT-1").html('ACTIVATE'),
        $("#ACT-1").attr('data-status', 'ACTIVE');

      $("#ACT-2").html('INITIATE CLOSURE'),
        $("#ACT-2").attr('data-status', 'INITIATE CLOSURE');

      $("#ACT-3").html('PENDING INVOICE'),
        $("#ACT-3").attr('data-status', 'PENDING INVOICE');
    }

    if (status == "PENDING INVOICE") {
      $("#ACT-1").html('ACTIVATE'),
        $("#ACT-1").attr('data-status', 'ACTIVE');

      $("#ACT-2").html('INITIATE CLOSURE'),
        $("#ACT-2").attr('data-status', 'INITIATE CLOSURE');

      $("#ACT-3").hide();
    }

    if (status == "INITIATED") {
      $("#ACT-1").html('AUTHORISE'),
        $("#ACT-1").attr('data-status', 'AUTHORISED');

      $("#ACT-2").html('DELETE'),
        $("#ACT-2").attr('data-status', 'DELETED');

      $("#ACT-3").hide();
    }

    if (status == "AUTHORISED") {
      $("#ACT-1").html('APPROVE'),
        $("#ACT-1").attr('data-status', 'APPROVED');

      $("#ACT-2").html('DELETE'),
        $("#ACT-2").attr('data-status', 'DELETED');

      $("#ACT-3").hide();
    }

    if (status == "APPROVED") {
      $("#ACT-1").html('ACTIVATE'),
        $("#ACT-1").attr('data-status', 'ACTIVE');

      $("#ACT-2").hide();
      $("#ACT-3").hide();
    }

    if (status == "INITIATE CLOSURE") {
      $("#ACT-1").html('AUTHORISE CLOSURE'),
        $("#ACT-1").attr('data-status', 'AUTHORISE CLOSURE');

      $("#ACT-2").hide();
      $("#ACT-3").hide();
    }

    if (status == "AUTHORISE CLOSURE") {
      $("#ACT-1").html('CLOSE'),
        $("#ACT-1").attr('data-status', 'CLOSED');

      $("#ACT-2").hide();
      $("#ACT-3").hide();
    }

    if (status == "CLOSED" || status == "DELETED") {

      $("#ACT-1").hide();
      $("#ACT-2").hide();
      $("#ACT-3").hide();
    }


  }

  function populateForm(projid) {
    // grab the correct input and output elements
    $("#proj-info").show();
    var url = "api/getProject.php?projid=" + projid;
    var dataJSON = "";

    $.getJSON(url, function(data) {


      $('#1B1').editable('setValue', data[0]['project_type_id']);
      $('#1B1').editable('option', 'pk', projid);

      $('#3B1').editable('setValue', data[0]['customer_id']);
      $('#3B1').editable('option', 'pk', projid);

      $('#4B1').editable('setValue', data[0]['region_id']);
      $('#4B1').editable('option', 'pk', projid);

      $('#2B1').editable('setValue', data[0]['project_name']);
      $('#2B1').editable('option', 'pk', projid);

      $('#5B1').editable('setValue', data[0]['status']);
      $('#5B1').editable('option', 'pk', projid);
      showActionButton(data[0]['status'], projid);

      $('#1B2').editable('setValue', data[0]['profit_centre_id']);
      $('#1B2').editable('option', 'pk', projid);

      $('#2B2').editable('setValue', data[0]['base_product']);
      $('#2B2').editable('option', 'pk', projid);

      $('#3B2').editable('setValue', data[0]['project_manager_id']);
      $('#3B2').editable('option', 'pk', projid);

      $('#4B2').editable('setValue', data[0]['project_director_id']);
      $('#4B2').editable('option', 'pk', projid);

      $('#5B2').editable('setValue', data[0]['report_type']);
      $('#5B2').editable('option', 'pk', projid);

      $('#1B3').editable('setValue', data[0]['planned_start_date'], true);
      $('#1B3').editable('option', 'pk', projid);
      //
      $('#2B3').editable('setValue', data[0]['planned_end_date'], true);
      $('#2B3').editable('option', 'pk', projid);

      $('#3B3').editable('setValue', data[0]['actual_start_date'], true);
      $('#3B3').editable('option', 'pk', projid);
      //
      $('#4B3').editable('setValue', data[0]['actual_end_date'], true);
      $('#4B3').editable('option', 'pk', projid);

      $('#5B3').editable('setValue', data[0]['extension']);
      $('#5B3').editable('option', 'pk', projid);

      $('#G1B1').editable('setValue', data[0]['project_details']);
      $('#G1B1').editable('option', 'pk', projid);

      $('#G2B1').editable('setValue', data[0]['objectives']);
      $('#G2B1').editable('option', 'pk', projid);

      $('#G1B2').editable('setValue', data[0]['scope']);
      $('#G1B2').editable('option', 'pk', projid);

      $('#G2B2').editable('setValue', data[0]['success_factor']);
      $('#G2B2').editable('option', 'pk', projid);

      var lnk = 'viewprojdetails.php?proj_id=' + projid
      $('#G3B1').html('<a href="' + lnk + '">Click Here</a>');

      totalRevenue =
        parseFloat(data[0]['invoice_pending_lcy_amt']) +
        parseFloat(data[0]['invoiced_lcy_amt']) +
        parseFloat(data[0]['received_lcy_amt']);

      totalBudgetApproved =
        parseFloat(data[0]['budget_approved']) +
        parseFloat(data[0]['excess_budget_approved']);

      totalExpense =
        parseFloat(data[0]['unified_labour_cost']) +
        parseFloat(data[0]['expense_amt']);



      $('#F1B1').html(amtFormat(data[0]['Contract_value']));
      $('#F2B1').html(amtFormat(data[0]['cr_amt']));
      $('#F3B1').html(amtFormat(parseFloat(data[0]['Contract_value']) + parseFloat(data[0]['cr_amt'])));

      $('#F1B2').html(amtFormat(data[0]['budget_initiated']));
      $('#F2B2').html(amtFormat(data[0]['excess_budget_initiated']));
      $('#F3B2').html(amtFormat(parseFloat(data[0]['budget_initiated']) + parseFloat(data[0]['excess_budget_initiated'])));

      $('#F1B3').html(amtFormat(data[0]['budget_approved']));
      $('#F2B3').html(amtFormat(data[0]['excess_budget_approved']));
      $('#F3B3').html(amtFormat(totalBudgetApproved));

      $('#F1B4').html(amtFormat(data[0]['base_labour_cost']));
      $('#F2B4').html(amtFormat(data[0]['unified_labour_cost']));
      $('#F3B4').html(amtFormat(data[0]['expense_amt']));
      $('#F4B4').html(amtFormat(totalExpense));

      $('#F1B5').html(amtFormat(totalRevenue));
      $('#F2B5').html(amtFormat(data[0]['invoice_pending_lcy_amt']));
      $('#F3B5').html(amtFormat(data[0]['invoiced_lcy_amt']));
      $('#F4B5').html(amtFormat(data[0]['received_lcy_amt']));

      $('#F1B6').html(amtFormat(totalBudgetApproved - totalExpense));
      if (100 * (totalBudgetApproved - totalExpense) / totalBudgetApproved < 0) {
        $('#F1A6').addClass('alert alert-danger');
        $('#F1B6').addClass('alert alert-danger');

        $('#F1A6').removeClass('alert alert-warning');
        $('#F1B6').removeClass('alert alert-warning');

        $('#F1A6').removeClass('alert alert-success');
        $('#F1B6').removeClass('alert alert-success');
      } else if (100 * (totalBudgetApproved - totalExpense) / totalBudgetApproved < 10.0) {
        $('#F1A6').addClass('alert alert-warning');
        $('#F1B6').addClass('alert alert-warning');

        $('#F1A6').removeClass('alert alert-danger');
        $('#F1B6').removeClass('alert alert-danger');

        $('#F1A6').removeClass('alert alert-success');
        $('#F1B6').removeClass('alert alert-success');
      } else {
        $('#F1A6').addClass('alert alert-success');
        $('#F1B6').addClass('alert alert-success');

        $('#F1A6').removeClass('alert alert-danger');
        $('#F1B6').removeClass('alert alert-danger');

        $('#F1A6').removeClass('alert alert-warning');
        $('#F1B6').removeClass('alert alert-warning');
      }

      if (data[0]['Contract_value'] < 1) {

        $('#F2A6').hide();
        $('#F2B6').hide();
        $('#F3A6').hide();
        $('#F3B6').hide();
        $('#F4A6').hide();
        $('#F4B6').hide();



      } else {

        $('#F2A6').show();
        $('#F2B6').show();
        $('#F3A6').show();
        $('#F3B6').show();
        $('#F4A6').show();
        $('#F4B6').show();

        $('#F2B6').html(amtFormat(parseFloat(data[0]['received_lcy_amt']) - totalExpense));
        $('#F3B6').html(amtFormat(totalRevenue - totalExpense));
        $('#F4B6').html(amtFormat(100 * (totalRevenue - totalExpense) / totalRevenue) + "%");


        if (100 * (totalRevenue - totalExpense) < 0.0) {
          $('#F3A6').addClass('alert alert-danger');
          $('#F3B6').addClass('alert alert-danger');

          $('#F3A6').removeClass('alert alert-warning');
          $('#F3B6').removeClass('alert alert-warning');

          $('#F3A6').removeClass('alert alert-success');
          $('#F3B6').removeClass('alert alert-success');
        } else if (100 * (totalRevenue - totalExpense) / totalRevenue < 50.0) {
          $('#F3A6').addClass('alert alert-warning');
          $('#F3B6').addClass('alert alert-warning');

          $('#F3A6').removeClass('alert alert-success');
          $('#F3B6').removeClass('alert alert-success');

          $('#F3A6').removeClass('alert alert-danger');
          $('#F3B6').removeClass('alert alert-danger');

        } else {
          $('#F3A6').addClass('alert alert-success');
          $('#F3B6').addClass('alert alert-success');

          $('#F3A6').removeClass('alert alert-warning');
          $('#F3B6').removeClass('alert alert-warning');

          $('#F3A6').removeClass('alert alert-danger');
          $('#F3B6').removeClass('alert alert-danger');
        }

        if (100 * (totalRevenue - totalExpense) / totalRevenue < 40.0) {
          $('#F4A6').addClass('alert alert-danger');
          $('#F4B6').addClass('alert alert-danger');

          $('#F4A6').removeClass('alert alert-warning');
          $('#F4B6').removeClass('alert alert-warning');

          $('#F4A6').removeClass('alert alert-success');
          $('#F4B6').removeClass('alert alert-success');
        } else if (100 * (totalRevenue - totalExpense) / totalRevenue < 50.0) {
          $('#F4A6').addClass('alert alert-warning');
          $('#F4B6').addClass('alert alert-warning');

          $('#F4A6').removeClass('alert alert-danger');
          $('#F4B6').removeClass('alert alert-danger');

          $('#F4A6').removeClass('alert alert-success');
          $('#F4B6').removeClass('alert alert-success');
        } else {
          $('#F4A6').addClass('alert alert-success');
          $('#F4B6').addClass('alert alert-success');

          $('#F4A6').removeClass('alert alert-danger');
          $('#F4B6').removeClass('alert alert-danger');

          $('#F4A6').removeClass('alert alert-warning');
          $('#F4B6').removeClass('alert alert-warning');
        }

        if (parseFloat(data[0]['received_lcy_amt']) - totalExpense < 0) {
          $('#F2A6').addClass('alert alert-danger');
          $('#F2B6').addClass('alert alert-danger');

          $('#F2A6').removeClass('alert alert-success');
          $('#F2B6').removeClass('alert alert-success');

          $('#F2A6').removeClass('alert alert-warning');
          $('#F2B6').removeClass('alert alert-warning');
        } else if (100 * (data[0]['received_lcy_amt'] - totalExpense) / data[0]['received_lcy_amt'] < 10.0) {
          $('#F2A6').addClass('alert alert-warning');
          $('#F2B6').addClass('alert alert-warning');

          $('#F2A6').removeClass('alert alert-success');
          $('#F2B6').removeClass('alert alert-success');

          $('#F2A6').removeClass('alert alert-danger');
          $('#F2B6').removeClass('alert alert-danger');
        } else {
          $('#F2A6').addClass('alert alert-success');
          $('#F2B6').addClass('alert alert-success');

          $('#F2A6').removeClass('alert alert-warning');
          $('#F2B6').removeClass('alert alert-warning');

          $('#F2A6').removeClass('alert alert-danger');
          $('#F2B6').removeClass('alert alert-danger');
        }
      }



      if (data[0]['noofdays'] < 0) {
        $('#5A4').removeClass('alert alert-success');
        $('#5B4').removeClass('alert alert-success');
        $('#5A4').addClass('alert alert-danger');
        $('#5B4').addClass('alert alert-danger');
        $('#5A4').html("Delayed by");
        $('#5B4').html(Math.abs(data[0]['noofdays']) + " Days");
      } else {
        $('#5A4').removeClass('alert alert-danger');
        $('#5B4').removeClass('alert alert-danger');
        $('#5A4').addClass('alert alert-success');
        $('#5B4').addClass('alert alert-success');
        $('#5A4').html("Duration Left");
        $('#5B4').html(data[0]['noofdays'] + " Days");
      }


    });

    showLabourMonth(projid);
    showLabourEmp(projid);

    showExpenseMonth(projid);
    showExpenseType(projid);

    showInvoiceSummary(projid);
    showInvoiceDetail(projid);
    showBudgetDetail(projid);

    showCRDetail(projid);
    showInvoicePie(projid);
    showInvoiceLine(projid);
    showLabourLine(projid);
    showLabourBar(projid);
    showLabourPie(projid)

  }

  function showLabourMonth(projid) {
    if ($.fn.dataTable.isDataTable('#monthLabour')) {
      $('#monthLabour').DataTable().destroy();
    }
    table = $('#monthLabour').DataTable({
      "paging": false,
      "ordering": false,
      "info": false,
      "searching": false,
      "ajax": {
        url: "api/getFinanceList.php",
        data: function(d) {
          d.projectid = projid;
          d.type = "MonthLabour";
        }
      },
      "columns": [{
          "data": "REPORT_MONTH",
          "render": function(data, type, row, meta) {
            if (type === 'display') {
              if (data != "TOTAL") {

                const [year, month, day] = data.split(" ")[0].split("-");
                const date = new Date(year, month - 1, day);
                data = date.toLocaleString('default', {
                  month: 'long'
                }) + " " + year;
              }

            }
            return data;
          }
        },
        {
          "className": "text-right",
          "data": "WORK_HOURS",
          "render": function(data, type, row, meta) {
            if (type === 'display') {
              data = amtFormat(data);
            }
            return data;
          }
        },
        {
          "className": "text-right",
          "data": "LABOURCOST",
          "render": function(data, type, row, meta) {
            if (type === 'display') {
              data = amtFormat(data);
            }
            return data;
          }
        },
        {
          "className": "text-right",
          "data": "UNIFIEDCOST",
          "render": function(data, type, row, meta) {
            if (type === 'display') {
              data = amtFormat(data);
            }
            return data;
          }
        }

      ]

    });

  }


  function showLabourEmp(projid) {
    if ($.fn.dataTable.isDataTable('#empLabour')) {
      $('#empLabour').DataTable().destroy();
    }
    table = $('#empLabour').DataTable({
      "paging": false,
      "ordering": false,
      "info": false,
      "searching": false,
      "ajax": {
        url: "api/getFinanceList.php",
        data: function(d) {
          d.projectid = projid;
          d.type = "EmpLabour";
        }
      },
      "columns": [{
          "data": "EMPLOYEE_NAME"
        },
        {
          "className": "text-right",
          "data": "WORK_HOURS",
          "render": function(data, type, row, meta) {
            if (type === 'display') {
              data = amtFormat(data);
            }
            return data;
          }
        }

      ]

    });

  }

  function showExpenseMonth(projid) {
    if ($.fn.dataTable.isDataTable('#monthExpense')) {
      $('#monthExpense').DataTable().destroy();
    }
    table = $('#monthExpense').DataTable({
      "paging": false,
      "ordering": false,
      "info": false,
      "searching": false,
      "ajax": {
        url: "api/getFinanceList.php",
        data: function(d) {
          d.projectid = projid;
          d.type = "MonthExpense";
        }
      },
      "columns": [{
          "data": "REPORT_MONTH",
          "render": function(data, type, row, meta) {
            if (type === 'display') {
              if (data != "TOTAL") {

                const [year, month, day] = data.split(" ")[0].split("-");
                const date = new Date(year, month - 1, day);
                data = date.toLocaleString('default', {
                  month: 'long'
                }) + " " + year;
              }

            }
            return data;
          }
        },
        {
          "className": "text-right",
          "data": "EXPENSE_AMOUNT",
          "render": function(data, type, row, meta) {
            if (type === 'display') {
              data = amtFormat(data);
            }
            return data;
          }
        }

      ]

    });

  }

  function showExpenseType(projid) {
    if ($.fn.dataTable.isDataTable('#typExpense')) {
      $('#typExpense').DataTable().destroy();
    }
    table = $('#typExpense').DataTable({
      "paging": false,
      "ordering": false,
      "info": false,
      "searching": false,
      "ajax": {
        url: "api/getFinanceList.php",
        data: function(d) {
          d.projectid = projid;
          d.type = "TypeExpense";
        }
      },
      "columns": [{
          "data": "EXPENSE_TYPE"
        },
        {
          "className": "text-right",
          "data": "EXPENSE_AMOUNT",
          "render": function(data, type, row, meta) {
            if (type === 'display') {
              data = amtFormat(data);
            }
            return data;
          }
        }

      ]

    });

  }

  function showInvoiceSummary(projid) {
    if ($.fn.dataTable.isDataTable('#INVSUM')) {
      $('#INVSUM').DataTable().destroy();
    }
    table = $('#INVSUM').DataTable({
      "paging": false,
      "ordering": false,
      "info": false,
      "searching": false,
      "ajax": {
        url: "api/getFinanceList.php",
        data: function(d) {
          d.projectid = projid;
          d.type = "InvoiceSummary";
        }
      },
      "columns": [{
          "data": "INVOICE_STATUS"
        },
        {
          "className": "text-right",
          "data": "LCY_AMOUNT",
          "render": function(data, type, row, meta) {
            if (type === 'display') {
              data = amtFormat(data);
            }
            return data;
          }
        }

      ]

    });

  }

  function showInvoiceDetail(projid) {
    if ($.fn.dataTable.isDataTable('#INVDET')) {
      $('#INVDET').DataTable().destroy();
    }
    table = $('#INVDET').DataTable({
      "paging": false,
      "ordering": false,
      "info": false,
      "searching": false,
      "ajax": {
        url: "api/getFinanceList.php",
        data: function(d) {
          d.projectid = projid;
          d.type = "InvoiceDetail";
        }
      },
      "columns": [
        {"data": "STATUS"},{"data": "MILESTONE_DESC"}, {"data": "INVOICE_NO"},
        {"data": "INVOICE_DATE"},{"data": "PAY_DATE"},
        {
          "className": "text-right",
          "data": "LCY_AMOUNT",
          "render": function(data, type, row, meta) {
            if (type === 'display') {
              data = amtFormat(data);
            }
            return data;
          }
        }

      ]

    });

  }

  function showBudgetDetail(projid) {
    if ($.fn.dataTable.isDataTable('#budget')) {
      $('#budget').DataTable().destroy();
    }
    table = $('#budget').DataTable({
      "paging": false,
      "ordering": false,
      "info": false,
      "searching": false,
      "ajax": {
        url: "api/getFinanceList.php",
        data: function(d) {
          d.projectid = projid;
          d.type = "Budget";
        }
      },
      "columns": [
        {"data": "STATUS"},{"data": "BUDGET_NAME"}, {"data": "CATEGORY"},
        {
          "className": "text-right",
          "data": "EXCESS_BUDGET",
          "render": function(data, type, row, meta) {
            if (type === 'display') {
              data = amtFormat(data);
            }
            return data;
          }
        }

      ]

    });

  }

  function showCRDetail(projid) {
    if ($.fn.dataTable.isDataTable('#change')) {
      $('#change').DataTable().destroy();
    }
    table = $('#change').DataTable({
      "paging": false,
      "ordering": false,
      "info": false,
      "searching": false,
      "ajax": {
        url: "api/getFinanceList.php",
        data: function(d) {
          d.projectid = projid;
          d.type = "Change";
        }
      },
      "columns": [
        {"data": "CR_NAME"},{"data": "CR_START_DATE"}, {"data": "STATUS"},
        {
          "className": "text-right",
          "data": "CR_AMOUNT",
          "render": function(data, type, row, meta) {
            if (type === 'display') {
              data = amtFormat(data);
            }
            return data;
          }
        }

      ]

    });

  }



  function showInvoicePie(projid) {
    var data =[];
    var labels =[];

    $.getJSON({
      url: "api/getFinanceList.php",
      data: {
        projectid : projid,
        type : "InvoiceSummary"
      },
      success: function (response) {//response is value returned from php
        var i = 0;
        response['data'].forEach( function(element) {
          if(element['INVOICE_STATUS'] != "TOTAL"){
              data.push(parseInt(element['LCY_AMOUNT']));
            labels.push(element['INVOICE_STATUS']);
          }//ENd of if

        });//End of foreach
        pieChart('inv1',data,labels,"INVOICE BY STATUS");
      }//end of success

    });//end of getJSON

  }//end of function showInvoicePie

  function showInvoiceLine(projid) {
    var data =[];
    var data1 =[];
    var data2 =[];
    var labels =[];


    $.getJSON({
      url: "api/getFinanceList.php",
      data: {
        projectid : projid,
        type : "InvoiceDetail"
      },
      success: function (response) {//response is value returned from php
        var i = 0;
        response['data'].forEach( function(element) {
          a = {x:element['INVOICE_DATE'],y:parseInt(element['LCY_AMOUNT'])};
          data1.push(a);
          a = {x:element['PAY_DATE'],y:parseInt(element['LCY_AMOUNT'])};
          data2.push(a);
          labels.push(element['INVOICE_DATE']);
        });//End of foreach

        data.push({data:data1,label:"Invoice"});
        data.push({data:data2,label:"Payment"});



        lineChart('inv2', data, labels,"INVOICE TREND BY DATE")
      }//end of success

    });//end of getJSON

  }//end of function showInvoiceLine

  function showLabourLine(projid) {
    var data =[];
    var data1 =[];
    var data2 =[];
    var labels =[];


    $.getJSON({
      url: "api/getFinanceList.php",
      data: {
        projectid : projid,
        type : "MonthLabour"
      },
      success: function (response) {//response is value returned from php
        var i = 0;
        response['data'].forEach( function(element) {
          if(element['REPORT_MONTH'] != "TOTAL" && !isNaN(parseInt(element['UNIFIEDCOST'])) ){
            a = {x:element['REPORT_MONTH'],y:parseInt(element['UNIFIEDCOST'])};
            data1.push(a);
            a = {x:element['REPORT_MONTH'],y:parseInt(element['WORK_HOURS'])};
            data2.push(a);
          }

          labels.push(element['REPORT_MONTH']);
        });//End of foreach

        data.push({data:data1,label:"Monthly Cost"});
        data.push({data:data2,label:"Monthly Work"});

        lineChart('lab1', data, labels,"LABOUR TREND BY COST AND WORK HOURS")
      }//end of success

    });//end of getJSON

  }//end of function showLabourLine

  function showLabourBar(projid) {
    var data =[];
    var data1 =[];
    var data2 =[];
    var labels =[];


    $.getJSON({
      url: "api/getFinanceList.php",
      data: {
        projectid : projid,
        type : "EmpLabour"
      },
      success: function (response) {//response is value returned from php
        var i = 0;
        response['data'].forEach( function(element) {
          if(element['EMPLOYEE_NAME'] != "TOTAL" && !isNaN(parseInt(element['UNIFIEDCOST'])) ){
            a = {x:element['EMPLOYEE_NAME'],y:parseInt(element['WORK_HOURS'])};
            data1.push(a);
            a = {x:element['EMPLOYEE_NAME'],y:parseInt(element['UNIFIEDCOST'])};
            data2.push(a);
          }

          labels.push(element['EMPLOYEE_NAME']);
        });//End of foreach

        data.push({data:data1,label:"Employee Cost"});
        data.push({data:data2,label:"Employee Work"});

        barChart('lab2', data, labels,"LABOUR TREND BY EMPLOYEE")
      }//end of success

    });//end of getJSON

  }//end of function showLabourBar

  function showLabourPie(projid) {
    var data =[];
    var labels =[];

    $.getJSON({
      url: "api/getFinanceList.php",
      data: {
        projectid : projid,
        type : "EmpLabour"
      },
      success: function (response) {//response is value returned from php
        var i = 0;
        response['data'].forEach( function(element) {
          if(element['EMPLOYEE_NAME'] != "TOTAL"){
              data.push(parseInt(element['UNIFIEDCOST']));
            labels.push(element['EMPLOYEE_NAME']);
          }//ENd of if

        });//End of foreach
        pieChart('lab3',data,labels,"UNIFIED COST BY EMPLOYEE");
      }//end of success

    });//end of getJSON

  }//end of function showLabourPie

</script>

<script type="text/javascript" src="script/jquery.populate.pack.js"></script>

<script src="script/evolvusgraph.js"> </script>



<form class="form-horizontal" id="project-form">
  <fieldset>

    <!-- Form Name -->
    <legend>Project Information</legend>

    <!-- Search input-->
    <div id="projSearch" class="form-group">

      <div id='row'>
        <div class="col-md-5">

          <div class="input-group">
            <input id="prj" name="prj" type="input" placeholder="Enter Project Name" class="form-control input-md typeahead" required="" aria-describedby="glph" autocomplete="sprcatre">
            <span class="input-group-addon" id="glph"><span class="glyphicon glyphicon-search"></span></span>
          </div>
          <div id="update-status"></div>
        </div>

        <div>
        </div>
      </div>
    </div>

  </fieldset>
</form>

<div id="proj-info">
  <div>
    <ul class='nav nav-pills  split-button-nav'>
      <li class='active'>
        <a data-toggle='tab' href='#GEN'>GENERAL</a>
      </li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
          FINANCE <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
          <li>
            <a data-toggle='tab' href='#FINSUM'>SUMMARY</a>
          </li>
          <li>
            <a data-toggle='tab' href='#FININV'>INVOICES</a>
          </li>
          <li>
            <a data-toggle='tab' href='#BDGT'>BUDGET</a>
          </li>
        </ul>
      </li>
      <li>
        <a data-toggle='tab' href='#DET'>DETAILS</a>
      </li>
      <li>
        <a data-toggle='tab' href='#LAB'>LABOUR</a>
      </li>
      <li>
        <a data-toggle='tab' href='#EXP'>EXPENSE</a>
      </li>
      <li>
        <a data-toggle='tab' href='#CHGREQ'>CHANGE REQUEST</a>
      </li>

    </ul>
  </div>
  <br />




  <div class='tab-content'>
    <div class="tab-pane fade in active" id="GEN">
      <p>
      <div class="row">
        <form id="gen-form" role="form">
          <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
            <table class="table table-striped">
              <tr>
                <th id="1A1">Project Type</th>
                <td id="1B1"></td>
              </tr>
              <tr>
                <th id="2A1">Project Name</th>
                <td id="2B1">
              </tr>
              <tr>
                <th id="3A1">Customer</th>
                <td id="3B1"></td>
              </tr>
              <tr>
                <th id="4A1">Region</th>
                <td id="4B1"></td>
              </tr>
              <tr>
                <th id="5A1">Status</th>
                <td id="5B1"></td>
              </tr>
            </table>
          </div>
          <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
            <table class="table table-striped">
              <tr>
                <th id="1A2">Profit Centre</th>
                <td id="1B2"></td>
              </tr>
              <tr>
                <th id="2A2">Product</th>
                <td id="2B2">
              </tr>
              <tr>
                <th id="3A2">Project Manager</th>
                <td id="3B2"></td>
              </tr>
              <tr>
                <th id="4A2">Project Director</th>
                <td id="4B2"></td>
              </tr>
              <tr>
                <th id="5A2">Report Period</th>
                <td id="5B2"></td>
              </tr>
            </table>
          </div>
          <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
            <table class="table table-striped">
              <tr>
                <th id="1A3">Planned Start Date</th>
                <td id="1B3"></td>
              </tr>
              <tr>
                <th id="2A3">Planned End Date</th>
                <td id="2B3">
              </tr>
              <tr>
                <th id="3A3">Actual Start Date</th>
                <td id="3B3"></td>
              </tr>
              <tr>
                <th id="4A3">Actual End Date</th>
                <td id="4B3"></td>
              </tr>
              <tr>
                <th id="5A3">Extension</th>
                <td id="5B3"></td>
              </tr>
              <tr>
                <th id="5A4"></th>
                <td id="5B4"></td>
              </tr>
            </table>
          </div>
        </form>
      </div>

      </p>
      <div class="row">
        <div class="col-sm-12 text-left">

          <button type="button" class="btn btn-primary" id="ACT-1" data-projectid="" data-status="">ACTIVATE</button>
          <button type="button" class="btn btn-primary" id="ACT-2" data-projectid="" data-status="">CLOSED</button>
          <button type="button" class="btn btn-primary" id="ACT-3" data-projectid="" data-status="">PENDING INVOICE</button>
        </div>
      </div>

    </div>
    <!--End of general content -->

    <div class="tab-pane fade" id="FINSUM">
      <p>
      <h4>SUMMARY</h4>
      <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
        <table class="table table-striped">
          <tr>
            <th id="F1A1">Contract Amount</th>
            <td id="F1B1" class="text-right"></td>
          </tr>
          <tr>
            <th id="F2A1">Change Request</th>
            <td id="F2B1" class="text-right"></td>
          </tr>
          <tr>
            <th id="F3A1">Total Value</th>
            <td id="F3B1" class="text-right"></td>
          </tr>
        </table>
      </div>
      <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
        <table class="table table-striped">
          <tr>
            <th id="F1A2">Normal Budget Initated</th>
            <td id="F1B2" class="text-right"></td>
          </tr>
          <tr>
            <th id="F2A2">Excess Budget Initated</th>
            <td id="F2B2" class="text-right"></td>
          </tr>
          <tr>
            <th id="F3A2">Total Budget Initated</th>
            <td id="F3B2" class="text-right"></td>
          </tr>
        </table>
      </div>
      <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
        <table class="table table-striped">
          <tr>
            <th id="F1A3">Normal Budget Approved</th>
            <td id="F1B3" class="text-right"></td>
          </tr>
          <tr>
            <th id="F2A3">Excess Budget Approved</th>
            <td id="F2B3" class="text-right"></td>
          </tr>
          <tr>
            <th id="F3A3">Total Budget Approved</th>
            <td id="F3B3" class="text-right"></td>
          </tr>

        </table>
      </div>
      <div class="clearfix"></div>
      <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
        <table class="table table-striped">
          <tr>
            <th id="F1A4">Base Labour Cost</th>
            <td id="F1B4" class="text-right"></td>
          </tr>
          <tr>
            <th id="F2A4">Unified Labour Cost</th>
            <td id="F2B4" class="text-right"></td>
          </tr>
          <tr>
            <th id="F3A4">Expense</th>
            <td id="F3B4" class="text-right"></td>
          </tr>
          <tr>
            <th id="F4A4">Total Cost</th>
            <td id="F4B4" class="text-right"></td>
          </tr>
        </table>
      </div>
      <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
        <table class="table table-striped">
          <tr>
            <th id="F2A5">Pending to be Invoiced</th>
            <td id="F2B5" class="text-right"></td>
          </tr>
          <tr>
            <th id="F3A5">Invoiced Amount</th>
            <td id="F3B5" class="text-right"></td>
          </tr>
          <tr>
            <th id="F4A5">Paid Amount</th>
            <td id="F4B5" class="text-right"></td>
          </tr>
          <tr>
            <th id="F1A5">Total Invoice</th>
            <td id="F1B5" class="text-right"></td>
          </tr>
        </table>
      </div>
      <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
        <table class="table table-striped">
          <tr>
            <th id="F1A6">Budget To Go</th>
            <td id="F1B6" class="text-right"></td>
          </tr>
          <tr>
            <th id="F2A6">Cashflow</th>
            <td id="F2B6" class="text-right"></td>
          </tr>
          <tr>
            <th id="F3A6">Running Profit</th>
            <td id="F3B6" class="text-right"></td>
          </tr>
          <tr>
            <th id="F4A6">Running Profit Percentage</th>
            <td id="F4B6" class="text-right"></td>
          </tr>
        </table>
      </div>

      </p>
    </div>
    <div class="tab-pane fade" id="FININV">
      <p>
     <h4>INVOICES</h4>
        <div id="tableholder" class="table-responsive col-md-3">

          <table id="INVSUM" class="table table-striped" width="100%">
            <thead>
              <tr>
                <th>Invoice Status</th>
                <th>Invoice Amount</th>
              </tr>
            </thead>
          </table>
        </div>
        <div class="table-responsive col-md-3">
          <!-- <div id="container" style="width:100; height:100;"></div> -->
          <canvas id="inv1" width="50" height="50"></canvas>

        </div>
        <div class="table-responsive col-md-6">
          <!-- <div id="container" style="width:100; height:100;"></div> -->
          <canvas id="inv2" width="300" height="150"></canvas>

        </div>
        <div class="clearfix"></div>

      <div class="table-responsive col-md-9">
        <table id="INVDET" class="table table-striped" width="100%">
          <thead>
            <tr>
              <th>Status</th>
              <th>Milestone</th>
              <th>Invoice No</th>
              <th>Invoice Date</th>
              <th>Pay Date</th>
              <th>Invoice Amount</th>
            </tr>
          </thead>
        </table>
      </div>




      </p>
    </div>

    <div class="tab-pane fade" id="DET">
      <p>
      <div class="form-group col-xs-5 col-sm-6 col-md-6 col-lg-6">
        <table class="table table-striped">
          <tr>
            <th id="G1A1">Project Details</th>
            <td id="G1B1"></td>
          </tr>
          <tr>
            <th id="G2A1">Objectives</th>
            <td id="G2B1"></td>
          </tr>
          <tr>
            <th id="G3A1"> More Details</th>
            <td id="G3B1"></td>
          </tr>
        </table>
      </div>
      <div class="form-group col-xs-5 col-sm-6 col-md-6 col-lg-6">
        <table class="table table-striped">
          <tr>
            <th id="G1A2">Scope</th>
            <td id="G1B2"></td>
          </tr>
          <tr>
            <th id="G2A2">Success Factor</th>
            <td id="G2B2"></td>
          </tr>
        </table>
      </div>
      </p>
    </div>


    <div class="tab-pane fade" id="LAB">
      <p>
        <div class="table-responsive col-md-4">
          <!-- <div id="container" style="width:100; height:100;"></div> -->
          <canvas id="lab1" width="50" height="50"></canvas>

        </div>
        <div class="table-responsive col-md-4">
          <!-- <div id="container" style="width:100; height:100;"></div> -->
          <canvas id="lab2" width="50" height="50"></canvas>

        </div>
        <div class="table-responsive col-md-4">
          <!-- <div id="container" style="width:100; height:100;"></div> -->
          <canvas id="lab3" width="50" height="50"></canvas>

        </div>
        <div class="clearfix"></div>

      <div id="tableholder" class="table-responsive col-md-6">

        <table id="monthLabour" class="table table-striped" width="100%">
          <thead>
            <tr>
              <th>Report Month</th>
              <th>Hours Booked</th>
              <th>Labour Cost</th>
              <th>Unified Cost</th>
            </tr>
          </thead>
        </table>
      </div>
      <div class="table-responsive col-md-6">
        <table id="empLabour" class="table table-striped" width="100%">
          <thead>
            <tr>
              <th>Employee Name</th>
              <th>Hours Booked</th>
            </tr>
          </thead>
        </table>
      </div>

      </p>
    </div>

    <div class="tab-pane fade" id="EXP">
      <p>
      <div id="tableholder" class="table-responsive col-md-6">

        <table id="monthExpense" class="table table-striped" width="100%">
          <thead>
            <tr>
              <th>Report Month</th>
              <th>Expense Amount</th>
            </tr>
          </thead>
        </table>
      </div>
      <div class="table-responsive col-md-6">
        <table id="typExpense" class="table table-striped" width="100%">
          <thead>
            <tr>
              <th>Expense Type</th>
              <th>Expense Amount</th>
            </tr>
          </thead>
        </table>
      </div>

      </p>
    </div>

    <div class="tab-pane fade" id="BDGT">
      <p>
        <h4>BUDGET</h4>

      <div id="tableholder" class="table-responsive col-md-6">

        <table id="budget" class="table table-striped" width="100%">
          <thead>
            <tr>
              <th>BUDGET STATUS</th>
              <th>BUDGET NAME</th>
              <th>CATEGORY</th>
              <th>BUDGET AMOUNT</th>
            </tr>
          </thead>
        </table>
      </div>


      </p>
    </div>

    <div class="tab-pane fade" id="CHGREQ">
      <p>

      <div id="tableholder" class="table-responsive col-md-9">

        <table id="change" class="table table-striped" width="100%">
          <thead>
            <tr>
              <th>CR NAME</th>
              <th>START DATE</th>
              <th>STATUS</th>
              <th>CR AMOUNT</th>
            </tr>
          </thead>
        </table>
      </div>


      </p>
    </div>


  </div>
  <!--End of tab content -->



</div>
<!--End of proj-info -->







<?php

require_once('bodyend.php');

?>
