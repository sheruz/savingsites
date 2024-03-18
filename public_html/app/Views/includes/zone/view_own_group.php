<input type="hidden" name="createdby_id" id="createdby_id" value="<?= $common['top_header_name']['id']?>">
<input type="hidden" name="zonename" value="<?= $common['zoneid']?>">

<div class="main_content_outer"> 
  
<div class="content_container">
	<div class="container_tab_header">View Own Interest Group</div>
	<div id="container_tab_content" class="container_tab_content">

<!--------------------------------------------------------------------HelpTips------------------------------------------------------------>    
        <div id="help_shot" class="container_tab_header header-default-message" margin-top:10px;>
                <p>This shows the interest groups created by the Zone Owner.</p>
        </div>
<!--------------------------------------------------------------------HelpTips------------------------------------------------------------>            
        
         <div <?php /*?>style="background:#A0D889"<?php */?> id="update_message"></div>
			<div id="tabs-1_x">
                <table width="85%" class="pretty" style="margin:-1px;">
                    <tbody>
                    <?php if(!empty($view_group)) { ?>
                    <? foreach($view_group as $addApproveZone){?>
                    <tr id="<?=$addApproveZone['id']?>">
                    <td style="width:70%"><?=$addApproveZone['name']?></td>
                    <td style="width:20%">
                    <button id="<?=$addApproveZone['id']?>" class="editgrp" onclick="edit_group(<?=$addApproveZone['id']?>,<?=$zoneid?>,<?=$createdby_id?>,<?=$createdby_type?>)">Edit</button>   <button id="<?=$addApproveZone['id']?>" class="deletegrp" onclick="delete_group(<?=$addApproveZone['id']?>,<?=$zoneid?>,<?=$createdby_id?>,<?=$createdby_type?>)">Delete</button>
                    </td>
                    </tr>
                    <? } }
                    else
                    {
                    ?>
                    <tr><td colspan="2">No Interest Group Found.</td></tr>
                    <?php	
                    }
                    ?>
                    </tbody>
                </table>
            </div>        
        <div class="view_group"></div>
    </div>
</div>
</div>


<script type="text/javascript">
$(document).ready(function () { 
	$('#zone_ig_accordian').click();
	$('#zone_own_ig').addClass('active');
	$('#tab1').click();
});

// + check_authneticate
function  check_authneticate(){ //alert(1);
	var is_authenticated=0;
	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ //alert('success');
		is_authenticated=data;
	}});	
	return is_authenticated;
}
// - check_authneticate

// + Varible Initialization
var zoneid = <?=$common['zoneid']?>;
// - Varible Initialization


// + edit_group
function edit_group(group_id,zoneid,createdby_id,createdby_type){ 
		var authenticate=check_authneticate();
		if(authenticate=='0'){
		var zone_id = <?=$zoneid?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){ 
		 	//$('.pretty').show();
			var dataToUse = {
				"group_id":group_id,
				"zoneid":zoneid,
				"createdby_id":createdby_id,
				"createdby_type":createdby_type
			};
			PageMethod("<?=base_url('emailnotice/edit_group')?>", "Open the add new Group form...<br/>This may take a few minutes", dataToUse, requestEditAddSuccess, null);
		 }
	}
	function requestEditAddSuccess(result){ //alert(JSON.stringify(result));
	$.unblockUI();
	if(result.Tag!=''){
		$('.pretty').hide();
		$(".view_group").html(result.Tag).show();
	}
}
// - edit_group


$(document).ready(function(){ //alert(1); return false;	
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
function requestGroupSuccess(result){			//alert(JSON.stringify(result.Message)); return false;
		$.unblockUI();
		if(result.Message=='Group is updated successfully!')
		{	
			$('#update_message').html('<h4 style="color:#090">Interest Group successfully edited</h4>').show();
			$('html,body').animate({scrollTop:0},"slow");
			setTimeout(function(){
				$('#update_message').hide('slow');
				}, 3000);
			//$('#group_name').val('');
			//$('#add_desc').val('');
		}
		//$("#msg").html(result.Message);
	}
// - save_group/Success


// + delete_group/Success
function delete_group(id){ //alert(id);
		var authenticate=check_authneticate();
		if(authenticate=='0'){
		var zone_id = <?=$zoneid?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){
			data={ id:id}					
			ConfirmDialog("Do you really want to delete this interest group?", "Warning", "<?=base_url('emailnotice/delete_group')?>","Deleting...<br/>This may take a minute", data, groupdeletesuccess, null);
		 }
	}
function groupdeletesuccess(result){ 
	$.unblockUI();
	if(result.Tag!=''){
		var id=result.Tag;
		$('tr#'+id).hide(); 
		$('#update_message').show();
		$('#update_message').html('<h4 style="color:#090">Email Notice successfully deleted</h4>');
			$('html,body').animate({scrollTop:0},"slow");
			setTimeout(function(){
				$('#update_message').hide('slow');
			}, 3000);
	}
	//$('.deletegrp').hide();
	//$('tr#'+$(item).val()).hide();	
}
// - delete_group/Success
</script>