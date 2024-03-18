<input type="hidden" name="orgzoneid" id="orgzoneid" value="<?=$fromzoneid;?>" />
<input type="hidden" name="org_id" id="org_id" value="<?=$org_id;?>" />
<script type="text/javascript">



$(document).ready(function () { 

	$('#webinar_accordian').click();

	$('#webinar_info').addClass('active');

	

});





$(document).ready(function () { 

    $('#organization_data_accordian').click();

	$('#organization_data_accordian').next().slideDown();

	$('#webinar_accordian').click();

	$('#webinar_accordian').next().slideDown();

	$('#webinar_info').addClass('active');

});



function  check_authneticate(){ //alert(1);

	var is_authenticated=0;

	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ //alert('success');

		is_authenticated=data;

	}});	

	return is_authenticated;

}



/* Save New Category */

// function save_webinar_link(){

// 	var authenticate=check_authneticate();

// 	if(authenticate=='0'){

// 		var zone_id = <?=$zoneid;?>;			 

// 		alert('You are currently logged out. Please log in to continue.');

// 		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

// 	}else if(authenticate==1){

// 		var status = $('input[name=select]:checked').val();	

// 		if($("#webinar_link").val() == '' && $("#description").val() == ''){

// 			alert('Please enter the webinar information.'); return false;

// 		}else if($("#webinar_link").val() == ''){

// 			alert('Please enter the room link'); return false;

// 		}

// 		else if($("#description").val() == ''){

// 			alert('Please enter the description'); return false;

// 		}

// 		var dataToUse = {

// 			"zoneid":$("#zoneid").val(),

// 			"organization_id":$("#organization_id").val(),

// 			"status":status,

// 			"webinar_link": $("#webinar_link").val(),

// 			"description": $("#description").val(),

// 			"created_by_userid":$("#created_by_userid").val(),

// 		}; 

// 		PageMethod("<?=base_url('organizationdashboard/save_webinar_link')?>", "Processing...<br/>This may take a minute.", dataToUse, weblinkSuccess, null);

// 	 }

// }



function weblinkSuccess(result){

	$.unblockUI();

	var message = result.Message;

	var title = result.Title;

	var txt = '';

	 	if(title==2){

			txt = '<h4 style="color:#090">Successfully saved the webinar information.</h4>' ;

	 	}else {

			alert('Webinar information already exist in the system. Either delete and create new or update the existing.'); return false;

		}

	  $("#msg").html(txt).show();

	  $("#msg").show();

	  $("#webinar_link").val('');

	  $("#description").val('');

	  $('html,body').animate({scrollTop:0},"slow");

	  setTimeout(function(){$("#msg").hide('slow');},3000);

}



 /*$(document).ready(function () {

                    $('#enable').click(function () {

                    

                       $('#div1').show('fast');

                });

                $('#disable').click(function () {

                      $('#div1').hide('fast');

                

                 });

               });*/

</script>





<input type="hidden" name="zoneid" id="zoneid" value="<?=$zoneid;?>" />

<input type="hidden" name="orgnid" id="organization_id" value="<?=$organizationid;?>" />





	



<div class="content_container content_webiner_information">


        

	<div id="container_tab_content" class="container_tab_content bv_webiner_info cus-web-info">

        <div id="tabs-2_y" class="row">
        <div class="top-title">
          <h2>Enter Webinar Information</h2>
          <h3 style="margin-bottom: 15px;
    font-size: 14px;
    line-height: 20px;">To use the free webinar service: <br />First sign up with <a href="https://talky.io/" target="_blank"><u> www.talky.io</u></a> <br />Then enter your personal room link and a description of your webinar.</h3>
          <hr class="center-diamond">
        </div>
        	<div class="col-sm-6 bv_img_info">
        		
        	<img src="https://cdn.savingssites.com/webinar_information.jpg" style="height: 360px;">

        	</div>

        	<div class="col-sm-6">

        	<div id="msg" style="display:none;margin-top:7px;"></div>

        	

        <div class="form-group center-block-table form_web_information">

            <p>

            	<div id="new_category">

                 <div id="status" align="center">

                	<input type="radio" name="select" value="1" checked="checked" /> Enable <input type="radio" name="select" value="-1" /> Disable<br /><br />
                 </div>

                 <div id="div1">

                   <label for="webinar_link" class="fleft w_150">Enter Room Link</label>

                      <input type="text" id="webinar_link" name="webinar_link" placeholder="Please enter the room link" class="w_300"/><br /><br />

                      <label for="webinar_link" class="fleft w_150">Enter Description</label>

                      <textarea name="description" id="description" placeholder="Please enter the description" class="w_300"></textarea>

                    <p>

                        <button class="m_left_150" onclick="save_webinar_link()">Save</button>

                        <!--<button onclick="HideCategoryEditor()">Back To Category</button>-->

                    </p>

                    </div>

                </div>

            </p>

        </div>

        </div>
    	</div>

    	</div>

      

    </div>