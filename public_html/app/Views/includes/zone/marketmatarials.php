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

    <div class="container_tab_header">Zone Marketing Materials</div>

    <div id="container_tab_content" class="container_tab_content">

      <ul>

        <li><a href="#tabs-1" id="tab1" onclick="view_mm_display(<?=$zone_id?>);">Library Of Marketing Materials</a></li>

        <li><a href="#tabs-2">Upload Marketing Materials</a></li>

      </ul>

      <div id="msg" style="display:none;"></div>

      <div id="tabs-1">

        <div id ="view_mm" class="view_new_mm"></div>

      </div>

      <div id="tabs-2" class="bv_market_mm">

        <div class="form-group center-block-table1">

          <?=form_open_multipart("Zonedashboard/save_market_materials", "name='mm_form' id='mm_form'");?>

          <input type="hidden" id="iszoneid" value="<?=$zone_id?>"/>

          <span class="form-group-row">

            <p for="mm_name" class="bold">Material Name</p>

            <input type="text" id="mm_name" name="mm_name" class="w_536" placeholder="Specify Material Name"/>

          </span>

          <span class="form-group-row">
            <br>

            <p for="mm_file" class="bold">Material File Name</p>

            <input type="file" id="mm_<?=$zone_id?>" name="mm_<?=$zone_id?>" onchange="return upload_Image('mm_<?=$zone_id?>','<?php echo site_url("Zonedashboard/upload_mar_mat/mm_".$zone_id."/mm_form");?>','mm_form');"/>

          <p class="form-group-row" style="">Allowed  formats : (<?php echo strtoupper('docx|doc|pdf|xlsx|xls');?>)</p>

          <p class="form-group-row" style="">Max Size : ( 3 MB)</p>

          <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>

          <div id="market" style="margin-left:200px;">

            <input type="hidden" id="ups_mm" name="ups_mm" />

          </div>

          </span>

          <span class="form-group-row">

            <p for="mm_desc" class="bold">Description</p>

            <textarea rows="10" cols="45" style="width: 536px; height: 150px" id="mm_desc" name="mm_desc"></textarea>

          </span>

          <?=form_close()?>

          <button onclick="save_mm($(this).prev('form'))" style="margin-left:170px;">Save</button>

          <!--<button onclick="view_mm_display(<?=$zone_id?>,'all');">Cancel</button>--> 

        </div>

      </div>

    </div>

  </div>

</div>

<script type="text/javascript">

$(document).ready(function () { 

	$('#adv_tools').click();

	$('#adv_tools').next().slideDown();

	$('#zonemarket').click();

	$('#zonemarket').next().slideDown();

	$('#zone_mm').addClass('active');

	$('#tab1').click();

});



function  check_authneticate(){ //alert(1);

	var is_authenticated=0;

	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ //alert('success');

		is_authenticated=data;

	}});	

	return is_authenticated;

}



// + View Marketing Materials Start

function view_mm_display(zoneid){ 

	var authenticate=check_authneticate();

	if(authenticate=='0'){

		var zone_id = <?=$zone_id?>;			 

		alert('You are currently logged out. Please log in to continue.');

		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

	}else if(authenticate==1){

		var data={"zoneid":zoneid};

		PageMethod("<?=base_url('Zonedashboard/view_all_mm')?>", "", data, viewallmmsuccess, null);

	 }

}



function viewallmmsuccess(result) {

	$.unblockUI();

	if(result.Tag!=''){ //alert(JSON.stringify(result));

		$("#view_mm").html(result.Tag);

	}

}

// + View Marketing Materials End



// + Save Marketing Materials Start

function save_mm(tag){ 

var _f=$(tag).closest('form');

if($("#ups_mm").val()==undefined || $("#ups_mm").val()==''){

	alert('Please provide a file for upload.');

	return false;

}

if($("#mm_name").val()==undefined || $("#mm_name").val()==''){

	alert('Please provide Material Name.');

	return false;

}

var dataToUse = {

	"mm_file":_f.find("#ups_mm").val(),

	"mm_display_name":_f.find("#mm_name").val(),

	"mm_desc":_f.find("#mm_desc").val()

};



PageMethod("<?=base_url('Zonedashboard/save_market_materials')?>", "", dataToUse, adsSaveSuccessful, null);

}

function adsSaveSuccessful(result) {

	$.unblockUI();

	$('#mm_form').trigger("reset");	

	$('#market').empty();	

	$('html,body').animate({scrollTop:0},"slow");

	$('#msg').html('<h4 style="color:#0C0">Uploaded Marketing Materials has been saved successfully.</h4>').show();

	setTimeout(function(){

		$('#msg').hide('slow');

	},3000);

}

// + Save Marketing Materials End



// + Delete Marketing Materials

function mm_delete(id,zoneid){	

	if($('#mm_zone').val()=='' || $('#mm_zone').val()==undefined){

		var zone_option='all';

	}else{

		var zone_option=$('#mm_zone').val(); //alert(zone_option);

	}

	var data = { id : id, zoneid : zoneid, zone_option : zone_option};

	ConfirmDialog("Really remove this from this zone?", "Warning", "<?=base_url('Zonedashboard/delete_mm')?>",

			"Successfully Remove ...<br/>This may take a minute", data, DeletemmSuccess, null);	

}

function DeletemmSuccess(result){

$.unblockUI();

	if(result.Title!=''){	

		$("#mm_"+result.Title).hide();

	}

}

// - Delete Marketing Materials



</script>
<style type="text/css">
  .form-group select, .form-group input[type="file"], .form-group input[type="text"],textarea#mm_desc {
 
    width: 100%;
    max-width: 100%;
}
.bold{
  font-weight: 700;
}
div#tabs-2{
  background: url(<?= base_url(); ?>/assets/images/email-form.jpg);
    background-size: cover;
    padding: 40px;
}
.form-group.center-block-table1 {
    background: #fff;
    width: 48%;
    padding: 15px;
        border-radius: 5px;
}
</style>