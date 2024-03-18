<? include("head.php");?>
<header class="desktop_view businessviewheader">
   <div class="container">
      <div class="row align-middle">
         <div class="col-md-3">
            <div class="main_logo">
               <img class="<?= $hidefooter; ?>" src="<?= base_url();?>/assets/SavingsUpload/images/new-savingssites3.png">
               <?php if($zone_logo == ''){ ?>
                  <div class="municipality-logo zone_chi">
                     <a class="brand homelink" id="<?=$zoneid?>" href="<?php echo  base_url()  ?>"><?=$zone_name?></a>
                  </div> 
               <?php } else{  ?>
                  <a class="brand homelink" id="<?=$zoneid?>" href="<?php echo base_url()  ?>">
                  <div class="municipality-logo zone_chi logo" style="background:url('<?=base_url()?>/assets/SavingsUpload/Business/<?=$business_id?>/<?=$zone_logo?>');    width: 250px;max-width: 250px;height: 100px;overflow: hidden;background-size: contain;background-repeat: no-repeat;background-position: center;">
                  </div>
                   </a>
               <?php } ?>
               <li role='navigation ' id="checkk" class="dropdown-submenu new com_li hide_on_desktop">
                  <div id="menuToggle-mobile" >
                     <input type="checkbox" /><span></span><span></span><span></span>
                  </div>
                  <ul class="dropdown-menu_list1" id="menu-bar-mobile" >
                     <li class="user-register fullwidth">
                        <a  href="#" class="btn-link cus-top-pad"><i class="fa fa-home"></i> $$ Home</a>
                     </li>
                     <?php if($user_id  == ''){ ?>
                     <li class="user-register">
                        <div class="dropdown">
                           <a class="btn-link dropdown-toggle cus-top-pad" type="button" id="dropdownMenuButton13" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-edit text-primary"></i>Register</a>
                           <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton13">
                              <a link="userregistration" class="modal_form_open dropdown-item toggle-btn-pop" href="javascript:void(0);" data-toggle="modal" data-target="#emailnoticesignupform02">Residents</a>
                              <a link="business_registration" class="modal_form_open dropdown-item toggle-btn-pop" href="javascript:void(0);" data-zoneid="">Bus. Create Deals </a>
                              <a link="organization_registration" class="modal_form_open dropdown-item toggle-btn-pop" href="javascript:void(0);">Nonprofit Orgs</a>
                              <a link="employee_registration" class="modal_form_open dropdown-item toggle-btn-pop employee_registration" href="javascript:void(0);">Local Employee</a>
                              <a link="visitor_registration" class="modal_form_open dropdown-item toggle-btn-pop" href="javascript:void(0);" data-toggle="modal" data-target="#visitor_registration02">Visitor</a>
                           </div>
                        </div>
                     </li>
                     <li class="user-login">
                        <div class="dropdown">
                           <a class=" dropdown-toggle btn-link" type="button" id="dropdownMenuButton13" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-sign-in text-primary"></i>Login</a>
                           <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton13">
                              <a title="neighbour_login" class="loginTextChange1 dropdown-item toggle-btn-pop" href="javascript:void(0);" data-toggle="modal" data-target="#login-box" id="neighbors_login">Residents</a>
                              <a title="businesses_login" class="loginTextChange1 dropdown-item toggle-btn-pop" href="javascript:void(0);" data-toggle="modal"> Bus. Create Deals </a>
                              <a title="organisations_login" class="loginTextChange1 dropdown-item toggle-btn-pop" href="javascript:void(0);" data-toggle="modal">Nonprofit Orgs</a>
                              <a title="employee_login" class="loginTextChange1 dropdown-item toggle-btn-pop employee_login" data-toggle="modal" href="javascript:void(0);">Local Employee</a>
                              <a title="visitor_login" class="loginTextChange1 dropdown-item toggle-btn-pop visitor_login" data-toggle="modal" data-target="#login-box" id="#login-box" href="javascript:void(0);">Visitor</a>
                           </div>
                        </div>
                     </li>
                     <?php }else{?>
                     <li class="sign_out_directory"><i class="fa fa-edit text-primary "></i> 
                        <a href="<?=base_url() ?>/Zonedashboard/zonedetail/<?= $zoneid; ?>" class="text-uppercase">Back To Dashboard</a>
                     </li> &nbsp;
                     <li class="sign_out"> 
                        <a href="javascript:void(0)" class="sign_out" onclick="sign_out();" style=""><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
                     </li>
                     <?php } ?>
                     
                     
                     <li class="rd-nav-item themeswitcher">
                        <div class="dropdowns" style="">
                           <button class="btn btn-default dropdown-toggle btn-link icon-theme" type="button" id="themeswitcher" data-version="<?php echo microtime(true); ?>" data-theme="<?php echo $business_theme ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style=""><?php echo $business_page ?></button>
                           <div class="dropdown-menu dropdown-menu-right" aria-labelledby="themeswitcher" x-placement="bottom-end">
                              <a class="dropdown-item purple changetheme" href="javascript:void(0);" data-theme="purple">Fun Purple</a>
                              <a class="dropdown-item brown changetheme" href="javascript:void(0);" data-theme="brown">Cozy Brown</a>
                              <a class="dropdown-item green changetheme" href="javascript:void(0);" data-theme="green">Save Green</a>
                              <a class="dropdown-item blue changetheme" href="javascript:void(0);" data-theme="oldGlory">Old Glory</a>
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
                     <div class="logo">
                        <ul class="logo-row first-row">
                           <li>
                              <img src="/assets/directory/images/logos/new-savingssites.png"/>
                           </li>

                            <li>
                              <img src="/assets/images/food_blck.png"/>
                           </li>
                           <div class="dropdown">
                              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton13"></div>
                           </div>
                     </div>
                     </ul>
                     </li>
            </div>
         </div>
         <div class="col-md-6">
           <div class="center_text_no_profit">
               <h2><?php
                  if(strlen($busdata[0]['aboutus']) > 150){
                     echo substr($busdata[0]['aboutus'], 0, 150).'....<br>';
                  }else{
                     echo @$busdata[0]['aboutus']; 
                  }?>
                  <!-- <br><span desc="<?//= $busdata[0]['history'];?>"><u id="historybusinessdetail">Our History</u></span> -->
               </h2>
            </div>
         </div>
         <div class="col-md-3">
           <div class="user-sec login_cart_icon">
            <?php if (empty($user_id)) {?>
                             <ul class="list-inline user-menu pull-right">
                  <li class="user-register">
                     <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle desktopsignup" type="button" id="dropdownRegister" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           <i class="fa fa-edit text-primary"></i>Sign Up</button>
                           <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownRegister">
                              <a link="userregistration" class="modal_form_open dropdown-item toggle-btn-pop" href="javascript:void(0);" data-toggle="modal" data-target="#emailnoticesignupform02">Residents</a>
                              <a link="business_registration" class="modal_form_open dropdown-item toggle-btn-pop" href="javascript:void(0);" data-zoneid="">Bus. Create Deals </a>
                              <a link="organization_registration" class="modal_form_open dropdown-item toggle-btn-pop" href="javascript:void(0);">Nonprofit Orgs</a>
                              <a link="employee_registration" class="modal_form_open dropdown-item toggle-btn-pop employee_registration" href="javascript:void(0);">Local Employee</a>
                              <a link="visitor_registration" class="modal_form_open dropdown-item toggle-btn-pop" href="javascript:void(0);" data-toggle="modal" data-target="#visitor_registration02">Visitor</a>
                           </div>
                        </div>
                     </li>
                     <li class="user-login">
                        <div class="dropdown">
                           <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton13" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="fa fa-sign-in text-primary"></i>  Login
                           </button>
                           <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton13">
                               <a title="neighbour_login" class="loginTextChange1 dropdown-item toggle-btn-pop" href="javascript:void(0);" data-toggle="modal" data-target="#login-box2" id="neighbors_login">Residents</a>
                                <a title="businesses_login" class="loginTextChange1 dropdown-item toggle-btn-pop" href="javascript:void(0);" data-toggle="modal" data-target="#login-box2"> Bus. Create Deals </a>
                                <a title="organisations_login" class="loginTextChange1 dropdown-item toggle-btn-pop" href="javascript:void(0);" data-toggle="modal">Nonprofit Orgs</a>
                                <a title="employee_login" class="loginTextChange1 dropdown-item toggle-btn-pop employee_login" data-toggle="modal" href="javascript:void(0);">Local Employee</a>
                                <a title="visitor_login" class="loginTextChange1 dropdown-item toggle-btn-pop visitor_login" data-toggle="modal" data-target="#login-box2" id="#login-box" href="javascript:void(0);">Visitor</a>
                           </div>
                        </div>
                     </li> 
                  </ul>
            <?php } ?>
            <?php if (!empty($user_id)) {
                     $fullnamedisplay = (strlen($firstName.' '.$lastName) > 16) ? $firstName : $firstName.' '.$lastName ;
                     echo '<span class="logged-in">Hi '.$fullnamedisplay.'! <a href="javascript:void(0);" class="sign_out" onclick="sign_out();">Logout</a></span>' ;
                  }
            ?>
            </div>
            <div><span desc="<?= $busdata[0]['hours_of_operation']; ?>" style="font-size: 25px;font-weight: bold;text-align: center;font-family: 'general_sansbold';color: #01519a;"><u id="hoursofopertionbusiness">Hours Of Operation<u></span></div>
            <div class="login_cart_icon">
            <?php  if(empty($newuserid)){ ?>
 <!--               <ul class="list-inline user-menu pull-right">
                  <li class="user-register">
                     <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownRegister" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           <i class="fa fa-edit text-primary"></i>Sign Up</button>
                           <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownRegister">
                              <a link="userregistration" class="modal_form_open dropdown-item toggle-btn-pop" href="javascript:void(0);" data-toggle="modal" data-target="#emailnoticesignupform02">Residents</a>
                              <a link="business_registration" class="modal_form_open dropdown-item toggle-btn-pop" href="javascript:void(0);" data-zoneid="">Bus. Create Deals </a>
                              <a link="organization_registration" class="modal_form_open dropdown-item toggle-btn-pop" href="javascript:void(0);">Nonprofit Orgs</a>
                              <a link="employee_registration" class="modal_form_open dropdown-item toggle-btn-pop employee_registration" href="javascript:void(0);">Local Employee</a>
                              <a link="visitor_registration" class="modal_form_open dropdown-item toggle-btn-pop" href="javascript:void(0);" data-toggle="modal" data-target="#visitor_registration02">Visitor</a>
                           </div>
                        </div>
                     </li>
                     <li class="user-login">
                        <div class="dropdown">
                           <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton13" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="fa fa-sign-in text-primary"></i>  Login
                           </button>
                           <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton13">
                              <a title="neighbour_login" class="loginTextChange1 dropdown-item toggle-btn-pop" href="javascript:void(0);" data-toggle="modal" data-target="#login-box" id="neighbors_login">Residents</a>
                              <a title="businesses_login" class="loginTextChange1 dropdown-item toggle-btn-pop" href="javascript:void(0);" data-toggle="modal"> Bus. Create Deals </a>
                              <a title="organisations_login" class="loginTextChange1 dropdown-item toggle-btn-pop" href="javascript:void(0);" data-toggle="modal">Nonprofit Orgs</a>
                              <a title="employee_login" class="loginTextChange1 dropdown-item toggle-btn-pop employee_login" data-toggle="modal" href="javascript:void(0);">Local Employee</a>
                              <a title="visitor_login" class="loginTextChange1 dropdown-item toggle-btn-pop visitor_login" data-toggle="modal" data-target="#login-box" id="#login-box" href="javascript:void(0);">Visitor</a>
                           </div>
                        </div>
                     </li> 
                  </ul> -->
               <?php } else {   ?>
                  <?php   if($session_session_normal_user_type=='resident_user'){ ?>
                  <ul class="list-inline user-menu pull-right">
                     <li class="erwerwer"><a href="javascript:void(0);"  class="text-uppercase" >
                  <?php $fullnamedisplay = (strlen($firstName.' '.$lastName) > 16) ? $firstName : $firstName.' '.$lastName ;
                     echo 'Welcome Back '.$fullnamedisplay.'!' ;
                  ?>
                        </a>
                     </li>
                     <li class="sign_out_directorys">
                        <i class="fa fa-user" aria-hidden="true"></i> <b>My Account</b></a>
                        <a href="javascript:void(0)" class="sign_out" style=""><b>Logout</b></a>
                     </li>
                     <div class="resident_user_logout" style="display:none">
                     </div>
                  </ul>
               <?php } else  if($session_session_normal_user_type==''){ ?> 
                  <ul class="list-inline user-menu pull-right text-left">
                     <li class="sign_out_directory"><i class="fa material-icons-dashboard text-primary "></i> <a href="javascript:void(0);" class="text-uppercase">Dashboard</a></li>
                     <li class="sign_out"><i class="fa fa-edit text-primary "></i> <a href="javascript:void(0);" onClick="sign_out();" class="text-uppercase">Logout</a></li>
                  </ul>
               <?php } }?>
            </div>
            <!-- login area code end here -->
         </div>
      </div>
   </div>
</header>