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
    var screensize = document.documentElement.clientWidth;
    
    if (screensize  <= 767) {
        $('.hide_on_mobile').remove();
    }else {
        $('.hide_on_desktop').remove();
    }

    var lowerlimit = 0;
    var upperlimit = uplimit;
    var charval = "";
    var from_where = "show_ads_specific_category";
    var search_value = "";
    var subcat_id = '';
    var cat_id = 1;

    //this
    setattronalldata(cat_id,subcat_id);
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
            if(audio == '' && pdf == ''){
                $('#middleheading').text('No Special Today');
            }else{
                $('#middleheading').text('There is a Special Today');
            }
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
        var placecatid = $(this).attr('placecatid');
        var placesubcatid = $(this).attr('placesubcatid');
        var type = $('#searchtype').attr('typeset');
        var searchval = $('#searchtype').val();

        if(type == 'filter-for-pboo'){
            var cat_id = placecatid;
            var subcat_id = '';
        }else if(type == 'show_favorites_ads' || type == 'show_all_offers'){
            var cat_id = '';
            var subcat_id = ''; 
        }else if(type == 'show_ads_specific_category'){
            var cat_id = placecatid;
            var subcat_id = ''; 
        }else if(type == 'show_ads_specific_sub_category'){
            var cat_id = '';
            var subcat_id = searchval; 
            searchval = '';
        }else if(type == 'show_data_miles'){
            var cat_id = placecatid;
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

        var sortbyvalue = '';
        $('.pboo-filter').each(function(){
            if($(this).hasClass('header-list-items') == true){
                sortbyvalue = $(this).attr('data-filter');
                return false;   
            }
        });
        
        var albhabetvalue = '';
        $('.show_all_ads').each(function(){
            if($(this).hasClass('sortenoption') == true){
                albhabetvalue = $(this).attr('rel');
                return false;   
            }
        })

        gettempadsData(lowerlimit,upperlimit,searchval,type,searchval,subcat_id,cat_id,'','pageload',sortbyvalue,albhabetvalue);
    });

    $(document).on('click','.emailnoticepopup',function(){
        var type=2; var status='';
        var ad_id = $(this).attr('adid'); 
        var bus_id = $(this).attr('busid'); 
        var zone_id = $('#userzone').val(); 
        var user_id = $(this).attr('userid'); 
        $('#togglesnapuser').attr('businesid',bus_id);
        if(user_id == '' || user_id == 0){
            savingalert('warning','Snap id Turn Off, Login To Turn On');
            return false;
        }
        $('#email_notice_pop_up_modal').modal('show');
        $.fn.showemailnoticepopup(user_id,bus_id,zone_id,type,status,ad_id);
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
        var catid = $(this).attr('id');
        setattronalldata(catid,'');
        gettempadsData(1,uplimit,'','show_ads_specific_category','','',catid);
        $('.showcategory_'+catid).slideUp(100);
        $('.showmaincat'+catid).addClass('hide');
        $(".bv_header_breadcrumb h1").text("RESTAURANTS");
        $('.show-list').removeClass('open');
        $(".cus-ul").css({
            display: 'unset',
            float: 'none',
            marginBottom: '0%'
        });
        $('.catid'+catid).addClass('open1');
    });

    $(document).on('click','.show_ads_specific_sub_category', function(){
        var subid = $(this).attr('id');
        var placecatid = $(this).attr('placecatid');
        if(placecatid == 1){
            $('.imgIcon').removeClass('hide');
        }else{
            $('.imgIcon').addClass('hide');
        }
        $('#searchtype').val(subid);
        $('#searchtype').attr('typeset', 'show_ads_specific_sub_category');
        setattronalldata(placecatid,subid);
        gettempadsData(1,uplimit,'','show_ads_specific_sub_category',placecatid,subid,placecatid);
        $('.showcategory_'+placecatid).slideUp(100);
        $('.showmaincat'+placecatid).addClass('hide');
        $(".bv_header_breadcrumb h1").text("RESTAURANTS");
        $('.show-list').removeClass('open');
        $(".cus-ul").css({
            display: 'unset',
            float: 'none',
            marginBottom: '0%'
        });
        $('.catid'+placecatid).addClass('open1');
    });

    $(document).on('click','.pboo-filter', function(){
        $('.pboo-filter').removeClass('header-list-items');
        $('.pboo-filter').addClass('themecolor');
        var charval=  $(this).attr('data-filter');
        $('#searchtype').val(charval);
        $('#searchtype').attr('typeset', 'filter-for-pboo');
        var placecatid = $(this).attr('placecatid');
        var placesubcatid = $(this).attr('placesubcatid');

        var albhabetvalue = '';
        $('.show_all_ads').each(function(){
            if($(this).hasClass('sortenoption') == true){
                albhabetvalue = $(this).attr('rel');
                return false;   
            }
        })
        setattronalldata(placecatid,placesubcatid);
        gettempadsData(1,uplimit,charval,'filter-for-pboo',charval,placesubcatid,placecatid,'','','',albhabetvalue);
        $(this).addClass('header-list-items');
        $(this).removeClass('themecolor').css('color','#fff');
        $('#sortenoption').addClass('sortenoption');
    });
    $(document).on('click','.show_all_ads', function(){
        $('.show_all_ads').removeClass('sortenoption');
        $(this).addClass('sortenoption');
        $('.atozfilteroption').addClass('sortenoption');
        var rel = $(this).attr('rel');
        $('#searchtype').val(rel);
        $('#searchtype').attr('typeset', 'show_all_offers');


        var sortbyvalue = '';
        $('.pboo-filter').each(function(){
            if($(this).hasClass('header-list-items') == true){
                sortbyvalue = $(this).attr('data-filter');
                return false;   
            }
        });
        var placecatid = $(this).attr('placecatid');
        var placesubcatid = $(this).attr('placesubcatid');
        setattronalldata(placecatid,placesubcatid);
        gettempadsData(1,uplimit,rel,'show_all_offers',rel,placesubcatid,placecatid,'','',sortbyvalue);
    });
    $(document).on('click','.businessNameSearch', function(){
        var search = $('.search_cont').val();
        if(search != ''){
            gettempadsData(1,uplimit,search,'show_all_offers',search,'','','true');
        }
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
    
    $(document).on('click','.snaplistsubspan', function(){
        $(this).closest('.snaplistsubmaindiv').remove();
    });

    $('#imgIcon').on('click', function() {
        var placecatid = $('.miles_count').attr('placecatid');
        var subcategory = $('.miles_count').attr('placesubcatid');
        var user_id = $(this).attr('userid');
        if (user_id == '' || user_id == undefined || user_id == 'undefined') {
            savingalert('warning','Snap id Turn Off, Login To Turn On');
            return false;
        }else{
            var attr = $(this).attr('snapstatus');
            if(attr == 'on'){
                $('#imgIcon img').attr('src', 'https://cdn.savingssites.com/snap-off.png');
                $('#imgIcon').attr('snapstatus', 'off');
                $('.emailnoticepopup img').attr('src', 'https://cdn.savingssites.com/snap-off.png'); 
                setbusinesssnapstatus(placecatid,0,subcategory);
            }else{
                $('#imgIcon img').attr('src', 'https://cdn.savingssites.com/icon-2.png');
                $('#imgIcon').attr('snapstatus', 'on');
                $('.emailnoticepopup img').attr('src', 'https://cdn.savingssites.com/icon-2.png'); 
                setbusinesssnapstatus(placecatid,1,subcategory);
            }
        }
    });

    $(document).on('click','#saveCriteria', function(){
        var snap_filter_arr = [];
        var businessid = $(this).attr('data-createdby-id');
        var businessuser = $(this).attr('data-user-id');
        var zone_id = $(this).attr('data-zone-id');
        var dataAdId         = $(this).attr('data-adid');
        var radioStatus = $('input[name="statusRadio"]:radio:checked').val();
        var dataAdId         = $(this).attr('data-adid');
        $('.snaplistsubdiv').each(function(){
            var dayobject= {};
            var day             = $(this).attr('dayid');
            var starttime       = $(this).attr('starttime');
            var endtime         = $(this).attr('endtime');
            var discountsnap      = $(this).attr('discountsnap');
            var snapsendtype    = $(this).attr('snapsendtype');
            
            dayobject = {'day':day,'starttime':starttime,'endtime':endtime,'discountsnap':discountsnap,'snapsendtype':snapsendtype};
            snap_filter_arr.push(dayobject);
        });

        $.ajax({
            type:"POST",
            data:{businessid,businessuser,zone_id,snap_filter_arr,radioStatus},                 
            url: '/save_user_business_snap_filter',      
            cache: false,
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success: function(data){ 
                savingalert(data.type,data.msg);      
                $('#saveCriteria').addClass('hide');
                $('#email_notice_pop_up_modal').modal('hide');
            }
        });
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
    jQuery(".themeswitcher .dropdown-menu a").on('click', function(e) {
        e.preventDefault();
        var parent = $('#themeswitcher');
        parent.attr('data-theme', $(this).data('theme'));
        parent.text($(this).text());
        changeTheme($(this).data('theme'), $(this).text(), parent.data('version'));         
        return false;
    })

    $(document).on('click','.sliderLeft', function(){
        var busid = $(this).attr('busid');
        var deallength = $(this).attr('deallength');
        var li_pos = $(this).closest('.sectionDiv').find('ol li');
        var dot_pos = $(this).closest('.sectionDiv').find('.circleDot');
        $(li_pos).each(function(){
            if($(this).hasClass('activeslide') == true){
                $(this).attr('id','select');
            }
        });

        var busidcount = 0;
        $(dot_pos).each(function(){
            if($(this).hasClass('circleactive') == true){
                busidcount = $(this).attr('buscount');
                if((parseInt(busidcount)-1) > 0){
                    $(this).removeClass('circleactive');
                    $(this).addClass('text-primarylight');
                }
            }
        });
        if(busidcount > 0){
            var combus = parseInt(busidcount)-1;
            var busidnew = busid+'_'+combus;
            $(dot_pos).each(function(){
            if($(this).attr('busid') == busidnew){
                $(this).removeClass('text-primarylight');
                $(this).addClass('text-primary');
                $(this).addClass('circleactive');
            } 
        });
        }

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

    $(document).on('click','.sliderRight', function(){
        var busid = $(this).attr('busid');
        var deallength = $(this).attr('deallength');
        var li_pos = $(this).closest('.sectionDiv').find('ol li');
        var dot_pos = $(this).closest('.sectionDiv').find('.circleDot');
        $(li_pos).each(function(){
            if($(this).hasClass('activeslide') == true){
                $(this).attr('id','select');
            }
        });
        var busidcount = 0;
        $(dot_pos).each(function(){
            if($(this).hasClass('circleactive') == true){
                busidcount = $(this).attr('buscount');
                if((parseInt(busidcount)+1) <= deallength){
                    $(this).removeClass('circleactive');
                    $(this).addClass('text-primarylight');
                }
            }
        });

        var combus = parseInt(busidcount)+1;
        var busidnew = busid+'_'+combus;
        if(combus <= deallength){
            $(dot_pos).each(function(){
                if($(this).attr('busid') == busidnew){
                    $(this).removeClass('text-primarylight');
                    $(this).addClass('text-primary');
                    $(this).addClass('circleactive');
                }    
            });
        }
        
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
    $(document).on('click','#topheaderangle', function(){
        if($(this).hasClass('fa-angle-down') == true){
            $(this).removeClass('fa-angle-down'); 
            $(this).addClass('fa-angle-right')   
            $('.sectionzonediv').slideUp('slow');
        }else{
            $(this).removeClass('fa-angle-right')   
            $(this).addClass('fa-angle-down');   
            $('.sectionzonediv').slideDown('slow');    
        }
    });

    $(document).on('click','.topheaderangle', function(){
        if($(this).hasClass('fa-angle-down') == true){
            $(this).removeClass('fa-angle-down'); 
            $(this).addClass('fa-angle-right')   
            $('.sectionzonediv').slideUp('slow');
        }else{
            $(this).removeClass('fa-angle-right')   
            $(this).addClass('fa-angle-down');   
            $('.sectionzonediv').slideDown('slow');    
        }
        $('.checkbox-custom').click();
    });
});

$(document).on('click','.locationmodal', function(){
    $('#locationdealmodal').modal({backdrop: 'static', keyboard: false}, 'show');
    $('#locationdealmodal').modal('show');
});

$(document).on('click','.dealgooglelocationmodal', function(){
    $('#locationdealmodal').modal({backdrop: 'static', keyboard: false});
    $('#locationdealmodal').modal('hide');
});

$(document).on('keyup','#dealclickwordplace', function(){
    var html = '';
    var search = $(this).val();
    if(search){
        $.ajax({
            'type': "POST",
            'url': '/getlocationdeal',            
            'data':{search},
            'dataType':'json',
            beforeSend : function(){
                $('#loading').css('display','block');
            },
            complete: function() {
                $('#loading').css('display','none');
            },
            success:function(result){ 
                if(result.length > 0){
                    $(result).each(function(k,v){
                        html += '<div lat="'+v.lat+'" lng="'+v.lng+'" class="dealgooglelist">'+v.formatted_address+'</div>'; 
                    });
                } 
                $('#listalllocationdealdata').html(html);
            }
        });        
    }
});

$(document).on('click','.dealgooglelist', function(){
    var address = $(this).text();
    var lat     = $(this).attr('lat');
    var lng     = $(this).attr('lng');
    $('.addressstoretodealpage').html(address);
    $('#googlelatdealpage').val(lat);
    $('#googlelngdealpage').val(lng);
    $('#locationdealmodal').modal({backdrop: 'static', keyboard: false});
    $('#locationdealmodal').modal('hide');
    html = '<div lat="'+lat+'" lng="'+lng+'" class="dealgooglelist">'+address+'</div>'; 
    $('#listalllocationdealdata').html(html);
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

function setbusinesssnapstatus(placecatid,status,subcategory){
    var userzone = $('#userzone').val();
    var user_id = $('#user_id').val();
    $.ajax({
        type : 'POST',
        url : "/set_business_snap_status",
        data: {placecatid,status,subcategory,userzone,user_id},
        success : function(e){
            savingalert(e.type,e.msg);
        }
    });   
}

function setbusinessusersnapstatus(businessid,status){
    var userzone = $('#userzone').val();
    var user_id = $('#user_id').val();
    $.ajax({
        type : 'POST',
        url : "/set_business_user_snap_status",
        data: {businessid,status},
        success : function(e){
            savingalert(e.type,e.msg);
        }
    });   
}

function setattronalldata(cat_id = '',subcat_id = ''){
    $('.show_ads_specific_category').attr('placecatid',cat_id).attr('placesubcatid',subcat_id);
    $('.show_ads_specific_sub_category').attr('placecatid',cat_id).attr('placesubcatid',subcat_id);
    $('.pboo-filter').attr('placecatid',cat_id).attr('placesubcatid',subcat_id);
    $('.show_all_ads').attr('placecatid',cat_id).attr('placesubcatid',subcat_id);
    $('.businessNameSearch').attr('placecatid',cat_id).attr('placesubcatid',subcat_id);
    $('.showfavorite').attr('placecatid',cat_id).attr('placesubcatid',subcat_id);
    $('.pageload').attr('placecatid',cat_id).attr('placesubcatid',subcat_id);
    $('.miles_count').attr('placecatid',cat_id).attr('placesubcatid',subcat_id);
    $('.pageload').attr('placecatid',cat_id).attr('placesubcatid',subcat_id);
}

function changeTheme(sel, title, version){ //alert(title); 
    var link_path = window.location.origin;
    $(".linkedcss").attr('href', link_path+"/assets/SavingsCss/theme-"+sel+".css");
    if(sel == 'purple'){
        $('.zoneview .cus_menu li').css('border','1px solid #7b498f');
        $('.zoneview .cus_menu .themeswitcher').css('border','none');
        $('#themeswitcher').css('border','1px solid #7b498f').css('color','#7b498f');
    }else if(sel == 'brown'){
        $('.zoneview .cus_menu li').css('border','1px solid #96735f');
        $('.zoneview .cus_menu .themeswitcher').css('border','none');
        $('#themeswitcher').css('border','1px solid #96735f').css('color','#96735f');
    }else if(sel == 'green'){
        $('.zoneview .cus_menu li').css('border','1px solid #5f9900');
        $('.zoneview .cus_menu .themeswitcher').css('border','none');
        $('#themeswitcher').css('border','1px solid #5f9900').css('color','#5f9900');
    }else if(sel == 'blue'){
        $('.zoneview .cus_menu li').css('border','1px solid #005eab');
        $('.zoneview .cus_menu .themeswitcher').css('border','none');
        $('#themeswitcher').css('border','1px solid #005eab').css('color','#005eab');
    }
    $(".rd-navbar-brand img").attr('src', link_path+"/assets/directory/images/logo-"+sel+".png");
    var data_to_use={
        'business_theme': sel,
        'business_title': title
    };
    $.ajax({
        type : 'POST',
        url : "/changetheme",
        data: data_to_use,
        success : function(data){},
        error : function(XMLHttpRequest, textStatus, errorThrown){}
    });
}

function sendmailcredit(userId,businessId,businessname,zone_id){
    $.ajax({
        type: "POST",
        url: "/sendEmail",
        dataType:'json',
        data: {'userId' :userId,'businessId' :businessId,'businessname' :businessname,'zone_id' :zone_id},
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
            
            var snapTiming = result[1].snapStartTime;
            var startTimeSelect = $('#startTime');
            startTimeSelect.empty(); 

            var snaptimeoption = '';
            $.each(snapTiming, function(k,v){
                snaptimeoption += '<option value="'+k+'">'+v+'</option>';
            })

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
                            var select_line='';
                            var ratingcontent='<h1 class="ratingz">Choose how you want this '+group_for+' to alert you</h1><br><div class="ig_submit_loading" style="margin:9px 0px 0px 0px;display:none;">Processing...<img id="loading1" src="<?=$link_path?>assets/images/loading.gif" width="20" height="20" alt="loading" style="padding-left:15px;"/></div> <div class="three columns"><span class="showSnapModelDetails"><i class="fa fa-info-circle" aria-hidden="true"></i></span>&nbsp;<span id="togglesnapuser">Snap Status</span> <input type="checkbox" class="togglesnapuser"/></div><div class="successsnap" style="display:none;"></div><br><br><span style="display: block;font-weight: bold;margin: -24px 0px 10px 21px;"><input type="radio" '+off_checked+' name="status" value="0" /> <span style="margin-left: 10px;font-weight: bold;">Use my Global Filters</span> <input type="radio" '+on_checked+' onchange=sendtypechange(); name="status" value="1" />&nbsp Below I’m setting different filters for this business.</span><div id="textoremail" class="checked_group text-center" style="'+showdiv+'" align="right"><input type="radio" name="statusRadio" onchange="sendtypechange();" value="1" '+radio1+'><span style="margin-left: 10px;font-weight: bold;">Email</span>&nbsp;<input type="radio" name="statusRadio" onchange="sendtypechange();" value="2" '+radio2+'><span style="margin-left: 10px;font-weight: bold;">Text Message</span>\
                             <br>\
                             </div>\
                                    <div id="snapFilterCriteria">\
                                        <div class="row">\
                                            <div class="col-md-12">\
                                                <h5>Set Available Time Period :</h5>\
                                            </div>\
                                        </div>\
                                        <br>\
                                        <div class="row">\
                                            <div class="col-md-1 timingz">\
                                                <h6>Start</h6>\
                                            </div>\
                                            <div class="col-md-2">\
                                                <select class="form-control timingz" name="startName" id="startTime">\
                                                    '+snaptimeoption+'\
                                                </select>\
                                            </div>\
                                            <div class="col-md-1 timingz">\
                                                <h6>End</h6>\
                                            </div>\
                                            <div class="col-md-2">\
                                                <select class="form-control timingz" name="endTime" id="endTime">\
                                                    '+snaptimeoption+'\
                                                </select>\
                                            </div>\
                                            <div class="col-md-3 snapfilterdis">\
                                               <h6>Discount</h6>\
                                            </div>\
                                            <div class="col-md-3 snapfilterdis">\
                                                <select class="form-control" id="percentageCriteria" name="discount-percentage">\
                                                    <option selected="selected">Select Discount</option>\
                                                        '+percentageCriteria+'\
                                                </select>\
                                            </div>\
                                        </div>\
                                        <br>\
                                        <hr>\
                                        <div class="row">\
                                            <div class="col-md-4">\
                                                <div class="form-check ">\
                                                    <label class="form-check-label">All Days</label>\
                                                    <input type="checkbox" class="inputCheckBoxallday addsnaptype" value="1">\
                                                </div>\
                                            </div>\
                                            <div class="col-md-4">\
                                                <div class="form-check ">\
                                                    <label class="form-check-label">Weekdays</label>\
                                                    <input type="checkbox" class="inputCheckBoxweekdays addsnaptype" value="2">\
                                                </div>\
                                            </div>\
                                            <div class="col-md-4">\
                                                <div class="form-check ">\
                                                     <label class="form-check-label">Weekend</label>\
                                                    <input type="checkbox" class="inputCheckBoxweekend addsnaptype" value="3">\
                                                </div>\
                                            </div>\
                                        </div>\
                                        <br>\
                                        <div class="row">\
                                           <div class="col-sm-12 text-center">\
                                                <div class="weekcolumn">M</div>\
                                                <div class="weekcolumn">T</div>\
                                                <div class="weekcolumn">W</div>\
                                                <div class="weekcolumn">T</div>\
                                                <div class="weekcolumn">F</div>\
                                                <div class="weekcolumn">S</div>\
                                                <div class="">S</div>\
                                            </div>\
                                        </div>\
                                        <div class="col-sm-12 text-center">\
                                               <div class="weekcolumn">\
                                                    <input type="checkbox" dayword="M" class="snapDay" name="snapDay" value="1">\
                                               </div>\
                                               <div class="weekcolumn">\
                                                    <input type="checkbox" dayword="T" class="snapDay" name="snapDay" value="2">\
                                               </div>\
                                               <div class="weekcolumn">\
                                                    <input type="checkbox" dayword="W" class="snapDay" name="snapDay" value="3">\
                                               </div>\
                                               <div class="weekcolumn">\
                                                    <input type="checkbox" dayword="Th" class="snapDay" name="snapDay" value="4">\
                                               </div>\
                                               <div class="weekcolumn">\
                                                    <input type="checkbox" dayword="F" class="snapDay" name="snapDay" value="5">\
                                               </div>\
                                               <div class="weekcolumn">\
                                                    <input type="checkbox" dayword="Sa" class="snapDay" name="snapDay" value="6">\
                                               </div>\
                                               <div class="weekcolumn">\
                                                    <input type="checkbox" dayword="Su" class="snapDay" name="snapDay" value="7">\
                                               </div>\
                                        </div>\
                                 <br>\
                                <div class="row">\
                                <button id="addusersnaptime" class="btn btn-primary list_btn_login">Add</button>\
                                    <div class="col-sm-12 snapcontent">\
                                    </div>\
                                </div>\
                                <div>\
                                    <button id="saveCriteria" class="btn btn-primary list_btn_login list_btn_orgs btn-free hide" data-user-id = "'+user_id+'" data-createdby-id = "'+createdby_id+'" data-zone-id = "'+zone_id+'" data-type = "'+type+'" data-from = "'+from+'" data-adid = "'+adid+'" data-busid = "'+adid+'">UPDATE</button>\
                                </div>\
                            </div>\
                            </div>\
                            </div><div id="checked_group"></div><br><br>'+select_line+'</br> <form id="igformsubmit" name="igform" action="javascript:void(0);" method="post">';
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

                                ratingcontent+='<p><span style="margin-bottom:7px; display:block;"><input style="margin-right:10px;" name="group[]" class="group" '+checkstatus+'  type="checkbox" value='+igid+' /><label style="font-size:18px;">'+igname+'</label></span></p>';

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

                    // $("#email_notice_pop_up").find('#checked_ group').html(text);
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
                        }else{                                                      
                            ratingcontent+='<p><span style="margin-bottom:7px; display:block;text-align: center;"><label style="font-size:18px; color: darkolivegreen;">Have not any category to select</label></span></p>';
                        }
                        ratingcontent+='</form>';
                    } else {
                        var ratingcontent='<a href="javascript:void(0)" class="close"><img src="<?=$link_path?>assets/images/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a><h3>Have not any category to select</h3>';
                    }
                    $(emailBox).html(ratingcontent).fadeIn(300);
                    // $("#email_notice_pop_up").find('#checked_group').html(text);
                    $('#email_notice_pop_up_modal').modal('show');

                    return false;

                 }

                })
            }

            getsavedsnapcustomdata(createdby_id,zone_id,user_id);

          }
        })
}

$(document).on('click','.addsnaptype', function(){
    $('.addsnaptype').prop('checked', false);
    $(this).prop('checked', true);
    $('.snapDay').prop('checked', false);
    var snaptypevalue = '';
    $('.addsnaptype').each(function(){
        if($(this).is(":checked") == true){
            snaptypevalue = $(this).val();
        }    
    });

    if(snaptypevalue == 1){
        $('.snapDay').prop('checked', true);
    }else if(snaptypevalue == 2){
        $('.snapDay').each(function(){
            var day = $(this).val();
            if(parseInt(day) <= 5){
                $(this).prop('checked', true);
            }
        });  
    }else if(snaptypevalue == 3){
        $('.snapDay').each(function(){
            var day = $(this).val();
            if(parseInt(day) > 5){
                $(this).prop('checked', true);
            }
        }); 
    }
});

$(document).on('click', '#addusersnaptime', function(event) {
    var percentage = $('#percentageCriteria').find(":selected").val();
    var percentagetext = $('#percentageCriteria').find(":selected").text();
    var startTime = $('#startTime').find(":selected").val();
    var startTimetext = $('#startTime').find(":selected").text();
    var endTime = $('#endTime').find(":selected").val();
    var endTimetext = $('#endTime').find(":selected").text();

    var snapsendtype = 0;
    var checkday = 0;
    if($('.inputCheckBoxallday').is(":checked") == true){var snapsendtype = 1;}
    if($('.inputCheckBoxweekdays').is(":checked") == true){var snapsendtype = 2;}
    if($('.inputCheckBoxweekend').is(":checked") == true){var snapsendtype = 3;}

    var html = '';
    $('.snapDay').each(function(){
        if($(this).is(":checked") == true){
            checkday = 1;
            perdayselect = $(this).val();
            dayword = $(this).attr('dayword');
            html += `<div class="snaplistsubmaindiv">
            <div class="snaplistsubdiv header-list-items" dayid="`+perdayselect+`" starttime="`+startTime+`" endtime="`+endTime+`" discountsnap="`+percentage+`" snapsendtype="`+snapsendtype+`">`+dayword+` `+startTimetext+`-`+endTimetext+` `+percentagetext+`<span class="snaplistsubspan">X</span></div></div>`;
        }    
    });
    if(checkday == 0){
        savingalert('warning','Please check atleast snap week days');
        return false;    
    }
    $('.snapcontent').append(html);
    $('#saveCriteria').removeClass('hide');
    $('#startTime').val(1).prop('selected', true);
    $('#endTime').val(1).prop('selected', true);
    $('.inputCheckBoxallday').prop('checked', false);
    $('.inputCheckBoxweekdays').prop('checked',false);
    $('.inputCheckBoxweekend').prop('checked', false);
    $('.snapDay').prop('checked', false);
    $('#percentageCriteria').val('').prop('selected', true);
});
    

$(document).on('click', '.cross-btn', function() {
    $(this).closest('.snap-data').remove(); 
});



$('.snapmodalclose').on('click', function() {
    $('#email_notice_pop_up_modal').modal('hide');
});

$('.snapusermodalclose').on('click', function() {
    $('#snapusermodal').modal('hide');
});


$(document).on('input', '.search_cont', function() {
    var search = $(this).val();
    var zoneid = $("input[name=zoneid]").val();
    $('.searchInputResults').html('');
    if (search) {
        $.ajax({
            type: "GET",
            url: "/getzonebusiness",
            data: {search,zoneid},
            dataType:'json',
            success: function (t) {
                if (t.length > 0) {
                    if (t.length > 7) {
                        $('.searchInputResults').css({'overflow-y': 'scroll','height': '300px'});
                    }else{
                        $('.searchInputResults').css({'overflow-y': 'auto','height': 'auto'}); 
                    }
                    $.each(t, function(k, v) {
                        $('.searchInputResults').css('display','block');
                        $('.searchInputResults').append('<div><p class="business_name" data-bname="' + v.name + '">' + v.name + '</p></div>');
                    });
                }else{
                    $('.searchInputResults').css({'overflow-y': 'auto','height': 'auto'}); 
                    $('.searchInputResults').css('display','block');
                    $('.searchInputResults').html('<div>No results found!</div>');
                }
            }
        });  
    }
});

 $('.searchInputResults').on('click', '.business_name', function() {
        $('.searchInputResults').css('display','none');
        var search = $(this).data('bname');
        $('.search_cont').val(search);

        var search = $('.search_cont').val();
        if(search != ''){
                gettempadsData(1,uplimit,search,'show_all_offers',search,'','','true');
            }
    });
 $(document).on('click','.showSnapModelDetails', function(){
        $('.show_snap_details_modal').modal('show');
});
$(document).on('click','.closeSnapDetail', function(){
    $(".show_snap_details_modal").modal("hide");
});


function getsavedsnapcustomdata(bus_id,zone_id,user_id){
    var html = '';
    $.ajax({
        type: "GET",
        url: "/get_saved_snap_customdata",
        data: {bus_id,zone_id,user_id},
        dataType:'json',
        beforeSend : function(){$('#loading').css('display','block');},
        complete: function() {$('#loading').css('display','none');},
        success: function (t) {
            $('input[name="statusRadio"]:radio').val(t.sendtype).prop('checked', true);     
            $('input[name="status"]:radio').val(1).prop('checked', true);     
            $('#textoremail').slideDown('slow');
            $("#snapFilterCriteria").slideDown("slow");
           
            $.each(t.datahtml,function(k,v){
                html += v;
            });
            $('.snapcontent').html(html);
            $('#saveCriteria').removeClass('hide');
        }
    });
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
function gettempadsData(lowerlimit,upperlimit,charval,from_where,search_value,subcat_id,cat_id,searchbutton="",pageload = '', sortbyvalue = '',albhabetvalue = ''){
    var user_id = $("input[name=user_id]").val();
    var zoneid = $("input[name=zoneid]").val();
    var urlsubcat = $('#urlsubcat').val();
    var googlelatdealpage = $('#googlelatdealpage').val();
    var googlelngdealpage = $('#googlelngdealpage').val();

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
        urlsubcat:urlsubcat,
        sortbyvalue:sortbyvalue,
        albhabetvalue:albhabetvalue,
        lat:googlelatdealpage,
        lng:googlelngdealpage
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
                $("ul#myTab").html($('<div class="kiss" style="text-align: center;width: 100%;border: none;color: red;font-size: 23px;line-height: 30px;" id="loader1"><span class="loaderdesignmobileview" style="font-size: 40px;line-height: 60px;font-weight:700;color:#000;"><span style="color:#000;">Locating....</span> Deals for You! <br>Deals <span style="color:#000;">from Businesses</span> Help <span style="color:#000;">Your</span> Favorite Nonprofit<img style="width:50px;height:50px;" src="/assets/images/kiss.png"</div>'));
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
                html += '<li class="'+$$class+' pageload" pagecount="'+i+'">'+i+'</li>';
            }
        }
        html += '<li><a href="#" data-page="next" class="page page-next nextlink">»</a></li>';
        $('.pagination_count').html(html);
    }else{
        html += '<li><a href="#" data-page="prev" class="page page-prev deactive">«</a></li>';
        html += '<li class="active pageload colorwhiteborder">1</li>';
        html += '<li><a href="#" data-page="next" class="page page-next">»</a></li>';
        $('.pagination_count').html(html);
    }
}

function dataTwoGridView(data){
    console.log(data);
    var html = '';
    var baseUrl = '<?= base_url(); ?>';
    var zone_id = $('#userzone').val();
    var user_id = $('#userId').val();
    var user_snap_settings = $('#user_snap_settings').val();
    var dt = new Date();
    var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
    var baseUrl = window.location.origin;
    var dealimg = '';
    var screenwidth = $(window).width();
    var screenheight = $(window).height();
    if(data.adlist.length > 0){
    $.each(data.adlist, function(k,v) {
        if(v.service_number != 0){ var service_number = v.service_number;}
        else{var service_number = 0;}

        if(v.catidnew == 1){ var foodhide = 'nohide';var FOS_btn = '';}
        else{ var foodhide = 'hide'; var FOS_btn = 'fos_fix_row';}

        if(v.favresfinal > 0){var heart = 'fa fa-heart';}
        else{var heart = 'fa fa-heart-o';}

        subcatimagelength = v.adidsubcatimage;
        var subcatimagehtml = ''; var subimagelength  = 0;
        if(subcatimagelength.length > 0){
            $.each(subcatimagelength, function(k,v) { subimagelength  = 1;});   
        }
        var busaddress = '';
        var googleaddress = '';
        if(v.bs_phone != ''){
            var p = v.bs_phone;
            var nb = p.toString().split('');
            var phone_int = '('+nb[0]+''+nb[1]+''+nb[2]+') '+nb[3]+''+nb[4]+''+nb[5]+'-'+nb[6]+''+nb[7]+''+nb[8]+''+nb[9]+'';
            busaddress += " <p><a href='tel:312-419-2700'><i title='Phone' class='fa fa-phone' aria-hidden='true'></i> Phone : "+ phone_int +"</a></p>";
        }

        busaddress += "<i title='Address' class='fa fa-map-marker' aria-hidden='true'></i> Address : ";
        if(v.bs_streetaddress1){
            googleaddress += v.bs_streetaddress1;
            busaddress += v.bs_streetaddress1+"";
        }
        if(v.bs_city != ''){
            busaddress += ',<br> '+v.bs_city+"";
            googleaddress += ', '+v.bs_city;
        }
        if(v.bs_state != ''){
            busaddress += ', '+v.bs_state+"";
            googleaddress += ', '+v.bs_state;
        }
        if(v.bs_zipcode != ''){
            busaddress += ', '+v.bs_zipcode+"";
            googleaddress += ', '+v.bs_zipcode;
        }
        var encodedaddress = encodeURIComponent(googleaddress);
        // var googlelink = "https://maps.googleapis.com/maps/api/geocode/json?address="+encodedaddress+"&sensor=false&key=AIzaSyAEQMa2LNksZ5nY-BbeiyZyaSa-IplsE8M";
        var googlelink = 'http://maps.google.com?q='+googleaddress+'';
        busaddress += " <a target='_blank' href='"+googlelink+"'><i class='fa fa-map'></i></a>";
        html += `<div class="col-md-6 col-sm-12 third-col">
            <div class="order_boxes">
               <div class="row align-middle">
                  <div class="col-md-10">
                     <h2 class="featured-title">`+v.bs_name+`</h2>
                  </div>
                  <div class="col-md-2">
                     <a target="_blank" href="/businessdetail/`+v.bs_slug+`/"  data-style="tooltip" data-tip="Business Home Ad" class="cus-btn-home pop_tooltip" ><i class="fa fa-home" aria-hidden="true"></i></a>
                  </div>
               </div>`;
        if(v.peekaboolist.length > 1){
            var circlehtml = '';
            for (var i = 1; i <= v.peekaboolist.length; i++) {
                if(i == 1){var $class = 'text-primary circleactive';}
                else{var $class = 'text-primarylight';}
                circlehtml += `<i busid="`+v.bs_id+'_'+i+`" buscount="`+i+`" class="fa fa-circle `+$class+` circleDot"></i>`;
            }
            html += `<section class="sectionDiv"><ol>`;
            $.each(v.peekaboolist, function(k1,v1) {
                imghtml = '';
                if(k1 == 0){var $hide='';var $active='activeslide';}else{var $hide='hide';var $active='';}
                html += `<li class="`+$hide+` `+$active+`">`; 
                html += `<div class="row align-middle min-height-order" style="margin-top:0px;">`;
                if(v1.deal_title != ''){
                    html +=`<span class="text-primary subheadeing" >`+v1.deal_title+` <i data-style="tooltip" class="dealdesc fa fa-info-circle text-primary pop_tooltip" data-tip="Fresh and Healthy Nutrition with a taste you'll enjoy."></i></span> `;
                }else{
                    html +=`<span class="text-primary subheadeing" > &nbsp;</span> `;
                }
                
                html +=`<div class="col-md-6 item_img 1">`;
                if(v.insert_via_csv == 1 && v1.card_img != ''){
                    if(screenwidth <= 767){
                        html += `<img  fgf src="`+amazonurl+`/`+v1.card_img+`">`;
                        imghtml = `https://savingssites.com/assets/SavingsUpload/CSV/`+v.zoneid+`/images/resizeimages/`+v1.card_img;
                    }else{
                        html += `<img  ds src="`+amazonurl+`/`+v1.card_img+`">`;
                        imghtml = ``+amazonurl+`/`+v1.card_img;
                    }
                }else{
                    if(v1.card_img != ''){
                        if(screenwidth <= 767){
                            html += `<img hg src="`+amazonurl+`/`+v1.card_img+`">`;
                            imghtml = ``+amazonurl+`/`+v1.card_img;
                        }else if(v.adidsubcatimage == ''){
                            html +=`<img src="`+amazonurl+`/GetExtraSavings.jpg">`;
                            imghtml = amazonurl+`/GetExtraSavings.jpg`;
                        }else{
                            html += `<img jtyj src="`+amazonurl+`/`+v1.card_img+`">`;
                            imghtml = amazonurl+`/`+v1.card_img;
                        }
                    }
                }
                
                if(subcatimagelength.length > 0 && v1.card_img != '' ){
                    subcatimagehtml = '';
                    $.each(subcatimagelength, function(k,v) {
                        subcatimagehtml += '<img thtr class="hide ss1 ss45" src="'+amazonurl+'/'+v+'" />';
                        imghtml = amazonurl+`/`+v;
                    });   
                }else if(subcatimagelength.length > 0 && v1.card_img == '' && v.insert_via_csv != 1 ){
                    subcatimagehtml = '';
                    $.each(subcatimagelength, function(k,v) {
                        if (k == 0 ) {
                            subcatimagehtml += '<img hnhh src="'+amazonurl+'/'+v+'" />';
                            imghtml = amazonurl+`/`+v;
                        }else{
                            subcatimagehtml += '<img ukjyu class="hide ss1 ss78" src="'+amazonurl+'/'+v+'" />';
                            imghtml = amazonurl+`/`+v;
                        }
                    });
                }
                
                dealimg = imghtml;
                html += subcatimagehtml;
                html += `</div>
                <div class="col-md-6 centerofdiv">
                    <table>
                        <tbody>
                            <tr> 
                                <td>Deal Value:<span class="pkbpop1 cartmodal" href="#" data-title="Title" data-content="Some Description<br>Some other description">
                                    <img src="`+amazonurl+`/info-icon-27.png"></span> </td>
                                <td style="text-align: end;">$`+v1.buy_price_decrease_by+`</td>
                            </tr>
                            <tr>
                                <td>Pay Business:<a class="dealprice newdealprice" href="#" data-title="Title" data-content="Some Description<br>Some other description">
                                    <img src="`+amazonurl+`/info-icon-27.png"></a>  </td>
                                <td style="text-align: end;">$`+v1.current_price+`</td>
                            </tr>
                            <tr>
                                <td>Deals Left: </td>`;
                                html+= `<td style="text-align: end;">`;
                                if(v1.numberofconsolation <= 0 && v1.numberofconsolation != -1){
                                    updatenumberofconsolation(v.business_owner_id);
                                }else if(v1.numberofconsolation == -1){
                                    html += `Unlimited`;
                                }else{
                                    html += v1.numberofconsolation;
                                }
                                
                                html += `<a class="dealremaining" href="#" data-title="Title" data-content="Some Description<br>Some other description" data-toggle="modal" data-target="#deals_remaining">
                                            <img src="`+amazonurl+`/info-icon-27.png"></a></td>`;    
                            html += `</tr>`;
                            html += `<tr><td colspan="2"><div style="width:60%;margin: 0 auto;"><div  style="width:25%;float:left;"><i class="fa fa-solid fa-chevron-left header-list-items sliderLeft" busid="`+v.bs_id+`" deallength="`+v.peekaboolist.length+`" style="border-radius: 50%;font-size: 12px;padding: 6px;color:#fff;"></i></div><div style="width:50%;float:left;text-align:center;">`+circlehtml+`</div><div  style="width:25%;float:left;"><i class="fa fa-solid fa-chevron-right header-list-items sliderRight" busid="`+v.bs_id+`" deallength="`+v.peekaboolist.length+`" style="border-radius: 50%;font-size: 12px;padding: 6px;color:#fff;float:right"></div></i></div></td></tr>`;
                            html +=`</tbody></table>`;
                            if(v.insert_via_csv == 1){
                            html +=`<button class="mediamargin list_btn_login list_btn_orgs btn-free pop_tooltip" data-style="tooltip" data-tip="Receive $5 off your first deal certificate purchase from this business" onclick='getmodalopenemail(`+service_number+`,`+v.bs_id+`,`+v.business_owner_id+`,"`+v.bs_name+`")'>FREE $5</button>`;
                            }else{
                               html+=`<button class="list_btn_login btn-free pop_tooltip" data-style="tooltip" data-tip="Receive $5 off your first deal certificate purchase from this business" onclick='getmodalopenemail(`+service_number+`,`+v.bs_id+`,`+v.business_owner_id+`,"`+v.bs_name+`")'>FREE $5</button>
                                <button class="list_btn_login addtocart" data_busid=`+v.bs_id+` data-id=`+v1.deal_id+` insert_via_csv=`+v.insert_via_csv+` item-name="`+v.bs_name+`" data-userid="`+data.user_id+`" data-zone="`+data.zone+`">Add to Cart</button>`;
                                }
                                
                               html +=`<button class="list_order_savings `+foodhide+`" data-toggle="modal" data-target="#service_modal_div02">
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
                        html += `<div class="row align-middle min-height-order" style="margin-top:0px;">`;
                        if(v1.deal_title != ''){
                            html +=`<span class="text-primary subheadeing" >`+v1.deal_title+`<i data-style="tooltip" class="dealdesc fa fa-info-circle text-primary pop_tooltip" data-tip="Fresh and Healthy Nutrition with a taste you'll enjoy."></i></span> `;
                        }else{
                             html +=`<span class="text-primary subheadeing" >&nbsp;</span> `;
                        }
                        html += `<div class="col-md-6 item_img">`;
                            if(subcatimagelength.length > 1){
                                html += '<i class="ss1 fa fa-solid fa-chevron-left subleft" aria-hidden="true"></i>';   
                            }
                                if(v.insert_via_csv == 1 && v1.card_img != ''){
                                    if(screenwidth <= 767){
                                        html += `<img src="`+amazonurl+`/`+v1.card_img+`">`;
                                        imghtml = `https://savingssites.com/assets/SavingsUpload/CSV/`+v.zoneid+`/images/resizeimages/`+v1.card_img;
                                    }
                                    else{
                                        html += `<img src="`+amazonurl+`/`+v1.card_img+`">`;
                                        imghtml = amazonurl+`/`+v1.card_img;
                                    }

                                }else{
                                    if(v1.card_img != ''){
                                        html += `<img src="`+amazonurl+`/`+v1.card_img+`">`;
                                        imghtml = amazonurl+`/`+v1.card_img;
                                    }
                                    else if(v.adidsubcatimage == ''){
                                        html +=`<img src="`+amazonurl+`/GetExtraSavings.jpg">`;
                                        imghtml = amazonurl+`/GetExtraSavings.jpg`;
                                    }
                                    else{
                                        // html += `<img src="`+amazonurl+`/`+v1.card_img+`">`;
                                        // imghtml = amazonurl+`/`+v1.card_img;   
                                    }
                                }
                                if(subcatimagelength.length > 0 && v1.card_img != ''){
                                    $.each(subcatimagelength, function(k,v) {
                                        subcatimagehtml += '<img class="hide ss2" src="'+amazonurl+'/'+v+'" />';
                                        imghtml = amazonurl+`/`+v;
                                    });   
                                }else if(subcatimagelength.length > 0){
                                    $.each(subcatimagelength, function(k,v) {
                                        if (k == 0) {
                                             subcatimagehtml += '<img src="'+amazonurl+'/'+v+'" />';
                                             imghtml = amazonurl+`/`+v;
                                        }else{
                                             subcatimagehtml += '<img class="hide ss2" src="'+amazonurl+'/'+v+'" />';
                                             imghtml = amazonurl+`/`+v;
                                        }
                                       
                                    });
                                }
                                dealimg = imghtml;


                                html += subcatimagehtml;
                                if(subcatimagelength.length > 1){
                                    html += '<i class="fa fa-solid fa-chevron-right subright" aria-hidden="true"></i>';   
                                }
                            html += `</div>
                            <div class="col-md-6 centerofdiv">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>Deal Value:<span class="pkbpop1 cartmodal" href="#" data-title="Title" data-content="Some Description<br>Some other description">
                                            <img src="`+amazonurl+`/info-icon-27.png"></span> </td>
                                        <td style="text-align: end;">$`+v1.buy_price_decrease_by+` 

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pay Business:<a class="dealprice newdealprice" href="#" data-title="Title" data-content="Some Description<br>Some other description">
                                            <img src="`+amazonurl+`/info-icon-27.png"></a>  </td>
                                        <td style="text-align: end;">$`+v1.current_price+` 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Deals Left:<a class="dealremaining" href="#" data-title="Title" data-content="Some Description<br>Some other description" data-toggle="modal" data-target="#deals_remaining">
                                            <img src="`+amazonurl+`/info-icon-27.png"></a> </td>`;
                                        html+= `<td style="text-align: end;">`;
                                        if(v1.numberofconsolation <= 0 && v1.numberofconsolation != -1){
                                            updatenumberofconsolation(v1.product_id,v.business_owner_id);
                                        }else if(v1.numberofconsolation == -1){
                                            html += `Unlimited`;
                                        }else{
                                            html += v1.numberofconsolation;
                                        }
                                        html += `</td>`;    

                            html += `</tr></tbody></table>`;
                            if(v.insert_via_csv == 1){
                             html += `<button class="mediamargin list_btn_login list_btn_orgs btn-free pop_tooltip" data-style="tooltip" data-tip="Receive $5 off your first deal certificate purchase from this business" onclick='getmodalopenemail(`+service_number+`,`+v.bs_id+`,`+v.business_owner_id+`,"`+v.bs_name+`")'>FREE $5</button>`;
                             }else{
                             html += `<button class="list_btn_login btn-free pop_tooltip" data-style="tooltip" data-tip="Receive $5 off your first deal certificate purchase from this business" onclick='getmodalopenemail(`+service_number+`,`+v.bs_id+`,`+v.business_owner_id+`,"`+v.bs_name+`")'>FREE $5</button>
                                <button class="list_btn_login addtocart" data_busid=`+v.bs_id+` data-id=`+v1.deal_id+` insert_via_csv=`+v.insert_via_csv+` item-name="`+v.bs_name+`" data-userid="`+data.user_id+`" data-zone="`+data.zone+`">Add to Cart</button>`;
                              }                  
                                html += `<button class="list_order_savings `+foodhide+`" data-toggle="modal" data-target="#service_modal_div02">
                                    <span onclick='getmodalopen(`+service_number+`,`+v.bs_id+`,`+v.business_owner_id+`,"`+v.bs_name+`")' class='`+foodhide+` foor_order_savings'><img src="`+baseUrl+`/assets/SavingsUpload/images/foodorder.jpg">
                                    </span>
                                </button>
                          
                            </div>
                            </div>`;
                    });
                }else{
                    if(subcatimagelength.length >0){
                        subcatimagehtml = '';
                        $.each(subcatimagelength, function(k,v) {
                            subcatimagehtml += '<img thtr class="hide ss1 ss45" src="'+amazonurl+'/'+v+'" />';
                            imghtml = amazonurl+`/`+v;
                        });  
                    }
                    html += `<div class="row align-middle min-height-order dmyimg-data">`;
                    html +=`<span class="text-primary subheadeing" >&nbsp;</span> `;
                    html += `<div class="col-md-6 item_img 3">`;
                    if(subimagelength == 1){
                        html += '<i class="fa fa-solid fa-chevron-left subleft" aria-hidden="true"></i>';   
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
                        html += '<i class="fa fa-solid fa-chevron-right subright" aria-hidden="true"></i>';   
                    }
                    html += `</div>
                    <div class="col-md-6 dumyimage">
                        <div style="width:100%">
                            <div style="width:30%;float:left;"><img style="width:70%;" class="dumyimage1" src="`+amazonurl+`/support_orgs.jpg"> </div>
                            <div style="width:70%;float:left;"><span style="font-size:13px;">`+v.short_description+`</span></div>
                        </div>
                        <button class="margintop1 list_btn_orgs btn-free pop_tooltip" data-style="tooltip" data-tip="Receive $5 off your first deal certificate purchase from this business" onclick='getmodalopenemail(`+service_number+`,`+v.bs_id+`,`+v.business_owner_id+`,"`+v.bs_name+`")'>FREE $5</button>
                        <button class="list_order_savings `+foodhide+`" data-toggle="modal" data-target="#service_modal_div02">
                            <span onclick='getmodalopen(`+service_number+`,`+v.bs_id+`,`+v.business_owner_id+`,"`+v.bs_name+`")' class='`+foodhide+` foor_order_savings'><img src='https://www.foodordersavings.com/img/logo_head.png'>
                            </span>
                        </button>
                        </div>
                    </div>`;
                }
                html += `<div class="row align-middle share_heart_icon `+FOS_btn+`">
                  <div class="col-md-12">
                    <div  class="row iconss">
                        <div class="buss_snap col-md-3">
                         <img src="`+amazonurl+`/info-icon-27.png"" class="info_icon" data-title="Title" data-content="Some Description<br>Some other description" data-toggle="modal" data-target="#pbkPop0002">
                            <span class="snap_icon emailnoticepopup" adid="`+v.adid+`" busid="`+v.bs_id+`" UserId ="`+data.user_id+`">`;
                                if(user_id == '' || user_id == undefined){
                                    html += `<img src="`+amazonurl+`/snap-off-black.png">`;
                                }else{
                                    if(v.business_sponsor_status == 1 && user_snap_settings == 1){
                                        html += `<img src="`+amazonurl+`/icon-2.png">`;
                                    }else{
                                        html += `<img src="`+amazonurl+`/snap-off.png">`;   
                                    }
                                }
                               
                                
                            html += `</span>
                        </div>
                        <div class="buss_heart_snap col-md-3">
                        <img src="`+amazonurl+`/info-icon-27.png"" class="info_icon favouriteicon" href="#" data-title="Title" data-content="Some Description<br>Some other description" data-toggle="modal" data-target="#favourite">
                            <span class="snap_icon_heart ad_favorite" data-title="Title" data-content="Some Description<br>Some other description" rel="1" adid="`+v.adid+`" busid="`+v.bs_id+`" UserId ="`+data.user_id+`">
                                
                                <i class="`+heart+`"></i>
                            </span>
                        </div>

                        <div class="location-pin col-md-3 pop_tooltip" id="pinlocation" busname="`+v.bs_name+`" address="`+busaddress+`"  data-style="tooltip" data-tip="Location">
                            <span class="pin-icon">
                                <img src="https://cdn.savingssites.com/pin.png">
                              
                            </span>
                        </div>`;
                        if(v.food_audio || v.food_pdf){
                            var themecolor = 'themecolor';
                        }else{
                            var themecolor = '';
                        }
                        if(v.food_audio != '' || v.food_pdf != ''){
                            html +=`<div class="col-md-3 pop_tooltip" data-style="tooltip"  data-tip="Daily Specials"><i day="`+v.food_day+`" busname="`+v.bs_name+`" imageaudio="`+dealimg+`" audiofile="`+v.food_audio+`" pdffile="`+v.food_pdf+`" business_id="`+v.bs_id+`" class="`+themecolor+` fa fa-solid fa-tags fa-xl play_audio_special_day" aria-hidden="true"></i></div>`;
                        }
                        html += `<li class="hide_on_desktop">
                         <a href="#" class="sahre_box"><img src="`+baseUrl+`/assets/directory/images/share.png"></a>
                            <div class="addthis_inline_share_toolbox_pwty" data-url="`+baseUrl+`/short_url/`+v.deal_id+`/`+zone_id+`/`+v.bs_id+`/`+v.adid+`/`+v.user_idnew+`" data-title="`+v.bs_name+`" data-media="`+dealimg+`"></div>
                        </li>
                    </div>
                  </div>
               </div>
            </div>
         </div>`;
    });
    }else{
        html += '<span class="error_nodata">Select the type of Businesses above to find your local deals.</span>'; 
    }
$('#appendtwocolumndiv').html(html);
}

$(".show-list").click(function(){
    var catid = $(this).attr('catid');
    var titlecat = $(this).attr('titlecat');
    if($(this).hasClass('open')){
        $(this).addClass('open1');
        $('.showcategory_'+catid).slideUp(100);
        $('.showmaincat'+catid).addClass('hide');
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
        $('.show-list').removeClass('open1');
        $('.maincategory').addClass('hide');
        $('.showcategory_'+catid).slideDown(100);
        $('.showmaincat'+catid).removeClass('hide');
        $('.showcategory_'+catid).removeClass("hide");
        $(this).addClass('open');
        $(".cus-ul").css({
            display: 'block',
            float: 'left',
            marginBottom: '2%'
        });
    }
    $('#sortenoption').removeClass('sortenoption');
    $('.pboo-filter').removeClass('themecolor');
    $('.atozfilteroption').removeClass('sortenoption');
    $('.show_all_ads').removeClass('sortenoption');
    $('.pboo-filter').removeClass('header-list-items');
    $('.pboo-filter').css('color', '');
    setattronalldata(catid,'');
});



$(".list-show").click(function(){
      $('html,body').animate({
        scrollTop: $("#appendtwocolumndiv").offset().top},
        'slow');
});

function updatenumberofconsolation(product_id,business_owner_id){
    var product_ids=product_id
    var business_owner_ids=business_owner_id;
    $.ajax({
        type: "GET",
        url: "/stokalertmail",
        data: {'product_ids': product_ids,'business_owner_ids':business_owner_ids},
        dataType:'json',
        success: function (t) {
           
        }
    });
}

function sign_out(){ 
    var zone_id = $('#userzone').val();
    var type = 'business';
    savingalert('success','Your Session has expired please login'); //Redirecting to the zone directory page
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
        if(check == 1){
          savingalert('info','Email Sent');  
          return false;
        }

        if(userId != ''){
            sendmailcredit(userId,businessId,businessname,zone_id);
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
    var msg = '<div style="opacity:1;" class="alert alert-'+type+' alert-dismissible fade show" role="alert"><strong>'+msg+'</strong></button></div>';
    $('#alert_msg').html(msg).css('display','block');
    setTimeout(hidealert, 3000);
}
function hidealert(){
    $('#alert_msg').css('display','none');  
}

$(document).ready(function(){
    $('.fa fa-phone').tooltip();
    $('.dealdesc').tooltip();
    $('#themeswitcher').text($('#business_title').val());
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

     
  
$(document).ready(function(){
    getsubcatfun(1);
    if ($('.show-list').length > 8) { 
        $(".hide_on_mobile ul").addClass("list-iteam-intro");
    }
    $(document).on('change','.miles_count',function(){
        var miles = $(this).val();
        $('#searchtype').val(miles);
        $('#searchtype').attr('typeset', 'show_data_miles');
        if(miles){
            var sortbyvalue = '';
            $('.pboo-filter').each(function(){
                if($(this).hasClass('header-list-items') == true){
                    sortbyvalue = $(this).attr('data-filter');
                    return false;   
                }
            });
            
            var albhabetvalue = '';
                $('.show_all_ads').each(function(){
                if($(this).hasClass('sortenoption') == true){
                    albhabetvalue = $(this).attr('rel');
                    return false;   
                }
            });


            var lowerlimit = 0;
            var upperlimit = uplimit;
            var charval = "";
            var from_where = "show_data_miles";
            var search_value = miles;
            var placecatid = $(this).attr('placecatid');
            var placesubcatid = $(this).attr('placesubcatid');
            gettempadsData(lowerlimit,upperlimit,charval,from_where,search_value,placesubcatid,placecatid,'','',sortbyvalue,albhabetvalue);
        }
    });

    $(document).on('change','.dropdown_select_cat', function(){
        var cattid = $(this).val();
        getsubcatfun(cattid);
    });

    $(document).on('change','.sub_mob_populate', function(){
        var placecatid = $('.dropdown_select_cat').find(":selected").val();
        var subid = $(this).find(":selected").attr('id');
        var val = $(this).find(":selected").val();
        $('#searchtype').val(subid);
        $('#searchtype').attr('typeset', 'show_ads_specific_sub_category');
        if(val == 'category'){
            gettempadsData(1,uplimit,'','show_ads_specific_category','','',placecatid);
        }else{
            gettempadsData(1,uplimit,'','show_ads_specific_sub_category',placecatid,subid,placecatid);
        }
    });

    $(document).on('click','.readsnapusermodal', function(){
        $('#snapusermodal').modal({backdrop: 'static', keyboard: false}, 'show');
        $('#snapusermodal').modal('show');
    });
    
    $(document).on('click','.togglesnapuser', function(){
        var businessid = $('#togglesnapuser').attr('businesid');
        if($(this).is(':checked') == true){
            setbusinessusersnapstatus(businessid,1);
        }else{
            setbusinessusersnapstatus(businessid,0);   
        }
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
            html += '<option class="show_ads_specific_sub_category" value="category" rel="'+cattid+'" id="'+cattid+'" placecatid="'+cattid+'" placesubcatid="">All</option>';
            $.each(e,function(k,v){
                html+= "<option class='show_ads_specific_sub_category' rel='"+v.id+"' id='"+v.id+"'>"+v.id0+" "+v.id2+"</option>";
            });
            $('.sub_mob_populate').html(html);         
        }
    });  
}
$(document).ready(function(){
    $('#eventactivity').on('click',function(e){
        e.preventDefault();

    });
    $(document).on('click','.close', function(){
        $('#emailnoticesignupform02').modal({backdrop: 'static', keyboard: false});
        $('#emailnoticesignupform02').modal('hide');
        $('#employee_registration').modal({backdrop: 'static', keyboard: false});
        $('#employee_registration').modal('hide');
        $('#visitor_registration02').modal({backdrop: 'static', keyboard: false});
        $('#visitor_registration02').modal('hide');
    });

    
});


// var scrolled = 0;
// function down()
// {
// scrolled = scrolled + 300;
// $( ".show_ads_specific_sub_category" ).animate({
// scrollTop :  scrolled
// });
// alert( " Scrolled down " +scrolled+ " Px." );
// }



$(".show-list").click(function(){
$(".show-list").removeClass("activelist");
    
})


$(document).ready(function() {
    var tooltip_class = '';
    $(document).on('mouseover','.pop_tooltip', function(){
        tooltip = $(this);
        tooltip_text = tooltip.attr('data-tip');
        tooltip_style = tooltip.attr('data-style');
        tooltip_class = '.' + tooltip_style;
        
        tooltip.addClass('showed-tooltip').after('<span class="'+tooltip_style+'">'+tooltip_text+'</span>');

        position_top = tooltip.position().top - $(tooltip_class).outerHeight() - 5;
        position_right = tooltip.position().center;
        
        $(tooltip_class).css({ 'right': position_right, 'top': position_top }).animate({'opacity':'1'}, 200);
        
    })
    .on('mouseout', function() {
        $(tooltip_class).animate({'opacity':'0', 'margin-left':'0px'}, 200, function() {
            $(this).remove();
            tooltip.removeClass('showed-tooltip');
        });
    
   });
});