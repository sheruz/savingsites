<input type="hidden" id="zoneid" name="zoneid" value="<?php echo $zoneid;?>"/>
<div class="main_content_outer">
  <div class="content_container">
    <div class="container_tab_header">Businesses that are Opportunity Providers</div>
    <div id="container_tab_content" class="container_tab_content">
      <ul>
        <li><a href="#tabs-1" id="tabs-title_1">Trial Businesses</a></li>
        <li><a href="#tabs-2" id="tabs-title_2">Paid Businesses</a></li>
        
      </ul>
      <!-- + Paid Businesses With Non Temp Category -->
      <div id="tabs-1">
        <div class="form-group">        
        <div class="container_tab_header" style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:0px;">
        	<!--<span style="padding-left:5px;"><strong>Filter</strong></span>
        	<select style="width:390px; margin-right:53px;" name="business_zone_fp_trial" id="business_zone_fp_trial">
       			<option value="1">Businesses in my zone and located in my zone</option>
       			<option value="0">Businesses advertising in my zone but located outside my zone</option>
       		</select>-->
      		
      		<button class="btn-sm active_fbt active" type="button" id="2###fbt" style="margin-left:-7px;">Search for Active Businesses</button>
        	<button class="btn-sm deactive_fbt" type="button" id="-2###fbt">Search for Inactive Businesses</button>        	
        	<a href="javascript:void(0);" onclick="$('#fbt').slideToggle('slow')"><img src="<?=base_url()?>assets/images/find.png" style="margin:7px 0 0 240px" width:"20px" height="20px" alt="Search Businesses" title="Search Businesses"/></a>
            <a class="fright new-help-button" href="javascript:void(0);" onclick="$('#fbt_helpdiv').slideToggle('slow')">HELP<!--<img alt="Help Tips" title="Help Tips" src="<?=base_url()?>assets/images/help.png" style="margin:3px 0 0 4px" width:"28px" height="28px"/>--></a>
        </div>
        <div id="fbt_helpdiv" class="container_tab_header header-default-message" style="display:none;">
        <p>This shows the "Paid Businesses with Non Temp Category". It has the following:</p>
        <p>To view the active paid businesses located in your zone or outside your zone select the desired option from "Filter" dropdown and then click on "Active Biz." option.</p>
         <p>To view the active paid businesses located in your zone or outside your zone select the desired option from "Filter" dropdown and then click on "Deactive Biz." option.</p>
        <p>Search your business directly by entering the name inside "Direct search by business name" text box and click on the "Search" option. Or search businesses alphabetically by selecting the desired alphabet and then click on the "Search" option.</p>
        </div>
          <!-- Search Part Start -->
            <div class="container_tab_header" id="fbt" style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:0px;display:none;">
          	<div class="bus_search_fbt_active">
            <input type="text" id="text_bus_search_fbt_active" name="text_bus_search_fbt_active" placeholder="Direct search by business name" style="width:240px;" />
        	<button class="btn-sm"  id="btn_bus_search_by_name_fbt_active" type="button">Search</button>
            <strong>Search Your Businesses </strong></strong>
            <select name="select_bus_search_fbt_active" id="select_bus_search_fbt_active">
                <option value="-1">By Alphabetical Order</option><option value="all">ALL</option><option value="A">A</option><option value="B">B</option><option value="C">C</option><option value="D">D</option><option value="E">E</option><option value="F">F</option><option value="G">G</option><option value="H">H</option><option value="I">I</option><option value="J">J</option><option value="K">K</option><option value="L">L</option><option value="M">M</option><option value="N">N</option> <option value="O">O</option><option value="P">P</option><option value="Q">Q</option><option value="R">R</option><option value="S">S</option><option value="T">T</option><option value="U">U</option> <option value="V">V</option><option value="W">W</option><option value="X">X</option><option value="Y">Y</option><option value="Z">Z</option>          			
            </select>
            <button class="btn-sm"  id="btn_bus_search_by_alphabet_fbt_active" type="button">Search</button>
            </div>
            
            
            <div class="bus_search_fbt_deactive" style="display:none;">
            <input type="text" id="text_bus_search_fbt_deactive" name="text_bus_search_fbt_deactive" placeholder="Direct search by business name" style="width:240px;" />
        	<button class="btn-sm"  id="btn_bus_search_by_name_fbt_deactive" type="button">Search</button>
            <strong>Search Your Businesses </strong></strong>
            <select name="select_bus_search_fbt_deactive" id="select_bus_search_fbt_deactive">
                <option value="-1">By Alphabetical Order</option><option value="all">ALL</option><option value="A">A</option><option value="B">B</option><option value="C">C</option><option value="D">D</option><option value="E">E</option><option value="F">F</option><option value="G">G</option><option value="H">H</option><option value="I">I</option><option value="J">J</option><option value="K">K</option><option value="L">L</option><option value="M">M</option><option value="N">N</option> <option value="O">O</option><option value="P">P</option><option value="Q">Q</option><option value="R">R</option><option value="S">S</option><option value="T">T</option><option value="U">U</option> <option value="V">V</option><option value="W">W</option><option value="X">X</option><option value="Y">Y</option><option value="Z">Z</option>          			
            </select>
            <button class="btn-sm"  id="btn_bus_search_by_alphabet_fbt_deactive" type="button">Search</button>
            </div>
          </div>
          <!-- Search Part End -->
          <div class="view_franchisee_business" style="display:none;"></div>
          <div class="edit_franchisee_business" style="display:none;"></div>
        </div>
      </div>
      <!-- - Paid Businesses With Non Temp Category --> 
      <!-- + Trial Businesses With Non Temp Category -->
      <div id="tabs-2">
        <div class="form-group">
          <div class="container_tab_header" style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:0px;">
                <!--<span style="padding-left:5px;"><strong>Filter</strong></span>
                <select style="width:390px; margin-right:53px;" name="business_zone_fp_paid" id="business_zone_fp_paid">
                    <option value="1">Businesses in my zone and located in my zone</option>
                    <option value="0">Businesses advertising in my zone but located outside my zone</option>
                </select>-->
                <button class="btn-sm active_fbp active" type="button" id="1###fbp" style="margin-left:-7px;">Search for Active Businesses</button>
                <button class="btn-sm deactive_fbp" type="button" id="-1###fbp">Search for Inactive Businesses</button>
                <!--<button class="btn-sm " type="button" style="background-color:green">Search</button>-->                
                <a href="javascript:void(0);" onclick="$('#fbp').slideToggle('slow')"><img src="<?=base_url()?>assets/images/find.png" style="margin:7px 0 0 240px" width:"20px" height="20px" alt="Search Businesses" title="Search Businesses"/></a>
                <a class="fright new-help-button" href="javascript:void(0);" onclick="$('#fbp_helpdiv').slideToggle('slow')">HELP<!--<img alt="Help Tips" title="Help Tips" src="<?=base_url()?>assets/images/help.png" style="margin:3px 0 0 4px" width:"28px" height="28px"/>--></a>
            </div>
            <div id="fbp_helpdiv" class="container_tab_header header-default-message" style="display:none;">
        <p>This shows the "Trial Businesses with Non Temp Category". It has the following:</p>
        <p>To view the active paid businesses located in your zone or outside your zone select the desired option from "Filter" dropdown and then click on "Active Biz." option.</p>
         <p>To view the active paid businesses located in your zone or outside your zone select the desired option from "Filter" dropdown and then click on "Deactive Biz." option.</p>
        <p>Search your business directly by entering the name inside "Direct search by business name" text box and click on the "Search" option. Or search businesses alphabetically by selecting the desired alphabet and then click on the "Search" option.</p>
        </div>
          <!-- Search Part Start -->
            <div class="container_tab_header" id="fbp" style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:0px; display:none;">
          	<div class="bus_search_fbp_active">
            <input type="text" id="text_bus_search_fbp_active" name="text_bus_search_fbp_active" placeholder="Direct search by business name" style="width:240px;" />
        	<button class="btn-sm"  id="btn_bus_search_by_name_fbp_active" type="button">Search</button>
            <strong>Search Your Businesses </strong></strong>
            <select name="select_bus_search_fbp_active" id="select_bus_search_fbp_active">
                <option value="-1">By Alphabetical Order</option><option value="all">ALL</option><option value="A">A</option><option value="B">B</option><option value="C">C</option><option value="D">D</option><option value="E">E</option><option value="F">F</option><option value="G">G</option><option value="H">H</option><option value="I">I</option><option value="J">J</option><option value="K">K</option><option value="L">L</option><option value="M">M</option><option value="N">N</option> <option value="O">O</option><option value="P">P</option><option value="Q">Q</option><option value="R">R</option><option value="S">S</option><option value="T">T</option><option value="U">U</option> <option value="V">V</option><option value="W">W</option><option value="X">X</option><option value="Y">Y</option><option value="Z">Z</option>          			
            </select>
            <button class="btn-sm"  id="btn_bus_search_by_alphabet_fbp_active" type="button">Search</button>
            </div>
            
            
            <div class="bus_search_fbp_deactive" style="display:none;">
            <input type="text" id="text_bus_search_fbp_deactive" name="text_bus_search_fbp_deactive" placeholder="Direct search by business name" style="width:240px;" />
        	<button class="btn-sm"  id="btn_bus_search_by_name_fbp_deactive" type="button">Search</button>
            <strong>Search Your Businesses </strong></strong>
            <select name="select_bus_search_fbp_deactive" id="select_bus_search_fbp_deactive">
                <option value="-1">By Alphabetical Order</option><option value="all">ALL</option><option value="A">A</option><option value="B">B</option><option value="C">C</option><option value="D">D</option><option value="E">E</option><option value="F">F</option><option value="G">G</option><option value="H">H</option><option value="I">I</option><option value="J">J</option><option value="K">K</option><option value="L">L</option><option value="M">M</option><option value="N">N</option> <option value="O">O</option><option value="P">P</option><option value="Q">Q</option><option value="R">R</option><option value="S">S</option><option value="T">T</option><option value="U">U</option> <option value="V">V</option><option value="W">W</option><option value="X">X</option><option value="Y">Y</option><option value="Z">Z</option>          			
            </select>
            <button class="btn-sm"  id="btn_bus_search_by_alphabet_fbp_deactive" type="button">Search</button>
            </div>
          </div>
          <!-- Search Part End -->
          <div class="view_franchisee_business" style="display:none;"></div>
          <div class="edit_franchisee_business" style="display:none;"></div>
        </div>
      </div>
      <!-- - Trial Businesses With Non Temp Category --> 
      
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function () { //alert(1); 
	$('#zone_business_accordian').click();
	$('#zone_franchisee_business').addClass('active');
	//$('input:radio:first').prop('checked', true);
	$(".view_franchisee_business" ).hide();
	$(".edit_franchisee_business" ).hide();	
	
	$("input[name=checkadfordelete]").attr('checked',false);
	$('.active_fbt').click();
});

$('.container_tab_content').find('ul').find('li').find('a').click(function(){ 
	$( ".view_franchisee_business" ).empty();
	var id=$(this).attr('id');
	if(id=='tabs-title_1'){ 
		$(".edit_franchisee_business" ).hide();
		$("input[name=checkadfordelete]").attr('checked',false);	
		$('#business_zone_fp_trial').val('1');
		$('.active_fbt').click();
	}else if(id=='tabs-title_2'){
		$(".edit_franchisee_business" ).hide();
		$("input[name=checkadfordelete]").attr('checked',false);
		$('#business_zone_fp_paid').val('1');
		$('.active_fbp').click();
	}
});
/////////////////////////////////////////// Trial Franchisee Business Part Start /////////////////////////////////////// 

$(document).on('change','#business_zone_fp_trial',function(){ //alert(1); return false;
	//var business_zone = $(this).val(); //alert(business_zone); return false;
	$('.active_fbt').click();
});
// For search part start
$(document).on('click','#btn_bus_search_by_name_fbt_active',function(){
	$('.active_fbt').click();
});
$(document).on('click','#btn_bus_search_by_alphabet_fbt_active',function(){
	$('.active_fbt').click();
});

$(document).on('click','#btn_bus_search_by_name_fbt_deactive',function(){
	$('.deactive_fbt').click();
});
$(document).on('click','#btn_bus_search_by_alphabet_fbt_deactive',function(){ 
	$('.deactive_fbt').click();
});
// For search part end
// To click on Deactivated Paid Businesses With Temp Category Tab 
$(document).on('click','.deactive_fbt',function(){ //alert('deactive_fbt'); 
	$('.active_fbt').removeClass('active');
	$('.deactive_fbt').addClass('active');
	$(".edit_franchisee_business" ).hide();
	$( ".view_franchisee_business" ).hide();
	$('.bus_search_fbt_active').hide();
	$('.bus_search_fbt_deactive').show();
	$('#text_bus_search_fbt_active').val('');
	$('#select_bus_search_fbt_active').val('-1');
	var zoneid=$('#zoneid').val();
	//var business_zone = $('#business_zone_fp_trial').val();
	var business_zone = ''; 
	var str_arr=$(this).attr('id');
	var str=str_arr.split('###');
	var business_type=str[0];
	var business_type_by_category=str[1];
	var bus_search_by_name=$('#text_bus_search_fbt_deactive').val(); 
	var bus_search_by_alphabet=$('#select_bus_search_fbt_deactive').val();
	if(bus_search_by_name!='' && bus_search_by_alphabet!='-1'){
		alert('Please Select One Search Criteria..');
		return false;
	}
	var data={'zoneid':zoneid,'business_zone':business_zone,'business_type':business_type,'business_type_by_category':business_type_by_category,'bus_search_by_name':bus_search_by_name,'bus_search_by_alphabet':bus_search_by_alphabet};
	PageMethod("<?=base_url('Zonedashboard/view_franchisee_business_by_type')?>", "Displaying Businessess...<br/>This may take a few minutes", data, successdata, null);
});
// To click on Activated Paid Businesses With Temp Category Business Tab 
$(document).on('click','.active_fbt',function(){  //alert('active_fbt');
	$('.deactive_fbt').removeClass('active');
	$('.active_fbt').addClass('active');
	$(".edit_franchisee_business" ).hide();
	$( ".view_franchisee_business" ).hide();
	$('.bus_search_fbt_deactive').hide();
	$('.bus_search_fbt_active').show();
	$('#text_bus_search_fbt_deactive').val('');
	$('#select_bus_search_fbt_deactive').val('-1');
	var zoneid=$('#zoneid').val();
	//var business_zone = $('#business_zone_fp_trial').val(); 
	var business_zone = ''; 
	var str_arr=$(this).attr('id');
	var str=str_arr.split('###');
	var business_type=str[0]; //alert('business_type'+business_type);
	var business_type_by_category=str[1];
	var bus_search_by_name=$('#text_bus_search_fbt_active').val(); 
	var bus_search_by_alphabet=$('#select_bus_search_fbt_active').val();
	if(bus_search_by_name!='' && bus_search_by_alphabet!='-1'){
		alert('Please Select One Search Criteria..');
		return false;
	}
	var data={'zoneid':zoneid,'business_zone':business_zone,'business_type':business_type,'business_type_by_category':business_type_by_category,'bus_search_by_name':bus_search_by_name,'bus_search_by_alphabet':bus_search_by_alphabet};
	PageMethod("<?=base_url('Zonedashboard/view_franchisee_business_by_type')?>", "Displaying Businessess...<br/>This may take a few minutes", data, successdata, null);
});
/////////////////////////////////////////// Trial Franchisee Business Part End /////////////////////////////////////// 

/////////////////////////////////////////// Paid Franchisee Business Part start ///////////////////////////////////////
$(document).on('change','#business_zone_fp_paid',function(){
	//var business_zone = $(this).val(); //alert(business_zone); return false;
	$('.active_fbp').click();
});
// For search part start
$(document).on('click','#btn_bus_search_by_name_fbp_active',function(){
	//var business_zone = $(this).val(); //alert(business_zone); //return false; 
	$('.active_fbp').click();
});
$(document).on('click','#btn_bus_search_by_alphabet_fbp_active',function(){
	//var business_zone = $(this).val(); //alert(business_zone); //return false; 
	$('.active_fbp').click();
});

$(document).on('click','#btn_bus_search_by_name_fbp_deactive',function(){
	//var business_zone = $(this).val(); //alert(business_zone); //return false; 
	$('.deactive_fbp').click();
});
$(document).on('click','#btn_bus_search_by_alphabet_fbp_deactive',function(){
	//var business_zone = $(this).val(); //alert(business_zone); //return false; 
	$('.deactive_fbp').click();
});
// For search part end 
// To click on Deactivated Paid Businesses With Temp Category Tab 
$(document).on('click','.deactive_fbp',function(){ //alert('deactive_fbp'); 
	$('.active_fbp').removeClass('active');
	$('.deactive_fbp').addClass('active');
	$(".edit_franchisee_business" ).hide();
	$( ".view_franchisee_business" ).hide();
	$('.bus_search_fbp_active').hide();
	$('.bus_search_fbp_deactive').show();
	$('#text_bus_search_fbp_active').val('');
	$('#select_bus_search_fbp_active').val('-1');
	$("input[name=checkadfordelete]").attr('checked',false);
	var zoneid=$('#zoneid').val();
	//var business_zone = $('input:radio[name="business_zone_tbntc"]:checked').val();
	//var business_zone = $('#business_zone_fp_paid').val(); //alert('business_zone'+business_zone);
	var business_zone = ''; 
	var str_arr=$(this).attr('id');
	var str=str_arr.split('###');
	var business_type=str[0]; //alert('business_type'+business_type);
	var business_type_by_category=str[1];
	var bus_search_by_name=$('#text_bus_search_fbp_deactive').val(); 
	var bus_search_by_alphabet=$('#select_bus_search_fbp_deactive').val();
	if(bus_search_by_name!='' && bus_search_by_alphabet!='-1'){
		alert('Please Select One Search Criteria..');
		return false;
	}
	var data={'zoneid':zoneid,'business_zone':business_zone,'business_type':business_type,'business_type_by_category':business_type_by_category,'bus_search_by_name':bus_search_by_name,'bus_search_by_alphabet':bus_search_by_alphabet};
	PageMethod("<?=base_url('Zonedashboard/view_franchisee_business_by_type')?>", "Displaying Businessess...<br/>This may take a few minutes", data, successdata, null);
});
// To click on Activated Paid Businesses With Temp Category Business Tab 
$(document).on('click','.active_fbp',function(){  //alert('active_fbp'); 
	$('.deactive_fbp').removeClass('active');
	$('.active_fbp').addClass('active');
	$(".edit_franchisee_business" ).hide();
	$( ".view_franchisee_business" ).hide();
	$('.bus_search_fbp_deactive').hide();
	$('.bus_search_fbp_active').show();
	$('#text_bus_search_fbp_deactive').val('');
	$('#select_bus_search_fbp_deactive').val('-1');
	$("input[name=checkadfordelete]").attr('checked',false);
	var zoneid=$('#zoneid').val();
	//var business_zone=$('#business_zone').val(); 
	//var business_zone = $('input:radio[name="business_zone_tbntc"]:checked').val();
	//var business_zone = $('#business_zone_fp_paid').val(); //alert('business_zone'+business_zone);
	var business_zone = ''; 
	var str_arr=$(this).attr('id');
	var str=str_arr.split('###');
	var business_type=str[0]; //alert('business_type'+business_type);
	var business_type_by_category=str[1];
	var bus_search_by_name=$('#text_bus_search_fbp_active').val(); 
	var bus_search_by_alphabet=$('#select_bus_search_fbp_active').val();
	if(bus_search_by_name!='' && bus_search_by_alphabet!='-1'){
		alert('Please Select One Search Criteria..');
		return false;
	}
	var data={'zoneid':zoneid,'business_zone':business_zone,'business_type':business_type,'business_type_by_category':business_type_by_category,'bus_search_by_name':bus_search_by_name,'bus_search_by_alphabet':bus_search_by_alphabet};
	PageMethod("<?=base_url('Zonedashboard/view_franchisee_business_by_type')?>", "Displaying Businessess...<br/>This may take a few minutes", data, successdata, null);
});
/////////////////////////////////////////// Paid Franchisee Business Part End /////////////////////////////////////// 



function successdata(result){ //alert(JSON.stringify(result));
	$.unblockUI();	
	if(result.Tag!=''){		
		var total_result=result.Title; //alert(total_result);		
		var limit=result.Message;
		limit_final=limit.split(',');
		lowerlimit=limit_final[0];
		if(limit=='10,10' || lowerlimit=='0'){ 
			$(".view_franchisee_business").html('');
			$(".view_franchisee_business").show();
			$(".view_franchisee_business").append(result.Tag);
			
		}else{
			$(".view_franchisee_business").show();
			$(".view_franchisee_business").append(result.Tag);
		}		
		if(total_result<10){
			$('.display_more_business').hide();			
		}else{
			$('.display_more_business').show();
		}
		$('.view_franchisee_business').find('thead.headerclass:not(:first)').hide();
		$('.view_franchisee_business').find('tr.headerclass_sub:not(:first)').hide();
		$('.view_franchisee_business').find('div.display_more_business:not(:last)').hide();
		$('.more_franchisee_business').attr('rel',limit);
		//$('.view_franchisee_business').find('div.container_tab_header').hide();	
		var default_message= $('.view_franchisee_business').find('table.pretty').length; 
		if(default_message==0){
			$('.view_franchisee_business').find('div.container_tab_header').show();
		}
	}
}
$(document).on('click','.more_franchisee_business',function(){ //alert(5);
	var limit=$(this).attr('rel'); //alert(limit);
	limit_final=limit.split(',');
	var lowerlimit=limit_final[0];
	var upperlimit=limit_final[0];
	var zoneid=$(this).attr('data-zoneid'); //alert(zoneid);
	var businesstype=$(this).attr('data-businesstype'); //alert(businesstype);
	var businesstypebycategory=$(this).attr('data-businesstypebycategory'); //alert(businesstypebycategory);
	var businesszone=$(this).attr('data-businesszone'); //alert(businesszone);
	var charvalname=$(this).attr('data-charvalname'); //alert(charvalname);
	var charvalalphabet=$(this).attr('data-charvalalphabet'); //alert(charvalalphabet);
	var data={'zoneid':zoneid,'business_zone':businesszone,'business_type':businesstype,'business_type_by_category':businesstypebycategory,'bus_search_by_name':charvalname,'bus_search_by_alphabet':charvalalphabet,lowerlimit:lowerlimit,upperlimit:upperlimit};
	/*$('thead#showhead').removeClass('_'+lowerlimit);
	$('thead#showhead').addClass('_'+lowerlimit);*/
	PageMethod("<?=base_url('Zonedashboard/view_franchisee_business_by_type')?>", "Displaying Businessess...<br/>This may take a few minutes", data, successdata, null);
});
////////////////////////////////////////////// Change Business Part Start ///////////////////////////////////////////////
// + To Show/Hide in Update menu
$(document).on('change','#action_performed',function(){ 
	var tag=$(this).val();//alert(tag);
	if(tag==6){ 
		$('select#change_business_status').show();
		$('select#action_performed_in_where').hide();
	}else if(tag==3){ 
		$('select#change_business_status').hide();
		$('select#action_performed_in_where').show();
	}
});
$(document).on('change','select#business_delete_all_or_specific',function(){
	var tag=$(this).val(); 
	if(tag==2){   
		$("input[name=checkadfordelete]").attr('disabled','disabled');
		$("input[name=select_all_business_franchisee]").attr('disabled','disabled');
	}else{ 
		$("input[name=checkadfordelete]").attr('disabled',false);
		$("input[name=select_all_business_franchisee]").attr('disabled',false);
	}
});
// - To Show/Hide in Update menu
// + To Select All from header
$(document).on('click','#select_all_business_franchisee',function(){ //alert(1);
	 $('.display_checkbox1').attr('checked', this.checked);
	    /* var str=$(this);
	     var datatype=$(this).attr('data-businesstypebycategory'); //alert(datatype);
		 alert($(this).attr('data-businesstypebycategory').length);
		 $('input[type="checkbox"]').each(function(){ 
			if($(this).attr('data-businesstypebycategory') == datatype ){ 
				$(this).attr('checked', str.checked);
			}
		});*/
		 
		 /*if($(this).attr('data-businesstypebycategory'))
          $('.display_checkbox1').attr('checked', this.checked);
  		  
		 alert($('.display_checkbox1 tbntc:checked').length);	 */
		
	
	/*var datatype=$(this).attr('data-businesstypebycategory'); alert(datatype); abc de
	

	checkboxes = document.getElementsByTagName("input"); //alert(checkboxes.html());//get main check box
	//alert(checkboxes);
	var ele=this; alert(ele.checked);
	if(ele.checked==true)//check main check box is checked or non checked
	{
		state = true;//set status
	}else{
		state = false;//set status
	}
	for (i=0; i<checkboxes.length ; i++)//chck all other checkbox and set their status
	{
	  if (checkboxes[i].type == "checkbox") 
	  {
		checkboxes[i].checked=state;
	  }
	}*/
}); // - To Select All from header
// + To click on individual checkbox, uncheck the 'Select All' checkbox
$(document).on('click','#individual_checkbox_business',function(){
	var total_checkbox=$("input[name=checkadfordelete]").length ;
	var total_checked_checkbox=$("input[name=checkadfordelete]:checked").length; 
	//alert(total_checkbox); alert(total_checked_checkbox); //return false; 	
	if(total_checkbox!=total_checked_checkbox){ //alert(1);
		 $('#select_all_business_franchisee').attr('checked', false);		
	}else if(total_checkbox==total_checked_checkbox){ //alert(2);
		 $('#select_all_business_franchisee').attr('checked', true);		
	}
}); // - To click on individual checkbox, uncheck the 'Select All' checkbox
///////////////////////////////////////////////////////////////////////////////////////////////////////
function uniqueArr(arr) {
arr1 = new Array();
for (i = 0; i < arr.length; i++) {
if (!checkstatus(arr1, arr[i])) {
arr1.length += 1;
arr1[arr1.length - 1] = arr[i];
}
}
return arr1;
}
function checkstatus(arr, e) {
for (j = 0; j < arr.length; j++) if (arr[j] == e) return true;
return false;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
$('#update_franchisee_business').live('click',function(){
	var action_performed = $(this).parents('#action_performed_div').find('#action_performed').val();
	var change_business_status=$(this).parents('#action_performed_div').find('#change_business_status').val();
	var action_performed_in_where=$(this).parents('#action_performed_div').find('#action_performed_in_where').val(); 
	var business_delete_all_or_specific=$(this).parents('#action_performed_div').find('#business_delete_all_or_specific').val();
	var display_checkbox='';
	$("input[name=checkadfordelete]:Checked").each(function(i,item){ //console.log(item);
		display_checkbox+=$(item).val()+',';
	});	
	display_checkbox=display_checkbox.substring(0,display_checkbox.length-1); //alert(display_checkbox);
	var a= display_checkbox.split(',');
	var b=uniqueArr(a);
	var display_checkbox=b.join(','); //alert(display_checkbox); return false;
	
	if(display_checkbox=='' && business_delete_all_or_specific==1){
		alert('Please Select At Least One Business.');
		return false;
	}
	var business_type=$(this).attr('data-businesstype'); //alert(business_type);
	var business_type_by_category=$(this).attr('data-businesstypebycategory');
	var business_zone=$(this).attr('data-businesszone');	
	//alert(action_performed); alert(change_business_status); alert(action_performed_in_where); alert(business_delete_all_or_specific);alert(display_checkbox); 
	data={businessid:display_checkbox,zoneid:$('#zoneid').val(),action_performed:action_performed,change_business_status:change_business_status,action_performed_in_where:action_performed_in_where,business_delete_all_or_specific:business_delete_all_or_specific,business_type:business_type,business_type_by_category:business_type_by_category,business_zone:business_zone}
	
	if(action_performed==3 && action_performed_in_where==0 && business_delete_all_or_specific==1){
		ConfirmDialog('If you delete businesses data records from your database it will simultaneously delete the ads for each deleted business. <br/></br>When you upload the businesses again, each business will be placed into the "Businesses Uploaded" category and each business will receive: <br/>1. The User ID will again be the businesses 10 digit phone number <br/>2. A new Password <br/>3. A new unique URL ID for Direct Browser Access and <br/>4. Temporary AD content will be auto inserted into each businesses Ad Space.', "Warning", "<?=base_url('Zonedashboard/action_performed_franchisee_business')?>","", data, businesssuccess, null);
	}else if(action_performed==3 && action_performed_in_where==1 && business_delete_all_or_specific==1){
		ConfirmDialog('If you delete businesses data records from your database it will simultaneously delete the ads for each deleted business. <br/></br>When you upload the businesses again, each business will be placed into the "Businesses Uploaded" category and each business will receive: <br/>1. The User ID will again be the businesses 10 digit phone number <br/>2. A new Password <br/>3. A new unique URL ID for Direct Browser Access and <br/>4. Temporary AD content will be auto inserted into each businesses Ad Space.', "Warning", "<?=base_url('Zonedashboard/action_performed_franchisee_business')?>","Deleting...<br/>This may take a minute", data, businesssuccess, null);
	}else if(action_performed==3 && action_performed_in_where==0 && business_delete_all_or_specific==2){
		ConfirmDialog('If you delete businesses data records from your database it will simultaneously delete the ads for each deleted business. <br/></br>When you upload the businesses again, each business will be placed into the "Businesses Uploaded" category and each business will receive: <br/>1. The User ID will again be the businesses 10 digit phone number <br/>2. A new Password <br/>3. A new unique URL ID for Direct Browser Access and <br/>4. Temporary AD content will be auto inserted into each businesses Ad Space.', "Warning", "<?=base_url('Zonedashboard/action_performed_franchisee_business')?>","Deleting...<br/>This may take a minute", data, businesssuccess, null);
	}else if(action_performed==3 && action_performed_in_where==1 && business_delete_all_or_specific==2){
		ConfirmDialog('If you delete businesses data records from your database it will simultaneously delete the ads for each deleted business. <br/></br>When you upload the businesses again, each business will be placed into the "Businesses Uploaded" category and each business will receive: <br/>1. The User ID will again be the businesses 10 digit phone number <br/>2. A new Password <br/>3. A new unique URL ID for Direct Browser Access and <br/>4. Temporary AD content will be auto inserted into each businesses Ad Space.', "Warning", "<?=base_url('Zonedashboard/action_performed_franchisee_business')?>","Deleting...<br/>This may take a minute", data, businesssuccess, null);
	}else{
		PageMethod("<?=base_url('Zonedashboard/action_performed_franchisee_business')?>", "Action Performed...<br/>This may take a few minutes", data, businesssuccess, null);
	}		
});
function businesssuccess(result){  //alert(JSON.stringify(result)); //alert(result);//alert(msg);return false;
	$.unblockUI();
	var business_delete_all_or_specific=result.Title;
	/*var business_delete_all_or_specific=result.Tag;*/
		if(result.Title!=''){ //alert(businessid);
			if(business_delete_all_or_specific==1){
				$("input[name=checkadfordelete]:Checked").each(function(i,item){ 
					//$('tr#'+$(this).val()).hide();
					//$('tr#'+$(this).val()).hide();
					$('.pretty').find('tr#'+$(this).val()).hide();
					$("input[name=checkadfordelete]:Checked").attr('checked',false);
					$("input[name=select_all_business_franchisee]:Checked").attr('checked',false); 
				});
			}else if(business_delete_all_or_specific==2){
				$('.uploadbusiness').hide();
				//showListedBusiness(result.Message,'all');	
			}
		}
}
////////////////////////////////////////////// Change Business Part End ///////////////////////////////////////////////
/////////////////////////////////////////////// Edit Business Part start ////////////////////////////////////////////////
$(document).on('click','.edit_business',function(){
	var id=$(this).attr('rel');
	//var id=$('.view_franchisee_business').find('tr.uploadbusiness').attr('rel');
	//$('.view_franchisee_business').hide();
	//$('.edit_franchisee_business').show();
	var businesstype=$(this).attr('data-businesstype'); //alert(businesstype);
	var businesstypebycategory=$(this).attr('data-businesstypebycategory'); //alert(businesstypebycategory);
	var businesszone=$(this).attr('data-businesszone');
	var data={businessid:id,zoneid:$('#zoneid').val(),businesstype:businesstype,businesstypebycategory:businesstypebycategory,businesszone:businesszone}
	PageMethod("<?=base_url('Zonedashboard/edit_franchisee_business')?>", "Action Performed...<br/>This may take a few minutes", data, EditNonTempBusinessSuccess, null);
});
function EditNonTempBusinessSuccess(result){
	$.unblockUI();
	if(result.Tag!=''){
		$('.view_franchisee_business').hide();
		$(".edit_franchisee_business").show();
		$(".edit_franchisee_business").html(result.Tag);
		var data={businessid:$('#biz_id').val(),zoneid:$('#biz_zone_id').val()}
		PageMethod("<?=base_url('Zonedashboard/view_edit_franchisee_business')?>", "Action Performed...<br/>This may take a few minutes", data, ViewEditFranchiseeBusinessSuccess, null); 
	}
}
function ViewEditFranchiseeBusinessSuccess(result){ //alert(JSON.stringify(result));
	$.unblockUI();
	if(result.Tag!=''){
		var str=result.Tag;
		$('.edit_franchisee_business').find('#biz_address_id').val(str.addressid);
		$('.edit_franchisee_business').find('#biz_user_id').val(str.userid);
		$('.edit_franchisee_business').find('#biz_addsetting_id').val(str.adsettingid);
		$('.edit_franchisee_business').find('#biz_user_id').val(str.userid);
		$('.edit_franchisee_business').find('#biz_name').val(str.name);
		$('.edit_franchisee_business').find('#biz_motto').val(str.motto);
		$('.edit_franchisee_business').find('#biz_email').val(str.contactemail); 		
		$('.edit_franchisee_business').find('#biz_first_name').val(str.contactfirstname);
		$('.edit_franchisee_business').find('#biz_last_name').val(str.contactlastname);
		$('.edit_franchisee_business').find('#biz_address_1').val(str.street_address_1); 
		$('.edit_franchisee_business').find('#biz_address_2').val(str.street_address_2);
		$('.edit_franchisee_business').find('#biz_city').val(str.city);
		$('.edit_franchisee_business').find('#biz_state').find('option[value='+str.state+']').attr('selected','selected');
		$('.edit_franchisee_business').find('#biz_phone').val(str.phone); 
		$('.edit_franchisee_business').find('#biz_website').val(str.website); 
		$('.edit_franchisee_business').find('#biz_sic').val(str.siccode);
		$('.edit_franchisee_business').find('#biz_username').val(str.username);
	}
}

$(document).on('click','#edit_update_franchisee_business',function(){
	var tag=$(this).parent().parent().siblings();
	var businesstype=$(this).attr('data-businesstype'); //alert(businesstype); 
	var businesstypebycategory=$(this).attr('data-businesstypebycategory'); //alert(businesstypebycategory);
	var businesszone=$(this).attr('data-businesszone'); //alert(businesszone);return false;
	
	var data={businessid:$('#biz_id').val(),zoneid:$('#biz_zone_id').val(),biz_addsetting_id:$('#biz_addsetting_id').val(),biz_address_id:$('#biz_address_id').val(),biz_user_id:$('#biz_user_id').val(),businesstype:businesstype,businesstypebycategory:businesstypebycategory,businesszone:businesszone,biz_name:tag.find('#biz_name').val(),biz_motto:tag.find('#biz_motto').val(),biz_email:tag.find('#biz_email').val(),biz_first_name:tag.find('#biz_first_name').val(),biz_last_name:tag.find('#biz_last_name').val(),biz_address_1:tag.find('#biz_address_1').val(),biz_address_2:tag.find('#biz_address_2').val(),biz_city:tag.find('#biz_city').val(),biz_state:tag.find('#biz_state').val(),biz_phone:tag.find('#biz_phone').val(),biz_website:tag.find('#biz_website').val(),biz_sic:tag.find('#biz_sic').val(),biz_username:tag.find('#biz_username').val()}
	PageMethod("<?=base_url('Zonedashboard/update_edit_franchisee_business')?>", "Action Performed...<br/>This may take a few minutes", data, UpdateEditFranchiseeBusinessSuccess, null); 
	
});
function UpdateEditFranchiseeBusinessSuccess(result){//alert(JSON.stringify(result));
	$.unblockUI();
	if(result.Tag!=''){
		$(".success").show();
	}
}
$(document).on('click','#back_to_business',function(){ 	
	var businesstype=$(this).attr('data-businesstype'); //alert(businesstype);
	var businesstypebycategory=$(this).attr('data-businesstypebycategory'); //alert(businesstypebycategory);
	var businesszone=$(this).attr('data-businesszone');
	$(".edit_franchisee_business").hide();
	$('.view_franchisee_business').show();
	if(businesstype==1 && businesstypebycategory=='fbp'){
		$('.active_fbp').click();
	}else if(businesstype==-1 && businesstypebycategory=='fbp'){
		$('.deactive_fbp').click();
	}else if(businesstype==2 && businesstypebycategory=='fbt'){
		$('.active_fbt').click();
	}else if(businesstype==-2 && businesstypebycategory=='fbt'){
		$('.deactive_fbt').click();
	}
});
/////////////////////////////////////////////// Edit Business Part end ////////////////////////////////////////////////
</script>