var link_path ; 
var base_url ;
var zoneId ;
var user_id ;
var user_type ;
$(document).ready(function(){
	/* set global variables @anish*/
	link_path = $('input[name=link_path]').val(); 
	base_url = $('input[name=base_url]').val();
	zoneId = $('input[name=zoneid]').val();
    zone_id = $('input[name=zoneid]').val();
	user_id = $('input[name=user_id]').val();
	user_type = $('input[name=user_type]').val();


	/* Back to Dashboard*/
	$(document).on('click','.sign_out_directory',function(){

        if(user_id!='' && user_id!='undefined'){
            if(user_type == 4){//alert(11);
                var x = base_url + "Zonedashboard/zonedetail/"+ zoneId ; 
            }else if(user_type == 8){//alert(22);
                var x = base_url + "organizationdashboard/organizationdetail/"+ user_type ;
            }else {
                var x = base_url + "businessdashboard/businessdetail/"+ user_type ;
            }
        }else{            
            var x = base_url +"zone/load/"+zone_id;
        }
        console.log(x , 'sd');

        $.ajax({
            url: base_url +"auth/check_session",
            cache: false,
            success: function(result){
                if(result == 1){
                    window.location = x;
                }else{
                    alert('You are currently logged out. Please log in to continue.');
                     window.location.reload();
                }
            }
        });
	});
    /* sign out for resident user*/
    $(document).on('click','.sign_out',function(){
        $.ajax({
            url: base_url +"auth/logout",
            cache: false,
            success: function(result){
                if(result){                    
                    window.location.reload();
                }else{
                    alert('You are currently logged out. Please log in to continue.');
                    window.location.reload();
                }
            }
        });
    });
    /* */
	$(document).on('click','.loginTextChange',function(e){
      
        var loginTitle = $(this).attr('title'); 
        if(loginTitle == 'neighbour_login'){
            $("#login_type").text('Residents Login');
            $('#username_label').text('User Name/Email address used when registering');
            $("#from_where_login").val(10);
            $('#forgot_password_limk').html('<a href='+base_url +'welcome/get_forgot_password/10>Forgot your password?</a><br />');
        }else if(loginTitle == 'businesses_login'){
            $("#login_type").text('Businesses Login');
            $('#username_label').text('User Name: (Phone number used when registering)');
            $("#from_where_login").val(5);
            $('#forgot_password_limk').html('<a href='+base_url +'welcome/get_forgot_password/5>Forgot your password?</a><br />');
        }else if(loginTitle == 'organisations_login'){
            $("#login_type").text('Organizations Login');
            $('#username_label').text('User Name: (Username used when registering)');
            $("#from_where_login").val(8);
            $('#forgot_password_limk').html('<a href='+base_url +'welcome/get_forgot_password/8>Forgot your password?</a><br />');
        }else if(loginTitle == 'zone_login'){
            $("#login_type").text('Zone Login');
            $('#username_label').text('User Name:');
            $("#from_where_login").val(4); 
             $('#forgot_password_limk').html('<a href='+base_url +'welcome/get_forgot_password/4>Forgot your password?</a><br />');
        }else if(loginTitle == 'publisher_login'){
            $("#login_type").text('Publisher Login');
            $('#username_label').text('User Name:');
            $("#from_where_login").val(4);     
            $('#forgot_password_limk').html('<a href='+base_url +'welcome/get_forgot_password/4>Forgot your password?</a><br />');
        }else if(loginTitle == 'visitor_login'){
            $("#login_type").text('Visitor Login');
            $('#username_label').text('User Name:');
            $("#from_where_login").val(7);   
            $('#forgot_password_limk').html('<a href='+base_url +'welcome/get_forgot_password/4>Forgot your password?</a><br />');
        }else if(loginTitle == 'employee_login'){
            $("#login_type").text('Employee Login');
            $('#username_label').text('User Name:');
            $("#from_where_login").val(15);   
            $('#forgot_password_limk').html('<a href='+base_url +'welcome/get_forgot_password/4>Forgot your password?</a><br />');
        }
    });

$(document).on('click','.clicksnapsignup',function(e){
        var $element = $(this).closest('.offer-outer-contest');
        var busid = $element.attr('data-busid'); 
        var adid = $element.attr('data-adid');
        var type = 2;
        var offertype = 'snap'; 
        $('#snap_signup_bs_id').val(busid);
        $('#snap_zone_id_login').val(zoneId);
        $('#snap_signup_type').val(type);
        $('#snap_signup_ad_id').val(adid);
        $('#snap_signup_offer_type').val(offertype);
        //$('#rating_value').val(rate);
        $('#from_where_login').val(10);        
    });


	/* Login */
	$(document).on('click','.login-submit',function(e){
		e.preventDefault();
        
        if($("#login_email").val() == ""){
            alert("You must fill in a username!");
            return;
        }else if($("#login_password").val() == ""){
            alert("You must fill in a password!");
            return;
        }
        //var form_data = $("#loginForm").serialize();
        $.fn.check_login_type($("#login_email").val(), $('#login_password').val(),$('#userzone').val(), $("#from_where_login").val());

	
	});

	$(document).on('click','.userregistration',function(){
 
        var data_to_use={
                'createdby_id': '',
                'zone_id': zoneId,
                'type': '',
                'ad_id': '',
                'offer_type':'',
                 'url':$(location).attr("href")
            };


        $.ajax({
	        'type'		:'POST',
	        'url'		:base_url+"emailnotice/emailnoticesignform",
	        'data'		:data_to_use,
	        'beforeSend':function(){ },            
	        'success'	: function(data) { 
              
                data = JSON.parse(data)
	            if(data !=''){
                    $("#emailnoticesignupform").modal();
	                $("#emailnoticesignupform_content").show();
        			$("#emailnoticesignupform_content").html(data.Tag);
        			return false;
	            }
	        }
    	});

	
	});


	// + business_registration()
    //function business_registration(){ alert(1);
    $(document).on('click','.business_registration',function(){
        
        //var data_to_use = array('type'=>'zone', 'session_zonid'=>zoneId);
        console.log( 'dfsdfsdfsd', jQuery(this).attr('data-reffer'));
        $this =  jQuery(this);

        var data_to_use={
                'type': 'zone',
                'session_zonid':zoneId
            }; 
        $.ajax({
	        'type'		:'POST',
	        'url'		:base_url+"zone/set_session",
	        'data'		:data_to_use,
	        'beforeSend':function(){ },            
	        'success'	: function(data) { 
	            // if(data == 1){
	                // window.location = base_url+"welcome/business_registration_authentication/"+zoneId;
                    window.location = base_url+"welcome/business_registration_authentication/"+zoneId+'/'+$this.attr('data-reffer');
	            // }
	        }
    	});
	});

        /*$this->session->set_userdata('session_zone',$session_type_from_zone);
        ?>
        var zoneId = $(element).attr('data-zoneId');
        window.location.href = "<?php echo base_url('welcome/business_registration_authentication')?>/"+zoneId;*/
    
    // - business_registration()
    // + organization_registration()
    $(document).on('click','.organization_registration',function(){       
    	//var data_to_use = array('type'=>'org', 'session_zonid'=>zoneId); 

        console.log( 'dfsdfsdfsd', jQuery(this).attr('data-reffer'));
        $this =  jQuery(this);

    	var data_to_use={
                'type': 'org',
                'session_zonid':zoneId
            };
    	$.ajax({
	        'type'		:'POST',
	        'url'		:base_url+"zone/set_session",
	        'data'		:data_to_use,
	        'beforeSend':function(){ },            
	        'success'	: function(data) {

                // console.log(data , 'data');
	            // if(data == 1){
	                window.location.href = base_url+"welcome/organization_registration/"+zoneId+'/'+$this.attr('data-reffer');
                       // window.location.href = base_url+"welcome/organization_registration/"+zoneId;
	            // }
	        }
    	});
    });	
});
/* document ready function end */

$.fn.check_login_type = function(username, password,userzone,loginType){ //alert(username); alert(loginType); 
	data_to_use = {'username': username, 'loginType': loginType};
	$.ajax({
        'type'		:'POST',
        'url'		:base_url+"auth/check_login_type",
        'data'		:data_to_use,
        'beforeSend':function(){ 
            $('div#login_loading').css('display','block');
        },            
        success		: function(data) { 
            if(data == 1){
                $.fn.sendItLogin(username, password,userzone);
            }else{
                $('div#login_loading').hide();
                $('div#error_login').html(data);
            }
        }
    });
}
$.fn.sendItLogin = function(username, password,userzone){ 
    var visitorUrl = $("#visitorUrl").val();
    var from_where_login = $("#from_where_login").val();
    var pageName = '';
    pageName = $("#pageName").val();
	//var username = username.replace(/[^a-zA-Z0-9 ]/g, "").replace(/\s+/g, '');
	var username = username.replace(/[-]/g, "").replace(/\s+/g, ''); // 09.07.2018
	var data_to_use = {'username': username, 'password': password,'userzone':userzone};
	$.ajax({
		'type'	:'POST',
		'url'	:base_url+"auth/login_from_zone_page",
		'data'	:data_to_use,
		'beforeSend':function(){ 
			$('div#login_loading').css('display','block');
		},
		'success':function(data) { //console.log(data); 
	    	var res = data.split('!~!');
	    	var condition=res[0]; var id=res[1]; 
	    	/*if(condition!= 'zone_owner_not_verify'){
	        if(id!='0'){
	            $('div#login_loading').hide();	            
	            $('div#error_login').hide();*/
	            var redirect='';
	            switch(condition){
                    case 'zone_owner':
                        $('div#login_loading').css('display','block');
                        redirect=base_url+'Zonedashboard/zonedetail/'+id ;
                        //console.log(redirect); return false;
                        window.location=redirect;
                        break;
                    case 'business_owner':
                        $('div#login_loading').css('display','block');
                        //redirect=base_url+'businessdashboard/businessdetail/'+id ;
                        redirect = (visitorUrl.length!=0&&pageName.length!=0) ? visitorUrl : base_url+'businessdashboard/businessdetail/'+id;
                        window.location=redirect;
                        break;
                    case 'verification':
                        redirect=base_url+'auth/verification/'+id ;
                        window.location=redirect;
                        break;
                    case 'listed':
                        redirect=base_url+'auth/listed_business_verification/'+id ;
                        window.location=redirect;
                        break;
                    case 'home':
                        redirect=base_url ;
                        window.location=redirect;
                        break;
                    case 'createABusiness':
                        $('div#login_loading').css('display','block');
                        redirect=base_url+'businessdashboard/createABusiness/1' ;
                        window.location=redirect;
                        break;
                    case 'user_profile':
                        redirect=base_url+'index.php?zone='+id ;
                        window.location=redirect;
                        break;
                    case 'snap_profile':
                        //redirect=base_url+'zone/'+id  ;
                        redirect = (visitorUrl.length!=0&&from_where_login==10&&pageName.length!=0) ? visitorUrl : base_url+'zone/'+id;
                        window.location=redirect;
                        break;
                    case 'organization':                    
                        redirect=base_url+'organizationdashboard/organizationdetail/'+id ;
                        window.location=redirect;
                        break;
                    case 'realtor':
                        redirect=base_url+'realtordashboard/realtordetail/'+id ;
                        window.location=redirect;
                        break;
                    case 'zipadmin':
                        redirect=base_url+'/admin/' ;
                        window.location=redirect;
                        break;
                    default:
                        //alert('Default');
                        $('div#error_login').html('<span style="color:red">Sorry! You are not a valid user </span>');
                }
	        /*}else if(id==0){
	            $('div#login_loading').hide();	// added on 12.6.14
	            $('div#error_login').html(condition);
	        }
	    	}else{
		        $('#loginForm').hide();
		        $('div#login_loading').hide();
		        $('.igsignup').hide();
		        $('#account_not_verify').show();
		        $('#user_zoneid').val(id);
	    	}*/
		}
	});
}