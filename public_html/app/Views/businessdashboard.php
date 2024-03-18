<?=$this->extend("layout/zonedashboardmaster")?>
<?=$this->section("pageTitle")?>
  Local Advertising | $avings $ites
<?=$this->endSection()?>
<?=$this->section("zonedashboardcontent")?>
<input type="hidden"  id="approverejectorderid" value=""/>
<?=$this->include("includes/businessdashboard/leftsidebar")?>
  <link rel="stylesheet" href= "https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
  <input type="hidden" id="bidstart" class="bidstart" value="<?= $bid; ?>" />
<?=$this->include("includes/businessdashboard/".$pagesidebar."")?>
<?=$this->include("includes/modals")?>
<div id="orderapprovaldiv"></div>
<?=$this->endSection()?>