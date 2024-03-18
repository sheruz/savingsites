<input type="hidden" id="frombus" value="<?=$frombus;?>" />
<!-- Advertisement Part Start-->
<div class="main_content_outer"> 
  
<div class="content_container">
	<div class="container_tab_header">New Advertisement<span id="back_to_advertisement" style="float:right; text-decoration:underline; cursor:pointer;">Back to Advertisement</span></div>
    <div id="msg"></div>
	<div id="container_tab_content" class="container_tab_content">
      <div>
        <div id="ad_display_first_part" ></div>
        <div id="editAdfromshowad">
          <form name="businesses_form22" id="businesses_form22" method="post" action="">
              <input type="hidden" id="foodimage" value=""/>
              <input type="hidden" id="iseditad" value="0"/>
              <input type="hidden" id="iszoneid" value="<?=$zoneid?>"/>
              <input type="hidden" id="ad_id_fromshowad" name="ad_id_fromshowad" value="-1"/>
              <input type="hidden" id="bus_id_againest_advertisement" name="bus_id_againest_advertisement" value=""/>
              <input type="hidden" id="ad_business_fromshowad" name="ad_business_fromshowad" value=""/>
              <input type="hidden" id="bustype" value=""/>
              <input type="hidden" id="duplicate_business" value=""/>			<!-- Added on 10/6/14-->
              <input type="hidden" id="all_bus_id" name="all_bus_id" value="<?=$businessid?>" /> 
              
          <br/>
         <!-- <h3>Advertisement Data</h3>-->
          <br/>
         <div style="display:none;">
                <p class="form-group-row" >
                    <label for="biz_zip_code" class="fleft w_200 m_top_0i">Upload File for Presentation On Deemand</label>
                    <span class="fleft dis_block">  
                    <input type="file" id="docx" name="docx" onchange="return upload_Image('docx','<?php echo site_url("dashboards/upload_docs/docx/businesses_form22");?>','businesses_form22');"/>
                    <p>Allowed  formats : (<?php echo strtoupper('docx|doc|pdf');?>)</p>
                    <p>Max Size : ( 1 MB)</p>
                    
                    <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                    <div id="logo_image22">
                        <input type="hidden" id="docs_pdf" name="docs_pdf" />
                    </div>
                    
                    </span>
                </p>
                </div>
          <p style="display:none;">
            <label for="ad_name_fromshowad" style="width:150px; float:left; display:block; padding-right:10px;">Deal Title</label>
            <input type="text" id="ad_name_fromshowad" name="ad_name_fromshowad"/>
          </p>
          <p>
            <label for="search_engine_title" style="width:150px; float:left; display:block; padding-right:10px;">Deal Title</label>
            <input type="text" id="ad_name_search_engine_title" name="ad_name_search_engine_title" style="width:550px !important; float:left;" />
          </p>
          <p> <span style="margin-left:160px;" id="search_engine_title_display" name="search_engine_title_display"></span> </p>
          <p>
            <label for="ad_code_fromshowad" style="width:150px; float:left; display:block; padding-right:10px;">Offer Code</label>
            <input type="text" id="ad_code_fromshowad" name="ad_code_fromshowad" style="width:550px !important;"/>
          </p>
          <p>
            <label for="ad_startdatetime_fromshowad" style="width:150px; float:left; display:block; padding-right:10px;">Start Date Time</label>
            <input type="text" id="ad_startdatetime_fromshowad" name="ad_startdatetime_fromshowad" style="width:550px !important;"/>
          </p>
          <p>
            <label for="ad_stopdatetime_fromshowad" style="width:150px; float:left; display:block; padding-right:10px;">Stop Date Time</label>
            <input type="text" id="ad_stopdatetime_fromshowad" name="ad_stopdatetime_fromshowad" style="width:550px !important;"/>
          </p>
          <!-- date time custom -->
          <div id="ad_cat" >
            <p>
           		 <b>Select multiple categories and multiple sub categories by holding the "Ctrl" key and a left click on the mouse.</b>
            </p>
            <p>
              <label for="ad_category_fromshowad" style="width:150px; float:left; display:block; padding-right:10px;">Category</label>
              <select id="ad_category_fromshowad" name="ad_category_fromshowad" onchange="business_cat()" multiple="multiple" size="10">
                <!--<option value="0"> --- Select Category --- </option>-->
                <? foreach ($category_list1 as $category) { ?>
                	
                	<option class='optioncategory' value=<?php echo $category['id']?><?php if($category['id']=='-99'){?> disabled="disabled" <?php } ?>><?php echo $category['name']?> </option>
                    
                                <?php /*?>echo("<option value='" . $category['id'] . "' class='optioncategory'>" . $category['name'] . "</option>");<?php */?>
				<? }?>
              </select>
            </p>
          </div>

          <br clear="all" />
          <div class="food_menu" style="display:none;">
            <label for="ad_name_fromshowad" style="width:150px; float:left; display:block; padding-right:10px;">Upload File for Menu</label>
            <input type="file" id="docx_foodmenu" name="docx_foodmenu" onchange="return upload_Image('docx_foodmenu','<?php echo site_url("dashboards/upload_docs_foodmenu/docx_foodmenu/businesses_form22");?>','businesses_form22');"/>
            <p>Allowed  formats : (<?php echo strtoupper('docx|doc|pdf');?>) &nbsp;Max Size : ( 1 MB)</p>
            <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
            <div id="logo_image222">
              <input type="hidden" id="docs_foodmenu" name="docs_foodmenu" />
            </div>
            <p id="docs_foodmenu_show" style="display:none;">
              <label for="ad_name_fromshowad" style="width:150px; float:left; display:block; padding-right:10px;">Upload File</label>
              <label id="docs_pdf_foodmenu" name="docs_pdf_foodmenu"></label>
            </p>
          </div>
          <div id="ad_subcategory_fromshowad1" style="display:none"> </div>
          <div style="clear:both;"></div>
          <p>
            <label for="ad_text_fromshowad">Ad Details</label>
            <textarea id="ad_text_fromshowad" class="dashboard_editor_textarea" name="ad_text_fromshowad"></textarea>
            <?php echo display_ckeditor($ckeditor_businessad); ?>
            <?php /*?><span class="fleft dis_block"> 
          <textarea id="ad_text_fromshowad" class="anish" name="ad_text_fromshowad" style="padding-left:150px !important"></textarea>
          
          </span> <?php */?>
           </p> 
            
          <p style="display:none;">
            <label for="text_message_fromshowad" style="width:150px; float:left; display:block; padding-right:10px;">Text Message</label>
            <textarea rows="10" cols="45" style="width: 425px; height: 150px" id="text_message_fromshowad" name="text_message_fromshowad"></textarea>
          </p>
          <?php /*?><?=form_close()?><?php */?>
          <button type="button" style="margin-left:160px;" onclick="save_new_ad_from_zone()">Save Advertisement</button>
         
      </form>   
        </div>
      </div>
      <!-- Advertisement Part End--> 
      </div>
  </div>
</div>
<script>
$(document).ready(function () { 
$('#zone_advertisement_accordian').click();
if($('#frombus').val() == 0){
	$('#zone_nontemp_advertisement').addClass('active');
}else if($('#frombus').val() == 1){
	$('#zone_temp_advertisement').addClass('active');
}
newadfromshowad();
});
</script>

<script>
var zone_id = '<?=$zoneid;?>'; 	

function  check_authneticate(){ //alert(1);
	var is_authenticated=0;
	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ //alert('success');
		is_authenticated=data;
	}});	
	return is_authenticated;
}
var businessid_select = 0;

// + date picker , default ck editor text, set blank fields
function newadfromshowad(){ 
	if($('#busvalue').val() == 1){
		$('#ad_category_fromshowad option[value=-99]').prop('disabled',false);
	}
	else if($('#busvalue').val() == 0){
		$('#ad_category_fromshowad option[value=-99]').prop('disabled',true);
	}
	
	$('#ad_display_first_part').hide();
	$("#ad_name_search_engine_title").val("");
	$("#search_engine_title_display").val("");
	$('#search_engine_title_display').html('');
	$("#docs_pdf_show").hide();
	$(".food_menu").hide();
	$("#docs_foodmenu_show").hide();
	$("#ad_id_fromshowad").val("-1");
	$("#ad_name_fromshowad").val("");
	$("#ad_code_fromshowad").val("");	
	
	$("#ad_category_fromshowad").val("");
	$("#ad_subcategory_fromshowad").val("");
	$("#ad_subcategory_fromshowad1").hide();
	$(".food_icon_image").hide();
	CKEDITOR.instances.ad_text_fromshowad.setData( "Your Ad Here!" );
	//ShowAdEditViewfromshowad();
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
	
	fn_create_search_engine_title();
}
// - date picker , default ck editor text, set blank fields

// + Set Deal Title
function fn_create_search_engine_title(){ 
	var zone_id=$('#zoneid').val();
	var business_id=$('#all_bus_id').val(); //alert(zone_id); alert(business_id);
	var data_to_use={'zoneid':zone_id,'business_id':business_id};
	$.ajax({
        'type': "GET",
		'data':data_to_use,
		'url': "<?=base_url('/businessdashboard/make_search_engine_title')?>",			
        'cache': false,
        'success': function(data){ 
		 	var str=data; 
			var abc=str.split('#@!');
			var zone_name=abc[0];
			var business_name=abc[1]; 
			var value_zone_arr=zone_name.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g,'-').toLowerCase();
			var value_business_arr=business_name.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g,'-').toLowerCase();
			var value_zone=value_zone_arr.replace('--','-');
			var value_business=value_business_arr.replace('--','-');
			var deal_title='deal-title';
			var value=value_zone+'-'+value_business+'-'+deal_title;
			if(value!=''){
				var val_final=value;
				$("#ad_name_search_engine_title").val(val_final);
				$('span#search_engine_title_display').text('www.savingssites.com/zone/'+value_zone+'/'+value_business+'/'+val_final);
			}
		}
	});
}

$(document).on('blur','#ad_name_search_engine_title',function(){		
	var tag=this;
	var zone_id=$('#zoneid').val();
	var business_id=$('#all_bus_id').val(); 
	var data_to_use={'zoneid':zone_id,'business_id':business_id};
	$.ajax({
		'type': "GET",
		'data':data_to_use,
		'url': "<?=base_url('/businessdashboard/make_search_engine_title')?>",			
		'cache': false,
		'success': function(data){ 
			var str=data; 
			var abc=str.split('#@!');
			var zone_name=abc[0];
			var business_name=abc[1]; 
			var value_zone_arr=zone_name.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g,'-').toLowerCase();
			var value_business_arr=business_name.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g,'-').toLowerCase();
			var value_zone=value_zone_arr.replace('--','-');
			var value_business=value_business_arr.replace('--','-');
			var str=$(tag).val();
			var value_deal_title_arr=str.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g,'-').toLowerCase();
			var lastChar = value_deal_title_arr.substr(value_deal_title_arr.length - 1);
			if(lastChar=='-')
				var deal_title=value_deal_title_arr.slice(0,-1);
			else
				var deal_title=value_deal_title_arr;
			//var value=value_zone+'-'+value_business+'-'+deal_title;
			//alert(deal_title);
			if(deal_title!=''){
				var val_final=deal_title;
				//$("#search_engine_title").val(val_final);
				$('span#search_engine_title_display').text('www.savingssites.com/zone/'+value_zone+'/'+value_business+'/'+val_final);
			}else{
				$('span#search_engine_title_display').text('');
			}
		}
	});
		
});

// + Set Deal Title




// + Business category Showing
function business_cat(subcat_id_foredit){
	if(subcat_id_foredit=='' || subcat_id_foredit==undefined)
		var subcat_id_foredit=0;
	else
		var subcat_id_foredit=subcat_id_foredit;
	var cat_id=$('#ad_category_fromshowad').val();
	var iszoneid=zone_id;
	
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

// - Business category Showing

// + Save New Ads/Success
function save_new_ad_from_zone(tag){    //alert($('<div/>').html(CKEDITOR.instances.ad_text_fromshowad.getData()).text()); return false;
	var authenticate=check_authneticate();
	if(authenticate=='0'){
		var zone_id = <?=$zoneid?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){
		var _f=$(tag).closest('form'); 					
		if($('#ad_id_fromshowad').val()=='-1'){
			var bus_id=$('#all_bus_id').val();
		}else{
			var bus_id=$('#bus_id_againest_advertisement').val();
		} 
		if($('#ad_category_fromshowad').val()!=''){ 
			var catid=$('#ad_category_fromshowad').val();
		}else{
			var catid=0;
		}
		
		var display_cat='';	
		$('.optioncategory:selected').each(function(i, j){ 			
			display_cat+=$(j).val()+',';
		});
		display_cat=display_cat.substring(0,display_cat.length-1);
		
		var display_cat_subcat='';	
		$('.optiondropdown:selected').each(function(i, j){ 			
			display_cat_subcat+=$(j).val()+',';
		});
		display_cat_subcat=display_cat_subcat.substring(0,display_cat_subcat.length-1);

		if(display_cat==''){
			alert('Please select category.');
			return false;
		}
		if(display_cat_subcat==''){
			alert('Please select sub category.');
			return false;
		}
		
		var ad_startdatetime = Date.parse($("#ad_startdatetime_fromshowad").val());		
		var ad_stopdatetime = Date.parse($("#ad_stopdatetime_fromshowad").val());		
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
			"id":$("#ad_id_fromshowad").val(),
			"iseditad":$("#iseditad").val(),
			"offer_code" :$("#ad_code_fromshowad").val(),
			"docs_pdf":$("#docs_pdf").val(),
			"docs_pdf_foodmenu":$("#docs_foodmenu").val(),
			"name":$("#ad_name_fromshowad").val(),
			"biz_list" : "true",
			"ad_stopdatetime":$("#ad_stopdatetime_fromshowad").val(),
			"ad_startdatetime":$("#ad_startdatetime_fromshowad").val(),
			'zoneid':'<?=$zoneid?>',
			"business_id":bus_id,
			"adtext": decodeURI(CKEDITOR.instances.ad_text_fromshowad.getData()),		
			"category_id": $("#ad_category_fromshowad").val(),
			"subcategory_id": $("#ad_subcategory_fromshowad").val(),
			"category_id": catid,
			"subcategory_id": display_cat_subcat,
			"imagetype": $("#foodimage").val(),		
			"active" : "1",
			"text_message": $("#text_message_fromshowad").val(),
			"search_engine_title":$('#search_engine_title_display').text()
		};
		//console.log(dataToUse); return false;
	   PageMethod("<?=base_url('Zonedashboard/saveAdfromshowad')?>", "Your ad has been successfully posted.", dataToUse, adsSaveSuccessful1, null);
	 }
}
function adsSaveSuccessful1(result) {
	$.unblockUI();
	if(result.Title == 1){
		$('#msg').html('<h4 style="color:#090">New Advertisement successfully created.</h4>');	
		$('html,body').animate({scrollTop:0},"slow");
		setTimeout(function(){$("#msg").hide('slow');},3000);
		CKEDITOR.instances.ad_text_fromshowad.setData('');
		$('#businesses_form22').each(function(){
   			this.reset();
		});
	}
}

// - Save New Ads/Success

// + Back to Advertisement
$(document).on('click','#back_to_advertisement',function(){ 
	window.location = '<?=$back_url?>' ;
});
// + Back to Advertisement
</script>
