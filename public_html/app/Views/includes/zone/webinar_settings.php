 

<script type="text/javascript">

 


/* Save New Category */

function save_webinar_setting(){
 
		var dataToUse = {

			"zoneid":$("#zoneid").val(),

			"braintree_merchant_id":$('#braintree_merchant_key').val(),

      "braintree_private_id":$('#braintree_private_key').val(),

      "braintree_public_id":$('#braintree_public_key').val(),

			"paypal_emailid": $("#paypal_emailid").val(),

			"payment": $(".payment").val(),

      'business_charge':$("#business_charge").val(),
 

		}; 


  PageMethod("<?=base_url('Zonedashboard/save_webinar_setting')?>", "Processing...<br/>This may take a minute.", dataToUse, weblinkSuccess, null);
}



function weblinkSuccess(result){

	$.unblockUI();

	var message = result.Message;

	var title = result.Title;

	var txt = '';

	  $("#msg").html(txt).show();

	  $("#msg").show();

	  $("#webinar_link").val('');

	  $("#description").val('');

	  $('html,body').animate({scrollTop:0},"slow");

	  setTimeout(function(){$("#msg").hide('slow');},3000);

}

</script>
 

<input type="hidden" name="zoneid" id="zoneid" value="<?=$common['zoneid']?>" />

<input type="hidden" name="zoneid" id= "business_id" value="<?= $common['businessid']?>">



<?php 

$condition_1 = $common['approval']['approval'] ;  // Represents the approval status of the business

$condition_2 = $common['usergroup']->group_id ;	  // Represents the user group id--> for zone_owner -> 4 ;for business_owner -> 5	

	

//if(($condition_1==1 || $condition_1==2 || $condition_1==3) || ($condition_2==4 || $condition_2==5)){

if(($condition_1==1 || $condition_1==2 || $condition_1==3) || ($condition_2==4)){

?>



<div class="content_container">

				 <?php if($common['from_zoneid']!='0'){ ?>

<div class="spacer"></div>

  <div class="businessname-heading">

      <div class="main main-large main-100">

          <div class="businessname-heading-main">

            <?php if($common['businessid']!='') {  //var_dump($common['approval_message']);exit;?> 

            <div style="float:left;"><font color="">Business Name : </font> <div class="oswald" style="font-size:26px; line-height:initial;">

      <?php } ?>  

             <?php if($common['realtorid']!='') {  //var_dump($common['approval_message']);exit;?> 

            Realtor : 

      <?php } ?>  

            

         <?php /*?>   <?php if($common['sub_header_name_from_zone']['id']!=''){ ?>

            Realtor : <?php echo urldecode($common['sub_header_name_from_zone']['name']); ?>

            <?php } ?>    <?php */?>

            <?php if($common['organizationid']!=''){//echo '<pre>';var_dump($common['zone'][0]['type']);exit;?> <?php /*if($common['zone'][0]['type'] == 2){ ?>High School Sports :<?php }else{ */?>Organization : <?php /*}*/ ?><?php } ?>  

      <?php

       echo urldecode($common['sub_header_name_from_zone']['name']);

       if($common['organizationid']!=''){

       ?> (<?php

        if($common['zone'][0]['type'] == 0){ ?>Others<?php }else if($common['zone'][0]['type'] == 1){ ?>Municipality<?php }else if($common['zone'][0]['type'] == 2){ ?>Schools<?php }else{ ?>High School Sports<?php } ?>)

            <?php }if($common['businessid']!='') { ?><?= ' '.$common['approval_message']?> <?php } ?>

          </div>

          </div>

              <a href="<?=base_url()?>Zonedashboard/zonedetail/<?=$common['from_zoneid']?>/0/1" class="fright" style="text-decoration:none">&#8592; Back to Zone Dashboard</a><br/>

                <?php 

        $x = $this->session->userdata('business_search_value');

        if($common['businessid']!='' && $x!= ''){ ?>

                <a href="<?=base_url()?>Zonedashboard/zonedetail/<?=$common['from_zoneid']?>" class="fright">&#8592; Back to Previous Search</a><br/>

                <?php } ?>
 

            <?php if($common['from_zoneid']!=0 && $common['businessid']!=''){ ?>

            <br>
 
 

         <?php 

          }?>

            </div>

        </div>

    </div>

<?php } 

if($common['where_from']=='zone'){?>

  <div class="spacer"></div>

    <div class="businessname-heading" style="overflow:hidden;">

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

	<div class="container_tab_header">Enter Webinar Settings</div>

    <div id="msg"></div>
 

	<div id="container_tab_content" class="container_tab_content">

        <div id="tabs-2_y">

        	<div id="msg" style="display:none;margin-top:7px;"></div>

        <div class="form-group center-block-table cus-form-table">

            <p>

            	<div id="new_category" class="bv_new_webnier">
 
                  <div class="paid boxes">
                    
 
                     <label for="biz_sic" class="fleft w_150">Enter Paypal ID</label>

                   <input type="text" id="paypal_emailid"   class="w_300"  value="<?php if(@$settingdata[0]['paypal_id']){ echo @$settingdata[0]['paypal_id'];  } ?>"  />
 
                  </div>

  
                 <div id="div1" class="cus-padding-top">

                   <label for="webinar_link" class="fleft w_150">Enter Branitree Merchant Key</label>

                      <input type="text" value="<?php if(@$settingdata[0]['braintree_merhant_key']){ echo @$settingdata[0]['braintree_merhant_key'];  } ?>" id="braintree_merchant_key" name="braintree_merchant_key" placeholder="" class="w_300"/><br /><br />

                          <label for="webinar_link" class="fleft w_150">Enter Branitree Private  Key</label>

                      <input type="text" id="braintree_private_key"  value="<?php if(@$settingdata[0]['braintree_private_key']){ echo @$settingdata[0]['braintree_private_key'];  } ?>" name="braintree_private_key" placeholder="" class="w_300"/><br /><br />

                          <label for="webinar_link" class="fleft w_150">Enter Branitree Public Key</label>

                      <input type="text" id="braintree_public_key" value="<?php if(@$settingdata[0]['braintree_public_key']){ echo @$settingdata[0]['braintree_public_key'];  } ?>" name="braintree_public_key" placeholder="" class="w_300"/><br /><br />


                          <label for="webinar_link" class="fleft w_150">Enter charge Percentage <br/> (For Business<br/> Users only)</label>

                      <input type="number" id="business_charge" value="<?php if(@$settingdata[0]['business_charge']){ echo @$settingdata[0]['business_charge'];  } ?>" name="business_charge" placeholder="" class="w_300"/><br /><br /><br /><br />


                      <label for="webinar_link" class="fleft w_150">Select the payment options</label>

                       <select class="payment">
                        <option <?php if(@$settingdata[0]['payment_option'] == ' '){ echo 'selected=selected';  } ?>   value="" >Select Any Option </option>
                        <option <?php if(@$settingdata[0]['payment_option'] == 'OT'){ echo 'selected=selected';  } ?> value="OT" >Group Tutoring </option>
                        <option  <?php if(@$settingdata[0]['payment_option'] == 'PP'){ echo 'selected=selected';  } ?>  value="PP" >Per Person</option>
                        <option <?php if(@$settingdata[0]['payment_option'] == 'MC'){ echo 'selected=selected';  } ?>  value="MC" >Monthly Charge</option>
                      </select>
 
                    <p>
                      <br/>

                        <button class="m_left_150" onclick="save_webinar_setting()">Save</button>
               

                    </p>

                    </div>

                </div>

            </p>

        </div>

        </div>

    	</div>

    </div>

</div>

 <?php }else if(($condition_1==-1 || $condition_1==-2 || $condition_1==-3) || $condition_2==5){ ?>

<div class="main_content_outer"> 

<div class="content_container">

				 <?php if($common['from_zoneid']!='0'){?>

<div class="spacer"></div>

  <div class="businessname-heading">

      <div class="main main-large main-100">

          <div class="businessname-heading-main">

            <?php if($common['businessid']!='') {  //var_dump($common['approval_message']);exit; ?> 

            <div style="float:left;"><font color="">Business Name : </font> <div class="oswald" style="font-size:26px; line-height:initial;">

      <?php } ?>  

             <?php if($common['realtorid']!='') {  //var_dump($common['approval_message']);exit;  ?> 

            Realtor : 

      <?php } ?>  

            

         <?php /*?>   <?php if($common['sub_header_name_from_zone']['id']!=''){ ?>

            Realtor : <?php echo urldecode($common['sub_header_name_from_zone']['name']); ?>

            <?php } ?>    <?php */?>

            <?php if($common['organizationid']!=''){//echo '<pre>';var_dump($common['zone'][0]['type']);exit;?> <?php /*if($common['zone'][0]['type'] == 2){ ?>High School Sports :<?php }else{ */?>Organization : <?php /*}*/ ?><?php } ?>  

      <?php

       echo urldecode($common['sub_header_name_from_zone']['name']);

       if($common['organizationid']!=''){

       ?> (<?php

        if($common['zone'][0]['type'] == 0){ ?>Others<?php }else if($common['zone'][0]['type'] == 1){ ?>Municipality<?php }else if($common['zone'][0]['type'] == 2){ ?>Schools<?php }else{ ?>High School Sports<?php } ?>)

            <?php }if($common['businessid']!='') { ?><?= ' '.$common['approval_message']?> <?php } ?>

          </div>

          </div>

              <a href="<?=base_url()?>Zonedashboard/zonedetail/<?=$common['from_zoneid']?>/0/1" class="fright" style="text-decoration:none">&#8592; Back to Zone Dashboard</a><br/>

                <?php 

        $x = $this->session->userdata('business_search_value');

        if($common['businessid']!='' && $x!= ''){ ?>

                <a href="<?=base_url()?>Zonedashboard/zonedetail/<?=$common['from_zoneid']?>" class="fright">&#8592; Back to Previous Search</a><br/>

                <?php } ?>

      <?php /*?><?php if($common['view_next_previous'] == 1){ ?>

                <a href="javascript:void(0);" id="previous_ad_change_category_for_business" class="fleft" data-businessid="<?=$common['businessid']?>" data-zoneid="<?=$common['from_zoneid']?>">&#8592; Go To previous Business To Assign Category</a>

                <a href="javascript:void(0);" id="next_ad_change_category_for_business" class="fright" data-businessid="<?=$common['businessid']?>" data-zoneid="<?=$common['from_zoneid']?>">Go To Next Business To Assign Category &#8594;</a>

            <?php } ?> <?php */?>  

            <?php if($common['from_zoneid']!=0 && $common['businessid']!=''){?>

            <br>

            <select class="fright" style="margin-right: 36px; margin-top: -12px;  height: 26px;" id="goto_different_ads">

            <option value="1">Business Display Filter</option>

            <option value="2"><a href="<?=base_url()?>Zonedashboard/all_business/<?=$common['zoneid']?>" class="fright" style="text-decoration:none">All Business</a> </option>

            <option value="3">Active Real Ads</option>

            <option value="4">Business Coming Soon</option>

            <option value="5">Inactive Ads</option>

            </select>

            <button class="fright" id="different_ads" style="margin-right: -256px; margin-top: -12px;  height: 26px;  width: 38px; background: #7b498f; border: none;"><p style="margin-top: -4px; margin-left: -6px;">Go</p></button>

         

         <?php 

          }?>

            </div>

        </div>

    </div>

<?php } 

if($common['where_from']=='zone'){?>

  <div class="spacer"></div>

    <div class="businessname-heading" style="overflow:hidden;">

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

	<div class="container_tab_header">Enter Webinar Information</div>

    <div style="font-size:20px; line-height:25px; color:red;">Your business is currently inactive. Please contact your Directory Manager for more details.

        	</div>

     </div>

  </div>

     <?php } ?>

 


 <script type="text/javascript">

$(document).ready(function () { //alert(1); 

  $('#zonewebinar').click();

 

  $('#zonewebinar_settings').addClass('active');
 
 $('.webinarsection').slideDown('slow');  

  $("input[name=checkadfordelete]").attr('checked',false);

  // $('#adv_tools').click();

});



</script>