<?=$this->extend("layout/scrapmaster")?>

<?=$this->section("pageTitle")?>
  Savings Sites
<?=$this->endSection()?>
  
<?=$this->section("scrapcontent")?>
<?=$this->include("includes/scrap/modals")?>
<div class="container">
  <div class="row">
    <div class="col-md-6">
      <h1 style="font-size: 45px;margin:20px;">Email History</h1>
    </div>
    <div class="col-md-6">
      <button style="margin: 25px;font-size: 20px;float: right;" id="addeditemail" class="btn btn-primary">Add +</button>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <table  id="emailexample" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Id</th>
            <th>Email Category</th>
            <th>Email Address</th>
            <th>Email Data</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="emaildiv">
        </tbody>
      </table> 
    </div>
  </div>
</div>
<?=$this->endSection()?>