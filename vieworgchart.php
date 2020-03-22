<?php
$permission = "VIEW";
require_once('head.php');

require_once('bodystart.php');
?>


<script src="./getorgchart/getorgchart.js"></script>
    <link href="./getorgchart/getorgchart.css" rel="stylesheet" />

    <style type="text/css">
        html, body {
            margin: 0px;
            padding: 0px;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }


        #people {
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
    <div id="people"></div>


   <script type="text/javascript">
        $.getJSON("getGoodOrgData.php", function (source) {
            var peopleElement = document.getElementById("people");
            var orgChart = new getOrgChart(peopleElement, {
	            orientation: getOrgChart.RO_TOP_PARENT_LEFT,
	            theme: "belinda",
                primaryFields: ["Name", "Title"],
                enableEdit: false,
                enableDetailsView: false,
                dataSource: source,
                renderNodeEvent: renderNodeEventHandler
            });
        });
        
        function renderNodeEventHandler(sender, args) {
        	
            var title = args.node.data["Title"];
            if ( title.search(/Trainee/i) == -1) {
            	return;
            }
            args.content[1] = args.content[1].replace("circle", "circle style='fill:green' " );         


        }
            
        
    </script>







<?php
require_once('bodyend.php');

?>
