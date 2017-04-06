<?php

$permission = "VIEW";
require_once('head.php');

require_once('bodystart.php');
?>


<script>
    var tableToExcel = (function () {     var uri = 'data:application/vnd.ms-excel;base64,'
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
                                function showDetails()
                                {
                                if (window.XMLHttpRequest)
                                {// code for IE7+, Firefox, Chrome, Opera, Safari
                                xmlhttp = new XMLHttpRequest();
                                }
                                else
                                {// code for IE6, IE5
                                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                                }
                                xmlhttp.onreadystatechange = function()
                                {
                                if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                                {
                                document.getElementById("txtDetails").innerHTML = xmlhttp.responseText;
                                }
                                }
                                var s = "";
                                var stat1 = "";
                                var e = document.getElementById("invstatus");
                                s = e.options[e.selectedIndex].text;
                                if (e.options[e.selectedIndex].text == "All")
                                {
                                s = "";
                                }
                                else
                                {

                                var stat = "''";
                                var x = 0;
                                for (x = 0; x < e.length; x++)
                                {
                                //alert(e[x].selected + e[x].value);
                                if (e[x].selected == true)
                                {
                                stat = "'" + e[x].value + "'," + stat;
                                }

                                }
                                s = stat;
                                }
                                var e = document.getElementById("cust");
                                var s1 = e.options[e.selectedIndex].value;
                                if (e.options[e.selectedIndex].text == "Choose...")
                                {
                                s1 = "";
                                }
                                s2 = "";
                                var e = document.getElementById("proj");
                                if (e != null)
                                {
                                var s2 = e.options[e.selectedIndex].value;
                                if (e.options[e.selectedIndex].text == "Choose...")
                                {
                                s2 = "";
                                }
                                }
                                s3 = "";
                                var e = document.getElementById("pm");
                                if (e != null)
                                {
                                var s3 = e.options[e.selectedIndex].value;
                                if (e.options[e.selectedIndex].text == "Choose...")
                                {
                                s3 = "";
                                }
                                }

                                s4 = "";
                                var e = document.getElementById("ExpectedInvoiceDate");
                                if (e != null)
                                {
                                var s4 = e.value;
                                }

                                s5 = "";
                                var e = document.getElementById("ExpectedPayDate");
                                if (e != null)
                                {
                                var s5 = e.value;
                                }

                                s6 = "";
                                var e = document.getElementById("ActualInvoiceDate");
                                if (e != null)
                                {
                                var s6 = e.value;
                                }

                                s7 = "";
                                var e = document.getElementById("ActualPayDate");
                                if (e != null)
                                {
                                var s7 = e.value;
                                }
//xmlhttp.open("GET","getinvoicelist.php?q="+s+"&q1="+s1+"&q2="+s2+"&q3="+s3,true);

                                xmlhttp.open("GET", "getinvoicelist.php?q=" + s + "&q1=" + s1 + "&q2=" + s2 + "&q3=" + s3 + "&q4=" + s4 + "&q5=" + s5 + "&q6=" + s6 + "&q7=" + s7, true);
                                xmlhttp.send();
                                }

                        function showProjection()
                        {

                        if (window.XMLHttpRequest)
                        {// code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                        }
                        else
                        {// code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                        }
                        xmlhttp.onreadystatechange = function()
                        {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                        {
                        document.getElementById("txtDetails").innerHTML = xmlhttp.responseText;
                        }
                        }
                        var s = "";
                        var stat1 = "";
                        var e = document.getElementById("invstatus");
                        s = e.options[e.selectedIndex].text;
                        if (e.options[e.selectedIndex].text == "All")
                        {
                        s = "";
                        }
                        else
                        {

                        var stat = "''";
                        var x = 0;
                        for (x = 0; x < e.length; x++)
                        {
                        //alert(e[x].selected + e[x].value);
                        if (e[x].selected == true)
                        {
                        stat = "'" + e[x].value + "'," + stat;
                        }

                        }
                        s = stat;
                        }
                        var e = document.getElementById("cust");
                        var s1 = e.options[e.selectedIndex].value;
                        if (e.options[e.selectedIndex].text == "Choose...")
                        {
                        s1 = "";
                        }
                        s2 = "";
                        var e = document.getElementById("proj");
                        if (e != null)
                        {
                        var s2 = e.options[e.selectedIndex].value;
                        if (e.options[e.selectedIndex].text == "Choose...")
                        {
                        s2 = "";
                        }
                        }
                        s3 = "";
                        var e = document.getElementById("pm");
                        if (e != null)
                        {
                        var s3 = e.options[e.selectedIndex].value;
                        if (e.options[e.selectedIndex].text == "Choose...")
                        {
                        s3 = "";
                        }
                        }

                        s4 = "";
                        var e = document.getElementById("ExpectedInvoiceDate");
                        if (e != null)
                        {
                        var s4 = e.value;
                        }

                        s5 = "";
                        var e = document.getElementById("ExpectedPayDate");
                        if (e != null)
                        {
                        var s5 = e.value;
                        }

                        s6 = "";
                        var e = document.getElementById("ActualInvoiceDate");
                        if (e != null)
                        {
                        var s6 = e.value;
                        }

                        s7 = "";
                        var e = document.getElementById("ActualPayDate");
                        if (e != null)
                        {
                        var s7 = e.value;
                        }

//xmlhttp.open("GET","getinvoicelist.php?q="+s+"&q1="+s1+"&q2="+s2+"&q3="+s3,true);

                        xmlhttp.open("GET", "getinvoiceProjection.php?q=" + s + "&q1=" + s1 + "&q2=" + s2 + "&q3=" + s3 + "&q4=" + s4 + "&q5=" + s5 + "&q6=" + s6 + "&q7=" + s7, true);
//xmlhttp.open("GET","getinvoiceProjection..php",true);
                        xmlhttp.send();
                        }



                        function showProject(str)
                        {
                        if (str == 'Choose..')
                                return;
                        if (window.XMLHttpRequest)
                        {// code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                        }
                        else
                        {// code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                        }
                        xmlhttp.onreadystatechange = function()
                        {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                        {
                        document.getElementById("txtProj").innerHTML = xmlhttp.responseText;
                        }
                        }
                        xmlhttp.open("GET", "getprojectnewinvoice.php?q=" + str, true);
                        xmlhttp.send();
                        }

                        function showCustomer()
                        {
                        if (window.XMLHttpRequest)
                        {// code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                        }
                        else
                        {// code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                        }
                        xmlhttp.onreadystatechange = function()
                        {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                        {
                        document.getElementById("txtCust").innerHTML = xmlhttp.responseText;
                        }
                        }
                        xmlhttp.open("GET", "getcustomer.php", true);
                        xmlhttp.send();
                        }




                        var supSelectedState = "";
                        var supList = new Bloodhound({
                        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                                queryTokenizer: Bloodhound.tokenizers.whitespace,
                                prefetch: 'getempauto.php?supervisor=Y',
                                remote: {
                                url: 'getempauto.php?supervisor=Y&query=%QUERY',
                                        wildcard: '%QUERY'
                                }
                        });
                        $(document).ready(function() {

                        $('#sup .typeahead').typeahead(null, {
                        display: 'value',
                                hint: true,
                                highlight: true,
                                minLength: 1,
                                source: supList

                        }).bind('typeahead:selected', function(obj, datum, name) {
                        console.log("manager selected");
                        supSelectedState = datum.empno;
                        }).bind('change', function(obj, datum, name) {
                        console.log("manager change");
                        supSelectedState = '';
                        });
                        })


                                var custSelectedState = "";
                        var custList = new Bloodhound({
                        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                                queryTokenizer: Bloodhound.tokenizers.whitespace,
                                prefetch: 'getcustauto.php',
                                remote: {
                                url: 'getcustauto.php?query=%QUERY',
                                        wildcard: '%QUERY'
                                }
                        });
                        $(document).ready(function() {

                        $('#cust .typeahead').typeahead(null, {
                        display: 'value',
                                hint: true,
                                highlight: true,
                                minLength: 1,
                                source: custList

                        }).bind('typeahead:selected', function(obj, datum, name) {
                        console.log("customer selected");
                        custSelectedState = datum.id;
                        }).bind('change', function(obj, datum, name) {
                        console.log("customer change");
                        custSelectedState = '';
                        });
                        })

                            var projSelectedState = "";
                        var projList = new Bloodhound({
                        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                                queryTokenizer: Bloodhound.tokenizers.whitespace,
                                prefetch: 'getprojauto.php',
                                remote: {
                                url: 'getprojauto.php?query=%QUERY&cust='+custSelectedState,
                                        wildcard: '%QUERY'
                                }
                        });
                        $(document).ready(function() {

                        $('#proj .typeahead').typeahead(null, {
                        display: 'projname',
                                hint: true,
                                highlight: true,
                                minLength: 1,
                                source: projList

                        }).bind('typeahead:selected', function(obj, datum, name) {
                        console.log("project selected; project = " + datum.projid + " Customer =  " + custSelectedState);
                        projSelectedState = datum.projid;
                        }).bind('change', function(obj, datum, name) {
                        console.log("project change");
                        projSelectedState = '';
                        });
                        })
            

</script>

<body onLoad="showDetails();">

    <h3>View Project Invoice</h3>
    <form name="search" >

        <div class="form-group">

            <div class="row">

                <div class="col-xs-4">
                    <label for="status" class="wb-inv">Status</label> 
                    <select class="form-control" id='invstatus' name='invstatus'  multiple='multiple' >
                        <option value='All' selected='selected'>All</option>
                        <option value='PENDING' >PENDING</option>
                        <option value='INVOICED' >INVOICED</option>
                        <option value='PAID' >PAID</option>
                    </select>
                </div>

                <div class="col-xs-4">	 
                    <label for="manager" class="wb-inv">Project Manager</label>
                    <div id="sup">
                        <input type="text" class="typeahead" name="manager" id = "manager" placeholder="Start typing..." >
                    </div>
                </div>

                <div class="col-xs-4">	 
                    <label for="customer" class="wb-inv">Customer</label>
                    <div id="cust">
                        <input type="text" class="typeahead" name="customer" id = "customer" placeholder="Start typing..." >
                    </div>
                </div>

                <div class="col-xs-4">	 
                    <label for="project" class="wb-inv">Project</label>
                    <div id="proj">
                        <input type="text" class="typeahead" name="project" id = "project" placeholder="Start typing..." >
                    </div>
                </div>

            </div>
        </div>



    </form>


<?php

require_once('bodyend.php');
?>
