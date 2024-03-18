<?=$this->extend("layout/master")?>

<?=$this->section("pageTitle")?>
  <?= $zone_name; ?> | Savingssites
<?=$this->endSection()?>
  
<?=$this->section("content")?>
<?=$this->include("includes/modals")?>
<input type="hidden" name="usergiftemail" id="usergiftemail" value="<?php echo $usergiftemail;?>">
<input type="hidden" name="giftuserexists" id="giftuserexists" value="<?php echo $giftuserexists;?>">
<input type="hidden" name="seo_zone" id="seo_zone" value="<?php echo $seo_zone_name;?>">
<input type="hidden" name="refer_code" id="refer_code" value="<?php echo $refer_code;?>">
<input type="hidden" name="homesubdomain" id="homesubdomain" value="<?php echo $zonebusinessname;?>">
<input type="hidden" value="<?= $pagesidebar;?>" class="pagesidebar" id="pagesidebar"/>
<?=$this->include("includes/mslider")?>
<?=$this->include("includes/offer_header")?>



<div class="outerofferdiv container"></div>


<?=$this->endSection()?>