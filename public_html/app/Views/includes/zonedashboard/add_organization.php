
<div class="page-wrapper main-area toggled">
   <div class="container">
    <div class="row" style=" margin-bottom: 80px;">
     

     
      <div class="container" id="createdealdiv">
          <!-- MultiStep Form -->
<div class="viewads" id="grad1">
   <div class="row justify-content-center mt-0">
      <div class="col-sm-6 col-md-12 text-center">
         <div class="card">
            <h2><strong>Make New Organization</strong></h2><hr>
            <div class="row">
               <div class="col-md-12 mx-0">
                  <form id="msform">
                     <fieldset>
                        <div class="form-card">
                           <div class="row">
                              <div class="col-md-6">
                                 <label for="acctype">Select Zip Code<span style="color:red">*</span></label>
                                 <select class="form-control orgselect" name="zip_code" id="zip_code">
                                    <option value="-1">--Select Zip Code--</option>
                                    <?php if(!empty($all_claimed_zip)){
                                       foreach($all_claimed_zip as $val){?>
                                          <option value="<?= $val->zip; ?>"><?= $val->zip; ?></option>
                                    <?php } }?>
                                 </select>
                              </div>
                              <div class="col-md-6">
                                 <label for="acctype">Confirm Password<span style="color:red">*</span>
                                 <input type="password" class="validate[required,confirm[password]]" name="cpassword" id="cpassword" value=""/>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <label for="acctype">Select State<span style="color:red">*</span>
                                 <select class="form-control orgselect" name="selState" id="selState">
                                    <option value="-1">--Select State--</option>
                                    <?php if(!empty($get_all_states)){
                                       foreach($get_all_states as $val){?>
                                       <option value="<?= $val->state_id; ?>"><?= $val->state_name; ?></option>
                                    <?php } }?>
                                 </select>
                              </div>
                              <div class="col-md-6">
                                 <label for="acctype">Email<span style="color:red">*</span>
                                 <input onblur="checkEmail(this.val)" type="text" class="validate[required] custemail" name="uemail" id="uemail" value="" />
                                 <input type="hidden" value="1" class="emailsucess">
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <label for="acctype">Select City<span style="color:red">*</span>
                                 <select class="form-control orgselect" name="city" id="selcity">
                                    <option value="-1">--Select City--</option>
                                 </select>
                              </div>
                              <div class="col-md-6">
                                 <label for="acctype">Confirm Email<span style="color:red">*</span>
                                 <input type="text" class="validate[required]" name="cemail" id="cemail" value="" />
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <label for="acctype">Directory<span style="color:red">*</span>
                                 <select class="select_zone_style form-control orgselect" name="selZone" id="selzone">
                                    <option value="-1">--Select Directory--</option>
                                 </select>
                              </div>
                              <div class="col-md-6">
                                 <label for="acctype">First Name<span style="color:red">*</span>
                                 <input type="text" class="validate[required]" name="fname" id="fname" value="" />
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <label for="acctype">Account Type<span style="color:red">*</span>
                                 <select class="validate[required] form-control orgselect" name="org_type" id="org_type">
                                    <option value="0">Organization</option>
                                    <option value="2">School</option>
                                    <option value="4">High School Sports</option>
                                    <option value="1">Municipality</option>
                                 </select>
                              </div>
                              <div class="col-md-6">
                                 <label for="acctype">Last Name<span style="color:red">*</span>
                                 <input type="text" class="validate[required]" name="lname" id="lname" value="" /></td>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <label for="acctype">Organization Name<span style="color:red">*</span>
                                 <input autocomplete="off" type="text" id="org_name" name="org_name" >
                              </div>
                              <div class="col-md-6">
                                 <label for="acctype">Phone<span style="color:red">*</span>
                                 <input type="text" class="validate[required]" name="phone" id="phone_user" value="" onblur="checkPhone()" placeholder="e.g.XXX-XXX-XXXX"/>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <label for="acctype">Username<span style="color:red">*</span>
                                 <input autocomplete="off" type="text" id="org_username" name="org_username"/>
                              </div>
                              <div class="col-md-6">
                                 <label for="acctype">Street Address<span style="color:red">*</span>
                                 <input type="text" class="validate[required]" name="user_address" id="user_address" value="" />
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <label for="acctype">Password<span style="color:red">*</span>
                                 <input type="password" class="validate[required]" name="password" id="password" value="" onblur="checkPassword(this.val)" />
                              </div>
                             
                           </div>
                        </div>
                        <input type="button" name="button" id="button_org_register" value="Register" class="btn btn-primary next action-button cus-btn"/>
                     </fieldset>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
      </div>
    </div>
  </div>
</div>
</div>
