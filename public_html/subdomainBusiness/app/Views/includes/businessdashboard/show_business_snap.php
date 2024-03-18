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
         <table class="display responsive-table datatable-all" cellspacing="0" width="100%" id="managecat">
            <thead>
               <tr>
                  <th scope="col">SNAP Deal</th>
                  <th scope="col">Action</th>
               </tr>
            </thead>
            <tbody>
            <?php
            foreach ($finalsnapbusArr as $k => $v) {
               echo '<tr>
                  <td>'.$v->dealname.'</td>
                  <td>
                     <a href="'.base_url().'/businessdashboard/'.$businessid.'/add_business_snap?edit=1&busid='.$businessid.'&dealid='.$v->dealId.'"><i busid="'.$businessid.'" daycount=1 class="fa fa-edit editusersnaptime"></i>
                     </a> 
                     <i busid="'.$businessid.'" daycount=1 class="fa fa-trash deleteusersnaptime"></i>
                     <i busid="'.$businessid.'" dealid="'.$v->dealId.'" daycount=1 class="fa fa-info-circle snapbusinessdetaillist"></i>
                  </td>
               </tr>';
            }?>
            </tbody>
         </table>
         
   </div>
</div>
</div>
<script type="text/javascript">
  $('#start_date').datetimepicker();
  $('#end_date').datetimepicker();
</script>