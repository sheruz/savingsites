<?php 
$zone_id = $common['zoneid'] ;

$real_estate_name = '' ;
$real_estate_link = '' ;
$real_estate_status = '0' ;

if(!empty($get_realestate_details[0])){
	$real_estate_name =  ($get_realestate_details[0]['real_estate_name'] != '') ? $get_realestate_details[0]['real_estate_name'] : '';
	$real_estate_link =  ($get_realestate_details[0]['real_estate_link'] != '') ? $get_realestate_details[0]['real_estate_link'] : '';
	$real_estate_status =  ($get_realestate_details[0]['status'] != '') ? $get_realestate_details[0]['status'] : '';
}
?>
<div class="main_content_outer">
  <div class="content_container">
    <div class="container_tab_header">Edit Real Estates</div>
    <div id="container_tab_content" class="container_tab_content">
      <div id="msg" style="display:none;"></div>
      <div id="tabs-2">
        <div class="form-group">
          <?=form_open("Zonedashboard/update_real_estate", "name='realestate_edit_form' id='realestate_edit_form'");?>
          <input type="hidden" id="iszoneid" name="zoneid" value="<?=$zone_id?>"/>
          <input type="hidden" id="realestateid" name="realestateid" value="<?=$get_realestate_details[0]['id']?>"/>
          <p class="form-group-row">
            <label for="label_real_estate_name" class="fleft w_200">Real Estate Name:</label>
            <input type="text" id="real_estate_name" name="real_estate_name" class="w_536" placeholder="Enter Real Estate Name" value="<?php echo $real_estate_name ;?>"/>
          </p>
          <p class="form-group-row">
            <label for="label_real_estate_link" class="fleft w_200">Real Estate Link:</label>
            <textarea rows="10" cols="45" style="width: 536px; height: 150px" id="real_estate_link" name="real_estate_link"><?php echo $real_estate_link ;?></textarea>
          </p>
          <p class="form-group-row">
          	<label for="label_real_estate_status" class="fleft w_200">Status:</label>
            <input type="radio" name="real_estate_status" value="1" <?php echo($real_estate_status == '1' ? 'checked' : ''); ?>>Viewable on directory page
            <input type="radio" name="real_estate_status" value="0" <?php echo($real_estate_status == '0' ? 'checked' : ''); ?>>Not viewable on directory page
          </p>
          <?=form_close()?>
          <button onclick="update_real_estate($(this).prev('form'))" style="margin-left:200px;">Submit</button>
          <button onclick="location.href='<?=base_url('Zonedashboard/zonerealestates/'.$zone_id)?>'" style="margin-left:10px;">Back</button>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function () { 
	$('#adv_tools').click();
	$('#adv_tools').next().slideDown();
	$('#zone_real_estate').click();
	$('#zone_real_estate').addClass('active');
	$('#tab1').click();
});

function check_authneticate(){ //alert(1);
	var is_authenticated=0;
	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ //alert('success');
		is_authenticated=data;
	}});	
	return is_authenticated;
}

// + Update Real Estate Start
function update_real_estate(){
	var authenticate=check_authneticate();
	if(authenticate == '0'){
		var zone_id = <?=$common['zoneid']?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate == 1){
		if($("#real_estate_name").val()==undefined || $("#real_estate_name").val()==''){
			alert('Please provide real estate name.');
			return false;
		}
		if($("#real_estate_link").val()==undefined || $("#real_estate_link").val()==''){
			alert('Please provide real estate link.');
			return false;
		}	 
		var dataToUse = $('form#realestate_edit_form').serialize();
		PageMethod("<?=base_url('Zonedashboard/updaterealestate')?>", "Processing...<br/>This may take a minute.", dataToUse, realEstateUpdateSuccessful, null);
	 }
}

function realEstateUpdateSuccessful(result){//alert(JSON.stringify(result)); return false;
	$.unblockUI();
	var message = result.Message;
	var txt = '';
	  	if(message){
			txt = '<h4 style="color:#090">Successfully updated real estate information.</h4>' ;
	  	}else {
			txt = '<h4 style="color:#090">The update was not successfull.</h4>';
		}
	  $("#msg").html(txt).show();
	  $("#msg").show();
	  //$("#webinar_link").val('');
	  //$("#description").val('');
	  $('html,body').animate({scrollTop:0},"slow");
	  setTimeout(function(){$("#msg").hide('slow');},3000);
}
// + Update Real Estate End

</script>