<?=$this->extend("layout/scrapmaster")?>

<?=$this->section("pageTitle")?>
  Savings Sites
<?=$this->endSection()?>
  
<?=$this->section("scrapcontent")?>
<?=$this->include("includes/scrap/modals")?>
<div class="container">
  <div class="row">
    <div class="col-md-6">
      <h1 style="text-align: center;margin-bottom: 0;margin-top: 46px;padding-bottom: 40px;">Images</h1>
    </div>
    <div class="col-md-6">
      <h1 style="text-align: center;margin-bottom: 0;margin-top: 46px;padding-bottom: 40px;font-size: 18px;"><a href="/scrap/imagecategory" target="_blank">Add/Edit Category</a></h1>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <form class="img-view-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" id="insertform">
        <div class="col-md-12">
          <select class="form-control divset" id="inscat" name="imagecategory">
            <option value>Select Image Category</option>
            <?php foreach ($catres as $ck => $cv){
              echo '<option value="'.$cv['id'].'">'.$cv['foodCategoryName'].'</option>';
            }?>
          </select>
          <br>
          <input type="file" class="form-control divset" id="insimage" name="image[]" multiple placeholder="Upload Image" required><button type="button" id="saveImage" class="btn btn-success">Upload</button>
        </div>
      </form> 
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <table  id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Image Id</th>
            <th>Image</th>
            <th>Category Name</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="imagediv">
        </tbody>
      </table> 
    </div>
  </div>
</div>
<?=$this->endSection()?>