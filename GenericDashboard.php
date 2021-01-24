<?php
$permission = "VIEW";
require_once('head.php');

require_once('bodystart.php');
$q = isset($_GET['menuID']) ? $_GET['menuID'] : 1;
$con = getConnection();
$sql = "
    select menu_name,dash_name,dash_type,dash_sql,dash_size ,dash_lakhs ,dash_width,dash_height,
    dash_labels, drill_allowed
    from 
dynamic_dashmenus a
inner join dynamic_menumap b on a.id = b.menu_id
    inner join dynamic_dashboards c on c.id = b.dash_id
    where menu_id = {$q}
    order by b.dash_order
";

$result = mysqli_query($con, $sql) or debug($sql . "   failed  <br/><br/>");
$return_arr = array();
while ($row = mysqli_fetch_assoc($result)) {
    $header = $row['menu_name'];
    $result1 = mysqli_query($con, $row['dash_sql']) or debug($row['dash_sql'] . "   failed  <br/><br/>");
    $data_Arr = array();
    while ($row1 = mysqli_fetch_assoc($result1)) {
        $data_Arr[] = $row1;
    }
    unset($row['dash_sql']);
    $row['data'] = $data_Arr;
    $return_arr[] = $row;
}


?>

<script src="script/evolvusgraph.js"> </script>


<script type="text/javascript">
    $(document).ready(function() {

        var jsonDash = <?php echo json_encode($return_arr); ?>;
        var i = 1;
        var row = 0;
        var incDivID = "start" + (i++);
        document.querySelector('#dash').insertAdjacentHTML(
            'beforeend', '<div class="row " id="' + incDivID + '"></div>'
        );
        jsonDash.forEach(function(item, index) {
            row += parseInt(item["dash_size"]);
            if (row > 12) {
                incDivID = "start" + (i++);
                document.querySelector('#dash').insertAdjacentHTML(
                    'beforeend', '<hr class="style1"> <div class="row " id="' + incDivID + '"></div>'
                );
                row = parseInt(item["dash_size"]);
            }
            divid = "dashlet" + (i++);
            frag = '<div class = "panel panel-default right0 divborder3 col-xs-' + item["dash_size"] + ' ">';
            frag += '<canvas id = "' + divid + '" width="' + item["dash_width"] + '%" height="' + item["dash_height"] + '%"> </canvas> </div>';


            document.querySelector('#' + incDivID).insertAdjacentHTML(
                'beforeend', frag
            );


            var labelArr = item['data'].map(item => item.x);
            var dataArr = (item['dash_labels'] || "DEFAULT").split(',').map(splt =>
                ({
                    data: item['data'].map(item => parseInt(item[splt.split(':')[1] || "y"])),
                    label: splt.split(':')[0]
                })
            );
            generateChart(divid, dataArr, labelArr, item["dash_type"], item["dash_lakhs"], item["dash_name"], item["drill_allowed"]);


        });



    });
</script>

<legend><?php echo $header ?></legend>

<div class="container" id="dash">

</div>
<?php

require_once('bodyend.php');

?>