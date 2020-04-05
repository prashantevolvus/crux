<?php
$permission = "VIEW";
require_once('head.php');

require_once('bodystart.php');
?>

<script type="text/javascript">
    $(document).ready(function(){
      refreshTable();
      fillDropDown("api/getSalesStage.php","#salesStage",true);
    });

    $(document).ready( function () {
    $('#det').click(function () {
    	refreshTable();
    });
    });

    function refreshTable(){
      var checkBox = document.getElementById("oppCheck");
      if (checkBox.checked == true){
        q=1;
      } else {
        q='';
      }
      var stat="";
      $('#salesStage :selected').each(function(i, sel){
        stat="'"+$(sel).val()+"' "+stat;
      	//alert(stat);
        console.log(stat);
        });
        s = stat.search("0") != -1 ? "" : stat.trim().replace(' ',',');


        $('#tableHolder').load('getpoppurtunities.php?q='+q+'&q1='+s, function(){
        });
        console.log(q);

    }

    jQuery.ajaxSetup({
      beforeSend: function() {
         $('#loader').show();
         $('#tableHolder').hide();

      },
      complete: function(){
         $('#loader').hide();
         $('#tableHolder').show();

      },
      success: function() {}
    });


</script>

<legend>Sales Oppurtunities Information</legend>

<div class="row">
<form id="oppurtunity-search">
  <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
    <label class="control-label" for="status">Status</label>
    <select id="salesStage" name="salesStage" class="form-control" multiple="multiple">
      <option value="0">All</option>
    </select>
  </div>
  <div class="form-group col-xs-10 col-sm-4 col-md-4 col-lg-4">
    <label for="Active-0">
      <input type="checkbox" name="Active" id="oppCheck" value="1">
        Active
    </label>
  </div>
  <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">
                <a href="addoppurtunities.php"  class="btn btn-primary btn-lg float-right"
                        type="button">
                        <span class="glyphicon glyphicon-plus"></span>
                     Add Oppurtunities
                </a>
      </div>
  <div class="clearfix"></div>
  <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4">

    <button id="det" name="det" type="button" class="btn btn-primary btn-sm">
      <span class="glyphicon glyphicon-search"></span>
      Search
    </button>


  </div>
</form>
</div>



<br>
  <form>

      <div id="loader1">
        <img id="loader" src="spinner.gif" style="display:none;"/>
      </div>
      <div id="tableHolder"></div>

</form>

<?php

require_once('bodyend.php');

?>
