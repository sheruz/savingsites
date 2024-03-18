<div class="page-wrapper main-area toggled viewdeals">
   <div class="container">
    <input type="hidden" id="businessid" name="businessid" value="<?php echo $businessid;?>"/>
      <div class="row" style=" margin-bottom: 80px;">
         <div class="top-title">
            <h2> View Zone Subusers</h2>
            <hr class="center-diamond">
            <p>The following list shows the zone subusers that have been created:</p>
            
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
                  <td>'.$value['password'].'</td>';
                  if($datasubusername == ''){
                     echo '<td><span class="editdeal cus-solid-prpl" subuserid="'.$value['id'].'""><a target="_blank" href="'.base_url().'/Zonedashboard/zonecreatesubuser?subuserid='.$value['id'].'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit</a></span></td>';
                  }else{
                     echo '<td></td>'; 
                  }
                  echo '</tr>';
              } ?>
            </tbody>
         </table>
        </div>
</div>