<?php 
  helper('form');
  $code_data="";
  if(! empty($embed_jotform_code)){ $code_data=$embed_jotform_code[0]->code; }
?>
<style>
.highlited {
  background-color: yellow;
}

#spinner_second{display: none;}
.testingServer {
  background-color: #fbfad5;
  border: 1px solid gray;
  padding: 10px;
  border-radius:8px;
  width: 200px;
  margin-left: 490px;
  margin-top: -205px;
}


.testingServer .lightBulb {
  background-image: url("warning.png");
  float: left;
  height: 24px;
  width: 24px;
  z-index: -999;
  background-size: 24px;
  background-repeat: no-repeat;
}

.hide{
  margin-left:540px;
  display:none;
}
#biz_history,#biz_about{
  height: 150px !important;
}
</style>

<input type="hidden" name="zoneid" value="<?= $zoneid;?>">
<input type="hidden" name="zonename" value="<?= $zone_name;?>">
<input type="hidden" name="from_zoneid" value="<? $fromzoneid;?>">
<input type="hidden" name="approval" value="<?= $approval['approval']?>">
<input type="hidden" name="from_zoneid" id="from_zoneid" value="<?=$group_id;?>">
<input type="hidden" name="businessid" id="businessid" value="<?=$businessid;?>">
<input type="hidden" name="business_first_password_change" id="business_first_password_change" value="<?=$business_first_password_change;?>">

<?php  $sponsor_business_id=0;
if(is_array($business_sponsored_status)){
  if($business_sponsored_status[0]->id){
    $sponsor_business_id=$business_sponsored_status[0]->id;
  }
}

$zone_id      = $zoneid;
$business_id  = $businessid;
$logo         = $sub_header_name_from_zone['logo'];
$condition_1  = $approval['approval'];  //approval status of the business
$condition_2  = $group_id ;	  // user group id--> zone_owner -> 4 ; business_owner -> 5	
$userid=$sub_header_name_from_zone['business_owner_id'];

if($fromzoneid!=''){ 
  $business_id_ra=$sub_header_name_from_zone['id'];
}else{ 
  $business_id_ra=$businessid;
}

if(($condition_1==1 || $condition_1==2 || $condition_1==3) || ($condition_2==4 )){ ?>
<div class="page-wrapper main-area toggled businessdetail main_content_outer addbuss"> 
  <div class="container content_container">
    <?php if($fromzoneid !='0'){ ?>
    <div class="spacer"></div>
<!--     <div class="businessname-heading">
      <div class="main main-large main-100">
        <div class="businessname-heading-main">
        <?php if($businessid!='') {    ?> 
          <div><font color="">Business Name : </font> <div class="oswald" style="font-size:26px; line-height:initial;">
        <?php } ?>  
       
        <?php echo urldecode($sub_header_name_from_zone['name']);
          if($businessid!='') { ?><?= ' '.$approval_message?> <?php } ?>
        </div>
        </div>
        <a href="<?=base_url()?>Zonedashboard/all_business/<?=$fromzoneid;?>" class="fright" style="text-decoration:none">&#8592; Back to Zone Dashboard</a><br/>
      <?php $x = $business_search_value;
        if($businessid!='' && $x!= ''){ ?>
          <a href="<?=base_url()?>Zonedashboard/zonedetail/<?=$fromzoneid;?>" class="fright">&#8592; Back to Previous Search</a><br/>
      <?php } ?>
      <?php if($fromzoneid!=0 && $businessid!=''){?>
        <br>
        <select class="fright"  id="goto_different_ads">
          <option value="1">Business Display Filter</option>
          <option value="2"><a href="<?=base_url()?>Zonedashboard/all_business/<?=$zoneid;?>" class="fright" style="text-decoration:none">All Business</a> </option>
          <option value="3">Active Real Ads</option>
          <option value="4">Business Coming Soon</option>
          <option value="5">Inactive Ads</option>
        </select>
        <button class="fright" id="different_ads" style="margin-right: -256px; margin-top: -12px;  height: 26px;  width: 38px; background: #7b498f; border: none;"><p style="margin-top: -4px; margin-left: -6px;">Go</p></button>
      <?php } ?>
      </div>
    </div>
  </div>
<?php } if($from_where == 'zone'){?>
  <div class="spacer"></div>
  <div class="businessname-heading" style="overflow:hidden;">
    <div class="main main-large main-100">
      <div class="businessname-heading-main">
        <div class="center" style="width:100%">
          <font style="">Search All Businesses (Real Active Ads, Businesses Uploaded, Biz Opp Providers, Inactive Ads)</font> 
          <input type="text" id="global_bus_search" name="global_bus_search" class="text-input" placeholder="Exact business name or phone no. or id" style="" value="<?php echo $this->session->userdata('business_search_value') ?>" />
          <button class="btn-sm"  id="global_bus_search_btn" type="button" style="">Search</button>
          <button class="btn-sm global_search_close hide_search_result" type="button" style="display:none">Clear Search</button>
        </div>
        <div id="no_bus_found" style="margin-left:15px;" class="fleft w_300"></div>
      </div>
    </div>
    <div id="view_global_bus_search_div" style="width:1130px; margin:10px auto 0; background-color:#d2e08f; display:none; overflow:hidden; padding:10px;">
    <div id="view_global_bus_search" class="fleft" style="width:1080px;"></div>
      <a style="margin:-10px 20px 0 0;" href="javascript:void(0)" class="close" onClick="$('#view_global_bus_search_div').slideToggle();"><img src="<?=base_url('assets/images/close_pop.png') ?>" class="btn_close global_search_close" title="Close Window" alt="Close" ></a>
    </div>
  </div> -->
<?php } ?> 
<!--   <div class="container_tab_header">Business Detail Information
    <div class="refferaldiv"><h4>Referral Code: <a  class="referalcopy" href="<?=base_url('businessSearch/search/'.$zoneid.'/'.@$referralCode) ?>"><i class="fa fa-copy"></i> <?php echo @$referralCode ?></a></h4>
    </div>
  </div> -->
  <div id="container_tab_content" class="container_tab_content cus-buss-detail bv_deatils_business_sec">
<!--     <ul id="tabs-nav">
      <li class="active"><a href="#tab1" id="update_business_details">Update Business Detail</a></li>
      <li <?php if($businessowner_zoneowner == 1){ ?>style="display:none;"<?php } ?>>
        <a href="#tab2" id="update_business_owner_info">Update Business Owner Information</a></li>
      <li class=""><a href="#tab3" id="change_password">Change Password</a></li>
      <li class=""><a href="#tab5" id="business_logo">Business Logo</a></li>
      <li class=""><a href="#tab6" id="program_sponsors">Program Sponsors</a></li>
      <li class=""><a href="#tab8" id="business_logo">Image</a></li>

    </ul> -->
     <ul id="tabs-nav">
    <li><a href="#tab1"> Update Business Detail</a></li>
    <li><a href="#tab2">Update Owner Information</a></li>
    <li><a href="#tab3">Change Password</a></li>
    <li><a href="#tab5">Business Logo</a></li>
   <!--  <li><a href="#tab6">Program Sponsors</a></li>
    <li><a href="#tab8">Image</a></li> -->
  </ul> 
  <div class="tabs">
  <div id="tabs-content">
    <div id="tab1" class="tab-content">
         <div class="top-title">
        <h2> Update Business Detail</h2>
         <hr class="center-diamond">
      </div>
<div id="help_shot" class="container_tab_header header-default-message bv_help_shot" margin-top:10px;>
      <p>To update the owner details fill up the neccessary fields and then click on the "Save" button down below.</p>
    </div>
    <div class="form-group">
      <div id="businessDataEdit">
        <?=form_open_multipart("dashboards/saveBusiness", "name='businesses_form' id='businesses_form' ");?>
        <div class="spacer"></div>
        <p class="form-group-row">
        <? if(!empty($my_businesses) && count($my_businesses) > 1){?>
        <label for="lastname" class="fleft w_200">Change Business</label>
        <select id="myBusinesses" >
          <option value="-1" selected="selected" disabled="disabled">--- Select A Business To Change To ---</option>
          <?php foreach($my_businesses as $my_business){ if($my_business['id'] == $business_id) { continue;}?>
            <option value="<?=$my_business['id']?>"><?=$my_business['name']?></option>
          <?php }?>
        </select>                        
        <? }  ?>
        </p>
        <input type="hidden" id="logo" name="logo" />
      </div>
    </div>
    <input type="hidden" id="biz_address_id" value="<?=$business->addressid?>"/>
    <input type="hidden" id="biz_owner_id" value="<?=$business->business_owner_id?>"/>
    <input type="hidden" id="biz_zone_ids" name="biz_zone_ids" value="<?= $zoneid;?>"/>
<div class="row">
  <div class="col-lg-6">
        <p class="form-group-row busines_col">
      <label for="email" class="fleft w_200">Business Name<span style="color:red">*</span></label>
      <input type="text" id="biz_name" name="biz_name" class="w_53601"  value="<?=urldecode(stripslashes($business->name))?>" />
    
      <div id="error_contact_name"></div>
    </p>
    
    <p class="form-group-row">
      <label for="restaurant_type" class="fleft w_200">Business Type</label>
      <select id="restaurant_type" class="fleft w_315">
        <option value="1" <?=$business->type == 1 ? ' selected="selected"' : '';?>>Restaurant</option>
        <option value="0" <?=$business->type == 0 ? ' selected="selected"' : '';?>>Non Restaurant</option>
      </select>
    </p>
    
    <p class="form-group-row">
      <label for="biz_motto" class="fleft w_200">Motto/Slogan</label>
      <textarea id="biz_motto" name="biz_motto" class="w_53601" ><?=stripslashes($business->motto)?></textarea>
    </p>
    
    <p class="form-group-row">
      <label for="biz_about" class="fleft w_200">About Us<br /> </label>
      <textarea id="biz_about" name="biz_about" class="w_53601" ><?=stripslashes($business->aboutus)?></textarea>
    </p>
      
    <p class="form-group-row">
      <label for="biz_contact_email" class="fleft w_200">Contact Email<span style="color:red">*</span></label>
      <input type="text" id="biz_contact_email" name="biz_contact_email" class="w_53601" value="<?=$adsemail;?>" />
      <div id="error_contact_email"></div>
    </p>

    <div style="margin-left: 200px;display:none;  background-color: wheat; height: 25px; border-radius: 7px;width: 245px;"id="email_notice" >
      <span style="color:red;  margin-left: 12px;"/> Please enter valid Email address </span>
    </div>
    
    <p class="form-group-row">
      <label for="biz_contactfirstname" class="fleft w_200">Contact First Name<span style="color:red">*</span></label>
      <input type="text" id="biz_contactfirstname" name="biz_contactfirstname" class="w_53601" value="<?=$adsfirstname?>" />
      <div id="error_contact_firstname"></div>
    </p>
    
    <p class="form-group-row">
      <label for="biz_contactlastname" class="fleft w_200">Contact Last Name<span style="color:red">*</span></label>
      <input type="text" id="biz_contactlastname" name="biz_contactlastname" class="w_53601"  value="<?=$adslastname?>" />
      <div  id="error_contact_lastname"></div>
    </p>
    
    <p class="form-group-row" style="display:none">
      <label for="biz_contactfullname" class="fleft w_200">Contact Full Name<span style="color:red">*</span></label>
      <input type="text" id="biz_contactfullname" name="biz_contactfullname" class="w_53601"  value="<?=$adsfirstname.' '.$adslastname?>" />
      <div  id="error_contact_fullname"></div>
    </p>
    
    <p class="form-group-row">
      <label for="biz_street_1" class="fleft w_200">Street Address<span style="color:red">*</span></label>
      <textarea id="biz_street_1" name="biz_street_1" class="w_53601" ><?=$adsaddress_1?></textarea>
      <div  id="error_contact_address"></div>
    </p>
  </div>

  <div class="col-lg-6">
    <p class="form-group-row">
      <label for="biz_street_2" class="fleft w_200">Mailing Address (if different)</label>
      <textarea id="biz_street_2" name="biz_street_2" class="w_53601" ><?=$adsaddress_2?></textarea>
    </p>
    <p class="form-group-row">
      <label for="biz_city" class="fleft w_200">City</span></label>
      <input type="text" id="biz_city" name="biz_city" class="w_53601" value="<?=$adscity?>"/>
      <div id="error_city"></div>
    </p>
    
    <p class="form-group-row">
      <label for="biz_zip_code" class="fleft w_200">Zip Code:</label>
      <select class="" name="postalcode" id="postalcode" onchange="hide_table();">
        <option value="-1">--Select Zip Code--</option>
          <?php if(!empty($all_claimed_zip)){
          foreach($all_claimed_zip as $val){
            if($val->zip == $adszip_code){
              $selected = "selected";
            }else{
              $selected = "";
            }

            ?>
            <option <?= $selected; ?> value="<?= $val->zip; ?>"><?= $val->zip; ?></option>
          <?php } }?>
      </select>
    </p>

    <p class="form-group-row">
      <label for="biz_about" class="fleft w_200">History<br /> </label>
      <textarea id="biz_history" name="biz_history" class="w_53601" ><?=stripslashes($business->history)?></textarea>
    </p>

    <p class="form-group-row">
      <label for="address" class="fleft w_200">State</label>
      <?= form_dropdown("biz_state", $state_list, (!empty($get_bus_state_phone[0]['state']) ? $get_bus_state_phone[0]['state'] : ''), 'id="biz_state"');?>
        <div id="error_contact_state"></div>
    </p>
    <?php if(!empty($get_bus_state_phone[0]['phone'])){
      $phone1=trim($get_bus_state_phone[0]['phone']);
      preg_match_all('/\d+/', $phone1, $matches);
      $matches[0]; 
      $phone=implode('',$matches[0]);
      if(!empty($phone)){
        $latest_phone_format= '('.substr($phone,0,3).') '.substr($phone,3,3).'-'.substr($phone,6);
        $a=substr($latest_phone_format, -1);
        if($a=='-'){ $s=rtrim($latest_phone_format, "-"); 
        }else{ $s=$latest_phone_format; }
      }else{ $s=''; }
      }
    ?>
    <p class="form-group-row" style="margin-top: 42px;">
      <label for="biz_phone" class="fleft w_200">Phone Number (shows in ads)<span style="color:red">*</span></label>
      <input type="text" id="biz_phone" name="biz_phone" class="w_53601" value="<?=$adsphone;?>" placeholder="Enter # (e.g. 555-XXX-XXXX)"/>
    </p>
    
    <p class="form-group-row">
      <label for="atbiz_phone" class="fleft w_200">Alternative Phone Number</label>
      <input type="text" id="albiz_phone" name="albiz_phone" class="w_536"  value="<?php if(!empty($alternate_phone)) echo $alternate_phone;?>" placeholder="Enter # (e.g. 555-XXX-XXXX )"/>
    </p>
    
    <p class="form-group-row" >
      <label for="biz_website" class="fleft w_200">Website</label>
      <input type="text" id="biz_website" name="biz_website" class="w_53601"  value="<?=$adswebsite?>" />
    </p>
    
    <p class="form-group-row">
      <label for="biz_sic" class="fleft w_200">ServiceNumber(Amazon Contact number)</label>
      <input style="height:40px;" type="number" id="service_number" name="service_number" class="w_53601"  value="<?=$adsservice_number?>" />   
    </p>
     
    
    <?php if($business->type == 1){ ?>
    <p class="form-group-row" id="image_upload_div">
      <label for="biz_sic" class="fleft w_200">Upload Greetings<br> (mp3, wav)</label>
      <input style="max-width: 100%!important;width: 48%!important;margin-right: 7px;background: #fff;" type="file" id="file" name="file" class="w_536"  value="<?=$adsaudio_greetings?>" saved_audio="<?= $adsaudio_greetings ?>" title="Greeting Format Must be MP3,WAV" onchange="javascript:uploadFile()"/>    
    </p>
    
    <?php if($adsaudio_greetings != ''){
      $path = 'https://savingssites.com/assets/audio/'.$adsaudio_greetings;
    ?>
    
    <p class="form-group-row" id="image_upload_div1">
      <label for="biz_sic" class="fleft w_200">Uploaded Audio Greetings</label>
      <audio controls autoplay>
        <source src="horse.ogg" type="audio/ogg">
        <source id="audiomp3" src="<?= $path;?>" type="audio/mpeg">
        Your browser does not support the audio element.
      </audio>    
    </p>

    <?php } } ?>
    
    <p class="form-group-row" style="display:none;">
      <label for="siccode" class="fleft w_200">SIC Code</label>
      <input type="text" id="siccode" name="siccode" class="w_300"  value="<?=isset($result['siccode'])?$result['siccode']:'';?>" />
    </p>
  </div>
</div>

    
    
    <div style="display: none;">
      <p class="form-group-row">
        <label for="city" class="fleft w_200  m_top_0i">Business Presentation</label>
        <input type="checkbox" name="biz_audio_presentation" id="biz_audio_presentation" value="<?=$adsaudio_presentation?>" <? if($adsaudio_presentation==1){ echo 'checked';} ?>/>MP3 Audio   
        <input type="checkbox" name="biz_video_presentation" id="biz_video_presentation" value="<?=$adsvideo_presentation?>" <? if($adsvideo_presentation==1){ echo 'checked';} ?>/>You Tube Video
      </p>
    </div>
    
    <div style="display: none;">
      <label for="biz_type" style="display:none;">Business Type:</label>
      <select id="biz_type" name="biz_type" style="display:none;float: right;margin-right: 34px;width: 306px;margin-top: 10px">
        <option value="1" <?php if($business_type['approval']==1) echo 'selected'?>>Active Paid</option>
        <option value="-1" <?php if($business_type['approval']==-1) echo 'selected'?>>Deactive Paid </option>
        <option value="2" <?php if($business_type['approval']==2) echo 'selected'?>>Active Trial </option>
        <option value="-2" <?php if($business_type['approval']==-2) echo 'selected'?>>Deactive Trial </option>
      </select>
      <label for="peration_hours" class="fleft w_200">Operation Hours:</label><br />
      <h5 style="margin-left: 188px;"></h5>
    </div>
    
    <div style="display: none;"><br>                 
      <label for="new_pass" class="fleft w_200">Appointment: </label>
      <textarea id="business_appointment" class="" value=""><?= isset($operation[0]['business_appointment'])?$operation[0]['business_appointment']:''; ?></textarea><br />
      <label for="new_pass" class="fleft w_200">Monday: </label>
      <input type="hidden" id="monday_active" class="active_days" value=""/>


                    </p>

                    <div <?php if(!empty($zone_owner)){echo 'style="display:block;"';}else{echo 'style="display:none;"';}?>>

                    <label for="business_owner" style="width:150px; float:left; display:block; padding-right:10px;">Business Owner:</label>

                    <select style="width:300px;" name="business_owner" id="business_owner" onchange="create_bus_owner(this.value);return false;">

                    <option value="-1">--- Create New Account---</option>

                    
                    </select>

                    <br/>

                    <div style="display:none;" id="new_user_detail">

                    <label for="userName" style="width:150px; float:left; display:block; padding-right:10px;">Username:</label>

                    <input style="width:300px;" class="fleft w_150" id="userName" name="userName"/>

                    <br/>

                    <label for="password" style="width:150px; float:left; display:block; padding-right:10px;">Password:</label>

                    <input style="width:300px;" class="fleft w_150" id="password" name="password"/>

                    <br/>

                    </div>

                    </div>

                   

                    <br />

                    <br clear="all"/>

                    <?=form_close()?>

                    <!--<button onclick="saveBusinessInfo();" style="margin-left:200px;" id="save_business_info" name="save_business_info">Save</button>-->

                    

                    <button onclick="saveBusinessInfo();" style="margin-left:200px;" id="save_business_info" name="save_business_info">Save</button>

                   <?php if($condition_1!=3){ ?>

                    <div>

                    <h4 class="cus-business-h4">Any changes does not effect your Peekaboo account.To change <span style="cursor:pointer; color:red" onclick="peekaboo_access_button('login')">click here</span>

                    </h4>

                </div>

                <?php } ?>
               

                 </div>
                 <div class="col-md-12">
                    <button class="fright w_200 cus-btn" type="button" id="update_business">Update Business</button>
                 </div>
     <?php /*?> <?php }?><?php */?>
    </div>
    <div id="tab2" class="tab-content">
      <div class="top-title">
        <h2> Update Business Owner Information</h2>
         <hr class="center-diamond">
      </div>
              <div id="help_shot" class="container_tab_header header-default-message bv_help_shot" margin-top:10px;>

                <p>To update the owner information fill up the required and then click on the "Update" button down below.</p>

        </div>

                  <div class="form-group center-block-table">

            <div class="row">
              <div class="col-lg-6">
 <form id="user-form" class="form-validate cus-form-bussness-tab2" enctype="multipart/form-data" name="adminForm" method="post" action="">

              

                <input type="hidden" id="userid" name="userid" value="<?= $userid; ?>"/>

                    <p class="form-group-row">

                    <label for="username" class="fleft w_100 m_top_0i">Username: </label><b> <?=$business_owner_details['username'] ?></b>

                    </p>

                    

                    <p class="form-group-row">

                      <label for="email" class="fleft w_100">Email<span style="color: red;">*</span></label>

                      <input type="text" id="jform_Email" name="jform_Email" class="w_300"  value="<?=$business_owner_details['email'] ?>" />

                    </p>

                    <div style="margin-left: 100px;display:none;  background-color: wheat; height: 25px; border-radius: 7px;width: 245px;"id="email_notice1" >

                    <span style="color:red;  margin-left: 12px;"/> Please enter valid Email address </span>

                    </div>

                    

                    <p class="form-group-row">

                      <label for="firstname" class="fleft w_100">First Name<span style="color: red;">*</span></label>

                      <input type="text" id="jform_Firstname" name="jform_Firstname" class="w_300"  value="<?=$business_owner_details['first_name']?>" />

                    </p>

                    

                    <p class="form-group-row">

                      <label for="lastname" class="fleft w_100">Last Name<span style="color: red;">*</span></label>

                      <input type="text" id="jform_Lastname" name="jform_Lastname" class="w_300" value="<?=$business_owner_details['last_name']?>" />

                    </p>
                    <?php
                      $p='';
                      if(!empty($business_owner_details['phone'])){
                        $phone=trim($business_owner_details['phone']);
                        if(!empty($phone)){
                          $latest_phone_format= '('.substr($phone,0,3).') '.substr($phone,3,3).'-'.substr($phone,6);
                          $p=substr($latest_phone_format, -1);
                          if($p=='-'){
                            $p=rtrim($latest_phone_format, "-"); 
                          }else{
                            $p=$latest_phone_format;
                          }
                        }
                      }
                    ?>


                    <p class="form-group-row">

                      <label for="phone" class="fleft w_100">Personal Contact</br>(not shared)<span style="color: red;">*</span></label>

                      <input type="text" id="jform_Phone" name="jform_Phone" class="w_300" value="<?=$p?>" />

                    </p>

                    

                    

                    <p class="form-group-row bv_owner_btn" style="text-align: center;">

                      <label for="zip1">

                        <button id="UpdateBusinessProfile" class="m_left_100 cus-btn" type="button" name="update_busowner_info">Update</button>

                      </label>

                    </p>

                    

                </form>
              </div>
              <div class="col-lg-6">
                <img src="https://i.ibb.co/sycr9v7/pexels-yan-krukov-5793953-1.jpg" style=" margin-top: 30px;">
              </div>
            </div>

               

                

              </div>



        </div>

   
     <div id="tab3" class="tab-content">
       
<div class="top-title">
        <h2> Change Password</h2>
         <hr class="center-diamond">
      </div>
          <div id="help_shot" class="container_tab_header header-default-message bv_help_shot" margin-top:10px;>

                 <p>To update the password fill up required and then click on the "Update".</p>

                </div>

        

          <div class="form-group center-block-table">
            <div class="row">
              
                <div class="col-md-6 change-pass-left">
            <h2>Passwords must contain:</h2>
            <li><i class="fa fa-check" aria-hidden="true"></i> Case sensitive</li>
            <li><i class="fa fa-check" aria-hidden="true"></i> Combination of 10-18 letters</li>
            <li><i class="fa fa-check" aria-hidden="true"></i> At least 1 Numbers (0,9)</li>
            <li><i class="fa fa-check" aria-hidden="true"></i> Special characters (!, @, #, $, %, &amp;)</li>
        
              </div>
              <div class="col-lg-6">
  <form id="user-form-password" class="form-validate cus-form-bussness-tab2  center-block-table cus-change-pass" enctype="multipart/form-data" name="adminForm" method="post" action="">

                    <p>

                      <label for="current_pass" class="fleft w_150">Current Password<span style="color:red;">*</span></label>

                      <input type="password" class="w_400" id="current_pass" name="current_pass"  value=""  />

                    </p>

                    

                    <p>

                      <label for="new_pass" class="fleft w_150">New Password<span style="color:red;">*</span></label>

                      <input type="password" class="w_400" id="new_pass" name="new_pass"  value=""  />

                    </p>

                    <span id="error_new_password" style="margin:0px 0px 8px 0; background:#F00; font-weight:bold; color:#fff; padding:1px 8px; width:450px; display:block;  display:none;"></span>

                    <p>

                      <label for="confirm_pass" class="fleft w_150">Confirm Password<span style="color:red;">*</span></label>

                      <input type="password" class="w_400" id="confirm_pass" name="confirm_pass"  value="" />

                    </p>

                    <span id="error_confirm_password" style="margin:0px 0px 8px 0px; background:#F00; font-weight:bold; color:#fff; padding:3px; width:450px; display:block; text-align:center; display:none; float:left"></span>

                    <p>

                      <label for="zip1">

                        <button onclick="UpdateBusinessPassword();return false;" class="m_left_150 cus-btn" type="button">Update</button>

                      </label>

                    </p>


              <?php if($condition_1!=3){ ?>

                <?php } ?>
            </form>
              </div>
      

            </div>

            </div>

            
     </div>
 <div id="tab5" class="tab-content">
  <div class="top-title">
          <h2>Business Logo</h2>
          <hr class="center-diamond">
        </div>
  <form name="frm_banner" id="add_banner_forbuisness" method="post" enctype="multipart/form-data" action="javascript:void(0);" class="uploader">
          <input id="card_img" onchange="loadFile(event)" type="file" name="card_img" accept="image/*">
          <div class="row">
            <div class="col-md-6">          
              <label for="card_img" id="file-drag">
            <img id="file-image" src="#" alt="Preview" class="hidden">
            <div id="start">
              <img src="https://savingssites.com/assets/images/picture.png" style="width: 65px;">
              <div>Drop your image here or Browse Files</div>
              <div id="notimage" class="hidden">Please select an image</div>
              <span id="file-upload-btn" class="btn btn-primary">Browse Files</span>
            </div>
            <div id="response" class="hidden">
              <div id="messages"></div>
              <progress class="progress" id="file-progress" value="0">
                <span>0</span>%
              </progress>
            </div>
          </label></div>
            <div class="col-md-6">

          <div style="width: 100%;" id="showdiv">
            
            <img id="output" style="width: 100%;" class="hide">
            <?php $logoimg = base_url().'/assets/SavingsUpload/Business/'.$businessid.'/'.$logo; ?>
           
            <div id="show_banner" style="background:url('<?= $logoimg ?>');    height: 100%;overflow: hidden;background-size: cover;background-repeat: no-repeat;background-position: center;">
                              
                          </div>
          </div>
            </div>
          </div>
<input type="submit" name="Submit" id="business_image_form" value="Submit" class="bttn cus-btn">
     
        </form>
            <!-- <form action="" method="POST" enctype="multipart/form-data" id="business_image_submit" class="cus-form-buss01 bv_logo_form">
 
  

            <div>

               <div class="green-upload-btn-label">Business Image :</div>

              <?php if(!empty($gallery_images)){

                foreach($gallery_images[0]['logo'] as $gimage){
 
                  $imagePath = explode('/',$gimage['medium_path']);

                  $ImageArray = array_reverse($imagePath);                  

                  $imageName = $ImageArray[0];  

                  ?>

                  <input type="radio" name="business_logo" id="" class="business_logo" value="<?php echo $imageName;  ?>">

                  <img src="<?php echo base_url().'image_gallery/'.$gimage['medium_path']?>" alt="img" height="60" width="60">

                <?php }

                

              }?>

            </div>

            <div>

              <div class="cus-best-result" >For best results upload between 250px and 500px wide image</div>

               <input id="file" type="file" name="userfile" class="business_image_submit" style="display:block;height: 43px;"/>

               <br>       

                <span class="do_upload_audio_loader"  id="spinner_second">

                  <img src="<?php echo base_url() ?>assets/images/loading.gif" style = "margin-top: -20px">

               </span>
 
                <?php  if(! empty($mydetail_businesses[0]['common_logo_image'])){ ?>

                   <div id="upload_business_logos" class="green-upload-btn" style="margin-bottom: 18px;">


                    <div id="dynamic_images">

                      <img  class='image_content' src="<?php echo base_url() . $mydetail_businesses[0]['common_logo_image'] ?>" width="100px" height="100px">
                      <img  class='image_contentnew hide' src="" width="100px" height="100px">

                    </div>

                     <div id="button_delete">

                      <button id="button_delete_data" data-id="<?php echo $business_id;?>" type='button' class='unlink_adsimage' style='height: 30px; width: 30px; border-radius: 15px; padding: 0px 0px 0px 2px; display:none;' onclick='delete_business(this)'>×</button>

                     </div>

                  </div>

                 

                  <p class="submit_business_logo" style="clear: both;margin-left: 200px;">

                    <input type="submit" name="Submit" id="business_image_form" style="width:70px;" value="Submit" class="bttn">

                  </p>



                 <?php } else { ?>
              
                  <p class="submit_business_logo" style="clear: both;margin-left: 200px;">

                    <input type="submit" name="Submit" id="business_image_form" value="Submit" class="bttn"  style="width:70px">

                  </p>

                <?php } ?>

                <input type="hidden" name="hid_business_logos" id="hids_business_logo"/>

                <div id="show_mssgs" style="color:#008000;font-weight:bold;font-size: 19px;margin-left: 298px;margin-top: -31px;"></div>

          </form> -->



        </div> 

 </div>
  </div>


 <!--        <div id="tab4" style="height: 123px;">

  <div class="top-title">
        <h2> Business Logo</h2>
         <hr class="center-diamond">
      </div>

          <div class="sponsor_type" style="float: left; padding: 7px 10px; padding-left: 0;margin-top: 17px">Make Your Business Sponsored:</div>

          <br>

          <?php if($sponsor_business_id){?>

          <button type="checkbox" id="business_sponsored" name="business_checkbox" data-status="0" data-zone-id="<?php echo $zone_id; ?>" data-business-id="<?php echo $business_id_ra; ?>">Make Ad Inactive</button>

          <?php }else{ ?>

          <button type="checkbox" id="business_sponsored" name="business_checkbox" data-status="1" data-zone-id="<?php echo $zone_id; ?>" data-business-id="<?php echo $business_id_ra; ?>">Make Ad Active</button>

          <?php } ?>

          <span class="do_upload_audio_loader" style="display:none;  margin-top: 30px;margin-left: 5px; float:left;" id="spinner_second">

            <img src="<?php echo base_url() ?>assets/images/loading.gif" style = "margin-top: -20px">

          </span>

 </div> -->

<!--   <div id="tab8" class="tab-content"> 
          <form id="add-another-business" class="form-validate" enctype="multipart/form-data" name="" method="post" action="">

                    <p>

                      <label for="business_name" class="fleft w_150">Business Name</label>

                      <input type="text" class="w_300" id="business_name" name="business_name"  value=""  />

                      <div id="error_business_name"></div>

                    </p>

                    

                    <p>

                      <label for="slogan" class="fleft w_150">Motto/Slogan</label>

                      <input type="text" class="w_300" id="slogan" name="slogan"  value=""  />

                      <div id="error_slogan"></div>

                    </p>

                    

                    <p>

                      <label for="street_address" class="fleft w_150">Street Address</label>

                      <input type="text" class="w_300" id="street_address" name="street_address"  value="" />

                      <div id="error_street_name"></div>

                    </p>

                    <p>

                      <label for="contact_phone" class="fleft w_150">Public Contact Phone</label>

                      <input type="text" class="w_300" id="contact_phone" name="contact_phone"  value="" />

                      <div id="error_contact_no"></div>

                    </p>

                    

                    <p>

                      <label for="business">

                        <button onclick="AddAnotherBusiness();return false;" class="m_left_150" type="button">Add</button>

                        <button onclick="backToBusinessDetails();return false;" class="m_left_150" type="button">Back</button>

                      </label>

                    </p>

            </form>
  </div> -->

  </div>
</div>




     

<?php }else if(($condition_1==-1 || $condition_1==-2 || $condition_1==-3) || $condition_2==5){?>

	<div class="main_content_outer"> 

	  <div class="content_container">

		<div class="container_tab_header">Business Detail</div>	

			<div style="font-size:20px; line-height:25px; color:red;">Your business is currently inactive. Please contact your Directory Manager for more details.

        	</div>

	 </div>

   </div>

<?php }?>

<!--  Start of business information modal -->

<div id="businessInformation" title="Business Information" style="display: none;">

  <div id="information-heading">

    <p>Great! We already have some of your business contact information! Update Us and Lets get started.

        We will walk you through and if you need help scream HELP!!! <a href="javascript:void(0)" id="modalInfomationContact">Contact Us</a></p>

      <p>

        1. Please edit/fill in your profile information, and then complete below check list.

      </p>

      <p>

        2. Select your business category(ies). If Restaurant, indicate all cuisines served.

      </p>

      <p>

        3. Use the HTML editor to add offers or just tell public to put SNAP ON for your business as you will email/text offers.

      </p>

      <p>

       4. Upload to your display area a nice .jpeg image of your business. Add any additional .jpeg photos to your photo gallery.

      </p>

      <p>

        5.Set up a Pay for Results Peekaboo Auction:<a href="javascript:void(0)" id="pbooAuctionHere12" onclick="peekaboo_access_button('login')">Here</a>

      </p>

      <p>

6. Restaurants: Review and change the Snap Dining Reservations pre-set, hourly discount percentage schedule: <?php if( $business->type == 1) {?><a href="javascript:void(0)" id="reservationHere"> Here </a><?php }else{?> <a href="javascript:void(0)" id="non_restaurant"> Here </a> <?php } ?>

      </p>

      <p>

        7. Remember to change your temporary password to a very secure password!

      </p>

      <button id="hideMepermanently">Hide me Permanently</button>

  </div>

</div>

<!--  End of business information modal  -->



<div id="showContact" title="Contact us" style="display: none;">

  <div class="col-lg-7 col-md-7 col-sm-7">

    <h1 class="white">Contact Savings Sites!</h1>

        <h2 class="white"><?php echo $business_id_ra; ?> Drop us a line and we will get back to you</h2>

        <form id="contact-form" name="contact-form" method="post" action="">

          <table width="100%" border="0" cellspacing="0" cellpadding="5" class="contactus_table">

            <tr>

              <td width="20%"><label for="name">Name</label></td>

              <td width="65%"><input type="text" class="validate[required,custom[onlyLetter]]" name="name" id="name" value="" /></td>

              <td width="15%" id="errOffset">&nbsp;</td>

            </tr>

            <tr>

              <td><label for="email">Email</label></td>

              <td><input type="text" class="validate[required,custom[email]]" name="email" id="email" value="" /></td>

              <td>&nbsp;</td>

            </tr>

            <tr>

              <td><label for="phone">Phone</label></td>

              <td><input type="text" class="" name="phone" id="phone" value="" /></td>

              <td>&nbsp;</td>

            </tr>

            <tr>

              <td><label for="subject">Subject</label></td>

              <td>

                  <select name="subject" id="subject" style="padding:5px; border:1px solid #ccc; border-radius:4px;">

                    <option value="" selected="selected">- Choose -</option>

                    <option value="Interested in Owning a Savings Sites Zone">Interested in Owning a Savings Sites Zone</option>

                    <option value="My Business is Interested in Advertising">My Business is Interested in Advertising</option>

                    <option value="I have a Suggestion to Improve Savings Sites">I have a Suggestion to Improve Savings Sites</option>

                    <option value="I Want to Propose a Joint Venture">I Want to Propose a Joint Venture</option>

                    <option value="I wish to Report Technical Issue(s)">I wish to Report Technical Issue(s)</option>

                    <option value="Other">Other</option>

                  </select>

                </td>

              <td>&nbsp;</td>

            </tr>

            <tr>

              <td><label for="message">Message</label></td>

              <td><textarea name="message" id="message" class="validate[required]" rows="5"></textarea></td>

              <td>&nbsp;</td>

            </tr>

            <tr>

              <td valign="top">&nbsp;</td>

              <td colspan="2" class="business_reg_btns"><input type="submit" name="button" id="button" value="Submit" class="btn" />
              </td>

            </tr>

          </table>

        </form></div>

        <div id="showrestaurant" title="Reservation">

          <div >Non Restaurant Business</div>

        </div>

</div>
</form></div>
<div style=" position: fixed;top: 0;left: 0;right: 0;bottom: 0;background-color: rgba(0, 0, 0, .5);z-index: 1099;" id="loading" class="hide">
  <img style="position: absolute;left: 50%;top: 50%;margin-left: -16px;margin-top: -16px;" src="https://savingssites.com/assets/images/loading.gif">
</div>

