<?=$this->extend("layout/scrapmaster")?>

<?=$this->section("pageTitle")?>
  Savings Sites
<?=$this->endSection()?>
  
<?=$this->section("scrapcontent")?>
<?php $i = 0; ?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h1 style="text-align: center;    margin-bottom: 0;    margin-top: 46px;">All Directories / Users </h1>
<table border="1" class="zone_login_data">
  <thead>
    <tr style="  text-align:center; font-size:18px; font-weight:bold;">
      <td>Id</td>
      <td>ZoneId</td>
      <td>Zonename</td>
      <td>Username</td>
      <td>Email</td>
      <td>First Name</td>
      <td>Last Name</td>
      <td>User Id</td>
      <td>Link</td>
      <td>Action</td>   
    </tr>
  </thead>
  <tbody>
  <?php foreach ($result as $key => $v) {
    $i++;
    if($v['subdomain'] == ''){
      $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]"."/zone/".$v['seo_zone_name'];
    }else{
      $http = isset($_SERVER['HTTPS']) ? "https" : "http";
      $url = $http.'://'.$v['subdomain'].'.savingssites.com'.'/Zonedashboard/zoneinformation';
    }
    echo '<tr>
      <td>'.$i.'</td>
      <td>'.$v['zoneid'].'</td>
      <td>'.$v['name'].'</td>
      <td>'.$v['username'].'</td>
      <td>'.$v['email'].'</td>
      <td>'.$v['first_name'].'</td>
      <td>'.$v['last_name'].'</td>
      <td>'.$v['id'].'</td>
      <td><a target="_blank" href="'.$url.'">'.$url.'</a></td>
      <td><input type="button" class="loginZone btn btn-info" userid="'.$v['id'].'" value="Login" /></td>
    </tr>';
  }

   ?>
  </tbody>
 

</table>      
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script type="text/javascript">
  $(document).on('click','.loginZone',function(e){
    e.preventDefault();
    var userId = $(this).attr('userid');
    $.ajax({
      type:"POST",
      url:'/logintozone',
      data:{'userId': userId},
      dataType:'json',
      beforeSend:function(){
        $("#loading").removeClass('hide');
      },
      complete: function() {
        $("#loading").addClass('hide');
      },
      success: function (r) {

        window.location.href = "https://"+r.subdomainZone+".savingssites.com/Zonedashboard/zoneinformation";
        //window.location.href = "https://"+r.subdomainZone+".savingssites.com/Zonedashboard/zoneinformation/"+r.zoneid+"?zoneName="+r.zoneName+"&userId="+r.id+"";     
        // window.location.href = "https://"+r.subdomainZone+".savingssites.com/Zonedashboard/zoneinformation/"+r.zoneid+"?zoneName="+r.zoneName+"&userId="+r.id+"";
      }
    });
  });
</script>
<?=$this->endSection()?>