<input type="hidden" id="business_type" value="<?=$business_type?>"/> <input type="hidden" id="business_type_by_category" value="<?=$business_type_by_category?>"/> <input type="hidden" id="business_zone" value="<?=$business_zone?>"/>
<?php if(!empty($non_temp_business_in_zone)) { ?>
<table class="pretty" border="0" cellpadding="0" cellspacing="0">
  <thead id="showhead" class="headerclass">
    <tr>
      <th width="24%">Business Name</th>
      <th width="20%">Contact Name</th>
      <th>Telephone</th>
      <th width="30%">Action</th>
      <th width="12%">Select/<br/>Deselect All<br/><input type="checkbox" name="select_all_business_non_temp" id="select_all_business_non_temp"  value="all" title="Select/Deselect All" alt="Select/Deselect All" data-businesstype="<?=$business_type?>" data-businesstypebycategory="<?=$business_type_by_category?>" data-businesszone="<?=$business_zone?>"></th> 
    </tr>
  </thead>
  <tbody>
    <tr class="headerclass_sub">
      <td colspan="5"><div id="action_performed_div" class="fright">
          <select name="action_performed" id="action_performed" class="w_215 select_style_sm">
            <option value="6">Change Public Display Status</option>
            <option value="3">Delete</option>
          </select>
          <!--<select name="change_business_status" id="change_business_status" class="w_285 select_style_sm">-->
			  <?php if($business_type==1){?>
              <select name="change_business_status" id="change_business_status" class="w_285 select_style_sm">
                <option value="-1">Deactivate - Disable public view of ads</option>
                <option value="2">Active Trial Businesses - Ad is viewable</option>
                <?php if($business_type_by_category=='pbtc' || $business_type_by_category=='tbtc') { ?>
                	<option value="3">Active Upload Businesses - Ad is viewable</option>
                <?php } ?>
           </select>             
              <?php } else if($business_type=='-1'){?>
              <select name="change_business_status" id="change_business_status" class="w_285 select_style_sm">
                <option value="1">Active Paid Businesses - Ad is viewable</option>
                <option value="2">Active Trial Businesses - Ad is viewable</option>
                <?php if($business_type_by_category=='pbtc' || $business_type_by_category=='tbtc') { ?>
                	<option value="3">Active Upload Businesses - Ad is viewable</option>
                <?php } ?>
           </select>
              <? } else if($business_type=='2'){ ?>
              	<select name="change_business_status" id="change_business_status" class="w_285 select_style_sm">
                    <option value="-2">Deactivate - Disable public view of ads</option>
                    <option value="1">Active Paid Businesses - Ad is viewable</option>
                    <?php if($business_type_by_category=='pbtc' || $business_type_by_category=='tbtc') { ?>
                    	<option value="3">Active Upload Businesses - Ad is viewable</option>
                    <?php } ?>
           </select>
               <? } else if($business_type=='-2'){ ?>
                    <select name="change_business_status" id="change_business_status" class="w_285 select_style_sm">
                    <option value="2">Active Trial Businesses - Ad is viewable</option>
                    <option value="1">Active Paid Businesses - Ad is viewable</option>
                    <?php if($business_type_by_category=='pbtc' || $business_type_by_category=='tbtc') { ?>
                    	<option value="3">Active Upload Businesses - Ad is viewable</option>
                    <?php } ?>
           </select>                  	
              <?php }  else if($business_type=='3'){?>
              <select name="change_business_status" id="change_business_status" class="w_285 select_style_sm">
                    <!--<option value="-3">Deactivate - Disable public view of ads</option>-->
                   <option value="2">Active Trial Businesses - Ad is viewable</option>
                    <option value="1">Active Paid Businesses - Ad is viewable</option>
                   
           </select>  
              <?php } else if($business_type=='-3'){?>
              <select name="change_business_status" id="change_business_status" class="w_285 select_style_sm">
              <option value="3">Active Upload Businesses - Ad is viewable</option>
                   <option value="2">Active Trial Businesses - Ad is viewable</option>
                    <option value="1">Active Paid Businesses - Ad is viewable</option>
                    </select>  
              <?php } ?>
              
              <!--<option value="3">Active Upload Businesses - Ad is viewable</option>
           </select>-->
          <select name="business_delete_all_or_specific" id="business_delete_all_or_specific" class="w_215 select_style_sm">
            <option value="1">Selected Businesses</option>
            <option value="2">All Businesses</option>
          </select>
          <select name="action_performed_in_where" id="action_performed_in_where" class="w_215 select_style_sm" style="display:none;">
            <option value="0">Current Zone</option>
            <!--<option value="1" disabled="disabled">All Zones</option>-->
          </select>
          <button class="btn-sm"  id="update_non_temp_business" type="button" data-businesstype="<?=$business_type?>" data-businesstypebycategory="<?=$business_type_by_category?>" data-businesszone="<?=$business_zone?>">Update</button>
        </div></td>
    </tr>
    
	<? foreach($non_temp_business_in_zone as $key1=>$business){
	//echo $key_count=($key1)%2;
	$key_count=($key1)%2;
	if($key_count==0){
		$displaytableview_class='displaytableview_odd';
	}else if($key_count==1){
		$displaytableview_class=='displaytableview_even';
	}	
	?>
    <tr id="<?=$business['businessid']?>" class="uploadbusiness <?=$displaytableview_class?>" >
      <td style="text-align:justify;" width="24%"><b>
        <?=stripslashes($business['name'])?>
        </b><br/>
        <?php /*?><button class="m_left_100" style="background-color:#859731">Go To <b>
        <?=$business['name']?>
        </b> Dashboard</button><?php */?>
        
        </td>
      <td width="20%"><?=$business['first_name']?>&nbsp;<?=$business['last_name']?></td>
        
      <td> 
      <?=$business['phone']?>
        <?php /*?>Activated:<?=$business['approved']?>
        <br />
        Deactivated:
        <?=$business['unapproved']?><?php */?>
        </td>
        <td  width="30%">
        <a href="<?=base_url()?>businessdashboardbcs/viewad/<?=$business['id']?>/<?=$zoneid?>" class="link-underlined text-default"><b>&#x2192; Go To Business Dashboard</b></a><br />
        
        <a class="link-underlined text-default edit_business" href="javascript:void(0)" id="edit_business" rel="<?=$business['id']?>" data-businesstype="<?=$business_type?>" data-businesstypebycategory="<?=$business_type_by_category?>" data-businesszone="<?=$business_zone?>"  title="Edit <?=stripslashes($business['name'])?> Business"><b>&#x2192; Edit Business</b></a><br />
        <!--<a href="javascript:void(0);" class="link-underlined text-default">&#x2192; Send Email to Business Owner to give Login Info</a><br/>-->
        
        </td>
      <td  width="12%"><input type="checkbox" name="checkadfordelete" id="individual_checkbox_business" class="display_checkbox1 <?=$business_type_by_category?>" value="<?=$business['businessid']?>" data-businesstype="<?=$business_type?>" data-businesstypebycategory="<?=$business_type_by_category?>" data-businesszone="<?=$business_zone?>"/></td>
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
    <?php $displaytableview_class=''; } ?>
   
  </tbody>
</table>
<?php /*?><?php if($count_non_temp_business_in_zone>2){?><?php */?>
<div class="display_more_business" style="float: right;"><a class="more_non_temp_business" style=" color:#000;" href="javascript:void(0)" rel="0,0" data-zoneid="<?=$zoneid?>" data-businesstype="<?=$business_type?>" data-businesstypebycategory="<?=$business_type_by_category?>" data-businesszone="<?=$business_zone?>" data-charvalname="<?=$charval_name?>" data-charvalalphabet="<?=$charval_alphabet?>"><strong>Display more businesses</strong></a> </div>
<?php /*?><?php } ?><?php */?>
 <?php } else{ ?>
    <div class="container_tab_header" style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;">No Businesses are Found</div>
    <?php } ?>