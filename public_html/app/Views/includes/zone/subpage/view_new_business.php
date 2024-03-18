<input type="hidden" id="business_type" value="<?=$business_type?>"/> <input type="hidden" id="business_type_by_category" value="<?=$business_type_by_category?>"/> <input type="hidden" id="business_zone" value="<?=$business_zone?>"/>
<?php if(!empty($my_business_in_zone)){?>
<table class="pretty" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">
  <thead>
    <tr>
      <th width="24%">Business Name</th>
      <th width="20%">Contact Name</th>
      <th>No. of Ads</th>
      <th width="30%">Action</th>
      <th width="12%">Select/<br/>
        Deselect All<br/>
        <input type="checkbox" name="select_all_business_new" id="select_all_business_new"  value="all" title="Select/Deselect All" alt="Select/Deselect All"></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td colspan="5"><div id="action_performed_div" class="apmybusiness fright">
          <select name="action_performed" id="action_performed" class="action_performed_mybusiness w_215 select_style_sm">
            <option value="6">Change Public Display Status</option>
            <option value="3">Delete</option>
          </select>
          <select name="change_business_status" id="change_business_status" class="w_285 select_style_sm">
            <option value="2">Active Trial Businesses - Ad is viewable</option>
            <option value="1">Active Paid Businesses - Ad is viewable</option>
          </select>
          <select name="business_delete_all_or_specific" id="business_delete_all_or_specific" class="w_215 select_style_sm">
            <option value="1">Selected Businesses</option>
            <option value="2">All Businesses</option>
          </select>
          <select name="action_performed_in_where" id="action_performed_in_where" class="w_215 select_style_sm" style="display:none;">
            <option value="0">Current Zone</option>
            <option value="1">All Zones</option>
          </select>
          <button class="btn-sm"  id="update_new_business" type="button" bs_type="<?php echo $businesszone_select ?>">Update</button>
        </div></td>
    </tr>
    <? foreach($my_business_in_zone as $business){?>
    <tr id="<?=$business['businessid']?>" class="newbusiness">
      <td style="text-align:justify;"><b>
        <?=$business['name']?>
        </b></td>
      <td><?=$business['last_name']?>
        <?=$business['first_name']?></td>
      <td>New:
        <?=$business['new']?>
        <?php /*?><br />
                  Activated:
                  <?=$business['approved']?>
                  <br />
                  Deactivated:
                  <?=$business['unapproved']?><?php */?></td>
      <td><a href="<?=base_url()?>businessdashboard/businessdetail/<?=$business['businessid']?>/<?=$zoneid?>" class="link-underlined text-default"><b>&#x2192; Go To Business Dashboard</b></a><br />
        <?php /*?><a class="link-underlined text-default" href="javascript:void(0)"  title="Edit <?=stripslashes($business['name'])?> Business"><b>&#x2192; Edit Business</b></a> <?php */?>
        <a class="link-underlined text-default edit_business" href="javascript:void(0)" id="edit_business" rel="<?=$business['businessid']?>" data-businesstype="<?=$business_type?>" data-businesstypebycategory="<?=$business_type_by_category?>" data-businesszone="<?=$business_zone?>"  title="Edit <?=stripslashes($business['name'])?> Business"><b>&#x2192; Edit Business</b></a>
        <!--<br /><a href="javascript:void(0);" class="link-underlined text-default">&#x2192; Send Email to Business Owner to give Login Info</a><br/>--></td>
      <td><input type="checkbox" name="checkadfordelete" id="individual_checkbox_business" class="display_checkbox1" value="<?=$business['businessid']?>" /></td>
      <?php /*?><td><?=$ad['pendingdzone']?></td><?php */?>
      <?php /*?><td><?=$ad['deactivatedzone']?></td>
              <td><button onclick="editad(<?=$ad['id']?>,<?=$ad['business_id']?>,<?=$zoneid?>);">Edit</button>
                <br />
                <br />
                <button onclick="editzone(<?=$ad['id']?>,<?=$ad['business_id']?>);">Edit/Delete Zone</button>
                <br />
                <br />
                <button onclick="deleteAd(<?=$ad['id']?>,<?=$ad['business_id']?>, '<?=stripslashes($ad['name'])?>');">Delete</button></td><?php */?>
    </tr>
    <? }?>
  </tbody>
</table>
<?php } else { ?>
<div class="container_tab_header" style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;">No New Businesses are Found</div>
<?php } ?>
