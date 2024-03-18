<script type="text/javascript">
/*$(document).ready(function () { 
	$('#webinar_accordian').click();
	$('#webinar_information1').addClass('active');
	//var location = document.URL.split('/');
	//alert(location[location.length-1]);
	//EditAnnouncement(location[location.length-1]);
});*/

$(document).ready(function () { 
	$('#adv_tools').click();
	$('#adv_tools').next().slideDown();
	$('#phone_broadcasting').click();
	$('#phone_broadcasting').next().slideDown();
	$('#phone_broadcasting_view').addClass('active');
	
	
});
/* Edit Anncouncement */

var zoneid = <?=$common['zoneid']?>;

function  check_authneticate(){ //alert(1);
	var is_authenticated=0;
	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ //alert('success');
		is_authenticated=data;
	}});	
	return is_authenticated;
}

function update_phone_broadcasting_link(){
	var authenticate=check_authneticate();
	if(authenticate=='0'){
		var zone_id = <?=$common['zoneid']?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){
	
		if($("#phone_link").val() == ''){
			alert('Please enter the phone broadcasting information'); return false;
		}
			 
		var dataToUse = {
			"zoneid":$("#zoneid").val(),
		
			"phone_link": $("#phone_link").val(),
			"phone_id": $("#phone_id").val(),
			
		
		};
		PageMethod("<?=base_url('Zonedashboard/update_phone_broadcasting_link')?>", "Processing...<br/>This may take a minute.", dataToUse, phonebroadcastingSuccess, null);
	 }
}

function phonebroadcastingSuccess(result){//alert(JSON.stringify(result)); return false;
	$.unblockUI();
	var message = result.Message;
	var txt = '';
	  	if(message){
			txt = '<h4 style="color:#090">Successfully update the phone broadcasting.</h4>' ;
	  	}else {
			txt = '<h4 style="color:#090">The save was not successfull.</h4>';
		}
	  $("#msg").html(txt).show();
	  $("#msg").show();
	  //$("#webinar_link").val('');
	  //$("#description").val('');
	  $('html,body').animate({scrollTop:0},"slow");
	  setTimeout(function(){$("#msg").hide('slow');},3000);
}

$(document).ready(function() {
  $("#phone_link").blur(function() {
    var input = $(this);
    var val = input.val();
    if (val && !val.match(/^http([s]?):\/\/.*/)) {
        input.val('http://' + val);
    }
  });
});

$(function() {
	
	 var re = /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/
	 
		$(document).on('blur','#phone_link',function() {	
		if (re.test($(this).val())) {
		     // alert('Valid URL');
			 //$('html,body').animate({scrollTop:0},"slow");
//				$("#msg").html('<h4 style="color:#090">Valid coupon link</h4>').show();
//				 setTimeout(function(){$("#msg").hide('slow');},3000);
			
		}else{
				$("#phone_link").val("");
				$('html,body').animate({scrollTop:0},"slow");
				$("#msg").html('<h4 style="color:#090">Invalid Phone Broadcasting link</h4>').show();
				 setTimeout(function(){$("#msg").hide('slow');},3000);
		}
  });
});




</script>


<input type="hidden" name="zoneid" id="zoneid" value="<?=$common['zoneid']?>" />

<div class="main_content_outer"> 
  
<div class="content_container">
	<div class="container_tab_header">Edit Phone Broadcasting Information</div>
    <div id="msg"></div>
    
    
	<div id="container_tab_content" class="container_tab_content">
        
        <div class="form-group center-block-table">
        	<input type="hidden" id="announcement_id" name="announcement_id" value="-1"/>
            <input type="hidden" id="announcement_zone" name="announcement_zone" value="<?=$common['zoneid']?>"/>
            <input type="hidden" id="phone_id" name="phone_id" value="<?=$getall_coupon[0]['id']?>"/>
            
               
               <label for="phone_link" style="margin-top:0px;" class="fleft w_150">Enter Phone Broadcasting Link</label>
        <input type="text" id="phone_link" name="phone_link" value="<?=$getall_coupon[0]['phone_broadcasting']?>" placeholder="Enter # (e.g. http://savingssites.com)" class="w_300"/><br /><br />
              
                <p>
                    <button class="m_left_150" onclick="update_phone_broadcasting_link()">Save</button>
                </p>      
        </div>
        
    </div>
    
    
</div>

</div>

 
