<style>



#contentRight {

	float: left;

	margin-left:-2px;

	margin-right:-2px;

}



#contentRight li {

  list-style: none;

    margin: 0 3px 6px 3px;

    padding: 5px;
    background-color: #f9f9f8;
    border: #969393 solid 1px;
    color: #fff;
    width: 185px;
    cursor: move;
    float: left;
    overflow: hidden;

}
p.cus-lef {
    margin-left: 49px;
}
p.cus-lef2 {
    margin-left: 23px;
}

#contentRight ul{ padding-left:0; margin-top:0;}

#contentLeft {

	float: right;

	width: 260px;

	padding:10px;

	background-color:#336600;

	color:#FFFFFF;

}
input[type="radio"] {
    margin: 0 5px !important;
}
input[type="checkbox"] {
    margin: 0 5px !important;
}
input.form-control {
    width: 480px;
    max-width: 600px;
}
input#imgfile {
    width: 480px;
    max-width: 600px;
    margin-left: 52px !important;
}
.counter{

	color:#fff;

	margin-left: 18px;

}
input.bttn.pull-left {
    margin-left: 100px !important;
}

.header-default-message {
    background-color: #fff;
    background: #f5f5f5;
}

.container_tab_content .ui-widget-header {

    display: none;
}
.img-inactive{

	position: absolute;

  color: red;

  top: 0;

  left: 0;

  font-weight: 700;

  font-size: 21px;

  bottom: 43px;

  right: 0;

  /* text-align: center; */

  line-height: 127px;

  z-index: 1;

  margin-top: -27px;

  margin-left: -10px;

  text-shadow: 1px 2px 3px #5C5353;

}

.img-inactive::before{

	background-image: linear-gradient(to bottom, rgba(255, 255, 255, 0.6) 0%, rgba(255, 255, 255, 0.6) 100%);

    background-repeat: repeat-x;

    content: "";

    height: 100%;

    left: 0;

    position: absolute;

    top: 0;

    width: 100%;

}
span.bv_url_links {
    margin-left: 10px;
    margin-top: 10px !important;
    position: relative;
    top: 3px;
}

.img-inactive > div{

	position:relative;

	-ms-transform: rotate(-35deg); /* IE 9 */

    -webkit-transform: rotate(-35deg); /* Chrome, Safari, Opera */

    transform: rotate(-35deg);

}

</style>

<div class="main_content_outer"> 

  

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

            <a style="margin:-10px 20px 0 0;" href="javascript:void(0)" class="close" onClick="$('#view_global_bus_search_div').slideToggle();"><img src="<?=base_url('assets/images/close_pop.png') ?>" class="btn_close global_search_close" title="Close Window" alt="Close" ></a>

      </div>

    </div>



<?php } ?>

	<div class="container_tab_header">Zone Banner</div>

	<div id="container_tab_content" class="container_tab_content">

        <ul>     

        <!-- <li><a href="#tabs-2" onclick="resetnotification()">Add Banner</a></li>        -->

        </ul>

        <div id="tabs-2">

        	

            	<div class="container_tab_header header-default-message"> <p>Use Microsoft Office Picture Manager or Microsoft Paint to crop and resize your picture to the correct 2000 pixels wide and 471 pixels high to fit the banner. <br/> For best results upload a 1583 pixel wide x 500 pixel high image</p></div>

                <!--<form name="frm_banner" id="add_banner" method="post" onsubmit="save_banner()" enctype="multipart/form-data"  action="javascript:void(0);">-->

                <form name="frm_banner" id="banner_submit" method="post" onsubmit="save_banner()" enctype="multipart/form-data"  action="javascript:void(0);">

                 <div class="form-group center-block-table bv_add_banner_table">

                 <table width="100%" align="left" cellpadding="1" cellspacing="1">

                    <tr>

                      <td  valign="top" bgcolor="#FFFFFF"><table width="100%" cellspacing="1" cellpadding="4" >

                          <div class="form_error" style="display:none;"></div>

                          <tr id="image" >

						  
 

                            <td  valign="middle" class="title_content_block bv_title_block"><span class="cat_block1">Image</span>:</td>

                            <td  valign="middle" class="title_content_block bv_content_block">
                              <div id="uplodImage">

                                <input type="file" id="imgfile" onchange="ajaxFileUpload();"  name="imgfile" value="" />

                                <input type="hidden" name="uploadedInput" id="uploadedInput" value="" />

                                <input type="hidden" name="zone_id" value="<?php echo $zone_id;?>" />

                                <span style="display:none;right: 240px;" id="spinner"><img src="<?php echo base_url() ?>assets/images/loading.gif"></span>

                                <div id="show_banner" style="width: 300px;"></div>

                                

                              </div></td>

                          </tr>

                          <!--<tr>

                            <td  valign ="middle" class="cat_block1">Description:</td>

                            <td><textarea id="newtextarea" name="description" style="width:371px;height: 150px;"></textarea></td>

                          </tr>-->

                          <tr>

                            <td  valign="top" class="title_content_block bv_title_block">Status:</td>

                            <td  valign="top" class="title_content_block bv_content_block bv_view_td">

							<p class="cus-lef"> 	<label style="margin-top:0;"><input type="radio" name="status" value="1" checked="checked">

                             		Viewable

								</label>

								<label style="margin-top:0;">

									<input type="radio" name="status" value="0" >

									Not viewable

								</label> 
                </p>

              </td>

                          </tr>



						  <tr>

                            <td  valign="top" class="title_content_block bv_title_block">Banner Link:</td>

                            <td  valign="top" class="title_content_block bv_content_block">

								<label style="margin-top:0;margin-right: 20px;">

									<input type="text" name="set_banner" class="form-control"><br>
                  <span class="bv_url_links">(Please use http:// or www before on url Link)</span>

								</label>
								

							</td>

                          </tr>

						  



                          <tr>

                            <td  valign="middle" class="title_content_block bv_title_block">Display At:</td>

                            <td  valign="middle" class="title_content_block bv_content_block">

                             <!--  <input type="radio" name="status" value="1" checked="checked"> -->

                          <p class="cus-lef2">   <label style="margin-top:0;"><input type="checkbox" name="view_at[]" value="1"> Directory      </label>                  

                              

                             <label style="margin-top:0;"><input type="checkbox" name="view_at[]" value="2"> Business Search   </label>                           

                             

                             <label style="margin-top:0;"><input type="checkbox" name="view_at[]" value="3"> Peekaboo</label>

                              

                             <label style="margin-top:0;"><input type="checkbox" name="view_at[]" value="4"> Dining</label>

                              

                             <label style="margin-top:0;"><input type="checkbox" name="view_at[]" value="5"> Webinar</label>
                           </p>



                             <!--<label style="margin-top:0;"><input type="checkbox" name="view_at[]" value="6"> Home</label>-->

                              

                            </td>

                          </tr>



                          <!--<tr>

                            <td  valign="middle" class="cat_block1">Banner position no:</td>

                            <td><input type="text" name="order" id="order" value=""/></td>

                          </tr>-->

                          <tr >

                            <td  class="cat_block1">&nbsp;</td>

                            <td  valign="middle" class="cat_block1" colspan="2"></br>

                              <p class="align-center">

                                <input type="submit" name="Submit" value="Submit" class="bttn pull-left"  style="width:80px">

                              <input type="reset" id="reset_banner" style="display:none;"/>

                               </p></td>

                          </tr>

                          

                          <tr >

                            <td colspan="2" class="err">&nbsp;</td>

                          </tr>

                        </table></td>

                    </tr>

                  </table>

                  </div>

                </form>

            

        </div>

        

        <!-- Tab 1 Start -->        

        

        <!-- Tab 2 End -->

        

    </div>

    

    

</div>



</div>





<script type="text/javascript">

$(document).ready(function () { 

  $('#zone_data_accordian').click();

  $('#zone_data_accordian').next().slideDown();

  $('#jotform').click();

  $('#jotform').next().slideDown();

  $('#add_banner').addClass('active');

	

	// + Banner Position Ordering Code

	$(function() {var a='';

		$("#contentRight ul").sortable({ 

		opacity: 0.6, 

		cursor: 'move',

		

		update: function() {

			/*var newIndex = ui.item.index();

        	var oldIndex = $(this).attr('data-previndex');

        	$(this).removeAttr('data-previndex');

			newIndex=newIndex+1;

			

			$('div#contentRight ul li').each(function(i){

				a+=$(this).attr('id')+'@@@'+newIndex+",";

			});

			console.log(a); //return false;

			var order_arr=$(this).sortable("serialize");*/

			

			//var order = $(this).sortable("serialize") + '&action=updateRecordsListings' + '&zone_id=' + $('#zone_id').val(); 

			//console.log(order); return false;

			/*$.post("<?=base_url('banner_controller/banner_order_change')?>/", order, function(theResponse){

				

			});*/

			var order = '';

			$('div#contentRight ul li').each(function(i){

				order+=$(this).attr('id')+",";

				$('#'+$(this).attr('id')).find('.counter').text(i+1);

			});

			

			var data={order:order, zone_id : $('#zone_id').val()};

			//PageMethod("<?=base_url('banner_controller/banner_order_change')?>", "Saving Business Data<br/>This may take a few minutes", data, null, null);

 			$.post("<?=base_url('banner_controller/banner_order_change')?>/", data, function(){

				

			});														 

		}								  

		});

	});

	

	// + Banner Position Ordering Code 

});



function resetnotification(){

	$('.form_error').empty();

}

</script>

<script type="text/javascript">

function save_banner(){

	if($('#uploadedInput').val()!='' && $('#order').val()!=''){

		$('.form_error').hide();

		var dataToUse=$('form#banner_submit').serialize();

		PageMethod("<?=base_url('banner_controller/save_zone_banner')?>", "Adding banner please wait ....", dataToUse, add_banner_insert, null);

    return false;

	}else{

		$('.form_error').show();

		var form_error='';

		if($('#uploadedInput').val()==''){

			form_error+="Please upload a file.</br>";

		}

		/*if($('#order').val()==''){

			form_error+="Please provide banner position no.";

		}*/		

		$('.form_error').html('<span style="color:#F00; font-weight:bold;font-size: 19px;margin-left: 35px;">'+form_error+'</span>');

		return false;

	}

}

function add_banner_insert(result){

	$.unblockUI();

	$('.form_error').show();

	$('.form_error').html('<span style="color:#008000;font-weight:bold;font-size: 19px;margin-left: 35px;">Save Successful.</span>');

	$('#reset_banner').click();

	$('#uploadedInput').val('');

	/*setTimeout(function(){

		$('#tabs-2').find('div.form_error').hide('slow');

		window.location.reload();

	},3000);*/

}



function ajaxFileUpload(){ //alert(1);

	//starting setting some animation when the ajax starts and completes

	$('#spinner').show();

	 $.ajaxFileUpload(        		

	{

		url:'<?=base_url('banner_controller/save_banner_image/'.$zone_id.'')?>',

		secureuri:false,

		fileElementId:'imgfile',

		dataType: 'json',

		success: function (data, status)

		{

			//console.log(data); return false;

			$('#spinner').hide();

			$('#uploadedInput').val(data.clientImage);

			$('#show_banner').html('<img src="'+baseurl+'uploads/zone_banner/'+data.zone_id+'/'+data.clientImage+'" style="width:300px;  margin-top: 8px;">');

			//$('#bannerimage').attr('src',baseurl+'uploads/banner/'+<?=$zone_id?>+'/'+data.uploadedImage);

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

			alert(e);

		}

	}

)       

return false;

}   



function ajaxFileUpload1(){

	//starting setting some animation when the ajax starts and completes

	 $.ajaxFileUpload(        		

	{

		url:'<?=base_url('banner_controller/save_banner_image/'.$zone_id.'')?>',

		secureuri:false,

		fileElementId:'imgfile',

		dataType: 'json',

		success: function (data, status)

		{

			//alert(data.uploadedImage);

			var zone = $('#zone_id').val();

			$('#uploadedInput').val(data.uploadedImage);

			$('#bannerimage').attr('src',baseurl+'uploads/banner/'+zone+'/'+data.uploadedImage);

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

			alert(e);

		}

	}

)       

return false;

} 



function edit_banner(banner_id,zone_id){ //alert(banner_id);

var dataToUse={'banner_id':banner_id,'zone_id':zone_id};

PageMethod("<?=base_url('banner_controller/edit_banner_new')?>", "Please wait ....", dataToUse,edit_banner_success, null);

}



function edit_banner_success(result){

	$.unblockUI();

	$('#banner_list').hide();

	$('#banner_details').show();

	$('#banner_details').html(result.Tag);

}



function delete_banner(banner_id,zone_id,banner_path,image_name){

	

	var dataToUse={'banner_id':banner_id,'zone_id':zone_id,'banner_path':banner_path,'image_name':image_name};

	ConfirmDialog("Do you really want to delete? ", "Delete Banner", "<?=base_url('banner_controller/delete_banner')?>", "Deleting Zone Banner Image<br/>This may take a minute", dataToUse, delete_banner_success, null);	

	

	

	//var confirm_delete=confirm('Are you sure?');

	/*if(confirm_delete==true){

		var dataToUse={'banner_id':banner_id,'zone_id':zone_id,'banner_path':banner_path,'image_name':image_name};

		PageMethod("<?=base_url('banner_controller/delete_banner')?>", "Please wait ....", dataToUse, delete_banner_success, null);

	}*/

}



function delete_banner_success(result){

	$.unblockUI();

	banner_id = result.Title;//alert(banner_id);

	if(banner_id != ''){

		$('#banner_'+banner_id).hide();

		$('#banner_'+banner_id).remove();

		    var order = ''; 

			$('div#contentRight ul li').each(function(i){

				order+=$(this).attr('id')+",";

				$('#'+$(this).attr('id')).find('.counter').text(i+1);

			});

	

	}

}



var baseurl = "<?php echo base_url(); ?>";

//$(document).on('submit','form#update_banner',function(){	

function update_banner_function(image_name,order){  //alert(image_name); alert(order);return false; alert('pos=>'+$('#banner_id').val()); 

	if(image_name!='' && order!=''){

		$('.form_error').hide();

		var dataToUse=$('form#update_banner').serialize();

		PageMethod("<?=base_url('banner_controller/update_banner_new')?>", "Please wait ....", dataToUse, update_banner_success, null);

	}else{

		$('.form_error').show();

		var form_error='';

		if($('#uploadedInput').val()==''){

			form_error+="Please upload a file.</br>";

		}

		if($('#order').val()==''){

			form_error+="Please provide banner position no.";

		}		

		$('.form_error').html('<span style="color:#F00; font-weight:bold;font-size: 19px;margin-left: 35px;">'+form_error+'</span>');

		return false;

	}

}

function update_banner_success(){

	$.unblockUI();

	$('.form_error').show();

	$('.form_error').html('<span style="color:#008000;font-weight:bold;font-size: 19px;margin-left: 35px;">Update Successful.</span>');

	$('html,body').animate({scrollTop:0},"slow");

	setTimeout(function(){

		/*$('#tabs-1').find('div.form_error').hide('slow');*/

		$('#tabs-2').find('div.form_error').hide('slow');

	},3000);	

}

$(document).on('submit','#update_banner',function(){

	update_banner_function($('#uploadedInput1').val(),$('#order1').val());

});



$('textarea#edittextarea').bind("enterKey",function(e){

   $('#edittextarea').val($('#edittextarea').val() + '<br />'); 

});

$('textarea#edittextarea').keyup(function(e){

    if(e.keyCode == 13)

    {

        $(this).trigger("enterKey");

    }

});



$('textarea#newtextarea').bind("enterKey",function(e){

   $('#newtextarea').val($('#newtextarea').val() + '<br />'); 

});

$('textarea#newtextarea').keyup(function(e){

    if(e.keyCode == 13)

    {

        $(this).trigger("enterKey");

    }

});

</script>