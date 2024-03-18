<?=$this->extend("layout/scrapmaster")?>

<?=$this->section("pageTitle")?>
  Savings Sites
<?=$this->endSection()?>
  
<?=$this->section("scrapcontent")?>
<?=$this->include("includes/scrap/modals")?>
<div class="container">
  <form action="" method="post">
    <div class="mb-3 mt-3">
      <input type="text" class="form-control username" placeholder="Enter Username">
    </div>
    <div class="mb-3 mt-3">
      <input type="text" class="form-control firstname" placeholder="Enter Firstname">
    </div>
    <div class="mb-3 mt-3">
      <input type="text" class="form-control lastname" placeholder="Enter Lastname">
    </div>
    <div class="mb-3 mt-3">
      <input type="phone" class="form-control phone" placeholder="Enter phone" name="phone">
    </div>
    <div class="mb-3 mt-3">
      <input type="email" class="form-control email" placeholder="Enter email" name="email">
    </div>
    <div class="mb-3 mt-3">
      <input type="text" class="form-control city" placeholder="Enter City" name="city">
    </div>
    <div class="mb-3 mt-3">
      <input type="text" class="form-control address" placeholder="Enter Address" name="Address">
    </div>
    <div class="mb-3">
      <input type="text" class="form-control zonename" placeholder="Enter Zonename" name="zonename">
    </div>
    <div class="mb-3">
      <div style="width: 50%;float: left;">
        <input type="text" class="form-control zonesubdomaindealname" placeholder="Enter Sub Domain Deal Page Name" name="zonedealsubdomain">
      </div>
      <div style="width: 50%;float: left;">
        <input type="text" class="form-control zonesubdomainname" placeholder="Enter Sub Domain Zone Page Name" name="zonesubdomain">
      </div>
    </div>
    <label for="comment">Zip:</label>
      <textarea class="form-control zip" rows="5" name="text"></textarea>
      <br>
      <div class="mb-3">
        <button type="button" id="savedata" class="btn btn-primary ">Save</button>
      </div>
  </form>
</div>
<?=$this->endSection()?>