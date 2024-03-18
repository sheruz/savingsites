<div class="page-wrapper main-area toggled viewdeals">
   <div class="container">
    <input type="hidden" id="businessid" name="businessid" value="<?php echo $businessid;?>"/>
      <div class="row" style=" margin-bottom: 80px;">
         <div class="top-title">
            <h2> View Business Rank</h2>
            <hr class="center-diamond">
            <p>Top Rank Business are listed below:</p>
         </div>
         <table class="display responsive-table datatable-all" cellspacing="0" width="100%" id="managecat">
            <thead>
               <tr>
                  <th scope="col">Rank</th>
                  <th scope="col">Business Id</th>
                  <th scope="col">Business Name</th>
                  <th scope="col">Bid Amount</th>
               </tr>
            </thead>
            <tbody>
              <?php 
               $sr = 0;
               foreach ($businessrankbid as $k => $v) {
                  $sr++;
                  echo '<tr><td>'.$sr.'</td>
                        <td>'.$v['business_id'].'</td>
                        <td>'.$v['business_name'].'</td>
                        <td>'.$v['bid_amount'].'</td>
                    </tr>'; 
               } 
              ?>
            </tbody>
         </table>
      </div>
    </div>