<?php
$permission = "VIEW";
require_once('head.php');

require_once('bodystart.php');
?>

<script>

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
	
	$('#projSearch .typeahead').typeahead(null,{
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
    			return '<p>'+data.cust + ' : <strong>' + data.projname + '</strong> – ' +  ' [Status : ' + data.status+']</p>';
			}
  		}
	}).bind('typeahead:selected', function(obj, datum, name) { 
            	console.log("selected");
				//populateForm(datum.projid);
				//alert( "http://www.evolvus.com/project/viewprojdetails.php?proj_id="+datum.projid);
				window.location  = "viewprojdetails.php?proj_id="+datum.projid;
	});
})
        


function populateForm(projid){
	// grab the correct input and output elements
	var url = "getprojdetauto.php?projid="+projid ; 
	var dataJSON = "";
	
		$.get(url, function(data){
			
			
	// create the text variables
		var text		= data.replace(/(^\s+|\s+$)/, '');
		text			= "(" + text + ");";
		alert(text);
		
		
		//alert(" TEXT " + text);
	// attempt to create valid JSON
		try{
			var json = eval(text)
		}
		catch(err){
			alert('That appears to be invalid JSON!  '+err)
			return false;
		
		}
		var form		= document.forms['projDetails'];
		alert(form['projid'].value);

		alert (" json " + json);	
	// populate the form if no error
		$(form).populate(text, {debug:1})
	});
}
		
	
</script>
	<script type="text/javascript" src="script/jquery.populate.pack.js"></script>

<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Project Information</legend>

<!-- Search input-->
<div class="form-group">
  <div id="projSearch">

  	<div class="col-md-5">
  	  <div class="input-group">
    	<input id="project" name="project" type="input" placeholder="Enter Project Name" class="form-control input-md typeahead" required="" aria-describedby="glph">
    	<span class="input-group-addon" id="glph"><span class="glyphicon glyphicon-search"></span></span>
  	</div>
  	<div>
  </div>
</div>
</fieldset>
</form>






	
	




<?php
//<div id='loader'><img src="images/loader.gif"/></div>
/*


<div class="form-group" id="projDetails" >
	<div class="col-md-5">
  	  <div class="input-group">
  	      	<input id="projid" name="projid" type="input" class="form-control input-md" value="909" disabled >
  	        <input id="projname" name="projname" type="input" class="form-control input-md" disabled >
  	        <input id="cust" name="cust" type="input" class="form-control input-md" disabled >
  	        <input id="status" name="status" type="input" class="form-control input-md" disabled >


  	  </div>
  	</div>

</div>

*/
require_once('bodyend.php');

?>
