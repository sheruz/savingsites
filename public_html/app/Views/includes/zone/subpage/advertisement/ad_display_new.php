<?php /*?><table class="pretty advertisement_display" border="0" cellpadding="0" cellspacing="0" style="margin-top:-15px;">
    <!--<thead><tr><th>Ad Details</th><th>StartDateTime<br />StopDateTime</th><th>Business Details</th><th>Action</th></tr></thead>-->
    <tbody><?php */?>
    <?php if(!empty($add_approve_zone)) { ?>		
          <tr class="headerclass_ad"><td colspan="5"><div id="action_performed_div" class="fright">
          <select name="action_performed" id="action_performed" onchange="action_performed_change();">
            <option value="1">Change Public Display Status</option>
            <option value="2">Delete</option>
          </select>
         <?php if($selectedoption == 1){ ?>
          <select name="change_ads_status" id="change_ads_status">
            <option value="-1">Deactivate Advertisement</option>             
          </select>
         <?php }else if($selectedoption == 0){ ?> 
         <select name="change_ads_status" id="change_ads_status">
            <option value="1">Activate Advertisement</option>            
            <option value="-1">Deactivate Advertisement</option>                    
         </select>   
         <?php }if($selectedoption == -1){ ?>
         <select name="change_ads_status" id="change_ads_status">
            <option value="1">Activate Advertisement</option>          
         </select>
         <?php } ?> 
          <select name="specific_or_all" id="specific_or_all" onchange="specific_or_all();">
            <option value="1">Selected Ad</option>
            <option value="2">All Ads</option>
          </select>
          <button class="btn-sm" type="button" id="update_ad" data-businessid="<?=$businessid?>" data-adtype="<?=$selectedoption?>">Update</button>
          </div>	
          </td></tr>
    <?php foreach($add_approve_zone as $key=>$addApproveZone){
			$key_count=($key)%2;
			if($key_count==0){
				$displaytableview_class='displaytableview_odd';
			}else if($key_count==1){
				$displaytableview_class=='displaytableview_even';
			}
		?>
        <tr id="<?=$addApproveZone['adid']?>" class="ads_row <?=$displaytableview_class; ?>">
        <td style="text-align:justify;" width="60%" class="responsive-image tdwordbreakall" >
		<?=urldecode($addApproveZone['adtext'])?><br />
        <i>Offer Code:</i> <?=$addApproveZone['offer_code']?><br /><br />
        <?php if(!empty($reason[$addApproveZone['adid']])){?><i>This ad was edited because: <br /></i> <?=$reason[$addApproveZone['adid']]?><?php }?>
        </td>
        <td width="20%">Main Category: <?=$addApproveZone['catname']; ?><br />Sub-Category: <?=$addApproveZone['subcatname']; ?></td>
        <td width="10%">
        <?php if($addApproveZone['startdate']!='0000-00-00' && $addApproveZone['enddate']!='0000-00-00' && $addApproveZone['starttime']!=NULL && $addApproveZone['stoptime']!=NULL){ ?>
        <b>Start Date:</b> <?=$addApproveZone['startdate']?><br />
		<b>End Date:</b> <?=$addApproveZone['enddate']?><br/>
        <b>Time Slot:</b> <?php echo date("g:i a", strtotime($addApproveZone['starttime'])).' <b>To</b> '.date("g:i a", strtotime($addApproveZone['stoptime']));?>
        <? } else { ?>
        <?php echo "";?>
        <? } ?>
        </td>
        <td width="20%">Business Owner: 
		<? if($addApproveZone['last_name']!=''){?>
		<?=stripslashes($addApproveZone['first_name'])?> , <?=stripslashes($addApproveZone['last_name'])?> 
        <? } else { ?>
        <?=stripslashes($addApproveZone['username'])?>
        <? } ?>
        <br />
		Business:  <?=urldecode(stripslashes($addApproveZone['busname']))?></td>
        <td	width="20%">    
        
        <input type="checkbox" name="checkadforchange" class="display_checkbox1 individual_checkbox_nontempads" value="<?=$addApproveZone['adid']?>"/>
            
        <!--<button onclick="ads_edit(<?=$addApproveZone['adid']?>,<?=$zoneid?>,<?=$addApproveZone['business_id']?>);">Edit</button><br /><br />
		
		<?php if($addApproveZone['approval']==0 || $addApproveZone['approval']==2){ ?>
        	<button class="ad_approval_activate" onclick="ad_approval(<?=$addApproveZone['adid']?>,<?=$zoneid?>,1,<?=$addApproveZone['business_id']?>);">Activate</button><br /><br /><button class="ad_approval_deactivate" onclick="ad_approval(<?=$addApproveZone['adid']?>,<?=$zoneid?>,-1,<?=$addApproveZone['business_id']?>);">Deactivate</button><br /><br /><button onclick="ad_approval_delete(<?=$addApproveZone['adid']?>,<?=$zoneid?>,5,<?=$addApproveZone['business_id']?>);">Delete</button>
        <?php } else if($addApproveZone['approval']==1){?>
            <button class="ad_approval_deactivate" onclick="ad_approval(<?=$addApproveZone['adid']?>,<?=$zoneid?>,-1,<?=$addApproveZone['business_id']?>);">Deactivate</button><br /><br /><button onclick="ad_approval_delete(<?=$addApproveZone['adid']?>,<?=$zoneid?>,5,<?=$addApproveZone['business_id']?>);">Delete</button>
        <?php } else if($addApproveZone['approval']=='-1'){?>
        	<button class="ad_approval_activate" onclick="ad_approval(<?=$addApproveZone['adid']?>,<?=$zoneid?>,1,<?=$addApproveZone['business_id']?>);">Activate</button><br /><br /><button onclick="ad_approval_delete(<?=$addApproveZone['adid']?>,<?=$zoneid?>,5,<?=$addApproveZone['business_id']?>);">Delete</button>
        <?php } ?><br/>
		<?php if($sticky_ad_settings[0]['auto_approve_sticky_ad']){
		if($addApproveZone['stickyad']==0){ ?>
		<button onclick="ad_sticky(<?=$addApproveZone['adid']?>,<?=$zoneid?>,<?=$addApproveZone['business_id']?>,1);">Stick</button>
		<?php } else if($addApproveZone['stickyad']==1){ ?>
		<button onclick="ad_sticky(<?=$addApproveZone['adid']?>,<?=$zoneid?>,<?=$addApproveZone['business_id']?>,0);">Unstick</button>
		<? } }?>-->
		
        </td>
        </tr>
    <? $displaytableview_class=''; } } ?>
<?php /*?>    </tbody>
</table><?php */?>
<?php /*?><div style="float:right"><a id="my_business_limit" href="javascript:void(0)" onclick="showAdvertisement(<?=$zoneid?>,'<?=$charval?>',this);" rel="0,0">Display more ad</a> </div><?php */?>