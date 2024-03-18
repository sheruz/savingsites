<?=$this->extend("layout/zonedashboardmaster")?>
<?=$this->section("pageTitle")?>
  Business Dashboard | Savingssites
<?=$this->endSection()?>
<?=$this->section("zonedashboardcontent")?>
<input type="hidden"  id="approverejectorderid" value=""/>
<?=$this->include("includes/modals")?>
<?php 
  if($subuser != ''){
    echo $this->include("includes/businessdashboard/leftsidebarsubuser");
  }else{
    echo $this->include("includes/businessdashboard/leftsidebar"); 
  }

?>
  <link rel="stylesheet" href= "https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css"/>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
  <input type="hidden" id="bidstart" class="bidstart" value="<?= $bid; ?>" />
  <input type="hidden" value="<?= $pagesidebar;?>" class="pagesidebar" id="pagesidebar"/>
  <input type="hidden" value="<?= $businessid;?>" class="businessid" id="businessid"/>
  <input type="hidden" value="<?= $uid;?>" class="businessuser" id="businessuser"/>
  <input type="hidden" value="<?= $editsnap;?>" class="buseditsnap" id="buseditsnap"/>
  <?php if($pagesidebar != 'businessbidrank'){ ?>
  <div class="bidnowbox">
    <div class="row">
      <div class="col-lg-2"></div>
      <div class="col-lg-8">
        <p>Bid Now!  Secure your deal position above other businesses on the Deals page. 
         <a href="javascript:void(0)" class="sidemenu" id="businessbidrank" type="businessdashboard" page="businessbidrank">Learn More</a>
        </p>
      </div>
      <div class="col-lg-2">
        <img src="/assets/images/modalimg.png">
      </div>
    </div>
    <button type="button" class="close closebidbutton" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
  </div>
  <?php } ?>

<?=$this->include("includes/businessdashboard/".$pagesidebar."")?>

<div id="orderapprovaldiv"></div>
<?=$this->endSection()?>