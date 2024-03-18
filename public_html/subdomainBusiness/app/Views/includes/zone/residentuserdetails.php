<script type="text/javascript">

$(document).ready(function () { 
	$('#adv_tools').click();
	$('#adv_tools').next().slideDown();
	$('#zone_residentuser').click();
	$('#zone_residentuser').next().slideDown();
	$('#residentuser').addClass('active');
	
});


function csvbusinessdownload(){
			window.location.href = '<?=base_url("csvuploader/exportresidentuser.php?zoneid=".$zoneid);?>';
	}
	

</script>




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
 <div class="container_tab_header" style="position:relative;">
    	<div style="padding:12px 0;"><span>View All Resident Users</span><input type="hidden" id="exportpattern" value="" /></div>

    <div style="position:absolute; right:8px; top:8px;">
    	<span><a href="javascript:void(0);" onclick="csvbusinessdownload();"><button style="background-color:#D01B13;color:white; margin-top:7px;"><b>Download Data</b></button></a></span>
    </div>
    </div>

<?php if(!empty($resident_list)) { ?>
<table class="pretty" border="0" cellpadding="0" cellspacing="0">
  <thead id="showhead" class="headerclass">
    <tr> 
      <th width="20%">Contact Name</th>
      <th width="20%">Telephone</th>
      <th width="15">Email</th>
      <!-- <th width="20%">Resident Username</th> -->
      <th width="20%">Resident Userid</th>
   </tr>
  </thead>
  <tbody>

	<?php foreach($resident_list as $details){//echo '<pre>';var_dump($details);exit;

	?>
    <tr id="<?=$details['id']?>" class="uploadbusiness " >
    <td width="20%"><b><?=urldecode(stripslashes($details['first_name']))?>&nbsp;<?=urldecode(stripslashes($details['last_name']))?></b></td>
        <td width="20"><b> <?=$details['phone']?> </b></td>
        <td width="20"><b><?=$details['email']?> </b></td>
        <!-- <td width="15%"><b> <?=urldecode(stripslashes($details['username']))?> </b><br/></td> -->
        <td style="text-align:justify;" width="15%"><b> <?=urldecode($details['id'])?> </b><br/></td> 
    </tr>
    <?php } ?>
   
  </tbody>
</table>
<!--<div id="more_organization" class="text-default" style="float: right; margin-top: 22px;"><a id="more_organization_limit" href="javascript:void(0)" onclick="showResidentDetails(<?=$zoneid?>,'all',this);" style=" color:#000;" rel="0,0">Display More Resident Details</a> </div>-->
 <?php } else{ ?>
    <div class="container_tab_header" id="not_found" style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;">No Resident are Found</div>
    <?php } ?>
   
</div>

 


