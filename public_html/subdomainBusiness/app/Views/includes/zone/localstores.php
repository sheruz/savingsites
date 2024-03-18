<?php 
$zone_id = $common['zoneid'] ;
?>
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
    <div class="container_tab_header">Zone Local Stores</div>
    <div id="container_tab_content" class="container_tab_content">
      <ul>
        <li><a href="#tabs-1" id="tab1" onclick="view_local_stores_display(<?=$zone_id?>);">Local Stores</a></li>
        <li><a href="#tabs-2">Upload Local Stores Information</a></li>
      </ul>
      <div id="msg" style="display:none;"></div>
      <div id="tabs-1">
        <div id ="view_local_stores"></div>
      </div>
      <div id="tabs-2">
        <div class="form-group center-block-table">
          <?=form_open("Zonedashboard/save_local_store", "name='localstore_form' id='localstore_form'");?>
          <input type="hidden" id="iszoneid" name="zoneid" value="<?=$zone_id?>"/>
          <p class="form-group-row">
            <label for="store_name" class="fleft w_200">Store Name:</label>
            <input type="text" id="store_name" name="store_name" class="w_536" placeholder="Enter Store Name"/>
          </p>
          <p class="form-group-row">
            <label for="mm_desc" class="fleft w_200">Store Link:</label>
            <textarea rows="10" cols="45" style="width: 536px; height: 150px" id="store_link" name="store_link"></textarea>
          </p>
          <p class="form-group-row">
          	<label for="store_name" class="fleft w_200">Status:</label>
            <input type="radio" name="store_status" value="1" checked="checked">Viewable on directory page
            <input type="radio" name="store_status" value="0" >Not viewable on directory page
          </p>
          <?=form_close()?>
          <button onclick="save_local_store($(this).prev('form'))" style="margin-left:200px;">Submit</button>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function () { 
	$('#adv_tools').click();
	$('#adv_tools').next().slideDown();
	$('#zone_store').click();
	$('#zone_store').next().slideDown();
	$('#tab1').click();
});

function  check_authneticate(){ //alert(1);
	var is_authenticated=0;
	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ //alert('success');
		is_authenticated=data;
	}});	
	return is_authenticated;
}

// + View Local Stores Start
function view_local_stores_display(zoneid){ 
	var authenticate=check_authneticate();
	if(authenticate=='0'){
		var zone_id = <?=$zone_id?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){
		var data={"zoneid":zoneid};
		PageMethod("<?=base_url('Zonedashboard/viewalllocalstores')?>", "Please wait...", data, viewalllocalstoressuccess, null);
	 }
}

function viewalllocalstoressuccess(result) {
	$.unblockUI();
	if(result.Tag!=''){ //alert(JSON.stringify(result));
		$("#view_local_stores").html(result.Tag);
	}
}
// + View Local Stores End

// + Save Local Store Start
function save_local_store(tag){ 
	var dataToUse=$('form#localstore_form').serialize();
	if($("#store_name").val()==undefined || $("#store_name").val()==''){
		alert('Please provide store name.');
		return false;
	}
	if($("#store_link").val()==undefined || $("#store_link").val()==''){
		alert('Please provide store link.');
		return false;
	}
	
	PageMethod("<?=base_url('Zonedashboard/savelocalstore')?>", "", dataToUse, localStoreSaveSuccessful, null);
}
function localStoreSaveSuccessful(result) {
	$.unblockUI();
	$('#localstore_form').trigger("reset");	
	$('#store_name,#store_link').empty();
	$('#store_status').val(1);
	
	$('html,body').animate({scrollTop:0},"slow");
	$('#msg').html('<h4 style="color:#0C0">Local store details has been saved successfully.</h4>').show();
	setTimeout(function(){
		$('#msg').hide('slow');
	},3000);
}
// + Save Local Store End

// + Delete Local Store Start
function store_delete(storeid){	
	var zoneid = <?=$zone_id?>;
	if(storeid != ''){
		var data = { storeid : storeid, zoneid : zoneid};
		ConfirmDialog("Really remove this local store from this zone?", "Warning", "<?=base_url('Zonedashboard/deletelocalstore')?>","Successfully Remove ...<br/>This may take a minute", data, localStoreDeleteSuccessful, null);
	}else{
		return false;
	}
		
}
function localStoreDeleteSuccessful(result){
$.unblockUI();
	if(result.Title!=''){	
		$("#local_store_"+result.Title).hide();
	}
}
// - Delete Local Store End

// + Edit Local Store Start
function store_edit(storeid){
	var zoneid = <?=$zone_id?>;
	window.location.href = "<?=base_url('Zonedashboard/editlocalstore') ?>" + "/" + zoneid + "/" + storeid ;
}
// - Edit Local Store Start

</script>