

<input type="hidden" name="orgzoneid" id="orgzoneid" value="<?=$fromzoneid;?>" />
<input type="hidden" name="org_id" id="org_id" value="<?=$org_id;?>" />

<div class="main_content_outer"> 

  

<div class="content_container form-group calender_history_container">


	      <div class="top-title">
        <h2>Email To Organization Members</h2>
         <hr class="center-diamond">
      </div>

	<?php if($common['from_zoneid']!='0'){?>



	<?php }?>

	<div id="container_tab_content" class="container_tab_content">

    	<?php if(!empty($calendarhistorylist)){?>

       <div id="bulk_email" style="margin-top: 5px;">

    	<table align="center" class="pretty" width="950px" cellpadding="0" cellspacing="0">

	                <thead>

	                   <tr>

	                   		<th width="400px">Organization Members Name</th> <!--First Name Last Name--->

							<th width="200px">Email</th>	

                            <th width="200px">Category</th>						

                            <!--<th width="80px">Action <input type="checkbox" onclick="return select_all(this);" name="article_news" id="article_news" value="all"  /></th>-->

	                   </tr>

	                </thead>

	                <tbody>

	                    <? foreach ($calendarhistorylist as $organization_list){?>

	                    <tr>

                        	<td>

								<?=$organization_list['name']?>								

							</td>

                            <td><?=$organization_list['email']?></td>

                            <td><?=$organization_list['category']?></td>

	                    	<?php /*?><td>

								<input type="checkbox" class="zone_owner_check" name="zone_owner[<?=$organization_list['id']?>]" id="zone_owner_<?=$organization_list['id']?>" value="<?=$organization_list['id']?>" />

							</td><?php */?>

					</tr>

						<? } ?>

	            	</tbody>

	            </table>

               </div>

               <!-- <div id="send_mail_text" class="for-tex-container" style="float:right;"><a class="text-default" href="javascript:void(0);" onclick="send_all_business_bulk_new();return false;">Send Mail to all</a></div>-->

    <?php }else{?>

    	<div class="container_tab_header" style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:10px;">No Members Found.</div>

   	<?php }?>

   

   	     <div id="body_email" style="display:none;">

          <input type="hidden" id="eids" name="eids" value=""/>

          <p class="form-group-row">

            <label for="email_subject" class="fleft w_200">Subject</label>   <!--Add this for new design class="fleft w_200" and remove the style="width:150px; float:left; padding-right:10px;"  --> 

            <input type="text" id="email_subject" name="email_subject" style="width:425px;"/> <!--Add this class class="w_536" when you open the Ck editor on line 50-->

          </p>

          

          <p class="form-group-row">

            <!--<label for="text_for_mail" style="width:150px; float:left; display:block; padding-right:10px;">Text Message</label>-->

           <label for="city" class="fleft w_200">Text Message</label><!--Add this for new design class="fleft w_200" and remove the style="width:150px; float:left; display:block; padding-right:10px;"-->

           	<!--<span class="fleft dis_block">-->  <!--Open this when needed to give the Ck Editor-->

            	<textarea id="text_for_mail" name="text_for_mail" rows="10" cols="45"></textarea> <!--Remove the style="width: 425px; height: 150px" when needed to give the Ck Editor -->

            	<?php //echo display_ckeditor($ckeditor_sendbulkemail);?>

            <!--</span>-->

          </p>

          

           <div class="spacer"></div>

          <p class="form-group-row">

          	<button class="sendmail" onclick="sendallemail();" style="margin-left:160px;">Send Mail</button> <!--Add this m_left_200 when required-->

          	<button class="back" onclick="email_back();" style="margin-left:10px;">Back</button>

          </p>

        </div>

   

</div>

</div>



<script type="text/javascript">

// /*$(document).ready(function () { 

// 	$('#organization_email_accordian').click();

// 	$('#organization_email_accordian').addClass('active');

// 	//$('.showbulkemail').click();

// });

// */

// $(document).ready(function () { 

// 	$('#organization_data_accordian').click();

// 	$('#organization_data_accordian').next().slideDown();

// 	$('#organization_event_accordian').click();

// 	$('#organization_event_accordian').next().slideDown();

// 	$('#organization_emailhistory').addClass('active');

// });















// // + check_authneticate

// function  check_authneticate(){ //alert(1);

// 	var is_authenticated=0;

// 	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ //alert('success');

// 		is_authenticated=data;

// 	}});	

// 	return is_authenticated;

// }    

// // - check_authneticate



// //function bulk_zone_business_allbusiness(){ 

// //	if($('#bulk_email_zone').val()==2 ){

// //		$('#bulk_email_type').hide();

// //	}else{

// //		$('#bulk_email_type').show();

// //	}

// //}





// function select_all(ele)

// { 

// 	checkboxes = document.getElementsByTagName("input");//get main check box

// 	if(ele.checked==true)//check main check box is checked or non checked

// 	{

// 		state = true;//set status

// 	}else{

// 		state = false;//set status

// 	}

// 	for (i=0; i<checkboxes.length ; i++)//chck all other checkbox and set their status

// 	{

// 	  if (checkboxes[i].type == "checkbox") 

// 	  {

// 		checkboxes[i].checked=state;

// 	  }

// 	}

// }





// function send_email()

// {

//     var dataToUse = {

// 	    "zone":default_zone,

// 		"subscriber":$("#subscriber").val(),

// 		"template":$("#template").val(),

// 		"template_subject":$("#template_subject").val(),

// 		"template_content":CKEDITOR.instances.template_content.getData()

//     };



// 	    $.post("<?=base_url('dashboards/send_email_bulk')?>", dataToUse,

// 				function(data) {

					

// 					if(CKEDITOR.instances['template_content'])

// 				    {

// 				    	CKEDITOR.instances['template_content'].destroy();

// 				    }

// 				    if(CKEDITOR.instances['addtemplate_content'])

// 				    {

// 				    	CKEDITOR.instances['addtemplate_content'].destroy();

// 				    }

// 				    $("#bulk_email").html(data);

// 		});

// }

/* Bulk email portion end */



// email part start partha 18.01.2013

// function send_all_business_bulk_new(){ 

// 	var authenticate=check_authneticate();

// 	if(authenticate=='0'){

// 		var zone_id = <?=$common['zoneid']?>;			 

// 		alert('You are currently logged out. Please log in to continue.');

// 		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

// 	}else if(authenticate==1){

// 		var id= Array();

// 		$('.zone_owner_check').each(function (){

// 			if($(this).is(':checked')){

// 				id.push($(this).val());

// 			}

// 		});

	

// 		var ids=id.join(',');

// 		if(ids==''){

// 			alert('Please select at least one organization to send a mail.');

// 			return false;

// 		}

// 		$('#eids').val(ids);

// 		$('#bulk_email').hide();

// 		$('#body_email').show();

// 		$('#send_mail_text').hide();

// 	 }

// }

// function email_back(){

// 	$('.zone_owner_check').each(function (){

// 		if($(this).is(':checked')){

// 			$(this).attr('checked', false);

// 		}

// 	});

// 	$("#email_subject").val('');

//     $("#text_message_email").val('');

// 	$('#bulk_email').show();

// 	$('#body_email').hide();

// 	$('#send_mail_text').show();

// }

// function sendallemail(){ 

// 	var authenticate=check_authneticate();

// 	if(authenticate=='0'){

// 		var zone_id = <?=$common['zoneid']?>;			 

// 		alert('You are currently logged out. Please log in to continue.');

// 		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

// 	}else if(authenticate==1){ 

// 		if($("#email_subject").val()==''){

// 			alert('Please give subject');

// 			return false;

// 		}

// 		if($("#text_message_email").val()==''){

// 			alert('Please give message');

// 			return false;

// 		}

// 			var dataToUse = {

// 				"uid":$("#eids").val(),

// 				"subject":$("#email_subject").val(),

// 				"message": $("#text_message_email").val()

// 			};

// 			PageMethod("<?=base_url('organizationdashboard/send_mail_to_org_members')?>", "Sending email<br/>This may take a minute.", dataToUse, emailSendSuccessful, null);

// 	 }

//     }

// 	function emailSendSuccessful(result) {

//         $.unblockUI();

// 		$('.zone_owner_check').each(function (){

// 			if($(this).is(':checked')){

// 				$(this).attr('checked', false);

// 			}

// 		});

// 		$("#email_subject").val('');

//         $("#text_message_email").val('');

// 		$('#bulk_email').show();

// 		$('#body_email').hide();

// 	}

</script>





