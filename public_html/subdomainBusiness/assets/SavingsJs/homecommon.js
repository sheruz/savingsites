$(document).ready(function(){
    if($('#pagesidebar').val() == 'organizationdetail'){
    $('.zip_code_organization').select2({
        ajax: {
            type: 'get',
            url: '/getzipcodes',
            dataType: "json",
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data, params) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.zip,
                            id: item.zip,
                            data: item
                        };
                    })
                };
            }
        }
    });
    $('#selState').select2({
            ajax: {
                type: 'get',
                url: '/getStates',
                dataType: "json",
                data: function (params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function (data, params) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.state_name,
                                id: item.state_id,
                                data: item
                            };
                        })
                    };
                }
            }
        });
    }
    var refdealuser = $('#refdealuser').val(); 
    var referdealid = $('#referdealid').val(); 
    if(refdealuser > 0 && referdealid > 0){
        $('#refdealmodal').modal('show');
    }
    $("#loading").hide();
    $(".formError").hide();
    $('#bottom_link').show();
    var zone_id = $('#zone_id').val();
    var user_id = $('#user_id').val();
    var usergiftemail = $('#usergiftemail').val();
    var giftuserexists = $('#giftuserexists').val();
    var baseurl = window.location.origin;
    if(giftuserexists == '' && usergiftemail != ''){
        $('#emailnoticesignupform02').modal('show');  
        $('#emailnotice_email_resident').val(usergiftemail); 
    }
    fetchMyAccountData('userupdate',zone_id,user_id);
    $("#name").mask('999-999-9999',{placeholder:' '});
    $("#phone_user").mask('999-999-9999',{placeholder:' '});
    $("#cell_phone").mask('999-999-9999',{placeholder:' '});
    $("#cell_phone_resident").mask('999-999-9999',{placeholder:' '});
    $("#cell_phone_visitor").mask('999-999-9999',{placeholder:' '});
    $("#cell_phone_employee").mask('999-999-9999',{placeholder:' '});
    // $("#zoneidcsv").select2();
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
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function(data){
                console.log(data); 
                if($.trim(data)!='0'){  
                    window.location.href = '/zone/'+data ;
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

    $('.readshow').click(function(){
      $('#textshow').css("display",'block');

    });

    $("#contactpost").click(function(){
        $('#loading').css('visibility','visible');
        $('#loading').css('visibility','hidden');
        var name=$('#fullname').val();
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
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
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

   $(document).on('click','.more_benifit', function(){
    //alert('hhe'); left work
    $('#more_benifitimg').toggleClass('show');
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
        var gender = $('#gender').val();
        var fullname = $('#fullname').val(); 
        var sic_code = $('#sic_code').val();
        var phone = $('#phone_user').val();
        var website = $('#website').val();
        var refer_email = $('#referrer_email').val();
        var refer_phone = $('#referrer_phone').val();
        var refer_code = $('#refer_code').val();
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
        var  phone_share ="";
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
            $('#save_user').prop('disabled', false);
            return false;
        }
        if(name !=""){
             $('#save_user').prop('disabled', true);
            $.ajax({
                type:"POST",
                url:'/profile_update',
                data:{'id': id, 'account_type': account_type,'zone': zone, 'name': name,'password': password, 'company_name':company_name ,'motto': motto, 'uemail': uemail,'fname': fname, 'lname': lname, 'fullname': fullname, 'phone': phone,'user_address': user_address,'user_address2':user_address2,'city': city,'state': state, 'zip': zip, 'user_city':user_city, 'user_state':user_state , 'user_zip':user_zip , 'refer_code':refer_code, 'userid_for_registration':userid_for_registration,'refer_choice':refer_choice,'refer_email':refer_email,'refer_phone':refer_phone, 'website':website, 'zone_owner':zone_owner,'selZone':zoneId, 'bemail':bemail, 'phone_share':phone_share,'alternate_phone':alternate_phone,'restaurant_type':restaurant_type,'postalcode':postalcode,'gender': gender},
                dataType:'json',
                beforeSend : function(){
                    $('#loading').css('display','block');
                },
                complete: function() {
                    $('#loading').css('display','none');
                },
                success: function (data) {
                    $('#save_user').prop('disabled', false);
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

    $(document).on('click','#save_sponsor_user', function(){
        alert("here");
        var refer_choice = '';
        var refer_email = '';
        var refer_phone = '';
        var refer_code = '';
        var id=-1;
        var account_type = '';
        var fname = $('#fname').val(); 
        var lname = $('#lname').val();
        var uemail = $('#uemail').val();
        var phone = $('#phone_user').val();
        var gender = $('#gender').find("option:selected").val();
        var selstate = $('#selstate').find("option:selected").val();
        var selcity = $('#selcity').find("option:selected").val();
        var user_address  = $('#sponser_user_address').val();
        var username = $('#sponserusername').val(); 
        var postalcode = $('#postalcode').val();
        var password = $('#password').val(); 
        var cpassword = $('#cpassword').val(); 
        var zone = $('#get_zoneid').val();

       
     
       
       
      
      
        if(fname == '' || lname == '' || uemail == '' || phone == '' || gender == '' || user_address == '' || username == '' || postalcode == '' || password == '' || cpassword == ''){
            savingalert('warning','Please fill all required fields.');
            return false;  
        }
        if(password != cpassword){
            savingalert('warning','Password and confirm password must be same.');
            return false; 
        }

        $('#save_user').prop('disabled', true);
        $.ajax({
            type:"POST",
            url:'/sponsor_profile_update',
            data:{id,account_type,fname,lname,uemail,phone,gender,user_address,username,postalcode,selstate,selcity,password,zone},
            dataType:'json',
            beforeSend : function(){$('#loading').css('display','block');},
            complete: function() {$('#loading').css('display','none');},
            success: function (data) {
                    $('#save_user').prop('disabled', false);
                    if(data.type == 'warning'){
                        savingalert('warning',data.msg);
                    }else{
                        $(".required-div").hide();
                        $("#registration-form").hide('slow').after(data);
                    }
                }
            });

        
          
       
        
        
        
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
        var baseurl = window.location.origin;
     
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
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function (d) {

                savingalert(d.type,d.msg);
                if (d.type == 'success') {
                    window.location.href = base_url;
                }
 
 
            }
        });
    });
 approvedbusiness();
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
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function(data){
                if(data.msg == 'Success'){
                    $(".response_mssg").css({"color":"green"});
                    $(".response_mssg").html("Thank you for submitting your reset request. A reset code should be emailed to the email address you registered under.");
                }else if(data.msg == 'Failed'){
                    $(".response_mssg").css({"color":"red"});
                    $(".response_mssg").html("Sorry! Unable to get your request. Please put valid Username/Email/Phone.");
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
           $('#emailnoticesignupform02').modal('show');
        }else if(link == 'business_registration'){
            window.location.href = '/home/business_registration_authentication/'+zone_id;
        }else if(link == 'organization_registration'){
            window.location.href = '/home/organization_registration/'+zone_id;
        }else if(link == 'employee_registration'){
           $('#employee_registration').modal('show');
        }else if(link == 'visitor_registration'){
           $('#visitor_registration02').modal('show');
        }else if(link == 'sponsor_registration'){
            window.location.href = '/sponsor_registration/'+zone_id;
        }
    }); 

    $(document).on('click','.showdropdown',function(){
        $(this).addClass('show');
      $('.showdropdown .dropdown-menu-right').toggleClass('show');  
    });   

    $(document).on('click','.loginTextChange1', function(){
        $('.dropdown-menu-right').removeClass('show');
        $('#refdealmodal').css('display','none');
        var id = $(this).attr('title');
        if(id == 'neighbour_login'){
            $('#username_label_name').html('User Name/Email address used when registering');
            $('#login_type_name').html('Residents Login');
            $('#subuserlogin').addClass('hide');
            $('#login_type_name').attr('loginType', 10);
            $('#forgot_password_limk').html('<a href="/get_forgot_password/10">Forgot your password?</a><br />');
            $('#login-box').modal('show');
        }else if(id == 'businesses_login'){
            $('#username_label_name').html('User Phone Number used when registering');
            $('#login_type_name').attr('loginType', 5);
            $('#subuserlogin').addClass('hide');
            $('#forgot_password_limk').html('<a href="/get_forgot_password/5">Forgot your password?</a><br />');
            $('#login_type_name').html('Businesses Login');
            $('#login-box').modal('show');    
        }else if(id == 'organisations_login'){
            $('#username_label_name').html('User Name/Email address used when registering');
            $('#login_type_name').attr('loginType', 8);
            $('#subuserlogin').addClass('hide');
            $('#forgot_password_limk').html('<a href="/get_forgot_password/8">Forgot your password?</a><br />');
            $('#login_type_name').html('Organizations Login');
            $('#login-box').modal('show');
        }else if(id == 'employee_login'){
            $('#login_type_name').html('Employee Login');
            $('#login_type_name').attr('loginType', 15);
            $('#subuserlogin').addClass('hide');
            $('#forgot_password_limk').html('<a href="/get_forgot_password/15">Forgot your password?</a><br />');
            $('#username_label_name').html('User Name:');
            $('#login-box').modal('show');
        }else if(id == 'visitor_login'){
            $('#login_type_name').html('Visitor Login');
            $('#login_type_name').attr('loginType', 7);
            $('#subuserlogin').addClass('hide');
            $('#forgot_password_limk').html('<a href="/get_forgot_password/7">Forgot your password?</a><br />');
            $('#username_label_name').html('User Name:');
            $('#login-box').modal('show');
        }else if(id == 'publisher_login'){
            $('#login_type_name').html('Publisher Login');
            $('#login_type_name').attr('loginType', 4);
            $('#subuserlogin').removeClass('hide');
            $('#forgot_password_limk').html('<a href="/get_forgot_password/4">Forgot your password?</a><br />');
            $('#username_label_name').html('User Name:');
            $('#login-box').modal('show');
        }else if(id == 'sponsor_login'){
            $('#username_label_name').html('User Name used when registering');
            $('#login_type_name').html('Sponsor Login');
            $('#subuserlogin').addClass('hide');
            $('#login_type_name').attr('loginType', 17);
            $('#forgot_password_limk').html('<a href="/get_forgot_password/17">Forgot your password?</a><br />');
            $('#login-box').modal('show');
        }
    });

    $(document).on('click','.loginTextChange2', function(){
        $('#login-box').modal('hide');
        $('#login_type_name').html('Publisher Manager Login');
        $('#login_type_name').attr('loginType', 16);
        $('#forgot_password_limk').html('<a href="/get_forgot_password/4">Forgot your password?</a><br />');
        $('#username_label_name').html('User Name:');
        $('#subuserlogin').addClass('hide');
        $('#login-box').modal('show');
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

    $("form#ratingsignupForms_employee").on( "submit", function( event ) {

        var username = $('#emailnotice_username_employee').val();
        var email = $('#emailnotice_email_employee').val();
        var phone = $('#emailnotice_phone_employee').val();
        var additionalDelivery = $('#additionalDelivery_employee').val();
        var cell_phone = $('#cell_phone_employee').val();
        var emailnotice_password = $('#emailnotice_password_employee').val();
        var retype_password = $('#retype_password_employee').val();
        var first_name = $('#first_name_employee').val();
        var last_name = $('#last_name_employee').val();
        var refer_code = $('#refer_code').val();
        var zone_id = $('#zone_id').val();
        var userID;
        event.preventDefault();
        


        if(username == '' || username == undefined || username == 'undefined' || username == 'null' || username == null){
            savingalert('warning','Enter Username');
            return false;   
        }
        if(email == '' || email == undefined || email == 'undefined' || email == 'null' || email == null){
            savingalert('warning','Enter Email');
            return false;   
        }
        if(emailnotice_password == '' || emailnotice_password == undefined || emailnotice_password == 'undefined' || emailnotice_password == 'null' || emailnotice_password == null){
            savingalert('warning','Enter Password');
            return false;   
        }
        if(retype_password == '' || retype_password == undefined || retype_password == 'undefined' || retype_password == 'null' || retype_password == null){
            savingalert('warning','Enter Re-type Password');
            return false;   
        }
        if(emailnotice_password != retype_password){
            savingalert('warning','Password and Re-type Password Must be Same');
            return false;    
        }
        if(first_name == '' || first_name == undefined || first_name == 'undefined' || first_name == 'null' || first_name == null){
            savingalert('warning','Enter First Name');
            return false;   
        }
        if(last_name == '' || last_name == undefined || last_name == 'undefined' || last_name == 'null' || last_name == null){
            savingalert('warning','Enter Last Name');
            return false;   
        }
        var serializedata=$('form#ratingsignupForms_employee').serializeArray();
        
        $.ajax({
            'type':'POST',
            'url' :'/employeenoticeinsertdata',
            'data':serializedata,
            'dataType': "json",
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            'success': function(result) { 
                if(result.type == 'warning'){
                    savingalert(result.type,result.msg);
                    return false;    
                }else{
                    savingalert(result.type,result.msg);  
                    location.reload();
                    return false;
                }
                
            }
        });
    });

    $("form#ratingsignupForms_visitor").on("submit", function( event ) {
        var username = $('#emailnotice_username_visitor').val();
        var email = $('#emailnotice_email_visitor').val();
        var phone = $('#emailnotice_phone_visitor').val();
        var cell_phone = $('#cell_phone_visitor').val();
        var emailnotice_password = $('#emailnotice_password_visitor').val();
        var retype_password = $('#retype_password_visitor').val();
        var first_name = $('#first_name_visitor').val();
        var last_name = $('#last_name_visitor').val();
        var refer_code = $('#refer_code').val();
        var zone_id = $('#zone_id').val();
        var userID;
        event.preventDefault();
        
        if(username == '' || username == undefined || username == 'undefined' || username == 'null' || username == null){
            savingalert('warning','Enter Username');
            return false;   
        }
        if(email == '' || email == undefined || email == 'undefined' || email == 'null' || email == null){
            savingalert('warning','Enter Email');
            return false;   
        }
        if(emailnotice_password == '' || emailnotice_password == undefined || emailnotice_password == 'undefined' || emailnotice_password == 'null' || emailnotice_password == null){
            savingalert('warning','Enter Password');
            return false;   
        }
        if(retype_password == '' || retype_password == undefined || retype_password == 'undefined' || retype_password == 'null' || retype_password == null){
            savingalert('warning','Enter Re-type Password');
            return false;   
        }
        if(emailnotice_password != retype_password){
            savingalert('warning','Password and Re-type Password Must be Same');
            return false;    
        }
        if(first_name == '' || first_name == undefined || first_name == 'undefined' || first_name == 'null' || first_name == null){
            savingalert('warning','Enter First Name');
            return false;   
        }
        if(last_name == '' || last_name == undefined || last_name == 'undefined' || last_name == 'null' || last_name == null){
            savingalert('warning','Enter Last Name');
            return false;   
        }
        var serializedata=$('form#ratingsignupForms_visitor').serializeArray();
        
        $.ajax({
            'type':'POST',
            'url' :'/visitornoticeinsertdata',
            'data':serializedata,
            'dataType': "json",
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            'success': function(result) { 
                if(result.type == 'warning'){
                    savingalert(result.type,result.msg);
                    return false;    
                }else{
                    savingalert(result.type,result.msg);  
                location.reload();
                return false;
                }
            }
        });
    });
    
    $("form#ratingsignupForm_resident").on( "submit", function( event ) {
        var first_name = $('#first_name_resident').val();
        var last_name = $('#last_name_resident').val();
        var username = $('#emailnotice_username_resident').val();
        var email = $('#emailnotice_email_resident').val();
        var postal = $('#postal_address_resident').val();
        var additionaldelivery = $('#additionalDelivery_resident').val();
        var address = $('#street_address_resident').val();
        var city = $('#city_resident').val();
        var state = $('#state_resident').val();
        var zip = $('#zip_code_resident').val();
        var telephone = $('#telephone_resident').val();
        var telephone = $('#telephone_resident').val();
        var cell_phone = $('#cell_phone_resident').val();
        var password = $('#emailnotice_password_resident').val();
        var retype_password = $('#retype_password_resident').val();
        var refer_code = $('#refer_code_resident').val();
        var zone_id = $('#zone_id').val();
        var usergiftemail = $('#usergiftemail').val();
        var userID;
        event.preventDefault();
        
        if (!$('#gendervalue').val()) {
            savingalert('warning', 'Please select a gender');
            return;
        } else {
            var gender = $('#gendervalue').val();
        }


        if(first_name == '' || first_name == undefined || first_name == 'undefined' || first_name == 'null' || first_name == null){
            savingalert('warning','Enter First Name');
            return false;   
        }
        if(last_name == '' || last_name == undefined || last_name == 'undefined' || last_name == 'null' || last_name == null){
            savingalert('warning','Enter Last Name');
            return false;   
        }

        if(username == '' || username == undefined || username == 'undefined' || username == 'null' || username == null){
            savingalert('warning','Enter Username');
            return false;   
        }
        if (username.length > 12 || username.length < 6  ) {
            savingalert('warning','Username must be between 6-12 characters');
            return false;

        }
        if(email == '' || email == undefined || email == 'undefined' || email == 'null' || email == null){
            savingalert('warning','Enter Email');
            return false;   
        }
        if(postal == '' || postal == undefined || postal == 'undefined' || postal == 'null' || postal == null){
            savingalert('warning','Enter Postal');
            return false;   
        }
        if(address == '' || address == undefined || address == 'undefined' || address == 'null' || address == null){
            savingalert('warning','Enter Address');
            return false;   
        }
        if(city == '' || city == undefined || city == 'undefined' || city == 'null' || city == null){
            savingalert('warning','Enter City');
            return false;   
        }
        if(state == '' || state == undefined || state == 'undefined' || state == 'null' || state == null){
            savingalert('warning','Enter state');
            return false;   
        }
        if(zip == '' || zip == undefined || zip == 'undefined' || zip == 'null' || zip == null){
            savingalert('warning','Enter zip');
            return false;   
        }
        if(cell_phone == '' || cell_phone == undefined || cell_phone == 'undefined' || cell_phone == 'null' || zip == null){
            savingalert('warning','Enter Phone');
            return false;   
        }



        if(password == '' || password == undefined || password == 'undefined' || password == 'null' || password == null){
            savingalert('warning','Enter Password');
            return false;   
        }
        if(retype_password == '' || retype_password == undefined || retype_password == 'undefined' || retype_password == 'null' || retype_password == null){
            savingalert('warning','Enter Re-type Password');
            return false;   
        }
        if(password != retype_password){
            savingalert('warning','Password and Re-type Password Must be Same');
            return false;    
        }

        // if(gender == '' || gender == undefined || gender == 'undefined' || gender == 'null' || first_name == null){
        //     savingalert('warning','Select Gender');
        //     return false;   
        // }
        var serializedata=$('form#ratingsignupForm_resident').serializeArray();
        var refdealuser = $('#refdealuser').val();
        $.ajax({
            'type':'POST',
            'url' :'/emailnoticeinsertdata',
            'data':serializedata,
            'dataType': "json",
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            'success': function(result) { 
                if(result.type == 'warning'){
                    savingalert(result.type,result.msg);
                    return false;    
                }
                if(result !=''){
                    if(refdealuser > 0){
                        get1dealtouser(refdealuser,username,10);
                    }
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
                        var origin   = window.location.origin;
                        if(origin == 'https://peekabooauctions.com'){
                            // $("#login-box").modal("show");
                            $("#ratingsignupForms_visitor .close").click();
                        }else{
                            document.cookie = "register=first";
                            window.location.href =  origin;
                            return false;
                        }
                    }
                }
        });
    });
    $(document).on('click','#header_login', function(){
        var username = $('#login_email').val();   
        var password = $('#login_password').val();
        var logintype = $('#login_type_name').attr('loginType');  
        var baseurl = window.location.origin;
        if(logintype == 16){
            check_login_sub_user(username,password,baseurl); 
        }else{
            check_login(username,password,logintype); 
        }
    });

    $(document).on('click','.zoneMyAccount', function(){
        $('.zoneMyAccount').removeClass('active');
        $(this).addClass('active');
        var type = $(this).attr('type');
        var zone_id = $('#zone_id').val();
        var user_id = $('#user_id').val();
        if(type == 'editsubscribebusiness'){
            fetchMyAccountDataedit(type,zone_id,user_id);
        }else{
            fetchMyAccountData(type,zone_id,user_id);
        }
    });
    
    $(document).on('click','.profile_update',function(){
        var alphone = [];
        var id = $(this).attr('data-id');
        var fn=$('#fn_pro').val();
        var ln=$('#ln_pro').val();
        var res_gen=$('#res_gen').val();
        var phone = $('#cell_phone').val();
        var carrier = $('#carrier').val();       
        var res_email = $('#res_email').val();       
        var res_address = $('#res_address').val();       
        var res_state = $('#res_state').val();       
        var res_city = $('#res_city').val();       
        var res_zip = $('#res_zip').val();       
        $(".phone_alternate").each(function() {
          alphone.push($(this).val());
        });  
        
        $.ajax({
            type: "POST",
            url: '/myaccount_update',
            data:{'id':id,'fn':fn,'ln':ln,'res_gen':res_gen,'phone':phone,'carrier':carrier,'alternatephone':alphone,'res_email':res_email,'res_address':res_address,'res_state':res_state,'res_city':res_city,'res_zip':res_zip},
            dataType:'json',
            cache: false,
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function(d){
                savingalert(d.type,d.msg);
                // $('#success').show();
                // $('#success').text(data);
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
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
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
        var userid =       $(this).attr('userid');
        var zoneid =       $(this).attr('zoneid');
        var busid =        $(this).attr('busid');
        var deaid =        $(this).attr('deaid');
        var alldata =      $(this).attr('alldata');
        var creditStatus = $(this).attr('creditStatus');
        var usedcert =     $(this).attr('usedcert');
        var token = '<?php time(); ?>';
        var base_url = window.location.origin;
        var giftemail = $('#giftemail').val();
        
        var baseurl123 = base_url+'/thankyou/'+zoneid+'?UserId='+userid+'&Amount=0&creditStatus='+creditStatus+'&AucId='+deaid+'&busid='+busid+'&zoneid='+zoneid+'&usedcert='+usedcert+'&'+alldata;
        window.location.href =  baseurl123;
    });
    
    $(document).on('blur','#giftemail', function(){
        var giftemail = $(this).val();
        var returndata = $("input[name=return]").val();
        
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var validate = regex.test(giftemail);
        if(giftemail != ''){
            if(validate != true){
                savingalert('warning','Invalid Email Address');
                $('input[type=image]').css('display','none');
                return false;   
            }else{
                $('input[type=image]').css('display','block');
                var newreturndata = returndata+'&giftemail='+giftemail;
                $("input[name=return]").val(newreturndata);
                return false;   
            }
        }else{
            $('input[type=image]').css('display','block');  
        }
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
                beforeSend : function(){
                    $('#loading').css('display','block');
                },
                complete: function() {
                    $('#loading').css('display','none');
                },
                success:function(response)  { 
                    var res = response.split('!~!');
                    var condition=res[0]; 
                    var id=res[1];
                    if (condition=='business_owner') {
                        if (passfrom=="pbg"){
                            $("#pbgpayment").submit();
                        }else{
                            // updateBusinessInformation(id);
                            // window.location.href='<?=base_url('businessdashboard/')?>/'+id ;
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
        var textToCopy = $('#referlinktext').val();
        var tempTextarea = $('<textarea>');
        $('body').append(tempTextarea);
        tempTextarea.val(textToCopy).select();
        document.execCommand('copy');
        tempTextarea.remove();
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
                beforeSend : function(){
                    $('#loading').css('display','block');
                },
                complete: function() {
                    $('#loading').css('display','none');
                },
                success:function(r){
                    savingalert('success','Email send Successfully');
                }
            });
        }
    });

    $(document).on('click', '#generateQRemail', function(){
        var email = $('#qremail').val();
        var user_id = $('#user_id').val();
        var type = 'link_refer_mail';
        var code = $('.refertext').text();
        if(email != ''){
            $.ajax({
                'url' :'/qr_generate_email',
                'type':'POST',
                'data':{'email':email,'user_id':user_id,'code':code},
                'dataType':'json',
                beforeSend : function(){
                    $('#loading').css('display','block');
                },
                complete: function() {
                    $('#loading').css('display','none');
                },
                success:function(r){
                    savingalert('success','Email send Successfully');
                }
            });
        }
    });

    $(document).on('click', '#validatesubmit', function(){
        var user = $('#validateusername').val();
        var pass = $('#validatepassword').val();
        var userid = $("#userqrid").val();
        var userqrfname = $("#userqrfname").val();
        var userqrlname = $("#userqrlname").val();
        var zoneqrId = $("#zoneqrId").val();
        var base_url = window.location.origin;
        if(user != '' && pass != ''){
            $.ajax({
                'url' :'/validateqrbusiness',
                'type':'POST',
                'data':{'user':user,'pass':pass},
                dataType:'json',
                beforeSend : function(){
                    $('#loading').css('display','block');
                },
                complete: function() {
                    $('#loading').css('display','none');
                },
                success:function(r){
                    if(r.type == 'success'){
                        var html = '<a href='+base_url+'/approvalstatus?userid='+userid+'&userfname='+userqrfname+'&userlname='+userqrlname+'&businessid='+r.busid+'&businessname='+r.business_name+'&status=A&zoneId='+zoneqrId+'&via=QR&click=1" style="color: #fff;text-align: center;margin: 0 auto;width: 236px;display: block;position: relative;top: -17px;text-decoration: none;font-size: 26px;font-weight: 700;background: #15c;padding: 10px;border-radius: 4px;margin-top:40px;float:left;">Approve</a>';
                        html += '<a href='+base_url+'/approvalstatus?userid='+userid+'&userfname='+userqrfname+'&userlname='+userqrlname+'&businessid='+r.busid+'&businessname='+r.business_name+'&status=N&zoneId='+zoneqrId+'&via=QR&click=1" style="color: #fff;text-align: center;margin: 0 auto;width: 236px;display: block;position: relative;top: -17px;text-decoration: none;font-size: 26px;font-weight: 700;background: red;padding: 10px;border-radius: 4px;margin-top:40px;float:left;">Reject</a>';
                        $('#buttondiv').html(html);
                        $('#approverejectbutton').removeClass('hide');
                        $('#buttondiv').removeClass('hide');
                    }else{

                    $('#buttondiv').addClass('hide');
                    }
                }
            });
        }
    });

    $(document).on('click', '#generateQR', function(){
        var qrtext = $('#qrtext').val();
        if(qrtext != ''){
            $.ajax({
                'url' :'/genQR',
                'type':'POST',
                'data':{'qrtext':qrtext},
                beforeSend : function(){
                    $('#loading').css('display','block');
                },
                complete: function() {
                    $('#loading').css('display','none');
                },
                success:function(r){
                    savingalert('success','Email send Successfully');
                }
            });
        }
    });

    $(document).on('keyup','#searchemail', function(){
        $('#ajaxemailss').html('');
        var search = $(this).val();
        if(search){
            $.ajax({
                url : "/getemaildata",
                type : 'GET',
                data : { 'search':search},
                success : function(data) { 
                    console.log(data);
                    $('#ajaxemailss').html(data);    
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
            data : { id : $(this).attr('data-productid'), purchaseID: $(this).attr('data-porchaseid') , zoneid:zoneid,userid:userid, via: $(this).attr('dealtype') },
            dataType:'json',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
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
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success : function(data) { 
                $('.certificate_view').modal('hide');  
                $('#certificate'+id).find('.verified').html('Verified');
                savingalert('success','Certificate Verify Successfully');    
            }
        });
    });

    $(document).on('click', '.dontshowmodalfree5', function(){
        var userid = $('#user_id').val();
        $.ajax({
            type:'POST',
            url:'/dontshowmodalfree5',
            data:{'userid':userid},
            dataType:'json',
            cache:'false',
            success: function(r){
                $("#myModal").modal("show");
            }
        });   
    });

    $(document).on('click', '.singlelogin', function(){
        var phone = $(this).attr('phone');   
        var email = $(this).attr('email');   
        var group = $(this).attr('group');  
        var baseUrl = window.location.origin; 
        $.ajax({
            'type':'GET',
            'url':'/singleloginmultiuser',
            'data':{'phone':phone,'email':email,'group':group},
            'dataType':"json",
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },            
            'success': function(r) {
                if(r.type == 'success'){
                    if(group == 5){
                        redirect=baseUrl+'/businessdashboard/'+r.id+'/businessdetail';
                    }
                    if(group == 8){
                        redirect=baseUrl+'/organizationdashboard/'+r.id+'/';
                    }
                    if(group == 10 || group == 7 || group == 15){
                        redirect=baseUrl+'/my_account/';
                    }
                    window.location=redirect;
                } 
            }
        });
    });



    $(".sidebar-dropdown > a").click(function() {
  $(".sidebar-submenu").slideUp(200);
  if (
    $(this)
      .parent()
      .hasClass("active")
  ) {
    $(".sidebar-dropdown").removeClass("active");
    $(this)
      .parent()
      .removeClass("active");
  } else {
    $(".sidebar-dropdown").removeClass("active");
    $(this)
      .next(".sidebar-submenu")
      .slideDown(200);
    $(this)
      .parent()
      .addClass("active");
  }
});
    
    $(document).on('click','.showfree5info', function(){
        $("#free5modal").modal("show");
    });

    $(document).on('click','.bv_contact_btn', function(){
        var baseurl = window.location.origin;
        $.ajax({
            'type':'GET',
            'url':'/getcontactdetail',
            'data':{'baseurl':baseurl},
            'dataType':"json",       
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },    
            'success': function(r) {
                var html = '<p>Name: <strong>'+r.firstname+' '+r.lastname+'</strong></p><p>Email: <strong><a href="mailto:'+r.email+'">'+r.email+'</a></strong></p>';
                $('#contactmodal').html(html);
            }
        });
    });

    $(document).on('click','.booksnapatable', function(){
        var recieveruser = $(this).attr('snapuserid');
        var snapbusid = $(this).attr('snapbusid');
        var snapzoneid = $(this).attr('snapzoneid');
        var snapdayid = $(this).attr('dayid');
        var snapstarttimeid = $(this).attr('starttimeid');
        var snapendtimeid = $(this).attr('endtimeid');
        var snapnoofpeopleid = $(this).attr('noofpeopleid');
        var snapsendtypeid = $(this).attr('snapsendtypeid');
        var $this = $(this);
        $.ajax({
            type:"POST",
            data:{recieveruser,snapbusid,snapzoneid,snapdayid,snapstarttimeid,snapendtimeid,snapnoofpeopleid,snapsendtypeid},                 
            url: '/confirm_business_snap_filter',      
            dataType: 'json',
            success: function(data){  
                if(data.type == 'warning'){
                    savingalert(data.type,data.msg);
                }else{
                    $this.remove();
                    savingalert(data.type,data.msg);
                    
                    setTimeout(function() {
                       window.location.href = data.url;
                    },2000); 
                }
            }
        });
    });
});

$('#mainSlider').nivoSlider({
        directionNav: true,
        animSpeed: 500,
        slices: 18,
        pauseTime: 900000,
        pauseOnHover: false,
        controlNav: true,
        prevText: '<i class="fa fa-angle-left nivo-prev-icon"></i>',
        nextText: '<i class="fa fa-angle-right nivo-next-icon"></i>'
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

$(document).on('click','.commonzoneorg', function(){
    var ids = $(this).attr('ids');
    $('.commonzoneorg').removeClass('zonetabheader');
    $('.commonzoneorg').addClass('zonetabheadern');
    $(this).removeClass('zonetabheadern');
    $(this).addClass('zonetabheader');
    $('#municipality').addClass('hide');
    $('#school').addClass('hide');
    $('#nonprofit').addClass('hide');
    $('#entertainment').addClass('hide');
    $('#'+ids).removeClass('hide');
});

$(document).on('keyup','#filter', function(){
    var ids = '';
    if (!$('#municipality').hasClass("hide")) {
        ids = 'municipality';
    }else if (!$('#school').hasClass("hide")) {
        ids = 'school';
    }else if (!$('#nonprofit').hasClass("hide")) {
        ids = 'nonprofit';
    }else if (!$('#entertainment').hasClass("hide")) {
        ids = 'entertainment';
    }
    var filter = $(this).val(),
    count = 0;
    $('#'+ids+' div ul li').each(function(index, value) {
        if ($(this).text().search(new RegExp(filter, "i")) < 0) {
            $(this).hide();
        } else {
          $(this).show();
          count++;
        }
    });
});

$(document).ready(function(){
    $('#show-allcats').on('change', function() {
        var getselect=$(this).find("option:selected").text();
        $('#showallemailblog').css('display','none');
        var orgArr = [];
        $('#showallemailblog .showalldataa').each(function(){
            var withemail=$(this).text();
            if(withemail != ''){
            var myArray = withemail.split(".");
            var orgArry = myArray[1];
            var myArray1 = orgArry.split("@");
            inArrayorg=myArray1[0];
            orgArr.push(inArrayorg);
            }
        });
        if(orgArr.length > 0){
          // console.log(orgArr);
            $.each(orgArr, function (k, orgv) {
                showlistdata('municipality', orgv);
                showlistdata('school', orgv);
                showlistdata('nonprofit', orgv);
                showlistdata('entertainment', orgv);
            });
        }
        $('.municipalityexists').removeClass('notexists')
        $('.schoolexists').removeClass('notexists')
        $('.nonprofitexists').removeClass('notexists')
        $('.entertainmentexists').removeClass('notexists')
  });
});

function approvedbusiness(){
    var userid_s = $('#user_id').val();
    var html = '';
    $.ajax({
        type:'GET',
        url:'/approvalcheck',
        data:{'userid_s':userid_s},
        dataType:'json',
        cache:'false',
        success: function(r){
            if(r.length > 0){
                $(r).each(function(k,v){
                    html += '<tr>'; 
                    html += '<td>'+v.businessname+'</td>'; 
                    html += '<td>Approved</td>'; 
                    html += '</tr>'; 
                });
                $('#visitid').html(html);
                $("#myModal").modal("show");    
            }
        }
    });
}

function showlistdata(id, orgv){
    count = 0;
    $('#'+id+' div ul li').each(function(index, value) {
        if ($(this).text().search(new RegExp(orgv, "i")) < 0) {
            $(this).addClass('notexists');
        } else {
            $(this).addClass(id+'exists');
            count++;
        }
    });
}

$("form#ratingsignupForms" ).on( "submit", function( event ) {
    email_verification($('#emailnotice_email').val());
    username_verification1($('#emailnotice_username').val());    
    var error='';
    var error_checkboxmsg = '';
    if($('#usernamevalidation').val()==0 || $('#usernamevalidation').val()==false){
        if($('#usernamevalidation').val()==false)
            error+=""+$('#emailnotice_username').val()+" must be between 3-12 characters.<br/>";
        else    
            error+=""+$('#emailnotice_username').val()+" username is not available.<br/>";
    }else{
        error+='';
    }

    if($('#emailvalidation').val()==0 || $('#emailvalidation').val()==false){
        if($('#emailvalidation').val()==false)
            error+=""+$('#emailnotice_email').val()+"  not follow email pattern of abcd@efg.com..<br/>";
        else
            error+=""+$('#emailnotice_username').val()+" email is not available.<br/>"; 
    }else{
        error+='';
    }
    
    if($('#emailnotice_password').val()!=$('#retype_password').val()){
        error+='Password did not match.<br/>';
    }else{
        error+='';
    }   
    
    if($("input[name=resident_accept]:checked").val() == 'accepted') {
        if($("#age_residentuser option:selected").val() == ''){
            error+='Please select age value.<br/>';
            $( "#age_residentuser" ).addClass( "error_border" );
        }else{
            $( "#age_residentuser" ).removeClass( "error_border" );
            error+='';
        }
        
        if($("#resident_gender option:selected").val() == '') {
            error+='Please select renter info.<br/>';
            $( "#resident_gender" ).addClass( "error_border" );
        }else{
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
    
    if(error!=''){
        $('#error').show();
        $('#error').html(error).css({'color':'#f41525'});
        return false;
    }else{
        //return false;     
        $('#error').hide();
        event.preventDefault();
        var serializedata=$('form#ratingsignupForms').serializeArray(); 
        // console.log(serializedata , 'serializedata');
        var userID;
        
        $.ajax({
            'type':'POST',
            'url':base_url+"emailnotice/employeenoticeinsertdata",
            'data':serializedata,
            'dataType':"json",
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },            
            'success': function(result) { 
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
                    $('#emailnoticesignupform').hide();
                    var origin   = window.location.origin;
                    if(origin == 'https://peekabooauctions.com'){
                        $("#login-box").modal("show");
                        $("#emailnoticesignupform .close").click();
                    }else{
                        document.cookie = "register=first";
                        location.reload();
                        return false;
                    }
                }
            }
        });
    }
});

$(document).on('click','.daycheckall', function(){
    if($(this).is(':checked') == true){
        $('.daycheck').prop('checked', true);
        $('.daychecknot').prop('checked', false);
        $('#buisnesssnap').prop('disabled', false);
    }else{
        $('.daycheck').prop('checked', false);
    }
});

$(document).on('click','.daychecknot', function(){
    if($(this).is(':checked') == true){
        $('.daycheck').prop('checked', false);
        $('#buisnesssnap').prop('disabled', true);
        $('#subcatdiv').html('');
        $('.daycheckall').prop('checked', false);
        var html = 'You are click on no fav food , are you sure to click on submit button and updated deals are not notified when its launch.';
        $('#subcatdiv').html(html);

    }
});    

$(document).on('change','#buisnesssnap', function(){
    var type = 'subscribebusiness';
    var zone_id = $('#zone_id').val();
    var user_id = $('#user_id').val();
    var catval = $(this).val();
    var day = [];
    var allday = $('.daycheckall').is(':checked');
    var notday = $('.daychecknot').is(':checked');
    if(notday == true){

    }else{
        if(allday == true){
            day.push(8);
        }else{
            var day = [];
            $(".daycheck").each(function() {
                if($(this).is(':checked') == true){
                    day.push($(this).attr('dayid'));
                }
            });  
        }
        if(day.length <= 0){
            savingalert('warning','Please Select Atleast One Day');
            return false;
        }
        fetchMyAccountData(type,zone_id,user_id,catval,day);
    }
});

$(document).on('click','.savesubcatdeals', function(){
    var day = [];
    var subcatArr = [];
    var catval = $('#buisnesssnap').val();
    var user_id = $('#user_id').val();
    var zone_id = $('#zone_id').val();
    if($('.daycheckall').is(':checked') == true){
        day.push(8);
    }else if($('.daychecknot').is(':checked') == true){
        day.push(9);
    }else{
        $(".daycheck").each(function() {
            if($(this).is(':checked') == true){day.push($(this).attr('dayid'));}
        });    
    }
    $(".subcatcheck").each(function() {
        if($(this).is(':checked') == true){subcatArr.push($(this).attr('subcatidcheck'));}
    });

    $.ajax({
        url : "/savesubcatbusiness",
        type : 'GET',
        data : {'user_id':user_id,'day':day,'catval':catval,'subcatArr':subcatArr,'zone_id':zone_id},
        dataType:'json',
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },
        success : function(d) { 
            savingalert(d.type,d.msg);
            window.location.reload();    
        }
    });
});

$(document).on('click','.snapchangestatus',function(){
    var snapid = $(this).attr('ids');
    var types = $(this).attr('types');
    var $this = $(this);
    if(types == 'inactive'){var msg = 'IN-Active';}
    else{var msg = 'Active';}
    $.ajax({
        url : "/changesnapstatus",
        type : 'POST',
        data : {'snapid':snapid,'types':types},
        dataType:'json',
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },
        success : function(d) { 
            savingalert(d.type,d.msg);  
            $this.closest('tr').find('.storedstatus').html(msg); 
        }
    });
});

function check_login_sub_user(username,password,url,baseurl){
    var baseurl = window.location.origin;
    $.ajax({
        url : "/logintozone",
        type : 'POST',
        data : {'username':username,'password':password,'url':url},
        dataType:'json',
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },
        success : function(r) { 
            if(r.type == 'warning'){
                savingalert(r.type,r.msg); 
            }else{
                if ( typeof r.typesub !== 'undefined' && r.typesub == 'business' ) {
                    window.location.href = baseurl+"/businessdashboard/"+r.businessid+"/zoneshowsubuser?subuser="+r.subuser+"";
                }else{
                    window.location.href = baseurl+"/Zonedashboard/zoneinformation?zoneName="+r.seo_zone_name+"&userId="+r.id+"&subuser="+username+"";
                }
            }

        }
    });
}

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

function fetchMyAccountData(type,zone_id,user_id,catval = 0,day=  []){
    if(day.length <= 0){
        day.push(0);
    }
    if(user_id == ''){
        return false;
    }
    if(type != 'claimdeal' && type != 'claimdealsend'){
        $(".sidebar-dropdown").removeClass("active");
        $('.sidebar-submenu').css('display','none');
    }
    var subcatArr = [];
    $(".subcatcheck").each(function() {
        if($(this).is(':checked') == true){subcatArr.push($(this).attr('subcatidcheck'));}
    });
    var user_id = $('#user_id').val();
    var residentshareurl = $('#residentshareurl').val();
    if(type){
        $.ajax({
            type: "GET",
            url: '/fetchMyAccountData',
            dataType:'json',
            data:{'type':type,'zone_id':zone_id,'user_id':user_id,'catval':catval,'day':day,'subcatArr':subcatArr,'residentshareurl':residentshareurl},
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function(d){
                var count = d.count;
                $('#myaccountbodyData').html(d.html);
                $("#cell_phone").mask('999-999-9999',{placeholder:' '});
                for (var i = 1; i <= count; i++) {
                    $("#phone_alternate"+i).mask('999-999-9999',{placeholder:' '});
                }
                $('#buisnesssnap').select2();
                $('#buisnesssnap').val(catval).trigger('change.select2');
            }
        });
    }    
}

function fetchMyAccountDataedit(type,zone_id,user_id,catval = 0,day=  []){
    if(day.length <= 0){
        day.push(0);
    }
    var subcatArr = [];
    $(".subcatcheck").each(function() {
        if($(this).is(':checked') == true){subcatArr.push($(this).attr('subcatidcheck'));}
    });
    var user_id = $('#user_id').val();
    if(type){
        $.ajax({
            type: "GET",
            url: '/fetchMyAccountDataedit',
            dataType:'json',
            data:{'type':type,'zone_id':zone_id,'user_id':user_id,'catval':catval,'day':day,'subcatArr':subcatArr},
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function(d){
                var count = d.count;
                $('#myaccountbodyData').html(d.html);
                $('#buisnesssnap').select2();
                $('#buisnesssnap').val(d.catval).trigger('change.select2');
            }
        });
    }    
}

function getdatasubcat(){

}
function savingalert(type = '',msg = ''){
    var msg = '<div style="opacity:1;" class="alert alert-'+type+' alert-dismissible fade show" role="alert"><strong>'+msg+'</strong></button></div>';
    $('#alert_msg').html(msg).css('display','block');
    setTimeout(hidealert, 3000);
}
function hidealert(){
    $('#alert_msg').css('display','none');  
}
function check_login(username,password,logintype){
    var get_zoneid = $('#get_zoneid').val();
    var grocerystore = $('#grocerystore').val();
    if(get_zoneid == '' || get_zoneid == undefined || get_zoneid == 'undefined'){
        var get_zoneid = $("input[name=zoneid]").val();
    }
    var refdealuser = $('#refdealuser').val();
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
                if(refdealuser > 0){
                    get1dealtouser(refdealuser,username,logintype);
                }
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
                            if(data.response == 'Invalid Username or Password!~!0' || data.response == '<span style="color:red">Invalid Username or Password.</span>!~!0'){
                                savingalert('warning','Invalid Username or Password');
                                return false;    
                            }
                            var data1 = data.response;
                            var res = data1.split('!~!');
                            var condition=res[0]; var id=res[1]; 
                            var sessiondata=res[2]; 
                            var redirect='';
                            var urlzone = data.zone;
                            var urlzone = window.location.origin;
                            switch(condition){
                                case 'zone_owner':
                                    $('div#login_loading').css('display','block');
                                    redirect=urlzone+'/Zonedashboard/zoneinformation';
                                    window.location=redirect;
                                    break;
                                case 'business_owner':
                                    $('div#login_loading').css('display','block');
                                    var res = data1.split('!~!');
                                    var sessiondata=res[3];
                                    if(grocerystore == 'available'){
                                        redirect=urlzone+'/groceryStore';
                                    }else{
                                        redirect=urlzone+'/businessdashboard/'+id+'/businessdetail';
                                    }
                                    window.location=redirect;
                                    break;
                                case 'verification':
                                    redirect=urlzone+'auth/verification/'+id ;
                                    window.location=redirect;
                                    break;
                                case 'listed':
                                    redirect=urlzone+'auth/listed_business_verification/'+id ;
                                    window.location=redirect;
                                    break;
                                case 'home':
                                    redirect=urlzone ;
                                    window.location=redirect;
                                    break;
                                case 'createABusiness':
                                    $('div#login_loading').css('display','block');
                                    redirect=urlzone+'/businessdashboard/createABusiness/1' ;
                                    window.location=redirect;
                                    break;
                                case 'user_profile':
                                    redirect=urlzone+'index.php?zone='+id ;
                                    window.location=redirect;
                                    break;
                                case 'snap_profile':
                                    var sessiondata=res[3];
                                    if(grocerystore == 'available'){
                                        redirect=urlzone+'/grocery_store';
                                    }else{
                                        redirect = urlzone+'/my_account';
                                    }
                                    window.location=redirect;
                                    break;
                                case 'sponsor_profile':
                                    var sessiondata=res[3];
                                    if(grocerystore == 'available'){
                                        redirect=urlzone+'/grocery_store';
                                    }else{
                                        redirect=urlzone+'/Sponsor/sponsorinformation';
                                    }
                                    window.location=redirect;
                                    break;
                                case 'organization':   
                                    var res = data1.split('!~!');
                                    var zone=res[2];
                                    var sessiondata=res[3];
                                    if(grocerystore == 'available'){
                                        redirect=urlzone+'/groceryStore';
                                    }else{  
                                     redirect=urlzone+'/organizationdashboard/'+id+'/organizationdetail';
                                    }
                                    window.location=redirect;
                                    break;
                                case 'realtor':
                                    redirect=urlzone+'realtordashboard/realtordetail/'+id ;
                                    window.location=redirect;
                                    break;
                                case 'zipadmin':
                                    redirect=urlzone+'/admin/' ;
                                    window.location=redirect;
                                    break;
                                default:
                                $('div#error_login').html('<span style="color:red">Sorry! You are not a valid user </span>');
                            }
                        },
                    'error':function(data) {
                         window.location.reload();
                    }
                });
            }else{
                savingalert('danger',data.response);
            }
        }
    });
}

function get1dealtouser(refdealuser,username,logintype){
    $.ajax({
        type:"POST",
        url:'/set1dealreferdata',
        data:{'refdealuser': refdealuser,'username':username,'logintype':logintype},
        dataType:'json',
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },
        success: function (res) {}
    });   
}

function username_verification(username = ''){}
function username_verification1(username = ''){
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
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
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
                beforeSend : function(){
                    $('#loading').css('display','block');
                },
                complete: function() {
                    $('#loading').css('display','none');
                },
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
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },
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
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },
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
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },
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
  }else{
    $('#passerror').html('');  
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

function printQRDiv() {
    var divToPrint=document.getElementById('qrcode');
    var newWin=window.open('Print-Window');
    newWin.document.open();

    var html = '<html><body onload="window.print()"><style>img{width: 220px;}body{margin: 80px 45px;}@page{size:auto;margin: 10;}</style>';
    for (var i = 0; i < 12; i++) {
        console.log(i);
         html += divToPrint.innerHTML;

    }
    
    html +='</body></html>';
    newWin.document.write(html);
    console.log(html);
    newWin.document.close();
    setTimeout(function(){newWin.close();},10);
}

function printDiv(divName) {
    var html = '<html><body onload="window.print()"><style>body{opacity:0}img{width: 300px;}body{margin: 90px 55px;}@page{size:auto;margin: 10;}@media print{body{opacity:1}}</style>';
     var printContents = document.getElementById('qrcode').innerHTML;
     for (var i = 0; i < 12; i++) {
        console.log(i);
         html += printContents;

    }
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = html;

     window.print();

     document.body.innerHTML = originalContents;
}

function sign_out(){
    var zone_id = $('#userzone').val();
    if(zone_id == '' || zone_id == undefined){
        zone_id = $('#zone_id').val();
    }
    var type = 'business';
    savingalert('success','Your Session has expired please login');
    $.ajax({
        type: "GET",
        url: "/auth/logout",
        data: {'type': type},
        dataType:'json',
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },
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
var uplimit= 20;

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
    
    $(document).on('click','.pageloadgrocery', function(){
        $('.pageloadgrocery').removeClass('active white');
        var pagecount = $(this).attr('pagecount');
        $('.pageloadgrocery').each(function(){
            var loop = $(this).attr('pagecount');
            if(pagecount == loop){
                $(this).addClass('active white');   
            }   
        })
        var upperlimit = uplimit;
        var lowerlimit =(pagecount-1)*uplimit; 
        var grocerystoreuid = $('#grocerystoreuid').val();
        var searchmiles = $('#searchmiles').val();
        getcrocerydata(lowerlimit,upperlimit,grocerystoreuid,searchmiles);
    });
  
    $(document).on('click','.searchmilesbutton', function(){
        var searchmiles = $('#searchmiles').val();  
        if(searchmiles){
            getcrocerydata(0,uplimit,'',searchmiles);    
        }
    });

    $(document).on('click','.businesssnapaddtolist', function(){
        var bussnapstarttime = $('.bussnapstarttime').find(":selected").val();
        var bussnapstarttimetext = $('.bussnapstarttime').find(":selected").text();

        var bussnapendtime = $('.bussnapendtime').find(":selected").val();
        var bussnapendtimetext = $('.bussnapendtime').find(":selected").text();
    
        var noofpeoplesnaptime = $('#noofpeoplesnaptime').find(":selected").val();
        var noofpeoplesnaptimetext = $('#noofpeoplesnaptime').find(":selected").text();

        var snapsendtype = 0;
        var noofpeople = '';
        if($('#alldays').is(":checked") == true){var snapsendtype = 1;}
        if($('#weekdays').is(":checked") == true){var snapsendtype = 2;}
        if($('#weekends').is(":checked") == true){var snapsendtype = 3;}
        
        var checkday = 0;
        if(noofpeoplesnaptime){
            noofpeople = noofpeoplesnaptime;
        }
        var html = '';
        $('.perdayselect').each(function(){
            if($(this).is(":checked") == true){
                checkday = 1;
                perdayselect = $(this).attr('day');
                dayword = $(this).attr('dayword');
                html += `<div class="snaplistsubmaindiv">
                <div class="snaplistsubdiv" dayid="`+perdayselect+`" starttime="`+bussnapstarttime+`" endtime="`+bussnapendtime+`" noofpeople="`+noofpeople+`" snapsendtype="`+snapsendtype+`">`+dayword+` `+bussnapstarttimetext+`-`+bussnapendtimetext+` `+noofpeople+`<span class="snaplistsubspan">X</span></div></div>`;
            }    
        });
        
        if(checkday == 0){
            savingalert('warning','Please check atleast snap week days');
            return false;    
        }
       
        $('#snaptimelist').append(html);

        $('.savesnapforbusiness').removeClass('hide');
        $('.bussnapstarttime').val(1).prop('selected', true);
        $('.bussnapendtime').val(1).prop('selected', true);
        $('#alldays').prop('checked', false);
        $('#weekdays').prop('checked',false);
        $('#weekends').prop('checked', false);
        $('.perdayselect').prop('checked', false);
        $('#noofpeoplesnaptime').val('');
    });

    $(document).on('click','.snaplistsubspan', function(){
        $(this).closest('.snaplistsubmaindiv').remove();
    });

    $(document).on('click','.addsnaptype', function(){
        $('.addsnaptype').prop('checked', false);
        $(this).prop('checked', true);
        $('.perdayselect').prop('checked', false);
        var snaptypevalue = '';
        $('.addsnaptype').each(function(){
            if($(this).is(":checked") == true){
                snaptypevalue = $(this).val();
            }    
        });

        if(snaptypevalue == 1){
            $('.perdayselect').prop('checked', true);
        }else if(snaptypevalue == 2){
            $('.perdayselect').each(function(){
                var day = $(this).attr('day');
                if(parseInt(day) <= 5){
                    $(this).prop('checked', true);
                }
            });  
        }else if(snaptypevalue == 3){
            $('.perdayselect').each(function(){
                var day = $(this).attr('day');
                if(parseInt(day) > 5){
                    $(this).prop('checked', true);
                }
            }); 
        }
    });

    $(document).on('click','.savesnapforbusiness', function(){
        var snap_filter_arr = [];

        var user_id = $('#user_id').val();
        var zone_id = $('#zone_id').val();
        $('.snaplistsubdiv').each(function(){
            var dayobject= {};
            var day             = $(this).attr('dayid');
            var starttime       = $(this).attr('starttime');
            var endtime         = $(this).attr('endtime');
            var noofpeople      = $(this).attr('noofpeople');
            var snapsendtype    = $(this).attr('snapsendtype');
            
            dayobject = {'day':day,'starttime':starttime,'endtime':endtime,'noofpeople':noofpeople,'snapsendtype':snapsendtype};
            snap_filter_arr.push(dayobject);
        });

        $.ajax({
            type:"POST",
            data:{user_id,zone_id,snap_filter_arr},                 
            url: '/save_user_snap_filter',      
            cache: false,
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function(data){  
                $('#snaptimelist').html('');      
                $('.savesnapforbusiness').addClass('hide');
                savingalert(data.type,data.msg);
            }
        });
    });

    $(document).on('click','.deleteusersnaptime',function(){
        if (confirm('Are you Sure to Delete?')) {
            var daycount = $(this).attr('daycount');
            var user = $(this).attr('user');
            if(daycount && user){
                $.ajax({
                    type:"POST",
                    data:{daycount,user},                 
                    url: '/delete_user_snap_filter',      
                    cache: false,
                    beforeSend : function(){$('#loading').css('display','block');},
                    complete: function() {$('#loading').css('display','none');},
                    success: function(data){  
                        savingalert(data.type,data.msg);  
                        $('#removedetailsnapdiv'+daycount).html('');    
                    }
                });
            }
        }
    });
});

function editsharelinkresidentenable(){
    $('#referlinktext1').prop('readonly', false);
    $('#referlinktext1').focus();  
    $('.editresidentinviteurl').addClass('hide');
    $('.updateresidentinviteurl').removeClass('hide');
}

function updatesharelinkresidentenable(){
    var residentinvitecode = $('#referlinktext1').val();
    var user_id = $('#user_id').val();
    $.ajax({
        type: "POST",
        url: '/updateresidentshareurl',
        data: {'residentinvitecode':residentinvitecode,'user_id':user_id},
        dataType: 'json',
        beforeSend : function(){$('#loading').css('display','block');},
        complete: function(){$('#loading').css('display','none');},
        success: function(data){
            if(data.type == 'success'){
                $('#referlinktext1').prop('readonly', true);
                $('#referlinktext1').val(residentinvitecode);  
                $('#referlinktext').val(data.shareurl+'/'+residentinvitecode); 
                var fburl = "https://www.facebook.com/sharer.php?u="+data.shareurl+'/'+residentinvitecode; 
                $('#fb').attr('href', fburl);
                var Xurl = "http://www.twitter.com/share?url="+data.shareurl+'/'+residentinvitecode; 
                $('#twitter').attr('href', Xurl);  
                $('.editresidentinviteurl').removeClass('hide');
                $('.updateresidentinviteurl').addClass('hide');
                savingalert(data.type,data.msg); 
            }else{
                savingalert(data.type,data.msg);
            }  
        }
    });
}

function getcrocerydata(lowerlimit,upperlimit,grocerystoreuid = '',searchmiles = ''){
    var html = '';
    var sessiondatagrocery = $('#sessiondatagrocery').val();
    $.ajax({
        type: "GET",
        url: '/getgrocerydata',
        data: {'lowerlimit':lowerlimit,'upperlimit':upperlimit,'grocerystoreuid':grocerystoreuid,'searchmiles':searchmiles},
        dataType: 'json',
        beforeSend : function(){$('#loading').css('display','block');},
        complete: function(){$('#loading').css('display','none');},
        success: function(data){
            if(data.length > 0){
                $('.pagination').removeClass('hide');
                var htmlpagination = `<ul class="pagination_count">
                    
                    <li><span class="page page-prev previouslink deactive">«</span></li>
                    $count = $rowcountArr/20;
                    $count = round($count);
                    for ($i=1; $i < $count; $i++) { 
                        if($i <= 10){
                            if($i == 1){$active = 'active white';}
                            else{$active = '';}
                            echo '<li class="pageloadgrocery '.$active.'" pagecount="'.$i.'">'.$i.'</li>';
                        }
                    }
                    <li><span class="page page-next nextlink">»</span></li></ul>`;
            }else{
                $('.pagination').addClass('hide');
            }
            $(data).each(function(k,v){
                var url = 'http://'+v.website;
                html += '<div class="col-lg-4 col-md-6 col-sm-12 entered shopoffer" ids="'+v.id+'"><p><b><i class="fa-solid fa-store"></i>   Store:</b> '+v.company_name+'<br><b><i class="fa-solid fa-house-chimney"></i>   Address:</b> '+v.address+','+v.city+','+v.zip+'<br><b><i class="fa-solid fa-phone"></i>   Phone:</b> '+v.phone+'<br><b><i class="fa-solid fa-car-side"></i>   Distance:</b> '+v.mileslat+' miles<br><button type="button" class="btn btn-success design" style=""><a target="_blank" href="'+url+'" class="changes">Grocery Specials</a></button> </p></div>';
            });
            $('#grocerydataajax').html(html);
        }
    });
}


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

