var amazonurl = $('#amazonurl').val();
var buttonAdd = $("#add-button");
var buttonRemove = $("#remove-button");
var className = ".dynamic-field";
var count = 0;
var field = "";
var maxFields =50;
var zone_id = $('#zone_id').val();
var user = $('#userid').val();
var username = $('#username').val();
var business_id = $('#business_id').val();
var baseurl = window.location.origin;
var pagesidebar = $('#pagesidebar').val();
var bidstart = $('#bidstart').val();
var subusereixsts = $('#subusereixsts').val();

$(document).ready(function(){
    $("#zonesubuserzipcodes").select2();
    var zipcodesubusers = $('#selectedzipcodes').val();
    if(zipcodesubusers != '' && zipcodesubusers != undefined){
        zipcodesubusers = zipcodesubusers.split(',');
        $('#zonesubuserzipcodes').val(zipcodesubusers).trigger('change.select2');
    }
    $('#zonesubuserzipcodes').select2({
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
    $('#sponsorbusinessid').select2();
    var subcatnew = $('#subcatnew').val();
    if(subcatnew > 0){
        $('.threestep-subsub').removeClass('hide');
    }
    var nodataexcel = $('#nodataexcel').val();
    if(nodataexcel == 'E'){
        savingalert('warning','No data Found');
    }
    if(pagesidebar != 'businessdetail'){
        getallcategoriesorg();
    }
    if(pagesidebar == 'add_business_snap'){
        getcountsnapuseremaillist();
    }
    if(bidstart == 1){
        checkorderapproval(business_id);
        var bidexists = checkbidexists(business_id);
        if(bidexists == 1){
            $('#bidhidediv').addClass('bithide');
            $('#bidhidediv').removeClass('hide');
        }else{
            setInterval(function(){
                $('#popmodalbusiness').modal({backdrop: 'static', keyboard: false}, 'show');
                $('.bidnowbox').removeClass('hide');
                // $('#popmodalbusiness').modal('show');
            },100000);
            setInterval(function(){
                $('#popmodalbusiness').modal('hide');
            },105000);   
        }
        setInterval(function(){
            rejectorder(business_id);
        },15000);

    }
    if(pagesidebar == 'webinar_details1'){
        showallwebinar();
    }
    if(pagesidebar == 'view_interest_group'){
        var zoneid = $('#orgzoneid').val();
        var org_id = $('#org_id').val();
        display_ig(zoneid,org_id,3,0);
    }
    if(pagesidebar == 'view_category_subcategory'){
        var org_id = $('#org_id').val();
       showallCategory(org_id);
    }
    if(pagesidebar == 'view_announcement'){
        var org_id = $('#org_id').val();
        showallannouncement(org_id);
    }
    var business_first_password_change =  $('#business_first_password_change').val();
    if(business_first_password_change == 1){
        $('#business_first_password').modal({backdrop: 'static', keyboard: false}, 'show');
        $('#business_first_password').modal('show');
    }else{
        $('#business_first_password').modal({backdrop: 'static', keyboard: false});
        $('#business_first_password').modal('hide');
    }
    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;
    addactive();
    $('.datatable-all').DataTable( {responsive: true});
    var date = new Date();

    var currentDate = date.toISOString().slice(0,10);
   
    var currentTime = date.getHours() + ':' + date.getMinutes();
    // document.getElementById('start_date').value = currentDate+' '+currentTime;
    // document.getElementById('end_date').value = currentDate+' '+currentTime;
    if(pagesidebar == 'myzonebusiness'){
        myZoneBusTable(213,2,3,4,3,1,'',-1,'contains');
    }
    $("#cell_phone").mask('999-999-9999',{placeholder:' '});
    $("#cell_phonealternate").mask('999-999-9999',{placeholder:' '});
    $("#biz_phone").mask('999-999-9999',{placeholder:' '});
    $("#albiz_phone").mask('999-999-9999',{placeholder:' '});
    $("#phone_user").mask('999-999-9999',{placeholder:' '});
    $("#main_category").select2();
    $("#sub_category").select2();
    $("#biz_state").select2();
    $("#catoption").select2();
    $("#selectcatsubcat").select2();
    $("#bus_search_results").select2();
    $("#bus_search_by_alphabet").select2();
    $("#deliveryTime").select2();
    $('#business_is_restaurant').change();

    $("#add_banner_forzone").on('submit',(function(e) {
        var imagename = $('#imgfile').attr('imagename');
        var subusereixsts = $('#subusereixsts').val();
        var fd = new FormData(this);
        fd.append('zone_id',zone_id);
        fd.append('imagename',imagename);
        fd.append('subuser',subusereixsts);
    e.preventDefault();
        $.ajax({
            url: "/banner_controller/save_zonelogo",
            type: "POST",
            data:  fd,
            contentType: false,
            cache: false,
            processData:false,
            dataType:'json',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function(data){
                if(data.type == 'success'){
                    savingalert(data.type,data.msg); 
                    $('#runlogo').attr('src',''+baseurl+'/assets/SavingsUpload/zone_logo/672/'+data.data)
                    
                } 
            }          
        });
    }));

    $("#add_banner_forbuisness").on('submit',(function(e) {
        var imagename = $('#card_img').attr('imagename');
        var busid = $('#card_img').attr('businessimageid');
        var subusereixsts = $('#subusereixsts').val();
        var fd = new FormData(this);
        fd.append('busid',busid);
        fd.append('imagename',imagename);
        fd.append('subusereixsts',subusereixsts);
    e.preventDefault();
        $.ajax({
            url: "/banner_controller/save_buisnesslogo",
            type: "POST",
            data:  fd,
            contentType: false,
            cache: false,
            processData:false,
            dataType:'json',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function(data){
                if(data.type == 'success'){
                    savingalert(data.type,data.msg); 
                    location.reload();
                } 
            }          
        });
    }));
    buttonAdd.click(function() {
        addNewField();
        enableButtonRemove();
        disableButtonAdd();
    });
    
    buttonRemove.click(function() {
        removeLastField();
        disableButtonRemove();
        enableButtonAdd();
    });

    $('.buttonAdd').click(function(e){
        e.preventDefault();
        var array = [];
        var subusereixsts = $('#subusereixsts').val();
        $('.dynamic-field').each(function(){
            if($(this).find('input[name="field[]"]').val() || $(this).find('input[name="order[]"]').val()){
                array.push({
                    key: $(this).find('input[name="field[]"]').val(),
                    value: $(this).find('input[name="order[]"]').val(),
                }); 
            }
        });

        $.ajax({
            type:"POST",
            data:{'zoneid':$('.zoneid').val() ,  'array':JSON.stringify(array),'subusereixsts':subusereixsts},                 
            url: '/Zonedashboard/addDiscount',      
            cache: false,
            dataType:'json',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function(data){  
                if(data.type == 'success'){
                    location.reload();
                }
            }
        });
    });
    
    // email formating js
    $('.buttonsubmit').click(function(e){
        e.preventDefault();
        $.ajax({
            type:"POST",
            data:{ "zone_id":$('.zoneid').val() , 'username':$('.keysform').find('input[name=username]').val() ,'email':$('.keysform').find('input[name=email]').val()   ,   'password':$('.keysform').find('input[name=passowrd]').val() , 'region':$('.keysform').find('input[name=region]').val()},                   
            url: "/Zonedashboard/saveawskeys",      
            cache: false,
            beforeSend : function(){$('#loading').css('display','block');},
            complete: function() {$('#loading').css('display','none');},
            success: function(data){              
                location.reload();
            }
        });
    });

    //mailconnection check
    $(document).on('click','#matchupdate',function(e){
     var produtid = $(this).attr('produtid');
     $.ajax({
            url : '/zonebusid_updt',
            type : 'GET',
            data : {'produtid':produtid},
            dataType:'json',
            success:function(result){
             console.log('get');
             //console.log(result);
             // if(result == 1){
             //   $('.showAftest').css('display','block');             
             //   $('.showAftest').css('display','block');             
             //  }
           }
        });

     });


    $(document).on('click','.chekmailconnection',function(e){
        e.preventDefault();
        var ids=$("#ids").val();
        var host = $('#hostname').val();
        if(host.length == 0){
            savingalert('warning','Name is Required');
        return false;
    }
        var user = $('#username').val();
        if(user.length == 0){
            savingalert('warning','User is Required');
       
         return false;
    }
        var pass = $('#password').val();
        if(pass.length == 0){
            savingalert('warning','Password is Required');
         return false;
    }
        var port = $('#port').val();
        if(port.length == 0){
            savingalert('warning','Port is Required');
         return false;
    }
        $.ajax({
            url : '/checktestconnection',
            type : 'POST',
            data : {'host':host,'user':user,'pass':pass,'port':port,'ids':ids},
            dataType:'json',
            success:function(result){
                console.log(result);
                if(result == 1){
                    $('.showAftest').css('display','block');             
                    $('.showAftest').css('display','block'); 
                    $('.chekmailconnection').addClass('hide');            
                }else{
                    savingalert('warning','Please Fill Correct Crediential');
                    $('#showsubmitbt').css('display','none');             
                    $('#showaddrow').css('display','none');             
                }
            }
        });
        
    });

//update by getid
    $(document).on('click','#updatemailblog', function(){
        var ids = $(this).attr("ids"); 
        $("#ids").val(ids);
        var host = $(this).attr("host"); 
        $("#hostname").val(host);
        var user = $(this).attr("user");
        $("#username").val(user);
        var pass = $(this).attr("pass");
        $("#password").val(pass);
        var port = $(this).attr("port");
        $("#port").val(port);
    });


    $(document).on('click','.delivery_check', function(){
        if($(this).is(':checked')){
            $('.delivery').removeClass('d-none');
            $('.delivery_uncheck').prop('checked', false);
        }
    });
    $(document).on('click','.delivery_uncheck', function(){
        if($(this).is(':checked')){
            $('.delivery').addClass('d-none');
            $('.delivery_check').prop('checked', false);
            $('#estimated_mile').val('');
            $('#deliveryCharges').val('');
            $('#deliveryTime').val('').trigger('change');
        }
    });
    
    $(document).on('blur','#biz_username',function(){
        var userame=$(this).val();
        if(userame==''){
            $('#success_uname').hide();
            return false;
        }
        var username = userame.replace(/-/g,'');
        var regex = new RegExp("^[a-zA-Z0-9.]*$"); 
        if(regex.test(username) !== true){ 
            $('#error_uname').html(userame+" must not contain special characters.");
            $('#error_uname').show();
            return false;
        }
        var data = { "user_name": userame};
        PageMethod("<?=base_url('Zonedashboard/add_business_check_username')?>", "Verify the username <br/>This may take a few minutes", data, showusername, null);
    });
    
    $(document).on('blur','#cell_phone',function(){
        $('#business_is_restaurant').change();
        var phone_int=$(this).val().replace(/[^0-9]/gi, '');
        if(phone_int==''){
            savingalert('warning','Please specify phone number');
            $('#biz_username').val('');
            return false;
        }
        var type = 'zone';
        $.ajax({
            type:'GET',
            url:"/add_business_check_username",        
            data:{'user_name': phone_int,'type':type},
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function(result) {         
                if(result=='0'){
                    savingalert('warning','This phone number is already exist.');
                    $('#biz_username').val('');
                    return false;
                }else{
                    savingalert('success','This phone number available.');
                    $('#biz_username').val(phone_int);
                    $('#biz_username').prop('readonly', true).css('background','grey');
                }
            }
        });
    });
    
    $(document).on('blur','#biz_password',function(){
        var password = $(this).val();
        if(password==''){
            savingalert('warning','Password Should Not be Empty');
            return false; 
        }
        var regex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%#&])[A-Za-z\d$@$!%#&]{5,}$/; 
        if(password.length < 5 || password.length > 18){
            savingalert('warning','Password should be between 5 to 18 characters');
            return false;
        }else if(!regex.test(password)){ 
            savingalert('warning','Password should be combination of letters, numbers and special characters (!, @, #, $, %, &)');
            return false;
        }
    });
    
    $(document).on('click','#create_generate_password',function(){ 
        $.ajax({
            type:'GET',
            url:"/Zonedashboard/create_generate_password_org",
            dataType:'json',  
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },      
            success: function(result) {      
                if(result!=''){               
                    $("#biz_password").val(result);
                }else{
                    $("#biz_password").val('');
                }   
            }
        });
    });

    $(document).on('change','#business_is_restaurant',function(){
        $('#biz_type').change();
        if($(this).val() == 1){
            $('#image_upload_div').removeClass('hide');
            $("#file").val(null);
            $('#main_category').prop('disabled', true);
        }else{
            $('#image_upload_div').addClass('hide');
            $('#main_category').prop('disabled', false);
            $("#file").val(null);
        }
    });
    
    $(document).on('change','#biz_type',function(){
        var html = '';
        var tag=$(this).val();
        var zoneid=$('#zone_id').val();
        var business_is_restaurant=$('#business_is_restaurant').val();
        var biz_mode=$("input[name=biz_mode]:checked").val(); 
        var data={'biz_type':tag,'zoneid':zoneid,'business_is_restaurant':business_is_restaurant,'biz_mode':biz_mode};  
        $.ajax({
            type:'Post',
            url:"/Zonedashboard/category_for_create_business",        
            data:data,
            dataType:'json',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function(result) {         
                $(result).each(function(k,v){
                    html += '<option value='+v.id+'>'+v.name+'</option>';
                });
                $('#main_category').html(html);
                if(business_is_restaurant == 1){
                    $('#main_category').change();
                }
            }
        });  
    });


    $(document).on('change','#main_category',function(){ 
        var catid=$('#main_category').val(); 
        var zoneid=$('#zone_id').val();
        $('#subcat').prop('checked', true);
        $('#sub_category').html('');
        var data={'catid':catid,'zoneid':zoneid}; 
        if(catid!=undefined){
            $.ajax({
                type:'Post',
                url:"/Zonedashboard/subcat_for_create_businessnew",        
                data:data,
                dataType:'html',
                beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
                success: function(result) {     
                    $('#sub_category').html(result);
                }
            });  
        }
        if($(this).val()){
            $('.deal_wraper').css('display','');
            $('.right_col').css('display','');
            $('.footer_btn').css('display','');
        }else{
            $('.deal_wraper').css('display','none');
            $('.right_col').css('display','none');
            $('.footer_btn').css('display','none');
        }
    });

    $(document).on('click','.coupon_question',function(){ 
        var catid=$(this).val(); 
        var zoneid=$('#zone_id').val();
        
        var data={'catid':catid,'zoneid':zoneid}; 
        if(catid!=undefined){
            $.ajax({
                type:'GET',
                url:"/Zonedashboard/subcat_for_create_businessnew",        
                data:data,
                dataType:'html',
                beforeSend : function(){
                    $('#loading').css('display','block');
                },
                complete: function() {
                    $('#loading').css('display','none');
                },
                success: function(result) {     
                    $('#sub_category').html(result);
                }
            });  
        }
    });

    $(document).on('click','#subcat', function(){
        if($(this).is(':checked')){
            $('#sub_category > option').each(function(){
                var attr = $(this).attr('disabled');
                    
                    if (typeof attr === 'undefined') {
                        $(this).prop("selected","selected");
                    }
            });
            $("#sub_category").trigger("change");
        }else{
            $("#sub_category > option").prop("selected", false);
            $("#sub_category").trigger("change");
        }
    });
    $(document).on('click','.sidemenunew',function(){
        if($('.threestep-subsub').hasClass('hide')){
            $('.threestep-subsub').removeClass('hide');
        }else{
            $('.threestep-subsub').addClass('hide');
        }
    });

    $(document).on('click','.sidemenu',function(){
        var zone_id = $('#zone_id').val();
        var businessid = $('#businessid').val();
        var login_id = $('#org_id').val();
        var subusereixsts = $('#subusereixsts').val();
        var attr = $(this).attr('page');
        var type = $(this).attr('type');
        var sessionzone = $('#sessionzone').val();
        if(type == 'businessdashboard'){
            if(subusereixsts != '' && subusereixsts != undefined){
                window.location.href = "/businessdashboard/"+businessid+"/"+attr+"&subuser="+subusereixsts+"";
            }else{
                window.location.href = "/businessdashboard/"+businessid+"/"+attr+"";
            }
        }else if(type == 'organizationdashboard'){
            var zone_id = $('#orgzoneid').val();
            window.location.href = "/organizationdashboard/"+login_id+"/"+attr+"";
        }else if(type == 'zoneinfo'){
            window.location.href = "/Zonedashboard/zoneinfo/"+zone_id+"?page="+attr+"";
        }else if(type == 'sponsordashboard'){
            window.location.href = '/Sponsor/'+attr+''; 
        }else{
            if(subusereixsts != '' && subusereixsts != undefined){
                window.location.href = "/Zonedashboard/"+attr+"?subuser="+subusereixsts+"";
            }else{
                window.location.href = "/Zonedashboard/"+attr+"";
            }
        }
    });    
    
    $(document).on('click','#create_business',function(){ 
        $('#create_business').prop('disabled',false);
        var deliver ;
        var biz_name = $('#biz_name').val();
        var biz_moto = $('#biz_moto').val();
        var biz_about = $('#biz_about').val();
        var biz_mail = $('#biz_mail').val();
        var biz_firstname = $('#biz_firstname').val();
        var biz_lastname = $('#biz_lastname').val();
        var biz_address = $('#biz_address').val();
        var biz_city = $('#biz_city').val();
        var biz_state = $('#biz_state').val();
        var biz_zip = $('#biz_zip').val();
        var cell_phone = $('#cell_phone').val();
        var cell_phonealternate = $('#cell_phonealternate').val();
        var biz_website = $('#biz_website').val();
        var business_is_restaurant = $('#business_is_restaurant').val();
        var biz_username = $('#biz_username').val();
        var biz_password = $('#biz_password').val();
        var biz_type = $('#biz_type').val();
        var main_category = $('#main_category').val();
        var sub_category = $('#sub_category').val();
        
        var ad_startdatetime = $('#ad_startdatetime').val();
        var ad_stopdatetime = $('#ad_stopdatetime').val();
        var serviceNumber = $('#ServiceNumber').val();
        var zone_id = $('#zone_id').val();
        var estimated_mile = $('#estimated_mile').val();
        var deliveryCharges = $('#deliveryCharges').val();
        var deliveryTime = $('#deliveryTime').val();
        var audio_greetings = $('#biz_firstname').attr('audio_greetings');
        var phone_int= $("#cell_phone").val().replace(/[^0-9]/gi, '');
        var subusereixsts = $('#subusereixsts').val();

        if(biz_name == ''){
            savingalert('warning','Please specify Business Name');
            $('#create_business').prop('disabled',false);
            $('#biz_name').focus();
            return false;
        }
        if(biz_mail == ''){
            savingalert('warning','Please specify Business Email');
            $('#create_business').prop('disabled',false);
            $('#biz_mail').focus();
            return false;
        }
        if(biz_firstname == ''){
            savingalert('warning','Please specify Business First Name');
            $('#create_business').prop('disabled',false);
            $('#biz_firstname').focus();
            return false;
        }
        if(biz_lastname == ''){
            savingalert('warning','Please specify Business Last Name');
            $('#create_business').prop('disabled',false);
            $('#biz_lastname').focus();
            return false;
        }
        if(biz_zip == ''){
            savingalert('warning','Please specify Business Zip Code');
            $('#create_business').prop('disabled',false);
            $('#biz_zip').focus();
            return false;
        }
        if(cell_phone == ''){
            savingalert('warning','Please specify Business Phone');
            $('#create_business').prop('disabled',false);
            $('#cell_phone').focus();
            return false;
        }
        if(biz_password == ''){
            savingalert('warning','Please specify Business Password');
            $('#create_business').prop('disabled',false);
            $('#biz_password').focus();
            return false;
        }
        if(sub_category == ''){
            savingalert('warning','Please Business Sub Category');
            $('#biz_password').focus();
            return false;
        }
        var audio_presentation=$("input[name=biz_audio_presentation]:checked").val(); 
        var video_presentation=$("input[name=biz_video_presentation]:checked").val(); 
        if(audio_presentation==undefined){ audio_presentation=0; }
        if(video_presentation==undefined){ video_presentation=0; }
        if($('#yes').prop('checked') ){
            deliver = 1;
            $('.miles').css("display" , 'block');
        }else if($('#no').prop('checked')){
            deliver = 0;
            $('.miles').css("display" , 'none');
        } 
        
        // $('.optiondropdown:selected').each(function(i, j){            
        //     display_cat_subcat+=$(j).val()+','; 
        // });
        
        // display_cat_subcat=display_cat_subcat.substring(0,display_cat_subcat.length-1);
        //       if($('#main_category').val()=='' || display_cat_subcat==''){
        //   alert("Please specify Category/Sub-category.");
        //   return false;
        // }
         // if(CKEDITOR.instances.stater_ad_message.getData() == ''){
        //   alert("Please specify Starter Ad.");
        //   return false;
        // }
        var data = {
            id : "-1",
            zipcode : biz_zip,
            zone_id : zone_id,
            name: biz_name,
            motto: biz_moto,
            aboutus: biz_about,
            contactemail : biz_mail,
            contactfirstname : biz_firstname,
            contactlastname : biz_lastname,
            contactfullname : biz_firstname+''+biz_lastname,
            street1 : biz_address,
            street2 : biz_address,
            city : biz_city,
            state : biz_state,
            phone : cell_phone,
            phone_int : phone_int,
            website : biz_website,
            restaurant_type:business_is_restaurant,
            siccode : '',
            audio_presentation : audio_presentation,
            video_presentation : video_presentation, 
            owner_account : 2,
            biz_username : biz_username,
            biz_password : biz_password,
            existing_bo : $('#ebo').val(),
            biz_mode : 1, 
            biz_type : biz_type,
            catid : main_category,  
            subcatid : sub_category,
            stater_ad : '',
            ad_stopdatetime:ad_startdatetime,
            ad_startdatetime:ad_stopdatetime,
            biz_profile_check : $('#biz_profile_check').val(),
            deliver : deliver  , 
            miles : estimated_mile,
            deliveryTime: deliveryTime,
            deliveryCharges : deliveryCharges,
            audio_greetings: audio_greetings,
            service_number: serviceNumber,
            alternate_phone: cell_phonealternate,
            subusereixsts: subusereixsts
        };

        $.ajax({
            type:'POST',
            url:"/Zonedashboard/create_business",        
            data:data,
            dataType:'json',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function(result) {
                if(result.type == 'success'){
                    $('#create_business').prop('disabled',false);
                    savingalert('success','Business Created Successfully');
                    $('#businessForm').trigger("reset");
                    $('#biz_username').css('background','white').prop('readonly', false);
                    $('#business_is_restaurant').change(); 
                    window.location.href = baseurl+"/Zonedashboard/myzonebusiness?subuser=undefined";
                }else{
                    savingalert(result.type,result.msg); 
                }
            }
        });  
    });

    $(document).on('click','#reset',function(){
        location.reload();
    });

    $(document).on('change','#catoption', function(){
        var v= $(this).val();
        if(v == 'category'){
            var url = "/Zonedashboard/listofcategory";
        }else{
            var url = "/Zonedashboard/listofsubcategory";
        }
        $.ajax({
            type:'GET',
            url:url,
            dataType:'html',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function(result) {
                $('#selectcatsubcat').html(result);
            }
        });    
    });

    $(document).on('click','#searcatsubcats', function(){
        var catoption = $('#catoption').val();
        var selectcatsubcat = $('#selectcatsubcat').val();
        fetch_data_by_filter(catoption,selectcatsubcat);
    });

    $(document).on('click','#search_business', function(){
        var catoption = $('#bus_search_results').val();
        var selectcatsubcat = $('#bus_search_by_alphabet').val();
        fetch_data_by_filter(catoption,selectcatsubcat);
    });

    $(document).on('click','.adddeal, .editdeal,.editorganization', function(){
        var busid = $(this).attr('busid');
        var zoneid = $(this).attr('zoneid');
        var busname = $(this).attr('busname');
        var productid = $(this).attr('productid');
        var orgid = $(this).attr('orgid');
        $('#company_name').val(busname);
        $('#business_id').val(busid);
        $('#zone_id').val(zoneid);
        $('#createdealdiv').removeClass('hide');
        if(productid > 0){
            editdeal(productid,busid);
            $('#product_id').val(productid);
            $('.peekaboo_cat').css('display','');
            $('.deal_wraper').css('display','');
            $('.right_col').css('display','');
            $('.footer_btn').css('display','');
        }
        if(orgid > 0){
            var orguser = $(this).attr('orguser');
            var zone_id = $(this).attr('zone_id');
            editorganization(orgid,orguser,zone_id);
        }
    });

    $(document).on('click','.showdealdetail', function(){
        var busid = $(this).attr('busid');
        var dealmeta = $(this).attr('dealmeta');
        var baseurl = window.location.origin;
        $('#createdealdiv').removeClass('hide');
        if(dealmeta > 0){
            $.ajax({
                type:'GET',
                url:"/Businessdashboard/showdealdata",
                data:{'dealmeta':dealmeta,'busid':busid},
                dataType:'json',
                beforeSend : function(){
                    $('#loading').css('display','block');
                },
                complete: function() {
                    $('#loading').css('display','none');
                },
                success: function(r){
                    var res = r.data[0];
                    $('#username').text(res.first_name+' '+res.last_name); 
                    $('#add').text(res.Address); 
                    $('#email').text(res.email);
                    $('#phone').text(res.phone); 
                    $('#user_type').text(res.user_type); 
                    $('#dealid').text(res.dealId); 
                    $('#dealtitle').text(res.deal_title); 
                    $('#dealdesc').text(res.deal_description); 
                    $('#image').attr('src','https://cdn.savingssites.com/'+res.card_img);
                    $('#dealstart').text(res.start_date);  
                    $('#dealend').text(res.end_date);  
                    $('#dealcreation').text(res.created_date);  
                    $('#auctiontype').text(res.auction_type);  
                    $('#status').text(res.status);    
                    $('#publisher_fee').text(res.publisher_fee);  
                    $('#seller_fee').text(res.seller_fee);  
                    $('#price').text(res.dealamounnt);  
                    $('#PurchasedAt').text(res.purchasedAt);  
                    $('#dealamount').text(res.dealamounnt);  
                    $('#disamount').text(res.dealdiscount);  
                    $('#actualprice').text(res.dealactual_price);  
                    $('#certval').text(res.buy_price_decrease_by); 
                }
            });  
        }
    });

    $(document).on('click','.updateperdetail', function(){
        var zone_id = $(this).attr('zone_id');
        var userid = $(this).attr('userid');
        var orgid = $(this).attr('orgid');
        var fee_per = $(this).closest('tr').find('.orgfeeper').val();
        if(orgid > 0){
            $.ajax({
                type:'POST',
                url:"/updateperdetail",
                data:{'zone_id':zone_id,'userid':userid,'orgid':orgid,'fee_per':fee_per},
                dataType:'json',
                beforeSend : function(){
                    $('#loading').css('display','block');
                },
                complete: function() {
                    $('#loading').css('display','none');
                },
                success: function(r){
                    savingalert(r.type,r.msg)
                }
            });  
        }
    });
    $(document).on('click','#closedeal', function(){
        $('#msform').find('#progressbar li').removeClass('active');
        $('#msform').find('fieldset').css('opacity',0);
        $('#msform').find('fieldset').css('display','none');
        $('#msform').find('#progressbar li:first').addClass('active');
        $('#msform').find('fieldset:first').css('display','block');
        $('#msform').find('fieldset:first').css('opacity',1);
        $('#createdealdiv').addClass('hide');
        $('.auctioncreate')[0].reset();
        $('.peekaboo_cat').css('display','none');
        $('.deal_wraper').css('display','none');
        $('.right_col').css('display','none');
        $('.footer_btn').css('display','none');
        $('#progressbar li').removeClass('active');
        $('#progressbar li:first').addClass('active');
    });

     $(document).on('click','.editdealpge', function(){
        $('.hide').removeClass('hide');
        var businessid = $(this).attr('busid');
        $('#businessid').val(businessid); 
         $.ajax({
            type:"post",
            url:"/Zonedashboard/business_set",
            data:{'businessid':businessid},
            dataType:"JSON",
            success:function(data){
                $('#biz_name').val(data.data[0].name); 
                $('#biz_type').val(data.data[0].type);  
                $('#biz_motto').val(data.data[0].motto); 
                $('#biz_about').val(data.data[0].aboutus); 
                $('#biz_contact_email').val(data.data[0].contactemail); 
                $('#biz_contactfirstname').val(data.data[0].contactfirstname);
                $('#biz_contactlastname').val(data.data[0].contactlastname);  
                $('#biz_street_1').val(data.data[0].street_address_1);
                $('#biz_city').val(data.data[0].city);
                $('.postalcode').val(data.data[0].zip_code).trigger('change'); 
                $('#biz_state').val(data.data[0].state);
                $('#biz_website').val(data.data[0].website);      
                $('#biz_phone').val(data.data[0].phone);
                $('#albiz_phone').val(data.data[0].alerternative);
                $('#usernameset').text(data.data[0].username);
                $('.w_300').val(data.data[0].email);
                $('#jform_Firstname').val(data.data[0].contactfirstname);
                $('#jform_Lastname').val(data.data[0].contactlastname); 
                $('#jform_Phone').val(data.data[0].username);
                $('#userid').val(data.data[0].business_owner_id); 
            }         
        });
    });

    $(document).on('click','.sortlisttags', function(){
        if($(this).is(":checked") == true){
            var auction_id = $(this).attr('data-id');
            $.ajax({
                type:"POST",
                url:"/Businessdashboard/upload_deal_list",
                data:{'auction_id':auction_id},
                beforeSend : function(){
                    $('#loading').css('display','block');
                },
                complete: function() {
                    $('#loading').css('display','none');
                },
                success:function(data){
                    data = JSON.parse(data);
                    if(data){
                        var  endindatecount =parseFloat(data[0].end_date) + parseFloat(data[0].start_date);
                        $('.redemption').val(data[0].dealRedemption);
                        $('#redemption_val').val(data[0].dealRedemption);
                        $('#publisher_fee').val(data[0].donationClaimingFee);
                        $('#max_sold_per_auction').val(data[0].numberOfDeals);
                        $("#cert_accept_yes").prop("checked", true);
                        $('.consolation_view').slideDown(1000);
                        $('.low_limit_price').val(data[0].discountedPrice);
                    }
                }
            });
            $('.peekaboo_cat').css('display','');
            $('.deal_wraper').css('display','');
            $('.right_col').css('display','');
            $('.footer_btn').css('display','');
        }else{
            $('.peekaboo_cat').css('display','none');
            $('.deal_wraper').css('display','none');
            $('.right_col').css('display','none');
            $('.footer_btn').css('display','none');
        }
    });

    $(document).on('click','.reschedulebtn', function(){
        var proid = $(this).attr('proid');
        $.ajax({
            type:'POST',
            url:"/Zonedashboard/deal_reschedule",
            data:{'data_to_use': proid},
            dataType:'json',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function(r) {
                savingalert(r.type,r.msg)
            }
        }); 
    });

    $(document).on('click','#rescheduleall', function(){
        $.ajax({
            type:'POST',
            url:"/Zonedashboard/alldeal_reschedule",
            data:{'zone_id': zone_id},
            dataType:'json',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function(r) {
                savingalert(r.type,r.msg);
                // location.reload();
            }
        }); 
    });
    
    $(".next").click(function(){
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();
        //Add Class Active
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        //show the next fieldset
        next_fs.show(); 
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function(now) {
                // for making fielset appear animation
                opacity = 1 - now;
                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
            next_fs.css({'opacity': opacity});
        }, 
        duration: 600
        });
    });

    $(".previous").click(function(){
        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();
        //Remove class active
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
        //show the previous fieldset
        previous_fs.show();
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function(now) {
                // for making fielset appear animation
                opacity = 1 - now;
                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previous_fs.css({'opacity': opacity});
            }, 
            duration: 600
        });
    });
    
    $('.radio-group .radio').click(function(){
        $(this).parent().find('.radio').removeClass('selected');
        $(this).addClass('selected');
    });
    $(".submit").click(function(){
        return false;
    })

    $(document).on('click','.businessstatus', function(){
        var v = $(this).val();
        if(v == 'yes'){
            $('.peekaboo_start_date').addClass('hide');
            $('.timelength').removeClass('hide');
            $('#start_date').prop('disabled', false);
        }else{
            $('.peekaboo_start_date').removeClass('hide');
            $('.timelength').addClass('hide');  
            $('#start_date').prop('disabled', false);
        }
    });

    $(document).on('change','#card_img', function(){
        $('#show_banner').css('display','none');
        const file = this.files[0];
        if (file){
          let reader = new FileReader();
          reader.onload = function(event){
            $('#output').attr('src', event.target.result);
            $('#output').css('height','250px');
            $('#output').css('width','300px');
          }
          reader.readAsDataURL(file);
        }
    });

    $(document).on('click','#submitMessage', function(){
        var business_id = $('#business_id').val();
        var subusereixsts = $('#subusereixsts').val();
        if($("#catID").val() =='' || $("#start_date").val() =='' || $("#end_date").val() =='' || $("#low_limit_price").val() =='' || $("#consolation_price").val() ==''  || $("#page_title").val() =='' || $('.meta_description').val() == '' || $("#min_bid_cost").val()   || $("#deal_description").val() ==''){
            savingalert('warning','Please Enter all required fields');
            return false;
        }else{    
            var form_data = $(".auctioncreate");
            var disabled = form_data.find(':input:disabled').removeAttr('disabled');
            var serialized = form_data.serialize();
                disabled.attr('disabled','disabled');
            $.ajax({
                type:"POST",
                url:"/Businessdashboard/insert_deals",
                data: {'data_to_use': serialized  , 'deal_id': $('.sortlisttags:checked').attr('data-id') ,'subusereixsts':subusereixsts }, 
                beforeSend : function(){
                    $('#loading').css('display','block');
                },
                complete: function() {
                    $('#loading').css('display','none');
                },   
                success: function(response){ 
                    window.location.href = "/businessdashboard/"+business_id+"/viewdeals";
                }
            });
        }
    });

    $(document).on('blur','#buy_price_decrease_by',function(){
        var redemption = $(this).val();
        var data_to_use = {price:redemption,zoneid:zone_id};
        $.ajax({
            type:"POST",
            url:"/Businessdashboard/publisher_fee",
            data: data_to_use,    
            cache:false, 
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },         
            success: function(response){ 
                if(response!=""){
                    $("#redemption_val").val(redemption);
                    $("#publisher_fee").val(response);
                    $("#seller_fee").change();
                }
            }
        });
    });

    $(document).on('change','#seller_fee',function(){
        var seller_fee = $(this).val();
        var redemption = $('.redemption').val();
        var percentage = (seller_fee * redemption)/100;
        var seller_credit = percentage / 0.25;
        $("#seller_credit").val(Math.round(seller_credit));
    });

    $('#reset').click(function(){
        $('input[type="text"]').not('#company_name').val(' ');
        $('textarea').val(' ');
        $("option:selected").prop("selected", false);
        $("#show_banner").html(" ");
        $(' input[type="radio"]').removeAttr('checked');
    });

    $(document).on('keyup','#dealdescription',function(){ 
        var max = 2000;
        var max1 = 100;
        var deal_description = $(this).val();
        var remove_html = deal_description.replace(/(<([^>]+)>)/ig,"");
        var len = remove_html.length;
        if (len >= max) {
            $('#text2000').text(' you have reached the limit');
        } else {
            var ch = max - len;
            $('#text2000').text(ch + ' characters left');
        }
        if (len >= max1) {
            $('#characterLeft3').text(' you have reached the limit');
            $('#characterLeft1').text(' you have reached the limit');
        } else {
            var ch = max1 - len;
            $('#characterLeft3').text(ch + ' characters left');
            $('#characterLeft1').text(ch + ' characters left');
        }
    });

    $(document).on('change','#card_img', function(){
        var file_data = $('#card_img').prop('files')[0];
        var form_data = new FormData();
        var busid = $('#business_id').val();
        var deal_product_id = $('#deal_product_id').val();
        var userid = $("input[name='user_id']").val();
        if(busid == '' || busid == undefined){
            busid = $('#businessid').val();
        }
        if(deal_product_id == '' || deal_product_id == undefined){
            deal_product_id = $('#businessid').val();
        }
        form_data.append('file', file_data);
        form_data.append('type','business');
        form_data.append('busid',busid);
        form_data.append('deal_product_id',deal_product_id);
        form_data.append('userid',userid);
        UploadImage(form_data,zone_id,'Business','#card_img');
    });

    $(document).on('change','#imgfile', function(){
        var file_data = $('#imgfile').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        UploadImage(form_data,zone_id,'zone_logo','#imgfile');
    });

    $(document).on('change','#imgfileorg', function(){
        var file_data = $('#imgfileorg').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        var zone_id = $('#orgzoneid').val();
        UploadImage(form_data,zone_id,'org_logo','#imgfileorg');
    });

    $(document).on('change', '#upload_file', function(){
        var file_data = $(this).prop('files')[0];
        var form_data = new FormData();
        var busid = $('#business_id').val();
        if(busid == '' || busid == undefined){
            busid = $('#businessid').val();
        }
        form_data.append('file', file_data);
        form_data.append('type','business');
        form_data.append('busid',busid);
        UploadImage(form_data,zone_id,'Business','#show_bannermulti');
    })

    $(document).on('click','.addadvertisment,.viewadvertisment',function(){
        var busname = $(this).attr('busname'); 
        var busid = $(this).attr('busid'); 
        var zoneid = $(this).attr('zoneid'); 
        var fromzoneid = $(this).attr('fromzoneid'); 
        var adid = $(this).attr('adid');  
        $('#businessname').html(busname);
        $('#business_name').val(busname);
        $('#business_id').val(busid);
        $('#businessid').html('('+busid+')');
        if(adid > 0){
            viewAds(busid,adid,zoneid,fromzoneid);
        }
        $('#createdealdiv').removeClass('hide');
        $('html, body').animate({scrollTop: '+=650px'}, 1000);
    });

    $(document).on('keyup','#deal_restriction', function(){    
        var max = 200;
        var len = $(this).val().length;
        if (len >= max) {
            $('#text200').text(' you have reached the limit');
            $(this).val().remove();
        } else {
            var ch = max - len;
            $('#text200').text(ch + ' characters left');
        }
    });

    $(document).on('change','#allcategories', function(){
        $('.org_image_output').attr('src','');
        var catid = $(this).val();
        var org_id = $('#org_id').val();
        var orgzoneid = $('#orgzoneid').val();
        var  baseurl = window.location.origin;
        if(catid != '' && catid != -1){
        $.ajax({
            'url':"/getorgcategoryimage",
            'type': 'GET',
            'data':{'catid':catid,'org_id':org_id},
            'dataType':'json',  
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },    
            success:function(r){
                if(r != ''){
                    $('.org_image_output').attr('src','https://cdn.savingssites.com/'+r)
                }else{
                    savingalert('success','No Image Found');
                }
            }
        });
        }
    });

    $(document).on('click','.genarate_url',function(){
        var dealid = $('#search_engine_title').val();
        if(dealid == ''){
            savingalert('warning','Please Fill Deal Title');
            $('#search_engine_title').focus();
            return false;
        }
        var ad_title = $('#search_engine_title').val();
        var baseurl = window.location.origin;
        var from_where = 'd';
        if(ad_title == ''){ 
            $('#search_engine_title').removeClass("correct");
            $('#search_engine_title').addClass("incorrect");    
            $('#search_engine_title').focus();
            $("p.nextbutton4").addClass('disabled'); 
        }else{
            $('#search_engine_title').removeClass("incorrect");
            $('#search_engine_title').addClass("correct");
            $("p.nextbutton4").removeClass('disabled');  
        }

        dataToUse ={"ad_title":ad_title,"from_where": from_where};
        $.ajax({
            url: "/Businessdashboard/check_title", 
            dataType: 'json', 
            data: dataToUse,
            type: 'get',
            beforeSend : function(){

                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function (data) {
                if(data.msg =='Dealtitle Exist'){
                   savingalert('warning','Dealtitle Already Exist'); 
                }
               // console.log(data.msg);
                // var f_d_title = ad_title+'-'+ result_title;
                // $('#search_engine_title').val(f_d_title);
                // $('#search_engine_title').val(""+baseurl+"/short_url/index.php?deal_title="+ad_title+"");
            }
        });
    });

    $(document).on('click','#create_ad',function(){
        var _f=$(this).closest('form');
        var page = $('#pagesidebar').val();
        var businessnew = $("#business_id").val();
        var zonedashboardads = $("#zonedashboardads").val();
        // if($('#ad_category_fromshowad').val()!=''){ 
            var catid=$('#ad_category_fromshowad').val();
        // }else{
        //     var catid=0;
        // }
        var display_cat=''; 
        
        $('.optioncategory:checked').each(function(i, j){           
            display_cat+=$(j).val()+',';
        });

        display_cat=display_cat.substring(0,display_cat.length-1);
        var display_cat_subcat='';  
        
        $('.optiondcheckbox:checked').each(function(i, j){          
            display_cat_subcat+=$(j).val()+',';
        });
        
        display_cat_subcat=display_cat_subcat.substring(0,display_cat_subcat.length-1);
        
        var ad_startdatetime = Date.parse(_f.find("#ad_startdatetime").val());
        var ad_stopdatetime = Date.parse(_f.find("#ad_stopdatetime").val());
        var ad_starttime = $("#ad_starttime").val();
        var ad_stoptime = $("#ad_stoptime").val();
        
        if(display_cat==''){
            savingalert('warning','Please Specify Category.');
            return false;
        }
        
        if(display_cat_subcat==''){
            savingalert('warning','Please Specify Sub-category.');
            return false;
        }
        var deliver ;
        var deliver_zip = [];
        
        if($('#yes').prop('checked') ){
            deliver = 1;
        }else if($('#no').prop('checked')){
            deliver = 0;
        }
        
        if (deliver==1){
            $('.delivery-zipclass:checked').each(function(i){
                deliver_zip[i] = $(this).val();
            });
        }
        
        if ($('#showreservation:checked').val()!=undefined){
            var showreservation = $('#showreservation:checked').val();
        }else{
            showreservation = 0;
        }
        
        if ($('#showmenutab:checked').val()!=undefined){
            var showmenutab = $('#showmenutab:checked').val();
        }else{
            showmenutab = 0;
        }
        var subusereixsts = $('#subusereixsts').val();
        var dataToUse = {
            "id":$("#ad_id").val(),
            "adid":$("#adid").val(),
            "docs_pdf":$("#docs_pdf").val(),
            "docs_pdf_foodmenu":$("#docs_foodmenu").val(),
            "offer_code" : $("#ad_code_fromshowad").val(),
            "name":$("#ad_name_fromshowad").val(),
            "ad_startdatetime":$("#ad_startdatetime").val(),
            "ad_stopdatetime":$("#ad_stopdatetime").val(),
            "ad_starttime":ad_starttime,
            "ad_stoptime":ad_stoptime,
            "business_id": $("#business_id").val(),
            "zoneid":$('#zoneid').val(),
            "fromzoneid":$('#fromzoneid').val(),
            "adtext": $('#uploadedInput').val(),
            "short_description": $('#short_description').val(),
            "number_of_deal": $('#number_of_deal').val(),       
            "deal_restriction": $('#deal_restriction').val(),
            "deal_information": $('#deal_information').val(),
            "category_id": catid,
            "subcategory_id": display_cat_subcat,
            "showreservation": showreservation,
            "showmenutab": showmenutab,
            "active" : "1",
            "text_message": $("#text_message_fromshowad").val(),
            "text_reason": $("#text_reason").val(),
            "business_zone_id": $('#business_zone_id').val(),
            "where_from":$('#where_from').val(),
            "imagetype":$('#foodimage').val(),
            "search_engine_title":$('#search_engine_title_display').text(),
            "audio_file":$('#audio_disp').val(),
            "video":$('#video_presentation').val(),
            "deliver":deliver,
            "deliver_zips":deliver_zip,
            "deal_title":$('#search_engine_title').val(),
            "business_name":$('#business_name').val(),
            "textmeoffer":$('#textmeoffertext').val(),
            "multiimage":$('#multiuploadedInput').val(),
            "deal_description":$('.dealdescription').val(),
            "miles":$('.miles_estimate').val(),
            "deliveryCharges" : $('.deliveryCharges').val(),
            "subcatimagebutton" : $('#subcatimagebutton').val(),
            "subusereixsts" : subusereixsts,
        };
        $.ajax({
            url: "/Businessdashboard/savead", 
            dataType: 'json', 
            data: dataToUse,
            type: 'post',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function (res) {
                if(page == 'makenewadvertisement'){
                    if(zonedashboardads == 1){
                        window.location.href = baseurl+'/Zonedashboard/viewads';
                    }else{
                        window.location.href = baseurl+'/businessdashboard/'+businessnew+'/viewads';
                    }
                }else{
                    savingalert('success','Ad Updated Successfully');  
                    setTimeout(function() {
                        location.reload();
                    }, 2500);
                }
            }
        });
    });
    
    $(document).on('click','#submit_code_button', function(event){
        event.preventDefault();
        var zone_id =$('#zone_id').val();
        var category_id = $("#paypal_url").val();
        var braintree_merchantid = $("#braintree_merchantid").val();
        var braintree_public_key = $("#braintree_public_key").val();
        var braintree_private_key = $("#braintree_private_key").val();
        var subusereixsts = $('#subusereixsts').val();
        var dataToUse = {'paypal_url':category_id,'braintree_merchantid':braintree_merchantid,'braintree_public_key':braintree_public_key , 'braintree_private_key':braintree_private_key,'zone_id':zone_id,'subusereixsts':subusereixsts};
        $.ajax({
            url: "/Zonedashboard/update_paypal_accounting_setting", 
            dataType: 'json', 
            data: dataToUse,
            type: 'post',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function(res){
                savingalert('success','Data Inserted Successfully');
            }
        });
        
    });

    $(document).on('click','#submit_twilio_button', function(event){
        event.preventDefault();
        var zone_id =$('#zone_id').val();
        var twiliossid = $("#twiliossid").val();
        var twilioauthtoken = $("#twilioauthtoken").val();
        var twiliono = $("#twiliono").val();
        var twilioeditid = $("#twilioeditid").val();
        if(twiliossid == '' || twilioauthtoken == '' || twiliono == ''){
            savingalert('warning','Please Fill All Required Fields.');   
        }
        var dataToUse = {'zone_id':zone_id,'twiliossid':twiliossid,'twilioauthtoken':twilioauthtoken,'twiliono':twiliono,'twilioeditid':twilioeditid};
        $.ajax({
            url: "/addtwilioaccount", 
            dataType: 'json', 
            data: dataToUse,
            type: 'post',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function(r){
                if(r.type == 'warning'){
                    savingalert(r.type,r.msg);
                    return false;
                }else{
                    savingalert(r.type,r.msg);
                    location.reload();
                }
            }
        });
        
    });

    $('#toggle').click(function(){
        if($(this).val() == 1){
            $(this).val(0);
        }else{
            $(this).val(1);
        }
        if($(this).val() == 1){
            $('.delivery_hide').css('display','');
        }else{
            $('.delivery_hide').css('display','none');
        }
    })

    $(document).on('click','#update_business', function(){
        var zone_id = $('#zone_id').val();
        var businessid = $('#businessid').val();
        var biz_name = $('#biz_name').val();
        var restaurant_type = $('#restaurant_type').val(); 
        var biz_motto = $('#biz_motto').val();
        var biz_about = $('#biz_about').val();
        var biz_history = $('#biz_history').val();
        var biz_contact_email = $('#biz_contact_email').val();   
        var biz_contactfirstname = $('#biz_contactfirstname').val();
        var biz_contactlastname = $('#biz_contactlastname').val(); 
        var biz_street_1 = $('#biz_street_1').val(); 
        var biz_street_2 = $('#biz_street_2').val(); 
        var biz_city = $('#biz_city').val();
        var biz_zip_code = $('#postalcode').val();
        var biz_zone = $('#biz_zone').val();
        var biz_state = $('#biz_state').val();
        var biz_phone = $('#biz_phone').val();
        var albiz_phone = $('#albiz_phone').val();
        var biz_website = $('#biz_website').val();
        var service_number=$('#service_number').val();
        var subusereixsts = $('#subusereixsts').val();
        if(biz_name == '' || biz_contact_email == '' || biz_contactfirstname == '' || biz_contactlastname == '' || biz_street_1 == '' || biz_zone == '' || biz_phone == ''){
            savingalert('warning','Please Fill Required Fields.');
            return false;
        }
        if(biz_zip_code == '' || biz_zip_code == -1){
            savingalert('warning','Please Fill Postal Code.');
            return false;
        }
        data = {
            'zone_id' : zone_id,
            'businessid' : businessid,
            'biz_name' : biz_name,
            'restaurant_type' : restaurant_type, 
            'biz_motto' : biz_motto,
            'biz_about' : biz_about,
            'biz_history' : biz_history,
            'biz_contact_email' : biz_contact_email,   
            'biz_contactfirstname' : biz_contactfirstname,
            'biz_contactlastname' : biz_contactlastname, 
            'biz_street_1' : biz_street_1, 
            'biz_street_2' : biz_street_2, 
            'biz_city' : biz_city,
            'biz_zip_code' : biz_zip_code,
            'biz_zone' : biz_zone,
            'biz_state' : biz_state,
            'biz_phone' : biz_phone,
            'albiz_phone' : albiz_phone,
            'biz_website' : biz_website,
            'service_number' : service_number,
            'subusereixsts' : subusereixsts
        }
        $.ajax({
            type:"POST",
            url:'/businessdashboard_update',
            data:data,
            dataType:'json',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function (res) {
                savingalert(res.type,res.msg); 
            }
        });  
    });

    $(document).on('click','#UpdateBusinessProfile', function(){
        var dataToUse = {
            "userid":user,
            "email":$('#jform_Email').val(),
            "firstname":$('#jform_Firstname').val(),
            "lastname":$('#jform_Lastname').val(),
            "busgender":$('#busgender').val(),
            "phone":$('#jform_Phone').val(),
            "address":$('#jform_Address').val(),
            "city":$('#jform_City').val(),
            "state":$('#jform_State').val(),
            "zip":$('#jform_Zip').val(),
            "subusereixsts":$('#subusereixsts').val(),
            
        };
        if($('#jform_Email').val() == '' || $('#jform_Firstname').val() == '' || $('#jform_Lastname').val() == '' || $('#jform_Phone').val() == ''){
            savingalert('warning','Please Fill Required Fields');
            return false;   
        }
        $.ajax({
            url: "/update_businessprofile", 
            dataType: 'json', 
            data: dataToUse,
            type: 'post',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function (res) {
                savingalert(res.type,res.msg);
            }
        });
    });
    $(document).on('change', '#selState', function(){
        var v = $(this).val();
        var zone_id = $('#zone_id').val();
        if(zone_id == '' || zone_id == 'undefined' || zone_id == undefined){
            var zone_id = $('#orgzoneid').val();
        }
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
        var get_zoneid = $('#zone_id').val();
        var subusereixsts = $('#subusereixsts').val();
        var subusereixsts= '';
        if(zip_code == '' || selState == '' || selzone == '' || org_type == '' || org_name == '' || org_username == '' || password == '' || cpassword == '' || uemail == '' || cemail == '' || fname == '' || lname == '' || phone_user == '' || user_address == ''){
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
            data:{'id': id, 'org_name':org_name, 'org_type':org_type, 'org_username': org_username,'org_password': org_password, 'org_email': org_email, 'city': city,'state': state, 'zip': zip, 'selzone':selzone, 'fname':fname, 'lname':lname, 'phone':phone, 'user_address':user_address, 'user_city':user_city, 'user_state':user_state, 'user_zip':user_zip, 'userid_for_registration':userid_for_registration, 'announcement_display':announcement_display, 'subusereixsts':subusereixsts},
            dataType:'json',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function (data) {
                savingalert('success','Organization Created Successfully');
                setTimeout(function () {
                    window.location.href = '/Zonedashboard/view_organization';
                 }, 2500);
            }
        });
    });

    $(document).on('click','#button_org_update', function(){
        var id = $('#uemail').attr('orgid');
        var userid = $('#uemail').attr('userid');
        var email =  $('#uemail').val();
        var first_name = $('#fname').val();
        var last_name = $('#lname').val();
        var orgname = $('#org_name').val();
        var phone = $('#phone_user').val();
        var Address = $('#user_address').val();
        var subusereixsts = $('#subusereixsts').val();
        $.ajax({
            type:"POST",
            url:'/update_organization',
            data:{'id': id, 'email':email, 'first_name':first_name, 'last_name': last_name,'orgname': orgname, 'phone': phone, 'Address': Address, 'userid': userid, 'subusereixsts': subusereixsts},
            dataType:'json',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function (d) {
                savingalert(d.type,d.msg);
                $('#closedeal').trigger('click');
                 setTimeout(function () {
                    window.reload();
                 }, 2500);
            }
        });
    });
    $(document).on('blur','#bitamount',function(){
        var amount = $(this).val();
        var zoneid = $("#payzoneid").val();
        var busid = $("#paybusid").val();
        var busname = $("#paybusname").val();
        var usertype = $("#user_type").val();
        if(amount < 30){
            $(this).val(30); 
            amount = 30;  
        }
        var url = window.location.origin+'/thankyou/'+zoneid+'?bid_amount='+amount+'&busid='+busid+'&zoneid='+zoneid+'&business_name='+busname+'&user_type=business';
        $('#paypalamount').val(amount);
        $('#return_data').val(url);
    });

    $(document).on('click','#order_category_business',function(){
        var subcat = $(this).data('id');
        var subtext = $(this).attr('text');
        var pagesidebar = $('#pagesidebar').val();
        $('.order_category_business').css('background','');
        $(this).css('background','#b8bfce');
        if(pagesidebar != 'ranksponsorsubcat'){
            window.location.href = "/Zonedashboard/ranksponsorsubcat?subcat="+subcat+""; 
            return false;
        }
        $('#getthenamecat').text(subtext);
        var zone_id = $('#zone_id').val();
        var html = '';
        var i = 0;
        $.ajax({
            url:'/categorysort',
            data:{'catid':subcat,'zoneid':zone_id},
            dataType:'json',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function(r){ 
                $(r).each(function(k,v){
                    i++;
                    // html+='<li class="draggable_div" style="position:relative;" businessid ="'+v.business_id+'"  data-adid="'+v.adid+'" id="'+v.business_id+'"><p>'+v.name+'</p> <button class="counter" title="sponsor Order" style="top: 0px; position:absolute; right: 0px;  padding: 3px 7px; border-radius: 15px;">'+i+'</button><input type="hidden" name="zoneid" class="zoneid" value="'+subcat+'"></li>';

                    html+='<li class="draggable_div1" zone_id="'+zone_id+'" subcat="'+subcat+'" style="position:relative;list-style:none;" businessid ="'+v.business_id+'"  data-adid="'+v.adid+'" id="'+v.business_id+'"><p>'+v.name+'</p> <button class="counter" title="sponsor Order">'+i+'</button></li>';
                });
                $('#sortable1').html(html);
            }
        }); 
    });

    $(document).on('click','#dsearch',function(){
        var startdate = $('#dstartdate').val();
        var stopdate = $('#dstopdate').val();
        if(startdate == ''){
            savingalert('warning','Start Date Should Not be Empty');
            return false;  
        }
        if(stopdate == ''){
            savingalert('warning','End Date Should Not be Empty');
            return false;  
        }
        var html = '';
        $.ajax({
            url:'/getclaimfeereport',
            data:{'startdate':startdate,'stopdate':stopdate,'zoneid':zone_id},
            async:false,
            dataType:'json',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function(r){ 
                if(r.length > 0){
                    $(r).each(function(k,v){
                        html += '<tr><td>'+v.company_name+'</td><td>'+v.first_name+' '+v.last_name+'</td><td>'+v.phone+'</td><td>'+v.dealId+'</td><td>'+v.deal_title+'</td><td>'+v.amountPurchased+'</td><td>'+publisher_fee+'</td><td>'+purchasedAt+'</td><td width="13%"><span class="showdealdetail cus-solid-prpl" busid="'+v.busId+'" zone_id="'+v.zoneId+'" dealmeta="'+v.id+'">Detail</span></td></tr>'; 
                    });
                }else{
                    html += 'No Record Found';
                }
                $('#claimdata').html(html);
            }
        });
    });
    $(".referalcopy").click(function(element){
        element.preventDefault();
        inputs =  jQuery(".referalcopy").attr('href'); 
        navigator.clipboard.writeText(inputs);
        alert('Copy to clipboard')
    });
    $(document).on('click','#updatepernfav',function(){
        var percentage = $('#nonper').val();
        var loginuser = $('#loginuser').val();
        if(percentage != 10 && percentage > 0){
            $.ajax({
                'url':"/saveNonFavPer",
                'data':{'percentage':percentage,'loginuser':loginuser},
                'dataType':'json',    
                beforeSend : function(){
                    $('#loading').css('display','block');
                },
                complete: function() {
                    $('#loading').css('display','none');
                },  
                success:function(r){
                    savingalert(r.type,r.msg);    
                }
            });   
        }
    });

    $(document).on('click','#rearrangebusiness',function(){
        var zone = $('#loginzoneid').val();
        var via = 'zonedashboard';
        if(zone){
            $.ajax({
                'url':"/rankbusiness/"+zone+"",
                'data':{'via':via},
                'dataType':'json',   
                beforeSend : function(){
                    $('#loading').css('display','block');
                },
                complete: function() {
                    $('#loading').css('display','none');
                },   
                success:function(r){
                    savingalert(r.type,r.msg); 
                    location.reload();  
                }
            });  
        }
    });

    $(document).on('click','#rearrangesubbusiness',function(){
        var zone = $('#loginzoneid').val();
        var via = 'zonedashboard';
        var i=0;
        var order=[];
        var subcat = "";
        $(".draggable_div1").each(function(i){
            var id=$(this).attr("data-adid");
            order.push(id);
            $('#'+$(this).attr('id')).find('.counter').text(i+1);
            zone_id = $(this).attr('zone_id');
            subcat = $(this).attr('subcat');
        });
        
        if(zone){
            $.ajax({
                'url':"/rankSubCatbusiness/"+zone+"",
                'data':{'via':via,'order':order,'subcat':subcat},
                'dataType':'json',   
                beforeSend : function(){
                    $('#loading').css('display','block');
                },
                complete: function() {
                    $('#loading').css('display','none');
                },   
                success:function(r){
                    savingalert(r.type,r.msg); 
                    location.reload();  
                }
            });  
        }
    });
    $(document).on('click','.close',function(){
        $('.modal').modal('hide');
    });

    $(document).on('click','#update_banner_org',function(){

        var uploadedInput1 = $('#uploadedInput1').val();
        var allcategories3 = $('#allcategories1').val();
        var uploadedInput = $('#uploadedInput1').val();
        var org_id = $('#org_id').val();
        var photo_id = $('#photo_id').val();
        var description = $('#org_description').val();
        var status = $('.org_status_check').val();
        $.ajax({
        'url':"/update_org_photo",
        'type': 'POST',
        'data':{'uploadedInput1':uploadedInput1,'allcategories3':allcategories3,'uploadedInput':uploadedInput,'org_id':org_id,'photo_id':photo_id,'description':description,'status':status},
        'dataType':'json', 
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },     
        success:function(r){
            savingalert(r.type,r.msg);   
            $('#editorgimages').modal('hide'); 
        }
        });
    });

    $(document).on('click','#submit_code_button', function(){
        var sel1 = $('#sel1').val();
        var embed_code = $('#embed_code').val();
        var zone_id = $('#orgzoneid').val();
        if(sel1 == ''){
            savingalert('warning','Please Select Category');
            return false;    
        }
        if(embed_code == ''){
            savingalert('warning','Please Select Payment Form Code');
            return false;    
        }
        $.ajax({
        'url':"/updatejotformcodes",
        'type': 'POST',
        'data':{'form_type_id':sel1,'codes':embed_code,'zone_id':zone_id},
        'dataType':'json', 
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },     
        success:function(r){
            if(r > 0){
                savingalert('success','Inserted Successfully'); 
                $('#embed_code').val('');    
            }else{
                savingalert('warning','Something Went Wrong'); 
            }
        }
    });
    })

    $(document).on('click','#search_buttonpboo', function(){
        var user_namepboo = $('#user_namepboo').val();
        var org_id = $('#org_id').val();
        if(user_namepboo == ''){
            savingalert('warning','Please Enter Username');  
            return false; 
        }
        $.ajax({
            'url':"/pboo_account_details",
            'type': 'POST',
            'data':{'username':user_namepboo,'payer_id':org_id,'payer_type':'org'},
            'dataType':'json',    
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },  
            success:function(r){
                if(r.status == 'nousers'){
                    savingalert('warning','Sorry No user Found with your search result'); 
                    $('#user_namepboo').val('');    
                }else{
                    savingalert('warning','Something Went Wrong'); 
                }
            }
        });
    });
    
    $(document).on('click','#spreadsheet_download_button', function(){
        var organization_id = $(this).attr('data-organization-id');
        window.location = '/speradsheet_list_data/'+organization_id+'/org';
    });

    $(document).on('click','.acceptreject',function(){
        var orderid = $(this).attr('orderid');
        var ordertype = $(this).attr('ordertype');
        var busid = $(this).attr('busid');
        var $this = $(this);
        Approverejectorder(orderid,ordertype,busid,$this);
        
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
            'beforeSend':function(){ },            
            'success': function(r) {
                if(r.type == 'success'){
                    if(group == 5){
                        redirect=baseUrl+'/businessdashboard/'+r.id;
                    }
                    if(group == 8){
                        redirect=baseUrl+'/organizationdashboard/'+r.id+'/';
                    }
                    if(group == 10 || group == 7 || group == 15){
                        location.reload();
                    }else{
                        window.location=redirect;
                    }
                } 
            }
        });
    });

    $(document).on('click','#subcatimagecheck', function(){
        if($('#subcatimagebutton').is(':checked') == true){
            $('#subcatimagebutton').val(2);
        }else{
            $('#subcatimagebutton').val(1);
        }
    });
    
    $(document).on('click','#zoneeverydayspecial,#zoneorganization,#zonebusinessdeals,#zoneadvertisement,#zonebusiness,#zonecategories,#zonesubuser,#zoneseetings',function(){
        if($(this).is(':checked') == true){
            var childclass = $(this).attr('childsub');
            addremovesubchilds(childclass);
        }
        if($(this).is(':checked') == false) {
            var childclass = $(this).attr('childsub');
              $('.'+childclass).prop('checked', false);
        }
        
    });

    $(document).on('click','#save_subuser',function(){
        var subusereditid = $('#subusereditid').val();
        var fname = $('#fname').val();
        var lname = $('#lname').val();
        var email = $('#email').val();
        var confirmemail = $('#confirmemail').val();
        var username = $('#zoneusername').val();
        var password = $('#zonepassword').val();
        var confirmpassword = $('#zoneconfirmpassword').val();
        var zoneid = $('#zone_id').val();
        var type = $('#subusertypeway').val();
        var businessid = $('#businessid').val();
        var subusereixsts = $('#subusereixsts').val();
        var zonesubuserzipcodes = $('#zonesubuserzipcodes').val();
        var subuserpermission = [];
        if(fname == '' || lname == '' || email == '' || confirmemail == '' || username == '' || password == '' || confirmpassword == ''){
            savingalert('warning','Please Fill Required Fields.');
            return false;    
        }
        if(email != confirmemail){
            savingalert('warning','Email and Confirm Email must be same');
            return false;   
        }
        if(password != confirmpassword){
            savingalert('warning','Password and Confirm Password must be same');
            return false;   
        }
        $('.zonesettingssub').each(function(){
            if($(this).is(':checked') == true){
                var ids = $(this).attr('id');
                subuserpermission.push(ids); 
            }
        });
        $('.zonesubusersub').each(function(){
            if($(this).is(':checked') == true){
                var ids = $(this).attr('id');
                subuserpermission.push(ids); 
            }
        });
        $('.zonecategoriessub').each(function(){
            if($(this).is(':checked') == true){
                var ids = $(this).attr('id');
                subuserpermission.push(ids); 
            }
        });
        $('.zonebuainesssub').each(function(){
            if($(this).is(':checked') == true){
                var ids = $(this).attr('id');
                subuserpermission.push(ids); 
            }
        });
        $('.zoneadvertisementsub').each(function(){
            if($(this).is(':checked') == true){
                var ids = $(this).attr('id');
                subuserpermission.push(ids); 
            }
        });
        $('.zonebusinesssub').each(function(){
            if($(this).is(':checked') == true){
                var ids = $(this).attr('id');
                subuserpermission.push(ids); 
            }
        });
        $('.zoneorganizationsub').each(function(){
            if($(this).is(':checked') == true){
                var ids = $(this).attr('id');
                subuserpermission.push(ids); 
            }
        });
        $('.zoneeverydayspecialsub').each(function(){
            if($(this).is(':checked') == true){
                var ids = $(this).attr('id');
                subuserpermission.push(ids); 
            }
        });
        if($('#zoneeverydayspecial').is(':checked') == true){
            var ids = $('#zoneeverydayspecial').attr('ids');
            subuserpermission.push(ids);
        }
        if($('#zoneorganization').is(':checked') == true){
            var ids = $('#zoneorganization').attr('ids');
            subuserpermission.push(ids);
        }
        if($('#zonebusinessdeals').is(':checked') == true){
            var ids = $('#zonebusinessdeals').attr('ids');
            subuserpermission.push(ids);
        }
        if($('#zoneadvertisement').is(':checked') == true){
            var ids = $('#zoneadvertisement').attr('ids');
            subuserpermission.push(ids);
        }
        if($('#zonebusiness').is(':checked') == true){
            var ids = $('#zonebusiness').attr('ids');
            subuserpermission.push(ids);
        }
        if($('#zonecategories').is(':checked') == true){
            var ids = $('#zonecategories').attr('ids');
            subuserpermission.push(ids);
        }
        if($('#zonesubuser').is(':checked') == true){
            var ids = $('#zonesubuser').attr('ids');
            subuserpermission.push(ids);
        }if($('#zoneseetings').is(':checked') == true){
            var ids = $('#zoneseetings').attr('ids');
            subuserpermission.push(ids);
        }
        $.ajax({
            'type':'POST',
            'url':'/save_sub_zoneuser',
            'data':{'subusereditid':subusereditid,'fname':fname,'lname':lname,'email':email,'username':username,'password':password,'zoneid':zoneid,'data':subuserpermission,'type':type,'businessid':businessid,'subusereixsts':subusereixsts,'zonesubuserzipcodes':zonesubuserzipcodes},
            'dataType':"json",
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },          
            'success': function(r) {
                savingalert(r.type,r.msg); 
                if(r.type == 'success'){
                    $('.zonesettingssub').prop('checked', false);
                    $('.zonesubusersub').prop('checked', false);
                    $('.zonecategoriessub').prop('checked', false);
                    $('.zonebuainesssub').prop('checked', false);
                    $('.zoneadvertisementsub').prop('checked', false);
                    $('.zonebusinesssub').prop('checked', false);
                    $('.zoneorganizationsub').prop('checked', false);
                    $('.zoneeverydayspecialsub').prop('checked', false);
                    $('#zoneeverydayspecial').prop('checked', false);
                    $('#zoneorganization').prop('checked', false);
                    $('#zonebusinessdeals').prop('checked', false);
                    $('#zoneadvertisement').prop('checked', false);
                    $('#zonebusiness').prop('checked', false);
                    $('#zonecategories').prop('checked', false);
                    $('#zonesubuser').prop('checked', false);
                    $('#zoneseetings').prop('checked', false);
                    $('#fname').val('');
                    $('#lname').val('');
                    $('#email').val('');
                    $('#confirmemail').val('');
                    $('#zoneusername').val('');
                    $('#zonepassword').val('');
                    $('#zoneconfirmpassword').val('');
                    location.reload();
                }  
            }
        });
    });
    
    $(document).on('change','#twiliofileselect', function(){
        var val = $(this).val();
        if(val == 'audio'){
            $('#newrecorddiv').removeClass('hide');
            $('#newuploaddiv').addClass('hide');
        }else{
            $('#newrecorddiv').addClass('hide');
            $('#newuploaddiv').removeClass('hide');
        }
    }); 

    $(document).on('click','.savecommumethod', function(){
        var busid = $(this).attr('busid');
        var method = $(this).closest('tr').find('.compmethod:checked').val();
        $.ajax({
            url : '/save_commumethod',
            type : 'POST',
            data : {'busid':busid, 'method': method},
            dataType:'json',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success : function(r) {
            savingalert(r.type,r.msg);    
            }
        });
    });

    $(document).on('click','.blogmethod', function(){
        var status = $(this).val();
        var blogid = $(this).attr('ids');
        $.ajax({
            url : '/save_blogumethod',
            type : 'POST',
            data : {'status':status, 'blogid': blogid},
            dataType:'json',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success : function(r) {
            savingalert(r.type,r.msg);    
            }
        });
    });
          //$(".compmethod1").prop("checked", true);
    $('.compmethod1').change(function(){
        if (!$('#subcat').is(":checked")) {
            $('#selectsec').attr('disabled','disabled');
        }
        else {
            $('#selectsec').removeAttr('disabled');
        }
    });
    $(document).on('click','.compmethod1', function(){
        var method = $(this).closest('tr').find('.compmethod2').prop('checked', false); 
    });
    $(document).on('click','.compmethod2', function(){
        var method = $(this).closest('tr').find('.compmethod1').prop('checked', false); 
    }); 

    $(document).on('click','.blogmethod1', function(){
        var method = $(this).closest('tr').find('.blogmethod2').prop('checked', false); 
    });
    $(document).on('click','.blogmethod2', function(){
        var method = $(this).closest('tr').find('.blogmethod1').prop('checked', false); 
    }); 

    $(document).on('click','.saveapprovaldpa', function(){
        var status = $(this).closest('tr').find('.approvaldpaselect').val(); 
        var id = $(this).attr('ids');
        $.ajax({
            url : '/chnage_approvaldpa',
            type : 'POST',
            data : {'status':status, 'id': id},
            dataType:'json',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success : function(r) {
            savingalert(r.type,r.msg);    
            }
        });
    });

    $(document).on('click','.dpaexceldown', function(){
        var zoneid = $('#zone_id').val();
        var val = $('.dpaexcel').val();
        var baseurl = window.location.origin;
        var url = '/downloadcsvdpa?status='+val+'&zoneid='+zoneid+''; 
        if(val == ''){
            savingalert('warning','Please Select Status Type');
            return false;     
        }
        window.open(url);
    });   

    $(document).on('click','.deletebuisness', function(){
        var busid = $(this).attr('busid');
        var $this = $(this);
        $.ajax({
            url : '/del_business',
            type : 'POST',
            data : {'busid':busid},
            dataType:'json',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success : function(d) {
                savingalert(d.type,d.msg);
                $this.closest('tr').remove();         
            }
        });
    });

    $(document).on('click','.bidinfosend', function(){
        var busid = $(this).attr('busid');
        var busname = $(this).attr('busname');
        var action = $(this).attr('action');
        var $this = $(this);
        var zoneid = $('#zone_id').val();
        $.ajax({
            url : '/bidpendingaction',
            type : 'POST',
            data : {'busid':busid,'action':action,'busname':busname,'zoneid':zoneid},
            dataType:'json',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success : function(d) {
                savingalert(d.type,d.msg);
                $this.closest('tr').remove();         
            }
        });
    });
    $(document).on('click','.dpareschedule', function(){
        $.ajax({
            url : '/rescheduleapprovedbus',
            type : 'POST',
            dataType:'json',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success : function(d) {
                savingalert(d.type,d.msg);         
            }
        });
    });

    // $(document).on('click','.testconncheck', function(e){
    //     e.preventDefault();
    //     alert('here');
    //     var host = $('#hostname').val(); 
    //     var user = $('#username').val();
    //     var pass = $('#password').val();
    //     var port = $('#port').val();
    //     alert(port)
        // $.ajax({
        //     url : '/rescheduleapprovedbus',
        //     type : 'POST',
        //     dataType:'json',
        //     beforeSend : function(){
        //         $('#loading').css('display','block');
        //     },
        //     complete: function() {
        //         $('#loading').css('display','none');
        //     },
        //     success : function(d) {
        //         savingalert(d.type,d.msg);         
        //     }
        // });
   // });

    $(document).on('click','#emailserversave', function(e){
        e.preventDefault();
        var zone = $('#zone_id').val();    
        $('#zoneemail').val(zone);
         //alert("here");
        // return false;
        // var host = $('#hostname').val(); 
        // var user = $('#username').val();
        // var pass = $('#password').val();
        // var port = $('#port').val();
        var form = $("#formId");
        //form.append('zone', zone);
        $.ajax({
            url : '/emailserversave',
            type : 'POST',
            // data : {'host':host,'user':user,'pass':pass,'port':port,'zone':zone},
            data: form.serialize(),
            dataType:'json',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success : function(d) {
                savingalert(d.type,d.msg);
                window.location.reload(true);         
            }
        });
    });

    $(document).on('click','#deleteconf', function(e){
          e.preventDefault();
       if (confirm('Are You Sure to Delete')) {
        var delid =$(this).attr('delid');
        var $this = $(this);
        $.ajax({
            url : '/deltemailblgid',
            type : 'GET',
            data : { 'delid':delid },
            dataType:'json',
            success : function(data) {
                console.log(data);  
                if(data==1){
                    alert('Your Date Deleted Successfully');
                    $this.closest('tr').remove();
                } else{
                    alert('Something went wrong');
                }  
            }
        });
      
    } else {
        alert('Why did you press cancel? You should have confirmed');
     }     
    });
    $(document).on('click','.addnewrow', function(){
        var html = '<br><div class="row duplicatediv"><div class="col-md-3"><input class="form-control" type="text" id="hostname" placeholder="Enter Hostname/Mail Server" /></div><div class="col-md-3"><input class="form-control" type="text" id="username" placeholder="Enter Username" /></div><div class="col-md-2"><input class="form-control" type="password" id="password" placeholder="Enter Password" /></div><div class="col-md-2"><input class="form-control" type="number" id="port" placeholder="Enter Port" /></div><div class="col-md-2"><button class="btn btn-info addnewrow">Add Row</button></div></div><br>';
        $('.duplicatediv').after(html);
        $(this).closest('.row').removeClass('duplicatediv');
        $(this).remove();
    });

    $(document).on('click','.closebidbutton', function(){
        $('.bidnowbox').addClass('hide');
    });



    $('#postalcode').select2({
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

    $(document).on('click','.businesssnapbutton', function(){
        var busid = $(this).attr('busid');
        var zoneid = $(this).attr('zoneid');
        var snapemailusers = $('.snapemailusers').text();
        if(parseInt(snapemailusers) == 0){
            savingalert('warning','Snap Email User Not Found');
            return false;   
        }
        $.ajax({
            type: "POST",
            url:'/sendsnapemailuser',
            data:{'busid':busid,'zoneid':zoneid},
            dataType: "json",
            success: function(r){
                savingalert(r.type,r.msg);
            }
        });
    });
});

$('.snapbusinessmodalclose').on('click', function() {
    $('#snapbusinessmodal').modal('hide');
});

$(document).on('click','.readsnapbusinessmodal', function(){
    $('#snapbusinessmodal').modal({backdrop: 'static', keyboard: false}, 'show');
    $('#snapbusinessmodal').modal('show');
});

$(document).on('click','.businesssnapaddtolist', function(){
    var deallistsnapbusiness = $('#deallistsnapbusiness').find(":selected").val();
    var deallistsnapbusinesstext = $('#deallistsnapbusiness').find(":selected").text();

    var bussnapstarttime = $('.bussnapstarttime').find(":selected").val();
    var bussnapstarttimetext = $('.bussnapstarttime').find(":selected").text();

    var bussnapendtime = $('.bussnapendtime').find(":selected").val();
    var bussnapendtimetext = $('.bussnapendtime').find(":selected").text();
    
    var noofpeoplesnaptime = $('#noofpeoplesnaptime').val();

    var snapsendtype = 0;
    var noofpeople = '';
    if(deallistsnapbusiness == ''){
        savingalert('warning','Please Select Atleast One Deal');
        return false;   
    }
    if(noofpeoplesnaptime == ''){
        savingalert('warning','Please Add Number of people Allowed');
        return false;   
    }
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
                <div class="snaplistsubdiv" dayid="`+perdayselect+`" starttime="`+bussnapstarttime+`" endtime="`+bussnapendtime+`" noofpeople="`+noofpeople+`" snapsendtype="`+snapsendtype+`" snapdealid="`+deallistsnapbusiness+`">`+deallistsnapbusinesstext+`<br> `+dayword+` `+bussnapstarttimetext+`-`+bussnapendtimetext+` `+noofpeople+`<span class="snaplistsubspan">X</span></div></div>`;
        }    
    });
    
    if(checkday == 0){
        savingalert('warning','Please check atleast snap week days');
        return false;    
    }
    
    $('#snaptimelist').append(html);

    $('.lastupdatemobilediv').removeClass('hide');
    $('.savesnapforbusiness').removeClass('hide');
    $('.bussnapstarttime').val(1).prop('selected', true);
    $('.bussnapendtime').val(1).prop('selected', true);
    $('#deallistsnapbusiness').val('').trigger('change');
    $('#alldays').prop('checked', false);
    $('#weekdays').prop('checked',false);
    $('#weekends').prop('checked', false);
    $('.perdayselect').prop('checked', false);
    $('#noofpeoplesnaptime').val('');
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

$(document).on('click','.copyshorturl', function(){
    var url = $(this).attr('link');
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val(url).select();
    document.execCommand("copy");
    $temp.remove();
    savingalert('success','business Url copied'); 
});

$(document).on('click','.editshorturlicon', function(){
    $('.showshorturl').addClass('hide'); 
    $('.editshorturlicon').addClass('hide'); 
    $('.updateshorturl').removeClass('hide'); 
    $('.editshorturl').removeClass('hide'); 
    $('#shorturlchange').focus();
});

$(document).on('click','.updateshorturl', function(){
    var shorturl = $('#shorturlchange').val();
    var businessid = $('#businessid').val();
    if(shorturl){
        $.ajax({
            type: "POST",
            url:'/updateshorturl',
            data:{'shorturl':shorturl,'businessid':businessid},
            dataType: "json",
            success: function(r){
                if(r.type == 'warning'){
                    savingalert(r.type,r.msg);
                }else{
                    savingalert(r.type,r.msg);  
                }
            }
        });
    }else{
        savingalert('warning','Short url should not be empty');     
    }
});

$(document).on('click','.buttonsubmitsponser', function(e){
    e.preventDefault();
    var data = new FormData(document.getElementById("sponserForm"));
    data.append('zoneid',$('#zone_id').val());
    $.ajax({
        type: "POST",
        url:'/saveSponser',
        data:data,
        enctype: 'multipart/form-data',
        processData: false,  
        contentType: false,
        dataType: "json",
        success: function(r){
            if(r.type == 'warning'){
                savingalert(r.type,r.msg);
            }else{
                savingalert(r.type,r.msg);  
                location.reload();
            }
        }
    });
});

$(document).on('click','.addbusinesssponsorbanner', function(e){
    e.preventDefault();
    var sponsorbusinessid = $('#sponsorbusinessid').val();
    var loginuser = $('#loginuser').val();
    var data = new FormData(document.getElementById("businesssponserForm"));
    data.append('zoneid',$('#zone_id').val());
    data.append('sponsorbusinessid',sponsorbusinessid);
    data.append('loginuser',loginuser);
    $.ajax({
        type: "POST",
        url:'/savebusinesssponserbanner',
        data:data,
        enctype: 'multipart/form-data',
        processData: false,  
        contentType: false,
        dataType: "json",
        success: function(r){
            if(r.type == 'warning'){
                savingalert(r.type,r.msg);
            }else{
                savingalert(r.type,r.msg);
                var sessionzone = $('#sessionzone').val();
                window.location.href = '/Sponsor/view_business_sponsor_banner'; 
            }
        }
    });
});

$(document).on('click','.gotoediturl', function(){
    $(this).closest('tr').find('.updatedlink').removeClass('hide');
    $(this).closest('tr').find('.editurlgrocerylink').removeClass('hide');
    $(this).closest('tr').find('.gotoediturl').addClass('hide');
    $(this).closest('tr').find('.editurlshow').addClass('hide');
});

$(document).on('click','.editurlgrocerylink', function(e){
    e.preventDefault();
    var updatelink = $(this).closest('tr').find('.updatedlink').val();
    var storeid = $(this).closest('tr').find('.storeid').val();
    $(this).closest('tr').find('.updatedlink').addClass('hide');
    $(this).closest('tr').find('.editurlgrocerylink').addClass('hide');
    $(this).closest('tr').find('.gotoediturl').removeClass('hide');
    $(this).closest('tr').find('.editurlshow').removeClass('hide').text(updatelink);
    $.ajax({
        type: "POST",
        url:'/editurlgrocerylink',
        data:{'updatelink':updatelink,'storeid':storeid},
        dataType: "json",
        success: function(r){
            if(r.type == 'warning'){
                savingalert(r.type,r.msg);
            }else{
                savingalert(r.type,r.msg);  
            }
        }
    });
});

$(document).on('change','.statuseditchange', function(e){
    var id = $(this).attr('ids');
    var status = $(this).val();
    $.ajax({
        type: "POST",
        url:'/editSponser',
        data:{'id':id,'status':status},
        dataType: "json",
        success: function(r){
            if(r.type == 'warning'){
                savingalert(r.type,r.msg);
            }else{
                savingalert(r.type,r.msg);  
            }
        }
    });
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
$(document).on('click','#preview_auction',function(){ 
        var userid = $('input[name=user_id]').val();
        var id =  $('#deal_description').attr('dealid');
        var purchaseID = $('#deal_description').attr('dealproductid');
        var zoneid = $('#deal_description').attr('dealzone');
        var via = 'zonedashboard';
        
        $.ajax({
            url : '/get_certificate',
            type : 'GET',
            data : {'id':id, 'purchaseID':purchaseID, 'zoneid':zoneid,'userid':userid,'via':via},
            dataType:'json',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success : function(data) {
                $('.certificate_view1 .modal-body').html(data.html); 
                $('.certificate_view1').modal('show');      
            }
        });
        
        
    });

function username_verification(){
    
} 

function addremovesubchilds(childclass){
    $('.'+childclass).prop('checked', true);
}

function Approverejectorder(orderid,ordertype,busid,$this){
    $.ajax({
        'url':"/setorderApprovals",
        'type': 'POST',
        'data':{'orderid':orderid,'ordertype':ordertype},
        'dataType':'json',  
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },    
        success:function(r){
            checkorderapproval(busid);
            $this.closest('div').remove();
        }
    });   
}

function rejectorder(busid){
    var orderId = $('#approverejectorderid').val();
    if(orderId){
        $.ajax({
            'url':"/setorderreject",
            'type': 'POST',
            'data':{'busid':busid,'orderId':orderId},
            'dataType':'json', 
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },     
            success:function(r){
                savingalert(r.type,r.msg);
                $('#orderapprovaldiv').html('');
            }
        });
    }
}

function checkorderapproval(busId){
    var type = 'jspage';
    $.ajax({
        'url':"/allorderApprovals",
        'type': 'GET',
        'data':{'busId':busId,'type':type},
        'dataType':'json', 
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },     
        success:function(r){
            $('#orderapprovaldiv').html('');
            var top = 10;
            var left= 30;
            var index = 1;
            var idArr = [];
            $(r).each(function(k,v){
                idArr.push(v.id);
                html ='<div class="order-pop" style="top: '+top+'%;left: '+left+'%;z-index: '+index+';"><img src="https://savingssites.com/assets/images/shopping-cart.png"><h2><center>New Order</center</h2><h4><center>Order Number: '+v.id+'</center></h4><p><center>'+v.itemqty+' Items $'+v.itemprice+'.00 Cash <center></p><p><button class="acceptreject orderaccept" ordertype="A" orderid="'+v.id+'" busid="'+busId+'">Accept Order</button><button class="acceptreject orderreject"  ordertype="R" orderid="'+v.id+'" busid="'+busId+'">Reject Order</button></p></div>';
                top = top+10;
                left = left+10;
                index = index+1;
                $('#orderapprovaldiv').append(html);
            });
            var ordeid = idArr.join(',');
            $('#approverejectorderid').val(ordeid);
        }
    });
}

function showallCategory(org_id){
    var html = ''; 
    $.ajax({
        'url':"/getallcategory",
        'type': 'GET',
        'data':{'org_id':org_id},
        'dataType':'json',  
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },    
        success:function(r){
            $(r).each(function(k,v){
                html += `<tr><td style="text-align: center;">`+v.id+`</td>
                <td style="text-align: center;">`+v.name+`<div class="editcategory`+v.id+`" style="display:none"><input type="text" id="cat_name`+v.id+`" value="`+v.name+`" maxlength="30" /><input type="hidden" id="cat_id`+v.id+`" value="`+v.id+`" /><button id="`+v.id+`" onclick="editCategory(`+v.id+`);">Update</button><button id="`+v.id+`" onclick="cancelEdit(`+v.id+`);">Cancel</button></div><td style="text-align: center;"><button onclick="editCategoryDiv(`+v.id+`,'`+v.name+`',`+org_id+`);" id="`+v.id+`_`+v.name+`">Edit</button>&nbsp;<button id="`+v.id+`" onclick="deleteCategory(`+v.id+`,`+org_id+`);">Delete</button></td></tr>`;
            });
            $('#all_category').html(html);
        }
    });
}

function editCategoryDiv(catid, description,org_id){
    var html = `<div><table><tr>
            <input type="hidden" name="org_id" id="catidorg" value=`+catid+`>
            <td>Category Name</td>
            <td><textarea name="description" id="add_desccategory" maxlength="50">`+description+`</textarea></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td class="cat_block1">
            <input type="button" name="Submit" onclick="editCategory()" id="update_interest_group" value="Save" class="bttn">
            </td>
        </tr>
    </div>`;
    $('#headertitle').text("Update Organization Category");
    $('#orginterestgroupdata').html(html);
    $('#orginterestgroup').modal('show');
}

function EditBroadcast(brodcastd){
    var zoneid = $('#orgzoneid').val();
    var org_id = $('#org_id').val();
    var url = baseurl+'/organizationdashboards/'+org_id+'new_broadcast?brodcastid='+brodcastd+'';
    var newtab = window.open(url);
}

function saveCategory(){
    var category = $('#category_text').val(); 
    var org_id = $('#org_id').val(); 
    if(category == ''){
        savingalert('warning','Please Enter a Category Name.');
        return false;
    }
    $.ajax({
        'url':"/save_category",
        'type': 'POST',
        'data':{'org_id':org_id,'category':category},
        'dataType':'json', 
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },     
        success:function(r){
            savingalert(r.type,r.msg); 
            $('#category_text').val('');    
        }
    });
}

function editCategory(){
    var catid = $('#catidorg').val(); 
    var org_id = $('#org_id').val(); 
    var desc = $('#add_desccategory').val(); 
    if(desc == ''){
        savingalert('warning','Please Enter a Category Name.');
        return false;
    }
    $.ajax({
        'url':"/edit_category",
        'type': 'POST',
        'data':{'org_id':org_id,'id':catid,'name':desc},
        'dataType':'json', 
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },     
        success:function(r){
            savingalert(r.type,r.msg); 
            $('#orginterestgroup').modal('hide');
            showallCategory(org_id);    
        }
    });
}

function deleteCategory(catid,org_id){
    if (confirm('Are You Sure to Delete ')) {
        $.ajax({
            'url':"/delete_category",
            'type': 'POST',
            'data':{'id':catid},
            'dataType':'json',  
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },    
            success:function(r){
                savingalert(r.type,r.msg); 
                showallCategory(org_id);
            }
        });
    }
}

function SaveAnnouncement(){
    var all_categories = $('#all_categories').val();
    var announcement_title = $('#announcement_title').val();
    var announcement_text = $('#announcement_text').val();
    var org_id = $('#org_id').val();
    var orgzoneid = $('#orgzoneid').val();
    var id = $('#announcementid').val();
    
    if(all_categories == ''){
        savingalert('warning','Please Select Category');
        return false;   
    }
    if(announcement_title == ''){
        savingalert('warning','Please Enter Announcement Title');
        return false;   
    }
    if(announcement_text == ''){
        savingalert('warning','Please Enter Announcement Text');
        return false;   
    }
    
    var dataToUse = {
        'zone_id': orgzoneid,     
        'organization_id': org_id,
        'title':announcement_title,
        'announcement_text': announcement_text,
        'category': all_categories,
        'announcement_type':0,
        'id':id,
    };  
    $.ajax({
        'url':"/save_org",
        'type': 'POST',
        'data':dataToUse,
        'dataType':'json',     
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        }, 
        success:function(r){
            savingalert(r.type,r.msg); 
            $('#all_categories').val('').trigger('change'); 
            $('#announcement_title').val(''); 
            $('announcement_text').val('');   
            $('announcement_text').html('');  
            showallannouncement(org_id); 
            $('#orginterestgroup').modal('hide');
        }
    });
}

function showallannouncement(org_id){ 
    var fromzoneid = $('#fromzoneid').val();
    var html = '';
    $.ajax({
        'url':"/viewmoreannouncement",
        'type': 'GET',
        'data':{'org_id':org_id,'fromzoneid':fromzoneid},
        'dataType':'json',   
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },   
        success:function(r){
            console.log(r);
            $(r).each(function(k,v){
                html += `<tr id="`+v.id+`"><td width="20%">`+v.title+`</td><td width="60%" style="text-align:left;" class="responsive-image">`+v.announcement+`</td><td width="20%"><input type="hidden" name="org_ann_id" id="org_ann_id" value="`+v.id+`" /><a href="javascript:void(0);"><button class="editButton m_top_1" onclick="EditAnnouncement(`+v.category+`,`+v.id+`,'`+v.title+`','`+v.announcement+`')">Edit</button></a><button class="deleteButton m_top_10" onclick="DeleteAnnouncement(`+fromzoneid+`,`+v.id+`,`+org_id+`)">Delete</button></td></tr>`;
            });
            $('#showannouncement').html(html);
        }
    });
}

function EditAnnouncement(catid,id, title,description){
    var html = `<div><table><tr>
            <input type="hidden" name="org_id" id="announcementid" value=`+id+`>
            <input type="hidden" name="org_id" id="all_categories" value=`+catid+`>
            <td>Title</td>
            <td><input type="text" id="announcement_title" name="announcement_title" class="w_536" placeholder="Specify Announcement Name" value="`+title+`"></td>
        </tr>
        <tr>
        <td>Announcement Text</td>
            <td><textarea name="description" id="announcement_text" maxlength="50">`+description+`</textarea></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td class="cat_block1">
            <input type="button" name="Submit" onclick="SaveAnnouncement()" id="update_interest_group" value="Save" class="bttn">
            </td>
        </tr>
    </div>`;
    $('#headertitle').text("Update Announcement");
    $('#orginterestgroupdata').html(html);
    $('#orginterestgroup').modal('show');
}



function save_group(zoneid,createdby_id,createdby_type){ 
    var group_name = $('#group_name').val(); 
    var group_desc = $('textarea#add_descgroup').val();
    var group_id = -1;
        
    if(group_name == ''){
        savingalert('warning','Please Enter Group Name');  
        return false;    
    }
    if(group_desc == ''){
        savingalert('warning','Please Enter Group Description');  
        return false;    
    }
    var dataToUse = {
        'zoneid':zoneid,
        'createdby_id':createdby_id,
        'createdby_type':createdby_type,
        'group_id':group_id,
        'group_name':group_name,
        'group_desc':group_desc,
    };
    $.ajax({
        'url':"/save_group",
        'type': 'POST',
        'data':dataToUse,
        'dataType':'json', 
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },     
        success:function(r){
            savingalert(r.type,r.msg); 
            $('#group_name').val(''); 
            $('textarea#add_descgroup').val('');   
        }
    });
}

function display_ig(zoneid,createdby_id,createdby_type,ig_type){
    var dataToUse = {
        'zoneid':zoneid,
        'createdby_id':createdby_id,
        'ig_type':ig_type,
        'createdby_type':createdby_type
    }
    var html = '';
    $.ajax({
        'url':"/display_ig",
        'type': 'GET',
        'data':dataToUse,
        'dataType':'json', 
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },     
        success:function(r){
            $(r).each(function(k,v){
                html += `<tr id="`+v.id+`"><td style="width:65%; text-align:center;">`+v.name+`</td>
                <td style="width:30%; text-align:center;"><button id="`+v.id+`" class="savelistedad" onclick="edit_group(`+v.id+`,`+zoneid+`,`+createdby_id+`,`+v.createdby_type+`,'`+v.name+`','`+v.description+`')">Edit</button><button id="`+v.id+`" class="savelistedad" onclick="delete_group(`+v.id+`,`+zoneid+`,`+createdby_id+`,`+v.createdby_type+`)">Delete</button></td></tr>`;
            });
            $('#interestgroupdata').html(html);
        }
    });
}

function edit_group(group_id,zoneid,createdby_id,createdby_type,group_name,description){ 
    var html = `<div><table><tr>
            <input type="hidden" name="uploadedInput1" id="interestgroup_id" value=`+group_id+`>
            <input type="hidden" name="photo_id" id="interestgroupzone" value=`+zoneid+`>
            <input type="hidden" name="org_id" id="interestorg_id" value=`+createdby_id+`>
            <input type="hidden" name="org_id" id="interescreatedby_type" value=`+createdby_type+`>
            <td>Group Name</td>
            <td><input type="text" id="group_name" class="w_300" name="group_name" value="`+group_name+`"></td>
        </tr>
        <tr>
            <td>Description:</td>
            <td><textarea name="description" id="add_descgroup" maxlength="50">`+description+`</textarea></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td class="cat_block1">
            <input type="button" name="Submit" onclick="update_interest_group()" id="update_interest_group" value="Save" class="bttn">
            </td>
        </tr>
    </div>`;
    $('#orginterestgroupdata').html(html);
    $('#orginterestgroup').modal('show');
}

function update_interest_group(){
    var interestgroup_id = $('#interestgroup_id').val();
    var interestorg_id = $('#interestorg_id').val();
    var interescreatedby_type = $('#interescreatedby_type').val();
    var group_name = $('#group_name').val();
    var add_descgroup = $('#add_descgroup').val();
    var interestgroupzone = $('#interestgroupzone').val();
    $.ajax({
        'url':"/save_group",
        'type': 'POST',
        'data':{'group_id':interestgroup_id,'createdby_id':interestorg_id,'createdby_type':interescreatedby_type,'group_name':group_name,'group_desc':add_descgroup,'zoneid':interestgroupzone},
        'dataType':'json',  
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },    
        success:function(r){
            savingalert(r.type,r.msg);  
            $('#orginterestgroup').modal('hide');
            location.reload();  
        }
    });
}

function save_org_photo(){
    var category = $('#allcategories').val();
    var img = $('#uploadedInputorg').val();
    var org_id = $('#org_id').val();
    if(category == '' || category == -1){
        savingalert('warning','Please select a category');  
        return false;
    }
    if(img == ''){
        savingalert('warning','Please upload a file or please wait for few minutes to upload the file');  
        return false;   
    }
    $.ajax({
        'url':"/save_org_photo",
        'type': 'POST',
        'data':{'organizationid':org_id,'allcategories':category,'uploadedInput':img},
        'dataType':'json', 
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },     
        success:function(r){
            savingalert(r.type,r.msg);    
        }
    });
}

function view_org_photo(){
    var catid = $('#allcategories1 option:selected').val();
    var orgnid = $('#org_id').val();
    var dataToUse = {catid:catid, orgnid:orgnid};
    var baseurl = window.location.origin;
    var html = '';
    if(catid && orgnid){
        $.ajax({
        'url':"/view_org_photo",
        'type': 'GET',
        'data':dataToUse,
        'dataType':'json', 
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },     
        success:function(r){
            if(r.length > 0){
                html += '<ul>';
                $(r).each(function(k,v){
                    html += `<li id='banner_`+v.id+`'><span class="dragdropimage"><img style="width:250px !important;" src=https://cdn.savingssites.com/`+v.image_name+` width='220px'/></span><div style="margin-top:5px;"><button id=`+v.id+` class='editgrp' onclick='edit_org_photo(`+v.id+`,`+orgnid+`,"`+v.image_name+`","`+v.description+`")'>Edit</button><button id=`+v.id+` class='deletegrp' onclick='delete_org_photo(`+v.id+`,`+orgnid+`,`+v.cat_id+`,"`+v.image_name+`")'>Delete</button></div></li>`;
                });
                html += '</ul>';
                $('#orgimagelist').html(html);
            }else{
                savingalert('warning','No data Found');  
            }
        }
    });
    }
}

function edit_org_photo(photo_id,org_id,image_name,description = ''){
    var html = `<div><table><tr>
            <input type="hidden" name="uploadedInput1" id="uploadedInput1" value=`+image_name+`>
            <input type="hidden" name="photo_id" id="photo_id" value=`+photo_id+`>
            <input type="hidden" name="org_id" id="org_id" value=`+org_id+`>
            <td>&nbsp;</td>
            <td><img style="width:250px !important;" src="https://cdn.savingssites.com/`+image_name+`" width="220px"/></td>
        </tr>
        <tr>
            <td>Description:</td>
            <td><textarea name="description" id="org_description" maxlength="50">`+description+`</textarea></td>
        </tr>
        <tr>
            <td>Status:</td>
            <td><input type="radio" class="org_status_check" name="status" value="1" checked="checked">
                Active<input type="radio" class="org_status_check" name="status" value="0" >Inactive 
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td class="cat_block1">
            <input type="button" name="Submit" id="update_banner_org" value="Save" class="bttn">
            </td>
        </tr>
    </div>`;
    $('#orgdataimages').html(html);
    $('#editorgimages').modal('show');
}

function Editwebinar(id,link,description = '',status = 0){
    if(status == 1){
        var checked = 'checked';
    }else{
        var unchecked = 'checked';
    }
    var html = `<div><table><tr>
            <input type="hidden" name="webinarupdateid" id="webinarupdateid" value=`+id+`>
            <input type="hidden" name="org_id" id="org_id" value=`+description+`>
            <td>&nbsp;</td>
            <td><input type="radio" name="select" value="1" `+checked+` checked="checked" /> Enable <input type="radio" name="select" value="-1" `+unchecked+` /> Disable</td>
        </tr>
        <tr>
            <td>Enter Room Link</td>
            <td><input type="text" id="webinarupdatelink" name="webinar_link" placeholder="Please enter the room link" class="w_300" value="`+link+`"/></td>
        </tr>
        <tr>
            <td>Enter Description</td>
            <td><textarea name="description" id="webinarupdatedesc" placeholder="Please enter the description" class="w_300">`+description+`</textarea> 
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td class="cat_block1">
            <button class="m_left_150" onclick="update_webinar_link()">Save</button>
            </td>
        </tr>
    </div>`;
    $('#orgdatawebinar').html(html);
    $('#editorgwebinar').modal('show');
}

function update_webinar_link(){
    var webinarupdateid = $('#webinarupdateid').val();
    var zoneid = $('#orgzoneid').val();
    var organization_id = $('#org_id').val();
    var status = $('input[name=select]:checked').val(); 
    var webinar_link = $("#webinarupdatelink").val(); 
    var description = $("#webinarupdatedesc").val();  
    
    if(webinar_link == ''){
        savingalert('warning','Please enter the room link');
        return false;
    }
    if(description == ''){
        savingalert('warning','Please enter the description');
        return false;
    }
    $.ajax({
        'url':"/update_webinar_link",
        'type': 'POST',
        'data':{'webinar_id':webinarupdateid,'zoneid':zoneid,'organization_id':organization_id,'status':status,'webinar_link':webinar_link,'description':description},
        'dataType':'json',     
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        }, 
        success:function(r){
            savingalert(r.type,r.msg);
            $('#editorgwebinar').modal('hide');
            showallwebinar();
        }
    });
}

function save_webinar_link(){
    var status = $('input[name=select]:checked').val(); 
    var organization_id = $('#org_id').val();
    var zoneid = $('#orgzoneid').val();
    var webinar_link = $("#webinar_link").val(); 
    var description = $("#description").val();  
    
    if(webinar_link == ''){
        savingalert('warning','Please enter the room link');
        return false;
    }
    if(description == ''){
        savingalert('warning','Please enter the description');
        return false;
    }
    $.ajax({
        'url':"/save_webinar_link",
        'type': 'POST',
        'data':{'zoneid':zoneid,'organization_id':organization_id,'status':status,'webinar_link':webinar_link,'description':description},
        'dataType':'json',  
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },    
        success:function(r){
            savingalert(r.type,r.msg);  
            $('#webinar_link').val('');
            $('#description').val('');
        }
    });
}

function showallwebinar(){
    var organization_id = $('#org_id').val();
    var zoneid = $('#orgzoneid').val();
    var orguser_id = $('#orguser_id').val();
    var html = '';
    $.ajax({
        'url':"/viewmorewebinar",
        'type': 'GET',
        'data':{'zoneid':zoneid,'organization_id':organization_id,'orguser_id':orguser_id},
        'dataType':'json',
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },      
        success:function(r){
            $(r).each(function(k,v){
                html += `<tr id="`+v.id+`"><td width="15%">`+v.link+`</td><td width="40%" style="text-align:left;" class="responsive-image">`+v.description+`</td><td width="20%"><input type="hidden" name="org_ann_id" id="org_ann_id" value="`+v.id+`" /><a href="javascript:void(0);"><button class="editButton" onclick="Editwebinar(`+v.id+`,'`+v.link+`','`+v.description+`','`+v.status+`');">Edit</button></a><button class="deleteButton m_top_10" onclick="delete_webinar(`+v.id+`,`+zoneid+`)">Delete</button></td></tr>`;
            });
            $('#showannouncement').html(html);
        }
    });
}

function saveBroadcast(){ 
    var id = $("#announcement_id").val();
    var zone_id = $('#orgzoneid').val(); 
    var organization_id = $('#org_id').val(); 
    var title = $("#announcement_title").val();
    var announcement_text = $("#announcement_text").val(); 
    var category = $("#all_categories").val();
    var offer_date = $("#bookdate_picker").val();
    var offer_times = $('.offer_times:checked').val();

    if(title == ''){
        savingalert('warning','Please Enter title');
        return false;    
    }
    if(category == ''){
        savingalert('warning','Please Select Category');
        return false;    
    }
    if(offer_date == ''){
        savingalert('warning','Please Select Date');
        return false;    
    }
    if(offer_times == ''){
        savingalert('warning','Please Pick Time');
        return false;    
    }
    if(announcement_text == ''){
        savingalert('warning','Please Enter Annoucement Text');
        return false;    
    }
    
    var dataToUse = {
        'announceId':id,
        'zone_id': zone_id,              
        'organization_id': organization_id,
        'title':title,
        'announcement_text': announcement_text,
        'category': category,
        'offer_date' : offer_date,
        'offer_times' :offer_times
    };  
    $.ajax({
        'url':"/save_broadcast",
        'type': 'POST',
        'data':dataToUse,
        'dataType':'json',  
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },    
        success:function(r){
            savingalert(r.type,r.msg);  
            var url = baseurl+'/organizationdashboard/'+organization_id+'/view_broadcast';
            window.open(url,"_self");
        }
    });
}

function delete_org_photo(photo_id,org_id,cat_id,image_name){
    var dataToUse={'photo_id':photo_id,'org_id':org_id,'cat_id':cat_id,'image_name':image_name};
    if (confirm('Are You Sure to Delete ')) {
        $.ajax({
            'url':"/delete_org_photo",
            'type': 'POST',
            'data':dataToUse,
            'dataType':'json', 
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },     
            success:function(r){
                savingalert(r.type,r.msg);  
                location.reload();
            }
        });
    }
}

function DeleteAnnouncement(zoneid,id,org_id){
    var dataToUse={'id':id,'zoneid':zoneid,'orgid':org_id};
    if (confirm('Are You Sure to Delete ')) {
        $.ajax({
            'url':"/delete_org",
            'type': 'POST',
            'data':dataToUse,
            'dataType':'json', 
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },     
            success:function(r){
                savingalert(r.type,r.msg);
                showallannouncement(org_id);
            }
        });
    }
}

function Deletebroadcast(brodcastid){
    var dataToUse={'brodcastid':brodcastid};
    if (confirm('Are You Sure to Delete ')) {
        $.ajax({
            'url':"/delete_broadcast",
            'type': 'POST',
            'data':dataToUse,
            'dataType':'json', 
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },     
            success:function(r){
                savingalert(r.type,r.msg);  
                location.reload();
            }
        });
    }
}

function delete_group(id,zoneid,createdby_id,createdby_type){
    var dataToUse={'id':id,'zoneid':zoneid,'createdby_id':createdby_id,'createdby_type':createdby_type};
    if (confirm('Are You Sure to Delete ')) {
        $.ajax({
            'url':"/delete_group",
            'type': 'POST',
            'data':dataToUse,
            'dataType':'json',  
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },    
            success:function(r){
                savingalert(r.type,r.msg);  
                location.reload();
            }
        });
    }
}

function delete_webinar(id,zone_id){
    var dataToUse={'id':id,'zoneid':zone_id};
    if (confirm('Are You Sure to Delete ')) {
        $.ajax({
            'url':"/delete_webinar",
            'type': 'POST',
            'data':dataToUse,
            'dataType':'json', 
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },     
            success:function(r){
                savingalert(r.type,r.msg);  
                showallwebinar();
            }
        });
    }
}

function getallcategoriesorg(){
    content = '';
    $.ajax({
        'url':"/show_allcategoryorg",
        'data':{id:$('#org_id').val()},
        'dataType':'json',  
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },    
        'success':function(result){ 
            content += '<option class="allcatshow" value="-1" selected>--Select Category--</option>';
            $.each(result,function(i,j){
                content += '<option value="'+j.id+'">'+j.name+'</option>';
            });
            $("#allcategories").html(content);
            $("#allcategories1").html(content);
        }
    });
}

function checkbidexists(business_id){
    var exists = 0;
   
        $.ajax({
            url:'/checkexistsbid',
            data:{'business_id':business_id},
            async:false,
            dataType:'json',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function(r){ 
                exists = r;
            }
        });   
    
    return exists;
}

function getCity(state_code = '', id = '',zone_id=''){
    $('#cityshow').addClass('hide');
    $('#cityselect').removeClass('hide');
    var dataToUse = {'state_code':state_code,'zone_id':zone_id};
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

function UpdateBusinessPassword(){ 
    var zone_id = $('#biz_zone_ids').val();
    var business_first_password_change = $('#business_first_password_change').val();
    var subusereixsts = $('#subusereixsts').val();
    
    if(business_first_password_change == 1){
        if($('#bcurrent_pass').val() == '' || $('#bnew_pass').val() == '' || $('#bconfirm_pass').val() == ''){
            savingalert('warning','Please Fill Required Fields.');
            return false;    
        }
        if($('#bnew_pass').val() != $('#bconfirm_pass').val()){
            savingalert('warning','New Password and Confirm New Password Must Be Same');
            return false;   
        } 
        if($('#bcurrent_pass').val() == $('#bnew_pass').val()){
            savingalert('warning','No changes Made');
            return false;   
        }
        var dataToUse = {
            "userid":user,
            "zoneid":zone_id,
            "current_pass":$('#bcurrent_pass').val(),
            "new_pass":$('#bnew_pass').val(),
            "confirm_pass":$('#bconfirm_pass').val(),
            "business_first_password_change":business_first_password_change,
            "subusereixsts":subusereixsts
        };  
    }else{
        if($('#current_pass').val() == '' || $('#new_pass').val() == '' || $('#confirm_pass').val() == ''){
            savingalert('warning','Please Fill Required Fields.');
            return false;    
        }
        if($('#new_pass').val() != $('#confirm_pass').val()){
            savingalert('warning','New Password and Confirm New Password Must Be Same');
            return false;   
        }
        if($('#current_pass').val() == $('#new_pass').val()){
            savingalert('warning','No changes Made');
            return false;   
        }
        var dataToUse = {
            "userid":user,
            "zoneid":zone_id,
            "current_pass":$('#current_pass').val(),
            "new_pass":$('#new_pass').val(),
            "confirm_pass":$('#confirm_pass').val(),
            "business_first_password_change":0,
            "subusereixsts":subusereixsts
        };
    }
    $.ajax({
        url: "/UpdateBusinessPassword", 
        dataType: 'json', 
        data: dataToUse,
        type: 'post',
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },
        success: function (res) {
            savingalert(res.type,res.msg);
            if(business_first_password_change == 1){
                $('#business_first_password').modal('hide');
            }
        }
    });
}

function viewAds(busid,adid,zoneid,fromzoneid){
    $.ajax({
        url: "/editad/"+busid+"/"+fromzoneid+"/"+adid+"/"+zoneid, 
        dataType: 'json', 
        data: {'businessid':busid,'zoneid':zoneid,'adid':adid,'fromzoneid':zoneid},
        type: 'get',
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },
        success: function (res) {
            $('.optioncategory').prop('checked', true);
            var adedit = res.addetails[0];  
            var catedit = res.get_category_subcategory;
            $('#adid').val(adid);
            $('#dealdescription').val(adedit.deal_description);
            $('#ad_startdatetime').val(adedit.startdate);
            $('#ad_stopdatetime').val(adedit.enddate);
            $('#deal_restriction').val(adedit.deal_restriction);
            $('#deal_restriction').val(adedit.deal_restriction);
            $('#search_engine_title').val(adedit.deal_title);
            $('#short_description').val(adedit.short_description);
            $('#video_presentation').val(adedit.video_file);
            $('#video_presentation').val(adedit.video_file);
            $('#textmeoffertext').val(adedit.textmeoffer);
            $('#uploadedInput').val(adedit.adtext);
            if(adedit.show_subcat_image == 1){
                $('#subcatimagebutton').val(1);
                $('#subcatimagebutton').prop('checked', true);
            }else{
                $('#subcatimagebutton').val(2);
                $('#subcatimagebutton').prop('checked', false);
            }
            if(adedit.insert_via_csv == 1){
                $('#adsimage').attr('src',baseurl+'/assets/SavingsUpload/CSV/'+res.zoneid+'/images/'+adedit.adtext+'')
            }else if(adedit.insert_via_aws == 1){
                $('#adsimage').attr('src','https://cdn.savingssites.com/'+adedit.adtext+'');
            }else{
                $('#adsimage').attr('src',baseurl+'/assets/SavingsUpload/Business/'+busid+'/'+adedit.adtext+'')
            }
            if(adedit.insert_via_csv == 1){
                $('#sigleimgshow').attr('src',baseurl+'/assets/SavingsUpload/CSV/'+res.zoneid+'/images/'+adedit.adtext+'')
            }else if(adedit.insert_via_aws == 1){
                $('#sigleimgshow').attr('src','https://cdn.savingssites.com/'+adedit.adtext+'');
            }else{
                $('#sigleimgshow').attr('src',baseurl+'/assets/SavingsUpload/Business/'+busid+'/'+adedit.adtext+'')
            }
            var subcatArr = adedit.subcatid.split(',');
            $('.optiondcheckbox').each(function(){
                var v = $(this).val();
                if(jQuery.inArray(v, subcatArr) !== -1){
                    $(this).prop('checked', true);
                }
            });
            if(adedit.deliver == 1){
                $('#yes').prop('checked', true);
            }else{
                $('#no').prop('checked', true);
            }
            if(catedit.reservation_status == 1){
                $('#showreservation').prop('checked',true);
            }
            if(catedit.menutab_status == 1){
                $('#showmenutab').prop('checked',true);
            }
            if(res.business_images_gallery != ''){
                $(res.business_images_gallery).each(function(k,v){
                    if(adedit.insert_via_aws == 1){
                        $('#show_bannermulti').append('<img style="width:150px;height:150px;" src="https://cdn.savingssites.com/'+adedit.adtext+'"/>');
                    }else{
                        $('#show_bannermulti').append('<img style="width:150px;height:150px;" src="'+baseurl+'/assets/SavingsUpload/Business/'+busid+'/'+v.image_name+'"/>');
                    }
                });
            }
        }
    });  
}

function deleteAd(id, busid, name,$this){ 
    if (confirm('Really remove Ad Id:'+id+' from this zone?')) {
        var data = { id : id, business_id : busid,zoneid:zone_id};
        $.ajax({
            url: "/deleteAd", 
            dataType: 'json', 
            data: data,
            type: 'post',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function (res) {
                savingalert('success','Successfully Remove This Ad');
                $this.closest('tr').remove(); 
            }
        });
    }
}

function ad_status_change(businessid,adid,zoneid,status){
    var data = {businessid : businessid, adid : adid, zoneid : zoneid, status : status};
    if (confirm('Do you want to make this Ad inactive?')) {
        $.ajax({
            url: "/ad_status_change", 
            dataType: 'json', 
            data: data,
            type: 'post',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function (res) {
                savingalert('success','Successfully Remove This Ad');
                window.location.href = "/Zonedashboard/menu_generator/"+zone_id+""; 
            }
        });   
    }
}

function ampmToMilitary(time){ 
    if(time != ''){
        var hours = Number(time.match(/^(\d+)/)[1]);
        var minutes = Number(time.match(/:(\d+)/)[1]);
        var ap = time.match(/\s(.*)$/)[1];
        
        if(ap == "pm" && hours<12) hours = hours+12;
        if(ap == "am" && hours==12) hours = hours-12;
        
        var sHours = hours.toString();
        var sMinutes = minutes.toString();
        
        if(hours<10) sHours = "0" + sHours;
        if(minutes<10) sMinutes = "0" + sMinutes;
        return (sHours + ":" + sMinutes);
    }else{
        return null;
    }
}

function youtubeUrlValidation(a){
    var p = /^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
    if(!a.match(p)){
        savingalert('warning','Please enter a valid youtube link');
        $('#video_presentation').val('');
    }
}

function text_me() {
    if( $('#textmeoffertext').val() == '' ){
        $('#textmeoffertext').removeClass("correct");
        $('#textmeoffertext').addClass("incorrect");    
        return false;
    }else{
        $('#textmeoffertext').removeClass("incorrect");
        $('#textmeoffertext').addClass("correct");
    }
}


var mulimage = [];
function UploadImage(form_data,zone_id,location,id){
    var busid = $('#business_id').val();
    if(busid == '' || busid == undefined){
        busid = $('#businessid').val();
    }
    var baseurl = window.location.origin;
    $.ajax({
        url: "/UploadImage/"+zone_id+"/"+location+"", 
        dataType: 'json', 
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },
        success: function (res) {
            mulimage.push(res.data);
            $('#uploadedInputorg').val(res.data);
            if(id == '#show_bannermulti'){
                $(id).append('<img style="width:150px;height:150px;" src="'+baseurl+'/assets/SavingsUpload/'+location+'/'+busid+'/'+res.data+'"/>')
            }else if(id == "#card_img"){
                $('#card_img').attr('imagename',res.data);    
                $('#uploadedInput').val(res.data);    
                $('#card_img').attr('businessimageid',busid);    
            }else{
                $('#imgfile').attr('imagename',res.data);
                $('#uploadedInput').val(res.data);
                console.log(id);
                $(id).text('assets/SavingsUpload/'+location+'/'+zone_id+'/'+res.data);
                $('#multiuploadedInput').val(mulimage);
            }
            savingalert(res.type,res.msg);
        }
    });
}

function editdeal(id,busid){
    var baseurl = window.location.origin;
    $.ajax({
        type:'GET',
        url:"/Businessdashboard/editdealdata",
        data:{'productid':id},
        dataType:'json',
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },
        success: function(result){
            var r = result.editdata[0];
            $('#buy_price_decrease').val(r.buy_price_decrease_by);
            $('#company_name').val(r.company_name);
            $('#publisher_fee').val(r.publisher_fee);
            $('#low_limit_price').val(r.low_limit_price);
            $('#deal_description').val(r.deal_description);
            $('#deal_description').attr('dealid',r.deal_id);
            $('#deal_description').attr('dealproductid',r.deal_product_id);
            $('#deal_description').attr('dealzone',r.zone_id);
            $('.meta_description').val(r.meta_description);
            $('#page_title').val(r.page_title);
            $('#max_sold_per_auction').val(r.numberofconsolation);
            $('#end_date').val(r.end_date);
            $('#start_date').val(r.start_date);
            if(r.numberofconsolation == -1){
                $('#unlimited_value').prop('checked', true);
            }else{
                $('#unlimited_value').prop('checked', false);
            }
            $('#status').val(r.status).prop('selected', true);
            $('#status').val(r.status).prop('selected', true);
            if(r.insert_via_csv == 1){
                $('#show_banner1').attr('src', baseurl+'/assets/SavingsUpload/CSV/'+r.zone_id+'/images/'+r.card_img);
            }else{
                $('#show_banner1').attr('src', baseurl+'/assets/SavingsUpload/Business/'+busid+'/'+r.card_img);
            }
            $('#uploadedInput').val(r.card_img);
            $('#deal_product_id').val(id);
            $('.sortlisttags').each(function(){
                var deal = $(this).attr('data-id');
                if(deal == r.selected_deal){
                    $(this).prop('checked', true);        
                }  
            })
        }
    });  
} 


function editorganization(orgid,orguser,zone_id){
    var baseurl = window.location.origin;
    $.ajax({
        type:'GET',
        url:"/get_organization",
        data:{'orgid':orgid,'orguser':orguser,'zone_id':zone_id},
        dataType:'json',
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },
        success: function(result){
            var r = result[0];
            $('#uemail').attr('orgid',r.orgid);
            $('#uemail').attr('userid',r.userid);
            $('#uemail').val(r.email);
            $('#fname').val(r.first_name);
            $('#lname').val(r.last_name);
            $('#org_name').val(r.orgname);
            $('#org_username').val(r.username);
            $('#phone_user').val(r.phone);
            $('#user_address').val(r.Address);
        }
    });  
}        



function fetch_data_by_filter(catoption,selectcatsubcat){
    var html = '';
    $.ajax({
        type:'POST',
        url:"/getMyZoneBusiness",
        data:{'zoneid':zone_id,'catoption':catoption,'selectcatsubcat':selectcatsubcat},
        dataType:'json',
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },
        success: function(result) {
            if(result.length > 0){
                $(result).each(function(k,v){
                    html += '<tr>';
                    html += '<td>'+v.id+'</td>';
                    html += '<td>'+v.name+'</td>';
                    html += '<td>'+v.contactfirstname+' '+v.contactlastname+'</td>';
                    html += '<td>'+v.phone+'</td>';
                    html += '<td>'+v.zip_code+'</td>';
                    html += '<td><a href="javascript:void(0)" class="tab_icon green" target="_blank"><b> AD</b></a><a href="javascript:void(0)" class="tab_icon" ><i class="fa fa-id-card" aria-hidden="true"></i></a><a href="javascript:void(0)" class="tab_icon red"><i class="fa fa-trash" aria-hidden="true"></i></a></td>';
                    // html += '<td><input type="checkbox"></td>';
                    html += '</tr>';
                });
            }else{
                html += '<tr>';
                html += '<td colspan="7">No Business Found</td>';
                html += '</tr>';
            }
            $('#myzonebusinesdata').html(html);
        }
    });        
}

function myZoneBusTable(zoneid,typeofbusinesses,typeofadds,paymentstatus,activestatus,businessmode,bus_search_by_name,bus_search_by_alphabet,bus_search_results){
    $.ajax({
        'url': "/Zonedashboard/all_business_by_filtering",
        'method': "POST",
        'data':{'zoneid':zoneid,'typeofbusinesses':typeofbusinesses,'typeofadds':typeofadds,'paymentstatus':paymentstatus,'activestatus':activestatus,'businessmode':businessmode,'bus_search_by_name':bus_search_by_name,'bus_search_by_alphabet':bus_search_by_alphabet,'bus_search_results':bus_search_results},
        // 'contentType': 'application/json'
    }).done( function(data) {
        $('#example').dataTable( {
            "aaData": data,
            "columns": [
                { "data": "id" },
                { "data": "name" },
                { "data": "detail_alias" },
                { "data": "points" }
            ]
        })
    })


 

}


function addNewField() {
    count = totalFields() + 1;
    field = $("#dynamic-field-1").clone();
    field.attr("id", "dynamic-field-" + count);
    field.children("label").text("Field " + count);
    field.find("input").val("");
    $(className + ":last").after($(field));
}
function enableButtonRemove() {
    if (totalFields() === 2) {
      buttonRemove.removeAttr("disabled");
      buttonRemove.addClass("shadow-sm");
    }
}
function disableButtonAdd() {
    if (totalFields() === maxFields) {
        buttonAdd.attr("disabled", "disabled");
        buttonAdd.removeClass("shadow-sm");
    }
}

function removeLastField() {
    if (totalFields() > 1) {
      $(className + ":last").remove();
    }
}

function disableButtonRemove() {
    if (totalFields() === 1) {
        buttonRemove.attr("disabled", "disabled");
        buttonRemove.removeClass("shadow-sm");
    }
}

function enableButtonAdd() {
    if (totalFields() === (maxFields - 1)) {
        buttonAdd.removeAttr("disabled");
        buttonAdd.addClass("shadow-sm");
    }
}

function totalFields() {
    return $(className).length;
}

function addactive(){
    var pagesidebar = $('#pagesidebar').val();
    $('#'+pagesidebar).closest('li').addClass('active');
    $('#'+pagesidebar).closest('.sidebar-submenu').css('display','block');
    $('#'+pagesidebar).closest('.sidebar-submenu').closest('li').addClass('active');
}

function uploadFile() {
    var form_data = new FormData();
    var file_data1 = $('#file').prop('files')[0];
    form_data.append('file', file_data1);
    $.ajax({
      url: '/Zonedashboard/upload_business_greetings', 
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      type: 'post',
      dataType: "json",
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },
      success: function (r) {
        if(r.type == 'success'){
          var file_name = r.data;
          $('#biz_firstname').attr('audio_greetings', file_name);
        }
        if(r.type == 'error'){
            savingalert('danger',r.msg);
        }
      }
    });
  }

function UpdateProfile() { 
    var Email = $('#jform_Email').val();
    var Firstname = $('#jform_Firstname').val();
    var Lastname = $('#jform_Lastname').val();
    var Phone = $('#jform_Phone').val();
    var Address = $('#jform_Address').val();
    var City = $('#jform_City').val();
    var State = $('#jform_State').val();
    var Zip = $('#jform_Zip').val();
    var subusereixsts = $('#subusereixsts').val();

    if(Email == '' || Firstname == '' || Lastname == '' || Phone == '' || Address == '' || City == '' || State == '' || Zip == ''){
        savingalert('warning','Please Fill All Required Fields.'); 
        return false;
    }
    
    $.ajax({
        url:"/Zonedashboard/update_profile",      
        type:"POST",
        dataType:'json',
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },
        data:{ 'userid':user, 'email':Email, 'firstname':Firstname, 'lastname':Lastname, 'phone':Phone, 'address':Address, 'city':City, 'state':State, 'zip':Zip, 'subusereixsts':subusereixsts},                 
        success: function(data){ 
            if(data.type == 'success'){
                savingalert(data.type,data.msg);  
            }
        }
    });
}

function UpdateOrgProfile() {
    var Email = $('#jform_Email').val();
    var Firstname = $('#jform_Firstname').val();
    var Lastname = $('#jform_Lastname').val();
    var Phone = $('#jform_Phone').val();
    var Address = $('#jform_Address').val();
    var State = $('#selState').val();
    var City = $('#jform_City').val();
    if(City == '' || City == undefined){
        var City = $('#selcity').val();
    }
    var Zip = $('#jform_Zip').val(); 
    var userid = user;
    var type = 3; 
    if(Email == '' || Firstname == '' || Lastname == '' || Phone == '' || Address == '' || City == '' || State == '' || Zip == ''){
        savingalert('warning','Please Fill All Required Fields.'); 
        return false;
    }
    $.ajax({
        url:"/organizationdashboard/update_profile",      
        type:"POST",
        dataType:'json',
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },
        data:{ 'userid':user, 'email':Email, 'firstname':Firstname, 'lastname':Lastname, 'phone':Phone, 'address':Address, 'city':City, 'state':State, 'zip':Zip, 'type':type},                 
        success: function(data){ 
            if(data.type == 'success'){
                savingalert(data.type,data.msg);  
            }
        }
    });
}

function UpdatePassword(){ 
    if($('#current_pass').val() == '' && $('#new_pass').val() == '' && $('#confirm_pass').val() ==''){          
        savingalert('warning','Fields can not be left blank. Please provide values.');
        return false;
    }
    if($('#current_pass').val() == ''){
        savingalert('warning','Please enter your current password.');
        return false;
    }
    if($('#new_pass').val() == ''){
        savingalert('warning','Please enter your new password.');
        return false;
    }
    if($('#confirm_pass').val() ==''){
        savingalert('warning','Please enter the confirm password.');
        return false;
    }
    if($('#new_pass').val() != $('#confirm_pass').val()){
        savingalert('warning','Your New Password and Confirm Password are not same. For this No Changes Made!');
        return false;
    }
    
    $.ajax({
        url:"/Zonedashboard/update_password",      
        type:"POST",
        dataType:'json',
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },
        data:{'userid':user, 'current_pass': $('#current_pass').val(), 'new_pass':$('#new_pass').val(),'confirm_pass': $('#confirm_pass').val(),'username':username,'subusereixsts':subusereixsts
        },                 
        success: function(data){ 
            if(data.type == 'success'){
                savingalert(data.type,data.msg); 
                $('#current_pass').val('');
                $('#new_pass').val('');
                $('#confirm_pass').val('');
            }   
        }
    });
}

var loadFile = function(event) {
    $('#show_banner').css('display','none');
    $('#output').removeClass('hide');
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('output');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
};

function changeTheme() {
    var theme = $("#themeChange").val();
    var r = confirm("Want to change your theme?");
    if (r == true) {
        $.ajax({
            url:"/Zonedashboard/change_theme",      
            type:"POST",
            dataType:'json',
            data:{'zone_id':zone_id, 'theme': theme},                 
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function(data){ 
                if(data.type == 'success'){
                    savingalert(data.type,data.msg); 
                    location.reload();
                }   
            }
        });
    }
}

function checkConfirmPassword(x){
  if($('input[name="password"]').val() != $('input[name="cpassword"]').val()){
    $('#passerror').html('<span style="color:#f41525; font-weight: bold; text-align: center; margin-left: -16px;">Password and Confirm Passwords doesn\'t match.</span>');
  }
}

$('input[name="submitformat"]').click(function(){
    var splashArray = new Array();
    $('#boxA .slot').each(function(){
        dataAttr = $(this).find('.activeProp').attr('data-id'); 
        dataPosition = $(this).attr('data-position'); 
        datausername = $(this).find('.activeProp').attr('data-username');
        databid = $(this).find('.activeProp').attr('data-bid');
        alert(dataAttr+'----'+dataPosition+'----'+datausername+'----'+databid);
        if(dataAttr == 'business'){             
            splashArray.push({
                value: dataAttr, 
                position:  dataPosition ,
                username: datausername,
                busid: databid
            });  
        }else if(dataAttr == 'content'){             
            splashArray.push({
                value:dataAttr , 
                dataValue:$(this).find('textarea').val().replace(/'/g, ' ').replace(/"/g, ' ')  , 
                position:  dataPosition 
            });  

        }else if(typeof  dataAttr != 'undefined'){             
            splashArray.push({
                value: dataAttr, 
                position:  dataPosition 
            });  
        }  
    })
    
    $.ajax({
        type:"POST",
        data:{'dataarray': splashArray,"zone_id": $('.zoneid').val() },
        url: "/Zonedashboard/addemailformat",  
        cache: false,
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },
        success: function(data){  
            location.reload();
        }
    });
});

function getcountsnapuseremaillist(){
    return false;
    var zoneid = $('#zone_id').val();
    var busid = $('#businessid').val();
    $.ajax({
        type: "GET",
        url:'/getcountsnapuseremaillist',
        data:{'busid':busid,'zoneid':zoneid},
        dataType: "json",
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },
        success: function(r){
            $('.snapemailusers').text(r.data);
        }
    });
}

function sign_out(){ 
    var zone_id = $('#zone_id').val();
    if(zone_id == '' || zone_id == 'undefined' || zone_id == undefined){
        var zone_id = $('#orgzoneid').val();
    }
    var type = 'business';
    savingalert('success','Redirecting to the zone directory page');
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
            window.location.href = window.location.origin;;
        }
    });
}

function savingalert(type = '',msg = ''){
    var msg = '<div style="opacity:1;" class="alert alert-'+type+' alert-dismissible fade show" role="alert"><strong>'+msg+'</strong></button></div>';
    $('#alert_msg').html(msg).css('display','block');
    setTimeout(hidealert, 3000);
}
function hidealert(){
    $('#alert_msg').css('display','none');  
}

ClassicEditor
    .create(document.querySelector( '#stater_ad_message' ) )
    .then( editor => {
        console.log( editor );
    })
    .catch( error => {
        // console.error( error );
    });
             

    
    setTimeout(function() {


    
    
 

    $(document).on('click', '#mailsend', function(){
        var email = $('#referlinkmail').val();
        var type = 'link_refer_mail';
        var subusereixsts = $('#subusereixsts').val();
        var code = $('.refertext').text();
        if(email != ''){
            $.ajax({
                'url' :'/Zonedashboard/refer_generate',
                'type':'POST',
                'data':{'email':email,'type':type,'code':code,'subusereixsts':subusereixsts},
                beforeSend : function(){
                    $('#loading').css('display','block');
                },
                complete: function() {
                    $('#loading').css('display','none');
                },
                success:function(r){
                    alert("Email send Successfully");
                }
            });
        }
    });
 
 
    var baseurl = $('.baseurl').val();
    //alert(baseurl);
    $.ajax({
        'url' :'/Zonedashboard/get_refer_link',
        'type':'Post',
        'data':{'baseurl':baseurl},
        'dataType':'json',
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },
        success:function(r){
            if(r.status == 'success'){
                var code = r.data;
                var link = baseurl+ '/zone/refer/'+code; 
                var link = baseurl+ '?refer='+code; 
                $('#referlinktext').val(link);
                $('.refertext').text(code);
                $('#fb').attr('href', 'https://www.facebook.com/sharer.php?u='+link);
                $('#twitter').attr('href', 'http://www.twitter.com/share?url='+link);
            }
        }
    });
 
function copyToClipboard(elementId) {
    var textBox = document.getElementById(elementId);
    textBox.select();
    document.execCommand("copy");
    alert("Copy To ClipBoard");
}
 

    var dragOption = {
        delay: 10,
        distance: 5,
        opacity: 0.45,
        revert: "invalid",
        start: function (event, ui) {
            $(".ui-selected").each(function () {
                $(this).data("original", $(this).position());
            });
        },
        drag: function (event, ui) {
            var offset = ui.position;
            $(".ui-selected").not(this).each(function () {
                var current = $(this).offset(),
                    targetLeft = document.elementFromPoint(current.left - 1, current.top),
                    targetRight = document.elementFromPoint(current.left + $(this).width() + 1, current.top);
                $(this).css({
                    position: "relative",
                    left: offset.left,
                    top: offset.top
                }).data("target", $.unique([targetLeft, targetRight]));
            });
        },
        stop: function (event, ui) {
            validate($(".ui-selected").not(ui.draggable));
        }
    }, dropOption = {
        accept: '.item',
        activeClass: "green3",
        greedy: true,
        drop: function (event, ui) {
         
 
 

            if ($(this).is(".slot") && !$(this).has(".item").length) {
              

                $(this).append(ui.draggable.css({
                    top: 0,
                    left: 0
                }));
            } else {
                ui.draggable.animate({
                    top: 0,
                    left: 0
                }, "slow");
            }
            validate($(".ui-selected").not(ui.draggable));
        }
    }

    $(".box").selectable({
        filter: ".item",
        start: function (event, ui) {
            $(".ui-selected").draggable("destroy");
        },
        stop: function (event, ui) {
            $(".ui-selected").draggable(dragOption)
        }
    });
    $(".slot").droppable(dropOption);

    function validate($draggables) {

        $draggables.each(function () {  
            var $target = $($(this).data("target")).filter(function (i, elm) {
                return $(this).is(".slot") && !$(this).has(".item").length;
            });
            if ($target.length) {
                $target.append($(this).css({
                    top: 0,
                    left: 0
                }))
            } else {
                $(this).animate({
                    top: 0,
                    left: 0
                }, "slow");
            }

        });
        $(".ui-selected").data("original", null)
            .data("target", null)
            .removeClass("ui-selected");
    }
  

  var typingTimer;                //timer identifier
var doneTypingInterval = 1000;  //time in ms, 5 second for example

//on keyup, start the countdown
$('.searchResult').keyup(function(){
    clearTimeout(typingTimer);
    if ($('.searchResult').val) {
        typingTimer = setTimeout(function(){
            //do stuff here e.g ajax call etc....
             var v = $.trim($(".searchResult").val());  
         
              $.ajax({

                   type:"POST",
                   data:{'searchkey': v,'zoneid':zone_id},  url: "/Zonedashboard/searchBusinessads",      

                   cache: false,
                   beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
                   success: function(data){  
 
                        
                        $('.searchresult').html(data);
                        $('.searchResult').val(' ');

                      }

            });

        }, doneTypingInterval);
    }
});

$(document).on('click' , '.emailformatpage .crosssign' , function(e){
    e.preventDefault();
    $(this).parents('.item').remove();  
});

$(".selAvtivity").change(function(){
  var option = $('option:selected', this).attr('name');
  jQuery('.activity_span').text(option);
});

$('.selOrgnization').change(function() {
  var option = $('option:selected', this).attr('value'); 
  var newText = option.split(/\s/).join('_');
  jQuery('.madfod_span').text(newText);   
});

$('.emailformatpage .sendemail').click(function(e){
    e.preventDefault();
    $.ajax({
        type:"POST",
        data:{ "zone_id": zone_id},                   
        url: "/Zonedashboard/sendEmailSnapONUSer",      
        cache: false,
        beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
        success: function(data){}
    });
})
}, 2000);

$(document).ready(function(){

$('#sortable').sortable({
    update: function(event, ui){

        var data_array=[];

        var i=0;

        var order="";

        $(".draggable_div").each(function(i){

            var id=$(this).attr('id');

            order+=id+",";

            $('#'+$(this).attr('id')).find('.counter').text(i+1);



        });
        var subusereixsts = $('#subusereixsts').val();
        var data={order:order,'subusereixsts':subusereixsts};

        $.post("/Zonedashboard/sponser_business_reorder",data,function(){

            

                

        }); 


    }

});

$('#sortable1').sortable({
    update: function(event, ui){
        var data_array=[];
        var i=0;
        var order="";
        var zone_id = "";
        var subcat = "";
        var subusereixsts = $('#subusereixsts').val();
        $(".draggable_div1").each(function(i){
            var id=$(this).attr("data-adid");
            order+=id+",";
            $('#'+$(this).attr('id')).find('.counter').text(i+1);
            zone_id = $(this).attr('zone_id');
            subcat = $(this).attr('subcat');
        });
        var data={'order':order,'zone_id':zone_id,'subcat':subcat,'subusereixsts':subusereixsts};
        $.post("/Zonedashboard/sponser_business_reorder_cat",data,function(){}); 
    }
});

    $(document).on('click','.startampm', function(){
        $('.startampm').prop('checked', false);
        $(this).prop('checked', true);
    });

    $(document).on('click','.endampm', function(){
        $('.endampm').prop('checked', false);
        $(this).prop('checked', true);
    });

    $(document).on('click','.snaplistsubspan', function(){
        $(this).closest('.snaplistsubmaindiv').remove();
    });

    $(document).on('click','.snapbusinessdetaillist', function(){
        var dealid = $(this).attr('dealid');
        var busid = $(this).attr('busid');
        var html = '';
        $.ajax({
            type:"GET",
            data:{dealid,busid},                 
            url: '/explore_snap_business_data',      
            dataType: 'json',
            success: function(data){  
                if(data != ''){
                    $.each(data,function(k,v){
                        var allday = '';
                        var weekdays = '';
                        var weekend = '';
                        var rowsr = v.length;
                        $(v).each(function(k1,v1){
                            if(v1.snapsendtypearr == 1){allday = '<i class="fa fa-check"></i>';}
                            if(v1.snapsendtypearr == 2){weekdays = '<i class="fa fa-check"></i>';}
                            if(v1.snapsendtypearr == 3){weekend = '<i class="fa fa-check"></i>';}

                            html += '<tr>';
                            if(k1 == 0){
                                html += '<td rowspan="'+rowsr+'">'+k+'</td>';    
                            }
                            html += '<td>'+v1.starttimeword+'</td>';
                            html += '<td>'+v1.endtimeword+'</td>';
                            html += '<td>'+weekdays+'</td>';
                            html += '<td>'+weekend+'</td>';
                            html += '<td>'+allday+'</td>';
                            html += '<td>'+v1.noofpeoplearr+'</td>';
                            html += '</tr>';
                        });
                    });
                    $('#snap_business_deal_list_data').html(html);
                }
                $('#snap_business_deal_list_modal').modal('show');
            }
        });
    });

    $(document).on('click','.savesnapforbusiness', function(){
        var snap_filter_arr = [];

        var businessid = $('#businessid').val();
        var businessuser = $('#businessuser').val();
        var zone_id = $('#zone_id').val();
        var buseditsnap = $('#buseditsnap').val();
        var buseditsnap = $('#buseditsnap').val();
        var dealId = '';
        $('.snaplistsubdiv').each(function(){
            var dayobject= {};
            var day             = $(this).attr('dayid');
            var starttime       = $(this).attr('starttime');
            var endtime         = $(this).attr('endtime');
            var noofpeople      = $(this).attr('noofpeople');
            var snapsendtype    = $(this).attr('snapsendtype');
            var snapdealid    = $(this).attr('snapdealid');
            dealId = snapdealid;
            
            dayobject = {'day':day,'starttime':starttime,'endtime':endtime,'noofpeople':noofpeople,'snapsendtype':snapsendtype,'snapdealid':snapdealid};
            snap_filter_arr.push(dayobject);
        });

        $.ajax({
            type:"POST",
            data:{businessid,dealId,businessuser,zone_id,snap_filter_arr,buseditsnap},                 
            url: '/save_business_snap_filter',      
            dataType: 'json',
            success: function(data){  
                if(data.type == 'warning'){
                    savingalert(data.type,data.msg);
                }else{
                    $('#snaptimelist').html('');      
                    $('.lastupdatemobilediv').addClass('hide');
                    $('.savesnapforbusiness').addClass('hide');
                    savingalert(data.type,data.msg);
                    if(buseditsnap == 1){
                        window.location.href = "/businessdashboard/"+businessid+"/show_business_snap";
                    }
                }
            }
        });
        getcountsnapuseremaillist();
    });

    $(document).on('click','.deleteusersnaptime',function(){
        if (confirm('Are you Sure to Delete?')) {
            var daycount = $(this).attr('daycount');
            var busid = $(this).attr('busid');
            if(busid && daycount){
                $.ajax({
                    type:"POST",
                    data:{daycount,busid},                 
                    url: '/delete_business_snap_filter',      
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



   
$('.managecategories .catSubID').click(function(e){
   e.preventDefault();
        $('.categoryID').val($(this).attr('data-cat'));

        $.ajax({
            type:"POST",
            data:{'catid':$(this).attr('data-cat')  ,  'zoneid': $(this).attr('data-zoneid') },                 
            url: '/Zonedashboard/edit_sub_category_display',      
            cache: false,
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function(data){        
                $('.subcat_content').html(data);
                $('.subcategories_data').css('display','inline-block');
            }
        });

});


 $(document).ready(function(e){
  

    $('.subcatclose').click(function(e){
        e.preventDefault();
         $('.subcategories_data').css('display','none');
    });

    $('.managecategories .sub_updatecat').click(function(e){
        e.preventDefault();
        
    });


     $('.managecategories .makeselected').click(function(e){
      var CatArray = [];
      var $cnt = 0;
      var subusereixsts = $('#subusereixsts').val();
       $('.display_checkbox').each(function(e){
            if ($(this).is(':checked')) {          
                  CatArray.push($(this).attr('data-cat'));
                      $cnt++;
              } 
       });

       if($cnt == 0){
       
          savingalert('warning','Please select Category to make active!');
       }else{
            $.ajax({
                   type:"POST",
                    data:{'catid':JSON.stringify(CatArray),  'zoneid': $('.makeselected').attr('data-zoneid'), 'status':'all', 'subusereixsts':subusereixsts},                 
                    url: '/Zonedashboard/save_zone_cat_display',      
                    cache: false,
                    beforeSend : function(){
                        $('#loading').css('display','block');
                    },
                    complete: function() {
                        $('#loading').css('display','none');
                    },
                    success: function(data){ 
                      savingalert('success','Data Saved Successfully!');
                      setTimeout(function(){                        
                        location.reload();
                     },500); 
                      
                    }
            });
       }
 
          
    })

    $('.managecategories .switch input[type=checkbox]').on('click',function(e){
      $status = '';
        var subusereixsts = $('#subusereixsts').val();
       if($(this).is(':checked') == true) {
         $status = 'selected';
        }else{
         $status = 'unselected';
        }  


          $.ajax({
              type:"POST",
              data:{'catid':$(this).attr('data-cat') ,  'zoneid': $(this).attr('data-zoneid') , 'status':$status,'subusereixsts':subusereixsts },                 
              url: '/Zonedashboard/save_zone_cat_display',      
              cache: false,
              beforeSend : function(){
                $('#loading').css('display','block');
                },
                complete: function() {
                    $('#loading').css('display','none');
                },
              success: function(data){        
                  
                 savingalert('success','Data Saved Successfully!');
              }
            });  

    });


 $('#eventactivity').on('click',function(e){
            e.preventDefault();
             var allcategorie = $("#getselectval").find(":selected").text();
             var titleval= $(".title-val").val();
             var content= $(".content").val();
             var getzoneid = $("#getzoneid").val();
             var getbusinessnam = $("#getbusinessnam").text();
            $.ajax({
                url : "/activityemailblog",
                type : "POST",
                dataType : "json",
                data : {"allcategorie" : allcategorie, "titleval" : titleval,"content": content ,"getzoneid":getzoneid ,"getbusinessnam":getbusinessnam},
                success:function(data) {
                   // alert(data); 
                }
            });
        });
    
 });


$(document).on('click','.managecategories .updatecat',function(e){
   e.preventDefault();
   
  $('.managecategories .subcategories_data input[type=checkbox]:checked').each(function(){
        
  });

});


$(".managecategories  .allcheckbox").change(function(){  
  if ($(this).is(':checked')) {      
  $('.display_checkbox').prop('checked', true);      
  } else {     
    $('.display_checkbox').prop('checked', false); 
  }      
});

$('.makeallselected').click(function(){  
  if ($('.display_checkbox1').is(':checked')) {      
$('.display_checkbox1').prop('checked', false); 
  
  } else {     
     
      $('.display_checkbox1').prop('checked', true);   
    
  }      
});


    $(document).on('click' , '.sub_updatecat' ,function(e){
        e.preventDefault();
        
        var CatArray = [];
        var $cnt = 0;

           $(this).parents('.alllist_sub').find('tr').each(function(e){
            
                if($(this).find('.subcatID .display_checkbox1').is(':checked')) {            
                      CatArray.push($(this).find('.subcatID .display_checkbox1').attr('data-cat'));
                          $cnt++;
                  } 
           });

   
           if($cnt == 0){
                savingalert('warning','Please select Category to make active!');
           }else{

                $.ajax({
                       type:"POST",
                        data:{'catid':JSON.stringify(CatArray), 'PCatId':$('.categoryID').val()  , 'zoneid': $('.makeselected').attr('data-zoneid') },                 
                        url: '/Zonedashboard/save_zone_sub_cat_display',      
                        cache: false,
                        beforeSend : function(){
                            $('#loading').css('display','block');
                        },
                        complete: function() {
                            $('#loading').css('display','none');
                        },
                        success: function(data){ 
                              savingalert('success','Data Saved Successfully!');
                        }
                });
           }
     
    })

       

$(".cus-solid-prpl").click(function(){
    $("#makenewad_wrapper").hide();  
});
$("#closedeal").click(function(){
    $("#makenewad_wrapper").show();
});

 $(document).ready(function () {
    $("button").click(function () {
      // $(".bidnowbox").hide(1000);
    });
  });

 /* dilog box js here */

 // 2023-08-27 By Joao Rodrigues
class Dialog {
  // Declare static properties to store the dialog elements
  static dialog = null;
  static dialogBody = null;
  static closeButton = null;
  static button = null;

  constructor(dialogId) {
    // Check if the dialog element already exists, if not, create it
    if (!Dialog.dialog) {
      Dialog.dialog = this.#createHTMLDialogBox(dialogId);
    }
    Dialog.dialogBody = Dialog.dialog.querySelector(".dialog-body");
    Dialog.closeButton = Dialog.dialog.querySelector(".dialog-close");
    Dialog.button = Dialog.dialog.querySelector(".dialog-button");

    // Bind the close method to the current instance
    this.close = this.close.bind(this);

    // Add an event listener for the two buttons.
    Dialog.closeButton.addEventListener("click", this.close);
    Dialog.button.addEventListener("click", this.close);
  }

  set visible(value) {
    Dialog.dialog.classList.toggle("open", value);
  }

  show(message) {
    Dialog.dialogBody.textContent = message;
    document.addEventListener("keydown", this.close);
    // Use requestAnimationFrame to force transitions to run at the first time.
    requestAnimationFrame(() => {
      this.visible = true;
    });
  }

  close(event) {
    // Check if the ESC key was pressed or the button was clicked
    if (event?.key === "Escape" || event?.type === "click") {
      this.visible = false;
      document.removeEventListener("keydown", this.close);
    }
  }

  // Declare a private method to create a HTML dialog element and append it to the document
  #createHTMLDialogBox() {
    const dialog = document.createElement("div");
    dialog.setAttribute("role", "dialog");
    dialog.setAttribute("aria-labelledby", "jsdialog-title");
    dialog.setAttribute("aria-describedby", "jsdialog-body");
    dialog.classList.add("dialog");
    dialog.id = "jsdialog";
    dialog.innerHTML = `
      <div class="dialog-header">
        <span class="dialog-title" id="jsdialog-title">Free New Movers</span>
        <button type="button" class="dialog-close" aria-label="Close">&times;</button>
      </div>
      <div class="dialog-body" id="jsdialog-body">
        
      </div>
      <div class="dialog-footer">
        <button type="button" class="dialog-button">OK</button>
        <p>The minimum ad position rankings bid is only $60 per month to obtain 30 new movers credits. ( $2.00 per new mover credit)</p>
        <ul>
        <li>Bid $100 for ad position ranking and get 100 new mover credits. ( $1.00 per new mover credit)</li>
        <li>Bid $200 and get 300 new mover credits. ($.67 per new mover credit)</li>
        <li>Bid $300 and get 750 new mover credits ('$.40 per new mover credit)</li>
        <li>Bid $500 and get 2000 new mover data credits. ('$.25 per new mover credit)</li>
        <li>Bid $1,000 and get 10,000 new mover data credits. ('$.10 per new mover credit)</li>
        </ul>
      </div>`;
    return document.body.appendChild(dialog);
  }
}

/**
 * Click event handler for the button.btn.
 * It creates a new instance of the Dialog class and
 * calls the show method with a message argument.
 */
const buttons = document.querySelectorAll(".lrnmore");
buttons.forEach((button) => {
  button.addEventListener("click", () => {
    new Dialog()
      .show(`Bidding for ad position rankings not only improves your business ad position rankings within your business subcategory, it also gives you
        access to our very valuable daily feed of highly targeted new movers.`);
  });
});