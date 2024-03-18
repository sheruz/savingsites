<?php 
   $d = isset($_GET['d'])?$_GET['d']:'';
?>
<div class="page-wrapper main-area toggled viewdeals">
   <div class="container">
    <input type="hidden" id="businessid" name="businessid" value="<?php echo $businessid;?>"/>
      <div class="row" style=" margin-bottom: 80px;">
         <div class="top-title">
            <h2>Business Deals Approval DPA Report</h2>
            <hr class="center-diamond">
            <div class="row">
               <div class="col-md-3">
                  <input type="hidden" id="nodataexcel" value="<?= $d; ?>"/>
                  <select class="form-control dpaexcel">
                     <option value="">Choose Status</option>
                     <option value="all">Select All</option>
                     <option value="A">Active</option>
                     <option value="P">Pending</option>
                     <option value="N">Hiding</option>
                  </select>
               </div>
               <div class="col-md-3">
                  <button class="btn btn-success dpaexceldown">Download CSV</button>
               </div>
               <div class="col-md-3"> 
                  <button class="btn btn-success dpareschedule">Reschedule</button>
               </div>
            </div>
         </div>
         
         <br>
         <table class="display responsive-table datatable-all" cellspacing="0" width="100%" id="managecat">
            <thead>
               <tr>
                  <th scope="col">Business Name</th>
                  <th scope="col">Send Type</th>
                  <th scope="col">Send Date</th>
                  <th scope="col" width="20%">Status</th>
                  <th scope="col">Accepted/Rejected Date</th>
                  <th scope="col">Action</th>
               </tr>
            </thead>
            <tbody>
            <?php foreach ($businessArr as $k => $v) {
               
                  if($v['status'] == 'N'){
                     $approval = '<select ids="'.$v['id'].'" class="form-control approvaldpaselect"><option value="A">Active</option><option value="P">Pending</option><option value="N" selected>Hiding</option></select>';
                  }
                  if($v['status'] == 'A'){
                     $approval = '<select ids="'.$v['id'].'" class="form-control approvaldpaselect"><option value="A" selected>Active</option><option value="P">Pending</option><option value="N">Hiding</option></select>';
                  }
                  if($v['status'] == 'P'){
                     $approval = '<select ids="'.$v['id'].'" class="form-control approvaldpaselect"><option value="A">Active</option><option value="P" selected>Pending</option><option value="N">Hiding</option></select>';
                  }
                  if($v['via'] == ''){
                     $type = 'Email';
                  }else if($v['via'] == 'QR'){
                     $type = 'QR Code';
                  }else{
                     $type = 'Phone Call';
                  }
                  if($v['updated_at'] == '0000-00-00'){
                     $update = '';
                  }else{
                       $update = date('d-m-Y', strtotime($v['created_at']));
                  }
                  echo '<tr><td>'.$v['businessname'].'</td><td>'.$type.'</td><td>'.date('d-m-Y', strtotime($v['created_at'])).'</td><td>'.$approval.'</td><td>'.$update.'</td><td><button class="btn btn-success saveapprovaldpa" ids="'.$v['id'].'">Save</button></td></tr>';
               
            } ?>
            </tbody>
         </table>
        </div>
      </div>