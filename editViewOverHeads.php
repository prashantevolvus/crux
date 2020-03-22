<?php
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
    $rowCount = $_POST['numOfRows'];
    $con = getConnection();
    for ($x = 0; $x < $rowCount; $x++) {
        $id = mysqli_real_escape_string($con, $_POST['to_id'][$x]);
        $name = mysqli_real_escape_string($con, $_POST['oh_name'][$x]);
        $allocParam = mysqli_real_escape_string($con, $_POST['oh_alloc_param'][$x]);
        $allocBasis = mysqli_real_escape_string($con, $_POST['alloc_basis'][$x]);
        $amount = mysqli_real_escape_string($con, $_POST['to_amount'][$x]);
        $usr = $_SESSION['user'];
        $sql = "update project_management.txn_overheads set to_heads='$name',to_alloc_basis='$allocBasis',to_alloc_param='$allocParam',to_amount=$amount,to_mod_user='$usr',to_auth_sts='0' where to_id=$id";

        if ($result = mysqli_query($con, $sql)) {
            $_SESSION['message'] = 'Overheads updated successfully';
        } else {
            $_SESSION['message'] = 'Overheads didn\'t update ';
        }
    }
    closeConnection($con);
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
            /* prevent horizontal scrollbar */
            overflow-x: hidden;
        }

        /*********** backend solve --sri ***/
        .tt-menu {
            overflow: auto;
            height: 400px;
        }

        .tt-menu {
            /* used to be tt-dropdown-menu in older versions */
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

        .table td {
            border-top: 0px !important;
            vertical-align: center !important;
            padding: 0px;

        }

        th {
            text-align: center !important;
        }

        #viewEditOverheads input {
            width: 100%;
            margin: 0px;
        }

        #viewEditOverheads input {
            border: none !important;
            background: transparent !important;
        }

        #viewEditOverheads th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #D3D3D3;
            color: black;
        }

        #viewEditOverheads select {
            -webkit-appearance: none;
            -moz-appearance: none;
            text-indent: 0px;
            border: 0;
            background: transparent;
            outline: none;
        }

        [id^="chktag"] {
            width: auto !important;
            vertical-align: middle;
        }
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.13/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.13/datatables.min.js"></script>
    <script type="text/javascript" src="script/typeahead.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
    <script>
        $(".tt-hint").addClass("form-control");
    </script>
    <script>
        <?php 
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if (isset($_GET['count'])) {
                $count = $_GET['count'];
                echo  "alert('$count Overhead(s) saved successfully');";
            }
        }
        ?>
        var authResult = true;

        function getBaseLocationParam(id) {
            if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else { // code for IE6, IE5
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
            if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else { // code for IE6, IE5
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
                getBaseLocationParam('replace' + id);
            } else if (fetch == 'PC') {
                getProjectParam('replace' + id);
            } else if (fetch == '') {
                document.getElementById('replace' + id).innerHTML = "Select an Allocation Basis";
            } else {
                document.getElementById('replace' + id).innerHTML = "<select id='param2' name='oh_alloc_param[]' required><option value='0' selected='selected'>Not Required</option></select>";
            }
        }

        function getMainheads(id) {

            if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else { // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById(id).innerHTML = xmlhttp.responseText;
                }
            }
            t = id.replace(/moh/g, '');

            xmlhttp.open('GET', 'getMainHead.php?id=' + t, true);
            xmlhttp.send();
        }

        function ajaxFecthRecs(ev) {
            ev.preventDefault();
            var month = document.getElementById("fetchMonYear").value;
            document.getElementById("enableEdit").removeAttribute("disabled");
            $.ajax({
                type: "POST",
                url: 'overHeadViewRecords.php',
                data: {
                    action: 'VIEW',
                    mon: month
                },
                success: function(html) {
                    document.getElementById("overHeadRecords").innerHTML = html;
                },
                complete: function(data) {
                    var x = document.querySelectorAll("[id^='chktag']");
                    for (var i = 0; i < x.length; i++) {
                        x[i].addEventListener('click', enableAuthButton);
                    }
                    var y = document.querySelectorAll("[id^='editChktag']");
                    for (var i = 0; i < y.length; i++) {
                        y[i].addEventListener('click', enableEditButton);
                    }
                }

            });



        }

        function enableEditForAll() {
            var x = document.querySelectorAll('input');
            for (var i = 0; i < x.length; i++) {
                x[i].disabled = false;
            }
            var x = document.querySelectorAll('select');
            for (var i = 0; i < x.length; i++) {
                x[i].disabled = false;
            }
            document.getElementById("finalSubmit").style.display = "inline";
        }

        function enableAuth() {

            document.getElementById("authorise").style.display = "inline";
            var x = document.querySelectorAll("[id^='chktag']");
            for (var i = 0; i < x.length; i++) {
                x[i].disabled = false;
            }
        }

        function authSelRecs() {
            var x = document.querySelectorAll("[id^='chktag']");

           
            for (var i = 0; i < x.length; i++) {
                
              
                if (x[i].checked == true) {
                   
                    var update = x[i].value;

                    var userName = 'anon';
                    var recId = x[i].id.replace(/chktag/g, '');
                    
                    var res = true;
                    checkedID = x[i].id;
                    ajaxForAuth(update, userName, recId,checkedID);

                }

            }
            setTimeout(function() {
                if (!authResult) {
                    alert('Too low privileges to authorise any overhead');
                } else {
                    alert('Authorised sucessfully');
                }
            }, 100);
            document.getElementById("authorise").style.display = "none";
        }


        function editSelRecs() {

            var x = document.querySelectorAll("[id^='editChktag']");

            for (var i = 0; i < x.length; i++) {
                x[i].disabled = false;

            }
            document.getElementById("finalSubmit").style.display = "inline";
        }

        function editSubmitPartialForm() {

            var x = document.querySelectorAll("[id^='editChktag']");
            for (var i = 0; i < x.length; i++) {
                if (x[i].checked == true) {
                    var recId = x[i].id.replace(/editChktag/g, '');

                    document.getElementById('rm' + recId).disabled = false;
                    document.getElementById('basis' + recId).disabled = false;
                    document.getElementById('amt' + recId).disabled = false;
                    document.getElementById('mh' + recId).disabled = false;

                } else {
                    var recId = x[i].id.replace(/editChktag/g, '');
                    document.getElementById('rm' + recId).disabled = true;
                    document.getElementById('basis' + recId).disabled = true;
                    document.getElementById('amt' + recId).disabled = true;
                    document.getElementById('mh' + recId).disabled = true;

                }

            }
            document.getElementById('updateForm').style.display = "inline";
        }

        function updatePartialForm() {
            var x = document.querySelectorAll("[id^='editChktag']");

            for (var i = 0; i < x.length; i++) {

                if (x[i].checked == true) {

                    var userName = 'anon';
                    var recId = x[i].id.replace(/editChktag/g, '');
                    var a = $('#rm' + recId).val();
                    var b = $('#basis' + recId).val();
                    var c = $('#amt' + recId).val();
                    var d = $('#replace' + recId).children('select').val();
                    var e = $('#id' + recId).val();
                    var f = $('#mh' + recId).val();

                    if (a == '' || b == '' || c == '' || d == '' || e == '' || f == '') {
                        alert('Please fill all the fields before updating');
                        return;
                    }
                    //roleChecker();
                    ajaxForUpdate(a, b, c, d, e, f, userName);


                    x[i].checked = false;


                }

            }
            disableEditForAll();
            enableEditCheck();
            document.getElementById('fetchMonYear').disabled = false;
            document.getElementById('fetchMonthwise').disabled = false;
            document.getElementById('enableAuthorise').disabled = false;
            document.getElementById('authorise').disabled = false;
            document.getElementById('authorise').style.display = "none";
            document.getElementById('enableEdit').disabled = false;
            document.getElementById('finalSubmit').disabled = false;
            document.getElementById('updateForm').disabled = false;
            document.getElementById('updateForm').style.display = "none";


        }

        function roleChecker() {
            $.ajax({
                type: "GET",
                url: 'authUpdateUser.php',
                data: {
                    action: 'AUTH',
                    perm: 'AUTHORISE'
                },
                success: function(data) {

                }
            });
        }

        function ajaxForAuth(update, userName, recId, checkedID) {
            var res;

            $.ajax({
                type: "GET",
                url: 'authUpdateUser.php',
                data: {
                    action: 'AUTH',
                    perm: 'AUTHORISE'
                },
                success: function(data) {

                    if (data.length <= 25) {

                        userName = data;
                        $.ajax({
                            type: "POST",
                            url: 'authOverHeads.php',
                            data: {
                                action: 'VIEW',
                                id: update,
                                user: userName
                            },
                            success: function(data) {
                                //console.log(data);
                            }

                        });
                    } else {
                        authResult = false;
                    }
                },

            }).done(function() {
                if (authResult) {
                    document.getElementById("lab" + recId).innerHTML = "<b>Approved</b>";
                }
                else{
                    document.getElementById(checkedID).checked=false;
                }
            });
        }


        function ajaxForUpdate(a, b, c, d, e, f, userName) {
           
            $.ajax({
                type: "GET",
                url: 'authUpdateUser.php',
                data: {
                    action: 'VIEW'
                },
                success: function(data) {
                    userName = data;

                    $.ajax({
                        type: "POST",
                        url: 'reUpdateOverHeads.php',
                        data: {
                            action: 'UPDATE',
                            rm: a,
                            basis: b,
                            amt: c,
                            param: d,
                            id: e,
                            mainHead: f,
                            userName: userName
                        },
                        success: function() {

                        }
                    });

                }

            });
        }

        function enableEditCheck() {
            var y = document.querySelectorAll("[id^='editChktag']");

            for (var i = 0; i < y.length; i++) {
                y[i].disabled = false;
            }

            var x = document.querySelectorAll("[id^='chktag']");

            for (var i = 0; i < x.length; i++) {

                x[i].disabled = false;
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

        function disableEditForAll() {
            var x = document.querySelectorAll('input');
            for (var i = 0; i < x.length; i++) {
                x[i].disabled = true;
            }
            var x = document.querySelectorAll('select');
            for (var i = 0; i < x.length; i++) {
                x[i].disabled = true;
            }
            document.getElementById("finalSubmit").style.display = "none";
        }

        function enableAuthButton() {
            var x = document.querySelectorAll("[id^='chktag']");
            //console.log(x);
            var flag = false;
            for (var i = 0; i < x.length; i++) {
                if (x[i].checked == true) {
                    flag = true;
                }
            }
            if (flag) {
                var a = document.getElementById("authorise");

                if (a != null)
                    a.style.display = "inline";

            } else {

                var b = document.getElementById("authorise");

                if (b != null)
                    b.style.display = "none";

            }
        }

        function enableEditButton() {
            var y = document.querySelectorAll("[id^='editChktag']");

            var flag = false;
            for (var i = 0; i < y.length; i++) {
                if (y[i].checked == true) {
                    flag = true;
                }
            }
            if (flag) {
                document.getElementById("updateForm").style.display = "inline";

            } else {
                //document.getElementById("finalSubmit").style.display ="none";
                document.getElementById('updateForm').style.display = "none";
            }
        }

        function eventBinderForMainOverhead(id, ev) {

            var ele = document.getElementById(id);

            t = id.toString().replace(/moh/g, '');

            if (ele != null) {
                if (!ele.disabled)
                    getMainheads('moh' + t);
            }
            //$('#'+t).attr("onclick", "").unbind("click");
        }

        $(document).on("click", function() {

            var x = document.querySelectorAll("[id^='editChktag']");
            for (var i = 0; i < x.length; i++) {
                if (x[i].checked == true) {
                    var recId = x[i].id.replace(/editChktag/g, '');

                    document.getElementById('rm' + recId).disabled = false;
                    document.getElementById('basis' + recId).disabled = false;
                    document.getElementById('amt' + recId).disabled = false;
                    document.getElementById('mh' + recId).disabled = false;
                } else {
                    var recId = x[i].id.replace(/editChktag/g, '');
                    document.getElementById('rm' + recId).disabled = true;
                    document.getElementById('basis' + recId).disabled = true;
                    document.getElementById('amt' + recId).disabled = true;
                    document.getElementById('mh' + recId).disabled = true;
                }

            }
        });

        function showSubheads(code, id) {
            //console.log(id, code);
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
    </script>
</head>

<body>

    <?php include 'header_test.php'; ?>

    <div class="container-fluid">
        <h3>View/Edit Overheads</h3>
        <div class="row">
            <div class="col-sm-12">
                <form onsubmit="ajaxFecthRecs(event)">
                    <input id="fetchMonYear" type="month" name="fetchMonYear" required>
                    <input id='fetchMonthwise' type="submit" name="fecthRecs" value="Fetch Overheads">
                    <input id='enableAuthorise' type="button" style='display:none' name="auth" value="Tick Auth" onclick="enableAuth()">
                    <input id='authorise' type='button' style='display:none' value="Authorise" onclick="authSelRecs()">
                    <input id="enableEdit" type="button" style='display:none' name="enableEdit" value="Tick Edit" disabled onclick="editSelRecs()">
                    <input id='finalSubmit' type='button' value='Edit' style='display:none' onclick='editSubmitPartialForm()'>
                    <input id='updateForm' type='button' value='Update' style='display:none' onclick='updatePartialForm()'>
                </form>

            </div>
        </div>
        <div class="row">
            <div class="col-sm-12" id="overHeadRecords">

            </div>
        </div>
    </div>
</body>

</html> 