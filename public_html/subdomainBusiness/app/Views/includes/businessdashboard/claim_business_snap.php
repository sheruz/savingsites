<div class="page-wrapper main-area toggled viewdeals">
   <div class="container">
    <input type="hidden" id="businessid" name="businessid" value="<?php echo $businessid;?>"/>
    <input type="hidden" id="deal_product_id" name="deal_product_id" value=""/>
    <div class="row" style=" margin-bottom: 80px;">
         <div class="top-title">
            <h2>Show Business SNAP Deals</h2>
            <hr class="center-diamond">
            <p>Below are the SNAP deals offered by the businesses. Each deal has a limited time to be featured on our deal page. Once a deal expires, Business re-genrate deals in snap program page.</p>
         </div>
         <table class="display responsive-table" cellspacing="0" width="100%" id="managecat">
            <thead>
               <tr>
                  <th scope="col">Claimer User</th>
                  <th scope="col">Claimer Email</th>
                  <th scope="col">Claimer Phone</th>
                  <th scope="col">Day</th>
                  <th scope="col">In Time</th>
                  <th scope="col">Out Time</th>
               </tr>
            </thead>
            <tbody>
            <?php 
            foreach ($finalsnapbusArr as $k => $v) {
            	echo '<tr><td>'.$v->first_name.' '.$v->last_name.'</td><td>'.$v->email.'</td><td>'.$v->phone.'</td><td>'.$v->date.' ('.$v->dayword.')</td><td>'.$v->starttimeword.'</td><td>'.$v->endtimeword.'</td></tr>';
            }
            ?>   
            </tbody>
         </table>
         
   </div>
</div>
</div>
<script type="text/javascript">
  $('#start_date').datetimepicker();
  $('#end_date').datetimepicker();
</script>