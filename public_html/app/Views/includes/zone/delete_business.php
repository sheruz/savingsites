<?php //echo $zoneid;exit; ?><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
.highlited {
  background-color: yellow;
}

.testingServer {
  background-color: #fbfad5;
  border: 1px solid gray;
  padding: 10px;
  position: fixed;
  border-radius:8px;
  width: 354px;
  height: 149px;
}

.testingServer .lightBulb {
  background-image: url("warning.png");
  float: left;
  height: 24px;
  width: 24px;
  z-index: -999;
  background-size: 24px;
  background-repeat: no-repeat;
}

.testingServer .message {
  margin-left: 40px;
  width: 250px;
}
.hide{
/*margin-left:540px;*/
display:none;
}

</style>
</head>

<div id="dialog-password" style="display:none">
<input type="password" id="password_confirm" >
</div>
<input type="hidden" id="businessid" name="businessid" value="<?php echo $businessid;?>"/><input type="hidden" id="zoneid" name="zoneid" value="<?php echo $zoneid;?>"/>
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
	<div class="container_tab_header">Delete All Businesses</div>
    <span style="display:none; font-size:25px; color:red; margin-left: 380px;" id="error_message">Incorrect Password</span>
	<div id="container_tab_content" class="container_tab_content">
    <div class="testingServer1">
    <div class="message">
    <h5>Are you sure you want to delete all businesses from your directory?</h5>
    </div>
    <p class="form-group-row" style=" margin-top:20px">
              <label for="button_save">
                <button id="delete_business"  style="" type="button">Delete All Businesses</button>
              </label>
     </p>
    </div>
    <div class="testingServer hide">
    <div class="message">
    <h3>All Business from your current Zone successfully deleted</h3>
    </div>
  
    </div>
    
    </div>
    </div>
    </div>
    
<script type="text/javascript">
$(document).ready(function () {
	$('#zone_business_accordian').click();
	$('#zone_business_accordian').next().slideDown();
	$('#zone_delete_business').addClass('active');
	$('.bona').show();
	$('#biz_mode_normal').click();
	//var zoneid = $('#zoneid').val();
});
var zoneid = $('#zoneid').val();
$(document).on('click','#delete_business',function(){
	//alert(1);
	$('#error_message').hide() ;
	//var zoneid = $('#zoneid').val();
	var checkdata = {} ;
	if(zoneid != ''){
		$("#dialog-password").dialog({
				resizable: false,
				modal: true,
				title: "Enter Login password",
				height: 150,
				width: 250,
				dialogClass: 'no-close success-dialog',
				buttons: {
					"Ok": function () {
						$(this).dialog('close');
						callback(true);
					},
				}
			});
			
			function callback(value) {
				if (value) {
					popup_password = $('#password_confirm').val();
					checkdata['popup_password'] = popup_password;
					checkdata['zoneid'] = zoneid;
					PageMethod("<?=base_url('Zonedashboard/check_login_password')?>", "Action Performed...<br/>This may take a few minutes", checkdata, matchpassword, null);
				}
			}
	}
})
			function matchpassword(result){ 
				$.unblockUI();
				console.log(result.Tag) ;//
				//var zoneid = $('#zoneid').val();
					if(result.Tag == 'success'){
						var data = {"zoneid":zoneid};//alert(zoneid) ;
						console.log(data) ;
						ConfirmDialog("Do you really want to delete? ", "Delete all businesses","<?php echo base_url('Zonedashboard/delete_all_business_fromzone')?>","Deleting Business <br> This may take a few minute", data, deletesuccess, null);
					}else{
						$('#error_message').show() ;
						/*setTimeout(function(){
						$('#error_message').hide('slow');
						}, 5000);*/
						//return false ;
					}
					
			}
			function deletesuccess(result){
				$.unblockUI();
				//var zoneid = $('#zoneid').val();console.log(result.Tag) ;
				var zoneid = <?php echo $zoneid;?>;
				var data = {"zoneid":zoneid};
					if(result.Tag!=''){ 
						if(result.Tag == 'delete'){
							PageMethod("<?=base_url('Zonedashboard/delete_all_business_fromzone')?>", "Do not refresh the page <br> deleting is in progress", data, deletesuccess, null);
						}else{
							var zoneid = <?php echo $zoneid;?>;
							PageMethod("<?=base_url('Zonedashboard/menu_generator')?>/"+zoneid, "", null, null, null);
							$('.testingServer').hide('slow');
							$('.hide').show('slow');
						}
					}
			}
				

</script>