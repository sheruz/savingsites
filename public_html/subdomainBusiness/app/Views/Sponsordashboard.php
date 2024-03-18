<?=$this->extend("layout/sponsordashboardmaster")?>
<?=$this->section("pageTitle")?>
  Sponsor Dashboard | Savingssites
<?=$this->endSection()?>
<?=$this->section("sponsorcontent")?>
<input type="hidden" id="loginuser" class="loginuser" value="<?= $uid?>"/>
<input type="hidden" id="amazonurl" class="amazonurl" value="<?= $amazonurl?>"/>
<?php 
  echo $this->include("includes/sponsordashboard/leftsidebar"); 
?> 
<link rel="stylesheet" href= "https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
  <input type="hidden" id="sessionzone" value="<?= $sessionzone; ?>" />
  <input type="hidden" value="<?= $pagesidebar;?>" class="pagesidebar" id="pagesidebar"/>
<?=$this->include("includes/sponsordashboard/".$pagesidebar."")?>
<?=$this->include("includes/modals")?>





<?=$this->endSection()?>