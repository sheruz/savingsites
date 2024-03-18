<input type="hidden" name="orgzoneid" id="orgzoneid" value="<?=$fromzoneid;?>" />
<input type="hidden" name="org_id" id="org_id" value="<?=$org_id;?>" />
<input type="hidden" name="zoneid" id="zoneid" value="<?=$common['zoneid']?>" />
<input type="hidden" name="orgnid" id="orgnid" value="<?=$common['organizationid']?>" />
<input type="hidden" name="fromzoneid" id="fromzoneid" value="<?=$fromzoneid?>" />
<input type="hidden" name="zoneid" id="zoneid" value="<?=$common['zoneid']?>" />
<input type="hidden" name="organization_id" id="organization_id" value="<?=$organizationid?>" />
<input type="hidden" id="announcement_limit" value="<?=$limit ?>" />
<input type="hidden" id="countallannouncements" value="<?=$countallannouncements ?>" />
<input type="hidden" id="right_contain" value="<?=$right_container ?>" />

<?php if(($common['organization_status']==1 || $common['usergroup']->group_id==4)){?>
<div class="main_content_outer"> 
    <div class="content_container view_broadcast_container">
        <div class="top-title">
            <h2>View Announcements</h2>
            <hr class="center-diamond">
        </div>
	    <div id="msg"></div>		
	    <div id="helpdiv" class="container_tab_header header-default-message" >
            <p>To edit an announcement click on the "Edit" button of the respective announcement. To delete an announcement click on the "Delete" button of the respective announcement. </p>
        </div>
        <div id="container_tab_content" class="container_tab_content">   
            <div id="tabs-1_x">
                <div> <?php if(!empty($announcement_list)){?>
                    <table class="pretty header" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">
                        <thead id="showhead">
                            <tr>
                                <th width="50%">Title</th>            
                                <th width="20%">Announcement Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="showannouncement">
                        <?php foreach ($announcement_list as $announce) {
						  echo '<tr id="'.$announce['announceId'].'"><td>'.$announce['announceTitle'].'</td><td>'.date('Y-m-d', strtotime($announce['announceDate'])).' '.$announce['announceTime'].'</td><td><input type="hidden" name="org_ann_id" id="org_ann_id" value="'.$announce['announceId'].'">
							<a href="javascript:void(0);"><button class="editButton m_top_10" onclick="EditBroadcast('.$announce['announceId'].');return false;">Edit</button></a><button class="deleteButton m_top_10" onclick="Deletebroadcast('.$announce['announceId'].',\''.$announce['announceTitle'].'\');return false;">Delete</button></td></tr>';
                        } ?>	
                        </tbody>
                    </table>
                    <?php }else{?>
       		           <p><div id="not_found" class="container_tab_header" style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;">No announcements found.</div></p>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }else if($common['organization_status']==-1 && $common['usergroup']->group_id==8){?>
<div class="main_content_outer"> 
  <div class="content_container">
  	<div class="container_tab_header">View Announcements</div>	
  	<div style="font-size:20px; line-height:25px; color:red;">Your organization is currently deactivated. Please contact your Zone Owner for more details.</div>
  </div>
</div>
<?php }?>


<script type="text/javascript">
/*$(document).ready(function () { 
	$('#organization_announcement_accordian').click();
	$('#organization_view_announcement').addClass('active');
	showallannouncement();
});*/

// $(document).ready(function () { 
// 	$('#organization_broadcast_accordian').click();
// 	$('#organization_broadcast_accordian').next().slideDown();
// 	$('#organization_view_broadcast').addClass('active');
// 	//showallannouncement();
// });


// // + variable initialization
// var zoneid = <?=$common['zoneid']?>;
// var orgid = <?=$common['organizationid']?>;
// var fromzoneid = <?=$fromzoneid?>;
// // - variable initialization

// // + check_authneticate
// function  check_authneticate(){ //alert(1);
// 	var is_authenticated=0;
// 		$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ //alert('success');
// 		is_authenticated=data;
// 	}});	
// 	return is_authenticated;
// }
// // - check_authneticate

// // + EditAnnouncement
// function EditAnnouncement(id){ 
// 	window.location.href = "<?=base_url('organizationdashboard/editBroadcast/') ?>" + "/" + orgid + "/" + fromzoneid +"/"+ id ;
//     //$("ad_business").val(id);
//     //PageMethod("<?=base_url('announcements/get')?>" + "/" + id, "", null, ShowAnnouncementEdit, null);
// }
// // - EditAnnouncement

// // + v
// function ShowAnnouncementEdit(result) { //alert(JSON.stringify(result)); return false; anishsett
//     $.unblockUI();//console.log(result.category);
//     ShowAnnouncementEditor(); 
// 	var maincat = result.category;					 
//     $("#announcement_id").val(result.id);
// 	$(".usersubcat").val(maincat);
//     $("#announcement_title").val(result.title);					//
//     CKEDITOR.instances.announcement_text.setData(result.announcement );
// 	$("#announcement_type").val(result.announcement_type);
// 	var categories_arr=result.category_for_admin.split(',');
// 	var categories=categories_arr[0];
// 	var subcategories=categories_arr[1];
// 	$('#all_categories').val(categories); 
// 	$('#all_categories').change(); 
// 	$('#my_announcements_limit').hide();			
// 	$('#ann_allsubcatshow_24').find('option[value=25]').attr('selected','selected');
// }
// // - ShowAnnouncementEdit

// //
// function DeleteAnnouncement(id, title) { 
// 	ConfirmDialog("Really delete : " + title, "Delete Announcement", "<?=base_url('announcements/delete_broadcast')?>", "Deleting Announcement<br/>This may take a minute",{"id": id ,"zoneid": zoneid,"orgid":orgid}, announceSaveSuccessful, null);
// }
// //

// //
// function announceSaveSuccessful(result) {
// 	$.unblockUI();
// 	if (result.Message != -1) {
// 		window.location.reload(true);
// 	}
// }
// // Pagination

// function showallannouncement(tag){ 
// 	var authenticate=check_authneticate();
// 	if(authenticate=='0'){
// 		var zone_id = <?=$common['zoneid']?>;			 
// 		alert('You are currently logged out. Please log in to continue.');
// 		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
// 	}else if(authenticate==1){ 
	 
// 	 var lowerlimit=''; var upperlimit=''; 
// 	 var $this=$(tag); 
// 	 var limit=$this.attr('rel');
// 	 if(limit=='' || limit==undefined){ 
// 		lowerlimit=0; upperlimit=5;
// 	 }else{	
// 		limit_final=limit.split(',');
// 		lowerlimit=limit_final[0]; upperlimit=limit_final[1];
		
// 	 }
// 		PageMethod("<?=base_url('organizationdashboard/viewmoreannouncement')?>/"+orgid+"/"+zoneid+"/"+lowerlimit+"/"+upperlimit, "Displaying the announcements...<br/>This may take a few minutes", null, showAccounceInformation, null);
// 	 }
// }
// function showAccounceInformation(result){ 
// 	$.unblockUI();
// 	var total_result=result.Title;
// 	var adsno=result.Title; 
	
// 	if(adsno>4)
// 	{
// 		$('#my_announcements_limit').show();
// 		$('#container_tab_content').find('.header').show();		
// 	}
// 	else
// 	{
// 		$('#my_announcements_limit').hide();
// 		$('#container_tab_content').find('.header').show();	
// 	}
	
// 	var limit=result.Message;
// 	if(result.Tag!=''){
// 		if(limit=='5,5'){
// 			$("#showannouncement").html('');
// 			$("#showannouncement").append(result.Tag);
// 			$('#annoucement_edit').hide();
			
// 			//$('#showhead').show();		//
			
// 		}else{
// 		$("#showannouncement").append(result.Tag);
// 		$('#annoucement_edit').hide();
// 		//$('.apmybusiness:gt(0)').hide();
// 		//$('#showhead').hide();			//
// 		}
// 		if(adsno == 0){
// 			$("#showannouncement").html('<div class="container_tab_header" style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;">No Announcements Found.</div>');
// 			$('.header').hide();
// 		}
// 		$('#my_announcements_limit').attr('rel',limit);	
// 	}
// }


</script>

 
