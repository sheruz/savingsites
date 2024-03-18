<input type="hidden" name="zoneid" value="<?= $zoneid;?>">
<input type="hidden" name="zonename" value="<?= $zone_name;?>">
<input type="hidden" name="from_zoneid" value="<? $fromzoneid;?>">
<input type="hidden" name="approval" value="<?= $approval['approval']?>">
<input type="hidden" name="from_zoneid" id="from_zoneid" value="<?=$group_id;?>">
<input type="hidden" name="businessid" id="businessid" value="<?=$businessid;?>">
<input type="hidden" name="business_first_password_change" id="business_first_password_change" value="<?=$business_first_password_change;?>">
<div class="page-wrapper main-area toggled viewdeals">
   <div class="container">
    <input type="hidden" id="businessid" name="businessid" value="<?php echo $businessid;?>"/>
      <div class="row" style=" margin-bottom: 80px;">
         <div class="top-title">
            <h2> View Business Subusers</h2>
            <hr class="center-diamond">
            <p>Below are all the subusers who have access to this business's admin.</p>
         </div>
         <table class="display responsive-table datatable-all" cellspacing="0" width="100%" id="managecat">
            <thead>
               <tr>
                  <th scope="col">Email</th>
                  <th scope="col">Username</th>
                  <th scope="col">Password</th>
                  <th scope="col" style="width: 30%;">Action</th>
               </tr>
            </thead>
            <tbody>
            <?php foreach ($businessrankbid as $value) {
               echo '<tr>
                  <td>'.$value['email'].'</td>
                  <td>'.$value['username'].'</td>
                  <td>'.$value['password'].'</td>
                  <td><span class="editdeal cus-solid-prpl" subuserid="'.$value['id'].'""><a target="_blank" style="color: #eef2f6" href="'.base_url().'/businessdashboard/'.$businessid.'/zonecreatesubuser?subuserid='.$value['id'].'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit</a></span></td>
               </tr>';} 
            ?>
            </tbody>
         </table>
        </div>
</div>