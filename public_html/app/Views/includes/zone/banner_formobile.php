<style>

.contentRight {
	float: left;
	margin-left:-2px;
	margin-right:-2px;
}

.contentRight li {
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
.contentRight ul{ padding-left:0; margin-top:0;}
#contentLeft {
	float: right;
	width: 260px;
	padding:10px;
	background-color:#336600;
	color:#FFFFFF;
}
.contentRights {
  float: left;
  margin-left:-2px;
  margin-right:-2px;
}

.contentRights li {
  list-style: none;
  margin: 0 3px 6px 3px;
  padding: 5px;
  background-color:#d2e08f;
  border: #CCCCCC solid 1px;
  color:#fff;
  width:192px;
  cursor:move;
  float:left;
  overflow:hidden;
}
.contentRights ul{ padding-left:0; margin-top:0;}
#contentLeft {
  float: right;
  width: 260px;
  padding:10px;
  background-color:#336600;
  color:#FFFFFF;
}
.counter{
	color:#fff;
	margin-left: 18px;
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
        <li><a href="#tabs-1" onclick="resetnotification(1)">Directory</a></li>
        <li><a href="#tabs-2" onclick="resetnotification(2)">Business Search</a></li>
        <li><a href="#tabs-3" onclick="resetnotification(3)">Pekaboo</a></li>
        <li><a href="#tabs-4" onclick="resetnotification(4)">Dining</a></li>
        <li><a href="#tabs-5" onclick="resetnotification(5)">Webinar</a></li>
        <!-- <li><a href="#tabs-2" onclick="resetnotification()">Add Banner</a></li> -->        
        
        </ul>
        <!-- <div id="tabs-2">
        	
            	<div class="container_tab_header header-default-message"> <p>Use Microsoft Office Picture Manager or Microsoft Paint to crop and resize your picture to the correct 2000 pixels wide and 471 pixels high to fit the banner</p></div>
                <form name="frm_banner" id="add_banner" method="post" onsubmit="save_banner()" enctype="multipart/form-data"  action="javascript:void(0);">
                 <div class="form-group center-block-table">
                 <table width="100%" align="left" cellpadding="1" cellspacing="1">
                    <tr>
                      <td  valign="top" bgcolor="#FFFFFF"><table width="95%" cellspacing="1" cellpadding="4" >
                          <div class="form_error" style="display:none;"></div>
                          <tr id="image" >
						  
						  <div style="  background-color: rgb(19, 19, 18););height: 28px;border-radius: 5px;">
							 <span style="font-size:15px;color:wheat;  padding: 4px;display: block;">
								For best results upload a 1583 pixel wide x 500 pixel high image
							 </span>
						  </div>
                            <td  valign="middle" class="title_content_block"><span class="cat_block1">Image</span>:</td>
                            <td  valign="middle" class="title_content_block"><div id="uplodImage">
                                <input type="file" id="imgfile" onchange="ajaxFileUpload();"  name="imgfile" value="" /></br></br>
                                <input type="hidden" name="uploadedInput" id="uploadedInput" value="" />
                                <input type="hidden" name="zone_id" value="<?php echo $zone_id;?>" />
                                <span style="display:none;right: 240px;" id="spinner"><img src="<?php echo base_url() ?>assets/images/loading.gif"></span>
                                <div id="show_banner" style="width: 300px;"></div>
                                
                              </div></td>
                          </tr>
                          
                          <tr>
                            <td  valign="middle" class="title_content_block">Status:</td>
                            <td  valign="middle" class="title_content_block"><input type="radio" name="status" value="1" checked="checked">
                              Viewable on directory page
                              <br>
                              <input type="radio" name="status" value="0" >
                              Not viewable on directory page </td>
                          </tr>
                          
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
            
        </div> -->
        
        <!-- Tab 1 Start -->
        
        <div id="tabs-1" data-id="1">
        	<div class="form-group">
            <div class="container_tab_header header-default-message" style="/*background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:0px; overflow:hidden;*/">
            	<p>Drag and Drop Images To Change Banner Position</p>
            </div>
                <div class="banner_details" id="banner_details" style="display:none; margin-top:10px;"></div>
                    <div class="banner_list" id="banner_list1" style="margin-top:10px;">
                   <!-- <table class="pretty" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">
                      <thead>
                        <tr>
                          <th>Image Name</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      </tbody>
                    </table>-->
                      <div id="contentRight1" class="contentRight">
                      <ul>
                        <?php if(!empty($all_banner)) { $count = 1;?>
                        <?php foreach($all_banner as $ab){ //echo '<pre>';var_dump($ab);exit;//var_dump($ab['status']);
                            $banner_path=!empty($ab['zone_id']) ? $ab['zone_id'] : "default";
                            $imageName = $ab['image_name'];
                            //$imageUrl  = base_url().'uploads/banner/'.$banner_path.'/'.$imageName;
                            $isEditable = true;
                           /* if (
			                        $imageName == 'slider_default_0.jpg' ||
			                        $imageName == 'slider_default_1.jpg' ||
			                        $imageName == 'slider_default_2.jpg' ||
			                        $imageName == 'slider_default_3.jpg' ||
			                        $imageName == 'slider_default_4.jpg' ||
			                        $imageName == 'slider_default_5.jpg' ||
			                        $imageName == 'slider_default_snapdining.jpg'||
			                        $imageName == 'blog-banner.jpg' ||
			                        $imageName == 'cal-banner.jpg' ||
			                        $imageName == 'circular-banner.jpg' ||
			                        $imageName == 'classifieds-banner.jpg' ||
			                        $imageName == 'grocery-banner.jpg' ||
			                        $imageName == 'hs-banner.jpg' ||
			                        $imageName == 'webinar-banner.jpg' ||
                              $imageName == 'webinar-banner1.jpg'

			                     ) {*/
			                     if($ab['zone_id']==0){
			                		   /*$imageUrl=base_url()."assets/banner/$imageName";                          
			                		   $banner_path = "default";*/
			                		   
                             $imageUrl=base_url()."assets/directory/images/banner/$imageName";
			                     }else{
			                     	$isEditable  = false;
                              //$imageUrl=base_url()."assets/directory/images/banner/$imageName";
                              $imageUrl  = base_url().'uploads/zone_mobile_resizeupload/'.$banner_path.'/'.$imageName;
                          }




                        ?>
                        <?php if($ab['status'] == 0){ ?>
                        <li id="banner_<?=$ab['id']?>" style="position:relative;">
                        <span class="img-inactive"><div>Not Viewable</div></span>
                          <?php }else{ ?>
                           <li id="banner_<?=$ab['id']?>" style="position:relative;">
                           <?php } ?>
                          <span class="dragdropimage"><img src="<?= $imageUrl ?>" width="220px" style="width:100%;"/>
                          <button class="counter" title="Banner Order" style="top: 0px; position:absolute; right: 0px;  padding: 3px 7px; border-radius: 15px;"><?php echo $count ?></button>
                          </span>
                          <div style="margin-top:5px;">
                          <button id="<?=$ab['id']?>" class="editgrp" onclick="edit_banner(<?=$ab['id']?>,<?=$zone_id?>,'<?=$banner_path?>')">Edit</button>
                          <?php if($ab['zone_id']!=0) { ?>
                          <button id="<?=$ab['id']?>" class="deletegrp" onclick="delete_banner(<?=$ab['id']?>,<?=$zone_id?>,'<?=$banner_path?>','<?=$ab['image_name']?>')">Delete</button>
                          <?php }  ?>
                          
                            
                           
                            </div>
                        </li>
                        <? $count ++ ;} }
                    else
                    {
                    ?>
                        
                          <li>No Banner Found.</li>
                        
                        <?php	
                    }
                     ?>
                     </ul>
                     </div>
                    </div>
   
            </div>
        </div>
        <!-- Tab 2 End -->


        <div id="tabs-2" data-id="2">
          
        </div>


        <div id="tabs-3" data-id="3">
          
        </div>


        <div id="tabs-4" data-id="4">
          
        </div>


        <div id="tabs-5" data-id="5">
          
        </div>


        <div id="tabs-6" data-id="6">
          
        </div>
        
    </div>
    
    
</div>

</div>


<script type="text/javascript">
$(document).ready(function () { 

  $('#zone_data_accordian').click();
  $('#zone_data_accordian').next().slideDown();
  $('#jotform').click();
  $('#jotform').next().slideDown();
  $('#manage_banner_mobile').addClass('active');
	
	// + Banner Position Ordering Code
	
	
	// + Banner Position Ordering Code 
});

function resetnotification(viewable_id){
	$('.form_error').empty();
  $.ajax({
      type:"POST",
      url:"<?=base_url('Zonedashboard/tabeviewZonebannerFormobile/'.$zone_id.'')?>",
      dataType:"json",
      data:
      {
        viewable_at:viewable_id
      },
      success:function(response)
      {
        //alert(response.viewable_id);
        if(response.viewable_id == '1')
        {
          $('.banner_list').empty();
          $("#tabs-1").html(response.html);

          $('.contentRights').attr('id','contentRight1');
          $('.banner_list').attr('id','banner_list1');
          $("#update_banner").empty();
        }
        else if(response.viewable_id == '2')
        {
          $('.banner_list').empty();
          $("#tabs-2").html(response.html);
          $('.contentRights').attr('id','contentRight2');
          $('.banner_list').attr('id','banner_list2');
          $("#update_banner").empty();
        }
        else if(response.viewable_id == '3')
        {
          $('.banner_list').empty();
          $("#tabs-3").html(response.html);
          $('.contentRights').attr('id','contentRight3');
          $('.banner_list').attr('id','banner_list3');
          $("#update_banner").empty();
        }
        else if(response.viewable_id == '4')
        {
          $('.banner_list').empty();
          $("#tabs-4").html(response.html);
          $('.contentRights').attr('id','contentRight4');
          $('.banner_list').attr('id','banner_list4');
          $("#update_banner").empty();
        }
        else if(response.viewable_id == '5')
        {
          $('.banner_list').empty();
          $("#tabs-5").html(response.html);
          $('.contentRights').attr('id','contentRight5');
          $('.banner_list').attr('id','banner_list5');
          $("#update_banner").empty();
        }
        else if(response.viewable_id == '6')
        {
          $('.banner_list').empty();
          $("#tabs-6").html(response.html);
          $('.contentRights').attr('id','contentRight6');
          $('.banner_list').attr('id','banner_list6');
          $("#update_banner").empty();
        }
      }
  });
}
</script>
<script type="text/javascript"> 

function edit_banner(banner_id,zone_id){ //alert(banner_id);
var tab_idhref = $(".ui-state-active a").attr('href');
var split_tab = tab_idhref.split('-');
var tab_id = split_tab[1];

var dataToUse={'banner_id':banner_id,'zone_id':zone_id,'tab_id':tab_id,'device_type':'2'};
//$("#edit_banner").attr('name','edit_banner'+);
PageMethod("<?=base_url('banner_controller/edit_banner_formobile')?>", "Please wait ....", dataToUse,edit_banner_success, null);
//$(".edit_banner").empty();
}

function edit_banner_success(result){
	$.unblockUI();
  //$("#banner_details").remove();
	$('#banner_list').hide();
	//$('#banner_details').show();
  $('.banner_list').hide();
  $('.banner_details').show();
  $('.banner_details').html(result.Tag);
	//$('#banner_details').html(result.Tag);

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
		PageMethod("<?=base_url('banner_controller/update_banner_mobile')?>", "Please wait ....", dataToUse, update_banner_success, null);
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
		$('#tabs-1').find('div.form_error').hide('slow');
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

$(document).ready(function () { 
  $('#zone_data_accordian').click();
  $('#zone_data_accordian').next().slideDown();
  $('#jotform').click();
  $('#jotform').next().slideDown();
  $('#manage_banner_mobile').addClass('active');

  var tab_idhref = $(".ui-state-active a").attr('href');
  var split_tab = tab_idhref.split('-');
  var tab_id = split_tab[1];
  
  // + Banner Position Ordering Code
  $(function() {var a='';
    $(".contentRight ul").sortable({ 
    opacity: 0.6, 
    cursor: 'move',
    
    update: function() {
      var order = '';
      $('div#contentRight1 ul li').each(function(i){
        order+=$(this).attr('id')+",";
        //console.log(i);
        $('#'+$(this).attr('id')).find('.counter').text(i+1);
      });
      
      var data={order:order, zone_id : $('#zone_id').val(),'tab_id':tab_id,'device_type':'2'};
      //PageMethod("<?=base_url('banner_controller/banner_order_change')?>", "Saving Business Data<br/>This may take a few minutes", data, null, null);
      $.post("<?=base_url('banner_controller/banner_order_changeformobile')?>/", data, function(){
        console.log(null);
        
      });                            
    }                 
    });
  });
  
  // + Banner Position Ordering Code 
});
</script>