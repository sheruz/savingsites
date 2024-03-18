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
        <link rel="stylesheet" href="<?= base_url("/assets/css/bootstrap.css"); ?>" />
        <link rel="stylesheet" href="<?= base_url("/assets/css/home.css"); ?>" />
        <link rel="stylesheet" href="<?= base_url("/assets/home/custom/css/home.css"); ?>" />
        <link rel="stylesheet" href="<?= base_url();?>/assets/home/customcss/style_home.css?v=<?= rand(); ?>" id="main-styles-link" />
        <link id="selTheme" href="<?= base_url();?>/assets/css/theme-<?= $theme ?>.css" rel="stylesheet"/> 
        <link rel="stylesheet" href="<?= base_url();?>/assets/SavingsCss/homecommon.css?v=<?= rand();?>" />
        <link rel="stylesheet" href="<?= base_url();?>/assets/SavingsCss/scrap.css?v=<?= rand();?>" />
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" />
        <link rel="stylesheet" href="<?= base_url();?>/assets/css/theme-blue.css?v=<?= rand();?>" />
        <link rel="stylesheet" href="<?= base_url();?>/assets/css/theme-brown.css?v=<?= rand();?>" />
        <link rel="stylesheet" href="<?= base_url();?>/assets/css/theme-green.css?v=<?= rand();?>" />
        <link rel="stylesheet" href="<?= base_url();?>/assets/css/theme-purple.css?v=<?= rand();?>" />
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
        <? 
            if(!empty($displayoffer)){
        ?>
        <input type="hidden" name="displayoffer" id="displayoffer" value="<?= isset($displayoffer[0]['displayoffer'])?$displayoffer[0]['displayoffer']:'';?>"/>
        <? } ?>
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
 

       