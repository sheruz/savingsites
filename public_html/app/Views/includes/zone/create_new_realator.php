

<div class="main_content_outer"> 

  

<div class="content_container">

<?php if($common['from_zoneid']!='0'){?>

<div class="spacer"></div>

  <div class="businessname-heading">

      <div class="main main-large main-100">

          <div class="businessname-heading-main">

            <?php if($common['businessid']!='') {  //var_dump($common['approval_message']);exit;?> 

            <font color="#333333">Business Name : </font> 

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

            <?php }if($common['businessid']!='') { ?><?=' '.$common['approval_message']?> <?php } ?>

              <a href="<?=base_url()?>Zonedashboard/zonedetail/<?=$common['from_zoneid']?>/0/1" class="fright" style="text-decoration:none">&#8592; Back to Zone Dashboard</a><br/>

                <?php 

        $x = $this->session->userdata('business_search_value');

        if($common['businessid']!='' && $x!= ''){ ?>

                <a href="<?=base_url()?>Zonedashboard/zonedetail/<?=$common['from_zoneid']?>" class="fright">&#8592; Back to Previous Search</a><br/>

                <?php } ?>

      <?php /*?><?php if($common['view_next_previous'] == 1){ ?>

                <a href="javascript:void(0);" id="previous_ad_change_category_for_business" class="fleft" data-businessid="<?=$common['businessid']?>" data-zoneid="<?=$common['from_zoneid']?>">&#8592; Go To previous Business To Assign Category</a>

                <a href="javascript:void(0);" id="next_ad_change_category_for_business" class="fright" data-businessid="<?=$common['businessid']?>" data-zoneid="<?=$common['from_zoneid']?>">Go To Next Business To Assign Category &#8594;</a>

            <?php } ?> <?php */?>  

            <?php if($common['from_zoneid']!=0 && $common['businessid']!=''){?>

            <br>

            <select class="fright" style="margin-right: 54px; margin-top: -12px;  height: 26px;" id="goto_different_ads">

            <option value="1">Business Display Filter</option>

            <option value="2"><a href="<?=base_url()?>Zonedashboard/all_business/<?=$common['zoneid']?>" class="fright" style="text-decoration:none">All Business</a> </option>

            <option value="3">Active Real Ads</option>

            <option value="4">Business Coming Soon</option>

            <option value="5">Inactive Ads</option>

            </select>

            <button class="fright" id="different_ads" style="margin-right: -210px; margin-top: -12px;  height: 26px;  width: 38px;"><p style="  margin-top: -2px; margin-left: -6px;">Go</p></button>

         

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

            <a style="margin:-10px 20px 0 0;" href="javascript:void(0)" class="close" onClick="$('#view_global_bus_search_div').slideToggle();"><img src="<?=base_url('assets/images/close_pop.png') ?>" class="btn_close global_search_close" title="Close Window" alt="Close" ></a>

      </div>

    </div>



<?php } ?>	

	<div class="container_tab_header">Create New Home Sold Sponsor</div>

	<div id="container_tab_content" class="container_tab_content">

       

       <div id="tabs-1">

            <div class="form-group">

              

              <div id="msg" style="display:none;margin-top:7px;"></div>

              <div id="realtor">

             <!-- <input type="hidden" id="organization_id" name="organization_id" value="-1"/>

              <input type="hidden" id="organization_zone" name="organization_zone" value="<?=$zoneid;?>"/>-->

              

              <input type="hidden" id="realtor_uid" name="realtor_uid" value="<?=$realtor['0']['id'] ?>"/>

               <input type="hidden" id="realtor_id" name="realtor_id" value="-1"/>

              <input type="hidden" id="realtor_zone" name="realtor_zone" value="<?=$zoneid;?>"/>

              <div class="container_tab_header form-group header-default-message" style="/*background-color:#d2e08f; color:#222;margin-top:10px; margin-bottom:0px;*/">

              <p> - The username will get generated automatically based on the first 8 characters of the realtor name followed by 6 random numbers.<br>

                  - Clicking on the 'Generate Password' will automatically generate a random alpha-numeric password. <br>

                  - Realtor Username and Zone Username should not be same. </p>

              </div>

              

               

              

              <div id="show1" class="center-block-table">

              <span style="color:red"> (*)These fields are required </span>

              

              <p class="form-group-row">

                <label for="realtor_name" class="fleft w_200">Realtor Name<span style="color:red">*</span></label>

                <input type="text" style="width:300px;" id="realtor_name" name="realtor_name" maxlength="30" onblur="create_random_username(this)"/>

                (Maximum 30 characters)

              </p>

              

              <p class="form-group-row">

                <label for="realtor_email" class="fleft w_200">Realtor Email Address</label>

                <input style="width:300px;" type="text" id="realtor_email" name="realtor_email" />

                <div id="emailspan" style="margin-left:200px;"></div>

              </p>

              

              <p class="form-group-row">

                <label for="realtor_username" class="fleft w_200">Realtor Username<span style="color:red">*</span></label>

                <input style="width:300px;" type="text" id="realtor_username" name="realtor_username" onblur="check_realtor_username();"/>

              </p>

              

              <div class="spacer"></div>

              <span id="error_realtor_uname" style="margin:0 0 8px 160px; background:#F00; font-weight:bold; color:#fff; padding:3px; width:380px; display:none; text-align:center"></span>

               <span id="error_realtor_uname1" style="margin:0 0 8px 160px; background:#F00; font-weight:bold; color:#fff; padding:3px; width:380px; display:none; text-align:center"></span>

              <div class="spacer"></div>

              <p class="form-group-row">

                <label for="realtor_password" class="fleft w_200">Realtor Password<span style="color:red">*</span></label>

                <input type="text" id="realtor_password" name="realtor_password"/>

                <button onclick="create_generate_password()">Generate Password</button>

              </p>

              <span id="error_new_password" style=" margin-left:200px; background:#F00; font-weight:bold; color:#fff; padding:3px; width:450px; display:block; text-align:center; display:none;"></span>

               <div class="spacer" style="  height: 10px;"></div>

              <span style="margin-left:200px; margin-top:10px">

             <button onclick="SaveRealtor()" name="create_realtor">Save Realtor</button>

              <!--<button onclick="HideAnnouncementEditor_org()">Back To Organization</button>-->

              </span>

                    

                </div>

                <div id="message" style="display:none" >

                <h2 style="color:#090" align="center">Realtor  already exist in the system. Either delete and create new or update the existing.</h2>

                </div>

                <div id="message1" style="display:none" >

                <h2 style="color:#090">Realtor created successfully. Realtor  already exist in the system. Either delete and create new or update the existing.</h2>

                </div>

              <!--</div>-->

              </div>

              

          </div>

    </div>

    

    

</div>



</div>





<script type="text/javascript">

$(document).ready(function () { //alert($('#realtor_uid').val());

	$('#adv_tools').click();

	$('#adv_tools').next().slideDown();

	$('#zonerealtor').click();

	$('#zonerealtor').next().slideDown();

	$('#create_new_realator').addClass('active');

   

});

$(function(){

	if($('#realtor_uid').val() != '' ){

		$('#show1').hide();

		$('#message').show();

	}

});

</script>



<script>

var default_zone = '<?=$zoneid;?>';

var temp_zone_id = '<?=$zoneid;?>';



function  check_authneticate(){ 

	var is_authenticated=0;

	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ //alert('success');

		is_authenticated=data;

	}});	

	return is_authenticated;

}



// + Creating random username

function create_random_username(val1){	

	var org_name1=$(val1).val();

	var org_name=org_name1.replace(/\s+/, "") ;

	var org_name_length=org_name.length;

	var org_username_1=org_name.substring(0,8);				

	var rand_org = Math.floor((Math.random()*1000000)+1);

	var org_username=org_username_1+rand_org;

	$("#realtor_username").val(org_username);

}

// - Creating random username



// + checking for org name

function check_realtor_username(){

	

	

	

	var org_username=$("#realtor_username").val();

	var org_id=$("#realtor_id").val();

	var data = { "zoneid": default_zone , "org_username": org_username , "org_id": org_id};

	PageMethod("<?=base_url('Zonedashboard/check_org_username')?>", "Verify the realtor user name <br/>This may take a few minutes", data, showorgusername, null);

}



function showorgusername(result){

	$.unblockUI();

	 var regex = new RegExp("^[a-zA-Z0-9.]*$"); 

		var userame=$('#realtor_username').val(); 

		if(regex.test(userame) !== true){

			$('#error_realtor_uname1').html('Space not allowed');

			$('#error_realtor_uname1').show();

			$('#realtor_username').val('');	

		}else{

			$('#error_realtor_uname1').hide();

		}

	if(result.Tag==''){

		$('#error_realtor_uname').html('This username is reserved for zone\'s username. Please try with another username.' );

		$('#error_realtor_uname').show();

		$('#success_realtor_uname').hide();

		$('#realtor_username').val('');	

	}else{

		$('#error_realtor_uname').hide();

	}

}



// - checking for org name



// + random generate password

function create_generate_password(){

	PageMethod("<?=base_url('Zonedashboard/create_generate_password_org')?>", "Creating The Password...<br/>This may take a few minutes", null, showPasswordOrg, null);

}

function showPasswordOrg(result){

	$.unblockUI();

	if(result.Tag!=''){				

		$("#realtor_password").val(result.Tag);

	}

}

// - random generate password



// + Create New Realtor Part



function SaveRealtor(){

	var authenticate=check_authneticate();

	if(authenticate=='0'){

		var zone_id = <?=$zoneid?>;			 

		alert('You are currently logged out. Please log in to continue.');

		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

	}else if(authenticate==1){

		check_realtor_username_save();

	 }

}



function check_realtor_username_save(){

	var realtor_username=$("#realtor_username").val();

	var realtor_id=$("#realtor_id").val();

	var data = { "zoneid": default_zone , "org_username": realtor_username , "org_id": realtor_id};

	PageMethod("<?=base_url('Zonedashboard/check_org_username')?>", "", data, showrealtorusername_save, null);

}



function showrealtorusername_save(result){

	$.unblockUI();

	if(result.Tag==''){

		$('#error_realtor_uname').html('This username is reserved for zone\'s username. Please try with another username.' );

		$('#error_realtor_uname').show();

		$('#success_realtor_uname').hide();

		$('#realtor_username').val('');		

	}else{

		$('#error_realtor_uname').hide();

		if($("#realtor_name").val()==''){

			alert('Please Provide Realtor Name');

			return false;

		/*}else if($("#realtor_email").val()==''){

			alert('Please Provide Realtor Email');

			return false;*/

		}else if($("#realtor_username").val()==''){

			alert('Please Provide Realtor User Name');

			return false;

		}else if($("#realtor_password").val()=='' && $("#realtor_id").val()==-1){

			alert('Please Provide Realtor Password');

			return false;

		}

		var org_type=$("input[name=organization_type]:Checked").val();

		var org_announcement_posted=$("input[name=announcement_posted]:Checked").val();

		var dataToUse = {

			"id":$("#realtor_id").val(),

			"org_name":$("#realtor_name").val(),

			"org_email":$("#realtor_email").val(),

			"org_username":$("#realtor_username").val(),

			"org_password":$("#realtor_password").val(),		

			"zone_id": $("#realtor_zone").val(),

			"realtor_uid":$("#realtor_uid").val()

		};

		PageMethod("<?=base_url('Zonedashboard/SaveRealtor')?>", "Saving New Realtor<br/>This may take a minute.", dataToUse, RealtorSaveSuccessful, null);

	}

}

function RealtorSaveSuccessful(result) {//alert(JSON.stringify(result)); return false;

	$.unblockUI();

	/*var message = result.Message;

	var title = result.Title;

	var txt = '';

	    if(title==2){

			 txt = '<h4 style="color:#090">Realtor created successfully.</h4>' ;

		}else{

			alert('Already exit in realtor');

		}

		$("#msg").html(txt).show();

		$("#msg").show();*/

	$("#realtor_name").val("");

	$("#realtor_email").val(""); 

	$("#realtor_username").val("");

	$("#realtor_password").val("");

	var zoneid= $("#realtor_zone").val();

	$('html,body').animate({scrollTop:0},"slow");

	//$("#msg").html('<h4 style="color:#090">Realtor created successfully</h4>').show();

	 setTimeout(function(){$("#msg").hide('slow');},3000);

	/* $("#message1").show();

	 $("#show1").hide();*/

	 window.location.href = '<?=base_url('Zonedashboard/view_new_realtor')?>' + '/'+ zoneid;

}





// - Create New Organization Part



/* Upload CSV Files*/

function upload_csv_file(){ 

	

	var data = { "zoneid": default_zone, 'uploaded_file_name' : $('#docs_pdf').val()};

	PageMethod("<?=base_url('Zonedashboard/anish')?>", "", data, null, null);

}

//+ valid email part

$("#realtor_email").blur(function(){

  // var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;  
  var emailReg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

  var emailaddress = $("#realtor_email").val();

	 if(!emailReg.test(emailaddress)) {

		$("#emailspan").html('<font color="#cc0000">Please enter valid Email address</font>'); 

		$('#realtor_email').focus();

		$("button[name='create_realtor']").attr('disabled','disabled'); 

	 }else{

		$("#emailspan").html('<font color="#cc0000"></font>'); 

		$("button[name='create_realtor']").removeAttr('disabled');

       }

});



$(document).on('blur','#realtor_password',function(){

	var new_password = $(this).val();

	 var regex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%#&])[A-Za-z\d$@$!%#&]{10,}$/; 

	if(new_password.length < 10 || new_password.length > 18){

		$('#error_new_password').html(" Password should be between 10 to 18 characters");

			$('#error_new_password').show();

			$('#realtor_password').focus();

			$("button[name='create_realtor']").attr('disabled','disabled');

			return false;

	}else if(!regex.test(new_password)){ 

		$('#error_new_password').html(" Password should be combination of letters, numbers and special characters (!, @, #, $, %, &)");

			$('#error_new_password').show();

			$('#realtor_password').focus();

			$("button[name='create_realtor']").attr('disabled','disabled');

			return false;

		}else{  

			$('#error_new_password').hide();

			$("button[name='create_realtor']").removeAttr('disabled');

		}

});



</script>