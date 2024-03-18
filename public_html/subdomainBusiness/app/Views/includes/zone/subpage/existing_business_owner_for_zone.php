<p class="form-group-row">
  <!--<label for="business_type" class="fleft w_200">Existing Business Owner(Advertiser)</label>-->
  <?php if(!empty($existing_business_owner_for_zone)){?>
  <select class="fleft w_315" id="ebo" style="width:555px; margin-left:200px;">
  <?php 
    foreach($existing_business_owner_for_zone as $ebo){
	if($ebo['first_name']!='' && $ebo['last_name']!=''){
		$ebo_name=$ebo['first_name'].' '.$ebo['last_name'];
	}else{
		$ebo_name=$ebo['username'];
	}
	?>
    <option value="<?=$ebo['id']?>"><?=$ebo_name?></option>
    <?php } ?>
  </select>
  <?php } else {?>
  <p style="margin-left:200px; color:red">No Existing Paid/Trial Business Owner in your Zone.</p>
  <?php } ?>
</p>