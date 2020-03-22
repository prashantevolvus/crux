<php
$permission = "VIEW";
require_once('common.php');
?>
<?php
session_name("Project");
session_start();
$_SESSION['url'] = $_SERVER['REQUEST_URI'];
require_once('dbconn.php');
if (!checkUserSession($_SESSION["user"])) {
    header("Location:login.php");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $res = 0;
    $con = getConnection();
    $rowCount = $_POST['rowCount'];
    $monthYear = mysqli_real_escape_string($con, $_POST['oh_date'][0]);
    for ($x = 0; $x < $rowCount; $x++) {
	$tmp = mysqli_real_escape_string($con, $_POST['oh_main_head'][$x]);
	$tmp2 = explode("|",$tmp );
        $main_name = $tmp2[1];
        $name = mysqli_real_escape_string($con, $_POST['oh_name'][$x]);
        $allocParam = mysqli_real_escape_string($con, $_POST['oh_alloc_param'][$x]);
        $allocBasis = mysqli_real_escape_string($con, $_POST['oh_alloc_basis'][$x]);
        $amount = mysqli_real_escape_string($con, $_POST['oh_amount'][$x]);
        $usr = $_SESSION['user'];
        $sql = "insert into project_management.txn_overheads (to_heads,to_alloc_basis,to_alloc_param,to_amount,to_mon_year,to_crtd_user,to_main_heads) values('$name','$allocBasis','$allocParam',$amount,'$monthYear','$usr','$main_name');";
        if ($result = mysqli_query($con, $sql)) {
            $res++;
        }
    }
    closeConnection($con);
    sleep(3);
    header('Location:editViewOverHeads.php?count=' . $res);
}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<!DOCTYPE html>
<html lang="en">
<link rel="shortcut icon" href="favicon.ico">

<head>
    <Title>Crux-Project-Tool</Title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        /*********** backend solve --sri ***/
        .tt-menu {
            overflow: auto;
            height: 400px;
        }

        .tt-menu {
            width: 422px;
            margin-top: 4px;
            padding: 4px 0;
            background-color: #fff;
            border: 1px solid #ccc;
            border: 1px solid rgba(0, 0, 0, 0.2);
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
            -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
            box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
        }

        .tt-query {
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
            -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        }

        .tt-hint {
            color: #999
        }

        .tt-suggestion {
            padding: 3px 20px;
            line-height: 24px;
        }

        .tt-suggestion.tt-cursor,
        .tt-suggestion:hover {
            color: #fff;
            background-color: #0097cf;
        }

        .twitter-typeahead {
            width: 100%;
        }

        .input-group .input-group-addon {
            line-height: 1 !important;
        }

        #custom-templates .empty-message {
            padding: 5px 10px;
            text-align: center;
        }

        .table {
            margin: 0px auto;
            float: none;
        }

        td {
            border-top: 0px !important;
            padding: 0px !important;
        }

        }

        #addOverHeadsTable input {
            width: 100%;
            padding: 10px;
            margin: 0px;
        }

        #addOverHeadsTable th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #D3D3D3;
            color: black;
        }

        #addOverHeadsTable select {
            -webkit-appearance: none;
            -moz-appearance: none;
            text-indent: 0px;
            border: 0;
            background: transparent;
            outline: none;
        }
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.13/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.13/datatables.min.js"></script>
    <script type="text/javascript" src="script/typeahead.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.min.js"></script>
    <script>
        $(".tt-hint").addClass("form-control");
    </script>
    <script>
        function add_row() {
            $rowno = $("#addOverHeadsTable tr").length;
            $rowno = $rowno - 1;
            $("#addOverHeadsTable tr:last").after(" ");
        }

        function delete_row(id) {
            $(id).remove();
        }

        function getMainheads(id) {
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById(id).innerHTML = xmlhttp.responseText;
                }
            }
            t = id.replace(/main_head_options/g, '');
            xmlhttp.open("GET", "getMainHead.php?id=" + t, true);
            xmlhttp.send();
        }

        function getBaseLocationParam(id) {
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById(id).innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "getBaseLocation.php", true);
            xmlhttp.send();
        }

        function getProjectParam(id) {
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById(id).innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "getProfitCenters.php", true);
            xmlhttp.send();
        }

        function getAllocationParam(fetch, id) {
            if (fetch == 'BL') {
                getBaseLocationParam(id);
            } else if (fetch == 'PC') {
                getProjectParam(id);
            } else if (fetch == '') {
                document.getElementById(id).innerHTML = "Select an Allocation Basis";
            } else {
                document.getElementById(id).innerHTML = "<select id='param2' name='oh_alloc_param[]' required><option value='0' selected='selected'>Not Required</option></select>";
            }
        }
        count = 0;

        function myAjax() {
            $('#addOverHeadsTable').show();
            var x = document.querySelectorAll("[id^='rm']");
            if (x.length < 10) {
                $.ajax({
                    type: "POST",
                    url: 'addRow.php',
                    data: {
                        action: 'call_this',
                        counter: count
                    },
                    success: function(html) {
                        $('#addOverHeadsTable tr:last').after(html);
                        $('#addOverHeadsTable tr:last').append('<span class ="close" value="rm' + count + '">\u00D7</span>');
                        count++;
                    }
                });
            } else {
                alert('Maximum 10 overheads can be added at a time');
            }
        }

        function showSuggestionHead(id) {
            $(function() {
                $("#" + id).autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            cache: 'true',
                            url: "suggestionsHead.php",
                            dataType: "json",
                            data: {
                                q: request.term
                            },
                            success: function(data) {
                                response(data);
                            },
                            error: function(request, error) {
                                alert(" Can't do because: " + error);
                            }
                        });
                    },
                });
            });
        }
        $(document).ready(function() {
            $(document).on('click', '.close', function() {
                id = $(this).attr('value');
                document.getElementById(id).remove();
            });
        });

        function rowCounter() {
            var x = document.querySelectorAll("[id^='rm']");
            var counter = x.length;
            document.getElementById("rowCount").value = counter;
            if (counter == 0) {
                alert('Form is empty, add some overheads');
                return false;
            } else {
                return true;
            }
        }

        function showSubheads(code, id) {
            console.log(id, code);
            $.ajax({
                type: 'GET',
                url: 'getSubHeads.php',
                data: {
                    iden: id,
                    typeCode: code
                },
                success: function(data) {
                    document.getElementById('subHead' + id).innerHTML = data;
                }
            });
        }
        $(document).ready(function() {
            $('#addOverHeadsTable').hide();
            rowno = $("#addOverHeadsTable tr").length;
        });
        $(document).on('mouseover', function() {
            rowno = $("#addOverHeadsTable tr").length;
            if (rowno == 1) {
                $('#addOverHeadsTable').hide();
            }
        });
    </script>
</head>

<body>
    <?php include 'header_test.php'; ?>
    <div class="container-fluid">
        <h3>Add Overheads</h3>
        <form name="addOverHeads" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-12">
                    <div style='height:400px;' class='table-responsive'>
                        <table id="addOverHeadsTable" border="0" style="border-collapse: separate; border-spacing: 10px" class="table">
                            <thead>
                                <tr>
                                    <th>Heads</th>
                                    <th>Sub-Heads</th>
                                    <th>Allocation Basis</th>
                                    <th>Allocation Param</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <div id="rows"></div>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top:20px">
                <div class="col-sm-6">
                    <input id="rowCount" name="rowCount" type="hidden" value="0" />
                    <input type="button" value="Add Row" onclick="myAjax()" />&nbsp;
                    <input type="submit" name="submit" value="Submit" onclick="return rowCounter()">
                </div>
                <div class="col-sm-6" style="text-align:right">
                    Month/Year<span style='color:red'>&nbsp;*&nbsp;</span>
                    <input type="month" name="oh_date[]" required>
                </div>
            </div>
        </form>
    </div>
</body>

</html> 
<?php
$permission = "VIEW";
