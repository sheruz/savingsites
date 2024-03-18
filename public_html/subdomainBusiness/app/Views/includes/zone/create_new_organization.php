

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

            <a style="margin:-10px 20px 0 0;" href="javascript:void(0)" class="close" onClick="$('#view_global_bus_search_div').slideToggle();"><img src="https://cdn.savingssites.com/close_pop.png" class="btn_close global_search_close" title="Close Window" alt="Close" ></a>

      </div>

    </div>



<?php } ?>

	<div class="container_tab_header">Create New Organization</div>

	<div id="container_tab_content" class="container_tab_content bv_bread_tab">

       <!--<ul>

        <li><a href="#tabs-1" id="tabs-title_1" onclick="">Manually Created Organization</a></li>

        <li><a href="#tabs-2" id="tabs-title_2" onclick="">CSV Uploaded Organization</a></li>        

      </ul>-->

       

       <div id="tabs-1">

        

          <!--<div class="container_tab_header header-default-message"  style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:0px;">-->

          <div id="msg" style="display:none;margin-top:7px;"></div>

          <div id="organization" class="new_org_msg">

          <input type="hidden" id="organization_id" name="organization_id" value="-1"/>

          <input type="hidden" id="organization_zone" name="organization_zone" value="<?=$zoneid;?>"/>

          <div class="container_tab_header form-group header-default-message" style="/*background-color:#d2e08f; color:#222;margin-top:10px; margin-bottom:12px;*/">

          <p> - The username will get generated automatically based on the first 8 characters of the organization name followed by 6 random numbers.<br>

           - Clicking on the 'Generate Password' will automatically generate a random alpha-numeric password.<br>

           - Organization Username and Zone Username should not be same. </p>

          </div>

          <div class="form-group center-block-table1">

          <span style="color:red"> (*)These fields are required </span>

          <p class="form-group-row">

            <label for="organization_name" class="fleft w_200">Organization Name<span style="color:red">*</span></label>

            <span class="cus-label-new-org">

            <input type="text" style="width:300px;" id="organization_name" name="organization_name" maxlength="30" onblur="create_random_username(this)"/>
            <br>

          	<span class="bv_org_high" style="    margin-left: 201px;">(Maximum 30 characters)</span>
            </span>

          </p>

          <p class="form-group-row">

            <label for="organization_name" class="fleft w_200" style="margin-top:0px;">Organization Type<span style="color:red">*</span> </label>

            <input type="radio" id="organization_type_muni" name="organization_type" value="1" checked="checked" />

            Municipality

            <input type="radio" id="organization_type_school" name="organization_type" value="2" />

            Schools 

            <input type="radio" id="organization_type_normal" name="organization_type" value="0" />

            Other Organizations 
            <br>

           <span class="bv_org_high" style="    margin-left: 201px;">

            <input type="radio" id="organization_type_highschool" name="organization_type" value="4" />

            High School Sports
          </span>

            </p><br />

          <p class="form-group-row">

            <label for="organization_email" class="fleft w_200">Email Address</label>

            <input style="width:300px;" type="text" id="organization_email" name="organization_email" />

          </p>

          <span style="margin-left: 200px;display:none;"id="email_notice" >

                    <span style="color:red; margin-left: 0;position: relative;top: -10px;"/> Please enter valid Email address </span>

                    </span>

          <p class="form-group-row">

            <label for="organization_username" class="fleft w_200">Username<span style="color:red">*</span></label>

            <input style="width:300px;" type="text" id="organization_username" name="organization_username" onblur="check_org_username();"/>

          </p>

          <div class="spacer"></div>

          <span id="error_org_uname" style="margin: 0px 0px 8px 160px;
    background: transparent;
    font-weight: bold;
    color: rgb(255 0 0);
    padding: 3px;
    width: 291px;
    display: block;
    text-align: left;
    font-size: 11px;
    margin-top: -10px;
    margin-left: 201px;"></span>

          <span id="error_realtor_uname1" style="margin:0 0 8px 160px; background:#F00; font-weight:bold; color:#fff; padding:3px; width:380px; display:block; text-align:center; display:none;"></span>

          <div class="spacer"></div>

          <p class="form-group-row">

            <label for="organization_password" class="fleft w_200">Password<span style="color:red">*</span><br />

      

            </label>

           

            <input type="text" id="organization_password" name="organization_password"/ style="    width: 300px;">
            <br>
<span style="margin-left: 201px;  ">
            <button onclick="create_generate_password()" class="bv_org_btn" style=" margin-top: 5px;">Generate Password</button>
            </span>

          </p>

          <span id="error_new_password"></span>

          <p class="form-group-row">

            <label for="announcement_posted_to" class="fleft w_200" style="margin-top:0px;">Announcement Posted To</label>

            <input type="radio" id="announcement_posted_to_zone" name="announcement_posted" value="0" checked="checked" />

            This Zone

            <!--<input type="radio" id="announcement_posted_to_all" name="announcement_posted" value="1" />

            All Zone--> </p>

          <span style="margin-left:200px;">

          <button onclick="SaveOrganization()" class="bv_save_org_btn" name="create_org">Save Organization</button>

          <!--<button onclick="HideAnnouncementEditor_org()">Back To Organization</button>-->

          </span>

                

            </div>

          <!--</div>-->

          </div>

          </div>

       

        

        

        <?php /*?><div id="tabs-2">

        <div class="form-group">

          <div class="container_tab_header header-default-message"  style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:0px;">

          aaaaaaaaaaaaaa

          </div>

          <?=form_open_multipart("Zonedashboard/anish", "name='csv_org' id='csv_org'");?>

          <p class="form-group-row">

            <label for="organization_password" class="fleft w_200">File name to import</label>

            <input type="file" id="docx_pod" name="docx_pod" onchange="return upload_Image('docx_pod','<?php echo site_url("Zonedashboard/upload_csv_file_organization/docx_pod/csv_org");?>','csv_org');"/>

            <p class="form-group-row" style="margin-left:200px;">Allowed  formats : (<?php echo strtoupper('docx|doc|pdf');?>) &nbsp;Max Size : ( 1 MB)</p>

                        <p class="form-group-row" style="margin-left:200px;">Max Size : ( 1 MB)</p>

                        

                        <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>

                        <div id="logo_image22">

                        <input type="text" id="docs_pdf" name="docs_pdf" />

                    </div>

          </p>

          <p class="form-group-row">

            

            <button onclick="upload_csv_file()" type="button">Upload</button>

          </p>

          <!--<input size='50' type='file' name='filename'>

          <input type='submit' name='submit' value='Upload'>-->

          <?=form_close()?>

          </div>

          </div><?php */?>

        

    </div>

    

    

</div>



</div>





<script type="text/javascript">

$(document).ready(function () { 

	$('#zone_organization_accordian').click();

	$('#zone_organization_accordian').next().slideDown();

	$('#zone_new_organization').addClass('active');

	$('#error_org_uname').hide(); 

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

	$("#organization_username").val(org_username);

}

// - Creating random username



// + checking for org name

function check_org_username(){

	

	var org_username=$("#organization_username").val();

	var org_id=$("#organization_id").val();

	var data = { "zoneid": default_zone , "org_username": org_username , "org_id": org_id};

	PageMethod("<?=base_url('Zonedashboard/check_org_username')?>", "Verify the organization user name <br/>This may take a few minutes", data, showorgusername, null);

}



function showorgusername(result){

	$.unblockUI();

	 var regex = new RegExp("^[a-zA-Z0-9.]*$"); 

		var userame=$('#organization_username').val(); 

		if(regex.test(userame) !== true){

			$('#error_realtor_uname1').html('Space not allowed');

			$('#error_realtor_uname1').show();

			$('#realtor_username').val('');	

		}else{

			$('#error_realtor_uname1').hide();

		}

	if(result.Tag==''){

		$('#error_org_uname').html('This username is reserved for zone\'s username. Please try with another username.' );

		$('#error_org_uname').show();

		$('#success_org_uname').hide();

		$('#organization_username').val('');		

	}else{

		$('#error_org_uname').hide();

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

		$("#organization_password").val(result.Tag);

	}

}

// - random generate password



// + Create New Organization Part



function SaveOrganization(){

	var authenticate=check_authneticate();

	if(authenticate=='0'){

		var zone_id = <?=$zoneid?>;			 

		alert('You are currently logged out. Please log in to continue.');

		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

	}else if(authenticate==1){

		check_org_username_save();

	 }

}



function check_org_username_save(){

		

	var org_username=$("#organization_username").val();

	var org_id=$("#organization_id").val();

	$('#error_org_uname').hide();

	if($("#organization_name").val()==''){

		alert('Please Provide Organization Name');

		return false;

	}else if($("#organization_username").val()==''){

		alert('Please Provide Organization User Name');

		return false;

	}else if($("#organization_password").val()=='' && $("#organization_id").val()==-1){

		alert('Please Provide Organization Password');

		return false;

	}

	var data = { "zoneid": default_zone , "org_username": org_username , "org_id": org_id};

	PageMethod("<?=base_url('Zonedashboard/check_org_username')?>", "", data, showorgusername_save, null);

}



function showorgusername_save(result){

	$.unblockUI();

	if(result.Tag==''){

		$('#error_org_uname').html('This username is reserved for zone\'s username. Please try with another username.' );

		$('#error_org_uname').show();

		$('#success_org_uname').hide();

		$('#organization_username').val('');		

	}else{

		/*$('#error_org_uname').hide();

		if($("#organization_name").val()==''){

			alert('Please Provide Organization Name');

			return false;

		}else if($("#organization_username").val()==''){

			alert('Please Provide Organization User Name');

			return false;

		}else if($("#organization_password").val()=='' && $("#organization_id").val()==-1){

			alert('Please Provide Organization Password');

			return false;

		}*/

		var org_type=$("input[name=organization_type]:Checked").val();

		var org_announcement_posted=$("input[name=announcement_posted]:Checked").val();

		var dataToUse = {

			"id":$("#organization_id").val(),

			"org_name":$("#organization_name").val(),

			"org_email":$("#organization_email").val(),

			"org_username":$("#organization_username").val(),

			"org_password":$("#organization_password").val(),		

			"zone_id": $("#organization_zone").val(),

			"org_type": org_type,

			"announcement_display": org_announcement_posted		

		};

		PageMethod("<?=base_url('Zonedashboard/SaveOrganization')?>", "Saving New Organization<br/>This may take a minute.", dataToUse, OrganizationSaveSuccessful, null);

	}

}

function OrganizationSaveSuccessful(result) {

	$.unblockUI();

	$("#organization_name").val("");

	$("#organization_email").val(""); 

	$("#organization_username").val("");

	$("#organization_password").val("");

	$('html,body').animate({scrollTop:0},"slow");

	$("#msg").html('<h4 style="color:#090">Organization created successfully</h4>').show();

	 setTimeout(function(){$("#msg").hide('slow');},3000);

}



// - Create New Organization Part



/* Upload CSV Files*/

 function upload_csv_file(){ 

	

	var data = { "zoneid": default_zone, 'uploaded_file_name' : $('#docs_pdf').val()};

	PageMethod("<?=base_url('Zonedashboard/anish')?>", "", data, null, null);

 }



 $('#organization_email').focusout(function(){



        $('#organization_email').filter(function(){

              var email=$('#organization_email').val();

              // var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
              var emailReg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

				if( !emailReg.test(email)){

					$('#email_notice').slideDown();

					//$('#email_notice').fadeOut(6000);

					$('#organization_email').focus();

					//$('#email_notice').fadeToggle();

				}else{

						$('#email_notice').slideUp('slow');

				     } 

        })

 });

 

 $(document).on('blur','#organization_password',function(){

	var new_password = $(this).val();

	 var regex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%#&])[A-Za-z\d$@$!%#&]{10,}$/; 

	if(new_password.length < 10 || new_password.length > 18){

		$('#error_new_password').html(" Password should be between 10 to 18 characters");

			$('#error_new_password').show();

			$('#organization_password').focus();

			$("button[name='create_org']").attr('disabled','disabled');

			return false;

	}else if(!regex.test(new_password)){ 

		$('#error_new_password').html(" Password should be combination of letters, numbers and special characters (!, @, #, $, %, &)");

			$('#error_new_password').show();

			$('#organization_password').focus();

			$("button[name='create_org']").attr('disabled','disabled');

			return false;

		}else{  

			$('#error_new_password').hide();

			$("button[name='create_org']").removeAttr('disabled');

		}

});



</script>

<style type="text/css">
 span#error_new_password {
        margin-left: 204px;
     font-weight: bold;
    color: rgb(255 0 0);
    width: 511px;
    text-align: center;
    font-size: 12px;
    margin-top: -32px;
    position: relative;
    top: -11px;
  }
</style>