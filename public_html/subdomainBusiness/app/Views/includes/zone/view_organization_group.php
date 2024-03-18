<input type="hidden" id="zoneid" value="<?=$zoneid; ?>">
<input type="hidden" id="show_ig_type" value="" />

<div class="main_content_outer"> 
  
<div class="content_container form-group">
	<div class="container_tab_header">View Organization Interest Group</div>
	<div id="container_tab_content" class="container_tab_content">
        <ul>
        <li><a href="#tabs-1" id="tab1" onclick="show_ig_submenu(1);"<?php /*?>onclick="display_ig(<?=$zoneid?>,<?=$common['businessid']?>,2,1);"<?php */?>>Activated Interest Group</a></li>
        <!--<li><a href="#tabs-2" onclick="show_ig_submenu(0);"<?php /*?>onclick="display_ig(<?=$zoneid?>,<?=$common['businessid']?>,2,0);"<?php */?>>New Interest Group For Approval</a></li>-->
        <li><a href="#tabs-3" onclick="show_ig_submenu(2);"<?php /*?>onclick="display_ig(<?=$zoneid?>,<?=$common['businessid']?>,2,2);"<?php */?>>Deactivated Interest Group</a></li>
        </ul>
         <div <?php /*?>style="background:#A0D889"<?php */?> id="update_message"></div>
         															<!-- Activated -->
        <div id="tabs-1">
<!--------------------------------------------------------------------HelpTips------------------------------------------------------------>    
        <div id="help_shot" class="container_tab_header header-default-message" margin-top:10px;>
                <p>This shows the "Activated Interest Groups" which are created by the Organization Owner. Select from the drop-down list the names of Organization and then click on the "Show" button. If you do not want to approve the group(s) click on the "Deactivate" option.</p>
        </div>
<!--------------------------------------------------------------------HelpTips------------------------------------------------------------>        
            <div class="org_ig_submenu"></div>
            <div class="view_group" ></div>
        </div>
         															<!-- New -->        
        <div id="tabs-2" style="display:none">
<!--------------------------------------------------------------------HelpTips------------------------------------------------------------>    
        <div id="help_shot" class="container_tab_header header-default-message" margin-top:10px;>
                <p>This shows the "New Interest Group For Approval" which are created by the Organization Owner. Select from the drop-down list the names of Organization and then click on the "Show" button. If you do not want to approve the group(s) click on the "Deactivate" option. Or if you want to approve then click on the "Activate" option.</p>
        </div>
<!--------------------------------------------------------------------HelpTips------------------------------------------------------------>       
			<div class="org_ig_submenu"></div>
            <div class="view_group" ></div>
        </div>       
         															<!-- Dectivated -->           
        <div id="tabs-3">
<!--------------------------------------------------------------------HelpTips------------------------------------------------------------>    
        <div id="help_shot" class="container_tab_header header-default-message" margin-top:10px;>
                <p>This shows the "Deactivated Interest Groups" which are created by the Organization Owner. Select from the drop-down list the names of Organization and then click on the "Show" button. If you do not want to approve the group(s) click on the "Activate" option.</p>
        </div>
<!--------------------------------------------------------------------HelpTips------------------------------------------------------------>        
			<div class="org_ig_submenu"></div>            <div class="view_group" ></div>
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
	$('#zone_org_ig').addClass('active');
	$('#tab1').click();
});

// + Varible Initialization
var zoneid = <?=$zoneid?>;
// - Varible Initialization

// + check_authneticate
function check_authneticate(){ //alert(1);
	var is_authenticated=0;
	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ //alert('success');
		is_authenticated=data;
	}});	
	return is_authenticated;
}
// - check_authneticate

// + submenu
function show_ig_submenu(approval){	
var authenticate=check_authneticate();
	if(authenticate=='0'){
		var zone_id = <?=$zoneid?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){	
	 $('#show_ig_type').val(approval);
	 $(".view_group").html('');
	 var dataToUse = {
		 		"zoneid" : zoneid,
				"status" : approval
		 };
		PageMethod("<?=base_url('Zonedashboard/zoneorg_submenu')?>", "", dataToUse, submenusuccess, null);	
	 }
}

function submenusuccess(result){
	$.unblockUI();
	if(result.Tag!=''){
		$('.org_ig_submenu').html(result.Tag);
		$('.showig').click();
	}
}

// - submenu

// + Ig Lists
function display_ig_for_org_by_zone(zoneid){		
	var authenticate=check_authneticate();
	if(authenticate=='0'){
		var zone_id = <?=$zoneid?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){
		 var ig_type=$('#show_ig_type').val();
		 var orgid=$('.all_org').val();
		 var dataToUse = {
			"zoneid":zoneid,
			"ig_type":ig_type,
			"orgid":orgid
		 };
		 PageMethod("<?=base_url('emailnotice/view_groups_org_by_zone')?>", "Displaying the Interest Group...<br/>This may take a few minutes", dataToUse, requestGroupDisplayByZoneSuccess, null);
	 }
}
	
function requestGroupDisplayByZoneSuccess(result){
	$.unblockUI();
	$(".view_group").html(result.Tag);
}

// - Ig Lists

// + Ig Approvals
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
		 PageMethod("<?=base_url('emailnotice/update_groups_business_by_zone')?>", "Updating...<br/>This may take a few minutes", dataToUse, group_approve_by_zone_successs, null);
	 }
}
function group_approve_by_zone_successs(result){
	$.unblockUI();
	window.location.reload();
}
// - Ig Approvals
</script>