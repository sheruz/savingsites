<?=$this->extend("layout/scrapmaster")?>

<?=$this->section("pageTitle")?>
  Savings Sites
<?=$this->endSection()?>
  
<?=$this->section("scrapcontent")?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h1 style="text-align: center;margin-bottom: 0;margin-top: 46px;padding-bottom: 40px;">Upload To AWS</h1>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <form class="img-view-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" id="insertform">
        <div class="col-md-12">
          <button type="button" id="saveawsImage" class="btn btn-success">Upload</button>
        </div>
      </form> 
    </div>
  </div>

</div>
<?=$this->endSection()?>