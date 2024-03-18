<style xmlns="http://www.w3.org/1999/html">
fieldset {
	border:1px solid green
}
legend {
	padding: 0.2em 0.5em;
	border:1px solid green;
	color:green;
	font-size:90%;
	text-align:right;
}
.p_change_reason {
	display:none;
}
  .option{
	   cursor:pointer;
	   text-align:left;
	   width:90%;
	}
	.optionall{
	   cursor:pointer;
	   text-align:left;
	   width:90%;
	}
	.dropdown{
		height:100px;width:250px;border:1px solid #999;overflow:scroll;overflow-x: hidden;
	}
	.dropdown table{
		font:Verdana, Geneva, sans-serif;
		font-size:10px;
		font-weight:normal;
		margin:0;
	}
	.dropdown table tr,.dropdown table tr td{
		background-color:#FFF;
	}
	.selected{
		 background-color:#069;
	}
	div.food_icon_image{ background:#343436; overflow:hidden; padding:6px; border-radius:6px;}
	.food_icon_image a{ display:block; float:left; margin:2px;}		
	.food_icon_image_normal img{ margin:1px;}
	.food_icon_image_selected img{ border:1px solid #FFF;}
	textarea.dashboard_editor_textarea{ margin-left:161px;}
	.letters_to_muni img, .letters_to_busi img{ margin:0px 0 0 0; float:left;}
	.letters_to_muni p, .letters_to_busi p{ float:right; width:310px; text-align:center; color:#fff; font-size:15px; margin:0;}
	.letters_to_muni p span, .letters_to_busi p span{ color:#fff; font-size:24px; font-weight:bold;}
	.letters_to_muni, .letters_to_busi{ padding:2px 15px 12px; float:left; height:50px; width:380px; background:#0089c2; border-radius:15px; box-shadow:0px 0px 20px #000; margin:17px 0; }
	.letters_to_busi{ float:right !important;}
</style>

<div id="main-header" class="main-header" >
	<!--<div>Your account cannot be verified.For verify your account, please <a href="#email-box" class="email-window">click here</a></div>-->
	<div style="overflow: scroll;">
    	
		<div id="accordion">
        	<!-- Zone Data Start-->
			<h3><a style="float:left;" href="#">Zone Data (Zone: <?=$zone->name?>, Zone Id: <?=$zone_id?>)</a><div style="float:right; margin:7px 10px 0 30px; color:#FFF">Step: 1 </div></h3>
			<div>
            	<!--<input type="image" src="<?=base_url('assets/images/Actions-edit-rename-icon.png')?>" onclick="editName();return false;" title="Rename Zone" value="Rename Zone" class="img22 mb10"/>
        		<input type="image" src="<?=base_url('assets/images/Actions-shazam-icon.png')?>" onclick="newZone();return false;" title="Create Zone" value="Create Zone" class="img22 mb10"/>-->
                <input type="button" onclick="newZone();return false;" title="Create New Zone" value="Create New Zone" id="createzone"/>
                <input type="button" onclick="editName();return false;" title="Rename Zone" value="Rename Zone" id="renamezone"/>
                
                <input type="button" onclick="deleteZone(<?=$zone_id?>);return false;" title="Delete This Zone" value="Delete Zone" id="deletezone"/>
            	<!--<span id="zoneNameEditButtons">-->
            		<!--<input type="image" src="<?=base_url('assets/images/Button-Save-icon.png')?>" onclick="saveZoneName();return false;" title="Rename Zone" value="Rename Zone" class="img22 mb10"/>
           			<input type="image" src="<?=base_url('assets/images/Button-Cancel-icon.png')?>" onclick="cancelEditName();return false;" title="Cancel Edit" value="Cancel Edit" class="img22 mb10"/>-->
                    <input type="button" onclick="saveZoneName();return false;" title="Save Zone" value="Save Zone" id="savezone"/>
           			<input type="button" onclick="cancelEditName();return false;" title="Cancel Edit" value="Cancel" id="canceledit"/>                     
            	<!--</span>--> <br /><br/>
				<? if(!empty($my_zones) && count($my_zones) > 1){?>
                <label for="myZones"><b>Change Zone</b></label>
                <select id="myZones">
                  <option value="-1" selected="selected" disabled="disabled">--- Select A Zone To Change To ---</option>
                  <?foreach($my_zones as $my_zone){ if($my_zone['id'] == $zone_id) { continue;}?>
                  <option value="<?=$my_zone['id']?>">
                  <?=$my_zone['name']?>
                  </option>
                  <?}?>
                </select>
                </br>
                <? } ?>
				<div id="zoneData"> <b>Zone Name</b>: <span id="zoneNameDisplay">
				  <?=$zone->name?>
				  </span> <span id="zoneNameEdit">
				  <input type="text" id="zoneName" value="<?=$zone->name?>"/>
                  <button onclick="zone_verification();">Zone Verification</button>
				  </span>
                  <span id="error_zname" style="margin:0 0 8px 226px; background:#F00; font-weight:bold; color:#fff; padding:3px; width:300px; display:block; text-align:center"></span>
                  <span id="success_zname" style="font-weight:bold; color:#fff; margin:0 0 0 226px; background:#063; padding:3px; width:300px; display:block; text-align:center"></span>
                  <br/>
				  <b>Zone Owner</b>:
				  <?= $zone_owner->last_name ?>
				  ,
				  <?= $zone_owner->first_name?>
				  <br />
				  <?if(!empty($total_business)){?>
				  <b>Total Businesses</b>:
				  <?=$total_business[0]['TotBusiness']?>
				  <br/>
				  <?}?>
				  <?if(!empty($total_ads)){?>
				  <b>Total Ads</b>:
				  <?=$total_ads[0]['TotAds']?>
				  <br/>
				  <?}?>
				  <b>Total SNAP Subscribers</b>: Coming Soon<br/>
				  
				 <!-- <b>Zone Url (raw)</b>: <a target="_blank" href="<?=base_url('/welcome/index/')?>/<?=$zone->id?>"><?=base_url('/welcome/index/')?>/<?=$zone->id?></a><br />-->				  
				  
                  <b>Zone Url (raw)</b>: <a target="_blank" href="<?=base_url('/index.php?zone=')?><?=$zone->id?>"><?=base_url('/index.php?zone=')?><?=$zone->id?></a><br />			
                  <b>Zone Url (SEO Compliant URL)</b>: <a target="_blank" href="<?=base_url('/zone/load/')?>/<?=$zone->name?>"><?=base_url('/zone/load/')?>/<?=$zone->name?></a><br />				  
				  <b>Zone Url (SEO Compliant URL 2)</b>: <a target="_blank" href="<?=base_url('/zone/load/')?>/<?=$zone->id?>"><?=base_url('/zone/load/')?>/<?=$zone->id?></a><br />
				  				 
				</div>
			</div><!-- Zone Data end-->
             <!-- Zip Codes Start-->
			<h3><a style="float:left;" href="#" onclick="zipcodes_display(<?=$zone_id?>,<?=$uid?>)";>Zip Codes (Zone: <?=$zone->name?>, Zone Id: <?=$zone_id?>)</a> <div style="float:right; margin:7px 10px 0 30px; color:#FFF">Step: 2 </div></h3>
			<div><div id="zip_codes"></div></div><!-- Zip Codes End-->
            <!-- Default Settings Part Start-->
			<h3><a style="float:left;" href="#" onclick="defaultsetting(<?=$zone_id?>);">Default Settings (Zone: <?=$zone->name?>, Zone Id: <?=$zone_id?>)</a><div style="float:right; margin:7px 10px 0 30px; color:#FFF">Step: 3 </div></h3>
			<div><div id ="default_setting"> </div></div> <!-- Default Settings Part end-->            
            <!-- Category List Start-->
			<h3><a style="float:left;" href="#" onclick="edit_category(<?=$zone_id?>);">Category List (Zone: <?=$zone->name?>, Zone Id: <?=$zone_id?>) </a>
            <div style="float:right; margin:7px 10px 0 30px; color:#FFF">Step: 4 </div></h3>
			<div>
            			
				<div style="background-color: #808080; height:30px;"> 
					<div style="padding:5px 25px; float:left;"><a href="javascript:void()" onclick="add_category(<?=$zone_id?>);"><!--Add Category-->Suggest New Category</a></div>
					<div style="padding:5px 25px; float:left;"><a href="javascript:void()" onclick="add_sub_category(<?=$zone_id?>);"><!--Add Sub Category-->Suggest New SubCategory</a></div>
					<div style="padding:5px 25px;"><a href="javascript:void()" onclick="edit_category(<?=$zone_id?>);"> Category/Sub Category Visibility</a></div>
				</div>
				<div id ="new_cat" style="background-color: gainsboro;"> </div>
				<div id ="new_subcat" style="background-color: gainsboro;"> </div>
				<div id ="edit_cat"> </div>
				<div id ="edit_subcat"> </div>
			</div><!-- Category List End-->
           								
			
			<!-- Business Part Start-->
            <h3><a style="float:left;" href="javascript:void()" onclick="showBusiness(<?=$zone_id?>,'all');">My Businesses (Zone: <?=$zone->name?>, Zone Id: <?=$zone_id?>) </a><div style="float:right; margin:7px 10px 0 30px; color:#FFF">Step: 5 </div></h3>
			<div>
				 <select name="business_zone" id="business_zone" onchange="zone_business_allbusiness()">
				  <!--<option value="0">Business in my zone</option>
				  <option value="1">Business advertising in my zone</option>
				  <option value="2">All Business</option>-->
                  <option value="2">All businesses in my zone or outside my zone</option>
                  <option value="0">Businesses in my zone and located in my zone</option>
				  <option value="1">Businesses advertising in my zone but located outside my zone</option>
				 <!-- <option value="2">All businesses in my zone or outside my zone</option>-->
                  <option value="3">All businesses which are not assigned to any zone</option>
				</select>
				<select name="show_bus_type" id="show_bus_type" style="display:none">
				  <option value="0">New Business - Not Yet Approved</option>
				  <option value="1">Active Paid Business - Ad is viewable</option>
				  <option value="-1">Expired Paid Business - Ad is not viewable</option>
				  <option value="2">Active Trial Business - Ad is viewable</option>
				  <option value="-2">Expired Trial Business - Ad is not viewable</option>
				</select>
				<button class="showbusiness" onclick="showBusiness(<?=$zone_id?>,'all');">Show</button><br/> <input type="text" id="bus_search" name="bus_search" placeholder="Direct search by business name" style="width:250px;"/><button class="showbusiness" onclick="showBusiness(<?=$zone_id?>,$('#bus_search').val());" style="margin-left:5px;">Search</button><br/>
				
				<br/><div style="padding-left:8px; color:#808080"><strong>Search your business by alphabetical order</strong></div>
                <a href="javascript:void()" onclick="showBusiness(<?=$zone_id?>,'a');" class="alphabet">a</a>
                <a href="javascript:void()" onclick="showBusiness(<?=$zone_id?>,'b');" class="alphabet">b</a>
                <a href="javascript:void()" onclick="showBusiness(<?=$zone_id?>,'c');" class="alphabet">c</a>
                <a href="javascript:void()" onclick="showBusiness(<?=$zone_id?>,'d');" class="alphabet">d</a>
                <a href="javascript:void()" onclick="showBusiness(<?=$zone_id?>,'e');" class="alphabet">e</a>
                <a href="javascript:void()" onclick="showBusiness(<?=$zone_id?>,'f');" class="alphabet">f</a>
                <a href="javascript:void()" onclick="showBusiness(<?=$zone_id?>,'g');" class="alphabet">g</a>
                <a href="javascript:void()" onclick="showBusiness(<?=$zone_id?>,'h');" class="alphabet">h</a>
                <a href="javascript:void()" onclick="showBusiness(<?=$zone_id?>,'i');" class="alphabet">i</a>
                <a href="javascript:void()" onclick="showBusiness(<?=$zone_id?>,'j');" class="alphabet">j</a>
                <a href="javascript:void()" onclick="showBusiness(<?=$zone_id?>,'k');" class="alphabet">k</a>
                <a href="javascript:void()" onclick="showBusiness(<?=$zone_id?>,'l');" class="alphabet">l</a>
                <a href="javascript:void()" onclick="showBusiness(<?=$zone_id?>,'m');" class="alphabet">m</a>
                <a href="javascript:void()" onclick="showBusiness(<?=$zone_id?>,'n');" class="alphabet">n</a>
                <a href="javascript:void()" onclick="showBusiness(<?=$zone_id?>,'o');" class="alphabet">o</a>
                <a href="javascript:void()" onclick="showBusiness(<?=$zone_id?>,'p');" class="alphabet">p</a>
                <a href="javascript:void()" onclick="showBusiness(<?=$zone_id?>,'q');" class="alphabet">q</a>
                <a href="javascript:void()" onclick="showBusiness(<?=$zone_id?>,'r');" class="alphabet">r</a>
                <a href="javascript:void()" onclick="showBusiness(<?=$zone_id?>,'s');" class="alphabet">s</a>
                <a href="javascript:void()" onclick="showBusiness(<?=$zone_id?>,'t');" class="alphabet">t</a>
                <a href="javascript:void()" onclick="showBusiness(<?=$zone_id?>,'u');" class="alphabet">u</a>
                <a href="javascript:void()" onclick="showBusiness(<?=$zone_id?>,'v');" class="alphabet">v</a>
                <a href="javascript:void()" onclick="showBusiness(<?=$zone_id?>,'w');" class="alphabet">w</a>
                <a href="javascript:void()" onclick="showBusiness(<?=$zone_id?>,'x');" class="alphabet">x</a>
                <a href="javascript:void()" onclick="showBusiness(<?=$zone_id?>,'y');" class="alphabet">y</a>
                <a href="javascript:void()" onclick="showBusiness(<?=$zone_id?>,'z');" class="alphabet">z</a><br/>               
				<div class="editbusinessform"></div>
				<div id ="bus_display"></div>
			</div><!-- Business Part End-->
            
			<!-- Listed Business Part Start -->
			<h3><a style="float:left;" href="javascript:void()" onclick="showListedBusiness(<?=$zone_id?>,'all');">Upload, View and Search Businesses (Zone: <?=$zone->name?>, Zone Id: <?=$zone_id?>)</a><div style="float:right; margin:7px 10px 0 30px; color:#FFF">Step: 6 </div></h3>
			<div>
				 <!--<select name="business_zone_listed" id="business_zone_listed" onchange="zone_business_allbusiness()">
				  
				  <option value="1">Business advertising in my zone</option>
				  <option value="0">Business in my zone</option> 
				  <option value="2">All Business</option>
				</select>-->
               <div style="margin:18px 0 0; background:#333333; color:#fff; padding:10px; font-weight:bold;">Upload csv data file here. </div>
   
				<div style="background-color: #808080; height:30px;"> 
					
					<div style="padding:5px 25px; float:left;"><a href="javascript:void()" onclick="showListedBusiness(<?=$zone_id?>,'all');" class="showall">View Uploaded Businesses</a></div>
                    <div style="padding:5px 25px; float:left;"><a target="_blank" href="<?=base_url('csvuploader/index.php?csvuploaderzoneid=')?><?=$zone->id?>" class="showall"><u>Upload Businesses Here</u></a></div>
                    <div style="padding:5px 25px; float:left;"><a href="<?=base_url('csvuploader/sample_csv.csv')?>" class="showall">Download sample csv format</a></div>
                    
				</div>
				
				
				<br/>
				<select name="show_bus_type_listed" id="show_bus_type_listed">
				  <option value="3">Active Uploaded Business</option>
				  <option value="-3">Expired Uploaded Business</option>
				  <option value="0">All Uploaded Business</option>
				  <!--<option value="1">Active Paid Business</option>
				  <option value="-1">Deactive Paid Business</option>				  
				  <option value="-2">Deactive Trial Business</option>
				  <option value="0">New Business</option>-->
				</select>
				<button class="showListedBusiness" onclick="showListedBusiness(<?=$zone_id?>,'all');">Show</button><br /><input type="text" id="listed_bus_search" name="listed_bus_search" placeholder="Direct search by business name" style="width:250px;"/><button class="showListedBusiness" onclick="showListedBusiness(<?=$zone_id?>,$('#listed_bus_search').val());" style="margin-left:5px;">Search</button><br/>
                <div style="padding-left:8px; color:#808080"><strong>Search your business by alphabetical order</strong></div>
                <a href="javascript:void()" onclick="showListedBusiness(<?=$zone_id?>,'a');" class="alphabet">a</a>
                <a href="javascript:void()" onclick="showListedBusiness(<?=$zone_id?>,'b');" class="alphabet">b</a>
                <a href="javascript:void()" onclick="showListedBusiness(<?=$zone_id?>,'c');" class="alphabet">c</a>
                <a href="javascript:void()" onclick="showListedBusiness(<?=$zone_id?>,'d');" class="alphabet">d</a>
                <a href="javascript:void()" onclick="showListedBusiness(<?=$zone_id?>,'e');" class="alphabet">e</a>
                <a href="javascript:void()" onclick="showListedBusiness(<?=$zone_id?>,'f');" class="alphabet">f</a>
                <a href="javascript:void()" onclick="showListedBusiness(<?=$zone_id?>,'g');" class="alphabet">g</a>
                <a href="javascript:void()" onclick="showListedBusiness(<?=$zone_id?>,'h');" class="alphabet">h</a>
                <a href="javascript:void()" onclick="showListedBusiness(<?=$zone_id?>,'i');" class="alphabet">i</a>
                <a href="javascript:void()" onclick="showListedBusiness(<?=$zone_id?>,'j');" class="alphabet">j</a>
                <a href="javascript:void()" onclick="showListedBusiness(<?=$zone_id?>,'k');" class="alphabet">k</a>
                <a href="javascript:void()" onclick="showListedBusiness(<?=$zone_id?>,'l');" class="alphabet">l</a>
                <a href="javascript:void()" onclick="showListedBusiness(<?=$zone_id?>,'m');" class="alphabet">m</a>
                <a href="javascript:void()" onclick="showListedBusiness(<?=$zone_id?>,'n');" class="alphabet">n</a>
                <a href="javascript:void()" onclick="showListedBusiness(<?=$zone_id?>,'o');" class="alphabet">o</a>
                <a href="javascript:void()" onclick="showListedBusiness(<?=$zone_id?>,'p');" class="alphabet">p</a>
                <a href="javascript:void()" onclick="showListedBusiness(<?=$zone_id?>,'q');" class="alphabet">q</a>
                <a href="javascript:void()" onclick="showListedBusiness(<?=$zone_id?>,'r');" class="alphabet">r</a>
                <a href="javascript:void()" onclick="showListedBusiness(<?=$zone_id?>,'s');" class="alphabet">s</a>
                <a href="javascript:void()" onclick="showListedBusiness(<?=$zone_id?>,'t');" class="alphabet">t</a>
                <a href="javascript:void()" onclick="showListedBusiness(<?=$zone_id?>,'u');" class="alphabet">u</a>
                <a href="javascript:void()" onclick="showListedBusiness(<?=$zone_id?>,'v');" class="alphabet">v</a>
                <a href="javascript:void()" onclick="showListedBusiness(<?=$zone_id?>,'w');" class="alphabet">w</a>
                <a href="javascript:void()" onclick="showListedBusiness(<?=$zone_id?>,'x');" class="alphabet">x</a>
                <a href="javascript:void()" onclick="showListedBusiness(<?=$zone_id?>,'y');" class="alphabet">y</a>
                <a href="javascript:void()" onclick="showListedBusiness(<?=$zone_id?>,'z');" class="alphabet">z</a>
                
				<div class="editbusinessform_listed"></div>
				<div id ="bus_display_listed"></div>
			</div>
			<!-- Listed Business Part End -->
			<!-- Advertisement Part Start-->
            <h3><a style="float:left;" href="#">Advertisement (Zone: <?=$zone->name?>, Zone Id: <?=$zone_id?>) </a><div style="float:right; margin:7px 10px 0 30px; color:#FFF">Step: 7 </div></h3>
			<div>				
				<select name="show_ad_type" id="show_ad_type">
				  <option value="0">New Ads For Approval</option>
				  <option value="1">Activated Ads</option>
				  <option value="-1">Inactivated Ads</option>
				</select>
				<select id="all_business" name="all_business" >
                
                
				  <option value="<?php echo str_replace(',','-',$advertising_businesses_ids) ; ?>"> --- All Activated Business --- </option>
                   
                     
				  <? foreach($advertising_businesses as $all_business){ ?>
				  <option value="<?=$all_business['id']?>">
				  <?=$all_business['name']?>
				  </option>
				  <? } ?>
                 
				</select>
				<button onclick="showAdvertisement(<?=$zone_id?>,'all');" class="showad">Show</button>
                <!--<div style="display:none" id="newadzone"><button onclick="newadfromshowad()" disabled="disabled" id="newad">New Ad</button>
                </div>-->
               <br /><input type="text" id="listed_ad_search" name="listed_bus_search" placeholder="Direct search by Ad Details" style="width:250px;"/><button class="showAdvertisement" onclick="showAdvertisement(<?=$zone_id?>,$('#listed_ad_search').val());" style="margin-left:5px;">Search</button><br/>
                <div style="padding-left:8px; color:#808080"><strong>Search your ad by alphabetical order</strong></div>
                <a href="javascript:void()" onclick="showAdvertisement(<?=$zone_id?>,'a');" class="alphabet">a</a>
                <a href="javascript:void()" onclick="showAdvertisement(<?=$zone_id?>,'b');" class="alphabet">b</a>
                <a href="javascript:void()" onclick="showAdvertisement(<?=$zone_id?>,'c');" class="alphabet">c</a>
                <a href="javascript:void()" onclick="showAdvertisement(<?=$zone_id?>,'d');" class="alphabet">d</a>
                <a href="javascript:void()" onclick="showAdvertisement(<?=$zone_id?>,'e');" class="alphabet">e</a>
                <a href="javascript:void()" onclick="showAdvertisement(<?=$zone_id?>,'f');" class="alphabet">f</a>
                <a href="javascript:void()" onclick="showAdvertisement(<?=$zone_id?>,'g');" class="alphabet">g</a>
                <a href="javascript:void()" onclick="showAdvertisement(<?=$zone_id?>,'h');" class="alphabet">h</a>
                <a href="javascript:void()" onclick="showAdvertisement(<?=$zone_id?>,'i');" class="alphabet">i</a>
                <a href="javascript:void()" onclick="showAdvertisement(<?=$zone_id?>,'j');" class="alphabet">j</a>
                <a href="javascript:void()" onclick="showAdvertisement(<?=$zone_id?>,'k');" class="alphabet">k</a>
                <a href="javascript:void()" onclick="showAdvertisement(<?=$zone_id?>,'l');" class="alphabet">l</a>
                <a href="javascript:void()" onclick="showAdvertisement(<?=$zone_id?>,'m');" class="alphabet">m</a>
                <a href="javascript:void()" onclick="showAdvertisement(<?=$zone_id?>,'n');" class="alphabet">n</a>
                <a href="javascript:void()" onclick="showAdvertisement(<?=$zone_id?>,'o');" class="alphabet">o</a>
                <a href="javascript:void()" onclick="showAdvertisement(<?=$zone_id?>,'p');" class="alphabet">p</a>
                <a href="javascript:void()" onclick="showAdvertisement(<?=$zone_id?>,'q');" class="alphabet">q</a>
                <a href="javascript:void()" onclick="showAdvertisement(<?=$zone_id?>,'r');" class="alphabet">r</a>
                <a href="javascript:void()" onclick="showAdvertisement(<?=$zone_id?>,'s');" class="alphabet">s</a>
                <a href="javascript:void()" onclick="showAdvertisement(<?=$zone_id?>,'t');" class="alphabet">t</a>
                <a href="javascript:void()" onclick="showAdvertisement(<?=$zone_id?>,'u');" class="alphabet">u</a>
                <a href="javascript:void()" onclick="showAdvertisement(<?=$zone_id?>,'v');" class="alphabet">v</a>
                <a href="javascript:void()" onclick="showAdvertisement(<?=$zone_id?>,'w');" class="alphabet">w</a>
                <a href="javascript:void()" onclick="showAdvertisement(<?=$zone_id?>,'x');" class="alphabet">x</a>
                <a href="javascript:void()" onclick="showAdvertisement(<?=$zone_id?>,'y');" class="alphabet">y</a>
                <a href="javascript:void()" onclick="showAdvertisement(<?=$zone_id?>,'z');" class="alphabet">z</a>             
                
                <div class="editbusinessform_listed"></div>
				<div id ="ad_display_listed"></div>
                
                <div id="editAdfromshowad" style="display:none">				
					<?=form_open_multipart("dashboards/saveAdfromshowad", "name='businesses_form22' id='businesses_form22'");?>
                    <input type="hidden" id="foodimage" value=""/>
                    <input type="hidden" id="iseditad" value="0"/>
                    <input type="hidden" id="iszoneid" value="<?=$zone->id?>"/>
                    <input type="hidden" id="ad_id_fromshowad" name="ad_id_fromshowad" value="-1"/>
                    <input type="hidden" id="ad_business_fromshowad" name="ad_business_fromshowad" value=""/>
                    <input type="file" id="docx" name="docx" onchange="return upload_Image('docx','<?php echo site_url("dashboards/upload_docs/docx/businesses_form22");?>','businesses_form22');"/>
                    <p>Allowed  formats : (<?php echo strtoupper('docx|doc|pdf');?>)</p>
                    <p>Max Size : ( 1 MB)</p>
                    <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                    <div id="logo_image22">
                      <input type="hidden" id="docs_pdf" name="docs_pdf" />
                    </div>
                    <p id="docs_pdf_show" style="display:none;">
                      <label for="ad_name_fromshowad" style="width:150px; float:left; display:block; padding-right:10px;">Upload File</label>
                      <label id="docs_pdf_1" name="docs_pdf_1"></label>
                    </p>
                    <p style="display:none;">
                      <label for="ad_name_fromshowad" style="width:150px; float:left; display:block; padding-right:10px;">Ad Title</label>
                      <input type="text" id="ad_name_fromshowad" name="ad_name_fromshowad"/>
                    </p>
                    <p>
                      <label for="ad_code_fromshowad" style="width:150px; float:left; display:block; padding-right:10px;">Offer Code</label>
                      <input type="text" id="ad_code_fromshowad" name="ad_code_fromshowad"/>
                    </p>
                    <p>
                      <label for="ad_startdatetime_fromshowad" style="width:150px; float:left; display:block; padding-right:10px;">Start Date Time</label>
                      <input type="text" id="ad_startdatetime_fromshowad" name="ad_startdatetime_fromshowad"/>
                    </p>
                    <p>
                      <label for="ad_stopdatetime_fromshowad" style="width:150px; float:left; display:block; padding-right:10px;">Stop Date Time</label>
                      <input type="text" id="ad_stopdatetime_fromshowad" name="ad_stopdatetime_fromshowad"/>
                    </p>
                    <!-- date time custom -->
                    <div id="ad_cat" >
                    <p>
                      <label for="ad_category_fromshowad" style="width:150px; float:left; display:block; padding-right:10px;">Category</label>
                      <select id="ad_category_fromshowad" name="ad_category_fromshowad" onchange="business_cat()">
                      <option value="0"> --- Select Category --- </option>
                        <? foreach ($category_list1 as $category) {
                                echo("<option value='" . $category['id'] . "'>" . $category['name'] . "</option>");}?>
                      </select>
                    </p>
                    </div>
                    
                    
                    <div id="ad_subcategory_fromshowad1" style="display:none">
                    <!--<p><label for="ad_subcategory_fromshowad" style="width:150px; float:left; display:block; padding-right:10px;">Sub Category</label>
                    <select id="ad_subcategory_fromshowad" name="ad_subcategory_fromshowad">
                        <option value=""> --- Select Sub Category --- </option> 
                         <? /*foreach ($category_list2 as $category) {
							 if($category['id']!='')
                                echo("<option value='" . $category['id'] . "'>" . $category['name'] . "</option>");}*/?>                      
                    </select></p> -->                   
                    </div>
                    <div class="food_icon_image" style="display:none;">
                        <a href="javascript:void(0);" title="american" class="food_icon_image_normal checkclass" rel="1"><img src="../../assets/images/food_icons/white/american.png" height="30" alt=""/></a>
                        <a href="javascript:void(0);" title="asian" class="food_icon_image_normal checkclass" rel="2"><img src="../../assets/images/food_icons/white/asian.png" height="30" alt=""/></a>
                        <a href="javascript:void(0);" title="bakery" class="food_icon_image_normal checkclass" rel="3"><img src="../../assets/images/food_icons/white/bakery.png" height="30" alt=""/></a>           
                        <a href="javascript:void(0);" title="banquet" class="food_icon_image_normal checkclass" rel="4"><img src="../../assets/images/food_icons/white/banquet.png" height="30" alt=""/></a>       
                        <a href="javascript:void(0);" title="bbq" class="food_icon_image_normal checkclass" rel="5"><img src="../../assets/images/food_icons/white/bbq.png" height="30" alt=""/></a>
                        <a href="javascript:void(0);" title="catering" class="food_icon_image_normal checkclass" rel="6"><img src="../../assets/images/food_icons/white/catering.png" height="30" alt=""/></a>
                        <a href="javascript:void(0);" title="chicken" class="food_icon_image_normal checkclass" rel="7"><img src="../../assets/images/food_icons/white/chicken.png" height="30" alt=""/></a>                    	
                        <a href="javascript:void(0);" title="chinese" class="food_icon_image_normal checkclass" rel="8"><img src="../../assets/images/food_icons/white/chinese.png" height="30" alt=""/></a>                    	
                        <a href="javascript:void(0);" title="coffee" class="food_icon_image_normal checkclass" rel="9"><img src="../../assets/images/food_icons/white/coffee.png" height="30" alt=""/></a>
                        <a href="javascript:void(0);" title="convenience" class="food_icon_image_normal checkclass" rel="10"><img src="../../assets/images/food_icons/white/convinence.png" height="30" alt=""/></a>                    	
                        <a href="javascript:void(0);" title="deli" class="food_icon_image_normal checkclass" rel="11"><img src="../../assets/images/food_icons/white/deli.png" height="30" alt=""/></a> 
                        <a href="javascript:void(0);" title="delivery" class="food_icon_image_normal checkclass" rel="12"><img src="../../assets/images/food_icons/white/delivery.png" height="30" alt=""/></a>                    	
                        <a href="javascript:void(0);" title="diners" class="food_icon_image_normal checkclass" rel="13"><img src="../../assets/images/food_icons/white/diners.png" height="30" alt=""/></a>
                        <a href="javascript:void(0);" title="fastfood" class="food_icon_image_normal checkclass" rel="14"><img src="../../assets/images/food_icons/white/fastfood.png" height="30" alt=""/></a>                    	
                        <a href="javascript:void(0);" title="fine_dining" class="food_icon_image_normal checkclass" rel="15"><img src="../../assets/images/food_icons/white/fine_dining.png" height="30" alt=""/></a>
                        <a href="javascript:void(0);" title="fish" class="food_icon_image_normal checkclass" rel="16"><img src="../../assets/images/food_icons/white/fish.png" height="30" alt=""/></a>
                        <a href="javascript:void(0);" title="food_trucks" class="food_icon_image_normal checkclass" rel="17"><img src="../../assets/images/food_icons/white/food_trucks.png" height="30" alt=""/></a>                    	
                        <a href="javascript:void(0);" title="french" class="food_icon_image_normal checkclass" rel="18"><img src="../../assets/images/food_icons/white/french.png" height="30" alt=""/></a>
                        <a href="javascript:void(0);" title="fusion" class="food_icon_image_normal checkclass" rel="19"><img src="../../assets/images/food_icons/white/fusion.png" height="30" alt=""/></a>                    					 						
                        <a href="javascript:void(0);" title="greek" class="food_icon_image_normal checkclass" rel="20"><img src="../../assets/images/food_icons/white/greek.png" height="30" alt=""/></a>
                        <a href="javascript:void(0);" title="grocery" class="food_icon_image_normal checkclass" rel="21"><img src="../../assets/images/food_icons/white/grocery.png" height="30" alt=""/></a>                    	
                        <a href="javascript:void(0);" title="indian" class="food_icon_image_normal checkclass" rel="22"><img src="../../assets/images/food_icons/white/indian.png" height="30" alt=""/></a>                    	 						
                        <a href="javascript:void(0);" title="italian" class="food_icon_image_normal checkclass" rel="23"><img src="../../assets/images/food_icons/white/italian.png" height="30" alt=""/></a>
                        <a href="javascript:void(0);" title="japanese" class="food_icon_image_normal checkclass" rel="24"><img src="../../assets/images/food_icons/white/japanese.png" height="30" alt=""/></a>                    	
                        <a href="javascript:void(0);" title="market" class="food_icon_image_normal checkclass" rel="25"><img src="../../assets/images/food_icons/white/market.png" height="30" alt=""/></a>                    	 						
                        <a href="javascript:void(0);" title="meat" class="food_icon_image_normal checkclass" rel="26"><img src="../../assets/images/food_icons/white/meat.png" height="30" alt=""/></a>
                        <a href="javascript:void(0);" title="mexican" class="food_icon_image_normal checkclass" rel="27"><img src="../../assets/images/food_icons/white/mexican.png" height="30" alt=""/></a>                    	
                        <a href="javascript:void(0);" title="no-reserve" class="food_icon_image_normal checkclass" rel="28"><img src="../../assets/images/food_icons/white/no-reserve.png" height="30" alt=""/></a>                    	
                        <a href="javascript:void(0);" title="organic" class="food_icon_image_normal checkclass" rel="29"><img src="../../assets/images/food_icons/white/organic.png" height="30" alt=""/></a>                    	
                        <a href="javascript:void(0);" title="others" class="food_icon_image_normal checkclass" rel="30"><img src="../../assets/images/food_icons/white/others.png" height="30" alt=""/></a>                    	 						
                        <a href="javascript:void(0);" title="pizza" class="food_icon_image_normal checkclass" rel="31"><img src="../../assets/images/food_icons/white/pizza.png" height="30" alt=""/></a>
                        <a href="javascript:void(0);" title="pizza_cook" class="food_icon_image_normal checkclass" rel="32"><img src="../../assets/images/food_icons/white/pizza-cook.png" height="30" alt=""/></a>                    	
                        <a href="javascript:void(0);" title="reserve_suggest" class="food_icon_image_normal checkclass" rel="33"><img src="../../assets/images/food_icons/white/reserve_suggest.png" height="30" alt=""/></a>                    	
                        <a href="javascript:void(0);" title="reserved" class="food_icon_image_normal checkclass" rel="34"><img src="../../assets/images/food_icons/white/reserved.png" height="30" alt=""/></a>                    	
                        <a href="javascript:void(0);" title="salad" class="food_icon_image_normal checkclass" rel="35"><img src="../../assets/images/food_icons/white/salads.png" height="30" alt=""/></a>
                        <a href="javascript:void(0);" title="seafood" class="food_icon_image_normal checkclass" rel="36"><img src="../../assets/images/food_icons/white/seafood.png" height="30" alt=""/></a>                    	
                        <a href="javascript:void(0);" title="sportbar" class="food_icon_image_normal checkclass" rel="37"><img src="../../assets/images/food_icons/white/sportsbar.png" height="30" alt=""/></a>                    	
                        <a href="javascript:void(0);" title="steak" class="food_icon_image_normal checkclass" rel="38"><img src="../../assets/images/food_icons/white/streak.png" height="30" alt=""/></a>
                        <a href="javascript:void(0);" title="desserts" class="food_icon_image_normal checkclass" rel="39"><img src="../../assets/images/food_icons/white/subs.png" height="30" alt=""/></a>
                        <a href="javascript:void(0);" title="sushi" class="food_icon_image_normal checkclass" rel="40"><img src="../../assets/images/food_icons/white/sushi.png" height="30" alt=""/></a>
                        <a href="javascript:void(0);" title="take-out" class="food_icon_image_normal checkclass" rel="41"><img src="../../assets/images/food_icons/white/takeaway.png" height="30" alt=""/></a>                    	
                        <a href="javascript:void(0);" title="thai" class="food_icon_image_normal checkclass" rel="42"><img src="../../assets/images/food_icons/white/thai.png" height="30" alt=""/></a>
                        <a href="javascript:void(0);" title="veg" class="food_icon_image_normal checkclass" rel="43"><img src="../../assets/images/food_icons/white/veg.png" height="30" alt=""/></a>                        
                    </div>
                    <br clear="all" />
                    <p>
                      <label for="ad_text_fromshowad">Ad Details</label>
                      <textarea id="ad_text_fromshowad" class="dashboard_editor_textarea" name="ad_text_fromshowad"></textarea>
                      <?php echo display_ckeditor($ckeditor_fromshowad); ?> </p>
                    <p>
                      <label for="text_message_fromshowad" style="width:150px; float:left; display:block; padding-right:10px;">Text Message</label>
                      <textarea rows="10" cols="45" style="width: 425px; height: 150px" id="text_message_fromshowad" name="text_message_fromshowad"></textarea>
                    </p>                    
                    <?=form_close()?>
                    <button onclick="saveAdfromshowad($(this).prev('form'))">Save</button>
                    <button <?php /*?>onclick="CancelAdEdit()"<?php */?> onclick="cancel_add_edit($(this).prev('form'))">Cancel</button>
              	</div>
				<div id ="ad_display"> </div>
			</div><!-- Advertisement Part End-->
            
			<!-- Announcements Part Start-->
            <h3><a style="float:left;" href="#" onclick="showallannouncement('all');">Announcements & Organization (Zone: <?=$zone->name?>, Zone Id: <?=$zone_id?>) </a><div style="float:right; margin:7px 10px 0 30px; color:#FFF">Step: 8 </div></h3>
			<div>
            	<div style="background-color: #808080; height:30px;"> 
					<div style="padding:5px 25px; float:left;"><a href="javascript:void()" onclick="newAnnouncement();">New Announcement</a></div>
					<div style="padding:5px 25px; float:left;"><a href="javascript:void()" onclick="showallannouncement('all');" class="showall">Show Announcement</a></div>
                    <div style="padding:5px 25px;float:left;"><a href="javascript:void()" onclick="newOrganization();">Add New Organization</a></div>
                    <div style="padding:5px 25px;"><a href="javascript:void()" onclick="showallorganization();" class="showall_org">View Organization</a></div>
				</div>
                
                <div id="announcements_category_type">
                <select name="announcements_category" id="announcements_category">
				  <option value="0">Announcements by me</option>
				  <option value="1">Announcements by organization</option>
				</select>
				<select name="announcements_type" id="announcements_type">
				  <option value="0">New Announcements</option>
				  <option value="1">Active Announcements</option>
				  <option value="-1">Inactive Announcements</option>				  
				</select>
				<button class="showallannouncement" onclick="showallannouncement('all');">Show Announcements</button><br />
                <a href="javascript:void()" onclick="showallannouncement('a');" class="alphabet">a</a>
                <a href="javascript:void()" onclick="showallannouncement('b');" class="alphabet">b</a>
                <a href="javascript:void()" onclick="showallannouncement('c');" class="alphabet">c</a>
                <a href="javascript:void()" onclick="showallannouncement('d');" class="alphabet">d</a>
                <a href="javascript:void()" onclick="showallannouncement('e');" class="alphabet">e</a>
                <a href="javascript:void()" onclick="showallannouncement('f');" class="alphabet">f</a>
                <a href="javascript:void()" onclick="showallannouncement('g');" class="alphabet">g</a>
                <a href="javascript:void()" onclick="showallannouncement('h');" class="alphabet">h</a>
                <a href="javascript:void()" onclick="showallannouncement('i');" class="alphabet">i</a>
                <a href="javascript:void()" onclick="showallannouncement('j');" class="alphabet">j</a>
                <a href="javascript:void()" onclick="showallannouncement('k');" class="alphabet">k</a>
                <a href="javascript:void()" onclick="showallannouncement('l');" class="alphabet">l</a>
                <a href="javascript:void()" onclick="showallannouncement('m');" class="alphabet">m</a>
                <a href="javascript:void()" onclick="showallannouncement('n');" class="alphabet">n</a>
                <a href="javascript:void()" onclick="showallannouncement('o');" class="alphabet">o</a>
                <a href="javascript:void()" onclick="showallannouncement('p');" class="alphabet">p</a>
                <a href="javascript:void()" onclick="showallannouncement('q');" class="alphabet">q</a>
                <a href="javascript:void()" onclick="showallannouncement('r');" class="alphabet">r</a>
                <a href="javascript:void()" onclick="showallannouncement('s');" class="alphabet">s</a>
                <a href="javascript:void()" onclick="showallannouncement('t');" class="alphabet">t</a>
                <a href="javascript:void()" onclick="showallannouncement('u');" class="alphabet">u</a>
                <a href="javascript:void()" onclick="showallannouncement('v');" class="alphabet">v</a>
                <a href="javascript:void()" onclick="showallannouncement('w');" class="alphabet">w</a>
                <a href="javascript:void()" onclick="showallannouncement('x');" class="alphabet">x</a>
                <a href="javascript:void()" onclick="showallannouncement('y');" class="alphabet">y</a>
                <a href="javascript:void()" onclick="showallannouncement('z');" class="alphabet">z</a>
                </div>
                
				<div id="showannouncement"></div>
               <!-- <div id="showorganization"></div>-->
                <div id="showorganizationdetail"></div>
				<div id="annoucement_edit" style="display:none;">
					<input type="hidden" id="announcement_id" name="announcement_id" value="-1"/>
				  	<input type="hidden" id="announcement_zone" name="announcement_zone" value="<?=$zone->id?>"/>
                      <p>
                        <label for="announcement_title">Title</label>
                        <input type="text" id="announcement_title" name="announcement_title" />
                      </p>
                      <p>
                        <label for="announcement_text">Annoucement Text</label>
                        <textarea id="announcement_text" name="announcement_text"></textarea>
                        <?php echo display_ckeditor($ckeditor); ?> 
                      </p>
                      <p>
                        <label for="announcementtype">Is this an emergency announcement?</label>
                        <select id="announcementtype" name="announcementtype">
                        <option value="0" >No</option>
                        <option value="1">Yes</option> 
                        </select>
                      </p>
				  	<button onclick="SaveAnnouncement()">Save</button>
				  	<button onclick="HideAnnouncementEditor()">Back To Announcements</button>
				</div>
                <!-- New Organization part start-->
                <div id="organization" style="display:none;">
                	<input type="hidden" id="organization_id" name="organization_id" value="-1"/>
				  	<input type="hidden" id="organization_zone" name="organization_zone" value="<?=$zone->id?>"/>
                    <p>
                   <strong> When the organization name is typed in, the username should automatically generate based on the first 8 characters of the organization name and 6 random numbers.</strong>
                    </p>
                    <p>
                    <strong>Clicking on 'Generate Password', it should generate a random alpha-numeric password and display it in the password textbox.</strong>
                    </p>
                    <p>
                    <strong>Organization Username and Zone Username cannot be same.</strong>
                    </p>
                    <p id="change_pwd" style="display:none;">
                    <strong>Password can't be display.</strong>
                    </p>
                    <p>
                    	<label for="organization_name" style="width:150px; float:left; display:block; padding-right:10px;" >Organization Name</label>
                    	<input type="text" id="organization_name" name="organization_name" onblur="create_random_username(this)"/>
                    </p>
                    <p>
                    <label for="organization_name" style="width:150px; float:left; display:block; padding-right:10px;" >Organization Type</label>
                    <input type="radio" id="organization_type" name="organization_type" value="1" checked="checked" />Municipality
                    <input type="radio" id="organization_type" name="organization_type" value="0" />Normal
                    </p>
                    <p class="organization_email">
                    	<label for="organization_email" style="width:150px; float:left; display:block; padding-right:10px;">Email Address</label>
                    	<input type="text" id="organization_email" name="organization_email" />
                    </p>
                    <p class="organization_username">
                    	<label for="organization_username" style="width:150px; float:left; display:block; padding-right:10px;">Username</label>
                    	<input type="text" id="organization_username" name="organization_username" onblur="check_org_username();"/>
                    </p>
                    <span id="error_org_uname" style="margin:0 0 8px 160px; background:#F00; font-weight:bold; color:#fff; padding:3px; width:380px; display:block; text-align:center"></span>                  
                    <p class="organization_password">
                    	<label for="organization_password" style="width:150px; float:left; display:block; padding-right:10px;">Password</label>
                    	<input type="text" id="organization_password" name="organization_password"/><button onclick="create_generate_password()">Generate Password</button>
                    </p>                     
                    <button onclick="SaveOrganization()">Save Organization</button>
				  	<button onclick="HideAnnouncementEditor_org()">Back To Organization</button>
                </div>
                
                
                
                
            </div>
            
            
            <!-- Announcements Part End-->
			<!-- Zone Managers Part Start-->
             <!-- Zone Managers Part End-->
            <!-- Municipal Owners Part Start-->
			<!-- Municipal Owners Part End-->
            
			<!-- Bulk Email Part Start-->
            <h3><a style="float:left;" href="#">Bulk Email (Zone: <?=$zone->name?>, Zone Id: <?=$zone_id?>) </a><div style="float:right; margin:7px 10px 0 30px; color:#FFF">Step: 9 </div></h3>
			<div><div id="bulk_email"> <?php echo $templates;?> </div>
            <div id="body_email" style="display:none;">
            <input type="hidden" id="eids" name="eids" value=""/>
             <p>
              <label for="email_subject" style="width:150px; float:left; padding-right:10px;">Subject</label>
              <input type="text" id="email_subject" name="email_subject" style="width:425px;"/>
             </p>
             <p>
               <label for="text_message_email" style="width:150px; float:left; display:block; padding-right:10px;">Text Message</label>
               <textarea rows="10" cols="45" style="width: 425px; height: 150px" id="text_message_email" name="text_message_email"></textarea>
             </p> 
             <button class="sendmail" onclick="sendallemail();" style="margin-left:160px;">Send Mail</button><button class="back" onclick="email_back();" style="margin-left:10px;">Back</button>
            </div>
            </div><!-- Bulk Email Part End-->
			<!-- Marketting Materials Start -->
            <h3><a style="float:left;" href="#" onclick="show_market_materials(<?=$zone_id?>);">Marketing Materials Shared By Zone Owners (Zone: <?=$zone->name?>, Zone Id: <?=$zone_id?>) </a><div style="float:right; margin:7px 10px 0 30px; color:#FFF">Step: 10 </div></h3>
             <div><div id ="marketting_materials">
             <div style="background-color: #808080; height:30px;"> 
					<div style="padding:5px 25px; float:left;"><a href="javascript:void()" onclick="add_mm(<?=$zone_id?>);" class="showall">Upload Marketing Materials</a></div>
					<!--<div style="padding:5px 25px; float:left;"><a href="javascript:void()" onclick="view_mm(<?=$zone_id?>);" class="showall_mm">View Uploaded Marketing Materials</a></div>                    
			<div style="padding:5px 25px; float:left;"><a href="javascript:void()" onclick="view_mm_default(<?=$zone_id?>);" class="showall_mm">Default Marketing Materials</a></div>-->
            <div style="padding:5px 25px; float:left;"><a href="javascript:void()" onclick="view_all_mm(<?=$zone_id?>);" class="showall_mm">Library of Uploaded Marketing Materials</a></div>
            </div>
            <div id="add_mm" style="display:none">				
				<?=form_open_multipart("dashboards/save_mm", "name='mm_form' id='mm_form'");?>
                
                <input type="hidden" id="iszoneid" value="<?=$zone->id?>"/>
                
                <p >
                      <label for="mm_name" style="width:150px; float:left; display:block; padding-right:10px;">Material Name</label>
                      <input type="text" id="mm_name" name="mm_name"/>
                    </p>
                    
                
                <p>
                <label for="mm_file" style="width:150px; float:left; display:block; padding-right:10px;">Matarial File Name</label>
                <input type="file" id="<?=$zone_id?>" name="<?=$zone_id?>" onchange="return upload_Image('<?=$zone_id?>','<?php echo site_url("dashboards/upload_mar_mat/".$zone_id."/mm_form");?>','mm_form');"/>
                <p>Allowed  formats : (<?php echo strtoupper('docx|doc|pdf');?>)</p>
                <p>Max Size : ( 1 MB)</p>
                <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                <div id="market">
                  <input type="hidden" id="ups_mm" name="ups_mm" />
                </div>
                <!--<p id="docs_pdf_show" style="display:none;">
                  <label for="ad_name_fromshowad" style="width:150px; float:left; display:block; padding-right:10px;">Upload File</label>
                  <label id="docs_pdf_1" name="docs_pdf_1"></label>
                </p>-->
                </p>
                <p>
                      <label for="mm_desc" style="width:150px; float:left; display:block; padding-right:10px;">Description</label>
                      <textarea rows="10" cols="45" style="width: 425px; height: 150px" id="mm_desc" name="mm_desc"></textarea>
                    </p> 
                    
                <?=form_close()?>
                <button onclick="save_mm($(this).prev('form'))">Save</button>
            </div>
            <div id ="mm_display_dropdown"> </div>
            <div id ="all_mm_display"></div>
            <div id ="mm_display"> </div>  
             	<div id="view_mm" style="display:none">
             	<div class="letters_to_muni" >
                	<img src="../../assets/images/download_icon.png" height="62" width="62" alt=""/>
                	<p><span>Download</span><br /><a href="<?=base_url('download/municipality')?>" target="_blank">Letter to the Municipality.docx</a></p>
                </div>
                <div class="letters_to_busi" >
                	<img src="../../assets/images/download_icon.png" height="62" width="62"  alt=""/>
                	<p><span>Download</span><br /><a href="<?=base_url('download/new_business_added')?>" target="_blank">Letter to New Business Added.docx</a></p>
                </div>
             	<div class="letters_to_muni" >
                	<img src="../../assets/images/download_icon.png" height="62" width="62" alt=""/>
                	<p><span>Download</span><br /><a href="<?=base_url('download/sales_info')?>" target="_blank">Savings Sites Sales Info 1_16_13.docx</a></p>
                </div>
                <div class="letters_to_busi" >
                	<img src="../../assets/images/download_icon.png" height="62" width="62"  alt=""/>
                	<p><span>Download</span><br /><a href="<?=base_url('download/local_advertising')?>" target="_blank">Comparison of Local Advertising.xlsx</a></p>
                </div> 
                </div>               
             </div></div>
            <!-- Marketting Materials End -->
            <!-- Export Business Start -->
            <h3><a style="float:left;" href="javascript:void()" onclick="exportbusiness(<?=$zone_id?>);">Export Businesses (Zone: <?=$zone->name?>, Zone Id: <?=$zone_id?>)</a><div style="float:right; margin:7px 10px 0 30px; color:#FFF">Step: 11 </div></h3>
            <div><div id ="export_business"> </div></div>
            <!-- Export Business End -->
            <!-- Statistics Part Start-->
			<h3><a style="float:left;" href="#">Zone Statistics (Zone: <?=$zone->name?>, Zone Id: <?=$zone_id?>) </a><div style="float:right; margin:7px 10px 0 30px; color:#FFF">Step: 12 </div></h3>
			<div>
                <div id="show_stats">                 
                  Coming Soon                  
                </div>
            </div><!-- Statistics Part End-->
            <!-- User Info Part Start-->
            <h3><a style="float:left;" href="#" onclick="getUserInformation();">Zone Owner Information (Zone: <?=$zone->name?>, Zone Id: <?=$zone_id?>)</a><div style="float:right; margin:7px 10px 0 30px; color:#FFF">Step: 13 </div> </h3>
			<div>
            	<div style="background-color: #808080; height:30px;"> 
					<div style="padding:5px 25px; float:left;" class="userinfo"><a href="javascript:void()" onclick="getUserInformation();">Zone Owner Information</a></div>
					<div style="padding:5px 25px;"><a href="javascript:void()" onclick="getUserPassword();">Zone Owner Password</a></div>
					<div id="userInfo"></div>
					<div id="userPassword"></div>
				</div>
            </div> <!-- User Info Part End-->
            
		</div>
	</div>
</div>
<div id="contactOwnerDialog"> </div>
<div id="dialog-form-businesstype" title="Select type of business" style="display:none" >
	<input type="hidden" id="temp_busid" />
    <input type="hidden" id="temp_zoneid" />
    <input type="hidden" id="temp_option" />
    <input type="hidden" id="temp_business_zone" />
    <input type="hidden" id="temp_show_bus_type" />
    
	<table width="100%" border="0" cellspacing="2" cellpadding="1">
	  <tr>
	    <td><div id="radio">
		<input type="radio" id="radio1" name="radio" value="1" /><label for="radio1">Paid</label>&nbsp;&nbsp;&nbsp;
		<input type="radio" id="radio2" name="radio"  value="2" /><label for="radio2">Trial</label>
	</div></td>
      </tr>
  </table>
</div>

<div id="dialog-form-businesstype_listed" title="Select type of business" style="display:none" >
	<input type="hidden" id="temp_busid" />
    <input type="hidden" id="temp_zoneid" />
    <input type="hidden" id="temp_option" />
    <input type="hidden" id="temp_business_zone" />
    <input type="hidden" id="temp_show_bus_type" />
    
	<table width="100%" border="0" cellspacing="2" cellpadding="1">
	  <tr>
	    <td><div id="radio">
		<input type="radio" id="radio1" name="radio" value="1" /><label for="radio1">Paid</label>&nbsp;&nbsp;&nbsp;
		<input type="radio" id="radio2" name="radio"  value="2" /><label for="radio2">Trial</label>
	</div></td>
      </tr>
  </table>
</div>

<!--<div id="email-box" class="email-popup"> <a href="javascript:void(0)" class="close"><img src="<?=base_url("assets/images/close_pop.png")?>" class="btn_close" title="Close Window" alt="Close" /></a>
    <form id="formaccountverify" class="post" method="post" action="#" enctype="multipart/form-data">
       
        <label for="email" class="label">Email:</label>
        <input type="email" name="email" id="email" value="" class="textfield" required/>
       
        <input type="submit" id="submit1" name="submit1" value="Submit" class="button"/>
    </form>
</div>-->
<script type="text/javascript" src="<?=base_url('assets/ckeditor/adapters/jquery.js')?>"></script>
<!--<script type="text/javascript" src="<?=base_url('assets/scripts/timeout-dialog.js')?>"></script>-->
<script type="text/javascript">



//function check123(){ //alert(1); return false;
/*function ses_timeout(){
$.timeoutDialog({
      timeout: 5, 
      countdown: 10, 
      logout_redirect_url: 'http://google.com'
});
}
setInterval(function() {
           ses_timeout();
        }, 10000);*/

var default_zone = <?=$zone->id?>;
var temp_zone_id = <?=$zone->id?>;
$("#accordion" ).accordion({autoHeight:false});

$("#business_zone").show();
//$("#show_bus_type").show();
/* ---- */
$("#foodimage").val('');
$('.checkclass').click(function(){	
	if($(this).hasClass('food_icon_image_normal')){
		$(this).removeClass('food_icon_image_normal');
		$(this).addClass('food_icon_image_selected');		
	}else if($(this).hasClass('food_icon_image_selected')){
		$(this).removeClass('food_icon_image_selected');
		$(this).addClass('food_icon_image_normal');
	}	
	var val=$(this).attr('rel');
	var food_image_all_values='';		
	$('.food_icon_image_selected').each(function(i,item){ //alert(2);
		food_image_all_values+=$(this).attr('rel')+',';
	});			
	food_image_all_values=food_image_all_values.substring(0,food_image_all_values.length-1);
	//alert(display_checkbox);
	$("#foodimage").val(food_image_all_values);
});


$("select[id='ad_subcategory_fromshowad']").live("change", function() { 
	var total_selected=$(this).find('option:selected').length;
	if(total_selected>2){ 
		$(this).find('option:selected:last').removeAttr('selected');		
	}       
});

/*  ---- */


/* Zone Data part Start */
$("#zoneNameEdit").hide();
$("#zoneNameEditButtons").hide();
$("#success_zname").hide();
$("#error_zname").hide();

$("#canceledit").hide();
$("#savezone").hide();
var zone_id = <?=$zone->id?>;
var create_biz = 0;
function editName(){ // For rename zone
	var zname='<?=$zone->name?>';
	//alert(zname);
	if($("#zoneName").val()==''){
		$("#zoneName").val(zname);
	}
	$("#zoneNameEdit").show();
	$("#zoneNameDisplay").hide();	
	//$("#zoneNameEditButtons").hide();
	$("#canceledit").show();
	$("#createzone").hide();
	$("#deletezone").hide();
	
	$("#success_zname").hide();
	$("#error_zname").hide(); //zoneNameEditButtons
}
function newZone(){ // for create new zone 
	$("#zoneNameEdit").show();
	$("#zoneNameDisplay").hide();
	//$("#zoneNameEditButtons").show();
	$("#canceledit").show();
	//$("#savezone").show();
	$("#renamezone").hide();
	$("#deletezone").hide();
	
	$("#success_zname").hide();
	$("#error_zname").hide();
	$("#zoneName").val("");
	zone_id = -1;
}
function cancelEditName(){
	$("#zoneNameEdit").hide();
	$("#zoneNameDisplay").show();
	//$("#zoneNameEditButtons").hide();
	$("#createzone").show();
	$("#renamezone").show();
	$("#deletezone").show();
	$("#canceledit").hide();
	$("#savezone").hide();
	$("#success_zname").hide();
	$("#error_zname").hide();
}
function saveZoneName(){ //alert(zone_id);	
	//alert(1); return false;
	var tempZone = zone_id;	
	if(create_biz == 1){	
		tempZone = -1;
	}
	
	var aaa=$('#zoneName').val(); //alert(aaa); return false;
	if(aaa==''){
		alert('Please specify a zone name');
		return false;
	}
	//alert(aaa); return false;
	var data = { "zone_id": tempZone, "zone_name": aaa};
	$("#zoneNameDisplay").html(aaa);
	$("#zoneNameEdit").hide();
	$("#zoneNameDisplay").show();
	//$("#zoneNameEditButtons").hide();
	var title = "Renaming Zone";
	if(tempZone == -1) { title = "Creating Zone";}
	PageMethod("<?=base_url('dashboards/renameZone')?>", title, data, tempZone == -1 ? NewZoneSaved : null, null);
	$.unblockUI();
	$('#error_zname').hide();
	$('#success_zname').hide();
	$('#createzone').show();
	$('#renamezone').show();
	$('#deletezone').show();
	$('#savezone').hide();
	$('#canceledit').hide();
	
}

function NewZoneSaved(result){
	window.location.href = "<?=base_url('dashboards/zone')?>" + "/" + result.Tag;
}
<? if(!empty($my_zones) && count($my_zones) > 1){?>
    $("#myZones").change(function(){
        var zid = $(this).val();
        if(zid == -1){return;}
        window.location.href = "<?=base_url('dashboards/zone')?>/" + zid;
        });
    <? }?>
	
function zone_verification(){ //alert(1); return false;
	var tempZone = zone_id;
	var zonename=$('#zoneName').val();
	if(zonename==''){
		alert('Please specify a zone name');
		return false;
	}
	var data = { "zone_name": zonename};
	PageMethod("<?=base_url('dashboards/check_zonename')?>", "Verify the zone name <br/>This may take a few minutes", data, showzonename, null);
	
}
function showzonename(result){
	$.unblockUI();
	if(result.Tag==''){
		$('#error_zname').html('This zone name is already exist. Please try with another zone name.' );
		$('#error_zname').show();
		$('#success_zname').hide();
		$('#zoneName').val('');
		
	}else{
		$('#success_zname').html('Thank You. "'+result.Tag+ '" is available.');
		$('#success_zname').show();
		$('#error_zname').hide();
		//$("#zoneNameEditButtons").show();
		$("#savezone").show();
	}
}
function deleteZone(zid){
	window.location.href = "<?=base_url('auth/deleteZone')?>" + "/" + zid;
}
/* Zone Data Part End */
/*  User Information Part Start */
function getUserInformation(){
	PageMethod("<?=base_url('dashboards/getUserInformation')?>", "Display The User Information...<br/>This may take a few minutes", null, showUserInformation, null);
}
function showUserInformation(result){
	$.unblockUI();
	if(result.Tag!=''){
		$("#userPassword").hide();
		$("#userInfo").show();
		$("#userInfo").html(result.Tag);
	}
}
function getUserPassword(){
	PageMethod("<?=base_url('dashboards/getUserPassword')?>", "Display The User Password...<br/>This may take a few minutes", null, showUserPassword, null);
}
function showUserPassword(result){
	$.unblockUI();
	if(result.Tag!=''){	
		$("#userInfo").hide();
		$("#userPassword").show();
		$("#userPassword").html(result.Tag);
	}
}
function UpdateProfile() { 
	var dataToUse = {
		"userid":$('#userid').val(),
		"email":$('#jform_Email').val(),
		"firstname":$('#jform_Firstname').val(),
		"lastname":$('#jform_Lastname').val(),
		"phone":$('#jform_Phone').val(),
		"address":$('#jform_Address').val(),
		"city":$('#jform_City').val(),
		"state":$('#jform_State').val(),
		"zip":$('#jform_Zip').val()
	};
    PageMethod("<?=base_url('dashboards/update_profile')?>", "Saving Profile<br/>This may take a minute.", dataToUse, null, null);       
}
function UpdatePassword(){
	 var dataToUse = {
		"userid":$('#userid').val(),
		"current_pass":$('#current_pass').val(),
		"new_pass":$('#new_pass').val(),
		"confirm_pass":$('#confirm_pass').val()
	 };
	  PageMethod("<?=base_url('dashboards/update_password')?>", "Saving New Password<br/>This may take a minute.", dataToUse, null, null);
}
/*  User Information Part End */
/* Zip Codes Related Part Start*/
function zipcodes_display(zoneid,uid){
	var dataToUse = {
		"zoneid":zoneid,
		"uid":uid,
	}
	PageMethod("<?=base_url('dashboards/zipcode_display')?>", "Display the zip codes of this zone...<br/>This may take a few minutes", dataToUse, requestZipSuccess, null);
}
function requestZipSuccess(result){
	$.unblockUI();
	if(result.Tag!=''){	
		$("#zip_codes").html(result.Tag);
	}
}
function addZipToZone(zoneId) {
	var zip_id = $("#zipToAdd").val();
	var data = { "zone_id": zoneId, "zipcode": zip_id };
	PageMethod("<?=base_url('dashboards/addZipToZone')?>", "Add zip code to this zone...<br/>This may take a few minutes", data, UpdateZips, null);

}
function UpdateZips(result) {
    $.unblockUI();
    $("#zip_codes").html(result.Tag);	
}
function removeZipFromZone(zip, zoneId, title) {
	var dataToUse = { "id": zoneId, "zipcode": zip };
	ConfirmDialog("Really remove : " + title + " from this zone?", "Remove Zip Code From This Zone", "<?=base_url('dashboards/removeZipFromZone')?>",
			"Remove zip code from this zone<br/>This may take a few minute", dataToUse, UpdateZips, null);
}
/* Zip Codes Related Part End*/
/* Category Related Part Start*/
function add_category(zoneid){ 
	var dataToUse = {
		"zoneid":zoneid
	}
	PageMethod("<?=base_url('dashboards/add_new_cat_zone')?>", "Open the add new category form...<br/>This may take a few minutes", dataToUse, requestZoneAddCategorySuccess, null);
}
function requestZoneAddCategorySuccess(result){
	$.unblockUI();
	if(result.Tag!=''){	
		$("#new_cat").html(result.Tag);
		$("#edit_cat").html('');
		$("#new_subcat").html('');
		$("#edit_subcat").html('');		
	}
}

function save_category(){	
	if($('#category_name').val()==''){
		alert("Please enter category.");
		return false;
	}else if($('#sub_category_name').val()==''){
		alert("Please enter sub category.");
		return false;
	}
	var dataToUse = {
		"zone_id":$('#zone_id').val(),
		"cat_name":$('#category_name').val(),		
		"sub_cat_name":$('#sub_category_name').val()
	 };	
	PageMethod("<?=base_url('dashboards/save_category_zone')?>", "Saving the new category...<br/>This may take a few minutes", dataToUse, requestcategorySuccess, null);
}
function requestcategorySuccess(result){
	//alert(JSON.stringify(result));
	$.unblockUI();
	$("#category_name").val('');
	$("#sub_category_name").val('');
	$("#msg").html(result.Message);
}

function add_sub_category($zoneid){ //alert($zoneid);
	var dataToUse = {
		"zoneid":$zoneid
	}
	PageMethod("<?=base_url('dashboards/add_new_subcat_zone')?>", "Open the add new sub category form...<br/>This may take a few minutes", dataToUse, requestZoneAddCategorySuccess, null);
}
function requestZoneAddCategorySuccess(result){
	$.unblockUI();
	if(result.Tag!=''){	
		$("#new_subcat").html(result.Tag);
		$("#edit_cat").html('');		
		$("#new_cat").html('');
		$("#edit_subcat").html('');		
	}
}

function save_subcategory(){	
	if($('#sub_category_name').val()==''){
		alert("Please enter sub category.");
		return false;
	}
	var dataToUse = {
		"zone_id":$('#zone_id').val(),
		"cat_name":$('#category_select').val(),		
		"sub_cat_name":$('#sub_category_name').val()
	 };	
	PageMethod("<?=base_url('dashboards/save_subcategory_zone')?>", "Saving the new sub category...<br/>This may take a few minutes", dataToUse, requestsubcategorySuccess, null);
}
function requestsubcategorySuccess(result){
	$.unblockUI();
	$("#msg").html(result.Message);
	$("#sub_category_name").val('');
}

function edit_category($zoneid){
	var dataToUse = {
		"zoneid":$zoneid
	}
	PageMethod("<?=base_url('dashboards/edit_category_display')?>", "Display The Categories...<br/>This may take a few minutes", dataToUse, requestEditCategorySuccess, null);
}
function requestEditCategorySuccess(result){	
	$.unblockUI();
	if(result.Tag!=''){	
		$("#edit_cat").html(result.Tag);
		$("#new_subcat").html('');
		$("#new_cat").html('');
		$("#edit_subcat").html('');		
	}
}
function individual_checkbox(){ 
	var total_checkbox=$("input[name=check]").length ;
	var total_checked_checkbox=$("input[name=check]:checked").length; //alert(total_checkbox); alert(total_checked_checkbox);
	if(total_checkbox!=total_checked_checkbox){ 
		 $('#select_all_category').attr('checked', false);		
	}else if(total_checkbox==total_checked_checkbox){
		 $('#select_all_category').attr('checked', true);		
	}	
}
function select_all_category(ele){ 
	checkboxes = document.getElementsByTagName("input");//get main check box
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
	}
}

//function save_display_category(zoneid,type){ //alert(1); return false;
//	var display_checkbox='';		
//	$("input[name=check]:Checked").each(function(i,item){ //alert(2);
//		display_checkbox+=$(item).val()+',';
//	});			
//	display_checkbox=display_checkbox.substring(0,display_checkbox.length-1);
//	
//	/*var display_checkbox_all_zone='';		
//	$("input[name=check1]:Checked").each(function(i,item){ //alert(2);
//		display_checkbox_all_zone+=$(item).val()+',';
//	});			
//	display_checkbox_all_zone=display_checkbox_all_zone.substring(0,display_checkbox_all_zone.length-1);*/
//	/*$('#this_zone').val(display_checkbox_this_zone);
//	$('#all_zone').val(display_checkbox_all_zone);	*/
//	//alert(display_checkbox_this_zone); alert(display_checkbox_all_zone);  return false;
//	/*if(type==2){ 
//		var zoneids=$('#all_my_zone').val();
//	}else if(type==1){
//			var zoneids=zoneid;
//	}*/
//	
//	var my_all_zone=$('#all_my_zone').val();
//	var my_current_zone=$('#my_current_zone').val();
//	// alert(zoneids); return false;
//	//alert(display_checkbox); /*alert(zoneids);  alert(type);*/return false;
//	
//	dataToUse={	"catid":display_checkbox,				
//				"my_current_zone":my_current_zone,
//				"my_all_zone":my_all_zone,
//				"type"
//	}
//	PageMethod("<?php /*?><?=base_url('dashboards/save_zone_cat_display')?><?php */?>", "Saving Categories for display<br/>This may take a minute.", dataToUse, requestEditCategorySuccess, null);
//}
function save_display_category(zoneid){ //alert(1); return false;
	var display_checkbox='';		
	$("input[name=check]:Checked").each(function(i,item){ //alert(2);
		display_checkbox+=$(item).val()+',';
	});			
	display_checkbox=display_checkbox.substring(0,display_checkbox.length-1);	
	//alert(display_checkbox); alert(zoneid); return false;
	
	dataToUse={	"catid":display_checkbox,
				"zoneid":zoneid
				
				
	}
	PageMethod("<?=base_url('dashboards/save_zone_cat_display')?>", "Saving Categories for display<br/>This may take a minute.", dataToUse, null, null);
}

function save_all_my_zone(){ //alert(1); return false; 
	/*var all_zones=$('#all_my_zone').val();
	var this_zones=$('#my_current_zone').val(); //alert(all_zones); alert(this_zones); return false;
	dataToUse={	"all_zone":all_zones				
	}
	PageMethod("<?=base_url('dashboards/save_cat_subcat_all_my_zone')?>", "Saving Categories/Subcategories to all my zone for display<br/>This may take a minute.", dataToUse, null, null);*/
	var all_zones=$('#all_my_zone').val();
	var dataToUse = { "all_zone": all_zones};
	
	ConfirmDialog1("Are you sure to display all categories/subcategories to all of your zones?", "Categories/Subcategories visibility to all my zone", "<?=base_url('dashboards/save_cat_subcat_all_my_zone')?>",
			"Apply To All My Zone<br/>This may take a minute", dataToUse, null, null);
}

function display_subcat($catid,$zoneid){
	var dataToUse = {
		"catid":$catid,
		"zoneid":$zoneid
	}
	PageMethod("<?=base_url('dashboards/edit_sub_category_display')?>", "Display The Sub Categories...<br/>This may take a few minutes", dataToUse, requestEditSubCategorySuccess, null);
}

function requestEditSubCategorySuccess(result){
	$.unblockUI();
	if(result.Tag!=''){	
		$("#edit_subcat").html(result.Tag);
		$("#edit_cat").html('');
		$("#new_subcat").html('');
		$("#new_cat").html('');
	}
}

function save_display_sub_category(catid,zoneid){
	
	var display_checkbox='';	
	$("input[name=check]:Checked").each(function(i,item){
		display_checkbox+=$(item).val()+',';
	});			
	display_checkbox=display_checkbox.substring(0,display_checkbox.length-1);
	//alert(catid); alert(zoneid); alert(display_checkbox); return false;
	dataToUse={	"subcatid":display_checkbox,
				"zoneid":zoneid,
				"catid":catid
				
	}
	PageMethod("<?=base_url('dashboards/save_zone_sub_cat_display')?>", "Saving Sub Categories for display<br/>This may take a minute.", dataToUse, null, null);
}
/* Category Related Part End */
/* BusinessPart Start */
function goto_business_dashboard(busid,zoneid){
	//alert(busid); alert(zoneid);
	window.location.href = "<?=base_url('dashboards/business')?>/" + busid+"/"+zoneid;
}
function individual_checkbox_business(){ 
	var total_checkbox=$("input[name=checkadfordelete]").length ;
	var total_checked_checkbox=$("input[name=checkadfordelete]:checked").length; //alert(total_checkbox); alert(total_checked_checkbox); return false; 
	if(total_checked_checkbox==1)
		$('#action_performed').show(); //return false;
	else if(total_checked_checkbox==0)
		$('#action_performed').hide(); //return false;
	if(total_checkbox!=total_checked_checkbox){ //alert(1);
		 $('#select_all_business').attr('checked', false);		
	}else if(total_checkbox==total_checked_checkbox){ //alert(2);
		 $('#select_all_business').attr('checked', true);		
	}	
}
function individual_checkbox_business_listed(){ 
	var total_checkbox=$("input[name=checkadfordelete_listed]").length ;
	var total_checked_checkbox=$("input[name=checkadfordelete_listed]:checked").length; //alert(total_checkbox); alert(total_checked_checkbox); return false; 
	if(total_checked_checkbox==1)
		$('#action_performed').show(); //return false;
	else if(total_checked_checkbox==0)
		$('#action_performed').hide(); //return false;
	if(total_checkbox!=total_checked_checkbox){ //alert(1);
		 $('#select_all_business').attr('checked', false);		
	}else if(total_checkbox==total_checked_checkbox){ //alert(2);
		 $('#select_all_business').attr('checked', true);		
	}	
}
function select_all_business(ele){ 
	checkboxes = document.getElementsByTagName("input");//get main check box
	if(ele.checked==true)//check main check box is checked or non checked
	{
		state = true;//set status
		$('#action_performed').show();
	}else{
		state = false;//set status
		$('#action_performed').hide();
	}
	for (i=0; i<checkboxes.length ; i++)//chck all other checkbox and set their status
	{
	  if (checkboxes[i].type == "checkbox") 
	  {
		checkboxes[i].checked=state;
	  }
	}
}
function change_status(val){ //5213
	//alert(val);
	$('#action_performed_in_where').hide();
	$('#business_active_paid_trial').hide();
	if(val==0){
		$('#action_performed_in_where').hide();
		$('#update').hide();
		$('#business_active_paid_trial').hide();
	}else {
		if(val==3){
		$('#action_performed_in_where').show();
		$('#business_active_paid_trial').hide();
		}else if(val==1){
		$('#action_performed_in_where').hide();
		$('#business_active_paid_trial').show();
		}
		
		$('#update').show();
		$('#action_performed_value').val(val);
	}
}
function action_update(){
	var all_zone=$('#all_my_zone').val();
	var zoneid =$('#my_current_zone').val();
	var business_zone_select_value=$("#business_zone").val();
	if(business_zone_select_value!=2){
		var business_type_select_value=$("#show_bus_type").val();
	}else{
		var business_type_select_value=5;
	}
	var action_performed=$('#action_performed_value').val(); 
	var action_performed_in_where=$('#action_performed_in_where').val();
	var business_active_paid_trial=$('#business_active_paid_trial').val();
	
	var display_checkbox='';		
	$("input[name=checkadfordelete]:Checked").each(function(i,item){ //alert(2);
		display_checkbox+=$(item).val()+',';
	});			
	display_checkbox=display_checkbox.substring(0,display_checkbox.length-1);	
	//alert(display_checkbox); alert(all_zone); alert(zoneid); return false;
	if(display_checkbox==''){
		alert('Please select Business.');
		return false;
	}
	
	//alert(business_zone_select_value); alert(business_type_select_value); alert(action_performed); alert(action_performed_in_where); alert(display_checkbox); return false;
	data={ busid:display_checkbox,
			zoneid:zoneid,
			allzoneid:all_zone,
			business_zone_select_value:business_zone_select_value,
			business_type_select_value:business_type_select_value,
			action_performed:action_performed,
			action_performed_in_where:action_performed_in_where,
			business_active_paid_trial:business_active_paid_trial
	}
	if(action_performed==3 && action_performed_in_where==0){
		ConfirmDialog("<b>All Selected Businesses and their all relative Ads of current Zone will be deleted permanently.<br/> If you Delete these, then selected businesses and related Ads cannot be returned backed In future.</b>", "Delete Business and Ads from this Zone", "<?=base_url('dashboards/action_performed_business')?>","Deleting...<br/>This may take a minute", data, requestZoneBusinessSuccess, null);
	}else if(action_performed==3 && action_performed_in_where==1){
		ConfirmDialog("<b>All Selected Businesses and their all relative Ads of current Zone will be deleted permanently.<br/> If you Delete these, then selected businesses and related Ads cannot be returned backed In future.</b>", "Delete Business and Ads from all Zone", "<?=base_url('dashboards/action_performed_business')?>","Deleting...<br/>This may take a minute", data, requestZoneBusinessSuccess, null);
	}else{
		PageMethod("<?=base_url('dashboards/action_performed_business')?>", "Action Performed...<br/>This may take a few minutes", data, requestZoneBusinessSuccess, null);
	}
	
}
function deletebusinessfromZone(){ 
	var all_zone=$('#all_my_zone').val();
	var zoneid =$('#my_current_zone').val();
	//var select_id=$("#show_ad_type").val();	
	//alert(select_id); return false;
	$('div.editbusinessform').html('');
	var business_zone_select_value=$("#business_zone").val();
	if(business_zone_select_value!=2){
		var business_type_select_value=$("#show_bus_type").val();
	}else{
		var business_type_select_value=5;
	}
	
	var display_checkbox='';		
	$("input[name=checkadfordelete]:Checked").each(function(i,item){ //alert(2);
		display_checkbox+=$(item).val()+',';
	});			
	display_checkbox=display_checkbox.substring(0,display_checkbox.length-1);	
	//alert(display_checkbox); alert(all_zone); alert(zoneid); return false;
	if(display_checkbox==''){
		alert('Please select Business.');
		return false;
	}
	param={ busid:display_checkbox,
			zoneid:zoneid,
			business_zone_select_value:business_zone_select_value,
			business_type_select_value:business_type_select_value
	}
	ConfirmDialog("<b>All Selected Businesses and their all relative Ads of current Zone will be deleted permanently.<br/> If you Delete these, then selected businesses and related Ads cannot be returned backed In future.</b>", "Delete Business and Ads from this Zone", "<?=base_url('dashboards/delete_business_ad_zone')?>","Deleting...<br/>This may take a minute", param, requestZoneBusinessSuccess, null);
}
function deletebusinessfromAllZone(){
	var all_zone=$('#all_my_zone').val();
	var zoneid =$('#my_current_zone').val();
	$('div.editbusinessform').html('');
	var business_zone_select_value=$("#business_zone").val();
	if(business_zone_select_value!=2){
		var business_type_select_value=$("#show_bus_type").val();
	}else{
		var business_type_select_value=5;
	}
	
	var display_checkbox='';		
	$("input[name=checkadfordelete]:Checked").each(function(i,item){ //alert(2);
		display_checkbox+=$(item).val()+',';
	});			
	display_checkbox=display_checkbox.substring(0,display_checkbox.length-1);	
	//alert(display_checkbox); alert(all_zone); alert(zoneid); return false;
	if(display_checkbox==''){
		alert('Please select Business.');
		return false;
	}
	param={ busid:display_checkbox,
			zoneid:zoneid,
			business_zone_select_value:business_zone_select_value,
			business_type_select_value:business_type_select_value
	}
	ConfirmDialog("<b>All Selected Businesses and their all relative Ads of current Zone will be deleted permanently.<br/> If you Delete these, then selected businesses and related Ads cannot be returned backed In future.</b>", "Delete Business and Ads from this Zone", "<?=base_url('dashboards/delete_business_ad_all_zone')?>","Deleting...<br/>This may take a minute", param, requestZoneBusinessSuccess, null);

}
function showBusiness(zone_id,charval,tag){ //alert(zone_id); //return false; april
	if(charval==''){
		charval='all';
	}
	//alert(charval); //return false;
	//var getvalue = $(this).find('a').attr('rel');
	var lowerlimit=''; var upperlimit=''; 
	var $this=$(tag);
	var limit=$this.attr('rel'); //alert(limit);
	if(limit=='' || limit==undefined){
		lowerlimit=0; upperlimit=2;
	}else{
		//alert (limit);
		limit_final=limit.split(',');
		lowerlimit=limit_final[0]; upperlimit=limit_final[1];
		
	}
	//alert(charval); 
	//alert(lowerlimit); alert(upperlimit);
	
	$('#bus_display').show();    
	$('div.editbusinessform').html('');
	//alert($("#business_zone").val()); alert($("#show_bus_type").val()); return false;
	var business_zone_select_value=$("#business_zone").val();
	if(business_zone_select_value!=2){
		var business_type_select_value=$("#show_bus_type").val();
		$('#show_bus_type').show();
	}else{
		var business_type_select_value=5;
	}
	if(business_zone_select_value==3){
		zone_id=-1;
	}
	
	//alert(business_zone_select_value); alert(business_type_select_value); alert(zone_id); alert(charval);
	
	
	var data={'business_zone':$('#business_zone').val()};
	PageMethod("<?=base_url('dashboards/display_business')?>/"+business_zone_select_value+"/"+business_type_select_value+"/"+zone_id+"/"+charval+"/"+lowerlimit+"/"+upperlimit, "Display The Businesses...<br/>This may take a few minutes", data, requestZoneBusinessSuccess, null);
    
}
function requestZoneBusinessSuccess(result){
	//alert(JSON.stringify(result));
	$.unblockUI();
	var limit=result.Message; //alert(limit);
	if(result.Tag!=''){
		
		$("#bus_display").html(result.Tag);
		$('#my_business_limit').attr('rel',limit);	
	}
}

//Edit business by zone owner
function showeditbusinessform(businessid,zoneid){ //alert(businessid); alert(zoneid); return false;
	var param={'businessid':businessid,'zoneid':zoneid};
	PageMethod("<?=base_url('dashboards/showeditbusinessform')?>", "Fetching business<br/>This may take a minute.", param, showeditbusinessformhtml, null);
}
	
function showeditbusinessformhtml(result){
	$('#bus_display').hide();
	$('#showbusiness').click();
	$('div.editbusinessform').html(result.Tag);
	 $.unblockUI();
	 var checkedval=$('[name=owner_account_type]:checked').val();
	 $.fn.showdiv(checkedval);
}

function showeditbusinessform_listed(businessid,zoneid){ //alert(2); return false;
	var param={'businessid':businessid,'zoneid':zoneid};
	PageMethod("<?=base_url('dashboards/showeditbusinessformListed')?>", "Fetching business<br/>This may take a minute.", param, listedshoweditbusinessformhtml, null);
}
	
function listedshoweditbusinessformhtml(result){
	$('#bus_display_listed').hide();  
	$('#showListedBusiness').click();
	$('div.editbusinessform_listed').html(result.Tag);
	 $.unblockUI();
	 var checkedval=$('[name=owner_account_type]:checked').val();
	 $.fn.showdiv(checkedval);
}

$.fn.showdiv=function(val){
	$('#owner_account_val').val(val);
	if(val==3){
		$('#existing_account_edit').show();
	}
};

function business_approval(busid,zoneid,option){ //alert(1); return false;
	$('#temp_busid').val(busid);
	$('#temp_zoneid').val(zoneid);
	$('#temp_option').val(option);
	$('#temp_business_zone').val($("#business_zone").val());
	$('#temp_show_bus_type').val($("#show_bus_type").val());
	$('#dialog-form-businesstype').find('input[name=radio]').attr('checked',false);
	$('#dialog-form-businesstype').dialog( "open" );	
}
function business_approval_deactive(busid,zoneid,option){ 
	PageMethod("<?=base_url('dashboards/business_action')?>/"+busid+"/"+zoneid+"/"+option+"/"+$('#business_zone').val()+"/"+$('#show_bus_type').val(), "Display The Business...<br/>This may take a few minutes", null, requestZoneBusinessSuccess, null);
}
function business_approval_delete(busid,zoneid,type){
	//alert(busid); alert(zoneid); //return false;
	/*var busid=$('#temp_busid').val();
	var zoneid=$('#temp_zoneid').val();*/
	var business_zone_select_value=$('#business_zone').val();
	var business_type_select_value=$('#show_bus_type').val();
	//alert(business_zone_select_value); alert(business_type_select_value); return false;
	//var option=$('input[name=radio]:checked').val();
	var data = { busid : busid, zoneid : zoneid, business_zone_select_value : business_zone_select_value, business_type_select_value : business_type_select_value};
	ConfirmDialog("Really remove this business from this zone?", "Remove Business From Zone", "<?=base_url('dashboards/deleteBusiness')?>",
			"Successfully Remove This Business<br/>This may take a minute", data, requestZoneBusinessSuccess, null);
}
/*function BusinessDeleteSuccessful(result) {
	$.unblockUI();
	if(result.Tag!=''){	
		$("#bus_display").html(result.Tag);
	}
	//CancelAdEdit();       
}*/
$( "#dialog-form-businesstype" ).dialog({
			autoOpen: false,
			height: 200,
			width: 300,
			modal: true,
			buttons: [
			{id: "active",text: "Activate",click: function(){
				var busid=$('#temp_busid').val();
					var zoneid=$('#temp_zoneid').val();
					var business_zone_select_value=$('#temp_business_zone').val();
					var business_type_select_value=$('#show_bus_type').val();
					var option=$('input[name=radio]:checked').val();
					PageMethod("<?=base_url('dashboards/business_action')?>/"+busid+"/"+zoneid+"/"+option+"/"+business_zone_select_value+"/"+business_type_select_value, "Display The Business...<br/>This may take a few minutes", null, requestZoneBusinessSuccess, null);
					$( this ).dialog("close");
				}
			},{id: "dialogCancel",text: "Cancel",click: function() { $(this).dialog("close");}
			}],			
			close: function() {				
			}
});		
$( "#dialog-form-businesstype" ).find( "#radio" ).buttonset();

function zone_business_allbusiness(){
	if($('#business_zone').val()==2){
		$('#show_bus_type').hide();
	}else{
		$('#show_bus_type').show();
	}
}
function show_special_business_type_all(busid,tag){
	var select_val=$(tag).val();	
	PageMethod("<?=base_url('dashboards/SaveBusinessPayment')?>" + "/" + busid+"/"+select_val, "Successfully Updated...<br/>This may take a few minutes", null, null, null);
}

function show_special_business_all(busid,tag){
	var sval=$(tag).val();
	//alert(busid); alert(a);
	PageMethod("<?=base_url('dashboards/SaveBusinessApproval')?>" + "/" + busid+"/"+sval, "Successfully Updated...<br/>This may take a few minutes", null, null, null);
}
function website_visibility_business(busid,tag){
	var website_val=$(tag).val();
	//alert(busid); alert(sval);
	PageMethod("<?=base_url('dashboards/SaveWebsiteVisible')?>" + "/" + busid+"/"+website_val, "Successfully Updated...<br/>This may take a few minutes", null, null, null);
}
function email_visibility_business(busid,tag){
	var email_val=$(tag).val();
	//alert(busid); alert(sval);
	PageMethod("<?=base_url('dashboards/SaveEmailVisible')?>" + "/" + busid+"/"+email_val, "Successfully Updated...<br/>This may take a few minutes", null, null, null);
}
/* BusinessPart End */
/* Listed Business Part Start */
function newlistedbusiness(zoneid){
	alert(zoneid); return false;
	window.location.href = "<?=base_url('dashboards/zone')?>/" + zid;
	
}
function deleteListedbusinessfromZone(){ 
	var all_zone=$('#all_my_zone').val();
	var zoneid =$('#my_current_zone').val();
	//var select_id=$("#show_ad_type").val();	
	//alert(select_id); return false;
	$('div.editbusinessform').html('');
	/*var business_zone_select_value=$("#business_zone").val();
	if(business_zone_select_value!=2){
		var business_type_select_value=$("#show_bus_type").val();
	}else{
		var business_type_select_value=5;
	}*/
	var business_type_select_value=$("#show_bus_type_listed").val();
	var display_checkbox='';		
	$("input[name=checkadfordelete]:Checked").each(function(i,item){ //alert(2);
		display_checkbox+=$(item).val()+',';
	});			
	display_checkbox=display_checkbox.substring(0,display_checkbox.length-1);	
	//alert(display_checkbox); alert(all_zone); alert(zoneid); alert(business_type_select_value); return false;
	if(display_checkbox==''){
		alert('Please select Business.');
		return false;
	}
	param={ busid:display_checkbox,
			zoneid:zoneid,
			//business_zone_select_value:business_zone_select_value,
			business_type_select_value:business_type_select_value
	}
	ConfirmDialog("<b>All Selected Businesses and their all relative Ads of current Zone will be deleted permanently.<br/> If you Delete these, then selected businesses and related Ads cannot be returned backed In future.</b>", "Delete Business and Ads from this Zone", "<?=base_url('dashboards/delete_listed_business_ad_zone')?>","Deleting...<br/>This may take a minute", param, ListedBusinessSuccess, null);
}
function deleteListedbusinessfromAllZone(){
	var all_zone=$('#all_my_zone').val();
	var zoneid =$('#my_current_zone').val();
	$('div.editbusinessform').html('');
	/*var business_zone_select_value=$("#business_zone").val();
	if(business_zone_select_value!=2){
		var business_type_select_value=$("#show_bus_type").val();
	}else{
		var business_type_select_value=5;
	}*/
	var business_type_select_value=$("#show_bus_type_listed").val();
	var display_checkbox='';		
	$("input[name=checkadfordelete]:Checked").each(function(i,item){ //alert(2);
		display_checkbox+=$(item).val()+',';
	});			
	display_checkbox=display_checkbox.substring(0,display_checkbox.length-1);	
	//alert(display_checkbox); alert(all_zone); alert(zoneid); alert(business_type_select_value); return false;
	if(display_checkbox==''){
		alert('Please select Business.');
		return false;
	}
	param={ busid:display_checkbox,
			zoneid:zoneid,
			//business_zone_select_value:business_zone_select_value,
			business_type_select_value:business_type_select_value
	}
	ConfirmDialog("<b>All Selected Businesses and their all relative Ads of current Zone will be deleted permanently.<br/> If you Delete these, then selected businesses and related Ads cannot be returned backed In future.</b>", "Delete Business and Ads from this Zone", "<?=base_url('dashboards/delete_listed_business_ad_all_zone')?>","Deleting...<br/>This may take a minute", param, ListedBusinessSuccess, null);

}
function change_status_listed(val){ //5213
	//alert(val);
	$('#action_performed_in_where').hide();
	$('#business_active_paid_trial').hide();
	if(val==0){
		$('#action_performed_in_where').hide();
		$('#update').hide();
		$('#business_active_paid_trial').hide();
	}else {
		if(val==3){
		$('#action_performed_in_where').show();
		$('#business_active_paid_trial').hide();
		}else if(val==1){
		$('#action_performed_in_where').hide();
		$('#business_active_paid_trial').show();
		}
		
		$('#update').show();
		$('#action_performed_value').val(val);
	}
}
function action_update_listed(){ //alert(1); return false;
	var all_zone=$('#all_my_zone').val();
	var zoneid =$('#my_current_zone').val();
	var business_zone_select_value=$("#business_zone").val();
	if(business_zone_select_value!=2){
		var business_type_select_value=$("#show_bus_type").val();
	}else{
		var business_type_select_value=5;
	}
	var show_bus_type_listed=$('#show_bus_type_listed').val();
	var action_performed=$('#action_performed_value').val(); 
	var action_performed_in_where=$('#action_performed_in_where').val();
	var business_active_paid_trial=$('#business_active_paid_trial').val();
	
	var display_checkbox='';		
	$("input[name=checkadfordelete_listed]:Checked").each(function(i,item){ //alert(2);
		display_checkbox+=$(item).val()+',';
	});			
	display_checkbox=display_checkbox.substring(0,display_checkbox.length-1);	
	//alert(display_checkbox); alert(all_zone); alert(zoneid); return false;
	if(display_checkbox==''){
		alert('Please select Business.');
		return false;
	}
	
	//alert(business_zone_select_value); alert(business_type_select_value); alert(action_performed); alert(action_performed_in_where); alert(display_checkbox); return false;
	data={ busid:display_checkbox,
			zoneid:zoneid,
			allzoneid:all_zone,
			business_zone_select_value:business_zone_select_value,
			business_type_select_value:business_type_select_value,
			show_bus_type_listed:show_bus_type_listed,
			action_performed:action_performed,
			action_performed_in_where:action_performed_in_where,
			business_active_paid_trial:business_active_paid_trial
	}
	if(action_performed==3 && action_performed_in_where==0){
		ConfirmDialog("<b>All Selected Businesses and their all relative Ads of current Zone will be deleted permanently.<br/> If you Delete these, then selected businesses and related Ads cannot be returned backed In future.</b>", "Delete Business and Ads from this Zone", "<?=base_url('dashboards/action_performed_listed_business')?>","Deleting...<br/>This may take a minute", data, ListedBusinessSuccess, null);
	}else if(action_performed==3 && action_performed_in_where==1){
		ConfirmDialog("<b>All Selected Businesses and their all relative Ads of current Zone will be deleted permanently.<br/> If you Delete these, then selected businesses and related Ads cannot be returned backed In future.</b>", "Delete Business and Ads from all Zone", "<?=base_url('dashboards/action_performed_listed_business')?>","Deleting...<br/>This may take a minute", data, ListedBusinessSuccess, null);
	}else{
		PageMethod("<?=base_url('dashboards/action_performed_listed_business')?>", "Action Performed...<br/>This may take a few minutes", data, ListedBusinessSuccess, null);
	}
	
}



function showListedBusiness(zone_id,charval,tag){ //alert(zone_id);alert(charval); 
	
	if(charval==''){
		charval='all';
	}	
	var lowerlimit=''; var upperlimit=''; 
	var $this=$(tag);
	var limit=$this.attr('rel'); //alert(limit);
	if(limit=='' || limit==undefined){
		lowerlimit=0; upperlimit=5;
	}else{
		limit_final=limit.split(',');
		lowerlimit=limit_final[0]; upperlimit=limit_final[1];
		
	}
	//alert (lowerlimit);
	//alert(upperlimit);
	$('#bus_display_listed').show();    
	$('div.editbusinessform_listed').html('');
	var business_type_select_value=$("#show_bus_type_listed").val();
	//alert(business_zone_select_value); 
	//alert(business_type_select_value); return false;
	//var data={'business_zone':$('#business_zone_listed').val()};
	PageMethod("<?=base_url('dashboards/display_business_listed')?>/"+business_type_select_value+"/"+zone_id+"/"+charval+"/"+lowerlimit+"/"+upperlimit, "Display The Listed Businesses...<br/>This may take a few minutes", null, ListedBusinessSuccess, null);
    
}
function ListedBusinessSuccess(result){
	$.unblockUI();
	var limit=result.Message;
	if(result.Tag!=''){	
	
		$("#bus_display_listed").html(result.Tag);
		$('#my_business_limit').attr('rel',limit); 
		//change_category();
		$('.listed_category').each(function(){ //alert(1);
			change_category(this);
			});
	}
}
function listed_business_approval_deactive(busid,zoneid,option){ //alert($('#show_bus_type_listed').val());
	PageMethod("<?=base_url('dashboards/listed_business_action')?>/"+busid+"/"+zoneid+"/"+option, "Display The Listed Business...<br/>This may take a few minutes", null, ListedBusinessSuccess, null);
}
function listed_business_approval_activate(busid,zoneid,option){ //alert($('#show_bus_type_listed').val());
	PageMethod("<?=base_url('dashboards/listed_business_action')?>/"+busid+"/"+zoneid+"/"+option, "Display The Listed Business...<br/>This may take a few minutes", null, ListedBusinessSuccess, null);
}
function listed_business_approval_delete(busid,zoneid,type){
	//alert(busid); alert(zoneid); //return false;
	/*var busid=$('#temp_busid').val();
	var zoneid=$('#temp_zoneid').val();*/
	//var business_zone_select_value=$('#business_zone').val();
	var business_type_select_value=$('#show_bus_type_listed').val();
	//alert(business_zone_select_value); alert(business_type_select_value); return false;
	//var option=$('input[name=radio]:checked').val();
	var data = { busid : busid, zoneid : zoneid, business_type_select_value : type};
	ConfirmDialog("Really remove this business from this zone?", "Remove Business From Zone", "<?=base_url('dashboards/listed_deleteBusiness')?>",
			"Successfully Remove This Business<br/>This may take a minute", data, ListedBusinessSuccess, null);
}


/*function listed_business_approval(busid,zoneid,option){ //alert(1); return false;
	$('#temp_busid').val(busid);
	$('#temp_zoneid').val(zoneid);
	$('#temp_option').val(option);
	$('#temp_business_zone').val($("#business_zone_listed").val());
	$('#temp_show_bus_type').val($("#show_bus_type_listed").val());
	$('#dialog-form-businesstype_listed').find('input[name=radio]').attr('checked',false);
	$('#dialog-form-businesstype_listed').dialog( "open" );	
}*/
/*$( "#dialog-form-businesstype_listed" ).dialog({
			autoOpen: false,
			height: 200,
			width: 300,
			modal: true,
			buttons: [
			{id: "active",text: "Activate",click: function(){
				var busid=$('#temp_busid').val();
					var zoneid=$('#temp_zoneid').val();
					var business_zone_select_value=$('#temp_business_zone').val();
					var business_type_select_value=$('#show_bus_type_listed').val();
					var option=$('input[name=radio]:checked').val();
					PageMethod("<?=base_url('dashboards/listed_business_action')?>/"+busid+"/"+zoneid+"/"+option+"/"+business_zone_select_value+"/"+business_type_select_value, "Display The Listed Business...<br/>This may take a few minutes", null, ListedBusinessSuccess, null);
					$( this ).dialog("close");
				}
			},{id: "dialogCancel",text: "Cancel",click: function() { $(this).dialog("close");}
			}],			
			close: function() {				
			}
});		
$( "#dialog-form-businesstype_listed" ).find( "#radio" ).buttonset();*/
/*  Listed Business Part End */
/*  Advertisement Part Start */
function showAdvertisement(zone_id,charval,tag){
	///$('#newadd').show();   
	
	if(charval==''){
		charval='all';
	}	
	
	var lowerlimit=''; var upperlimit=''; 
	var $this=$(tag);
	var limit=$this.attr('rel'); //alert(limit);
	if(limit=='' || limit==undefined){
		lowerlimit=0; upperlimit=2;
	}else{
		limit_final=limit.split(',');
		lowerlimit=limit_final[0]; upperlimit=limit_final[1];
	}
	//alert (lowerlimit);
	//alert(upperlimit);
	$('#bus_display_listed').show();
	
	var select_id=$("#show_ad_type").val();
	var business_id=$("#all_business").val(); //alert(business_id); return false;
	var split_bus_id=business_id.split('-');
	/*var count_bus_id=split_bus_id.length; //alert(count_bus_id);	 
	if(count_bus_id==1){ alert(1); //return false;
		$('#newadzone').show();
	}else{ alert(2); //return false;
		$('#newadzone').hide();
	}*/
	/*if(business_id.indexOf('-')>-1)
		$('#newad').attr('disabled','disabled'); 
	else
		$('#newad').removeAttr('disabled');*/	
	PageMethod("<?=base_url('dashboards/display_ad')?>/"+select_id+"/"+zone_id+"/"+business_id+"/"+charval+"/"+lowerlimit+"/"+upperlimit, "Display The Advertisements...<br/>This may take a few minutes", null, requestZoneAddSettingSuccess, null);
    
}
function requestZoneAddSettingSuccess(result){
	$.unblockUI();
	var limit=result.Message;
	if(result.Tag!=''){	
		$("#ad_display").html(result.Tag);
		$('#my_business_limit').attr('rel',limit);
		
	}
}
function allactivate_ads(){
	$('.ad_approval_activate').click();
}
function alldeactivate_ads(){
	$('.ad_approval_deactivate').click();
}

function ad_approval(adid,zoneid,option,bus_id){ 
	var select_id=$("#show_ad_type").val();	
	var business_id=$("#all_business").val();
	//alert('adid -- '+adid+' -- zoneid --'+zoneid+' -- option -- '+option+' -- busines id --'+bus_id+' -- select id --'+select_id+'  - all business id --  '+business_id); return false;
	PageMethod("<?=base_url('dashboards/edit_ad')?>/"+adid+"/"+zoneid+"/"+option+"/"+select_id+"/"+bus_id+"/"+business_id, "Display The Advertisements...<br/>This may take a few minutes", null, requestZoneAddSettingSuccess, null);
}
function ad_approval_delete(adid,zoneid,option,busid){
	var select_id=$("#show_ad_type").val();
	var business_id=$("#all_business").val();
	
	var data = { adid : adid, zoneid : zoneid, option : option, select_id : select_id, busid : busid, business_id : business_id};
	ConfirmDialog("Really remove this advertisement from this zone?", "Remove Ad From This Zone", "<?=base_url('dashboards/delete_ad')?>",
			"Successfully Remove This Ad<br/>This may take a minute", data, requestZoneAddSettingSuccess, null);
	
	
}

function ad_sticky(adid,zoneid,bus_id,option){ 
	var select_id=$("#show_ad_type").val();	
	var business_id=$("#all_business").val();
	//alert('adid -- '+adid+' -- zoneid --'+zoneid+' -- option -- '+option+' -- busines id --'+bus_id+' -- select id --'+select_id+'  - all business id --  '+business_id); return false;
	PageMethod("<?=base_url('dashboards/sticky_ad')?>/"+adid+"/"+zoneid+"/"+option+"/"+select_id+"/"+bus_id+"/"+business_id, "Saving the changes successfully...<br/>", null, requestZoneAddSettingSuccess, null);
}

function all_ads_to_all_zone(){ 
	var all_bus_id=$("#all_bus_id").val();
	var param = { all_bus_id : all_bus_id};
	//alert(all_bus_id); return false;
	/*PageMethod("<?=base_url('dashboards/all_ads_apply_to_all_zones')?>", "Fetching business<br/>This may take a minute.", param, null, null);*/
	
	ConfirmDialog1("Are you sure to all activated ads to all of your zones?", "Ad display to all my zone", "<?=base_url('dashboards/all_ads_apply_to_all_zones')?>",
			"Apply To All My Zone<br/>This may take a minute", param, null, null);
	
	
	
}

function newadfromshowad(){ //alert('new ad');  return false;
	
	$("#docs_pdf_show").hide();
	$("#ad_id_fromshowad").val("-1");
	$("#ad_name_fromshowad").val("");
	$("#ad_code_fromshowad").val("");	
	
	//$("#ad_starttime").val("12:00 am");
	//$("#ad_stoptime").val("11:59 pm");
	$("#ad_category_fromshowad").val("");
	$("#ad_subcategory_fromshowad").val("");
	//alert($("#ad_category_fromshowad").val()); alert($("#ad_subcategory_fromshowad").val()); //return false;
	//$("#foodimage").val('');
	$("#ad_subcategory_fromshowad1").hide();
	$(".food_icon_image").hide();
	CKEDITOR.instances.ad_text_fromshowad.setData( "Your Ad Here!" );
	ShowAdEditViewfromshowad();
	$("#show_ads").hide();
	$("#text_message_fromshowad").val("");
	$("#ad_startdatetime_fromshowad").val('');
	$("#ad_stopdatetime_fromshowad").val('');
	$('#iseditad').val('0');
	<?php /*?>$("p.p_change_reason").hide();
	$("#change_reason").val('');<?php */?>
	$( "#ad_startdatetime_fromshowad, #ad_stopdatetime_fromshowad" ).datetimepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat:'yy-mm-dd'
	});
}
function ShowAdEditViewfromshowad(){
	$("#editAdfromshowad").show();
	$('#ad_display').hide();
	/*$('#showbusiness').click();*/ 
}
// anish9313
function saveAdfromshowad(tag){ 
	//alert(1); return false;
	//alert($('#docs_pdf_fromshowad'));    return false;
	var _f=$(tag).closest('form');
	
	var catid=$('#ad_category_fromshowad').val(); 
	var subcatid=$('#ad_subcategory_fromshowad').val(); //alert(catid); alert(subcatid); //return false;
	//alert($('#ad_subcategory_fromshowad').val()); return false;
	if(catid=='0'){
		alert('please select category');
		return false;
	}
	/*if(subcatid==''){
		alert('please select sub category.');
		return false;
	}*/
		
		
	var ad_startdatetime = Date.parse(_f.find("#ad_startdatetime_fromshowad").val());
	var ad_stopdatetime = Date.parse(_f.find("#ad_stopdatetime_fromshowad").val());

	if(ad_startdatetime==null || ad_stopdatetime==null)
	{
		alert('please insert start date time and stop date time');
		return false;
	}
	
	if(ad_startdatetime.compareTo(ad_stopdatetime)>=0)
	{
		alert('please insert start date time and stop date time');
		return false;
	}
     
        
	var dataToUse = {
		"id":_f.find("#ad_id_fromshowad").val(),
		"iseditad":_f.find("#iseditad").val(),
		"offer_code" : _f.find("#ad_code_fromshowad").val(),
		"docs_pdf":_f.find("#docs_pdf").val(),
		"name":_f.find("#ad_name_fromshowad").val(),
		"biz_list" : "true",
		"ad_stopdatetime":_f.find("#ad_stopdatetime_fromshowad").val(),
		"ad_startdatetime":_f.find("#ad_startdatetime_fromshowad").val(),
		'zoneid':'<?=$zone->id?>',
		"business_id":$('#all_business').val(),
		"adtext": CKEDITOR.instances.ad_text_fromshowad.getData(),
		//"adtext": '',
		"category_id": _f.find("#ad_category_fromshowad").val(),
		"subcategory_id": _f.find("#ad_subcategory_fromshowad").val(),
		"imagetype": _f.find("#foodimage").val(),		
		"active" : "1",
		"text_message": _f.find("#text_message_fromshowad").val()<?php /*?>,
		"change_reason":_f.find('#change_reason').val()<?php */?>
	};
	//alert(dataToUse);	
   // PageMethod("<?=base_url('dashboards/saveAdfromshowad')?>", "Saving Ad<br/>This may take a minute.", dataToUse, adsSaveSuccessful, null);
   PageMethod("<?=base_url('dashboards/saveAdfromshowad')?>", "Your ad has been successfully posted.", dataToUse, adsSaveSuccessful, null);
}
function adsSaveSuccessful(result) {
	$('button.showad').click();
	//$("#ad_display").html(result.Tag);
	$('div#editAdfromshowad').hide();
	$('#ad_display').show();
	$.unblockUI();
	$("#ad_id_fromshowad").val('');
	$("#foodimage").val('');
}



function cancel_add_edit(form){	
	$("#ad_subcategory_fromshowad").val('');	
	$('#iseditad').val('0');
	$('div#editAdfromshowad').hide();	
	$('#ad_display').show();	
	$("#ad_subcategory_fromshowad1").hide(); $(".food_icon_image").hide();	
	$('button.showad').click();	 
}


function showeditform(adid,zoneid,businessid){ //alert('edit ad'); return false;
		//$('#newad').attr('disabled','disabled');
		//alert(adid,zoneid);
		
		
		$('#ad_display').hide();
		 /*var dataToUse = {
            "adid":adid,
            "zoneid" : zoneid,
			"businessid":businessid
        };*/
		//$('div#editAdfromshowad').hide();
		
		$("#ad_subcategory_fromshowad").val(); //alert($("#ad_subcategory_fromshowad").val());
		$("#ad_subcategory_fromshowad").val('');
		$("#ad_subcategory_fromshowad1").show();
		
		show_specific_subcat_in_category(adid,zoneid,businessid);
		
        <?php /*?>PageMethod("<?=base_url('dashboards/showeditform')?>/"+adid+'/'+zoneid+'/'+businessid, "Fetching Ad<br/>This may take a minute.", null, showeditadform, null);<?php */?>
	}
function show_specific_subcat_in_category(adid,zoneid,businessid){ //alert(1);
	//alert(7); return false;
	PageMethod("<?=base_url('dashboards/show_details_ad_zone')?>/"+adid+'/'+zoneid+'/'+businessid, "Fetching Ad<br/>This may take a minute.", null, adSpecificSubcategorySuccess, null);
}
function adSpecificSubcategorySuccess(result){
	$.unblockUI();
	if(result.Tag!=''){	//alert(2);
		$("#ad_subcategory_fromshowad1").html(result.Tag);
		var adid=$('#bus_adid').val(); var businessid=$('#bus_busid').val();  var zoneid=$('#bus_zoneid').val(); 
		//var adid=69; var businessid=13; var zoneid=7;
		PageMethod("<?=base_url('dashboards/showeditform')?>/"+adid+'/'+businessid+'/'+zoneid, "Fetching Ad<br/>This may take a minute.", null, showeditadform, null);
	}
}
function showeditadform(result){ //alert(3);
	//alert(JSON.stringify(result));
	$.unblockUI();
	//$("#ad_subcategory_fromshowad1").show();
	//$("#ad_subcategory_fromshowad1").html(result.Tag);
	//$("#ad_subcategory_fromshowad").val(''); 
	var ads=result;
	$('#logo_image22').hide();
	$('#docs_pdf').val(ads.docs_pdf);
	if(ads.docs_pdf!=''){
		$('#docs_pdf_show').show();
	}else{
		$('#docs_pdf_show').hide();
	}
	var file_upload_text=ads.docs_pdf;
	var file_upload_text_final=file_upload_text.substring(16);
	$('label#docs_pdf_1').html(file_upload_text_final);
	$('#ad_business_fromshowad').val(ads.business_id);
	$('#ad_id_fromshowad').val(ads.id);
	$('#ad_name_fromshowad').val(ads.name);
	$('#ad_code_fromshowad').val(ads.offer_code);
	$('#ad_startdatetime_fromshowad').val(ads.startdatetime);
	$('#ad_stopdatetime_fromshowad').val(ads.stopdatetime);
	$('#ad_category_fromshowad').find('option[value='+ads.categoryid+']').attr('selected','selected');
	$('#ad_subcategory_fromshowad').find('option[value='+ads.subcategoryid+']').attr('selected','selected');
	//$('#ad_subcategory_fromshowad').find('option[value='+ads.subcategoryid1+']').attr('selected','selected');
	if(ads.categoryid==30){
		$('.food_icon_image').show();
	}else{
		$('.food_icon_image').hide();
	}
	//alert(ads.imagetype);
	$('#foodimage').val(ads.imagetype);
	var imagetype=ads.imagetype;
	if(imagetype!=0){
	var imagetype_split=imagetype.split(',');	
	$.each(imagetype_split,function(i,item){		
		$("a.checkclass[rel="+item+"]").attr('class','food_icon_image_selected checkclass');
	});
	}
	
	
	
	CKEDITOR.instances.ad_text_fromshowad.setData(ads.adtext),
	$('#text_message_fromshowad').val(ads.text_message);
	$('#iseditad').val(1);
	$("p.p_change_reason").show();
	$("#change_reason").val(ads.change_reason);
	//$('button.showad').click();
	$('div#editAdfromshowad').show();
}
function business_cat(){
	//alert(1); return false;
	var cat_id=$('#ad_category_fromshowad').val();
	var iszoneid=$('#iszoneid').val();//alert(cat_id); alert(iszoneid); return false;
	//alert(cat_id);
	if(cat_id=='0'){	
		$("#ad_subcategory_fromshowad1").hide();
	}else{
		$("#ad_subcategory_fromshowad1").show(); //$(".food_icon_image").show();
		if(cat_id==30){
			$(".food_icon_image").show();
		}else{
			$(".food_icon_image").hide();
		}
		var data = { cat_id : cat_id , iszoneid : iszoneid };
		PageMethod("<?=base_url('dashboards/zone_subcategories_in_a_category_zone')?>", "", data, adSubcategorySuccess, null);
	}
}
function adSubcategorySuccess(result){
	$.unblockUI();
	if(result.Tag!=''){	
		$("#ad_subcategory_fromshowad1").html(result.Tag);
	}
}


/*function deletealladthisbusiness(){ 
	var businessid=$('#all_bus_id').val();
	var zoneid =$('#current_zoneid').val();
	var select_id=$("#show_ad_type").val();	
	//alert(select_id); return false;
	var display_checkbox='';		
	$("input[name=checkadfordelete]:Checked").each(function(i,item){ //alert(2);
		display_checkbox+=$(item).val()+',';
	});			
	display_checkbox=display_checkbox.substring(0,display_checkbox.length-1);	
	//alert(display_checkbox); alert(businessid); alert(zoneid); return false;
	if(display_checkbox==''){
		alert('Please select atleast one ad.');
		return false;
	}
	param={	adid:display_checkbox,
			busid:businessid,
			zoneid:zoneid,
			select_id : select_id
	}
	ConfirmDialog("Are you sure to delete all ads to this zone?", "Delete Ad from this Zone", "<?=base_url('dashboards/delete_ad_from_specific_business')?>",
			"Deleting...<br/>This may take a minute", param, requestZoneAddSettingSuccess, null);
	
	
}*/


	
/* Advertisement Part End */
/* Export Business Start */ 
function exportbusiness(zoneid){
	var dataToUse = {
		"zoneid":zoneid,				
	}
	
	
	PageMethod("<?=base_url('dashboards/export_business_display')?>", "Display The Businesses ...<br/>This may take a few minutes", dataToUse, requestExportBusinessSuccess, null);
}
function requestExportBusinessSuccess(result){
	//alert(JSON.stringify(result));
	$.unblockUI();
	if(result.Tag!=''){	
		$("#export_business").html(result.Tag);		
	}
}

function export_2(zoneid){ 
	var buss_type_2=$('#bus_type_2').val();
	$('#id_2').attr('href',"<?=base_url('csvuploader/export_controller.php?zone=')?>"+zoneid+"&kind=1&type="+buss_type_2);
}
function export_3(zoneid){ 
	var buss_type_3=$('#bus_type_3').val();
	$('#id_3').attr('href',"<?=base_url('csvuploader/export_controller.php?zone=')?>"+zoneid+"&kind=0&type="+buss_type_3);
}
function export_4(zoneid){ 
	var buss_type_4=$('#bus_type_4').val();
	$('#id_4').attr('href',"<?=base_url('csvuploader/export_controller.php?zone=')?>"+zoneid+"&kind=5&type="+buss_type_4);
}
function export_5(zoneid){ 
	var buss_type_5=$('#bus_type_5').val();
	$('#id_5').attr('href',"<?=base_url('csvuploader/export_controller.php?zone=')?>"+zoneid+"&kind=3&type="+buss_type_5);
}

/*function export_1(){
	var zoneid=$('#zoneid').val();
	var dataToUse = {
		"zoneid":$('#zoneid').val(),
		"business_type" : -99,
		"business_kind" : $('#buss_kind_1').val()		
	}
	PageMethod("<?=base_url('dashboards/export_business')?>", "Export the Businesses ...<br/>This may take a few minutes", dataToUse, null, null);
	
}
function export_2(){
	var zoneid=$('#zoneid').val();
	var dataToUse2 = {
		"zoneid":$('#zoneid').val(),
		"business_type" : $('#bus_type_2').val(),
		"business_kind" : $('#buss_kind_2').val()		
	}
	PageMethod("<?=base_url('dashboards/export_business')?>", "Display The Default Setting ...<br/>This may take a few minutes", dataToUse2, null, null);
	
}
function export_3(){
	var zoneid=$('#zoneid').val();
	var dataToUse3 = {
		"zoneid":$('#zoneid').val(),
		"business_type" : $('#bus_type_3').val(),
		"business_kind" : $('#buss_kind_3').val()		
	}
	PageMethod("<?=base_url('dashboards/export_business')?>", "Display The Default Setting ...<br/>This may take a few minutes", dataToUse3, null, null);
	
}
function export_4(){
	var zoneid=$('#zoneid').val();
	var dataToUse4 = {
		"zoneid":$('#zoneid').val(),
		"business_type" : $('#bus_type_4').val(),
		"business_kind" : $('#buss_kind_4').val()		
	}
	PageMethod("<?=base_url('dashboards/export_business')?>", "Display The Default Setting ...<br/>This may take a few minutes", dataToUse4, null, null);
	
}
function export_5(){
	var zoneid=$('#zoneid').val();
	var dataToUse5 = {
		"zoneid":$('#zoneid').val(),
		"business_type" : $('#bus_type_5').val(),
		"business_kind" : $('#buss_kind_5').val()		
	}
	PageMethod("<?=base_url('dashboards/export_business')?>", "Display The Default Setting ...<br/>This may take a few minutes", dataToUse5, null, null);
	
}*/
/* Export Business End */
/* Default Setting Start */
function defaultsetting(zoneid){
	var dataToUse = {
		"zoneid":zoneid,		
	}
	
	
	PageMethod("<?=base_url('dashboards/default_setting_display')?>", "Display The Default Setting ...<br/>This may take a few minutes", dataToUse, requestDefaultSettingSuccess, null);
}
function requestDefaultSettingSuccess(result){
	//alert(JSON.stringify(result));
	$.unblockUI();
	if(result.Tag!=''){	
		$("#default_setting").html(result.Tag);		
	}
}
function savespecificBusiness(zone_id){
	//alert($('#zonetheme').val()); return false;
	var auto_approve_paid_specific_ad_myzone='';
	if($('#auto_approve_paid_ad_myzone').val()==0){
		$('.auto_approve_paid_specific_ad_myzone').each(function(i,item){
			if($(item).is(':checked')){
				auto_approve_paid_specific_ad_myzone+=$(item).val()+',';
			}
		});
		auto_approve_paid_specific_ad_myzone=auto_approve_paid_specific_ad_myzone.substring(0,auto_approve_paid_specific_ad_myzone.length-1);
	}else{
		$('.auto_approve_paid_specific_ad_myzone').attr('checked',false);
	}
	var auto_approve_paid_specific_ad_locatedmyzone='';
	if($('#auto_approve_paid_ad_locatedmyzone').val()==0){
		$('.auto_approve_paid_specific_ad_locatedmyzone').each(function(i,item){
			if($(item).is(':checked')){
				auto_approve_paid_specific_ad_locatedmyzone+=$(item).val()+',';
			}
		});
		auto_approve_paid_specific_ad_locatedmyzone=auto_approve_paid_specific_ad_locatedmyzone.substring(0,auto_approve_paid_specific_ad_locatedmyzone.length-1);
	}else{
		$('.auto_approve_paid_specific_ad_locatedmyzone').attr('checked',false);
	}
	var dataToUse={	"zoneid":zone_id,	
					"auto_approve_paid_ad_myzone":$('#auto_approve_paid_ad_myzone').val(),
					"auto_approve_paid_specific_ad_myzone":auto_approve_paid_specific_ad_myzone,
					"auto_approve_paid_ad_locatedmyzone":$('#auto_approve_paid_ad_locatedmyzone').val(),
					"auto_approve_paid_specific_ad_locatedmyzone":auto_approve_paid_specific_ad_locatedmyzone,					
					"auto_approve_trial_ad_myzone":$('#auto_approve_trial_ad_myzone').val(),
					"auto_approve_trial_specific_ad_myzone":$('#auto_approve_trial_specific_ad_myzone').val(),
					"auto_approve_trial_ad_locatedmyzone":$('#auto_approve_trial_ad_locatedmyzone').val(),
					"auto_approve_trial_specific_ad_locatedmyzone":$('#auto_approve_trial_specific_ad_locatedmyzone').val(),					
					"auto_approve_paid_business_myzone":$('#auto_approve_paid_business_myzone').val(),
					"auto_approve_paid_business_locatedmyzone":$('#auto_approve_paid_business_locatedmyzone').val(),
					"auto_approve_trial_business_myzone":$('#auto_approve_trial_business_myzone').val(),
					"auto_approve_trial_business_locatedmyzone":$('#auto_approve_trial_business_locatedmyzone').val(),
					
					"auto_approve_listed_business_myzone":$('#auto_approve_listed_business_myzone').val(),
					"auto_approve_listed_business_locatedmyzone":$('#auto_approve_listed_business_locatedmyzone').val(),
					
					"auto_approve_emergency_announcements":$('#auto_approve_emergency_announcements').val(),
					"auto_approve_normal_announcements":$('#auto_approve_normal_announcements').val(),
					
					"auto_approve_offers_announcements":$('#auto_approve_offers_announcements').val(),
					"auto_approve_banner":$('#auto_approve_banner').val(),
					"showoffer":$('#shownooffer').val(),
					"auto_approve_sticky_ad":$('#auto_approve_sticky_ad').val(),
					"ischangezonetheme":$('#is_change_theme').val(),
					"zonetheme":$('#zonetheme').val()
					};
        PageMethod("<?=base_url('dashboards/savespecificBusiness')?>", "Saving Default Settings<br/>This may take a minute.", dataToUse, spSaveSuccessful, null);
}
function spSaveSuccessful(){
	$.unblockUI();
	$("#showspbusiness").hide();
}
/* Default Setting End */
/* Bulk email portion start */
function get_business_bulk()
{
	//alert(1);
	$.post("<?=base_url('dashboards/get_business_bulk')?>/"+default_zone, '',
		function(data) {
		//alert(data);
		$("#bulk_email").html(data);
	});
}
function get_template_bulk()
{
	//alert(2);
	$.post("<?=base_url('dashboards/get_template_bulk')?>", '',
		function(data) {
		//alert(data);
		$("#bulk_email").html(data);
	});
}
function Edittemplate(id){	
	$.post("<?=base_url('dashboards/edit_template_bulk')?>/"+id, '',
		function(data) {
		if(CKEDITOR.instances['template_content'])
		{
			CKEDITOR.instances['template_content'].destroy();
		}
		if(CKEDITOR.instances['addtemplate_content'])
		{
			CKEDITOR.instances['addtemplate_content'].destroy();
		}
		$("#bulk_email").html(data);			
	});
}
function Deletetemplate(id, title){
	$.post("<?=base_url('dashboards/delete_template_bulk')?>/"+id,'',
			function(data) {
			$("#bulk_email").html(data);
	});
}
function newtemplate_bulk()
{
    $.post("<?=base_url('dashboards/newtemplate_bulk')?>/", '',
		function(data) {
			$("#bulk_email").html(data);
	});
}
function save_template(status)
{
		var hidden_temp_id = $("#hidden_temp_id").val();
		var dataToUse = {
				"id":$("#hidden_temp_id").val(),
				"zone":default_zone,
				"status":status,
		        "template_subject":$("#template_subject").val(),
		        "addtemplate_content":CKEDITOR.instances.addtemplate_content.getData()
		};
		if(status==1)
		{
			$.post("<?=base_url('dashboards/save_template_bulk')?>/", dataToUse,
				function(data) {
					if(CKEDITOR.instances['template_content'])
				    {
				    	CKEDITOR.instances['template_content'].destroy();
				    }
				    if(CKEDITOR.instances['addtemplate_content'])
				    {
				    	CKEDITOR.instances['addtemplate_content'].destroy();
				    }
					$("#bulk_email").html(data);
			});
		}else{
			$.post("<?=base_url('dashboards/save_template_bulk')?>/", dataToUse,
					function(data) {
						if(CKEDITOR.instances['template_content'])
					    {
					    	CKEDITOR.instances['template_content'].destroy();
					    }
					    if(CKEDITOR.instances['addtemplate_content'])
					    {
					    	CKEDITOR.instances['addtemplate_content'].destroy();
					    }
						$("#bulk_email").html(data);
			});
		}
}

function select_all(ele)
{ //alert(1);return false;
	checkboxes = document.getElementsByTagName("input");//get main check box
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
	}
}
function get_all_business(user)
{
	$.post("<?=base_url('dashboards/get_all_business')?>/"+user+"/"+default_zone, '',
			function(data) {
			//alert(data);
				$("#contactOwnerDialog").html(data);
				$('#contactOwnerDialog').dialog('open');
		});
	
}

$("#contactOwnerDialog").dialog({autoOpen : false, modal: true, width:500});
function send_all_business_bulk()
{
	//alert(1);
	var zone_owner=new Array();
	var i=0;
	$('.zone_owner_check').each(function (){
    	if($(this).is(':checked'))
    	{
			//alert($(this).val());
    		zone_owner[i] = $(this).val();
    		i++;
        }
    });
	var dataToUse = {
		    "zone_owner":zone_owner
	    };
    
	$.post("<?=base_url('dashboards/set_subscriber_bulk')?>/"+default_zone, dataToUse,
			function(data) {
				$("#bulk_email").html(data);
		});
}

function send_email()
{
    var dataToUse = {
	    "zone":default_zone,
		"subscriber":$("#subscriber").val(),
		"template":$("#template").val(),
		"template_subject":$("#template_subject").val(),
		"template_content":CKEDITOR.instances.template_content.getData()
    };

	    $.post("<?=base_url('dashboards/send_email_bulk')?>", dataToUse,
				function(data) {
					
					if(CKEDITOR.instances['template_content'])
				    {
				    	CKEDITOR.instances['template_content'].destroy();
				    }
				    if(CKEDITOR.instances['addtemplate_content'])
				    {
				    	CKEDITOR.instances['addtemplate_content'].destroy();
				    }
				    $("#bulk_email").html(data);
		});
}
/* Bulk email portion end */
/* Municipal owners start */
 
/* Municipal owners end */
/* Zone Manager start */

/* Zone Manager end */
/* Announcement start */

	

	function ShowAnnouncementEditor(){     
        $("#annoucement_edit").show();
        $("#showannouncement").hide(); 
		$("#organization").hide();
		$("#showorganizationdetail").hide();
		//$("#announcements_category_type").show();
		$("#announcements_category_type").hide();  
    }
	function HideAnnouncementEditor(){ 
        $("#annoucement_edit").hide();
        $("#showannouncement").show();
		$("#announcements_category_type").show();
		$("#organization").hide();		
		$("#showorganizationdetail").hide();
		$(".showall").click();
    }
	function showallannouncement(charval){ //alert(charval); return false;
		var announcements_category=$("#announcements_category").val(); 
		var announcements_type=$("#announcements_type").val(); 
		PageMethod("<?=base_url('dashboards/getAnnounceData')?>/"+default_zone+"/"+announcements_category+"/"+announcements_type+"/"+charval, "Display The Announcement...<br/>This may take a few minutes", null, showAccounceInformation, null);
	}
	function showAccounceInformation(result){
		$.unblockUI();
		if(result.Tag!=''){ //alert(1);	
			$("#annoucement_edit").hide();
        	$("#showannouncement").show();
			$("#announcements_category_type").show();
			$("#organization").hide();		
			$("#showorganizationdetail").hide();
			$("#showannouncement").html(result.Tag);
		}	
	}
	function newAnnouncement() {
		$('#error_org_uname').hide();		
        $("#organization_id").val("-1");
        $("#announcement_title").val("");
        CKEDITOR.instances.announcement_text.setData( "Your Announcement Here!" );
        ShowAnnouncementEditor();
    }
	function SaveAnnouncement(){
		
		if($("#announcement_title").val()==''){
			$("#announcement_title").val('Title');
		}
		//alert($("#announcement_title").val()); return false;
		//var announcements_category=$("#announcements_category").val(); 
		//var announcements_type=$("#announcements_type").val(); //alert(announcements_category);  alert(announcements_type); return false; 
        var dataToUse = {
            "id":$("#announcement_id").val(),
            "title":$("#announcement_title").val(),
            "zone_id": $("#announcement_zone").val(),
            "announcement_text": CKEDITOR.instances.announcement_text.getData( ),
			"announcementtype": $("#announcementtype").val(),
			"announcements_category": $("#announcements_category").val(),
			"announcements_type": $("#announcements_type").val(),
    	};
        PageMethod("<?=base_url('announcements/save')?>", "Saving Announcement<br/>This may take a minute.", dataToUse, announceSaveSuccessful, null);
    }
    function announceSaveSuccessful(result) {
        $.unblockUI();
        $("#showannouncement").html(result.Tag);
        //$("#showannouncement table").dataTable({ "bPaginate" : false});
        HideAnnouncementEditor();
    }	
	function EditAnnouncement(id){
		$("ad_business").val(id);
		PageMethod("<?=base_url('announcements/get')?>" + "/" + id, "", null, ShowAnnouncementEdit, null);
	}
	function ShowAnnouncementEdit(result) {
		$.unblockUI();
		ShowAnnouncementEditor();
		$("#announcement_id").val(result.id);
		$("#announcement_title").val(result.title);
		CKEDITOR.instances.announcement_text.setData(result.announcement_text );
	}
	function DeleteAnnouncement(id, title,announcements_category,announcements_type) {
		ConfirmDialog("Really delete : " + title, "Delete Announcement", "<?=base_url('announcements/delete')?>", "Deleting Announcement<br/>This may take a minute",
			{ "id": id ,  "announcements_category": announcements_category ,  "announcements_type": announcements_type, "zoneid":default_zone}, announceSaveSuccessful, null);
	}
	
	function announcement_approval(anid,option,announcements_category,announcements_type){ 
		//alert(anid); alert(option); alert(announcements_category); alert(announcements_type); return false; 
		//var select_id=$("#show_ad_type").val();	
		//var business_id=$("#all_business").val();
		//alert('adid -- '+adid+' -- zoneid --'+zoneid+' -- option -- '+option+' -- busines id --'+bus_id+' -- select id --'+select_id+'  - all business id --  '+business_id); return false;
		PageMethod("<?=base_url('dashboards/announcement_status_change')?>/"+anid+"/"+option+"/"+announcements_category+"/"+announcements_type+"/"+default_zone, "Change the Status...<br/>This may take a few minutes", null, showAccounceInformation, null);
	}
	/*function requestAnnouncementSuccess(result){
		$.unblockUI();
		if(result.Tag!=''){	
			$("#ad_display").html(result.Tag);
		}
	}*/
	
	function allactivate_announcement(){
		$('.announcement_activate').click();
	}
	function alldeactivate_announcement(){
		$('.announcement_deactivate').click();
	}
/* Announcement end */
/* */
	$('#error_org_uname').hide(); 
	function check_org_username(){
		
		var org_username=$("#organization_username").val();
		var org_id=$("#organization_id").val();
		//alert(org_username); alert(org_id); alert(default_zone);
		var data = { "zoneid": default_zone , "org_username": org_username , "org_id": org_id};
		PageMethod("<?=base_url('dashboards/check_org_username')?>", "Verify the organization user name <br/>This may take a few minutes", data, showorgusername, null);
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
 
	function create_random_username(val1){		
		var org_name=$(val1).val();
		var org_name_length=org_name.length;
		var org_username_1=org_name.substring(0,8);				
		var rand_org = Math.floor((Math.random()*1000000)+1);
		var org_username=org_username_1+rand_org;
		$("#organization_username").val(org_username);
	}
	function create_generate_password(){
		PageMethod("<?=base_url('dashboards/create_generate_password_org')?>", "Creating The Password...<br/>This may take a few minutes", null, showPasswordOrg, null);
	}
	function showPasswordOrg(result){
		$.unblockUI();
		if(result.Tag!=''){				
			$("#organization_password").val(result.Tag);
		}
	}
	function newOrganization(){
		//alert(1);
		$('#error_org_uname').hide(); 
		$("#organization_id").val("-1");
		$("#organization_name").val("");
		$("#organization_email").val(""); 
		$("#organization_username").val("");
		$("#organization_password").val("");
		ShowOrganizationEditor();	
	}
	function ShowOrganizationEditor(){ 
		$("#annoucement_edit").hide();
		$("#showannouncement").hide();
		$("#announcements_category_type").hide();
		$("#organization").show();
		$("#showorganizationdetail").hide();
		$('p.organization_email').show();
		$('p.organization_username').show();
		$('p.organization_password').show();
		$('p#change_pwd').hide();
	}
	function HideAnnouncementEditor_org(){ //alert(2);
			$("#annoucement_edit").hide();
			$("#showannouncement").hide();
			$("#announcements_category_type").hide();
			$("#organization").hide();
			$("#showorganizationdetail").show();
			$("#organization_id").val("-1");
			$("#organization_name").val("");
			$("#organization_email").val(""); 
			$("#organization_username").val("");
			$("#organization_password").val("");
			$(".showall_org").click();
	}
	function showallorganization(){ 
		PageMethod("<?=base_url('dashboards/getOrganizationData')?>/"+default_zone, "Display The Organization List...<br/>This may take a few minutes", null, showAccounceInformationOrg, null);
	}
	function showAccounceInformationOrg(result){
		$.unblockUI();
		if(result.Tag!=''){	
			$("#annoucement_edit").hide();
			$("#showannouncement").hide();
			$("#announcements_category_type").hide();
			$("#organization").hide();
			$("#showorganizationdetail").show();
			$("#showorganizationdetail").html(result.Tag);
		}
	}
	function ApprovalOrganization(id,status){ //alert(id);
		PageMethod("<?=base_url('dashboards/ApprovalOrganization')?>" + "/" + id+"/"+status+"/"+default_zone, "", null, showAccounceInformationOrg, null);
	}
	function EditOrganization(id){ //alert(id); return false;
		if(id>0){
			$('p#change_pwd').show();
		}	    	
    	PageMethod("<?=base_url('dashboards/EditOrganization')?>" + "/" + id, "", null, ShowOrganizationEdit, null);
	}
	function ShowOrganizationEdit(result) {
		$.unblockUI();
		$('#error_org_uname').hide();
		$("#annoucement_edit").hide();
		$("#showannouncement").hide();
		$("#announcements_category_type").hide();
		$("#organization").show();
		$("#showorganizationdetail").hide();
		
		$("#organization_id").val(result.id);
		$("#organization_zone").val(result.zoneid);
		$("#organization_name").val(result.name);
		$("#organization_email").val(result.email);
		$("#organization_username").val(result.username);
		/*if($("#organization_username").val(result.username)){
		}*/
		$("#organization_password").val('');
		//$("#organization_zone").val(result.zoneid);
		$('p.organization_email').show();
		$('p.organization_username').show();
		$('p.organization_password').show();   
	}
	function DeleteOrganization(id, title) {
   		 ConfirmDialog("Really delete : " + title, "Delete Organization", "<?=base_url('dashboards/DeleteOrganization')?>", "Deleting Organization<br/>This may take a minute",
        	{ "id": id ,"zone_id" : default_zone}, OrganizationSaveSuccessful, null);
	}
	function check_org_username_save(){
		
		var org_username=$("#organization_username").val();
		var org_id=$("#organization_id").val();
		//alert(org_username); alert(org_id); alert(default_zone);
		var data = { "zoneid": default_zone , "org_username": org_username , "org_id": org_id};
		PageMethod("<?=base_url('dashboards/check_org_username')?>", "", data, showorgusername_save, null);
	}
	function showorgusername_save(result){
		$.unblockUI();
		if(result.Tag==''){
			$('#error_org_uname').html('This username is reserved for zone\'s username. Please try with another username.' );
			$('#error_org_uname').show();
			$('#success_org_uname').hide();
			$('#organization_username').val('');		
		}else{
			//alert(1); return false;
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
			var dataToUse = {
				"id":$("#organization_id").val(),
				"org_name":$("#organization_name").val(),
				"org_email":$("#organization_email").val(),
				"org_username":$("#organization_username").val(),
				"org_password":$("#organization_password").val(),		
				"zone_id": $("#organization_zone").val(),
				"org_type": org_type		
			};
			PageMethod("<?=base_url('dashboards/SaveOrganization')?>", "Saving New Organization<br/>This may take a minute.", dataToUse, OrganizationSaveSuccessful, null);
		}
	}
	function SaveOrganization(){ //alert($("#organization_type").val());return false;
		check_org_username_save();
		
	}
	function OrganizationSaveSuccessful(result) {
		$.unblockUI();
		$("#annoucement_edit").hide();
		$("#showannouncement").hide();
		$("#announcements_category_type").hide();
		$("#organization").hide();
		$("#showorganizationdetail").show();
		$("#showorganizationdetail").html(result.Tag);
		$("#organization_id").val("-1");
		$("#organization_name").val("");
		$("#organization_email").val(""); 
		$("#organization_username").val("");
		$("#organization_password").val("");		
	}
	function allactivate_announcement_by_org(){
		$('.announcements_activate_by_org').click();
	}
	function alldeactivate_announcement_by_org(){
		$('.announcements_deactivate_by_org').click();
	}
/* */
/* Style Tag Part Start */

/* Style Tag Part End */
// email part start partha 18.01.2013
function send_all_business_bulk_new(){
	var id= Array();
	$('.zone_owner_check').each(function (){
    	if($(this).is(':checked')){
			id.push($(this).val());
        }
    });
	var ids=id.join(',');
	if(ids==''){
		alert('Please select business');
		return false;
	}
	$('#eids').val(ids);
	$('#bulk_email').hide();
	$('#body_email').show();
}
function email_back(){
	$('.zone_owner_check').each(function (){
		if($(this).is(':checked')){
			$(this).attr('checked', false);
		}
	});
	$("#email_subject").val('');
    $("#text_message_email").val('');
	$('#bulk_email').show();
	$('#body_email').hide();
}
function sendallemail(){ 
	if($("#email_subject").val()==''){
		alert('Please give subject');
		return false;
	}
	if($("#text_message_email").val()==''){
		alert('Please give message');
		return false;
	}
	//alert($("#eids").val());
        var dataToUse = {
            "uid":$("#eids").val(),
            "subject":$("#email_subject").val(),
            "message": $("#text_message_email").val()
    	};
        PageMethod("<?=base_url('dashboards/sendallemails')?>", "Sending email<br/>This may take a minute.", dataToUse, emailSendSuccessful, null);
    }
	function emailSendSuccessful(result) {
		//alert(result);
        $.unblockUI();
		$('.zone_owner_check').each(function (){
			if($(this).is(':checked')){
				$(this).attr('checked', false);
			}
		});
		$("#email_subject").val('');
        $("#text_message_email").val('');
		$('#bulk_email').show();
		$('#body_email').hide();
	}
	
	function add_mm(zoneid){ 
		$("#add_mm").show();
		$('#view_mm').hide();
		$('#mm_display_dropdown').hide();
		$('#mm_display').hide();
	}
	function save_mm(tag){ 
	//alert(1); return false;
	//alert($('#mm_name').val()); alert($('#ups_mm').val()); alert($('#mm_desc').val());   return false;
	var _f=$(tag).closest('form'); //alert(_f);
	var dataToUse = {
		
		"mm_file":_f.find("#ups_mm").val(),
		"mm_display_name":_f.find("#mm_name").val(),
		"mm_desc":_f.find("#mm_desc").val(),
		
	};
	PageMethod("<?=base_url('dashboards/save_market_materials')?>", "Your ad has been successfully posted.", dataToUse, adsSaveSuccessful, null);
	}
	function adsSaveSuccessful(result) {
		//alert(JSON.stringify(result));
		$.unblockUI();
		//$('div#editAdfromshowad').hide();
		//$('div#editAdfromshowad').show();
		$("#add_mm").hide();
		$('#view_mm').hide();
		//$('#view_mm').show();
		$('#mm_display_dropdown').show();
		$('#mm_display').show();
		$('.showall_mm').click();
		if(result.Tag!=''){	
		show_mm(result.Tag);
		}
	}
	function view_all_mm(zoneid){
		var data={'zoneid':$('#iszoneid').val()};
		PageMethod("<?=base_url('dashboards/view_all_mm')?>", "", data, viewallmmsuccess, null);
	}
	function viewallmmsuccess(result) {
		$.unblockUI();
		if(result.Tag!=''){	
			/*$('#add_mm').hide();
			$('#view_mm').hide();
			$('#mm_display_dropdown').show();*/
			$("#all_mm_display").html(result.Tag);
		}
	}
	function view_mm(zoneid){		
		var data={'zoneid':$('#iszoneid').val()};
		//show_mm(zoneid);
		//$('.showmm_zone').click();
		//alert($('#iszoneid').val()); return false;
		PageMethod("<?=base_url('dashboards/market_materials_zone_dropdown')?>", "", data, viewmmdropdownsuccess, null);
	}
	function viewmmdropdownsuccess(result) {
		$.unblockUI();
		if(result.Tag!=''){	
			$('#add_mm').hide();
			$('#view_mm').hide();
			$('#mm_display_dropdown').show();
			$("#mm_display_dropdown").html(result.Tag);
		}
	}
	
	function show_mm(zoneid){ //alert(zone_option); alert(zoneid); return false;
		if($('#mm_zone').val()=='' || $('#mm_zone').val()==undefined){
			var zone_option='all';
		}else{
			var zone_option=$('#mm_zone').val(); //alert(zone_option);
		}
		var data={'zone_option':zone_option,'zoneid': zoneid};
		PageMethod("<?=base_url('dashboards/market_materials_display')?>", "", data, viewmmsuccess, null);
	}
	function viewmmsuccess(result) {
		$.unblockUI();
		if(result.Tag!=''){	
			$('#add_mm').hide();
			$('#view_mm').hide();
			$('#mm_display_dropdown').show();
			$('#mm_display').show();
			$("#mm_display").html(result.Tag);
		}
	}
	/*function show_market_materials(zoneid){
		$('.showall_mm').click();
		//show_mm(zoneid);
	}*/
	function view_mm_default(zoneid){
		$('#add_mm').hide();
		$('#mm_display_dropdown').hide();
		$('#mm_display').hide();
		$('#view_mm').show();
	}
	function mm_delete(id,zoneid){
	/*var select_id=$("#show_ad_type").val();
	var business_id=$("#all_business").val();*/
	if($('#mm_zone').val()=='' || $('#mm_zone').val()==undefined){
		var zone_option='all';
	}else{
		var zone_option=$('#mm_zone').val(); //alert(zone_option);
	}
	var data = { id : id, zoneid : zoneid, zone_option : zone_option};
	ConfirmDialog("Really remove this from this zone?", "Remove Market Materials", "<?=base_url('dashboards/delete_mm')?>",
			"Successfully Remove ...<br/>This may take a minute", data, DeletemmSuccess, null);
	
	
	}
	function DeletemmSuccess(result){
	$.unblockUI();
		if(result.Tag!=''){	
			$('#mm_display').show();
			$("#mm_display").html(result.Tag);
		}
	}
   
	function change_category(tag){ //alert(tag.value); 
		
		var catid=tag.value;
		var iszoneid=$('#my_current_zone').val();
		var default_value=$('#dropdown_action').val();
		var listed_businessid=$(tag).parent().find('input#listed_businessid').val();
		//alert(catid); alert(iszoneid); alert(default_value); alert(listed_businessid); //return false;
		var data = { cat_id : catid , iszoneid : iszoneid , default_value : default_value, listed_businessid : listed_businessid};
		PageMethod("<?=base_url('dashboards/subcat_listed_business_change_cat')?>", "", data, listedCategorySuccess, null);
	}
	function listedCategorySuccess(result){
		//alert(JSON.stringify(result));
		$.unblockUI();
		var title_result=result.Title; //alert(title_result.subcategoryid);
		var a=result.Message; //alert(a);
		//alert("#listed_subcategory_"+a);
		if(result.Tag!=''){
			//alert("div#listed_subcategory_"+a+'-------------'+$("div#listed_subcategory_"+a).length);	
			$("div#listed_subcategory_"+a).show();
			$("div#listed_subcategory_"+a).html(result.Tag);
			$('#listed_subcategory_'+a).find('option[value='+title_result+']').attr('selected','selected');
		}
	}
	function save_listed_cat_subcat(tag){
		var adid=$(tag).attr('id');
		var catid=$('#'+adid+' select:first').val();
		var subcatid=$('#'+adid+' select:last').val();
		//var subcatid=$(tag).prev('.listed_subcat').val(); 
		//alert(adid); alert(catid); alert(subcatid); return false;
		var data = { adid : adid , catid : catid , subcatid : subcatid};
		PageMethod("<?=base_url('dashboards/save_listed_cat_subcat')?>", "", data, listedCategorySuccess, null);
	}

</script>