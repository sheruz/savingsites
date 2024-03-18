

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

	<div class="container_tab_header">Zip Code Detail</div>

	<div id="container_tab_content" class="container_tab_content">

        <!--<ul>

        <li><a href="#tabs-1">Zone Information</a></li>

        <li><a href="#tabs-2">Zone Owner Information</a></li>

        <li><a href="#tabs-3">Change Password</a></li>

        

        </ul>-->

        

<!-- --------------------------------------------------------------------------------------Help Tips---------------------------------------------------------------------------- -->

				<!--<div class="container_tab_header header-default-message"  style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:0px;">

            		<div class="btn-group-2" align="left">

                    	This section will show the created Announcements.

						<a href="javascript:void(0);" class="fright" onclick="$('#helpdiv').slideToggle('slow')"><img alt="Help Tips" title="Help Tips" src="<?=base_url()?>assets/images/help.png" style="margin:3px 0 0 10px" width:"28px" height="28px"/></a>

                    </div>

            	</div>

                	-->

                <div id="help_shot" class="container_tab_header header-default-message" margin-top:10px;>

                    <p>To claim additional zip codes click on the "Claim Additional Zips To Your Master Record" button.<br>To remove your assigned zip codes click on the respective "Remove this Zip code form zone" button.</p>

                </div>

                

<!-- ---------------------------------------------------------------------------------------Help Tips-------------------------------------------------------------------------- -->

        

        <div id="tabs-1">

        	<!-- <div class="form-group">

            <div class="container_tab_header" style="/*background-color:#d2e08f;*/ color:#222; font-size:13px;margin-top:10px; margin-bottom:0px;"><button onclick="javascript:void(0);" title="Claim Additional Zips To Your Master Record" id="claim_zip">Claim Additional Zips To Your Master Record</button></div>

            </div> -->

<div class="container_tab_header bv_assigned_zip" style="/*background-color:#d2e08f;*/ font-size:18px;margin-top:20px; margin-bottom:0px;"><strong>Your Assigned Zip</strong></div>                

<?php /*?><button onclick="window.location.href='<?=base_url()?>';" title="Claim Additional Zips To Your Master Record">Claim Additional Zips To Your Master Record</button><?php */?>



<!-- Athena eSolutions add the empty checking - 29.11.2012 --> 

  <?php if(!empty($not_zip_codes)){ ?>

  <select id="zipToAdd">

	<? foreach($not_zip_codes as $zip){?>

	<option value="<?=$zip['ZIP5']?>">

	<?=$zip['ZIP5']?>

	(

	<?=$zip['City']?>

	)</option>

	<?}?>

  </select>

  <!--<input type="image" class="img16" src="<?=base_url('assets/images/Button-Add-icon.png')?>" onclick="addZipToZone(<?=$zoneid?>);return false;"/> 

  <input type="button" onclick="addZipToZone(<?=$zoneid?>);return false;" title="Add this zip code to <b><?=$zone->name?></b> zone" value='Add this zip code to <strong><?=$zone->name?></strong> zone'/>-->

  <button onclick="addZipToZone(<?=$zoneid?>);return false;"  title="Add this zip code to <?=$zone->name?> zone">Add this zip code to <strong><?=$zone->name?></strong> zone</button>

  <br />

  <?php } ?>

<!-- Athena eSolutions end -->



<?php

if(!empty($zip_codes)){

?>



<table width="100%">

<? $i = 0;

	

	foreach($zip_codes as $zip){

		if($i == 3) { echo("</tr>"); $i = 0;}

		if($i == 0) { echo("<tr>");}

		$i += 1;

		?>



  <td><?=$zip['ZIP5']?>

	(

	<?=$zip['City']?>

	)

	<!--<input type="image" class="img14" src="<?=base_url('assets/images/Actions-edit-delete-icon.png')?>" onclick="removeZipFromZone('<?=$zip['ZIP5']?>', <?=$zoneid?>,'<?=$zip['ZIP5']?>(<?=$zip['City']?>)' );return false;"/>-->

	<button onclick="removeZipFromZone('<?=$zip['ZIP5']?>', <?=$zoneid?>,'<?=$zip['ZIP5']?>(<?=$zip['City']?>)' );return false;"  title="Remove this zip code from <?=$zone->name?> zone">Remove this zip code from <strong><?=$zone->name?></strong> zone</button>

	</td>

  <?}?>

</tr><br />

</table>

<?php

}

?>



            </div>

        </div>

        

        

        

    </div>

    

    

</div>



</div>





<script type="text/javascript">

$(document).ready(function () { 

	$('#zone_data_accordian').click();

	$('#zone_data_accordian').next().slideDown();

	$('#zone_zip').addClass('active');

	$('#about_content1').hide();

});

</script>



<script>



$(document).on('click','#claim_zip',function(){

	var zone_id=<?=$zoneid?>;

	window.location.href='<?=base_url('Zonedashboard/claim_zips')?>/'+zone_id;	

});









function  check_authneticate(){ //alert(1);

	var is_authenticated=0;

	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ //alert('success');

		is_authenticated=data;

	}});	

	return is_authenticated;

}



function removeZipFromZone(zip, zoneId, title) {

	var authenticate=check_authneticate();

	if(authenticate=='0'){

		var zone_id = <?=$zoneid?>;			 

		alert('You are currently logged out. Please log in to continue.');

		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

	}else if(authenticate==1){

		var dataToUse = { "id": zoneId, "zipcode": zip };

		ConfirmDialog("Really remove : " + title + " from this zone?", "Warning", "<?=base_url('Zonedashboard/removeZipFromZone')?>",

			"Remove zip code from this zone<br/>This may take a few minute", dataToUse, UpdateZips, null);

	 }

}



function UpdateZips(result) {//alert(JSON.stringify(result));

    $.unblockUI();

	if(result.Tag==''){

		$("#tabs-1").html('Problem in Assign to Zip. Please Try again later.');

		window.location.reload;

	}else{

    	$("#tabs-1").html(result.Tag);

		window.location.reload;

	}

}

function addZipToZone(zoneId) {

	var authenticate=check_authneticate();

	if(authenticate=='0'){

		var zone_id = <?=$zoneid?>;			 

		alert('You are currently logged out. Please log in to continue.');

		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

	}else if(authenticate==1){

		var zip_id = $("#zipToAdd").val(); 

		var data = { "zone_id": zoneId, "zipcode": zip_id };

		PageMethod("<?=base_url('Zonedashboard/addZipToZone')?>", "Add zip code to this zone...<br/>This may take a few minutes", data, UpdateZips, null);

	}

}

</script>