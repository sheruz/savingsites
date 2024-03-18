<?=$this->extend("layout/scrapmaster")?>

<?=$this->section("pageTitle")?>
  Savings Sites
<?=$this->endSection()?>
  
<?=$this->section("scrapcontent")?>
<?=$this->include("includes/scrap/modals")?>
<?php $i=0; ?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <select class="form-control" id="zonelistscrap">
        <option>Select Zone</option>
          <?php foreach ($zonedata as $k => $v) {
            echo '<option value="'.$v['id'].'">'.$v['id'].'</option>';
          }?>
      </select>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <h1 style="text-align: center;    margin-bottom: 0;    margin-top: 46px;">All Deals </h1>
      <table class="table table-bordered" id="zone_deals_data">
        <thead>
          <tr style=" text-align:center; font-size:18px; font-weight:bold;">
            <td>Serial No.</td>
            <td>AddId</td>
            <td>BusinessId</td>
            <td>Dealtitle</td>
          </tr>
        </thead> 
        <tbody>
        <?php foreach ($data as $k => $v) {
          $i++;
          echo '<tr>
            <td>'.$i.'</td>
            <td>'.$v['id'].'</td>
            <td>'.$v['business_id'].'</td>
            <td>'.$v['deal_title'].'</td>
          </tr>';  
        } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?=$this->endSection()?>