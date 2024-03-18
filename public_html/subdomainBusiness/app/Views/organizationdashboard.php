<?=$this->extend("layout/zonedashboardmaster")?>
<?=$this->section("pageTitle")?>
  Business Dashboard | Savingssites
<?=$this->endSection()?>
<?=$this->section("zonedashboardcontent")?>
<?=$this->include("includes/organizationdashboard/leftsidebar")?>
  <link rel="stylesheet" href= "https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
  <input type="hidden" value="<?= $pagesidebar;?>" class="pagesidebar" id="pagesidebar"/>
<?=$this->include("includes/organizationdashboard/".$pagesidebar."")?>
<?=$this->include("includes/modals")?>
<?=$this->endSection()?>