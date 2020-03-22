<html>
<head>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script>
  $(function() {
    var cache = {};
function log( message ) {
      $( "<div>" ).text( message ).prependTo( "#log" );
      $( "#log" ).scrollTop( 0 );
    }
 $( "#empname" ).autocomplete({
   //source: "test_getemp.php",
   minLength: 2,  
   select: function( event, ui ) {
         ui.item ?
          $("#empid").val(ui.item.id) :
          $("#empid").val(0) ;
          ui.item ?
          $("#empname").val(ui.item.value) :
          $("#empname").val("") ;
          return false;
 		},
 		change: function( event, ui ) {
        $( "#empid" ).val( ui.item? ui.item.id : 0 );
    	},
    	source: function( request, response ) {
        var term = request.term;
        if ( term in cache ) {
          response( cache[ term ] );
          return;
        }
 
        $.getJSON( "test_getemp.php", request, function( data, status, xhr ) {
          cache[ term ] = data;
          response( data );
        });
        }
 
    });
  });
    
  </script>
</head>
<body>
<tr>
<div class="ui-widget">
    <label for="empname">Employee: </label>
    <input id="empname" autocomplete="off">
    
    <input id="empid" >
</div>
</tr>
<tr>
<br>
<br>
<div class="ui-widget" style="margin-top:2em; font-family:Arial">
  Result:
  <div id="log" style="height: 200px; width: 300px; overflow: auto;" class="ui-widget-content"></div>
</div>
</tr>
</body>
