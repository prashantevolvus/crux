<?php
require_once('head.php');

require_once('bodystart.php');
?>


  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#invoice">Invoice Ageing</a></li>
    <li><a data-toggle="tab" href="#budget">Budget Overrun</a></li>
    <li><a data-toggle="tab" href="#duration">Duration Overrun</a></li>
    
  </ul>
  
  <div class="tab-content">
    <div id="invoice" class="tab-pane fade in active">
       <p><?include 'dashinvoice.php';?></p>
      </div>
    <div id="budget" class="tab-pane fade">
     <p><?include 'dashbudget.php';?></p>
    </div>
    
    <div id="duration" class="tab-pane fade">
     <p><?include 'dashproject.php';?></p>
    </div>
  
  </div>
  


<?php
require_once('bodyend.php');

?>