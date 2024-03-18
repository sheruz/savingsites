<?php include("head.php");?>
<header class="desktop_view">
   <div class="container">
      <div class="row align-middle">
         <div class="col-md-2">
            <div class="main_logo">
               <img src="https://cdn.savingssites.com/new-savingssites3.png">
               
                  
               
               <li role='navigation ' id="checkk" class="dropdown-submenu new com_li hide_on_desktop">
                  <div id="menuToggle-mobile" >
                     <input type="checkbox" /><span></span><span></span><span></span>
                  </div>
                  <ul class="dropdown-menu_list1" id="menu-bar-mobile" >
                     <li class="user-register fullwidth">
                        <a  href="<?=base_url() ?>/zone/<?= $zoneid;?>" class="btn-link cus-top-pad"><i class="fa fa-home"></i> $$ Home</a>
                     </li>
                     <?php if($user_id  == ''){ ?>
                     <li class="user-register">
                        <div class="dropdown">
                           <a class="btn-link dropdown-toggle cus-top-pad" type="button" id="dropdownMenuButton13" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-edit text-primary"></i>Register</a>
                           <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton13">
                              <a link="userregistration" class="dropdown-item toggle-btn-pop modal_form_open" href="javascript:void(0);" data-toggle="modal">Residents</a>
                              <a link="business_registration" class="modal_form_open dropdown-item toggle-btn-pop" data-reffer='<?php  if(@$refferalcode){ echo @$refferalcode;  } ?>' href="javascript:void(0);" data-zoneId="<?= $zoneid ?>">Create Deals</a>
                              <a link="organization_registration" class="modal_form_open dropdown-item toggle-btn-pop"  data-reffer='<?php  if(@$refferalcode){ echo @$refferalcode;  } ?>' href="javascript:void(0);">Nonprofit Orgs</a>
                              <a link="employee_registration" class="dropdown-item toggle-btn-pop modal_form_open" data-toggle="modal"  href="javascript:void(0);">Local Employee</a>
                              <a link="visitor_registration" class="modal_form_open dropdown-item toggle-btn-pop"  data-toggle="modal" href="javascript:void(0);">Visitor</a>
                              <a link="sponsor_registration" class="modal_form_open dropdown-item toggle-btn-pop"  data-toggle="modal" href="javascript:void(0);">Sponsor</a>
                           </div>
                        </div>
                     </li>
                     <li class="user-login">
                        <div class="dropdown">
                           <a class=" dropdown-toggle btn-link" type="button" id="dropdownMenuButton13" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-sign-in text-primary"></i>Login</a>
                           <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton13">
                              <a class="dropdown-item toggle-btn-pop loginTextChange" href="javascript:void(0);" data-toggle="modal" data-target="#login-box2" id="neighbors_login" title="neighbour_login">Residents ss6</a>
                              <a class="dropdown-item toggle-btn-pop loginTextChange" href="javascript:void(0);" data-toggle="modal" data-target="#login-box2" id="businesses_login" title="businesses_login"> Create Deals</a>
                              <a class="dropdown-item toggle-btn-pop loginTextChange" href="javascript:void(0);" data-toggle="modal" data-target="#login-box2" id="organisations_login" title="organisations_login">Nonprofit Orgs</a>
                              <a class="dropdown-item toggle-btn-pop loginTextChange employee_login"  data-toggle="modal" data-target="#login-box2" id="#login-box"   title="employee_login" href="javascript:void(0);">Local Employee</a>
                              <a class="dropdown-item toggle-btn-pop loginTextChange visitor_login tyt"  data-toggle="modal" data-target="#login-box2" id="#login-box"   title="visitor_login" href="javascript:void(0);">Visitor</a>
                           </div>
                        </div>
                     </li>
                     <?php }else{?>
                     <li class="sign_out_directory"> 
                        <a target="_blank" href="<?= $baseloginUrl; ?>/Zonedashboard/zoneinformation" class="btn-link cus-top-pad"><i class="fa fa-edit text-primary "></i> Back To Dashboard</a>
                     </li>
                     <li class="sign_out"> 
                        <a href="javascript:void(0)" class="sign_out btn-link cus-top-pad" onclick="sign_out();" style=""><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
                     </li>
                     <?php } ?>
                     
                     
                     <li class="rd-nav-item themeswitcher">
                        <div class="dropdowns" style="">
                           <button class="btn btn-default dropdown-toggle btn-link icon-theme" type="button" id="themeswitcher" data-version="<?php echo microtime(true); ?>" data-theme="<?php echo $business_theme ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style=""><?php echo $business_page ?></button>
                           <div class="dropdown-menu dropdown-menu-right" aria-labelledby="themeswitcher" x-placement="bottom-end">
                              <!-- <a class="dropdown-item purple changetheme" href="javascript:void(0);" data-theme="purple">Fun Purple</a>
                              <a class="dropdown-item brown changetheme" href="javascript:void(0);" data-theme="brown">Cozy Brown</a>
                              <a class="dropdown-item green changetheme" href="javascript:void(0);" data-theme="green">Save Green</a>
                              <a class="dropdown-item blue changetheme" href="javascript:void(0);" data-theme="oldGlory">Old Glory</a> -->
                           </div>
                        </div>
                     </li>
                                             <div class="video_modal mobile_view_new0">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#about-modal">About
</button>
   <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#foodModal">Deals Video</button>
   <a href="#aboutDining" data-toggle="modal" data-target="#snap_filter" class="with-icon btn-link btn btn-info btn-lg" style="    margin-left: 5px;">
   SNAP
   <span class="mobile_hide">Filters</span>?</a>

</div>
                     
                     </ul>
                     </li>
            </div>
         </div>
         <div class="col-md-7">
           <div class="center_text_no_profit">
               <h2>You Save & Support<span> Your Favorite Nonprofit! <span style="margin-left: 10px;margin-right:10px;font-size: 20px;color: #000;">About</span><i class="fa fa-angle-right" id="topheaderangle"></i></span>
               </h2>
               
            </div>

         </div>
         <div class="col-md-3">
            <div class="user-sec">
            <?php if (empty($user_id)) {?>
            <?php } ?>
            <?php if (!empty($user_id)) {
                     $fullnamedisplay = (strlen($firstName.' '.$lastName) > 16) ? $firstName : $firstName.' '.$lastName ;
                     echo '<span class="logged-in">Hi '.$fullnamedisplay.'! <a href="javascript:void(0);" class="sign_out" onclick="sign_out();">Logout</a></span>' ;
                  }
            ?>
            </div>
            <div class="login_cart_icon">
               <ul>
               <li><span class="<?= $cartclass; ?>" id="cartcount" cartcount="<?= $cartcount; ?>"><?= $cartcount; ?></span></li>
               <li class="com_li cart_login"><i class="fa fa-shopping-cart" aria-hidden="true"></i></li>
               <li role='navigation ' id="checkk" class="dropdown-submenu new com_li">
                  <div id="menuToggle">
                     <input type="checkbox" /><span></span><span></span><span></span>
                  </div>
                  <ul class="dropdown-menu_list1" id="menu-bar" >
                     <li class="user-register fullwidth">
                        <a  href="https://<?php echo $subdomainZoneget;?>.savingssites.com" class="btn-link cus-top-pad"><i class="fa fa-home"></i> $$ Home</a>
                     </li>
                     <li class="rd-nav-item themeswitcher">
                        <div class="dropdowns showdropdown" style="">
                           <button class="btn btn-default dropdown-toggle btn-link icon-theme" type="button" id="themeswitcher" data-version="<?php echo microtime(true); ?>" data-theme="<?php echo $business_theme ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style=""><?php echo $business_page ?></button>
                           <div class="dropdown-menu dropdown-menu-right showdropdown" aria-labelledby="themeswitcher" x-placement="bottom-end">
                              <!-- <a class="dropdown-item changetheme" href="javascript:void(0);" data-theme="purple">Fun Purple</a> -->
                              <!-- <a class="dropdown-item changetheme" href="javascript:void(0);" data-theme="brown">Cozy Brown</a> -->
                              <!-- <a class="dropdown-item changetheme" href="javascript:void(0);" data-theme="green">Save Green</a> -->
                              <!-- <a class="dropdown-item changetheme" href="javascript:void(0);" data-theme="oldGlory">Old Glory</a> -->
                           </div>
                        </div>
                     </li>
                     <?php if($user_id  == ''){ ?>
                     <li class="user-register">
                        <div class="dropdown">
                           <a class="btn-link dropdown-toggle cus-top-pad" type="button" id="dropdownMenuButton13" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-edit text-primary"></i>Register</a>
                           <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton13">
                             
                              <a link="userregistration" class="modal_form_open dropdown-item toggle-btn-pop" href="javascript:void(0);" data-toggle="modal">Residents</a>


                              <a link="business_registration" class="modal_form_open dropdown-item toggle-btn-pop" href="javascript:void(0);" data-zoneid="">Bus. Create Deals </a>
                             <a link="organization_registration" class="modal_form_open dropdown-item toggle-btn-pop" href="javascript:void(0);">Nonprofit Orgs</a>
                              <a link="employee_registration" class="modal_form_open dropdown-item toggle-btn-pop employee_registration" href="javascript:void(0);">Local Employee</a>
                              <a link="visitor_registration" class="modal_form_open dropdown-item toggle-btn-pop" href="javascript:void(0);">Visitor</a>
                              <a link="sponsor_registration" class="modal_form_open dropdown-item toggle-btn-pop" href="javascript:void(0);">Sponsor</a>
                           </div>
                        </div>
                     </li>
                     <li class="user-login">
                        <div class="dropdown">
                           <a class=" dropdown-toggle btn-link" type="button" id="dropdownMenuButton13" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-sign-in text-primary"></i>Login</a>
                           <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton13">
                              <a title="neighbour_login" class="dropdown-item toggle-btn-pop loginTextChange1" href="javascript:void(0);" data-toggle="modal" data-target="#login-box2" id="neighbors_login" title="neighbour_login">Residents</a>
                              <a title="businesses_login" data-target="#login-box2" class="dropdown-item toggle-btn-pop loginTextChange1" href="javascript:void(0);" data-toggle="modal">Bus.Create Deals</a>
                              <a title="organisations_login" data-target="#login-box2" class="dropdown-item toggle-btn-pop loginTextChange1" href="javascript:void(0);" data-toggle="modal">Nonprofit Orgs</a>
                              <a title="employee_login" data-target="#login-box2" class="dropdown-item toggle-btn-pop loginTextChange1"  data-toggle="modal" href="javascript:void(0);">Local Employee</a>
                              <a title="visitor_login" data-target="#login-box2" class="dropdown-item toggle-btn-pop loginTextChange1 visitor_login tyt"  data-toggle="modal" data-target="#login-box2" id="#login-box" href="javascript:void(0);">Visitor</a>
                           </div>
                        </div>
                     </li>
                     <?php }else{ ?>
                     <li class="user-register fullwidth"> 
                        <a target="_blank" href="<?= $baseloginUrl; ?>/Zonedashboard/zoneinformation" class="btn-link cus-top-pad"><i class="fa fa-edit text-primary "></i> Back To Dashboard</a>
                     </li> &nbsp;
                     <li class="user-register fullwidth"> 
                        <a href="javascript:void(0)" class="btn-link cus-top-pad sign_out" onclick="sign_out();" style=""><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
                     </li>
                     <?php } ?>
                     <div class="video_modal mobile_view_new0">
                        <button type="button" class="btn btn-primary topheaderangle">About</button>
                        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#foodModal">Deals Video</button>

                        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#snap_filter">SNAP<span class="mobile_hide"> Dollars</span></button>
                     </div>
                     
                     </ul>
                     </li>
                  </ul>
            </div>
            <!-- login area code end here -->
         </div>
      </div>
   </div>
</header>