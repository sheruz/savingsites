<input type="hidden" id="zoneid" value="<?=$zoneid?>" />

<input type="hidden" id="userid" value="<?=$uid?>" />



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

            <a style="margin:-10px 20px 0 0;" href="javascript:void(0)" class="close" onClick="$('#view_global_bus_search_div').slideToggle();"><img src="https://cdn.savingssites.com/close_pop.png" class="btn_close global_search_close" title="Close Window" alt="Close" ></a>

      </div>

    </div>



<?php } ?>

	<div class="container_tab_header">Announcement By Organization</div>

	<div id="container_tab_content" class="container_tab_content bv_annouce_sec">

       <!-- <ul>

        <li><a href="#tabs-1" id="tab1" onclick="setAnnouncementType(1);showallannouncement('all');">Active Announcement</a></li>

        <li><a href="#tabs-2" onclick="setAnnouncementType(0);showallannouncement('all');">New Announcement</a></li>

        <li><a href="#tabs-3" onclick="setAnnouncementType(-1);showallannouncement('all');">Deactive Announcement</a></li>

        </ul>-->

        

        <ul>

            <!--<li><a href="#tabs-1" id="tab1" onclick="tabClick('1');">Activated Announcement</a></li>-->

            <li><a href="#tabs-1" id="tab1" onclick="tabClick('1');">Current Announcement</a></li>

            

          <!--  <li><a href="#tabs-2" onclick="tabClick('0');">New Announcement</a></li>-->

            

            <!--<li><a href="#tabs-3" onclick="tabClick('-1');">Deactivated Announcement</a></li>-->

            <li><a href="#tabs-3" onclick="tabClick('-1');">Old Announcements (No longer viewable in the Directory)</a></li>

        </ul>

        <input type="hidden" id="announcements_type" value="" />

        

        

        <input type="hidden" value="<?=$orgvalue;?>" id="orgvalue" />

        <input type="hidden" name="show_announcement_type" id="show_announcement_type" value="" />											

                                                    

                                                    <!--Activated Announcements starts here-->

        <div id="tabs-1">  

        	<div class="form-group"> 

            	<div class="form-group new_announe" style="/*background-color:#d2e08f;*/ color:#222; font-size:13px;margin-top:10px; margin-bottom:0px; overflow:hidden;">

                <strong style="float:left; margin-right:10px; margin-top: 7px;">Search Your Organization</strong>

            <select name="alpha_announcement_search" id="alpha_announcement_search1" onchange="get_org_list();" class="fleft" style="margin-right:10px;">

            <option value="-1">By Alphabetical Order</option><option value="A">A</option><option value="B">B</option><option value="C">C</option><option value="D">D</option><option value="E">E</option><option value="F">F</option><option value="G">G</option><option value="H">H</option><option value="I">I</option><option value="J">J</option><option value="K">K</option><option value="L">L</option><option value="M">M</option><option value="N">N</option> <option value="O">O</option><option value="P">P</option><option value="Q">Q</option><option value="R">R</option><option value="S">S</option><option value="T">T</option><option value="U">U</option> <option value="V">V</option><option value="W">W</option><option value="X">X</option><option value="Y">Y</option><option value="Z">Z</option>          			

            </select>

            <a class="fright new-help-button" href="javascript:void(0);" onclick="$('#helpdiv').slideToggle('slow')">HELP<!--<img alt="Help Tips" title="Help Tips" src="<?=base_url()?>assets/images/help.png" width:"28px" height="28px"/>--></a>

            <div id="announcement_names1" class="fleft"></div>

                <?php /*?><!--<a class="fright" href="javascript:void(0);" onclick="$('#helpdiv').slideToggle('slow')"><img alt="Help Tips" title="Help Tips" src="<?=base_url()?>assets/images/help.png" width="28px" height="28px"/></a>--><?php */?>

            	</div>   

                <div id="helpdiv" class="container_tab_header header-default-message" style="display:none;">

                <p>This shows the "Activated Announcements". It has the following:<br>

                  Select from the drop down the name of the Organization of which you want to view the announcements and then click on the "Show" button.<br>

                 <!--<p>To post a new advertisement click on the option saying "Post new announcements under organization name."</p>-->

                 To deactive all the advertisements click on the "Deactive All Announcements" option.</p>

                </div>

                				<!-- Status Change button -->

                <!-- <div id="newannouncement" style="float:right">

                  	<button style="float: right;margin-right: 2px;text-align: right; display:none;" class="deactivateallannounce"  onclick="alldeactivate_announcement_by_org();">Deactivate All Announcements</button>

                </div> -->		

                    			<!-- Status Change button -->

                                

              <div class="announcement_submenu_display"></div>   

              <div class="vc_announce_col">

                  <table align="center" id="<?= $uId = str_replace(".","",uniqid('', true)); ?>" class="pretty tab1" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">

                    <thead>

                      <tr>

                        <th width="25%">Announcement Title</th>

                        <th width="45%">Announcement Details</th>

                        <th width="25%">Action</th>

                      </tr>

                    </thead>

        		<tbody class="showannouncement announcement_display"></tbody>

                  </table>
                </div>

                <div class="more_announcement" style="float: right; display:none;"><a class="announcement_limit" style=" color:#000;" href="javascript:void(0)" onclick="fn_displayAnnouncement('all',this);" rel="0,0">Displaying more announcements</a> </div>

        	</div>

        </div>       

        											<!--Activated Announcements ends here-->

                                                    

                                                    

        

        											<!--New Announcement starts here-->

        <div id="tabs-2" style="display:none;"> 

              <div class="form-group"> 

            	<div class="form-group" style="color:#222; font-size:13px;margin-top:10px; margin-bottom:0px; overflow:hidden;">

                <strong style="float:left; margin-right:10px; margin-top:7px;">Search Your Organization</strong>

            <select name="alpha_announcement_search" id="alpha_announcement_search2" onchange="get_org_list();" class="fleft" style="margin-right:10px;">

            <option value="-1">By Alphabetical Order</option><option value="A">A</option><option value="B">B</option><option value="C">C</option><option value="D">D</option><option value="E">E</option><option value="F">F</option><option value="G">G</option><option value="H">H</option><option value="I">I</option><option value="J">J</option><option value="K">K</option><option value="L">L</option><option value="M">M</option><option value="N">N</option> <option value="O">O</option><option value="P">P</option><option value="Q">Q</option><option value="R">R</option><option value="S">S</option><option value="T">T</option><option value="U">U</option> <option value="V">V</option><option value="W">W</option><option value="X">X</option><option value="Y">Y</option><option value="Z">Z</option>          			

            </select> 

                <a class="fright new-help-button" href="javascript:void(0);" onclick="$('#helpdiv1').slideToggle('slow')">HELP<!--<img alt="Help Tips" title="Help Tips" src="<?=base_url()?>assets/images/help.png" width:"28px" height="28px"/>--></a>

                <div id="announcement_names2" class="fleft"></div>

                    <!--<a class="fright" href="javascript:void(0);" onclick="$('#helpdiv').slideToggle('slow')"><img alt="Help Tips" title="Help Tips" src="<?=base_url()?>assets/images/help.png" width="28px" height="28px"/></a>-->

                </div>	

                <div id="helpdiv1" class="container_tab_header header-default-message" style="display:none;">

                <p>This shows the "New Announcements". It has the following:</p>

                <p>Select from the drop down the name of the Organization of which you want to view the announcements and then click on the "Show" button.</p>

                 <!--<p>To post a new announcements click on the option saying "Post new announcements under organization name."</p>-->

                 <p>To deactive or active all the announcements click on the "Deactive All Announcements" or "Active All Announcements" option.</p>

                </div>			

                                <!--Status Change button-->

                <!--<div id="newannouncement" style="float:right">

                  <button style="float: right;margin-right: 2px;text-align: right; display:none;" class="activateallannounce" onclick="allactivate_announcement_by_org();">Activate All Announcements</button>

                  <button style="float: right;margin-right: 2px;text-align: right; display:none;" class="deactivateallannounce"  onclick="alldeactivate_announcement_by_org();">Deactivate All Announcements</button>

                </div>﻿-->

               				  	<!--Status Change button-->	

                  <div class="announcement_submenu_display"></div>              

                  <table align="center" id="<?= $uId = str_replace(".","",uniqid('', true)); ?>" class="pretty" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">

                    <thead>

                      <tr>

                        <th width="25%">Announcement Title</th>

                        <th width="45%">Announcement Details</th>

                        <th width="25%">Action</th>

                      </tr>

                    </thead>

                  <tbody class="showannouncement announcement_display"></tbody>

                  </table>

                <div class="more_announcement" style="float: right; display:none;"><a class="more_announcement_limit" style=" color:#000;" href="javascript:void(0)" onclick="showallannouncement('all',this);" rel="0,0">Displaying more announcement</a> </div>

        	</div>

        </div>       

        											<!--New Announcement ends here-->

                                                    

                                                    

        

        											<!--Deactive Announcement starts here-->

        <div id="tabs-3">

        	  <div class="form-group"> 

            	<div class="form-group" style="color:#222; font-size:13px;margin-top:10px; margin-bottom:0px; overflow:hidden;">

                <strong style="float:left; margin-right:10px; margin-top:7px;">Search Your Organization</strong>

                    <select name="alpha_announcement_search" id="alpha_announcement_search3" onchange="get_org_list();" class="fleft" style="margin-right:10px;">

                    <option value="-1">By Alphabetical Order</option><option value="A">A</option><option value="B">B</option><option value="C">C</option><option value="D">D</option><option value="E">E</option><option value="F">F</option><option value="G">G</option><option value="H">H</option><option value="I">I</option><option value="J">J</option><option value="K">K</option><option value="L">L</option><option value="M">M</option><option value="N">N</option> <option value="O">O</option><option value="P">P</option><option value="Q">Q</option><option value="R">R</option><option value="S">S</option><option value="T">T</option><option value="U">U</option> <option value="V">V</option><option value="W">W</option><option value="X">X</option><option value="Y">Y</option><option value="Z">Z</option>          			

                    </select>

                    <a class="fright new-help-button" href="javascript:void(0);" onclick="$('#helpdiv2').slideToggle('slow')">HELP<!--<img alt="Help Tips" title="Help Tips" src="<?=base_url()?>assets/images/help.png" width:"28px" height="28px"/>--></a>

            	<div id="announcement_names3" class="fleft"></div>

                <!--<a class="fright" href="javascript:void(0);" onclick="$('#helpdiv').slideToggle('slow')"><img alt="Help Tips" title="Help Tips" src="<?=base_url()?>assets/images/help.png" width="28px" height="28px"/></a>-->

            	</div> 

                <div id="helpdiv2" class="container_tab_header header-default-message" style="display:none;">

                <p>This shows the "Dectivated Announcements". It has the following:<br>

                Select from the drop down the name of the Organization of which you want to view the announcements and then click on the "Show" button.<br>

                 <!--<p>To post a new announcements click on the option saying "Post new announcements under organization name."</p>-->

                 To active all the announcements click on the "Active All Announcements" option.</p>

                </div> 			

                            <!--Status Change button-->    	

            	<!--<div id="newadd" style="float:right">

                  <button style="float: right;margin-right: 2px;text-align: right; display:none;" class="activateallannounce" onclick="allactivate_announcement_by_org();">Activate All Announcements</button>

                </div>﻿-->

                			<!--Status Change button-->

                <div class="announcement_submenu_display"></div>

                  <table align="center" id="<?= $uId = str_replace(".","",uniqid('', true)); ?>" class="pretty" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">

                    <thead>

                      <tr>

                        <th width="25%">Announcement Title</th>

                        <th width="45%">Announcement Details</th>

                        <th width="25%">Action</th>

                      </tr>

                    </thead>

                  <tbody class="showannouncement announcement_display"></tbody>

                  </table>

                <div class="more_announcement" style="float: right; display:none;"><a class="more_announcement_limit" style=" color:#000;" href="javascript:void(0)" onclick="showallannouncement('all',this);" rel="0,0">Displaying more announcement</a> </div>

        	</div>

        </div>

        											<!--Deactive Announcement ends here-->

        

        

    </div>

    

    

</div>



</div>





<script type="text/javascript">

$(document).ready(function () {

	$('#zone_organization_accordian').click();

	$('#zone_organization_accordian').next().slideDown();

	$('#zannouncement').click();

	$('#zannouncement').next().slideDown();

	$('#zone_announcement').addClass('active');

	$('#tab1').click();

});

</script>



<script>

var default_zone = '<?=$zoneid;?>';

var temp_zone_id = '<?=$zoneid;?>';



function  check_authneticate(){ 

	var is_authenticated=0;

	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ 

		is_authenticated=data;

	}});	

	return is_authenticated;

}



function setAnnouncementType(val){ 

	$('#announcements_type').val(val);	

}



// + tabClick

function tabClick(val){		

	$('#show_announcement_type').val(val);

	$('.showannouncement').html('');

	$('.announcement_submenu_display').html('');

	if(val == 1){								

		$('#announcement_names2').html('');

		$('#announcement_names3').html('');

		$('#alpha_announcement_search2 option[value=-1]').attr('selected','selected');

		$('#alpha_announcement_search3 option[value=-1]').attr('selected','selected');

	}

	if(val == 0){								

		$('#announcement_names1').html('');

		$('#announcement_names3').html('');

		$('#alpha_announcement_search1 option[value=-1]').attr('selected','selected');

		$('#alpha_announcement_search3 option[value=-1]').attr('selected','selected');		

	}

	if(val == -1){								

		$('#announcement_names1').html('');

		$('#announcement_names2').html('');

		$('#alpha_announcement_search1 option[value=-1]').attr('selected','selected');

		$('#alpha_announcement_search2 option[value=-1]').attr('selected','selected');		

	}

	/*$("#all_business :first-child").prop('selected', true);

	$("#all_business1 :first-child").prop('selected', true);

	$("#all_business2 :first-child").prop('selected', true);*/

}

// - tabClick



// + get_org_list/Success

function get_org_list(){   

	var zoneid = $('#zoneid').val();

	var userid = $('#userid').val();

	var select_id = $("#show_announcement_type").val();				

	var char = '';

	if(select_id == 1){

		char = $('#alpha_announcement_search1').val();

	}

	if(select_id == 0){

		char = $('#alpha_announcement_search2').val();

	}

	if(select_id == -1){

		char = $('#alpha_announcement_search3').val();

	}

	var data = {'zoneid' : zoneid, 'userid' : userid, 'orgvalue' : 0, 'char' : char, 'select_id' : select_id}

	PageMethod("<?=base_url('Zonedashboard/get_org_list')?>/", "Displaying The Announcements...<br/>This may take a few minutes", data, getorglistsuccess, null);

}

function getorglistsuccess(result){ //alert(JSON.stringify(result));

	$.unblockUI();

	if(result.Tag != ''){

		$('.announcement_submenu_display').html('');

		$('.showannouncement').html('');

		var select_id=$("#show_announcement_type").val();

		if(select_id == 1){

			$('#announcement_names1').html(result.Tag);

		}else if(select_id == 0){

			$('#announcement_names2').html(result.Tag);

		}else if(select_id == -1){

			$('#announcement_names3').html(result.Tag);

		}

		if($('#announcement_names1').find('button').hasClass('showad') == true){

			$('.showad').click();

		}

		if($('#announcement_names2').find('button').hasClass('showad') == true){ 

			$('.showad').click();

		}

		if($('#announcement_names3').find('button').hasClass('showad') == true){ 

			$('.showad').click();

		}

		$('tbody.showannouncement').show('slow');	

		$('.announcement_submenu_display').hide('slow');

	}

}

// - get_org_list/Success





// + announcement_submenu/Success

function announcement_submenu(zone_id,tag){ 	

	var authenticate=check_authneticate();

	if(authenticate=='0'){

		var zone_id = <?=$zoneid?>;			 

		alert('You are currently logged out. Please log in to continue.');

		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

	}else if(authenticate==1){



		var select_id=$("#show_announcement_type").val();		 

		if(select_id == 1){

			orgid_select = $("#all_organization option:selected").val();

		}else if(select_id == 0){

			orgid_select = $("#all_organization1 option:selected").val();

		}else if(select_id == -1){

			orgid_select = $("#all_organization2 option:selected").val();

		}  

		var org_id=orgid_select; 				

		var check_org=org_id.indexOf("-");  	

		data={	org_id:org_id	}	

		if(check_org=='-1' && org_id!=''){

			PageMethod("<?=base_url('Zonedashboard/display_announcement_submenu')?>/"+zone_id+"/"+select_id, "Displaying The Announcements...<br/>This may take a few minutes", data, DisplayAnnouncementExtraPartSuccess, null); 

		}else{

			$(".advertisement_submenu_display").hide();

			fn_displayAnnouncement(zone_id,'');

		}

	 }

}

function DisplayAnnouncementExtraPartSuccess(result){ 			//alert(JSON.stringify(result.Tag)); return false;

	$.unblockUI();

	var zone_id=result.Title;

	if(result.Tag!=''){

		$(".announcement_submenu_display").show(); 				//alert(JSON.stringify($(".announcement_submenu_display").show())); return false;

		$(".announcement_submenu_display").html(result.Tag);		

		fn_displayAnnouncement(zone_id,'');

	}

}

function fn_displayAnnouncement(zone_id,tag){ 

	var authenticate=check_authneticate();

	if(authenticate=='0'){

		var zone_id = <?=$zoneid?>;			 

		alert('You are currently logged out. Please log in to continue.');

		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

	}else if(authenticate==1){

		var select_id=$("#show_announcement_type").val();				

		if(select_id == 1){

			orgid_select = $("#all_organization option:selected").val();			

		}else if(select_id == 0){

			orgid_select = $("#all_organization1 option:selected").val();			

		}else if(select_id == -1){

			orgid_select = $("#all_organization2 option:selected").val();			

		}  

		var org_id=orgid_select; 		

		var charval='all';

		var lowerlimit=''; var upperlimit=''; 				

		var $this=$(tag);

		var limit=$this.attr('rel'); 

		if(limit=='' || limit==undefined){

			lowerlimit=0; upperlimit=5;

		}else{

			limit_final=limit.split(',');

			lowerlimit=limit_final[0]; upperlimit=limit_final[1];

		}	 

		data = {org_id : org_id}

		PageMethod("<?=base_url('Zonedashboard/display_announcement')?>/"+select_id+"/"+zone_id+"/"+charval+"/"+lowerlimit+"/"+upperlimit, "Displaying The Announcements...<br/>This may take a few minutes", data, DisplayAnnouncementSuccess, null);

	 }

}

function DisplayAnnouncementSuccess(result){ 

	$.unblockUI();	//alert(JSON.stringify(result));

	var total_result=result.Title; 

	var select_id = $("#show_announcement_type").val();

	if(total_result==0){

		$('#newannouncement').hide();

		$('.more_announcement').hide();

	}else{

		$('#newannouncement').show();

		if(total_result>4){ 

			$('.more_announcement').show();

		}else{

			$('.more_announcement').hide();

		}

	}

	var limit=result.Message; 	

	if(result.Tag!=''){

		if(limit=='5,5'){ 

			$(".showannouncement").html('');

			$(".showannouncement").append(result.Tag);			

		}else{

			$(".showannouncement").append(result.Tag);

		}

		if(select_id == 1){

			if($('#tabs-1').find('tr').hasClass('ads_row') == false){

				$('.tab1').hide();

				$('.showannouncement').html('<div style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;" class="container_tab_header">No Activated Announcements Found</div>');

			}

			else{

				$('.tab1').show();

			}

		}else if(select_id == 0){

			if($('#tabs-2').find('tr').hasClass('ads_row') == false){

				$('.tab2').hide();

				$('.showannouncement').html('<div style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;" class="container_tab_header">No New Announcements Found</div>');

			}

			else{

				$('.tab2').show();

			}		

		}

		else if(select_id == -1){

			if($('#tabs-3').find('tr').hasClass('ads_row') == false){

				$('.tab3').hide();

				$('.showannouncement').html('<div style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;" class="container_tab_header">No Deactivated Announcements Found</div>');				

			}

			else{

				$('.tab3').show();

			}		

		}

		

		$('.announcement_limit').attr('rel',limit);         		

	}

}

// - announcement_submenu/Success



// + Activate/Deactivate Announcements

function announcement_approval(id,zoneid,option,orgid){ 					 

	var authenticate=check_authneticate();

	if(authenticate=='0'){

		var zone_id = <?=$zoneid?>;			 

		alert('You are currently logged out. Please log in to continue.');

		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

	}else if(authenticate==1){

		var select_id=$("#show_announcement_type").val();	

		if(select_id == 1){

			orgid_select = $("#all_organization option:selected").val();

		}else if(select_id == 0){

			orgid_select = $("#all_organization1 option:selected").val();

		}else if(select_id == -1){

			orgid_select = $("#all_organization2 option:selected").val();

		}

		var org_id=orgid_select;	

		$('tr#'+id).hide();

		$('.announcement_display').find('tr#'+id).hide();

		PageMethod("<?=base_url('Zonedashboard/edit_announcement')?>/"+id+"/"+zoneid+"/"+option+"/"+select_id+"/"+orgid+"/"+org_id, "Displaying The Advertisements...<br/>This may take a few minutes", null, null, null);

	 }

}

// - Activate/Deactivate Announcements



// + Delete/Success Announcements

function ad_approval_delete(id,zoneid,option,orgid){

	var authenticate=check_authneticate();

	if(authenticate=='0'){

		var zone_id = <?=$zoneid?>;			 

		alert('You are currently logged out. Please log in to continue.');

		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

	}else if(authenticate==1){

		var select_id=$("#show_announcement_type").val();

		if(select_id == 1){

			orgid_select = $("#all_organization option:selected").val();

		}else if(select_id == 0){

			orgid_select = $("#all_organization1 option:selected").val();

		}else if(select_id == -1){

			orgid_select = $("#all_organization2 option:selected").val();

		}

		var org_id=orgid_select;

		

		var data = { id : id, zoneid : zoneid, option : option, select_id : select_id, orgid : orgid, org_id : org_id}; 

		ConfirmDialog("Really remove this advertisement from this zone?", "Warning", "<?=base_url('Zonedashboard/delete_announcement')?>",

				"Successfully Remove This Announcement<br/>This may take a minute", data, DeleteAnnouncementSuccess, null);

	 }

}

	

function DeleteAnnouncementSuccess(result){ //alert(JSON.stringify(result)); return false;

	$.unblockUI();

	$('.announcement_display').find('tr#'+result.Tag).hide();

}

// - Delete/Success Announcements



// + allactivate/alldeactivate announcements

function allactivate_announcements(){

	$('.ad_approval_activate').click();

}

function alldeactivate_announcements(){	

	$('.ad_approval_deactivate').click();

}

// - allactivate/alldeactivate announcements



// + all_status_change_ads

function all_status_change_announcements(status){ 

	var select_id=$("#show_announcement_type").val();	

	if(select_id == 1){

		orgid_select = $("#all_organization option:selected").val();

	}else if(select_id == 0){

		orgid_select = $("#all_organization1 option:selected").val();

	}else if(select_id == -1){

		orgid_select = $("#all_organization2 option:selected").val();

	}  

	var org_id=orgid_select;

	var zoneid=$('#current_zoneid').val();

	$('table.announcement_display').hide();

	$('div.more_announcement').hide();

	PageMethod("<?=base_url('Zonedashboard/all_announcements_status_change')?>/"+org_id+"/"+status+"/"+zoneid, "Displaying The Advertisements...<br/>This may take a few minutes", null, all_status_change_announcements_success, null);

}

// - all_status_change_ads



function all_status_change_announcements_success(result){console.log(result);

	$.unblockUI();

	if(result.Tag>0){

		$('tbody.showannouncement').hide('slow');

		$('.announcement_submenu_display').hide('slow');

	}

}





// Following are the things needed to remove later on.





// + Show all announcement



//function showallannouncement(charval,tag){}



//function showAccounceInformation(result){}



// - Show all announcement



// + Announcement Approval



		//function announcement_approval(anid,option,announcements_category,announcements_type){}

	

		//function announcement_approval_success(result){}

// - Announcement Approval

	

//		

//		// + Announcement Approval for All

//		

//			function allactivate_announcement_by_org(){}

//			function alldeactivate_announcement_by_org(){}

//		

//		// - Announcement Approval for All

//		

//		// + Delete Announcement

//		

//		function DeleteAnnouncement(id, title,announcements_category,announcements_type) {

//			ConfirmDialog("Really delete : " + title, "Warning", "<?=base_url('announcements/delete')?>", "Deleting Announcement<br/>This may take a minute",

//				{ "id": id ,  "announcements_category": "1" ,  "announcements_type": announcements_type, "zoneid":default_zone}, announceSaveSuccessful, null);

//		}

//		

//		function announceSaveSuccessful(result) {

//			$.unblockUI();

//			$(".showannouncement").html(result.Tag);

//		}



// - Delete Announcement



</script>