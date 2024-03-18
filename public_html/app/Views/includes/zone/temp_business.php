<input type="hidden" id="zoneid" name="zoneid" value="<?php echo $zoneid;?>"/>
<div class="main_content_outer">
  <div class="content_container">
    <div class="container_tab_header"><strong>Businesses Uploaded</strong></div>
    <div id="container_tab_content" class="container_tab_content">
      <ul>
        <li><a href="#tabs-1" id="tabs-title_1" onclick="">CSV Uploaded Businesses</a></li>
        <li><a href="#tabs-2" id="tabs-title_2" onclick="">Manually Created Businesses</a></li>
        <li><a href="#tabs-3" id="tabs-title_3">Trial Businesses</a></li>
        <li><a href="#tabs-4" id="tabs-title_4">Paid Businesses</a></li>
        <!--<li><a href="#tabs-5" id="tabs-title_5">Duplicate Uploaded Biz.</a></li>-->
      </ul>
      <!-- CSV Uploaded Businesses With Temp Category Start -->
      <div id="tabs-1">
        <div class="form-group">
          <div class="container_tab_header header-default-message"  style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:0px;">
            <div class="btn-group-2" align="left"> 
              <!-- <ul>
              <li><a class="active_ub active" rel="3">Active Uploaded Businesses</a></li>
              <li><a class="deactive_ub" rel="-3">Deactive Uploaded Businesses</a></li>
            </ul>-->
              <button class="active_ub active btn-sm" id="3###ub">Search for Active Businesses</button>
              <button class="deactive_ub btn-sm" id="-3###ub">Search for Inactive Businesses</button>
              <a href="javascript:void(0);" onclick="$('#csv_search_biz').slideToggle('slow')"><img src="<?=base_url()?>assets/images/find.png" style="margin:7px 0 0 240px" width:"20px" height="20px" alt="Search Businesses" title="Search Businesses"/></a> 
              
              <a class="fright new-help-button" href="javascript:void(0);" onclick="$('#helpdiv').slideToggle('slow')">HELP<!--<img alt="Help Tips" title="Help Tips" src="<?=base_url()?>assets/images/help.png" style="margin:3px 0 0 10px" width:"28px" height="28px"/>--></a> </div>
          </div>
          
          <div id="helpdiv" class="container_tab_header header-default-message" style="display:none;">
            <p>This shows the "CSV Uploaded Businesses". It has the following:</p>
            <p>To view the active businesses" click on the "Active Biz." option.</p>
            <p>To view the deactive businesses" click on the "Deactive Biz." option.</p>
            <p>Search your business directly by entering the name inside "Direct search by business name" text box and click on the "Search" option. Or search businesses alphabetically by selecting the desired alphabet and then click on the "Search" option.</p>
          </div>
          <!-- Search Part Start -->
          <div class="container_tab_header" id="csv_search_biz" style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:0px; display:none;">
            <div class="bus_search_ub_active">
              <input type="text" id="text_bus_search_ub_active" name="text_bus_search_ub_active" placeholder="Direct search by business name" style="width:240px;" />
              <button class="btn-sm"  id="btn_bus_search_by_name_ub_active" type="button">Search</button>
              <strong>Search Your Businesses </strong></strong>
              <select name="select_bus_search_ub_active" id="select_bus_search_ub_active">
                <option value="-1">By Alphabetical Order</option>
                <option value="all">ALL</option>
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
              </select>
              <button class="btn-sm"  id="btn_bus_search_by_alphabet_ub_active" type="button">Search</button>
            </div>
            <div class="bus_search_ub_deactive" style="display:none;">
              <input type="text" id="text_bus_search_ub_deactive" name="text_bus_search_ub_deactive" placeholder="Direct search by business name" style="width:240px;" />
              <button class="btn-sm"  id="btn_bus_search_by_name_ub_deactive" type="button">Search</button>
              <strong>Search Your Businesses </strong></strong>
              <select name="select_bus_search_ub_deactive" id="select_bus_search_ub_deactive">
                <option value="-1">By Alphabetical Order</option>
                <option value="all">ALL</option>
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
              </select>
              <button class="btn-sm"  id="btn_bus_search_by_alphabet_ub_deactive" type="button">Search</button>
            </div>
          </div>
          <!-- Search Part End -->
          
          <div class="view_uploaded_business" style="display:none;"></div>
          <div class="edit_uploaded_business" style="display:none;"></div>
          <!-- <div class="more_business" style="float:right;"><a class="business_limit" href="javascript:void(0)" style=" color:#000;" onclick="bus_pagination(this);">Display more Business</a> </div>--> 
        </div>
      </div>
      <!-- CSV Uploaded Businesses With Temp Category end --> 
      <!-- Manually Created Businesses With Temp Category Start -->
      <div id="tabs-2" class="form-group center-block-table">
        <div class="form-group">
          <div class="container_tab_header" style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:0px;">
            <div class="btn-group-2">
              <button class="active_ub_m active btn-sm" id="3###ub_m">Search for Active Businesses</button>
              <button class="btn-sm deactive_ub_m" id="-3###ub_m">Search for Inactive Businesses</button>
              <a href="javascript:void(0);" onclick="$('#man_search_biz').slideToggle('slow')"><img src="<?=base_url()?>assets/images/find.png" style="margin:7px 0 0 240px" width:"20px" height="20px" alt="Search Businesses" title="Search Businesses"/></a> 
              
              <a class="fright new-help-button" href="javascript:void(0);" onclick="$('#helpdiv1').slideToggle('slow')">HELP<!--<img alt="Help Tips" title="Help Tips" src="<?=base_url()?>assets/images/help.png" style="margin:3px 0 0 10px" width:"28px" height="28px"/>--></a> </div>
          </div>
          
          <div id="helpdiv1" class="container_tab_header header-default-message" style="display:none;">
            <p>This shows the "Registered Businesses". It has the following:</p>
            <p>To view the active businesses click on "Active Biz." option.</p>
            <p>To view the deactive businesses" click on the "Deactive Biz." option.</p>
            <p>Search your business directly by entering the name inside "Direct search by business name" text box and click on the "Search" option. Or search businesses alphabetically by selecting the desired alphabet and then click on the "Search" option.</p>
          </div>
          <!-- Search Part Start -->
          <div class="container_tab_header" id="man_search_biz" style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:0px; display:none;">
            <div class="bus_search_ub_m_active">
              <input type="text" id="text_bus_search_ub_m_active" name="text_bus_search_ub_m_active" placeholder="Direct search by business name" style="width:240px;" />
              <button class="btn-sm"  id="btn_bus_search_by_name_ub_m_active" type="button">Search</button>
              <strong>Search Your Businesses </strong></strong>
              <select name="select_bus_search_ub_m_active" id="select_bus_search_ub_m_active">
                <option value="-1">By Alphabetical Order</option>
                <option value="all">ALL</option>
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
              </select>
              <button class="btn-sm"  id="btn_bus_search_by_alphabet_ub_m_active" type="button">Search</button>
            </div>
            <div class="bus_search_ub_m_deactive" style="display:none;">
              <input type="text" id="text_bus_search_ub_m_deactive" name="text_bus_search_ub_m_deactive" placeholder="Direct search by business name" style="width:240px;" />
              <button class="btn-sm"  id="btn_bus_search_by_name_ub_m_deactive" type="button">Search</button>
              <strong>Search Your Businesses </strong></strong>
              <select name="select_bus_search_ub_m_deactive" id="select_bus_search_ub_m_deactive">
                <option value="-1">By Alphabetical Order</option>
                <option value="all">ALL</option>
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
              </select>
              <button class="btn-sm"  id="btn_bus_search_by_alphabet_ub_m_deactive" type="button">Search</button>
            </div>
          </div>
          <!-- Search Part End -->
          <div class="view_uploaded_business" style="display:none;"></div>
          <div class="edit_uploaded_business" style="display:none;"></div>
          <!--<div class="more_business_m" style="float:right;"><a class="business_limit" href="javascript:void(0)" style=" color:#000;" onclick="bus_pagination_m(this);">Display more Business</a> </div>--> 
        </div>
      </div>
      <!-- Manually Created Businesses With Temp Category End --> 
      
      <!-- Trial Uploaded Businesses With Temp Category Start -->
      <div id="tabs-3" class="form-group center-block-table">
        <div class="form-group">
          <div class="container_tab_header header-default-message"  style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:0px;">
            <div class="btn-group-2" align="left">
              <button class="btn-sm active_tbtc active" id="2###tbtc">Search for Active Businesses</button>
              <button class="btn-sm deactive_tbtc" id="-2###tbtc">Search for Inactive Businesses</button>
              <a href="javascript:void(0);" onclick="$('#temp_trial_div').slideToggle('slow')"><img src="<?=base_url()?>assets/images/find.png" style="margin:7px 0 0 240px" width:"20px" height="20px" alt="Search Businesses" title="Search Businesses"/></a> 
              
              <a class="fright new-help-button" href="javascript:void(0);" onclick="$('#temp_trial_helpdiv').slideToggle('slow')">HELP<!--<img alt="Help Tips" title="Help Tips" src="<?=base_url()?>assets/images/help.png" style="margin:3px 0 0 10px" width:"28px" height="28px"/>--></a> </div>
          </div>
          <div id="temp_trial_helpdiv" class="container_tab_header header-default-message" style="display:none;">
            <p>This shows the "Trial Businesses with Temp Category". It has the following:</p>
            <p>To view the active trial businesses located in your zone or outside your zone select the desired option from "Filter" dropdown and then click on "Active Biz." option.</p>
            <p>To view the deactive trial businesses located in your zone or outside your zone select the desired option from "Filter" dropdown and then click on "Deactive Biz." option.</p>
            <p>Search your business directly by entering the name inside "Direct search by business name" text box and click on the "Search" option. Or search businesses alphabetically by selecting the desired alphabet and then click on the "Search" option.</p>
          </div>
          <!-- Search Part Start -->
          <div class="container_tab_header" id="temp_trial_div" style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:0px; display:none;">
            <div class="bus_search_tbtc_active">
              <input type="text" id="text_bus_search_tbtc_active" name="text_bus_search_tbtc_active" placeholder="Direct search by business name" style="width:240px;" />
              <button class="btn-sm"  id="btn_bus_search_by_name_tbtc_active" type="button">Search</button>
              <strong>Search Your Businesses </strong></strong>
              <select name="select_bus_search_tbtc_active" id="select_bus_search_tbtc_active">
                <option value="-1">By Alphabetical Order</option>
                <option value="all">ALL</option>
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
              </select>
              <button class="btn-sm"  id="btn_bus_search_by_alphabet_tbtc_active" type="button">Search</button>
            </div>
            <div class="bus_search_tbtc_deactive" style="display:none;">
              <input type="text" id="text_bus_search_tbtc_deactive" name="text_bus_search_tbtc_deactive" placeholder="Direct search by business name" style="width:240px;" />
              <button class="btn-sm"  id="btn_bus_search_by_name_tbtc_deactive" type="button">Search</button>
              <strong>Search Your Businesses </strong></strong>
              <select name="select_bus_search_tbtc_deactive" id="select_bus_search_tbtc_deactive">
                <option value="-1">By Alphabetical Order</option>
                <option value="all">ALL</option>
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
              </select>
              <button class="btn-sm"  id="btn_bus_search_by_alphabet_tbtc_deactive" type="button">Search</button>
            </div>
          </div>
          <!-- Search Part End -->
          
          <div class="view_uploaded_business" style="display:none;"></div>
          <div class="edit_uploaded_business" style="display:none;"></div>
          <!-- <div class="more_business" style="float:right;"><a class="business_limit" href="javascript:void(0)" style=" color:#000;" onclick="bus_pagination(this);">Display more Business</a> </div>--> 
        </div>
      </div>
      <!-- Trial Uploaded Businesses With Temp Category End --> 
      <!-- Paid Uploaded Businesses With Temp Category Start -->
      <div id="tabs-4" class="form-group center-block-table">
        <div class="form-group">
          <div class="container_tab_header header-default-message"  style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:0px;">
            <div class="btn-group-2" align="left">
              <button class="btn-sm active_pbtc active" id="1###pbtc">Search for Active Businesses</button>
              <button class="btn-sm deactive_pbtc" id="-1###pbtc">Search for Inactive Businesses</button>
              <a href="javascript:void(0);" onclick="$('#temp_paid_div').slideToggle('slow')"><img src="<?=base_url()?>assets/images/find.png" style="margin:7px 0 0 240px" width:"20px" height="20px" alt="Search Businesses" title="Search Businesses"/></a> 
              
              <a class="fright new-help-button" href="javascript:void(0);" onclick="$('#temp_paid_helpdiv').slideToggle('slow')">HELP<!--<img alt="Help Tips" title="Help Tips" src="<?=base_url()?>assets/images/help.png" style="margin:3px 0 0 10px" width:"28px" height="28px"/>--></a> </div>
          </div>
          
          <div id="temp_paid_helpdiv" class="container_tab_header header-default-message" style="display:none;">
            <p>This shows the "Paid Businesses with Temp Category". It has the following:</p>
            <p>To view the active paid businesses located in your zone or outside your zone select the desired option from "Filter" dropdown and then click on "Active Biz." option.</p>
            <p>To view the deactive paid businesses located in your zone or outside your zone select the desired option from "Filter" dropdown and then click on "Deactive Biz." option.</p>
            <p>Search your business directly by entering the name inside "Direct search by business name" text box and click on the "Search" option. Or search businesses alphabetically by selecting the desired alphabet and then click on the "Search" option.</p>
          </div>
          <div class="container_tab_header" id="temp_paid_div" style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:0px;display:none;">
            <div class="bus_search_pbtc_active" >
              <input type="text" id="text_bus_search_pbtc_active" name="text_bus_search_pbtc_active" placeholder="Direct search by business name" style="width:240px;" />
              <button class="btn-sm"  id="btn_bus_search_by_name_pbtc_active" type="button">Search</button>
              <strong>Search Your Businesses </strong></strong>
              <select name="select_bus_search_pbtc_active" id="select_bus_search_pbtc_active">
                <option value="-1">By Alphabetical Order</option>
                <option value="all">ALL</option>
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
              </select>
              <button class="btn-sm"  id="btn_bus_search_by_alphabet_pbtc_active" type="button">Search</button>
            </div>
            <div class="bus_search_pbtc_deactive" style="display:none;">
              <input type="text" id="text_bus_search_pbtc_deactive" name="text_bus_search_pbtc_deactive" placeholder="Direct search by business name" style="width:240px;" />
              <button class="btn-sm"  id="btn_bus_search_by_name_pbtc_deactive" type="button">Search</button>
              <strong>Search Your Businesses </strong></strong>
              <select name="select_bus_search_pbtc_deactive" id="select_bus_search_pbtc_deactive">
                <option value="-1">By Alphabetical Order</option>
                <option value="all">ALL</option>
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
              </select>
              <button class="btn-sm"  id="btn_bus_search_by_alphabet_pbtc_deactive" type="button">Search</button>
            </div>
          </div>
          <div class="view_uploaded_business" style="display:none;"></div>
          <div class="edit_uploaded_business" style="display:none;"></div>
        </div>
      </div>
      <!-- Paid Uploaded Businesses With Temp Category End --> 
      <!-- Duplicate Uploaded Businesses With Temp Category Start -->
      <!--<div id="tabs-5" class="form-group center-block-table">
        <div class="form-group">
          <div class="container_tab_header" style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;">Yet to be implemented.</div>
        </div>
      </div>-->
      <!-- Duplicate Uploaded Businesses With Temp Category Start --> 
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function () { 
	$('#zone_business_accordian').click();
	$('#zone_temp_business').addClass('active');	
	$('.view_uploaded_business').hide();
	$('.edit_uploaded_business').hide();
	$('.active_ub').click(); // Clicked Activated Uploaded Business Tab
});


$('.container_tab_content').find('ul').find('li').find('a').click(function(){ 
	$( ".view_uploaded_business" ).empty();
	$(".edit_uploaded_business" ).hide();	
	var id=$(this).attr('id'); //alert(id);
	if(id=='tabs-title_1'){			
		$('.active_ub').click();
	}else if(id=='tabs-title_2'){
		$('.active_ub_m').click();
	}else if(id=='tabs-title_3'){
		$('.active_tbtc').click();
	}else if(id=='tabs-title_4'){
		$('.active_pbtc').click();
	}
});
///////////////////////////////// CSV Uploaded Businesses With Temp Category Start //////////////////////////////////////////////// 
// For search part start
$(document).on('click','#btn_bus_search_by_name_ub_active',function(){
	$('.active_ub').click();
});
$(document).on('click','#btn_bus_search_by_alphabet_ub_active',function(){
	$('.active_ub').click();
});
$(document).on('click','#btn_bus_search_by_name_ub_deactive',function(){
	$('.deactive_ub').click();
});
$(document).on('click','#btn_bus_search_by_alphabet_ub_deactive',function(){
	$('.deactive_ub').click();
});
// For search part end
// To click on Deactivated Uploaded Business Tab 
$(document).on('click','.deactive_ub',function(){  //alert('deactive_ub_m'); 
	$('.active_ub').removeClass('active');
	$('.deactive_ub').addClass('active');
	$(".edit_uploaded_business" ).hide();
	$(".view_uploaded_business").hide();
	$('.bus_search_ub_active').hide();
	$('.bus_search_ub_deactive').show();
	$('#text_bus_search_ub_active').val('');
	$('#select_bus_search_ub_active').val('-1');
	var zoneid=$('#zoneid').val();
	//var approval=$(this).attr('id'); //alert(approval);
	var business_zone = 0;
	var str_arr=$(this).attr('id');
	var str=str_arr.split('###');
	var business_type=str[0]; //alert('business_type'+business_type);
	var business_type_by_category=str[1];
	var bus_search_by_name=$('#text_bus_search_ub_deactive').val();  
	var bus_search_by_alphabet=$('#select_bus_search_ub_deactive').val(); 
	$(".edit_uploaded_business").hide();
	// pagination
	var lowerlimit=''; var upperlimit='';
	var limit=$('#limit1').val();
	if(limit=='' || limit==undefined){
		lowerlimit=0; upperlimit=10;
	}else{
		limit_final=limit.split(',');
		lowerlimit=limit_final[0]; upperlimit=limit_final[1];			
	}	
	// pagination	
	if(bus_search_by_name!='' && bus_search_by_alphabet!='-1'){
		alert('Please Select One Search Criteria..');
		return false;
	}
	var data={'zoneid':zoneid,'business_type':business_type,'business_type_by_category':business_type_by_category,'business_zone':business_zone,'bus_search_by_name':bus_search_by_name,'bus_search_by_alphabet':bus_search_by_alphabet,
			'lowerlimit':lowerlimit,
			'upperlimit':upperlimit
			};
	PageMethod("<?=base_url('Zonedashboard/view_uploaded_business_by_type')?>", "Displaying Businessess...<br/>This may take a few minutes", data, successdata, null);
});
// To click on Activated Uploaded Business Tab 
$(document).on('click','.active_ub',function(){  //alert('active_ub');  
	$('.deactive_ub').removeClass('active');
	$('.active_ub').addClass('active');
	$(".edit_uploaded_business" ).hide();
	$(".view_uploaded_business").hide();	
	$('.bus_search_ub_deactive').hide();
	$('.bus_search_ub_active').show();
	$('#text_bus_search_ub_deactive').val('');
	$('#select_bus_search_ub_deactive').val('-1');
	var zoneid=$('#zoneid').val(); 
	$(".edit_uploaded_business").hide(); 
	var business_zone = 0;
	var str_arr=$(this).attr('id');
	var str=str_arr.split('###');
	var business_type=str[0]; //alert('business_type'+business_type);
	var business_type_by_category=str[1]; //alert('business_type=>'+business_type); alert('business_type_by_category=>'+business_type_by_category); return false;
	 
	var bus_search_by_name=$('#text_bus_search_ub_active').val(); 
	var bus_search_by_alphabet=$('#select_bus_search_ub_active').val();
	// + pagination
	var lowerlimit=''; var upperlimit='';
	var limit=$('#limit').val();
	if(limit=='' || limit==undefined){
		lowerlimit=0; upperlimit=10;
	}else{
		limit_final=limit.split(',');
		lowerlimit=limit_final[0]; upperlimit=limit_final[1];			
	} 
	// - pagination	
	if(bus_search_by_name!='' && bus_search_by_alphabet!='-1'){
		alert('Please Select One Search Criteria..');
		return false;
	}
	var data={'zoneid':zoneid,'business_type':business_type,'business_type_by_category':business_type_by_category,'business_zone':business_zone,'bus_search_by_name':bus_search_by_name,'bus_search_by_alphabet':bus_search_by_alphabet,
			'lowerlimit':lowerlimit,'upperlimit':upperlimit};
			
	PageMethod("<?=base_url('Zonedashboard/view_uploaded_business_by_type')?>", "Displaying Businessess...<br/>This may take a few minutes", data, successdata, null);
});

// Pagination Section

$(document).on('click','.more_temp_business',function(){ //alert(5);
	var limit=$(this).attr('rel'); //alert(limit);
	limit_final=limit.split(',');
	var lowerlimit=limit_final[0];
	var upperlimit=limit_final[1];	//alert(lowerlimit+'-'+upperlimit);
	var zoneid=$(this).attr('data-zoneid'); //alert(zoneid);
	var businesstype=$(this).attr('data-businesstype'); //alert(businesstype);
	var businesstypebycategory=$(this).attr('data-businesstypebycategory'); //alert(businesstypebycategory);
	var businesszone=$(this).attr('data-businesszone'); //alert(businesszone);
	var charvalname=$(this).attr('data-charvalname'); //alert(charvalname);
	var charvalalphabet=$(this).attr('data-charvalalphabet'); //alert(charvalalphabet);
	var data={'zoneid':zoneid,'business_type':businesstype,'business_type_by_category':businesstypebycategory,'is_default':businesszone,'bus_search_by_name':charvalname,'bus_search_by_alphabet':charvalalphabet,lowerlimit:lowerlimit,upperlimit:upperlimit};
	PageMethod("<?=base_url('Zonedashboard/view_uploaded_business_by_type')?>", "Displaying Businessess...<br/>This may take a few minutes", data, successdata, null);
});


///////////////////////////////// CSV Uploaded Businesses With Temp Category End ////////////////////////////////////////////////

///////////////////////////////// Manually Created Businesses With Temp Category Start ////////////////////////////////////////////
// For search part start
$(document).on('click','#btn_bus_search_by_name_ub_m_active',function(){
	$('.active_ub_m').click();
});
$(document).on('click','#btn_bus_search_by_alphabet_ub_m_active',function(){
	$('.active_ub_m').click();
});
$(document).on('click','#btn_bus_search_by_name_ub_m_deactive',function(){
	$('.deactive_ub_m').click();
});
$(document).on('click','#btn_bus_search_by_alphabet_ub_m_deactive',function(){
	$('.deactive_ub_m').click();
});
// For search part end
// To click on Deactivated Uploaded Business Tab 
$(document).on('click','.deactive_ub_m',function(){  //alert('deactive_ub_m');
	$('.active_ub_m').removeClass('active');
	$('.deactive_ub_m').addClass('active');
	$(".edit_uploaded_business" ).hide();
	$(".view_uploaded_business").hide();
	$('.bus_search_ub_m_active').hide();
	$('.bus_search_ub_m_deactive').show();
	$('#text_bus_search_ub_m_active').val('');
	$('#select_bus_search_ub_m_active').val('-1');
	var zoneid=$('#zoneid').val();
	var business_zone = 1;
	var str_arr=$(this).attr('id');
	var str=str_arr.split('###');
	var business_type=str[0]; //alert('business_type'+business_type);
	var business_type_by_category=str[1];
	$(".edit_uploaded_business").hide();
	// pagination
	var lowerlimit=''; var upperlimit='';
	var limit=$('#limit3').val();
	if(limit=='' || limit==undefined){
		lowerlimit=0; upperlimit=10;
	}else{
		limit_final=limit.split(',');
		lowerlimit=limit_final[0]; upperlimit=limit_final[1];			
	}
	// pagination
	var bus_search_by_name=$('#text_bus_search_ub_m_deactive').val();  
	var bus_search_by_alphabet=$('#select_bus_search_ub_m_deactive').val();
	var data={'zoneid':zoneid,'business_type':business_type,'business_type_by_category':business_type_by_category,'business_zone':business_zone,'bus_search_by_name':bus_search_by_name,'bus_search_by_alphabet':bus_search_by_alphabet,'lowerlimit':lowerlimit,'upperlimit':upperlimit};			
	if(bus_search_by_name!='' && bus_search_by_alphabet!='-1'){
		alert('Please Select One Search Criteria..');
		return false;
	}
	PageMethod("<?=base_url('Zonedashboard/view_uploaded_business_by_type')?>", "Displaying Businessess...<br/>This may take a few minutes", data, successMCBdata, null);
});
// To click on Activated Uploaded Business Tab 
$(document).on('click','.active_ub_m',function(){ //alert('active_ub_m');
	$('.deactive_ub_m').removeClass('active');
	$('.active_ub_m').addClass('active');
	$(".edit_uploaded_business" ).hide();
	$(".view_uploaded_business").hide();
	$('.bus_search_ub_m_deactive').hide();
	$('.bus_search_ub_m_active').show();
	$('#text_bus_search_ub_m_deactive').val('');
	$('#select_bus_search_ub_m_deactive').val('-1');
	var zoneid=$('#zoneid').val(); 
	var business_zone = 1;
	var str_arr=$(this).attr('id');
	var str=str_arr.split('###');
	var business_type=str[0]; //alert('business_type'+business_type);
	var business_type_by_category=str[1];
	$(".edit_uploaded_business").hide();
	// pagination
	var lowerlimit=''; var upperlimit='';
	var limit=$('#limit2').val();
	if(limit=='' || limit==undefined){
		lowerlimit=0; upperlimit=10;
	}else{
		limit_final=limit.split(',');
		lowerlimit=limit_final[0]; upperlimit=limit_final[1];			
	}
	// pagination
	var bus_search_by_name=$('#text_bus_search_ub_m_active').val();  
	var bus_search_by_alphabet=$('#select_bus_search_ub_m_active').val(); 
	var data={'zoneid':zoneid,'business_type':business_type,'business_type_by_category':business_type_by_category,'business_zone':business_zone,'bus_search_by_name':bus_search_by_name,'bus_search_by_alphabet':bus_search_by_alphabet,'lowerlimit':lowerlimit,'upperlimit':upperlimit};
			
	if(bus_search_by_name!='' && bus_search_by_alphabet!='-1'){
		alert('Please Select One Search Criteria..');
		return false;
	}
	PageMethod("<?=base_url('Zonedashboard/view_uploaded_business_by_type')?>", "Displaying Businessess...<br/>This may take a few minutes", data, successMCBdata, null);
});
function successMCBdata(result){	//alert(JSON.stringify(result));
	$.unblockUI();
	
	if(result.Tag!=''){ 
		var total_result=result.Title;
		var limit=result.Message;
		limit_final=limit.split(',');
		lowerlimit=limit_final[0];
		if(limit=='10,10' || lowerlimit=='0'){ 
			$(".view_uploaded_business").html('');
			$(".view_uploaded_business").show();
			$(".view_uploaded_business").append(result.Tag);
			
		}else{
			//$(".view_uploaded_business").html('')
			$(".view_uploaded_business").show();
			$(".view_uploaded_business").append(result.Tag);
		}
		if(total_result<10){
			$('.display_more_business').hide();
		}else{
			$('.display_more_business').show();
		}	
		//$("thead.headerclass:not(:first)").hide();
		//$("tr.headerclass_bus:not(:first)").hide();		
		
		$('.view_uploaded_business').find('thead.headerclass:not(:first)').hide();
		$('.view_uploaded_business').find('tr.headerclass_bus:not(:first)').hide();
		$('.view_uploaded_business').find('div.display_more_business:not(:last)').hide();
		$('.display_more_business').find('a.more_temp_business').attr('rel',limit);
		//$('.view_non_temp_business').find('div.container_tab_header').hide();	
		var default_message= $('.view_temp_business').find('table.pretty').length; 
		if(default_message==0){
			$('.view_temp_business').find('div.container_tab_header').show();
		}
		
		/*if(result.Title == 0){ 
			$('.view_uploaded_business').html('<div class="container_tab_header" style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;">No Businesses are Found</div>').show();
		}*/
	}

	
	
	/*if(result.Tag!=''){
		$(".view_uploaded_business").show();
		$(".view_uploaded_business").html(result.Tag);
	}*/
}
///////////////////////////////// Manually Created Businesses With Temp Category End //////////////////////////////////////////// 

/////////////////////////////////////////// Trial Businesses With Temp Category start /////////////////////////////////////// 
$(document).on('change','#business_zone_tbtc',function(){
	//var business_zone = $(this).val(); //alert(business_zone); return false; 
	$('.active_tbtc').click();
});
// For search part start
$(document).on('click','#btn_bus_search_by_name_tbtc_active',function(){
	//var business_zone = $(this).val(); //alert(business_zone); //return false; 
	$('.active_tbtc').click();
});
$(document).on('click','#btn_bus_search_by_alphabet_tbtc_active',function(){
	//var business_zone = $(this).val(); //alert(business_zone); //return false; 
	$('.active_tbtc').click();
});

$(document).on('click','#btn_bus_search_by_name_tbtc_deactive',function(){
	//var business_zone = $(this).val(); //alert(business_zone); //return false; 
	$('.deactive_tbtc').click();
});
$(document).on('click','#btn_bus_search_by_alphabet_tbtc_deactive',function(){
	//var business_zone = $(this).val(); //alert(business_zone); //return false; 
	$('.deactive_tbtc').click();
});
// For search part end  
// To click on Deactivated Trial Businesses With Temp Category Tab 
$(document).on('click','.deactive_tbtc',function(){ //alert('deactive_tbtc');
	$('.active_tbtc').removeClass('active');
	$('.deactive_tbtc').addClass('active');
	$(".edit_uploaded_business" ).hide();
	$(".view_uploaded_business").hide();
	$('.bus_search_tbtc_active').hide();
	$('.bus_search_tbtc_deactive').show();
	$('#text_bus_search_tbtc_active').val('');
	$('#select_bus_search_tbtc_active').val('-1');
	var zoneid=$('#zoneid').val();
	//var business_zone=$('#business_zone').val();
	var bus_search_by_name=$('#text_bus_search_tbtc_deactive').val(); 
	var bus_search_by_alphabet=$('#select_bus_search_tbtc_deactive').val();
	//var business_zone = $('input:radio[name="business_zone_tbtc"]:checked').val();
	var business_zone = 2;
	var str_arr=$(this).attr('id');
	var str=str_arr.split('###');
	var business_type=str[0];
	var business_type_by_category=str[1];
	var data={'zoneid':zoneid,'business_zone':business_zone,'business_type':business_type,'business_type_by_category':business_type_by_category,'bus_search_by_name':bus_search_by_name,'bus_search_by_alphabet':bus_search_by_alphabet};
	if(bus_search_by_name!='' && bus_search_by_alphabet!='-1'){
		alert('Please Select One Search Criteria..');
		return false;
	}
	PageMethod("<?=base_url('Zonedashboard/view_uploaded_business_by_type')?>", "Displaying Businessess...<br/>This may take a few minutes", data, successdata, null);
});
// To click on Activated Trial Businesses With Temp Category Tab 
$(document).on('click','.active_tbtc',function(){// alert('active_tbtc');
	
	
	$('.deactive_tbtc').removeClass('active');
	$('.active_tbtc').addClass('active');
	$(".edit_uploaded_business" ).hide();
	$('.bus_search_tbtc_deactive').hide();
	$('.bus_search_tbtc_active').show();
	$('#text_bus_search_tbtc_deactive').val('');
	//$('#text_bus_search_pbtc_deactive').attr('placeholder','Direct Search By Business Name');
	$('#select_bus_search_tbtc_deactive').val('-1');
	var zoneid=$('#zoneid').val();
	var bus_search_by_name=$('#text_bus_search_tbtc_active').val(); //alert(bus_search_by_name); 
	var bus_search_by_alphabet=$('#select_bus_search_tbtc_active').val(); //alert(bus_search_by_alphabet); 
	$(".view_uploaded_business").hide();
	//var business_zone = $('input:radio[name="business_zone_tbtc"]:checked').val();
	var business_zone = 2;
	var str_arr=$(this).attr('id');
	var str=str_arr.split('###');
	var business_type=str[0];
	var business_type_by_category=str[1];
	var data={'zoneid':zoneid,'business_zone':business_zone,'business_type':business_type,'business_type_by_category':business_type_by_category,'bus_search_by_name':bus_search_by_name,'bus_search_by_alphabet':bus_search_by_alphabet};
	if(bus_search_by_name!='' && bus_search_by_alphabet!='-1'){
		alert('Please Select One Search Criteria..');
		return false;
	}
	PageMethod("<?=base_url('Zonedashboard/view_uploaded_business_by_type')?>", "Displaying Businessess...<br/>This may take a few minutes", data, successdata, null);
});
/////////////////////////////////////////// Trial Businesses With Temp Category end /////////////////////////////////////// 

/////////////////////////////////////////// Paid Businesses With Temp Category start ///////////////////////////////////////
$(document).on('change','#business_zone_pbtc',function(){
	//var business_zone = $(this).val(); //alert(business_zone); //return false; 
	$('.active_pbtc').click();
});
// For search part start
$(document).on('click','#btn_bus_search_by_name_pbtc_active',function(){
	//var business_zone = $(this).val(); //alert(business_zone); //return false; 
	$('.active_pbtc').click();
});
$(document).on('click','#btn_bus_search_by_alphabet_pbtc_active',function(){
	//var business_zone = $(this).val(); //alert(business_zone); //return false; 
	$('.active_pbtc').click();
});

$(document).on('click','#btn_bus_search_by_name_pbtc_deactive',function(){
	//var business_zone = $(this).val(); //alert(business_zone); //return false; 
	$('.deactive_pbtc').click();
});
$(document).on('click','#btn_bus_search_by_alphabet_pbtc_deactive',function(){
	//var business_zone = $(this).val(); //alert(business_zone); //return false; 
	$('.deactive_pbtc').click();
});
// For search part end  
// To click on Deactivated Paid Businesses With Temp Category Tab 
$(document).on('click','.deactive_pbtc',function(){ //alert('deactive_pbtc');
	$('.active_pbtc').removeClass('active');
	$('.deactive_pbtc').addClass('active');
	$(".edit_uploaded_business" ).hide();
	$( ".view_non_temp_business").hide();
	$('.bus_search_pbtc_active').hide();
	$('.bus_search_pbtc_deactive').show();
	$('#text_bus_search_pbtc_active').val('');
	//$('#text_bus_search_pbtc_active').attr("placeholder","Direct Search By Business Name");
	$('#select_bus_search_pbtc_active').val('-1');
	var zoneid=$('#zoneid').val();
	var bus_search_by_name=$('#text_bus_search_pbtc_deactive').val(); 
	var bus_search_by_alphabet=$('#select_bus_search_pbtc_deactive').val(); 
	//var business_zone = $('input:radio[name="business_zone_pbtc"]:checked').val();
	var business_zone = 2;
	var str_arr=$(this).attr('id');
	var str=str_arr.split('###');
	var business_type=str[0];
	var business_type_by_category=str[1];
	if(bus_search_by_name!='' && bus_search_by_alphabet!='-1'){
		alert('Please Select One Search Criteria..');
		return false;
	}
	var data={'zoneid':zoneid,'business_zone':business_zone,'business_type':business_type,'business_type_by_category':business_type_by_category,'bus_search_by_name':bus_search_by_name,'bus_search_by_alphabet':bus_search_by_alphabet};
	PageMethod("<?=base_url('Zonedashboard/view_uploaded_business_by_type')?>", "Displaying Businessess...<br/>This may take a few minutes", data, successdata, null);
});
// To click on Activated Paid Businesses With Temp Category Business Tab 
$(document).on('click','.active_pbtc',function(){ //alert('active_pbtc');
	$('.deactive_pbtc').removeClass('active');
	$('.active_pbtc').addClass('active');
	$(".edit_uploaded_business" ).hide();
	$(".view_non_temp_business" ).hide();
	$('.bus_search_pbtc_deactive').hide();
	$('.bus_search_pbtc_active').show();
	$('#text_bus_search_pbtc_deactive').val('');
	//$('#text_bus_search_pbtc_deactive').attr('placeholder','Direct Search By Business Name');
	$('#select_bus_search_pbtc_deactive').val('-1');
	var zoneid=$('#zoneid').val();
	var bus_search_by_name=$('#text_bus_search_pbtc_active').val(); //alert(bus_search_by_name); 
	var bus_search_by_alphabet=$('#select_bus_search_pbtc_active').val(); //alert(bus_search_by_alphabet); 
	//var business_zone = $('input:radio[name="business_zone_pbtc"]:checked').val();
	var business_zone = 2;
	var str_arr=$(this).attr('id');
	var str=str_arr.split('###');
	var business_type=str[0];
	var business_type_by_category=str[1];
	if(bus_search_by_name!='' && bus_search_by_alphabet!='-1'){
		alert('Please Select One Search Criteria..');
		return false;
	}
	var data={'zoneid':zoneid,'business_zone':business_zone,'business_type':business_type,'business_type_by_category':business_type_by_category,'bus_search_by_name':bus_search_by_name,'bus_search_by_alphabet':bus_search_by_alphabet};
	PageMethod("<?=base_url('Zonedashboard/view_uploaded_business_by_type')?>", "Displaying Businessess...<br/>This may take a few minutes", data, successdata, null);
});
/////////////////////////////////////////// Paid Businesses With Temp Category end ///////////////////////////////////////
// To view the Data
function successdata(result){  //alert(JSON.stringify(result));
	$.unblockUI();
	if(result.Tag!=''){
		var total_result=result.Title;
		var limit=result.Message;
		limit_final=limit.split(',');
		lowerlimit=limit_final[0];
		if(limit=='10,10' || lowerlimit=='0'){ 
			$(".view_uploaded_business").html('');
			$(".view_uploaded_business").show();
			$(".view_uploaded_business").append(result.Tag);
			
		}else{
			//$(".view_uploaded_business").html('')
			$(".view_uploaded_business").show();
			$(".view_uploaded_business").append(result.Tag);
		}
		if(total_result<10){
			$('.display_more_business').hide();
		}else{
			$('.display_more_business').show();
		}	
		//$("thead.headerclass:not(:first)").hide();
		//$("tr.headerclass_bus:not(:first)").hide();	
		
		$('.view_uploaded_business').find('thead.headerclass:not(:first)').hide();
		$('.view_uploaded_business').find('tr.headerclass_bus:not(:first)').hide();
		$('.view_uploaded_business').find('div.display_more_business:not(:last)').hide();
		$('.display_more_business').find('a.more_temp_business').attr('rel',limit);
		//$('.view_non_temp_business').find('div.container_tab_header').hide();	
		var default_message= $('.view_temp_business').find('table.pretty').length; 
		if(default_message==0){
			$('.view_temp_business').find('div.container_tab_header').show();
		}
		
		/*if(result.Title == 0){ 
			$('.view_uploaded_business').html('<div class="container_tab_header" style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;">No Businesses are Found</div>').show();
		}*/
	}
}
 
// + To Select All from header
$(document).on('click','#select_all_business_listed',function(){ //alert(1);
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
}); // - To Select All from header
// + To click on individual checkbox, uncheck the 'Select All' checkbox
$(document).on('click','#individual_checkbox_business',function(){
	var total_checkbox=$("input[name=checkadfordelete]").length ;
	var total_checked_checkbox=$("input[name=checkadfordelete]:checked").length; 
	//alert(total_checkbox); alert(total_checked_checkbox); return false; 	
	if(total_checkbox!=total_checked_checkbox){ //alert(1);
		 $('#select_all_business_listed').attr('checked', false);		
	}else if(total_checkbox==total_checked_checkbox){ //alert(2);
		 $('#select_all_business_listed').attr('checked', true);		
	}
}); // - To click on individual checkbox, uncheck the 'Select All' checkbox
// + To Show/Hide in Update menu
$(document).on('change','#action_performed',function(){
	var tag=$(this).val(); //alert(tag);  return false;
	if(tag==6){
		$('select#change_business_status').show();
		//$('#business_delete_all_or_specific').show();
		$('select#action_performed_in_where').hide();
	}else if(tag==3){
		$('select#change_business_status').hide();
		//$('#business_delete_all_or_specific').show();
		$('select#action_performed_in_where').show();
	}
});
$(document).on('change','#business_delete_all_or_specific',function(){
	if($('#business_delete_all_or_specific').val()==2){ //alert(1);  
		$("input[name=checkadfordelete]").attr('disabled','disabled');
		$("input[name=select_all_business]").attr('disabled','disabled');
	}else{ 
		$("input[name=checkadfordelete]").attr('disabled',false);
		$("input[name=select_all_business]").attr('disabled',false);
	}
});
// - To Show/Hide in Update menu
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
// + Update The Business
$(document).on('click','#update_temp_business',function(){
	//var action_performed=$('#action_performed').val(); 
	var action_performed = $(this).parents('#action_performed_div').find('#action_performed').val(); 
	//var change_business_status=$('#change_business_status').val();
	var change_business_status=$(this).parents('#action_performed_div').find('#change_business_status').val(); 
	//var action_performed_in_where=$('#action_performed_in_where').val();
	var action_performed_in_where=$(this).parents('#action_performed_div').find('#action_performed_in_where').val(); 
	var business_delete_all_or_specific=$(this).parents('#action_performed_div').find('#business_delete_all_or_specific').val();
	//var business_delete_all_or_specific=$(this).parents('#action_performed_div').find('#business_delete_all_or_specific').val(); 
	var display_checkbox='';		
	$("input[name=checkadfordelete]:Checked").each(function(i,item){
		display_checkbox+=$(item).val()+',';
	});	
	display_checkbox=display_checkbox.substring(0,display_checkbox.length-1);
	var a= display_checkbox.split(',');
	var b=uniqueArr(a);
	var display_checkbox=b.join(',');
	if(display_checkbox=='' && business_delete_all_or_specific==1){
		alert('Please Select At least One Business.');
		return false;
	} //alert(display_checkbox); return false;
	var business_type=$(this).attr('data-businesstype'); //alert(business_type);
	var business_type_by_category=$(this).attr('data-businesstypebycategory');
	var business_zone=$(this).attr('data-businesszone');
	
	data={businessid:display_checkbox,zoneid:$('#zoneid').val(),action_performed:action_performed,change_business_status:change_business_status,action_performed_in_where:action_performed_in_where,business_delete_all_or_specific:business_delete_all_or_specific,business_type:business_type,business_type_by_category:business_type_by_category,business_zone:business_zone}
	
	if(action_performed==3 && action_performed_in_where==0 && business_delete_all_or_specific==1){
			ConfirmDialog('If you delete businesses data records from your database it will simultaneously delete the ads for each deleted business. <br/></br>When you upload the businesses again, each business will be placed into the "Businesses Uploaded" category and each business will receive: <br/>1. The User ID will again be the businesses 10 digit phone number <br/>2. A new Password <br/>3. A new unique URL ID for Direct Browser Access and <br/>4. Temporary AD content will be auto inserted into each businesses Ad Space.', "Warning", "<?=base_url('Zonedashboard/action_performed_listed_business')?>","", data, businesssuccess, null);
		}else if(action_performed==3 && action_performed_in_where==1 && business_delete_all_or_specific==1){
			ConfirmDialog('If you delete businesses data records from your database it will simultaneously delete the ads for each deleted business. <br/></br>When you upload the businesses again, each business will be placed into the "Businesses Uploaded" category and each business will receive: <br/>1. The User ID will again be the businesses 10 digit phone number <br/>2. A new Password <br/>3. A new unique URL ID for Direct Browser Access and <br/>4. Temporary AD content will be auto inserted into each businesses Ad Space.', "Warning", "<?=base_url('Zonedashboard/action_performed_listed_business')?>","Deleting...<br/>This may take a minute", data, businesssuccess, null);
		}else if(action_performed==3 && action_performed_in_where==0 && business_delete_all_or_specific==2){
			ConfirmDialog('If you delete businesses data records from your database it will simultaneously delete the ads for each deleted business. <br/></br>When you upload the businesses again, each business will be placed into the "Businesses Uploaded" category and each business will receive: <br/>1. The User ID will again be the businesses 10 digit phone number <br/>2. A new Password <br/>3. A new unique URL ID for Direct Browser Access and <br/>4. Temporary AD content will be auto inserted into each businesses Ad Space.', "Warning", "<?=base_url('Zonedashboard/action_performed_listed_business')?>","Deleting...<br/>This may take a minute", data, businesssuccess, null);
		}else if(action_performed==3 && action_performed_in_where==1 && business_delete_all_or_specific==2){
			ConfirmDialog('If you delete businesses data records from your database it will simultaneously delete the ads for each deleted business. <br/></br>When you upload the businesses again, each business will be placed into the "Businesses Uploaded" category and each business will receive: <br/>1. The User ID will again be the businesses 10 digit phone number <br/>2. A new Password <br/>3. A new unique URL ID for Direct Browser Access and <br/>4. Temporary AD content will be auto inserted into each businesses Ad Space.', "Warning", "<?=base_url('Zonedashboard/action_performed_listed_business')?>","Deleting...<br/>This may take a minute", data, businesssuccess, null);
		}else{
			PageMethod("<?=base_url('Zonedashboard/action_performed_listed_business')?>", "Action Performed...<br/>This may take a few minutes", data, businesssuccess, null);
		}		
});
function businesssuccess(result){  //alert(JSON.stringify(result)); //alert(result);//alert(msg);return false;
	$.unblockUI();
	var business_delete_all_or_specific=result.Title;
	/*var business_delete_all_or_specific=result.Tag;*/
		if(result.Title!=''){ //alert(businessid);
			if(business_delete_all_or_specific==1){
				$("input[name=checkadfordelete]:Checked").each(function(i,item){ //alert(2);
					//$('tr#'+$(item).val()).hide();
					$('.pretty').find('tr#'+$(this).val()).hide();
					$("input[name=checkadfordelete]:Checked").attr('checked',false);
					$("input[name=select_all_business_listed]:Checked").attr('checked',false); 
				});
			}else if(business_delete_all_or_specific==2){
				$('.uploadbusiness').hide();
				//showListedBusiness(result.Message,'all');	
			}
		}
}
// - Update The Business
///////////////////////////////// Edit Business Start /////////////////////////////////////

$(document).on('click','.edit_business',function(){ 
	var id=$(this).attr('rel'); 
	var businesstype=$(this).attr('data-businesstype');
	var businesstypebycategory=$(this).attr('data-businesstypebycategory');
	var businesszone=$(this).attr('data-businesszone');
	var data={businessid:id,zoneid:$('#zoneid').val(),businesstype:businesstype,businesstypebycategory:businesstypebycategory,businesszone:businesszone}
	PageMethod("<?=base_url('Zonedashboard/edit_temp_business')?>", "Action Performed...<br/>This may take a few minutes", data, EditNonTempBusinessSuccess, null);
});
function EditNonTempBusinessSuccess(result){
	$.unblockUI();
	if(result.Tag!=''){
		$('.view_uploaded_business').hide();
		$(".edit_uploaded_business").show();
		$(".edit_uploaded_business").html(result.Tag);
		var data={businessid:$('#biz_id').val(),zoneid:$('#biz_zone_id').val()}
		PageMethod("<?=base_url('Zonedashboard/view_edit_temp_business')?>", "Action Performed...<br/>This may take a few minutes", data, ViewEditNonTempBusinessSuccess, null); 
	}
}
function ViewEditNonTempBusinessSuccess(result){ //alert(JSON.stringify(result));
	$.unblockUI();
	if(result.Tag!=''){
		var str=result.Tag;
		$('.edit_uploaded_business').find('#biz_address_id').val(str.addressid);
		$('.edit_uploaded_business').find('#biz_user_id').val(str.userid);
		$('.edit_uploaded_business').find('#biz_addsetting_id').val(str.adsettingid);
		$('.edit_uploaded_business').find('#biz_user_id').val(str.userid);
		$('.edit_uploaded_business').find('#biz_name').val(str.name);
		$('.edit_uploaded_business').find('#biz_motto').val(str.motto);
		$('.edit_uploaded_business').find('#biz_email').val(str.contactemail); 		
		$('.edit_uploaded_business').find('#biz_first_name').val(str.contactfirstname);
		$('.edit_uploaded_business').find('#biz_last_name').val(str.contactlastname);
		$('.edit_uploaded_business').find('#biz_address_1').val(str.street_address_1); 
		$('.edit_uploaded_business').find('#biz_address_2').val(str.street_address_2);
		$('.edit_uploaded_business').find('#biz_city').val(str.city);
		$('.edit_uploaded_business').find('#biz_state').find('option[value='+str.state+']').attr('selected','selected');
		$('.edit_uploaded_business').find('#biz_phone').val(str.phone); 
		$('.edit_uploaded_business').find('#biz_website').val(str.website); 
		$('.edit_uploaded_business').find('#biz_sic').val(str.siccode);
		$('.edit_uploaded_business').find('#biz_username').val(str.username); 
		$('.edit_uploaded_business').find('#biz_password').val(str.uploaded_business_password);
	}
}

$(document).on('click','#edit_update_temp_business',function(){ 
	var tag=$(this).parent().parent().siblings();
	var businesstype=$(this).attr('data-businesstype');
	var businesstypebycategory=$(this).attr('data-businesstypebycategory');
	var businesszone=$(this).attr('data-businesszone');
	
	var data={businessid:$('#biz_id').val(),zoneid:$('#biz_zone_id').val(),biz_addsetting_id:$('#biz_addsetting_id').val(),biz_address_id:$('#biz_address_id').val(),biz_user_id:$('#biz_user_id').val(),businesstype:businesstype,businesstypebycategory:businesstypebycategory,businesszone:businesszone,biz_name:tag.find('#biz_name').val(),biz_motto:tag.find('#biz_motto').val(),biz_email:tag.find('#biz_email').val(),biz_first_name:tag.find('#biz_first_name').val(),biz_last_name:tag.find('#biz_last_name').val(),biz_address_1:tag.find('#biz_address_1').val(),biz_address_2:tag.find('#biz_address_2').val(),biz_city:tag.find('#biz_city').val(),biz_state:tag.find('#biz_state').val(),biz_phone:tag.find('#biz_phone').val(),biz_website:tag.find('#biz_website').val(),biz_sic:tag.find('#biz_sic').val(),biz_username:tag.find('#biz_username').val()}
	//console.log(data); return false;
	PageMethod("<?=base_url('Zonedashboard/update_edit_temp_business')?>", "Action Performed...<br/>This may take a few minutes", data, UpdateEditNonTempBusinessSuccess, null); 
	
});
function UpdateEditNonTempBusinessSuccess(result){				//alert(JSON.stringify(result));
	$.unblockUI();
	if(result.Tag!=''){
		$(".success").show();
	}
}

/*$(document).on('click','#back_to_business',function(){ 	
	var businesstype=$(this).attr('data-businesstype');
	$(".edit_uploaded_business").hide();
	$('.view_uploaded_business').show();
});*/
$(document).on('click','#back_to_business',function(){  	
	var businesstype=$(this).attr('data-businesstype');
	var businesstypebycategory=$(this).attr('data-businesstypebycategory'); 
	var businesszone=$(this).attr('data-businesszone'); //alert(businesstype); alert(businesstypebycategory); alert(businesszone);
	$(".edit_uploaded_business").hide();
	$('.view_uploaded_business').show();
	if(businesstype=='3' && businesszone=='0' && businesstypebycategory=='ub'){
		$('.active_ub').click();
	}else if(businesstype=='-3' && businesszone=='0' && businesstypebycategory=='ub'){
		$('.deactive_ub').click();
	}else if(businesstype=='3' && businesszone=='1' && businesstypebycategory=='ub_m'){
		$('.active_ub_m').click();
	}else if(businesstype=='-3' && businesszone=='1' && businesstypebycategory=='ub_m'){
		$('.deactive_ub_m').click();
	}else if(businesstype=='2' && businesszone=='2' && businesstypebycategory=='tbtc'){
		$('.active_tbtc').click();
	}else if(businesstype=='-2' && businesszone=='2' && businesstypebycategory=='tbtc'){
		$('.deactive_tbtc').click();
	}else if(businesstype=='1' && businesszone=='2' && businesstypebycategory=='pbtc'){
		$('.active_pbtc').click();
	}else if(businesstype=='-1' && businesszone=='2' && businesstypebycategory=='pbtc'){
		$('.deactive_pbtc').click();
	}
});
///////////////////////////////// Edit Business End /////////////////////////////////////
</script>