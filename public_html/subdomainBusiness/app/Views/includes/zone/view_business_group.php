<input type="hidden" id="zoneid" value="<?=$common['zoneid'];?>" />
<input type="hidden" id="show_ig_type" name="show_ig_type" value="">
 
<div class="main_content_outer"> 
  
<div class="content_container form-group">
	<div class="container_tab_header">View Business Interest Group</div>
	<div id="container_tab_content" class="container_tab_content">
        <ul>
        <li><a href="#tabs-1" id="tab1" onclick="show_ig_submenu(1);" <?php /*?>onclick="display_ig_for_business_by_zone(<?=$common['zoneid']?>,1);"<?php */?>>Activated Interest Group</a></li>
        <!--<li><a href="#tabs-2" onclick="show_ig_submenu(0);" <?php /*?>onclick="display_ig_for_business_by_zone(<?=$common['zoneid']?>0);"<?php */?>>New Interest Group For Approval</a></li>-->
        <li><a href="#tabs-3" onclick="show_ig_submenu(2);" <?php /*?>onclick="display_ig_for_business_by_zone(<?=$common['zoneid']?>,2);"<?php */?>>Deactivated Interest Group</a></li>
        </ul>
        
        <div <?php /*?>style="background:#A0D889"<?php */?> id="update_message"></div>
         
        <div id="tabs-1">
<!--------------------------------------------------------------------HelpTips------------------------------------------------------------>    
        <div id="help_shot" class="container_tab_header header-default-message" margin-top:10px;>
                <p>This shows the "Activated Interest Groups" which are created by the Business Owner. Select from the drop-down list the names of Organization and then click on the "Show" button. If you do not want to deactivate the group(s) click on the "Deactivate" option.</p>
        </div>
<!--------------------------------------------------------------------HelpTips------------------------------------------------------------>        
            <div class="bus_submenu"></div>
            <div class="view_group" ></div>
        </div>
        	
        <div id="tabs-2" style="display:none">
<!--------------------------------------------------------------------HelpTips------------------------------------------------------------>    
        <div id="help_shot" class="container_tab_header header-default-message" margin-top:10px;>
                <p>This shows the "New Interest Group For Approval" which are created by the Business Owner. Select from the drop-down list the names of Organization and then click on the "Show" button. If you do not want to approve the group(s) click on the "Deactivate" option. Or if you want to approve then click on the "Activate" option.</p>
        </div>
<!--------------------------------------------------------------------HelpTips------------------------------------------------------------>        
        	<div class="bus_submenu"></div>
            <div class="view_group" ></div>
        </div>
        
        <div id="tabs-3">
<!--------------------------------------------------------------------HelpTips------------------------------------------------------------>    
        <div id="help_shot" class="container_tab_header header-default-message" margin-top:10px;>
                <p>This shows the "Deactivated Interest Groups" which are created by the Business Owner. Select from the drop-down list the names of Organization and then click on the "Show" button. If you want to activate the group(s) click on the "Activate" option.</p>
        </div>
<!--------------------------------------------------------------------HelpTips------------------------------------------------------------>        
        	<div class="bus_submenu"></div>
            <div class="view_group" ></div>
        </div>
    </div>
</div>
</div>


<script type="text/javascript">
$(document).ready(function () { 
	$('#adv_tools').click();
	$('#adv_tools').next().slideDown();
	$('#igroup').click();
	$('#igroup').next().slideDown();
	$('#zone_business_ig').addClass('active');
	$('#tab1').click();
});

// + Varible Initialization
var zoneid = <?=$common['zoneid']?>;
// - Varible Initialization


// + check_authneticate
function  check_authneticate(){ 
	var is_authenticated=0;
	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ //alert('success');
		is_authenticated=data;
	}});	
	return is_authenticated;
}
// - check_authneticate

// + business submenu for ig
function show_ig_submenu(approval){ 
	var authenticate=check_authneticate();
	if(authenticate=='0'){
		var zone_id = <?=$zoneid?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){
		 $(".view_group").html('');
		 $('#show_ig_type').val(approval);
		 var dataToUse = {
			"zoneid":zoneid,
			"status":approval
		 };		 
		 PageMethod("<?=base_url('Zonedashboard/zonebusinessig_submenu')?>", "", dataToUse, submenusuccess, null);
	 }
}
function submenusuccess(result){
	$.unblockUI();
	if(result.Tag!=''){
		$('.bus_submenu').html(result.Tag);
		$('.showig').click();
	}
}
// - business submenu for ig

// + display_ig_for_business_by_zone/Success
function display_ig_for_business_by_zone(zoneid){	
		var authenticate=check_authneticate();
		if(authenticate=='0'){
		var zone_id = <?=$zoneid?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){
			 var ig_type=$('#show_ig_type').val();
			 var busid=$('.all_business').val();			
			 var dataToUse = {
				"zoneid":zoneid,
				"ig_type":ig_type,
				"busid":busid
			 };
			 PageMethod("<?=base_url('emailnotice/view_groups_business_by_zone')?>", "Displaying the Interest Group...<br/>This may take a few minutes", dataToUse, requestGroupDisplayByZoneSuccess, null);
		 }
	}

function requestGroupDisplayByZoneSuccess(result){
	$.unblockUI();
	$(".view_group").html(result.Tag);
}
// - display_ig_for_business_by_zone/Success

// + To make the business interest group approved/unapproved/Success
function group_approve_by_zone(id,status){
	var authenticate=check_authneticate();
	if(authenticate=='0'){
		var zone_id = <?=$zoneid?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){
		 var dataToUse = {
			"id":id,
			"status":status
		 };
		 $('tr#'+id).hide();
		 $('.pretty').find('tr#'+id).hide();
		 PageMethod("<?=base_url('emailnotice/update_groups_business_by_zone')?>", "Updating...<br/>This may take a few minutes", dataToUse, group_approve_by_zone_successs, null);
	 }
}
function group_approve_by_zone_successs(result){
	$.unblockUI();
}
// + To make the business interest group approved/unapproved/Success


// + display_ig/Success
// - display_ig/Success


$(document).ready(function(){	
	$(document).on('submit','#edit_group_zone',function(){
		var _t = $(this);
		var authenticate=check_authneticate();
		if(authenticate=='0'){
		var zone_id = <?=$zoneid?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){
			if($('#group_name').val()==''){
				alert("Please Provide Group Name");
				return false;
			}
			var dataToUse = {
				"zoneid":_t.find('#zoneid').val(),
				"createdby_id":_t.find('#createdby_id').val(),
				"createdby_type":_t.find('#createdby_type').val(),
				"group_id":_t.find('#group_id').val(),
				"group_name":_t.find('#group_name').val(),
				"group_desc":_t.find('#add_desc').val(),
			 };
			PageMethod("<?=base_url('emailnotice/save_group')?>", "Saving the new Group...<br/>This may take a few minutes", dataToUse, requestGroupSuccess, null);
		 }
		return false;
	})	
})
function requestGroupSuccess(result){		//alert(JSON.stringify(result.Message)); return false;
		$.unblockUI();
		if(result.Message=='Group is updated successfully!')
		{	
			$('#update_message').html('<h4 style="color:#090">Interest Group successfully edited</h4>');
			$('html,body').animate({scrollTop:0},"slow");
			setTimeout(function(){
				$('#update_message').hide('slow');
				}, 3000);
			$('#group_name').val('');
			$('#add_desc').val('');
		}
		//$("#msg").html(result.Message);
	}
// - save_group/Success


</script>