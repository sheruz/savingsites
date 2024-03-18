<?=$this->extend("layout/scrapmaster")?>

<?=$this->section("pageTitle")?>
  Savings Sites
<?=$this->endSection()?>
  
<?=$this->section("scrapcontent")?>
<?=$this->include("includes/scrap/modals")?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h1 style="text-align: center;margin-bottom: 0;padding-bottom: 40px;font-size: 55px;">Food Macro CSV</h1>
    </div>
  </div>
    <form class="img-view-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" id="insertform">
  <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-3">
            <label>Zip Code</label>
          </div>
          <div class="col-md-9">
            <input type="file" class="form-control divset" id="ziptxt" name="image" multiple placeholder="Upload Image" required>
          </div>
        </div><br>
      </div>
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-3">
            <label>Fresh CSV File</label>
          </div>
          <div class="col-md-9">
            <input type="file" class="form-control divset" id="freshcsv" name="image" multiple placeholder="Upload Image" required>
          </div>
        </div><br>
      </div>
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-3">
            <label>YP CSV File</label>
          </div>
          <div class="col-md-9">
            <input type="file" class="form-control divset" id="ypcsv" name="image" multiple placeholder="Upload Image" required>
          </div>
        </div><br>
      </div>
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-3">
            <label>Food Database CSV File</label>
          </div>
          <div class="col-md-9">
            <input type="file" class="form-control divset" id="dbcsv" name="image" multiple placeholder="Upload Image" required>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-2">
            <button style="margin:auto;margin-top:20px;" type="button" id="savemacrofoodcsv" class="btn btn-success">Gen CSV</button>
          </div>
          <div class="col-md-2">
            <button id="macrocsvfood" class="btn btn-success hide" style="margin:auto;margin-top:20px;color: #fff;" type="button"><a style="color: #fff;" href="/setdatatogencsvfood?date=<?= date('d-m-Y'); ?>"/>Download CSV</a></button>
          </div>
          <div class="col-md-3"></div>
        </div>
      </div>
  </div>
    </form> 
</div>
<?=$this->endSection()?>