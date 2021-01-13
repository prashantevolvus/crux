<?php
$permission = "VIEW";
require_once('head.php');

require_once('bodystart.php');

$con = getConnection();

?>

<script src="script/evolvusgraph.js"> </script>


<script type="text/javascript">
    $(document).ready(function() {
                $.getJSON("api/getChangeRequestList.php?projid=" + $("#projid").val(), function(data) {

                    showLabourBar(578, 'lab1');
                    showLabourBar(578, 'lab2');
                    showLabourBar(578, 'lab3');

                });


                function showLabourBar(projid, canvasid) {
                    var data = [];
                    var data1 = [];
                    var data2 = [];
                    var labels = [];


                    $.getJSON({
                        url: "api/getFinanceList.php",
                        data: {
                            projectid: projid,
                            type: "EmpLabour"
                        },
                        success: function(response) { //response is value returned from php
                            var i = 0;
                            response['data'].forEach(function(element) {
                                if (element['EMPLOYEE_NAME'] != "TOTAL" && !isNaN(parseInt(element[
                                        'UNIFIEDCOST']))) {
                                    a = {
                                        x: element['EMPLOYEE_NAME'],
                                        y: parseInt(element['WORK_HOURS'])
                                    };
                                    data1.push(a);
                                    a = {
                                        x: element['EMPLOYEE_NAME'],
                                        y: parseInt(element['UNIFIEDCOST'])
                                    };
                                    data2.push(a);
                                }

                                labels.push(element['EMPLOYEE_NAME']);
                            }); //End of foreach

                            data.push({
                                data: data1,
                                label: "Employee Cost"
                            });
                            data.push({
                                data: data2,
                                label: "Employee Work"
                            });

                            barChart(canvasid, data, labels, "bar", "N", "LABOUR TREND BY EMPLOYEE")
                        } //end of success

                    }); //end of getJSON

                } //end of function showLabourBar
</script>

<legend>Dashboards</legend>

<div class="container ">
    <div class="row row-no-gutters">
        <div class="col-xs-4">
            <canvas id="lab1"></canvas>
        </div>
        <div class="col-xs-4">
            <canvas id="lab2"></canvas>
        </div>
        <div class="col-xs-4">
            <canvas id="lab3"></canvas>
        </div>
    </div>
</div>
<?php

require_once('bodyend.php');

?>