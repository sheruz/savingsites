<?=$this->extend("layout/scrapmaster")?>

<?=$this->section("pageTitle")?>
  Savings Sites
<?=$this->endSection()?>
  
<?=$this->section("scrapcontent")?>
<?=$this->include("includes/scrap/modals")?>
<div class="container">
  <br><br><br>
  <div class="row hide">
    <div class="col-sm-3">
      <select class="form-control divset" id="scrapcategory" name="imagecategory">
        <option value>Select Category</option>
        <?php foreach ($catres as $ck => $cv) {
          echo '<option child_type="'.$cv['child_type'].'" value="'.$cv['id'].'">'.$cv['name'].'</option>';
        }?>
      </select> 
    </div>
    <div class="col-sm-3">
      <select class="form-control divset" id="scrapsubcategory" name="imagecategory">
        <option value>Select Sub Category</option>
      </select>
    </div> 
    <div class="col-sm-3">
      <input type="file" class="form-control" id="scrapcatimage" name="scrapcatimage[]" multiple placeholder="Upload Image" required> 
    </div>
    <div class="col-sm-3">
      <button type="button" id="savescrapcategoryimage" class="btn btn-success">Upload</button>
    </div> 
  </div>
  <!-- <br><hr><br> -->
  
  




 <!--  <div class="row">
    <div class="col-md-12">
      <form class="img-view-form" action="<?php //echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" id="insertform">
        <div class="col-md-12">
          
          <br>
          <br>
        </div>
      </form> 
    </div>
  </div> -->
  <div class="row">
    <div class="col-md-12">
      <table  id="scrapimagetable" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Image Id</th>
            <th>Image</th>
            <th>Category Name</th>
            <th>Sub Category Name</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="imagecatsubcatediv">
        </tbody>
      </table> 
    </div>
  </div>
</div>
<?=$this->endSection()?>