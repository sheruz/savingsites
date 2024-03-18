
<input type="hidden" name="orgzoneid" id="orgzoneid" value="<?=$fromzoneid;?>" />
<input type="hidden" name="org_id" id="org_id" value="<?=$org_id;?>" />
<input type="hidden" name="zoneid" id="zoneid" value="<?=$common['zoneid']?>" />

<input type="hidden" name="orgnid" id="orgnid" value="<?=$common['organizationid']?>" />



<?php if(($common['organization_status']==1 || $common['usergroup']->group_id==4)){?>		<!--This is to check that if the organization is  deactivated then the particular will not show up in when logged in as Organziation Dashboard-->

<div class="main_content_outer interest_group_main_content"> 

  

<div class="content_container">
	    <div class="top-title">
          <h2>View Interest Group</h2>
          <hr class="center-diamond">
        </div>

	<div id="view-interest-group" class="container_tab_content">
    <ul id="tabs-nav">
    <li class="active"><a href="#tab1" id="tab1" onclick="display_ig(<?=$common['zoneid']?>,<?=$common['organizationid']?>,3,0);">New Interest Group For Approval</a></li>
    <li><a href="#tab2" onclick="display_ig(<?=$common['zoneid']?>,<?=$common['organizationid']?>,3,1);">Activated Interest Group</a></li>
    <li><a href="#tab3" onclick="display_ig(<?=$common['zoneid']?>,<?=$common['organizationid']?>,3,2);">Deactivated Interest Group</a></li>
  </ul>


        

<!---------------------------------------------------------------------Help Tips------------------------------------------------------------->

				<!--<div class="container_tab_header header-default-message"  style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:0px;">

            		<div class="btn-group-2" align="left">

                    	This section will show the created Announcements.

						<a href="javascript:void(0);" class="fright" onclick="$('#helpdiv').slideToggle('slow')"><img alt="Help Tips" title="Help Tips" src="<?=base_url()?>assets/images/help.png" style="margin:3px 0 0 10px" width:"28px" height="28px"/></a>

                    </div>

            	</div>

                	-->

                <div id="helpdiv" class="container_tab_header header-default-message bv_head_wraper" margin-top:10px;>

                    <p>  

                    To edit an interest group click on the "Edit" button of the respective interest group . 

                    To delete an interest group click on the "Delete" button of the respective interest group . 

                	</p>
                <table class="pretty" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">
                    <thead>
                        <tr>
                            <th width="65%">Interest Group</th>
                            <th width="30%">Action</th>
                        </tr>
                    </thead>
                    <tbody id="interestgroupdata"></tbody>
                </table>
            </div>

                

<!---------------------------------------------------------------------Help Tips------------------------------------------------------------->

        

        <div id="tabs-1" class="form-group center-block-table">

            <div class="view_group"></div>

        </div>

        <div id="tabs-2">

            <div class="view_group"></div>

        </div>

        

        <div id="tabs-3" class="form-group center-block-table">

            <div class="view_group"></div>

        </div>

        

    </div>

    

    

</div>



</div>



<?php }else if($common['organization_status']==-1 && $common['usergroup']->group_id==8)

{?>

<div class="main_content_outer"> 

  <div class="content_container">

  	<div class="container_tab_header">View Interest Group</div>	

  	<div style="font-size:20px; line-height:25px; color:red;">Your organization is currently deactivated. Please contact your Zone Owner for more details.</div>

  </div>

</div>

<?php }?>





<!-- New functions addded on 25/6/14-->

<script type="text/javascript">

// $(document).ready(function () { 

// 	$('#organization_ig_accordian').click();

// 	$('#organization_view_ig').addClass('active');

// 	$('#tab1').click();

// });



// function check_authneticate(){ //alert(1);

// 	var is_authenticated=0;

// 	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ //alert('success');

// 		is_authenticated=data;

// 	}});	

// 	return is_authenticated;

// }



// function display_ig(zoneid,createdby_id,createdby_type,ig_type){ //alert(zoneid); alert(busid);

// 	var authenticate=check_authneticate();

// 	if(authenticate=='0'){

// 		var zone_id = <?=$common['zoneid']?>;			 

// 		alert('You are currently logged out. Please log in to continue.');

// 		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

// 	}else if(authenticate==1){

// 		 $('.pretty').show();

// 		var dataToUse = {

// 			"zoneid":zoneid,

// 			"createdby_id":createdby_id,

// 			"ig_type":ig_type,

// 			"createdby_type":createdby_type

// 		}

// 		PageMethod("<?=base_url('emailnotice/display_ig')?>", "Displaying the Interest Group...<br/>This may take a few minutes", dataToUse, requestGroupDisplayByBusinessSuccess, null);

// 	 }

// }

// function requestGroupDisplayByBusinessSuccess(result){

// 	$.unblockUI();

// 	if(result.Tag!=''){

// 		//$('#view_group_upperpart').show();

// 		$(".view_group").html(result.Tag);

// 	}

// }



// /* Edit IG START */

// function edit_group(group_id,zoneid,createdby_id,createdby_type){ 

// 		var authenticate=check_authneticate();

// 		if(authenticate=='0'){

// 		var zone_id = <?=$common['zoneid']?>;			 

// 		alert('You are currently logged out. Please log in to continue.');

// 		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

// 	}else if(authenticate==1){

// 			var dataToUse = {

// 				"group_id":group_id,

// 				"zoneid":zoneid,

// 				"createdby_id":createdby_id,

// 				"createdby_type":createdby_type

// 			}

// 			PageMethod("<?=base_url('emailnotice/edit_group')?>", "Open the add new Group form...<br/>This may take a few minutes", dataToUse, requestEditAddSuccess, null);

// 		 }

// 	}

// 	function requestEditAddSuccess(result){ //alert(JSON.stringify(result));

// 	$.unblockUI();

// 	if(result.Tag!=''){

// 		$('.pretty').hide();

// 		$(".view_group").html(result.Tag);

// 	}

// }



// function save_group(zoneid,createdby_id,createdby_type,group_id,group_name,add_desc){ //console.log($('#group_name').val()); return false;

// 	//alert(zoneid+' '+createdby_id+' '+createdby_type+' '+group_id+' '+group_name+' '+add_desc); return false;

// 		var authenticate=check_authneticate();

// 		if(authenticate=='0'){

// 		var zone_id = <?=$common['zoneid']?>;			 

// 		alert('You are currently logged out. Please log in to continue.');

// 		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

// 	}else if(authenticate==1){

// 			if($('#group_name').val()==''){

// 				alert("Please Provide Group Name");

// 				return false;

// 			}

// 			var dataToUse = {

// 				"zoneid":zoneid,

// 				"createdby_id":createdby_id,

// 				"createdby_type":createdby_type,

// 				"group_id":group_id,

// 				"group_name":group_name,

// 				"group_desc":add_desc,

// 			 };

// 			PageMethod("<?=base_url('emailnotice/save_group')?>", "Saving the new Group...<br/>This may take a few minutes", dataToUse, requestGroupSuccess, null);

// 		 }

// 	}

// 	function requestGroupSuccess(result){

// 		//alert(JSON.stringify(result));

// 		$.unblockUI();

// 		if(result.Message=='Group is updated successfully!')

// 		{	

// 			$('#update_message').html('<h4 style="color:#090">Interest Group successfully edited</h4>');

// 			$('html,body').animate({scrollTop:0},"slow");

// 			setTimeout(function(){

// 				$('#update_message').hide('slow');

// 				}, 3000);

// 			$('#group_name').val('');

// 			$('#add_desc').val('');

// 		}

// 		//if(result.Tag!='update')

// //		{

// //			$("#group_name").val('');

// //			$('textarea#add_desc').val('');

// //		}

// //		$("#msg").html(result.Message);

// 	}

// /* Edit IG END */	



// /* Delete IG START */



// function delete_group(id){ 

// 		var authenticate=check_authneticate();

// 		if(authenticate=='0'){

// 		var zone_id = <?=$common['zoneid']?>;			 

// 		alert('You are currently logged out. Please log in to continue.');

// 		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

// 	}else if(authenticate==1){

// 			data={ id:id}					

// 			ConfirmDialog("Are you sure to delete this interest group?", "Warning", "<?=base_url('emailnotice/delete_group')?>","Deleting...<br/>This may take a minute", data, groupdeletesuccess, null);

// 		}

// 	}

			

// 	function groupdeletesuccess(result){ 

// 	$.unblockUI();

// 	if(result.Tag!=''){ 

// 		var id=result.Tag;

// 		$('tr#'+id).hide();

// 		window.location.reload(); 	

// 	}	

// }

/* Delete IG END */

</script>











 







