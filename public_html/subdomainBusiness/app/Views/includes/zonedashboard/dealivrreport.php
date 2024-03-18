<div class="page-wrapper main-area toggled viewdeals">
   <div class="container">
    <input type="hidden" id="businessid" name="businessid" value="<?php echo $businessid;?>"/>
      <div class="row" style=" margin-bottom: 80px;">
         <div class="top-title">
            <h2>Business Deals IVR Report</h2>
            <hr class="center-diamond">
            <p>The deals approve by IVR are listed below:</p>
         </div>
         <table class="display responsive-table datatable-all" cellspacing="0" width="100%" id="managecat">
            <thead>
               <tr>
                  <!-- <th scope="col">User</th> -->
                  <th scope="col">Business Name</th>
                  <th scope="col">IVR Call Date</th>
                  <th scope="col">Status</th>
               </tr>
            </thead>
            <tbody>
            <?php foreach ($businessArr as $k => $v) {
               if($v['via'] == 'Phone Call'){
                  if($v['status'] == 'N'){
                     $approval = 'Not Interested';
                  }
                  if($v['status'] == 'A'){
                     $approval = 'Interested';
                  }
                  // echo '<tr><td>'.$v['userfname'].' '.$v['userlname'].'</td><td>'.$v['businessname'].'</td><td>'.date('d-m-Y', strtotime($v['created_at'])).'</td><td>'.$approval.'</td></tr>';
                  echo '<tr><td>'.$v['businessname'].'</td><td>'.date('d-m-Y', strtotime($v['created_at'])).'</td><td>'.$approval.'</td></tr>';
               }
            } ?>
            </tbody>
         </table>
        </div>
      </div>