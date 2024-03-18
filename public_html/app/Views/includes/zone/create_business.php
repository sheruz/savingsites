<input type="hidden" id="businessid" name="businessid" value="<?php echo $businessid;?>"/>
<input type="hidden" id="zoneid" name="zoneid" value="<?php echo $zoneid;?>"/>
<div class="main_content_outer">   
  <div class="content_container">
    <?php if($common['from_zoneid']!='0'){?>
    <div class="spacer"></div>
    <div class="businessname-heading ggg">
      <div class="main main-large main-100">
        <div class="businessname-heading-main">
          <?php if($common['businessid']!='') {  //var_dump($common['approval_message']);exit;?> 
            <font color="#333333">Business Name : </font> 
          <?php } if($common['realtorid']!='') {  //var_dump($common['approval_message']);exit;?> 
            Realtor : 
          <?php } if($common['organizationid']!=''){?> 
            Organization : 
          <?php } ?>  
          <?php
            echo urldecode($common['sub_header_name_from_zone']['name']);
            if($common['organizationid']!=''){
          ?> (<?php
              if($common['zone'][0]['type'] == 0){ ?>Others<?php }else if($common['zone'][0]['type'] == 1){ ?>Municipality<?php }else if($common['zone'][0]['type'] == 2){ ?>Schools<?php }else{ ?>High School Sports<?php } ?>)
              <?php }if($common['businessid']!='') { ?><?=' '.$common['approval_message']?> <?php } ?>
                <a href="<?=base_url()?>Zonedashboard/zonedetail/<?=$common['from_zoneid']?>/0/1" class="fright" style="text-decoration:none">&#8592; Back to Zone Dashboard</a><br/>
              <?php $x = $this->session->userdata('business_search_value');
                if($common['businessid']!='' && $x!= ''){ ?>
                  <a href="<?=base_url()?>Zonedashboard/zonedetail/<?=$common['from_zoneid']?>" class="fright">&#8592; Back to Previous Search</a><br/>
              <?php } ?>
              <?php if($common['from_zoneid']!=0 && $common['businessid']!=''){?>
              <br>
              <select class="fright" style="margin-right: 54px; margin-top: -12px;  height: 26px;" id="goto_different_ads">
                <option value="1">Business Display Filter</option>
                <option value="2"><a href="<?=base_url()?>Zonedashboard/all_business/<?=$common['zoneid']?>" class="fright" style="text-decoration:none">All Business</a> </option>
                <option value="3">Active Real Ads</option>
                <option value="4">Business Coming Soon</option>
                <option value="5">Inactive Ads</option>
              </select>

            <button class="fright" id="different_ads" style="margin-right: -210px; margin-top: -12px;  height: 26px;  width: 38px;"><p style="  margin-top: -2px; margin-left: -6px;">Go</p></button>

         

         <?php 

          }?>

            </div>

        </div>

    </div>

<?php } 

if($common['where_from']=='zone'){?>

  <div class="spacer"></div>

    <div class="businessname-heading fff" style="overflow:hidden;">

      <div class="main main-large main-100">

          <div class="businessname-heading-main">

            <div class="center" style="width:100%">

             <font style="">Search All Businesses (Real Active Ads, Businesses Uploaded, Biz Opp Providers, Inactive Ads)</font> 

            <input type="text" id="global_bus_search" name="global_bus_search" class="text-input" placeholder="Exact business name or phone no. or id" style="" value="<?php echo $this->session->userdata('business_search_value') ?>" />

            <button class="btn-sm"  id="global_bus_search_btn" type="button" style="">Search</button>

            <?php /*?><span style="margin:-10px 20px 0 0; display:none" class="close"><button class="btn-sm global_search_close" type="button" style="padding:7px; width:115px; margin-top:7px;  margin-top: 10px;margin-left: -36px;">Clear Search</button></span><?php */?>

            <button class="btn-sm global_search_close hide_search_result" type="button" style="display:none">Clear Search</button>

            </div>

      <div id="no_bus_found" style="margin-left:15px;" class="fleft w_300"></div>

            </div>

        </div>

        <div id="view_global_bus_search_div" style="width:1130px; margin:10px auto 0; background-color:#d2e08f; display:none; overflow:hidden; padding:10px;">

          <div id="view_global_bus_search" class="fleft" style="width:1080px;"></div>

            <a style="margin:-10px 20px 0 0;" href="javascript:void(0)" class="close" onClick="$('#view_global_bus_search_div').slideToggle();"><img src="<?=base_url('assets/images/close_pop.png') ?>" class="btn_close global_search_close" title="Close Window" alt="Close" ></a>

      </div>

    </div>



<?php } ?>
    <div class="container_tab_header">Create New Business</div>
      <div id="container_tab_content" class="container_tab_content bv_create_bussines">
        <div id="tabs-1_x" class="form-group">
          <div class="form-group ">
            <div id="msg"></div>
              <div class="container_tab_header failure" style="background-color:#d01b13; display:none;">Sorry! Try Again Later.</div>
              <div class="page-subheading">Business Details (<small>The business is created under <?php echo $zonename->seo_zone_name;?></small>)</div>
              <form id="create_business_form" enctype="multipart/form-data" class="form-validate" name="create_business" method="post" action="">
                <input type="hidden" id="userid" name="userid" value=""/>
                <input type="hidden" name="biz_zone_id" id="biz_zone_id" value=""/>
                <span style="color:red">(*)These fields are required </span> 
                <div class="spacer"></div>
                <div id="biz_zone_select" style="display:none;"></div>  
                <div class="spacer"></div>
                <div id="biz_zone_select" style="display:none;"></div>  
                <div class="spacer"></div>
                <p class="form-group-row">
                  <label for="email" class="fleft w_200">Business Name<span style="color:red">*</span>
                  </label>
                  <input type="text" id="biz_name" name="biz_name" class="w_536"  value="" placeholder="Specify Business Name"/>
                  <div id="error_contact_name"></div>
                </p>
                <p class="form-group-row">
                  <label for="biz_motto" class="fleft w_200">Motto/Slogan</label>
                  <textarea id="biz_motto" name="biz_motto" class="w_536" ></textarea>
                </p>
                <p class="form-group-row">
                  <label for="biz_about" class="fleft w_200">About Us</label>
                  <textarea id="biz_about" name="biz_about" class="w_536" ></textarea>
                  <p class="cus-red-text"> <span style="color:red">An “About Us” menu tab will only show on your site if your business fills in About Us contents here; <br>otherwise an About Us menu tab will not appear on your site: </span></p>
                </p>
                <p class="form-group-row">
                  <label for="biz_email" class="fleft w_200">Contact Email<span style="color:red">*</span></label>
                  <input type="text" id="biz_email" name="biz_email" class="w_536" value="" />
                </p>
                <div style="margin-left: 200px;display:none;  background-color: red; border-radius: 7px;width: 245px;" id="email_notice" >
                    <p style="color:white;  margin-left: 12px;"/> Please enter valid Email address </p>
                </div>
                <div class="spacer"></div>
                <p class="form-group-row">
                  <label for="biz_first_name" class="fleft w_200">Contact First Name<span style="color:red">*</span></label>
                  <input type="text" id="biz_first_name" name="biz_first_name" class="w_536 biz_full_name" value="" />
                  <div id="error_contact_firstname"></div>
                </p>
                <p class="form-group-row">
                  <label for="biz_last_name" class="fleft w_200">Contact Last Name<span style="color:red">*</span></label>
                  <input type="text" id="biz_last_name" name="biz_last_name" class="w_536 biz_full_name"  value="" />
                  <div id="error_contact_lastname"></div>
                </p>
                <p class="form-group-row" style="display:none">
                  <label for="biz_full_name" class="fleft w_200">Contact Full Name</label>
                  <input type="text" id="biz_full_name" name="biz_full_name" class="w_536"  value="" />
                </p>
                <p class="form-group-row">
                  <label for="biz_address_1" class="fleft w_200">Street Address</label>
                  <textarea id="biz_address_1" name="biz_address_1" class="w_536" ></textarea>
                </p>
                <div style="display:none;">
                  <p class="form-group-row">
                    <label for="biz_address_2" class="fleft w_200">Street Address 2</label>
                    <textarea id="biz_address_2" name="biz_address_2" class="w_536" ></textarea>
                  </p>
                </div>
                <p class="form-group-row">
                  <label for="biz_city" class="fleft w_200">City</label>
                  <input type="text" id="biz_city" name="biz_city" class="w_536" value="" />
                </p>
                <p class="form-group-row">
                  <label for="address" class="fleft w_200">State</label>
                  <?= form_dropdown("biz_state", $state_list, '', 'id="biz_state"');?>
                </p>
                <p class="form-group-row"><label for="biz_zip_code" class="fleft w_200 m_top_0i">Zip Code<span style="color:red">*</span></label><input type="text" id="biz_zip_code" name="biz_zip_code" class="w_536"  value="" placeholder="Specify Zip Code"/></p>
                <div style="margin-left: 200px;display:none;  background-color: red; border-radius: 7px;width: 245px;" id="zip_error" >
                    <p style="color:white;  margin-left: 12px;"> Please specify zip code </p>
                </div>
                <p class="form-group-row">
                  <label for="biz_phone" class="fleft w_200">Phone Number<span style="color:red">*</span></label>
                  <input type="text" id="biz_phone" name="biz_phone" class="w_536"  value="" placeholder="Enter # (e.g. 555-XXX-XXXX )"/>
                </p>
                <div style="margin-left: 200px;display: inline-block;  background-color: red; border-radius: 0px;width: auto;" id="phone_error" >
                  <p style="color:white;  margin-left: 0px; margin-bottom: 0px; " class="phone_error" /></p>
                </div>
                <p class="form-group-row">

                      <label for="biz_website" class="fleft w_200">Website</label>

                      <input type="text" id="biz_website" name="biz_website" class="w_536"  value="" />



                    </p>

                    <p class="form-group-row">

                    <label for="business_is_restaurant" class="fleft w_200">Business Type</label>

                    <select id="business_is_restaurant" class="fleft w_315">

                      <option value="1">Restaurant</option>

                      <option value="0">Non Restaurant</option>

                    </select>

                  </p>

                    <div style="display:none;">

                    <p class="form-group-row">

                      <label for="biz_sic" class="fleft w_200">SIC Code</label>

                      <input type="text" id="biz_sic" name="biz_sic" class="w_536"  value="" />



                    </p>

                    </div>

                    <!-- <p class="form-group-row">

                      <label for="city" class="fleft w_200 m_top_0i">Business Presentation</label>

                        <input type="checkbox" name="biz_audio_presentation" id="biz_audio_presentation" value="1" checked="checked"/>MP3 Audio  	

						<input type="checkbox" name="biz_video_presentation" id="biz_video_presentation" value="1" checked="checked"/>You Tube Video



                    </p>-->

                    

                    <div class="spacer"></div>

                    <div class="page-subheading" style="padding-top:15px;">Business Advertiser Details</div>

                     <div class="spacer"></div>

                    <p class="form-group-row" style="display: none;">

                        <label for="biz_owner" class="fleft w_200 m_top_0i">Business Advertiser</label>                        

                        <input type="radio" name="owner_account" id="new_account_new"  value="2" checked="checked"/>New Business

                        <input type="radio" name="owner_account" id="owner_account_existing"  value="3" disabled="disabled"/>Existing Business

                        <input type="radio" name="owner_account" id="owner_account_my" value="1"/>Zone Owner

                    </p>

                    <div class="spacer"></div>

                    <div class="bona">

                        <p class="form-group-row">                    	

                          <label for="biz_username" class="fleft w_200">Username</label>

                          <input type="text" id="biz_username" name="biz_username" class="w_536" value="" readonly="readonly" />

                          

                        </p>

                         <span id="error_username" style="margin:0px 170px 8px 0; background:#F00; font-weight:bold; color:#fff; padding:3px; width:550px; display:block; text-align:center; display:none; float:right"></span>

                        <span id="error_uname" style="margin:0px 85px 8px 0; background:#F00; font-weight:bold; color:#fff; padding:3px; width:550px; display:block; text-align:center; display:none; float:right"></span> <span id="success_uname" style="font-weight:bold; color:#fff; margin:0 0 0 232px; background:#063; padding:3px; width:550px; display:block; text-align:center;display:none"></span>

                        <div class="spacer"></div>

                        <p class="form-group-row">                    	

                         <label for="biz_password" class="fleft w_200">Password<span style="color:red">*</span>  </label>

                         <input type="text" id="biz_password" name="biz_password" class="w_536" value="" placeholder="Specify Password" style="width:370px;"/>

                         <button id="create_generate_password" type="button">Generate Password</button>
                         <p class="cus-red-text"><span style="color:red">Case sensitive, combination of 5-18 letters, numbers and special characters (!, @, #, $, %, &) </span></p>

                        </p>

                        

                       <!--  <span id="error_password" style="margin:0px 170px 8px 0; background:#F00; font-weight:bold; color:#fff; padding:3px; width:550px; display:block; text-align:center; display:none; float:right"></span> -->

                        <div style="margin-left: 200px;display:none;  background-color: red; border-radius: 7px;width: 245px;" id="password_error" >

                          <p style="color:white;  margin-left: 12px;" class="password_error" /></p>

                        </div>

                        <div class="spacer"></div>

                    </div>

                    <div class="spacer"></div>

                    <!-- + For Existing Business Owner-->

                    <div class="boea" style="display:none;"></div>

                    <!-- - For Existing Business Owner-->

                    <div class="spacer"></div>

                    <div class="page-subheading" style="padding-top:15px;">Business Advertisement Details</div>

                    <p class="form-group-row" style="display:none;">

                      

                        <label for="biz_mode" class="fleft w_200 m_top_0i">Business Mode</label>

                        <input type="radio" name="biz_mode" id="biz_mode_normal" value="1" checked="checked"/>Non Business Opportunity Providers

                        <?php  if($delete_cat_byindustry == 1){	

						?>

                        <input type="radio" name="biz_mode" id="biz_mode_franchisee"  value="2"/>Business Opportunity Providers<br />

                        

                        <?php  } ?>

                    </p>



                  



                    <div class="spacer"></div>

                    <div id="get_business_mode" style="display:none;"></div>

                    <div class="spacer"></div>

                    <div id="get_category" style="display:none;"></div>

                    <div class="spacer"></div>

                    <div id="get_subcategory" style="display:none;"></div>  

                    <div class="spacer"></div> <br />

                                     

                    <p class="form-group-row">

                      <label for="city" class="fleft w_200">Starter Ad<span style="color:red">*</span></label>

                      <span class="fleft dis_block">                      

                        <textarea id="stater_ad_message" name="stater_ad_message" >

                        <p align="center" class="MsoNormal" style="text-align: center;"><b><span  style="font-size: 18.0pt; color: #1F497D;">We have not had a chance to post all our offers in the system-<br><br>Please Contact Us for Our Offer!</span></b><br><br><br><span style="color:#000; font-size:20px">If you would like SavingsSites to contact the business on your behalf to ask them to post their offer, </span><span style="font-size:18px"><a href="#starter-ad-popup" style="text-decoration: underline;" class="starter_ad_click"><span style="color:red">click here</span></a></span></p>

                        </textarea>

                		         <?php echo display_ckeditor($ckeditor_staterad); ?> 

                        </span>

                    </p>

                    <div class="spacer"></div>

                    <p class="form-group-row">

                   <label for="biz_sic" class="fleft w_200">Start Date Time</label>

                   <input type="text" id="ad_startdatetime" name="ad_startdatetime" class="w_536"  value="" placeholder="Specify Start Date/Time For Advertisement"/>

                    </p>

                    <div class="spacer"></div>

                    <p class="form-group-row">

                      <label for="biz_sic" class="fleft w_200">Stop Date Time</label>

                      <input type="text" id="ad_stopdatetime" name="ad_stopdatetime" class="w_536"  value="" placeholder="Specify End Date/Time For Advertisement"/>    

                    </p>

                     <p id="deliver" class="form-group-row" style="display:none;">   <!--Added on 14/8/14-->

                          <label for="deliver" class="fleft w_200">We Deliver</label>

                          <input type="radio" name="deliver" id="yes" value="1"/> Yes

                           <input type="radio" name="deliver" id="no" value="0" checked="checked"/> No

                    </p> 
                    <p class="form-group-row">
                      <label for="biz_sic" class="fleft w_200">ServiceNumber(Amazon Contact number)</label>
                      <input style="max-width: 100%!important;width: 61%!important;margin-right: 7px;" type="number" id="service_number" name="service_number" class="w_536"  value="" title="Please Enter Service Number"/>    
                    </p>
                    <p class="form-group-row" id="image_upload_div">

                      <label for="biz_sic" class="fleft w_200">Upload Greetings<br> (mp3, wav)</label>

                      <input style="max-width: 100%!important;width: 61%!important;margin-right: 7px;" type="file" id="file" name="file" class="w_536"  value="" title="Greeting Format Must be MP3,WAV" onchange="javascript:uploadFile()"/>    

                    </p>
                   



                      <p class="form-group-row miles"  style="display:none;">

                      

                        <label for="miles" class="fleft w_200">What is the furthest<br> number of miles from your Restaurant that you deliver?  </label> 

                        <input type="text" name="miles" id="estimated_mile" value=" " placeholder="Number of Miles: "  /> <br/>


                       

 

                    </p>
                     <p class="form-group-row miles"  style="display:none;">
                         <label for="miles" class="fleft w_200">Delivery Charges  </label> 

                       <input type="text" name="deliveryCharges" class="deliveryCharges" placeholder="delivery Charges:">
                     </p>

                     <p class="form-group-row miles"  style="display:none;">
                         <label for="miles" class="fleft w_200">Delivery Time Period  </label> 


                             <select name="deliveryTime" id="deliveryTime">
                                 <option value="">Select the Delivery Time</option>
                                <?php for ($i = 0; $i <= 120; $i+=10) { ?>

                                   <option value="<?php  echo $i; ?>"><?php  echo $i; ?> Minutes</option>   
                                <?php }  ?>  </select>


                     </p>



                    <p class="form-group-row">

                      <label for="button_save">

											<input type="checkbox" id="biz_profile_check" name="biz_profile_check" value="1" checked> Go To Business Profile<br>

                        <button id="create_business" class="m_left_200" type="button">Create Business</button>

											<button id="reset" type="button">Reset</button>

                      </label>

                    </p>

                    <div class="spacer"></div>

                   <!-- <div class="container_tab_header success" style="background-color:#859731; display:none;">You have successfully created the business.</div>-->

                	<div class="container_tab_header failure" style="background-color:#d01b13; display:none;">Sorry! Try Again Later.</div>

                    <div class="spacer"></div>

              	</form>

              </div>



        </div>

        

        

    </div>

    

    

</div>



</div>
<div style=" position: fixed;top: 0;left: 0;right: 0;bottom: 0;background-color: rgba(0, 0, 0, .5);z-index: 1099;" id="loading" class="hide">
  <img style="position: absolute;left: 50%;top: 50%;margin-left: -16px;margin-top: -16px;" src="<?= base_url(); ?>/assets/images/loading.gif">
</div>
<script type="text/javascript">
$(document).ready(function () {
  $('#zone_business_accordian').click();
  $('#zone_business_accordian').next().slideDown();
  $('#zone_create_business').addClass('active');
  $('.bona').show();
  $('#biz_mode_normal').click();
});

// + Datepicker for start time stop time
$("#ad_startdatetime,#ad_stopdatetime").live('focus',function(){
  $(this).datetimepicker({
    changeMonth: true,
    changeYear: true,
    dateFormat:'mm-dd-yy'
  });
});

// check for valid email checking
$('#biz_email').blur(function(){ 
  $('#biz_email').filter(function(){
    var email=$('#biz_email').val();
    var emailReg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if( !emailReg.test(email)){
        $('#email_notice').slideDown();
        $('#biz_email').focus();
    }else{
        $('#email_notice').slideUp('slow');
    } 
  })
});

// + for changing Business Owner part start
$(document).on('change','input[name=owner_account]',function(){ 
  var tag=$(this).val();
  if(tag==1){
    $('.bona').hide();
    $('.boea').hide();
    $('#biz_username').val('');
    $('#biz_password').val('');
    $('span#error_uname').hide();
    $('span#success_uname').hide();
  }else if(tag==2){
    $('.bona').show();
    $('.boea').hide();
  }else if(tag==3){
    $('.bona').hide();
    $('.boea').show();
  }
});

$(document).on('click','#owner_account_existing',function(){
  var zoneid=$('#zoneid').val(); //alert(zoneid);
  var data={'zoneid':$('#zoneid').val()};
  PageMethod("<?=base_url('Zonedashboard/existing_business_owner_for_zone')?>", "", data, EBOSuccess, null); 
});

function EBOSuccess(result){
  $.unblockUI();
  if(result.Tag!=''){
    $('.boea').show();
    $(".boea").html(result.Tag);		
  }
}

// + for Business Mode part start
$(document).on('click','input[name=biz_mode]',function(){ 	
  var biz_mode=$(this).val();  
  var zoneid=$('#zoneid').val();
  var data={'zoneid':zoneid,'biz_mode':biz_mode};
  PageMethod("<?=base_url('Zonedashboard/business_mode_for_create_business')?>", "", data, BizModeSuccess, null);
});

function BizModeSuccess(result){
  $.unblockUI();
  if(result.Tag!=''){
    $("div#get_business_mode").show();
    $("div#get_business_mode").html(result.Tag);
    $('#biz_type').change();
  }
}

// + for Business Mode part end
$(document).on('change','#business_is_restaurant',function(){
  $('#biz_type').change();
  if($(this).val() == 1){
    $('#image_upload_div').removeClass('hide');
    $("#file").val(null);
  }else{
    $('#image_upload_div').addClass('hide');
    $("#file").val(null);
  }
});

// + for Business Type part start
$(document).on('change','#biz_type',function(){
  var tag=$(this).val();
  var zoneid=$('#zoneid').val();
  var business_is_restaurant=$('#business_is_restaurant').val();
  var biz_mode=$("input[name=biz_mode]:checked").val(); 
  if(tag != 3 && tag ==''){
    CKEDITOR.instances.stater_ad_message.setData('');
  }
  else if(tag != 3 && tag !=''){
    //CKEDITOR.instances.stater_ad_message.setData('');
  }else{
    CKEDITOR.instances.stater_ad_message.setData('<p align="center" class="MsoNormal" style="text-align: center;"><b><span  style="font-size: 18.0pt; color: #1F497D;">We have not had a chance to post all our offers in the system-<br><br>Please Contact Us for Our Offer!</span></b><br><br><br><span style="color:#000; font-size:20px">If you would like SavingsSites to contact the business on your behalf to ask them to post their offer, </span><span style="font-size:18px"><a href="#starter-ad-popup" style="text-decoration: underline;" class="starter_ad_click"><span style="color:red">click here</span></a></span></p>');
  }
  var data={'biz_type':tag,'zoneid':zoneid,'biz_mode':biz_mode,'business_is_restaurant':business_is_restaurant};	
  PageMethod("<?=base_url('Zonedashboard/category_for_create_business')?>", "", data, CatCreateBusinessSuccess, null);
});

function CatCreateBusinessSuccess(result){
  $.unblockUI();
  if(result.Tag!=''){
    $("div#get_category").show();
    $("div#get_category").html(result.Tag);
    $('#main_category').change();
  }
}

// + for getting subcategory againest any category
$(document).on('change','#main_category',function(){ 
  var catid=$('#main_category').val(); 
  var zoneid=$('#zoneid').val();
  var data={'catid':catid,'zoneid':zoneid};	
  if(catid!=undefined)
    PageMethod("<?=base_url('Zonedashboard/subcat_for_create_business')?>", "", data, catsuccess, null);
});

function catsuccess(result){ 
  $.unblockUI();
  if(result.Title ==1){
    $('#main_category').attr('disabled', true);
  }else{
    $('#main_category').attr('disabled', false);
  }
  if(result.Tag!=''){
    $("div#get_subcategory").show();
    $("div#get_subcategory").html(result.Tag);
    var catid = result.Title; 
    if(catid==1){
      $('#deliver').show();
    }else{
      $('#deliver').hide();
    }
  }
}

// + for verify Username
$(document).on('blur','#biz_username',function(){
  var userame=$(this).val();
  if(userame==''){
    $('#success_uname').hide();
    return false;
  }
  var username = userame.replace(/-/g,'');
  var regex = new RegExp("^[a-zA-Z0-9.]*$"); 
  if(regex.test(username) !== true){ 
    $('#error_uname').html(userame+" must not contain special characters.");
    $('#error_uname').show();
    return false;
  }
  var data = { "user_name": userame};
  PageMethod("<?=base_url('Zonedashboard/add_business_check_username')?>", "Verify the username <br/>This may take a few minutes", data, showusername, null);
});

function showusername(result){
  $.unblockUI();
  if(result.Tag=='0'){
    $('#error_uname').html('This Username is already exist.<br/> Please try with another user name.' );
    $('#error_uname').show();
    $('#success_uname').hide();
    $("#userName").val('');	
    $("#password").val('');
    $('#biz_username').focus();
    return false;
  }else{
    $('#error_uname').hide();
  }
}

// + For Phone Number Display in Username
$(document).on('blur','#biz_phone',function(){
  var phone_int=$(this).val().replace(/[^0-9]/gi, '');
  if(phone_int==''){
    $('#phone_error').slideDown();
    $('p.phone_error').html('Please specify phone number');
    $('#biz_phone').focus();
    $('#biz_username').val('');
    return false;
  }
  $.ajax({
    type:'POST',
    url:"<?=base_url('Zonedashboard/add_business_check_username')?>",        
    data:{'user_name': phone_int},
    success: function(result) { 
      $.unblockUI();          
      if(result=='0'){
        $('#phone_error').slideDown();
        $('p.phone_error').html('This phone number is already exist');
        $('#biz_phone').focus();
        $('#biz_username').val('');
        return false;
      }else{
        $('#phone_error').slideUp('slow');
        $('p.phone_error').html('');
        var phone_int=$('#biz_phone').val();//alert(phone_int);
        $('#biz_username').val(phone_int);
      }
    }
  });
});

// - For Phone Number Display in Username
$(document).on('click','#create_generate_password',function(){ 
  PageMethod("<?=base_url('Zonedashboard/create_generate_password_org')?>", "Creating The Password...<br/>This may take a few minutes", null, showPasswordBus, null);
});

function showPasswordBus(result){
  $.unblockUI();
  if(result.Tag!=''){				
    $("#biz_password").val(result.Tag);
  }
}

function select_zone_value(){
  var zoneid = $('#zip_to_zone').val();
  $('#biz_zone_id').val(zoneid);
}

$('#biz_profile_check').change(function(){
  if($(this).attr('checked')){
    $(this).val('1');
  }else{
    $(this).val('0');
  }
});

$(document).on('click','#create_business',function(){
  if($("#biz_zip_code").val()=='' || $("#biz_zone_id").val()=='-1'){
    alert(' Please specify valid Zip Code');
    return false;		
  }else if($("#biz_name").val()==''){
    alert(' Please specify Business Name');
    return false;
  }
  if($("#biz_first_name").val()==''){
    alert("Please specify first name.");
    return false;
  }
  if($("#biz_last_name").val()==''){
    alert("Please specify last name.");
    return false;
  }
  if($("#biz_phone").val()!=''){
    if($("#biz_phone").val().length<12){
      alert("Please specify valid phone no.");
      return false; 
    }
  }else{
    alert("Please specify phone no.");
    return false;
  }
  if($("input[name=owner_account]:checked").val()==2 && $('#biz_username').val()==''){
    alert("Please specify Username.");
    return false;
  }
  if($("input[name=owner_account]:checked").val()==2 && $('#biz_password').val()==''){
    alert("Please specify Password.");
    return false;
  }
  var password = $('#biz_password').val();
  var regex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%#&])[A-Za-z\d$@$!%#&]{5,}$/; 
  if(password.length < 5 || password.length > 18){
    return false;
  }else if(!regex.test(password)){
    return false;
  }
  var audio_presentation=$("input[name=biz_audio_presentation]:checked").val(); 
  if(audio_presentation==undefined){
    audio_presentation=0;
  }
  var video_presentation=$("input[name=biz_video_presentation]:checked").val(); 
  if(video_presentation==undefined){
    video_presentation=0;
  }
  var display_cat_subcat='';	
  $('.optiondropdown:selected').each(function(i, j){ 			
    display_cat_subcat+=$(j).val()+','; 
  });
  display_cat_subcat=display_cat_subcat.substring(0,display_cat_subcat.length-1);
  if($('#main_category').val()=='' || display_cat_subcat==''){
    alert("Please specify Category/Sub-category.");
    return false;
  }
  if(CKEDITOR.instances.stater_ad_message.getData() == ''){
    alert("Please specify Starter Ad.");
    return false;
  }
  var deliver ;
  if($('#yes').prop('checked') ){
    deliver = 1;
    jQuery('.miles').css("display" , 'block');
  }else if($('#no').prop('checked')){
    deliver = 0;
    jQuery('.miles').css("display" , 'none');
  } 
  var phone_int=$("#biz_phone").val().replace(/[^0-9]/gi, '');
  var data = {
    id : "-1",
    zipcode : '<?php echo $zipcode[0]['zip_code'];?>',
    zone_id : <?php echo  $zoneid; ?>,
    name: $("#biz_name").val(),
    motto: $("#biz_motto").val(),
    aboutus: $("#biz_about").val(),
    contactemail : $("#biz_email").val(),
    contactfirstname : $("#biz_first_name").val(),
    contactlastname : $("#biz_last_name").val(),
    contactfullname : $("#biz_full_name").val(),
    street1 : $("#biz_address_1").val(),
    street2 : $("#biz_address_2").val(),
    city : $("#biz_city").val(),
    state : $("#biz_state").val(),
    phone : $("#biz_phone").val(),
    phone_int : phone_int,
    website : $("#biz_website").val(),
    restaurant_type:$('#business_is_restaurant').val(),
    siccode : $("#biz_sic").val(),
    audio_presentation : audio_presentation,
    video_presentation : video_presentation, 
    owner_account : $("input[name=owner_account]:checked").val(),
    biz_username : $('#biz_username').val(),
    biz_password : $('#biz_password').val(),
    existing_bo : $('#ebo').val(),
    biz_mode : $("input[name=biz_mode]:checked").val(), 
    biz_type : $('#biz_type').val(),
    catid : $('#main_category').val(),	
    subcatid : display_cat_subcat,
    stater_ad : CKEDITOR.instances.stater_ad_message.getData(),
    ad_stopdatetime:$("#ad_stopdatetime").val(),
    ad_startdatetime:$("#ad_startdatetime").val(),
    biz_profile_check : $('#biz_profile_check').val(),
    deliver : deliver  , 
    miles : $('#estimated_mile').val(),
    deliveryTime: $('#deliveryTime').val(),
    deliveryCharges : $('.deliveryCharges').val(),
    audio_greetings: $('#biz_first_name').attr('audio_greetings'),
    service_number: $('#service_number').val(),
  };
  $('#create_business').attr("disabled",true);
  PageMethod("<?=base_url('Zonedashboard/create_business')?>", "Saving Business Data<br/>This may take a few minutes", data, BizSaveSuccessful, null);
});

  function uploadFile() {
    var form_data = new FormData();
    var file_data1 = $('#file').prop('files')[0];
    form_data.append('file', file_data1);
    $.ajax({
      url: "<?=base_url('Zonedashboard/upload_business_greetings')?>", 
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      type: 'post',
      dataType: "json",
      beforeSend: function() {
        $("#loading").removeClass('hide');
      },
      complete: function() {
        $("#loading").addClass('hide');
      },
      success: function (r) {
        if(r.type == 'success'){
          var file_name = r.data;
          $('#biz_first_name').attr('audio_greetings', file_name);
        }
        if(r.type == 'error'){
          alert(r.msg);
        }
      }
    });
  }

function BizSaveSuccessful(result){
  $.unblockUI();
  if(result.Tag == 1){
    $('#create_business').removeAttr("disabled", false);
    $("#biz_zip_code").val('');
    $("#biz_zone_id").val('');
    $('#biz_zone_select').val(''); 
    $("#biz_name").val('');
    $("#biz_motto").val('');
    $("#biz_email").val('');
    $("#biz_first_name").val(''); 
    $("#biz_first_name").val(''); 
    $("#biz_last_name").val('');
    $("#biz_full_name").val('');
    $("#biz_address_1").val('');         
    $("#biz_address_2").val(''); 
    $("#biz_city").val('');
    $("#biz_state").val(''); 
    $("#biz_phone").val(''); 
    $("#biz_website").val('');
    $("#biz_sic").val(''); 
    $("input[name=owner_account]:checked").val('');
    $('#biz_username').val('');
    $('#biz_password').val(''); 
    $('#ebo').val('');
    $("input[name=biz_mode]:checked").val('');
    $('#biz_type').val('');
    $('#main_category').val('');
    $("#ad_stopdatetime").val('');
    $("#ad_startdatetime").val('');
    $('#biz_zone_id').val($('#zip_to_zone option:selected').remove(''));
    CKEDITOR.instances.stater_ad_message.setData('');
    $('#biz_zone_select').find('p').hide() ;
    $('#msg').html('<h4 style="color:#090">You have successfully created the business.</h4>').show();
    $('html,body').animate({scrollTop:0},"slow");
    setTimeout(function(){$("#msg").hide('slow'); },3000); 
  }else if(result.Tag != 1){
    var businessId = result.Tag;
    var zoneId = <?php echo  $zoneid; ?>;
    var url = "<?php echo base_url('')?>"; 
    window.location.href = url+"businessdashboard/businessdetail/"+businessId+"/"+zoneId;
  }
}

$(document).on('click','#reset',function(){
  location.reload();
});

$(function (){
  $("#biz_phone").mask("999-999-9999",{placeholder:' '});
});

$(document).on('blur','#biz_password',function(){
  var password = $(this).val();
  if(password==''){
    $('#password_error').slideDown();
    return false; 
  }
  var regex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%#&])[A-Za-z\d$@$!%#&]{5,}$/; 
  if(password.length < 5 || password.length > 18){
    $('#password_error').slideDown();
    $('p.password_error').html("Password should be between 5 to 18 characters");
    return false;
  }else if(!regex.test(password)){ 
    $('#password_error').slideDown();
    $('p.password_error').html("Password should be combination of letters, numbers and special characters (!, @, #, $, %, &)");
    return false;
  }else{  
    $('#password_error').slideUp('slow');
  }
});

$('#deliver input[type=radio]').change(function() {
  if (this.value == '1') {
    jQuery('.miles').css("display" , 'block');
  }else{
    jQuery('.miles').css("display" , 'none');
  }
});
</script>
<style type="text/css">
  select{
    width: 61% !important;
    max-width: 100%;
}
.cus-red-text{
  text-align: left;
    position: relative;
    top: -10px;
    font-size: 11px;
    line-height: 16px;
    margin-left: 203px;
}
</style>