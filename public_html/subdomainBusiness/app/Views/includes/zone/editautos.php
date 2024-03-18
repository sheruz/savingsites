<?php 
$zone_id = $common['zoneid'] ;

$autos_name = '' ;
$autos_link = '' ;
$autos_status = '0' ;

if(!empty($get_autos_details[0])){
	$autos_name =  ($get_autos_details[0]['autos_name'] != '') ? $get_autos_details[0]['autos_name'] : '';
	$autos_link =  ($get_autos_details[0]['autos_link'] != '') ? $get_autos_details[0]['autos_link'] : '';
	$autos_status =  ($get_autos_details[0]['status'] != '') ? $get_autos_details[0]['status'] : '';
}
?>
<div class="main_content_outer">
  <div class="content_container">
    <div class="container_tab_header">Edit Auto</div>
    <div id="container_tab_content" class="container_tab_content">
      <div id="msg" style="display:none;"></div>
      <div id="tabs-2">
        <div class="form-group">
          <?=form_open("Zonedashboard/update_auto", "name='auto_edit_form' id='auto_edit_form'");?>
          <input type="hidden" id="iszoneid" name="zoneid" value="<?=$zone_id?>"/>
          <input type="hidden" id="autosid" name="autosid" value="<?=$get_autos_details[0]['id']?>"/>
          <p class="form-group-row">
            <label for="label_autos_name" class="fleft w_200">Autos Name:</label>
            <input type="text" id="autos_name" name="autos_name" class="w_536" placeholder="Enter Autos Name" value="<?php echo $autos_name ;?>"/>
          </p>
          <p class="form-group-row">
            <label for="label_autos_link" class="fleft w_200">Autos Link:</label>
            <textarea rows="10" cols="45" style="width: 536px; height: 150px" id="autos_link" name="autos_link"><?php echo $autos_link ;?></textarea>
          </p>
          <p class="form-group-row">
          	<label for="label_autos_status" class="fleft w_200">Status:</label>
            <input type="radio" name="autos_status" value="1" <?php echo($autos_status == '1' ? 'checked' : ''); ?>>Viewable on directory page
            <input type="radio" name="autos_status" value="0" <?php echo($autos_status == '0' ? 'checked' : ''); ?>>Not viewable on directory page
          </p>
          <?=form_close()?>
          <button onclick="update_autos($(this).prev('form'))" style="margin-left:200px;">Submit</button>
          <button onclick="location.href='<?=base_url('Zonedashboard/zoneautos/'.$zone_id)?>'" style="margin-left:10px;">Back</button>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function () { 
	$('#adv_tools').click();
	$('#adv_tools').next().slideDown();
	$('#zone_autos').click();
	$('#zone_autos').addClass('active');
	$('#tab1').click();
});

function check_authneticate(){ //alert(1);
	var is_authenticated=0;
	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ //alert('success');
		is_authenticated=data;
	}});	
	return is_authenticated;
}

// + Update Autos Start
function update_autos(){
	var authenticate=check_authneticate();
	if(authenticate == '0'){
		var zone_id = <?=$common['zoneid']?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate == 1){
		if($("#autos_name").val()==undefined || $("#autos_name").val()==''){
			alert('Please provide auto name.');
			return false;
		}
		if($("#autos_link").val()==undefined || $("#autos_link").val()==''){
			alert('Please provide auto link.');
			return false;
		}	 
		var dataToUse = $('form#auto_edit_form').serialize();
		PageMethod("<?=base_url('Zonedashboard/updateautos')?>", "Processing...<br/>This may take a minute.", dataToUse, autosUpdateSuccessful, null);
	 }
}

function autosUpdateSuccessful(result){//alert(JSON.stringify(result)); return false;
	$.unblockUI();
	var message = result.Message;
	var txt = '';
	  	if(message){
			txt = '<h4 style="color:#090">Successfully updated auto information.</h4>' ;
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
// + Update Autos End

</script>