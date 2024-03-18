    $(document).ready(function(){
    $("#loading").hide();
    $(".formError").hide();
    $('#bottom_link').show();
    var zone_id = $('#zone_id').val();
    var user_id = $('#user_id').val();
    fetchMyAccountData('userupdate',zone_id,user_id);
    $("#name").mask('999-999-9999',{placeholder:' '});
    $("#phone_user").mask('999-999-9999',{placeholder:' '});
    $("#cell_phone").mask('999-999-9999',{placeholder:' '});
    $("#zoneidcsv").select2();
    var href = document.location.href;
    var split = href.split('/');
    if(split[4] == 'cart'){
        var total = $('#emptytotal').val();
        if(total == 0){
            $('#cart_modal_checkout_empty').modal({backdrop: 'static', keyboard: false}, 'show');
            $('#cart_modal_checkout_empty').modal('show');
        }
    }
    $(document).on('click','.close', function(){
        $('#cart_modal_checkout_empty').modal({backdrop: 'static', keyboard: false});
        $('$cart_modal_checkout_empty').modal('hide');
    });
    $(document).on('click','.showgobtn', function(){
        var zip=$('#zip').val();
        if(zip==''){
        	savingalert('warning','Please Select Zip Code');
            return false;
        }
        $.ajax({
        	type: "GET",
           	url: '/zip_to_zone/'+zip,
            cache: false,
            success: function(data){
                console.log(data); 
            	if($.trim(data)!='0'){	
                    window.location.href = data ;
				}else if($.trim(data) == '0'){
                    $('#zip_locator').modal('show');
                }
            }
        });
    });

    $(document).on('click', '#menuToggle', function(){
    	if($('#menu-bar').hasClass("menushow")){
    		$('#menu-bar').removeClass("menushow");
    		$('#menu-bar').css("display",'none');
    	}else{
    		$('#menu-bar').addClass("menushow")
    		$('#menu-bar').css("display",'block');
		}
    });

    $(document).on('click', '#sinupchecks', function(){
           // alert('here');    
        });

    $("#contactpost").click(function(){
        $('#loading').css('visibility','visible');
        $('#loading').css('visibility','hidden');
        var name=$('#name').val();
        var email=$('#email').val();
        var phone=$('#phone').val();
        var subject=$('#subject').val();
        var message=$('#message').val();  
        var url = "/contact";
        if(name == '' && email == ''){
            savingalert('danger','Please Select Required Fields'); 
            return false;  
        }                                                                              
        $("#contactpost").hide('slow').after('<h3>Thank you we will contact you sortly!</h3>');

        $.ajax({
            type:"POST",
            url:url,
            data:{'name': name, 'email': email,'phone': phone, 'subject': subject,'message': message},
            dataType:'json',
            success: function (res) {
                if(res == 1){
                    $('#loading').css('visibility','visible');
                    $("#contactpost").after('<h1 style="color:#eeefb2;font-size:60px;">Thank you!</h1>');
                    $('#loading').css('visibility','hidden');
                    $('#name').val('');
                    $('#email').val('');
                    $('#phone').val('');
                    $('#subject').val('');
                    $('#message').val('');
                }
            }
        });
    });

    $(document).on('click','#save_user', function(){
        var refer_choice = '';
        var refer_email = '';
        var refer_phone = '';
        var refer_code = '';
        var id=-1;
        var account_type = '';
        var zone = $('#zone').val();
        var name = $('#name').val().replace(/-/g, ''); 
        var password = $('#password').val(); 
        var company_name = $('#business_name').val();
        var motto = $('#motto').val();   
        var uemail = $('#uemail').val();
        var fname = $('#fname').val(); 
        var lname = $('#lname').val(); 
        var fullname = $('#fullname').val(); 
        var sic_code = $('#sic_code').val();
        var phone = $('#phone_user').val();
        var website = $('#website').val();
          refer_email = $('#referrer_email').val();
          refer_phone = $('#referrer_phone').val();
          refer_code = $('#refer_code').val();
        var zone_owner = $('#zone_owner').val();
        var userid_for_registration = "";
        var state=$('#selstate').val();
        var city=$('#selcity').val();
        var selzone = $('#selzone').val();
        var zip=$('#selzip').val();
        var user_address  = $('#user_address').val();
        var user_address2  = $('#user_address2').val();
        var user_city = $('#user_city').val();
        var user_state = $('#user_state').val();
        var user_zip = $('#user_zip').val();
        var bemail = $('#bemail').val();
        var postalcode = $('#postalcode').val();
        var restaurant_type = $('#restaurant_type').val();
          phone_share ="";
        var alternate_phone = $('#alphone_user').val(); 
        if($('input[name="zoneId"]').val()==''){
            var zoneId = selzone;
        }else{
            var zoneId = $('input[name="zoneId"]').val();
        }
        if(zone_owner == -1){
            alert('Please select a zone name.'); 
        }
        if(postalcode == '' || postalcode == -1){
            savingalert('warning','Please Insert Postal Code.');
            $('#postalcode').focus();    
            return false;
        }
        if(name !=""){
            $.ajax({
                type:"POST",
                url:'/profile_update',
                data:{'id': id, 'account_type': account_type,'zone': zone, 'name': name,'password': password, 'company_name':company_name ,'motto': motto, 'uemail': uemail,'fname': fname, 'lname': lname, 'fullname': fullname, 'phone': phone,'user_address': user_address,'user_address2':user_address2,'city': city,'state': state, 'zip': zip, 'user_city':user_city, 'user_state':user_state , 'user_zip':user_zip , 'refer_code':refer_code, 'userid_for_registration':userid_for_registration,'refer_choice':refer_choice,'refer_email':refer_email,'refer_phone':refer_phone, 'website':website, 'zone_owner':zone_owner,'selZone':zoneId, 'bemail':bemail, 'phone_share':phone_share,'alternate_phone':alternate_phone,'restaurant_type':restaurant_type,'postalcode':postalcode},
                dataType:'json',
                success: function (data) {
                    if(data.type == 'warning'){
                        savingalert('warning',data.msg);
                    }else{
                        $(".required-div").hide();
                        $("#registration-form").hide('slow').after(data);
                    }
                }
            });
        }else{
        savingalert('warning','Required data is missing or is not in the correct format. Please complete the required fields where marked with a red message(s)');
        }
    });

    $(document).on('change', '#selState', function(){
        var v = $(this).val();
        var zone_id = $('#zone_id').val();
        getCity(v,'#selState',zone_id);
    });

    $(document).on('change', '#selcity', function(){
        var city = $(this).val();
        var state = $('#selState').val();
        getZone(city,state,'#selcity');
    });

    $(document).on('click', '#button_org_register',function(){
        var zip_code =  $('#zip_code').val();
        var selState =  $('#selState').val();
        var selcity =  $('#selcity').val();
        var selzone =  $('#selzone').val();
        var org_type =  $('#org_type').val();
        var org_name =  $('#org_name').val();
        var org_username =  $('#org_username').val();
        var password =  $('#password').val();
        var cpassword =  $('#cpassword').val();
        var uemail =  $('#uemail').val();
        var cemail =  $('#cemail').val();
        var fname =  $('#fname').val();
        var lname =  $('#lname').val();
        var phone_user =  $('#phone_user').val();
        var user_address =  $('#user_address').val();
        var get_zoneid = $('#get_zoneid').val();
     
        if(zip_code == '' || selState == '' || selcity == '' || selzone == '' || org_type == '' || org_name == '' || org_username == '' || password == '' || cpassword == '' || uemail == '' || cemail == '' || fname == '' || lname == '' || phone_user == '' || user_address == ''){
            savingalert('warning','Please complete the required fields where marked with a red message(s)');
            return false;
        }
        if(password != cpassword){
            savingalert('warning','Password and Confirm Password Should be Same');
            return false;   
        }
        if(uemail != cemail){
            savingalert('warning','Email and  Confirm Email Should be Same');
            return false;   
        }
        var id=-1;
        var org_name = $('#org_name').val();  
        var org_type = $('#org_type').val();  
        var org_username=$('#org_username').val();    
        var org_password=$('#password').val();  
        var org_email=$('#uemail').val();   
        var zip=$('#zip_code').val();         
        var state=$('#selState').val();     
        var city=$('#city').val();        
        var selzone = $('#selzone').val();    
        if(state != -1){
            if(city == -1){
                savingalert('warning','Please Select a City.');
                return false;
            }
            if(selzone == -1){
                savingalert('warning','Please select a Zone Name.');
                return false; 
            }
        }
        var fname=$('#fname').val();
        var lname=$('#lname').val();
        var phone=$('#phone_user').val();
        var user_address  = $('#user_address').val();
        var user_city = $('#user_city').val();
        var user_state = $('#user_state').val();
        var user_zip = $('#user_zip').val();
        var userid_for_registration=$('#userid_for_registration').val();
        var announcement_display = '0';
        $.ajax({
            type:"POST",
            url:'/organization_registration',
            data:{'id': id, 'org_name':org_name, 'org_type':org_type, 'org_username': org_username,'org_password': org_password, 'org_email': org_email, 'city': city,'state': state, 'zip': zip, 'selzone':selzone, 'fname':fname, 'lname':lname, 'phone':phone, 'user_address':user_address, 'user_city':user_city, 'user_state':user_state, 'user_zip':user_zip, 'userid_for_registration':userid_for_registration, 'announcement_display':announcement_display},
            dataType:'json',
            success: function (data) {
                savingalert('success','User Created Successfully, redirect to Zone Page');
                setTimeout(function () {
                    window.location.href = '/zone/'+get_zoneid;
                 }, 2500);
                // $('#loading').css('visibility','visible');
                // $("#registration-form").hide('slow').after(data);
                // $('#loading').css('visibility','hidden');
                // $('#bottom_link').hide();
                // $('#new_table').hide();
                // $('#zip_table').hide();
                // $('#continue').hide();
            }
        });
    });

    $(document).on('click','.forgotpassword', function(){
        var username = $('#username_forgot').val();
        var usertype = $('#usertype_forgot').val();
        if(username == ''){
            savingalert('warning','Please Fill Username');
            return false;    
        } 
        $.ajax({
            type:"post",
            url:'/forgot_password',
            dataType:"json",
            data:{'name':username,'usertype':usertype},
            success: function(data){
                if(data.msg == 'Success'){
                    $(".response_mssg").css({"color":"green"});
                    $(".response_mssg").html("Thank you for submitting your reset request. A reset code should be emailed to the email address you registered under.");
                }else if(data.msg == 'Failed'){
                    $(".response_mssg").css({"color":"red"});
                    $(".response_mssg").html("Sorry! Unable to get your request. Please put valid email.");
                }
            }
        });
    });

    $(document).on('click','.modal_form_open', function(){
        $('.dropdown-menu-right').removeClass('show');
        var link = $(this).attr('link');
        var seo_zone = $('#seo_zone').val();
        var zone_id = $('#zone_id').val();
        var refer_code = $('#refer_code').val();
        
        if(link == 'userregistration'){
           $('#emailnoticesignupform').modal('show');
        }else if(link == 'business_registration'){
            window.location.href = '/home/business_registration_authentication/'+zone_id;
        }else if(link == 'organization_registration'){
            window.location.href = '/home/organization_registration/'+zone_id;
        }else if(link == 'employee_registration'){
           $('#employee_registration').modal('show');
        }else if(link == 'visitor_registration'){
           $('#visitor_registration').modal('show');
        }
    });    

    $(document).on('click','.loginTextChange1', function(){
        $('.dropdown-menu-right').removeClass('show');
        var id = $(this).attr('title');
        if(id == 'neighbour_login'){
            $('#username_label_name').html('User Name/Email address used when registering');
            $('#login_type_name').html('Residents Login');
            $('#login_type_name').attr('loginType', 10);
            $('#forgot_password_limk').html('<a href="/get_forgot_password/10">Forgot your password?</a><br />');
            $('#login-box').modal('show');
        }else if(id == 'businesses_login'){
            $('#username_label_name').html('User Name/Email address used when registering');
            $('#login_type_name').attr('loginType', 5);
            $('#forgot_password_limk').html('<a href="/get_forgot_password/5">Forgot your password?</a><br />');
            $('#login_type_name').html('Businesses Login');
            $('#login-box').modal('show');    
        }else if(id == 'organisations_login'){
            $('#username_label_name').html('User Name/Email address used when registering');
            $('#login_type_name').attr('loginType', 8);
            $('#forgot_password_limk').html('<a href="/get_forgot_password/8">Forgot your password?</a><br />');
            $('#login_type_name').html('Organizations Login');
            $('#login-box').modal('show');
        }else if(id == 'employee_login'){
            $('#login_type_name').html('Employee Login');//alert("hiii man");
            $('#login_type_name').attr('loginType', 15);
            $('#forgot_password_limk').html('<a href="/get_forgot_password/15">Forgot your password?</a><br />');
            $('#username_label_name').html('User Name:');//alert("hiii man me there");
            $('#login-box').modal('show');//alert("hiii man");
        }else if(id == 'visitor_login'){
            $('#login_type_name').html('Visitor Login');
            $('#login_type_name').attr('loginType', 7);
            $('#forgot_password_limk').html('<a href="/get_forgot_password/7">Forgot your password?</a><br />');
            $('#username_label_name').html('User Name:');
            $('#login-box').modal('show');
        }else if(id = 'publisher_login'){
             $('#login_type_name').html('Publisher Login');
            $('#login_type_name').attr('loginType', 4);
            $('#forgot_password_limk').html('<a href="/get_forgot_password/4">Forgot your password?</a><br />');
            $('#username_label_name').html('User Name:');
            $('#login-box').modal('show');
        }
    });

    var sr = 0;
    $(document).on('click','#multiplePhone', function(){
        var cell_phone = $('#cell_phone').val();
        var type = $('#cell_phone').attr('texttype');
        var count = $('#cell_phone').attr('count');
        if(cell_phone == ''){
            savingalert('warning','Please Enter cell phone no');
            return false;
        }
        sr++;
        count++;
        if(type == 'updatemyaccount'){
            var html = '<div class="form-group aComment">  <span> <label>Cell Phone Alternative:</label><input style="width: 93%;float: left;margin-right: 10px;" name="phone_alternate[]" type="text" id="phone_alternate'+count+'" class="form-control phone_alternate"></span><button style="width: 5%;float: left;height:49px;" type="button" class="btn btn-danger rcellpalt">X</button></div>'; 
            $('#cell_phone').attr('count',count);   
        }else{
            var html = '<div class="aComment col-sm-12"><div class="col-sm-10" style="float:left"><p><span class="label_left"><label>Cell Phone Alternative:</label></span><span class="input_right"><input name="cell_phoneextra[]" id="phone_alternate'+sr+'" type="text" class="form-control cell_phoneextra" autocomplete="off"></span></p></div><div style="float:left" class="col-sm-2"><span class="label_left" style="margin-top:12px;"><label>&nbsp;</label></span><button style="height:45px" type="button" class="btn btn-danger rcellpalt">X</button></div></div>';
        }
        $(this).closest('div').after(html); 
        $("#phone_alternate"+count).mask('999-999-9999',{placeholder:' '});
        $("#phone_alternate"+sr).mask('999-999-9999',{placeholder:' '});
    });
    $(document).on('click','.rcellpalt', function(){
        $(this).closest(".aComment").remove();
    });

    $("form#ratingsignupForm" ).on( "submit", function( event ) {
        console.log('herer');
    var error='';
    var error_checkboxmsg = '';
    email_verification($('#emailnotice_email').val());
    username_verification($('#emailnotice_username').val());    
    var refer_code = $('#refer_code').val();
    var zone_id = $('#zone_id').val();
    
    if($('#emailnotice_password').val()!=$('#retype_password').val()){
        error+='Password did not match.<br/>';
    }   
    if(error!=''){
        savingalert('danger',error);
        return false;
    }else{
        event.preventDefault();
        var serializedata=$('form#ratingsignupForm').serializeArray();
        var userID;
        $.ajax({
            'type':'POST',
            'url' :'/emailnoticeinsertdata',
            'data':serializedata,
            'dataType': "json",
            'beforeSend':function(){},            
            'success': function(result) { 
                console.log(result);
                if(result !=''){
                    var obj=result;
                    var userid=obj.user_id;          
                    var createdby_id=obj.createdby_id;
                    var zoneid=obj.zone_id;
                    var type=obj.type;
                    var login_type=obj.offer_type;
                    var rating_val=obj.offer_type;
                    $('#loginsignup').hide();
                    $('#loginsignupsnap').hide();
                    $('#emailnoticesignupform').hide();
                    $('#emailnoticesignupform02').modal('hide');
                    $("form#ratingsignupForm").get(0).reset();
                    var origin   = window.location.origin;
                    if(origin == 'https://peekabooauctions.com'){
                        // $("#login-box").modal("show");
                        $("#emailnoticesignupform .close").click();
                    }else{
                        document.cookie = "register=first";
                        location.reload();
                        return false;
                    }
                }
            }
        });}
    });

    $(document).on('click','#header_login', function(){
        var username = $('#login_email').val();   
        var password = $('#login_password').val();
        var logintype = $('#login_type_name').attr('loginType');  
        check_login(username,password,logintype); 
    });

    $(document).on('click','.zoneMyAccount', function(){
        $('.zoneMyAccount').removeClass('active');
        $(this).addClass('active');
        var type = $(this).attr('type');
        var zone_id = $('#zone_id').val();
        var user_id = $('#user_id').val();
        fetchMyAccountData(type,zone_id,user_id);
        
    });
    
    $(document).on('click','.profile_update',function(){
        var alphone = [];
        var id = $(this).attr('data-id');
        var fn=$('#fn_pro').val();
        var ln=$('#ln_pro').val();
        var phone = $('#cell_phone').val();
        var carrier = $('#carrier').val();       
        $(".phone_alternate").each(function() {
          alphone.push($(this).val());
        });           
        $.ajax({
            type: "POST",
            url: '/myaccount_update',
            data:{'id':id,'fn':fn,'ln':ln,'phone':phone,'carrier':carrier,'alternatephone':alphone},
            dataType:'json',
            cache: false,
            success: function(d){
                savingalert(d.type,d.msg);
                $('#success').show();
                $('#success').text(data);
            }
        });
    });
    $(document).on('click','.remove-item', function(){
        $(this).closest('.cart-item').remove();
        dataremoveID = $(this).attr('data-remove1ID');
        $.ajax({
            type: "POST",
            url: '/removeProductCart',
            data: {'dataremoveID':dataremoveID},
            success: function(response) {
                savingalert('success','Product removed from Cart!');
                location.reload();
            }
        });
    });

    $(document).on('click','.sign_out',function(){
        sign_out();
    });

    $(document).on('click','#free_Certbutton', function(){
        var userid = $(this).attr('userid');
        var zoneid = $(this).attr('zoneid');
        var busid = $(this).attr('busid');
        var deaid = $(this).attr('deaid');
        var alldata = $(this).attr('alldata');
        var creditStatus = $(this).attr('creditStatus');
        var usedcert = $(this).attr('usedcert');
        var token = '<?php time(); ?>';
        var base_url = window.location.origin;
        
        var baseurl123 = base_url+'/thankyou/'+zoneid+'?UserId='+userid+'&Amount=0&creditStatus='+creditStatus+'&AucId='+deaid+'&busid='+busid+'&zoneid='+zoneid+'&usedcert='+usedcert+'&'+alldata;
        window.location.href =  baseurl123;
    });

    $(document).on('click','.loadorganization', function(){
        $('#loadorganizationModal').modal('show');
    });

    $('.modal').on('hide.bs.modal', function() {
        var memory = $(this).html();
        $(this).html(memory);
    });

    $(document).on('click','#business-auth', function(){
        var username = $('#userid').val();
        var zone_id = $('#zone_id').val();
        var password = "change";
        var phoneNoStatus = checkPhonebus(username);
        if(!phoneNoStatus){
            savingalert('danger','Invalid phone number');
            return false;
        }else {
            $.ajax({
                type:"POST",
                url: "/login_from_zone_page",
                data:{ 'username':username,'password':password},
                success:function(response)  { 
                    var res = response.split('!~!');
                    var condition=res[0]; 
                    var id=res[1];
                    if (condition=='business_owner') {
                        if (passfrom=="pbg"){
                            $("#pbgpayment").submit();
                        }else{
                            // updateBusinessInformation(id);
                            // window.location.href='<?=base_url('businessdashboard/businessdetail')?>/'+id ;
                        }
                    }else { 
                        $("#invalidBusinessAuthenmticateUser").html('<p style="color:red;">Your business is not registerd yet.You will be redirected to registration page....</p>');
                        setTimeout(function() {
                                window.location.href='/home/business_registration/'+zone_id;
                            },3000);  
                        }  
                    }
                });
        }
    });
    
    $(document).on('click','#copytoclip', function(){
        var textBox = document.getElementById('referlinktext');
        textBox.select();
        document.execCommand("copy");
        savingalert('success','Copy To ClipBoard');
    });

    $(document).on('click', '#mailsend', function(){
        var email = $('#referlinkmail').val();
        var type = 'link_refer_mail';
        var code = $('.refertext').text();
        if(email != ''){
            $.ajax({
                'url' :'/refer_generate',
                'type':'POST',
                'data':{'email':email,'type':type,'code':code},
                success:function(r){
                    savingalert('success','Email send Successfully');
                }
            });
        }
    });

    $(document).on('click', '.clickview', function(e){
        e.preventDefault();
        var userid=$('#get_user_id').val();
        var zoneid=$('#get_zoneid').val();
        
        $.ajax({
            url : '/get_certificate',
            type : 'GET',
            data : { id : $(this).attr('data-productid'), purchaseID: $(this).attr('data-porchaseid') , zoneid:zoneid,userid:userid },
            dataType:'json',
            success : function(data) {
                $('.certificate_view .modal-body').html(data.html); 
                $('.certificate_view').modal('show');      
            }
        });
    });

    $(document).on('click', '.verifyme', function(e){
        var id = $(this).attr('data-dealid');
        e.preventDefault();
        $.ajax({
            url : "/get_certificate_verify",
            type : 'GET',
            data : { 'id':id},
            dataType:'json',
            success : function(data) { 
                $('.certificate_view').modal('hide');  
                $('#certificate'+id).find('.verified').html('Verified');
                savingalert('success','Certificate Verify Successfully');    
            }
        });
    });

    $(document).on('change','#blogsearchcat', function(){
        var vl = $(this).val();
        window.location.href='/blog?search='+vl+'';
    });

    $(document).on('keyup','#searchemail', function(){
        var search = $(this).val();
        if(search){
            $.ajax({
                url : "/getemaildata",
                type : 'GET',
                data : { 'search':search},
                dataType:'json',
                success : function(data) { 
                    $('#ajaxemail').html(data);    
                }
            });
        }
    });
});

$(document).on('click','.videomodal', function(){
    var type = $(this).attr('vtype');
    if(type == 1){
        $('#videomodalzonepage').modal({backdrop: 'static', keyboard: false}, 'show');
        $('#videomodalzonepage').modal('show');
        document.getElementById('myvideo1').play();
    }else if(type == 2){
        $('#videomodalzonepage1').modal({backdrop: 'static', keyboard: false}, 'show');
        $('#videomodalzonepage1').modal('show');
        document.getElementById('myvideo2').play();
    }else if(type == 3){
        $('#videomodalzonepage2').modal({backdrop: 'static', keyboard: false}, 'show');
        $('#videomodalzonepage2').modal('show');
        document.getElementById('myvideo3').play();
    }

});

$(document).on('click','.videomodalzonepageclose', function(){
    $('#videomodalzonepage').modal({backdrop: 'static', keyboard: false});
    $('#videomodalzonepage').modal('hide');
    $('#videomodalzonepage1').modal({backdrop: 'static', keyboard: false});
    $('#videomodalzonepage1').modal('hide');
    $('#videomodalzonepage2').modal({backdrop: 'static', keyboard: false});
    $('#videomodalzonepage2').modal('hide');
    document.getElementById('myvideo1').stop();
    document.getElementById('myvideo2').stop();
    document.getElementById('myvideo3').stop();
});    

function checkPhonebus(a){   
   var phoneno = /^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/;
   if(!a) { 
     return false;
   }
   if(a.match(phoneno)) { 
        return  true;
   }
   return false;
}

function fetchMyAccountData(type,zone_id,user_id){
    if(type){
        $.ajax({
            type: "GET",
            url: '/fetchMyAccountData',
            dataType:'json',
            data:{'type':type,'zone_id':zone_id,'user_id':user_id},
            success: function(d){
                var count = d.count;
                $('#myaccountbodyData').html(d.html);
                $("#cell_phone").mask('999-999-9999',{placeholder:' '});
                for (var i = 1; i <= count; i++) {
                    $("#phone_alternate"+i).mask('999-999-9999',{placeholder:' '});
                }
            }
        });
    }    
}
function savingalert(type = '',msg = ''){
	var msg = '<div class="alert alert-'+type+' alert-dismissible fade show" role="alert"><strong>'+msg+'</strong></button></div>';
	$('#alert_msg').html(msg).css('display','block');
	setTimeout(hidealert, 3000);
}
function hidealert(){
    $('#alert_msg').css('display','none');	
}
function check_login(username,password,logintype){
    var get_zoneid = $('#get_zoneid').val();
    var base_url = window.location.origin;
        $.ajax({
            type:"POST",
            url:'/check_login_type',
            data:{'username': username, 'loginType': logintype, 'zoneid': get_zoneid},
            dataType:'json',
            beforeSend:function(){ 
                $('div#login_loading').css('display','block');
            }, 
            success: function (data) {
                if(data == 1){
                    $.ajax({
                        url:'/login_from_zone_page',
                        type  :'POST',
                        data:{'username': username, 'password': password,'userzone' :get_zoneid},
                        dataType:'json',
                        beforeSend:function(){
                            $('#process_login').show();
                        $("#process_login").html('<h1 style="color:#fff !important;">Processing...<img id="loading1" src="<?=base_url(assets/images/loading.gif)?>" width="30" height="30" alt="loading" /></h1>'); },
                        success:function(data) { 
                            // console.log(data);
                            // return false;
                            var res = data.split('!~!');
            var condition=res[0]; var id=res[1]; 
            var redirect='';
                switch(condition){
                    case 'zone_owner':
                        $('div#login_loading').css('display','block');
                        redirect='/Zonedashboard/zonedetail/'+id;
                        // console.log(redirect); return false;
                        window.location=redirect;
                        break;
                    case 'business_owner':
                        $('div#login_loading').css('display','block');
                        redirect='/businessdashboard/businessdetail/'+id+'/'+get_zoneid;
                        // redirect = (visitorUrl.length!=0&&pageName.length!=0) ? visitorUrl : base_url+'businessdashboard/businessdetail/'+id;
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
                        https://savingssites.com/zone/my_account/213
                        // redirect = (visitorUrl.length!=0&&from_where_login==10&&pageName.length!=0) ? visitorUrl : base_url+'/zone/'+id;
                        redirect = base_url+'/zone/my_account/'+get_zoneid;
                        window.location=redirect;
                        break;
                    case 'organization':   
                        var res = data.split('!~!');
                        var zone=res[2];                  
                        redirect=base_url+'/organizationdashboard/organizationdetail/'+id+'/'+zone ;
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
        },
        'error':function(data) {
            window.location.reload();
        }
        });
                }else{
                    savingalert('danger',data);
                }
            }
        });
}
function username_verification(username = ''){
    if(username == '' || username == null || username == 'undefined' || username == undefined){
        return false;
    }
    var chk_uname=/^[A-Za-z0-9]+$/;
    var regex = new RegExp("^[a-zA-Z0-9.]*$");
    if(username != ''){
        var userame=username; 
    }else{
        var userame=$.trim($('#name').val().replace(/-/g, '')); 
    } 
    if(userame != ''){
        if(!regex.test(userame)) {
            savingalert('danger','Special characters not allowed');
            return false;
        }
        $.ajax({
            type:"GET",
            url:'/add_business_check_username',
            data:{'user_name': userame,'type':'home'},
            dataType:'json',
            success: function (res) {
                if(res=='0'){
                    savingalert('warning','This Username is not available.');
                    $('#name').val('');
                }else{
                    savingalert('success','"'+res+ '" is available.');
                }
            }
        });
    } else {
        savingalert('danger','Please specify a valid username');
        return false;
    }
}

function email_verification(emailnotice_email){ //alert(1);
    var email_pattern = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(emailnotice_email!=''){
        if(!email_pattern.test(emailnotice_email)){             
           savingalert('danger', emailnotice_email+'not follow email pattern of abcd@efg.com.');
            return false;
        }else{
            var data={'check_email':emailnotice_email,'type':'15'};
            $.ajax({
                "type":"GET",
                url:'/check_email',
                "async":false,
                'data':data,
                'success':function(result) {
                    if(result=='0'){
                        savingalert('danger', emailnotice_email+'" is not available.');
                    }else{
                        savingalert('success', emailnotice_email+ '" is available.');
                    }
                }
            });
        }
    }   
}

function getZip(){
    var zone = $('#selzone option:selected').val();
    var con = '';
    $.ajax({
        url:'/getZip',
        data:{zone:zone},
        dataType:'json',
        success: function(r){
            con += '<option value="-1">--Select Zip--</option>';
            if(r != ''){
                $.each(r,function(i,j){
                    if(i == 0){
                        con += '<option value="'+j.zip+'" selected = "selected">'+j.zip+'</option>';
                    }else{
                        con += '<option value="'+j.zip+'">'+j.zip+'</option>';
                    }
                });
                $('#selzip').html(con);
            } 
        }
    });
}

function put_name(){    
    var fname=$('#fname').val();
    var lname=$('#lname').val();    
    var fullname='';
    if(fname!='' && lname!=''){
      fullname=fname+' '+lname;
    }else if(fname==''){
      fullname=lname;
    }else if(lname==''){
      fullname=fname;
    }
    $('#fullname').val(fullname);
  }

function getZone(city = '',statecode='',id=''){
    if(statecode == ''){
        savingalert('warning','Please select a state.');
        return false;
    }
    if(city==''){
        savingalert('warning','Please select a city');
        return false;
    }
    var con = '';
    $.ajax({
        url:'/getZone',
        data:{state:statecode,city:city},
        dataType:'json',
        success: function(r){
            con += '<option value="-1">--Select Directory--</option>';
            if(r != ''){
                $.each(r,function(i,j){
                    con += '<option value="'+j.id+'">'+j.zone+'</option>';
                });
            } 
            $('#selzone').html(con);
            $('#selzip').html('<option value="-1">--Select Zip--</option>');
        }
    });
}

function getCity(state_code = '', id = '',zone_id = ''){
    var dataToUse = {'state_code':state_code};
    var con = '';
    $.ajax({
        url:'/getCity',
        data:dataToUse,
        dataType:'json',
        success: function(r){ 
            con += '<option value="-1">--Select City--</option>'; 
            if(r != ''){
                $.each(r,function(i,j){ 
                    con += '<option value="'+j.city+'">'+j.city+'</option>';
                });
            }
            $('#selcity').html(con);
            $('#selzone').html('<option value="-1">--Select Zone--</option>');
            $('#selzip').html('<option value="-1">--Select Zip--</option>');
        }
    });   
}

function checkPassword(uerror){
    var password_pattern = /^(?=.*?[a-z])(?=.*?\d)(?=.*?[\!\@\#\$\%\&]{1,})/i;  
    if($('input[name="password"]').val() == '' || $('input[name="password"]').val() == null){
        savingalert('danger','Password Field is mandatory.'); 
    }else if($('input[name="password"]').val().length < 5 || $('input[name="password"]').val().length > 18){
        savingalert('danger','Password should be between 5 to 18 characters.');
        if($('#name').val() != ''){
          $('input[name="password"]').val(null);
        }
    }else if($('input[name="password"]').val().match(password_pattern) == null){
        savingalert('danger','Password should be combination of letters ,<br> numbers and special characters(!, @, #, $, %, &).');
        if($('#name').val() != ''){ 
          $('input[name="password"]').val(null);
        }
    }else{
        savingalert('success','Password Pattern is correct.');  
    }
}

function checkEmail(mail) {
    var emailPass = true;
    var mail = jQuery(".custemail").val();
    if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(mail)){
        emailPass = true;
        $('#emailerror').html(''); 
        $('.emailsucess').val(1);
    }else{
        emailPass = false;
        savingalert('success','Your email is invalid.');
        $('.emailsucess').val(0);
    }
}


function checkPhone(){   
    var a = $('#phone_user').val();
    a = $.trim(a.replace(/\-/g, ''));
    var phoneno = /^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/;         
    if(a){
        if(!a.match(phoneno)) { 
            savingalert('danger','Not a valid Phone Number');
            $('#phone_user').val('');
        }else{
            savingalert('success','Phone number is valid.');
        }  
    } else {
        savingalert('danger','Please provide your phone no');
    }
}

function checkPhone_share(){   
    var a = $('#phone_user_share').val();
    a = $.trim(a.replace(/\-/g, ''));
    var phoneno = /^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/;
    if(a) { 
        if(!a.match(phoneno)) { 
            savingalert('danger','Not a valid Phone Number');
            $('#phone_user_share').val('');
        }else{
            savingalert('danger','Phone number is valid.');
        } 
    } else {
        $("#phone_error_share").hide();
    }
}

function checkConfirmPassword(x){
  if($('input[name="password"]').val() != $('input[name="cpassword"]').val()){
    $('#passerror').html('<span style="color:#f41525; font-weight: bold; text-align: center; margin-left: -16px;">Password and Confirm Passwords doesn\'t match.</span>');
  }
}


function hide_table(){
    val = $('#zip_code option:selected').val();
    if(val != -1){ 
      $('#new_table').hide();
    }else{
      $('#new_table').show();
    }
}

function verifyCaptcha() {
    document.getElementById('g-recaptcha-error').innerHTML = '';
}

function sign_out(){ 
    var zone_id = $('#userzone').val();
    if(zone_id == '' || zone_id == undefined){
        zone_id = $('#zone_id').val();
    }
    var type = 'business';
    savingalert('success','Your Session has expired please login, Redirecting to the zone directory page');
    $.ajax({
        type: "GET",
        url: "/auth/logout",
        data: {'type': type},
        dataType:'json',
        success: function (t) {
           window.location.href = window.location.origin;
        }
    });
}









      $('#foodModal').on('shown.bs.modal', function () {
  $('#video1')[0].play();
})
$('#foodModal').on('hidden.bs.modal', function () {
  $('#video1')[0].pause();
})

setTimeout(function() {
$('.slide_btn').click(function(e){
    e.preventDefault();
    $('.owl-next').click();
 
})

 }, 2500);


$(document).ready(function(){
  
  var tabWrapper = $('#tab-block'),
      tabMnu = tabWrapper.find('.tab-mnu  li'),
      tabContent = tabWrapper.find('.tab-cont > .tab-pane');
  
  tabContent.not(':first-child').hide();
  
  tabMnu.each(function(i){
    $(this).attr('data-tab','tab'+i);
  });
  tabContent.each(function(i){
    $(this).attr('data-tab','tab'+i);
  });
  
  tabMnu.click(function(){
    var tabData = $(this).data('tab');
    tabWrapper.find(tabContent).hide();
    tabWrapper.find(tabContent).filter('[data-tab='+tabData+']').show(); 
  });
  
  $('.tab-mnu > li').click(function(){
    var before = $('.tab-mnu li.active');
    before.removeClass('active');
    $(this).addClass('active');
   });
  
});

// homepage & zone page scroll div 
$(document).ready(function(){

var scrollToTopBtn = document.getElementById("topbar");
var rootElement = document.documentElement;

function scrollToTop() {
  rootElement.scrollTo({
    top: 480,
    behavior: "smooth"
  });
}
scrollToTopBtn.addEventListener("click", scrollToTop);

});
// find elements
var carousel = $(".carousel");

var options = {
  adaptiveHeight: true,
  arrows: true,
  dots: true,
  fade: true,
  infinite: false,
  mobileFirst: true,
  rows: 0,
  slidesToScroll: 1,
  slidesToShow: 1,
  speed: 0,
  zIndex: 75
};

var addAnimationClass = true;

carousel.on('beforeChange', function(e, slick, current, next) {
  var current = carousel.find('.slick-slide')[current];
  var next = carousel.find('.slick-slide')[next];
  var src = $(current).find('.carousel__image').attr('src');

  $(next).find('.carousel__slide__overlay').css('background-image', 'url("' + src + '")');
  
  
  if(addAnimationClass) {
    carousel.addClass('doAnimation');
    
    // so that adding the class only happens once
    addAnimationClass = false;
  }
});

carousel.not('.slick-initialized').slick(options);