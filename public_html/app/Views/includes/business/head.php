<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <title>Savings Sites Businesses Search</title>
    <meta name="format-detection" content="telephone=no" />
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" /> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="utf-8" />

    <link href="<?= base_url();?>/assets/css/bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url();?>/assets/businessSearch/css/fonts.css" />
    <link href="<?= base_url();?>/assets/css/menu.min.css" rel="stylesheet" type="text/css" />
 

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
    <link href="//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.plyr.io/3.6.2/plyr.css">
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
