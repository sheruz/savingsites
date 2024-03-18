<style>

.highlited {

  background-color: yellow;

}

.form-group.center-block-table {
    display: inline-block;
    width: 100%;
}
.dynamic-field{
  width: 61% !important;
}

.ui-widget button {
    color: #1c198a !important;
}
.col-md-2.mt-30.append-buttons {
    margin-top: 52px;
    position: absolute;
    top: 64px;
    right: 20%;
}
.testingServer {

  background-color: #fbfad5;

  border: 1px solid gray;

  padding: 15px;

  border-radius:8px;

  width: 200px;

  margin-left:20px;

  margin-top:12px;

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

}

.hide{

margin-left:540px;

display:none;

}
.append-buttons  button#add-button{
 color: #000
}


</style>



<?php 
  extract($data);
?>
<input type="hidden" name="username" value="<?=$zone_owner->username?>">

<input type="hidden" name="userid" value="<?=$common['user']->id?>">




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

              <font style="">Search All Businesses(Real Active Ads, Businesses Uploaded, Biz Opp Providers, Inactive Ads)</font> 

              <input type="text" id="global_bus_search" name="global_bus_search" class="text-input" placeholder="Business name or phone no. or id" style="" value="<?= $business_search_value; ?>" />

              <button class="btn-sm"  id="global_bus_search_btn" type="button" style="">Search</button>         

              <button class="btn-sm global_search_close hide_search_result" type="button" style="display:none">Clear Search</button>

            </div>

            <div id="no_bus_found" style="margin-left:15px;" class="fleft w_300"></div>

          </div>

        </div>

        <div id="view_global_bus_search_div" style="width:1130px; margin:10px auto 0; background-color:#d2e08f; display:none; overflow:hidden; padding:10px;">

          <div id="view_global_bus_search" class="fleft" style="width:1080px;"></div>
            <a style="margin:-10px 20px 0 0;" href="javascript:void(0)" class="close" onClick="$('#view_global_bus_search_div').slideToggle();">
              <img src="<?=base_url('assets/images/close_pop.png') ?>" class="btn_close global_search_close" title="Close Window" alt="Close" >
            </a>

      </div>

    </div>



<?php } ?>   

 

<div id="container_tab_content" class="container_tab_content">
<div class="container_tab_header">Zone Detail Information
 
</div>
	<div id="tabs">
        <ul>

            <li><a href="#tabs-1">Zone Information</a></li>

            <li><a href="#tabs-2">Update Zone Owner Information</a></li>

            <li><a href="#tabs-3">Change Password</a></li>

            <li><a href="#tabs-4">Credits</a></li>

            <li><a href="#tabs-5">Zone Logo</a></li>

            <li><a href="#tabs-6">Theme Color</a></li>

    				<li><a href="#tabs-7">Short Url</a></li>

            <li><a href="#tabs-8">Settings</a></li>

        </ul>

        <div style="" id="update_message"></div>

        <div id="tabs-1">

        	<div class="form-group">

            <div id="help_shot" class="container_tab_header header-default-message" margin-top:10px;>

                    <p>The "Zone information" tab shows the Zone Owner details. To change from one zone to another select from the dropdown the desired name of the zone you want to visit. After selection redirection will happen automatically.</p>

            </div>

        <div class="container_tab_header" style="/*background-color:#d2e08f;*/ color:#222; font-size:13px;margin-top:10px; margin-bottom:10px;">

        <input type="button" onclick="newZone();return false;" title="Create New Zone" value="Create New Zone" id="createzone"/>

        <input type="button" onclick="editName();return false;" title="Rename Zone" value="Rename Zone" id="renamezone"/>

        <input type="button" onclick="deleteZone(<?=$zone_id?>);return false;" title="Delete This Zone" value="Delete Zone" id="deletezone" style="display:none;"/>

        <input type="button" onclick="saveZoneName();return false;" title="Save Zone" value="Save Zone" id="savezone"/>

        <input type="button" onclick="cancelEditName();return false;"  title="Cancel Edit" value="Cancel" id="canceledit"/>

        </div>

        <? if(!empty($my_zones) && count($my_zones) > 1){?>

        <label for="myZones" style="float: left;"><b>Change Zone</b></label>

        <select id="myZones">

            <option value="-1" selected="selected" disabled="disabled">--- Select A Zone To Change To ---</option>

            <? foreach($my_zones as $my_zone){ if($my_zone['id'] == $zone_id) { continue; }?>

            <option value="<?=$my_zone['id']?>">

            <?=$my_zone['name']?>

            </option>

            <? } ?>

        </select>

        </br>

        <? } ?>

        <div id="zoneData"> 
<div class="container cus-zone-information bv_table_row">

  <table class="rwd-table">
    <tbody>
    <!--   <tr>
      
        <th>Due Date</th>
        <th>Net Amount</th>
      </tr> -->
      <tr>
        <td data-th="Supplier Code">
      Zone Name 
        </td>
        <td data-th="Supplier Name">
       <?=$zone['name']?>
        <span id="zoneNameEdit">

          <input type="text" id="zoneName" value="<?=$zone['name']?>"/>

          <button id="button" onclick="zone_verification();" >Check Zone Name Availability</button>

          </span> 
          <span id="error_zname" style="margin:0 0 8px 222px; background:#F00; color:#fff; padding:3px 10px; width:380px; display:block; border-radius: 7px;"></span> <span id="success_zname" style="color:#fff; margin:0 0 0 222px; background:#063; padding:3px 10px; width:380px; display:block; border-radius: 7px;"></span> 
        </td>     
      </tr>

      <tr>
        <td data-th="Supplier Code">
     Zone Owner 
        </td>
        <td data-th="Supplier Name">
           <?= htmlentities(urldecode($zone_owner->first_name))?>

          <?= htmlentities(urldecode($zone_owner->last_name)) ?>
        </td>     
      </tr>


        <?if(!empty($total_business)){ ?>

             <tr>

        <td > Total Businesses</td>

        <td >  <?=$total_business[0]['countbus']?> </td>

          <tr/>

            <tr>

        <td >Businesses Uploaded</td>

         <td> <?=$active_coming_soon_bus[0]['countbus'] + $inactive_coming_soon_bus[0]['countbus']?>

          (Viewable: <?= $active_coming_soon_bus[0]['countbus']?>, Not Viewable:<?= $inactive_coming_soon_bus[0]['countbus']?>)</td>

          </tr>

          <tr>

          <td>Free Trial</td>

         <td> <?=$active_trial[0]['countbus'] + $inactive_trial[0]['countbus']?>

          (Viewable: <?= $active_trial[0]['countbus']?>, Not Viewable:<?= $inactive_trial[0]['countbus']?>) </td>

          <tr/>

          <tr>

          <td>Paid</td>

          <td><?=$active_paid[0]['countbus'] + $inactive_paid[0]['countbus']?>

          (Viewable: <?= $active_paid[0]['countbus']?>, Not Viewable:<?= $inactive_paid[0]['countbus']?>)</td>

          </tr>

          <? }  ?>





          <?if(!empty($total_ads)){ ?>
         <tr>
          <td>Total Ads</td>

        <td>  <?=$total_ads[0]['countad']?></td>

          </tr>

          <tr>

          <td>Businesses Uploaded</td>

          <td><?=$active_coming_soon[0]['countad'] + $inactive_coming_soon[0]['countad']?>

          (Active: <?= $active_coming_soon[0]['countad']?>, Inactive:<?= $inactive_coming_soon[0]['countad']?>)</td>

          </tr>

          <tr>

          <td>Real Active Ads</td>

          <td><?=$active_realad[0]['countad']?></td>

         </tr>

         <tr>

          <td>Real Inactive Ads</td>

         <td> <?=$inactive_realad[0]['countad']?> </td>

        </tr>

          <? } ?>


          <tr>
            <td>Zone Url </td>

           <td>  <a target="_blank" href="<?=base_url('/zone')?>/<?=$zone['seo_zone_name']?>" style="color:#000;">

          <?=base_url('/zone')?>/<?=$zone['seo_zone_name']?>

          </a></td>
            </tr>






 
      
    </tbody>
  </table>

</div>










 
        

 

      </div>

            </div>

        </div>

        <div id="tabs-2" class="form-group center-block-table">

        	<div id="help_shot" class="container_tab_header header-default-message" >

                    <!--<p>The "Zone information" tab shows the Zone Owner details. To change from one zone to another select from the dropdown the desired name of the zone you want to visit. After selection redirection will happen automatically.</p>-->

                    <p>To update the owner information click on the "Update Zone Owner Information" tab. Click on the "Update" button to save your changes.cccc</p>

                    <!--<p>To update your password click on the "Change Password" tab. Enter the required and click on the "Update" button to save your changes.</p>-->

                </div>

               
<div class="row">
  <div class="col-md-6 bv_align_center">
    <img src="<?php echo base_url() ?>/assets/images/pexels-mati.jpg" style="margin-top: 40px;">
  </div>
   <div class="col-md-6 bv_zonetest_col">
      <div class="form-group center-block-table1 cus-zone-form">
               <p style="color:red" class="req-field">(*)These fields are required </p> 

                <form id="user-form" class="form-validate" enctype="multipart/form-data" name="adminForm" method="post" action="">

                <input type="hidden" id="userid" name="userid" value=""/>

                    <p class="form-group-row">

                    <label for="username" class="fleft w_100 m_top_0i cus-user">Username : <b><?=$zone_owner->username?></b></label>

                    </p>

                    

                    <p class="form-group-row">

                      <label for="email" class="fleft w_100">Email<span style="color:red">*</span></label>

                      <input type="text" id="jform_Email" name="jform_Email" class="w_300"  value="<?=$zone_owner->email?>" />

                      <div id="error_contact_email"></div>

                    </p>

                    <div style="margin-left: 100px;display:none;  background-color: wheat; height: 25px; border-radius: 7px;width: 245px;"id="email_notice" >

                    <span style="color:red;  margin-left: 12px;"/> Please enter valid Email address </span>

                    </div>

                    

                    <p class="form-group-row">

                      <label for="firstname" class="fleft w_100">First Name</label>

                      <input type="text" id="jform_Firstname" name="jform_Firstname" class="w_300"  value="<?=$zone_owner->first_name?>" />

                    </p>

                    

                    <p class="form-group-row">

                      <label for="lastname" class="fleft w_100">Last Name</label>

                      <input type="text" id="jform_Lastname" name="jform_Lastname" class="w_300" value="<?=$zone_owner->last_name?>" />

                    </p>

                    

                    <p class="form-group-row">

                      <label for="phone" class="fleft w_100">Phone</label>

                      <input type="text" id="jform_Phone" name="jform_Phone" class="w_300" value="<?=$zone_owner->phone?>" />

                    </p>

                    

                    <p class="form-group-row">

                      <label for="address" class="fleft w_100">Address</label>

                      <input type="text" id="jform_Address" name="jform_Address" class="w_300"  value="<?=$zone_owner->Address?>" />

                    </p>

                    

                    <p class="form-group-row">

                      <label for="city" class="fleft w_100">City</label>

                      <input type="text" id="jform_City" name="jform_City" class="w_300"  value="<?=$zone_owner->City?>" />

                    </p>

                    

                    <p class="form-group-row">

                      <label for="lastname" class="fleft w_100">State</label>

                      <? //= form_dropdown("State", $state_list, (!empty($zone_owner->State_Code) ? $zone_owner->State_Code : ''), 'id="jform_State" style="width:316px;"');?>

                    </p>

                    

                    <p class="form-group-row">

                      <label for="zip1" class="fleft w_100">Zip</label>

                      <input type="text" id="jform_Zip" name="jform_Zip" class="w_300"  value="<?=$zone_owner->Zip?>" />

                    </p>

                    

                    <p class="form-group-row  btn_new">

                      <label for="zip1">

                        <button onclick="UpdateProfile();return false;" class="m_left_100" name="update_profile">Update</button>

                      </label>

                    </p>

                    

                </form>

              </div>
   </div>
</div>
           



        </div>

        <div id="tabs-3">

        <div id="help_shot" class="container_tab_header header-default-message" margin-top:10px;>

                    <!--<p>The "Zone information" tab shows the Zone Owner details. To change from one zone to another select from the dropdown the desired name of the zone you want to visit. After selection redirection will happen automatically.</p>

                    <p>To update the owner information click on the "Update Zone Owner Information" tab. Click on the "Update" button to save your changes.</p>-->

                    <p>To update your password click on the "Change Password" tab. Enter the required and click on the "Update" button to save your changes.</p>

                </div>

        	<div class="form-group center-block-table">

                <form id="user-form-password" class="form-validate fleft" enctype="multipart/form-data" name="adminForm" method="post" action="">

                	<input type="hidden" id="userid" name="userid" value="<?=$userId?>"/>

                    <p>

                      <label for="current_pass" class="fleft w_150">Current Password</label>

                      <input type="password" class="w_300" id="current_pass" name="current_pass"  value="" />

                    </p>

                    <p>

                      <label for="new_pass" class="fleft w_150">New Password</label>

                      <input type="password" class="w_300" id="new_pass" name="new_pass"  value="" />

                    </p>

                    <span id="error_new_password" style="margin:0px 0px 8px 0; background:#F00; font-weight:bold; color:#fff; padding:3px; width:450px; display:block; text-align:center; display:none;"></span>

                    <p>

                      <label for="confirm_pass" class="fleft w_150">Confirm Password</label>

                      <input type="password" class="w_300" id="confirm_pass" name="confirm_pass"  value="" />

                    </p>

                    <span id="error_confirm_password" style="margin:0px 0px 8px 0; background:#F00; font-weight:bold; color:#fff; padding:3px; width:450px; display:block; text-align:center; display:none; float:right"></span>

                    <p>

                      <label for="zip1">

                        <button class="m_left_150" onclick="UpdatePassword();return false;">Update</button>

                      </label>

                    </p>

      			</form>

                <div class="testingServer fleft new">

                    <div class="message">

                      <h4 style="color:red; margin-top:0;">Case sensitive, combination of 10-18 letters, numbers and special characters (!, @, #, $, %, &) </h4>

                    </div>

            	</div>

            </div>

            

            

            

        </div>



        <div id="tabs-4">

          <div style="margin-top:20px">

            <b>Current Credit</b>: 

            <?php //$curent_credit = $credits[0]["credits"]; 

                  //echo $curent_credit;

            ?>

          </div>    

        </div>

		

        <div id="tabs-6">

          <div style="    margin-top: 45px;margin-bottom: 36px;">

            <b>Select theme color for your site</b>:<br />

            <select id="themeChange" onchange="changeTheme()">

            <option <?php if ($theme_color == "purple"){echo 'selected="selected"';} ?> value="purple">Fun Purple</option>

            <option <?php if ($theme_color == "brown"){echo 'selected="selected"';} ?> value="brown">Cozy Brown</option>

            <option <?php if ($theme_color == "green"){echo 'selected="selected"';} ?> value="green">Save Green</option>

            <option <?php if ($theme_color == "blue"){echo 'selected="selected"';} ?> value="blue">Old Glory</option>

            </select>

            <p class="error_msg"></p>

          </div>

        </div>



				<div id="tabs-7">

					<div id="help_shot" class="container_tab_header header-default-message" >

						<!--<p>The "Zone information" tab shows the Zone Owner details. To change from one zone to another select from the dropdown the desired name of the zone you want to visit. After selection redirection will happen automatically.</p>-->

						<p>To update the owner theme click on the "Zone Theme" tab. Click on the "Update" button to save your changes.</p>

						<!--<p>To update your password click on the "Change Password" tab. Enter the required and click on the "Update" button to save your changes.</p>-->

					</div>

						<div class="form-group center-block-table">

								<form id="user-short-form" class="form-validate" enctype="multipart/form-data" name="adminForm" method="post" action="">

								<!-- <input type="hidden" id="userid" name="userid" value=""/> -->



										<p class="form-group-row">

											<label for="shortUrl" class="fleft w_100">Short Url(*)</label>

											<input typr="text" name="shortUrl" id="shortUrl" value="<?=(!empty($get_short_urlinfo['short_url']) ? $get_short_urlinfo['short_url'] : '')?>">

											<span class="shortUrlerror"> </span>

										</p>



										<p class="form-group-row">

											<label for="zip1">

												<button onclick="UpdateShortUrl();return false;" class="m_left_100" name="update_theme">Update</button>

											</label>

										</p>                  

										

								</form>

							</div>

					</div>




        <div id="tabs-8">         

            <div class="form-group center-block-table">
             
                
          <form action="" method="post">
             <div class="row" style="align-items: center;">
  
                  <?php if($discountrate){ 

                    foreach (json_decode($discountrate) as   $value) {
                          
                      ?>
                  <div class="col-md-10 dynamic-field" id="dynamic-field-1">
                    <div class="row" >                       
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="field" class="hidden-md">Discount(%)</label>
                          <input type="text" id="field" class="form-control" value="<?php echo $value->key ?>" name="field[]" />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Number of Orders</label>
                          <input type="text" class="form-control" value="<?php echo $value->value ?>" name="order[]">
                        </div>
                      </div>
                    </div>
                  </div>

         <?php  } 
         }else{  ?>


             <div class="col-md-10 dynamic-field" id="dynamic-field-1">
                    <div class="row" >                       
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="field" class="hidden-md">Discount(%)</label>
                          <input type="text" id="field" class="form-control" name="field[]" />
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Number of Orders</label>
                          <input type="text" class="form-control" name="order[]">
                        </div>
                      </div>
                    </div>
                  </div>
        <?php  } ?>





                  <div class="col-md-2 mt-30 append-buttons">
                    <div class="clearfix">
                      <button type="button" id="add-button" class="btn btn-secondary float-left text-uppercase shadow-sm"><i class="fa fa-plus fa-fw"></i>
                      </button>
                      <button type="button" id="remove-button" class="btn btn-secondary float-left text-uppercase ml-1" ><i class="fa fa-minus fa-fw"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <input type="hidden" name="zoneid" class="zoneid" value="<?php echo $zone_id; ?>" >
                <input type="button" name="buttonAdd" value="Submit" class="buttonAdd">
          </form>    



              </div>

          </div>



		<div id="tabs-5">

			<form name="frm_banner" id="add_banner_forzone" method="post" onsubmit="save_banner()" enctype="multipart/form-data"  action="javascript:void(0);">

			  <table width="100%" border="0" align="left" cellpadding="1" cellspacing="1" bgcolor="#999999">

				<tr>

				  <td  valign="top" bgcolor="#FFFFFF">

					<table width="95%" border="0" cellspacing="1" cellpadding="4" >

					  <div class="form_error" style="display:none;"></div>

					  <!--<tr>

						<td width="12%"  valign="middle" class="cat_block1">Banner Link:</td>

						<td width="88%" valign="middle" class="cat_block1"><input  name="banner_link" type="text" class="comment" id="banner_link" value="" size="50"></td>

					  </tr>-->

					  <tr id="image">

              <div id="help_shot" class="zonelogotexthelp container_tab_header header-default-message bv_head_wraper">

             
                    <p>For best results upload a 260 pixel wide x 80 pixel high image</p>


                </div>


 
						

						<td  valign="middle"  class="title_content_block">
								<h2  valign="middle" class="title_content_block"><span class="cat_block1">Image</span>:</h2>
							<div id="uplodImage">

							<input type="file" id="imgfile" onchange="ajaxFileUpload();"  name="imgfile" value="" />

							<input type="hidden" name="uploadedInput" id="uploadedInput" value="" />

							<input type="hidden" name="zone_id" value="<?php echo $zone_id;?>" />

							<input type="hidden" name="folder_name" id="folder_name" value="" />

							<span style="display:none;right: 240px;" id="spinner"><img src="<?php echo base_url() ?>assets/images/loading.gif"></span>

							

							<!--<p id="uploading">(Please select a file(1526px*471px) to upload)</p>-->

						  </div></td>

					  </tr>

					  

					   <tr id="image_block">

					

						<td  valign="middle" class="title_content_block">

							<div id="show_banner" style="width: 300px;"><?php if(!empty($check_zone_logo['image_name'])): ?><img src="<?=base_url();?>/uploads/zone_logo/<?=$common['zoneid']?>/normal_image/<?=$check_zone_logo['image_name'];?>" style="width:300px;margin-top: 8px;"><?php endif; ?></div>

						</td>

					  </tr>

					

					  <?php if(!empty($check_zone_logo['image_name'])): ?>

					  <tr id="delete_image_block">

						

						<td  valign="middle" class="cat_block1">

						<button id="demo" class="cus-btn-del" onclick="delete_banner_image(<?=$common['zoneid']?>)"> delete </button>

						 </td>

					  </tr>

					  <?php endif; ?>

					 

					  <tr>

					

						<td  valign="middle" class="cat_block1"><input type="submit" name="Submit" value="Submit" class="bttn zone-upload-submit"  >

						  <input type="reset" id="reset_banner" style="display:none;"/></td>

					  </tr>

					  

					  <tr>

						<td colspan="2" class="err">&nbsp;</td>

					  </tr>

					</table>

				  </td>

				</tr>

			  </table>

			</form>

		</div>

		</div>

        

    </div>

    

    

</div>



</div>





<script type="text/javascript">

function save_banner(){

	if($('#uploadedInput').val()!='' && $('#order').val()!=''){

		$('.form_error').hide();

		var dataToUse=$('form#add_banner_forzone').serialize();

		PageMethod("<?=base_url('banner_controller/save_zonelogo')?>", "Adding banner please wait ....", dataToUse, add_banner_insert, null);

	}else{

		$('.form_error').show();

		var form_error='';

		if($('#uploadedInput').val()==''){

			form_error+="Please upload a file.</br>";

		}

		if($('#order').val()==''){

			form_error+="Please provide banner position no.";

		}		

		$('.form_error').html('<span style="color:#F00; font-weight:bold;font-size: 19px;margin-left: 35px;">'+form_error+'</span>');

		//return false;

	}

}

function add_banner_insert(result){

	$.unblockUI();

	$('.form_error').show();

	$('.form_error').html('<span style="color:#008000;font-weight:bold;font-size: 19px;margin-left: 35px;">Save Successful.</span>');

	$('#reset_banner').click();

	$('#uploadedInput').val('');

}



function delete_banner_image(zone_id){

	$('.form_error').hide();

	var dataToUse={

		'zoneid':zone_id

	}

	PageMethod("<?=base_url('Zonedashboard/remove_zonelogo')?>", "Delete banner logo please wait ....", dataToUse, delete_banner_status, null);

}



function changeTheme() {

  var theme = $("#themeChange").val();

    var r = confirm("Want to change your theme?");

  if (r == true) {

      var dataToUse = {

  "zone_id":<?=$zone_id?>,

  "theme":theme,

  };

  PageMethod("<?=base_url('Zonedashboard/change_theme')?>", "Changing theme color please wait ....", dataToUse, changeBanner, null);

  }

}



function changeBanner(result){

  $.unblockUI();

  $('.error_msg').show();

  $('.error_msg').html('<span style="color:#008000;font-weight:bold;font-size: 19px;margin-left: 35px;">Theme updated Successfully.</span>');

  setInterval(function(){ $('.error_msg').html(''); }, 4000);

}



function delete_banner_status(result){

	$.unblockUI();

	$('.form_error').show();

	$('.form_error').html('<span style="color:#008000;font-weight:bold;font-size: 19px;margin-left: 35px;">Deleted Successful.</span>');

	$('#delete_image_block').hide();

	$('#image_block').hide();

}



function ajaxFileUpload(){

	//starting setting some animation when the ajax starts and completes

	$('#spinner').show();

	 $.ajaxFileUpload(        		

	{

		type:"POST",

		url:'<?=base_url('banner_controller/save_zonelogo_image/'.$zone_id.'')?>',

		secureuri:false,

		fileElementId:'imgfile',

		dataType: 'json',

		success: function (data, status)

		{

			$('#spinner').hide();

			$('.form_error').hide();

			$('#image_block').show();

			$('#uploadedInput').val(data.clientImage);

			$('#folder_name').val(data.folder_name);

			//$('#show_banner').html('<img src="'+baseurl+'uploads/zone_logo/temp_folder/'+data.uploadedImage+'/normal_image/'+data.clientImage+'" style="width:300px;  margin-top: 8px;">');

			$('#show_banner').html('<img src="'+baseurl+'uploads/zone_logo/'+zone_id+'/normal_image/'+data.clientImage+'" style="width:300px;  margin-top: 8px;">');

			if(data!=0){}

			if(typeof(data.error) != 'undefined')

			{

				if(data.error != '')

				{

					alert(data.error);

				}else

				{

					alert(data.msg);

				}

			}

		},

		error: function (data, status, e)

		{

			//alert(e);

		}

	}

)       

return false;

}



$(document).ready(function () { 

	$('#zone_data_accordian').click();

	$('#zone_data_accordian').next().slideDown();

	$('#zone_detail').addClass('active');

	$( "#tabs" ).tabs({ selected: 1});

	

});



// + check_authneticate

function  check_authneticate(){ //alert(1);

	var is_authenticated=0;

	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ //alert('success');

		is_authenticated=data;

	}});	

	return is_authenticated;

}

// - check_authneticate



// + Variable initialization

var userid = '<?=$common['user']->id?>';

// - Variable initialization



//+ UpdateShortUrl

function UpdateShortUrl(){

  var shortUrl = $("#shortUrl").val();

	if(shortUrl == '')

	{

		$('.shortUrlerror').show();

		$('.shortUrlerror').html('<span style="color:red;font-weight:bold;font-size: 19px;margin-left: 35px;">Field could not blank.</span>');

		setInterval(function(){ $('.shortUrlerror').html(''); }, 4000);

	}else{

		var zone_id= <?=$zone_id?>;

		var dataToUse = {

		"shortUrl":shortUrl,

		"zone_id":zone_id

		};

		PageMethod("<?=base_url('Zonedashboard/update_short_url')?>", "Saving Short Url<br/>This may take a minute.", dataToUse, UpdateSuccess, null);

	}

}

// + UpdateProfile/Success

function UpdateProfile() { 

	var authenticate=check_authneticate();

	if(authenticate=='0'){

		var zone_id = <?=$zone_id?>;			 

		alert('You are currently logged out. Please log in to continue.');

		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

	}

	else if(authenticate==1){

		

		if($('#jform_Email').val()== ''){

				     var txt = '<h5 style="color:#090">Please enter email.</h5>';

					 $('#error_contact_email').html(txt);

					 $('#error_contact_email').show();

					 return false;

				 }else{

					 $('#jform_Email').val();

					 //$('#error_contact_name').hide();

					 setTimeout(function(){

							$('#error_contact_email').hide('slow');

						}, 1000);

				 }

		

		

		var dataToUse = {

			"userid":userid,		//$('#userid').val(),

			"email":$('#jform_Email').val(),

			"firstname":$('#jform_Firstname').val(),

			"lastname":$('#jform_Lastname').val(),

			"phone":$('#jform_Phone').val(),

			"address":$('#jform_Address').val(),

			"city":$('#jform_City').val(),

			"state":$('#jform_State').val(),

			"zip":$('#jform_Zip').val()

		};

	PageMethod("<?=base_url('Zonedashboard/update_profile')?>", "Saving Profile<br/>This may take a minute.", dataToUse, UpdateSuccess, null);

	}

}

function UpdateSuccess(result){ 		//alert(JSON.stringify(result.Tag)); return false;

	$.unblockUI();

	if(result.Tag==''){	

		$('#update_message').html('<h4 style="color:#090">Profile updated successfully</h4>');

			$('html,body').animate({scrollTop:0},"slow");

			setTimeout(function(){

				$('#update_message').hide('slow');

				}, 3000);

		$('#update_message').show();

	}

}

// - UpdateProfile/Success



// + UpdatePassword/Success

function UpdatePassword(){ 

	var authenticate=check_authneticate();

	if(authenticate=='0'){			 

		var zone_id = <?=$zone_id?>;			 

		alert('You are currently logged out. Please log in to continue.');

		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

	 }else if(authenticate==1){

		 if($('#current_pass').val() == '' && $('#new_pass').val() == '' && $('#confirm_pass').val() ==''){			 

			alert("Fields can't be left blank. Please provide values."); 

			return false;

		}

		if($('#current_pass').val() == ''){

			alert('Please enter your current password.'); return false;

		}

		if($('#new_pass').val() == ''){

			alert('Please enter your new password.'); return false;

		}

		if($('#confirm_pass').val() ==''){

			alert('Please enter the confirm password.'); return false;

		}

		 

		 var dataToUse = {

			"userid":userid,

			"current_pass":$('#current_pass').val(),

			"new_pass":$('#new_pass').val(),

			"confirm_pass":$('#confirm_pass').val()

		 };

		 PageMethod("<?=base_url('Zonedashboard/update_password')?>", "Saving New Password<br/>This may take a minute.", dataToUse, UpdatePasswordSuccess, null);

	 }

}

/*function UpdatePasswordSuccess(result){			//alert(JSON.stringify(result)); return false;

	$.unblockUI();

	if(result.Tag==''){ 

		$('#update_message').html('<h4 style="color:#090">Password updated successfully</h4>');

			$('html,body').animate({scrollTop:0},"slow");

			setTimeout(function(){

				$('#update_message').hide('slow');

				}, 3000);

		$("#user-form-password")[0].reset();  // or => document.getElementById("user-form-password").reset();  

		$('#update_message').show();

	}

}

*/

function UpdatePasswordSuccess(result){			//alert(JSON.stringify(result));

	$.unblockUI();

	if(result.Message=='Update Successful'){ 

		$('#update_message').html('<h4 style="color:#090">Password updated successfully</h4>');

			$('html,body').animate({scrollTop:0},"slow");

			setTimeout(function(){

				$('#update_message').hide('slow');

				}, 3000);

		$("#user-form-password")[0].reset();  // or => document.getElementById("user-form-password").reset();  

		$('#update_message').show();

	}else {

		alert(result.Message); return false;

	}

}

// - UpdatePassword/Success



/* Zone Data part Start */

$("#zoneNameEdit").hide();

$("#zoneNameEditButtons").hide();

$("#success_zname").hide();

$("#error_zname").hide();



$("#canceledit").hide();

$("#savezone").hide();

var zone_id = <?=$zone_id?>;

var create_biz = 0;

var flag=0;

// for create new zone

function newZone(){ 

	var authenticate=check_authneticate();

	if(authenticate=='0'){			 

		 var zone_id = <?=$zone_id?>;			 

alert('You are currently logged out. Please log in to continue.');

window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;}else if(authenticate==1){ 

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

		create_biz = 1;

	 }

}

 // For rename zone

function editName(){

	var authenticate=check_authneticate();

	if(authenticate=='0'){			 

		 var zone_id = <?=$zone_id?>;			 

alert('You are currently logged out. Please log in to continue.');

window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;}else if(authenticate==1){

		var zname=<?=$zone['name']?>;

	

		if($("#zoneName").val()==''){

			$("#zoneName").val(zname);

		}

		$("#zoneNameEdit").show();

		$("#zoneNameDisplay").hide();	

		$("#canceledit").show();

		$("#createzone").hide();

		$("#deletezone").hide();

		

		$("#success_zname").hide();

		$("#error_zname").hide(); //zoneNameEditButtons

		create_biz = 0;

	 }

}

// For cancel new zone

function cancelEditName(){	

	$("#zoneNameEdit").hide();

	$("#zoneNameDisplay").show();

	$("#createzone").show();

	$("#renamezone").show();

	//$("#deletezone").show();

	$("#canceledit").hide();

	$("#savezone").hide();

	$("#success_zname").hide();

	$("#error_zname").hide();

}



// Save Zone Name

function saveZoneName(){ 

	var authenticate=check_authneticate();

	if(authenticate=='0'){			 

		 		 

alert('You are currently logged out. Please log in to continue.');

window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;}else if(authenticate==1){

		var zone_id = <?=$zone_id?>;	

		var tempZone = zone_id;	

		if(create_biz == 1){	

			tempZone = -1;

		}

		

		var zonename=$('#zoneName').val(); //alert(aaa); return false;

		if(zonename==''){

			alert('Please specify a zone name');

			return false;

		}

		

		var data = { "zone_id": tempZone, "zone_name": zonename};

		$("#zoneNameDisplay").html(zonename);

		$("#zoneNameEdit").hide();

		$("#zoneNameDisplay").show();

		//$("#zoneNameEditButtons").hide();

		var title = "Renaming Zone";

		if(tempZone == -1) { title = "Creating Zone";}

		PageMethod("<?=base_url('Zonedashboard/renameZone')?>", title, data, tempZone == -1 ? NewZoneSaved : NewZoneSaved, null);

		$.unblockUI();

		$('#error_zname').hide();

		$('#success_zname').hide();

		$('#createzone').show();

		$('#renamezone').show();

		$('#deletezone').show();

		$('#savezone').hide();

		$('#canceledit').hide();

		

	 }

}



function NewZoneSaved(result){ 

	window.location.href = "<?=base_url('Zonedashboard/zonedetail')?>" + "/" + result.Tag;

}



<? if(!empty($my_zones) && count($my_zones) > 1){  ?>

$("#myZones").change(function(){

	var zid = $(this).val();

	if(zid == -1){return;}

	window.location.href = "<?=base_url('Zonedashboard/zonedetail')?>/" + zid;

	});

<? } ?>



// For Delete Zone

function deleteZone(zid){

	var authenticate=check_authneticate();

	if(authenticate=='0'){			 

		 var zone_id = <?=$zone_id?>;			 

alert('You are currently logged out. Please log in to continue.');

window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;}else if(authenticate==1){

		window.location.href = "<?=base_url('auth/deleteZone')?>" + "/" + zid;

	 }

}



function zone_verification(){ 

	var tempZone = zone_id;

	var zonename=$('#zoneName').val(); 

	if(/^[a-zA-Z0-9- ]*$/.test(zonename) == false) {

		$('#error_zname').show();

		$('#error_zname').html('Zone Name should not contain special character.' );

		$('#success_zname').hide();

		return false;

	}

	if(zonename==''){

		$('#error_zname').show();

		$('#error_zname').html('Zone Name should not empty.' );

		$('#success_zname').hide();

		return false;

	}

	var data = { "zone_name": zonename,'type':'dashboard'};

	PageMethod("<?=base_url('Zonedashboard/check_zonename')?>", "Verify the zone name <br/>This may take a few minutes", data, showzonename123, null);

}



function showzonename123(result){ 

	$.unblockUI();

	if(result.Tag=='0'){

		$('#error_zname').html('This zone name is already taken.' );

		$('#error_zname').show();

		$('#success_zname').hide();

		$("#savezone").hide();

		//$('#zoneName').val('');

		

	}else{

		$('#success_zname').html('Thank You. "'+result.Tag+ '" is available.');

		$('#success_zname').show();

		$('#error_zname').hide();

		// $("#zoneNameEditButtons").show();

		$("#savezone").show();

	}

}

$(function (){

            $("#jform_Phone").mask('999-999-9999',{placeholder:' '});

         });

		 

		 

$(function() {

				$('#button').click(function() {

				//$('#zoneName').attr("disabled", true);

				// Write your Code

				});



				$('#canceledit').click(function() {

						$('#zoneName').removeAttr("disabled", false);

				})

								

				$('#renamezone').click(function() {

    				$('#zoneName').removeAttr("disabled", false);

            $(this).hide();

				})

								

        $('#zoneName').on('input',function(){ 

            $('#error_zname').hide();

            $('#success_zname').hide();

        });

});





$(document).on('blur','#new_pass',function(){

	var new_password = $(this).val();

	 var regex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%#&])[A-Za-z\d$@$!%#&]{10,}$/; 

	if(new_password.length < 10 || new_password.length > 18){

		$('#error_new_password').html(" Password should be between 10 to 18 characters");

			$('#error_new_password').show();

			//$('#new_pass').focus();

			return false;

	}else if(!regex.test(new_password)){ 

		$('#error_new_password').html(" Password should be combination of letters, <br>numbers and special characters (!, @, #, $, %, &)");

			$('#error_new_password').show();

			//$('#new_pass').focus();

			return false;

		}else{  

			$('#error_new_password').hide();

		}

});



$(document).on('blur','#confirm_pass',function(){

	var new_pass = $('#new_pass').val();

	var confirm_pass = $(this).val();

	if(new_pass != confirm_pass){

		$('#error_confirm_password').html(" New password and confirm password does not matched");

			$('#error_confirm_password').show();

			//$('#confirm_pass').focus();

			return false;

	}else{

		$('#error_confirm_password').hide();

	}

});



   $('#jform_Email').focusout(function(){

           $('#jform_Email').filter(function(){

                   var email=$('#jform_Email').val();

                   // var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                   var emailReg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

					  if( !emailReg.test(email)){

						$('#email_notice').slideDown();

						//$('#email_notice').fadeOut(6000);

						$('#jform_Email').focus();

						$("button[name='update_profile']").attr('disabled','disabled');

						//$('#email_notice').fadeToggle();

						}else{

							$('#email_notice').slideUp('slow');

							$("button[name='update_profile']").removeAttr('disabled');

						} 

			})

            });

		 

		 

	$(document).ready(function(){

         $(document).on('blur','#jform_Email',function(){

			 //$('#biz_name').focusout(function(){

			   if($('#jform_Email').val()== ''){

				     var txt = '<h5 style="color:#090">Please enter email.</h5>';

					 $('#error_contact_email').html(txt);

					 $('#error_contact_email').show();

					 return false;

				 }else{

					 $('#jform_Email').val();

					 //$('#error_contact_name').hide();

					 setTimeout(function(){

							$('#error_contact_email').hide('slow');

						}, 1000);

				 }

		     });

		 });

		 
 
		 

		 $(document).ready(function() {

  var buttonAdd = $("#add-button");
  var buttonRemove = $("#remove-button");
  var className = ".dynamic-field";
  var count = 0;
  var field = "";
  var maxFields =50;


  function totalFields() {
    return $(className).length;
  }

  function addNewField() {
    count = totalFields() + 1;
    field = $("#dynamic-field-1").clone();
    field.attr("id", "dynamic-field-" + count);
    field.children("label").text("Field " + count);
    field.find("input").val("");
    $(className + ":last").after($(field));
  }

  function removeLastField() {
    if (totalFields() > 1) {
      $(className + ":last").remove();
    }
  }

  function enableButtonRemove() {
    if (totalFields() === 2) {
      buttonRemove.removeAttr("disabled");
      buttonRemove.addClass("shadow-sm");
    }
  }

  function disableButtonRemove() {
    if (totalFields() === 1) {

      buttonRemove.attr("disabled", "disabled");
      buttonRemove.removeClass("shadow-sm");

    }
  }

  function disableButtonAdd() {
    if (totalFields() === maxFields) {

      buttonAdd.attr("disabled", "disabled");
      buttonAdd.removeClass("shadow-sm");

    }
  }

  function enableButtonAdd() {
    if (totalFields() === (maxFields - 1)) {

      buttonAdd.removeAttr("disabled");
      buttonAdd.addClass("shadow-sm");

    }
  }

  buttonAdd.click(function() {
    addNewField();
    enableButtonRemove();
    disableButtonAdd();
  });

  buttonRemove.click(function() {
    removeLastField();
    disableButtonRemove();
    enableButtonAdd();
  });
});

		 
$('.buttonAdd').click(function(e){
   e.preventDefault();
  var array = [];

  $('.dynamic-field').each(function(){
     if($(this).find('input[name="field[]"]').val() || $(this).find('input[name="order[]"]').val()){
    array.push({
      key: $(this).find('input[name="field[]"]').val(),
      value: $(this).find('input[name="order[]"]').val(),
    }); 
  }

  });


 


         
              $.ajax({

                   type:"POST",

                    data:{'zoneid':$('.zoneid').val() ,  'array':JSON.stringify(array)},                 

                   url: "<?=base_url('/Zonedashboard/addDiscount/')?>",      

                   cache: false,

                   success: function(data){  
 
                        
                       location.reload();

                      }

            });


 

});

		 

</script>