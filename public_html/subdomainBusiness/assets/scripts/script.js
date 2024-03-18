function showCategory(a, b, c) {
    $("#category").hide("explode"), $.ajax({
        type: "GET",
        url: "form_processor.php?catId=" + a,
        cache: !1,
        success: function(a) {
            $("#category #header-business #catType").text(b), $("#category #header-business #catName").text(c), $("#category").show("slow")
        }
    }), activeCategory = a
}

function toggleHire(a) {
    "banners/hiring_yes.png" == $("#hire" + a + " img").attr("src") ? $("#hire" + a + " img").attr("src", "banners/hiring_no.png") : $("#hire" + a + " img").attr("src", "banners/hiring_yes.png")
}

function toggleBarter(a) {
    "banners/barter_yes.png" == $("#barter" + a + " img").attr("src") ? $("#barter" + a + " img").attr("src", "banners/barter_no.png") : $("#barter" + a + " img").attr("src", "banners/barter_yes.png")
}

function triggerDownload(a) {
    window.setTimeout(function() {
        setCookie("SSDFireFox", "true", 1), window.location = a
    }, 5e3)
}

function call_js_for_baner_in_zone() {
    $("#slider").nivoSlider()
}

function call_for_auto_scroll_slider() {
    $("#carousel-example-generic").carousel({
        interval: 5e3,
        pause: "hover"
    })
}

function call_js_for_pboo_baner_in_zone() {
    $("#peekaboo-slider").nivoSlider()
}

function call_js_for_category_display_in_zone() {
    $("#nav_menu").dcVerticalMegaMenu({
        rowItems: "3",
        speed: "slow",
        effect: "slide",
        direction: "bottom"
    }), $(".nav_menu1").dcVerticalMegaMenu({
        rowItems: "3",
        speed: "slow",
        effect: "slide",
        direction: "bottom"
    }), $(".nav_menu2").dcVerticalMegaMenu({
        rowItems: "3",
        speed: "slow",
        effect: "slide",
        direction: "bottom"
    }), $("#nav_menu3").dcVerticalMegaMenu({
        rowItems: "3",
        speed: "slow",
        effect: "slide",
        direction: "bottom"
    })
}

function call_js_for_user_signup() {
    $("a.reg-window").click(function() {
        var a = $(this).attr("href"),
            b = jQuery(this).attr("Hidden_Value"),
            c = b.split(",");
        $("#resident_login_business_id").val(c[0]), $("#resident_login_ad_id").val(c[1]), $("#resident_login_zone_id").val(c[2]), $("#resident_login_type").val(c[3]), $(a).fadeIn(300);
        var d = ($(a).height() + 24) / 2,
            e = ($(a).width() + 24) / 2;
        return $(a).css({
            "margin-top": -d,
            "margin-left": -e
        }), $("#mask").fadeIn(300), !1
    })
}

function call_js_for_quick_access_in_zone() {
    $(document).on("click", "#create_links a", function() {
        var a = jQuery(this).attr("Atitle"),
            b = jQuery(this).attr("data-head");
        $("#quick_access_userid").val(a), $("#quick_access_zoneid").val(b);
        var c = $(this).attr("href");
        $(c).fadeIn(300);
        var d = ($(c).height() + 24) / 2,
            e = ($(c).width() + 24) / 2;
        return $(c).css({
            "margin-top": -d,
            "margin-left": -e
        }), $("body").append('<div id="mask"></div>'), $("#mask").fadeIn(300), view_all_with_popup_load(), !1
    })
}

function call_js_for_directory_search_in_zone() {
    $("a.search-window").click(function() {
        var a = jQuery(this).attr("Atitle");
        $("#zone_fav_userid").val(a), anish();
        var b = $(this).attr("href");
        $(b).fadeIn(300);
        var c = ($(b).height() + 24) / 2,
            d = ($(b).width() + 24) / 2;
        return $(b).css({
            "margin-top": -c,
            "margin-left": -d
        }), $("body").append('<div id="mask"></div>'), $("#mask").fadeIn(300), !1
    })
}

function call_js_for_email_offer_for_zone() {
    $("a.email-window").click(function() {
        var a = $(this).attr("href"),
            b = jQuery(this).attr("Atitle"),
            c = jQuery(this).attr("article123");
        $("#adId_hidden").val(b), $("#busId_hidden").val(c), $(a).fadeIn(300);
        var d = ($(a).height() + 24) / 2,
            e = ($(a).width() + 24) / 2;
        return $(a).css({
            "margin-top": -d,
            "margin-left": -e
        }), $("body").append('<div id="mask"></div>'), $("#mask").fadeIn(300), !1
    })
}

function call_js_for_email_offer_1_for_zone(a) {
    if ("directory-popup" == a) var b = "directory-popup";
    else var b = "email-popup";
    $("a.close, #mask").live("click", function() {
        return $("#mask , ." + b).fadeOut(300, function() {
            $("#mask").remove()
        }), !1
    })
}

function call_js_for_text_me_offer_for_zone() {
    $("a.sms-window").click(function() {
        var a = $(this).attr("href"),
            b = jQuery(this).attr("Atitle");
        $("#adId_hidden_sms").val(b), $(a).fadeIn(300);
        var c = ($(a).height() + 24) / 2,
            d = ($(a).width() + 24) / 2;
        return $(a).css({
            "margin-top": -c,
            "margin-left": -d
        }), $("body").append('<div id="mask"></div>'), $("#mask").fadeIn(300), !1
    }), $("a.login-window").click(function() {
        var a = $("#login-box");
        $(a).fadeIn(300);
        var b = ($(a).height() + 24) / 2,
            c = ($(a).width() + 24) / 2;
        return $(a).css({
            "margin-top": -b,
            "margin-left": -c
        }), $("body").append('<div id="mask"></div>'), $("#mask").fadeIn(300), !1
    })
}

function call_js_for_starter_ad_popup() {
    $("a.starter_ad_click").click(function() {
        var a = $(this).parents("div.otext").attr("rel"),
            b = $(this).parents("div.otext").data("adid"),
            c = $(this).attr("href");
        $("#business_id_hidden").val(a), $("#ad_id_hidden").val(b), $(c).fadeIn(300);
        var d = ($(c).height() + 24) / 2,
            e = ($(c).width() + 24) / 2;
        return $(c).css({
            "margin-top": -d,
            "margin-left": -e
        }), $("body").append('<div id="mask"></div>'), $("#mask").fadeIn(300), !1
    })
}

function call_js_for_rating(a, b, c) {
    $(".rating1 .rating").jRating({
        bigStarsPath: "/assets/stylesheets/icons/stars1.png",
        length: 5,
        decimalLength: 1,
        rateMax: 5,
        isDisabled: !0
    }), $(".ratingcomment .rating").jRating({
        bigStarsPath: "/assets/stylesheets/icons/stars1_transparent.png",
        length: 5,
        decimalLength: 1,
        rateMax: 5,
        isDisabled: !0
    }), $(".rating2 .rating").jRating({
        bigStarsPath: "../../assets/stylesheets/icons/stars.png",
        length: 5,
        decimalLength: 1,
        rateMax: 5,
        canRateAgain: !0,
        phpPath: baseurl + "ads/ratead",
        zone_id: a,
        user_id: b,
        bus_id: c,
        onSuccess: function(a, b) {
            b.next(".datasSent").find(".avg_rating").text(a.rate), confirmComment(a.busId, a.userId, a.zone_id)
        },
        onError: function() {
            alert("Error : please retry")
        }
    })
}

function call_AddThis_plugin() {}

function call_for_show_moreless() {
    $.each($(".addoffer_left_image_part"), function(a, b) {
        var c = $(b).closest(".ui-tabs-panel");
        parseFloat($(b).css("height")) >= 500 ? ($(b).css("max-height", "500px").show(), 0 == c.find(".testclass").hasClass("show_more") && c.find(".testclass").removeClass("show_less").addClass("show_more").find("h3").html("Show More.."), c.find(".show_more").show()) : 1 == c.find(".testclass").hasClass("show_less") ? c.find(".show_less").removeClass("show_less").addClass("show_more").find("h3").html("Show More..") : ($(b).show(), c.find(".show_more").hide())
    })
}
var activeCategory = 1,
    name = "#phone",
    announce = 0,
    menuYloc = null;
$(document).ready(function() {

       /* $("#benefits-manager > h3 > a, #benefits-ss > h3 > a").on('click', function(e) {
            e.preventDefault();
            $ele = $(this).parent().parent().find(".benefits-body");
            if ($ele.hasClass("open")) {
                $ele.removeClass("open");
                $(this).text("Open");
            } else {
                $ele.addClass("open");
                $(this).text("Close");
            }
        });
*/        
   $(".benefits-menu h3 > a").on('click', function(e) {
        e.preventDefault();
        $id = $(this).data("id");
        $ele = $("#" + $id).find(".benefits-body");
        if($ele.hasClass("open")){
            $ele.removeClass("open");
            //$(this).text("Open");
        }else{
            $ele.addClass("open");
            //$(this).text("Close");
        }
    });

    $(".toggle-container > h3 > a").on('click', function(e) { 
        e.preventDefault();        
        $ele = $(this).parent().parent().find(".toggle-body");
        $target = $(this).parent().parent().attr("id"); //alert($target);
        if($ele.hasClass("open")){
            $ele.removeClass("open");
            $ele.hide('slow');
            $(this).text("Open");
            $("a[data-target='"+$target+"']").removeClass('active');
        }else{
            $ele.addClass("open");
            $ele.show('slow');
            $("a[data-target='"+$target+"']").addClass('active');
            $(this).text("Close");
        }
    });
    // jQuery(".toggle-btn").on('click', function(e) {
    //     e.preventDefault();
    //     $target = $("#" + $(this).data("target"));
    //     if($target){
    //         $ele = $target.find(".toggle-body");
    //         if(jQuery(this).hasClass('active')){
    //             $ele.hide('slow');
    //             jQuery(this).removeClass('active');
    //             $ele.removeClass("open");
    //             $target.find(" > h3 > a").text("Open");
    //             jQuery("#searchPanels1").hide('slow');
    //             jQuery("#searchPanels1").removeClass("open");
    //         }else{
    //             $ele.show('slow');
    //             jQuery(this).addClass('active');
    //             $ele.addClass("open");
    //             $target.find(" > h3 > a").text("Close");
    //             jQuery("#searchPanels1").show('slow');
    //             jQuery("#searchPanels1").addClass("open");
    //             $('html, body').stop().animate({
    //               'scrollTop': jQuery("#searchPanels1").offset().top-40
    //                 }, 900, 'swing', function () {
                    
    //             });
    //             $('html, body').stop().animate({
    //               'scrollTop': $target.offset().top-40
    //                 }, 900, 'swing', function () {
                    
    //             });
    //         }
    //     }
    // });

    $("#snapDining").on('click',function(e){ 
        e.preventDefault();        
        $ele = $("#dinings-toggle > h3 > a").parent().parent().find(".toggle-body");
        $target = $("#dinings-toggle > h3 > a").parent().parent().attr("id"); //alert($target);
        if($ele.hasClass("open")){
            $ele.removeClass("open");
            $ele.hide('slow');
            $("#dinings-toggle > h3 > a").text("Open");
            $("a[data-target='"+$target+"']").removeClass('active');
            jQuery("#searchPanels1").hide('slow');
            jQuery("#searchPanels1").removeClass("open");
        }else{
            $ele.addClass("open");
            $ele.show('slow');
            $("a[data-target='"+$target+"']").addClass('active');
            $("#dinings-toggle > h3 > a").text("Close");
            jQuery("#searchPanels1").show('slow');
            jQuery("#searchPanels1").addClass("open");
            $('html, body').stop().animate({
              'scrollTop': jQuery("#searchPanels1").offset().top-40
                }, 900, 'swing', function () {
                
            });
            $('html, body').stop().animate({
              'scrollTop': $target.offset().top-40
                }, 900, 'swing', function () {
                
            });
        }

    });

    $(document).on('click','#snapD',function(e){       
        
        e.preventDefault();        
        $ele = $("#dinings-toggle > h3 > a").parent().parent().find(".toggle-body");
        $target = $("#dinings-toggle > h3 > a").parent().parent().attr("id"); //alert($target);
        if($ele.hasClass("open")){
            $ele.removeClass("open");
            $ele.hide('slow');
            $("#dinings-toggle > h3 > a").text("Open");
            $("a[data-target='"+$target+"']").removeClass('active');
            jQuery("#searchPanels1").hide('slow');
            jQuery("#searchPanels1").removeClass("open");
        }else{
            $ele.addClass("open");
            $ele.show('slow');
            $("a[data-target='"+$target+"']").addClass('active');
            $("#dinings-toggle > h3 > a").text("Close");
            jQuery("#searchPanels1").show('slow');
            jQuery("#searchPanels1").addClass("open");
            $('html, body').stop().animate({
              'scrollTop': jQuery("#searchPanels1").offset().top-40
                }, 900, 'swing', function () {
                
            });
            $('html, body').stop().animate({
              'scrollTop': $target.offset().top-40
                }, 900, 'swing', function () {
                
            });
        }
    });

    $("#snapFilters").on('click',function(e){
        e.preventDefault();        
        $ele = $("#snap-toggle > h3 > a").parent().parent().find(".toggle-body");
        $target = $("#snap-toggle > h3 > a").parent().parent().attr("id"); //alert($target);
        if($ele.hasClass("open")){
            $ele.removeClass("open");
            $ele.hide('slow');
            $("#snap-toggle > h3 > a").text("Open");
            $("a[data-target='"+$target+"']").removeClass('active');
            jQuery("#searchPanels1").hide('slow');
            jQuery("#searchPanels1").removeClass("open");
        }else{
            $ele.addClass("open");
            $ele.show('slow');
            $("a[data-target='"+$target+"']").addClass('active');
            $("#snap-toggle > h3 > a").text("Close");
            jQuery("#searchPanels1").show('slow');
            jQuery("#searchPanels1").addClass("open");
            $('html, body').stop().animate({
              'scrollTop': jQuery("#searchPanels1").offset().top-40
                }, 900, 'swing', function () {
                
            });
            $('html, body').stop().animate({
              'scrollTop': $target.offset().top-40
                }, 900, 'swing', function () {
                
            });
        }

    });

    $(".pbooAuctions").on('click',function(e){
        e.preventDefault();        
        $ele = $("#peek-toggle > h3 > a").parent().parent().find(".toggle-body");
        $target = $("#peek-toggle > h3 > a").parent().parent().attr("id"); //alert($target);
        if($ele.hasClass("open")){
            $ele.removeClass("open");
            $ele.hide('slow');
            $("#peek-toggle > h3 > a").text("Open");
            $("a[data-target='"+$target+"']").removeClass('active');
            jQuery("#searchPanels1").hide('slow');
            jQuery("#searchPanels1").removeClass("open");
        }else{
            $ele.addClass("open");
            $ele.show('slow');
            $("a[data-target='"+$target+"']").addClass('active');
            $("#peek-toggle > h3 > a").text("Close");
            jQuery("#searchPanels1").show('slow');
            jQuery("#searchPanels1").addClass("open");
            $('html, body').stop().animate({
              'scrollTop': jQuery("#searchPanels1").offset().top-40
                }, 900, 'swing', function () {
                
            });
            $('html, body').stop().animate({
              'scrollTop': $target.offset().top-40
                }, 900, 'swing', function () {
                
            });
        }

    });
/**
        $("#phoneWrapper").addFloating({
                targetLeft: 10,
                targetBottom: 5,
                snap: !0
            }), $("#left-container").addFloating({
                targetLeft: 10,
                targetBottom: 150,
                snap: !0
            }), $("#slider").nivoSlider(), $("#mega-menu-1").dcMegaMenu(), $(".announceWrapper a:eq(0)").addClass("announceActive").next(".contactemail").addClass("active"), $(".announceWrapper a:eq(0)").attr("style", "font-size:1.2em;"), $(".announceWrapper a.title").click(function(a) {

	if ($("#phoneWrapper").length > 0){
		
	}
	
	
        $(".announceWrapper a:eq(0)").addClass("announceActive").next(".contactemail").addClass("active"), $(".announceWrapper a:eq(0)").attr("style", "font-size:1.2em;"), $(".announceWrapper a.title").click(function(a) {
>>>>>>> 10833487fd1df898df2a7a02a0398d84acda3409
                return $(this).animate({
                    fontSize: "14px"
                }, {
                    queue: !0,
                    duration: 300
                }, function() {
                    $(this).animate({
                        fontSize: "14px"
                    }, {
                        queue: !0,
                        duration: 200
                    })
                }), $(".announceWrapper a").removeClass("announceActive").next(".contactemail").removeClass("active"), $(".announceWrapper a").attr("style", ""), announce = $("#area-organization .announceWrapper a").index(this), $(this).addClass("announceActive").next(".contactemail").addClass("active"), $(".announceWrapper a").attr("style", ""), announce = $("#area-organization .announceWrapper a").index(this), $(this).addClass("announceActive").next(".contactemail").addClass("active"), $(".orgbannermain").hide("slow"), $(".orgbannermain1").addClass("withbg"), $(".orgbannermain1").html('<h2 class="text-center">Athena Esolution</h2><p>You can also receive EmailNotices from this Organization sent by SavingsSites,<br>therefore your email address will not be provided to the Organization! <a class="contactemail" href="javascript:void(0)" onclick="clicksnapsignup(&quot;31&quot;,&quot;1&quot;,&quot;3&quot;,&quot;&quot;,&quot;snap&quot;);">HERE</a></p><ul class="menuH decor1 col-sm-6 col-md-4 col-xs-12 col-lg-4"><li id="main_subcat_2" class="main_subcat col-md-4 col-sm-6 col-xs-12"><a class="arrow subcat" data-head="2" data-times="40" data-toggle="modal" data-target="#org-pop-box1">Summer</a></li><li id="main_subcat_8" class="main_subcat col-md-4 col-sm-6 col-xs-12"><a class="arrow subcat" data-head="8" data-times="40" data-toggle="modal" data-target="#org-pop-box1">Blood Donation</a></li><li id="main_subcat_23" class="main_subcat col-md-4 col-sm-6 col-xs-12"><a class="arrow subcat" data-head="23" data-times="40" data-toggle="modal" data-target="#org-pop-box1">Calendar cat</a></li></ul>'), $(".orgbannermain1 > h2").text($(this).text()), $(this).animate({
                    fontSize: "1.2em",
                    opacity: .5
                }, 200, function() {
                    $(this).animate({
                        opacity: 1
                    }, 200)
                }), !1
            }), $(".announceWrapper a.contactemail").click(function(a) {
                return $(this).animate({
                    fontSize: "14px"
                }, {
                    queue: !0,
                    duration: 300
                }, function() {
                    $(this).animate({
                        fontSize: "14px"
                    }, {
                        queue: !0,
                        duration: 200
                    })
                }), $(".announceWrapper a").removeClass("active").prev(".title").removeClass("announceActive"), $(".announceWrapper a").attr("style", ""), $(this).addClass("active").prev(".title").addClass("announceActive"), $(this).animate({
                    fontSize: "1.2em",
                    opacity: .5
                }, 200, function() {
                    $(this).animate({
                        opacity: 1
                    }, 200)
                }), !1
            }), $("#select_theme").change(function() {
                var a = $("select#select_theme option:selected").val();
                return $("link#switcher").attr("href", "stylesheets/style_" + a + "/styles.css"), $("#ssfb").attr("src", "images/ssfb_maroon.png"), $("#ssgp").attr("src", "images/ssgp_maroon.png"), $("#sstt").attr("src", "images/sstw_maroon.png"), 1 == a && ($("#ssfb").attr("src", "images/ssfb_gold.png"), $("#ssgp").attr("src", "images/ssgp_gold.png"), $("#sstt").attr("src", "images/sstw_gold.png")), 2 == a && ($("#ssfb").attr("src", "images/ssfb_white.png"), $("#ssgp").attr("src", "images/ssgp_white.png"), $("#sstt").attr("src", "images/sstw_white.png")), !1
            }), $("#phClose").click(function() {
                $("#phoneWrapper").hide()
            }), $(".mega-menu .sub li.mega-hdr li a").addGlow({
                textColor: "#fff",
                haloColor: "#fff",
                radius: 100
            }), $("ul.mega-menu li a").hover(function() {
                $(this).find(".dc-mega-li").stop().animate({
                    width: "100%"
                }, {
                    queue: !1,
                    duration: 300
                })
            }, function() {
                $(this).find(".dc-mega-li").stop().animate({
                    width: "0px"
                }, {
                    queue: !1,
                    duration: 300
                })
            }),
            $("#atozBusiness a").hover(
                function() {
                    $(this).find(".sub-container").stop().animate({
                        width: "100%"
                    }, {
                        queue: !1,
                        duration: 300
                    })
                }),
            $("#social_home").css({
                opacity: 1
            }), $("#social_home").hover(function() {
                $(this).animate({
                    top: "-15"
                }), $(this).css({
                    opacity: 1
                })
            }, function() {
                $(this).animate({
                    top: "0"
                }), $(this).css({
                    opacity: 1
                })
            }), $("#social_face").css({
                opacity: 1
            }), $("#social_face").hover(function() {
                $(this).animate({
                    top: "-15"
                }), $(this).css({
                    opacity: 1
                })
            }, function() {
                $(this).animate({
                    top: "0"
                }), $(this).css({
                    opacity: 1
                })
            }), $("#social_goo").css({
                opacity: 1
            }), $("#social_goo").hover(function() {
                $(this).animate({
                    top: "-15"
                }), $(this).css({
                    opacity: 1
                })
            }, function() {
                $(this).animate({
                    top: "0"
                }), $(this).css({
                    opacity: 1
                })
            }), $("#social_twee").css({
                opacity: 1
            }), $("#social_twee").hover(function() {
                $(this).animate({
                    top: "-15"
                }), $(this).css({
                    opacity: 1
                })
            }, function() {
                $(this).animate({
                    top: "0"
                }), $(this).css({
                    opacity: 1
                })
            }), $("#social_home").css({
                opacity: 1
            }), $("#social_home").hover(function() {
                $(this).animate({
                    top: "-15"
                }), $(this).css({
                    opacity: 1
                })
            }, function() {
                $(this).animate({
                    top: "0"
                }), $(this).css({
                    opacity: 1
                })
            }), $(".header-business-back a").click(function() {
                return $("body,html").animate({
                    scrollTop: 0
                }, 600), !1
            }), $("#ratingpage").live("click", function() {
                var a = $("#ratingpagewith");
                $(a).fadeIn(300);
                var b = ($(a).height() + 24) / 2,
                    c = ($(a).width() + 24) / 2;
                return $(a).css({
                    "margin-top": -b,
                    "margin-left": -c
                }), !1
            }), $("a.contact-window").click(function() {
                var a = $("#contact-box");
                return $(a).fadeIn(300), !1
            }), $("a.close, #mask").live("click", function() {
                return $("#mask , .email-popup").fadeOut(300, function() {
                    $("#mask").remove()
                }), !1
            }), $(".fontMgr").click(function(a) {
                "none" == $(".fontchanger").css("display") ? $(".fontchanger").slideDown("fast") : $(".fontchanger").slideUp("fast"), a.preventDefault()
            });
            */
        var a = "Roboto Slab",
            b = "1.0em",
            c = "100%";
        $("#fontchange").click(function(b) {
            b.preventDefault();
            var c = "1.0em";
            "Roboto Slab" == a ? a = "Rosario" : "Rosario" == a ? (a = "Economica", c = "1.2em") : "Economica" == a ? a = "Amarante" : "Amarante" == a ? (a = "Aladin", c = "1.3em") : a = "Aladin" == a ? "Oswald" : "Oswald" == a ? "Arial" : "Arial" == a ? "Georgia" : "Georgia" == a ? "Amaranth" : "Amaranth" == a ? "Open Sans" : "Roboto Slab", $(".mega-menu").css("font-size", c), $(".mega-menu").css("font-family", a), $(".otext").css("font-family", a), $(".announceWrapper a.title").css("font-family", a), $(".announceWrapper a.title announceActive").css("font-family", a), $(this).attr("title", "Change Nav Menu and Org Font - " + a)
        }), $("#textchange").click(function(a) {
            a.preventDefault(), b = "1.0em" == b ? "1.1em" : "1.1em" == b ? "1.2em" : "1.2em" == b ? "1.3em" : "1.3em" == b ? "1.4em" : "1.4em" == b ? "1.5em" : "1.5em" == b ? "1.8em" : "1.8em" == b ? "2.0em" : "2.0em" == b ? "0.9em" : "1.0em", $(".otext").children().css("font-size", b)
        }), $("#linechange").click(function(a) {
            a.preventDefault(), c = "100%" == c ? "110%" : "110%" == c ? "120%" : "120%" == c ? "150%" : "150%" == c ? "175%" : "175%" == c ? "200%" : "100%", $(".otext").children().css("line-height", c)
        }), $.fn.user_selected_directory = function() {
            if (null != $.cookie("font_info")) {
                var a = $.cookie("font_info"),
                    b = a.split("~!~")[1],
                    c = a.split("~!~")[0];
                $(document).find("#user_selected_font").remove(), $("body").append('<style type="text/css" id="user_selected_font">\t.mega-menu{ font-size:' + b + ";font-family:" + c + "}\t.otext {font-family:" + c + "}\t.announceWrapper a.title{font-family:" + c + "}\t</style>")
            }
            if (null != $.cookie("text_info")) {
                var d = $.cookie("text_info"),
                    e = d.split("~!~")[0];
                $(document).find("#user_selected_text").remove(), $("body").append('<style type="text/css" id="user_selected_text">\t\t\t.otext *{font-size:' + e + " !important;}\t</style>")
            }
            if (null != $.cookie("line_info")) {
                var f = $.cookie("line_info"),
                    g = f.split("~!~")[0];
                $(document).find("#user_selected_line").remove(), $("body").append('<style type="text/css" id="user_selected_line">\t\t\t.otext *{line-height:' + g + " !important;}\t</style>")
            }
        }, $.fn.user_selected_directory(), $("#fontchange").click(function(b) {
            b.preventDefault();
            var c = "1.0em";
            $(".mega-menu").css("font-size", c), $(".mega-menu").css("font-family", a), $(".otext").css("font-family", a), $(".announceWrapper a.title").css("font-family", a), $.cookie("font_info", a + "~!~" + c), $.fn.user_selected_directory()
        }), $("#textchange").click(function(a) {
            a.preventDefault(), b = "1.0em" == b ? "1.1em" : "1.1em" == b ? "1.2em" : "1.2em" == b ? "1.3em" : "1.3em" == b ? "1.4em" : "1.4em" == b ? "1.5em" : "1.5em" == b ? "1.8em" : "1.8em" == b ? "2.0em" : "2.0em" == b ? "0.9em" : "1.0em", $.cookie("text_info", b + "~!~"), $.fn.user_selected_directory()
        }), $("#linechange").click(function(a) {
            a.preventDefault(), c = "100%" == c ? "110%" : "110%" == c ? "120%" : "120%" == c ? "150%" : "150%" == c ? "175%" : "175%" == c ? "200%" : "100%", $.cookie("line_info", c + "~!~"), $.fn.user_selected_directory()
        })
         /* Start of  Clicking on slider button functionality 22/02/2018 */
         var panelToggle = function(){
        var width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
        if(width > 767){
            $("#area-category").show('fast');
            $("#area-business5").show('fast'); 
        }else {
            $(".mobilePanel a.logo").removeClass('active');
            $("#area-category").show('fast');
            $("#area-business5").hide('fast'); 
            $(".mobilePanel a[data-type='ss']").addClass('active');
        }
            
    };
    panelToggle();
        
    $(window).resize(function() {
          panelToggle();
    });
    
    $('.toggleButtons').bind('click.smoothscroll',function (e) {
        e.preventDefault();
        var target = this.hash,
            $target = $(target);
        console.log($target.length);
        if($target.length){
            $('html, body').stop().animate({
              'scrollTop': $target.offset().top-40
                }, 900, 'swing', function () {
                
            });
        }
    }); 
    
    $('a.panelsButton').bind('click.smoothscroll',function (e) {
        e.preventDefault();
        var target = this.hash,
            $target = $(target);
        console.log($target.length);
        if($target.length){
            jQuery('ul.sf-menu > li ul').hide('fast');
            $("#searchPanels").show('slow');
            $('html, body').stop().animate({
              'scrollTop': $target.offset().top-40
                }, 900, 'swing', function () {
                
            });
        }
    }); 
    
    /*$('a.benefitsButton').bind('click',function (e) {*/
    $(document).on('click','a.benefitsButton',function(e) {
        e.preventDefault();
        var target = this.hash,
            $target = $(target);
        $tab = 1;       
        if($(this).data('tab') !== undefined){            
            $tab = $(this).data('tab');
        }
        console.log($tab);
        var tabId = "#tab-11"+$tab;
        if($target.length){
            var $navLiElement = $target.find("ul.nav li");
           /* alert($navLiElement.attr('class'));
            alert($navLiElement.find('a[href="' + tabId + '"]').attr('href'));*/

            $target.find("ul.nav-tabs li").removeClass("active");
            $target.find(".tab-content .tab-pane").removeClass("active");
            $target.find(".tab-content .tab-pane").removeClass("in");
            $target.find("ul.nav-tabs li.residents").addClass("active");
            /*$target.find(".tab-content #tab-111").addClass("active");
            $target.find(".tab-content #tab-111").addClass("in");*/
            $target.find(".tab-content "+tabId).addClass("active");
            $target.find(".tab-content "+tabId).removeClass('fade').addClass("in");
            $target.find('ul.nav-tabs li:eq('+$tab+') a').tab('show');
            $ele = $target.find(".benefits-body");
            if(!$ele.hasClass("open")){
                $ele.addClass("open");
                $target.find(">h3>a").text("Close");
            }
            $('html, body').stop().animate({
              'scrollTop': $target.offset().top-40
                }, 900, 'swing', function () {
                
            });
        }
    }); 
         /* End of Clicking on slider button functionality 22/02/2018 */
    });
   $(document).on("click", "a.hrsoperation", function() {
        var a = $(this).attr("href"),
            b = $(this).attr("data-appointment"),
            c = $(this).attr("data-monday_timing_from").split("#"),
            c = $(this).attr("data-monday_timing_from").split("#"),
            d = $(this).attr("data-monday_timing_to").split("#"),
            e = $(this).attr("data-monday_add_text"),
            f = $(this).attr("data-tuesday_timing_from").split("#"),
            g = $(this).attr("data-tuesday_timing_to").split("#"),
            h = $(this).attr("data-tuesday_add_text"),
            i = $(this).attr("data-wednessday_timing_from").split("#"),
            j = $(this).attr("data-wednessday_timing_to").split("#"),
            k = $(this).attr("data-wednessday_add_text"),
            l = $(this).attr("data-thursday_timing_from").split("#"),
            m = $(this).attr("data-thursday_timing_to").split("#"),
            n = $(this).attr("data-thursday_add_text"),
            o = $(this).attr("data-friday_timing_from").split("#"),
            p = $(this).attr("data-friday_timing_to").split("#"),
            q = $(this).attr("data-friday_add_text"),
            r = $(this).attr("data-saturday_timing_from").split("#"),
            s = $(this).attr("data-saturday_timing_to").split("#"),
            t = $(this).attr("data-saturday_add_text"),
            u = $(this).attr("data-sunday_timing_from").split("#"),
            v = $(this).attr("data-sunday_timing_to").split("#"),
            w = $(this).attr("data-sunday_add_text");
        $(this).attr("data-timezonename");
        return "" != b ? $("#business_appointment").html(b) : $("#business_appointment").html("Nothing"), 0 != c && 0 != d && "closed" != c[0] && "closed" != d[0] ? $("#monday_timing").html(c[0] + ":" + c[1] + " " + c[2] + " to " + d[0] + ":" + d[1] + " " + d[2] + "<br/>" + e) : $("#monday_timing").html("Closed"), 0 != f && 0 != g && "closed" != f[0] && "closed" != g[0] ? $("#tuesday_timing").html(f[0] + ":" + f[1] + " " + f[2] + " to " + g[0] + ":" + g[1] + " " + g[2] + "<br/>" + h) : $("#tuesday_timing").html("Closed"), 0 != i && 0 != j && "closed" != i[0] && "closed" != j[0] ? $("#wednessday_timing").html(i[0] + ":" + i[1] + " " + i[2] + " to " + j[0] + ":" + j[1] + " " + j[2] + "<br/>" + k) : $("#wednessday_timing").html("Closed"), 0 != l && 0 != m && "closed" != l[0] && "closed" != m[0] ? $("#thursday_timing").html(l[0] + ":" + l[1] + " " + l[2] + " to " + m[0] + ":" + m[1] + " " + m[2] + "<br/>" + n) : $("#thursday_timing").html("Closed"), 0 != o && 0 != p && "closed" != o[0] && "closed" != p[0] ? $("#friday_timing").html(o[0] + ":" + o[1] + " " + o[2] + " to " + p[0] + ":" + p[1] + " " + p[2] + "<br/>" + q) : $("#friday_timing").html("Closed"), 0 != r && 0 != s && "closed" != r[0] && "closed" != s[0] ? $("#saturday_timing").html(r[0] + ":" + r[1] + " " + r[2] + " to " + s[0] + ":" + s[1] + " " + s[2] + "<br/>" + t) : $("#saturday_timing").html("Closed"), 0 != u && 0 != v && "closed" != u[0] && "closed" != v[0] ? $("#sunday_timing").html(u[0] + ":" + u[1] + " " + u[2] + " to " + v[0] + ":" + v[1] + " " + v[2] + "<br/>" + w) : $("#sunday_timing").html("Closed"), $(a).find("h1").html($(this).attr("data-title")), !1
    }),
    function(a) {
        a.fn.UItoTop = function(b) {
            var c = {
                    text: "",
                    min: 500,
                    scrollSpeed: 800,
                    containerID: "toTop",
                    containerClass: "fa fa-arrow-circle-o-up",
                    easingType: "linear"
                },
                d = a.extend(c, b),
                e = "#" + d.containerID;
            d.containerHoverID;
            a("body").append('<a href="#" id="' + d.containerID + '" class="' + d.containerClass + '" >' + d.text + "</a>"), a(e).hide().click(function() {
                return a("html, body").stop().animate({
                    scrollTop: 0
                }, d.scrollSpeed, d.easingType), a("#" + d.containerHoverID, this).stop().animate({
                    opacity: 0
                }, d.inDelay, d.easingType), !1
            }), a(window).scroll(function() {
                var b = a(window).scrollTop();
                void 0 === document.body.style.maxHeight && a(e).css({
                    position: "absolute",
                    top: a(window).scrollTop() + a(window).height() - 50
                }), b > d.min ? a(e).stop(!0, !0).fadeIn(600) : a(e).fadeOut(800)
            })
        }
    }(jQuery), jQuery(function(a) {
        a().UItoTop({
            easingType: "easeOutQuart"
        })

    });