
<?php if(!empty($search_value)){?>
 <div class="container_tab_header"><strong>Search Businesses</strong></div>
<table class="pretty" border="0" cellpadding="0" cellspacing="0">
  <thead id="showhead" class="headerclass">
    <tr>
      <th width="10%">Business Id</th>
      <th width="24%">Business Name</th>
      <th width="20%">Business Status</th>
      <th width="20%">Contact Name</th>
      <th>Telephone</th>
      <th width="30%">Action</th>
      <?php /*?><th width="12%">Select/<br/>Deselect All<br/><input type="checkbox" name="select_all_business_non_temp" id="select_all_business_non_temp"  value="all" title="Select/Deselect All" alt="Select/Deselect All" data-businesstype="<?=$business_type?>" data-businesstypebycategory="<?=$business_type_by_category?>" data-businesszone="<?=$business_zone?>"></th> <?php */?>
    </tr>
  </thead>
  <tbody>
    <?php /*?><tr class="headerclass_sub">
      <td colspan="6"><div id="action_performed_div" class="fright">
          <select name="action_performed" id="action_performed" class="w_215 select_style_sm">
              <option value="6">Change Public Display Status</option>
              <option value="3">Delete</option>
          </select>
          <!--<select name="change_business_status" id="change_business_status" class="w_285 select_style_sm">-->
        
              <select name="change_business_status" id="change_business_status" class="w_285 select_style_sm">
                   <option value="3">Active uploaded Businesses - Ad is viewable</option>
                   <option value="2">Active Trial Businesses - Ad is viewable</option>
                   <option value="1">Active Paid Businesses - Ad is viewable</option>
                   <option value="-3">Deactivate - uploaded Business</option>
                   <option value="-2">Deactivate - Trial Business</option>
                   <option value="-1">Deactivate - Paid Business</option>
              </select> 
              <!--<option value="3">Active Upload Businesses - Ad is viewable</option>
           </select>-->
          <select name="business_delete_all_or_specific" id="business_delete_all_or_specific" class="w_215 select_style_sm">
              <option value="1">Selected Businesses</option>
              <option value="2">All Businesses</option>
          </select>
          <select name="action_performed_in_where" id="action_performed_in_where" class="w_215 select_style_sm" style="display:none;">
              <option value="0">Current Zone</option>
              <option value="1" disabled="disabled">All Zones</option>
          </select>
          <button class="btn-sm"  id="update_non_temp_business" type="button" data-businesstype="<?=$business_type?>" data-businesstypebycategory="<?=$business_type_by_category?>" data-businesszone="<?=$business_zone?>">Update</button>
        </div></td>
    </tr><?php */?>
    
	<? foreach($search_value as $key1=>$business){
		$business_status = '';
		if(isset($business['approval'])){
			if($business['approval'] == 1){
				$business_status = 'Viewable Paid' ;
			}else if($business['approval'] == -1){
				$business_status = 'Not Viewable Paid' ;
			}else if($business['approval'] == 2){
				$business_status = 'Viewable Free Trial' ;
			}else if($business['approval'] == -2){		
				$business_status = 'Not Viewable Free Trial' ;
			}else if($business['approval'] == 3){
				$business_status = 'Not Viewable, Businesses Uploaded' ;
			}else if($business['approval'] == -3){	
				$business_status = 'Not Viewable, Businesses Uploaded' ;
			}else if($business['approval'] == 0){
				$business_status = 'Waiting For Approval' ;
			}
		}
	//echo $key_count=($key1)%2;
	$key_count=($key1)%2;
	if($key_count==0){
		$displaytableview_class='displaytableview_odd';
	}else if($key_count==1){
		$displaytableview_class=='displaytableview_even';
	}	
	?>
    <tr id="<?=$business['id']?>" class="uploadbusiness <?=$displaytableview_class?>" >
      <td style="text-align:justify;" width="10%"><b>
        <?=urldecode($business['id'])?>
        </b><br/>
      </td>
      <td style="text-align:justify;" width="24%"><b>
        <?=urldecode(stripslashes($business['name']))?>
        </b><br/>
      </td>
      <td style="" width="20%"><b>
        <?=$business_status?>
        </b><br/>
      </td>  
      <td width="20%"><?=$business['usercontactfullname'];?></td>
      <td>
      <?=$business['phone']?> 
      </td>
        <td  width="40%">
        <a href="<?=base_url()?>businessdashboard/viewad/<?=$business['id']?>/<?=$zone_id?>" class="link-underlined text-default"><b>&#x2192; Go to this Business AD profile</b></a><br />
        
        <a class="link-underlined text-default edit_business" href="javascript:void(0)" id="edit_business" rel="<?=$business['id']?>" data-businesstype="<?=$business['approval']?>" data-businesszone="<?=$business['settingszoneid']?>"  title="Edit <?=stripslashes($business['name'])?> Business"><b>&#x2192; Edit Business contact information</b></a><br />
        <!--<a href="javascript:void(0);" class="link-underlined text-default">&#x2192; Send Email to Business Owner to give Login Info</a><br/>-->
        
        </td>
      <?php /*?><td  width="12%"><input type="checkbox" name="checkadfordelete" id="individual_checkbox_business" class="display_checkbox1 <?=$business_type_by_category?>" value="<?=$business['businessid']?>" data-businesstype="<?=$business_type?>" data-businesstypebycategory="<?=$business_type_by_category?>" data-businesszone="<?=$business_zone?>"/></td><?php */?>
      <?php /*?><td><?=$ad['pendingdzone']?></td><?php */?>
      <?php /*?><td><?=$ad['deactivatedzone']?></td>
              <td><button onclick="editad(<?=$ad['id']?>,<?=$ad['business_id']?>,<?=$zoneid?>);">Edit</button>
                <br />
                <br />
                <button onclick="editzone(<?=$ad['id']?>,<?=$ad['business_id']?>);">Edit/Delete Zone</button>
                <br />
                <br />
                <button onclick="deleteAd(<?=$ad['id']?>,<?=$ad['business_id']?>, '<?=stripslashes($ad['name'])?>');">Delete</button></td><?php */?>
    </tr>
    <?php $displaytableview_class=''; } ?>
   
  </tbody>
</table>
<?php }else{ ?>
<div class="container_tab_header" style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;">No Businesses are Found</div>
<?php  }?>
<input type="hidden" id="biz_id" value="" />
<input type="hidden" id="biz_zone_id" value="" />

<script>
/////////////////////////////////////////////// Edit Business Part start ////////////////////////////////////////////////
$(document).on('click','.edit_business',function(){ 
	var id=$(this).attr('rel');
	var businesstype='0'; //alert(businesstype);
	var businesstypebycategory='0'; //alert(businesstypebycategory);
	var businesszone=$(this).attr('data-businesszone');
	$('#biz_id').val(id);	$('#biz_zone_id').val(businesszone);
	var data={businessid:id,zoneid:$('#zone_id').val(),businesstype:businesstype,businesstypebycategory:businesstypebycategory,businesszone:businesszone}
	//console.log(data); return false;
	PageMethod("<?=base_url('Zonedashboard/edit_non_temp_business')?>", "Action Performed...<br/>This may take a few minutes", data, EditNonTempBusinessSuccess, null);
});
function EditNonTempBusinessSuccess(result){
	$.unblockUI();
	if(result.Tag!=''){
		$(".content_container").html(result.Tag);
		var data={businessid:$('#biz_id').val(),zoneid:$('#biz_zone_id').val()}
		PageMethod("<?=base_url('Zonedashboard/view_edit_non_temp_business')?>", "Action Performed...<br/>This may take a few minutes", data, ViewEditNonTempBusinessSuccess, null); 
	}
}
function ViewEditNonTempBusinessSuccess(result){ //alert(JSON.stringify(result));
	$.unblockUI();
	if(result.Tag!=''){
		var str=result.Tag;
		$(document).find('#back_to_business').text('Back To Search Results');
		$(document).find('#biz_address_id').val(str.addressid);
		$(document).find('#biz_user_id').val(str.userid);
		$(document).find('#biz_addsetting_id').val(str.adsettingid);
		$(document).find('#biz_user_id').val(str.userid);
		$(document).find('#biz_name').val(str.name);
		$(document).find('#biz_motto').val(str.motto);
		$(document).find('#biz_email').val(str.contactemail); 		
		$(document).find('#biz_first_name').val(str.contactfirstname);
		$(document).find('#biz_last_name').val(str.contactlastname);
		$(document).find('#biz_address_1').val(str.street_address_1); 
		$(document).find('#biz_address_2').val(str.street_address_2);
		$(document).find('#biz_city').val(str.city);
		$(document).find('#biz_state').find('option[value='+str.state+']').attr('selected','selected');
		$(document).find('#biz_phone').val(str.phone); 
		$(document).find('#biz_website').val(str.website); 
		$(document).find('#biz_sic').val(str.siccode);
		$(document).find('#biz_username').val(str.username);
	}
}

$(document).on('click','#edit_update_non_temp_business',function(){
	var tag=$(this).parent().parent().siblings();
	var businesstype=$(this).attr('data-businesstype'); //alert(businesstype); 
	var businesstypebycategory=$(this).attr('data-businesstypebycategory'); //alert(businesstypebycategory);
	var businesszone=$(this).attr('data-businesszone'); //alert(businesszone);return false;
	
	var data={businessid:$('#biz_id').val(),zoneid:$('#biz_zone_id').val(),biz_addsetting_id:$('#biz_addsetting_id').val(),biz_address_id:$('#biz_address_id').val(),biz_user_id:$('#biz_user_id').val(),businesstype:businesstype,businesstypebycategory:businesstypebycategory,businesszone:businesszone,biz_name:tag.find('#biz_name').val(),biz_motto:tag.find('#biz_motto').val(),biz_email:tag.find('#biz_email').val(),biz_first_name:tag.find('#biz_first_name').val(),biz_last_name:tag.find('#biz_last_name').val(),biz_address_1:tag.find('#biz_address_1').val(),biz_address_2:tag.find('#biz_address_2').val(),biz_city:tag.find('#biz_city').val(),biz_state:tag.find('#biz_state').val(),biz_phone:tag.find('#biz_phone').val(),biz_website:tag.find('#biz_website').val(),biz_sic:tag.find('#biz_sic').val(),biz_username:tag.find('#biz_username').val()}
	PageMethod("<?=base_url('Zonedashboard/update_edit_non_temp_business')?>", "Action Performed...<br/>This may take a few minutes", data, UpdateEditNonTempBusinessSuccess, null); 
	
});
function UpdateEditNonTempBusinessSuccess(result){//alert(JSON.stringify(result));
	$.unblockUI();
	if(result.Tag!=''){
		$(".success").show();
	}
}
$(document).on('click','#back_to_business',function(){
	$('#global_bus_search_btn').click();
});
</script>