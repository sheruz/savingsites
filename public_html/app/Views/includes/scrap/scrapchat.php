<?=$this->extend("layout/scrapmaster")?>

<?=$this->section("pageTitle")?>
  Savings Sites
<?=$this->endSection()?>
  
<?=$this->section("scrapcontent")?>
<?=$this->include("includes/scrap/modals")?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h1 style="font-size:45px;text-align: center;margin-bottom: 0;margin-top: 46px;padding-bottom: 40px;">Chat Legal and Commercial Matter</h1>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <textarea class="form-control" style="height: 250px !important;" id="responsedata"></textarea><br>
      <input type="text" id="searchchat" class="form-control" placeholder="Type keyword for Search">
    </div>
  </div>
</div>
<?=$this->endSection()?>