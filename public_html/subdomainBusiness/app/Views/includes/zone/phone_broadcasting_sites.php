<script type="text/javascript">
$(document).ready(function () { 
	$('#adv_tools').click();
	$('#adv_tools').next().slideDown();
	$('#phone_broadcasting').click();
	$('#phone_broadcasting').next().slideDown();
	$('#phone_broadcasting_view').addClass('active');
	showallphone_broadcasting();
});

// + variable initialization
/*var zoneid = <?=$common['zoneid']?>;
//var orgid = <?=$common['organizationid']?>;
var fromzoneid = <?=$fromzoneid?>;*/
// - variable initialization

// + check_authneticate
function  check_authneticate(){ //alert(1);
	var is_authenticated=0;
	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ //alert('success');
		is_authenticated=data;
	}});	
	return is_authenticated;
}
// - check_authneticate

// + EditAnnouncement
function Editphone_broadcasting(id){
    var zone_id = '<?=$common['zoneid']?>';
	window.location.href = "<?=base_url('Zonedashboard/Editphone_broadcasting/') ?>" + "/" + zone_id +"/"+ id ;
}

// - EditAnnouncement

function showallphone_broadcasting(){
	var zone_id = '<?=$common['zoneid']?>';		 
	var authenticate=check_authneticate();
	if(authenticate=='0'){			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){//alert(zone_id);
		PageMethod("<?=base_url('Zonedashboard/more_phone_broadcasting_view')?>" + "/" + zone_id, "Processing...<br/>This may take a minute.", null, showAccounceInformation, null);
	 }
}
function showAccounceInformation(result){ 
	$.unblockUI();
	var total_result=result.Title;
	var adsno=result.Title; 
	
	if(adsno>4)
	{
		$('#my_announcements_limit').show();
		$('#container_tab_content').find('.header').show();		
	}
	else
	{
		$('#my_announcements_limit').hide();
		$('#container_tab_content').find('.header').show();	
	}
	
	var limit=result.Message;
	if(result.Tag!=''){
		if(limit=='5,5'){
			$("#showannouncement").html('');
			$("#showannouncement").append(result.Tag);
			$('#annoucement_edit').hide();
			
			//$('#showhead').show();		//
			
		}else{
		$("#showannouncement").append(result.Tag);
		$('#annoucement_edit').hide();
		//$('.apmybusiness:gt(0)').hide();
		//$('#showhead').hide();			//
		}
		if(adsno == 0){
			$("#showannouncement").html('<div class="container_tab_header" style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;">No phone broadcasting info found.</div>');
			$('.header').hide();
		}
		$('#my_announcements_limit').attr('rel',limit);	
	}
}


function deletephone_broadcasting(id) { 
     var dataToUse = {
			"phone_id":$("#phone_id").val(),
			"zoneid": $("#zoneid").val(),
		};
	 ConfirmDialog("Do you really want to delete this information? ", "Delete phone broadcasting", "<?=base_url('Zonedashboard/deletephone_broadcasting')?>", "Deleting Phone Broadcasting<br/>This may take a minute",dataToUse, announceSaveSuccessful, null);
}
//

//
function announceSaveSuccessful(result) {//alert(JSON.stringify(result));
	$.unblockUI();
	window.location.reload();
	if(result.Tag){
		
		//if(orgid != ''){
			//$('.pretty').find('tr#'+orgid).hide();
			//window.location.reload();
			//$('#not_found').show();
		//}
		//$('#msg').html('<h4 style="color:#090">Announcement successfully deleted</h4>');
		//$("#showannouncement").html(result.Tag);
		/*setTimeout(function(){
			$('#msg').hide('slow');
			window.location.reload();
		}, 3000);*/
	   // $("#showannouncement table").dataTable({ "bPaginate" : false});
		//HideAnnouncementEditor();
	}
}


</script>

<input type="hidden" name="zoneid" id="zoneid" value="<?=$common['zoneid']?>" />
<input type="hidden" name="orgnid" id="orgnid" value="<?=$common['organizationid']?>" />
<input type="hidden" name="fromzoneid" id="fromzoneid" value="<?=$fromzoneid?>" />

<?php /*?><!--Zone Id--><input type="hidden" name="zoneid" id="zoneid" value="<?=$common['zoneid']?>" /><?php */?>
<?php /*?><input type="hidden" name="organization_id" id="organization_id" value="<?=$organizationid?>" /><?php */?>

<input type="hidden" id="announcement_limit" value="<?=$limit ?>" />
<input type="hidden" id="countallannouncements" value="<?=$countallannouncements ?>" />
<input type="hidden" id="right_contain" value="<?=$right_container ?>" />
<input type="hidden" id="phone_broadcasting_id" value="<?=$coupon_list['0']['phone_broadcasting'] ?>" />

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
            <a style="margin:-10px 20px 0 0;" href="javascript:void(0)" class="close" onClick="$('#view_global_bus_search_div').slideToggle();"><img src="https://cdn.savingssites.com/close_pop.png" class="btn_close global_search_close" title="Close Window" alt="Close" ></a>
      </div>
    </div>

<?php } ?>	
<div class="container_tab_header">View Phone Broadcasting Information</div>
	<div id="msg"></div>		<!--Message div Show after update-->
	
<!---------------------------------------------------------------------Help Tips------------------------------------------------------------->
				<!--<div class="container_tab_header header-default-message"  style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:0px;">
            		<div class="btn-group-2" align="left">
                    	This section will show the created Announcements.
						<a href="javascript:void(0);" class="fright" onclick="$('#helpdiv').slideToggle('slow')"><img alt="Help Tips" title="Help Tips" src="<?=base_url()?>assets/images/help.png" style="margin:3px 0 0 10px" width:"28px" height="28px"/></a>
                    </div>
            	</div>
                	-->
             
    <div id="container_tab_content" class="container_tab_content">   
        <div id="tabs-1_x">
        <div>
        <?php 
	   if(!empty($coupon_list['0']['phone_broadcasting'])) {
		if(!empty($coupon_list)){ ?> 
        <table class="pretty header commonformattedtable" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">
            <thead id="showhead">
                <tr>
                    <th width="15%">Phone broadcasting link</th>            
                    <!--<th width="40%">Description</form-groupth>-->
                    <th width="20%">Action</th>
                </tr>
            </thead>
        
            <tbody id="showannouncement" border="0" cellpadding="0" cellspacing="0"></tbody>
            </table>
       <div id="more_announcements" style="float:right;"><a id="my_announcements_limit" class="text-default" href="javascript:void(0)" onclick="showallphone_broadcasting();" rel=""></a> </div>
       <?php }}else{?>
       		<p><div id="not_found" class="container_tab_header" style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;">No Phone broadcasting info found.</div></p>
       <?php  }?>
        </div>
        </div>
        
       
        
        
    </div>
    
    
</div>

</div>




 
