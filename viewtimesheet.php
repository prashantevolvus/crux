<?php
$permission = "VIEW";
require_once('head.php');

require_once('bodystart.php');
?>
<script>
var showDetailsJQ = function ()
{
  		
		var stat=""; 
		$('#status :selected').each(function(i, sel){ 
			stat="'"+$(sel).val()+"' "+stat;   		
    	});
    	
		s = stat.search("All") != -1 ? "" : stat.trim().replace(' ',',').replace('NS','NOT SUBMITTED');
		
		
		s2=supSelectedState;
		s3=empSelectedState;
		
		//alert(s2);

		
		//JQuery
		$.ajax({
  			method:'get', //Or get
  			url:'gettimesheetlist.php?q='+s+'&q1='+s2+'&q2='+s3,
  			beforeSend: function(){
                       $("#loader").show();
                       $('#txtDetails').hide();
                   },
  			success:function(result){
                $("#loader").hide();  
                 $('#txtDetails').show();				
    			$('#txtDetails').html(result);
  			},
  			error:function(){
  				$("#loader").hide();  
                 $('#txtDetails').show();				
    			$('#txtDetails').html("Something went wrong");
			}
			});
}

$(document).ready( function () {
$('#det').click(function () {
	showDetailsJQ();
});
});

$(document).ready(showDetailsJQ);




$(document).ready( function () {
   $( '#sum').click(function() {
  		//JQuery
	$.ajax({
  		method:'get', //Or get
  		url:'gettimesheetgroup.php',
  		beforeSend: function(){
                       $("#loader").show();
                       $('#txtDetails').hide();
        },
  		success:function(result){
  			$("#loader").hide();  
                 $('#txtDetails').show();
    		$('#txtDetails').html(result);
  		},
  		error:function(){
    		$("#loader").hide();  
                 $('#txtDetails').show();				
    			$('#txtDetails').html("Something went wrong");
		}
		});
});
} );




var supSelectedState = "";
var empSelectedState = "";
 
        
var empList = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  
    prefetch: 'getempauto.php',

  remote: {
    url: 'getempauto.php?query=%QUERY',
    wildcard: '%QUERY'
  }
});

      $(document).ready(function() {

            $('#emp .typeahead').typeahead(null,{
  				display: 'value',
  				source: empList

            }).bind('typeahead:selected', function(obj, datum, name) { 
			
				empSelectedState = datum.empno;
			}).bind('change', function(obj, datum, name) { 
				console.log("change");
				empSelectedState = '';
			});

        })

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

            $('#sup .typeahead').typeahead(null,{
                display: 'value',
                 hint: true,
 				 highlight: true,
 				 minLength: 1,
  				source: supList

            }).bind('typeahead:selected', function(obj, datum, name) { 
            	console.log("selected");
				supSelectedState = datum.empno;
			}).bind('change', function(obj, datum, name) { 
				console.log("change");
				supSelectedState = '';
			});
        
            

        })
        


</script>


<h4>View Pending Timesheet</h4>

<form name="timesheetListForm" >
	<div class="form-group">
  		<div class="row">
  			<div class="col-xs-4">
				
				<label for="status" class="wb-inv">Status</label> 
	
				<select class="form-control" id='status' name='tsstatus' multiple='multiple'>
        			<option value='All' selected='selected'>All</option>
        			<option value='NS' >NOT SUBMITTED</option>
        			<option value='SUBMITTED' >SUBMITTED</option>
        			<option value='REJECTED' >REJECTED</option>
				</select>
			</div>
  			<div class="col-xs-4">	 
	 			<label for="supervisor" class="wb-inv">Supervisor</label>
				<div id="sup">
        			<input type="text" class="typeahead" name="supervisor" id = "supervisor" placeholder="Start typing..." >
        		</div>
        	</div>
  			<div class="col-xs-4">
				<label for="employee" class="wb-inv">Employee</label>
				<div id="emp">
        			<input type="text" class="typeahead" name="employee" id = "employee" placeholder="Start typing..." >
        		</div>
        	</div>
			
		</div>
	</div>

	<div class="form-group">

		<input type="button"  id='det' value="Fetch">
		<input type="button"  id='sum' value="Summary">
  </div>
</form>

<div id='loader'><img src="images/loader.gif"/></div>
	
<div id=txtDetails></div>





<?php
require_once('bodyend.php');

?>
