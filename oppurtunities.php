<?php
$permission = "VIEW";
require_once('head.php');

require_once('bodystart.php');
?>

<script type="text/javascript">
    $(document).ready(function(){
      refreshTable();
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
      $('#status :selected').each(function(i, sel){
        stat="'"+$(sel).val()+"' "+stat;
      	//alert(stat);
        console.log(stat);
        });
        s = stat.search("All") != -1 ? "" : stat.trim().replace(' ',',');


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


<form class="form-horizontal">

<!-- Select Multiple -->
<div class="form-group">
  <div class="col-md-4">
    <label class="control-label" for="status">Status</label>
    <select id="status" name="status" class="form-control" multiple="multiple">
      <option value="All" selected>All</option>
      <option value="HotProspect">Hot Prospect</option>
      <option value="Prospect">Prospect</option>
      <option value="Suspect">Suspect</option>
      <option value="Lead">Lead</option>
      <option value="Won">Won</option>
      <option value="Lost">Lost</option>
    </select>
  </div>

<!-- Multiple Checkboxes -->
  <label class="control-label" for="Active"></label>
  <div class="col-md-4">
  <div class="checkbox">
    <label for="Active-0">
      <input type="checkbox" name="Active" id="oppCheck" value="1">
      Active
    </label>
  </div>
  </div>
  <div class="form-group">
                <a href="addoppurtunities.php"  class="btn btn-success btn-lg float-right"
                        type="button">
                        <span class="glyphicon glyphicon-plus"></span>
                     Add Oppurtunities
                </a>
      </div>
</div>

<!-- Button -->
<div class="form-group">
  <div class="col-md-4">
    <button id="det" name="det" type="button">
      <span class="glyphicon glyphicon-search"></span>
      Search
    </button>
  </div>


</div>


</fieldset>



</form>
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
