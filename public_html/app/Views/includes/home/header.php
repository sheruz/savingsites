<?php 
// session_start(); 
    $aid = isset($aid)?isset($aid):'';
    $adid = isset($adid)?isset($adid):'';
    $session_session_type = isset($session_session_type)?isset($session_session_type):'';
    $page = isset($page)?isset($page):'';
    $currentpage = isset($currentpage)?isset($currentpage):'';
    $session_session_type_id = isset($session_session_type_id)?isset($session_session_type_id):'';
    $user_type['type'] = '';
    $businessUser = isset($businessUser)?isset($businessUser):'';
    $user_id = isset($user_id) ? $user_id:'';
    $zone_logo = isset($zone_logo)?$zone_logo:'';
?>
<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
    <head>
        <title><?= $this->renderSection("pageTitle") ?></title>
        <meta name="format-detection" content="telephone=no" />
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta charset="utf-8" />
        <meta name="google-signin-client_id" content="125789437664-5aj9t1kvfljh8mkpqjm6sf2urit0fv5v.apps.googleusercontent.com">
        <?php //clearstatcache();   ?>
        <?php if($aid>0 || $adid!=''){    ?>
            <meta property="og:title" content="<?php echo "By  ".$bsname; ?> " />
        <?php if(@$addlist){  $html =   '  Redemption Value = $'.number_format($addlist[0]['buy_price_decrease_by'],2); $html .=  "\r\n"; ?>
        <?php $html .=  '  ORG Donation Fee = $'.number_format($addlist[0]['publisher_fee'],2); ?>
    <?php $html .=  '  Pay Bus. Deal Price'; 
        if ($addlist[0]['consolation_price']) {
            $html .=  '$'. number_format($addlist[0]['consolation_price'],2);
        }else{
            $html .=  "N/A";
        }  
        $savings = @$addlist[0]['buy_price_decrease_by'] -  @$addlist[0]['consolation_price'] - @$addlist[0]['publisher_fee'];   
        $html .= ' Net Savings: $'. number_format($savings,2); 
        if(empty($description)){$description=$business_name;}  
        }else{
            $html = $description;
        }  
    ?>
        <meta property="og:description" content="<?= $html ;?>"/>
        <?php   foreach($meta_business_image as $image){  ?>
            <meta property="og:image" content="<?= $image; ?>"/>
            <meta property="og:image:secure_url" content="<?= $image; ?>"/>
        <?php } ?>
        <meta property="og:image" content="<?= base_url()."/assets/home/directory/images/ss-share-logo.jpg";?>"/>
        <meta property="og:image:width" content="200" />
        <meta property="og:image:height" content="200" />
        <meta property="og:image:type" content="<?= $meta_business_image_type ;?>" />
        <meta property="og:type" content="Website" />
        <meta property="og:url" content=""/>
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="" />
        <meta name="twitter:creator" content="" />
        <meta name="twitter:title" content="<?= $business_name; ?>" />
        <?php
            if($description==$business_name){$description="By  ".$bsname;} 
        ?>
        <meta name="twitter:description" content="<?= $description ;?>">
        <?php foreach($meta_business_image as $image){ ?>
            <meta name="twitter:image" content="<?= $image;?>">
        <?php } ?>
        <meta name="twitter:image:width" content="200px">
        <meta name="twitter:image:height" content="200px">
    <?php }   else if($zoneid>0 || $zoneid!=''){ ?>
        <meta property="og:title" content="<?= "By  ".$zone_name; ?> " />
        <meta property="og:description" content="Save money without cutting, collecting, organizing, coupons, or being bombarded with emails for offers you don't want and are out of your area."/>
        <meta property="og:image" content="<?= base_url(); ?>/assets/home/directory/images/1546547670.png"/>    
        <meta property="og:url" content="" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="" />
        <meta name="twitter:creator" content="" />
        <meta name="twitter:title" content="<?= $zone_name?>" />
        <meta name="twitter:description" content="Save money without cutting, collecting, organizing, coupons, or being bombarded with emails for offers you don't want and are out of your area.">
        <meta name="twitter:image" content="<?= base_url(); ?>/assets/home/directory/images/1546547670.png">
        <meta name="twitter:image:width" content="200px">
        <meta name="twitter:image:height" content="200px">  
        <meta property="linkedin:title" content="<?= "By  ".$zone_name; ?> " />
        <meta property="linkedin:description" content="Save money without cutting, collecting, organizing, coupons, or being bombarded with emails for offers you don't want and are out of your area."/>
        <meta property="linkedin:image" content="<?= base_url(); ?>/assets/home/directory/images/1546547670.png"/>
    <?php }else{ ?>
        <meta property="og:title" content="Savingssites" />
        <meta property="og:description" content="Save money without cutting, collecting, organizing, coupons, or being bombarded with emails for offers you don't want and are out of your area."/>
        <meta property="og:image" content="<?= base_url(); ?>/assets/home/directory/images/1546547670.png"/>
        <meta property="og:url" content="" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="" />
        <meta name="twitter:creator" content="" />
        <meta name="twitter:title" content="Savingssites" />
        <meta name="twitter:description" content="Save money without cutting, collecting, organizing, coupons, or being bombarded with emails for offers you don't want and are out of your area.">
        <meta name="twitter:image" content="<?= base_url(); ?>/assets/home/directory/images/1546547670.png">
        <meta name="twitter:image:width" content="200px">
        <meta name="twitter:image:height" content="200px">
        <meta property="linkedin:title" content="Savingssites" />
        <meta property="linkedin:description" content="Save money without cutting, collecting, organizing, coupons, or being bombarded with emails for offers you don't want and are out of your area."/>
        <meta property="linkedin:image" content="<?= base_url(); ?>/assets/home/directory/images/1546547670.png"/>
        <meta property="abcdef" /> 
    <?php } ?>
    <link rel="stylesheet" href="<?= base_url("/assets/css/bootstrap.css"); ?>" />
    <link rel="stylesheet" href="<?= base_url("/assets/css/home.css"); ?>" />
    <link rel="stylesheet" href="<?= base_url("/assets/home/customcss/home.css"); ?>" />
    <link rel="icon" href="<?= base_url();?>/assets/home/directory/images/favicon-home.ico" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins:400,500%7CRaleway:300,o400,400i,500,600,700%7CRoboto:400,100,300,500,700,900|Montserrat:400,700|Oswald:300,400,700" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url();?>/assets/css/fonts.css?v=<?= rand(); ?>" />
    <link rel="stylesheet" href="<?= base_url();?>/assets/css/rd-navbar.css" />
    <link href='<?= base_url();?>/assets/css/fullcalendar.min.css' rel='stylesheet' /> 
    <link  href="<?= base_url();?>/assets/css/paginate.css" >   
    <link rel="stylesheet" href="<?= base_url();?>/assets/home/customcss/style_home.css?v=<?= rand(); ?>" id="main-styles-link" />
    <link rel="stylesheet" href="<?= base_url();?>/assets/css/layerslider.css?v=<?= microtime(true); ?>" />
    <link rel="stylesheet" href="<?= base_url();?>/assets/css/skin.css?v=<?= microtime(true); ?>" />
    <link id="selTheme" href="<?= base_url();?>/assets/css/theme-<?= $theme ?>.css" rel="stylesheet"/> 
    <link rel="stylesheet" href="<?= base_url();?>/assets/css/toastr.css?v=<?= microtime(true); ?>" />
    <link href="<?=base_url('EventCalendarD/core/framework/libs/pj/css/pj.bootstrap.min.css').'?time='.time(); ?>" type="text/css" rel="stylesheet" />  
    <link href="<?=base_url('EventCalendarD/index.php?controller=pjFront&action=pjActionLoadCss&theme=1')?>" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css" integrity="sha512-OTcub78R3msOCtY3Tc6FzeDJ8N9qvQn1Ph49ou13xgA9VsH9+LRxoFU6EqLhW4+PKRfU+/HReXmSZXHEkpYoOA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= base_url();?>/assets/stylesheets/validationEngine.jquery.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="<?= base_url();?>/assets/SavingsCss/homecommon.css?v=<?= rand();?>" />
  <!--   <link rel="stylesheet" href="<?= base_url();?>/assets/css/theme-blue.css?v=<?= rand();?>" />
    <link rel="stylesheet" href="<?= base_url();?>/assets/css/theme-brown.css?v=<?= rand();?>" /> -->
    <link rel="stylesheet" href="<?= base_url();?>/assets/css/theme-green.css?v=<?= rand();?>" />
    <!-- <link rel="stylesheet" href="<?= base_url();?>/assets/css/theme-purple.css?v=<?= rand();?>" /> -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script src="https://kit.fontawesome.com/2b5988e40c.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <input type="hidden" name="link_path" value="<?= base_url();?>">
        <input type="hidden" name="base_url" value="<?=  base_url();?>">
        <input type="hidden" name="zoneid" id="get_zoneid" value="<?= $zone_id;?>">
        <input type="hidden" name="lowerlimit" value=" ">
        <input type="hidden" name="user_id" id="get_user_id" value="<?= $user_id;?>">
        <input type="hidden" name="adid" value="<?= $adid;?>">
        <?php 
        if($session_session_type == '4'){
            $member_type= 3;
        } else if($session_session_type =='resident_user'){
            $member_type= 1;
        }else if($session_session_type =='business'){
            $member_type= 2;
        }
        ?>
        <input type="hidden" name="member_type" id="member_type" value="<?php //echo $member_type;?>">
        <input type="hidden" name="type_id" id="type_id" value="<?php //echo $session_session_type_id;?>">
        <input type="hidden" name="from_where" value="<?php //echo $from_where;?>">
        <input type="hidden" name="first_name" id="first_name" value="<?php //echo $first_name; ?>">
        <input type="hidden" name="last_name" id="last_name" value="<?php //echo $last_name; ?>">
        <input type="hidden" name="user_email" id="user_email" value="<?php //echo $user_email; ?>">
        <input type="hidden" name="user_name" id="user_name" value="<?php //echo $user_name; ?>">
        <input type="hidden" name="zone_id" id="zone_id" value="<?=$zone_id?>"/>
        <input type="hidden" name="user_id" id="user_id" value="<?=$user_id?>"/>
        <input type="hidden" name="count_banner" id="count_banner" value="<?//=$count_banner?>"/>
        <input type="hidden" name="barter_button" id="barter_button" value="<?//=$barter_button?>"/>
        <input type="hidden" name="job_button" id="job_button" value="<?//=$job_button?>"/>
        <input type="hidden" id="zone_setting_offers" name="zone_setting_offers" value="<?//=$zone_pref_setting[0]['auto_approve_offers_announcements']?>"/>
        <input type="hidden" id="auto_approve_banner" name="auto_approve_banner" value="<?//=$zone_pref_setting[0]['auto_approve_banner']?>"/>
        <input type="hidden" id="baner_css_value" value="<?//=$css_value?>"/>
        <?php 
            if(!empty($displayoffer)){
        ?>
        <input type="hidden" name="displayoffer" id="displayoffer" value="<?=$displayoffer[0]['displayoffer']?>"/>
        <?php } ?>
        <input type="hidden" name="current_location" id="current_location" value=""/>
        <input type="hidden" text="session_session_normal_user_in_zone" id="session_session_normal_user_in_zone" value="<?//=$session_session_normal_user_in_zone?>"/>
        <input type="hidden" text="session_session_normal_user_type" id="session_session_normal_user_type" value="<?//=$session_session_normal_user_type?>"/>
        <input type="hidden" text="session_session_type" id="session_session_type" value="<?//=$session_session_type ?>"/>
        <input type="hidden" name="get_adid" id="get_adid" value="<?//=$get_adid?>"/>
        <input type="hidden" name="link_path" id="link_path" value="<?= base_url();?>"/>
        <input type="hidden" name="base_url" id="base_url" value="<?=base_url()?>"/>


       
<?php  
    if(@$_GET['zone']){
        $url = site_url().'zone/'.$_GET['zone'];
        header('Location: ' .$url);
    }
    $base_url =   base_url();
?>


<div class="page">
    <?= $this->include("includes/home/".$header.""); ?>
   
    <form method="POST" id="pbg_submit" action="https://www.mover.deals/index.php?zoneid=<?php echo $zoneid; ?>/<?php echo $session_session_type_id; ?>/">
        <input type="hidden" name="zoneid" id="zoneid" value="<?php echo $zoneid; ?>" />
        <input type="hidden" name="businessid" id="businessid" value="<?php echo $session_session_type_id; ?>" />
        <input type="hidden" name="businessownerid" id="businessownerid" value="<?php echo $user_id; ?>" />
        <input type="hidden" name="group_id" id="group_id" value="<?php //echo $user_type['type']; ?>" />
        <input type="hidden" name="username" id="username" value="<?php //echo $businessUser; ?>" />
    <?php $pbglogin = "business_owner!~!".$session_session_type_id."!~!".$user_type['type']."!~!".$user_id."!~!".$businessUser.""; ?>
        <input type="hidden" name="pbgLogin" id="pbgLogin" value="<?php echo $pbglogin; ?>" />
    </form>
    <?php if (isset($_GET['popup']) && $_GET['popup'] == "savinglinks") {?>
        <script type="text/javascript">
            setTimeout(function(){ $('#myModal').modal('show'); }, 3000);
        </script>
    <?php  } ?>
 

       