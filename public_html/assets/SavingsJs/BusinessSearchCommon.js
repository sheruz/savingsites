var amazonurl = $('#amazonurl').val();

addEventListener("load", function() {
    setTimeout(hideURLbar, 0);
}, false);
function hideURLbar() {
    window.scrollTo(0, 1);
}

setTimeout(function(){  
    if(window.innerWidth >= '1920'){
  jQuery('.viewFilters a.gridviewfour').trigger('click');
}else if (window.innerWidth >= '1024' && window.innerWidth <= '1366'){
     jQuery('.viewFilters a.gridview').trigger('click');
}else if(window.innerWidth >= '720' &&  window.innerWidth <= '1280'){
  jQuery('.viewFilters li:nth-child(2) a').trigger('click');
}
 }, 
3000);

var base_url =  jQuery('input[name ="base_url"]').val();
var addthis_config = {
    "data_track_addressbar": false,
    services_overlay: 'facebook,twitter,email,print,more'
};

$('a.admaps').click(function() {
    var ad_id = $(this).attr('rel');
    var smsBox = $('.map_' + ad_id).attr('href');
    $(smsBox).toggle('slow');

    return false;
});

$('.visit_home').click(function(e){
    e.preventDefault();
    var dataval = $(this).attr("data-page");
    $("#redirect-page .page").val(dataval);
    $("#redirect-page").submit();
});

$( ".dropdown_select_cat" ).change( function() {
    $catID = $(this).find(':selected').attr("data-catid");    
    $.ajax({
        'type': "POST",
        'url': base_url+"/BusinessSearch/getSubDropdown/",   
        'data': {catid : $catID , zoneID: '<?php echo $zoneid; ?>' }, 
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },   
        success : function(data){        
            $(".sub_mob_populate").html(data);
            setTimeout(function(){ $( ".sub_mob_populate option" ).first().click();  }, 100);
        }
    });
});

setTimeout(function(){  
    $.ajax({
        'type': "POST",
        'url': base_url+"/BusinessSearch/getSubDropdown/",   
        'data': {catid : 1 , zoneID: '<?php echo $zoneid; ?>' }, 
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },   
        success : function(data){      
            $(".sub_mob_populate").html(data);
        }
    }); }, 
3000);

$("#menuToggle").click(function(){
    $(this).toggleClass('open');
    $('#menu-bar').toggleClass('open');
});

$("#menuToggle-mobile").click(function(){
    $(this).toggleClass('open');
    $('#menu-bar-mobile').toggleClass('open');
});

$('.sortopen').click(function(e){
    e.preventDefault();
    $('.sortarea').toggleClass('open');
});

$('div.nav-container .navbar ul.nav > li > div.tabbed-menu > ul > li > a[href^="#"]').click(function(e){
    var active = $(this).parent().hasClass('active');
    $('div.nav-container .navbar ul.nav > li > div.tabbed-menu > ul > li').removeClass('active');
    $('div.nav-container .navbar ul.nav > li > div.tabbed-menu > ul > li').find('a[data-toggle="tab"]').removeClass("active-tab");
    $('div.nav-container .navbar ul.nav > li > div.tabbed-menu > ul > li').find('.tabbed-menu-content').removeClass("active-tab-content");
    if(!active){
        $(this).parent().addClass('active');
        $(this).parent().find('a[data-toggle="tab"]').addClass("active-tab");
        $(this).parent().find('.tabbed-menu-content').addClass("active-tab-content");
    }
});

duraFunc=function(){
    "use strict";
    $('.dropdown-menu a[data-toggle="tab"]').on("click",function(a){a.stopPropagation(),$(this).tab("show")}),
    $("div.nav-container .navbar ul.nav > li > div.tabbed-menu > ul > li").mouseover(function(){
        $(this).is(":first-child")||$("div.nav-container .navbar ul.nav > li > div.tabbed-menu > ul > li:first-child a").removeClass("active-tab")
    }),
    $("div.nav-container .navbar ul.nav > li > div.tabbed-menu > ul > li").mouseleave(function(){
        $("div.nav-container .navbar ul.nav > li > div.tabbed-menu > ul > li:first-child a").addClass("active-tab")
    })
    jQuery('div.nav-container .navbar ul.nav > li > div.tabbed-menu > ul > li > a[href^="#"]').click(function(e) { 
        e.preventDefault();
    });
},
    duraFunc();

$("span.menu").click(function() {
    $(".top-nav ul").slideToggle("slow", function() {});
});

$(function() {
    setTimeout(function(){  //addthis.init(); 
   // addthis.layers.refresh(); 
    
    $(document).on('click','.visitor_registration',function(){
        var data_to_use={
            'createdby_id': '',
            'zone_id': '<?php echo $zoneId; ?>',
            'type': '',
            'ad_id': '',
            'offer_type':'',
            'url':$(location).attr("href")
        };
        $.ajax({
            'type':'POST',
            'url':"<?php echo base_url() ?>emailnotice/visitornoticesignform",
            'data':data_to_use,
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },            
            success : function(data) {  
                if(data !=''){
                     data = JSON.parse(data);   
                    $("#visitorsignupform_content").show();
                    $("#visitorsignupform_content").html(data.Tag);
            
                    return false;
                }
            }
        });
    }); 
    
    $(document).on('click','.employee_registration',function(){
        var data_to_use={
                'createdby_id': '',
                'zone_id': '<?php echo $zoneId; ?>',
                'type': '',
                'ad_id': '',
                'offer_type':'',
                 'url':$(location).attr("href")
            };
            
        $.ajax({
            'type'      :'POST',
            'url'       :"<?php echo base_url() ?>emailnotice/employeenoticesignform",
            'data'      :data_to_use,
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },            
            'success'   : function(data) {          

                if(data !=''){
                     data = JSON.parse(data);                  
                    $("#employeesignupform_content").show();
                    $("#employeesignupform_content").html(data.Tag);            
                    return false;
                }

            }
        });

    
    }); 
    $(document).on('click','#businessreservation', function(){
        var e = 'show_ads_specific_category';
        var s,
        o,
        r = getUrlParameter("per-post-onpage");
    new URLSearchParams(window.location.search);
    if (
        ((ads_view = $.cookie("ads_view") ? $.cookie("ads_view") : $(".viewFilters a.active").attr("data-view")),
        0 == r || "show_all_offers" == e || "filter-for-pboo" == e ? ((s = 1), (o = 20)) : ((s = r), (o = 20)),
        0 != $(".selectedfiltere").val().length)
    ) {
        var n = $(".selectedfiltere").attr("data-filter"),
            d = $(".selectedfiltere").val();
        "show_favorites_ads" != e && ("redemptionvalue" == n && ((e = "filter-for-pboo"), (t = d)), "businessaplhaname" == n && ((e = "show_all_offers"), (t = d)));
    }
        var noOfPerson = $('#noOfPerson').val();
        var searchDate = $('#datepicker1').val();
        var time = $('#time option:selected').text();
        var foodType = $('#foodType').val();
        var snapSettingsType = 0;
        var isDelivaryRequired = false;
        var user_id = $('#userId').val();
        var zone_id = $('#zoneId').val();
        var orderBy = 'MAXDISCOUNT';
        var outDoorDining = $('#outDoorDining').val();
        var embed = false;
        var lowerlimit = 1;
        var upperlimit = 20;
        var barter_button = "";
        var job_button = "";
        var home_url = '/';
        var link_path = '/';
        var cat_id = 1;
        var subcat_id = $.cookie("sub_cat_id");
        var ads_view = $(".viewFilters a.active").attr("data-view");
        var search_value = $("#search_box").find("input[name=business-name]").val();
        var baseUrl = '<?= base_url(); ?>';
            dataToUse = {};
        var tab = "";
        if(orderBy == "MAXDISCOUNT") {
            tab = "#maxdiscounts"
        } else {
            tab = "#restaurantOrder";
        }
        var from_where = 'show_ads_specific_category';
        var charval = '';
        
        $.ajax({
            type: "POST",
            url: "<?= base_url()?>ads/temp_ads/",
            data:{'noOfPerson' :noOfPerson,'searchDate' :searchDate,'time' :time,'foodType' :foodType,'snapSettingsType' :snapSettingsType,'isDelivaryRequired' :isDelivaryRequired,'user_id' :user_id,'zone_id' :zone_id,'orderBy' :orderBy,'outDoorDining' :outDoorDining,'embed' :embed,'lowerlimit' :lowerlimit,'upperlimit' :upperlimit,'barter_button' :barter_button,'job_button' :job_button,'home_url' :home_url,'link_path' :link_path,'cat_id' :cat_id,'subcat_id' :subcat_id,'ads_view' :ads_view,'search_value' :search_value,'baseUrl' :baseUrl,'from_where' :from_where,'charval' :charval},
            cache: !1,
            beforeSend: function () {
                // $(".latestoffers").hide(),
                $(".maxdiscounts").hide(),
                $(".container").show(),
                $("ul#myTab").show(),
                $("ul#myTab").append($('<div style="text-align: center;width: 100%;border: none;" id="loader1"><img src="' + baseUrl + '/assets/images/loading.gif"></div>'));
            },
            success: function (t) {
                console.log(t);
            if (
                ($("div#loader1").remove(),
                "show_all_offers" == e || "sponsor_businesses_home_page" == e
                    ? ($("ul#myTab").hide(), $(".outerofferdiv").hide(), $(".maxdiscounts").hide(), $(".latestoffers").show(), $(".latestoffers").html(t), $(".offertab").click())
                    : "show_search_business" == e
                    ? ($("ul#myTab").hide(), $(".maxdiscounts").hide(), $(".outerofferdiv").hide(), $(".latestoffers").show(), $(".latestoffers").html(t), $(".offertab").click())
                    : ("show_favorites_ads" == e || "show_ads_specific_sub_category" == e || "show_ads_specific_category" == e || "show_mover_business" == e || "filter-for-pboo" == e) &&
                      ($("ul#myTab").hide(), $(".outerofferdiv").hide(), $(".maxdiscounts").hide(), $(".latestoffers").show(), $(".latestoffers").html(t), $(".offertab").click()),
                $(".headpgination .pagination a").each(function () {
                    if (void 0 !== $(this).attr("data-ci-pagination-page")) {
                        var e = $(this).attr("href"),
                            t = $(this).attr("rel");
                        e = $.trim(e).split("=", 2)[1];
                        $.trim(e).split("&", 2)[0] == getUrlParameter("per-post-onpage") && "next" != t && $(this).addClass("active");
                    }
                }),
                $(".footer-pagination  .pagination a").each(function () {
                    if (void 0 !== $(this).attr("data-ci-pagination-page")) {
                        var e = $(this).attr("href"),
                            t = $(this).attr("rel");
                        e = $.trim(e).split("=", 2)[1];
                        $.trim(e).split("&", 2)[0] == getUrlParameter("per-post-onpage") && "next" != t && $(this).addClass("active");
                    }
                }),
                initOwlCarousel(jQuery(".owl-carousel")),
                $('[data-toggle="popover"]').popover(),
                $(".snaptogglecog").length > 0)
            ) {
                var a = zoneId,
                    i = $(".snaptogglecog");
                i.webuiPopover("destroy").webuiPopover({
                    width: 300,
                    delay: { show: 300, hide: 300 },
                    closeable: !0,
                    padding: !1,
                    type: "async",
                    cache: !1,
                    title: "Opt-in Status",
                    content: function () {
                        var e = i.data("userid"),
                            t = i.data("busid"),
                            s = i.data("adid"),
                            o = "snap-pop-id-" + $.now();
                        return snappopupupdate(e, a, t, s, o), '<div id="' + o + '">Loading...</div>';
                    },
                });
            }
            $(".snaptogglecog-login").length > 0 && $(".snaptogglecog-login").webuiPopover({ width: 260, padding: !1, delay: { show: 300, hide: 100 }, closeable: !0 }),
                $("select#tab_selector").each(function () {
                    var e = 0;
                    jQuery(this)
                        .find("option")
                        .each(function () {
                            $(this).val(e), e++;
                        });
                }),
                0 != $(".selectedfiltere").val().length &&
                    $(".pagination a ").each(function () {
                        var e = $(this).attr("href"),
                            t = $(".selectedfiltere").val(),
                            a = $(".selectedfiltere").attr("data-filter");
                        $(this).attr("href", e + "&" + a + "=" + t);
                    });
        },
        });
    });
    }, 8000);

});

setTimeout(function myStopFunction() {
    $('#mycoupon').modal({
        show: true
    }); 
}, 5000);
var uplimit= 52;
$(document).ready(function(){
    var lowerlimit = 0;
    var upperlimit = uplimit;
    var charval = "";
    var from_where = "show_ads_specific_category";
    var search_value = "";
    var subcat_id = '';
    var cat_id = 1;
    gettempadsData(lowerlimit,upperlimit,charval,from_where,search_value,subcat_id,cat_id);

    $('.gridlist').click(function(){
        $('.gridlist').removeClass('active');
        $(this).addClass('active');
        var view = $(this).data("view");
        if(view == 'compact'){
            $('.order_list_area').removeClass('fourth_view');
            $('.order_list_area').removeClass('third_view');
            $('.order_list_area').addClass('second_view');
        }else if(view == 'grid'){
            $('.order_list_area').removeClass('fourth_view');
            $('.order_list_area').addClass('third_view');
            $('.order_list_area').removeClass('second_view');
        }else if(view == 'fourgrid'){
            $('.order_list_area').addClass('fourth_view');
            $('.order_list_area').removeClass('third_view');
            $('.order_list_area').removeClass('second_view');      
        }
    });

    $(document).on('click','.play_audio_special_day', function(){
        var audio = $(this).attr('audiofile');
        var pdf = $(this).attr('pdffile');
        var business_id = $(this).attr('business_id');
        var busname = $(this).attr('busname');
        var imageaudio = $(this).attr('imageaudio');
        var day = $(this).attr('day');
        $('.headertitlenew').text(busname);
        var baseurl = window.location.origin;
        var url = baseurl+'/assets/SavingsUpload/Audio/'+business_id+'/'+audio;
        if(pdf != ''){
            var purl = baseurl+'/assets/SavingsUpload/PDF/'+business_id+'/'+pdf;
            var pdfurl = '<img src="/assets/images/pdf.png" class="pdf-img"><a target="_blank" href="'+purl+'">Daily Specials</a>'; 
            $('#middleheadingpdf').html(pdfurl);
        }else{
            $('#middleheadingpdf').html('');
        }
        if(audio == ''){
            $('#middleheading').text('No Special Today');
            $('#modalaudiosrc').addClass('hide');
            $('#imagemodal').attr('src',imageaudio);
            $('.bottomContent').addClass('noneclass');
        }else{
            $('#middleheading').text(day+' Special');
            $('#modalaudiosrc').attr('src',url);
            $('#modalaudiosrc').removeClass('hide');
            $('#imagemodal').attr('src',imageaudio);
            $('.bottomContent').removeClass('noneclass');

        }
        $('#audio_data').attr('src', url);
        $('#audiomodal').modal('show');
        // $('.headertitlenew').attr('audio', imageaudio);

    });
    $(document).on('click','.pageload', function(){
        $('.pageload').removeClass('active white');
        
        var type = $('#searchtype').attr('typeset');
        var searchval = $('#searchtype').val();
        if(type == 'filter-for-pboo'){
            var cat_id = 1;
            var subcat_id = '';
        }else if(type == 'show_favorites_ads' || type == 'show_all_offers'){
            var cat_id = '';
            var subcat_id = ''; 
        }else if(type == 'show_ads_specific_category'){
            var cat_id = 1;
            var subcat_id = ''; 
        }else if(type == 'show_ads_specific_sub_category'){
            var cat_id = '';
            var subcat_id = searchval; 
            searchval = '';
        }else if(type == 'show_data_miles'){
            var cat_id = 1;
            var subcat_id = ''; 
            searchval = searchval;
        }
        var pagecount = $(this).attr('pagecount');
        $('.pageload').each(function(){
            var loop = $(this).attr('pagecount');
            if(pagecount == loop){
                $(this).addClass('active white');   
            }   
        })
        var upperlimit = uplimit;
        var lowerlimit =(pagecount-1)*uplimit; 
        gettempadsData(lowerlimit,upperlimit,searchval,type,searchval,subcat_id,cat_id,'','pageload');
    });

    $(document).on('click','emailnoticepopup',function(){
        var type=2; var status='';
        var ad_id = $(this).attr('adid'); 
        var bus_id = $(this).attr('busid'); 
        var zone_id = $('#userzone').val(); 
        var user_id = $(this).attr('userid'); 
        if(user_id == '' || user_id == 0){
            savingalert('warning','Snap id Turn Off, Login To Turn On');
            return false;
        }
        $('#email_notice_pop_up_modal').modal('show');
        $.fn.showemailnoticepopup(user_id,bus_id,zone_id,type,status,ad_id) ;
     });

    $(document).on("click", ".ad_favorite", (function() {
        var user_id = $(this).attr("UserId");
        if(user_id == '' || user_id == 0){
            savingalert('warning','Login To add business to favorite');
            return false;
        }
        var $this = $(this).find('.fa');
        var zone_id = $('#userzone').val();
        var createdby_id = $(this).attr("busid");
        var type = 0;
        var status = 1;
        var adid = $(this).attr("adid");
   
        $.ajax({
            type: "POST",
            url: '/change_status_type',
            data: {'user_id':user_id,'zone_id':zone_id,'createdby_id':createdby_id,'type':type,'status':status,'adid':adid},
            dataType:'json',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function(e) {
                if(e == 1){
                    $this.removeClass('fa-heart-o');
                    $this.addClass('fa-heart');
                }
            }
        })
}));

    $(document).on('click','.show_ads_specific_category', function(){
        var id = $(this).attr('id');
        gettempadsData(1,uplimit,'','show_ads_specific_category','','',id);
       
    });

    $(document).on('click','.show_ads_specific_sub_category', function(){
        var subid = $(this).attr('id');
        $('#searchtype').val(subid);
        $('#searchtype').attr('typeset', 'show_ads_specific_sub_category');
        gettempadsData(1,uplimit,'','show_ads_specific_sub_category','',subid,'');
    });

    $(document).on('click','.pboo-filter', function(){
        var charval=  $(this).attr('data-filter');
        $('#searchtype').val(charval);
        $('#searchtype').attr('typeset', 'filter-for-pboo');
        gettempadsData(1,uplimit,charval,'filter-for-pboo',charval,'',1);
    });
    $(document).on('click','.show_all_ads', function(){
        var rel = $(this).attr('rel');
        $('#searchtype').val(rel);
        $('#searchtype').attr('typeset', 'show_all_offers');
        gettempadsData(1,uplimit,rel,'show_all_offers',rel,'','');
    });
    $(document).on('click','.businessNameSearch', function(){
        var search = $('.search_cont').val();
        gettempadsData(1,uplimit,search,'show_all_offers',search,'','','true');
    });

    $(document).on('click','.showfavorite', function(){
        $('#searchtype').val('show_favorites_ads');
        $('#searchtype').attr('typeset', 'show_favorites_ads');
        var user_id = $("input[name=user_id]").val();
        if(user_id == ''){
            savingalert('warning','Login to Show Favorite');
            return false;
        }else{
            gettempadsData(1,uplimit,'','show_favorites_ads','','','');
        }
    });

    $(document).on('click','.addtocart', function(){
        var user_id = $("input[name=user_id]").val();
        if(user_id == ''){
            savingalert('danger','Please Login, Add to Cart Items');
            return false;
        }
        dataId = $(this).attr('data-id');
        dataUSerid = $(this).attr('data-userid');
        dataZone = $(this).attr('data-zone');
        itemname = $(this).attr('item-name'); 
        data_busid = $(this).attr('data_busid'); 
        $.ajax({
            type: "POST",
            url: '/addCart',
            data: {'dealid':dataId, 'dataUSerid' :dataUSerid , 'dataZone': dataZone, 'itemname':itemname,'busid':data_busid},
            dataType:'json',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function(response) {
                if(response.type == 'warning'){
                    savingalert(response.type,response.msg);
                    return false; 
                }
                if(response > 0){
                    $('#cartcount').html(response);
                    $('#cartcount').attr('cartcount',response);
                    $('#cartcount').removeClass('hide');
                }
                $('#cart_modal_checkout').modal('show');
                $('#login_loadings').css('display','none');
            }
        });
    });

    $(document).on('click','#closecartmodal,.incart',function(){
        $('#cart_modal_checkout').modal('hide');
    });

    $(document).on('click','.checkout', function(){
        var cartcount = $('#cartcount').attr('cartcount');
        var user_id = $("input[name=user_id]").val();
        var zoneid = $("input[name=zoneid]").val();
        var baseUrl = window.location.origin;
        if(cartcount != '' && cartcount != 0){
             window.open(baseUrl+"/cart/", '_blank');
        }else{
            savingalert('warning','Your Cart is Empty<br>Add something to make me happy :) ');
            return false;   
        }
    });

    $(document).on('click','.perpage',function(){
        $('.perpage').removeClass('active');
        $(this).addClass('active');
        var page = $(this).attr('count');
        var searchval = $('#searchtype').val();
        var type = $('#searchtype').attr('typeset');
        if(type == 'filter-for-pboo'){
            var cat_id = 1;
            var subcat_id = '';
        }else if(type == 'show_favorites_ads' || type == 'show_all_offers'){
            var cat_id = '';
            var subcat_id = ''; 
        }else if(type == 'show_ads_specific_category'){
            var cat_id = 1;
            var subcat_id = ''; 
        }else if(type == 'show_ads_specific_sub_category'){
            var cat_id = '';
            var subcat_id = searchval; 
            searchval = '';
        }
        if(page > 1){
            if(page == 2){
                var limit = uplimit;
            }else{
                var limit = parseInt(page*uplimit);
            }
            gettempadsData(limit,uplimit,searchval,type,searchval,subcat_id,cat_id);
        }else{
            gettempadsData(1,uplimit,searchval,type,searchval,subcat_id,cat_id);
        }
    });
    
    $(document).on('click','.nextlink',function(){
        var total_post = $('#total_post').val();
        var page = $('.pagination_count li:last-child').prev().attr('pagecount');
        if(parseInt(page) <= parseInt(total_post)){
            var nextpage = parseInt(page)+1;
            $('.pagination_count li:last-child').prev().after('<li class="pageload" pagecount="'+nextpage+'">'+nextpage+'</li>');
            $('.pagination_count li:first-child').next().remove();
        }

        $('.pageload').removeClass('active white');
        $('.pagination_count li:last-child').prev().addClass('active white');
        var pagecount = page;
        var upperlimit = uplimit;
        var lowerlimit =(pagecount-1)*uplimit; 
        gettempadsData(lowerlimit,upperlimit,'','show_ads_specific_category','','',1,'','pageload');
    });

    $(document).on('click','.previouslink',function(){
        var total_post = $('#total_post').val();
        var p = $('.pagination_count li:first-child').next().attr('pagecount');
        var html = '';
        var page = parseInt(p)-1;
        if(parseInt(page) > 0){
            $('.pagination_count li').remove();  
            html += '<li><span class="page page-prev previouslink deactive">«</span></li>';
            for (var i = page; i <= parseInt(page)+9; i++) {
                html += '<li class="pageload" pagecount="'+i+'">'+i+'</li>';
            }
            html += '<li><span class="page page-next nextlink">»</span></li>';
            $('.pagination_count').html(html);
        $('.pageload').removeClass('active white');
        $('.pagination_count li:first-child').next().addClass('active white');
        var pagecount = page;
        var upperlimit = uplimit;
        var lowerlimit =(pagecount-1)*uplimit; 
        gettempadsData(lowerlimit,upperlimit,'','show_ads_specific_category','','',1,'','pageload');
        }
    });
    
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
            savingalert('danger','Please select atleast one Week day');
            return false;
        }
        if(snapTimes.length == 0) {
            savingalert('danger','Please select atleast one available Time');
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

    $(document).on('click','.cart_login', function(){
        var cartcount = $('#cartcount').attr('cartcount');
        var user_id = $("input[name=user_id]").val();
        var zoneid = $("input[name=zoneid]").val();
        var baseUrl = window.location.origin;
        if(cartcount != '' && cartcount != 0){
             // window.open(baseUrl+"/businessSearch/cart/"+zoneid+"", '_blank');
              window.open(baseUrl+"/cart/", '_blank');
        }else{
            savingalert('warning','Your Cart is Empty<br>Add something to make me happy :) ');
            return false;   
        }
    });

    $(document).on('click','#free_Certbutton', function(){
        var userid = $(this).attr('userid');
        var zoneid = $(this).attr('zoneid');
        var busid = $(this).attr('busid');
        var deaid = $(this).attr('deaid');
        var alldata = $(this).attr('alldata');
        var token = '<?php time(); ?>';
        var baseurl123 = '<?= base_url();?>/thankyou/<?= $zoneid ?>?UserId=<?= $user_id ?>&Amount=0&creditStatus=<?php echo $creditStatus ?>&AucId=<?php echo $deaid;  ?>&token=<?php  echo time(); ?>&busid=<?php echo $busid;  ?>&zoneid=<?php echo $zoneid;  ?>&usedcert=<?php echo $used_certificate;  ?>&user_type=free'+alldata;
        window.location.href =  baseurl123;
    });

    $(document).on('click','#changetheme', function(){
        var business_theme = $(this).attr('data-theme'); 
        var business_title = $(this).text(); 
        $.ajax({
            'type': "POST",
            'url': '/changetheme',            
            'data':{'business_title':business_title,'business_theme':business_theme},
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            'success':function(result){  
                $('.ig_submit_loading').hide();
                $('.successsnap').show();
                $('.successsnap').html('<h4 style="color:#008040;margin-top:9px;">Successfully done.</span>');
                if(from!='' && from=='ig'){
                    window.location.reload(true)
                }
            }
        });  
    });

    $(document).on('click','#sliderLeft', function(){
        var li_pos = $(this).closest('.sectionDiv').find('ol li');
        $(li_pos).each(function(){
            if($(this).hasClass('activeslide') == true){
                $(this).attr('id','select');
            }
        });
        if($('#select').prev().length > 0){
            $('#select').prev().addClass('activeslide').removeClass('hide');
            $('#select').removeClass('activeslide').addClass('hide').removeAttr('id');
        }
    });

    $(document).on('click','.subleft', function(){
        var img_pos = $(this).closest('.item_img').find('img');
        $(img_pos).each(function(){
            if($(this).hasClass('hide') == false){
                $(this).attr('id','selectsub');
            }
        });
        if($('#selectsub').prev().length > 0){
            var tag = $('#selectsub').prev().prop('tagName');
            if(tag == 'IMG'){
                $('#selectsub').prev().addClass('activeslidesub').removeClass('hide');
                $('#selectsub').removeClass('activeslidesub').addClass('hide').removeAttr('id');
            }else{
                $('#selectsub').removeAttr('id');
            }
        }
    });

    $(document).on('click','.close', function(){
        $('#loadbusinessaddress').modal('hide');
        $('#audiomodal').modal('hide');
    });

    $(document).on('click','#sliderRight', function(){
        var li_pos = $(this).closest('.sectionDiv').find('ol li');
        $(li_pos).each(function(){
            if($(this).hasClass('activeslide') == true){
                $(this).attr('id','select');
            }
        });
        if($('#select').next().length > 0){
            $('#select').next().addClass('activeslide').removeClass('hide');
            $('#select').removeClass('activeslide').addClass('hide').removeAttr('id');
        }
    });

    $(document).on('click','.subright', function(){
        var img_pos = $(this).closest('.item_img').find('img');
        $(img_pos).each(function(){
            if($(this).hasClass('hide') == false){
                $(this).attr('id','selectsub');
            }
        });
        if($('#selectsub').next().length > 0){
            var tag = $('#selectsub').next().prop('tagName');
            if(tag == 'IMG'){
                $('#selectsub').next().addClass('activeslidesub').removeClass('hide');
                $('#selectsub').removeClass('activeslidesub').addClass('hide').removeAttr('id');
            }else{
                $('#selectsub').removeAttr('id');
            }
        }
    });

    $(document).on('click','#historybusinessdetail', function(){
        $('#businesshistorydetaildata').html($(this).closest('span').attr('desc'));
        $('#businesshistory').modal('show');
    });
    // $(document).on('click','#hoursofopertionbusiness', function(){
    //     var data = $(this).closest('span').attr('desc');
    //     if(data != '' && data != 0){
    //         var ss = data.split(",");
    //         var html = '<div><ul>';
    //         $(ss).each(function(k,v){
    //             html += '<li>'+v+'</li>';
    //         });
    //         html += '</ul></div>';
    //         $('#businessoperationdata').html(html);
    //         $('#businessoperation').modal('show');
    //     }else{
    //         savingalert('warning','No Data Found');   
    //     }
        
    // });

    $(document).on('click','#header_login', function(){
        var username = $('#login_email').val();   
        var password = $('#login_password').val();
        var logintype = $('#login_type_name').attr('loginType');  
        check_login(username,password,logintype); 
    });
});

function sendmailcredit(userId,businessId,businessname,zone_id,check){
    $.ajax({
        type: "POST",
        url: "/sendEmail",
        dataType:'json',
        data: {'userId' :userId,'businessId' :businessId,'businessname' :businessname,'zone_id' :zone_id,'check':check},
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },
        success: function (e) {
            savingalert(e.type,e.msg);            
        }
    });   
}

function igformsubmit(user_id,createdby_id,zone_id,type,from,adid,sendingtype = 0,snapWeekDaysId =[0],snapTime =[0],minPercentageId = 0){ 
    var sendtype = (sendingtype !='' && sendingtype != undefined) ? sendingtype : '' ;
    var selected = $('input[name="status"]:radio:checked');
    if (selected.val()=='1'){
        var status = '1';
    }else{
        var status='0';
    }
    var iggroup=$('input:checkbox.group').serializeArray();
    var interestgroup=new Array();
    $.each(iggroup,function(index,val){
        interestgroup.push(val.value);
    })
    
    var data_to_use={'iggroup':interestgroup,'user_id':user_id,'createdby_id':createdby_id,'zone_id':zone_id,'type':type,'status':status,'send_type':sendtype,'snapWeekDaysId':snapWeekDaysId,'snapTime':snapTime,'minPercentageId':minPercentageId,'adid':adid};
    
    $.ajax({
        'type': "POST",
        'url': '/user_ig_insert',            
        'data':data_to_use,
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },
        'success':function(result){  
            $('.ig_submit_loading').hide();
            $('.successsnap').show();
            $('.successsnap').html('<h4 style="color:#008040;margin-top:9px;">Successfully done.</span>');
            if(from!='' && from=='ig'){
                window.location.reload(true)
            }
            change_status_type(user_id,zone_id,createdby_id,type,status,adid,'snap');
        }
    });
}

function change_status_type(user_id,zone_id,createdby_id,type,status,adid,from){ //
    var str = '';
    if(user_id){
        if(status == 1 && from == 'snap'){
            str+='<a class="toggle-on-off-img on emailnoticepopup" style="cursor: pointer;" data-target="#email_notice_pop_up_modal" data-toggle="modal" data-adid="'+adid+'" data-busid="'+createdby_id+'" data-userid="'+user_id+'"><img data-on="images/turn-on.png" data-off="'+link_path+'assets/directory/images/turn-off.png" src="'+link_path+'assets/directory/images/turn-on.png" class="for-img-shadow"/></a>';
            $('.snapdiv'+adid).html(str);
        }else if(status == 0 && from == 'snap'){                        
            str+='<a class="toggle-on-off-img on emailnoticepopup" style="cursor: pointer;" data-target="#email_notice_pop_up_modal" data-toggle="modal" data-adid="'+adid+'" data-busid="'+createdby_id+'" data-userid="'+user_id+'"><img data-on="images/turn-on.png" data-off="'+link_path+'assets/directory/images/turn-on.png" src="'+link_path+'assets/directory/images/turn-off.png" class="for-img-shadow"/></a>';                        
            $('.snapdiv'+adid).html(str);
        }
        $("#headerad"+adid).html(str);
    }
}


$.fn.showemailnoticepopup = function(user_id,createdby_id,zone_id,type,from,adid){
    if(type=='2'){
        var group_for="Business'"; var group_for_1="business";
    }else if(type=='3'){
        var group_for="Organization's"; var group_for_1="organization";
    }else{
        var group_for=""; var group_for_1="";
    }
    var txt = "";
    var data_to_use={'user_id':user_id,'createdby_id':createdby_id,'zone_id':zone_id,'type':type,'adid':adid};
    $.ajax({
        'type': "POST",
        'url':'/check_ig_display',
        'dataType':'json',
        'data':data_to_use,
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },
        'success':function(result){
            if(typeof(result[2]) != "undefined" && result[2] !== null){
                var snapid = result[2].snapDayId;    
                var snapTimeId = result[2].snapDayId;    
                var snapPercentage = result[2].snapDayId;    
            }else{
                var snapid = '';    
                var snapTimeId = '';    
                var snapPercentage = ''; 
            }
            var percentageCriteria = result[1].percentageCriteria;
            var snapStartTime      = result[1].snapStartTime;
            var snapWeekDays       = result[1].snapWeekDays;
            var snapDayIdString       = snapid;
            var snapTimeIdString      = snapTimeId;
            var discountPercentage    = snapPercentage;
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
            });
            
            $.each(result[1].snapWeekDays,function(index,val){
                var checkdata = "checked";
                snapWeekDays+="<input type='checkbox' name='snapweekdays' class = 'snapWeekDaysCheckBox' onChange = 'countSnapWeekDay(this)' value='"+index+"' "+checkdata+">&nbsp;<span>"+val+"</span><br>";
            });
            
            var j = 1;
            var i = 0;
            
            $.each(result[1].snapStartTime,function(index,val){
                var formattedTime = fomartTimeShow(val);
                var checkData = "";
                if($.inArray(index,timeArray) !== -1){
                    checkData = "checked";
                }
                if(j == 1){
                    snapStartTime+= "<div class='col-sm-3 col-xs-6 comom-time'>";
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
                    'url': '/check_ig_display',
                    'dataType':'json',
                    'data':data_to_use,
                    beforeSend : function(){
                        $('#loading').css('display','block');
                    },
                    complete: function() {
                        $('#loading').css('display','none');
                    },
                    'success':function(result){
                        var emailBox = $('#email_notice_pop_up');
                        $(".snap_time").attr('checked', true);
                        if(result!=''){
                            if(result.status!='undefined'){
                                var status=result.status;
                                var send_type = result.send_type;
                                var radio1= '',radio2='',radio3='';
                                if(status=='1' || send_type == 1 || send_type == 2 || send_type == 3){
                                    var on_checked='checked="checked"'; var showdiv = '';
                                    if(send_type == 1){
                                        radio1 = 'checked="checked"';
                                    }else if(send_type == 2){
                                        radio2 = 'checked="checked"';
                                    }else if(send_type == 3){
                                        radio3 = 'checked="checked"';
                                    }
                                    sendtypechange();
                                }else { 
                                    var off_checked='checked="checked"'; var showdiv = 'display:none;';
                                }
                            }
                            if(result.active_group_display!=''){
                                var select_line='</br><h4 style="margin-top:5px; font-size: 15px;">Select as many Interest Groups as you like to receive their special offers.</h4></br>';
                                    text = select_line ;
                            }else{
                                text = '';
                           }
                            var select_line='';
                            var ratingcontent='<h1 style="text-align:center; font-size: 26px; display:none;">Choose how you want this '+group_for+' to alert you</h1><br><span style="font-size: 14px;font-weight:bold; text-align:center;">To change your Opt-in Status for this '+group_for_1+' highlight below</span><div class="ig_submit_loading" style="margin:9px 0px 0px 0px;display:none;">Processing...<img id="loading1" src="<?=$link_path?>assets/images/loading.gif" width="20" height="20" alt="loading" style="padding-left:15px;"/></div><div class="successsnap" style="display:none;"></div><br><br><span style="display: block;font-weight: bold;margin: -24px 0px 10px 21px;"><input type="radio" '+on_checked+' onchange=sendtypechange(); name="status" value="1" />&nbsp Yes I want email notices from this '+group_for_1+', but emailed by SavingsSites, to protect my email address.</span><div id="textoremail" class="checked_group text-center" style="'+showdiv+'" align="right"><input type="radio" name="statusRadio" onchange="sendtypechange();" value="1" '+radio1+'><span style="margin-left: 10px;font-weight: bold;">Email</span>&nbsp;<input type="radio" name="statusRadio" onchange="sendtypechange();" value="2" '+radio2+'><span style="margin-left: 10px;font-weight: bold;">Text Message</span>&nbsp;<input type="radio" name="statusRadio" onchange="sendtypechange();" value="3" '+radio3+'><span style="margin-left: 10px;font-weight: bold;">Both Email and Text Message</span>\
                             <br>\
                            </div>\
                            <div id="snapFilterCriteria" style="display:none;">\
                            <div class="row" style="padding-top:20px;">\
                            <div style="" class="col-sm-12">\
                                    <p class=" text-center">Indicate Minimum discount Percentage you want before Receiving Offers: </p>\
                            </div>\
                            <div style="" class="col-sm-12 col-sm-offset-2">\
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
                    beforeSend : function(){
                        $('#loading').css('display','block');
                    },
                    complete: function() {
                        $('#loading').css('display','none');
                    },
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
                    $('#email_notice_pop_up_modal').modal('show');

                    return false;

                 }

                })
            }
          }
        })
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
    var radioStatus = $('input[name="statusRadio"]:radio:checked').val();
    if( radioStatus  == 1 || radioStatus == 2 || radioStatus == 3 ){
        $("#snapFilterCriteria").slideDown("slow"); 
    };
    var rstatus = $('input[name="status"]:radio:checked').val();
    if(rstatus == 0){
        $('#textoremail').slideUp('slow');
        $("#snapFilterCriteria").slideUp("slow");
    }
    else{
        $('#textoremail').slideDown('slow');
    }
}
function gettempadsData(lowerlimit,upperlimit,charval,from_where,search_value,subcat_id,cat_id,searchbutton="",pageload = ''){
 
    var user_id = $("input[name=user_id]").val();
    var zoneid = $("input[name=zoneid]").val();
    var urlsubcat = $('#urlsubcat').val();
    var l = {
        user_id: user_id,
        zone_id: zoneid,
        lowerlimit: lowerlimit,
        upperlimit: upperlimit,
        barter_button: "",
        job_button: "",
        home_url: "/",
        charval: charval,
        from_where: from_where,
        link_path: "/",
        search_value: search_value,
        subcat_id: subcat_id,
        cat_id: cat_id,
        embed: false,
        snapdinnig:'close',
        source:'',
        searchbutton:searchbutton,
        urlsubcat:urlsubcat
        // noOfPerson: "noOfPerson",
        // searchDate: "searchDate",
        // time: "time",
        // foodType: foodType,
        // orderBy: orderBy,
        // outDoorDining: outDoorDining,
    };
    $.ajax({
        type: "GET",
        url: "/temp_ads",
        data: l,
        dataType:'json',
        beforeSend: function () {
            $('#appendtwocolumndiv').html(''),
            $(".latestoffers").hide(),
                $(".maxdiscounts").hide(),
                $(".container").show(),
                $("ul#myTab").show(),
                $("ul#myTab").html($('<div class="kiss" style="text-align: center;width: 100%;border: none;color: red;font-size: 23px;line-height: 30px;" id="loader1"><span style="font-size: 40px;line-height: 60px;font-weight:700;"><span style="color:#000;">Locating....</span> Deals for You! <br>Deals <span style="color:#000;">from Businesses</span> Help <span style="color:#000;">Your</span> Favorite Nonprofit<img style="width:50px;height:50px;" src="/assets/images/kiss.png"</div>'));
        },
        complete: function() {
            $("ul#myTab").html('');
            $('.pagination').removeClass('hide');
        },
        success: function (t) {
            dataTwoGridView(t);
            if(pageload != 'pageload'){
                paginationcount(t.total_post);
            }
        }
    });
}



function paginationcount(count){
     $('.pagination_count').html('');
    var zone_id = $('#userzone').val();
    var html = '';
    var baseUrl = window.location.origin;
    var row = Math.round(count/uplimit);
    $('#total_post').val(row);
    if(row > 0 && count > uplimit){
        html += '<li><a href="#" data-page="prev" class="page page-prev previouslink deactive">«</a></li>';
        for (var i = 1; i <= row; i++) {
            if(i == 1) $$class= 'active';
            else $$class= '';
            if(i <= 10){
                html += '<li class=" '+$$class+' pageload" pagecount="'+i+'">'+i+'</li>';
            }
        }
        html += '<li><a href="#" data-page="next" class="page page-next nextlink">»</a></li>';
        $('.pagination_count').html(html);
    }
}

function dataTwoGridView(data){

    var html = '';
    var baseUrl = '<?= base_url(); ?>';
    var zone_id = $('#userzone').val();
    var dt = new Date();
    var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
    var baseUrl = window.location.origin;
    var dealimg = '';
    var screenwidth = $(window).width();
    var screenheight = $(window).height();
    if(data.adlist.length > 0){
    $.each(data.adlist, function(k,v) {
            console.log(v.bs_slug);
        if(v.service_number != 0){
            var service_number = v.service_number;
        }else{
            var service_number = 0; 
        }
        if(v.catidnew == 1){ 
            var foodhide = 'nohide';
            var FOS_btn = '';
        }else{ 
            var foodhide = 'hide'; 
            var FOS_btn = 'fos_fix_row';
        }
        if(v.favresfinal > 0){
            var heart = 'fa fa-heart';
        }else{
            var heart = 'fa fa-heart-o';
        }
        subcatimagelength = v.adidsubcatimage;
        var subcatimagehtml = '';
        var subimagelength  = 0;
        if(subcatimagelength.length > 0){
            $.each(subcatimagelength, function(k,v) {
                subimagelength  = 1;
            });   
        }
        var p = v.bs_phone_int;
        var nb = p.toString().split('');
        var phone_int = '('+nb[0]+''+nb[1]+''+nb[2]+') '+nb[3]+''+nb[4]+''+nb[5]+'-'+nb[6]+''+nb[7]+''+nb[8]+''+nb[9]+'';
        var busaddress = " <p><a href='tel:312-419-2700'><i class='fa fa-phone' aria-hidden='true'></i> Phone : "+ phone_int +"</a></p>"+"<i class='fa fa-map-marker' aria-hidden='true'></i> Address : ";
        if(v.bs_streetaddress1){
            busaddress += v.bs_streetaddress1+",";
        }
        if(v.bs_streetaddress2){
            busaddress += v.bs_streetaddress2+",";
        }
        if(v.bs_streetaddress2){
            busaddress += v.bs_state+",";
        }
        if(v.bs_streetaddress2){
            busaddress += v.bs_city+",";
        }
        if(v.bs_streetaddress2){
            busaddress += v.bs_zipcode+",";
        }
        html += `<div class="col-md-6 col-sm-12 third-col">
            <div class="order_boxes">
               <div class="row align-middle">
                  <div class="col-md-10">
                     <h2 class="featured-title">`+v.bs_name+`</h2>
                  </div>
                  <div class="col-md-2">
                     <a target="_blank" href="/businessdetail/`+v.bs_slug+`/" class="cus-btn-home"><i class="fa fa-home" aria-hidden="true"></i></a>
                  </div>
               </div>`;
                if(v.peekaboolist.length > 1){
                    html += `<section class="sectionDiv" style="position:relative;"><button id="sliderLeft"  class="left-btn"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></button><button id="sliderRight" class="right-btn"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i></button><ol>`;
                        $.each(v.peekaboolist, function(k1,v1) {
                            imghtml = '';
                            if(k1 == 0){var $hide='';var $active='activeslide';}else{var $hide='hide';var $active='';}
                            html += `<li class="`+$hide+` `+$active+`">`; 
                            html += `<div class="row align-middle min-height-order">
                                <div class="col-md-6 item_img 1">`;
                                if(v.insert_via_csv == 1 && v1.card_img != ''){
                                    if(screenwidth <= 767){
                                        html += `<img src="`+amazonurl+`/`+v1.card_img+`">`;
                                        imghtml = `https://savingssites.com/assets/SavingsUpload/CSV/`+v.zoneid+`/images/resizeimages/`+v1.card_img;
                                    }else{
                                        html += `<img src="`+amazonurl+`/`+v1.card_img+`">`;
                                        imghtml = ``+amazonurl+`/`+v1.card_img;
                                    }
                                }else{
                                    if(v1.card_img != ''){
                                        if(screenwidth <= 767){
                                            html += `<img src="`+amazonurl+`/`+v1.card_img+`">`;
                                            imghtml = ``+amazonurl+`/`+v1.card_img;
                                        }else{
                                            html += `<img src="`+amazonurl+`/`+v1.card_img+`">`;
                                            imghtml = amazonurl+`/`+v1.card_img;
                                        }
                                    }
                                }
                                dealimg = imghtml;
                                if(subcatimagelength.length > 0 && v1.card_img != ''){
                                    $.each(subcatimagelength, function(k,v) {
                                        subcatimagehtml += '<img class="hide ss1" src="'+amazonurl+'/'+v+'" />';
                                    });   
                                }else if(subcatimagelength.length > 0){
                                    $.each(subcatimagelength, function(k,v) {
                                        subcatimagehtml += '<img src="'+amazonurl+'/'+v+'" />';
                                    });
                                }
                                html += subcatimagehtml;
                                html += `</div>
                            <div class="col-md-6">
                            <table>
                                <tbody>
                                    <tr> 
                                        <td>Cert Value:<span class="pkbpop1 cartmodal" href="#" data-title="Title" data-content="Some Description<br>Some other description">
                                            <img src="`+amazonurl+`/info-icon-27.png"></span> </td>
                                        <td style="text-align: end;">$`+v1.buy_price_decrease_by+` 

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pay Bus:<a class="dealprice newdealprice" href="#" data-title="Title" data-content="Some Description<br>Some other description">
                                            <img src="`+amazonurl+`/info-icon-27.png"></a>  </td>
                                        <td style="text-align: end;">$`+v1.current_price+` 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Deals Left: </td>`;
                                        html+= `<td style="text-align: end;">`;
                                        if(v1.numberofconsolation <= 0 && v1.numberofconsolation != -1){
                                            html += `<span style='color:red;font-weight: 700;font-size: 11px;'>SOLD OUT</span>`;
                                        }else if(v1.numberofconsolation == -1){
                                            html += `Unlimited`;
                                        }else{
                                            html += v1.numberofconsolation;
                                        }
                                        html += `<a class="dealremaining" href="#" data-title="Title" data-content="Some Description<br>Some other description" data-toggle="modal" data-target="#deals_remaining">
                                            <img src="`+amazonurl+`/info-icon-27.png"></a></td>`;    

                            html += `</tr></tbody></table>
                                <button class="list_btn_login btn-free" onclick='getmodalopenemail(`+service_number+`,`+v.bs_id+`,`+v.business_owner_id+`,"`+v.bs_name+`")'>FREE $5</button>
                                <button class="list_btn_login addtocart" data_busid=`+v.bs_id+` data-id=`+v1.deal_id+` item-name="`+v.bs_name+`" data-userid="`+data.user_id+`" data-zone="`+data.zone+`">Add to Cart</button>
                                <button class="list_order_savings `+foodhide+`" data-toggle="modal" data-target="#service_modal_div02">
                                    <span onclick='getmodalopen(`+service_number+`,`+v.bs_id+`,`+v.business_owner_id+`,"`+v.bs_name+`")' class='`+foodhide+` foor_order_savings'><img src="`+baseUrl+`/assets/SavingsUpload/images/foodorder.jpg">
                                    </span>
                                </button>
                            </div>
                            </div>`;
                            html += `</li>`; 
                    });
                    html += `</ol></section>`;
               }else if(v.peekaboolist.length > 0){
                    $.each(v.peekaboolist, function(k1,v1) {
                        imghtml = '';
                        html += `<div class="row align-middle min-height-order">
                            <div class="col-md-6 item_img 2">`;
                            if(subimagelength == 1 && v1.card_img != ''){
                                html += '<i class="fa fa-chevron-circle-left subleft" aria-hidden="true"></i>';   
                            }
                                if(v.insert_via_csv == 1 && v1.card_img != ''){
                                    if(screenwidth <= 767){
                                        html += `<img src="`+amazonurl+`/`+v1.card_img+`">`;
                                        imghtml = `https://savingssites.com/assets/SavingsUpload/CSV/`+v.zoneid+`/images/resizeimages/`+v1.card_img;
                                    }else{
                                        html += `<img src="`+amazonurl+`/`+v1.card_img+`">`;
                                        imghtml = amazonurl+`/`+v1.card_img;
                                    }
                                }else{
                                    if(v1.card_img != ''){
                                        html += `<img src="`+amazonurl+`/`+v1.card_img+`">`;
                                        imghtml = amazonurl+`/`+v1.card_img;
                                       
                                    }
                                }
                                dealimg = imghtml;
                                if(subcatimagelength.length > 0 && v1.card_img != ''){
                                    $.each(subcatimagelength, function(k,v) {
                                        subcatimagehtml += '<img class="hide ss2" src="'+amazonurl+'/'+v+'" />';
                                    });   
                                }else if(subcatimagelength.length > 0){
                                    $.each(subcatimagelength, function(k,v) {
                                        subcatimagehtml += '<img src="'+amazonurl+'/'+v+'" />';
                                    });
                                }





                                html += subcatimagehtml;
                                if(subimagelength == 1 && v1.card_img != ''){
                                    html += '<i class="fa fa-chevron-circle-right subright" aria-hidden="true"></i>';   
                                }
                            html += `</div>
                            <div class="col-md-6">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>Cert Value:<span class="pkbpop1 cartmodal" href="#" data-title="Title" data-content="Some Description<br>Some other description">
                                            <img src="`+amazonurl+`/info-icon-27.png"></span> </td>
                                        <td style="text-align: end;">$`+v1.buy_price_decrease_by+` 

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pay Bus:<a class="dealprice newdealprice" href="#" data-title="Title" data-content="Some Description<br>Some other description">
                                            <img src="`+amazonurl+`/info-icon-27.png"></a>  </td>
                                        <td style="text-align: end;">$`+v1.current_price+` 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Deals Left:<a class="dealremaining" href="#" data-title="Title" data-content="Some Description<br>Some other description" data-toggle="modal" data-target="#deals_remaining">
                                            <img src="`+amazonurl+`/info-icon-27.png"></a> </td>`;
                                        html+= `<td style="text-align: end;">`;
                                        if(v1.numberofconsolation <= 0 && v1.numberofconsolation != -1){
                                            html += `<span style='color:red;font-weight: 700;font-size: 11px;'>SOLD OUT</span>`;
                                        }else if(v1.numberofconsolation == -1){
                                            html += `Unlimited`;
                                        }else{
                                            html += v1.numberofconsolation;
                                        }
                                        html += `</td>`;    

                            html += `</tr></tbody></table>
                            <button class="list_btn_login btn-free" onclick='getmodalopenemail(`+service_number+`,`+v.bs_id+`,`+v.business_owner_id+`,"`+v.bs_name+`")'>FREE $5</button>
                                <button class="list_btn_login addtocart" data_busid=`+v.bs_id+` data-id=`+v1.deal_id+` item-name="`+v.bs_name+`" data-userid="`+data.user_id+`" data-zone="`+data.zone+`">Add to Cart</button>
                                <button class="list_order_savings `+foodhide+`" data-toggle="modal" data-target="#service_modal_div02">
                                    <span onclick='getmodalopen(`+service_number+`,`+v.bs_id+`,`+v.business_owner_id+`,"`+v.bs_name+`")' class='`+foodhide+` foor_order_savings'><img src="`+baseUrl+`/assets/SavingsUpload/images/foodorder.jpg">
                                    </span>
                                </button>
                          
                            </div>
                            </div>`;
                    });
               }else{
                    html += `<div class="row align-middle min-height-order dmyimg-data">
                            <div class="col-md-6 item_img 3">`;
                            if(subimagelength == 1){
                                html += '<i class="fa fa-chevron-circle-left subleft" aria-hidden="true"></i>';   
                            }
                            if(v.adtext == ''){
                                html +=`<img src="`+amazonurl+`/OurDealsComingSoon-1.png">`;
                                imghtml = amazonurl+`/OurDealsComingSoon-1.png`;
                            }else{
                                if(v.insert_via_csv == 1){
                                    html += `<img src="`+amazonurl+`/`+v.adtext+`">`;
                                    imghtml = amazonurl+`/`+v.adtext;
                                }else{
                                    html +=`<img src="`+amazonurl+`/`+v.adtext+`">`;
                                    imghtml = amazonurl+`/`+v.adtext;
                                }
                            }
                            dealimg = imghtml; 
                            html += subcatimagehtml;
                            if(subimagelength == 1){
                                html += '<i class="fa fa-chevron-circle-right subright" aria-hidden="true"></i>';   
                            }
                            html += `</div>
                            <div class="col-md-6 dumyimage">
                            
                                <img class="dumyimage1" src="`+amazonurl+`/support_orgs.jpg"> 
                                <button class="list_btn_orgs btn-free" onclick='getmodalopenemail(`+service_number+`,`+v.bs_id+`,`+v.business_owner_id+`,"`+v.bs_name+`")'>FREE $5</button>
                                <button class="list_order_savings `+foodhide+`" data-toggle="modal" data-target="#service_modal_div02">
                                    <span onclick='getmodalopen(`+service_number+`,`+v.bs_id+`,`+v.business_owner_id+`,"`+v.bs_name+`")' class='`+foodhide+` foor_order_savings'><img src='https://www.foodordersavings.com/img/logo_head.png'>
                                    </span>
                                </button>

                            </div>
                            </div>`;
               }
         
        
        html += `<div class="row align-middle share_heart_icon `+FOS_btn+`">
                  <div class="col-md-3">
                    <ul>
                        <li class="buss_snap">
                         <img src="`+amazonurl+`/info-icon-27.png"" class="info_icon" data-title="Title" data-content="Some Description<br>Some other description" data-toggle="modal" data-target="#pbkPop0002">
                            <span class="snap_icon emailnoticepopup" adid="`+v.adid+`" busid="`+v.bs_id+`" UserId ="`+data.user_id+`">
                               
                                <img src="`+amazonurl+`/snap-off.png">
                            </span>
                        </li>
                        <li class="buss_heart_snap">
                        <img src="`+amazonurl+`/info-icon-27.png"" class="info_icon favouriteicon" href="#" data-title="Title" data-content="Some Description<br>Some other description" data-toggle="modal" data-target="#favourite">
                            <span class="snap_icon_heart ad_favorite" data-title="Title" data-content="Some Description<br>Some other description" rel="1" adid="`+v.adid+`" busid="`+v.bs_id+`" UserId ="`+data.user_id+`">
                                
                                <i class="`+heart+`"></i>
                            </span>
                        </li>

                        <li class="location-pin" id="pinlocation" busname="`+v.bs_name+`" address="`+busaddress+`">
                            <span class="pin-icon">
                                <img src="https://cdn.savingssites.com/pin.png">
                              
                            </span>
                        </li>`;
                        if(v.food_audio || v.food_pdf){
                            var themecolor = 'themecolor';
                        }else{
                            var themecolor = '';
                        }
                        html +=`<i day="`+v.food_day+`" busname="`+v.bs_name+`" imageaudio="`+dealimg+`" audiofile="`+v.food_audio+`" pdffile="`+v.food_pdf+`" business_id="`+v.bs_id+`" class="`+themecolor+` fa fa-play-circle-o play_audio_special_day" aria-hidden="true"></i>`;
                        
                        html += `<li class="hide_on_desktop">
                         <a href="#" class="sahre_box"><img src="`+baseUrl+`/assets/directory/images/share.png"></a>
                            <div class="addthis_inline_share_toolbox_pwty" data-url="`+baseUrl+`/short_url/`+v.deal_id+`/`+zone_id+`/`+v.bs_id+`/`+v.adid+`/`+v.user_idnew+`" data-title="`+v.bs_name+`" data-media="`+dealimg+`"></div>
                        </li>
                    </ul>
                  </div>
                  <div class="col-md-6"></div>
                  <div class="col-md-3 hide_on_mobile">
                     <a href="#" class="sahre_box"><img src="`+baseUrl+`/assets/directory/images/share.png"></a>
                      <div class="addthis_inline_share_toolbox_pwty" data-url="`+baseUrl+`/short_url/`+v.deal_id+`/`+zone_id+`/`+v.bs_id+`/`+v.adid+`/`+v.user_idnew+`" data-title="`+v.bs_name+`" data-media="`+dealimg+`"></div>
                  </div>
               </div>
            </div>
         </div>`;
    });
    }else{
        html += '<span class="error_nodata">No Place found. Please try again.</span>'; 
    }
$('#appendtwocolumndiv').html(html);
}

$(".show-list").click(function(){
    var catid = $(this).attr('catid');
    var titlecat = $(this).attr('titlecat');
    if($(this).hasClass('open')){
        $('.showcategory_'+catid).slideUp(100);
        $(".bv_header_breadcrumb h1").text("RESTAURANTS");
        $(this).removeClass('open');
        $(".cus-ul").css({
        display: 'unset',
        float: 'none',
        marginBottom: '0%'
    });
    }else{
        $('.list-show').each(function(){
            $(this).css('display','none');
            $(".bv_header_breadcrumb h1").text(titlecat);
            $(this).removeClass('open');   
        });
        $('.show-list').removeClass('open');
        $('.showcategory_'+catid).slideDown(100);
        $('.showcategory_'+catid).removeClass("hide");
        $(this).addClass('open');
        $(".cus-ul").css({
        display: 'block',
        float: 'left',
        marginBottom: '2%'
    });
    }
});



$(".list-show").click(function(){
      $('html,body').animate({
        scrollTop: $("#appendtwocolumndiv").offset().top},
        'slow');
});



function sign_out(){ 
    var zone_id = $('#userzone').val();
    var type = 'business';
    savingalert('success','Your Session has expired please login, Redirecting to the zone directory page');
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
    function addnotes($this){
        var userid = $this.closest('tr').attr('userid');
        var businessid = $this.closest('tr').attr('businessId');
        var title = $this.closest('tr').find('.title').val();
        var desc = $this.closest('tr').find('.desc').val();
        var busname = $this.closest('tr').find('.busname').html();
        var fav_res = '';
        var via = "businesspage";
        if(title == '' || title == undefined || title == null){
            alert("please insert Favorite Title");
            return false;
        }
        $.ajax({
            type: "POST",
            url: "/save_notes",
            dataType: "json",
            data:{'restaurant':businessid,'title':title,'desc':desc,'userid':userid,'fav_res':fav_res,'via':via},
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function(r){
                var html = '<tr userid="'+userid+'" businessId="'+businessid+'"><td class="busname">'+busname+'</td><td class="fav_id"></td><td class="tdtitle"><input type="text" class="title"/></td><td class="tddesc"><input type="text" class="desc"/></td><td class="favaddon"><i style="font-size:22px;" class="fa fa-plus" onclick="addnotes($(this))"></i></td></tr>';
                if(r.type == 'success'){
                    $this.closest('tr').find('.fav_id').html('Fav#'+r.data);
                    $this.closest('tr').find('.tdtitle').html(title);
                    $this.closest('tr').find('.tddesc').html(desc);
                    // $this.closest('tr').find('.favaddon').html('123');
                    $this.closest('tr').after(html);
                }else{
                    alert("Item Already Exists.");
                }      
            }
        });
    }

function getmodalopen(serviceno, businessId,userId,businessname){
        var userId = $('input[name="user_id"]').val();
        var zone_id = $('input[name="zoneid"]').val(); 
        var check = check_mail_send(userId,businessId);
        if(serviceno != 0){
            $('#servicenohead').html('<a href="tel:+'+serviceno+'" class="Blondie">Call Restaurant Now</a>');
        }else{
            $('#servicenohead').html('FO$ is faster, easier, more accurate,<br> and saves both you and the restaurant money!<br><br> Click for an additional $3.00 off your<br>first cash certificate for this business!<br>');
            $('#servicenohead').css('color','#000');
            if(userId != ''){
                if(check == 0 || check == '' || check == null){
                    $('#servicenohead').append("<br><button zone_id="+zone_id+"  userid="+userId+" businessId="+businessId+" businessname="+businessname+" style='background:#267dff;' type='button' class='sendmail btn btn-info'>Click for $3.00 cents</button>");
                }
            }else{
                $('#servicenohead').append("<br><button zone_id="+zone_id+"  userid="+userId+" businessId="+businessId+" businessname="+businessname+" style='background:#267dff;' type='button' class='btn btn-info'>Login to get $3.00 </button>");
            }
        }
        
        var html = '';



        if (userId) { 

            var base_url = window.location.origin;;
            $.ajax({
                type: "POST",
                url: "/getfavres",
                dataType:'json',
                data: {'userId' :userId,'businessId' :businessId},
                beforeSend : function(){
                    $('#loading').css('display','block');
                },
                complete: function() {
                    $('#loading').css('display','none');
                },
                success: function (e) {
                    if(e.length > 0){
                        $.each(e, function (k, v) {
                            html += '<tr>';
                            html += '<td>'+businessname+'</td>';
                            html += '<td>Fav#'+v.id+'</td>';
                            html += '<td>'+v.fav_title+'</td>';
                            html += '<td>'+v.fav_note+'</td>';
                            html += '</tr>';
                        });
                        html += '<tr userid="'+userId+'" businessId="'+businessId+'"><td class="busname">'+businessname+'</td><td class="fav_id"></td><td class="tdtitle"><input type="text" class="title"/></td><td class="tddesc"><input type="text" class="desc"/></td><td class="favaddon"><i style="font-size:22px;" class="fa fa-plus" onclick="addnotes($(this))"></i></td></tr>';
                        $('#showfavnotes').html(html);
                    }else{
                        $('#showfavnotes').html('<tr userid="'+userId+'" businessId="'+businessId+'"><td class="busname">'+businessname+'</td><td class="fav_id"></td><td class="tdtitle"><input type="text" class="title"/></td><td class="tddesc"><input type="text" class="desc"/></td><td class="favaddon"><i style="font-size:22px;" class="fa fa-plus" onclick="addnotes($(this))"></i></td></tr>');  
                    }
                }
            });
            $('#favfooterdiv').html('<button type="button" class="btn btn-info"><a target="_blank" href='+base_url+'online_delivery/favourites/'+zone_id+'/'+businessId+'>Edit Favorites</a></button>');

         }else{ 

            $('#showfavnotes').html('<tr><td colspan="5" style="text-align:center;">Login to see your favorites</td></tr>');


         } 

            




        $('#service_modal_div').modal('show');
    }

    function getmodalopenemail(serviceno, businessId,userId,businessname){
        var userId = $('input[name="user_id"]').val();
        var zone_id = $('input[name="zoneid"]').val(); 
        if(userId == ''){
            savingalert('warning','Login to get $5.00');
            return false;    
        }
        var check = check_mail_send(userId,businessId);
        if(userId != ''){
            sendmailcredit(userId,businessId,businessname,zone_id,check);
        }
    }

    function check_mail_send(userId,businessId){
        var res = 0;
        $.ajax({
            type: "POST",
            url: "/checkEmail",
            dataType:'json',
            async:false,
            data: {'userId' :userId,'businessId' :businessId},
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function (e) {
                    res = e.data;       
            }
        }); 
        return res;
    }
function savingalert(type = '',msg = ''){
    var msg = '<div class="alert alert-'+type+' alert-dismissible fade show" role="alert"><strong>'+msg+'</strong></button></div>';
    $('#alert_msg').html(msg).css('display','block');
    setTimeout(hidealert, 3000);
}
function hidealert(){
    $('#alert_msg').css('display','none');  
}

$(document).ready(function(){
    setTimeout(function(){
        $(".showonlick").click(function(){
        $('.checkbox-custom').click();
    });
    }, 
    2000);
    
    $(document).on('click','#pinlocation',function(){
        var add = $(this).attr('address');
        var busname = $(this).attr('busname');
        $('#myModalLabelbus').text(busname).css('color','white');
        $('#baddress').html(add);
        $('#loadbusinessaddress').modal('show');
    });
});

     
  
$(document).ready(function() {
    getsubcatfun(1);
    if ($('.show-list').length > 8) { 
        $(".hide_on_mobile ul").addClass("list-iteam-intro");
    }
    $(document).on('change','.miles_count',function(){
        var miles = $(this).val();
        $('#searchtype').val(miles);
        $('#searchtype').attr('typeset', 'show_data_miles');
        if(miles){
            var lowerlimit = 0;
            var upperlimit = uplimit;
            var charval = "";
            var from_where = "show_data_miles";
            var search_value = miles;
            var subcat_id = '';
            var cat_id = 1;
            gettempadsData(lowerlimit,upperlimit,charval,from_where,search_value,subcat_id,cat_id);
        }
    });
    

    $(document).on('click','.modal_form_open', function(){
        $('.dropdown-menu-right').removeClass('show');
        var link = $(this).attr('link');
        var seo_zone = $('#seo_zone').val();
        var zone_id = $('#zone_id').val();
        if(zone_id == '' || zone_id == 'undefined' || zone_id == undefined){
            var zone_id = $('#userzone').val();
        }
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

    $(document).on('change','.dropdown_select_cat', function(){
        var cattid = $(this).val();
        getsubcatfun(cattid);
    });
    $(document).on('click','.sub_mob_populate', function(){
        var subid = $(this).find(":selected").attr('id');
        $('#searchtype').val(subid);
        $('#searchtype').attr('typeset', 'show_ads_specific_sub_category');
        gettempadsData(1,uplimit,'','show_ads_specific_sub_category','',subid,'');
    });

});  


$(document).on('click','.cartmodal',function(){
        $('#pbkPop1').modal('show');
    });

$(document).on('click','.newdealprice',function(){
        $('#pay_bus_deal').modal('show');
    });
$(document).on('click','.dealremaining',function(){
        $('#deals_remaining').modal('show');
    });

$(document).on('click','.info_icon',function(){
        $('#pbkPop0002').modal('show');
    });
$(document).on('click','.favouriteicon',function(){
        $('#favourite').modal('show');
    });
$(document).on('click','.close',function(){
       $('#pbkPop1').modal('hide');
       $('#pay_bus_deal').modal('hide');
       $('#deals_remaining').modal('hide');
       $('#pbkPop0002').modal('hide');
       $('#favourite').modal('hide');
    });

function getsubcatfun(cattid){
    var zone_id = $('#userzone').val();
    var html = '';
    $.ajax({
        type: "GET",
        url: "/GETSUBCATEGORY",
        dataType:'json',
        data: {'cattid' :cattid,'zone_id' :zone_id},
        beforeSend : function(){
            $('#loading').css('display','block');
        },
        complete: function() {
            $('#loading').css('display','none');
        },
        success: function (e) {
            html += '<option class="show_ads_specific_category">Types of Businesses  </option>';
            $.each(e,function(k,v){
                html+= "<option class='show_ads_specific_sub_category' rel='"+v.id+"' id='"+v.id+"'>"+v.id0+" "+v.id2+"</option>";
            });
            $('.sub_mob_populate').html(html);         
        }
    });  
}
// $(document).ready(function(){
//     $('#eventactivity').on('click',function(e){
//         e.preventDefault();
//         console.log('dhewfewf');
//     });
// });


// var scrolled = 0;
// function down()
// {
// scrolled = scrolled + 300;
// $( ".show_ads_specific_sub_category" ).animate({
// scrollTop :  scrolled
// });
// alert( " Scrolled down " +scrolled+ " Px." );
// }



