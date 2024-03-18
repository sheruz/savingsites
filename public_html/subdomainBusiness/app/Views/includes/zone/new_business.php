<input type="hidden" id="zoneid" name="zoneid" value="<?php echo $zoneid;?>"/>
<div class="main_content_outer">
  <div class="content_container">
    <div class="container_tab_header">Businesses Waiting For Zone Owner Approval</div>
    <div id="container_tab_content" class="container_tab_content">
      <ul id="bs_type">
        <li><a href="#tabs-1" onclick="test1();" bs_type="1">Businesses</a></li>
        <li><a href="#tabs-2" onclick="test2();" bs_type="2">Business Opportunity Providers</a></li>
      </ul>
      <div id="tabs-1">
        <div class="form-group">
          <div class="container_tab_header" style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:0px;">This section shows the businesses waiting for the zone owners approval.</div>
          <div class="view_new_business" style="display:none;"></div>
          <div class="edit_new_business" style="display:none;"></div>
        </div>
      </div>
      <div id="tabs-2">
        <div class="form-group">
          <!--<div class="container_tab_header header-default-message">This package gives you easy access to the Lorem Ipsum dummy text; an option is available to separate the paragraphs.</div>-->
          <!--<div id="view_new_business" style="display:none;"></div>-->
         
           <div class="view_new_business" style="display:none;"></div>
          <div class="edit_new_business" style="display:none;"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function () { 
	$('#zone_business_accordian').click();
	$('#zone_new_business').addClass('active');
	$(".view_new_business" ).hide();
	$(".edit_new_business" ).hide();
	var zoneid=$('#zoneid').val();
	var data={'zoneid':zoneid};
	PageMethod("<?=base_url('Zonedashboard/newbusiness_show')?>", "Action Performed...<br/>This may take a few minutes", data, successdata, null);
});
      // ++ For normal business onclick the business button
function test1(){
	$('#zone_business_accordian').click();
	$('#zone_new_business').addClass('active');
	$(".view_new_business" ).hide();
	$(".edit_new_business" ).hide();
	var zoneid=$('#zoneid').val();
	var data={'zoneid':zoneid};
	PageMethod("<?=base_url('Zonedashboard/newbusiness_show')?>", "Action Performed...<br/>This may take a few minutes", data, successdata, null);
}
      // -- For normal business onclick the business button
      // ++ For franchise business
function test2(){
	$('#zone_business_accordian').click();
	$('#zone_new_business').addClass('active');
	$(".view_new_business" ).hide();
	$(".edit_new_business" ).hide();
	var zoneid=$('#zoneid').val();
	var data={'zoneid':zoneid};
	PageMethod("<?=base_url('Zonedashboard/new_franchisebusiness_show')?>", "Action Performed...<br/>This may take a few minutes", data, successdata, null);
}
      // -- For franchise business

function successdata(result){
	$.unblockUI();
	if(result.Tag!=''){
		$(".view_new_business").show();
		$(".view_new_business").html(result.Tag);
	}
}
// + To Select All from header
$(document).on('click','#select_all_business_new',function(){ //alert(1);
	checkboxes = document.getElementsByTagName("input");//get main check box
	//alert(checkboxes);
	var ele=this;
	if(ele.checked==true)//check main check box is checked or non checked
	{
		state = true;//set status
		//$('#action_performed').show();
	}else{
		state = false;//set status
		//$('#action_performed').hide();
	}
	for (i=0; i<checkboxes.length ; i++)//chck all other checkbox and set their status
	{
	  if (checkboxes[i].type == "checkbox") 
	  {
		checkboxes[i].checked=state;
	  }
	}
}); // - To Select All from header
// + To click on individual checkbox, uncheck the 'Select All' checkbox
$(document).on('click','#individual_checkbox_business',function(){
	var total_checkbox=$("input[name=checkadfordelete]").length ;
	var total_checked_checkbox=$("input[name=checkadfordelete]:checked").length; 
	//alert(total_checkbox); alert(total_checked_checkbox); //return false; 	
	if(total_checkbox!=total_checked_checkbox){ //alert(1);
		 $('#select_all_business_new').attr('checked', false);		
	}else if(total_checkbox==total_checked_checkbox){ //alert(2);
		 $('#select_all_business_new').attr('checked', true);		
	}
}); // - To click on individual checkbox, uncheck the 'Select All' checkbox
// + To dissabled All checkbox, when selecting 'All Business'
$(document).on('change','#business_delete_all_or_specific',function(){
	if($('#business_delete_all_or_specific').val()==2){ //alert(1);  
		$("input[name=checkadfordelete]").attr('disabled','disabled');
		$("input[name=select_all_business]").attr('disabled','disabled');
		//individual_checkbox_business();
	}else{ //alert(2); 
		$("input[name=checkadfordelete]").attr('disabled',false);
		$("input[name=select_all_business]").attr('disabled',false);
	}
}); // - To dissabled All checkbox, when selecting 'All Business'
// + To change 'Public Status/Delete'
$(document).on('change','#action_performed',function(){
	var tag=$(this).val();
	if(tag==6){
		$('#change_business_status').show();
		//$('#business_delete_all_or_specific').show();
		$('#action_performed_in_where').hide();
	}else if(tag==3){
		$('#change_business_status').hide();
		//$('#business_delete_all_or_specific').show();
		$('#action_performed_in_where').show();
	}
});// - To change 'Public Status/Delete'
// + To click on Update Button
$(document).on('click','#update_new_business',function(){
	var action_performed=$('#action_performed').val(); 
	var change_business_status=$('#change_business_status').val(); 
	var action_performed_in_where=$('#action_performed_in_where').val(); 
	var business_delete_all_or_specific=$('#business_delete_all_or_specific').val(); 
	var display_checkbox='';		
	$("input[name=checkadfordelete]:Checked").each(function(i,item){
		display_checkbox+=$(item).val()+',';
	});	
	display_checkbox=display_checkbox.substring(0,display_checkbox.length-1);
	if(display_checkbox=='' && business_delete_all_or_specific==1){
		alert('Please Select At Least One Business.');
		return false;
	}
		var business_type=$(this).attr('bs_type'); // business type  normal or franchise

	//alert(action_performed); alert(change_business_status); alert(action_performed_in_where);  alert(business_delete_all_or_specific);  alert(display_checkbox);
	data={businessid:display_checkbox,zoneid:$('#zoneid').val(),action_performed:action_performed,change_business_status:change_business_status,action_performed_in_where:action_performed_in_where,business_delete_all_or_specific:business_delete_all_or_specific,business_type:business_type}
	if(action_performed==3 && action_performed_in_where==0 && business_delete_all_or_specific==1){
			ConfirmDialog('If you delete businesses data records from your database it will simultaneously delete the ads for each deleted business. <br/></br>When you upload the businesses again, each business will be placed into the "Businesses Uploaded" category and each business will receive: <br/>1. The User ID will again be the businesses 10 digit phone number <br/>2. A new Password <br/>3. A new unique URL ID for Direct Browser Access and <br/>4. Temporary AD content will be auto inserted into each businesses Ad Space.', "Warning", "<?=base_url('Zonedashboard/action_performed_new_business')?>","", data, businesssuccess, null);
		}else if(action_performed==3 && action_performed_in_where==1 && business_delete_all_or_specific==1){
			ConfirmDialog('If you delete businesses data records from your database it will simultaneously delete the ads for each deleted business. <br/></br>When you upload the businesses again, each business will be placed into the "Businesses Uploaded" category and each business will receive: <br/>1. The User ID will again be the businesses 10 digit phone number <br/>2. A new Password <br/>3. A new unique URL ID for Direct Browser Access and <br/>4. Temporary AD content will be auto inserted into each businesses Ad Space.', "Warning", "<?=base_url('Zonedashboard/action_performed_new_business')?>","Deleting...<br/>This may take a minute", data, businesssuccess, null);
		}else if(action_performed==3 && action_performed_in_where==0 && business_delete_all_or_specific==2){
			ConfirmDialog('If you delete businesses data records from your database it will simultaneously delete the ads for each deleted business. <br/></br>When you upload the businesses again, each business will be placed into the "Businesses Uploaded" category and each business will receive: <br/>1. The User ID will again be the businesses 10 digit phone number <br/>2. A new Password <br/>3. A new unique URL ID for Direct Browser Access and <br/>4. Temporary AD content will be auto inserted into each businesses Ad Space.', "Warning", "<?=base_url('Zonedashboard/action_performed_new_business')?>","Deleting...<br/>This may take a minute", data, businesssuccess, null);
		}else if(action_performed==3 && action_performed_in_where==1 && business_delete_all_or_specific==2){
			ConfirmDialog('If you delete businesses data records from your database it will simultaneously delete the ads for each deleted business. <br/></br>When you upload the businesses again, each business will be placed into the "Businesses Uploaded" category and each business will receive: <br/>1. The User ID will again be the businesses 10 digit phone number <br/>2. A new Password <br/>3. A new unique URL ID for Direct Browser Access and <br/>4. Temporary AD content will be auto inserted into each businesses Ad Space.', "Warning", "<?=base_url('Zonedashboard/action_performed_new_business')?>","Deleting...<br/>This may take a minute", data, businesssuccess, null);
		}else{
			PageMethod("<?=base_url('Zonedashboard/action_performed_new_business')?>", "Action Performed...<br/>This may take a few minutes", data, businesssuccess, null);
		}	  
});
function businesssuccess(result){  //alert(JSON.stringify(result));return false; //alert(result);//alert(msg);
	$.unblockUI();
	var business_delete_all_or_specific=result.Title;
	/*var business_delete_all_or_specific=result.Tag;*/
		if(result.Title!=''){ //alert(businessid);
			if(business_delete_all_or_specific==1){
				$("input[name=checkadfordelete]:Checked").each(function(i,item){ //alert(2);
					//$('tr#'+$(item).val()).hide();
					$('.pretty').find('tr#'+$(this).val()).hide();
					$("input[name=checkadfordelete]:Checked").attr('checked',false);
					$("input[name=select_all_business_new]:Checked").attr('checked',false); 
				});
			}else if(business_delete_all_or_specific==2){
				$('.newbusiness').hide();
				//showListedBusiness(result.Message,'all');	
			}
		}
}
/////////////////////////////////////////////// Edit Business Part start ////////////////////////////////////////////////
$(document).on('click','.edit_business',function(){
	var id=$(this).attr('rel'); //alert(id);
	//$('.view_new_business').hide();
	//$('.edit_new_business').show();
	var businesstype=$(this).attr('data-businesstype'); //alert(businesstype);
	var businesstypebycategory=$(this).attr('data-businesstypebycategory'); //alert(businesstypebycategory);
	var businesszone=$(this).attr('data-businesszone');
	var data={businessid:id,zoneid:$('#zoneid').val(),businesstype:businesstype,businesstypebycategory:businesstypebycategory,businesszone:businesszone}
	PageMethod("<?=base_url('Zonedashboard/edit_new_business')?>", "Action Performed...<br/>This may take a few minutes", data, EditNonTempBusinessSuccess, null);
});
function EditNonTempBusinessSuccess(result){
	$.unblockUI();
	if(result.Tag!=''){
		$('.view_new_business').hide();
		$(".edit_new_business").show();
		$(".edit_new_business").html(result.Tag);
		var data={businessid:$('#biz_id').val(),zoneid:$('#biz_zone_id').val()}
		PageMethod("<?=base_url('Zonedashboard/view_edit_new_business')?>", "Action Performed...<br/>This may take a few minutes", data, ViewEditNonTempBusinessSuccess, null); 
	}
}
function ViewEditNonTempBusinessSuccess(result){ //alert(JSON.stringify(result));
	$.unblockUI();
	if(result.Tag!=''){
		var str=result.Tag;
		$('.edit_new_business').find('#biz_address_id').val(str.addressid);
		$('.edit_new_business').find('#biz_user_id').val(str.userid);
		$('.edit_new_business').find('#biz_addsetting_id').val(str.adsettingid);
		$('.edit_new_business').find('#biz_user_id').val(str.userid);
		$('.edit_new_business').find('#biz_name').val(str.name);
		$('.edit_new_business').find('#biz_motto').val(str.motto);
		$('.edit_new_business').find('#biz_email').val(str.contactemail); 		
		$('.edit_new_business').find('#biz_first_name').val(str.contactfirstname);
		$('.edit_new_business').find('#biz_last_name').val(str.contactlastname);
		$('.edit_new_business').find('#biz_address_1').val(str.street_address_1); 
		$('.edit_new_business').find('#biz_address_2').val(str.street_address_2);
		$('.edit_new_business').find('#biz_city').val(str.city);
		$('.edit_new_business').find('#biz_state').find('option[value='+str.state+']').attr('selected','selected');
		$('.edit_new_business').find('#biz_phone').val(str.phone); 
		$('.edit_new_business').find('#biz_website').val(str.website); 
		$('.edit_new_business').find('#biz_sic').val(str.siccode);
		$('.edit_new_business').find('#biz_username').val(str.username);
	}
}

$(document).on('click','#edit_update_new_business',function(){
	var tag=$(this).parent().parent().siblings();
	var businesstype=$(this).attr('data-businesstype'); //alert(businesstype); 
	var businesstypebycategory=$(this).attr('data-businesstypebycategory'); //alert(businesstypebycategory);
	var businesszone=$(this).attr('data-businesszone'); //alert(businesszone);return false;
	
	var data={businessid:$('#biz_id').val(),zoneid:$('#biz_zone_id').val(),biz_addsetting_id:$('#biz_addsetting_id').val(),biz_address_id:$('#biz_address_id').val(),biz_user_id:$('#biz_user_id').val(),businesstype:businesstype,businesstypebycategory:businesstypebycategory,businesszone:businesszone,biz_name:tag.find('#biz_name').val(),biz_motto:tag.find('#biz_motto').val(),biz_email:tag.find('#biz_email').val(),biz_first_name:tag.find('#biz_first_name').val(),biz_last_name:tag.find('#biz_last_name').val(),biz_address_1:tag.find('#biz_address_1').val(),biz_address_2:tag.find('#biz_address_2').val(),biz_city:tag.find('#biz_city').val(),biz_state:tag.find('#biz_state').val(),biz_phone:tag.find('#biz_phone').val(),biz_website:tag.find('#biz_website').val(),biz_sic:tag.find('#biz_sic').val(),biz_username:tag.find('#biz_username').val()}
	PageMethod("<?=base_url('Zonedashboard/update_edit_new_business')?>", "Action Performed...<br/>This may take a few minutes", data, UpdateEditNonTempBusinessSuccess, null); 
	
});
function UpdateEditNonTempBusinessSuccess(result){//alert(JSON.stringify(result));
	$.unblockUI();
	if(result.Tag!=''){
		$(".success").show();
	}
}
$(document).on('click','#back_to_business',function(){ 	
	/*var businesstype=$(this).attr('data-businesstype'); //alert(businesstype);
	var businesstypebycategory=$(this).attr('data-businesstypebycategory'); //alert(businesstypebycategory);
	var businesszone=$(this).attr('data-businesszone');
	$(".edit_new_business").hide();
	$('.view_new_business').show();
	if(businesstype==1 && businesstypebycategory=='pbntc'){
		$('.active_pbntc').click();
	}else if(businesstype==-1 && businesstypebycategory=='pbntc'){
		$('.deactive_pbntc').click();
	}else if(businesstype==2 && businesstypebycategory=='tbntc'){
		$('.active_tbntc').click();
	}else if(businesstype==-2 && businesstypebycategory=='tbntc'){
		$('.deactive_tbntc').click();
	}else if(businesstype==1 && businesstypebycategory=='pbtc'){
		$('.active_pbtc').click();
	}else if(businesstype==-1 && businesstypebycategory=='pbtc'){
		$('.deactive_pbtc').click();
	}else if(businesstype==2 && businesstypebycategory=='tbtc'){
		$('.active_tbtc').click();
	}else if(businesstype==-2 && businesstypebycategory=='tbtc'){
		$('.deactive_tbtc').click();
	}*/
});
/////////////////////////////////////////////// Edit Business Part end ////////////////////////////////////////////////
</script>