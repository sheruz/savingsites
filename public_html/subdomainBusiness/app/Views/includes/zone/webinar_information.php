<script type="text/javascript">

$(document).ready(function(){
    $(".boxes").hide();
    $('input[type="radio"]').click(function(){  
        var inputValue = $(this).attr("value");
        var targetBox = $("." + inputValue);console.log(targetBox);
        $(".boxes").not(targetBox).hide();
        $(targetBox).show();
    });
});
 

$(document).ready(function () { 

	$('#adv_tools').click();

	$('#adv_tools').next().slideDown();

	$('#zonewebinar').click();

	$('#zonewebinar').next().slideDown();

	$('#zonewebinar_infoinformation').addClass('active');

	
 



});

 
function  check_authneticate(){ //alert(1);

	var is_authenticated=0;

	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ //alert('success');

		is_authenticated=data;

	}});	

	return is_authenticated;

}



/* Save New Category */

function save_webinar_link(){

	var authenticate=check_authneticate();

	if(authenticate=='0'){

		var zone_id = <?=$common['zoneid']?>;			 

		alert('You are currently logged out. Please log in to continue.');

		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

	}else if(authenticate==1){	

		var status = $('input[name=select]:checked').val();	

		if($("#webinar_link").val() == '' && $("#description").val() == ''){

			alert('Please enter the webinar information.'); return false;

		}else if($("#webinar_link").val() == ''){

			alert('Please enter the room title'); return false;

		}

		else if($("#description").val() == ''){

			alert('Please enter the description'); return false;

		} else if($("#roomtype:checked").val() == 'paid'){

         if($('#pemail').val() == ''){

          alert('Please enter the Paypal Email '); return false;

         }else if($('#price').val() == ''){

            alert('Please enter the Price '); return false;

         }
    }




		var dataToUse = {

			"zoneid":$("#zoneid").val(),

			"status":status,

			"webinar_link": $("#webinar_link").val(),

			"description": $("#description").val(),

			"created_by_userid":$("#created_by_userid").val(),

			"ad_stopdatetime":$("#ad_stopdatetime").val(),

    	"ad_startdatetime":$("#ad_startdatetime").val(),

      "room_type":$("#roomtype:checked").val(),

      "recordinglink":$("#recordinglink").val(),

      "desImage": $('#show_banner img').attr('src') , 

       "totalpeople": $('#totalpeople').val() , 

       "price": $('#price').val() , 

       "pemail": $('#pemail').val() , 

		};

		PageMethod("<?=base_url('Zonedashboard/save_webinar_link')?>", "Processing...<br/>This may take a minute.", dataToUse, weblinkSuccess, null);

	 }

}



function weblinkSuccess(result){

	$.unblockUI();

	var message = result.Message;

	var title = result.Title;

	var txt = '';

	 	// if(title==2){

			txt = '<h4 style="color:#090">Successfully saved the webinar information.</h4>' ;

	 // 	}else {

		// 	alert('Webinar information already exist in the system. Either delete and create new or update the existing.'); return false;

		// }

	  $("#msg").html(txt).show();

	  $("#msg").show();

	  $("#webinar_link").val('');

	  $("#description").val('');

	  $('html,body').animate({scrollTop:0},"slow");

	  setTimeout(function(){$("#msg").hide('slow');},3000);

}

// var disabledDate = ['2021-05-20', '2021-05-15','202-05-16'];

$("#ad_startdatetime,#ad_stopdatetime").live('focus',function(){

	$(this).datetimepicker({

		changeMonth: true,

		changeYear: true,

		dateFormat:'mm-dd-yy',

    // disabledDates : disabledDate,

     minDate:new Date()

	});

});


function ajaxFileUpload(){

  //starting setting some animation when the ajax starts and completes

  $('#spinner').show();

   $.ajaxFileUpload(            

  {

    type:"POST",

    url:'<?=base_url('banner_controller/save_zonelogo_image/'.$common['zoneid'].'')?>',

    secureuri:false,

    fileElementId:'imgfile',

    dataType: 'json',

    success: function (data, status)

    {

      $('#spinner').hide();

      $('.form_error').hide();

      $('#image_block').show();

      $('#uploadedInput').val(data.clientImage);

      $('#folder_name').val(data.folder_name);

      //$('#show_banner').html('<img src="'+baseurl+'uploads/zone_logo/temp_folder/'+data.uploadedImage+'/normal_image/'+data.clientImage+'" style="width:300px;  margin-top: 8px;">');

      $('#show_banner').html('<img src="'+baseurl+'uploads/zone_logo/'+zone_id+'/normal_image/'+data.clientImage+'" style="width:300px;  margin-top: 8px;">');

      if(data!=0){}

      if(typeof(data.error) != 'undefined')

      {

        if(data.error != '')

        {

          alert(data.error);

        }else

        {

          alert(data.msg);

        }

      }

    },

    error: function (data, status, e)

    {

      //alert(e);

    }

  }

)       

return false;

}



</script>





<input type="hidden" name="zoneid" id="zoneid" value="<?=$common['zoneid']?>" />

<input type="hidden" name="orgnid" id="orgnid" value="<?=$common['organizationid']?>" />



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

	<div class="container_tab_header">Enter Webinar Information</div>

     <div id="msg"></div>

   <!-- <h3 style="background:#5B9733, #FFF">Please go to talky.io  or  WebRtc sides and create a free chat room  and then come back here and copy paste that chat room link </h3>-->

     <h3 style="background:#5B9733, #FFF">To use the free webinar service: <br />First sign up with <a href="https://talky.io/" target="_blank"><u> www.talky.io</u></a> <br />Then enter your personal room link and a description of your webinar.</h3>

   

   

       <!-- <h2 style="color:#090" align="center">Webinar already exist in the system. Either delete and create new or update the existing.</h2> -->

 

       <div id="container_tab_content" class="container_tab_content">

        <div id="tabs-2_y">

        	<div id="msg" style="display:none;margin-top:7px;"></div>

        <div class="form-group center-block-table">

            <p>

            <?php //print_r($webniar_exist) ?>

            	<div id="new_category">

                <div id="status" align="center">

                	<input type="radio" name="select" value="1" checked="checked" />Enable <input type="radio" name="select" value="-1" />Disable<br /><br /><br /><br />

                 </div>

                  <label for="webinar_link" class="fleft w_150"> Room Type: </label>
                
                 <input type="radio" id="roomtype" name="roomtype" value="paid" class="w_300">
                  <label for="male">Paid</label>    
                  <input type="radio" id="roomtype" name="roomtype" value="free" checked="checked" class="w_300">
                  <label for="female">Free</label><br>

                  <div class="paid boxes">
           <br /><br />
                     <label for="biz_sic" class="fleft w_150">Price</label>

                   <input type="text" id="price"   class="w_300"  value=""  />


                   <br /><br />

                      <label for="biz_sic" class="fleft w_150">Paypal Email ID (Please enter paypal Business Account id only)</label>

                   <input type="text" id="pemail"   class="w_300"  value=""  />


                   <br /><br />


                  </div>

                  
                 <br><br>
                 <label for="webinar_link" class="fleft w_150"> Upload Image: </label>

                 <div id="uplodImage">

              <input type="file" id="imgfile" onchange="ajaxFileUpload();"  name="imgfile" value="" />

              <input type="hidden" name="uploadedInput" id="uploadedInput" value="" />

              <input type="hidden" name="zone_id" value="<?php echo $zone_id;?>" />

              <input type="hidden" name="folder_name" id="folder_name" value="" />

              <span style="display:none;right: 240px;" id="spinner"><img src="https://cdn.savingssites.com/loading.gif"></span>

              

              <!--<p id="uploading">(Please select a file(1526px*471px) to upload)</p>-->

              </div>

                   
                       
                       <div id="show_banner" style="width: 300px;">  </div>

                 
                    
                 <br><br>
                   

                   <label for="biz_sic" class="fleft w_150">Total People</label>

                   <input type="text" id="totalpeople"   class="w_300"  value=""  />


                   <br /><br />




                   <label for="webinar_link" class="fleft w_150">Enter Room Title</label>

                      <input type="text" id="webinar_link" name="webinar_link" placeholder="Please enter the room title" class="w_300"/><br /><br />

                      <label for="webinar_link" class="fleft w_150">Enter Description</label>

                      <textarea name="description" id="description" placeholder="Please enter the description" class="w_300"></textarea><br /><br />

                      

                  <label for="biz_sic" class="fleft w_150">Start Date Time</label>

                   <input type="text" id="ad_startdatetime" name="ad_startdatetime" class="w_300"  value="" placeholder="Specify Start Date/Time For Advertisement"/><br /><br />

                  

                  <label for="biz_sic" class="fleft w_150">Stop Date Time</label>

                      <input type="text" id="ad_stopdatetime" name="ad_stopdatetime" class="w_300" value="" placeholder="Specify End Date/Time For Advertisement"/><br /><br />


                        <label for="biz_sic" class="fleft w_150">Recording Links</label>

                      <input type="text" id="recordinglink" name="recordinglink" class="w_300" value="" placeholder="Specify Recording "/><br /><br />



                    <p>

                        <button class="m_left_150" onclick="save_webinar_link()">Save</button>

                        <!--<button onclick="HideCategoryEditor()">Back To Category</button>-->

                    </p>

                </div>

            </p>

        </div>

        </div>

    	</div>

 

    </div>



 





