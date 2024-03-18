<div class="page-wrapper main-area toggled viewdeals">
   <div class="container">
    <input type="hidden" id="businessid" name="businessid" value="<?php echo $businessid;?>"/>
      <div class="row" style=" margin-bottom: 80px;">
         <div class="top-title">
            <h2> View Organization</h2>
            <hr class="center-diamond">
            <p>The Organization created by zone User are listed below:</p>
            
         </div>
         <table class="display responsive-table datatable-all" cellspacing="0" width="100%" id="managecat">
            <thead>
               <tr>
                  <th scope="col">Organization Id</th>
                  <th scope="col">Organization Name</th>
                  <th scope="col">User Id</th>
                  <th scope="col">User Name</th>
                  <th scope="col">First Name</th>
                  <th scope="col">Last Name</th>
                  <th scope="col">Email</th>
                  <th scope="col" style="width: 30%;">Action</th>
               </tr>
            </thead>
            <tbody>
               <?php foreach ($savedorganization as $k => $v) { 
                if($v->status == 1){
                  $useractive = 'Active';
                }else{
                  $useractive = 'In-Active';
                }
                ?>
               <tr>
                  <td><?php echo $v->orgid; ?></td>
                  <td><?php echo $v->orgname; ?></td>
                  <td><?php echo $v->userid; ?></td>
                  <td><?php echo $v->username; ?></td>
                  <td><?php echo $v->first_name; ?></td>
                  <td><?php echo $v->last_name; ?></td>
                  <td><?php echo $v->email; ?></td>
                  <td>
                     <span class="editorganization cus-solid-prpl" orgid="<?= $v->orgid; ?>" orguser="<?= $v->userid; ?>" zone_id="<?= $v->zoneuserid; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</span>
                     <!-- <span class="delorg cus-solid-blue" orgid="<?= $v->orgid; ?>" orguser="<?= $v->userid; ?>" zone_id="<?= $v->zoneuserid; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Delete</span> -->
                  </td>
               </tr>
               <?php } ?>
            </tbody>
         </table>
         <div class="container hide" id="createdealdiv">
        <div class="row">
          <div class="col-md-12">
             <p id="closedeal">Close <i class="fa fa-window-close" aria-hidden="true"></i></p>
            <div class="top-title">
              <h2>Edit Organization Details</h2>
              <hr class="center-diamond">
            </div>
            <form name="auctioncreate" method="post" id="msform" class="auctioncreate" action="">
              <fieldset>
                        <div class="form-card">
                           <div class="row">
                              <div class="col-md-6">
                                 <label for="acctype">Organization Name<span style="color:red">*</span>
                                 <input disabled autocomplete="off" type="text" id="org_name" name="org_name" >
                              </div>
                              <div class="col-md-6">
                                 <label for="acctype">Email<span style="color:red">*</span>
                                 <input onblur="checkEmail(this.val)" type="text" class="validate[required] custemail" name="uemail" id="uemail" value="" />
                                 <input type="hidden" value="1" class="emailsucess">
                              </div>
                              
                           </div>
                          
                           <div class="row">
                              <div class="col-md-6">
                                 <label for="acctype">First Name<span style="color:red">*</span>
                                 <input type="text" class="validate[required]" name="fname" id="fname" value="" />
                              </div>
                              <div class="col-md-6">
                                 <label for="acctype">Last Name<span style="color:red">*</span>
                                 <input type="text" class="validate[required]" name="lname" id="lname" value="" /></td>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <label for="acctype">Phone<span style="color:red">*</span>
                                 <input type="text" class="validate[required]" name="phone" id="phone_user" value="" onblur="checkPhone()" placeholder="e.g.XXX-XXX-XXXX"/>
                              </div> 
                               <div class="col-md-6">
                                 <label for="acctype">Street Address<span style="color:red">*</span>
                                 <input type="text" class="validate[required]" name="user_address" id="user_address" value="" />
                              </div> 
                              
                           </div>
                          </div>
                        <input type="button" name="button" id="button_org_update" value="Update Organization" class="btn btn-primary action-button cus-btn"/>
                     </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>



