<link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>

<script type='text/javascript' src='../../assets/scripts/jquery-1.7.2.min.js'></script>

<style type="text/css">


body{

	/*background: #777;*/

}

article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section {

	display:block;

}

nav ul {

	list-style:none;

}

blockquote, q {

	quotes:none;

}

blockquote:before, blockquote:after, q:before, q:after {

	content:'';

	content:none;

}


/* change colours to suit your needs */

ins {

	background-color:#ff9;

	color:#000;

	text-decoration:none;

}

/* change colours to suit your needs */

mark {

	background-color:#ff9;

	color:#000;

	font-style:italic;

	font-weight:bold;

}

del {

	text-decoration: line-through;

}

abbr[title], dfn[title] {

	border-bottom:1px dotted;

	cursor:help;

}

table {

	border-collapse:collapse;

	border-spacing:0;

}

/* change border colour to suit your needs */

hr {

	display:block;

	height:1px;

	border:0;

	border-top:1px solid #cccccc;

	margin:1em 0;

	padding:0;

}

input, select {

	vertical-align:middle;

}

.spacer {

	clear:both;

}

/* =========== main css ============*/

header {

	/*background:url(assets/images/topbar_bg.png) repeat-x;*/

	/*height:115px;*/

	/*margin-bottom: -142px;*/

}

/*.body_part{ background:url(assets/images/body_bg.png) repeat-x #510102; overflow:hidden; padding:40px 0;}*/

.body_part {

	/*padding:5px 10px 10px;

	width:413px;*/

	background:#fff;

}

.heading1 {

	background:#f8d385;

	min-height:40px;

	border-radius:10px;

	padding:15px;

}

#heading_signup {

	background:none;

	color:#333;

	font-size:1.5em;

	height:auto;

}

.innersize1k {

	margin:0 auto;

}

.body_part_inner {

	margin-top:12px;

	overflow:hidden;

}

.fleft {

	float:left;

}

.fright {

	float:right;

}

.align_c {

	text-align:center;

}

/*.label_left{ width:48%; float:left; display:block; text-align:right;}*/

.label_left {

	display:block;

}

/*.input_right{ width:48%; float:right; display:block;}*/

.input_right {

	display:block;

	margin-top:5px;

}

.label_left label {

	color:#333333;

	font:bold 12px/15px Verdana, Geneva, sans-serif;

}

.input_right input, textarea {

	/*border:1px solid #000;

	background:#fff;

	height:35px;

	width:378px;

	border-radius:4px;*/

}

.input_right textarea {

	height:75px;

}

.noticeformarea p {

	margin:8px 0 0 0;

	clear:both;

	overflow:hidden;

}

.alerttextmaroon {

	color:#510102;

	font:normal 12px/15px Arial, Helvetica, sans-serif;

	width:324px;

	display:block;

	margin:6px 0;

}

.body_part_inner h3 {

	font-family: 'Oswald', sans-serif;

	font-weight:400;

	font-size:23px;

}

.body_part_inner h4 {

	font:normal 16px/18px Arial, Helvetica, sans-serif;

	color:#8d8d8d;

}

.m_tb_30 {

	margin:30px 0;

}

.groupboxarea {

}

.checkboxcontent input[type="radio"], .checkboxcontent input[type="checkbox"] {

	margin-top:0;

}

.checkboxcontent p {

	width:50%;

	float:left;

	color:#510102;

	font:normal 15px/17px Arial, Helvetica, sans-serif;

	margin-top:8px;

}

.checkboxcontent span {

	display:block;

	float:left;

}

.m_left_10 {

	margin-left:10px;

}

.checkagree {

	margin-top:20px;

	color:#000000;

	font:normal 15px/17px Arial, Helvetica, sans-serif;

	overflow:hidden;

}

.checkagree input[type="checkbox"] {

	float:left;

	margin-top:2px;

}

.checkagree span {

	display:block;

	float:left;

}

.labellinebreak {

	clear:both;

	margin-top:12px;

	display:block;

}

.checklabel {

	width:96%;

}

.button_submit {

	border:1px solid #f5c050;

	-webkit-border-radius: 3px;

	-moz-border-radius: 3px;

	border-radius: 3px;

	font-size:18px;

	font-family:arial, helvetica, sans-serif;

	padding: 7px 40px 7px 40px;

	text-decoration:none;

	display:inline-block;

	text-shadow: -1px -1px 0 rgba(0, 0, 0, 0.3);

	font-weight:bold;

	color: #FFFFFF;

	background-color: #F8D385;

	background-image: -webkit-gradient(linear, left top, left bottom, from(#F8D385), to(#CFA54D));

	background-image: -webkit-linear-gradient(top, #F8D385, #CFA54D);

	background-image: -moz-linear-gradient(top, #F8D385, #CFA54D);

	background-image: -ms-linear-gradient(top, #F8D385, #CFA54D);

	background-image: -o-linear-gradient(top, #F8D385, #CFA54D);

	background-image: linear-gradient(to bottom, #F8D385, #CFA54D);

filter:progid:DXImageTransform.Microsoft.gradient(GradientType=0, startColorstr=#F8D385, endColorstr=#CFA54D);

	cursor:pointer;

}

.submitbox {/* padding:35px 0 0 35px;*/

	margin-top:33px;

	float:right;

}

.checkboxcontent input[type="checkbox"] {

	margin-right:10px;

	margin-top:-2px;

}

/* CATEGORY DROPDOWN SECTION */

.dropdown-check-list {

	/*display: inline-block;*/

}

.dropdown-check-list .anchor {

	position: relative;

    cursor: pointer;

    display: inline-block;

    padding: 10px 50px 5px 10px;

    border: 1px solid black;

    width: 100%;

    border-radius: 3px;

    height: 36px;

}

.dropdown-check-list .anchor:after {

	position: absolute;

	content: "";

	border-left: 2px solid black;

	border-top: 2px solid black;

	padding: 5px;

	right: 10px;

	top: 20%;

	-moz-transform: rotate(-135deg);

	-ms-transform: rotate(-135deg);

	-o-transform: rotate(-135deg);

	-webkit-transform: rotate(-135deg);

	transform: rotate(-135deg);

}

.dropdown-check-list .anchor:active:after {

	right: 8px;

	top: 21%;

}

.dropdown-check-list ul.items {

	padding: 2px;

	display: none;

	margin: 0;

	border: 1px solid black;

	border-top: none;

	border-bottom-right-radius: 5px;

	border-bottom-left-radius: 5px;

}

.dropdown-check-list ul.items li {

	list-style: none;

}


 



.error_border {

	border-color: red;	

}

 



/* CATEGORY DROPDOWN SECTION */

.form-container {

    background: #fafafa;

    border: 1px solid #f1f1f1;

    padding: 10px;

    margin-bottom: 15px;

    border-radius: 3px;

}

.form-container small {

    margin-top: 5px;

    display: block;

    font-size: 13px;

    line-height: 1.35;

}

.modal-dialog{

	color: #777;

}

.modal-body{

	max-height: 500px;

	overflow: auto;

}

span.red {

    color: red;

}

</style>

<script type="text/javascript" src="<?=base_url('assets/scripts/maskedinput.js')?>" ></script>

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



$("form#ratingsignupForm" ).on( "submit", function( event ) {



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

		if($('#emailvalidation').val()==false)		//return false;

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

		// console.log(serializedata , 'serializedata');


		var userID;

		$.ajax({

	        'type'		:'POST',

	        'url'		:base_url+"emailnotice/emailnoticeinsertdata",

	        'data'		:serializedata,

			'dataType': "json",

	        'beforeSend':function(){ },            

	        'success'	: function(result) { 

	            if(result !=''){

				

	               var obj=result.Tag;

					var userid=obj.user_id;			 

					var createdby_id=obj.createdby_id;

					var zoneid=obj.zone_id;

					var type=obj.type;

					var login_type=obj.offer_type;

					var rating_val=obj.offer_type;

              
					 //login_activation_link(userid);

					$('#loginsignup').hide();

					$('#loginsignupsnap').hide();

					$('#emailnoticesignupform').hide();

					//$('#mask').hide();

					  
				   var origin   = window.location.origin;

				   if(origin == 'https://peekabooauctions.com'){

                       $("#login-box").modal("show");
                       $("#emailnoticesignupform .close").click();

				   }else{
 
			     	document.cookie = "register=first";

			     	location.reload();
				    return false;


				   }


					

				  // $("#emailnoticesignupform .close").click();

                   
				


				  

					//will take action after login is successful 

			 	

				 
					
			

	            }

	        }

    	});

 


  




	}

	//})

});



function login_activation_link(userid){


	 $.post("<?=base_url('dashboards/send_user_verification_email')?>",{'userid':  userid },function(data) {   });
}
 function login_success_action(userid,createdby_id,zoneid,type,login_type,is_login_or_signup,rating_val){
 

	if(login_type!='' && login_type=='snap')

	{

		var data={'user_id':userid,'createdby_id':createdby_id,'zone_id':zoneid,'type':type};

		$.ajax({'url':'<?=base_url('emailnotice/active_group_display')?>','dataType':'json',

			'beforeSend' :login_success_pop_up(is_login_or_signup),

			'data':data,

			'success':function(result){

				if(result!='')

				{

					$('#log_in_success').hide();

					emailnoticepopup(userid,createdby_id,zoneid,type,login_type);

				}

				else

				{

					setTimeout("window.location.href='"+window.location.href+"';",500);

				}

			}

		})

	}else if(login_type!='' && login_type=='newsletter'){

		login_success_pop_up(is_login_or_signup);

		var status=1; var adid=0;

		change_status_type(userid,zoneid,createdby_id,type,status,adid,login_type);

		setTimeout("window.location.href='"+window.location.href+"';",500);

	}

	else if(login_type!='' && login_type=='ad_favourites'){

		login_success_pop_up(is_login_or_signup);

		var status=1; var adid=0;

		change_status_type(userid,zoneid,createdby_id,type,status,adid,login_type);

		setTimeout("window.location.href='"+window.location.href+"';",500);

	}

	else if(typeof(rating_val)!='undefined' && rating_val!=''){

		var data={zone_id:zoneid,user_id:userid,bus_id:createdby_id,rate:rating_val}

		$.ajax({url:'<?=base_url('ads/ratead')?>',data:data,dataType:'json',success:function(result) {

			confirmComment(createdby_id,userid,zoneid);

			alert('Not Done');

		}

		})

	}

	else

	{

		login_success_pop_up(is_login_or_signup);

		setTimeout("window.location.href='"+window.location.href+"';",500);

	}



}



function login_success_pop_up(is_login_or_signup){

	if(is_login_or_signup=='login')

	{

		var emailBox = $('#log_in_success');

	}

	else if(is_login_or_signup=='signup')

	{

		var emailBox = $('#sign_up_success');

	}

	$(emailBox).fadeIn(300);

}

	

/* function signupsuccess(result){ 

	var obj=result.Tag;

	var userid=obj.user_id;

	var createdby_id=obj.createdby_id;

	var zoneid=obj.zone_id;

	var type=obj.type;

	var login_type=obj.offer_type;

	$('#loginsignup').hide();

	$('#loginsignupsnap').hide();

	$('#emailnoticesignupform').hide();

	//$('#mask').hide();

	//will take action after login is successful 

	login_success_action(userid,createdby_id,zoneid,type,login_type,"signup");

} */

$(function (){

   $("#emailnotice_phone").mask('999-999-9999',{placeholder:' '});

    $("#cell_phone").mask('999-999-9999',{placeholder:' '});

   $( "#select_radio" ).prop( "checked", true );

});

$(document).ready(function(){

	$('input[name = globalSnapStatus]').change(function(){

		var choosenvalue = $(this).val();

		if(choosenvalue == 1){

			$("#globalDefaultSelectionBox").slideDown('slow');

		} else {

			$("#globalDefaultSelectionBox").slideUp('slow');

		}

	});

});





	/*

	 *		Organization drop down view

	 */

	var checkList = document.getElementById('list1');

	var items = document.getElementById('items');

	

	checkList.getElementsByClassName('anchor')[0].onclick = function (evt) {

		if (items.classList.contains('visible')){

			items.classList.remove('visible');

			items.style.display = "none";

		}else{

			items.classList.add('visible');

			items.style.display = "block";

		}

	

	}



	items.onblur = function(evt) {

		items.classList.remove('visible');

	}

	

	/*

	 *		Select value from category dropdown

	 */

	 var checked = []; //will contain all checked checkboxes

	 $(document).on('click','.org_checkbox', function(){

		 //alert($(this).attr('name')) ;

		 if($(this).attr('checked')){

			 checked.push($(this).attr('value')) ;

		 }else{

			 checked.splice($.inArray($(this).attr('value'), checked), 1) ;

		 }

		 

		 $('#selected_orgcategory').val(checked.toString()) ;

		 $('.anchor').text(checked.length+ '  item selected') ;

	 })

	 

	 /*

	 *		Select value from category dropdown

	 */

	 

	 $(document).on('change','.resident_accept_yes', function(){

		if ($(this).val() == 'accepted') {

			$('.dropdown_view').slideDown(1000);

		}else  if ($(this).val() == 'notaccepted'){

			$('.dropdown_view').slideUp(1000);

			$("#age_residentuser").val('');

			$("#resident_gender").val('');

			$("#resident_info").val('');

			$('#error_checkboxmsg').html('');

			$('#error_checkboxmsg').hide();

		}

	 });

	 

	 $(document).on('click','.select_age_optionlist', function(){ 

		 if($(".select_age_optionlist").is(':checked')) { //alert(11);

			$(".age_dropdown").show();  // checked

		 } else { //alert(22);

			$(".age_dropdown").hide();  // unchecked

			$("#age_residentuser").val('');

		 }

	 }); 

	

	$(document).on('click','.select_gender_optionlist', function(){ 

		 if($(".select_gender_optionlist").is(':checked')) { //alert(11);

			$(".gender_dropdown").show();  // checked

		 } else { //alert(22);

			$(".gender_dropdown").hide();  // unchecked

			$("#resident_gender").val('');

		 }

	 }); 

	 

	 $(document).on('click','.select_renter_optionlist', function(){ 

		 if($(".select_renter_optionlist").is(':checked')) { //alert(11);

			$(".renter_dropdown").show();  // checked

		 } else { //alert(22);

			$(".renter_dropdown").hide();  // unchecked

			$("#resident_info").val('');

		 }

	 }); 

	 

	 

	 function more_benifit(status=''){

		 if(status == 'showdiv'){

		 	$('.more_benifit_show').show('slow');

		 }else if(status == 'hidediv'){

			$('.more_benifit_show').hide('slow');

		 }

	 }

	 function countGlobalSnapWeekdays(element){

	 	var countedCheckBox = $('input.snapWeekdays:checked').length;

        if(countedCheckBox > 7) {

            $(element).attr('checked',false);

            toastDisplay('error','You can select maximum of seven days');



        }



	 }

	 function globalSnapAnyRegistratioan(element) {

	 	if($(element).is(":checked")){

            //$(lement).parent().parent().siblings().find('input.globalSnapRegistration').prop({'disabled':true,'checked':false});

            $(".snapStartTimeRegistration").prop('checked', false);

	 		$(".snapStartTimeRegistration[value=0]").prop('checked', true);

	 		$(".snapStartTimeRegistration").prop('disabled', true);

	 		$(".snapStartTimeRegistration[value=0]").prop('disabled', false);

          } else {

            //$(element).parent().parent().siblings().find('input.globalSnapRegistration').prop('disabled',false);           

            $(".snapStartTimeRegistration").prop('checked', true);

			$('.snapStartTimeRegistration[value=0]').attr('checked',false);

			$(".snapStartTimeRegistration").prop('disabled', false);

	 		

          }

	 }

	 

	 

	 

</script>



<!-- <header></header> -->

<?php

	 //var_dump($snapEmailCriteria['snapStartTime']);

	 //exit();

?>

<section class="body_part">



<div class="innersize1k"> 

  <!-- <div class="heading1">Email Notice Sign Up</div> -->

  

  <!--<div id="heading_signup">

    <h1 style="font-size:25px;">Neighbor Registration Form</h1>

  </div>-->

  <h4 style="font-size:14px; margin-top:10px;color:rgb(0 0 0 / 65%)">Your email address and /or text phone number is not given to the municipality, organizations or businesses.</h4>

  <h4 style="font-size:14px; margin-top:6px;color:rgb(0 0 0 / 65%)">All targeted updates are sent by Savings Sites, which never discloses your information. <a onclick="more_benifit('showdiv');" style="text-decoration:underline; cursor:pointer;">More Benefits.</a></h4>

  

  <div class="more_benifit_show" style="display:none;">

       <p style="margin-top:15px;">

          <strong>Municipal Protection:</strong><br />

            Because SavingsSites allows municipalities to freely email their residents and businesses from our server, this insulates the municipality from having to make public any email addresses collected, as many municipalities are forced to disclose email addresses under laws such as Open Public Record Act and Freedom of Information Act and Sunshine Laws.

      </p>

      

      <p style="margin-top:10px;">

         <strong>Targeted Information:</strong><br />

         The SavingsSites system also enables the businesses and organizations to create "INTEREST GROUPS" so you only receive information and only see events in the Events calendar on topics you select!

      </p>

      

      <p style="margin-top:10px;">

        <strong>Short Notice Alert Program (SNAP):</strong><br />

         Enjoy the benefits of your favorite businesses (SNAP) program to get substantially discounted specials, close-outs, perishables, and overruns not advertised. Professionals and contractors want their calendars filled, so they too will announce short notice deeply discounted offers. Many restaurants will seek to fill up their tables and offer deep discounts. Remember, Savings Sites does the emailing/texting and your information is not disclosed to the businesses.  

      </p>

      

     <span onclick="more_benifit('hidediv')"><img src="<?=base_url()?>assets/images/arrow-up.gif" style="width: 36px;margin-left: 48%; cursor:pointer;" /></span>

  </div>

      

  

  <form id="ratingsignupForm" class="" method="post" action="javascript:void(0);"  enctype="multipart/form-data">

    <div class="body_part_inner noticeformarea"> <small>Required where indicated <span class="red">*</span></small> <br />

      <span id="error" style="font-weight:bold; color:#fff;display:block; text-align:center; display:none;"></span> <br />

      <div style="clear:both"></div>

      <div class="form-container">

      <p> <span class="label_left">

        <label> User Name<span class="red">*</span>:</label>

        </span> <span class="input_right">

        <input name="username" id="emailnotice_username" type="text" onchange="username_verification($(this).val());" required class="form-control" />


        </span>

        <input type="hidden" name="usernamevalidation" id="usernamevalidation" value="" />

      

      <div style="clear:both;"></div>

      <span id="username_verify" style="font-weight:bold; color:#fff;display:block; text-align:center; display:none;"></span>

      <small>This can be a name other than your real name that is used for Blog Posts or if you choose to have your User Name posted as a Peekaboo Auction Winner (Must be between 6-12 characters):</small>

      </p>

  </div>

      <div class="form-container">

      <p> <span class="label_left">

        <label>Email<span class="red">*</span>:</label>

        </span> <span class="input_right">

        <input name="emailnotice_email" id="emailnotice_email" onchange="email_verification($(this).val());" type="text" required class="form-control" />

        <input type="hidden" name="emailvalidation" id="emailvalidation" value=""/>

        </span>

      

      <div style="clear:both;"></div>

      <span id="email_verify" style="font-weight:bold; color:#fff;display:block; text-align:center; display:none;"></span>

      </p>

  </div>

      <!--            <p>

            	<span class="label_left"><label>Username:(required)</label></span>

                <span class="input_right"><input name="username" id="username" type="text" required />

                </span>

            </p>--> 

      <!--Added phone field on 28/5/14-->

      <div class="form-container">

      <p> <span class="label_left">

        <label>Telephone: (Home Phone) If you only have cell phone enter cell here and below.</label>

        </span> <span class="input_right">

        <input name="emailnotice_phone" id="emailnotice_phone" type="text" onblur="" class="form-control" />

        </span> <span id="phone_verify" style="font-weight:bold; color:#F41525;display:block; text-align:center; display:none;"></span> <span id="phone_verify_success" style="font-weight:bold; color:#008040;display:block; text-align:center; display:none;"></span> 

        

      </p>

     

      

  </div>

<!-- 
      <div class="form-container">
 

									<div class="row">

										<div class="col-sm-12">

											<p>

												<span class="label_left">

													<label>

														Select Type:

													</label>

												</span>

												<span class="input_right">

												 <select name="user_type"><option value="10">Resident</option>
												 	<option value="2">Visitor</option>
												 	<option value="7">Employee</option></select>

												</span>

										 

											</p>

										</div>
									</div>
								</div>
 -->

      

      <div class="form-container">

									<!--Added phone field on 29/5/14-->

									<div class="row">

										<div class="col-sm-12">

											<p>

												<span class="label_left">

													<label>

														Cell Phone:

													</label>

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

		<div class="row">

			<div class="col-sm-6">

      <p> <span class="label_left">

        <label>Password<span class="red">*</span>:</label>

        </span> <span class="input_right">

        <input name="password" id="emailnotice_password" type="password" onfocusout="checkPwd()" required class="form-control"/>

        <span class="alerttextmaroon_label" style="color:red"> </span> 

        </span> </p>

    </div>

    <div class="col-sm-6">

      <p> <span class="label_left">

        <label>Retype Password<span class="red">*</span>:</label>

        </span> <span class="input_right">

        <input name="retype_password" id="retype_password" type="password" required class="form-control"/>

        </span> </p>

    </div>

</div>

</div>

<div class="form-container">

		<div class="row">

			<div class="col-sm-6">

      <p><span class="label_left">

        <label>First Name<span class="red">*</span>:</label>

        </span><span class="input_right">

        <input name="first_name" id="first_name" type="text" required class="form-control" />

        </span></p>

    </div>

    <div class="col-sm-6">

      <p><span class="label_left">

        <label>Last Name<span class="red">*</span>:</label>

        </span><span class="input_right">

        <input name="last_name" id="last_name" type="text" required class="form-control"/>

        </span></p>

    </div>

    <div class="col-sm-12">

      <p>

      	<small><strong>Needed with ID to redeem cash certificates:</strong></small>

      	<br>

      	<small class="label_left">

        <!--<label>Select Event Calendar Dropdown</label>-->

        When you are logged in the calendar will show you only events based upon categories that you are interested in. 

        </small>

    </div>

    </div>

    </div>

    

    <!--

        <div class="form-container">

		<div class="row">

			<div class="col-sm-12">

      <span class="input_right">

      	<label>Select your Categories of Interest</label>

      <input type="hidden" name="selected_orgcategory" id="selected_orgcategory" />

      <div id="list1" class="dropdown-check-list" tabindex="100"> <span class="anchor">Select Calendar Categories of Interest </span>

        <ul id="items" class="items">

          <?php	if(isset($organization_category) && !empty($organization_category)){ 

                    		foreach($organization_category as $val){

                ?>

          <li style="height:17px"><?php echo $val['orgname'];?> - <?php echo $val['name'];?>

            <input type="checkbox" class="org_checkbox" value="<?php echo $val['id'];?>" name="<?php echo $val['name'];?>"/>

          </li>

          <?php 		}

                		}

                ?>

        </ul>

      </div>

      <small>When you are logged in the calendar will show you only events based upon categories that you are interested in.</small>

      </span>

      </p>

      </div>

      </div>

      </div>

      -->

      

      <!-- # + ####################### Peekaboo free email credit ################################## -->

      <!--<div class=""> <span class="label_left">

        <label>Email Credit:</label>

        </span> <span > Yes

        <input type="radio" name="credit_email_accept" value="Yes" />

        No

        <input type="radio" name="credit_email_accept" value="Yes" />

        </span> </div>-->

      <?php //echo "<pre>"; var_dump($email_offers_criteria); ?>

      <!--<div class="form-container">

      <p class="text">

        <div id="accept_val">

        <span class="label_left" style="font-size: 13px;">

        	<label style="margin-bottom:6px;">Free Peekaboo Auction Peeking/Bidding Credits:</label> <input type="radio" name="resident_accept" id="select_radio" class="resident_accept_yes" value="accepted" style="margin-left:15px;"  /> Yes <input type="radio" name="resident_accept" class="resident_accept_yes" value="notaccepted"  /> No

        	<small>OPTIONAL: You can receive 2 FREE Credits by allowing Savings Sites to email you 12 targeted discount offers for your review. Businesses are paying Savings Sites to email their offers and that payment provides you with free credits. You are under no obligation to buy any product/service. You can opt-out at any time and your email address will never be provided to any business. If Yes, then answer the three questions below so you get "targeted" discount offers. If you're not interested then choose No, and simply bypass the questions and Submit. </small>

        	

        </span>

        </div>

      </p>

      </div>

      <div class="form-container">

      <div class="dropdown_view">

      <span id="error_checkboxmsg" style="font-weight:bold; color:#fff;display:block; text-align:center; display:none;"></span>

      

      

            <p>

               <div class="age_dropdown">

                   <select name="age_residentuser" id="age_residentuser" class="dropdown_style form-control" >

                          <option value="" selected="selected">Select Age Group for targeted discount offers</option>

                         <?php	if(isset($email_offers_criteria) && !empty($email_offers_criteria)){ 

                                    foreach($email_offers_criteria as $val){ 

                                        if($val['email_offers_criteria_type']==1){ ?>                              

                                              <option value="<?php echo $val['email_offers_criteria_id']; ?>" ><?php echo $val['email_offers_criteria_value']; ?></option>

                        <?php		  }

                                    }

                                }

                        ?>  

                   </select>

               </div>    

          </p>           



              <p>

               <div class="gender_dropdown">

                 <select name="resident_gender" id="resident_gender" class="dropdown_style form-control" >

                          <option value="" selected="selected">Select Gender for targeted discount offers</option>

                     <?php	if(isset($email_offers_criteria) && !empty($email_offers_criteria)){ 

                                foreach($email_offers_criteria as $val){ 

                                    if($val['email_offers_criteria_type']==2){ ?>                       

                                          <option value="<?php echo $val['email_offers_criteria_id']; ?>" ><?php echo $val['email_offers_criteria_value']; ?></option>

                    <?php		  }

                                }

                            }

                    ?>      

                 </select>

               </div>    

              </p>

          

          <p>

           <div class="renter_dropdown">

           <select name="resident_info" id="resident_info" class="dropdown_style form-control" >

                      <option value="" selected="selected">Select Own or Rent to get targeted discount offers</option>

			  <?php	if(isset($email_offers_criteria) && !empty($email_offers_criteria)){ 

                    foreach($email_offers_criteria as $val){ 

                        if($val['email_offers_criteria_type']==3){ ?>               

                          <option value="<?php echo $val['email_offers_criteria_id']; ?>" ><?php echo $val['email_offers_criteria_value']; ?></option>

		     <?php		    }

                    }

                }

               ?>    

           </select>

           </div>    

          </p>

        

      </div>

  </div>-->

     <!--  <div class="row">

      	<div class="col-sm-12">

      		<h1 class="text-center" style="font-size: 21px;">Short Notice Alert Program(SNAP)</h1>

      		<p><strong>Businesses do not send you offers.</strong> You select the businesses that can have Savings Sites send you business deals; and you kill all junk offers as all their deals must meet your (SNAP) filters (Minimum Discount Requirement and "Availability") </p>

      	</div>

      	<div class="center-block">

	      	 
        </div>



        <div class="col-sm-12"><div class="form-container"><label for="snapGlobalRegOn"><input style="margin-top:-2px; margin-right:10px;" type="radio" name="globalSnapStatus" value="1" class="globalSnap" id="snapGlobalRegOn"> SNAP STATUS ON</label>

        	<small>Yes SNAP ON all offers. I will decide which businesses to SNAP OFF or add my SNAP FILTERS to Kill Junk Offers!</small>

        </div></div>

      	<div class="col-sm-12"><div class="form-container"><label for="snapGlobalRegOff"><input style="margin-top:-2px; margin-right:10px;" type="radio" name="globalSnapStatus" value="0" checked="checked" id="snapGlobalRegOff" class="globalSnap"> OFF SNAP STATUS</label>

      		<small>SNAP OFF all offers. I will decide which businesses to SNAP ON and add my SNAP FILTERS to Kill Junk Offers!  </small>

      	</div></div>

      </div> -->

      

      <div id="globalDefaultSelectionBox" style="display: none;padding-top: 20px;">

      	<div class="row">

      		<div class="col-sm-12">

      		<div class="form-container">

      	

      		<h3>SNAP Email Filters -- You Control Your Flow of Offers!</h3>

      	

      	<div class="snapMinmumPercentage">

      		<div>

      			<p style="margin-bottom: 5px;">Modify (SNAP) filters in the resident admin dashboard for all businesses; or go to Deals page query businesses, and just click the SNAP image for your desired Businesses! </p>

      		</div>

      		<!--

      		<div>

	      		<select id="snapSelectMinimumPercentage" class="form-control" name="snapSelectedMinimumPercentage">

	      			<option value="0">Any Percentage</option>

	      			<?php foreach ($snapEmailCriteria['percentageCriteria'] as $key => $value) { ?>

	      					<option value="<?= $key ?>"><?= $value ?>%</option>

	      			<?php } ?>

	      		</select>

      		</div>

      		-->

      	</div>

      	<div style="clear: both"></div>

      	<div class="sendType" style="padding-top: 20px;">

      		<!--<div>

      			<select class="form-control" name="globalSnapSendType">

      				<option value="1">Email me Snap Notices</option>

      				<option value="2">TEXT me Snap Notices</option>

      				<option value="3">Both Text and Email</option>

      			</select>

      		</div>-->

      	</div>

      </div>

  </div>

  <!-- For time reservation -->

  <div style="display: none;" class="col-sm-12">

  <div class="form-container">

  	<div class="row">

      		<div class="col-sm-12">

      			 <strong>Indicate below the days and times of day you're available to use the offer:</strong>

      		</div>

      		<div style="clear: both"></div>

      		

      		<div class="col-sm-12">

      			<div class="row snaptimecolumn" style="margin-top: 26px;">

				<div class="col-sm-3 col-xs-6 hidden-xs" style="height:40px;"></div>

				<div class="col-sm-3 col-xs-6" style="height:40px;"><div class="any-time" style="margin-left: 61%; position: absolute; width: 100px; margin-top: -24px;"><input type="checkbox" name="snapStartTime[]" class="snapStartTimeRegistration" value="0" id="snapStartTimeRegistrationDefault" onchange="globalSnapAnyRegistratioan(this)">&nbsp;<span>Any time</span></div>am<br>			      		 

		      		 </div>

		      		  <div class="col-sm-3 col-xs-6 hidden-xs" style="height:40px;">pm</div>

		      		  <div class="col-sm-3 col-xs-6 hidden-xs" style="height:40px;">pm</div>

      				<div class="col-sm-3 col-xs-6">

			      		<?php

			      		  foreach ($snapEmailCriteria['snapWeekDays'] as $key => $value) { ?>

			      				<input type="checkbox" name="snapWeekdays[]" class="snapWeekdays" value = "<?= $key ?>" onChange="countGlobalSnapWeekdays(this)">&nbsp;<span><?= $value ?></span><br>

			      		<?php } ?>

		      		</div>

		      		 

		      		<?php 

		      			$i=1;

		      			foreach ($snapEmailCriteria['snapStartTime'] as $key => $value) { 

		      				$twelvehrsformat = date('h:i:s',strtotime($value));

		      				if($i == 1){ ?>

		      					<div class="col-sm-3 col-xs-6">

		      				<?php }



		      				?>

		      					<input type="checkbox" name="snapStartTime[]" value="<?= $key ?>" class="globalSnapRegistration snapStartTimeRegistration">&nbsp;<span><?= $twelvehrsformat ?></span><br>

		      		 <?php

		      		 	if($i == 6){ ?>

		      		 		</div>

		      		 	<?php

		      		 		$i=0;

		      		 	 }

		      		 	 $i++;

		      		 } ?>

      		 </div>

      		 <div class="col-sm-12" id="snapMessage"></div>

      	</div>

      </div>

      </div>

      </div>

      </div>

      </div>



      

    

      

      <!-- # + ####################### Peekaboo free email credit ################################## --> 

      

    </div>

    <!-- next section -->

    <input type="hidden" name="ad_id" value="<?php echo $ad_id;?>" />

    <input type="hidden" name="offer_type" value="<?php echo $offer_type;?>" />

    <input type="hidden" name="createdby_id" value="<?php echo $createdby_id;?>" />

    <input type="hidden" name="zone_id" value="<?php echo $zone_id;?>" />

    <input type="hidden" name="type" value="<?php echo $type;?>" />

    <div class="submitbox" style="padding-right: 20px;text-align: center;text-align: center;float:none;">

      <input type="submit" class="signup_button btn btn-default" value="Submit" />

    </div>

  </form>

</div>

</section>

<div class="modal fade peekboo-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="snapModalContent" style="position: absolute;padding-top: 120%;z-index: 1000">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" id="snapModalClose"><span aria-hidden="true">&times;</span></button>

                <h4 class="modal-title" id="myModalLabel"> What is SNAP?</h4>

            </div>

            <div class="modal-body">

                <p>Short Notice Alert Program (SNAP) allows you to opt-into receiving discount offers like close outs, perishables, restaurant cancellations, or appointments canceled with professionals and contractors. Professionals and contractors, restaurants, resorts, need to keep their schedules, tables and rooms filled and you benefit! </p>

                <p>Your email address is protected as the Savings Directory email server sends you SNAP emails and never discloses your email address to the business. You choose SNAP on a business by business basis. There is no additional registration needed other than your Savings Directory registration. You simply opt-in and opt-out by clicking your SNAP STATUS On or OFF!</p>

                <div style="padding-top: 5px">

                    <p style="font-weight: bold">SNAP EMAIL FILTERS :</p>

                    <p style="font-weight: bold">Even when your SNAP status is turned ON for a business you can further restrict the review of the offers by indicating your availability to use the offer by the (1) The Day of the Week (2) The Time of the Day (3) The Minimum Discount you want before you will review the offer. </p>

                </div>

                <p>If you have not registered, please go to the upper right corner and register. If you are already registered, then just login and turn your favorite businesses SNAP Offers On.</p>

                <p><strong>Businesses</strong>: There is no additional cost for the Savings Directory email server to provide SNAP emailing! SNAP is also integrated with our real time scheduling/reservations/booking system so the emailed recipients can be equitably allocated/assigned/reserved, on a first come first served basis, based on your quantities/open times available. </p>

            </div>

        </div>

    </div>

</div>

<script type="text/javascript">

	$(document).ready(function(){

		$("#snapModalClose").click(function(){

			$("#snapModalContent").modal('hide');

		});

		changeDefaultSnapStatus();



		$(".snapStartTimeRegistration").prop('checked', true);

		$('.snapStartTimeRegistration[value=0]').attr('checked',false);

	});

	function changeDefaultSnapStatus(){

		$('input[name=globalSnapStatus][value=1]').change().attr('checked',true);

		$('input[name=snapWeekdays][value=1]').attr('checked',true);

		$("input.snapWeekdays").each(function(index,value){

			if(index!=-1){

				$(this).attr('checked',true);

			}



		});

		//$("#snapStartTimeRegistrationDefault").click();

	}

</script>