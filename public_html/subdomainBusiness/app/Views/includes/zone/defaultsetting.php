

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

	<div class="container_tab_header">Zone Default Setting</div>

	<div id="container_tab_content" class="container_tab_content">

        <ul>

        <li><a href="#tabs-1">Businesses</a></li>

        <li><a href="#tabs-2" style = "display : none">Announcements</a></li>

        <li><a href="#tabs-3" style = "display : none">Interest Groups</a></li>

        <li><a href="#tabs-4">Directory Page</a></li>

        <li><a href="#tabs-5">Home Sold Sponsor</a></li>

        </ul>

        

<!----------------------------------------------------------------------------------------Help Tips------------------------------------------------------------------------------>

				

                <!--<div id="help_shot" class="container_tab_header header-default-message" margin-top:10px;>

                    <p>This is the control panel of the site.</p>

                </div>-->

                

<!-----------------------------------------------------------------------------------------Help Tips---------------------------------------------------------------------------->        

        

        																<!-- Businesses -->	

        <div id="tabs-1">

        	<div class="form-group">

            <form action="<?=base_url('Zonedashboard/savespecificBusiness')?>" name="businesses_form22" id="businesses_form22" onsubmit="return false">

            <div id="showspbusiness"></div>

            

           

            

                <div id="Businesses_details" style="display:none;">

                  <table class="pretty" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">

                    <tbody>

                      <tr>

                        <th colspan="2">Paid Businesses</th>

                      </tr>

                      <tr>

                        <td width="69%"><div style="float: left;">

                            <label for="auto_approve_paid_business_myzone" style="float: left;">Auto activate all new paid businesses advertising in your zone.</label>

                          </div></td>

                        <td width="31%" align="left"><select id="auto_approve_paid_business_myzone" name="auto_approve_paid_business_myzone" style="margin-left:0px;" >

                            <option value="1" <? if($zonepref['auto_approve_paid_business_myzone']==1) echo 'selected="selected"';?>>Yes</option>

                            <option value="0" <? if($zonepref['auto_approve_paid_business_myzone']==0) echo 'selected="selected"';?>>No</option>

                        </select></td>

                      </tr>

                      <tr>

                        <td><div style="float: left;">

                            <label for="auto_approve_paid_business_locatedmyzone" style="float: left;">Auto activate all new paid businesses located in your zone.<br />

                            </label>

                          </div></td>

                        <td align="left"><select id="auto_approve_paid_business_locatedmyzone" name="auto_approve_paid_business_locatedmyzone" style="margin-left:0px;" >

                            <option value="1" <? if($zonepref['auto_approve_paid_business_locatedmyzone']==1) echo 'selected="selected"';?>>Yes</option>

                            <option value="0" <? if($zonepref['auto_approve_paid_business_locatedmyzone']==0) echo 'selected="selected"';?>>No</option>

                        </select></td>

                      </tr>

                    </tbody>

                  </table>

                </div>

                

                

<!-- Paid Businesses Advertisements -->               

                

       <div id="Advertisements_details">

          <table class="pretty" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">

            <tbody>

              <tr>

                <th colspan="2">Paid Businesses Advertisements</th>

              </tr>

              <tr>

                <td width="69%"><div style="float: left;">

                    <label for="auto_approve_paid_ad_myzone" style="float: left;">Auto activate all new ads of paid businesses which are advertising in this zone, but located outside this zone</label>

                  </div></td>

                <td width="31%" align="left"><select id="auto_approve_paid_ad_myzone" name="auto_approve_paid_ad_myzone" style="margin-left:0px;" >

                    <option value="1" <?php if($zonepref['auto_approve_paid_ad_myzone']==1) echo 'selected="selected"';?>>Yes</option>

                  <!--  <option value="0" <?php if($zonepref['auto_approve_paid_ad_myzone']==0) echo 'selected="selected"';?>>No</option>-->

                  </select></td>

              </tr>



              <tr class="tr_businesses_of_myzone" <?php if($zonepref['auto_approve_paid_ad_myzone']==1) ?> style="display:none;">

                <td><div style="float: left;">

                    <label for="auto_approve_paid_specific_ad_myzone">Auto activate all new ads of specific businesses advertising in your zone</label>

                  </div></td>

                <td align="left">

                <div class="dropdown">

                <table cellpadding="0" cellspacing="0" width="100%">          

                  <? foreach($businesses_of_myzone as $v_businesses_of_myzone){?>

                  <tr >

                    <td><input id="v_businesses_of_myzone<?=$v_businesses_of_myzone['businessid']?>" type="checkbox" class="businesscheckbox auto_approve_paid_specific_ad_myzone" value="<?=$v_businesses_of_myzone['businessid']?>" <? if(strpos(','.$zonepref['auto_approve_paid_specific_ad_myzone'].',',','.$v_businesses_of_myzone['businessid'].',')!==false) echo 'checked="checked"'?>/></td>

                    <td class="option"><label for="v_businesses_of_myzone<?=$v_businesses_of_myzone['businessid']?>"><div><?=$v_businesses_of_myzone['businessname']?></div></label></td>

                  </tr>

                 <? }?>

                </table>

              </div>

                </td>

              </tr>

              <tr>

                <td><div style="float: left;">

                  <!--<label for="auto_approve_paid_ad_locatedmyzone" style="float: left;">Auto activate all new ads of businesses advertising in located your zone</label>-->

                  <label for="auto_approve_paid_ad_locatedmyzone" style="float: left;">Auto activate all new ads of paid businesses which are physically located within this zone</label>

                </div></td>

                <td align="left"><select id="auto_approve_paid_ad_locatedmyzone" name="auto_approve_paid_ad_locatedmyzone" >

                    <option value="1" <?php if($zonepref['auto_approve_paid_ad_locatedmyzone']==1) echo 'selected="selected"';?>>Yes</option>

                    <!--<option value="0" <?php if($zonepref['auto_approve_paid_ad_locatedmyzone']==0) echo 'selected="selected"';?>>No</option>-->

                  </select></td>

              </tr>

              <tr  class="tr_businesses_located_myzone"  <?php if($zonepref['auto_approve_paid_ad_locatedmyzone']==1)?> style="display:none;">

                <td><div style="float: left;">

                  <!--<label for="auto_approve_paid_specific_ad_locatedmyzone">Auto activate all new ads of specific businesses advertising in located your zone</label>-->

                  <label for="auto_approve_paid_specific_ad_locatedmyzone">Auto activate all new ads of specific businesses located in your zone</label>

                </div></td>

                <td align="left">

                <div class="dropdown">

                <table cellpadding="0" cellspacing="0" width="100%">          

                  <? foreach($businesses_located_myzone as $v_businesses_located_myzone){?>

                  <tr >

                    <td><input id="v_businesses_located_myzone<?=$v_businesses_located_myzone['businessid']?>" type="checkbox" class="businesscheckbox auto_approve_paid_specific_ad_locatedmyzone" value="<?=$v_businesses_located_myzone['businessid']?>" <? if(strpos(','.$zonepref['auto_approve_paid_specific_ad_locatedmyzone'].',',','.$v_businesses_located_myzone['businessid'].',')!==false) echo 'checked="checked"'?>/></td>

                    <td class="option"><label for="v_businesses_located_myzone<?=$v_businesses_located_myzone['businessid']?>"><div><?=$v_businesses_located_myzone['businessname']?></div></label></td>

                  </tr>

                 <? }?>

                </table>

              </div></td>

              </tr>

            </tbody>

          </table>



        </div>

                

              

	<div id="Listed_businesses_details" style="display:none;">

      <table class="pretty" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">

        <tbody>

          <tr>

            <th colspan="2">Active Uploaded Businesses and Inactive Uploaded Businesses</th>

          </tr>

          <tr>

            <td width="69%"><div style="float: left;">

                <label for="auto_approve_listed_business_myzone" style="float: left;">Auto activate all new Listed businesses advertising in your zone.</label>

              </div></td>

            <td width="31%" align="left"><select id="auto_approve_listed_business_myzone" name="auto_approve_listed_business_myzone" style="margin-left:0px;" >

                <option value="1" <? if($zonepref['auto_approve_listed_business_myzone']==1) echo 'selected="selected"';?>>Yes</option>

                <option value="0" <? if($zonepref['auto_approve_listed_business_myzone']==0) echo 'selected="selected"';?>>No</option>

            </select></td>

          </tr>

          <tr>

            <td><div style="float: left;">

                <label for="auto_approve_listed_business_locatedmyzone" style="float: left;">Auto activate all new Listed businesses located in your zone.<br />

                </label>

              </div></td>

            <td align="left"><select id="auto_approve_listed_business_locatedmyzone" name="auto_approve_listed_business_locatedmyzone" style="margin-left:0px;" >

                <option value="1" <? if($zonepref['auto_approve_listed_business_locatedmyzone']==1) echo 'selected="selected"';?>>Yes</option>

                <option value="0" <? if($zonepref['auto_approve_listed_business_locatedmyzone']==0) echo 'selected="selected"';?>>No</option>

            </select></td>

          </tr>

        </tbody>

      </table>

    </div>        

    

<!-- Trial Businesses -->    

    

    <div id="Businesses_details">

      <table class="pretty" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">

        <tbody>

          <tr>

            <th colspan="2">Free Businesses</th>

          </tr>

          <tr style="display:none">

            <td width="69%"><div style="float: left;">

                <label for="auto_approve_trial_business_myzone" style="float: left;">Auto activate all new Free Trial businesses which are advertising in this zone, but located outside this zone</label>

              </div></td>

            <td width="31%" align="left"><select id="auto_approve_trial_business_myzone" name="auto_approve_trial_business_myzone" style="margin-left:0px;" >

                <option value="1" <? if($zonepref['auto_approve_trial_business_myzone']==1) echo 'selected="selected"';?>>Yes</option>

                <option value="0" <? if($zonepref['auto_approve_trial_business_myzone']==0) echo 'selected="selected"';?>>No</option>

            </select></td>

          </tr>

          <tr style="display:none">

            <td><div style="float: left;">

                <label for="auto_approve_trial_business_locatedmyzone" style="float: left;">Auto activate all new Free Trial businesses which are physically located within this zone<br />

                </label>

              </div></td>

            <td align="left"><select id="auto_approve_trial_business_locatedmyzone" name="auto_approve_trial_business_locatedmyzone" style="margin-left:0px;" >

                <option value="1" <? if($zonepref['auto_approve_trial_business_locatedmyzone']==1) echo 'selected="selected"';?>>Yes</option>

<td width="69%"><div style="float: left;">

                <label for="trial_business_active" style="float: left;">No. of days a Free Trial business will be active<br />

                </label>

              </div></td>

            <td align="left">

            <input type="text" name="trial_business_active" id="trial_business_active" value="<?=$zonepref['trial_business_active']?>" style="width:50px;"/>

                         <option value="0" <? if($zonepref['auto_approve_trial_business_locatedmyzone']==0) echo 'selected="selected"';?>>No</option>

            </select></td>

          </tr>

          <tr>

               </td>

          </tr>

         <tr>

            <td width="69%"><div style="float: left;">

                <label for="notification_day" style="float: left;">Fix the period for E-mail notification before business expiration <br />

                </label>

              </div></td>

            <td align="left">

            <input type="number" name="notification_day" id="notification_day" value="<?=$zonepref['notification_day']?>" min="5" onblur="notification_daycount()" style="width:50px;padding: 7px;border: 1px solid #999;border-radius: 3px;"/>

            <span id="notification_msg" style="display:none;"></span>

            </td>

          </tr>

        </tbody>

      </table>

    </div>

    

<!-- Trial Businesses Advertisements -->    

    

    <div id="Advertisements_details">

        <table class="pretty" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">

          <tbody>

            <tr>

              <th colspan="2">Free Trial Businesses Advertisements</th>

            </tr>

            <tr>

              <td width="69%"><div style="float: left;">

                <label for="auto_approve_trial_ad_myzone" style="float: left;">Auto activate all new ads of Free Trial businesses which are advertising in this zone, but located outside this zone</label>

              </div></td>

              <td width="31%" align="left"><select id="auto_approve_trial_ad_myzone" name="auto_approve_trial_ad_myzone" style="margin-left:0px;" >

                <option value="1" <? if($zonepref['auto_approve_trial_ad_myzone']==1) echo 'selected="selected"';?>>Yes</option>

                <!--<option value="0" <? if($zonepref['auto_approve_trial_ad_myzone']==0) echo 'selected="selected"';?>>No</option>-->

              </select>

              </td>

            </tr>

            <?php /*?><tr <?php if($zonepref['auto_approve_trial_ad_myzone']==1) echo 'style="display:none"'?>><?php */?>

              <tr style="display:none"> <!-- Added on 10.6.14 -->

              <td><div style="float: left;">

                <label for="auto_approve_trial_specific_ad_myzone">Auto activate all new ads of specific businesses advertising in your zone</label>

              </div>

              </td>

              <td align="left"><select id="auto_approve_trial_specific_ad_myzone" name="auto_approve_trial_specific_ad_myzone" style="margin-left:0px;"  >

               <option value="1" <? if($zonepref['auto_approve_trial_specific_ad_myzone']==1) echo 'selected="selected"';?>>Yes</option>

                <option value="0" <? if($zonepref['auto_approve_trial_specific_ad_myzone']==0) echo 'selected="selected"';?>>No</option>

              </select>

              </td>

            </tr>

            <tr>

              <td><div style="float: left;">

                <!--<label for="auto_approve_trial_ad_locatedmyzone" style="float: left;">Auto activate all new ads of businesses advertising in located your zone</label>-->

                <label for="auto_approve_trial_ad_locatedmyzone" style="float: left;">Auto activate all new ads of Free Trial businesses which are physically located within this zone</label>

              </div>

              </td>

              <td align="left"><select id="auto_approve_trial_ad_locatedmyzone" name="auto_approve_trial_ad_locatedmyzone" >

               <option value="1" <? if($zonepref['auto_approve_trial_ad_locatedmyzone']==1) echo 'selected="selected"';?>>Yes</option>

                <!--<option value="0" <? if($zonepref['auto_approve_trial_ad_locatedmyzone']==0) echo 'selected="selected"';?>>No</option>-->

              </select></td>

            </tr>

            <?php /*?><tr <?php if($zonepref['auto_approve_trial_ad_locatedmyzone']==1) echo 'style="display:none"'?>><?php */?>

              <tr style="display:none">   <!-- Added on 10.6.14 -->

              <td><div style="float: left;">

                <!--<label for="auto_approve_trial_specific_ad_locatedmyzone">Auto activate all new ads of specific businesses advertising in located your zone</label>-->

                <label for="auto_approve_trial_specific_ad_locatedmyzone">Auto activate all new ads of specific businesses located in your zone</label>

              </div></td>

              <td align="left"><select id="auto_approve_trial_specific_ad_locatedmyzone" name="auto_approve_trial_specific_ad_locatedmyzone" style="margin-left:0px;" >

                <option value="1" <? if($zonepref['auto_approve_trial_specific_ad_locatedmyzone']==1) echo 'selected="selected"';?>>Yes</option>

                <option value="0" <? if($zonepref['auto_approve_trial_specific_ad_locatedmyzone']==0) echo 'selected="selected"';?>>No</option>

              </select>

              </td>

            </tr>

          </tbody>

        </table>

      </div>

 

<!-- Premium Advertisements -->      

      

      <?php /*?><div id="Sticky_details">

      <table class="pretty" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">

        <tbody>

          <tr>

            <th colspan="2">Premium Advertisements(Ad is highest ranked within it's sub category)</th>

          </tr>              

          <tr>

            <td width="69%"><div style="float: left;">

                <label for="auto_approve_sticky_ad" style="float: left;">Turn on Premium Advertisements</label>

              </div>

            </td>

            <td width="31%" align="left"><select id="auto_approve_sticky_ad" name="auto_approve_sticky_ad" style="margin-left:0px;" >

                <option value="0" <? if($zonepref['auto_approve_sticky_ad']==0) echo 'selected="selected"';?>>No</option>

                <option value="1" <? if($zonepref['auto_approve_sticky_ad']==1) echo 'selected="selected"';?>>Yes</option>

            </select>

            </td>

          </tr>              

        </tbody>

      </table>

     </div><?php */?>



<p class="align-center"><button onclick="savespecificBusiness(<?=$zoneid?>)">Save</button></p>     

</form>                

            </div>

        </div>

        																<!-- Announcements -->	

        

        <div id="tabs-2">

        	<div class="form-group">

            <form action="<?=base_url('Zonedashboard/savespecificBusiness')?>" name="businesses_form22" id="businesses_form22" onsubmit="return false">

            <div id="Announcement_details" >

              <table class="pretty" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">

                <tbody>

                  <tr>

                    <th colspan="2">Announcements</th>

                  </tr>

                  <tr>

                    <td width="69%"><div style="float: left;">

                        <label for="auto_approve_emergency_announcements" style="float: left;">Auto activate all emergency announcements</label>

                      </div>

                    </td>

                    <td width="31%" align="left"><select id="auto_approve_emergency_announcements" name="auto_approve_emergency_announcements" style="margin-left:0px;" >

                        <option value="0" <? if($zonepref['auto_approve_emergency_announcements']==0) echo 'selected="selected"';?>>No</option>

                        <option value="1" selected="selected" <? if($zonepref['auto_approve_emergency_announcements']==1) echo 'selected="selected"';?>>Yes</option>

                    </select>

                    </td>

                  </tr>

                  <tr>

                    <td><div style="float: left;">

                        <label for="auto_approve_normal_announcements" style="float: left;">Auto activate all normal announcements<br />

                        </label>

                      </div>

                    </td>

                    <td align="left"><select id="auto_approve_normal_announcements" name="auto_approve_normal_announcements" style="margin-left:0px;" >

                        <option value="0" <? if($zonepref['auto_approve_normal_announcements']==0) echo 'selected="selected"';?>>No</option>

                        <option value="1" <? if($zonepref['auto_approve_normal_announcements']==1) echo 'selected="selected"';?>>Yes</option>

                    </select>

                    </td>

                  </tr>

                </tbody>

              </table>

            </div>

            <button onclick="savespecificBusiness(<?=$zoneid?>)">Save</button>

            </form>

              </div>

        </div>

        																<!-- Interest Groups -->	     

        

        <div id="tabs-3" style = "display : none">

        	<div class="form-group">

            <form action="<?=base_url('Zonedashboard/savespecificBusiness')?>" name="businesses_form22" id="businesses_form22" onsubmit="return false">

                <div id="interest_group" >

                  <table class="pretty" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">

                    <tbody>

                      <tr>

                        <th colspan="2">Interest Groups</th>

                      </tr>

                      <tr>

                        <td width="69%"><div style="float: left;">

                            <label for="auto_approve_ig_by_org_lbl" style="float: left;">Auto activate all Interest Groups created by Organization</label>

                          </div></td>

                        <td width="31%" align="left"><select id="auto_approve_ig_by_org" name="auto_approve_ig_by_org" style="margin-left:0px;" >

                            <option value="0" <? if($zonepref['auto_approve_ig_by_org']==0) echo 'selected="selected"';?>>No</option>

                            <option value="1" selected="selected" <? if($zonepref['auto_approve_ig_by_org']==1) echo 'selected="selected"';?>>Yes</option>

                        </select></td>

                      </tr>

                      <tr>

                        <td><div style="float: left;">

                            <label for="auto_approve_ig_by_business" style="float: left;">Auto activate all Interest Groups created by Business<br />

                            </label>

                          </div></td>

                        <td align="left"><select id="auto_approve_ig_by_business" name="auto_approve_ig_by_business" style="margin-left:0px;" >

                            <option value="0" <? if($zonepref['auto_approve_ig_by_business']==0) echo 'selected="selected"';?>>No</option>

                            <option value="1" <? if($zonepref['auto_approve_ig_by_business']==1) echo 'selected="selected"';?>>Yes</option>

                        </select></td>

                      </tr>

                    </tbody>

                  </table>

                </div>

                <button onclick="savespecificBusiness(<?=$zoneid?>)">Save</button>

                </form>

            </div>

        </div>

        																<!-- Directory Page -->	

        

        <div id="tabs-4">

        	<div class="form-group">

            <form action="<?=base_url('Zonedashboard/savespecificBusiness')?>" name="businesses_form22" id="businesses_form22" onsubmit="return false">

                <div id="zone_details">

                  <table class="pretty" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">

                    <tbody>

                      <tr>

                        <th colspan="2">Zone Page</th>

                      </tr>

                      <tr>

                        <td width="69%"><div style="float: left;">

                            <?php /*?><label for="auto_approve_offers_announcements" style="float: left;">Show the following in my zone page</label><?php */?>

                            <label for="auto_approve_offers_announcements" style="float: left;">Show all panels</label>

                          </div></td>

                        <td width="31%" align="left">

                            <select id="auto_approve_offers_announcements" name="auto_approve_offers_announcements" style="margin-left:0px;" >

                            	<option value="4" <?php //if($zonepref['auto_approve_offers_announcements']==3) echo 'selected="selected"';?>>Yes</option>

	                            <?php /*?><option value="3" <?php if($zonepref['auto_approve_offers_announcements']==3) echo 'selected="selected"';?>>All Announcements and Organizations</option>

                                <option value="1" <?php if($zonepref['auto_approve_offers_announcements']==1) echo 'selected="selected"';?>>All Offers</option>

                                <option value="2" <?php if($zonepref['auto_approve_offers_announcements']==2) echo 'selected="selected"';?>>All Organizations</option><?php */?><!--Commented 3,2,1 on 30.01.2015-->

                                

								<?php /*?><option value="3" <?php if($zonepref['auto_approve_offers_announcements']==3) echo 'selected="selected"';?>>All Offers and Announcements</option>

                                <option value="1" <?php if($zonepref['auto_approve_offers_announcements']==1) echo 'selected="selected"';?>>All Offers</option>

                                <option value="2" <?php if($zonepref['auto_approve_offers_announcements']==2) echo 'selected="selected"';?>>All Announcements</option><?php */?>

                                <?php /*?><option value="3" <?php if($auto_approve_offers_announcements==3) echo 'selected="selected"';?>>All Offers and Announcements</option>

                                <option value="1" <?php if($auto_approve_offers_announcements==1) echo 'selected="selected"';?>>All Offers</option>

                                <option value="2" <?php if($auto_approve_offers_announcements==2) echo 'selected="selected"';?>>All Announcements</option><?php */?>

                            </select>

                        </td>

                      </tr>

                      <tr>

                      

                        <td><div style="float: left;">

                            <label for="auto_approve_banner" style="float: left;">Show banner on my zone page<br />

                            </label>

                          </div></td>

                        <td align="left">

                        <select id="auto_approve_banner" name="auto_approve_banner" style="margin-left:0px;" >

                            <option value="1" <?php if($zonepref['auto_approve_banner']==1) echo 'selected="selected"';?>>Yes</option>

                            <option value="0" <?php if($zonepref['auto_approve_banner']==0) echo 'selected="selected"';?>>No</option>

                        </select></td>     

                        

                      </tr>

                      <?php /*?><tr>

                        <td><div style="float: left;">

                            <label for="no_of_offers" style="float: left;">Show no. of offers on my zone page<br />

                            </label>

                        </div></td>

                        <td align="left">

                            <input type="text" name="shownooffer" id="shownooffer" value="<?=$zonepref['displayoffer']?>" style="width:50px;"/>

                        </td>

                      </tr><?php */?>

                      <?php /*?><tr id="zone_theme">

                        <td><div style="float: left;">

                            <label for="is_change_theme" style="float: left;">Let visitors decide which directory skin they want to see (Red, Blue) <br />  

                            </label>

                          </div></td>

                        <td align="left">

                        <select id="is_change_theme" name="is_change_theme" style="margin-left:0px;" onchange="change_theme(this)">

                            <option value="1" <?php if($zonepref['ischangezonetheme']==1) echo 'selected="selected"';?>>Yes</option>

                            <option value="0" <?php if($zonepref['ischangezonetheme']==0) echo 'selected="selected"';?>>No</option>

                        </select></td>

                      </tr><?php */?>

                      <tr id="zone_sub_theme" style="display:none">

                        <td><div style="float: left;">

                            <label for="zone_theme" style="float: left;">Choose which directory skin users will see<br />

                            </label>

                          </div></td>

                        <td align="left">

                        <select id="zonetheme" name="zonetheme" style="margin-left:0px;" >

                            <option value="MT" <?php if($zonepref['zonetheme']=='MT') echo 'selected="selected"';?>>Red</option>

                            <?php /*?><option value="DT" <?php if($zonepref['zonetheme']=='DT') echo 'selected="selected"';?>>Green</option><?php */?>

                            <option value="BT" <?php if($zonepref['zonetheme']=='BT') echo 'selected="selected"';?>>Blue</option>

                        </select></td>

                      </tr>

                      <tr>

                        <td><div style="float: left;">

                                <label for="auto_approve_banner" style="float: left;">Create your Sponsorship Ad<br />

                                </label>

                            </div>

                        </td>

                        <td align="left">

                            <textarea rows="3" cols="30" style="width:220px; height:50px;" name="sponsor_ad_text" id="sponsor_ad_text" maxlength="43" placeholder="Create your sponsorship ad"><?php echo $zonepref['sponsor_ad_text']; ?></textarea>

                            <!--<input type="text" name="sponsorship_name" id="sponsorship_name" value="<?=$zonepref['trial_business_active']?>" style="width:220px; height:150px"/>-->

                        </td>

                      </tr>

                    </tbody>

                  </table>

        

               </div>               

               <p class="align-center"><button onclick="savespecificBusiness(<?=$zoneid?>)">Save</button></p>

               </form>

            </div>

        </div>

        

        <!-- +++++++   ++++++++ -->

 <div id="tabs-5">     

        

        <div class="form-group">

            <form action="<?=base_url('Zonedashboard/savespecificBusiness')?>" name="csv_upload" id="csv_upload" onsubmit="return false">

                <div id="realtor_details">

                  <table class="pretty" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">

                    <tbody>

                      <tr>

                        <th colspan="2">Home Sold Sponsor upload CSV</th>

                      </tr>

                      <tr>

                        <td><div style="float: left;">

                            <label for="auto_approve_csvupload" style="float: left;">Realtor can delete CSV file<br />

                            </label>

                          </div></td>

                        <td align="left">

                        <select id="auto_approve_csvupload" name="auto_approve_csvupload" style="margin-left:0px;" >

                            <option value="1" <?php if($zonepref['auto_approve_csvupload']==1) echo 'selected="selected"';?>>Yes</option>

                            <option value="0" <?php if($zonepref['auto_approve_csvupload']==0) echo 'selected="selected"';?>>No</option>

                        </select></td>

                      </tr>

                    </tbody>

                  </table>

        

               </div>               

               <p class="align-center"><button onclick="savespecificBusiness(<?=$zoneid?>)">Save</button></p>

               </form>

            </div>

        

        

      </div>

        

         <!-- ------  -------  -->

        

 </div>

    

    

</div>



</div>





<script type="text/javascript">

$(document).ready(function () { 

	$('#zone_data_accordian').click();

	$('#zone_data_accordian').next().slideDown();

	$('#zone_setting').addClass('active');

});

</script>



<script type="text/javascript">

function  check_authneticate(){ 

	var is_authenticated=0;

	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ 

		is_authenticated=data;

	}});	

	return is_authenticated;

}



$('#zone_sub_theme').hide();

var option_type=$('#is_change_theme').val();

	if(option_type==1){

		$('#zone_sub_theme').hide();

	}else if(option_type==0){

		$('#zone_sub_theme').show();

	}

function change_theme(tag){ 

	var option_type=$(tag).val();

	if(option_type==1){

		$('#zone_sub_theme').hide();

	}else if(option_type==0){

		$('#zone_sub_theme').show();

	}

}

function notification_daycount(){

	if($('#notification_day').val()<5){

            $('#notification_msg').show();

			$('#notification_msg').html('Numbers can\'t be less than 5') ;

			$('#notification_msg').fadeIn(1000).delay(3000).fadeOut('slow') ;	

			var notifyday = '<?=$zonepref['notification_day']?>';

			$('#notification_day').val(notifyday);

		}

}



function savespecificBusiness(zone_id){ 

	var authenticate=check_authneticate();

	if(authenticate=='0'){

		var zone_id = <?=$zoneid?>;			 

		alert('You are currently logged out. Please log in to continue.');

		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

	}else if(authenticate==1){ 			

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

						"notification_day":$('#notification_day').val(),

						"trial_business_active":$('#trial_business_active').val(),

						

						"auto_approve_listed_business_myzone":$('#auto_approve_listed_business_myzone').val(),

						"auto_approve_listed_business_locatedmyzone":$('#auto_approve_listed_business_locatedmyzone').val(),

						

						"auto_approve_emergency_announcements":$('#auto_approve_emergency_announcements').val(),

						"auto_approve_normal_announcements":$('#auto_approve_normal_announcements').val(),

						

						"auto_approve_ig_by_org":$('#auto_approve_ig_by_org').val(),

						"auto_approve_ig_by_business":$('#auto_approve_ig_by_business').val(),

						

						"auto_approve_offers_announcements":$('#auto_approve_offers_announcements').val(),

						"auto_approve_banner":$('#auto_approve_banner').val(),

						"auto_approve_csvupload":$('#auto_approve_csvupload').val(),

						"showoffer":$('#shownooffer').val(),

						"auto_approve_sticky_ad":$('#auto_approve_sticky_ad').val(),

						"ischangezonetheme":$('#is_change_theme').val(),

						"zonetheme":$('#zonetheme').val(),

						"sponsor_ad_text":$('#sponsor_ad_text').val()

						};

						//alert(JSON.stringify(dataToUse));return false;

			PageMethod("<?=base_url('Zonedashboard/savespecificBusiness')?>", "Saving Default Settings<br/>This may take a minute.", dataToUse, spSaveSuccessful, null);

	 }

}

function spSaveSuccessful(){

	$.unblockUI();

	$("#showspbusiness").hide();

}





</script>



