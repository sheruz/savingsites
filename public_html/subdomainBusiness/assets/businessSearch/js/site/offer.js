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
	user_id = $('input[name=user_id]').val(); 
	user_type = $('input[name=user_type]').val();
    //$('.offerview').click();
    $.fn.showOffer() ;
     /* For Ad Favorite */
 $(document).on('click','.ad_favorite',function(){  //alert('favorite');
    var type=0; var status=1;
    var ad_id = $(this).attr('data-adid'); 
    var bus_id = $(this).attr('data-busid'); 
    var zone_id = zoneId; 
    var user_id = $(this).attr('data-UserId');    

    var rel = $(this).attr('rel'); 

    if(user_id){
        var data_to_use={
            'user_id': user_id,
            'zone_id': zone_id,
            'createdby_id': bus_id,
            'type': type,
            'status': status,
            'adid': ad_id
            //'from':from
        };
        $.ajax({
            'type': "POST",
             'url': base_url+"zone/change_status_type/",
             'cache': false,
             'data':data_to_use,
            beforeSend: function(){},   
            success : function(data){ //alert(data);
                
                if(data == 1){  
                    if(rel == 0){                        
                        $('.ad_favorite span').text('Remove Favorite');                       
                        $('.favorite-caption').text('Click on the below button to remove this Offer from your Favorites List.');
                        rel = $('.ad_favorite').attr('rel', 1);
                        //$(this).find('.tabs-menu').find('ul.nav-tabs').find('.ad-menu-favorite').text('Remove Favorite');
                    }else if(rel == 1){ 
                         $('.ad_favorite span').text('Add Favorite');                        
                        $('.favorite-caption').text('Click on the below button to add this Offer to your Favorites List.');
                        rel = $('.ad_favorite').attr('rel', 0);
                        //(this).find('.tabs-menu').find('ul.nav-tabs').find('.ad-menu-favorite').text('Add Favorite');
                    }  
                }
            }
        });
    }
});
     /* For Ad Favorite */
     /* Snap alert */
     $(document).on('click','.emailnoticepopup',function(){
        var type=2; var status='';
        var ad_id = $(this).attr('data-adid'); //alert(ad_id);
        var bus_id = $(this).attr('data-busid'); //alert(bus_id);
        var zone_id = zoneId; 
        var user_id = $(this).attr('data-userid'); //alert(user_id);
        $.fn.showemailnoticepopup(user_id,bus_id,zone_id,type,status,ad_id) ;
     });
    /* Snap alert */
});
$.fn.showemailnoticepopup = function(user_id,createdby_id,zone_id,type,from,adid){
    //alert('user_id:'+user_id+'createdby_id:'+createdby_id+'zone_id'+zone_id+'type:'+type); return false;
        //alert(222222);
       //$(".snap_time").attr('checked', true);
        if(type=='2')
        {
            var group_for="Business'"; var group_for_1="business";
        }
        else if(type=='3')
        {
            var group_for="Organization's"; var group_for_1="organization";
        }
        else
        {
            var group_for=""; var group_for_1="";
        }
        /*var snapCriteria = getSnapCriteria();
        alert(snapCriteria);*/
        var txt = "";
        var data_to_use={'user_id':user_id,'createdby_id':createdby_id,'zone_id':zone_id,'type':type};
         
        $.ajax({
            'type': "POST",
            'url':base_url+ 'emailnotice/check_ig_display',
            'dataType':'json',
            'data':data_to_use,
            'success':function(result){

            //alert(result);
            //console.log(result);return false;
            var percentageCriteria = "";
            var snapStartTime      = "";
            var snapWeekDays       = "";
            //console.log(result[2]);

            var snapDayIdString       = result[2].snapDayId;
            var snapTimeIdString      = result[2].snapTimeId;
            var discountPercentage    = result[2].snapPercentage;
            var dayArray              = [];
            var timeArray             = [];
            var anyDayIdSelected      = "";
            var anyTimeIdSelected     = "";
            if(discountPercentage){
                discountPercentage = parseInt(discountPercentage);
            }
            if(snapDayIdString){
                dayArray = snapDayIdString.split(',');
            }
            if(snapTimeIdString) {
                timeArray = snapTimeIdString.split(',');
            }
           $.each(result[1].percentageCriteria,function(index,val){
            var percentageSelected = "";
            if(index == discountPercentage){
                percentageSelected = "selected";
            }
            percentageCriteria+= "<option value='"+index+"' "+percentageSelected+">"+val+"%</option>";
            //percentageCriteria+="<input type='checkbox' name='percentageCriteria' value='"+val.id+"'><span>"+val.discount_percentage+"</span>"

           });
           //alert(percentageCriteria);

           $.each(result[1].snapWeekDays,function(index,val){
            var checkdata = "";
            //if($.inArray(index, dayArray) !== -1){
                checkdata = "checked";
            //}
            
            //snapWeekDays+= "<option value='"+val.id+"'>"+val.day+"</option>";
            snapWeekDays+="<input type='checkbox' name='snapweekdays' class = 'snapWeekDaysCheckBox' onChange = 'countSnapWeekDay(this)' value='"+index+"' "+checkdata+">&nbsp;<span>"+val+"</span><br>";
           });
           //alert(snapWeekDays);
           //alert(66666666);
           
           var j = 1;
           var i = 0;
           $.each(result[1].snapStartTime,function(index,val){
            var formattedTime = fomartTimeShow(val);
            var checkData = "";
            if($.inArray(index,timeArray) !== -1){
                checkData = "checked";
            }
            if(j == 1){
                snapStartTime+= "<div class='col-sm-3 col-xs-6'>";
            }
            snapStartTime+="<input type='checkbox' class='snap_time snapStartTimeRegistration' name='snapTime' value='"+index+"' "+checkData+">&nbsp;<span>"+formattedTime+"</span><br>";
            if(j == 6){
                snapStartTime+= "</div>";
                j=0;
                
            }
            j++;
           });

           
            var checked_group=new Array();
            if(checked_group == ''){
                $.each(result[0],function(index,val){
                    checked_group.push(val.interest_groupid);
                })
            }

            if(type == 2){
                $.ajax({
                    'type': "POST",
                    'url': base_url + 'emailnotice/check_ig_display',
                    'dataType':'json',
                    'data':data_to_use,
                    'success':function(result){
                    var emailBox = $('#email_notice_pop_up');
                    //console.log(result);
                    $(".snap_time").attr('checked', true);
                    if(result!='')
                    {

                        if(result.status!='undefined')
                        {
                            var status=result.status;

                            var send_type = result.send_type;
                            var radio1= '',radio2='',radio3='';
                            if(status=='1' || send_type == 1 || send_type == 2 || send_type == 3){
                                var on_checked='checked="checked"'; var showdiv = '';
                                if(send_type == 1){
                                    radio1 = 'checked="checked"';
                                }
                                else if(send_type == 2){
                                    radio2 = 'checked="checked"';
                                }
                                else if(send_type == 3){
                                    radio3 = 'checked="checked"';
                                }
                                sendtypechange();

                            }
                            else { var off_checked='checked="checked"'; var showdiv = 'display:none;';}
                        }

                        if(result.active_group_display!='')
                        {
                            var select_line='</br><h4 style="margin-top:5px; font-size: 15px;">Select as many Interest Groups as you like to receive their special offers.</h4></br>';
                            //var select_line='</br><h4 style="margin-top:5px">Select to choose the interested Interest Group/Groups. Select as many as you can.</h4></br>';
                            text = select_line ;
                        }
                        else
                        {
                            /*text = "<h4 style='color:rgb(145, 74, 173); margin-top:35px; font-size: 15px;'> Please select interest group otherwise you can't get email notice from this business.</h4>";*/
                            text = '';
                            // var select_line='</br><h3 style="margin-top:5px">No interest group available for these '+group_for+'!</h3>';
                        }
                        var select_line='';
                        var ratingcontent='<h1 style="text-align:center; font-size: 26px; display:none;">Choose how you want this '+group_for+' to alert you</h1><br><span style="font-size: 14px;font-weight:bold; text-align:center;">To change your Opt-in Status for this '+group_for_1+' highlight below</span><div class="ig_submit_loading" style="margin:9px 0px 0px 0px;display:none;">Processing...<img id="loading1" src="<?=$link_path?>assets/images/loading.gif" width="20" height="20" alt="loading" style="padding-left:15px;"/></div><div class="successsnap" style="display:none;"></div><br><br><input type="radio" '+on_checked+' onchange=sendtypechange(); name="status" value="1" /><span style="display: block;font-weight: bold;margin: -24px 0px 10px 21px;">Yes I want email notices from this '+group_for_1+', but emailed by SavingsSites, to protect my email address.</span><div id="textoremail" class="checked_group text-center" style="'+showdiv+'" align="right"><input type="radio" name="statusRadio" onchange="sendtypechange();" value="1" '+radio1+'><span style="margin-left: 10px;font-weight: bold;">Email</span>&nbsp;<input type="radio" name="statusRadio" onchange="sendtypechange();" value="2" '+radio2+'><span style="margin-left: 10px;font-weight: bold;">Text Message</span>&nbsp;<input type="radio" name="statusRadio" onchange="sendtypechange();" value="3" '+radio3+'><span style="margin-left: 10px;font-weight: bold;">Both Email and Text Message</span>\
                             <br>\
                            </div>\
                            <div id="snapFilterCriteria" style="display:none;">\
                            <div class="row" style="padding-top:20px;">\
                            <div style="" class="col-sm-12">\
                                    <p class=" text-center">Indicate Minimum discount Percentage you want before Receiving Offers: </p>\
                            </div>\
                            <div style="" class="col-sm-8 col-sm-offset-2">\
                                    <select id="percentageCriteria" class="form-control">\
                                        <option selected="selected" value="0">Any Discount</option>\
                                        '+percentageCriteria+'\
                                    </select>\
                            </div>\
                            <div style="clear:both;"></div>\
                            <br>\
                            <div class="col-sm-12">\
                                <p class=" text-center">Check the Days of the Week & Times of the Day you are Available to use offers from this business so you only receive offers you want to review : </p>\
                            </div>\
                            <br>\
                            <div class="col-sm-12">\
                            <div class="row snaptimecolumn" style="margin-top:26px;">\
                                <div class="col-sm-3 col-xs-6" style="margin-top:40px;">\
                                    '+snapWeekDays+'\
                                </div>\
                                <div class="col-sm-3 col-xs-6" style="height:40px;">\
                                    <div class="any-time" style="margin-left: 61%; position: absolute; width: 100px; margin-top: -26px;">\
                                    <input type="checkbox" name = "snapTime" id = "snapAnyTime" value="0" data-name = "time" class="snapStartTimeRegistration" onChange = "snapAny(this)" '+anyTimeIdSelected+'> &nbsp;<span>Any Time</span></div>am<br>\
                                </div>\
                                <div class="col-sm-3 col-xs-6 hidden-xs snapDynamicTime" style="height:40px;">pm</div><div class="col-sm-3 col-xs-6 hidden-xs" style="height:40px;">pm</div>\
                                 '+snapStartTime+'\
                                 </div>\
                                 </div>\
                                 </div>\
                                 <br>\
                                <div style="padding-top:20px;padding-bottom:5px;text-align:center">\
                                    <button id="saveCriteria" class="btn btn-default" data-user-id = "'+user_id+'" data-createdby-id = "'+createdby_id+'" data-zone-id = "'+zone_id+'" data-type = "'+type+'" data-from = "'+from+'" data-adid = "'+adid+'">Submit</button>\
                                </div>\
                            </div>\
                            </div>\
                            <br>\
                            <div class="">\
                            <input type="radio" '+off_checked+' name="status" value="0" onchange=igformsubmit('+user_id+','+createdby_id+','+zone_id+','+type+',"'+from+'",'+adid+');sendtypechange(); /> <span style="margin-left: 10px;font-weight: bold;">No I don&rsquo;t want email notices from this '+group_for_1+'.</span></div><div id="checked_group"></div><br><br>'+select_line+'</br> <form id="igformsubmit" name="igform" action="javascript:void(0);" method="post">';
                        if(result.active_group_display!='')
                        {
                            $.each(result.active_group_display,function(index, value){
                                if ($.inArray(value.id,checked_group) !== -1)
                                {
                                    var checkstatus="checked";
                                }
                                else
                                {
                                    var checkstatus="";
                                }
                                var igid=value.id;
                                var igname=value.name;

                                ratingcontent+='<p><span style="margin-bottom:7px; display:block;"><input style="margin-right:10px;" name="group[]" class="group" '+checkstatus+'  type="checkbox" onchange=igformsubmit('+user_id+','+createdby_id+','+zone_id+','+type+',"'+from+'",'+adid+'); value='+igid+' /><label style="font-size:18px;">'+igname+'</label></span></p>';

                            })
                        }
                        ratingcontent+='</form>';
                    } else {
                        var ratingcontent='<a href="javascript:void(0)" class="close"><img src="<?=$link_path?>assets/images/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a><h3>Have not any category to select</h3>';
                    }
                    $(emailBox).html(ratingcontent).fadeIn(300);
                    if(result.status == 1 || result.status == 2 || result.status == 3){
                       sendtypechange();
                    }
                    if(snapDayIdString == "0") {
                       $("#snapAnyDay").attr('checked', 'checked').change();
                    }
                    if(snapTimeIdString == "0") {
                       //$("#snapAnyTime").attr('checked', 'checked').change();
                       $(".snap_time").attr('checked', 'checked');
                    }

                   /* $('input[name = "snapweekdays"][value = "'+result[2].snapDayId+'"]').prop("checked",true);*/

                    $("#email_notice_pop_up").find('#checked_group').html(text);
                    return false;
                }
                })
            } else if(type == 3){
                $.ajax({                    
                    'type': "POST",
                    'url': base_url + 'emailnotice/selected_orgcategory_byloggeduser',
                    'dataType':'json',
                    'data':data_to_use,
                    'success':function(result){
                    var emailBox = $('#email_notice_pop_up');
                    if(result!='')
                    {
                        if(result.status!='undefined')
                        {
                            var status=result.status;
                            var send_type = result.send_type;
                            var radio1= '',radio2='',radio3='';
                            if(status=='1' || send_type == 1 || send_type == 2 || send_type == 3){var on_checked='checked="checked"'; var showdiv = '';
                                if(send_type == 1){
                                    radio1 = 'checked="checked"';
                                }
                                else if(send_type == 2){
                                    radio2 = 'checked="checked"';
                                }
                                else if(send_type == 3){
                                    radio3 = 'checked="checked"';
                                }
                                //customSnapFilterSlideDown();
                            }
                            else { var off_checked='checked="checked"'; var showdiv = 'display:none;';}
                        }

                        if(result.active_group_display!='')
                        {
                            var select_line='</br><h4 style="margin-top:5px">Select as many Interest Groups as you like to receive their special offers.</h4></br>';
                            //var select_line='</br><h4 style="margin-top:5px">Select to choose the interested Interest Group/Groups. Select as many as you can.</h4></br>';
                            text = select_line ;
                        }
                        else
                        {
                            text = "<h4 style='color:rgb(145, 74, 173); margin-top:35px;'> Please select interest group otherwise you can't get email notice from this organigation.</h4>";
                        }
                        var select_line='';
                        var ratingcontent='<a href="javascript:void(0)" class="close"><img src="<?=$link_path?>assets/images/close_pop.png" class="btn_close '+from+'" title="Close Window" alt="Close" /></a><h1 style="text-align:center; font-size: 26px;">'+group_for+' Calendar Categories</h1><br><span style="font-size: 14px;font-weight:normal; text-align:center;">This Organization has created categories of interest so you can filter and see only the calendar events by your selected interests.<br><br>The organization will be able to login to our email server and email or text you based upon your selected categories.The email or text will come from Savings Sites, as your email or text number is never provided to anyone.<br><br>Please Choose at Least One Category of Interest.If you have chosen no interest categories, you will not receive emails nor able to filter calendar events.</span><div class="category_loading" style="margin:9px 0px 0px 0px;display:none; text-align:center"><img id="loading1" src="<?=$link_path?>assets/images/loading.gif" width="20" height="20" alt="loading" style="padding-left:15px;"/></div><div class="success" style="display:none; text-align:center"></div><br><br><form id="orgcat_form" name="orgcat_form" action="javascript:void(0);" method="post" style="margin-left: 50px;">';
                        if(result.selected_category!='')                                    // If selected category present
                        {
                            $.each(result.selected_category,function(index, value){
                                if (value.ischecked== 1)
                                {
                                    var checkstatus="checked";
                                }
                                else
                                {
                                    var checkstatus="";
                                }
                                var categoryid      =   value.catid;
                                var categoryname    =   value.catname;
                                var checkboxid      =   'checkbox_'+categoryid ;

                                ratingcontent+='<p><span style="margin-bottom:7px; display:block;"><input style="margin-right:10px;" id="'+checkboxid+'"  type="checkbox" '+checkstatus+' userid='+user_id+' zoneid='+zone_id+' catid='+categoryid+' onchange=checkUncheckOrgcategory('+checkboxid+');  /><label style="font-size:18px;">'+categoryname+'</label></span></p>';
                            })
                        }else{                                                              // If have not any organizational category
                            ratingcontent+='<p><span style="margin-bottom:7px; display:block;text-align: center;"><label style="font-size:18px; color: darkolivegreen;">Have not any category to select</label></span></p>';
                        }
                        ratingcontent+='</form>';
                    } else {
                        var ratingcontent='<a href="javascript:void(0)" class="close"><img src="<?=$link_path?>assets/images/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a><h3>Have not any category to select</h3>';
                    }
                    $(emailBox).html(ratingcontent).fadeIn(300);
                    $("#email_notice_pop_up").find('#checked_group').html(text);

                    return false;

                 }

                })
            }
          }
        })
}
$.fn.showOffer = function(){ 
    var lowerlimit = 1;    
    var upperlimit =10;
    var data_to_use={
        'user_id': user_id,
        'zone_id': zoneId,
        'lowerlimit': lowerlimit,
         'upperlimit': upperlimit,
        'barter_button': '',
        'job_button': '',
        'home_url':link_path,
        //'from_where':"home_page_ads"
        'from_where':"sponsor_businesses_home_page", 
        'link_path':link_path
    };
    $.ajax({
        'type': "POST",
         'url': base_url+"ads/temp_ads/",
         'cache': false,
         'data':data_to_use,
        beforeSend: function(){},   
        success : function(data){//console.log(data); //return false; 
            $('.outerofferdiv').show();
            $('.outerofferdiv').html(data);
            lowerlimit=parseInt(lowerlimit) + parseInt(upperlimit);
            $('input[name=lowerlimit]').val("");
            $('input[name=lowerlimit]').val(lowerlimit);
            //$.fn.check_snap_status($ad['bs_id'], $user_id,2,$zoneid) ;        
        }
    });
}

$.fn.showOffer_mouseover = function(){ 
    var lowerlimit = $('input[name=lowerlimit]').val(); 
    var upperlimit =10;
    var data_to_use={
        'user_id': user_id,
        'zone_id': zoneId,
        'lowerlimit': lowerlimit,
         'upperlimit': upperlimit,
        'barter_button': '',
        'job_button': '',
        'home_url':link_path,
        //'from_where':"home_page_ads"
        'from_where':"sponsor_businesses_home_page",
        'link_path':link_path
    };
    $.ajax({
        'type': "POST",
         'url': base_url+"ads/temp_ads/",
         'cache': false,
         'data':data_to_use,
        beforeSend: function(){},   
        success : function(data){ //console.log(data);
            $('.outerofferdiv').append(data);
            lowerlimit=parseInt(lowerlimit) + parseInt(upperlimit);
            $('input[name=lowerlimit]').val("");
            $('input[name=lowerlimit]').val(lowerlimit);
                    
        }
    });
}

var counter =0;
$(window).scroll(function() {
   if($(window).scrollTop() + $(window).height() == $(document).height()) {
       counter = counter + 1;
       if(counter>1){
        //alert("bottom!"); alert(lowerlimit); alert(upperlimit);
        $.fn.showOffer_mouseover() ;
       }
        
   }
});

 function snapAny(element) {
	if($(element).is(":checked")){
		//$(lement).parent().parent().siblings().find('input.globalSnapRegistration').prop({'disabled':true,'checked':false});
		$(".snapStartTimeRegistration").prop('checked', false);
		$(".snapStartTimeRegistration[value=0]").prop('checked', true);
		$(".snapStartTimeRegistration").prop('disabled', true);
		$(".snapStartTimeRegistration[value=0]").prop('disabled', false);
	  } else {
		//$(element).parent().parent().siblings().find('input.globalSnapRegistration').prop('disabled',false);           
		$(".snapStartTimeRegistration").prop('checked', true);
		$('.snapStartTimeRegistration[value=0]').prop('checked',false);
		$(".snapStartTimeRegistration").prop('disabled', false);
		
	  }
 }

function fomartTimeShow(hour){
       hour = parseInt(hour);
       var ampm = "am";
            if (hour >= 12){
                ampm = "pm";
            }
            h = hour % 12;
            if (h == 0){
             h = 12;
            }
            return h +":00";
     }

function sendtypechange(){
        var radioStatus = $('input[name="statusRadio"]:radio:checked').val(); //alert('radioStatus'+radioStatus);
         if( radioStatus  == 1 || radioStatus == 2 || radioStatus == 3 ){
            $("#snapFilterCriteria").slideDown("slow"); 
        };
        var rstatus = $('input[name="status"]:radio:checked').val(); //alert('rstatus'+rstatus);  
        if(rstatus == 0){
            $('#textoremail').slideUp('slow');
            $("#snapFilterCriteria").slideUp("slow");
        }
        else{
            $('#textoremail').slideDown('slow');
        }
    }
 $(document).on('click','#saveCriteria',function(event){
        var snapWeekDays  = [];
        var snapTimes      = [];
        $('input[name = "snapweekdays"]:checkbox:checked').each(function(){
            snapWeekDays.push($(this).val());
        });
        $('input[name = "snapTime"]:checkbox:checked').each(function(){
            snapTimes.push($(this).val());
        });
        if(snapWeekDays.length == 0) {
            toastDisplay('error','Please select atleast one Week day');
            return false;
        }
        if(snapTimes.length == 0) {
            //alert("Please select atleast one available Time");
            toastDisplay('error','Please select atleast one available Time');
            return false;
        }
        var minPercentage = $("#percentageCriteria").val();
        var checkedCategory  = $('input[name="statusRadio"]:radio:checked').val();
        var userId           = $(this).attr('data-user-id');
        var createdById      = $(this).attr('data-createdby-id');
        var zoneId           = $(this).attr('data-zone-id');
        var dataType         = $(this).attr('data-type');
        var dataFrom         = $(this).attr('data-from');
        var dataAdId         = $(this).attr('data-adid');
        igformsubmit(userId,createdById,zoneId,dataType,dataFrom,dataAdId,checkedCategory,snapWeekDays,snapTimes,minPercentage);
    });
function igformsubmit(user_id,createdby_id,zone_id,type,from,adid,sendingtype = 0,snapWeekDaysId =[0],snapTime =[0],minPercentageId = 0){ 

        var sendtype = (sendingtype !='' && sendingtype != undefined) ? sendingtype : '' ;
        var selected = $('input[name="status"]:radio:checked');
        if (selected.val()=='1')
        {
            var status = '1';

        }
        else
        {
            var status='0';

        }
        var iggroup=$('input:checkbox.group').serializeArray();
        var interestgroup=new Array();
        $.each(iggroup,function(index,val)
        {
            interestgroup.push(val.value);
        })
       /* $('form#igformsubmit').ajaxStart(function(){
            $('.ig_submit_loading').show();
            $('.successsnap').hide();

        })
        $('form#igformsubmit').ajaxComplete(function(){
            $('.ig_submit_loading').hide();
            $('.successsnap').show();
            $('.successsnap').html('<h4 style="color:#008040;margin-top:9px;">Successfully done.</span>');
            if(from!='' && from=='ig')
            {
                window.location.reload(true)
            }

        })*/
        var data_to_use={'iggroup':interestgroup,'user_id':user_id,'createdby_id':createdby_id,'zone_id':zone_id,'type':type,'status':status,'send_type':sendtype,'snapWeekDaysId':snapWeekDaysId,'snapTime':snapTime,'minPercentageId':minPercentageId};
        //alert(base_url+'emailnotice/user_ig_insert');
        $.ajax({
            'type': "POST",
            'url': base_url+'emailnotice/user_ig_insert',            
            'data':data_to_use,
            'beforeSend': function(){  
                $('.ig_submit_loading').show();
                $('.successsnap').hide();
            }, 
            'success':function(result){  
             //alert(result);
              $('.ig_submit_loading').hide();
                $('.successsnap').show();
                $('.successsnap').html('<h4 style="color:#008040;margin-top:9px;">Successfully done.</span>');
                if(from!='' && from=='ig')
                {
                    window.location.reload(true)
                }
                change_status_type(user_id,zone_id,createdby_id,type,status,adid,'snap');
        }
        });
    }

function change_status_type(user_id,zone_id,createdby_id,type,status,adid,from){ //
        //alert(user_id); alert(zone_id); alert(createdby_id); alert(type); alert(status); alert(adid); alert(from); //return false;
        var str = '';
        if(user_id){
            if(status == 1 && from == 'snap'){
                str+='<a class="toggle-on-off-img on emailnoticepopup" style="cursor: pointer;" data-target="#email_notice_pop_up_modal" data-toggle="modal" data-adid="'+adid+'" data-busid="'+createdby_id+'" data-userid="'+user_id+'"><img data-on="images/turn-on.png" data-off="'+link_path+'assets/directory/images/turn-off.png" src="'+link_path+'assets/directory/images/turn-on.png" class="for-img-shadow"/></a>';
                $('.snapdiv'+adid).html(str);
                        
            }else if(status == 0 && from == 'snap'){ //alert(2);                        
                str+='<a class="toggle-on-off-img on emailnoticepopup" style="cursor: pointer;" data-target="#email_notice_pop_up_modal" data-toggle="modal" data-adid="'+adid+'" data-busid="'+createdby_id+'" data-userid="'+user_id+'"><img data-on="images/turn-on.png" data-off="'+link_path+'assets/directory/images/turn-on.png" src="'+link_path+'assets/directory/images/turn-off.png" class="for-img-shadow"/></a>';                        
                $('.snapdiv'+adid).html(str);
            }
            $("#headerad"+adid).html(str);
        }
    }





