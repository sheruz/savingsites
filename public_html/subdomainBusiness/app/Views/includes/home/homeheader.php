<header class="section page-header home_header">
        <div class="header-top">
            <div class="container">
                <div class="row justify-content-center align-items-xl-center">
                    <div class="col-sm-12">
                        <div class="menu-center mobile_view">
                            <ul class="rd-navbar-nav">
                                <li class="rd-nav-item">
                                    <div class="dropdown">
                                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Local Savings Search</button>
                                        <div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuButton1">
                                            <a class="dropdown-item busines_search" href="javascript:void(0);">Search for Business Offers 4 Ways</a>
                                            <a class="dropdown-item snapDining" href="javascript:void(0);">Search All Restaurant Reservations</a>
                                            <a class="dropdown-item sspeekaboo" href="javascript:void(0);">Pboo Auctions <small>(Discounted Cash Certificates)</small></a>
                                            <a class="dropdown-item" href="javascript:void(0);">Savings Circulars</a>
                                            <a class="dropdown-item toggle-btn-pop" href="javascript:void(0);" data-target="create-links1">Access Other Savings Sites</a>
                                            <a class="dropdown-item" href="https://design.savingssites.com/groupsavings/">Huge Group Deals</a>
                                            <a class="dropdown-item webinar" href="javascript:void(0);">Free Educational Webinars</a>
                                        </div>
                                    </div>
                                </li>
                                <li class="rd-nav-item">
                                    <div class="dropdown">
                                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Local News &amp; Events</button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton2">
                                            <a class="dropdown-item toggle-btn calendar-view" href="javascript:void(0);" data-target="calendarSystem">Events Calendar</a>
                                            <a class="dropdown-item toggle-btn organization" href="javascript:void(0);" data-target="area-organization">Local Organization</a>
                                            <a class="dropdown-item toggle-btn high-school" href="javascript:void(0);" data-target="area-highschoolsports">High School Sports/Events</a>
                                            <a class="dropdown-item" href="<?= base_url(); ?>/blog/index.php?b=0&amp;z=598" target="_blank">Local Blog</a>
                                            <a class="dropdown-item" href="https://www.cybersquadwebsites.com.au/sastone/m01/" target="">Classifieds</a>
                                            <a class="dropdown-item" href="" target="">Free Educational Webinars</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                                        <div class="col-12 col-lg-3 col-md-12" id="commonConsultationPopup"> 
                                            <div class="municipality-logo home_logo">
                            <a class="brand" href="<?= base_url(); ?>"><img src="https://cdn.savingssites.com/logo-green.png" alt=""></a>
                        </div>
                                        </div>
                    <div class="col-12 col-lg-6 col-md-4 bv_welcome_col">
                                                        <span class="list-inline user-menu pull-right">
                                    <!-- <li class="user-register deals">
                                    <a class="busines_search" href="javascript:void(0);">
                                        <img class="logo-ssb" style="" src="<?= base_url(); ?>/assets/home/directory/images/new-savingssites3.png">
                                    </a>
                            </li> -->
                            <span class=" ">
                                <form action="#" id="claim">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="text" id="zip" class="top-search-form" placeholder="Find Local Directory" >
                                            <a href="javascript:void(0);" class="showgobtn btn-default">GO</a>
                                        </div>
                                    </div>      
                                </form>
                            </span>
                            <!-- <li class="rd-nav-item save_hide_banner">Close Banner</li> -->
                        </span>
                                            <ul class="list-inline user-menu pull-right"></ul>
                                         </div>
                                        <div class="col-12 col-lg-3 col-md-12 head_last_col"> 
                                            <li style="color:#000;margin-bottom: 10px;">
                                                <?php if(!empty($user_id)){
                                                    echo 'Welcome Back!'.$firstName." ".$lastName.'<a href="javascript:void(0)" onclick="sign_out();" style=""><i class="fa-solid fa-right-from-bracket"></i>Logout</a>'; 
                                                }
                                                ?>
                                            </li>
                        <li><a href="javascript:void(0);" class="bv_contact_btn" data-toggle="modal" data-target="#conpop">Contact</a></li>




                        <nav role="navigation " id="checkk" class="dropdown-submenu new" style="display: none !important;">
                            <div id="menuToggle" class="home_menuToggle">
                                <input type="checkbox"><span></span><span></span><span></span>
                            </div>
                            <ul class="dropdown-menu_list1" id="menu-bar" style="display: none;">
                                <div class="cus_menu">
   
                                    <li class="rd-nav-item">
                                        <a class="rd-nav-link toggle-btn organization" href="javascript:void(0);" data-target="area-organization">Non-Profits</a>
                                    </li>
                                    <li class="rd-nav-item">
                                        <a class="rd-nav-link toggle-btn organization" href="javascript:void(0);" data-target="area-organization">Events</a>
                                    </li>
   
                                </div>            
                                <div class="logoss">
                                    <ul class="logo-row first-row">
                                        <li>
                                            <a href="<?= base_url(); ?>/businessSearch/search/<?= $zoneid;?>" target="_blank"><img class="disable 4" style="" src="https://cdn.savingssites.com/new-savingssites.png"></a>
                                        </li>
                                    </ul>
                                </div>
                            </ul>
                        </nav>
                                            <div class="mobile nav-menu" style="position: relative;display: none;">
                            <div class="container">
                                <div class="row justify-content-center align-items-xl-center">
                                    <div class="col-12">
                                        <div class="rd-navbar-wrap">
                                            <nav class="rd-navbar rd-navbar-classic" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-fixed" data-xl-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static" data-xxl-layout="rd-navbar-static" data-xxl-device-layout="rd-navbar-static" data-lg-stick-up-offset="46px" data-xl-stick-up-offset="46px" data-xxl-stick-up-offset="46px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
                                                <div class="rd-navbar-main-outer">
                                                    <div class="rd-navbar-main">
                                                        <div class="rd-navbar-panel">
                                                            <li class="user-register new_logo rd-nav-item">
                                                                <a class="busines_search gl" href="javascript:void(0);"><img class="logo-ssb" style="" src="https://cdn.savingssites.com/logo-green.png"></a>
                                                            </li>
                                                            <ul class="top_menu_login">
                                                                <li class="">
                                                                    <form action="#" id="claim">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <input type="text" id="zip" placeholder="Find Local Directory" style="      font-family: serif;   width: 140px;padding: 6px 4px;margin:0 5px;"><a href="javascript:void(0);" class="gobtn gobtnzip btn btn-default">GO</a>
                                                                            </div>
                                                                        </div>      
                                                                    </form>
                                                                </li>
                                                            </ul>
                                                            <a class="btn btn-hh-logos-trigger toggle-btns active" role="button" data-target="ss-logos"><i class="fa fa-sitemap" aria-hidden="true"></i></a>
                                                            <div class="dropdown themeswitcher">
                                                                <a class="btn btn-hh-mobile-trigger" id="themeswitcher1" data-version="1660815103.4319" role="button" data-toggle="dropdown"><i class="fa fa-magic" aria-hidden="true"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="themeswitcher1">
                                                                    <a class="dropdown-item theme purple" href="javascript:void(0);" data-theme="purple">Fun Purple</a>
                                                                    <a class="dropdown-item theme brown" href="javascript:void(0);" data-theme="brown">Cozy Brown</a>
                                                                    <a class="dropdown-item theme green" href="javascript:void(0);" data-theme="green">Save Green</a>
                                                                    <a class="dropdown-item theme blue" href="javascript:void(0);" data-theme="blue">Old Glory</a>
                                                                </div>
                                                            </div>
                                                            <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span>
                                                            </button>
                                                            <div class="rd-navbar-brand">
                                                                <a class="brand" href="index.php"><img src="https://cdn.savingssites.com/logo.png" alt=""></a>
                                                            </div>
                                                        </div>
                                                        <div class="rd-navbar-main-element">
                                                            <div class="rd-navbar-nav-wrap toggle-original-elements">
                                                                <div class="menu-left">
                                                                    <ul class="rd-navbar-nav">
                                                                        <li class="user-register new_logo rd-nav-item">
                                                                            <a class="busines_search gl" href="javascript:void(0);"><img class="logo-ssb" style="" src="https://cdn.savingssites.com/logo-green.png"></a>
                                                                        </li>
                                                                        <li class="rd-nav-item "><a class="rd-nav-link" href="<?= base_url(); ?>/home/about_us">About</a>
                                                                        </li>
                                                                        <li class="rd-nav-item ">
                                                                            <a class="rd-nav-link" href="<?= base_url(); ?>/home/contact_us">Contact</a>
                                                                        </li>
                                                                        <li class="rd-nav-item">
                                                                            <a class="rd-nav-link toggle-btn organization" href="javascript:void(0);" data-target="area-organization">Non-Profits</a>
                                                                        </li>   
                                                                        <li class="rd-nav-item">
                                                                            <a class=" rd-nav-link toggle-btn eventcalender" href="javascript:void(0);" data-target="area-calendar">Events</a>
                                                                        </li>     
                                                                       <!--  <li class="user-register deals">
                                                                            <a class="busines_search" href="javascript:void(0);"><img class="logo-ssb" style="" src="<?= base_url(); ?>/assets/home/directory/images/new-savingssites3.png"></a>
                                                                        </li>  -->
                                                                    </ul>
                                                                </div>
                                                                <div class="menu-center">
                                                                    <ul class="rd-navbar-nav">
                                                                        <li class="rd-nav-item demobadge"><a class="rd-nav-link" href="/zone/Chi-Town-Deals/"><i class="fa fa-play-circle-o" aria-hidden="true"></i> Demo Directory</a>
                                                                        </li>                        
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>           
                                                </div>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

<!-- Modal -->
<div class="modal fade" id="conpop" tabindex="-1" role="dialog" aria-labelledby="conpop" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Contact Us</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body" id="contactmodal">
                
        </div>
    </div>
  </div>
</div>