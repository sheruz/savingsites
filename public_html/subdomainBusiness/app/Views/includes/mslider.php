<?php  $useragent=$_SERVER['HTTP_USER_AGENT'];  
  function checkExternalFile($url){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $retCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $retCode;
  }?>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css">
<style>
    .main-slider-area {
    overflow: hidden;
    display: block;
    position: relative;
    z-index: 0;
}


html,
body {}


img {
    max-width: 100%;
    height: auto;
}

@font-face {
    font-family: 'rajdhanibold';
    src: url('https://muniblasts.com/assets/fonts/rajdhani-bold.woff2') format('woff2'),
         url('https://muniblasts.com/assets/fonts/rajdhani-bold.woff') format('woff');
    font-weight: normal;
    font-style: normal;

}

/* box layout */

.box.wrapper {
    max-width: 1200px;
    margin: auto;
    background: #fff;
    box-shadow: 0px 0px 5px #ddd;
}

.wow.slideInLeft p{ padding-left: 0px !important;  }
.signup_breatcome{ background: #0d2352 !important; }
.signup_breatcome .breatcome_title_inner{ text-align: center; }
.signup_breatcome .breatcome_title_inner img{ width: 160px; }
.signup_breatcome .breatcome_title_inner h3{ color: #fff; font-size: 20px; }
.signup_breatcome .breatcome_title_inner p{ color: #fff;  }
#sign_up .signup_form{ background: #0d2352; width: 70%; margin: 0px auto; padding: 40px; }
#sign_up h1{ text-align: center; margin-bottom: 30px; }
.bv_label{ color: #fff; padding-bottom: 6px; font-size: 18px;}
#sign_up .signup_form .form-control{ height: 40px;  }
#sign_up .signup_form .form-group-left{ width: 48%; float: left; }
#sign_up .signup_form .form-group-right{ width: 48%; float: right; }
#sign_up .signup_form .form-group select{ height: 40px; width: 100%;}
#sign_up .signup_form .form-group span{ color: #fff; padding-top: 10px; float: left; width: 100%; }
#sign_up .signup_form .form-group textarea{ width: 100%;  }
#sign_up .signup_form #signup{ margin-top: 30px; background: #fff; text-transform: uppercase; font-weight: 600; font-size: 16px; }
.microsoft_email{ padding: 60px 0px;      background: #f7f7f7; }

.microsoft_email .row,.microsoft_email2 .row{ display: flex; flex-wrap: wrap; }
.microsoft_email .row .align-self-center,.microsoft_email2 .row .align-self-center{ align-self: center; }
.microsoft_email .row h1,.microsoft_email2 .row h1{  margin-bottom: 10px;  color: #454545; font-size: 37px; line-height: 60px;  }
.microsoft_email .row h1:before,.microsoft_email2 .row h1:before{ content: none !important; }
.microsoft_email .row .desc,.microsoft_email2 .row .desc{ font-size: 16px; line-height: 30px; color: #555; }
.microsoft_email .row .desc p,.microsoft_email2 .row .desc p{ font-weight: 500 !important; }
.microsoft_email2{ padding: 60px 0px;      background: #fff; }
.whitelistemails_section{ text-align: center; }
.whitelistemails_section p{    font-weight: 500;  margin-top: 17px; font-size: 16px; line-height: 30px;color: #555; }
.whitelistemails_section h2{ font-size: 60px; font-weight: bold !important; color: #454545; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 0px; margin-bottom: 0px; font-family: 'rajdhanibold'; }
.whitelistemails_section h3{ color: #d12929; font-family: 'rajdhanibold'; font-size: 31px; line-height: 37px; font-weight: bold; }    
#white_list{ padding: 60px 0px;  }
.whitelistemails_section img{ margin: 20px auto; }

.microsoft_email .row h3,.microsoft_email2 .row h3{ position: relative; font-size: 30px;     margin-bottom: 40px; }
.microsoft_email .row h3::before,.microsoft_email2 .row h3::before {
    position: absolute;
    left: 0;
    bottom: -35px;
    content: "";
    width: 130px;
    height: 2px;
    background: #deb668;
}

#critical-email{ padding: 120px 0px; background: url(assets/images/critical-email.jpg); background-repeat: no-repeat; background-position: center center; background-size: 100%; }
#critical-email h2{ font-size: 50px; color: #fff; text-transform: uppercase; font-family: 'rajdhanibold'; text-align: center; }
#critical-email p{ color: #fff; font-weight: 500; font-size: 16px; line-height: 30px; }
.critical_desc{ background: #0000006b; padding: 30px 20px; }
.critical_desc p a{ color: #fff; font-weight: 500; font-size: 16px; line-height: 30px; text-decoration: underline; }
.critical_desc p a:hover{ color: #00caff; }



#our-classes-clone{ padding-top: 60px;  }
#our-classes-clone .section-heading{ text-align: center; }

#our-classes-clone .section-heading h2 { font-family: 'rajdhanibold'; font-size: 60px; font-weight: 900; color: #232d39; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 0px;margin-bottom: 0px; }
#our-classes-clone .section-heading h2 em { font-style: normal; color: #d12929; }
#our-classes-clone .section-heading h3 { color: #d12929 ; font-family: 'rajdhanibold'; font-size: 32px; line-height: 37px; }
#our-classes-clone .section-heading img{ margin: 20px auto; }
#our-classes-clone .section-heading .top-pad-40 { padding: 40px 225px; }

section#our-classes-clone ul { margin-bottom: 15px !important; }
section#our-classes-clone ul li { text-align: left; color: #ffffff; font-size: 18px; line-height: 27px; }
section#our-classes-clone ul { background: #d12929; padding: 10px; border-radius: 10px; }
i.fa.fa-th-large { margin: 5px; font-size: 18px; line-height: 18px ; } 



/* end box layout */

.fix {
    overflow: hidden;
}

.clear_both {
    clear: both;
}


/*============================
minister HEADER TOP AREA CSS
==============================*/

.em40_header_area_main {}

.em40_header_area_main.hdisplay_none {
    display: none;
}

.minister-header-top {
    background: #022147 none repeat scroll 0 0;
    padding: 12px 0;
}

.top-address p {
    margin-bottom: 0;
    color: #fff;
}

.top-address p span,
.top-address p a {
    margin-right: 20px;
}

.top-address p span i,
.top-address p a i {
    font-size: 15px;
    /* color: #deb668; */
    margin-right: 10px;
}

.top-address p a {
    display: inline-block;
    text-decoration: none;
    -webkit-transition: all 0.2s ease-in-out;
    transition: all 0.2s ease-in-out;
}


/* TOP RIGHT CSS */

.top-right-menu ul.social-icons {
    margin: 0;
    padding: 0;
}

.top-right-menu ul.social-icons li {
    display: inline-block;
    margin-left: 15px;
    position: relative;
}

.top-right-menu ul.social-icons li a {
    display: inline-block;
    text-decoration: none;
    -webkit-transition: all 0.2s ease-in-out;
    transition: all 0.2s ease-in-out;
    font-size: 15px;
}

.top-address p a,
.top-right-menu ul.social-icons li a,
.top-address p span {
    font-size: 14px;
    color: #fff;
}

.top-right-menu .social-icons li a:hover,
.top-right-menu .social-icons li a i:hover {
    color: #deb668;
}

.top-both-p0 .top-address p a,
.top-both-p0 .top-address p span {
    margin-right: 0px;
    margin-left: 12px;
}

.facebook.social-icon {
    color: #415E9B;
}

.twitter.social-icon {
    color: #1DA1F3;
}

.pinterest.social-icon {
    color: #BD081B;
}

.linkedin.social-icon {
    color: #007BB5;
}

.dribbble.social-icon {
    color: #EB4D88;
}

.login i,
.register i {
    margin-right: 9px;
}


/* Header Top Two */

.minister-header-top.header_top_two {
    background: #deb668 none repeat scroll 0 0;
}

.header_top_two .top-address p a {
    color: #fff;
}

.header_top_two .top-address p span i,
.header_top_two .top-address p a i {
    color: #fff;
}

.header_top_two .top-right-menu ul.social-icons li a {
    color: #fff;
}


/* sub menu css */

.top-right-menu ul .sub-menu {
    position: absolute;
    left: 0px;
    top: 100%;
    visibility: hidden;
    opacity: 0;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
    border-top: 1px solid #deb668;
    width: 150px;
    -webkit-transition: .5s;
    transition: .5s;
    text-align: left;
    background: #fff;
    z-index: 1;
}

.top-right-menu ul.social-icons li:hover .sub-menu {
    opacity: 1;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
    visibility: visible;
}

.top-right-menu ul .sub-menu li {
    padding: 5px 0px 0px 5px;
}

.top-right-menu ul .sub-menu li a {
    font-size: 12px;
}

.top-right-menu ul .sub-menu ul {
    display: none;
}

.top-welcome p {
    padding: 0px;
    margin: 0px;
}

.top-address.em-login a {
    margin-right: 10px;
}

.top-address.em-login a+a {
    margin-right: 0;
}

.top-address.em-login p a i,
.top-address.em-login p a i {
    margin-right: 5px;
}

.top-address.em-login a+a:before {
    content: "|";
    margin-right: 12px;
}

.txtc {
    text-align: center;
}

.text-center {
    text-align: center;
}

.text-left {
    text-align: left;
}

.text-right {
    text-align: right;
}


/* top opening */

.top-address.menu_18 span {
    background: #fff;
    padding: 8px 15px 9px;
    display: inline-block;
    color: #333;
}

.top-right-menu ul.social-icons.menu_18,
.top-right-menu ul.social-icons.menu_19 {
    padding: 7px 0;
}

.em-login.menu_18,
.em-quearys-top.menu_19 {
    padding: 7px 0;
}


/* top quearys */

.em-top-quearys-area {
    position: relative;
}

.em-header-quearys {
    list-style: none;
}

.em-quearys-menu i {
    background: #deb668 none repeat scroll 0 0;
    border-radius: 50px;
    display: inline-block;
    height: 26px;
    text-align: center;
    width: 26px;
    line-height: 26px;
    font-size: 11px;
    color: #fff;
}

.em-quearys-inner {
    position: absolute;
    right: 0;
    top: 36px;
    z-index: 999;
    display: none;
    -webkit-transition: .5s;
    transition: .5s;
}

.em-quearys-inner {}

.em-quearys-form {
    background-color: #ffffff;
    border-top: 1px solid #deb668;
    width: 290px;
    float: right;
}

.top-form-control {
    position: relative;
}

.top-form-control input {
    background: #f9f9f9;
    color: #666666;
    font-size: 13px;
    font-weight: 300;
    height: 48px;
    padding: 0 40px 0 15px;
    width: 100%;
    border: none;
    -webkit-transition: 1s;
    transition: 1s;
}

.top-form-control button.top-quearys-style {
    position: absolute;
    right: 6px;
    top: 50%;
    /* height: 44px; */
    background: transparent;
    font-size: 15px;
    border: none;
    color: #deb668;
    -webkit-transform: translateY(-50%);
    transform: translateY(-50%);
}

.em-s-hidden {
    display: none !important;
}


/* address left right icon */

.top-right-menu.litop {
    float: left;
}


/* mobile logo   */

.mobile_menu_logo.text-center {
    padding: 20px 0;
}


/*=========================
minister TOP  CREATIVE HEADER
==========================*/

.em_creative_header {
    background: #f9f9f9 none repeat scroll 0 0;
    padding: 28px 0;
    position: relative;
    overflow: hidden;
    z-index: 1;
}

.em_creative_header:before {
    background: #deb668 none repeat scroll 0 0;
    content: "";
    left: 0;
    top: 0;
    bottom: 0;
    width: 25%;
    height: 100%;
    z-index: -1;
    position: absolute;
}

.em_creative_header:after {
    background: #deb668 none repeat scroll 0 0;
    content: "";
    left: 18%;
    top: 0;
    bottom: 0;
    width: 15%;
    height: 100%;
    position: absolute;
    border: ;
    -webkit-transform: rotate(-121deg);
    transform: rotate(-121deg);
    z-index: -1;
}

.single_header_address {}

.creative_logo_thumb {
    z-index: 9;
    text-align: right;
}

.creative_header_icon {
    float: left;
    margin-right: 10px;
    overflow: hidden;
}

.creative_header_icon i {
    color: #deb668;
    font-size: 28px;
    margin-top: 5px;
}

.creative_header_address {
    overflow: hidden;
    padding-left: 80px;
}

.creative_header_address_text>h3 {
    font-size: 18px;
    font-weight: 600;
    margin: 0;
    padding: 0;
}

.creative_header_address_text>p {
    margin: 0;
}

.creative_logo_thumb {
    z-index: 9;
}

.creative_header_button {
    padding-left: 50px;
    position: relative;
    margin-top: 5px;
}

.creative_header_button:before {
    content: "";
    position: absolute;
    background: #deb668;
    width: 1px;
    height: 74px;
    left: 10px;
    top: -21px;
}

.creative_header_button .dtbtn {
    background: #deb668 none repeat scroll 0 0;
    border-radius: 30px;
    color: #fff;
    display: inline-block;
    font-family: raleway;
    font-size: 14px;
    font-weight: 600;
    margin-left: 0;
    padding: 6px 26px;
    text-transform: capitalize;
    -webkit-transition: all 0.3s ease 0s;
    transition: all 0.3s ease 0s;
}

.creative_header_button>a:hover {
    background: #deb668 none repeat scroll 0 0;
}

.em_slider_social {
    position: fixed;
    right: 15px;
    text-align: center;
    top: 50%;
    z-index: 9999;
}

.em_slider_social li {
    display: block;
    list-style: outside none none;
    text-decoration: none;
}

.em_slider_social a {
    background: #deb668 none repeat scroll 0 0;
    border: 1px solid #deb668;
    border-radius: 50%;
    color: #fff;
    display: inline-block;
    font-size: 16px;
    height: 35px;
    line-height: 35px;
    margin-bottom: 10px;
    width: 35px;
}

.em_slider_social a:hover {
    background: #deb668;
    color: #fff;
    border-color: #deb668;
}

.no-logo-sr .creative_search_icon {
    position: absolute;
    right: 19%;
    top: 50%;
    -webkit-transform: translateY(-50%);
    transform: translateY(-50%);
    z-index: 999;
}

.no-logo-sr .em-quearys-top.msin-menu-search .em-quearys-inner {
    top: 70px;
}

.no-logo-sr .minister_menu ul {
    text-align: center;
}

.no-logo-sr .minister_menu ul li {
    text-align: left;
}


/*==============================
minister HEADING NAV AREA CSS
===============================*/

.mean-container .mean-bar {
    padding: 0;
}

.mean-container .mean-nav {
    background: #fff none repeat scroll 0 0;
    float: none;
}

.main_menu_div {
    position: relative;
}

.minister_nav_area {
    background: #fff;
    position: absolute;
    left: 0;
    width: 100%;
    z-index: 999;
    box-shadow: 0px 4px 5px -3px rgba(0, 0, 0, 0.20);
}
.header_no_transparent .minister_nav_area {
    background: #fff;
    position: inherit;
    box-shadow: none;
}

.header_no_transparent .minister_menu>ul>li>a {
    color: #555;
}

.header_no_transparent .minister_menu>ul>li:hover a {
    color: #deb668;
}

.header_no_transparent .minister_menu>ul>li>a::before {
    border-bottom: 5px dotted #deb668;
}

.header_no_transparent .minister_menu ul .sub-menu li a {
    color: #444 !important;
}

.header_no_transparent a.dtbtn:hover {
    background-color: #122a89;
    color: #fff;
}
.header_transparent_two .minister_nav_area {
    background: inherit;
    box-shadow: none;
}
.header_transparent_two .logo-left {
    background: rgba(0,0,0,0.55);
}
.header_transparent_two .minister_nav_area.prefix {
    background: transparent !important;
    top: 0px;
}
.header_transparent_two .minister_nav_area.prefix .logo-left{
background:#0D2352;
}
/* LOGO CSS */

.logo {
    margin-top: 30px;
}

.logo a {
    font-weight: 700;
    display: inline-block;
    margin-top: 2px;
}

.minister_menu {
    text-align: right;
}


/* MAIN MENU CSS */

.minister_menu ul {
    text-align: right;
    list-style: none;
}

.minister_menu>ul>li {
    display: inline-block;
    position: relative;
}

.minister_menu > ul > li > a {
    display: block;
    -webkit-transition: .5s;
    transition: .5s;
    position: relative;
    color: #1d1e1e;
    font-size: 14px;
    font-weight: 500;
    text-transform: uppercase;
    margin: 50px 0px 38px;
    margin-left: 28px;
}
.minister_menu>ul>li:hover a {
    color: #000 !important;
}
.minister-header-top {
    display: none;
}
.minister_menu > ul > li > a:hover{
    
    color:#000 !important;
}
.minister_menu>ul>li>a::before {
    position: absolute;
    content: "";
    left: -2px;
    bottom: -6px;
    width: 0%;
    border-bottom: 5px dotted #0060af;
    transition: .3s;
}

.minister_menu>ul>li>a:hover::before {
    width: 101%;
}

.minister_menu ul li:last-child a {
    margin-right: 0px;
}

.minister_menu>ul>li.current>a,
.minister_menu>ul>li:hover>a {
    color: #fff;
    background-color: transparent;
}

.minister_menu>ul>li:hover>a:before,
.minister_menu>ul>li.current>a:before {
    opacity: 1;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
}


/* Menu Transparent */

.trp_nav_area {
    position: fixed;
    left: 0;
    right: 0;
    top: 0;
    z-index: 9999;
    background-color: transparent;
    padding: 25px 0;
    -webkit-transition: .5s;
    transition: .5s;
}


/* stycky nav Css */

.transprent-menu .minister_nav_area {
    left: 0;
    right: 0;
    top: 0;
    z-index: 9999;
    background-color: transparent;
    padding: 0;
    -webkit-transition: .5s;
    transition: .5s;
    position: absolute;
}

.minister_nav_area.postfix {
    -webkit-transition: .3s;
    transition: .3s;
}

.minister_nav_area.prefix {
    background: #fff !important;
    top: 0px;
}

.minister_nav_area.prefix .minister_menu>ul>li>a {
    color: #1d1e1e;
    -webkit-transition: .3s;
    transition: .3s;
        font-weight: 600;
}

.minister_nav_area.prefix .minister_menu>ul>li.current>a {
    color: #1d1e1e;
}


/* LOGO LEFT RIGHT CSS */

.logo-left {}

.logo-right .logo {
    text-align: right;
}

.logo-right .minister_menu>ul {
    text-align: left;
}

.logo-right .minister_menu>ul>li:first-child a {
    padding-left: 0px;
}

.logo-right .minister_menu>ul>li:last-child a {
    padding-right: auto;
}


/* logo top */

.logo-top .logo {
    text-align: center;
}

.logo-top .minister_menu>ul {
    text-align: center;
}

.logo-top>.minister_menu>ul>li:last-child a {
    padding-right: auto;
}


/* sub menu style */

.minister_menu ul .sub-menu {
    position: absolute;
    left: 0;
    top: 130%;
    width: 217px;
    text-align: left;
    background: #151515;
    margin: 0;
    padding: 15px 0;
    z-index: 9999;
    box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);
    -webkit-transition: .5s;
    transition: .5s;
    opacity: 0;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
    visibility: hidden;
}

.minister_menu ul li:hover>.sub-menu {
    opacity: 1;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
    visibility: visible;
    top: 100%;
    z-index: 9;
}

.minister_menu ul .sub-menu li {
    position: relative;
}

.minister_menu ul .sub-menu li a {
    display: block;
    padding: 12px 20px;
    margin: 0;
    line-height: 1.3;
    letter-spacing: normal;
    font-size: 12px;
    font-weight: 500;
    text-transform: uppercase;
    -webkit-transition: .1s;
    transition: .1s;
    visibility: inherit !important;
    color: #fff;
}
.minister_menu ul .sub-menu li:hover>a,
.minister_menu ul .sub-menu .sub-menu li:hover>a,
.minister_menu ul .sub-menu .sub-menu .sub-menu li:hover>a,
.minister_menu ul .sub-menu .sub-menu .sub-menu .sub-menu li:hover>a {
    background: rgba(255, 255, 255, .06);
    color: #deb668;
}


/* sub menu 2 */

.minister_menu ul .sub-menu .sub-menu {
    left: 100%;
    top: 130%;
    opacity: 0;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
    visibility: hidden;
}

.minister_menu ul .sub-menu li:hover>.sub-menu {
    opacity: 1;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
    visibility: visible;
    top: 0%;
}


/* sub menu 3 */

.minister_menu ul .sub-menu .sub-menu li {
    position: relative;
}

.minister_menu ul .sub-menu .sub-menu .sub-menu {
    right: 100%;
    left: auto;
    top: 130%;
    opacity: 0;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
    visibility: hidden;
}

.minister_menu ul .sub-menu .sub-menu li:hover>.sub-menu {
    opacity: 1;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
    visibility: visible;
    top: 0%;
}


/* sub menu 4 */

.minister_menu ul .sub-menu .sub-menu .sub-menu li {
    position: relative;
}

.minister_menu ul .sub-menu .sub-menu .sub-menu .sub-menu {}

.minister_menu ul .sub-menu .sub-menu .sub-menu li:hover>.sub-menu {
    opacity: 1;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
    visibility: visible;
    top: 0%;
}


/* user login */

.logged-in .transprent-menu .minister_nav_area.prefix {
    top: 32px;
}

.logged-in .trp_nav_area.hbg2 {
    top: 32px;
}


/* Main  menu search */

.minister_menu.main-search-menu>ul,
.em-quearys-top.msin-menu-search {
    display: inline-block;
}

.em-quearys-top.msin-menu-search .em-quearys-menu i {
    height: 36px;
    width: 36px;
    line-height: 36px;
    margin-left: 20px;
}

.em-quearys-top.msin-menu-search .em-quearys-inner {
    top: 59px;
}


/* has menu icon */

.minister-main-menu .menu-item-has-children>a:after {
    margin-left: 5px;
    content: "\f107";
    font-family: FontAwesome;
    opacity: 1;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
    font-size: 13px;
    opacity: .5;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";
}

.minister-main-menu .menu-item-has-children .menu-item-has-children>a:after {
    margin-left: 8px;
    content: "\f105";
}


/* Main menu button */

.donate-btn-header {
    display: flex;
        width: 25%;
}
ul.sub-menu.nav_scroll {
    width: 70%;
    float: left;
        text-align: center;
}
.donate-btn-header img {
    width: 60%;
    margin: 30px 10px;
}

.microsoft-partner{ border: 1px solid #ccc; padding: 6px; border-radius: 10px; }


a.dtbtn {
    border: none;
    display: block;
    font-size: 14px;
    margin-left: 30px;
    font-weight: 600;
    text-transform: uppercase;
    border-radius: 30px;
    padding: 7px 20px;
    background-color: #deb668;
    color: #fff;
    margin-top: 30px;
}

a.dtbtn:hover {
    background-color: #fff;
    color: #444;
}

.redX {
    color: #deb668;
}


/* logo sticky */

.minister-main-menu .logo a.main_sticky_main_l {
    display: block;
}

.minister-main-menu .logo a.main_sticky_l {
    display: none;
}


/* logo pre */

.minister-main-menu .prefix .logo a.main_sticky_main_l {
    display: none;
}

.minister-main-menu .prefix .logo a.main_sticky_l {
    display: block;
    margin-top: 3px;
}

.headroom--pinned {
    -webkit-transform: translateY(0);
    transform: translateY(0);
}

.headroom--unpinned {
    -webkit-transform: translateY(-100%);
    transform: translateY(-100%);
}

.header--fixed {
    position: fixed;
    z-index: 10;
    right: 0;
    left: 0;
    top: 0;
    -webkit-transition: -webkit-transform .25s ease-in-out;
    transition: -webkit-transform .25s ease-in-out;
    transition: transform .25s ease-in-out;
    transition: transform .25s ease-in-out, -webkit-transform .25s ease-in-out;
    will-change: transform;
}

.menu-height-space {
    height: 100px;
}


/* minister header-creative css */

.header-creative-area {
    padding: 24px 0 25px;
    /* background: #ddd; */
}

.header-creative-address {
    text-align: right;
    position: relative;
}

.header-creative-address::before {
    position: absolute;
    right: -27px;
    top: -25px;
    width: 1px;
    height: 211%;
    background: #ddd;
    content: "";
}

.header-creative-address.last-child:before {
    display: none;
}

.header-creative-icon i {
    font-size: 20px;
    display: inline-block;
    float: left;
    margin-left: 26px;
    height: 35px;
    width: 35px;
    color: #fff;
    text-align: center;
    background: #deb668;
    line-height: 35px;
    margin-top: 5px;
    border-radius: 3px;
}

.header-creative-text p {
    margin: 0;
    overflow: hidden;
    margin-left: 10px;
}


/*=============================
minister NIVO SLIDER AREA CSS
==============================*/

.main-slider-area {
    overflow: hidden;
    display: block;
    position: relative;
    z-index: 0;
}

.nivo-caption {
    background: rgba(0, 0, 0, 0.0) none repeat scroll 0 0;
    height: 100%;
    opacity: 1;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
}

.em-slider-content-nivo {}

.em_slider_right {}

.em_slider_inner {
    margin: auto;
    /* width: 60%; */
    position: absolute;
    top: 54%;
    left: 0;
    right: 0;
    -webkit-transform: translateY(-50%);
    transform: translateY(-50%);
    z-index: 9999;
}


/* slider title */

.em-slider-title {
    color: #fff;
    font-size: 15px;
    font-weight: 600;
    margin-bottom: 23px;
    text-transform: uppercase;
}

.em-slider-sub-title {
    color: #fff;
    font-size: 60px;
    font-weight: 800;
    margin-bottom: 0;
    text-shadow: 0 0 2px rgba(0, 0, 0, 0.05);
    text-transform: capitalize;
    margin: 0;
}
.text-center .em-slider-sub-title {
    font-weight: 600;
    text-transform: uppercase;
}

.em-slider-descript {
    color: #fff;
}

.em-slider-descript {
    font-size: 17px;
    font-weight: 400;
    margin-bottom: 43px;
    width: 55%;
    margin-top: 21px;
}

.text-left .em-slider-descript {
    margin-left: 0;
    margin-right: auto;
}
.text-center .em-slider-descript {
    margin: 11px auto 28px;
}

.text-right .em-slider-descript {
    margin-right: 0;
    margin-left: auto;
}


/* button */
.em-button-button-area a {
    color: #fff;
    display: inline-block;
    font-size: 15px;
    font-weight: 600;
    margin: 0 4px;
    padding: 10px 45px;
    position: relative;
    text-transform: uppercase;
    -webkit-transition: all 0.5s ease 0s;
    transition: all 0.5s ease 0s;
    z-index: 1;
    font-family: 'Raleway', sans-serif;
    background: #fff;
    border-radius: 30px;
    background: #fff;
    background: #deb668;
    z-index: 9999;
    letter-spacing: 1px;
}

.em-button-button-area a:hover {
    color: #fff;
    background: #041B5E;
    border-color: #041B5E;
}

.em-slider-half-width {
    width: 50%;
}

.em-slider-left {
    padding-right: 30px;
}

.em-slider-right {
    padding-left: 30px;
}

.em-slider-full-width {
    width: 85%;
}

.em-slider-half-width .em-slider-descript {
    width: 100%;
}


/* directionNav */

.em-nivo-slider-wrapper .nivo-directionNav {}

.em-nivo-slider-wrapper .nivo-directionNav a {
    top: 50%;
    -webkit-transform: translateY(-50%);
    transform: translateY(-50%);
    height: 70px;
    width: 70px;
    line-height: 68px;
    border: 1px solid #fff;
    text-align: center;
    display: block;
    border-radius: 50%;
    color: #fff;
    font-size: 34px;
    left: 0;
    -webkit-transition: all 0.3s ease 0s;
    transition: all 0.3s ease 0s;
    opacity: 0;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
    visibility: hidden;
    border-radius: 30px 0 0 30px;
}
.em-nivo-slider-wrapper .nivo-directionNav .nivo-prevNav {
    border-radius: 0 30px 30px 0;
}

.em-nivo-slider-wrapper .nivo-directionNav .nivo-nextNav {
    left: auto;
    right: 0;
}

.em-nivo-slider-wrapper .nivo-directionNav a:hover {
    background: #deb668;
    border-color: #deb668;
    color: #fff;
}

.em-nivo-slider-wrapper:hover .nivo-directionNav a {
    opacity: 1;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
    visibility: visible;
    left: 50px;
}

.em-nivo-slider-wrapper:hover .nivo-directionNav .nivo-nextNav {
    left: auto;
    right: 50px;
}


/* controlNav */

.em-nivo-slider-wrapper .nivo-controlNav {
    bottom: 50px;
    padding: 0;
    position: absolute;
    width: 100%;
    z-index: 9;
    display: none;
}

.em-nivo-slider-wrapper .nivo-controlNav a {
    background: #000 none repeat scroll 0 0;
    border-radius: 50%;
    cursor: pointer;
    display: inline-block;
    font-size: 14px;
    height: 25px;
    margin: 0 5px;
    width: 25px;
    color: #fff;
    line-height: 25px;
}

.em-nivo-slider-wrapper .nivo-controlNav a:hover,
.em-nivo-slider-wrapper .nivo-controlNav a.active {
    background: #deb668 none repeat scroll 0 0;
    opacity: 1;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
}

.hosting_feature {
    list-style: none;
    padding-left: 15px;
    padding-top: 20px;
}

.hosting_feature li {
    margin-bottom: 14px;
    font-size: 16px;
}

.hosting_feature li:last-child {
    margin-bottom: 0px;
}

.hosting_feature li i {
    margin-right: 10px;
}

.em_slider_single_img {
    position: absolute;
    right: 52%;
    top: 0;
}
.text-right .em_slider_single_img {
    position: absolute;
    left: 0%;
    top: 0;
}


/*==================
CUROUSEL SLIDER AREA
====================*/

.slider_area {
    background: url(assets/images/slider-bg.jpg);
    background-size: cover;
    background-position: center center;
    position: relative;
    z-index: 1;
}

.home-2.slider_area {
    background: url(img/slider/s4.jpg);
    background-size: cover;
    background-position: center center;
}

.home-3.slider_area {
    background: url(img/slider/s4.jpg);
    background-size: cover;
    background-position: center center;
}

.slider_area:before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, .0);
    z-index: -1;
}

.slider_content {
    display: table;
    height: 930px;
    text-align: center;
    width: 100%;
    padding-top: 23%;
}

.slider_text {
    vertical-align: middle;
    width: 100%;
}

.slider_text>h1 {
    color: #fff;
    font-size: 50px;
    text-transform: uppercase;
    margin: 0;
}

.slider_text>h2 {
    color: #fff;
    font-size: 50px;
    font-weight: 700;
    text-transform: uppercase;
    z-index: 999999999;
    margin: 0;
}

.slider_text>p {
    color: #fff;
    width: 61%;
    margin: auto;
    font-size: 18px;
}

.slider_readmore {
    margin-top: 32px;
}

.sreadmore {
    color: #fff;
    font-size: 14px;
    font-weight: 700;
    padding: 12px 40px;
    border-radius: 30px;
    display: inline-block;
    margin: 0 7px 0;
    -webkit-transition: .5s;
    transition: .5s;
    text-transform: uppercase;
    background: #041B5E;
    border-radius: 5px;
    z-index: 99999999;
}

.sreadmore:hover {
    color: #444;
    background: #fff;
}


/* Particles Js Slider */

.effective_slider .slider_text>h1 {
    margin-bottom: 13px;
}

.particles-js-canvas-el {
    position: absolute;
    top: 0;
    z-index: -1;
}

#particles-js {
    z-index: -1;
}


/*=========================
minister ABOUT AREA CSS
===========================*/
.about_area {
    padding: 60px 0 0;
    overflow: hidden;
    background: #f7f7f7;
}
.minister_about {
    padding: 117px 0 0 25px;
}
.about-pages .minister_about {
    padding: 0 0 0 59px;
}

.about_area.about-left-img {
    background: #f7f7f7;
    padding: 80px 0 40px;
}

.section_title_lefts {}

.section_title_lefts h2 {
    margin-top: 0;
    font-size: 17px;
    font-weight: 700;
    /* text-transform: capitalize; */
    margin-bottom: 19px;
    color: #6d6d6d;
}

.section_title_lefts h1 {
    margin-bottom: 78px;
    font-size: 37px;
    position: relative;
}

.section_title_lefts h1 span {
    display: block;
}

.hosthub_about {
    padding-left: 25px;
}

.section_title_lefts h1::before {
    position: absolute;
    left: 0;
    bottom: -35px;
    content: "";
    width: 130px;
    height: 2px;
    background: #deb668;
}
.section_title_lefts.about_subtitle h2 {
    position: relative;
    display: inline-block;
    font-family: 'Merriweather', serif;
    font-size: 15px;
    font-weight: 600;
    margin-bottom: 0px;
    text-transform: uppercase;
    color: #DEB668;
    letter-spacing: 2px;
}

.about_singnature img {
    margin-top: 8px;
}

.single_image {
    position: relative;
}

.about_text p {
    margin-bottom: 30px;
}

.about_text p.about_text_bold {
    margin-bottom: 30px;
    font-weight: 600;
    color: #333;
    font-size: 16px;
}

.about_button {
    margin-top: 44px;
}

.about_button a {
    color: #ffffff;
    background: #deb668;
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
    border-radius: 30px;
    padding: 13px 40px 13px 40px;
    font-family: Raleway, sans-serif;
    margin-right: 30px;
    letter-spacing: 1px;
}
.about_button a:hover {
    background: #022147;
}

.about_text ul {
    list-style: none;
}

.about_text ul li {
    line-height: 30px;
    font-size: 16px;
    font-weight: 500;
    margin-bottom: 9px;
    color: #555;
}

.about_text ul li i {
    color: #deb668;
    margin-right: 5px;
}

/* About Left Images Css */

.about-left-img .minister_about {
    padding: 59px 42px 0 0px;
}

.about-left-img.about-pages .minister_about {
    padding: 3px 42px 0 0px;
}

.about-left-img .single_image {
    margin-top: -10px;
    position: relative;
}

.about-left-img .hosthub_about {
    padding-left: 0;
    padding-right: 25px;
    /* padding-top: 10px; */
    /* margin-top: 4px; */
}

/*==============================
/* minister COUNTDOWN AREA CSS 
===============================*/


/* count down area css */

.count_down_area {
    background-image: url(assets/images/countdown-bg.jpg);
    background-position: center center;
    background-repeat: no-repeat;
    background-size: cover;
    padding: 83px 0 100px;
    position: relative;
    background-attachment: fixed;
}

.count_down_area::before {
    position: absolute;
    content: "";
    left: 0;
    right: 0;
    bottom: 0;
    top: 0;
    background: rgba(2, 2, 2, 0.75);
}

span.cdowns {
    width: 175px;
    height: 175px;
    background: rgba(222, 182, 104, 0.6);
    display: inline-block;
    margin: 0 29px;
    position: relative;
    border-radius: 100%;
}

span.cdowns::before {
    position: absolute;
    content: "";
    background: #fff;
    top: 65px;
    right: -37px;
    height: 12px;
    width: 12px;
    border-radius: 50%;
}

span.cdowns::after {
    position: absolute;
    content: "";
    background: #fff;
    top: 97px;
    right: -37px;
    height: 12px;
    width: 12px;
    border-radius: 50%;
}

span.cdowns:last-child::before,
span.cdowns:last-child::after {
    display: none;
}

.counterdowns {
    text-align: center;
}

span.time-counts {
    line-height: 125px;
    font-size: 60px;
    color: #fff;
}

.counterdowns p {
    color: #fff;
    font-size: 21px;
    line-height: 0px;
    margin-top: -4px;
}
.event_dtl_timeline {
    margin-bottom: 45px;
    padding: 20px 15px 20px;
    border: 1px solid #ddd;
    margin-top: 38px;
}

.event_details span.cdowns {
    width: 152px;
    height: 130px;
    background: #DEB668;
    display: inline-block;
    margin: 0 8px;
    position: relative;
    border-radius: 0;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.20);
    border-radius: 7px;
}

.event_details span.time-counts {
    line-height: 94px;
    font-size: 60px;
}

.event_details .counterdowns p {
    font-size: 21px;
    line-height: 0px;
    margin-top: 0px;
}

/*=======================
minister EVENT AREA CSS
=========================*/
.event_area {
    padding: 80px 0 100px;
}
.minister_single_event {
    margin: 0;
    border:1px solid #ddd;
    overflow:hidden;
    position: relative;
    margin-bottom:30px;
}

.event-grid .minister_single_event {
    margin-bottom: 30px;
}

.minister_event_thumb {
    float: left;
    position: relative;
}
.minister_event_thumb i {
    display: inline-block;
    font-size: 40px;
    color: #fff;
    position: absolute;
    left: 50%;
    top: 0;
    /* right: 0; */
    margin: auto;
    transform: translateX(-50%);
    opacity: 0;
    transition:.5s;
}
.minister_event_thumb img {
    width: 100%;
}

.minister_event_thumb a {
    position: relative;
    display: block;
    z-index: 1;
}

.minister_event_thumb a:before {
    position: absolute;
    content: "";
    left: 0;
    bottom: 0;
    width: 100%;
    height: 0%;
    background: rgba(0, 0, 0, 0.50);
    transition: .3s;
}

.minister_single_event:hover .minister_event_thumb i {
    top: 50%;
    transform:translateY(-50%);
    opacity:1;
}
.minister_single_event:hover .minister_event_thumb a:before {
    height: 100%;
}
.event_content_area {
    overflow: hidden;

}
.event_page_title {
    padding-bottom: 4px;
    padding-left: 25px;
    padding-right: 25px;
    padding-top: 15px;
}
.event_page_title:hover h2 a {
    color: #DEB668;
}
.event_page_title h2 a {
    color: #444;
    text-transform: capitalize;
    font-size: 21px;
    font-weight: 700;
    padding-bottom: 15px;
    display: block;
}
.minister_event_info{
    padding-left:20px;
}
.minister_event_info p {
    display: inline-block;
    margin-right: 30px;
}
.minister_event_info p:last-child {
    margin-right: 0px;
}

.minister_event_info p .info-top {
    font-weight: 600;
    font-size: 17px;
}
.minister_event_info p .info-bottom{
    display:block;
    overflow:hidden;
}
.minister_event_info p i {
    color: #deb668;
    font-size: 17px;
    /* overflow: hidden; */
    margin-right: 6px;
    /* margin-top: 14px; */
    display: inline-block;
    /* padding-top: 0px; */
}
.minister_event_info {
    border-top: 1px solid #ddd;
    margin-top: 15px;
    padding-top: 11px;
}
.minister_event_info{}
.minister_event_thumb {
    overflow: hidden;
    width: 40%;
    float: left;
}

.event_button{
    text-align:center;
}
.event_button a {
    display: inline-block;
    padding: 10px 45px;
    background: #DEB668;
    border-radius: 30px;
    font-size: 15px;
    text-transform: uppercase;
    color: #fff;
    font-weight: 600;
    transition:.3s;
}
.event_button a:hover {
    background: #031458;
}

/*==========================
minister EVENT DETAILS CSS
============================*/

.event_details {
    border: 1px solid #ddd;
    padding: 30px 15px 30px;
}

.event_dtl_content h2 {
    font-size: 22px;
    margin-bottom: 20px;
    margin-top: 21px;
}

.event_dtl_schedule {
    background: #f7f7f7;
    padding: 18px 25px 35px;
    margin-top: 30px;
    border-radius: 10px;
}

.event_dtl_schedule h2 {
    padding-bottom: 20px;
}

.shedule_description ul {
    list-style: square;
    padding-left: 30px;
}
.shedule_description ul li {
    /* margin-bottom: 20px; */
    padding: 15px 0;
    border-bottom: 1px solid #ddd;
    color: #777;
}

.shedule_description ul li span {
    float: right;
}

.event_dtl_map {
    margin-top: 40px;
}

/*=========================
minister FEATURE AREA CSS
===========================*/

.feature_area {
    padding: 60px 0 69px;
}

.single_feature {
    margin-bottom: 30px;
    position: relative;
    transition: .7s;
}

.feature_back {
    background: #03165B;
    height: 200px;
    width: 200px;
    margin: auto;
    position: relative;
    text-align: center;
    z-index: 1;
    border-radius: 100%;
}

.feature_back::before {
    position: absolute;
    content: "";
    left: 0;
    right: 0;
    width: 100%;
    height: 100%;
    background: transparent;
    border: 15px solid #deb668;
    z-index: -1;
    transition: .5s;
    border-radius: 100%;
}

.feature_back:hover:before {
    box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.6);
}

.feature_back_content {
    position: relative;
    top: 50%;
    transform: translateY(-50%);
    /* color: #fff; */
}

.feature_back_content p {
    color: #fff;
    padding: 0 22px;
}

.feature_back_content a {
    color: #fff;
    font-size: 12px;
    text-transform: uppercase;
    display: inline-block;
    background: #deb668;
    padding: 3px 16px;
    border-radius: 30px;
    margin-top: 4px;
}

.feature_icon {
    text-align: center;
    position: absolute;
    background: #DEB668;
    border: 3px solid #ffffff;
    left: 15px;
    top: 15px;
    width: 85%;
    height: 85%;
    margin: auto;
    transition: .7s;
    border-radius: 100%;
}
.feature_icon_inner {
    position: relative;
    top: 50%;
    transform: translateY(-50%);
}

.feature_icon {
    text-align: center;
}

.feature_icon_inner i {
    font-size: 35px;
    background: #fff;
    width: 90px;
    height: 90px;
    text-align: center;
    line-height: 90px;
    border-radius: 50%;
    color: #DEB668;
}

.single_feature:hover .feature_icon {
    top: -78%;
    transition: .7s;
    transform: rotateY(-160deg);
}

.feature_title {
    text-align: center;
    padding: 0 16px;
}

.feature_title h2 {
    padding: 8px 0 0px;
    transition: .3s;
    text-transform: capitalize;
}

.feature_title h2 a {
    font-weight: 700;
    font-size: 21px;
    color: #444;
    transition: .3s;
}

.feature_title h2 a:hover {
    color: #deb668;
}

.feature_title p {
    transition: .3s;
}

.feature_area {}

.single_feature:hover .feature_title p {
    color: #fff;
}
/*=======================
 FEATURE AREA HOME page2
========================*/
.feature_area_style2.feature_area {
    padding-top: 0;
}
.feature_area_style2 .col-md-4.col-lg-4.col-sm-6.col-xs-12 {
    margin: 0;
    padding: 0;
}

.single_feature_area {
    background: #fff;
    padding: 40px 0 35px;
    overflow: hidden;
    position: relative;
    box-shadow: 0px 0px 10px 3px rgba(0,0,0,0.15);
    transition: .5s;
    margin-top: -129px;
    margin-bottom:30px;
}
.single_feature_area.middle_feature {
    background: #deb668;
    transition:.5s;
}
.single_feature2 {
    text-align: center;
}
.single_feature_content {
    padding: 0 20px;
}
.single_feature_title h2 {
    padding: 5px 0 10px;
    transition:.5s;
    color:#444;
}
.single_feature_title p {
    padding: 0 0 13px;
    transition:.5s;
    color:#444;
}
.single_feature_icon i {
    font-size: 26px;
    background: #deb668;
    width: 55px;
    height: 55px;
    line-height: 55px;
    text-align: center;
    color: #fff;
    border-radius: 50%;
    transition:.5s;
}
.single_feature_btn a {
    background: #DEB668;
    padding: 5px 20px;
    color: #fff;
    font-size: 14px;
    border-radius: 30px;
}
.middle_feature .single_feature_icon i {
    background: #0D2352;
    color: #fff;
    transition:.5s;
}
.middle_feature .single_feature_title h2 {
    color: #fff;
    transition:.5s;
}
.middle_feature .single_feature_title p {
    color: #fff;
    transition:.5s;
}
.single_feature_area:hover{
    background: #deb668;
}
.single_feature_area:hover .single_feature_title h2{
    color:#fff;
}
.single_feature_area:hover .single_feature_title p{
    color:#fff;
}
.single_feature_area:hover .single_feature_icon i{
    background:#0D2352;
}
.single_feature_area.middle_feature:hover{
    background:#fff;
}
.single_feature_area.middle_feature:hover .single_feature_title h2{
    color:#444;
}
.single_feature_area.middle_feature:hover .single_feature_title p{
    color:#444;
}
.single_feature_area.middle_feature:hover .single_feature_icon i{
    background:#deb668;
    color:#fff;
}
.single_feature_area:hover .single_feature_btn a,
.single_feature_area.middle_feature .single_feature_btn a{
    background:#0D2352;
    color:#fff;
}
/*==============================
/* minister Pricing AREA CSS 
===============================*/

.pricing_area {
    background: #f7f7f7;
    padding: 79px 0 70px;
}

.single_pricing {
    background: #fff none repeat scroll 0 0;
    transition: all 0.3s ease 0s;
    padding: 23px 0px 45px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.20);
    margin-bottom: 30px;
    margin-top: 5px;
    position: relative;
    z-index: 1;
}

.single_pricing::before {
    position: absolute;
    content: "";
    left: 0;
    top: 0;
    width: 100%;
    height: 236px;
    background: #deb668;
    z-index: -1;
    border-radius: 0 0 140px 140px;
    transition: .3s;
}

.single_pricing:hover {
    box-shadow: 0 0 25px rgba(0, 0, 0, 0.20);
}

.single_pricing:hover:before {
    background: #031657;
}

.featur ul {
    text-align: center;
    padding-top: 30px;
}

.pricing_head {
    padding: 20px 0 16px;
    transition: all 0.3s ease 0s;
    text-align: center;
}

.pricing_icon {
    text-align: center;
}

.pricing_title {
    text-align: center;
    position: relative;
}

.pricing_img {
    text-align: center;
    border: 2px solid #fff;
    display: inline-block;
    /* margin: auto; */
    padding: 25px;
    border-radius: 100%;
    width: 110px;
    height: 110px;
    background: #fff;
}

.pricing_title h2 {
    font-size: 20px;
    color: #fff;
    -webkit-transition: .3s;
    transition: .3s;
}

.pricing_title h3 {
    display: inline-block;
    font-size: 21px;
    font-weight: 700;
    margin: 0;
    padding: 8px 0px 0;
    -webkit-transition: .3s;
    transition: .3s;
    text-transform: uppercase;
    color: #fff;
}

.pricing_title h4 {
    font-size: 14px;
    font-weight: 500;
    color: #fff;
    -webkit-transition: .3s;
    transition: .3s;
}

.price_item_inner_center {
    -webkit-transition: .3s;
    transition: .3s;
    margin-top: 19px;
}

.price_item {
    text-align: center;
    -webkit-transition: all 0.5s ease 0s;
    transition: all 0.3s ease 0s;
}

.price_item span {
    color: #deb668;
    display: inline-block;
    -webkit-transition: all 0.3s ease 0s;
    -webkit-transition: all 0.5s ease 0s;
    transition: all 0.3s ease 0s;
    font-size: 30px;
}

.slash {
    font-size: 26px !important;
}

.curencyp {
    font-size: 24px;
    font-weight: 600;
    position: relative;
}

.tk {
    color: #deb668;
    font-weight: 600;
}

.starting {
    display: block !important;
    font-size: 13px !important;
    color: #454545 !important;
    text-transform: uppercase;
}

.line_barp {}

.monthp {
    display: block;
    position: relative;
}

.bootmp {
    font-weight: 400;
}

.pricing_body {}

.featur {}

.featur ul {
    text-align: center;
    padding-top: 45px;
}

.featur ul li {
    display: block;
    font-size: 15px;
    font-weight: 300;
    padding: 7px 0;
    text-transform: none;
    transition: all 0.3s ease 0s;
}

.featur ul li i {
    margin-right: 5px;
    color: #666;
}

.featur ul li b {
    font-weight: 600;
}

.featur ul li:last-child {}

.pricing_bottom {
    padding-top: 16px;
}

.order_now {
    background: transparent none repeat scroll 0 0;
    /* padding: 29px 0; */
    text-align: center;
    -webkit-transition: all 0.3s ease 0s;
    transition: all 0.3s ease 0s;
    /* margin-bottom: -19px; */
}

.order_now a {
    background: #deb668 none repeat scroll 0 0;
    border-radius: 30px;
    color: #fff;
    display: inline-block;
    font-size: 15px;
    font-weight: 600;
    padding: 10px 40px;
    position: relative;
    text-transform: uppercase;
    -webkit-transition: all 0.3s ease 0s;
    transition: all 0.3s ease 0s;
    /* font-family: 'Raleway', sans-serif; */
    letter-spacing: 1px;
}

.single_pricing .order_now a,
.single_pricing .price_item_inner,
.single_pricing .pricing_title>h3 {
    -webkit-transition: .5s;
    transition: .5s;
}

.active .pricing_title h4 {
    color: #fff;
}

.single_pricing:hover .order_now a {
    background: #031657;
}

.single_pricing:hover .price_item span {
    color: #031657;
}


/*=============================
minister TESTIMONIAL AREA CSS
===============================*/

.testimonial_area {
    padding-top: 80px;
    padding-bottom: 55px;
}

.testimonial_area.about-pages {
    padding-top: 86px;
    padding-bottom: 128px;
    background: #fff;
}

.single_testimonial {
    text-align: center;
    margin-bottom: 30px;
    transition: .3s;
    background: #fff;
}

.em_testi_text p::before {
    display: none;
}

.em_testi_text {
    background: #deb668;
    padding: 20px 25px 20px;
    position: relative;
    border-radius: 5px;
}


.em_testi_text::before {
    position: absolute;
    left: 0;
    right: 0;
    bottom: -14px;
    width: 30px;
    height: 30px;
    background: #deb668;
    content: "";
    margin: auto;
    transform: rotate(135deg);
}

.em_testi_text p {
    position: relative;
    margin-top: 0;
    color: #fff;
}
.single_testimonia:hover .em_testi_text,
.single_testimonia:hover .em_testi_text:before {
    background: #041B5E;
}
.em_test_thumb {
    float: none;
    overflow: hidden;
    margin: 30px 0 15px;
}

.testimonial_area .em_test_thumb img {
    border-radius: 100%;
}

.em_testi_title h2 {
    font-size: 20px;
    text-align: center;
    margin-top: 0;
}

.em_testi_title h2 span {
    display: block;
    font-size: 15px;
    color: #deb668;
    margin-top: 4px;
    font-weight: 500;
}

.testi_review {
    margin-top: 10px;
}

.testi_review i {
    color: #deb668;
    margin: 0 2px;
}

.testimonial_area .col-md-6,
.testimonial_area .col-lg-6 {
    margin: 0;
    padding: 0;
}


/*=======================
minister VIDEO AREA CSS
=========================*/

.single_video {
    margin-top: 30px;
}

.video_image {
    position: relative;
}

.video_image img {
    width: 100%;
}

.choose_video_icon {}

.video_icon {
    position: absolute;
    top: 50%;
    left: 50%;
    z-index: 9999;
    transform: translateY(-50%) translateX(-50%);
}

.video_icon a {
    text-align: center;
    display: inline-block;
}

.video_icon a i {
    color: #fff;
    border: 5px solid #fff;
    width: 90px;
    height: 90px;
    line-height: 80px;
    font-size: 40px;
    border-radius: 50%;
}

.abtext em {
    color: #444;
    font-weight: 600;
}

.abtext ol {
    padding-left: 15px;
}

.abtext ol li {
    font-weight: 600;
    line-height: 30px;
}

.creative_title {
    letter-spacing: 0;
}


/*======================
 minister TEAM AREA CSS
========================*/

.team_area {
    padding: 86px 0 70px;
    background: #f7f7f7;
}

.single_team {
    position: relative;
    z-index: 1;
    overflow: hidden;
    margin-bottom: 30px;
}

.team_content {
    text-align: center;
    border: 1px solid #ddd;
    padding: 0 0 12px;
}

.team_thumb {
    position: relative;
}

.team_social {
    position: absolute;
    content: "";
    height: 100%;
    width: 100%;
    left: -100%;
    /* transform: translateX(-50%) translateY(-50%); */
    text-align: center;
    top: 0;
    /* z-index: -1; */
    background: rgba(0, 0, 0, 0.75);
    transition: .5s;
}

.team_socials_inner {
    position: relative;
    top: 50%;
    transform: translateY(-50%);
}

.team_socials_inner a {
    font-size: 20px;
    background: #deb668;
    width: 40px;
    height: 40px;
    line-height: 40px;
    display: inline-block;
    margin: 0 3px;
    border-radius: 100%;
    color: #fff;
}

.team_socials_inner a:hover {
    background: #fff;
    color: #deb668;
}

.single_team:hover .team_social {
    left: 0;
}


/*=======================
minister BLOG AREA CSS
=========================*/
.blog_area {
    padding: 79px 0 70px;
}
.blog_area.blog-grid {
    padding: 100px 0 72px;
}

.blog_area.blog-grid.blog-details-area {
    padding: 100px 0 97px;
}

.minister-single-blog {
    background-color: #fff;
    overflow: hidden;
    text-align: left;
    -webkit-transition: all 0.3s ease-in-out 0s;
    transition: all 0.3s ease-in-out 0s;
    margin-bottom: 30px;
    box-shadow: 0 0 4px rgba(0, 0, 0, 0.20);
}

.minister-single-blog:hover {
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.blog_thumb_inner {
    position: relative;
}

.minister-blog-thumb {
    overflow: hidden;
    position: relative;
}

.minister-blog-thumb a {
    position: relative;
}

.minister-blog-thumb a {
    display: block;
}

.minister-blog-thumb img {
    display: block;
    -webkit-transition: 6s;
    transition: 6s;
    width: 100%;
}

.blog-page-title h2 {
    font-size: 24px;
}

.minister-single-blog-title h2 {
    font-size: 24px;
}

.em-blog-content-area {
    padding: 18px 15px 25px;
    text-align: center;
}

.blog-inner {}

.blog-content {}

.blog-content h2 {
    margin: 0 0 18px;
}

.blog-page-title a {
    color: #333;
    display: block;
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 14px;
    text-transform: capitalize;
    -webkit-transition: all 0.5s ease 0s;
    transition: all 0.5s ease 0s;
}

.blog-page-title a:hover {
    color: #deb668;
}

.blog-content h2 a {
    font-size: 15px;
    font-weight: 700;
    text-transform: uppercase;
}

.blog-content h2 a:hover {
    color: #deb668;
}

.blog-content p {
    margin-bottom: 0;
}

.blog_icon {
    position: absolute;
    left: 50%;
    top: 50%;
    text-align: center;
    z-index: 999;
    transform: translateX(-50%) translateY(-50%);
    opacity: 0;
    transition: .5s;
}

.blog_icon a {
    color: #deb668;
    width: 45px;
    height: 45px;
    line-height: 45px;
    background: #fff;
    border-radius: 50%;
    transform: scale(0);
    font-size: 18px;
}

.blog-page-title {}

.blog-page-title h2 {}

.blog-page-title h2 a {
    color: #333;
}

.minister-blog-meta {
    margin-bottom: 0px;
    margin-top: 0;
    border-top: 1px solid #ddd;
    padding: 11px 15px 10px;
}

.minister-blog-meta:after {
    display: block;
    clear: both;
    content: "";
}

.minister-blog-meta-left {
    text-align: center;
    position: absolute;
    bottom: -6px;
    background: #fff;
    width: 87%;
    left: 0;
    padding: 15px 15px 15px;
    box-shadow: 0 0 4px rgba(0, 0, 0, 0.20);
    right: 0;
    margin: auto;
    border-radius: 5px;
}

.minister-blog-meta-left a,
.minister-blog-meta-right a,
.minister-blog-meta-left span,
.minister-blog-meta-right span {
    font-weight: 400;
    margin-right: 15px;
    text-transform: capitalize;
}

.minister-blog-meta-left a:hover,
.minister-blog-meta-left span:hover {
    color: #deb668;
}

.minister-blog-meta-left i {
    margin-right: 5px;
    color: #deb668;
}

.blog-page-title_adn>h2 {
    margin-bottom: 8px;
}

.minister-blog-meta-right {
    float: right;
    overflow: hidden;
}

.minister-blog-meta-right a,
.minister-blog-meta-right span {
    color: #454545;
    font-size: 12px;
    font-weight: 400;
    margin-right: 0;
    text-transform: uppercase;
}

.minister-blog-meta-right i {
    margin-right: 5px;
    color: #deb668;
}

.readmore a {
    border: 1px solid #ddd;
    color: #444;
    display: inline-block;
    font-size: 11px;
    font-weight: 400;
    padding: 6px 10px;
    text-transform: uppercase;
    transition: all 0.5s ease 0s;
    -webkit-transition: all 0.5s ease 0s;
    -moz-transition: all 0.5s ease 0s;
    -o-transition: all 0.5s ease 0s;
    -ms-transition: all 0.5s ease 0s;
}

.readmore a:hover {
    border-color: #deb668;
    background: #deb668;
    color: #fff;
}

.blog_btn a {
    border: 1px solid #DEB668;
    display: inline-block;
    padding: 6px 23px;
    text-transform: uppercase;
    font-size: 14px;
    border-radius: 5px;
    margin-top: 20px;
    color: #DEB668;
    font-weight: 600;
    box-shadow: 0 5px 12px rgba(0, 0, 0, 0.20);
    transition: .3s;
}

.blog_btn a:hover {
    background: #deb668;
    color: #fff;
    border-color: #deb668;
}


/* blog hover */

.minister-single-blog:hover .minister-blog-thumb:before {
    opacity: 1;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
    transform: scale(1);
}

.minister-single-blog:hover .blog_icon {
    opacity: 1;
}

.minister-single-blog:hover .blog_icon a {
    transform: scale(1)
}

.blog_nospace.col-xs-12 {
    padding: 0px;
}

.blog_nospace .minister-single-blog {
    margin-bottom: 0px;
}


/*===============================
minister BLOG DETAILS AREA CSS
================================*/

.blog_details {
    border: 1px solid #ddd;
    padding: 15px 15px 21px;
}

.blog_dtl_thumb {}

.blog_dtl_thumb {}

.blog_dtl_content {}

.blog_dtl_content h2 {
    padding-bottom: 8px;
    padding-top: 14px;
}

.blog_dtl_content h3 {
    padding-top: 20px;
    font-size: 20px;
}

.blog_dtl_content p {
    margin-top: 20px;
}

.blog_details .minister-blog-meta {
    margin-bottom: 0px;
    margin-top: 0;
    /* border-top: 1px solid #ddd; */
    padding: 0 0 18px;
    border-bottom: 1px solid #ddd;
    border-top: 0;
}
.blog_details .minister-blog-meta-left {
    text-align: left;
    position: inherit;
    bottom: inherit;
    background: transparent;
    width: inherit;
    left: inherit;
    padding: 0;
    box-shadow: none;
    right: 0;
    margin: auto;
    border-radius: 0;
}
.blog_details .minister-blog-meta-right {
    float: right;
    overflow: hidden;
    margin-top: -26px;
}
.blog_details blockquote {
    padding: 10px 20px;
    margin: 37px 0 36px;
    font-size: 14px;
    border-left: 7px solid #deb668;
    background: #f7f7f7;
    font-style: italic;
    font-weight: 500;
    padding: 15px 35px 15px;
}

.signatures {
    text-align: right;
    font-weight: 600;
    font-style: italic;
    font-size: 15px;
}


/* POST REPLY CSS */

.blog_comments_section {
    border: 1px solid #ddd;
    padding: 20px 15px 18px;
    margin: 50px 0 0;
}

.comments_ttl>h3 {
    font-size: 20px;
    font-weight: 700;
    position: relative;
}

.comments_ttl {
    margin-bottom: 37px;
}

.comments_ttl>h3::before {
    background: #deb668 none repeat scroll 0 0;
    content: "";
    height: 1px;
    left: 131px;
    position: absolute;
    top: 12px;
    width: 40px;
}

.comments_thumb {
    float: left;
    margin-right: 20px;
    overflow: hidden;
}

.commentst_content {
    overflow: hidden;
}

.blog_comments_section .post_meta {
    margin-bottom: 6px;
}

.blog_comments_section .post_meta span {
    /* font-size: 12px; */
    font-weight: 400;
    padding-right: 15px;
    /* text-transform: uppercase; */
    color: #6d6d6d;
}

.blog_comments_section .post_meta span:hover {
    color: #deb668;
}

.blog_comments_section .post_meta span:last-child:before {
    display: none;
}

.commentst_meta_reply {
    float: right;
}

.commentst_meta_reply i {
    margin-right: 10px;
}

.commentst_meta_reply:hover {
    color: #deb668;
}

.single_commentst_inner {
    margin-bottom: 44px;
    margin-top: 46px;
    padding-left: 63px;
}

.badmin i {
    margin-right: 3px;
}


/* COMMENT FORM CSS */

.blog_reply {
    overflow: hidden;
    border: 1px solid #ddd;
    margin-top: 50px;
    padding: 20px 15px 10px;
}

.reply_ttl>h3 {
    font-size: 20px;
    position: relative;
}

.reply_ttl {
    margin-bottom: 36px;
}

.reply_ttl>h3::before {
    background: #deb668 none repeat scroll 0 0;
    content: "";
    height: 1px;
    left: 194px;
    position: absolute;
    top: 12px;
    width: 40px;
}

.blog_reply .em_contact_form {
    margin-bottom: 0;
}

.blog_reply .contact_bnt button:hover {
    background: #0D2352;
    color: #fff;
}


/* contact area css */
.contact_area {
    background: #f7f7f7;
    padding: 81px 0 160px;
}

.contact_info {
    border: 1px solid #ddd;
    padding: 55px 20px 21px;
    border-radius: 10px;
    background: #fff;
}

.single_plases {
    margin-bottom: 35px;
    border-bottom: 1px solid #ddd;
    padding-bottom: 34px;
}

.single_plases_inner {
    text-align: left;
}

.plases_icon {
    float: left;
    overflow: hidden;
}

.plases_icon i {
    font-size: 26px;
    overflow: hidden;
    width: 50px;
    height: 50px;
    line-height: 50px;
    border-radius: 100%;
    text-align: center;
    /* border: 1px solid #ddd; */
    margin-right: 15px;
    transition: .3s;
    background: #deb668;
    color: #fff;
}

.single_plases:hover .plases_icon i {
    background: #deb668;
    color: #fff;
    border-color: #deb668;
}

.plases_text {
    overflow: hidden;
}

.plases_text h2 {
    font-size: 14px;
    font-weight: 400;
    color: #fff;
    margin-bottom: 2px;
}

.plases_text p {
    font-size: 14px;
    font-weight: 400;
    /* color: #fff; */
    margin-top: 0;
    margin-bottom: 0px;
}

.em_contact_form {
    margin-bottom: 100px;
}

.contact_form_inner {}

.form_field {
    width: 100%;
}

.form_field_inner {
    margin-bottom: 25px;
    width: 100%;
}

.form_field_inner input,
.form_field_inner input,
.field_comment_inner textarea {
    background: transparent;
    /* border: 1px solid #ddd; */
    color: #fff;
    font-size: 16px;
    font-weight: 500;
    height: 50px;
    -webkit-transition: all 0.3s ease 0s;
    border-bottom: 1px solid #fff;
    transition: all 0.3s ease 0s;
    width: 100%;
    outline: none;
    background: #fff;
    border: 1px solid #ddd;
    padding-left: 15px;
    border-radius: 10px;
}

.form_field_inner input:focus {
    border-color: #deb668;
}

.field_comment_inner textarea:focus {
    border-color: #deb668;
}

.form_field_inner input:hover {}

.form_field_comment {}

.field_comment_inner {}

.field_comment_inner textarea {
    height: 125px;
    padding-top: 10px;
}

.contact_bnt {
    margin-top: 23px;
}

.contact_bnt button {
    background: #deb668;
    border: 0 none;
    border-radius: 0;
    color: #fff;
    display: block;
    letter-spacing: 2px;
    padding: 14px 50px;
    margin: auto;
    border-radius: 10px;
    text-transform: capitalize;
    transition: .3s;
    width: 100%;
    margin-top: -4px;
}

.contact_bnt button:hover {
    background: #0d2352;
    color: #fff;
}

.google_map_area {
    pointer-events: none;
}

.map {
    width: 100%;
    margin: 0;
    height: 338px;
    border: 1px solid #ddd;
    border-radius: 10px;
}

 ::-webkit-input-placeholder {
    /* Chrome/Opera/Safari */
    color: #666;
}

 ::-moz-placeholder {
    /* Firefox 19+ */
    color: #666;
}

 :-ms-input-placeholder {
    /* IE 10+ */
    color: #666;
}

 :-moz-placeholder {
    /* Firefox 18- */
    color: #666;
}

.em_contact_form ::-webkit-input-placeholder {
    /* Chrome/Opera/Safari */
    color: #333 !important;
    font-size: 14px;
    font-weight: 400;
}

.em_contact_form ::-moz-placeholder {
    /* Firefox 19+ */
    color: #333 !important;
    font-size: 14px;
    font-weight: 400;
}

.em_contact_form :-ms-input-placeholder {
    /* IE 10+ */
    color: #333 !important;
    font-size: 14px;
    font-weight: 400;
}

.em_contact_form :-moz-placeholder {
    /* Firefox 18- */
    color: #333 !important;
    font-size: 14px;
    font-weight: 400;
}

.em_contact_form ::-webkit-input-placeholder {
    /* Chrome/Opera/Safari */
    color: #333 !important;
    font-size: 14px;
    font-weight: 400;
}

.em_quote_form ::-webkit-input-placeholder {
    /* Chrome/Opera/Safari */
    color: #fff !important;
    font-size: 14px;
    font-weight: 400;
}

.em_quote_form ::-moz-placeholder {
    /* Firefox 19+ */
    color: #fff !important;
    font-size: 14px;
    font-weight: 400;
}

.em_quote_form :-ms-input-placeholder {
    /* IE 10+ */
    color: #fff !important;
    font-size: 14px;
    font-weight: 400;
}

.em_quote_form :-moz-placeholder {
    /* Firefox 18- */
    color: #fff !important;
    font-size: 14px;
    font-weight: 400;
}

.em_quote_form ::-webkit-input-placeholder {
    /* Chrome/Opera/Safari */
    color: #fff !important;
    font-size: 14px;
    font-weight: 400;
}

.home-2 ::-moz-placeholder {
    /* Firefox 19+ */
    color: #333 !important;
    font-size: 14px;
    font-weight: 400;
}

.home-2 :-ms-input-placeholder {
    /* IE 10+ */
    color: #333 !important;
    font-size: 14px;
    font-weight: 400;
}

.home-2 :-moz-placeholder {
    /* Firefox 18- */
    color: #333 !important;
    font-size: 14px;
    font-weight: 400;
}


/*==========================
minister FOOTER TOP CSS
===========================*/

.footer-middle {
    background: #1a1a1a none repeat scroll 0 0;
    padding: 68px 0 92px;
}

.footer-middle {
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center center;
    background: #0D2352;
}

.footer-middle.wpfd {
    padding: 0;
}

.wpfdp {
    padding-top: 0px;
    padding-bottom: 80px;
}

.footer-middle .widget h2 {
    color: #fff;
    margin-bottom: 57px;
    margin-top: 28px;
    position: relative;
}

.footer-middle .widget h2:before {
    position: absolute;
    left: 0;
    bottom: -10px;
    content: "";
    width: 60px;
    height: 2px;
    background: #fff;
}

.footer-middle .widget ul li,
.footer-middle .widget ul li a,
.footer-middle .widget ul li:before,
.footer-middle .tagcloud a,
.footer-middle caption,
.footer-middle table,
.footer-middle table td a,
.footer-middle cite,
.footer-middle .rssSummary,
.footer-middle span.rss-date,
.footer-middle span.comment-author-link,
.footer-middle .textwidget p,
.footer-middle .widget .screen-reader-text {
    color: #fff;
}

.footer-middle .widget h2 {}

.footer-middle .widget ul li:before {}

.footer-middle .tagcloud a {}

.footer-middle .widget ul {
    list-style: none;
}

.footer-middle .widget ul li {
    margin-bottom: 20px;
    list-style: none;
}

.footer-middle .widget ul li a,
.footer-middle .widget ul li:before {
    -webkit-transition: .5s;
    transition: .5s;
}

.footer-middle .widget ul li a:hover,
.footer-middle .widget ul li:hover:before {
    color: #deb668;
}

.footer_s_inner {}

.footer_s_thumb {}

.footer_s_thumb img {}

.footer_s_content {}

.footer_s_content h2 {}

.footer_s_content p {}

.recent-portfolio-area {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-flow: row;
    flex-flow: row;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
}


/* Company Info Css */

.company_info_desc {
    padding-bottom: 23px;
}

.single_company_info {
    margin-bottom: 24px;
}

.single_company_info i {
    color: #fff;
    font-size: 15px;
    border: 1px solid #fff;
    float: left;
    border-radius: 50%;
    margin-right: 15px;
    line-height: 28px;
    height: 30px;
    width: 30px;
    text-align: center;
    transition: .3s;
}

.single_company_info:hover i {
    background: #deb668;
    color: #fff;
    border-color: #deb668;
}

.company_info_desc p {
    color: #fff;
}

.single_company_info p {
    color: #fff;
    padding-top: 3px;
}


/* recent post */

.single-widget-item {
    overflow: hidden;
}

.recent-post-item {
    clear: both;
}

.recent-post-image {
    float: left;
    margin-right: 10px;
}

.recent-post-image a {
    display: inline-block;
    margin-top: 6px;
    margin-bottom: 5px;
}

.recent-post-text {
    margin-top: -4px;
    overflow: hidden;
}

.recent-post-text h4 a {
    color: #333;
}

.recent-post-text .rcomment i {
    margin-right: 5px;
}

.recent-post-text .rcomment {
    color: #333;
}

.recent-post-item {
    clear: both;
}

.recent-post-image {
    float: left;
    margin-right: 10px;
}

.recent-post-text {
    overflow: hidden;
}

.recent-post-text>h4 {
    margin-bottom: 0;
}

.recent-post-text h4 a {
    color: #333;
    font-size: 14px;
    -webkit-transition: all 0.3s ease 0s;
    transition: all 0.3s ease 0s;
}

.recent-post-text h4 a:hover {
    color: #deb668;
}

.recent-post-text .rcomment {
    color: #333;
    font-size: 14px;
    text-transform: none;
}

.recent-post-text .rcomment i {
    margin-right: 5px;
}

.recent-post-text .rcomment {
    color: #333;
}

.footer-middle .recent-post-text h4 a {
    color: #fff;
    font-weight: 600;
}

.footer-middle .recent-post-text>h4 {
    margin-bottom: 5px;
    font-weight: 500;
    line-height: 1;
}

.footer-middle .recent-post-text>h4 a:hover {
    color: #deb668;
}

.footer-middle .recent-post-text .rcomment {
    color: #ddd;
    font-size: 12px;
    font-weight: 400;
}

.footer_contact_info {
    text-align: center;
    background: #0D2352;
    overflow: hidden;
    color: #fff;
    border-radius: 11px;
    box-shadow: 0 6px 30px rgba(0, 0, 0, .30);
    margin-top: -136px;
    margin-bottom: 67px;
}

.single_footer_contact {
    padding: 30px 0 20px;
    border-right: 1px solid rgba(255, 255, 255, 0.20);
}

.single_footer_contact.last {
    border-right: 0;
}

.contact_info_icon i {
    font-size: 40px;
    color: #fff;
    display: inline-block;
    /* width: 60px; */
    /* height: 60px; */
    text-align: center;
    /* background: #fff; */
    /* line-height: 60px; */
    border-radius: 100%;
    margin-bottom: 15px;
}

.single_footer_contact p {
    font-size: 18px;
    font-weight: 500;
}

.single_footer_contact p span {
    display: block;
    font-weight: 400;
    font-size: 15px;
}


/* Blog Widget Css */

.blog-grid .recent-post-text>h4 {
    margin-bottom: 3px;
    line-height: 18px;
}

.blog-grid .recent-post-text .rcomment {
    color: #6d6d6d;
    font-size: 12px;
}


/* Get quote css */

.em_quote_form {}

.quote_form_inner {
    padding-top: 6px;
}

.quote_form_field {}

.quote_form_field input {
    width: 100%;
    height: 40px;
    margin-bottom: 16px;
    background: #041842;
    border: 0;
    padding-left: 15px;
    border-radius: 5px;
    color: #fff;
}

.quote_form_field textarea {
    width: 100%;
    height: 115px;
    border: 0;
    padding-left: 15px;
    border-radius: 5px;
    color: #fff;
    background-color: #041842;
}

.quote_button {
    width: 100%;
    height: 40px;
    margin-top: 16px;
    border: 0;
    border-radius: 5px;
    background: #fff;
    color: #444;
    transition: .5s;
    text-transform: uppercase;
    font-size: 14px;
    font-weight: 500;
}

.quote_button:hover {
    background: #deb668;
    color: #fff;
}


/*===============================
minister FOOTER BOTTOM AREA CSS
================================*/

.footer-bottom {
    background: #0D2352 none repeat scroll 0 0;
    padding: 26px 0 24px;
    border-top: 1px solid rgba(255, 255, 255, 0.20);
}

.copy-right-text {}

.copy-right-text p {
    color: #fff;
    font-size: 14px;
    margin: 7px 0 0;
    padding: 0;
}

.footer-menu {}

.footer-menu ul {
    list-style: none;
    margin: 0px;
    padding: 0px;
}

.footer-menu ul li {
    display: inline-block;
}

.footer-menu ul li a {
    color: #fff;
    margin-left: 10px;
    text-align: center;
    color: #fff;
    font-size: 16px;
    transition: .3s;
}

.footer-menu ul li a:hover {
    color: #deb668;
}

.copy-right-text a:hover {
    color: #deb668;
}

.footer-menu ul li:last-child a {
    padding-right: 0px;
}

.footer_style_3 .footer-menu ul li:first-child a {
    padding-left: 0px;
}

.footer-menu ul ul {
    display: none;
}
.social_media h3 {
    font-size: 21px;
    color: #fff;
    padding-bottom: 20px;
    margin-top: 0;
}
.social_media a {
    display: inline-block;
    background: #deb668;
    color: #fff;
    width: 35px;
    height: 35px;
    text-align: center;
    font-size: 16px;
    line-height: 35px;
    border-radius: 100%;
    margin-right: 6px;
    transition:.3s;
}
.social_media a:hover{
    background:#fff; 
    color:#deb668;
}

/*==========================
minister OTHERS PAGES CSS
===========================*/

.row.sg {
    margin-top: 38px;
}


/*==========================
minister COUNTER AREA CSS
===========================*/

.counter_area {
    background: #f7f7f7;
    background-image: url(assets/images/counter-bg.jpg);
    background-size: cover;
    background-position: center center;
    background-repeat: no-repeat;
    padding: 100px 0 91px;
}

.single_counter {
    position: relative;
    text-align: center;
    -webkit-transition: all 0.3s ease 0s;
    transition: all 0.3s ease 0s;
}

.counter_icon {
    margin-top: 0;
    padding-top: 0;
    position: relative;
    transition: .5s;
}

.single_counter:hover .counter-icon {
    color: #fff;
}

.counter_icon i {
    height: 90px;
    width: 90px;
    margin: auto;
    background: transparent;
    line-height: 74px;
    border-radius: 7px;
    font-size: 36px;
    color: #deb668;
    background: #fff;
    border-radius: 100%;
    transition: .5s;
    display: inline-block;
    border: 8px solid #deb668;
}

.counter_icon i:hover {
    background: #041B5E;
    color: #fff;
}

.countr_text>h1 {
    display: inline-block;
    font-size: 36px;
    font-weight: 700;
    -webkit-transition: .3s;
    margin: 15px 0 0;
    transition: .3s;
    font-family: Poppins, sans-serif;
    position: relative;
}

.countr_text>h3 {
    display: inline-block;
    font-size: 50px;
    font-family: Poppins, sans-serif;
    color: #deb668;
}

.counter_title {
    padding: 0 0 0;
}

.counter_title h4 {
    font-size: 18px;
    font-weight: 600;
    margin: 0;
    text-transform: uppercase;
    -webkit-transition: .3s;
    transition: .3s;
    padding-top: 20px;
}


/*================================
minister CALL DO ACTION AREA CSS
=================================*/

.call-to-action_area {
    background: #deb668;
    padding: 80px 0 100px;
    background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), transparent url(assets/images/video-bg1.jpg) 0% 0%/cover repeat scroll;
    background-position: center center;
    background-attachment: fixed;
}

.em_call-to-action {}

.em_single_call-to-action_content {
    text-align: center;
}

.em_call-to-action_title {}

.em_call-to-action_title h2 {
    font-size: 41px;
    font-weight: 700;
    /* text-transform: capitalize; */
    margin-bottom: 13px;
    color: #fff;
}

.em_call-to-action_title h2 span {
    display: block;
    font-size: 36px;
    margin-top: 10px;
}

.em_call-to-action_inner {}

.em_call-to-action_desc {
    color: #fff;
    width: 55%;
    margin: auto;
    margin-left: 0;
    font-size: 16px;
    margin: auto;
}

.call-to-action_btn {}

.call-to-action_btn a {
    border: none;
    display: inline-block;
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    background-color: #deb668;
    border-radius: 50px;
    color: #fff;
    margin: 38px 10px 0;
    padding: 12px 40px;
    -webkit-transition: .5s;
    transition: .5s;
    letter-spacing: 2px;
}

.call-to-action_btn a.active {
    background: #fff;
    color: #deb668;
}

.call-to-action_btn a:hover {
    background: #031458;
    color: #fff;
}

.em-call-to_video {
    position: absolute;
    right: -40px;
    top: 50%;
    width: 24%;
    transform: translateY(-50%);
}

.em-call-video_link {
    float: left;
    margin-right: 20px;
}

.em-call-video_link a {
    font-size: 28px;
    margin-top: 9px;
    color: #fff;
    font-weight: 600;
}

.em-call-video_link a i {
    font-size: 28px;
    margin-top: 9px;
    color: #fff;
    margin-right: 15px;
}


/*================================
minister INSTAGRAM AREA CSS
=================================*/

.instadram_area {
    background: linear-gradient(rgba(0, 0, 0, 0.87), rgba(0, 0, 0, 0.87)), transparent url(assets/images/cn.jpg) 0% 0%/cover repeat scroll;
    background-repeat: no-repeat;
    background-size: cover;
    padding: 80px 0 100px;
}

.row.insta .col-md-2 {
    padding: 0px;
}

.instragram_thumb img {
    width: 100%;
}


/*=======================
minister BRAND AREA CSS
=========================*/

.brand-area {
    /* background: #f7f7f7; */
    padding: 0 0 82px;
    border-bottom: 1px solid #ddd;
}

.single_brand {
    transform: scale(1);
    transition: .5s;
    margin-top: 10px;
    margin-bottom: 20px;
}

.single_brand:hover {
    transform: scale(1.1);
    transition: .5s;
}

.single_brand_inner {}

.single_brand_thumb {}

.single_brand_thumb img {}


/*===========================
minister BREADCRUMB AREA CSS
=============================*/
.breatcome_area {
    background: linear-gradient(rgba(0, 0, 0, 0.71), rgba(0, 0, 0, 0.71)), transparent url(assets/images/brd-bg.jpg) 0% 0%/cover repeat scroll;
    background-position: center center;
    background-size: cover;
    background-repeat: no-repeat;
    padding: 215px 0 120px;
}

.breatcome_title {}

.breatcome_title_inner h2 {
    color: #fff;
    text-align: center;
    margin: 0;
    font-size: 41px;
    margin-bottom: 6px;
    font-weight: 700;
}

.breatcome_content {}

.breatcome_content ul {
    text-align: center;
}

.breatcome_content ul li {
    list-style: none;
    color: #fff;
    font-size: 15px;
    font-weight: 500;
    text-transform: capitalize;
}

.breatcome_content ul li a {
    color: #fff;
    text-transform: capitalize;
    font-size: 15px;
    font-weight: 500;
    margin-right: 5px;
}

.breatcome_content ul li a i {
    margin-left: 5px;
}


/*========================
 minister UNITETEST
=========================*/

.blog-page-title h2 {
    color: #333;
    display: block;
    font-size: 22px;
    font-weight: 600;
    margin-bottom: 7px;
    text-transform: capitalize;
    -webkit-transition: all 0.5s ease 0s;
    transition: all 0.5s ease 0s;
}

.blog-page-title a {
    color: #333;
    display: inline-block;
    font-weight: 600;
}

.blog-page-title h2 a:hover {
    color: #deb668;
}

.single-blog-content iframe {
    margin-top: 20px;
}

.blog-content h1,
.blog-content h2,
.blog-content h3,
.blog-content h4,
.blog-content h5,
.blog-content h6 {
    margin-top: 10px;
    margin-bottom: 10px;
    font-weight: 500;
    color: #333;
    font-size: 30px;
}

.post_reply h1,
.post_reply h2,
.post_reply h3,
.post_reply h4,
.post_reply h5,
.post_reply h6 {
    color: #303030;
    font-size: 30px;
    font-weight: 500;
    margin-top: 15px;
    margin-bottom: 15px;
}

.blog-content h2,
.post_reply h2 {
    font-size: 26px;
}

.blog-content h3,
.post_reply h3 {
    font-size: 22px;
}

.blog-content h4,
.post_reply h4 {
    font-size: 20px;
}

.blog-content h5,
.post_reply h5 {
    font-size: 18px;
}

.blog-content h6,
.post_reply h6 {
    font-size: 17px;
}


/* single blog */

.single-blog-content h1,
.single-blog-content h2,
.single-blog-content h3,
.single-blog-content h4,
.single-blog-content h5,
.single-blog-content h6 {
    margin-bottom: 22px;
    margin-top: 20px;
    font-size: 30px;
    font-weight: 600;
}

.single-blog-content h2 {
    font-size: 26px;
}

.single-blog-content h3 {
    font-size: 22px;
}

.single-blog-content h4 {
    font-size: 20px;
}

.single-blog-content h5 {
    font-size: 18px;
}

.single-blog-content h6 {
    font-size: 17px;
}


/*=============================
 minister PAGINATION AREA CSS
===============================*/

.paginations {
    text-align: center;
    margin-top: 20px;
    margin-bottom: 28px;
}

.paginations a,
.page-numbers span.current {
    width: 35px;
    height: 35px;
    line-height: 35px;
    display: inline-block;
    font-size: 14px;
    font-weight: 500;
    margin: auto 5px;
    border: 1px solid #ddd;
    color: #888;
}

.page-numbers li {
    display: inline-block;
}

.paginations a:hover,
.paginations a.current,
.page-numbers span.current {
    background: #deb668;
    border-color: #deb668;
    color: #fff;
}


/*========================
minister 404 AREA CSS
=========================*/

.not-found-area {
    background-color: #fff;
    background-position: center top;
    background-repeat: repeat;
    background-size: cover;
    border-top: 1px solid #f5f3f3;
    padding: 0 0 16px;
}

.not-found {
    display: table;
    width: 100%;
    height: 500px;
    text-align: center;
    padding-bottom: 40px;
}

.not-found-inner {
    display: table-cell;
    vertical-align: middle;
}

.not-found-inner {
    font-size: 30px;
}

.not-found-inner h2 {
    color: #f01e4a;
    display: inline-block;
    font-size: 160px;
    font-weight: 700;
    line-height: 1.2;
    padding: 15px 0;
}

.not-found-inner p {
    font-size: 30px;
}

.not-found-inner a {
    color: #606b82;
    font-size: 24px;
    margin-top: 40px;
    display: inline-block;
    text-decoration: underline;
}


/* search error */

.minister-search-page {
    background: #fff;
}

.search-error .search input {
    padding: 20px 0;
}

.search-error .search input[type="text"] {
    padding-left: 10px;
}

.search-error .search button {
    top: 48%;
    -webkit-transform: translateY(-50%);
    transform: translateY(-50%);
}

.search-error>p {
    font-size: 14px;
    margin: 14px 0 19px;
}

.search-error>h3 {
    display: block;
    font-size: 30px;
    color: #333;
}

.search-error .search input {
    height: 54px;
    border: 1px solid #ddd;
}


/* RECENT PORTFOLIO */

.recent-portfolio {
    margin-bottom: 10px;
    margin-right: 10px;
}

.recent-portfolio {
    width: 29.33%;
}

.recent-portfolio-image img {
    width: 100%;
}


/*========================
minister SCROLL TOP CSS
=========================*/

#scrollUp {
    background: #deb668 none repeat scroll 0 0;
    bottom: 30px;
    color: #fff;
    font-size: 30px;
    height: 40px;
    line-height: 40px;
    right: 30px;
    text-align: center;
    width: 40px;
}

#scrollUp i {
    color: #fff;
}

.copy-right-text a {
    color: #deb668;
}

.template-home .vc_row {
    margin-left: 0px !important;
    margin-right: 0px !important;
}

.wpb_gallery.wpb_content_element.vc_clearfix {
    margin-bottom: 0;
}

.mean-container .mean-bar {
    float: none;
    background: #fff none repeat scroll 0 0;
}

.mean-container .mean-nav ul li li a {
    color: #333;
    opacity: 1;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
}


/* kc element */

.template-home-wrapper {
    overflow: hidden;
}

.kc-blog-posts-3 .kc-list-item-3>a img {
    -webkit-transition: all 0.5s ease 0s;
    transition: all 0.5s ease 0s;
}


/*==========================
minister SECTION TITLE CSS
===========================*/

.section-title.t_center {
    margin: auto;
    text-align: center;
    width: 63%;
}

.section-title.t_left {
    margin: auto auto auto 0;
    width: 63%;
    text-align: left;
}

.section-title.t_right {
    margin: auto 0 auto auto;
    width: 63%;
    text-align: right;
}

.section-title.t_right .em-bar {
    margin: 0 0 5px auto;
}

.section-title.t_left .em-bar {
    margin: 0 0 5px;
}

.section-title h2 {
    font-size: 40px;
    font-weight: 700;
    margin-bottom: 11px;
}

.section-title .icon {
    position: relative;
    padding-bottom: 10px;
}
.section-title .icon i {
    color: #DEB668;
    font-size: 22px;
}
.section-title .icon::before {
    content: "";
    left: -111px;
    right: 0;
    position: absolute;
    width: 70px;
    height: 2px;
    margin: auto;
    background: #DEB668;
    top: 11px;
}
.section-title .icon::after {
    content: "";
    right: -111px;
    left: 0;
    position: absolute;
    width: 70px;
    height: 2px;
    margin: auto;
    background: #DEB668;
    top: 11px;
}

.section-title h3 {
    font-size: 18px;
    color: #deb668;
}

.tmr0 .section-title h2 {
    margin: 0;
}

.section-title h5 {
    font-size: 18px;
    font-weight: 500;
    margin: 0;
}

.section-title p {
    margin-bottom: 60px;
}

.em-icon {}

.em-icon i {}

.em-bar-main {
    margin: 10px 0 13px;
}

.em-bar {
    background: #deb668 none repeat scroll 0 0;
    height: 2px;
    margin: 0 auto 5px;
    width: 62px;
}

.em-bar.em-bar-big {
    width: 80px;
}

.em-image {
    margin-bottom: 10px;
}

.em-image img {}

.section-title.t_left span {
    color: #deb668;
}


/* section title 2 css */

.section-title1 {
    text-align: center;
}

.section-title1 h2 {
    font-size: 41px;
    font-weight: 700;
    margin-bottom: 28px;
    text-transform: capitalize;
    color: #fff;
    position: relative;
}

.section-title1 p {
    color: #fff;
    margin-bottom: 48px;
}

.em-image1 {
    margin-bottom: 10px;
}

.em-image1 img {}

.section-title1 h2::after {
    position: absolute;
    content: "";
    left: -7px;
    bottom: -24px;
    width: 1px;
    height: 20px;
    background: #fff;
    margin: auto;
    right: 0;
}

.section-title1 h2::before {
    position: absolute;
    content: "";
    left: 2px;
    bottom: -24px;
    width: 1px;
    height: 20px;
    background: #fff;
    margin: auto;
    right: 0;
}
.count_down_area .section-title h2 {
    font-size: 33px;
    margin-bottom: 70px;
    text-transform: none;
    color: #fff;
}
.count_down_area .section-title .icon {
    position: relative;
    padding-bottom: 44px;
}

/*===========================
 minister SERVICE AREA  CSS
=============================*/

.service_area {
    padding: 79px 0 70px;
}

.em-service {
    padding: 40px 25px 26px;
    text-align: center;
    -webkit-transition: all 0.5s ease 0s;
    transition: all 0.5s ease 0s;
    background: #f7f7f7;
    box-shadow: 0 0 4px rgba(0, 0, 0, 0.20);
    margin-bottom: 30px;
    border-radius: 15px;
}

.em-service:hover {
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.20);
}

.service_top_text {
    display: block;
}

.em-service-img {
    -webkit-transition: all 0.5s ease 0s;
    transition: all 0.5s ease 0s;
}

.em-service-title {
    overflow: hidden;
}

.em-service-title h2 {
    margin: 20px 0 14px;
    padding: 0;
    text-transform: capitalize;
    -webkit-transition: all 0.5s ease 0s;
    transition: all 0.5s ease 0s;
}

.em-service-desc {
    -webkit-transition: .5s;
    transition: .5s;
}

.em-service-desc p {
    font-size: 14px;
}

.service-btn {
    margin-top: 2px;
}

.service-btn>a {
    border-radius: 30px;
    color: #333;
    display: inline-block;
    font-size: 14px;
    font-weight: 500;
    text-transform: capitalize;
    -webkit-transition: all 0.5s ease 0s;
    transition: all 0.5s ease 0s;
    border: 1px solid transparent;
}


/* Service Style Two */

.em_feature_flipbox {
    margin-bottom: 30px;
    perspective: 1000px;
    position: relative;
        transform-style: preserve-3d;
    -webkit-perspective: 1000px;
    -webkit-transform-style: preserve-3d;
}

.em_feature_flipbox .feature_flipbox_font,
.em_feature_flipbox .feature_flipbox_back {
    min-height: 270px;
    height: auto;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    transform: rotateY(0);
    -webkit-transform: rotateY(0);
    -webkit-transform-style: preserve-3d;
    transform-style: preserve-3d;
    transition: transform .7s ease, -webkit-transform .7s ease;
    position: relative;
}



.em_feature_flipbox .feature_flipbox_font {
    background: #f7f7f7;
}

.em_feature_flipbox .feature_flipbox_inner {
    text-align: center;
    padding: 0 15px;
    border-radius: 2px;
    position: absolute;
    left: 0;
    top: 50%;
    width: 100%;
    perspective: inherit;
    -webkit-perspective: inherit;
    outline: transparent solid 1px;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    -webkit-transform: translateY(-50%) translateZ(60px) scale(0.94);
    transform: translateY(-50%) translateZ(60px) scale(0.94);
    z-index: 2;
}
.feature_flipbox_icon {
    font-size: 29px;
    text-align: center;
    display: inline-block;
    color: #DEB668;
    overflow: hidden;
    width: 80px;
    height: 80px;
    line-height: 80px;
    background: #DEB668;
    color: #fff;
    border-radius: 100%;
}

.em_feature_flipbox .em-feature-title h2 {
    font-size: 22px;
    padding-bottom: 13px;
    text-transform: capitalize;
    -webkit-transition: all 0.7s ease 0s;
    transition: all 0.7s ease 0s;
}

.em_feature_flipbox .feature_flipbox_back {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    background: #deb668;
    border-radius: 2px;
    -webkit-transform: rotateY(180deg);
    transform: rotateY(180deg);
        -webkit-transform-style: preserve-3d;
    transform-style: preserve-3d;
}

.em_feature_flipbox .feature_flipbox_back .frb-batton a {
    color: #fff;
    text-transform: capitalize;
    margin-top: 22px;
    background: transparent;
    color: #fff;
    display: inline-block;
    padding: 3px 25px;
    border-radius: 30px;
    border: 2px solid #fff;
    transition: .5s;
}

.em_feature_flipbox .feature_flipbox_back .frb-batton a:hover {
    color: #fff;
    border-color: #04175A;
    background: #04175A;
}

.em_feature_flipbox .feature_flipbox_back .frb-batton a i {
    display: none;
}

.em_feature_flipbox .feature_flipbox_back .em-feature-title h2 {
    padding-bottom: 16px;
    padding-top: 0;
    color: #fff;
    margin-bottom: 0;
}

.em_feature_flipbox .feature_flipbox_font .em-feature-desc,
.em_feature_flipbox .feature_flipbox_back .em-feature-desc {
    color: #fff;
}

.em_feature_flipbox:hover .feature_flipbox_font {
    -webkit-transform: rotateY(-180deg);
    transform: rotateY(-180deg);
}

.em_feature_flipbox:hover .feature_flipbox_back {
    -webkit-transform: rotateY(0deg);
    transform: rotateY(0deg);
}


/*============================
 MINISTER PORTFOLIO AREA CSS
=============================*/
.portfolio_area {
    padding: 80px 0 0;
}

.section-title.t_center.port p {
    width: 63%;
    margin: auto;
    margin-bottom: 49px;
}

.portfolio_menu {
    text-align: center;
    margin: 0px 0 40px;
}

.portfolio_menu ul {}

.portfolio_menu ul li {
    border-radius: 30px;
    color: #333;
    cursor: pointer;
    display: inline-block;
    font-size: 13px;
    font-weight: 500;
    margin: 0 5px 10px;
    padding: 6px 27px;
    position: relative;
    text-transform: uppercase;
    -webkit-transition: all 0.3s ease 0s;
    transition: all 0.3s ease 0s;
    background: #fff;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.20);
}

.portfolio_menu ul li:hover,
.portfolio_menu ul li.current_menu_item {
    color: #fff;
    background: #deb668  none repeat scroll 0 0;
    border-color: #deb668 ;
}


/* single portfolio css */

.row.li .col-md-4,
.row.li .col-md-3 {
    padding: 0;
}

.single_portfolio {
    overflow: hidden;
}

.single_portfolio_inner {
    position: relative;
    z-index: 1;
}

.single_portfolio_thumb {
    position: relative;
    z-index: -1;
}

.single_portfolio_thumb::before {
    position: absolute;
    content: "";
    background: none;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    transition: .5s;
    transform: scale(1);
}

.single_portfolio:hover .single_portfolio_thumb::before {
    background: rgba(235, 27, 43, 0.7);
    transform: scale(1.2);
    z-index: 1;
}

.single_portfolio_thumb img {
    width: 100%;
    transform: scale(1);
    transition: .5s;
}

.single_portfolio:hover .single_portfolio_thumb img {
    transform: scale(1.2);
}

.single_portfolio_icon {
    position: absolute;
    right: 0;
    bottom: -55px;
    z-index: 1;
    left: 0;
    margin: auto;
    transition: .5s;
    text-align: center;
    transition-delay: .5s;
}

.single_portfolio_icon i {
    font-size: 17px;
    height: 40px;
    width: 40px;
    line-height: 40px;
    border-radius: 50%;
    background: #FFF;
    text-align: center;
    color: #c91826;
    margin: 0px 5px;
}

.single_portfolio:hover .single_portfolio_icon {
    bottom: 30px;
}

.link i {
    transition-delay: 1s;
}

.portfolio_content_inner p span {
    font-size: 14px;
    font-weight: 500;
    color: #fff;
    text-transform: capitalize;
}

.portfolio_content_inner h3 a {
    color: #fff;
}

.portfolio_content_inner {
    text-align: left;
    background: rgba(0, 0, 0, 0.46);
    padding: 10px 0 18px;
    position: absolute;
    right: 0;
    transition: .5s;
    opacity: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 68%;
    text-align: center;
    left: 0;
    margin: auto;
}

.portfolio_content_inner h3 {
    color: #fff;
    font-size: 22px;
    font-weight: 600;
    margin-bottom: 3px;
    transition: .5s;
}

.single_portfolio:hover .portfolio_content_inner {
    right: 0px;
    opacity: 1;
}

.portfolio-pages .single_portfolio {
    overflow: hidden;
    margin-bottom: 30px;
}

.portfolio-pages .li.gutter-less .single_portfolio {
    overflow: hidden;
    margin-bottom: 0px;
}

.portfolio-pages .li.gutter-less .col-md-6,
.portfolio-pages .li.gutter-less .col-md-3,
.portfolio-pages .li.gutter-less .col-md-4 {
    margin: 0;
    padding: 0;
}


/* Portfolio Gutter Style */
.portfolio_gutter .col-md-4 {
    padding-bottom:30px;
}
.portfolio_area.portfolio_gutter {
    padding: 82px 0 50px;
}

/*========================
PORTFOLIO DETAILS  CSS
=========================*/

.portfolio-details-box li {
    border-bottom: 1px solid #ddd;
    font-size: 18px;
    font-weight: 300;
    padding: 20px 0;
    text-transform: capitalize;
    list-style: none;
}

.portfolio-details-box li:last-child {
    border-bottom: 0 none;
}

.portfolio-details-box li span {
    color: #333;
    display: inline-block;
    font-weight: 700;
    margin-right: 15px;
    text-transform: uppercase;
    width: 170px;
}

.portfolio-details-box ul {
    margin-bottom: 20px;
}

.portfolio-description {
    margin-top: 50px;
}

.portfolio-description>p {
    font-size: 18px;
}

.projects-navigation-wrap {
    margin-top: 50px;
}

.projects-navigation-wrap a {
    font-size: 14px;
    text-transform: uppercase;
}

.portfolio-content.portfolio-details-box {
    padding-top: 30px;
}

.prot_content.multi_gallery {
    width: 75%;
    margin: auto;
}


/* kc */

.abtext em {
    color: #444;
    font-weight: 600;
}

.abtext ol {
    padding-left: 15px;
}

.abtext ol li {
    font-weight: 600;
    line-height: 30px;
}

.creative_title {
    letter-spacing: 0;
}

/*===========================
 eduzone SERVICE AREA  CSS
=============================*/

.footer_menu.minister_menu>ul>li.current>a, .footer_menu.minister_menu>ul>li:hover>a {
    color: #fff !important;
}
.progress_area {
    padding: 79px 0 70px;
    background: #f7f7f7;
} 

.em-progress {
    text-align: left;
    -webkit-transition: all 0.5s ease 0s;
    transition: all 0.5s ease 0s;
    margin-bottom: 58px;
}

.em-progress-inner {
    overflow: hidden;
}

.em-progress-number {
    color: #DEB668;
    font-size: 35px;
    -webkit-transition: all 0.5s ease 0s;
    transition: all 0.5s ease 0s;
    margin-bottom: 5px;
}

.em-progress-number span {
    color: #fff;
    width: 85px;
    height: 85px;
    line-height: 65px;
    text-align: center;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.20);
    border-radius: 50%;
    display: inline-block;
    background: #deb668;
    margin-top: 9px;
    transition: .3s;
    border: 10px solid #fff;
    font-size: 30px;
    font-weight: 700;
    position: relative;
    z-index: 1;
    overflow: hidden;
}

.em-progress-number span::before {
    position: absolute;
    content: "";
    background: #041B5E;
    width: 100%;
    height: 100%;
    left: 0;
    top: -73px;
    border-radius: 100%;
    z-index: -1;
    transition: .3s;
}

.em-progress:hover .em-progress-number span::before {
    top: 0;
}

.em-progress:hover .em-progress-number i {
    background: #0d2f5d;
}

.em-progress-title {
    overflow: hidden;
}

.em-progress-title h2 {
    margin: 0 0 15px;
    padding: 0;
    text-transform: capitalize;
    -webkit-transition: all 0.5s ease 0s;
    transition: all 0.5s ease 0s;
}

.em-progress-desc {
    -webkit-transition: .5s;
    transition: .5s;
}

.em-progress-desc p {
    font-size: 14px;
    margin: 0;
}

.progress-btn {
    margin-top: 2px;
}

.progress-btn>a {
    border-radius: 30px;
    color: #212121;
    display: inline-block;
    font-size: 14px;
    font-weight: 500;
    text-transform: capitalize;
    -webkit-transition: all 0.5s ease 0s;
    transition: all 0.5s ease 0s;
    border: 1px solid transparent;
}

.progress-btna a:hover {
    color: #DEB668;
}

.progress-left-side .em-progress {
    text-align: right;
}


/*============================
minister CUOROSEL  CSS
=============================*/

.curosel-style .owl-nav div {
    border: 2px solid #deb668;
    border-radius: 50%;
    color: #deb668;
    font-size: 19px;
    height: 44px;
    left: -45px;
    line-height: 40px;
    position: absolute;
    top: 46%;
    -webkit-transition: all 0.5s ease 0s;
    transition: all 0.5s ease 0s;
    width: 44px;
    text-align: center;
    z-index: 99;
    -webkit-transform: translateY(-49%);
    transform: translateY(-49%);
    opacity: 0;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
}

.curosel-style .owl-nav .owl-next {
    left: auto;
    right: -45px;
}

.single_gallery.curosel-style .owl-nav div {
    left: 30px;
}

.single_gallery.curosel-style .owl-nav .owl-next {
    right: 30px;
    left: auto;
}

.portfolio_gallery_post.curosel-style .owl-nav div {
    left: 0px;
}

.portfolio_gallery_post.curosel-style .owl-nav .owl-next {
    right: 0px;
    left: auto;
}

.portfolio_gallery_post.curosel-style .owl-nav div {
    opacity: 1;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
}

.curosel-style .owl-nav .owl-next:hover {
    background: #deb668;
    color: #fff;
}

.curosel-style .owl-nav .owl-prev:hover {
    background: #deb668;
    color: #fff
}

.owl-carousel .owl-item img {
    margin: auto;
}

.curosel-style:hover .owl-nav div {
    opacity: 1;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
}

.testimonial_list .owl-dots {
    position: absolute;
    right: 50%;
    bottom: -35px;
    display: none;
}

.testimonial_list .owl-dot {
    display: inline-block;
    width: 12px;
    height: 12px;
    margin: 0px 5px 0;
    background: #deb668;
    border-radius: 100%;
}

.testimonial_list .owl-dot.active {
    background: #000;
}


/* responsive 320 start */


/* small mobile :320px. */

.mob_microsoft_email{ display: none; }


@media (max-width: 767px) {
    .about_area {
    padding: 60px 10px !important;
}
.about_text {
    padding: 0 15px;
}
.minister_menu > ul > li > a {
     margin: 10px 0 !important;
    margin-left: 10px !important;
}
    p.text-alignm {
    font-size: 18px !important;
}
#about .single_image img {
    position: inherit !important;
    top: 0;
} 
.single_image {
    position: initial !important;
}
.section-title h2 {
    font-size: 19px !important;
}
.count_down_area .section-title h2 {
    font-size: 25px !important;
}
.section-title.t_center {
    width: 100% !important;
}
    .mean-container .mean-bar {
    background: #ffffff none repeat scroll 0 0;
}
.mean-container a.meanmenu-reveal span {
    background: #2b2323;
} 
.mean-container .mean-nav {
    background: #ababab none repeat scroll 0 0 !important;
    float: none;
}
.mean-container a.meanmenu-reveal:hover span {
    background: #423d3d !important;
}
    body {
        overflow-x: hidden;
    }
    .minister-header-top {
        display: none;
    }
    .mean-container .mean-bar:before {
        text-transform: uppercase;
        top: 19px;
    }
    .mean-container a.meanmenu-reveal {
        padding: 19px 20px 18px;
    }

#Price .desp{ padding-left: 20px; padding-right: 20px;  }
/*.wow.slideInLeft ul li{ padding: 0px 5px;  }*/
#choose.progress_area .single-video img{ height: inherit !important; }

#critical-email{ background-size: cover !important; padding: 40px 0px;  }
.critical_desc{ margin: 10px;  }
#critical-email h2{ text-align: left; }
.whitelistemails_section h2{ font-size: 40px; line-height: 46px; }
.whitelistemails_section h3{     font-size: 24px; line-height: 30px; }
#critical-email h2{ font-size: 40px;  }
.microsoft_email .row h1{ font-size: 30px; line-height: 44px;  }
.microsoft_email .row h3{ font-size: 24px; line-height: 30px;   }

#our-classes-clone .section-heading h2{ font-size: 40px; }
#our-classes-clone .section-heading h3{ font-size: 18px; line-height: 24px; }
#our-classes-clone .top-pad-40{ padding: 0px !important; }
#white_list{ padding-top: 0px !important; }
.grid_pixel{ display: none; }
.municipal_price_img{ display: none; }
.mob_microsoft_email{ display: block !important; }
.desktop_microsoft_email{ display: none; }


}


/* responsive 320 end */


/*========================
minister VIDEO  CSS
=========================*/

.vedeo_area .col-md-12 {
    padding: 0;
}

.single_choose {
    margin-bottom: 20px;
}

.single-video {
    position: relative;
    text-align: center;
    margin-top:10px;
}

.single-video img {
    display: block;
    width: 100%;
    border-radius: 15px;
}

.single-video h3 {
    color: #fff;
    font-size: 29px;
    font-weight: 600;
    margin-bottom: 0;
    padding-top: 30px;
    text-transform: uppercase;
    position: absolute;
    left: 50%;
    top: 56%;
    transform: translateY(-50%) translateX(-50%);
}

.video-icon a {
    text-align: center;
    display: inline-block;
}

.video-icon a i {
    color: #fff;
    font-size: 60px;
    border-radius: 50%;
}

.v-overlay .video-icon a i {
    border: 0px solid #fff;
    font-size: 30px;
}

.video-icon {
    left: 50%;
    position: absolute;
    top: 50%;
    -webkit-transform: translateX(-50%) translateY(-50%);
    transform: translateX(-50%) translateY(-50%);
    padding-top: 8px;
}

.single-video::before {
    content: "";
    position: absolute;
    background: rgba(222, 182, 104, 0.6);
    bottom: 0;
    content: "";
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
    border-radius: 15px;
}


.single-video.video-overlay:before {
    background-color: rgba(0, 0, 0, 0.4);
    border: 3px solid rgba(255, 255, 255, 1);
    bottom: 0;
    content: "";
    height: 95%;
    left: 0;
    margin: auto;
    position: absolute;
    right: 0;
    top: 0;
    width: 95%;
}

.single-video.video-overlay:before {
    background: rgba(255, 160, 0, 0.5) none repeat scroll 0 0;
    border: 3px solid rgba(255, 255, 255, 1);
    bottom: 0;
    content: "";
    height: 95%;
    left: 0;
    margin: auto;
    width: 95%;
}
.video_area .single-video::before {
    background: rgba(0, 0, 0, 0.6);
    border-radius: 0;
}
.video_area .single-video img {
    border-radius: 0;   
}
.video_area  .col-md-12,
.video_area  .col-sm-12,
.video_area  .col-xs-12{
    padding:0;
}
/*==========================
minister ACOADING AREA CSS
============================*/

.accoarding_area {
    padding: 79px 0 80px;
    background: #f7f7f7;
}

.kc_accordion_section.group {
    padding-bottom: 27px !important;
}

.ui-accordion-header {}

.ui-accordion-header a {}

.ui-accordion-header a i {
    background: #333;
    color: #fff;
    border-radius: 50%;
    height: 28px;
    width: 28px;
    line-height: 28px;
    font-size: 14px;
    text-align: center;
    margin-right: 5px;
}

.ui-accordion-header.ui-state-active a i {
    background: #fff;
    color: #333;
}

.kc-panel-body ul {
    padding-left: 15px;
}

.kc-panel-body ul li {}


/* Widgets Css */

table#wp-calendar td#today a {
    color: #fff;
}

.blog-left-side .widget h2 {
    margin-top: 0;
}

.widget.widget_categories select {
    width: 100%;
    height: 34px;
}

.widget .screen-reader-text {
    display: none;
}

.search input {
    width: 100%;
}

.textwidget select {
    width: 100%;
}

.comment_field .textarea-field label {
    margin-top: 20px;
    margin-bottom: 10px;
}

.blog-content {
    word-break: break-word;
}

.post-password-form input[type=submit] {
    background: #deb668;
}

.page-list-single {
    clear: both;
}

.single-blog-content p {
    margin-bottom: 19px;
}

.blog-left-side .widget h2 {
    font-size: 24px;
}


/* Experience And biography Css */

.biography_area {
    background-image: url(assets/images/biography-bg.jpg);
    background-position: center center;
    background-size: cover;
    background-repeat: no-repeat;
    padding: 82px 0 100px;
}

.biography-timline {
    text-align: center!important;
    position: relative;
    padding: 0px;
    display: block;
    overflow: hidden;
}

.biography-timline::before {
    position: absolute;
    top: 0;
    left: calc(50% - 1px);
    bottom: 0;
    width: 2px;
    background-color: #deb668;
    -webkit-border-radius: 4rem;
    -moz-border-radius: 4rem;
    -ms-border-radius: 4rem;
    -o-border-radius: 4rem;
    border-radius: 4rem;
    content: ' ';
}

.single-biography {
    position: relative;
}

.single-biography:not(:last-child) {
    margin-bottom: 160px;
}

.single-biography:first-child {
    margin-top: 20px;
}

.biography_points::after {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    -ms-border-radius: 50%;
    -o-border-radius: 50%;
    border-radius: 50%;
    content: ' ';
    background-color: #deb668;
    z-index: 0;
    animation: video-icon-animation 1.4s 0.7s linear infinite;
}

.biography_points {
    position: absolute;
    top: 0;
    left: calc(50% - 15px);
    width: 30px;
    height: 30px;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    -ms-border-radius: 50%;
    -o-border-radius: 50%;
    border-radius: 50%;
    border: 5px solid #fff;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.20);
}

.biography_text {
    float: right;
    text-align: left;
    padding-top: 4px;
    background: transform;
    /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.10); */
    position: relative;
    transition: .3s;
    /* padding: 15px 15px 10px 15px; */
}
.biography_text h3 {
    font-size: 22px;
    text-transform: capitalize;
    margin: 0;
    margin-bottom: 25px;
    transition: .3s;
    position: relative;
}
.biography_text h3::before {
    position: absolute;
    content: "";
    left: 0;
    bottom: -12px;
    width: 50px;
    height: 2px;
    background: #DEB668;
}
.biography-timline .single-biography:nth-child(even) .biography_text h3:before {
right: 0;
left:inherit;
}
.biography_text span {
    font-size: 15px;
    transition: .3s;
}

.biography_text p {
    margin-top: 19px;
    transition: .3s;
}

.biography-date {
    text-align: right;
    display: inline-block;
    padding-right: 37px;
    margin-top: -3px;
}

.biography-date span {
    /* background: transparent; */
    display: inline-block;
    /* padding: 4px 28px; */
    /* border-radius: 30px; */
    font-size: 18px;
    /* color: #fff; */
    /* background: rgba(245, 35, 44, 0.8); */
}

.biography-date {
    font-size: 19px;
    font-weight: 500;
}

.biography-date,
.biography_text {
    width: 46%;
}

.biography-timline .single-biography:nth-child(even) .biography_text {
    float: left;
    text-align: right;
}

.biography-timline .single-biography:nth-child(even) .biography-date {
    text-align: left;
    padding-left: 37px;
    padding-right: 0;
}


/* Acoading css */

.panel-group .panel {
    margin-bottom: 19.5px;
    border-radius: 4px;
    border-radius: 30px;
    /* padding-left: 15px; */
}

.panel-title {
    font-size: 18px;
    color: #333;
}

.panel-title a {}

.panel-heading1 a i {
    background: #deb668;
    color: #fff;
    height: 28px;
    width: 28px;
    line-height: 28px;
    font-size: 15px;
    text-align: center;
    margin-right: 5px;
    border-radius: 100%;
}

.panel-heading1 {
    padding: 11px 24px;
    border-radius: 30px;
}

.panel-body {}

.panel-body ul {
    padding-left: 15px;
}

.panel-body ul li {}

.panel-heading1.active {
    background: #deb668;
}

.panel-heading1 {
    position: relative;
}

.panel-heading1::before {
    position: absolute;
    content: "+";
    color: #deb668;
    right: 15px;
    transform: translateY(-50%);
    top: 50%;
    font-size: 30px;
}

.panel-heading1.active {
    position: relative;
}

.panel-heading1.active::before {
    position: absolute;
    content: "-";
    color: #fff;
    right: 15px;
    transform: translateY(-50%);
    top: 50%;
}

.panel-heading1.active a {
    color: #fff;
}

.panel-heading1 a {
    display: block;
    color: #333;
    font-weight: 600;
    font-size: 21px;
}

.panel-heading1.active a i {
    background: #fff;
    color: #333;
}


/*======================
HOSTING DITALS AREA CSS
=======================*/

.hosting_details_area {
    background-image: url(assets/images/bg1.jpg);
    background-repeat: no-repeat;
    background-position: center center;
    padding: 261px 0 170px;
    position: relative;
}

.hosting_details_area:before {
    position: absolute;
    content: "";
    left: 0;
    top: 0;
    background: rgba(13, 46, 199, 0.50);
    height: 100%;
    width: 100%;
}

.single_hosting_details {}

.single_hosting_content {}

.single_hosting_content h1 {
    color: #fff;
    text-transform: uppercase;
    font-size: 50px;
}

.single_hosting_content h1 span {
    color: #deb668;
}

.single_hosting_content h2 {
    color: #fff;
    font-size: 25px;
    font-weight: 600;
}

.single_hosting_content p {
    color: #fff;
    padding: 9px 0 21px;
    width: 61%;
}

.single_hosting_content a {
    color: #444;
    background: #fff;
    padding: 11px 33px;
    transition: .3s;
    font-weight: 500;
    text-transform: uppercase;
    margin-top: 14px;
    display: inline-block;
    border-radius: 5px;
}

.single_hosting_content a:hover {
    background: #deb668;
    color: #fff;
}

.hosting_slide_img {
    position: absolute;
    content: "";
    left: 32%;
    top: -364px;
    width: 100%;
    height: 100%;
    transform: translateY(-50%);
    text-align: center;
}

.hosting_slide_thumb {}

.hosting_slide_img {}

.hosting_slide_img img {}


/*========================
 DOMEIN FEATURE AREA CSS
=========================*/

.domein_feature_area {
    background: #f7f7f7;
    padding: 100px 0 70px;
}

.single_domein_area {
    background: #fff;
    overflow: hidden;
    text-align: center;
    padding: 25px 0 14px;
    transition: .5s;
    margin-bottom: 30px;
    box-shadow: 0 0 4px rgba(0, 0, 0, 0.20);
}

.single_domein_area:hover {
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.20);
}

.single_domein_thumb {}

.single_domein_thumb img {}

.single_domein_content {}

.single_domein_content h2 {
    transition: .5s;
    margin: 22px 0 5px;
}

.single_domein_content p {
    transition: .5s;
}


/*==================
 CHOOSE US AREA CSS
====================*/

.choose_us_area {
    padding: 75px 0 70px;
}

.single_choose_us_area {
    text-align: center;
    margin-bottom: 30px;
    padding: 36px 25px 20px;
    transition: .3s;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.20);
    text-align: left;
}

.single_choose_us_area:hover {
    background: #f7f7f7;
    box-shadow: 0 0 25px rgba(0, 0, 0, 0.20);
}

.single_choose_us_thumb {}

.single_choose_us_content {}

.single_choose_us_content h2 {
    padding: 10px 0 12px;
}

.single_choose_us_content p {}

.domain_details_area {
    padding: 79px 0 80px;
}


/* Tab Area Css */


/*=========================
minister SERVICE AREA CSS
===========================*/

.goal_area {
    padding: 79px 0 87px;
}

.tab_area {
    overflow: hidden;
}

.minister-tab {
    overflow: hidden;
    clear: both;
}

.minister-tab li {
    display: block;
    list-style: none;
    overflow: hidden;
    box-shadow: 0 0 4px rgba(0, 0, 0, 0.25);
    background: #fff;
    padding: 14px 0px 14px 23px;
    transition: .5s;
    cursor: pointer;
    border-radius: 30px;
    margin: 5px 5px 16px 5px;
}

.minister-tab li i {
    font-size: 35px;
    transition: .5s;
    float: left;
    margin-right: 15px;
    color: #deb668;
}

.minister-tab li a {
    padding: 2px 0px 0;
    display: block;
    color: #6d6d6d;
}

.minister-tab li.active,
.minister-tab li:hover {
    background: #deb668;
    color: #fff;
}

.minister-tab li.active i,
.minister-tab li:hover i {
    color: #fff;
}

.minister-tab li.active a,
.minister-tab li:hover a {
    color: #fff;
}


/* Our Vision Area */

.our_vision_area {
    padding: 30px 25px 30px 13px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.25);
    margin: 5px;
    border-radius: 30px;
}

.vission_content h2 {
    padding-bottom: 25px;
    margin-top: 0;
    position: relative;
}

.vission_content h2::before {
    position: absolute;
    content: "";
    left: 0;
    height: 2px;
    width: 60px;
    background: #deb668;
    top: -9px;
}

.vission_content p {
    margin-bottom: 20px;
}

.single_vision {
    padding-left: 25px;
    padding-top: 11px;
}

.vission_content a {
    font-size: 16px;
    padding: 8px 35px;
    border-radius: 30px;
    color: #fff;
    background: #deb668;
    display: inline-block;
    margin-top: 17px;
}

.vission_content a:hover {
    background: #041B5E;
}

.vsion_thumb img {
    width: 100%;
    border-radius:15px;
}

.goal_area.feature_style2 {
    padding: 82px 0 70px;
}

.logo img {
    width: 100px;
    margin-top: -26px;
}
.text-left .em-slider-descript {
    margin: 0 !important;
    font-size: 25px ;
    width: 45%;
    line-height: 30px;
    padding-bottom: 15px;
}
.alexa_ul_4th li {
    list-style: none;
}

/* .em-slider-button.em-button-button-area.wow.fadeInRight.animated.animated {
    margin: -80px 74px;
}*/
.em-slider-button.em-button-button-area.wow.fadeInRight.animated.animated {
    margin: -80px -30px;
}
.about_text ul li {
    list-style: disc !important;
}
.em-button-button-area a {
    top: 65px;
}
.em_slider_single_img img {
   
    top: 215px !important;
}
.feature_title h2 a {
   
    font-size: 16px !important; 
}
.section_title_lefts h1 {
    margin-bottom: 40px;
}

.about_area {
    padding: 60px 0 !important;
    
}
#about {
    position: relative;
}
#about .single_image img {
    position: absolute;
    top: 255px;
}
.mk h2 { 
    font-size: 21px;
    line-height: 30px;
}
.footer_contact_info {
    float: left;
    margin-left: 0 !important;
    margin-right: 0 !important;
    width: 100% !important;
}

.searchcontent_button{
    color: #ffffff;
    background: #022147;
    font-size: 18px;
    font-weight: 600;
    text-transform: uppercase;
    border-radius: 30px;
    padding: 13px 25px;
    letter-spacing: 1px;
    border: 0;
    line-height: 25px;
    width: 38%;
}
.searchcontent_button:hover {
    background: #022147;
    color: #fff;
}
.searchcontent_button:focus {
    color: #fff;
}
.collapsebutton_wrapper{
    text-align: center;
}
/*.searchcontent{
   padding: 60px 0px;
}*/

.bv_sec_slider{ width: 100% !important; text-align: center; }

.searchcontent .title {
    text-align: center;
    padding: 25px 0px;
    border: 2px solid #3345E3;
    margin-top: 26px; width: 100%; float: left;
}

.searchcontent .form_wrapper{ width: 100; float: left; }

.searchcontent .title h2{
    margin-top: 0px;
}
.searchcontent .inner_wrapper{
    border: 2px solid #3345E3;
    margin-top: 10px;
    border-radius: 10px;
}
.searchcontent .inner_wrapper .countries{
    padding: 30px 0px;
    text-align: center;
}
.searchcontent .inner_wrapper .countries span{
    margin-right: 60px;
}
.searchcontent .inner_wrapper .states{
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    margin: auto;
    width: 97%;
    border: 2px solid #3345E3;
    border-radius: 10px;
    padding: 20px 0px 20px 0px;
    margin-bottom: 10px;
}
.searchcontent .inner_wrapper .states div {
    width: 135px;
    text-align: right;

}
.searchcontent .inner_wrapper .states input[type=checkbox] {
    height: 15px;
    width: 15px;
}
.zip_code {
    text-align: center;
    padding: 15px 0px;
}
.zip_code h2.zip_title {
    font-size: 30px;
}
.zip_code textarea{
    height: 165px;
    width: 90%;
    background-color: #FAFFFD;
    border: 1px solid #663;
    border-radius: 10px;
    margin-top: 5px;
}
.submit_button {
    text-align: center;
    padding: 10px 0px 20px;
}
input.search_submit {
    color: #ffffff;
    background: #deb668;
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
    border-radius: 30px;
    padding: 13px 40px 13px 40px;
    font-family: Raleway, sans-serif;
    letter-spacing: 1px;
    border: 0;
}
input.search_submit:hover{
    background: #022147;
    color: #fff;
}

@media (min-width: 1400px) and (max-width: 1920px) {

.text-left .em-slider-descript {
    margin: 0 !important;
    font-size: 28px !important;
    width: 45%;
    line-height: 30px;
       padding-bottom: 15px;
}
 }

@media (min-width: 1200px) and (max-width: 1399px) {

.em_slider_inner{ top: 60%;  }
.em_slider_inner ul li{ font-size: 18px !important;  line-height: 24px !important; }
.em_slider_inner p{ font-size: 18px !important;  line-height: 24px !important; }

}

@media (min-width: 992px) and (max-width: 1024px) {

#our-classes-clone .top-pad-40{ display: flex; }
#our-classes-clone .top-pad-40 .col-lg-6{ max-width: 50%; flex: 50%; float: left; }

}

@media (min-width: 768px) and (max-width: 1199px) {

.collapsebutton_wrapper{ width: 100%; }
.searchcontent_button {
    width: 59%;
}

.wow.slideInLeft ul li{ font-size: 16px; line-height: 20px; /*padding: 0px 5px;*/ }
.wow.slideInLeft p{ font-size: 16px; line-height: 20px; }
#footer .col-sm-6.col-md-12{ width: 100% !important; }
.footer-bottom .col-md-6{  width: 100% !important; text-align: center !important;  }
.donate-btn-header img{ margin: 30px 4px !important;  }
.minister_nav_area .sub-menu.nav_scroll{ margin-right: 0px !important;  }
#critical-email{ background-size: cover; }
#critical-email h2{ text-align: left; margin-bottom: 20px;  }

#emailing .align-self-center{ align-self: auto !important;  }

}


@media (min-width: 768px) and (max-width: 1024px) {

#emailing h1{ font-size: 30px !important; }
#emailing h3{ font-size: 24px !important; }

}


@media (max-width: 767px){

.mean-container .mean-bar::before{ color: transparent ; }

.collapsebutton_wrapper{ width: auto; }

}
#Price {
    padding: 50px 0 140px;
        background: #f7f7f7;
}
#Price li {
    list-style-image: url(http://muniblasts.com/assets/images/checked.png);
        margin: 5px 5px;
        font-size: 13px;
}
#Price h3 {
    position: relative;
        font-size: 30px;
    margin-bottom: 40px;
}
#Price h3:before {
    position: absolute;
    left: 0;
    bottom: -35px;
    content: "";
    width: 130px;
    height: 2px;
    background: #deb668;
}
#Price .desp {
    padding-top: 30px;
}

@media (max-width: 480px){
#Price li {
  
    font-size: 15px !important;
}
.whitelistemails_section h2{ font-size: 30px; line-height: 36px; }
.whitelistemails_section h3{ font-size: 20px; line-height: 24px; }
#critical-email h2{ font-size: 30px; }


.count_down_area,.progress_area,.service_area ,#Price {
    padding: 20px 0 20px !important;
}

.footer_contact_info{ margin-top: 0px;  }


}
</style>
<section class="topslider">
<div class="container">
<div class="row sec-1">
<div class="col-md-12">
<h1 class="h1favorite">Save by Giving!</h1>
<h1 class="h1benefits"><span>Give by Saving!</span></h1>
<p class="headerp mobileshow">Save money & support<br> your favorite nonprofit,<br> by using digital deals<br> donated by businesses!</p>
<p class="headerp desktopshow">Save money & support your favorite nonprofit, by using digital deals donated by businesses!</p>
</div>
<div class="row topicons">
    <div class="col-md-4">
        <div class="boxex setheight">
            <span class="top_icon"><img src="https://cdn.savingssites.com/Circled1.png"></span>
            <b class="mobileshow">Save by Giving!<br> Give by Saving!</b>
            <b class="desktopshow">Save by Giving! Give by Saving!</b>
            <p>Deal Example: Pay business only $30 for $60 value! To access that $30 discount, and support your favorite nonprofit, you only pay a small part of the $30 discount now.</p>
            <span class="bottom_icon"><span class="videomodal1">Explainer Video ></span><a href="#"><img vtype="1" class="videomodal" src="https://cdn.savingssites.com/VideoButton.png"></a></span>
        </div>
    </div>
    <div class="col-md-4">
                <div class="boxex">
            <span class="top_icon"><img src="https://cdn.savingssites.com/Circled2.png"></span>
            <b>Free $5 Extra for 1st Use!</b>
            <p>Every business has a FREE $5 button for 1st time use of its deal! Click as many businesses Free $5 buttons as you like to save an extra $5 for each!</p>
            <span class="bottom_icon"><span class="videomodal1">Explainer Video ></span><a href="#"><img  vtype="2" class="videomodal" src="https://cdn.savingssites.com/VideoButton.png"></a></span>
        </div>
    </div>
    <div class="col-md-4">
                <div class="boxex">
            <span class="top_icon"><img src="https://cdn.savingssites.com/Circled3.png"></span>
            <b>Activities, Events, and More!</b>
            <p>Freely search for fun activities and events. Hosted by municipalities, schools, nonprofits and businesses!</p>
            <span class="bottom_icon"><span class="videomodal1">Explainer Video ></span><a href="#"><img  vtype="3" class="videomodal" src="https://cdn.savingssites.com/VideoButton.png"></a></span>
        </div>
    </div>
</div>
</div>

<!-- <div class="row sec-2" id="hide-on-mob">
<div class="col-md-12">
<h1 class="h1favorite">Huge  <span>Digital Deals!</span></h1>
</div>
</div> -->
</div>
</section>

<section class="services_new fd" id="servics">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8 col-md-4 left_col_list">
                <ul class="lisit">
                    <li>Huge deals from thousands of local businesses!</li>
                    <li>Timely and Targeted Info and Events!</li>
                    <li>Short Notice Alert Program (SNAP) Emails!</li>
                    <li>Digital Deals on Phone! No Cutting Coupons!</li>
                    <li>Save Favorites for Quick Access to Deals!</li>
                    <a href="<?= $dealurl; ?>" target="_blank"><img src="https://cdn.savingssites.com/new-savingssites3.png" class="btn-deal"></a>
                </ul>
            </div>
            <div class="col-12 col-lg-4 col-md-4 bv_pixel">
                <img src="https://cdn.savingssites.com/pexels-mati.png">
            </div>
        </div>
    </div>
</section>
<section class="support_new" id="support">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-4 col-md-4 bv_suupport">
                <img src="https://cdn.savingssites.com/zone_image2.png">
            </div>
            <div class="col-12 col-lg-8 col-md-4 left_col_list">
                <ul class="blue_lisit">
                    <li>You Support Your Favorite Nonprofit!</li>
                    <li>Your Email is protected from Municipal disclosure laws!</li>
                    <li>Free Municipal Phone Alerts by Amazon Alexa!</li>
                    <li>Food Order Phone Line Powered by Amazon Coming Soon!</li>
                    <li>You’re Rewarded to Refer businesses and residents!</li>
                    <a href="<?= $dealurl; ?>" target="_blank"><img src="https://cdn.savingssites.com/new-savingssites3.png" class="btn-deal"></a>
                </ul>
            </div>
        </div>
    </div>
</section>
<section id="snapsection" class="snapsection">
    <div class="row protect_new slidernewadd2" id="snpheaders">
        <div class="col-md-12 text-center helpCntnt"><h2 style="font-size: 50px;font-weight: bold; background: #000; color: #fff;">Short Notice Alert Program (SNAP)</h2></div>
    </div>
    <div class="container aos-init aos-animate" data-aos="fade-up">
    <div class="row shortfirst1">
        <div class="col-md-12">
            <p class="centershortfirst"><b>SNAP DOLLARS</b></p>
        </div>
    </div>

    <div class="row shortfirst">
        <div class="col-md-6">                
            <p>Deals can be used at any time, with no expiration!</p>
            <p><strong>Added Benefits:</strong> You get extra SNAP Dollars when you use a deal during slow times of your selected businesses.</p>
            <p>Only if all your SNAP deal requirement filters are met, will we send you businesses SNAP notices. See 4 menu tabs and video.</p>
        </div>
        <div class="col-md-6">   
            <ul class="nav nav-pills mb-3" role="tablist">
                <li><a class="nav-link active" data-bs-toggle="pill" href="#tab1" aria-selected="true" role="tab">SNAP Filters</a></li>
                <li><a class="nav-link" data-bs-toggle="pill" href="#tab2" aria-selected="false" tabindex="-1" role="tab">SNAP Claims</a></li>
             
                <li><a class="nav-link" data-bs-toggle="pill" href="#tab4" aria-selected="false" tabindex="-1" role="tab">SNAP List</a></li>
            </ul> 
            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                    <p>Choose which businesses you want Savings Sites to send SNAP time Alerts.</p>
                
                        <div class="snapoff row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3 rightsnap">
                                <img src="https://cdn.savingssites.com/snap-off.png"/><br><span class="snaptext">SNAP OFF</span>
                            </div>
                            <div class="col-md-3">
                                <img src="https://cdn.savingssites.com/snap-on.png"/><br><span class="snaptext">SNAP ON</span>
                            </div>
                            <div class="col-md-3"></div>
                    </div>                                                
                    <p>Set the minimum discount percentage you’ll accept!<br>
                    Set the days of the week and the times of the day you can use the deal!<br>
                    Each business can have different SNAP filters!</p>



                </div>
                <div class="tab-pane fade show" id="tab2" role="tabpanel">
                    <p>Businesses will have a limited number of SNAP time slots. The SNAP notice contains a link to claim the businesses SNAP time slot. You’ll receive feedback on whether or not you were successful in claiming the SNAP time slot.</p>
                    <p>There is no requirement that you already have purchased a deal to get SNAP alerts. However, since SNAP time slots are claimed on a first come first served basis, those who are holding a non-expiring deal can obviously act much faster to claim SNAP time slots. So, if you want the extra SNAP dollars, we suggest you buy a deal ahead of time!</p>
                </div>
        
                <div class="tab-pane fade show" id="tab4" role="tabpanel">
                    <p>When we email important government information, we also include a list of deals from 20 businesses.</p>
                    <p>The businesses included are based upon your SNAP list!  </p>
                </div>
            </div>      
        </div>
    </div>

    <div  class="row">
        <div class="col-md-6">                           
            <div class="table-responsive">
                <table class="table table-striped text-center">
                    <thead style="background: var(--bs-link-color);">
                    <tr class="snapdollarlistcnt">
                        <th scope="col" style="background: #0ea2bd;color: var(--bs-gray-100);">Deal Value</th>
                        <th scope="col"  style="background: #0ea2bd;color: var(--bs-gray-100);">Price paid business<br>when deal is used</th>
                        <th scope="col"  style="background: #0ea2bd;color: var(--bs-gray-100);">Snap Dollars added to your account</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php 
                            if(count($deal_cert_Arr) > 0){
                                foreach ($deal_cert_Arr as $k => $v) {
                                    echo ' <tr>
                                        <td class="fw-bolder" data-label="Attributes" scope="row">$'.$v->dealRedemption.'</td>
                                        <td class="fw-bolder" data-label="Base Class">$'.$v->discountedPrice.'</td>
                                        <td class="fw-bolder" data-label="Simulated Case">$'.$v->short_notice.'</td>
                                    </tr>';
                                }
                            }
                            ?>
                    </tbody>
                </table>
            </div>
        </div>
         <div class="col-md-6">  
            <video style='width: 100%;' controls>
                <source src="https://cdn.savingssites.com/business_solo.mp4" type="video/mp4">
            </video>
            <div class="text-center"><h3>SNAP Benefits Residents</h3></div>
         </div>
    </div>


    <div class="row">
        <div class="col-md-6 snaplaunch dasktopview order-md-1 text-center" id="column1">
            <div class="about-img"><img src="https://cdn.savingssites.com/ss-snap-launch.svg"></div>
        </div>
        <div class="col-md-6 order-md-2" id="column2">
            <!-- <video style='width: 100%;' controls>
                <source src="https://cdn.savingssites.com/business_solo.mp4" type="video/mp4">
            </video> -->
            <img style="width: 100%;" src="https://cdn.savingssites.com/snapbusinesscomingsoon.jpg"/>
            <h3 class="text-center">SNAP Benefits Businesses</h3>
            <a href="<?= $dealurl; ?>" target="_blank"><img src="https://cdn.savingssites.com/new-savingssites3.png" class="btn-deal1"></a>
        </div>
    </div>
</section>









<section id="grocerysection" class="grocerystore snapsection">
    <div class="row protect_new slidernewadd2" id="snpheaders">
        <div class="col-md-12 text-center helpCntnt"><h2 style="font-size: 50px;font-weight: bold; background: #000; color: #fff;">Grocery Store Specials</h2></div>
    </div>
    <div class="container">
        <div class="row">
     <div class="col-md-6"><img src="/assets/home/directory/images/grocery.png"></div>
            <div class="col-md-6">
                <h2 class="text-center">Grocery Specials!</h2>
                <h3>See daily, weekly, monthly specials from local grocery stores:<button type="button" class="btn btn-primary text-capitalize"><a href="groceryStore" id="sinupchecks" style="color: white;" target="_blank">Grocery Stores</a></button> </h3> 
            </div>
        </div>
    </div>
</section>

<section class="slider active" id="ss-slider">
  <div class="outer">
    <div class="sizer">
      <div class="inner">
        <div id="layerslider_502" class="ls-wp-container fitvidsignore" style="width:1500px;height:100vh;margin:0 auto;margin-bottom: 0px;">
          <div class="ls-slide" data-ls="bgsize:cover;bgcolor:ffffff;duration:100;transition2d:2;transitionduration:1000;kenburnsscale:1.2;parallaxaxis:x;parallaxdurationmove:500;">
            <img width="1920" height="1080" src="https://cdn.savingssites.com/sky.png" class="ls-bg" alt="" sizes="100vw" />

            <img width="7680" height="1440" src="<?php echo base_url(); ?>https://cdn.savingssites.com/clouds-back.png" class="ls-l" alt="" sizes="100vw" style="top:70%;left:0px;" data-ls="durationin:2000;loop:true;loopoffsetx:-1920;loopduration:60000;loopstartat:transitioninstart + 0;loopcount:-1;parallax:true;parallaxlevel:5;parallaxaxis:y;">
            
            <img width="7680" height="1440" src="<?php echo base_url(); ?>https://cdn.savingssites.com/clouds-middle.png" class="ls-l" alt="" sizes="100vw" style="top:70&amp;;left:0px;" data-ls="durationin:2000;loop:true;loopoffsetx:-1920;loopduration:35000;loopstartat:transitioninstart + 0;loopcount:-1;parallax:true;parallaxlevel:10;parallaxaxis:y;">
            
            <img width="7680" height="1440" src="https://cdn.savingssites.com/clouds-front.png" class="ls-l" alt="" sizes="100vw" style="top:80&amp;;left:0px;" data-ls="durationin:2000;loop:true;loopoffsetx:-1920;loopduration:15000;loopstartat:transitioninstart + 0;loopcount:-1;parallax:true;parallaxlevel:15;parallaxaxis:y;">
            <p  style="white-space:normal;left:66%;text-align:left;font-weight:600;font-size:42px;color:#fff;font-family:Oswald;top:32%;letter-spacing:0.3px;" class="ls-l home_desc_first" data-ls="offsetyin:top;durationin:1500;delayin:2000;easingin:easeOutExpo;fadein:false;rotatein:-120;scalexin:1.0;scaleyin:1.0;transitionout:false;position:fixed;">Government Alerts!
            </p>
            <p  style="white-space:normal;left:66%;text-align:left;font-weight:600;font-size:28px;color:#fff;font-family:Oswald;top:48%;letter-spacing:0.3px;text-align: center;" class="ls-l home_desc_sec" data-ls="offsetyin:top;durationin:1500;delayin:3000;easingin:easeOutExpo;fadein:false;rotatein:-120;scalexin:1.0;scaleyin:1.0;transitionout:false;position:fixed;">We protect governments from<br>laws that force disclosure<br>of your email address!
            </p>
            
            <img width="279" height="500" src="https://cdn.savingssites.com/police-1.png" class="ls-l" alt="" sizes="100vw" style="top:100%;left:40%;" data-ls="offsetxin:-1180;delayin:1000;position:fixed;">
            
            <img width="214" height="462" src="https://cdn.savingssites.com/police-2.png" class="ls-l" alt="" sizes="100vw" style="top:100%;left:21%;" data-ls="offsetxin:1180;delayin:1000;position:fixed;">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="protect_new text-center slidernewadd1">
    <div class="container" style="max-width: 75%;">
        <div class="row">
            <div class="col-md-2">
                <img class="partner_logo" style="width: 165px;" src="https://cdn.savingssites.com/microsoft-partner-new.png" />
            </div>
            <div class="col-md-8"><h2 style="font-size: 60px;font-weight: bold;">Government & Residents Benefit</h2></div>
            <div class="col-md-2">
                <img  style="width: 165px;" src="https://cdn.savingssites.com/right-logo-alexa.png" />
            </div>
        </div>
    </div>
</section>
<section class="protect_new text-center" id="protect" style="background-image: url(https://cdn.savingssites.com/slider-1.jpg);background-repeat: no-repeat;position: relative;background-size: cover;">
    <div class="container">
        <div class="row" style="width: 46%;background: #fff;padding: 15px;border-radius: 20px;">
            <div class="desc" style="font-size: 1.1em;line-height: 25px;background: #fff;color: #000;">
                <p>• We protect residents email addresses & cell phone numbers from disclosure laws that force governments to surrender resident’s data!
                </p>
                <p>• Municipal, county, and state government communications are substantially improved! We have already collected opted-in email addresses from over 90% of every home and business and data is never sold!</p>
                <p>• Highly Targeted Info! Example: Recreation Director can email parents of 5th and 6th grade boys, who are interested in soccer.</p>
                <p>• Free for governments and residents! Free because resident’s signup to get government content, which also shows them deals to support nonprofits! Win-Win!</p>
                <p>• Alexa phone alerts coming. At no cost, governments can broadcast a million messages per second, in 18 languages, to residents free Alexa phone apps!</p>
            </div>  
        </div>
        <!--  <div class="row" style="width: 46%;background: #fff;padding: 15px;border-radius: 20px;margin-top: 5px;">
            <div class="desc" style="font-size: 1.1em;line-height: 25px;background: #fff;color: #000;">
                <h3 style="text-align: center;font-size: 25px;">Email send to Municipality & County <a href="#"><u>HERE</u></a>
                </h3>
            </div>  
        </div> -->
      <img src="https://cdn.savingssites.com/slide-img1.png" alt="" style="float: right;position: absolute;bottom: 0;">
        </div>
    </div>
</section>
<section class="protect_new text-center slidernewadd2">
    <div class="container">
        <div class="row">
            <div class="col-md-12 helpCntnt"><h2 style="font-size: 50px;font-weight: bold;">Help Us Help You!</h2></div>
            
        </div>
    </div>
</section>
<section class="text-center" id="protect1" style="background-image: url(https://cdn.savingssites.com/slider-2.jpg);background-repeat: no-repeat;position: relative;background-size: cover;">
    <div class="container-fluid">
        <div class="row toprow" style="padding-top: 300px;">
            <div class="col-md-5" style="margin-top: -35px;">
                <img src="https://cdn.savingssites.com/slide-img2.png" alt="">
            </div>
            <div class="col-md-7">
                <div class="wow fadeInRight" data-wow-duration="2s" data-wow-delay="0s">
                                <h1 class="em-slider-sub-title" style="position: relative; text-align:left;">Easy Decision!</h1>
                            </div>
                            <div class="wow fadeInRight" data-wow-duration="3s" data-wow-delay="0s">
                                <p  class="bv_sec_slider" style="text-align: left;font-size: 40px;color:#fff;font-size:36px;">Free! No Taxpayer Money used!</p>
                            </div> 
                            <div class="wow fadeInRight" data-wow-duration="3s" data-wow-delay="0s">
                                <p  class="bv_sec_slider" style="text-align: left;font-size: 40px;color:#fff;font-size:36px;">Residents Emails & Data Protected!</p>
                            </div> 
                            <div class="wow fadeInRight" data-wow-duration="3s" data-wow-delay="0s">
                                <p  class="bv_sec_slider" style="text-align: left;font-size: 40px;color:#fff;font-size:36px;">Huge Upgrade in Communications</p>
                            </div> 
                            <div class="row" style="padding: 15px;border-radius: 20px;margin-top: 5px;">
            <div class="desc" style="font-size: 1.1em;line-height: 25px;color: #000;">
                <h3 style="text-align: center;font-size: 25px;padding: 25px 0px;background: #fff;width: 85%;border-radius: 10px;">Our Letter to Municipal & County Staff:<a  target="_blank" href="<?= base_url(); ?>/gov_email_template"><u>here</u></a>
                </h3>
            </div>  
        </div> <div class="row" style="padding: 15px;border-radius: 20px;margin-top: 5px;">
            <div class="desc" style="font-size: 1.1em;line-height: 25px;color: #000;">
                <h3 style="text-align: center;font-size: 25px;padding: 25px 0px;background: #fff;width: 85%;border-radius: 10px;">Please see the referral letter <a  target="_blank" href="<?= base_url(); ?>/referral_letter"><u>here</u></a> and share it with friends,<br> so no one misses important government updates!
                </h3>
            </div>  
        </div>
       
            </div>
            
            
        </div>
        </div>
    </div>
</section>


<section class="every-profits">
  <div class="container">
    <div class="row text-center">
<!--         <div class="rdow sec-2" id="hide-on-desk">
            <div class="col-md-12">
                <h1 class="h1favorite ">Huge  Digital Deals!</h1>
            </div>
        </div> -->
    </div>
<div class="row">
  <h1 class="everyoneheading"><span style="color:#000;">Everyone</span> Benefits!</h1>
    <div class="col-md-3"></div>
    <div class="col-md-6 bg-chnage"></div>
    <div class="col-md-3"></div>
</div>
<div class="row">         
 <div class="tab-block" id = "tab-block">
  
  <ul class="tab-mnu">
    <li>Nonprofits</li>
    <li>Businesses</li>
    <li>Municipality</li>
  </ul>
  
  <div class="tab-cont">
<!--     <div class="tab-pane" style="display:none;">
         <h3 class="title">Residents Benefits</h3>
         <div class="boxes residents">
      <div class="col-img">
        <img src="https://cdn.savingssites.com/resident-new.jpg">
      </div>

      <div class="col-text">
           <div class="head_col">
          <h3 class="no-margin"><span class="num-val">1</span>
            <b>Save by Giving!</b> Sign up and choose your favorite nonprofit to also benefit. </h3>
          <h3><span class="num-val">2</span>
            <b>How it Works:</b> You just pay a donation claiming fee of only $12 now, to access a discounted certificate. Not until you’re actually serviced do you pay the business only $30 for $60 value! No expiration, and no more paying everything upfront to a discount service!</h3>
          <h3><span class="num-val">3</span>
            <b>Extra $5 Discount to try Different Businesses:</b> Every deal has a FREE $5 button, clickable once per business. So, instead of paying a $12 donation access fee, you only pay $7 to access the $30 discount certificate.

            <div class="extra_content"> 
                  <p> <b>5 Free Cash Certs!</b>  Refer a new business! </p>
                  <p> <b>Free Cash Cert:</b> Refer other residents to register. You and referred both get a free cash cert. </p>
                  <p> <b>$1 for Every Sales Referral!</b> Both you and referred get $1 off when referred buys a cash cert.</p>
              </div>
          
          </h3>
          <h3><span class="num-val">4</span>
            <b>Activities & Protected Info:</b>  Your email address is protected from OPRA disclosure laws. You receive real-time notices of “things to do,” etc., from municipalities, schools, nonprofits, and businesses!</h3>
          <h3><span class="num-val">5</span>
            <b>Food Order Savings phone line powered by Amazon.</b> Your discounted digital certificate can also be redeemed on the phone! It saves you money, is faster, and is more accurate than typing into a phone! <b>See...</b></h3>

        </div>
      </div>
    </div>

  
         
    </div> -->
    <div class="tab-pane" style="display:none;">
      <h3 class="title">Nonprofits Benefits</h3>
         <div class="boxes non-profits">
      <div class="col-img">
        <img src="https://cdn.savingssites.com/Nonproft-heart.png">
      </div>

      <div class="col-text">
           <div class="head_col">
          <h3><span class="num-val">1</span>
            <b>Easiest Fundraiser:</b> You know trying to fundraise by asking your members to pay, for example $30 for a product that can be bought elsewhere for $15, is difficult. Now you can simply email your members and tell them they will still pay less than what local businesses normally charge, even after their donation!!! </h3>

          <h3><span class="num-val">2</span>
            <b>Businesses & Residents Both Donate:</b> Your nonprofit receives funds from both people who are buying discounted cash certificates, and local businesses that are bidding for ad position ranking in their business category in the savings directory.</h3>
          <h3><span class="num-val">3</span>
            <b>Monthly Reports:</b> At the end of the month your .xlsx report will show you detailed report as to who selected your nonprofit to benefit! If the public does not select a particular nonprofit, the Publisher will share those donation funds. At the end of the month, you can email members and thank the people that bought the most discounted cash certificates. This will politely serve as a notice to all your members that did not buy that you are aware of which members have designated your organization to benefit.  </h3>
          <h3><span class="num-val">4</span>
            <b>Promote Activities & Events at No Cost. </b> We have a very high saturation level as we have already obtained 90% of every home and businesses opted-in email addresses. You’re provided a panel in which you can post announcements of your activities!</h3>
          <h3><span class="num-val">5</span>
            <b>Increased Membership:</b> Having your nonprofit listed with a contact person leads to more members! </h3>
        </div>
      </div>
      </div>

  

    </div>
    <div class="tab-pane">
                 <h3 class="title">Business Benefits</h3>
         <div class="boxes businesses-benefits">
      <div class="col-img">
        <img src="https://cdn.savingssites.com/grouppng.png">
      </div>

      <div class="col-text">
           <div class="head_col">
          <h3><span class="num-val">1</span>
            <b>Business & Residents Saturation!</b> We own the largest data business in the USA and have already collected 90% of the residents and businesses opted-in email data to promote the business directory. Most marketing services do not promote your business to the business market at all. Additionally, the municipal and nonprofit involvement in the program further saturates the market! </h3>

          <h3><span class="num-val">2</span>
            <b>Enhanced Goodwill:</b> Your participation is helping many local nonprofits raise funds, which we constantly remind residents of.  The number of good deals we ask for per month is nominal, but you’re receiving massive exposure! If we fall short of selling the limited number of deals, that’s our problem not yours! Your business had zero out of pocket costs, and no risk.</h3>
          <h3><span class="num-val">3</span>
            <b>Free Promotion of Limited Number of Deals!</b> Unlike other services we only ask your business to offer a very limited number of good deals to help local nonprofits. </h3>
          <h3 class="no-margin"><span class="num-val">4</span>
            <b>No Time Commitment! </b> Try it out for a month and if you’re not happy, quit!</h3>
          <h3><span class="num-val">5</span>
            <b>We Incentivize New Customers!</b> We provide additional discounts out of our own compensation to try new businesses! You gain new customers! </h3>
            <h3><span class="num-val">6</span>
            <b> Solo Featured Mobile Responsive Website! </b> Of course, we know you’re never going to refer your existing customers to a directory with your competitors! So, we give you your own website address to direct your customers to! Customers can make your business a favorite and opt into your FREE SHORT NOTICE ALERT PROGRAM (SNAP) email list.</h3>
            <h3><span class="num-val">7</span>
            <b>Restaurants Get Free Orders powered by Amazon!</b> If you offer a deal, there’s no charge when we refer new orders to your business. Unlike other food order, services, your business can email customers to thank them for their business and provide a discount to buy again. When users are not redeeming a deal, your cost is only $2 for an order we refer. You have an option to use your own drivers or use a pool of additional drivers. Read www.FoodOrderSavings.com, website for many more benefits.  </h3>
            <h3><span class="num-val">8</span>
            <b>Option: Free Merchant Services! </b> We are a partner of Fiserv and negotiated a tremendous deal.(a) Zero Merchant service fees (b) Automatic acceptance! So there’s no need to provide months of merchant service statements or tax returns! (c) No Monthly statement fees, (d) Free terminal (e)  National account teams for service!</h3>
        </div>
      </div>
    </div>

    </div>
    <div class="tab-pane">
                 <h3 class="title">Municipality Benefits</h3>
         <div class="boxes municipality-benefits">
      <div class="col-img">
        <img src="https://cdn.savingssites.com/Flagpng.png">
      </div>

      <div class="col-text">
           <div class="head_col">
          <h3><span class="num-val">1</span>
            <b>Protect Municipality from OPRA/FOIA/ Sunshine Disclosure Laws: </b> As you know if the municipality emailed residents, it exposes the residents’ personal data to disclosure laws where you have to turn over all the residents email addresses. We are a Microsoft and AWS partner that has developed innovative email software solutions that insulate the municipality from being forced to disclose residents’ personal information. The municipal staff still has control of the content and emailing, but the data is insulated.   </h3>

          <h3><span class="num-val">2</span>
            <b>Enhance Saturation Levels:</b> We have already collected over 90% of every home and businesses opted-in email addresses. Most municipalities who do email typically never even get to 10% of residents to join your list.</h3>
          <h3><span class="num-val">3</span>
            <b>Amazon Alexa Emergency Broadcasts:</b> We are an Amazon Alexa certified skills developer. Residents can be asked to download the FREE Amazon Alexa phone app. You can then broadcast messages directly to residents’ phones, at a rate of 1 million messages per second.    </h3>
          <h3><span class="num-val">4</span>
            <b>No Taxpayer Cost:</b> You’re getting Microsoft & AWS services at no taxpayer cost! Ask your residents if they want the municipality to continue wasting taxpayer money on inferior services, when they can get superior services at no cost.</h3>
   
        </div>
      </div>
    </div>

    </div>

  

  </div>

</div>
  <div class="col-12"><button class="btn btn-backup" id="topbar">Top of Benefits List</button></div>
    </div></div>
</section> 
  <div class="header_wraper">
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-6 col-md-4 left_col align_left_side">
          <h1>You Save & Your Favorite</h1>
          <h1 class="blue">Non-Profit Also Benefits!</h1>
          <p style="text-align: center;">Huge Discounted, Non-Expiring, Digital Deals!
            <br/>Redeem when serviced, at Business or Online!
            <br> <span class="hide-on-desk" data-toggle="modal" data-target="#ss-show">Read More</span> </p>
          <div class="bv_deeply_btn">
            <button><a class="busines_search" href="javascript:void(0);">Go to Deals!</a></button>
            <button type="button" class="youtube_btn btn btn-info btn-lg" data-toggle="modal" data-target="#foodModal"><i class="fa fa-youtube-play" aria-hidden="true"></i> YouTube Explainer</button>
          </div>
        </div>
        <div class="col-12 col-lg-6 col-md-4 left_col head_col">
          <h3>Businesses give Great Deals because we cut their costs by many thousands; then we, nonprofits and municipality promote them absolutely free!</h3>
          <h3><b>You</b> claim a deal by paying just a small part of the discount to support your favorite local nonprofit!  </h3>
          <h3><b>You</b> don’t pay business its deeply discounted price until you’re serviced! No expiration!</h3> </div>
      </div>
    </div>
  </div>
  <!--     <?php if(count($nonprofitorg) != 0){ 
      $total = count($nonprofitorg);
        if($total >12){
            $class='';
        }else{
            $class='hide';
        }
    ?> -->
    <section class="name_show zone-page" id="home_bg_name">
<!--         <div class="container">
            <div class="row">
            <?php foreach ($nonprofitorg as $k => $value) {    
              if($k <= 11){
              ?>
                <div class="col-12 col-lg-4 col-md-12 ">
                    <nav class="navbar navbar-default">
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                  <?php echo $value['name']; ?> </a>
                            </li>
                        </ul>
                    </nav>
                </div>                       
            <?php  }} ?> 
              <div class="<?= $class ?>" style="width: 100%;text-align: center;"><button class="btn btn-info loadorganization">Show All</button></div>
            </div>  
        </div> -->
         <div class="container">
          <div class="row">
              <button type="button" class="noprofit-btn loadorganization" data-toggle="modal" data-target="#loadorganization">Nonprofits you Choose to Support by Saving!<br>
                <span>
                  see list click here
              </span></button>
            </div>
          </div>
    </section>
    <?php  } ?>
<!--   <div class="top-header">
    <div class="container">
      <div id="ss-logos" class="active">
        <ul class="ss-logos">
          <li class="w150" data-caption-animate="slideInLeft" data-caption-delay="0"> <a class="busines_search" href="javascript:void(0);"><img class="logo-ssb" style="" src="<?= base_url(); ?>/assets/home/directory/images/new-savingssites3.png" /></a> </li>

        </ul>
      </div>
    </div>
  </div> --> 
<div></div>  
    <section class="comingsoon"> 
        <h3 class="windicitycoming">Coming Soon!<h3><br>
          <h2 class="foododers">Food Order Phone Line</h2> 
        <div class="windicity_img"> 
              <img class="windicityfoodimg" src="https://cdn.savingssites.com/food-order-new.png">
        </div>

         <br>
       <!-- <h2 class="foododers">More ways for you to Save & Support Nonprofits are Coming</h2><br> -->
    </section>
  <section class="slider_food">
    <div class="food_slides_new">
      <div class="carousel-inner owl-carousel owl-theme crouselHeader">
        <div class="item text-center carp1">
            <div class="fill"></div>
                <div class="carousel-caption "> 
                    <img src="https://cdn.savingssites.com/food_gif.gif" / alt="food">
                    <div class="caption_desc1">
                        <div id="mainwrap">
                          <div id="nowPlay"> <span id="npTitle"></span> </div>
                            <div id="audiowrap">
                              <div id="audio0">
                                    <audio id="audio1" preload controls>
                                      <source src="https://cdn.savingssites.com/food_audio_call.mp3" type="audio/mp3"> 
                                    </audio>
                              </div>
                            </div>                                                                      
                        </div>
                    </div>
                     <div class="container fosbullets">
                        <div class="row">
                            <div class="col-md-4">
                                <p>• Saves Money!</p>
                            </div>
                            <div class="col-md-4">
                                <p>• More Accurate!</p>
                            </div>
                            <div class="col-md-4">
                                <p>• Much Faster!</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <p>• Safer Payment!</p>
                            </div>
                            <div class="col-md-4">
                                <p>• Phone never busy!</p>
                            </div>
                            <div class="col-md-4">
                                <p>• Press key for Deal</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 pt-4">
                                <p class="presskeysam">See Many More Callers Benefits!  Click thru Read More!</p>
                            </div>
                        </div>
                    </div>  
                   <p class="animated fadeInUp read_more"><a href="javascript:void(0)" class="btn btn-transparent btn-rounded btn-large slide_btn">Read More</a></p>
                </div>
        </div>
        
        <div class="item">
            <div class="fill" style="background-image:url('https://cdn.savingssites.com/salads_5.jpg');"></div>
            <div class="carousel-caption carp2">
                <div class="caption_desc">
                    <h2 class="animated fadeInLeft">Get Discounts on Every Call!</h2>
                    <p class="animated fadeInUp left_desc">FOS enables you to redeem savings sites digital cash certificates, and the certificate ID is hashed down to one digit entry. If your favorite restaurant is not offering a deal or has sold out, they still will give you other discounts. Examples:</p>
                    <div class="moretext">
                        <p class="animated fadeInUp left_desc">(1) Simply using the service to automate its orders. </p>
                        <p class="animated fadeInUp left_desc">(2) Discounts for paying by cash, </p>
                        <p class="animated fadeInUp left_desc">(3) If you pick up instead of requiring delivery. </p>
                    </div> 
                </div>
                <p class="animated fadeInUp read_more"><a href="javascript:void(0)" class="btn btn-transparent btn-rounded btn-large slide_btn">Read More</a></p>
            </div>
        </div>
        <div class="item  ">
          <div class="fill" style="background-image:url('https://cdn.savingssites.com/chops-pork_3.jpg');"></div>
          <div class="carousel-caption carp2">
            <div class="caption_desc">
              <h2 class="animated fadeInLeft">No More Prepaying for Dinners to <br/> get Deals! Help your Favorite <br/> Nonprofit Fundraise!
              </h2>
              <p class="animated fadeInUp left_desc">Stop the nonsense of preparing for the entire dinner just to save money with services like Groupon and Local Flavor! You know how many times you end up paying upfront and end up never using it! </p>
              <div class="moretext">
                <p class="animated fadeInUp left_desc">Now, you can pay just a small donation claiming fee to claim a digital cash certificate to help your favorite nonprofits fundraiser! The Savings Sites digital cash certificate is reduced to one number to simply say or enter it on FOS line. You get your discount AT THE TIME OF SERVICE!!! </p>
              </div> </div>
            <p class="animated fadeInUp read_more"><a href="javascript:void(0)" class="btn btn-transparent btn-rounded btn-large slide_btn">Read More</a></p>
          </div>
        </div>
        <div class="item  ">
          <div class="fill" style="background-image:url('https://cdn.savingssites.com/ribs_2.jpg');"></div>
          <div class="carousel-caption carp2">
            <div class="caption_desc">
              <h2 class="animated fadeInLeft">One Sign-Up for all <br/> USA Restaurants!</h2>
              <p class="animated fadeInUp left_desc">Food Order Savings uses the sign-up that is done by residents to get important municipal emergency and general notices and to help local nonprofits raise funds. </p>
            </div>
            <p class="animated fadeInUp read_more"><a href="javascript:void(0)" class="btn btn-transparent btn-rounded btn-large slide_btn">Read More</a></p>
          </div>
        </div>
        <div class="item  ">
          <div class="fill" style="background-image:url('https://cdn.savingssites.com/tacos-burritos-3.jpg');"></div>
          <div class="carousel-caption carp2">
            <div class="caption_desc">
              <h2 class="animated fadeInLeft">Your Personal Data is Protected!</h2>
              <p class="animated fadeInUp left_desc">We will not sell your data! Additionally, we help municipal governments communicate with residents in a manner to protects the resident’s data. </p>
              <div class="moretext">
                <p class="animated fadeInUp left_desc">Municipalities must adhere to forced disclosure laws like Open Public Records Act and FOIA. These laws normally force the Municipality to disclose all residents email data, etc., just by demanding it! Our unique email software coupled with our partner Microsoft insulates the municipality form being forced to give away your data!</p>
              </div>  </div>
            <p class="animated fadeInUp read_more"><a href="javascript:void(0)" class="btn btn-transparent btn-rounded btn-large slide_btn">Read More</a></p>
          </div>
        </div>
        <div class="item  ">
          <div class="fill" style="background-image:url('https://cdn.savingssites.com/chinese_dishes_50.jpg');"></div>
          <div class="carousel-caption carp2">
            <div class="caption_desc">
              <h2 class="animated fadeInLeft">No More Typing Into Phone! </h2>
              <p class="animated fadeInUp left_desc">No more thumb typo mistakes into a cell phone. </p>
            </div>
            <p class="animated fadeInUp read_more"><a href="javascript:void(0)" class="btn btn-transparent btn-rounded btn-large slide_btn">Read More</a></p>
          </div>
        </div>
        <div class="item  ">
          <div class="fill" style="background-image:url('https://cdn.savingssites.com/stromboli_2.jpg');"></div>
          <div class="carousel-caption  carp2">
            <div class="caption_desc">
              <h2 class="animated fadeInLeft">Delivery Information & Special <br/> Delivery
                    Instructions are Auto <br/> Transferred to Restaurants!
               </h2>
              <p class="animated fadeInUp left_desc">In addition to full contact data transferred to restaurant in writing, callers when signing up specified special delivery information! Come to the side door not the front. Don’t ring the doorbell just text me because the dogs will come running to the door! Callers know their own written delivery instructions save time on every order and have less chance of delivery mistakes. </p>
            </div>
            <p class="animated fadeInUp read_more"><a href="javascript:void(0)" class="btn btn-transparent btn-rounded btn-large slide_btn">Read More</a></p>
          </div>
        </div>
        <div class="item  ">
          <div class="fill" style="background-image:url('https://cdn.savingssites.com/soup-chowder-new-england.jpg');"></div>
          <div class="carousel-caption  carp2">
            <div class="caption_desc">
              <h2 class="animated fadeInLeft">Favorite Keys Make Ordering <br/> Fast & Accurate!
              </h2>
              <p class="animated fadeInUp left_desc">When signing-up callers can detail for every restaurant their favorite menu items and if not the norm, callers can detail exactly how they want it made. Callers pick FAVORITE KEYS so when they order they simply say the key number and all content is transferred, exactly as the caller wrote it up! Callers know there is greater chance that their order will not be wrong! </p>
            </div>
            <p class="animated fadeInUp read_more"><a href="javascript:void(0)" class="btn btn-transparent btn-rounded btn-large slide_btn">Read More</a></p>
          </div>
        </div>
        <div class="item  ">
          <div class="fill" style="background-image:url('https://cdn.savingssites.com/salads_8.jpg');"></div>
          <div class="carousel-caption carp2">
            <div class="caption_desc">
              <h2 class="animated fadeInLeft">No More Giving Your Card Info! Safely Store it!
              </h2>
              <p class="animated fadeInUp left_desc">Callers also obviously prefer paying with a secure payment than spending time on the phone giving all their card information to an order taker! Simply, no more risks and time wasted giving credit card information over the phone! </p>
            </div>
            <p class="animated fadeInUp read_more"><a href="javascript:void(0)" class="btn btn-transparent btn-rounded btn-large slide_btn">Read More</a></p>
          </div>
        </div>
        <div class="item  ">
          <div class="fill" style="background-image:url('https://cdn.savingssites.com/burgers_17.jpg');"></div>
          <div class="carousel-caption  carp2">
            <div class="caption_desc">
              <h2 class="animated fadeInLeft">No More Busy Lines <br/> or Being Put on Hold!

              </h2>
              <p class="animated fadeInUp left_desc">Now callers simply call and they are off the phone in seconds having completed an accurate transfer of information and with a more secure payment! </p>
            </div>
            <p class="animated fadeInUp read_more"><a href="javascript:void(0)" class="btn btn-transparent btn-rounded btn-large slide_btn">Read More</a></p>
          </div>
        </div>
        <div class="item  ">
          <div class="fill" style="background-image:url('https://cdn.savingssites.com/soup-chowder-new-england.jpg');"></div>
          <div class="carousel-caption carp2">
            <div class="caption_desc">
              <h2 class="animated fadeInLeft">You Get Copy of your <br/> Order for Accuracy!

               </h2>
              <p class="animated fadeInUp left_desc">Restaurants are busy with calls, and they are prone to making mistakes. Having your food delivered that is not prepared as you requested happens all the time. Now you and the restaurant have audio and transcription evidence to eliminate wrong orders. </p>
            </div>
            <p class="animated fadeInUp read_more"><a href="javascript:void(0)" class="btn btn-transparent btn-rounded btn-large slide_btn">Read More</a></p>
          </div>
        </div>
        <div class="item  ">
          <div class="fill" style="background-image:url('https://cdn.savingssites.com/veal-milanese_3.jpg');"></div>
          <div class="carousel-caption carp2">
            <div class="caption_desc">
              <h2 class="animated fadeInLeft">Hear Delivery Time then Decide Delivery or Pickup 

              </h2>
              <p class="animated fadeInUp left_desc">Callers really are not always positive whether they will pick up or have it delivered. It all depends upon how long the delivery time is! Now callers hear the delivery time set by the restaurant! Callers then decide if they want it delivered or they’ll just pick it up! </p>
            </div>
            <p class="animated fadeInUp read_more"><a href="javascript:void(0)" class="btn btn-transparent btn-rounded btn-large slide_btn">Read More</a></p>
          </div>
        </div>
        <div class="item  ">
          <div class="fill" style="background-image:url('https://cdn.savingssites.com/pasta-with-macaroni-cheese.jpg');"></div>
          <div class="carousel-caption carp2">
            <div class="caption_desc">
              <h2 class="animated fadeInLeft">Live Entertainment Schedule <br/>& Daily Specials by Text! </h2>
              <p class="animated fadeInUp left_desc">No need to go to the restaurant and have the server read you the daily specials! Who can even remember the whole list and how each is made! It’s much better to have the specials and their ingredients texted to you! Then you will know whether you want to go to the restaurant to get one of the daily specials. </p>
              <div class="moretext">
                <p class="animated fadeInUp left_desc"> Also, many Restaurants have live entertainment and Karaoke Nights so you can find out without calling them.</p>
              </div>  </div>
            <p class="animated fadeInUp read_more"><a href="javascript:void(0)" class="btn btn-transparent btn-rounded btn-large slide_btn">Read More</a></p>
          </div>
        </div>
        <div class="item  ">
          <div class="fill" style="background-image:url('https://cdn.savingssites.com/bread-bagels.jpg');"></div>
          <div class="carousel-caption  carp2">
            <div class="caption_desc">
              <h2 class="animated fadeInLeft">Callers Substantially Benefit <br/>

                by using Food Order Savings <br/>

                than any other Ordering Service!

                </h2>
              <p class="animated fadeInUp left_desc">Saves Money! Easier! Faster! More Accurate! Less Risky with your card! Helps your favorite nonprofit rasie funds. </p>
              <p class="animated fadeInUp left_desc"> There is simply no reason to use any other service!</p>
            </div>
            <p class="animated fadeInUp read_more"><a href="javascript:void(0)" class="btn btn-transparent btn-rounded btn-large slide_btn">Read More</a></p>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <style type="text/css">

  #hide-on-desk {
    display: none !important;
  }
  
  @media (max-width: 767px) {
    #hide-on-mob {
      display: none !important;
    }
    #hide-on-desk {
      display: block !important;
    }
  }

.doAnimation .slick-active .carousel__slide__inner .carousel__image {
  -webkit-animation: scale-out 0.875s cubic-bezier(0.7, 0, 0.3, 1) 0.375s both;
          animation: scale-out 0.875s cubic-bezier(0.7, 0, 0.3, 1) 0.375s both;
  transform: scale(1.3);
}
.carousel__slide__overlay {
  background-color: transparent;
  background-size: 100%;
  height: 100%;
  left: 0;
  opacity: 0.5;
  position: absolute;
  top: 0;
  width: 100%;
  z-index: 2;
}
.slick-active .carousel__slide__overlay {
  animation: scale-in-hor-left 1.375s cubic-bezier(0.645, 0.045, 0.355, 1) 0.25s reverse both;
}
.carousel__image {
  height: 100%;
  -o-object-fit: cover;
     object-fit: cover;
  position: relative;
  transform: scale(1);
  width: 100%;
  z-index: 1;
}

@-webkit-keyframes scale-out {
  0% {
    transform: scale(1.3);
  }
  100% {
    transform: scale(1);
  }
}

@keyframes scale-out {
  0% {
    transform: scale(1.3);
  }
  100% {
    transform: scale(1);
  }
}
@-webkit-keyframes scale-in-hor-left {
  0% {
    transform: translateX(-100%) scaleX(0);
    transform-origin: 0% 0%;
    opacity: 1;
  }
  50% {
    transform: translateX(-50%) scaleX(0.5);
    transform-origin: 0% 0%;
    opacity: 1;
  }
  100% {
    transform: translateX(0) scaleX(1);
    transform-origin: 0% 0%;
    opacity: 1;
  }
}
@keyframes scale-in-hor-left {
  0% {
    transform: translateX(-100%) scaleX(0);
    transform-origin: 0% 0%;
    opacity: 1;
  }
  50% {
    transform: translateX(-50%) scaleX(0.5);
    transform-origin: 0% 0%;
    opacity: 1;
  }
  100% {
    transform: translateX(0) scaleX(1);
    transform-origin: 0% 0%;
    opacity: 1;
  }
}
  </style>
<section id="project">
    <div class="header common text-left">
        <center><h3>More Ways to Save & <span>Support Nonprofits are Coming! </span></h3></center> 
    </div>
    <div class="carousel boxxes">
        <div class="carousel__slide">
           <!-- <button type="button" data-role="none" role="button" tabindex="0"></button> -->
            <div class="carousel__slide__inner">
                <div class="project-text" bis_skin_checked="1">
                    <div class="project-img" bis_skin_checked="1">
                        <img src="https://cdn.savingssites.com/snapdining.jpg" class="img-responsive" alt="saving-site-logo">
                    </div>

                    <h2>Snap Dining Discounted Reservations!</h2>
                    <p>
                        Restaurants will be able to show the days of the week and hours of the days that you get a percentage discount. If you bought a deal to support your favorite nonprofit that deal will also be redeemable when reservation is made!
                    </p>
                    <div bis_skin_checked="1">
                        <p class="text" style="display: none;">
                        </p>
                    </div>
                    <div class="btn-container" bis_skin_checked="1">
                        
                    </div>
                 </div>
                  <div class="carousel__slide__overlay"></div>
           </div>
        </div>


        <div class="carousel__slide">
            <div class="carousel__slide__inner">
                <div class="project-text" bis_skin_checked="1">
                    <div class="project-img" bis_skin_checked="1">
                        <img src="https://cdn.savingssites.com/hugegroupdeals.jpg" class="img-responsive" alt="saving-site-logo">
                    </div>
                    <h2>Huge Group Deals</h2>
                    <p>
                        Free to join! Huge group deals on both business and consumer products and services! We get huge deals because we already have group buying power from hundreds of millions opted-in emails nationally!
                    </p>
                    <div bis_skin_checked="1">
                        <p class="text" style="display: none;">
                        </p>
                    </div>
                    <div class="btn-container" bis_skin_checked="1">
                        
                    </div>
                 </div>
                  <div class="carousel__slide__overlay"></div>
           </div>
        </div>


        <div class="carousel__slide">
            <div class="carousel__slide__inner">
                <div class="project-text" bis_skin_checked="1">
                    <div class="project-img" bis_skin_checked="1">
                        <img src="https://cdn.savingssites.com/peekabooauctions.png" class="img-responsive" alt="saving-site-logo">
                    </div>
                    <h2>Peekaboo Auctions</h2>
                    <p>
                        You’re going to have so much fun playing Peekaboo. Peekaboo is a unique reverse blind auction. Example: A dinner price starts out at $100 and there is a hidden price that is even less. Say the hidden price is $80. You buy “peeking credits” for 25 cents to support your favorite nonprofit! You use a peeking credit to get 20 seconds to decide if you want to end the auction and buy at that low hidden price.You and everyone else may bypass buying at the hidden price because each bypass causes the hidden price to drop! Eventually the price goes so low, for example to $5, and someone will say LOW ENOUGH, and end auction by buying! But everyone wins because all the “losers” still get to buy the $100 value for $80, and more than cover their peeking credit donation. Bidders, Sellers, Nonprofits Orgs all Win! 
                    </p>
                    <div bis_skin_checked="1">
                        <p class="text" id="textshow" style="display: none;">
                        </p>
                    </div>
                    <div class="btn-container" bis_skin_checked="1">
                        <div class="header-btn-group bv_read" bis_skin_checked="1">
                            <!-- <button class="readshow toggle boxed-btn  slideUp" tabindex="-1">Read More</button> -->
                        </div>
                    </div>
                 </div>
                  <div class="carousel__slide__overlay"></div>
           </div>
        </div>

        <div class="carousel__slide">
            <div class="carousel__slide__inner">
                <div class="project-text" bis_skin_checked="1">
                    <div class="project-img" bis_skin_checked="1">
                        <img src="https://cdn.savingssites.com/liveeventsfun.png" class="img-responsive" alt="saving-site-logo">
                    </div>
                    <h2>Live Events Fun & Edu Webinars</h2>
                    <p>
                       In partnership with Microsoft we organize by category, with detailed description, the time and date that businesses will host Fun and Educational Webinars! It’s free to attend live or watch a recording! 
                       We also will host group tutoring classes on common classes students have difficulty with. Also classes that are not typically taught in schools, like computer coding. Top teachers will tutor, and group participants will pay as low as $1 per hour! As usual your favorite nonprofit will be supported!
                            </p>
                    <div bis_skin_checked="1">
                        <p class="text" style="display: none;">
                        </p>
                    </div>
                    <div class="btn-container" bis_skin_checked="1">
                        
                    </div>
                 </div>
                  <div class="carousel__slide__overlay"></div>
           </div>
        </div>

        <div class="carousel__slide">
            <div class="carousel__slide__inner">
                <div class="project-text" bis_skin_checked="1">
                    <div class="project-img" bis_skin_checked="1">
                        <img src="https://cdn.savingssites.com/savingsdeliveryorder.png" class="img-responsive" alt="saving-site-logo">
                    </div>
                    <h2>Savings Delivery Order Online</h2>
                    <p>
                       When you place your online order you’ll be able to redeem any deal that you bought to support your favorite nonprofit! 
                    </p>
                    <div bis_skin_checked="1">
                        <p class="text" style="display: none;">
                        </p>
                    </div>
                    <div class="btn-container" bis_skin_checked="1">
                        
                    </div>
                 </div>
                  <div class="carousel__slide__overlay"></div>
           </div>
        </div>

        <div class="carousel__slide">
            <div class="carousel__slide__inner">
                <div class="project-text" bis_skin_checked="1">
                    <div class="project-img" bis_skin_checked="1">
                        <img src="https://cdn.savingssites.com/savingslinksyours.png" class="img-responsive" alt="saving-site-logo">
                    </div>
                    <h2>Savings Links Yours and Our favorites</h2>
                    <p>
                        We will freely supply you with a detailed synopsis of links to many other websites that will save you money!
                    </p>
                    <div bis_skin_checked="1">
                        <p class="text" style="display: none;">
                        </p>
                    </div>
                    <div class="btn-container" bis_skin_checked="1">
                        
                    </div>
                 </div>
                  <div class="carousel__slide__overlay"></div>
           </div>
        </div>

        <div class="carousel__slide">
            <div class="carousel__slide__inner">
                <div class="project-text" bis_skin_checked="1">
                    <div class="project-img" bis_skin_checked="1">
                        <img src="https://cdn.savingssites.com/classifiedseasy.png" class="img-responsive" alt="saving-site-logo">
                    </div>
                    <h2>Classifieds Easy to Buy, Easy to Sell</h2>
                    <p>
                        Our classifieds platform is unlike any other classifieds service! It’s so innovative that we won’t explain it until it’s ready for rollout because others will copy! Promise, you’ll never need to use any other classifieds.
                    </p>
                    <div bis_skin_checked="1">
                        <p class="text" style="display: none;">
                        </p>
                    </div>
                    <div class="btn-container" bis_skin_checked="1">
                        
                    </div>
                 </div>
                  <div class="carousel__slide__overlay"></div>
           </div>
        </div>

        <div class="carousel__slide">
            <div class="carousel__slide__inner">
                <div class="project-text" bis_skin_checked="1">
                    <div class="project-img" bis_skin_checked="1">
                        <img src="https://cdn.savingssites.com/localblog.png" class="img-responsive" alt="saving-site-logo">
                    </div>
                    <h2>Local Blog</h2>
                    <p>
                        Many blog categories that neighbors can post their comments. All comments are from registered members, so there won’t be any anonymous trolls.
                    </p>
                    <div bis_skin_checked="1">
                        <p class="text" style="display: none;">
                        </p>
                    </div>
                    <div class="btn-container" bis_skin_checked="1"></div>
                </div>
                  <div class="carousel__slide__overlay"></div>
           </div>
        </div>
   </div>
</section>
 <section class="container-fluid images_partners ours_partners pt-5">
    <h2 class="partner_name">Our <span class="h1benefits">Partners</span></h2>
      <div class="Inner_wrapper">
        <div class="row text-center" id="div_partner">
           <div class="col-lg-2 col-sm-12 seoimg pt-5">
             <img src="https://cdn.savingssites.com/SEo_new.png">  
           </div>
           <div class="col-lg-2 col-sm-12 pt-5">
             <img class="partner_microsoft" src="https://cdn.savingssites.com/micorsoft.png">  
           </div>
           <div class="col-lg-3 col-sm-12 pt-5">
             <img src="https://cdn.savingssites.com/amazon_spn.png">  
           </div>
           <div class="col-lg-3 col-sm-12 pt-5">
             <img src="https://cdn.savingssites.com/FiservLogo.png">  
           </div>
           <div class="col-lg-2 col-sm-12 pt-5">
             <img src="https://cdn.savingssites.com/QuickBooks-Certified-ProAdvisor.jpg">  
           </div>
        </div> 
     </div>
  </section>
  <div  class="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="youTube_explainer">
    <div class="modal-backdrop fade in"></div>

            <div class="modal-dialog" role="document" id="example">

                <div class="modal-content lottery-box-video">

    <div class="modal-header">                     
            <h4 class="modal-title" id="myModalLabel">
                   <i class="fa fa-thumbs-o-up" aria-hidden="true" style="position: relative;
    top: 7px;"></i>
                    <span id="login_type_name" logintype="4">Save By Giving!</span>
                </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
            </div>

                    <div class="modal-body">                                                

                        <div class="embed-responsive embed-responsive-16by9">
                   
                          <iframe id="video1" width="640" height="360" src="https://www.youtube.com/embed/USZAofevitM?autoplay=1&mute=1&enablejsapi=1" frameborder="0" style="border: solid 4px #37474F"></iframe>
                        </div>

                    </div>

                </div>

            </div>

        </div> 



