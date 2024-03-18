<?php if(!empty($non_temp_business_in_zone)) { ?>
<table class="pretty" border="0" cellpadding="0" cellspacing="0">
  <thead id="showhead" class="headerclass">
    <tr>
      <th width="10%">Business Id</th>
      <th width="15%">Business Name</th>
      <th width="20%">Business Status</th>
      <th width="10%">Contact Name</th>
      <th width="10">Telephone</th>
      <th width="10%">Zip Code</th>
    </tr>
  </thead>
  <tbody>
  
	<?php foreach($non_temp_business_in_zone as $key1=>$business){
		$business_status = '';
		$trial_remaining = '';
		if(isset($business['approval'])){
			if($business['approval'] == 2){
				$business_status = 'Viewable Free Trial'.$trial_remaining ;
			}else if($business['approval'] == -2){		
				$business_status = ' Not Viewable Free Trial' ;
			}
		}
	?>
    <tr id="<?=$business['businessid']?>" class="uploadbusiness <?=$displaytableview_class?>" >
      <td style="text-align:justify;" width="10%"><b>
        <?=urldecode($business['id'])?>
        </b><br/>
      </td>
     
      <td width="15%"><b>
        <?=urldecode(stripslashes($business['name']))?>
        </b><br/>
       
        </td>
        <td width="20%" class="samestatus" data-samestatus="<?php echo $business['approval']; ?>"><b>
        <?=$business_status?>
        </b><br/>
        </td>
      <td width="20%"><?=urldecode(stripslashes($business['first_name']))?>&nbsp;<?=urldecode(stripslashes($business['last_name']))?></td>
        
      <td width="10">
      <?=$business['phone']?> 
       </td>
         
       <td width="10">
      
        <?=str_pad(urldecode($business['zip_code']), 5, '0', STR_PAD_LEFT)?>
       </td>

    </tr>
    <?php $displaytableview_class=''; } ?>
   
  </tbody>
</table>
<div class="display_more_business" style="float: right;"><a class="more_non_temp_business" style=" color:#000;" href="javascript:void(0)" rel="0,0" data-zoneid="<?=$zoneid?>" data-businesstype="<?=$business_type?>" data-businesstypebycategory="<?=$business_type_by_category?>" data-businesszone="<?=$business_zone?>" data-charvalname="<?=$charval_name?>" data-charvalalphabet="<?=$charval_alphabet?>"><strong>Display more businesses</strong></a> </div>
 <?php } else{ ?>
    <div class="container_tab_header" id="not_found" style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;">No Businesses are Found</div>
    <?php } ?>
	
    <script type="text/javascript">
  $(document).ready(function () {
    $('#action_performed').change(function() {   // available all business drop down only for delete
      if ($(this).val() == 3) {
        $('#status_all').show();
      } else {
		  $('#business_delete_all_or_specific>option:eq(0)').attr('selected', true);
          $('#status_all').hide();
		 }
    });
  });
</script>