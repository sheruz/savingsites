<div class="page-wrapper main-area toggled viewdeals">
   <div class="container">
    <input type="hidden" id="businessid" name="businessid" value="<?php echo $businessid;?>"/>
      <div class="row" style=" margin-bottom: 80px;">
         <div class="top-title">
            <h2> Email Lists</h2>
            <hr class="center-diamond">
            <p>The incoming emails are listed below:</p>
         </div>
         <table class="display responsive-table datatable-all" cellspacing="0" width="100%" id="managecat">
            <thead>
               <tr>
                  <th scope="col">From</th>
                  <th scope="col">Subject</th>
                  <th scope="col">date</th>
                  <th scope="col" width="35%">Status</th>
               </tr>
            </thead>
            <tbody>
               <?php 
               foreach ($purchasedealArr as $v) { ?>
               <tr>
                  <td><?php echo $v['sender'] ?></td>
                  <td><?php echo $v['subject'] ?></td>
                  <td><?php echo $v['date'] ?></td>
                  <td>
                     <?php 
                     $check = '';
                     $check2 = '';
                     if($v['statx'] == 1){
                        $check = 'checked';
                     }else if($v['statx'] == 2){
                        $check2 = 'checked';
                     }

                     ?>
                     <input type="radio" <?= $check;?> ids="<?php echo $v['id']; ?>" class="blogmethod1 blogmethod" value="1"/> Activate <br><input type="radio"  ids="<?php echo $v['id']; ?>" <?= $check2;?> class="blogmethod2 blogmethod"  value="2"/> De Activate
            
                  </td>
               </tr>
               <?php   } ?>
            </tbody>
         </table>
        
   </div>
</div>