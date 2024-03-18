<?php 
$zone_id = $common['zoneid'] ;

$store_name = '' ;
$store_link = '' ;
$store_status = '0' ;

if(!empty($get_store_details[0])){
	$store_name =  ($get_store_details[0]['store_name'] != '') ? $get_store_details[0]['store_name'] : '';
	$store_link =  ($get_store_details[0]['store_link'] != '') ? $get_store_details[0]['store_link'] : '';
	$store_status =  ($get_store_details[0]['status'] != '') ? $get_store_details[0]['status'] : '';
}
?>
<div class="main_content_outer">
  <div class="content_container">
    <div class="container_tab_header">Edit Local Store</div>
    <div id="container_tab_content" class="container_tab_content">
      <div id="msg" style="display:none;"></div>
      <div id="tabs-2">
        <div class="form-group">
          <?=form_open("Zonedashboard/update_local_store", "name='localstore_edit_form' id='localstore_edit_form'");?>
          <input type="hidden" id="iszoneid" name="zoneid" value="<?=$zone_id?>"/>
          <input type="hidden" id="storeid" name="storeid" value="<?=$get_store_details[0]['id']?>"/>
          <p class="form-group-row">
            <label for="store_name" class="fleft w_200">Store Name:</label>
            <input type="text" id="store_name" name="store_name" class="w_536" placeholder="Enter Store Name" value="<?php echo $store_name ;?>"/>
          </p>
          <p class="form-group-row">
            <label for="mm_desc" class="fleft w_200">Store Link:</label>
            <textarea rows="10" cols="45" style="width: 536px; height: 150px" id="store_link" name="store_link"><?php echo $store_link ;?></textarea>
          </p>
          <p class="form-group-row">
          	<label for="store_name" class="fleft w_200">Status:</label>
            <input type="radio" name="store_status" value="1" <?php echo($store_status == '1' ? 'checked' : ''); ?>>Viewable on directory page
            <input type="radio" name="store_status" value="0" <?php echo($store_status == '0' ? 'checked' : ''); ?>>Not viewable on directory page
          </p>
          <?=form_close()?>
          <button onclick="update_local_store($(this).prev('form'))" style="margin-left:200px;">Submit</button>
          <button onclick="location.href='<?=base_url('Zonedashboard/zonelocalstores/'.$zone_id)?>'" style="margin-left:10px;">Back</button>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function () { 
	$('#adv_tools').click();
	$('#adv_tools').next().slideDown();
	$('#zone_store').click();
	$('#zone_store').addClass('active');
	$('#tab1').click();
});

function check_authneticate(){ //alert(1);
	var is_authenticated=0;
	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ //alert('success');
		is_authenticated=data;
	}});	
	return is_authenticated;
}

// + Update Local Store Start
function update_local_store(){
	var authenticate=check_authneticate();
	if(authenticate == '0'){
		var zone_id = <?=$common['zoneid']?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate == 1){
		var status = $('input[name=select]:checked').val();	
			if($("#store_name").val()==undefined || $("#store_name").val()==''){
			alert('Please provide store name.');
			return false;
		}
		if($("#store_link").val()==undefined || $("#store_link").val()==''){
			alert('Please provide store link.');
			return false;
		}	 
		var dataToUse = $('form#localstore_edit_form').serialize();
		PageMethod("<?=base_url('Zonedashboard/updatelocalstore')?>", "Processing...<br/>This may take a minute.", dataToUse, localStoreUpdateSuccessful, null);
	 }
}

function localStoreUpdateSuccessful(result){//alert(JSON.stringify(result)); return false;
	$.unblockUI();
	var message = result.Message;
	var txt = '';
	  	if(message){
			txt = '<h4 style="color:#090">Successfully updated local store information.</h4>' ;
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
// + Update Local Store End

</script>