 <style type="text/css">
 	.paid{
 		display: inline-block;
    width: 100%;
 	}
  .red{background-color: transparent;}
  .form-container {
    margin-top: 0;
}
input[type='password']{
  height: 42px !important;
}
.cus-form-table{
      background-size: contain;
      background-repeat: no-repeat;
}

 </style>

<script type="text/javascript">

 


/* Save New Category */

function save_other_referral(){
 
		var dataToUse = {

			"zoneid":$("#zoneid").val(),


    "hugegroup_referralid":$('#hugegroup_referralid').val(),

    "emailing_referralid":$('#emailing_referralid').val(),

    "usagroup_referralid":$('#usagroup_referralid').val()



 

		}; 

 

  PageMethod("<?=base_url('Zonedashboard/save_others_website_id')?>", "Processing...<br/>This may take a minute.", dataToUse, weblinkSuccess, null);

}



function weblinkSuccess(result){

	$.unblockUI();

	var message = result.Message;

	var title = result.Title;

	var txt = '';

	  $("#msg").html(txt).show();

	  $("#msg").show();

	  $("#webinar_link").val('');

	  $("#description").val('');

	  $('html,body').animate({scrollTop:0},"slow");

	  setTimeout(function(){$("#msg").hide('slow');},3000);

}

function email_verification(emailnotice_email){ //alert(1);
  var email_pattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if(emailnotice_email==''){
      $('#email_verify').hide();
      $('#email_verify').html('');
      return false;
    }
    if(emailnotice_email!='')
    {
      $('#email_verify').show();
      if(!email_pattern.test(emailnotice_email))
      {       
        $('#email_verify').html('"'+emailnotice_email+'" not follow email pattern of abcd@efg.com.').css({'color':'#f41525'});
        //$('#emailnotice_email').val('');
        return false;
      }
      else
      {
        var data={'check_email':emailnotice_email,'type':'10'};
        $.ajax({"type":"POST","url":"<?=base_url('dashboards/check_email')?>","async":false,'data':data,'success':function(result) {
          $('#email_verify').show();
          if(result=='0'){
            $('#email_verify').html('"'+emailnotice_email+'" is not available.').css({'color':'#f41525'});
            //$('#emailnotice_email').val('');
            $('#emailvalidation').val('0');
            /*$('#show_registration_button').hide();*/
          }else{
            $('#email_verify').html('"'+emailnotice_email+ '" is available.').css({'color':'#008040'});
            $('#emailvalidation').val('1');
            /*$('#show_registration_button').show();*/
          }
        }});
      }
    } 
}

function username_verification(username){
  var regex = new RegExp("^[a-zA-Z0-9.]*$"); 
  var data={'user_name': username,'type':'home'};
  if(regex.test(username) !== true){ 
    $('#username_verify').show();
    $('#username_verify').html('"'+username+'" must not contain special characters.').css({'color':'#f41525'});
    return false;
  }else if(username.length>=3 && username.length<=12){
  $.ajax({"type":"POST","url":"<?=base_url('dashboards/check_username')?>",'data':data,'async':false,'success':function(result) {
    $('#username_verify').show();
    if(result=='0'){
      $('#username_verify').html('"'+username+'" is not available.').css({'color':'#f41525'});
      $('#usernamevalidation').val('0');
    }else{
      $('#username_verify').html('"'+username+ '" is available.').css({'color':'#008040'});
      $('#usernamevalidation').val('1');
    }   
    }
  })
  }else{
    $('#username_verify').show();
    $('#username_verify').html('"'+username+'" must be between 3-12 characters.').css({'color':'#f41525'});
    return false;
  }
}


function ratingsignupForm(){
  var business_id=$('#businessid').val()
  var ratingfirstname=$('#ratingfirstname').val();
  var ratinglastname=$('#ratinglastname').val();
  var ratingupusername=$('#ratingupusername').val();
  var ratingupemail=$('#ratingupemail').val();
  var ratinguppassword=$('#ratinguppassword').val();
  var confirmratingpassword=$('#confirmratingpassword').val();  
  var login='3';
  
  if(ratinguppassword!='' && confirmratingpassword!='')
  {
    if(ratinguppassword!=confirmratingpassword)
    {
      alert('Password did not match,Please try again!');
      return false;
    }
    else{
       var data = {
        "login":login,
        "Username":ratingupusername,
        "new_password":ratinguppassword,
        "password_confirm":confirmratingpassword,
        "Email":ratingupemail,
        "Firstname":ratingfirstname,
        "Lastname":ratinglastname,
        "business_id":business_id
        };
    
      $.ajax({url:'<?=base_url('welcome/login/')?>',data:data,success:function(result) { 
      alert('You are successfully signed up,Please login to continue!');
  
      
      return false;

      
    }
  })
}
  }
}




</script>
 

<input type="hidden" name="zoneid" id="zoneid" value="<?=$zoneid?>" />

<input type="hidden" name="business_id" id= "business_id" value="<?= $common['businessid']?>">



<?php 

$condition_1 = $common['approval']['approval'] ;   

$condition_2 = $common['usergroup']->group_id ;	  

	
 

if(($condition_1==1 || $condition_1==2 || $condition_1==3) || ($condition_2==4)){

?>



<div class="content_container">

				 <?php if($common['from_zoneid']!='0'){ ?>

<div class="spacer"></div>

  <div class="businessname-heading">

      <div class="main main-large main-100">

          <div class="businessname-heading-main">

            <?php if($common['businessid']!='') {  //var_dump($common['approval_message']);exit;?> 

            <div style="float:left;"><font color="">Business Name : </font> <div class="oswald" style="font-size:26px; line-height:initial;">

      <?php } ?>  

             <?php if($common['realtorid']!='') {  //var_dump($common['approval_message']);exit;?> 

            Realtor : 

      <?php } ?>  

            

         <?php /*?>   <?php if($common['sub_header_name_from_zone']['id']!=''){ ?>

            Realtor : <?php echo urldecode($common['sub_header_name_from_zone']['name']); ?>

            <?php } ?>    <?php */?>

            <?php if($common['organizationid']!=''){//echo '<pre>';var_dump($common['zone'][0]['type']);exit;?> <?php /*if($common['zone'][0]['type'] == 2){ ?>High School Sports :<?php }else{ */?>Organization : <?php /*}*/ ?><?php } ?>  

      <?php

       echo urldecode($common['sub_header_name_from_zone']['name']);

       if($common['organizationid']!=''){

       ?> (<?php

        if($common['zone'][0]['type'] == 0){ ?>Others<?php }else if($common['zone'][0]['type'] == 1){ ?>Municipality<?php }else if($common['zone'][0]['type'] == 2){ ?>Schools<?php }else{ ?>High School Sports<?php } ?>)

            <?php }if($common['businessid']!='') { ?><?= ' '.$common['approval_message']?> <?php } ?>

          </div>

          </div>

              <a href="<?=base_url()?>Zonedashboard/zonedetail/<?=$common['from_zoneid']?>/0/1" class="fright" style="text-decoration:none">&#8592; Back to Zone Dashboard</a><br/>

                <?php 

        $x = $this->session->userdata('business_search_value');

        if($common['businessid']!='' && $x!= ''){ ?>

                <a href="<?=base_url()?>Zonedashboard/zonedetail/<?=$common['from_zoneid']?>" class="fright">&#8592; Back to Previous Search</a><br/>

                <?php } ?>
 

            <?php if($common['from_zoneid']!=0 && $common['businessid']!=''){ ?>

            <br>
 
 

         <?php 

          }?>

            </div>

        </div>

    </div>

<?php } 

if($common['where_from']=='zone'){?>

  <div class="spacer"></div>

    <div class="businessname-heading" style="overflow:hidden;">

      <div class="main main-large main-100">

          <div class="businessname-heading-main">

            <div class="center" style="width:100%">

             <font style="">Search All Businesses (Real Active Ads, Businesses Uploaded, Biz Opp Providers, Inactive Ads)</font> 

              <input type="text" id="global_bus_search" name="global_bus_search" class="text-input" placeholder="Exact business name or phone no. or id" style="" value="<?php echo $this->session->userdata('business_search_value') ?>" />

              <button class="btn-sm"  id="global_bus_search_btn" type="button" style="">Search</button>

              <?php /*?><span style="margin:-10px 20px 0 0; display:none" class="close"><button class="btn-sm global_search_close" type="button" style="padding:7px; width:115px; margin-top:7px;  margin-top: 10px;margin-left: -36px;">Clear Search</button></span><?php */?>

              <button class="btn-sm global_search_close hide_search_result" type="button" style="display:none">Clear Search</button>

              </div>

              <div id="no_bus_found" style="margin-left:15px;" class="fleft w_300"></div>

            </div>

        </div>

        <div id="view_global_bus_search_div" style="width:1130px; margin:10px auto 0; background-color:#d2e08f; display:none; overflow:hidden; padding:10px;">

            <div id="view_global_bus_search" class="fleft" style="width:1080px;"></div>

            <a style="margin:-10px 20px 0 0;" href="javascript:void(0)" class="close" onClick="$('#view_global_bus_search_div').slideToggle();"><img src="https://cdn.savingssites.com/close_pop.png" class="btn_close global_search_close" title="Close Window" alt="Close" ></a>

      </div>

    </div>



<?php } ?>

	<div class="container_tab_header">Add Reffer Users</div>

    <div id="msg"></div>
 

	<div id="container_tab_content" class="container_tab_content">

        <div id="tabs-2_y">

        	<div id="msg" style="display:none;margin-top:7px;"></div>

        <div class="form-group center-block-table cus-form-table">

         <form id="ratingsignupForm" class="" method="post" action="javascript:void(0);" enctype="multipart/form-data">
  
    <div class="body_part_inner noticeformarea"> <small>Required where indicated <span class="red">*</span></small> <br>

      <span id="error" style="font-weight:bold; color:#fff;display:block; text-align:center; display:none;"></span> <br>

      <div style="clear:both"></div>

      <div class="form-container">

      <p> <span class="label_left">

        <label>Referral Code: <h4><?php echo $referalcode; ?></h4></label><br/><br/>

         <input type="hidden" name="referraluser" value="<?php echo $referalcode; ?>">

        <input type="hidden" name="user_type" value="16">

        <label> User Name<span class="red">*</span></label><br>

        </span> <span class="input_right">

        <input name="username" id="emailnotice_username" type="text" onchange="username_verification($(this).val());" required="" class="form-control">


        </span>

        <input type="hidden" name="usernamevalidation" id="usernamevalidation" value="">

      

      </p><div style="clear:both;"></div>

      <span id="username_verify" style="font-weight:bold; color:#fff;display:block; text-align:center; display:none;"></span>
 
 

  </div>

      <div class="form-container">

      <p> <span class="label_left">

        <label>Email<span class="red">*</span>:</label>  <br>

        </span> <span class="input_right">

       
        <input name="emailnotice_email" id="emailnotice_email" onchange="email_verification($(this).val());" type="text" required="" class="form-control">

        <input type="hidden" name="emailvalidation" id="emailvalidation" value="">

        </span>

      

      </p><div style="clear:both;"></div>

      <span id="email_verify" style="font-weight:bold; color:#fff;display:block; text-align:center; display:none;"></span>

      <p></p>

  </div>

    

      <div class="form-container">

      <p> <span class="label_left">

        <label>Telephone:</label>  <br>

        </span> <span class="input_right">

        <input name="emailnotice_phone" id="emailnotice_phone" type="text" onblur="" class="form-control">

        </span> <span id="phone_verify" style="font-weight:bold; color:#F41525;display:block; text-align:center; display:none;"></span> <span id="phone_verify_success" style="font-weight:bold; color:#008040;display:block; text-align:center; display:none;"></span> 

       
      </p>
  </div>

 
      

      <div class="form-container">

             

                  <div class=" ">

                    <div class="">

                      <p>

                        <span class="label_left">

                          <label>

                            Cell Phone:

                          </label> <br>

                        </span>

                        <span class="input_right">

                          <input name="cell_phone" id="cell_phone" type="text" onblur="" class="form-control">

                        </span>

                        <span id="" style="font-weight:bold; color:#F41525;display:block; text-align:center; display:none;">

                        </span>

                        <span id="" style="font-weight:bold; color:#008040;display:block; text-align:center; display:none;">

                        </span>

                        <!--Added phone field on 28/5/14-->

                      </p>

                    </div>

                  </div>

                </div>

  <div class="form-container">

    <div class=" ">

      <div class="">

      <p> <span class="label_left">

        <label>Password<span class="red">*</span>:</label> <br>

        </span> <span class="input_right">

        <input name="password" id="emailnotice_password" type="password" onfocusout="checkPwd()" required="" class="form-control">

        <span class="alerttextmaroon_label" style="color:red"> </span> 

        </span> </p>

    </div>

    <div class="">

      <p> <span class="label_left">

        <label>Retype Password<span class="red">*</span>:</label> <br>

        </span> <span class="input_right">

        <input name="retype_password" id="retype_password" type="password" required="" class="form-control">

        </span> </p>

    </div>

</div>

</div>

<div class="form-container">

    <div class=" ">

      <div class="">

      <p><span class="label_left">

        <label>First Name<span class="red">*</span>:</label> <br>

        </span><span class="input_right">

        <input name="first_name" id="first_name" type="text" required="" class="form-control">

        </span></p>

    </div>

    <div class="">

      <p><span class="label_left">

        <label>Last Name<span class="red">*</span>:</label> <br>

        </span><span class="input_right">

        <input name="last_name" id="last_name" type="text" required="" class="form-control">

        </span></p>

    </div>
 

    </div>

    </div>

 
      

      <div id="globalDefaultSelectionBox" style="display: none;padding-top: 20px;">

        <div class="row">

          <div class="col-sm-12">

          <div class="form-container">

        

          <h3>SNAP Email Filters -- You Control Your Flow of Offers!</h3>

        

        <div class="snapMinmumPercentage">

          <div>

            <p style="margin-bottom: 5px;">Modify (SNAP) filters in the resident admin dashboard for all businesses; or go to Deals page query businesses, and just click the SNAP image for your desired Businesses! </p>

          </div>

        

        </div>

        <div style="clear: both"></div>

        <div class="sendType" style="padding-top: 20px;">
 

        </div>

      </div>

  </div>



  <div style="display: none;" class="col-sm-12">

  <div class="form-container">

    <div class="row">

          <div class="col-sm-12">

             <strong>Indicate below the days and times of day you're available to use the offer:</strong>

          </div>

          <div style="clear: both"></div>

          

          <div class="col-sm-12">

            <div class="row snaptimecolumn" style="margin-top: 26px;">

        <div class=" hidden-xs" style="height:40px;"></div>

        <div class="" style="height:40px;"><div class="any-time" style="margin-left: 61%; position: absolute; width: 100px; margin-top: -24px;"><input type="checkbox" name="snapStartTime[]" class="snapStartTimeRegistration" value="0" id="snapStartTimeRegistrationDefault" onchange="globalSnapAnyRegistratioan(this)">&nbsp;<span>Any time</span></div>am<br>                 

               </div>

                <div class="col-sm-3 col-xs-6 hidden-xs" style="height:40px;">pm</div>

                <div class="col-sm-3 col-xs-6 hidden-xs" style="height:40px;">pm</div>

              <div class="">

                
                    <input type="checkbox" name="snapWeekdays[]" class="snapWeekdays" value="1" onchange="countGlobalSnapWeekdays(this)" checked="checked">&nbsp;<span>Sunday</span><br>

                
                    <input type="checkbox" name="snapWeekdays[]" class="snapWeekdays" value="2" onchange="countGlobalSnapWeekdays(this)" checked="checked">&nbsp;<span>Monday</span><br>

                
                    <input type="checkbox" name="snapWeekdays[]" class="snapWeekdays" value="3" onchange="countGlobalSnapWeekdays(this)" checked="checked">&nbsp;<span>Tuesday</span><br>

                
                    <input type="checkbox" name="snapWeekdays[]" class="snapWeekdays" value="4" onchange="countGlobalSnapWeekdays(this)" checked="checked">&nbsp;<span>Wednesday</span><br>

                
                    <input type="checkbox" name="snapWeekdays[]" class="snapWeekdays" value="5" onchange="countGlobalSnapWeekdays(this)" checked="checked">&nbsp;<span>Thursday</span><br>

                
                    <input type="checkbox" name="snapWeekdays[]" class="snapWeekdays" value="6" onchange="countGlobalSnapWeekdays(this)" checked="checked">&nbsp;<span>Friday</span><br>

                
                    <input type="checkbox" name="snapWeekdays[]" class="snapWeekdays" value="7" onchange="countGlobalSnapWeekdays(this)" checked="checked">&nbsp;<span>Saturday</span><br>

                
              </div>

               

              
                    <div class=" ">

                  
                    <input type="checkbox" name="snapStartTime[]" value="1" class="globalSnapRegistration snapStartTimeRegistration">&nbsp;<span>06:00:00</span><br>

               
                    <input type="checkbox" name="snapStartTime[]" value="2" class="globalSnapRegistration snapStartTimeRegistration">&nbsp;<span>07:00:00</span><br>

               
                    <input type="checkbox" name="snapStartTime[]" value="3" class="globalSnapRegistration snapStartTimeRegistration">&nbsp;<span>08:00:00</span><br>

               
                    <input type="checkbox" name="snapStartTime[]" value="4" class="globalSnapRegistration snapStartTimeRegistration">&nbsp;<span>09:00:00</span><br>

               
                    <input type="checkbox" name="snapStartTime[]" value="5" class="globalSnapRegistration snapStartTimeRegistration">&nbsp;<span>10:00:00</span><br>

               
                    <input type="checkbox" name="snapStartTime[]" value="6" class="globalSnapRegistration snapStartTimeRegistration">&nbsp;<span>11:00:00</span><br>

               
                  </div>

                
                    <div class=" ">

                  
                    <input type="checkbox" name="snapStartTime[]" value="7" class="globalSnapRegistration snapStartTimeRegistration">&nbsp;<span>12:00:00</span><br>

               
                    <input type="checkbox" name="snapStartTime[]" value="8" class="globalSnapRegistration snapStartTimeRegistration">&nbsp;<span>01:00:00</span><br>

               
                    <input type="checkbox" name="snapStartTime[]" value="9" class="globalSnapRegistration snapStartTimeRegistration">&nbsp;<span>02:00:00</span><br>

               
                    <input type="checkbox" name="snapStartTime[]" value="10" class="globalSnapRegistration snapStartTimeRegistration">&nbsp;<span>03:00:00</span><br>

               
                    <input type="checkbox" name="snapStartTime[]" value="11" class="globalSnapRegistration snapStartTimeRegistration">&nbsp;<span>04:00:00</span><br>

               
                    <input type="checkbox" name="snapStartTime[]" value="12" class="globalSnapRegistration snapStartTimeRegistration">&nbsp;<span>05:00:00</span><br>

               
                  </div>

                
                    <div class=" ">

                  
                    <input type="checkbox" name="snapStartTime[]" value="13" class="globalSnapRegistration snapStartTimeRegistration">&nbsp;<span>06:00:00</span><br>

               
                    <input type="checkbox" name="snapStartTime[]" value="14" class="globalSnapRegistration snapStartTimeRegistration">&nbsp;<span>07:00:00</span><br>

               
                    <input type="checkbox" name="snapStartTime[]" value="15" class="globalSnapRegistration snapStartTimeRegistration">&nbsp;<span>08:00:00</span><br>

               
                    <input type="checkbox" name="snapStartTime[]" value="16" class="globalSnapRegistration snapStartTimeRegistration">&nbsp;<span>09:00:00</span><br>

               
                    <input type="checkbox" name="snapStartTime[]" value="17" class="globalSnapRegistration snapStartTimeRegistration">&nbsp;<span>10:00:00</span><br>

               
                    <input type="checkbox" name="snapStartTime[]" value="18" class="globalSnapRegistration snapStartTimeRegistration">&nbsp;<span>11:00:00</span><br>

               
                  </div>

                
           </div>

           <div class="col-sm-12" id="snapMessage"></div>

        </div>

      </div>

      </div>

      </div>

      </div>

      </div>

    </div>

    <!-- next section -->

    <input type="hidden" name="ad_id" value="">

    <input type="hidden" name="offer_type" value="">

    <input type="hidden" name="createdby_id" value="">

    <input type="hidden" name="zone_id" value="<?=$zoneid?>">

    <input type="hidden" name="type" value="">


    <div class="submitbox" style="padding-right: 20px;text-align: center;text-align: center;float:none;">

      <input type="submit" class="signup_button btn btn-default" value="Submit">

    </div>

  </form>

        </div>

        </div>

    	</div>

    </div>

</div>

 <?php }else if(($condition_1==-1 || $condition_1==-2 || $condition_1==-3) || $condition_2==5){ ?>

<div class="main_content_outer"> 

<div class="content_container">

				 <?php if($common['from_zoneid']!='0'){?>

<div class="spacer"></div>

  <div class="businessname-heading">

      <div class="main main-large main-100">

          <div class="businessname-heading-main">

            <?php if($common['businessid']!='') {    ?> 

            <div style="float:left;"><font color="">Business Name : </font> <div class="oswald" style="font-size:26px; line-height:initial;">

      <?php } ?>  

             <?php if($common['realtorid']!='') {   ?> 

            Realtor : 

      <?php } ?>  

            
      <?php

       echo urldecode($common['sub_header_name_from_zone']['name']);

       if($common['organizationid']!=''){

       ?> (<?php

        if($common['zone'][0]['type'] == 0){ ?>Others<?php }else if($common['zone'][0]['type'] == 1){ ?>Municipality<?php }else if($common['zone'][0]['type'] == 2){ ?>Schools<?php }else{ ?>High School Sports<?php } ?>)

            <?php }if($common['businessid']!='') { ?><?= ' '.$common['approval_message']?> <?php } ?>

          </div>

          </div>

              <a href="<?=base_url()?>Zonedashboard/zonedetail/<?=$common['from_zoneid']?>/0/1" class="fright" style="text-decoration:none">&#8592; Back to Zone Dashboard</a><br/>

                <?php 

        $x = $this->session->userdata('business_search_value');

        if($common['businessid']!='' && $x!= ''){ ?>

                <a href="<?=base_url()?>Zonedashboard/zonedetail/<?=$common['from_zoneid']?>" class="fright">&#8592; Back to Previous Search</a><br/>

                <?php } ?>
 

            <?php if($common['from_zoneid']!=0 && $common['businessid']!=''){?>

            <br>

            <select class="fright" style="margin-right: 36px; margin-top: -12px;  height: 26px;" id="goto_different_ads">

            <option value="1">Business Display Filter</option>

            <option value="2"><a href="<?=base_url()?>Zonedashboard/all_business/<?=$common['zoneid']?>" class="fright" style="text-decoration:none">All Business</a> </option>

            <option value="3">Active Real Ads</option>

            <option value="4">Business Coming Soon</option>

            <option value="5">Inactive Ads</option>

            </select>

            <button class="fright" id="different_ads" style="margin-right: -256px; margin-top: -12px;  height: 26px;  width: 38px; background: #7b498f; border: none;"><p style="margin-top: -4px; margin-left: -6px;">Go</p></button>

         

         <?php 

          }?>

            </div>

        </div>

    </div>

<?php } 

if($common['where_from']=='zone'){?>

  <div class="spacer"></div>

    <div class="businessname-heading" style="overflow:hidden;">

      <div class="main main-large main-100">

          <div class="businessname-heading-main">

            <div class="center" style="width:100%">

             <font style="">Search All Businesses (Real Active Ads, Businesses Uploaded, Biz Opp Providers, Inactive Ads)</font> 

            <input type="text" id="global_bus_search" name="global_bus_search" class="text-input" placeholder="Exact business name or phone no. or id" style="" value="<?php echo $this->session->userdata('business_search_value') ?>" />

            <button class="btn-sm"  id="global_bus_search_btn" type="button" style="">Search</button>

            <?php /*?><span style="margin:-10px 20px 0 0; display:none" class="close"><button class="btn-sm global_search_close" type="button" style="padding:7px; width:115px; margin-top:7px;  margin-top: 10px;margin-left: -36px;">Clear Search</button></span><?php */?>

            <button class="btn-sm global_search_close hide_search_result" type="button" style="display:none">Clear Search</button>

            </div>

      <div id="no_bus_found" style="margin-left:15px;" class="fleft w_300"></div>

            </div>

        </div>

        <div id="view_global_bus_search_div" style="width:1130px; margin:10px auto 0; background-color:#d2e08f; display:none; overflow:hidden; padding:10px;">

          <div id="view_global_bus_search" class="fleft" style="width:1080px;"></div>

            <a style="margin:-10px 20px 0 0;" href="javascript:void(0)" class="close" onClick="$('#view_global_bus_search_div').slideToggle();"><img src="https://cdn.savingssites.com/close_pop.png" class="btn_close global_search_close" title="Close Window" alt="Close" ></a>

      </div>

    </div>



<?php } ?>

	<div class="container_tab_header">Enter Webinar Information</div>

    <div style="font-size:20px; line-height:25px; color:red;">Your business is currently inactive. Please contact your Directory Manager for more details.

        	</div>

     </div>

  </div>

     <?php } ?>

 


 <script type="text/javascript">


  // Add validation to password  

  checkPwd = function () {

    var str = document.getElementById('emailnotice_password').value;

    if (str.length < 6) {

        // alert("too_short");

        jQuery('.alerttextmaroon_label').text('Password is too short');

       $("#retype_password").attr("disabled", "disabled"); 

        return ("too_short");

    } else if (str.length > 20) {

        // alert("too_long");

        jQuery('.alerttextmaroon_label').text('Password is too long');

        $("#retype_password").attr("disabled", "disabled"); 

        return ("too_long");

    } else if (str.search(/\d/) == -1) {

        // alert("no_num");

        jQuery('.alerttextmaroon_label').text('Password contains no num');

        $("#retype_password").attr("disabled", "disabled"); 

        return ("no_num");

    } else if (str.search(/[a-zA-Z]/) == -1) {

         jQuery('.alerttextmaroon_label').text('Password contains no letter');

         $("#retype_password").attr("disabled", "disabled"); 



        return ("no_letter");

    } else if (str.search(/[^a-zA-Z0-9\!\@\#\$\%\^\&\*\(\)\_\+\.\,\;\:]/) != -1) {

        jQuery('.alerttextmaroon_label').text('Password conatin bad character');

        $("#retype_password").attr("disabled", "disabled"); 

        return ("bad_char");

    }

    jQuery('.alerttextmaroon_label').text(' ');

    $("#retype_password").removeAttr("disabled"); 

    // return ("ok");

}


$("form#ratingsignupForm" ).on( "submit", function( event ) {
  console.log("dvfdfdfd");
  email_verification($('#emailnotice_email').val());
  //validating username
  username_verification($('#emailnotice_username').val());  

  var error='';
  var error_checkboxmsg = '';
  if($('#usernamevalidation').val()==0 || $('#usernamevalidation').val()==false)
  {
    if($('#usernamevalidation').val()==false)
      error+=""+$('#emailnotice_username').val()+" must be between 3-12 characters.<br/>";
    else  
      error+=""+$('#emailnotice_username').val()+" username is not available.<br/>";
  }
  else
  {
    error+='';
  }
  if($('#emailvalidation').val()==0 || $('#emailvalidation').val()==false)
  {
    if($('#emailvalidation').val()==false)    //return false;
      error+=""+$('#emailnotice_email').val()+"  not follow email pattern of abcd@efg.com..<br/>";
    else
      error+=""+$('#emailnotice_username').val()+" email is not available.<br/>"; 
  }
  else
  {
    error+='';
  }
  

  
  if($('#emailnotice_password').val()!=$('#retype_password').val())
  {
    error+='Password did not match.<br/>';
    
  }
  else
  {
    error+='';
  } 
  
    
      if($("input[name=resident_accept]:checked").val() == 'accepted') {
        if($("#age_residentuser option:selected").val() == '') {
          error+='Please select age value.<br/>';
          $( "#age_residentuser" ).addClass( "error_border" );
        } else {
          $( "#age_residentuser" ).removeClass( "error_border" );
          error+='';
        } 
        if($("#resident_gender option:selected").val() == '') {
          error+='Please select renter info.<br/>';
          $( "#resident_gender" ).addClass( "error_border" );
        } else {
          $( "#resident_gender" ).removeClass( "error_border" );
          error+='';
        }
        if($("#resident_info option:selected").val() == '') {
          error+='Please select renter info.<br/>';
          $( "#resident_info" ).addClass( "error_border" );
        } else {
          $( "#resident_info" ).removeClass( "error_border" );
          error+='';
        }
       
    } else {
      error+='';
    }
  
  
  if(error_checkboxmsg!=''){
    $('#error_checkboxmsg').show();
    $('#error_checkboxmsg').html(error_checkboxmsg).css({'color':'#f41525'});
    return false;
  }else{
    $('#error_checkboxmsg').hide();
  }
  if($('input[name="globalSnapStatus"]:checked').val() == 1) {
    if($('input.snapWeekdays:checked').length == 0) {
      error+="Please select atleast one week days";
      $("#snapMessage").html('<p style="color:red;font-size:14px" class="text-center">Please select atleast on snap start time</p>');
    }
    if($('input.snapStartTimeRegistration:checked').length == 0){
      error+="Please select atleast one snap start time";
      $("#snapMessage").html('<p style="color:red;font-size:14px;" class="text-center">Please select atleast on snap start time</p>');
    } 
   }
  if(error!='')
  {
    $('#error').show();
    $('#error').html(error).css({'color':'#f41525'});
    return false;
  }
  else
  {
    //return false;   
    $('#error').hide();
    event.preventDefault();
    var serializedata=$('form#ratingsignupForm').serializeArray();  
    
    
    $.ajax({
          'type'    :'POST',
          'url'   :"<?=base_url()?>/emailnotice/referalnoticeinsertdata",
          'data'    :serializedata,
      'dataType': "json",
          'beforeSend':function(){ },            
          'success' : function(result) { 
              if(result !=''){
          
                 var obj=result.Tag;
          var userid=obj.user_id;
          var createdby_id=obj.createdby_id;
          var zoneid=obj.zone_id;
          var type=obj.type;
          var login_type=obj.offer_type;
          var rating_val=obj.offer_type;
          $('#loginsignup').hide();
          $('#loginsignupsnap').hide();
        //  $('#emailnoticesignupform').hide();
        $("#regsucess").addClass( "show" );
        $("#regsucess").css("display","block");
        $("#emailnoticesignupform .close").click()
          //$('.neigbour-sucess').html("<h4 style='text-align:center; color:green'>Registration sucessfull</h4>");
          
          //setInterval(function(){ login_success_action(userid,createdby_id,zoneid,type,login_type,"signup",rating_val); }, 2000); 
          
          //window.location.reload();
              }
          }
      });
  }
});



$(document).ready(function () {  

  $('#zone_data_other_accordian').click();

  $('#zone_data_other_accordian').next().slideDown();

  $('#zone_data_other_accordian').addClass('active');

  $("#referral").addClass('active');

 
});








</script>