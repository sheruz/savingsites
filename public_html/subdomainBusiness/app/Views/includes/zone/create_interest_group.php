<input type="hidden" name="createdby_id" id="createdby_id" value="<?= $common['top_header_name']['id']?>">
<input type="hidden" name="zonename" value="<?= $common['zoneid']?>">

<div class="main_content_outer"> 
	<div class="content_container">
		<div class="container_tab_header">Add Interest Group</div>
        <div <?php /*?>style="background:#A0D889"<?php */?> id="update_message"></div>
			<div id="container_tab_content" class="container_tab_content">
                    <div class="form-group center-block-table">
                        <table align="center" class="admin-table" cellpadding="4" cellspacing="6">
                          	<input type="hidden" id="group_id" name="group_id" value="-1" />
                              <tr>
                              	<td width="50%"><label for="grpname" class="fleft w_100">Group Name</label></td>
								<td width="40%"><input  type="text" id="group_name" class="w_300" name="group_name"/>
			 					<br/></td>
                              </tr>
                              
                              <tr>
                              	<td width="50%"><label for="description" class="fleft w_100">Description</label></td>
								<td width="40%"><textarea id="add_desc" name="add_desc" class="w_300"></textarea></td>
                              </tr>
                              
                              <tr>
                                <td width="50%"></td>
                                <td width="40%"><button onclick="save_group(<?=$common['zoneid']?>,<?=$createdby_id?>,1,$('#group_id').val(),$('#group_name').val(),$('#add_desc').val());">Save Group</button></td>
                              </tr>
                              
                        </table>
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
	$('#zone_create_ig').addClass('active');
});

// + check_authneticate
function  check_authneticate(){ 
	var is_authenticated=0;
	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ //alert('success');
		is_authenticated=data;
	}});	
	return is_authenticated;
}
// - check_authneticate

// + Variable Initialization
var zoneid = <?=$common['zoneid']?>;
// - Variable Initialization

// + save_group/success
function save_group(zoneid,createdby_id,createdby_type,group_id,group_name,add_desc){ 
	var authenticate=check_authneticate();
	if(authenticate=='0'){
		var zone_id = <?=$common['zoneid']?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){
		if($('#group_name').val()==''){
			alert("Please Provide Group Name");
			return false;
		}
		var dataToUse = {
			"zoneid":zoneid,
			"createdby_id":createdby_id,
			"createdby_type":createdby_type,
			"group_id":group_id,
			"group_name":group_name,
			"group_desc":add_desc,
		};	
		//console.log(dataToUse); return false;		
	PageMethod("<?=base_url('emailnotice/save_group')?>", "Saving the new Group...<br/>This may take a few minutes", dataToUse, requestGroupSuccess, null);
	 }
}

function requestGroupSuccess(result){	//alert(JSON.stringify(result.Tag)); return false;
		$.unblockUI();
		if(result.Tag!='update')
		{
			$('#update_message').html('<h4 style="color:#090">New Interest Group successfully created</h4>');
			$('html,body').animate({scrollTop:0},"slow");
			setTimeout(function(){
				$('#update_message').hide('slow');
				}, 3000);
			$('#group_name').val('');
			$('#add_desc').val('');
			$('#update_message').show();		
		}
		//$("#msg").html(result.Message);
	}
// - save_group/success
</script>