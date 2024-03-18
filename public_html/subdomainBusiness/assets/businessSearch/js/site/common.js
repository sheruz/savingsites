var link_path, base_url, zoneId, user_id, user_type;
$(document).ready(function(){
    $(".themeswitcher .dropdown-menu a").on('click', function(e) {
        e.preventDefault();
        var parent = $('#themeswitcher');
        // parent.dropdown('toggle');
        parent.attr('data-theme', $(this).data('theme'));
        parent.text($(this).text());
        changeTheme($(this).data('theme'), $(this).text(), parent.data('version'));         
        return false;
    });
});

function changeTheme(sel, title, version){ //alert(title); 
    $(".linkedcss").attr('href', link_path+"/assets/directory/css/theme-"+sel+".css");
    $(".rd-navbar-brand img").attr('src', link_path+"/assets/directory/images/logo-"+sel+".png");
    var data_to_use={
        'business_theme': sel,
        'business_title': title
    };
    $.ajax({
        type : 'POST',
        url : "/changetheme",
        data: data_to_use,
        success : function(data){
            location.reload();
        },
        error : function(XMLHttpRequest, textStatus, errorThrown){}
    });
}
// $(document).ready((function() {
//     link_path = $("input[name=link_path]").val(), base_url = $("input[name=base_url]").val(), zoneId = $("input[name=zoneid]").val(), user_id = $("input[name=user_id]").val(), user_type = $("input[name=user_type]").val(), $(".homelink").click((function(e) {
//         location.reload()
//     })), $(".benefitslink").click((function(e) {
//         $(".about-view").show(), $(".slider-view").hide(), $.ajax({
//             url: base_url + "zone/about",
//             type: "POST",
//             async: !1,
//             beforeSend: function() {
//                 $(".about-view").show()
//             },
//             success: function(e) {
//                 console.log(e), $(".about-view").html(e)
//             }
//         })
//     })), jQuery(".themeswitcher .dropdown-menu a").on("click", (function(e) {
//         e.preventDefault();
//         // var n = $("#themeswitcher");
//         return n.dropdown("toggle"), n.attr("data-theme", $(this).data("theme")), n.text($(this).text()),
//             function(e, n, s) {
//                 $("#selThemes").attr("href", link_path + "assets/businessSearch/css/theme-" + e + ".css"), $(".header-top .rd-navbar-brand img").attr("src", link_path + "assets/businessSearch/images/logo-blue.png");
//                 var i = {
//                     business_theme: e,
//                     business_title: n
//                 };
//                 $.ajax({
//                     type: "POST",
//                     url: "/changetheme",
//                     data: i,
//                     success: function(e) {$(".linkedcss").attr("href", base_url+'/assets/SavingsCss/theme-'+i.business_theme+'.css');},
//                     error: function(e, n, s) {}
//                 })
//             }($(this).data("theme"), $(this).text(), n.data("version")), !1
//     })), $(".aboutlink").click((function(e) {
//         $(".benefits-view").show(), $(".slider-view").hide(), $(".about-view").hide(), $(".sub-banner").hide(), $(".sponsor-header").hide(), $(".outerofferdiv").hide(), $.ajax({
//             url: base_url + "zone/benefits",
//             type: "POST",
//             async: !1,
//             beforeSend: function() {
//                 $(".benefits-view").show()
//             },
//             success: function(e) {
//                 $(".benefits-view").html(e)
//             }
//         })
//     })), $(".organization").click((function(e) {
//         $(".benefits-view").show(), $(".about-view").hide(), $(".sponsor-header").hide();
//         var n = {
//             zone_id: zoneId
//         };
//         $.ajax({
//             url: base_url + "zone/organization",
//             type: "POST",
//             data: n,
//             async: !1,
//             beforeSend: function() {},
//             success: function(e) {
//                 $(".organization-view").html(e)
//             }
//         })
//     })), $(".high-school").click((function(e) {
//         $(".benefits-view").show(), $(".about-view").hide(), $(".sponsor-header").hide();
//         var n = {
//             zone_id: zoneId
//         };
//         $.ajax({
//             url: base_url + "zone/hs_sports",
//             type: "POST",
//             data: n,
//             async: !1,
//             beforeSend: function() {},
//             success: function(e) {
//                 $(".highschoolsports-view").html(e)
//             }
//         })
//     })), $(document).on("click", ".current_email_button", (function() {
//         var e = $(this).attr("id"),
//             n = $("#name_email_" + e).val();
//         /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/.test(n) ? $.ajax({
//             url: base_url + "zone/new_email_offer",
//             type: "POST",
//             dataType: "json",
//             data: {
//                 emailAddress: n,
//                 adId: e
//             },
//             success: function(n) {
//                 n.get_login_details ? ($("#name_email_" + e).css({
//                     display: "none"
//                 }), $("#response_get_" + e).html(n.message)) : ($("#response_get_" + e).html(n.message), $("#name_email_" + e).removeAttr("style"))
//             }
//         }) : $("#name_email_" + e).css({
//             border: "solid 3px red"
//         })
//     })), $(".snapDining").click((function() {
//         var e = base_url + "snapDining/dining/" + zoneId;
//         window.open(e, "_self")
//     })), $(".peekaboo").click((function() {
//         var e = "http://www.peekabooauctions.com/index.php?zoneid=" + zoneId;
//         window.open(e, "_self")
//     })), $(".webinar").click((function() {
//         var e = base_url + "educational_webinar/webinar/" + zoneId;
//         window.open(e, "_self")
//     })), $(".busines_search").click((function() {
//         var e = base_url + "businessSearch/search/" + zoneId;
//         window.open(e, "_self")
//     })), $(".hoverAnim img").hover((function() {
//         $(this).attr("src", "http://savingssites.com/assets/businessSearch/images/business_search_1.jpg")
//     })), $(".hoverAnim img").mouseleave((function() {
//         $(this).attr("src", "http://savingssites.com/assets/businessSearch/images/business_search_0.jpg")
//     }))
// }));