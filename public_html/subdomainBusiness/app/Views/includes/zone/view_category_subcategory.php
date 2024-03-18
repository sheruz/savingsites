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

    <div class="container_tab_header">View All Categories/Sub-Categories</div>

    <div id="container_tab_content" class="container_tab_content">

      <div id="tabs-1_x" class="cus-sub-category">

        <?php if($count_categories>0){ ?>

        <table width="85%" class="pretty bv_pretty" style="margin-bottom:0;">

          <thead>

            <tr>

              <div class="container_tab_header header-default-message bv_bread_tab"> <p>If you want to make your categories/sub-categories visible to this zone, then click on <strong>'Make Selected Visible'</strong> button. <br>Click on main category name to bring up the sub-categories under it. </p></div>

            </tr>

            <tr>

              <!-- <div class="container_tab_header form-group" style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:0px;"> Click on main category name to bring up the sub-categories under it. </div> -->

            </tr>

          <input type="hidden" name="all_my_zone" id="all_my_zone" value="<?=$all_my_zones?>"/>

          <input type="hidden" name="my_current_zone" id="my_current_zone" value="<?=$zoneid?>"/>

          <tr>

            <th>Main Category Names</th>

            <th>Show<input type="checkbox" onclick="return select_all_category(this);" name="select_all_category" id="select_all_category" value="all"  />Select/Deselect all </th>

          </tr>

          </thead>

          

          <tbody>

            <?php

	$tot=count($categories); 

	$cnt_no=$tot/2;

	$cnt_mod=$tot%2;

	$cnt=0;

	if($cnt_mod==0)

		$cnt=floor($cnt_no);

	else

		$cnt=floor($cnt_no)+1;

	

	?>

          <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:0; margin-bottom:0;">

            <tr>

              <td><table width="50%" align="left" class="pretty bv_pretty" style="width:50% !important; margin-top:0;">

                  <?php for($i=0;$i<$cnt;$i=$i+1){?>

                  <tr>

                    <?php /*?><?php for($j=$i;$j<=$i+1;$j++){ ?><?php */?>

                    <?php if(@$categories[$i]==false) continue;?>

                    <?php if($categories[$i]['id']!=-1){?>

                    <td style="text-align:left !important;"><input type="checkbox" name="check" class="display_checkbox" value="<?php echo $categories[$i]['id'];?>"<? if(strpos(','.$display_categories.',',','.$categories[$i]['id'].',')!==false) echo 'checked="checked"'?> onclick="individual_checkbox();"/>

                      <a style="color:black;" href="javascript:void();" onclick="display_subcat(<?php echo $categories[$i]['id'];?>,<?php echo $zoneid;?>)"><b><?php echo $categories[$i]['catname'];?></b></a></td>

                    <? } ?>

                    <?php /*?><? }?><?php */?>

                  </tr>

                  <? } ?>

                </table>

                <table width="50%" align="left" class="pretty pretty_new vc_pretty_new" style="width:50% !important; clear:none !important; margin-top:0;">

                  <?php for($j=$cnt;$j<$tot;$j=$j+1){?>

                  <tr>

                    <?php if(@$categories[$j]==false) continue;?>

                    <?php if($categories[$j]['id']!=-1){?>

                    <td style="text-align:left !important;"><input type="checkbox" name="check" class="display_checkbox" value="<?php echo $categories[$j]['id'];?>"<? if(strpos(','.$display_categories.',',','.$categories[$j]['id'].',')!==false) echo 'checked="checked"'?> onclick="individual_checkbox();"/>

                      <a style="color:black;" href="javascript:void();" onclick="display_subcat(<?php echo $categories[$j]['id'];?>,<?php echo $zoneid;?>)"><b><?php echo $categories[$j]['catname'];?></b></a></td>

                    <? } ?>

                  </tr>

                  <? } ?>

                </table></td>

            </tr>

          </table>

          <tr>

            <td colspan="2"><button class="my_current_zone" onclick="save_display_category(<?php echo $zoneid;?>);">Make Selected Visible</button>

              <br />

              

              <!--<?php if($display_categories!=0){ ?><button class="all_my_zone" onclick="save_all_my_zone();">Apply To All My Zones</button><? } ?>--></td>

          </tr>

          <tr>

            <!--<td colspan="2"><button class="menu_generator" onclick="menu_genarator(<?php echo $zoneid;?>);"  style="margin-left:229px; margin-top: 10px;">Create a New Main Category for Left Navigation Panel </button></td>-->

          </tr>

          </tbody>

          

        </table>

        <?php } else { ?>

        <p style="padding-left:20px;">Either You have no category or your category does not approved by admin.</p>

        <?php } ?>

      </div>

      <div id="tabs-2_x">

        <div id ="edit_cat"> </div>

        <div id ="edit_subcat"> </div>

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

	$('#zone_view_category_subcategory').addClass('active');

});

</script> 

<script type="text/javascript">

var zoneid = $('#my_current_zone').val();

//function individual_checkbox(){ 

	var total_checkbox=$("input[name=check]").length ;

	var total_checked_checkbox=$("input[name=check]:checked").length; //alert(total_checkbox); alert(total_checked_checkbox);

	if(total_checkbox!=total_checked_checkbox){ 

		 $('#select_all_category').attr('checked', false);		

	}else if(total_checkbox==total_checked_checkbox){

		 $('#select_all_category').attr('checked', true);		

	}	

//}



if($('#my_current_zone').val()==$('#all_my_zone').val()){

	$('.all_my_zone').attr('disabled','disabled');

	$('.my_current_zone').attr('disabled',false);	

}else{

	$('.all_my_zone').attr('disabled',false);

	$('.my_current_zone').attr('disabled',false);

}



function  check_authneticate(){ 

	var is_authenticated=0;

	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ 

		is_authenticated=data;

	}});	

	return is_authenticated;

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



function individual_checkbox(){ 

	var total_checkbox=$("input[name=check]").length ;

	var total_checked_checkbox=$("input[name=check]:checked").length; //alert(total_checkbox); alert(total_checked_checkbox);

	if(total_checkbox!=total_checked_checkbox){ 

		 $('#select_all_category').attr('checked', false);		

	}else if(total_checkbox==total_checked_checkbox){

		 $('#select_all_category').attr('checked', true);		

	}	

}



function display_subcat($catid,$zoneid){

	var authenticate=check_authneticate();

	if(authenticate=='0'){

		var zone_id = <?=$zoneid?>;			 

		alert('You are currently logged out. Please log in to continue.');

		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

	}else if(authenticate==1){

		var dataToUse = {

			"catid":$catid,

			"zoneid":$zoneid

		}

		PageMethod("<?=base_url('Zonedashboard/edit_sub_category_display')?>", "Displaying The Sub Categories...<br/>This may take a few minutes", dataToUse, requestEditSubCategorySuccess, null);

	 }

}



function requestEditSubCategorySuccess(result){

	$.unblockUI();

	if(result.Tag!=''){	

		$("#edit_subcat").html(result.Tag);

		//$("#edit_cat").html('');

		$('#tabs-1_x').hide();

		$('#tabs-2_x').show();

	}

}



function main_category(){ 

	window.location.reload();

	//$('#tabs-1_x').show();

	//$('#tabs-2_x').hide();

}



function save_display_category(zoneid){

	var authenticate=check_authneticate();

	if(authenticate=='0'){

		var zone_id = <?=$zoneid?>;			 

		alert('You are currently logged out. Please log in to continue.');

		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

	}else if(authenticate==1){ 

		var display_checkbox='';		

		$("input[name=check]:Checked").each(function(i,item){ //alert(2);

			display_checkbox+=$(item).val()+',';

		});			

		display_checkbox=display_checkbox.substring(0,display_checkbox.length-1);	

		//alert(display_checkbox); alert(zoneid); return false;

		

		dataToUse={	"catid":display_checkbox,

					"zoneid":zoneid

					

					

		}

		PageMethod("<?=base_url('Zonedashboard/save_zone_cat_display')?>", "Saving Categories for display<br/>This may take a minute.", dataToUse, null, null);

	 }

}





function save_all_my_zone(){ //alert(1); return false; 

	var authenticate=check_authneticate();

	if(authenticate=='0'){

		var zone_id = <?=$zoneid?>;			 

		alert('You are currently logged out. Please log in to continue.');

		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

	}else if(authenticate==1){

		var current_zone=$('#my_current_zone').val(); //alert(this_zones); return false;

		var all_zones=$('#all_my_zone').val();

		var dataToUse = { "all_zone": all_zones};

		

		var dataToUse = {"all_zone": all_zones, "current_zone": current_zone};

		

		ConfirmDialog1("Are you sure to Displaying all categories/subcategories to all of your zones?", "Warning", "<?=base_url('Zonedashboard/save_cat_subcat_all_my_zone')?>",

				"Apply To All My Zone<br/>This may take a minute", dataToUse, null, null);

	 }

}



function menu_genarator(zoneid){

	var authenticate=check_authneticate();

	if(authenticate=='0'){

		var zone_id = <?=$zoneid?>;			 

		alert('You are currently logged out. Please log in to continue.');

		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

	}else if(authenticate==1){

		 dataToUse={"zoneid":zoneid}

		 PageMethod("<?=base_url('Zonedashboard/menu_generator')?>/"+zoneid, "Saving The Menu<br/>This may take a minute.", null, null, null);

	 }

}



function save_display_sub_category(catid,zoneid){ //alert(catid); alert(zoneid); return false;

	var authenticate=check_authneticate();

	if(authenticate=='0'){

		var zone_id = <?=$zoneid?>;			 

		alert('You are currently logged out. Please log in to continue.');

		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

	}else if(authenticate==1){

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

		PageMethod("<?=base_url('Zonedashboard/save_zone_sub_cat_display')?>", "Saving Sub Categories for display<br/>This may take a minute.", dataToUse, null, null);

	 }

}

</script> 

