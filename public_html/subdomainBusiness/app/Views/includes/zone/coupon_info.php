<script type="text/javascript">



$(document).ready(function () { 

	$('#adv_tools').click();

	$('#adv_tools').next().slideDown();

	$('#couponsite').click();

	$('#couponsite').next().slideDown();

	$('#coupon_info').addClass('active');

	

});

$(function(){

	if($('#show_coupon_link').val() != '' ){

		$('#show_coupon').hide();

		$('#message').show();

	}

});



function  check_authneticate(){ //alert(1);

	var is_authenticated=0;

	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ //alert('success');

		is_authenticated=data;

	}});	

	return is_authenticated;

}



function save_coupon_info(){

	var authenticate=check_authneticate();

	if(authenticate=='0'){

		var zone_id = <?=$common['zoneid']?>;			 

		alert('You are currently logged out. Please log in to continue.');

		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

	}else if(authenticate==1){	

		if($("#coupon_link").val() == '' && $("#coupon_description").val() == ''){

			alert('Please enter the coupon information.'); return false;

		}else if($("#coupon_link").val() == ''){

			alert('Please enter the coupon link'); return false;

		}

		else if($("#coupon_description").val() == ''){

			alert('Please enter the coupon description'); return false;

		} 

		var dataToUse = {

			"zoneid":$("#zoneid").val(),

			"coupon_link": $("#coupon_link").val(),

			"coupon_description": $("#coupon_description").val(),

		};

		PageMethod("<?=base_url('Zonedashboard/save_coupon_info')?>", "Processing...<br/>This may take a minute.", dataToUse, couponSuccess, null);

	 }

}

 function couponSuccess(result){//alert(JSON.stringify(result));

	$.unblockUI();

	$("#coupon_link").val("");

	$("#coupon_description").val(""); 

	$('html,body').animate({scrollTop:0},"slow");

	$("#msg").html('<h4 style="color:#090">Coupon created successfully</h4>').show();

	 setTimeout(function(){$("#msg").hide('slow');},3000);

}



$(document).ready(function() {

  $("#coupon_link").blur(function() {

    var input = $(this);

    var val = input.val();

    if (val && !val.match(/^http([s]?):\/\/.*/)) {

        input.val('http://' + val);

    }

  });

});



//	$('#button').click(function() {

//				$('#zoneName').attr("disabled", true);

//				// Write your Code

//							});

//								$('#canceledit').click(function() {

//								$('#zoneName').removeAttr("disabled", false);

//								})

//								

//										$('#renamezone').click(function() {

//										$('#zoneName').removeAttr("disabled", false);

//										})

//								



$(function() {

	

	 var re = /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/

	 

		$(document).on('blur','#coupon_link',function() {	

		if (re.test($(this).val())) {

		    //alert('Valid URL');

			//$('html,body').animate({scrollTop:0},"slow");

//				$("#msg").html('<h4 style="color:#090">Valid coupon link</h4>').show();

//				 setTimeout(function(){$("#msg").hide('slow');},3000);

//			

		}else{

				$("#coupon_link").val("");

				$('html,body').animate({scrollTop:0},"slow");

				$("#msg").html('<h4 style="color:#090">Invalid coupon link</h4>').show();

				 setTimeout(function(){$("#msg").hide('slow');},3000);

		}

  });

});









</script>

<input type="hidden" name="show_coupon1" id="show_coupon_link" value="<?=$create_list['0']['coupon_link'] ?>" />

<input type="hidden" name="zoneid" id="zoneid" value="<?=$common['zoneid']?>" />

<input type="hidden" name="show_coupon" id="show_coup" value="<?=$create_list['0']['id']?>" />



<div class="content_container">

	 <?php if($common['from_zoneid']!='0'){?>

<div class="spacer"></div>

  <div class="businessname-heading">

      <div class="main main-large main-100">

          <div class="businessname-heading-main">

            <?php if($common['businessid']!='') {  //var_dump($common['approval_message']);exit;?> 

            <font color="#333333">Business Name : </font> 

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

            <?php }if($common['businessid']!='') { ?><?=' '.$common['approval_message']?> <?php } ?>

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

            <a style="margin:-10px 20px 0 0;" href="javascript:void(0)" class="close" onClick="$('#view_global_bus_search_div').slideToggle();"><img src="https://cdn.savingssites.com/close_pop.png" class="btn_close global_search_close" title="Close Window" alt="Close" ></a>

      </div>

    </div>



<?php } ?>

	<div class="container_tab_header">Enter Coupon Information</div>

     <div id="msg"></div>    

	<div id="container_tab_content" class="container_tab_content">

        <div id="tabs-2_y">

        	<div id="msg" style="display:none;margin-top:7px;"></div>

       <div id="show_coupon">

        <div class="form-group center-block-table">

            <p>

            

            	<div id="new_category">

               

                   <label for="coupon_link" class="fleft w_150">Enter Coupon Link</label>

                      <input type="text" id="coupon_link" name="coupon_link" placeholder="Enter # (e.g. http://savingssites.com)"   class="w_300 coupon"/>

                     <!-- <label for="coupon_description" class="fleft w_150">Enter Description</label>

                      <textarea name="coupon_description" id="coupon_description" placeholder="Please enter the coupon description" class="w_300"></textarea>-->

                    <p>

                    <p id="result"></p>

                        <button class="m_left_150" onclick="save_coupon_info()"  id="button">Save</button>

                       

                    </p>

                </div>

            </p>

        </div>

        </div>

        

        <div id="message" style="display:none" >

                <h2 class="cus-coupon">Coupon  already exist in the system. Either delete and create new or update the existing.</h2>

         </div>

         <div id="message1" ></div>

        </div>

    	</div>

    </div>























































