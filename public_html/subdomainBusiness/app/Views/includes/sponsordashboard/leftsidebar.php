<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<?php 
  if(isset($_GET['page']) && $_GET['page'] == 'ranksponsorsubcat'){
    $hide = '';
  }else{
    $hide = 'hide';
  }

?>
<div class="page-wrapper savings toggled " id="vardum">
  <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
<i class="fa fa-arrow-right" aria-hidden="true"></i>
  </a>
  <nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
      <div class="sidebar-brand">
        <a href="#">Welcome</a>
        <div id="close-sidebar">
      <i class="fa fa-arrow-left" aria-hidden="true"></i>
        </div>
      </div>
    </div>
      <!-- sidebar-header  -->
      <div class="sidebar-search">
          <div class="logoimg">
             <!--echo '<img id="runlogo" src="https://cdn.savingssites.com/'.$check_zone_logo[0]['id'].'/'.$check_zone_logo[0]['image_name'].'" style="width: 100%;">';-->
            <?php if(!empty($check_zone_logo[0]['image_name'])){
              echo '<img id="runlogo" src="https://cdn.savingssites.com/'.$check_zone_logo[0]['image_name'].'" style="width: 100%;">';
            }else{
              echo '<img src="https://cdn.savingssites.com/logo-green.png" style="width: 100%;">';
            } ?>
             
          </div>
                 <h2><?= $zone_name?></h2>
      </div>
      <!-- sidebar-search  -->
      <div class="sidebar-menu" id="sidebar-menu">
        <ul>
         
          <li class="sidebar-dropdown zonedetail">
            <a href="javascript:void(0)">
              <i class="fa fa-info" aria-hidden="true"></i>
              <span>Sponsor Settings</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" type="sponsordashboard" id="zoneinformation" page="zoneinformation">Sponsor Details
                  </a>
                </li>
              </ul>
            </div>
          </li>
          
          <li class="sidebar-dropdown">
            <a href="javascript:void(0)">
              <i class="far fa-gem"></i>
              <span>Business Sponsor Banner</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="javascript:void(0)" type="sponsordashboard" class="sidemenu" id="addsponsorbanner" page="add_business_sponsor_banner">Add Banner</a>
                </li>
                <li>
                  <a href="javascript:void(0)" type="sponsordashboard" class="sidemenu" id="showsponsorbanner" page="view_business_sponsor_banner">View Banner</a>
                </li>
              </ul>
            </div>
          </li>
         
         
         

        


        </ul>
      </div>
      <!-- sidebar-menu  -->
    </div>
