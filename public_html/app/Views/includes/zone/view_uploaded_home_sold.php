

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
<div class="container_tab_header" id="container_tab_header">View Uploaded Home Sold</div>
	<div id="container_tab_content" class="container_tab_content">
    <div id="msg" style="display:none;"></div>
        <div id="tabs-1_x">
        
        <!--<div class="container_tab_header form-group" style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:0px; padding:16px;">
        <a class="fright" href="javascript:void(0);" onclick="$('#search_org').slideToggle('slow')"><img src="<?=base_url()?>assets/images/find.png" style="margin:-9px 0 0 4px" width:"20px" height="20px" alt="Search Organization" title="Search Organization"/></a>
         </div>-->

 <!-- Search Part Start -->
    <div class="container_tab_header form-group" id="search_org" style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:0px;display:none;">
        <div class="bus_search_pbntc_active">
            <input type="text" id="text_org_search" name="text_org_search" placeholder="Direct search by street name/number" style="width:240px;" />
            <button class="btn-sm"  id="text_org_search_btn" type="button" onclick="showHomeSold(<?=$zoneid?>,$('#text_org_search').val(),'',$('.organization_type').val());">Search</button>
        </div>
 <!-- Search Part End -->            
            
            <!--<div id="organization_search">
              <input type="text" id="org_search" name="org_search" class="w_300" placeholder="Direct search by organization name" />
              <button class="showbusiness" onclick="showHomeSold(<?=$zoneid?>,$('#org_search').val());" style="margin-left:5px;">Search</button><br/>
            </div>-->
           
            
        </div>
        <div id="organizationheader">
          <table class="pretty" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">
            <thead>
              <tr>
                    <th width="20%">Street</th>
                    <th width="10%">City</th>
                    <th width="10%">SOld Price($)</th>
                    <th width="10%">Closed Date</th>
                    <th width="10%">Bedrooms</th>
                    <th width="10%">Bathrooms</th>
                    <th width="10%">Select/<br/>
                    Deselect All<br/>
                    <input type="checkbox" name="select_all_organizations" id="select_all_organizations"  value="all" title="Select/Deselect All" alt="Select/Deselect All"></th> 
                    <!--<th>Admin</th>-->
              </tr>
            </thead>
              <tbody id="showorganization">
                <tr class="headerclass_organization">
                  <td colspan="8"><div id="action_performed_div" class="apmybusiness fright">
                      <select name="action_performed" id="action_performed" class="action_performed_mybusiness w_215 select_style_sm" style="float:left;">                        <option value="2">Delete</option>
                      </select>
                      
                      <select name="organization_delete_all_or_specific" id="organization_delete_all_or_specific" class="w_215 select_style_sm">
                        <option value="1">Selected Home Sold</option>
                        <option value="2">All Home Sold</option>
                      </select>
                      <button class="btn-sm" id="delete_home_sold" type="button" organization_type="$('.organization_type').val()">Update</button>
                    </div></td>
                </tr>
    			</tbody>
          </table>
        </div>
        <div id="showorganizationdetail"></div>
        <div id="more_organization" class="text-default" style="float: right; margin-top: 22px;"><a id="more_organization_limit" href="javascript:void(0)" onclick="showHomeSold(<?=$zoneid?>,'all',this,$('.organization_type').val());" style=" color:#000;" rel="0,0">Display More Homes Sold</a> </div>
        </div>      
</div>

</div>
<script type="text/javascript">
$(document).ready(function () { 
$('#adv_tools').click();
	$('#adv_tools').next().slideDown();
	$('#zonerealtor').click();
	$('#zonerealtor').next().slideDown();
	$('#zone_view_home_sold').addClass('active');
	$('#zone_neighbor_accordian').click();
	$('#zone_view_home_sold').addClass('active');
	//$('.active_org').click().addClass('active');
	window.onload=showHomeSold();
});
</script>

<script>
var default_zone = '<?=$zoneid;?>';
var temp_zone_id = '<?=$zoneid;?>';
function  check_authneticate(){ //alert(1);
	var is_authenticated=0;
	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ //alert('success');
		is_authenticated=data;
	}});	
	return is_authenticated;
}

// + Tab change activities
function resetsearch(){
	$('#text_org_search').val('');
	$('#select_org_by_char option[value="-1"]').attr('selected','selected');
	$('#organization_delete_all_or_specific option[value="1"]').attr('selected','selected');
	$('#select_all_organizations').removeAttr('disabled');
	$('#action_performed option[value=1]').attr('selected','selected').change();
}

// - Tab change activities

$('#action_performed_div').change(function() {
	var selectVal = $('#action_performed :selected').val();
	if(selectVal == 1){
		$('#change_organization_status').show();
	}else if(selectVal == 2){
		$('#change_organization_status').hide();
	}
});

///////////////////////////////////////////////// + To view Organization + 
function showHomeSold(zoneid,charval,tag,type){
	 var authenticate=check_authneticate(); 
	 if(authenticate=='0'){
		var zone_id = <?=$zoneid?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){		 
		 $('.myorgsearch').click(function(){
			$('#org_search').val('');
		});
		var lowerlimit=''; var upperlimit=''; 
		var $this=$(tag);
		var limit=$this.attr('rel'); 
		if(limit=='' || limit==undefined){
			lowerlimit=0; upperlimit=15;
		}else{
			limit_final=limit.split(',');
			lowerlimit=limit_final[0]; upperlimit=limit_final[1];			
		}
		if($('#text_org_search').val()!='' && $('#select_org_by_char option:selected').val()!='-1'){
			alert('Please Select One Search Criteria..');
			return false;
		}
		
		var charval = 'all';
		
		var message="Displaying The Home Sold List...<br/>This may take a few seconds...";
															// form the button  seding the tab value and thus sending tag in the pagemethod
		PageMethod("<?=base_url('Zonedashboard/showHomeSold')?>/"+default_zone+"/"+charval+"/"+lowerlimit+"/"+upperlimit, message, null, showAccounceInformationOrg, null);
}}
	
function showAccounceInformationOrg(result){
	$.unblockUI();//alert(JSON.stringify(result.Title));
	if(result.Tag!=''){	
	var total_result=result.Title;
	if(total_result==0){
		$('#more_organization').hide();
		$('#margin_bottom_width').show();
	}
	else
	{	
		if(total_result<15){
			$('#more_organization').hide();
			$('#margin_bottom_width').show();
		}
		else{
			$('#more_organization').show();
			$('#margin_bottom_width').hide();
		}
	}
	var limit=result.Message;
	limit_final=limit.split(',');
	lowerlimit=limit_final[0];
	if(limit=='15,15' || lowerlimit=='0'){ 
		$("#showorganizationdetail").html(' ');
		$("#showorganizationdetail").show();
		$("#showorganizationdetail").append(result.Tag);
		
	}else{
		$("#showorganizationdetail").show();
		$("#showorganizationdetail").append(result.Tag);
	}
	// + Notification for no Organization Found
			if($('#showorganizationdetail').find('tr').hasClass("org_row") == false){
				$('#organizationheader').hide();
				$("#showorganizationdetail").html(result.Tag);
			}
			else{
				$('#organizationheader').show();
			}
	// - Notification for no Organization Found		
		$('#more_organization_limit').attr('rel',limit);	
	}
}
///////////////////////////////////////////////// - To view Organization -


///////////////////////////////////////////////// + Update view Organization +
$('#organization_delete_all_or_specific').change(function(){
	if($(this).val() == 1){ 
		$('#tabs-1_x input:checkbox').removeAttr('disabled');
	}else if($(this).val() == 2){ 
		$('#tabs-1_x input:checkbox').attr('disabled', 'disabled'); 
	}
		//alert($(this).val());//$('.display_checkbox1').attr('checked','checked');
});
$(document).on('click','#delete_home_sold',function(){
 var authenticate=check_authneticate(); //alert(a);
 if(authenticate=='0'){
		var zone_id = <?=$zoneid?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){ 
		var action_performed = $('#action_performed :selected').val();		// Delete or change
		//var change_business_status = $('#change_organization_status :selected').val();	// change to activate or deactivate
		var allorspecific = $('#organization_delete_all_or_specific :selected').val();	// all org or specific
		var realtor_type = $('.realtor_type').val();		// active or deactive
		var display_checkbox='';		
		$("input[name=checkadforchange]:Checked").each(function(i,item){
			display_checkbox+=$(item).val()+',';
		});	
		display_checkbox=display_checkbox.substring(0,display_checkbox.length-1);
		if(display_checkbox == '' && $('#tabs-1_x input:checkbox').prop('disabled') != true){
			alert('Please Select At Least One Home Sold');
			return false;
		}
		var data = { "id": display_checkbox ,"zone_id" : default_zone, "action_performed" : action_performed, "allorspecific" : allorspecific, "realtor_type" : realtor_type }; 
		
		if(action_performed == 2){ // Delete
			ConfirmDialog("Do you really want to delete? ", "Delete Realtor", "<?=base_url('Zonedashboard/delete_home_sold')?>", "Deleting Realtor<br/>This may take a few minutes", data, OrganizationActionSuccessful, null);		
		}
 }
});

///////////////////////////////////////////////// - Update view Organization -

function OrganizationActionSuccessful(result) { //alert(JSON.stringify(result)); return false;
	$.unblockUI();
	if(result.Title != ''){ //alert(result.Title);
	var id = result.Title;	
		if(id != 'all'){  // for all specific organizations with same type
			var id = result.Title;	
			var id_arr = id.split(',');
			$.each(id_arr,function(i,j){ 
				$('#showorganizationdetail').find('tr#'+j).hide();
			});
		}
		else if(id == 'all'){ // for all organization with same type
			$('.org_row').hide();
		}
	}
	
	$('#msg').html('<h4 style="color:#0C0">Home Sold deleted successfully.</h4>').show();
	$('html,body').animate({scrollTop:0},"slow");
	setTimeout(function(){
		$('#msg').hide('slow');
	},3000);
	
	window.onload=showHomeSold();
	
}

function EditRealtor(id){ 
	var authenticate=check_authneticate();
	if(authenticate=='0'){
		var zone_id = <?=$zoneid?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){
		 $('#tabs-1_x').hide();
		 $('#tabs-2_x').show();
		 $('#container_tab_header').text('Edit Organization');
		if(id>0){
			$('p#change_pwd').show();
			$('#organizationheader').hide();
			$('#more_organization').hide();
		}	    	
		PageMethod("<?=base_url('Zonedashboard/EditRealtor')?>" + "/" + id, "", null, ShowOrganizationEdit, null);
	 }
}
function ShowOrganizationEdit(result) {
	$.unblockUI();
	//alert(JSON.stringify(result)); return false;
	$("#organization_id").val(result.id);
	//$("#organization_zone").val(result.zoneid);
	$("#organization_name").val(result.name);
	$("#organization_email").val(result.email);
	$("#organization_username").val(result.username);
			
	if(result.type==1){
		$('#organization_type_muni').attr('checked','checked');
		$('#organization_type_school').attr('checked',false); 
		$('#organization_type_normal').attr('checked',false);
	}else if(result.type==0){
		$('#organization_type_normal').attr('checked','checked');
		$('#organization_type_muni').attr('checked',false);
		$('#organization_type_school').attr('checked',false);
	}else if(result.type==2){
		$('#organization_type_school').attr('checked','checked');
		$('#organization_type_normal').attr('checked',false);		
		$('#organization_type_muni').attr('checked',false);
	}else if(result.type==4){
		$('#organization_type_school').attr('checked','false');
		$('#organization_type_normal').attr('checked',false);		
		$('#organization_type_muni').attr('checked',false);
		$('#organization_type_highschool').attr('checked','checked');
	}
	if(result.announcement_display==1){
		$('#announcement_posted_to_all').attr('checked','checked');
		$('#announcement_posted_to_zone').attr('checked',false);
	}else if(result.announcement_display==0){
		$('#announcement_posted_to_zone').attr('checked','checked');
		$('#announcement_posted_to_all').attr('checked',false);
	}
	$("#organization_password").val('');
	$('p.organization_email').show();
	$('p.organization_username').show();
	$('p.organization_password').show();   
}
// + To Select All from header
$(document).on('click','#select_all_organizations',function(){ 
	checkboxes = document.getElementsByTagName("input");
	var ele=this;
	if(ele.checked==true)
	{
		state = true;
	}else{
		state = false;
	}
	for (i=0; i<checkboxes.length ; i++)
	{
	  if (checkboxes[i].type == "checkbox") 
	  {
		checkboxes[i].checked=state;
	  }
	}
}); // - To Select All from header

/*function DeleteOrganization(id, title) {	
	 var authenticate=check_authneticate(); //alert(a);
	 if(authenticate=='0'){
		var zone_id = <?=$zone_id?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){
		ConfirmDialog("Do you really want to delete this organization : " + title, "Delete Organization", "<?=base_url('Zonedashboard/DeleteOrganization')?>", "Deleting Organization<br/>This may take a minute",
		{ "id": id ,"zone_id" : default_zone}, OrganizationSaveSuccessful, null);
	 }
}*/

function ApprovalOrganization(id,status){ //alert(id); alert(status); return false;	
	var authenticate=check_authneticate();
	if(authenticate=='0'){
		var zone_id = <?=$zoneid?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){
		var charval='all';
		var lowerlimit=''; var upperlimit=''; 
		var $this=$('#more_organization_limit');
		var limit=$this.attr('rel'); 					//alert(limit); return false;
		if(limit=='' || limit==undefined){
			lowerlimit=0; upperlimit=5;
		}else{
		limit_final=limit.split(',');
		lowerlimit=limit_final[0]; upperlimit=limit_final[1];
		lowerlimit=0; if(limit_final[0]==0) {upperlimit=limit_final[1]} else {upperlimit=limit_final[0]};
		}
		PageMethod("<?=base_url('Zonedashboard/ApprovalOrganization')?>" + "/" + id+"/"+status+"/"+default_zone+"/"+charval+"/"+lowerlimit+"/"+upperlimit, "", null, ApprovalOrganizationSuccess, null);
	}
}
	function ApprovalOrganizationSuccess(result){
		$.unblockUI();
		if(result.Tag!=''){	
		var total_result=result.Title;
		if(total_result<5){
			$('#more_organization').hide();
			$('#margin_bottom_width').show();
		}
		else
		{
			$('#more_organization').show();
			$('#margin_bottom_width').hide();
		}
		var limit=result.Message;
		var limit_final=limit.split(',');
		var lowerlimit=limit_final[0];
		var upperlimit=limit_final[1];
		var updated_limit=upperlimit+','+5;
		if(limit=='5,5' || lowerlimit=='0'){ 
			$('#announcementheader').hide();
			$('#more_announcement').hide();
			$('#organization').hide();
			$("#showorganizationdetail").html(' ');
			$("#showorganizationdetail").show();
			$("#showorganizationdetail").append(result.Tag);
			
		}else{ 
			$('#announcementheader').hide();
			$('#more_announcement').hide();
			$('#organization').hide();			
			$('#organizationheader').show();
			$("#annoucement_edit").hide();
			$("#showannouncement").hide();
			$("#announcements_category_type").hide();
			$("#organization").hide();
			$("#showorganizationdetail").show();
			$("#showorganizationdetail").append(result.Tag);
			}
			$('#more_organization_limit').attr('rel',updated_limit);
		
			
		}
	
	}
</script>

<!-- Edit Organization Section -->

<script>
var default_zone = '<?=$zoneid;?>';
var temp_zone_id = '<?=$zoneid;?>';

function  check_authneticate(){ 
	var is_authenticated=0;
	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ //alert('success');
		is_authenticated=data;
	}});	
	return is_authenticated;
}

// + Random Username creation

function create_random_username(val1){	
	var org_name1=$(val1).val();
	var org_name=org_name1.replace(/\s+/, "") ;
	var org_name_length=org_name.length;
	var org_username_1=org_name.substring(0,8);				
	var rand_org = Math.floor((Math.random()*1000000)+1);
	var org_username=org_username_1+rand_org;
	$("#organization_username").val(org_username);
}

// - Random Username creation

// + Organization Checking

function check_org_username(){
	
	var org_username=$("#organization_username").val();
	var org_id=$("#organization_id").val();
	var data = { "zoneid": default_zone , "org_username": org_username , "org_id": org_id};
	PageMethod("<?=base_url('Zonedashboard/check_org_username')?>", "Verify the organization user name <br/>This may take a few minutes", data, showorgusername, null);
}

function showorgusername(result){
	$.unblockUI();
	if(result.Tag==''){
		$('#error_org_uname').html('This username is reserved for zone\'s username. Please try with another username.' );
		$('#error_org_uname').show();
		$('#success_org_uname').hide();
		$('#organization_username').val('');		
	}else{
		$('#error_org_uname').hide();
	}
}

// - Organization Checking

// + Generate Random password

function create_generate_password(){
	PageMethod("<?=base_url('Zonedashboard/create_generate_password_org')?>", "Creating The Password...<br/>This may take a few minutes", null, showPasswordOrg, null);
}
function showPasswordOrg(result){
	$.unblockUI();
	if(result.Tag!=''){				
		$("#organization_password").val(result.Tag);
	}
}

// - Generate Random password

// + Save Organization

function SaveOrganization(){
	var authenticate=check_authneticate();
	if(authenticate=='0'){
		var zone_id = <?=$zoneid?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){
		check_org_username_save();
	 }
}

function check_org_username_save(){
		
	var org_username=$("#organization_username").val();
	var org_id=$("#organization_id").val();
	var data = { "zoneid": default_zone , "org_username": org_username , "org_id": org_id}; 
	PageMethod("<?=base_url('Zonedashboard/check_org_username')?>", "", data, showorgusername_save, null);
}

function showorgusername_save(result){
	$.unblockUI();
	if(result.Tag==''){
		$('#error_org_uname').html('This username is reserved for zone\'s username. Please try with another username.' );
		$('#error_org_uname').show();
		$('#success_org_uname').hide();
		$('#organization_username').val('');		
	}else{
		$('#error_org_uname').hide();
		if($("#organization_name").val()==''){
			alert('Please Provide Organization Name');
			return false;
		}else if($("#organization_email").val()==''){
			alert('Please Provide Organization Email');
			return false;
		}else if($("#organization_username").val()==''){
			alert('Please Provide Organization User Name');
			return false;
		}else if($("#organization_password").val()=='' && $("#organization_id").val()==-1){
			alert('Please Provide Organization Password');
			return false;
		}
		var org_type=$("input[name=organization_type]:Checked").val();
		//alert(org_type); return false;
		var org_announcement_posted=$("input[name=announcement_posted]:Checked").val();	
		//alert(org_announcement_posted); return false;
		var dataToUse = {
			"id":$("#organization_id").val(),
			"org_name":$("#organization_name").val(),
			"org_email":$("#organization_email").val(),
			"org_username":$("#organization_username").val(),
			"org_password":$("#organization_password").val(),		
			"zone_id": $("#organization_zone").val(),
			"org_type": org_type,
			"announcement_display": org_announcement_posted		
		};
		PageMethod("<?=base_url('Zonedashboard/SaveOrganization')?>", "Saving New Organization<br/>This may take a minute.", dataToUse, OrganizationSaveSuccessful, null);
	}
}
function OrganizationSaveSuccessful(result) {
	$.unblockUI();
	$('#msg').html('<h4 style="color:#0C0">Successfully Updated</h4>').show();
	setTimeout(function(){
		$('#msg').hide('slow');
	},3000);		
}

// - Save Organization

function back_to_org(){
	$('#zone_view_organization').click();
}

</script>