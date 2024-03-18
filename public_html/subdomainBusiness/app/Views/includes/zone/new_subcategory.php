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
    <div class="container_tab_header">Suggest New Sub-Category</div>
    <div id="container_tab_content" class="container_tab_content">
      <div id="tabs-2_y">
        <div class="form-group">
          <div class="container_tab_header header-default-message"> <p>These categories are not approved by Admin.<br />
            If Admin approve this Sub-Category, then this Sub-Category will be display in all zones.</p></div>
          <div class="spacer"></div>
          <!--<div class="container_tab_header success" style="background-color:#859731; display:none;">You have successfully created the Sub-Category.</div>-->
          <div id="msg"></div>
          <div class="spacer"></div>
          <p class="form-group-row">
            <label for="categoryfrom" class="fleft w_300">Category From</label>
           <!-- T&S ////////// 18/02/2015
            <input type="radio" name="categoryfrom" id="categoryfrom1"  value="2"/>
            All existing Category
            -->
            <input type="radio" name="categoryfrom" id="categoryfrom" value="1"/>
            Category created by you<br />
          </p>
          <div class="spacer"></div>
          <div id="get_categoryfrom" style="display:none;"></div>
          <div class="spacer"></div>
          <p class="form-group-row">
            <label for="email" class="fleft w_300">Sub-Category Name</label>
            <input type="text" id="sub_category_name" name="sub_category_name" class="w_300"  value="" placeholder="Specify Sub-Category Name"/>
          </p>
          <div class="spacer"></div>
          <p class="form-group-row">
            <label for="button_save" >
              <button id="save_sub_category" class="m_left_300" type="button">Save Sub-Category</button>
            </label>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function () { 
	$('#zone_data_accordian').click();
	$('#zone_data_accordian').next().slideDown();
	$('#zcategory').click();
	$('#zcategory').next().slideDown();
	$('#zone_new_subcategory').addClass('active');
	//$('#categoryfrom1').click();   commented by TS on 18.2.15
	$('#categoryfrom').click();
});

function check_authneticate(){ 
	var is_authenticated=0;
	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ 
		is_authenticated=data;
	}});	
	return is_authenticated;
}
/* get categories part start */
$(document).on('click','input[name=categoryfrom]',function(){ 	
	var mode=$(this).val();
	var zoneid=<?=$zoneid?>;
	var data={'zone_id':zoneid, 'mode':mode};
	PageMethod("<?=base_url('Zonedashboard/categories_for_new_subcategory')?>", "Displaying Category...<br/>This may take a few minutes", data, categoryfromSuccess, null);
	
});
function categoryfromSuccess(result){
	$.unblockUI();
	if(result.Tag!=''){
		$("div#get_categoryfrom").show();
	    $("div#get_categoryfrom").html(result.Tag);
		
			if($('#category').val()=='' || $('#category').val()==null){
			    $("#sub_category_name").prop("disabled", true); 
			}else{
		    	$("#sub_category_name").prop("disabled", false); 
			}	
	}
}
/* get categories part end */

$(document).on('click','#save_sub_category',function(){
	var authenticate=check_authneticate();
	if(authenticate=='0'){
		var zone_id = <?=$zoneid?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){
		 if($('#category').val()=='' || $('#category').val()==null){
		   // $("#sub_category_name").attr("disabled", "disabled"); 
			alert("You have no Categories. Please Create Category, then added Subcategory.");
			return false;
		}
		 if($('#sub_category_name').val()==''){
			alert("Specify Sub Category.");
			return false;
		}
		var zoneid=<?=$zoneid?>;
		var dataToUse = {"zone_id":zoneid,"cat_id":$('#category').val(),"sub_cat_name":$('#sub_category_name').val()};	
		PageMethod("<?=base_url('Zonedashboard/save_subcategory_zone')?>", "Saving the new sub category...<br/>This may take a few minutes", dataToUse, requestsubcategorySuccess, null); 
	 }
});
function requestsubcategorySuccess(result){
	$.unblockUI();	
	$('#msg').html('<h4 style="color:#090">New category successfully created</h4>').show();
	$("#sub_category_name").val('');
	//$('.success').show();
	setTimeout(function(){
		$('#msg').hide('slow');
	}, 3000);
}
</script> 
