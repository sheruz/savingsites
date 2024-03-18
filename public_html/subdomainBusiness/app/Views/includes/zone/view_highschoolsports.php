





<div class="main_content_outer"> 

  

<div class="content_container bv_temp_business sports">

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

<div class="container_tab_header" id="container_tab_header">View High School Sports</div>

	<div id="container_tab_content" class="container_tab_content">

    <div id="msg" style="display:none;"></div>

        <div id="tabs-1_x">

        

        <div class="container_tab_header form-group ve_org_head" style="/*background-color:#d2e08f;*/ color:#222; font-size:13px;margin-top:10px; margin-bottom:0px;">

       <!--Active/Deactive-->

        <button class="btn-sm active_org active" onclick="showallorganization(<?=$zoneid?>,'all','',this.id); resetsearch();" type="button" id="1###org" style="">Active High School Sports</button>

        <button class="btn-sm deactive_org" onclick="showallorganization(<?=$zoneid?>,'all','',this.id); resetsearch();" type="button" id="-1###org">Inactive High School Sports</button> 

       <!--Active/Deactive-->

               	

        <a class="fright" href="javascript:void(0);" onclick="$('#search_org').slideToggle('slow')"><img src="https://cdn.savingssites.com/find.png" style="width:28px; height:28px" alt="Search Organization" title="Search Organization"/></a>

         </div>



 <!-- Search Part Start -->

    <div class="container_tab_header form-group bv_search_org" id="search_org" style="display:none;">

        <div class="bus_search_pbntc_active">

            <input type="text" id="text_org_search" name="text_org_search" placeholder="Direct search by High School Sports name" style="width:240px;" />

            <button class="btn-sm"  id="text_org_search_btn" type="button" onclick="showallorganization(<?=$zoneid?>,$('#text_org_search').val(),'',$('.organization_type').val());">Search</button><strong>Search High School Sports</strong>

            <select name="select_org_by_char" id="select_org_by_char">

            <option value="-1">By Alphabetical Order</option><option value="all">ALL</option><option value="A">A</option><option value="B">B</option><option value="C">C</option><option value="D">D</option><option value="E">E</option><option value="F">F</option><option value="G">G</option><option value="H">H</option><option value="I">I</option><option value="J">J</option><option value="K">K</option><option value="L">L</option><option value="M">M</option><option value="N">N</option> <option value="O">O</option><option value="P">P</option><option value="Q">Q</option><option value="R">R</option><option value="S">S</option><option value="T">T</option><option value="U">U</option> <option value="V">V</option><option value="W">W</option><option value="X">X</option><option value="Y">Y</option><option value="Z">Z</option>          			

            </select>

            <button class="btn-sm" id="select_org_by_char_btn" type="button" onclick="showallorganization(<?=$zoneid?>,$('#select_org_by_char  option:selected').val(),'',$('.organization_type').val());">Search</button>

        </div>

 <!-- Search Part End -->            

            

            <!--<div id="organization_search">

              <input type="text" id="org_search" name="org_search" class="w_300" placeholder="Direct search by organization name" />

              <button class="showbusiness" onclick="showallorganization(<?=$zoneid?>,$('#org_search').val());" style="margin-left:5px;">Search</button><br/>

            </div>-->

           

            

        </div>

        <div id="organizationheader">

          <table class="pretty" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">

            <thead>

              <tr>

                    <th width="20%">High School Sports Name</th>

                    <th width="20%">Contact Details</th>

                    <th width="30%">Action</th>

                    <!--<th width="15%">Status/Delete</th>-->

                    <th width="12%">Select/<br/>

                    Deselect All<br/>

                    <input type="checkbox" name="select_all_organizations" id="select_all_organizations"  value="all" title="Select/Deselect All" alt="Select/Deselect All"></th> 

                    <!--<th>Admin</th>-->

              </tr>

            </thead>

              <tbody id="showorganization">

                <tr class="headerclass_organization">

                  <td colspan="5"><div id="action_performed_div" class="apmybusiness fright">

                      <select name="action_performed" id="action_performed" class="action_performed_mybusiness w_215 select_style_sm" style="float:left;">

                        <option value="1">Change High School Sports Status</option>

                        <option value="2">Delete</option>

                      </select>

                      

                      <select name="change_organization_status" id="change_organization_status" class="w_285 select_style_sm">

                        <!--<option value="-3">Deactivate - Disable public view of announcements</option>

                        <option value="3">Activate - Enable public view of announcements</option>-->

                      </select>

                      <select name="organization_delete_all_or_specific" id="organization_delete_all_or_specific" class="w_215 select_style_sm">

                        <option value="1">Selected High School Sports</option>

                        <option value="2">All High School Sports</option>

                      </select>

                      <button class="btn-sm" id="update_organization" type="button" organization_type="$('.organization_type').val()">Update</button>

                    </div></td>

                </tr>

    			</tbody>

          </table>

        </div>

        <div id="showorganizationdetail" class="show_org_dd"></div>

        <div id="more_organization" class="text-default" style="text-align: right; font-weight: 700; background: transparent; margin-top: 22px;"><a id="more_organization_limit" href="javascript:void(0)" onclick="showallorganization(<?=$zoneid?>,'all',this,'$('.organization_type').val()');" rel="0,0">Display More High School Sports</a> </div>

        </div>      

        

        <div id="tabs-2_x" style="display:none;">

        <div id="organization" class=" form-group">

          <input type="hidden" id="organization_id" name="organization_id" value="-1"/>

          <input type="hidden" id="organization_zone" name="organization_zone" value="<?=$zoneid?>"/>

          <input type="hidden" id="realtor_username" name="realtor_username" value=""/>

          <div class="container_tab_header form-group cus-highschool" >

          <p> The username will get generated automatically based on the first 8 characters of the High School Sports name followed by 6 random numbers.</p>

          <p> Clicking on the 'Generate Password' will automatically generate a random alpha-numeric password. </p>

          <p> High School Sports Username and Zone Username should not be same. </p>

          </div>

          <p class="form-group-row">

            <label for="organization_name" class="fleft w_200">High School Sports Name</label>

            <input type="text" style="width:300px;" id="organization_name" name="organization_name" maxlength="30"/>
            <p class="cus-red-text"> (Maximum 30 characters)</p>

           

          </p>

          <p class="form-group-row">

            <label for="organization_name" class="fleft w_200">High School Sports Type</label>

            <input type="radio" id="organization_type_muni" name="organization_type" value="1" checked="checked" />

            Municipality

            <input type="radio" id="organization_type_school" name="organization_type" value="2" />

            Schools 

            <input type="radio" id="organization_type_normal" name="organization_type" value="0" />

            Other Organizations 

            <input type="radio" id="organization_type_highschool" name="organization_type" value="4" />

            High School Sports

            </p>

          <p class="form-group-row">

            <label for="organization_email" class="fleft w_200">Email Address</label>

            <input style="width:300px;" type="text" id="organization_email" name="organization_email" />

          </p>

          <div style="margin-left: 200px;display:none;  background-color: wheat; height: 25px; border-radius: 7px;width: 245px;"id="email_notice" >

                    <p style="color:red;  margin-left: 12px;"/> Please enter valid Email address </p>

                    </div>

          <p class="form-group-row">

            <label for="organization_username" class="fleft w_200">Username</label>

            <input style="width:300px;" type="text" id="organization_username" name="organization_username" onblur="check_org_username();" disabled="disabled"/>

          </p>

          <span id="error_org_uname" style="margin:0 0 8px 160px; background:#F00; font-weight:bold; color:#fff; padding:3px; width:380px; display:none; text-align:center"></span>

          <p class="form-group-row">

            <label for="organization_password" class="fleft w_200">Password <br />

           

            </label>

            <input type="text" id="organization_password" name="organization_password"/>


            <button onclick="create_generate_password()">Generate Password</button>
                <p class="cus-red-text"> <span style="color:red">Case sensitive, combination of 10-18 letters, numbers and special characters (!, @, #, $, %, &) </span></p>

          </p>

          <span id="error_new_password" style=" margin-left:200px; background:#F00; font-weight:bold; color:#fff; padding:3px; width:450px; display:block; text-align:center; display:none;position: relative;top: -8px;"></span>

          <p class="form-group-row">

            <label for="announcement_posted_to" class="fleft w_200">Announcement Posted To</label>

            <input type="radio" id="announcement_posted_to_zone" name="announcement_posted" value="0" checked="checked" />

            This Zone

            <input type="radio" id="announcement_posted_to_all" name="announcement_posted" value="1" />

            All Zone </p>

          <span style="margin-left:200px;">

          <button onclick="SaveOrganization()" name="save_highschool_sports">Save</button>

          <button onclick="back_to_hss()" name="back_highschool_sports">Back To High School Sports</button>

          </span> </div>

        </div>

        

    </div>  

</div>



</div>

<script type="text/javascript">

$(document).ready(function () { 

	$('#zone_organization_accordian').click();

	$('#zone_organization_accordian').next().slideDown();

	$('#zone_view_highschoolsports').addClass('active');

	$('.active_org').click().addClass('active');

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

function showallorganization(zoneid,charval,tag,type){	

		

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

		if(charval == '' || charval == -1){

			var charval = 'all';

		}

		var type_arr = type.split('###');

		var type_org = type_arr[0];

		if(type_org == 1){

			$('.active_org').addClass('active');

			$('.deactive_org').removeClass('active');			

			$('#change_organization_status').html('<option value="-1">Deactivate - Disable public view of announcements</option>');

			var message="Displaying  The Activated High School Sports List...<br/>This may take a few seconds...";

		}else if(type_org == -1){

			$('.active_org').removeClass('active');

			$('.deactive_org').addClass('active');

			$('#change_organization_status').html('<option value="1">Activate - Enable public view of announcements</option>');

			var message="Displaying  The Deactivated High School Sports List...<br/>This may take a few seconds...";

		}

															// form the button  seding the tab value and thus sending tag in the pagemethod

		PageMethod("<?=base_url('Zonedashboard/getHighschoolsportsData')?>/"+default_zone+"/"+charval+"/"+type_org+"/"+lowerlimit+"/"+upperlimit, message, null, showAccounceInformationOrg, null);

}}

	

function showAccounceInformationOrg(result){

	$.unblockUI();

	if(result.Tag!=''){	

	var total_result=result.Title;

	if(total_result==0){ //alert(2); return false;

		$('#more_organization').hide();

		$('#margin_bottom_width').show();

	}

	else

	{	if(total_result<15){

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

$(document).on('click','#update_organization',function(){

 var authenticate=check_authneticate(); //alert(a);

 if(authenticate=='0'){

		var zone_id = <?=$zoneid?>;			 

		alert('You are currently logged out. Please log in to continue.');

		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

	}else if(authenticate==1){ 

	var action_performed = $('#action_performed :selected').val();			// Delete or change

	var change_business_status = $('#change_organization_status :selected').val();	// change to activate or deactivate

	var allorspecific = $('#organization_delete_all_or_specific :selected').val();	// all org or specific

	var organization_type = $('.organization_type').val();		// active or deactive

	var display_checkbox='';		

	$("input[name=checkadforchange]:Checked").each(function(i,item){

		display_checkbox+=$(item).val()+',';

	});	

	display_checkbox=display_checkbox.substring(0,display_checkbox.length-1);

	if(display_checkbox == '' && $('#tabs-1_x input:checkbox').prop('disabled') != true){

		alert('Please Select At Least One Organization');

		return false;

	}

	var data = { "id": display_checkbox ,"zone_id" : default_zone, "action_performed" : action_performed, "change_business_status" : change_business_status, "allorspecific" : allorspecific, "organization_type" : organization_type }; 

	if(action_performed == 1){ // Update Status Activate and Deactivate

	

		PageMethod("<?=base_url('Zonedashboard/action_performed_organization')?>/", "Action Performed...<br/>This may take a few minutes", data, OrganizationActionSuccessful, null);

	

	}

	

	else if(action_performed == 2){ // Delete

	

				ConfirmDialog("Do you really want to delete? ", "Delete Organization", "<?=base_url('Zonedashboard/action_performed_organization')?>", "Deleting Organizations<br/>This may take a minute", data, OrganizationActionSuccessful, null);		

	

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

	

	$('#msg').html('<h4 style="color:#0C0">High School Sports status has been changed successfully.</h4>').show();

	$('html,body').animate({scrollTop:0},"slow");

	setTimeout(function(){

		$('#msg').hide('slow');

	},3000);

	

}



function EditOrganization(id){ 

	var authenticate=check_authneticate();

	if(authenticate=='0'){

		var zone_id = <?=$zoneid?>;			 

		alert('You are currently logged out. Please log in to continue.');

		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

	}else if(authenticate==1){

		 $('#tabs-1_x').hide();

		 $('#tabs-2_x').show();

		 $('#container_tab_header').text('Edit High School Sports');

		if(id>0){

			$('p#change_pwd').show();

			$('#organizationheader').hide();

			$('#more_organization').hide();

		}	    	

		PageMethod("<?=base_url('Zonedashboard/EditOrganization')?>" + "/" + id, "", null, ShowOrganizationEdit, null);

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

	$("#realtor_username").val(result.username);

			

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

	var realtor_username=$("#realtor_username").val();

	var data = { "zoneid": default_zone , "org_username": org_username , "org_id": org_id , "realtor_username": realtor_username};

	PageMethod("<?=base_url('Zonedashboard/check_org_username')?>", "Verify the High School Sports user name <br/>This may take a few minutes", data, showorgusername, null);

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

	var realtor_username=$("#realtor_username").val();

	var data = { "zoneid": default_zone , "org_username": org_username , "org_id": org_id , "realtor_username":realtor_username}; 

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

			alert('Please Provide High School Sports Name');

			return false;

		}else if($("#organization_username").val()==''){

			alert('Please Provide High School Sports User Name');

			return false;

		}else if($("#organization_password").val()=='' && $("#organization_id").val()==-1){

			alert('Please Provide High School Sports Password');

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



function back_to_hss(){

	$('#zone_view_highschoolsports').click();

}



$('#organization_email').focusout(function(){



         $('#organization_email').filter(function(){

              var email=$('#organization_email').val();

              // var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
              var emailReg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

				 if( !emailReg.test(email)){

					$('#email_notice').slideDown();

					//$('#email_notice').fadeOut(6000);

					$("button[name='save_highschool_sports']").attr('disabled','disabled');

					$("button[name='back_highschool_sports']").attr('disabled','disabled');

					$('#organization_email').focus();

					//$('#email_notice').fadeToggle();

					}else{

						$('#email_notice').slideUp('slow');

						$("button[name='save_highschool_sports']").removeAttr('disabled');

						$("button[name='back_highschool_sports']").removeAttr('disabled');

					} 

         })

  });

  

  $(document).on('blur','#organization_password',function(){

	var new_password = $(this).val();

	 var regex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%#&])[A-Za-z\d$@$!%#&]{10,}$/; 

	if(new_password.length < 10 || new_password.length > 18){

		$('#error_new_password').html(" Password should be between 10 to 18 characters");

			$('#error_new_password').show();

			$('#organization_password').focus();

			$("button[name='save_highschool_sports']").attr('disabled','disabled');

			$("button[name='back_highschool_sports']").attr('disabled','disabled');

			return false;

	}else if(!regex.test(new_password)){ 

		$('#error_new_password').html(" Password should be combination of letters, numbers and special characters (!, @, #, $, %, &)");

			$('#error_new_password').show();

			$('#organization_password').focus();

			$("button[name='save_highschool_sports']").attr('disabled','disabled');

			$("button[name='back_highschool_sports']").attr('disabled','disabled');

			return false;

		}else{  

			$('#error_new_password').hide();

			$("button[name='save_highschool_sports']").removeAttr('disabled');

			$("button[name='back_highschool_sports']").removeAttr('disabled');

		}

});





</script>

<style type="text/css">
  button#text_org_search_btn {
    background: #101480;
    padding: 8px;
}
button#select_org_by_char_btn {
    background: #101480;
    padding: 8px;
}
#search_org {
    background: #bdbcc9;
    padding: 10px
  text-align: center;
  text-align: center;

}
#search_org strong {
    font-size: 15px;
    margin: 20px;
}
input[type=checkbox], input[type=radio] {

    margin: 5px !important;
}
.cus-highschool {
    background-color: #402aab;
    background-repeat: repeat-x;
    background-image: -moz-linear-gradient(-40deg, #eeeeee, #e6e6e6);
    background-image: -webkit-linear-gradient( 
-40deg
 , #eeeeee, #e6e6e6);
    background-image: -o-linear-gradient(-40deg, #eeeeee, #e6e6e6);
    background-image: linear-gradient( 
-40deg
 , #101480, #7040d5);
    color: #ffffff;
    text-shadow: unset;
    border-bottom: solid 1px #c4c4c4;
    margin-bottom: 20px;
    padding: 10px;
}
@media (max-width: 767px){
.bv_search_org .form-group select,.bv_search_org .form-group input[type="file"],.bv_search_org .form-group input[type="text"] {
   
width: 510px !important;
    max-width: 610px;
}
}

</style>