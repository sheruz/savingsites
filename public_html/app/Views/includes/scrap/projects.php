<?=$this->extend("layout/scrapmaster")?>

<?=$this->section("pageTitle")?>
  Savings Sites
<?=$this->endSection()?>
  
<?=$this->section("scrapcontent")?>
<?=$this->include("includes/scrap/modals")?>
<?php $count = 1; ?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <table class="data-table" id="project_data">
        <caption class="title">List of Directory Owners</caption>
        <thead>
          <tr>
            <th>SL No.</th>
            <th>Zone Name</th>
            <th>Email</th>
            <th>Website Url</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($projectdata as $k => $v) {
        if($v['subdomain'] == ''){
          $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]"."/zone/".$v['seo_zone_name'];
        }else{
          $http = isset($_SERVER['HTTPS']) ? "https" : "http";
          $url = $http.'://'.$v['subdomain'].'.savingssites.com';
        }
          echo '<tr>
            <td>'.$count.'</td>
            <td>'.$v['name'].'</td>
            <td>'.$v['email'].'</td>
            <td><a target="_blank" href="'.$url.'">'.$url.'</a></td>
          </tr>';
          $count++;  
        }?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?=$this->endSection()?>