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

	$('#zonewebinar').click();

	$('#zonewebinar').next().slideDown();

	$('#zonewebinar_infoinformation1').addClass('active');

	

	

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



function update_webinar_link(){

	var authenticate=check_authneticate();

	if(authenticate=='0'){

		var zone_id = <?=$common['zoneid']?>;			 

		alert('You are currently logged out. Please log in to continue.');

		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

	}else if(authenticate==1){

		var status = $('input[name=select]:checked').val();	

		if($("#webinar_link").val() == '' && $("#description").val() == ''){

			alert('Please enter the webinar information.'); return false;

		}else if($("#webinar_link").val() == ''){

			alert('Please enter the room link'); return false;

		}

		else if($("#description").val() == ''){

			alert('Please enter the description'); return false;

		}	 

		var dataToUse = {

			"zoneid":$("#zoneid").val(),

			"status":status,

			"webinar_link": $("#webinar_link").val(),

			"description": $("#description").val(),

			"webinar_id":$("#webinar_id").val(),

			"ad_stopdatetime":$("#ad_stopdatetime").val(),

    		"ad_startdatetime":$("#ad_startdatetime").val(),

    		"recordinglink":$("#recordinglink").val(),

		      "desImage": $('#show_banner img').attr('src') , 

		       "totalpeople": $('#totalpeople').val() , 

		       "room_type":$("#roomtype:checked").val(),


		};

		PageMethod("<?=base_url('Zonedashboard/update_webinar_link')?>", "Processing...<br/>This may take a minute.", dataToUse, weblinkSuccess, null);

	 }

}

function ajaxFileUpload(){

  //starting setting some animation when the ajax starts and completes

  $('#spinner').show();

   $.ajaxFileUpload(            

  {

    type:"POST",

    url:'<?=base_url('banner_controller/save_zonelogo_image/'.$common['zoneid'].'')?>',

    secureuri:false,

    fileElementId:'imgfile',

    dataType: 'json',

    success: function (data, status)

    {

      $('#spinner').hide();

      $('.form_error').hide();

      $('#image_block').show();

      $('#uploadedInput').val(data.clientImage);

      $('#folder_name').val(data.folder_name);

      //$('#show_banner').html('<img src="'+baseurl+'uploads/zone_logo/temp_folder/'+data.uploadedImage+'/normal_image/'+data.clientImage+'" style="width:300px;  margin-top: 8px;">');

      $('#show_banner').html('<img src="'+baseurl+'uploads/zone_logo/'+zone_id+'/normal_image/'+data.clientImage+'" style="width:300px;  margin-top: 8px;">');

      if(data!=0){}

      if(typeof(data.error) != 'undefined')

      {

        if(data.error != '')

        {

          alert(data.error);

        }else

        {

          alert(data.msg);

        }

      }

    },

    error: function (data, status, e)

    {

      //alert(e);

    }

  }

)       

return false;

}




function weblinkSuccess(result){//alert(JSON.stringify(result)); return false;

	$.unblockUI();

	var message = result.Message;

	var txt = '';

	  	if(message){

			txt = '<h4 style="color:#090">Successfully saved the webinar information.</h4>' ;

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

$("#ad_startdatetime,#ad_stopdatetime").live('focus',function(){

	$(this).datetimepicker({

		changeMonth: true,

		changeYear: true,

		dateFormat:'mm-dd-yy'

	});

});





</script>





<input type="hidden" name="zoneid" id="zoneid" value="<?=$common['zoneid']?>" />



<div class="main_content_outer"> 

  

<div class="content_container">

	<div class="container_tab_header">Edit Webinar Information</div>

    <div id="msg"></div>

    

     <h3 style="background:#5B9733, #FFF">To use the free webinar service: <br />First sign up with <a href="https://talky.io/" target="_blank"><u> www.talky.io</u></a> <br />Then enter your personal room link and a description of your webinar.</h3>

    

	<div id="container_tab_content" class="container_tab_content">

        

        <div class="form-group center-block-table">

        	<input type="hidden" id="announcement_id" name="announcement_id" value="-1"/>

            <input type="hidden" id="announcement_zone" name="announcement_zone" value="<?=$common['zoneid']?>"/>

            <input type="hidden" id="webinar_id" name="webinar_id" value="<?=$getall_webinar[0]['id']?>"/>

            

               <div id="status" align="center">

                	<input type="radio" name="select" value="1" checked="checked" />Enable <input type="radio" name="select" value="-1" />Disable<br /><br /><br /><br />

               </div>


                  <label for="webinar_link" class="fleft w_150"> Room Type: </label>
                
                 <input type="radio" id="roomtype" name="roomtype" value="paid" class="w_300" <?php if($getall_webinar[0]['room_type'] == 'paid'){ echo "checked=checked"; } ?>   >
                  <label for="male">Paid</label>    
                  <input type="radio" id="roomtype" name="roomtype" value="free"  class="w_300"  <?php if($getall_webinar[0]['room_type'] == 'free'){ echo "checked=checked"; } ?> >
                  <label for="female">Free</label><br>
                  

                 <br><br>     <div class="paid boxes">
           <br /><br />
                     <label for="biz_sic" class="fleft w_150">Price</label>

                   <input type="text" id="price"   class="w_300"  value="<?php echo $getall_webinar[0]['price'] ?>"  />


                   <br /><br />

                      <label for="biz_sic" class="fleft w_150">Paypal Email ID (Please enter paypal Business Account id only)</label>

                   <input type="text" id="pemail"   class="w_300"  value="<?php echo $getall_webinar[0]['paypal_id'] ?>"  />


                   <br /><br />


                  </div>
                  <br><br>
                 <label for="webinar_link" class="fleft w_150"> Upload Image: </label>

                 <div id="uplodImage">

              <input type="file" id="imgfile" onchange="ajaxFileUpload();"  name="imgfile" value="" />

              <input type="hidden" name="uploadedInput" id="uploadedInput" value="" />

              <input type="hidden" name="zone_id" value="<?php echo $zone_id;?>" />
          

              <span style="display:none;right: 240px;" id="spinner"><img src="<?php echo base_url() ?>assets/images/loading.gif"></span>

              

              <!--<p id="uploading">(Please select a file(1526px*471px) to upload)</p>-->

              </div>

                   
                       
                       <div id="show_banner" style="width: 300px;"> <img src="<?=$getall_webinar[0]['webinarImage']?>" /> </div>

                 
                    
                 <br><br>

                  <label for="biz_sic" class="fleft w_150">Total People</label>

                   <input type="text" id="totalpeople"   class="w_300"  value="<?=$getall_webinar[0]['totalpeople']?>"  />


                   <br /><br />




               <label for="webinar_link" class="fleft w_150">Enter Room Link</label>

                      <input type="text" id="webinar_link" name="webinar_link" value="<?=$getall_webinar[0]['link']?>" placeholder="Please enter the room link" class="w_300"/><br /><br />

               <label for="webinar_link" class="fleft w_150">Enter Description</label>

                      <textarea name="description" id="description" placeholder="Please enter the description" class="w_300"><?=$getall_webinar[0]['description']?></textarea><br /><br />

                       <label for="biz_sic" class="fleft w_150">Start Date Time</label>

                   <input type="text" id="ad_startdatetime" name="ad_startdatetime" class="w_300"  value="<?=$getall_webinar[0]['start_time']?>" placeholder="Specify Start Date/Time For Advertisement"/><br /><br />

                  

                  <label for="biz_sic" class="fleft w_150">Stop Date Time</label>

                      <input type="text" id="ad_stopdatetime" name="ad_stopdatetime" class="w_300" value="<?=$getall_webinar[0]['end_time']?>" placeholder="Specify End Date/Time For Advertisement"/><br /><br />    




                <label for="biz_sic" class="fleft w_150">Recording Links</label>

                      <input type="text" id="recordinglink" name="recordinglink" class="w_300" value="<?=$getall_webinar[0]['recording_link']?>" placeholder="Specify Recording "/><br /><br />




                <p>




                    <button class="m_left_150" onclick="update_webinar_link()">Save</button>

                </p>      

        </div>

        

    </div>

    

    

</div>



</div>



 

