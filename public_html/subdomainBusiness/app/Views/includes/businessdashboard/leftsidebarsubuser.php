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
    <input type="hidden" id="subusereixsts" value="<?= $subuser; ?>">
<i class="fa fa-arrow-right" aria-hidden="true"></i>
  </a>
  <nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
      <div class="sidebar-brand">
        <a href="#">Welcome</a>
        <div id="close-sidebar">
      <i class="fa fa-arrow-left" aria-hidden="true"></i>
        </div>
      </div></div>
      <!-- sidebar-header  -->
      <div class="sidebar-search">
                <div class="logoimg">
                  <input type="hidden" id="subusereixsts" value="<?= $subuser; ?>">
                <?php if(!empty($check_zone_logo[0]['image_name'])){
                  echo '<img id="runlogo" src="'.base_url().'/assets/SavingsUpload/zone_logo/'.$check_zone_logo[0]['id'].'/'.$check_zone_logo[0]['image_name'].'" style="width: 100%;">';
                }else{
                  echo '<img src="https://cdn.savingssites.com/logo-green.png" style="width: 100%;">';
                } ?>
                   
                </div>
                 <h2><?= $zone_name?></h2>
      </div>
      <!-- sidebar-search  -->
      <div class="sidebar-menu" id="sidebar-menu">
      <?php 
      if($result = array_intersect(['zs1','zs2','zs3','zs4','zs5','zs6','zs7'], $datasubuserArr1)){
        echo '<ul>
          <li class="sidebar-dropdown zonedetail">
            <a href="javascript:void(0)">
              <i class="fa fa-info" aria-hidden="true"></i>
              <span>Business Information</span>
            </a>
            <div class="sidebar-submenu">
              <ul>';
        if(in_array('zs7',$datasubuserArr1)){
          echo '<li><a href="javascript:void(0)" class="sidemenu" id="businessshorturl" type="businessdashboard" page="businessshorturl">Business Short URL</a></li>';
        } 
        if(in_array('zs1',$datasubuserArr1)){
          echo '<li><a href="javascript:void(0)" class="sidemenu" id="businessdetail" type="businessdashboard" page="businessdetail">Business Detail</a></li>';
        } 
        if(in_array('zs2',$datasubuserArr1)){
          echo '<li><a href="javascript:void(0)" class="sidemenu" id="dealreport" type="businessdashboard" page="dealreport">Deals Sell Report</a></li>';
        } 
        if(in_array('zs3',$datasubuserArr1)){
          echo '<li><a href="javascript:void(0)" class="sidemenu" id="businessbidrank" type="businessdashboard" page="businessbidrank">Bid Payment</a></li>';
        }
        if(in_array('zs4',$datasubuserArr1)){
          echo '<li><a href="javascript:void(0)" class="sidemenu" id="singlemultilogin" type="businessdashboard" page="singleusermultiplelogin">User Multiple Login</a></li>';  
        }
       
        echo '</ul></div></li>';
      }

      if($result = array_intersect(['zsuser1','zsuser2'], $datasubuserArr1)){
        echo '<li class="sidebar-dropdown zonedetail"><a href="javascript:void(0)">
              <i class="fa fa-info" aria-hidden="true"></i>
              <span>Business Manager</span></a><div class="sidebar-submenu"><ul>';
        if(in_array('zsuser1',$datasubuserArr1)){
          echo '<li><a href="javascript:void(0)" class="sidemenu" type="businessdashboard" id="zonecreatesubuser" page="zonecreatesubuser">Create Manager</a></li>';
        }
        if(in_array('zsuser2',$datasubuserArr1)){
          echo '<li><a href="javascript:void(0)" class="sidemenu" type="businessdashboard" id="zoneshowsubuser" page="zoneshowsubuser">VIew Manager</a></li>';
        }
        echo '</ul></div></li>';
      }

      if($result = array_intersect(['zma1','zma2'], $datasubuserArr1)){
        echo '<li class="sidebar-dropdown"><a href="javascript:void(0)"><i class="far fa-gem"></i>
              <span>Advertisement</span></a><div class="sidebar-submenu"><ul>';
        if(in_array('zma1',$datasubuserArr1)){
          echo '<li><a href="javascript:void(0)" class="sidemenu" type="businessdashboard" id="makenewadvertisement" page="makenewadvertisement">Make New Advertisement</a></li>';
        }  
        if(in_array('zma2',$datasubuserArr1)){
          echo '<li><a href="javascript:void(0)" type="businessdashboard" class="sidemenu" id="viewads" page="viewads">View Advertisements</a></li>';
        } 
        echo '</ul></div></li>';  
      }

      if($result = array_intersect(['zcd1','zcd2','zcd3','zcd4'], $datasubuserArr1)){
        echo '<li class="sidebar-dropdown"><a href="javascript:void(0)"><i class="far fa-gem"></i>
              <span> Business Deals</span></a><div class="sidebar-submenu"><ul>';
        if(in_array('zcd1',$datasubuserArr1)){
          echo '<li><a href="javascript:void(0)" type="businessdashboard" class="sidemenu" id="create_deal" page="create_deal">Create Deal</a></li>';
        }
        if(in_array('zcd2',$datasubuserArr1)){
          echo '<li><a href="javascript:void(0)" type="businessdashboard" class="sidemenu" id="viewdeals" page="viewdeals">View Deals</a></li>';
        }
        echo '</ul></div></li>';
      }

      if($result = array_intersect(['bsnap1','bsnap2'], $datasubuserArr1)){
        echo '<li class="sidebar-dropdown"><a href="javascript:void(0)"><i class="far fa-gem"></i>
              <span> Business SNAP</span></a><div class="sidebar-submenu"><ul>';
        if(in_array('bsnap1',$datasubuserArr1)){
          echo '<li><a href="javascript:void(0)" type="businessdashboard" class="sidemenu" id="add_business_snap" page="add_business_snap">SET SNAP Filters</a></li>';
        }
        if(in_array('bsnap2',$datasubuserArr1)){
          echo '<li><a href="javascript:void(0)" type="businessdashboard" class="sidemenu" id="show_business_snap" page="show_business_snap">Show SNAP Detail</a></li>';
        }
        if(in_array('bsnap3',$datasubuserArr1)){
          echo '<li><a href="javascript:void(0)" type="businessdashboard" class="sidemenu" id="claim_business_snap" page="claim_business_snap">Claimed SNAP Deal Detail</a></li>';
        }
        echo '</ul></div></li>';
      }

      if($result = array_intersect(['zco1','zco2','zco3','zco4'], $datasubuserArr1)){
        echo '<li class="sidebar-dropdown"><a href="javascript:void(0)"><i class="far fa-gem"></i>
              <span> Business Order</span></a><div class="sidebar-submenu"><ul>';
        if(in_array('zco1',$datasubuserArr1)){
          echo '<li><a href="javascript:void(0)" type="businessdashboard" class="sidemenu" id="orderapproval" page="orderapproval">Order Approval</a></li>';
        } 
        if(in_array('zco2',$datasubuserArr1)){
          echo '<li><a href="javascript:void(0)" type="businessdashboard" class="sidemenu" id="orderstatus" page="orderstatus">Order Status</a></li>';
        }  
        echo '</ul></div></li>';
      }

      if($result = array_intersect(['zes1'], $datasubuserArr1)){
        echo '<li class="sidebar-dropdown"><a href="javascript:void(0)"><i class="far fa-gem"></i>
              <span>All Business EveryDay Spc.Food</span></a><div class="sidebar-submenu"><ul>';  
        if(in_array('zes1',$datasubuserArr1)){
          echo '<li><a href="javascript:void(0)" class="sidemenu" id="everydayfoodspecial" page="everydayfoodspecial">Daily Specials Recordings</a></li>';
        }
        echo '</ul></div></li>';
      }
      ?>
      
                   

                
                 
                    
                   
                   
                  
                  
                
                
               

                
                
              
         
             
         
                
               
               
                
               
              
         
                
               
             
         
               
               
               
              
          
               
               
               
             
          
               
             
          <!-- <li class="sidebar-dropdown">
            <a href="javascript:void(0)">
              <i class="fa fa-chart-line"></i>
              <span> Organizations</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="javascript:void(0)">Pie chart</a>
                </li>
                <li>
                  <a href="javascript:void(0)">Line chart</a>
                </li>
                <li>
                  <a href="javascript:void(0)">Bar chart</a>
                </li>
                <li>
                  <a href="javascript:void(0)">Histogram</a>
                </li>
              </ul>
            </div>
          </li> -->
          <!-- <li class="sidebar-dropdown">
            <a href="javascript:void(0)">
              <i class="fa fa-globe"></i>
              <span> Webinar Information</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="javascript:void(0)">Google maps</a>
                </li>
                <li>
                  <a href="javascript:void(0)">Open street map</a>
                </li>
              </ul>
            </div>
          </li> -->
         <!--  <li>
            <a href="javascript:void(0)">
              <i class="fa fa-book"></i>
              <span> Promotional</span>
            
            </a>
          </li> -->
         <!--  <li>
            <a href="javascript:void(0)">
              <i class="fa fa-calendar"></i>
              <span>  Event Calendar</span>
            </a>
          </li> -->
          <!-- <li>
            <a href="javascript:void(0)">
              <i class="fa fa-wrench" aria-hidden="true"></i>
              <span>Settings </span>
            </a>
          </li> -->
        </ul>
      </div>
      <!-- sidebar-menu  -->
    </div>
