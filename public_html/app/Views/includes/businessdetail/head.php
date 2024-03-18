<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <title>Savings Sites Businesses Search</title>
    <meta name="format-detection" content="telephone=no" />
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" /> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="utf-8" />
    <meta name="google-signin-client_id" content="125789437664-5aj9t1kvfljh8mkpqjm6sf2urit0fv5v.apps.googleusercontent.com">
    <?php clearstatcache(); 
    if($adid!=''){ ?>
        <meta property="og:title" content="<?php echo "By  ".$bnamenew; ?> " />
        <?php 
        // echo "<pre>";print_r($addlist);die;
        // I LIKE instead: Value: $60, Pay Business: $30, Your Favorite Nonprofit fee $15, Save $15!  


            if($addlist){  
                $html =   ' Value: $'.number_format($addlist[0]['buy_price_decrease_by'],2); 
                $html .=  "\r\n";
                $html .=  ' Pay Business:'; 
            if ($addlist[0]['current_price']) {
                $html .=  '$'. number_format($addlist[0]['current_price'],2);
            }else{
                $html .=  "N/A";
            } 
            if($addlist[0]['buy_price_decrease_by'] == ''){
                $addlist[0]['buy_price_decrease_by'] = 0;   
            }
            if($addlist[0]['current_price'] == ''){
                $addlist[0]['current_price'] = 0;   
            }
            if($addlist[0]['publisher_fee'] == ''){
                $addlist[0]['publisher_fee'] = 0;   
            }
             $html .=  ' Your Favorite Nonprofit fee: $'.number_format($addlist[0]['publisher_fee'],2);
            $savings = $addlist[0]['buy_price_decrease_by'] -  $addlist[0]['current_price'] - $addlist[0]['publisher_fee'];   
            $html .= ' Net Savings: $'. number_format($savings,2); 
            if(empty($description)){
                $description=$bnamenew;
            }  
        }else{
            $html = $description;
        }  
        ?>
        <meta property="og:description" content="<?= $html ;?>"/>
        <meta property="og:image" content="<?= $busimage; ?>"/>
        <meta property="og:image:secure_url" content="<?= $busimage; ?>"/>
        
        
        <meta property="og:image:width" content="200" />
        <meta property="og:image:height" content="200" />
        <meta property="og:image:type" content="<?php echo $busimagetype ;?>" />
        <meta property="og:type" content="Website" />
        <meta property="og:url" content=""/>
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="" />
        <meta name="twitter:creator" content="" />
        <meta name="twitter:title" content="<?php echo $bnamenew; ?>" />
        <?php if($description==$bnamenew){$description="By  ".$bnamenew;} ?>
        <meta name="twitter:description" content="<?php echo $description ;?>">
        <meta name="twitter:image" content="<?= $busimage; ?>">
        <meta name="twitter:image:width" content="200px">
        <meta name="twitter:image:height" content="200px">

    <?php }else if($zoneid>0 || $zoneid!=''){ ?>
        <meta property="og:title" content="<?php echo "By  ".$zone_name; ?> " />
        <meta property="og:description" content="Save money without cutting, collecting, organizing, coupons, or being bombarded with emails for offers you don't want and are out of your area."/>
        <meta property="og:image" content="<?php echo base_url(); ?>assets/directory/images/banner/1546547670.png"/>    
        <meta property="og:url" content="" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="" />
        <meta name="twitter:creator" content="" />
        <meta name="twitter:title" content="<?php echo $zone_name?>" />
        <meta name="twitter:description" content="Save money without cutting, collecting, organizing, coupons, or being bombarded with emails for offers you don't want and are out of your area.">
        <meta name="twitter:image" content="<?php echo base_url(); ?>assets/directory/images/banner/1546547670.png">
        <meta name="twitter:image:width" content="200px">
        <meta name="twitter:image:height" content="200px">
        <meta property="linkedin:title" content="<?php echo "By  ".$zone_name; ?> " />
        <meta property="linkedin:description" content="Save money without cutting, collecting, organizing, coupons, or being bombarded with emails for offers you don't want and are out of your area."/>
        <meta property="linkedin:image" content="<?php echo base_url(); ?>assets/directory/images/banner/1546547670.png"/>
    
    <?php }else{ ?>
        <meta property="og:title" content="Savingssites" />
        <meta property="og:description" content="Save money without cutting, collecting, organizing, coupons, or being bombarded with emails for offers you don't want and are out of your area."/>
        <meta property="og:image" content="<?php echo base_url(); ?>assets/directory/images/banner/1546547670.png"/>
        <meta property="og:url" content="" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="" />
        <meta name="twitter:creator" content="" />
        <meta name="twitter:title" content="Savingssites" />
        <meta name="twitter:description" content="Save money without cutting, collecting, organizing, coupons, or being bombarded with emails for offers you don't want and are out of your area.">
        <meta name="twitter:image" content="<?php echo base_url(); ?>assets/directory/images/banner/1546547670.png">
        <meta name="twitter:image:width" content="200px">
        <meta name="twitter:image:height" content="200px">
        <meta property="linkedin:title" content="Savingssites" />
        <meta property="linkedin:description" content="Save money without cutting, collecting, organizing, coupons, or being bombarded with emails for offers you don't want and are out of your area."/>
        <meta property="linkedin:image" content="<?php echo base_url(); ?>assets/directory/images/banner/1546547670.png"/>
        <meta property="abcdef" /> 
    <?php } ?>
    <link href="<?= base_url();?>/assets/css/bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url();?>/assets/businessSearch/css/fonts.css" />
    <link href="<?= base_url();?>/assets/css/menu.min.css" rel="stylesheet" type="text/css" />
    <?php  
     if(@$_COOKIE['business_sstheme'] == 'green'){ ?>   <link rel="stylesheet" class="linkedcss" href="<?= base_url();?>/assets/SavingsCss/theme-green.css?v=<?= microtime(true); ?>"/> <?php }else if(@$_COOKIE['business_sstheme'] == 'brown'){ ?>  <link class="linkedcss" rel="stylesheet" href="<?= base_url();?>/assets/SavingsCss/theme-brown.css?v=<?= microtime(true); ?>"/>  <?php }else if(@$_COOKIE['business_sstheme'] == 'purple'){?> <link  class="linkedcss"  rel="stylesheet" href="<?= base_url();?>/assets/SavingsCss/theme-purple.css?v=<?= microtime(true); ?>"/> <?php  }else if(@$_COOKIE['business_sstheme'] == 'blue'){ ?>   <link class="linkedcss"  rel="stylesheet" href="<?= base_url();?>/assets/SavingsCss/theme-oldGlory.css?v=<?= microtime(true); ?>"/> <?php  }else{ ?> <link rel="stylesheet" class="linkedcss" href="<?= base_url();?>/assets/SavingsCss/theme-oldGlory.css?v=<?= microtime(true); ?>"/> <?php  }
    ?>
    <link rel="stylesheet" href="<?= base_url();?>/assets/SavingsCss/BusinessSearchCommon.css?v=<?= microtime(true); ?>"/>  
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    </head>
        <input type="hidden" name="link_path" value="<?= base_url();?>">
        <input type="hidden" name="base_url" value="<?= base_url();?>">
        <input type="hidden" name="zoneid" value="<?= $zoneid;?>">
        <input type="hidden" name="lowerlimit" value=" ">
        <input type="hidden" name="user_id" value="<?= $userid;?>">
        <input type="hidden" name="user_type" value="<?= isset($user_type['type'])?$user_type['type']:'';?>">
        <input type="hidden" name="ads_view" value="compact">
    <?php if(isset($frompage) && strlen($frompage)>0){ ?>
        <input type="hidden" name="frompage" value="<?= $frompage;?>">
    <?php }else{ ?>
        <input type="hidden" name="frompage" value="">
    <?php } 
    if(isset($rows) && $rows > 0){
        $cartclass = '';
        $cartcount = $rows;
    }else{
        $cartclass = 'hide';
        $cartcount = '';
    }
    ?>
