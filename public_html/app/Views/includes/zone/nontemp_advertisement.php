<script type="text/javascript" src="<?=base_url('assets/ckeditor/ckeditor.js')?>"></script><script type="text/javascript">CKEDITOR_BASEPATH = '<?=base_url('assets/ckeditor/')?>';</script>

<input type="hidden" id="zoneid" value="<?=$zoneid?>" />
<input type="hidden" id="userid" value="<?=$uid?>" />
<div class="main_content_outer">
  <div class="content_container">
    <div class="container_tab_header">View Advertisements</div>
    <div id="container_tab_content" class="container_tab_content">
      <ul>
        <li><a href="#tabs-1" id="tab1" data-zoneid="<?=$zoneid?>" onclick="tabClick('1');">Activated Advertisement</a></li>
        <li><a href="#tabs-2" id="tab2" data-zoneid="<?=$zoneid?>" onclick="tabClick('0');">New Advertisement</a></li>
        <li><a href="#tabs-3" id="tab3" data-zoneid="<?=$zoneid?>" onclick="tabClick('-1');">Deactivated Advertisement</a></li>
      </ul>
      
      <!-- Activated Advertisement -->
      
      <input type="hidden" value="<?=$busvalue;?>" id="busvalue" />
      <input type="hidden" name="show_ad_type" id="show_ad_type" value="" />
      <div id="tabs-1">
        <div class="form-group">
          <div class="container_tab_header form-group" style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:0px; overflow:hidden;"> <span style="float:left; margin-right:10px; margin-top: 7px;">Search Your Business</span>
            <!--<select name="alpha_bus_search" id="alpha_bus_search1" onchange="get_bus_list();" class="fleft" style="margin-right:10px;">
              <option value="-1">By Alphabetical Order</option>
              <option value="A">A</option>
              <option value="B">B</option>
              <option value="C">C</option>
              <option value="D">D</option>
              <option value="E">E</option>
              <option value="F">F</option>
              <option value="G">G</option>
              <option value="H">H</option>
              <option value="I">I</option>
              <option value="J">J</option>
              <option value="K">K</option>
              <option value="L">L</option>
              <option value="M">M</option>
              <option value="N">N</option>
              <option value="O">O</option>
              <option value="P">P</option>
              <option value="Q">Q</option>
              <option value="R">R</option>
              <option value="S">S</option>
              <option value="T">T</option>
              <option value="U">U</option>
              <option value="V">V</option>
              <option value="W">W</option>
              <option value="X">X</option>
              <option value="Y">Y</option>
              <option value="Z">Z</option>
            </select>-->
            <div class="bus_name_by_char1" style="display:none;"></div>
            <div id="bus_names1" class="fleft"></div>
            <a class="fright new-help-button" href="javascript:void(0);" onclick="$('#helpdiv').slideToggle('slow')">HELP<!--<img alt="Help Tips" title="Help Tips" src="<?=base_url()?>assets/images/help.png" width="28px" height="28px"/>--></a> </div>
          <div id="helpdiv" class="container_tab_header header-default-message" style="display:none;">
            <p>This shows the "Activated Advertisements". It has the following:</p>
            <p>Select from the drop down the name of the Business of which you want to view the advertisement and then click on the "Show" button.</p>
            <p>To go inside the Business Dashboard click on the "Go To Business Dashboard" link.</p>
            <p>To change the status of the advertisements select the required from the "Change Public Display Status" drop down menu , choose the desired options from the beside drop down menus and then click on the "Update" button.</p>
          </div>
          <div class="advertisement_submenu_display"></div>
          <table class="pretty tab1 tableheader" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">
            <thead class="thead">
              <tr>
                <th width="60%">Ad Details</th>
                <th width="20%">Category / Sub-Category</th>
                <th width="10%">StartDateTime<br />
                  StopDateTime</th>
                <th width="20%">Business Details</th>
                <!--<th width="20%">Action</th>-->
                <th width="20%">
                Select/<br/>
        Deselect All<br/>
        <input type="checkbox" name="select_all_ad" class="select_all_ad"  value="all" title="Select/Deselect All" alt="Select/Deselect All">
        		</th>
              </tr>
            </thead>
            <tbody class="ad_display clean1">
            </tbody>
          </table>
          <div class ="new_ad_display"></div>
          <div class="more_advertisement" style="float:right; display:none;"><a class="advertisement_limit" href="javascript:void(0)" style=" color:#000;" onclick="fn_displayAdvertisement(<?=$zoneid?>,this);" rel="0,0">Display more advertisements</a> </div>
        </div>
      </div>
      
      <!-- New Advertisement -->
      
      <div id="tabs-2">
        <div class="form-group">
          <div class="container_tab_header form-group" style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:0px; overflow:hidden;"> <span style="float:left; margin-right:10px; margin-top: 7px;">Search Your Business</span>
            <!--<select name="alpha_bus_search" id="alpha_bus_search2" onchange="get_bus_list();" class="fleft" style="margin-right:10px;">
              <option value="-1">By Alphabetical Order</option>
              <option value="A">A</option>
              <option value="B">B</option>
              <option value="C">C</option>
              <option value="D">D</option>
              <option value="E">E</option>
              <option value="F">F</option>
              <option value="G">G</option>
              <option value="H">H</option>
              <option value="I">I</option>
              <option value="J">J</option>
              <option value="K">K</option>
              <option value="L">L</option>
              <option value="M">M</option>
              <option value="N">N</option>
              <option value="O">O</option>
              <option value="P">P</option>
              <option value="Q">Q</option>
              <option value="R">R</option>
              <option value="S">S</option>
              <option value="T">T</option>
              <option value="U">U</option>
              <option value="V">V</option>
              <option value="W">W</option>
              <option value="X">X</option>
              <option value="Y">Y</option>
              <option value="Z">Z</option>
            </select>-->
            <div class="bus_name_by_char2" style="display:none;"></div>
            <div id="bus_names2" class="fleft"></div>
            <a class="fright new-help-button" href="javascript:void(0);" onclick="$('#helpdiv1').slideToggle('slow')">HELP<!--<img alt="Help Tips" title="Help Tips" src="<?=base_url()?>assets/images/help.png" width="28px" height="28px"/>--></a> </div>
          <div id="helpdiv1" class="container_tab_header header-default-message" style="display:none;">
            <p>This shows the "New Advertisements". It has the following:</p>
            <p>Select from the drop down the name of the Business of which you want to view the advertisement and then click on the "Show" button.</p>
            <p>To go inside the Business Dashboard click on the "Go To Business Dashboard" link.</p>
            <p>To change the status of the advertisements select the required from the "Change Public Displpay Status" drop down menu , choose the desired options from the beside drop down menus and then click on the "Update" button.</p>
         </div>
          <div class="advertisement_submenu_display"></div>
          <table class="pretty tab2 tableheader" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">
            <thead class="thead">
              <tr>
                <th width="60%">Ad Details</th>
                <th width="20%">Category / Sub-Category</th>
                <th width="10%">StartDateTime<br />
                  StopDateTime</th>
                <th width="20%">Business Details</th>
                <th width="20%">
                Select/<br/>
        Deselect All<br/>
        <input type="checkbox" name="select_all_ad" class="select_all_ad"  value="all" title="Select/Deselect All" alt="Select/Deselect All">
        		</th>
              </tr>
            </thead>
            <tbody class ="ad_display clean2">
            </tbody>
          </table>
          <div class ="new_ad_display"></div>
          <div class="more_advertisement" style="float:right; display:none;"><a class="advertisement_limit" href="javascript:void(0)" style=" color:#000;" onclick="fn_displayAdvertisement(<?=$zoneid?>,this);" rel="0,0">Display more advertisements</a> </div>
        </div>
      </div>
      
      <!-- Deactivated Advertisement -->
      
      <div id="tabs-3">
        <div class="form-group">
          <div class="container_tab_header form-group" style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:0px; overflow:hidden;"> <span style="float:left; margin-right:10px; margin-top: 7px;">Search Your Business</span>
            <!--<select name="alpha_bus_search" id="alpha_bus_search3" onchange="get_bus_list();" class="fleft" style="margin-right:10px;">
              <option value="-1">By Alphabetical Order</option>
              <option value="A">A</option>
              <option value="B">B</option>
              <option value="C">C</option>
              <option value="D">D</option>
              <option value="E">E</option>
              <option value="F">F</option>
              <option value="G">G</option>
              <option value="H">H</option>
              <option value="I">I</option>
              <option value="J">J</option>
              <option value="K">K</option>
              <option value="L">L</option>
              <option value="M">M</option>
              <option value="N">N</option>
              <option value="O">O</option>
              <option value="P">P</option>
              <option value="Q">Q</option>
              <option value="R">R</option>
              <option value="S">S</option>
              <option value="T">T</option>
              <option value="U">U</option>
              <option value="V">V</option>
              <option value="W">W</option>
              <option value="X">X</option>
              <option value="Y">Y</option>
              <option value="Z">Z</option>
            </select>-->
            <div class="bus_name_by_char3" style="display:none;"></div>
            <div id="bus_names3" class="fleft"></div>
            <a class="fright new-help-button" href="javascript:void(0);" onclick="$('#helpdiv2').slideToggle('slow')">HELP<!--<img alt="Help Tips" title="Help Tips" src="<?=base_url()?>assets/images/help.png" width="28px" height="28px"/>--></a> </div>
          <div id="helpdiv2" class="container_tab_header header-default-message" style="display:none;">
            <p>This shows the "Deactivated Advertisement". It has the following:</p>
            <p>Select from the drop down the name of the Business of which you want to view the advertisement and then click on the "Show" button.</p>
            <p>To go inside the Business Dashboard click on the "Go To Business Dashboard" link.</p>
            <p>To change the status of the advertisements select the required from the "Change Public Displpay Status" drop down menu , choose the desired options from the beside drop down menus and then click on the "Update" button.</p>
        </div>
          <div class="advertisement_submenu_display"></div>
          <table class="pretty tab3 tableheader" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">
            <thead class="thead">
              <tr>
                <th width="60%">Ad Details</th>
                <th width="20%">Category / Sub-Category</th>
                <th width="10%">StartDateTime<br />
                  StopDateTime</th>
                <th width="20%">Business Details</th>
                <th width="20%">
                Select/<br/>
        Deselect All<br/>
        <input type="checkbox" name="select_all_ad" class="select_all_ad"  value="all" title="Select/Deselect All" alt="Select/Deselect All">
        		</th>
              </tr>
            </thead>
            <tbody class ="ad_display clean3">
            </tbody>
          </table>
          <div class ="new_ad_display"></div>
          <div class="more_advertisement" style="float:right; display:none;"><a class="advertisement_limit" href="javascript:void(0)" style=" color:#000;" onclick="fn_displayAdvertisement(<?=$zoneid?>,this);" rel="0,0">Display more advertisements</a> </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function () { 
	$('#zone_advertisement_accordian').click();
	$('#zone_nontemp_advertisement').addClass('active');
	$('#tab1').click();
	//$('.alpha_bus_search').change();
});

var zone_id = '<?=$zoneid;?>';
function  check_authneticate(){ //alert(1);
	var is_authenticated=0;
	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ //alert('success');
		is_authenticated=data;
	}});	
	return is_authenticated;
}
var businessid_select = 0;
// + tab clicks
function tabClick(val){ //alert(val); alert($('#zoneid').val());
	
	$('#show_ad_type').val(val);
	$('.ad_display').html('');
	$('.advertisement_submenu_display').html('');
	$('.new_ad_display').html('');
	$('.more_advertisement').hide();
	if(val == 1){
		$('#bus_names2').html(''); $('#bus_names3').html(''); 
		$('#alpha_bus_search2 option[value=-1]').attr('selected','selected');
		$('#alpha_bus_search3 option[value=-1]').attr('selected','selected');
	}
	if(val == 0){
		$('#bus_names1').html(''); $('#bus_names3').html('');
		$('#alpha_bus_search1 option[value=-1]').attr('selected','selected');
		$('#alpha_bus_search3 option[value=-1]').attr('selected','selected');		
	}
	if(val == -1){
		$('#bus_names1').html(''); $('#bus_names2').html(''); 
		$('#alpha_bus_search1 option[value=-1]').attr('selected','selected');
		$('#alpha_bus_search2 option[value=-1]').attr('selected','selected');		
	}
	var data={'zoneid':$('#zoneid').val(), 'approval':val, 'bustype':0}
	PageMethod("<?=base_url('Zonedashboard/display_business_by_character')?>", "", data, DisplayBusinessByCharacterSuccess, null); 
}
// - tab clicks
function DisplayBusinessByCharacterSuccess(result){ //alert(JSON.stringify(result)); //return false;
	$.unblockUI();
	var approval=result.Message; 
	var select_id=$("#show_ad_type").val();
	if(result.Tag!=''){ 
		if(select_id == 1){
			$('.bus_name_by_char1').html(result.Tag).show();	// set char wise dropdown
			$('.bus_name_by_char2').html('').hide();			// Empty and Hide other tab divs
			$('.bus_name_by_char3').html('').hide();			// Empty and Hide other tab divs
		}else if(select_id == 0){
			$('.bus_name_by_char2').html(result.Tag).show();	// set char wise dropdown
			$('.bus_name_by_char1').html('').hide();			// Empty and Hide other tab divs
			$('.bus_name_by_char3').html('').hide();			// Empty and Hide other tab divs
		}else if(select_id == -1){
			$('.bus_name_by_char3').html(result.Tag).show();	// set char wise dropdown
			$('.bus_name_by_char2').html('').hide();			// Empty and Hide other tab divs	
			$('.bus_name_by_char1').html('').hide();			// Empty and Hide other tab divs	
		}
		
		$('select#alpha_bus_search'+approval).change();
	}else{
		//$('.bus_name_by_char').html('').hide();
	}
}

// + Advertisement Submenu for Business
function advertisement_submenu(zone_id,tag){ 	
	var authenticate=check_authneticate();
	if(authenticate=='0'){
		var zone_id = <?=$zoneid?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){
		//$(".advertisement_submenu_display").html('');
		$("#editAdfromshowad").html('');
		var select_id=$("#show_ad_type").val();		 
		if(select_id == 1){
			businessid_select = $("#all_business option:selected").val();
		}else if(select_id == 0){
			businessid_select = $("#all_business1 option:selected").val();
		}else if(select_id == -1){
			businessid_select = $("#all_business2 option:selected").val();
		}  
		var business_id=businessid_select; 	
		var check_business=business_id.indexOf("-");  
		data={	business_id:business_id	}	
		if(check_business=='-1' && business_id!=''){
			PageMethod("<?=base_url('Zonedashboard/display_advertisement_submenu')?>/"+zone_id+"/"+select_id, "", data, DisplayAdvertisementExtraPartSuccess, null); 
		}else{
			$(".advertisement_submenu_display").hide();
			
			fn_displayAdvertisement(zone_id,'');
		}
	 }
}
function DisplayAdvertisementExtraPartSuccess(result){ 
	$.unblockUI();
	var zone_id=result.Title;
	if(result.Tag!=''){
		$(".advertisement_submenu_display").show(); 
		$(".advertisement_submenu_display").html(result.Tag);		
		fn_displayAdvertisement(zone_id,'');
	}
}

// - Advertisement Submenu for Business

// + Displaying Avvertise section
function fn_displayAdvertisement(zone_id,tag){ 
	var authenticate=check_authneticate();
	if(authenticate=='0'){
		var zone_id = <?=$zoneid?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){
		var select_id=$("#show_ad_type").val();
		if(select_id == 1){
			businessid_select = $("#all_business option:selected").val();
		}else if(select_id == 0){
			businessid_select = $("#all_business1 option:selected").val();
		}else if(select_id == -1){
			businessid_select = $("#all_business2 option:selected").val();
		}
		var ad_categorytype =0; //alert(ad_categorytype); 
		var business_id=businessid_select; 
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
		data = {business_id : business_id}
		PageMethod("<?=base_url('Zonedashboard/display_ad')?>/"+ad_categorytype+"/"+select_id+"/"+zone_id+"/"+charval+"/"+lowerlimit+"/"+upperlimit, "Displaying The Advertisements...<br/>This may take a few minutes", data, DisplayAdvertisementSuccess, null);
	 }
}
function DisplayAdvertisementSuccess(result){ 
	$.unblockUI();	//alert(JSON.stringify(result));
	var total_result=result.Title; 
	var select_id = $("#show_ad_type").val();
	if(total_result==0){
		//$('#thead').hide();
		$('.thead').hide();
		$('.more_advertisement').hide();
	}else{
		//$('#thead').show();
		$('.thead').show();
		if(total_result>4){ 
			$('.more_advertisement').show();
		}else{
			$('.more_advertisement').hide();
		}
	}
	var limit=result.Message; 	
	if(result.Tag!=''){
		if(limit=='5,5'){ 
			$(".ad_display").html('');
			$(".ad_display").append(result.Tag);			
		}else{
			$(".ad_display").append(result.Tag);
		}
		$('.ad_display').find('tr.headerclass_ad:not(:first)').hide();	// hiding action performed bar at the pagination time
		$('input:checkbox').removeAttr('disabled');	// uncheck all check boxes when ads data coming
		if(select_id == 1){
			if($('#tabs-1').find('tr').hasClass('ads_row') == false){
				$('.tab1').hide();
				$('.ad_display').html('<div style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;" class="container_tab_header">No Activated Advertisement Found</div>');
			}
			else{
				$('.tab1').show();
			}
			$('.clean2').html(''); $('.clean3').html('');	// clearing other tabs data
		}else if(select_id == 0){
			if($('#tabs-2').find('tr').hasClass('ads_row') == false){
				$('.tab2').hide();
				$('.ad_display').html('<div style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;" class="container_tab_header">No New Advertisement Found</div>');
			}
			else{
				$('.tab2').show();
			}	
 		    $('.clean1').html(''); $('.clean3').html('');	// clearing other tabs data
		}
		else if(select_id == -1){
			if($('#tabs-3').find('tr').hasClass('ads_row') == false){
				$('.tab3').hide();
				$('.ad_display').html('<div style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;" class="container_tab_header">No Deactivated Advertisement Found</div>');				
			}
			else{
				$('.tab3').show();
			}	
			$('.clean1').html(''); $('.clean2').html('');		// clearing other tabs data
		}
		$('.advertisement_limit').attr('rel',limit);		
	}
}

// - Displaying Avvertise section

// + action performed change
function action_performed_change(){
	var selectVal = $('#action_performed :selected').val();
	if(selectVal == 1){
		$('#change_ads_status').show();
	}else if(selectVal == 2){
		$('#change_ads_status').hide();
	}
}
// - action performed change

// + For Spedific or All Add
function specific_or_all(){ 
var selectVal = $('#specific_or_all :selected').val();
	if(selectVal == 1){ 
		$('input:checkbox').removeAttr('disabled');
	}else if(selectVal == 2){ 
		$('input:checkbox').attr('disabled', 'disabled'); 
	}
		//alert($(this).val());//$('.display_checkbox1').attr('checked','checked');
}
// - For Spedific or All Add


// + Update for Advertisement
$(document).on('click','#update_ad',function(){
	var action_performed = $(this).parents('#action_performed_div').find('#action_performed').val(); 
	var change_ads_status=$(this).parents('#action_performed_div').find('#change_ads_status').val(); 
	var allorspecific = $(this).parents('#action_performed_div').find('#specific_or_all').val();
	var display_checkbox='';		
	$("input[name=checkadforchange]:Checked").each(function(i,item){
		display_checkbox+=$(item).val()+',';
	});	
	display_checkbox=display_checkbox.substring(0,display_checkbox.length-1);
	if(display_checkbox == '' && $('input:checkbox').prop('disabled') != true){
		alert('Please Select At Least One Organization');
		return false;
	}
	var ads_type = $(this).attr('data-adtype');
	var businessid = $(this).attr('data-businessid');
	var data = { "id": display_checkbox ,"zone_id" : zone_id, "action_performed" : action_performed, "change_ads_status" : change_ads_status, "allorspecific" : allorspecific, "ads_type" : ads_type, "businessid" : businessid}; 
	if(action_performed == 1){ // Update Status Activate and Deactivate
		PageMethod("<?=base_url('Zonedashboard/action_performed_zone_ads')?>", "Changing status...<br/>This may take a few minutes", data, actionPerformedSuccess, null);
	}
	else if(action_performed == 2){		// Delete Advertisement
		ConfirmDialog("Do you really want to delete? ", "Delete Advertisement", "<?=base_url('Zonedashboard/action_performed_zone_ads')?>", "Deleting Ads...<br/>This may take a few minutes", data, actionPerformedSuccess, null);
	}
});
function actionPerformedSuccess(result){
	$.unblockUI();
	var data = result.Title;
	
	if(data != ''){
		
		if(data == 'all'){
			$('.ads_row').html('');
		}
		else{
			var id_arr = data.split(',');
			$.each(id_arr,function(i,j){ 
				$('.pretty').find('tr#'+j).hide();
				
			});
		}
	}
}

// - Update for Advertisement

// + To Select All from header
$(document).on('click','.select_all_ad',function(){ //alert(1);
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
}); 
// - To Select All from header

// + Active / Deactive all ads
function allactivate_ads(){		// N O T   I N   U S E
	$('.ad_approval_activate').click();
}
function alldeactivate_ads(){		// N O T   I N   U S E
	$('.ad_approval_deactivate').click();
}
// - Active / Deactive all ads

// + ads status change
function all_status_change_ads(status){			// N O T   I N   U S E
	var select_id=$("#show_ad_type").val();	
	if(select_id == 1){
		businessid_select = $("#all_business option:selected").val();
	}else if(select_id == 0){
		businessid_select = $("#all_business1 option:selected").val();
	}else if(select_id == -1){
		businessid_select = $("#all_business2 option:selected").val();
	}  
	var business_id=businessid_select;
	var zoneid=$('#current_zoneid').val();
	$('table.advertisement_display').hide();
	$('div.more_advertisement').hide();
	PageMethod("<?=base_url('Zonedashboard/all_ads_status_change')?>/"+business_id+"/"+status+"/"+zoneid, "Displaying The Advertisements...<br/>This may take a few minutes", null, null, null);
}
// - ads status change

// + Ads approval change
function ad_approval(adid,zoneid,option,bus_id){ 		// N O T   I N   U S E
	var authenticate=check_authneticate();
	if(authenticate=='0'){
		var zone_id = <?=$zoneid?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){
		var select_id=$("#show_ad_type").val();	
		if(select_id == 1){
			businessid_select = $("#all_business option:selected").val();
		}else if(select_id == 0){
			businessid_select = $("#all_business1 option:selected").val();
		}else if(select_id == -1){
			businessid_select = $("#all_business2 option:selected").val();
		}
		var business_id=businessid_select;	
		$('tr#'+adid).hide();
		$('.advertisement_display').find('tr#'+adid).hide();
		PageMethod("<?=base_url('Zonedashboard/edit_ad')?>/"+adid+"/"+zoneid+"/"+option+"/"+select_id+"/"+bus_id+"/"+business_id, "Displaying The Advertisements...<br/>This may take a few minutes", null, null, null);
	 }
}

// - Ads approval change


// + Ads Delete
function ad_approval_delete(adid,zoneid,option,busid){			// N O T   I N   U S E
	var authenticate=check_authneticate();
	if(authenticate=='0'){
		var zone_id = <?=$zoneid?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){
		var select_id=$("#show_ad_type").val();
		if(select_id == 1){
			businessid_select = $("#all_business option:selected").val();
		}else if(select_id == 0){
			businessid_select = $("#all_business1 option:selected").val();
		}else if(select_id == -1){
			businessid_select = $("#all_business2 option:selected").val();
		}
		var business_id=businessid_select;
		
		var data = { adid : adid, zoneid : zoneid, option : option, select_id : select_id, busid : busid, business_id : business_id};
		ConfirmDialog("Really remove this advertisement from this zone?", "Warning", "<?=base_url('Zonedashboard/delete_ad')?>",
				"Successfully Remove This Ad<br/>This may take a minute", data, DeleteAdSuccess, null);
	 }
}
function DeleteAdSuccess(result){
	$.unblockUI();
	$('.advertisement_display').find('tr#'+result.Title).hide();
}
// - Ads Delete


<?php /*?>// + This will edit the ad created/Success				// N O T   I N   U S E
function showeditform(adid,zoneid,businessid){ 	
	var authenticate=check_authneticate();
	if(authenticate=='0'){
		var zone_id = <?=$zone_id?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){			
		PageMethod("<?=base_url('Zonedashboard/showeditform')?>/"+adid+'/'+zoneid+'/'+businessid, "Fetching Ad<br/>This may take a minute.", null, ShowEditadFormSuccess, null);
	 }
}

function ShowEditadFormSuccess(result){ //alert(JSON.stringify(result)); //console.log(result.Message);
	$.unblockUI();
	$(".ad_display").html(result.Tag);
	CKEDITOR.replace( 'ad_text_fromshowad', {
		fullPage: true,
		allowedContent: true,
		height: 100,
		width: 550
	});	
	var ads=result.Message; 
	var content='';
	if(ads.type == 2){			
		content += '<option class="optioncategory" value="14">By Industry & Start-up Cost</option>';	
	}
	else{
		$.each(ads.category_list1,function(i,j){
			if(j.id != 14){
				content += '<option class="optioncategory" value="'+j.id+'">'+j.name+'</option>';
			}
		});
	}
	$('#ad_category_fromshowad').html(content);
	$('#bus_id_againest_advertisement').val(ads.business_id);
	$('#logo_image22').hide();
	$('#docs_pdf').val(ads.docs_pdf);
	if(ads.docs_pdf!=''){
		$('#docs_pdf_show').show();
	}else{
		$('#docs_pdf_show').hide();
	}
	$('#logo_image222').hide();
	$('#docs_foodmenu').val(ads.foodmenu);
	if(ads.foodmenu!=''){
		$('#docs_foodmenu_show').show();
	}else{
		$('#docs_foodmenu_show').hide();
	}
	if($('#busvalue').val() == 1){
		$('#ad_category_fromshowad option[value=-99]').prop('disabled',false);
	}
	else if($('#busvalue').val() == 0){
		$('#ad_category_fromshowad option[value=-99]').prop('disabled',true);
	}
	
	var zoneid=ads.zoneid;
	var file_upload_text=ads.docs_pdf;
	var file_upload_text_final=file_upload_text.substring(16);
	$('label#docs_pdf_1').html(file_upload_text_final);
	var file_upload_text_menu=ads.foodmenu;
	var file_upload_text_final_menu=file_upload_text_menu.substring(16);
	$('label#docs_pdf_foodmenu').html(file_upload_text_final_menu);
	$('#editAdfromshowad').find('#ad_name_search_engine_title').val(ads.search_engine_title);
	$('#editAdfromshowad').find('span#search_engine_title_display').text('www.savingssites.com/zone/load/'+zoneid+'/'+ads.search_engine_title);
	$('#editAdfromshowad').find('#ad_business_fromshowad').val(ads.business_id);
	$('#editAdfromshowad').find('#ad_id_fromshowad').val(ads.id);
	$('#editAdfromshowad').find('#ad_name_fromshowad').val(ads.name);
	$('#editAdfromshowad').find('#ad_code_fromshowad').val(ads.offer_code);
	$('#editAdfromshowad').find('#ad_startdatetime_fromshowad').val(ads.startdatetime);
	$('#editAdfromshowad').find('#ad_stopdatetime_fromshowad').val(ads.stopdatetime);
	CKEDITOR.instances.ad_text_fromshowad.setData(ads.adtext),
	$('#editAdfromshowad').find('#text_message_fromshowad').val(ads.text_message);
	$('#iseditad').val(1);
	$("p.p_change_reason").show();
	//$("#change_reason").val(ads.change_reason);
	$('#editAdfromshowad').find('#ad_category_fromshowad').find('option[value='+ads.categoryid+']').attr('selected','selected');
	$('#editAdfromshowad').find('#ad_subcategory_fromshowad').find('option[value='+ads.subcategoryid+']').attr('selected','selected');
	//$('#ad_subcategory_fromshowad').find('option[value='+ads.subcategoryid1+']').attr('selected','selected');
	if(ads.categoryid==1){
		$('.food_icon_image').show(); $(".food_menu").show();
	}else{
		$('.food_icon_image').hide(); $(".food_menu").hide();
	}
	var cat_arr=ads.catid.split(','); //alert(cat_arr);	
	$.each(cat_arr,function(i,j){ //alert(j);
		$('#ad_category_fromshowad').find('option[value='+j+']').attr('selected','selected');
		var n=j.indexOf("1"); 

		if(n>-1){
			$(".food_icon_image").show(); $(".food_menu").show();
		}else{
			$(".food_icon_image").hide(); $(".food_menu").hide(); $('#foodimage').val('');
			$('.checkclass').removeClass('food_icon_image_selected'); $('.checkclass').addClass('food_icon_image_normal');
		} 
	});
	var subcat_arr=ads.subcatid.split(','); 
	business_cat(subcat_arr);
	$('#foodimage').val(ads.imagetype);
	var imagetype=ads.imagetype;
	if(imagetype!=0){
	var imagetype_split=imagetype.split(',');	
	$.each(imagetype_split,function(i,item){		
		$("a.checkclass[rel="+item+"]").attr('class','food_icon_image_selected checkclass');
	});
	}
	$('div#editAdfromshowad').show();
	
	$('#bustype').val(ads.type);
}
// - // + This will edit the ad created/Success

// + Business category Showing
function business_cat(subcat_id_foredit){
	if(subcat_id_foredit=='' || subcat_id_foredit==undefined)
		var subcat_id_foredit=0;
	else
		var subcat_id_foredit=subcat_id_foredit;
	var cat_id=$('#ad_category_fromshowad').val();
	var iszoneid=$('#zoneid').val();
	
	if(cat_id=='' || cat_id=='-1'){ 	
		$("#ad_subcategory_fromshowad1").hide();
		$(".food_icon_image").hide();$('#foodimage').val('');
		$('.checkclass').removeClass('food_icon_image_selected');$('.checkclass').addClass('food_icon_image_normal');
	}else{
		$("#ad_subcategory_fromshowad1").show(); //$(".food_icon_image").show();
		var n=cat_id.indexOf("1");
		if(n>-1){
			$(".food_icon_image").show(); $(".food_menu").show();
		}else{
			$(".food_icon_image").hide(); $(".food_menu").hide(); $('#foodimage').val('');
			$('.checkclass').removeClass('food_icon_image_selected'); $('.checkclass').addClass('food_icon_image_normal');
		}
		var data = { cat_id : cat_id , iszoneid : iszoneid , subcat_id_foredit : subcat_id_foredit};
		PageMethod("<?=base_url('Zonedashboard/subcategories_in_a_category_zone')?>", "", data, adSubcategorySuccess, null);
	}
}
function adSubcategorySuccess(result){
	$.unblockUI();
	if(result.Tag!=''){	
		$("#ad_subcategory_fromshowad1").html(result.Tag);
		if(result.Message!=''){
			var subcat_arr=result.Message; 
			$.each(subcat_arr,function(i,j){ 
				$('#ad_subcategory_fromshowad1').find('option[rel='+j+']').attr('selected','selected');			
			});
		}
	}
}

// - Business category Showing<?php */?>						// N O T   I N   U S E

// + Getting Business List
function get_bus_list(){ //alert('anish');
	var zoneid = $('#zoneid').val();
	var userid = $('#userid').val();
	var select_id = $("#show_ad_type").val(); //alert(select_id); return false;
	var char = '';
	/*if(select_id == 1){
		char = $('#alpha_bus_search1').val();
	}
	if(select_id == 0){
		char = $('#alpha_bus_search2').val();
	}
	if(select_id == -1){
		char = $('#alpha_bus_search3').val();
	}*/
	var char = $('#alpha_bus_search'+select_id+' option:selected').val(); 
	var data = {'zoneid' : zoneid, 'userid' : userid, 'busvalue' : 0, 'char' : char, 'select_id' : select_id}
	PageMethod("<?=base_url('Zonedashboard/get_bus_list')?>/", "", data, getbuslistsuccess, null);
}
function getbuslistsuccess(result){ 
	$.unblockUI();
	if(result.Tag != ''){
		$('.advertisement_submenu_display').html('');
		$('.ad_display').html('');
		var select_id=$("#show_ad_type").val();
		if(select_id == 1){
			$('#bus_names1').html(result.Tag);
		}else if(select_id == 0){
			$('#bus_names2').html(result.Tag);
		}else if(select_id == -1){
			$('#bus_names3').html(result.Tag);
		}
		if($('#bus_names1').find('button').hasClass('showad') == true){
			$('.showad').click();
		}
		if($('#bus_names2').find('button').hasClass('showad') == true){ 
			$('.showad').click();
		}
		if($('#bus_names3').find('button').hasClass('showad') == true){ 
			$('.showad').click();
		}				
	}
}

// - Getting Business List

<?php /*?>// + New Ads For a Particular Business

function newadview(){
	var select_id=$("#show_ad_type").val();		 
	if(select_id == 1){
		businessid_select = $("#all_business option:selected").val();
	}else if(select_id == 0){
		businessid_select = $("#all_business1 option:selected").val();
	}else if(select_id == -1){
		businessid_select = $("#all_business2 option:selected").val();
	}  
	var business_id=businessid_select; 	
	window.location.href='<?=base_url('Zonedashboard/newadview')?>/'+zone_id+"/0/0/"+business_id;	
}

// - New Ads For a Particular Business<?php */?>

<?php /*?>// + This will edit the ad created/Success
function ads_edit(adid,zoneid,businessid){
	window.location.href='<?=base_url('Zonedashboard/editadview')?>/'+zoneid+"/0/0/"+businessid + "/" + adid;
}
// -  This will edit the ad created/Success<?php */?>
</script>