<?=$this->extend("layout/zonedashboardmaster")?>
<?=$this->section("pageTitle")?>
  Local Advertising | $avings $ites
<?=$this->endSection()?>
<?=$this->section("zonedashboardcontent")?>
<input type="hidden" id="loginuser" class="loginuser" value="<?= $uid?>"/>
<?=$this->include("includes/zonedashboard/leftsidebar");?>  
<link rel="stylesheet" href= "https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
<?=$this->include("includes/zonedashboard/".$pagesidebar."")?>
<?=$this->include("includes/modals")?>
<?=$this->endSection()?>