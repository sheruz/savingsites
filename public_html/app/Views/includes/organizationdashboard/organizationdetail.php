<?php helper('form'); ?>
<input type="hidden" name="orgzoneid" id="orgzoneid" value="<?=$fromzoneid;?>" />
<input type="hidden" name="org_id" id="org_id" value="<?=$org_id;?>" />
<input type="hidden" name="orgnid" id="orgnid" value="<?=$org_owner_id;?>" />
<input type="hidden" name="orgnid" id="orgnid" value="<?=$organization_status;?>" />
<input type="hidden" name="from_zoneid" id="from_zoneid" value="<?=$from_zoneid;?>">
<input type="hidden" name="from_zoneid" id="from_zoneid" value="<?=$group_id;?>">
<input type="hidden" name="userid" id="userid" value="<?=$uid;?>">
<input type="hidden" name="username" id="username" value="<?=$organization_owner_detail['username'];?>">
<div class="main_content_outer"> 
  <div class="content_container">
  <?php if($from_zoneid!='0'){?>
    <div class="spacer"></div>
    <div class="businessname-heading">
      <div class="main main-large main-100">
        <div class="businessname-heading-main">
          <?php if($organizationid!='') { ?>
          <div style="float:left;">
            <font color="">Organization Name: </font> 
            <div class="oswald" style="font-size:26px; line-height:initial;">
          <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php }?>
  <div id="container_tab_content" class="container_tab_content owner_section">
    <ul id="tabs-nav">
    <li class="active"><a href="#tab1">Organization Owner Contact Information</a></li>
    <li><a href="#tab2">Change Organization Password</a></li>
  </ul>

    <div <?php /*?>style="background:#A0D889"<?php */?> id="update_message"></div>
<!--     <div id="helpdiv" class="container_tab_header header-default-message bv_head_wraper" margin-top:10px;>
      <p>To view the Organization Owner Information click on the Organization Owner Information tab. To update your organization password click on the "Change Password" tab.</p>
    </div> -->

  <div class="tabs org">
  <div id="tabs-content">
    <div id="tab1" class="tab-content" style="display: none;">
       <?php if($org_id!='') { ?>
    <div class="refferaldiv">
      <h4>Referral Code: <a  class="referalcopy" href="<?=base_url('businessSearch/search/'.$zoneid.'/'.$referralCode) ?>"><i class="fa fa-copy"></i> <?php echo $referralCode ?></a></h4>
    </div>
  <?php } ?>
      <div class="top-title">
        <h2>Update Organization Owner Information</h2>
         <hr class="center-diamond">
      </div>
            <div class="form-group center-block-table">
        <form id="user-form" class="form-validate bv_owner_form" enctype="multipart/form-data" name="adminForm" method="post" action="" style="float:left;">
          <div class="row">
            <div class="col-md-12">
                        <input type="hidden" id="userid" name="userid" value=""/>
          <p class="form-group-row"><label for="username" class="fleft w_100 m_top_0i">Username</label><b><?=$organization_owner_detail['username']?></b></p>
            </div>
            <div class="col-md-6">
          <p class="form-group-row">
            <label for="email" class="fleft w_100">Email</label>
            <input type="text" id="jform_Email" name="jform_Email" class="w_300"  value="<?=$organization_owner_detail['email']?>" />
          </p>

          <p class="form-group-row">
            <label for="firstname" class="fleft w_100">First Name</label>
            <input type="text" id="jform_Firstname" name="jform_Firstname" class="w_300"  value="<?=$organization_owner_detail['first_name']?>" />
          </p>

          <p class="form-group-row">
            <label for="lastname" class="fleft w_100">Last Name</label>
            <input type="text" id="jform_Lastname" name="jform_Lastname" class="w_300" value="<?=$organization_owner_detail['last_name']?>" />
          </p>

          <p class="form-group-row">
            <label for="phone" class="fleft w_100">Phone</label>
            <input type="text" id="jform_Phone" name="jform_Phone" class="w_300" value="<?=$organization_owner_detail['phone']?>" />
          </p>
            </div>
            <div class="col-md-6">
          <p class="form-group-row">
            <label for="address" class="fleft w_100">Address</label>
            <input type="text" id="jform_Address" name="jform_Address" class="w_300"  value="<?=$organization_owner_detail['Address']?>" />
          </p>
          <p class="form-group-row">
            <label for="zip1" class="fleft w_100">Zip</label>
            <input disabled type="text" id="jform_Zip" name="jform_Zip" class="w_300"  value="<?=$organization_owner_detail['Zip']?>" />
          </p>
          <p class="form-group-row">
            <label for="lastname" class="fleft w_100">State</label>
            <select class="" name="selState" id="selState">
                  <option value="-1">--Select State--</option>
                  <?php if(!empty($get_all_states)){
                    foreach($get_all_states as $val){
                      if($organization_owner_detail['State_Code'] == $val->state_id){
                        $selected = 'selected';
                      }else{
                        $selected = '';
                      }
                      ?>
                      <option <?= $selected; ?> value="<?= $val->state_id; ?>"><?= $val->state_name; ?></option>
                  <?php } }?>
                </select>
          </p>
          <p class="form-group-row"  id="cityshow">
            <label for="city" class="fleft w_100">City</label>
            <input type="text" id="jform_City" name="jform_City" class="w_300"  value="<?=$organization_owner_detail['City']?>" />
          </p>
          <p class="form-group-row hide" id="cityselect">
            <label for="city" class="fleft w_100">City</label>
            <select class="" name="city" id="selcity">
                <option value="-1">--Select City--</option>
            </select>
          </p>

            </div>
          </div>
 
          <p class="form-group-row">
            <label class="bv_update" for="zip1">
              <button onclick="UpdateOrgProfile();return false;" class="m_left_100" name="organization_info">Update</button>
            </label>
          </p>
        </form>

        <div class="note_information" style="float:left; margin-left:30px; margin-top:40px;color:#C00;">The information on this page is required. It is private information between the organization owner and Savingssites.<br /><br/> This information will not be released or shared. <br /><br/> It will only be used for communitations between SavingsSites and the organization owner.
        </div>
      </div>
    </div>
    <div id="tab2" class="tab-content" style="display: none;">
      <div class="top-title">
          <h2>Change Password</h2>
          <hr class="center-diamond">
        </div>
        <div class="row">
          <div class="col-md-6 change-pass-left">
            <h2>Passwords must contain:</h2>
            <li><i class="fa fa-check" aria-hidden="true"></i> Case sensitive</li>
            <li><i class="fa fa-check" aria-hidden="true"></i> Combination of 10-18 letters</li>
            <li><i class="fa fa-check" aria-hidden="true"></i> At least 1 Numbers (0,9)</li>
            <li><i class="fa fa-check" aria-hidden="true"></i> Special characters (!, @, #, $, %, &amp;)</li>
          </div>
          <div class="col-md-6">
          <div class="form-group center-block-table cus-change-pass org-change-pass">
        <div class="form-group center-block-table  bv_change_password">
          <form id="user-form-password" class="form-validate" enctype="multipart/form-data" name="adminForm" method="post" action="">
            <input type="hidden" id="userid" name="userid" value=""/>

            <p>
              <label for="current_pass" class="fleft w_150">Current Password</label>
              <input type="password" class="w_300" id="current_pass" name="current_pass"  value="" />
            </p>

            <p>
              <label for="new_pass" class="fleft w_150">New Password</label>
              <input type="password" class="w_300" id="new_pass" name="new_pass"  value="" />
            </p>

            <p>
              <label for="confirm_pass" class="fleft w_150">Confirm Password</label>
              <input type="password" class="w_300" id="confirm_pass" name="confirm_pass"  value="" />
            </p>

            <p>
              <label class="bv_update_sec" for="zip1">
                <button class="m_left_150">Update</button>
              </label>
            </p>
          </form>
        </div>
            <div class="testingServer fleft new">
              <div class="message">
                
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
<div class="modal fade" id="dialog" role="dialog" data-backdrop="false" style="max-width: 560px;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title" style="margin: 7px 0;">SUCCESS</h5>
      </div>
      <div class="modal-body msg" ></div>
    </div>
  </div>
</div>

<div class="modal fade" id="dialog_1" role="dialog" data-backdrop="false" style="max-width: 560px;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title" style="margin: 7px 0;">SUCCESS</h5>
      </div>
      <div class="modal-body msg" ></div>
    </div>
  </div>
</div>










 







