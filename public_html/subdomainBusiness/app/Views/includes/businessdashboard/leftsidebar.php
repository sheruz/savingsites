<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<div class="page-wrapper savings toggled">
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
      </div></div>
      <!-- sidebar-header  -->
      <div class="sidebar-search">
                <div class="logoimg">
                <?php if(!empty($logo)){
                  echo '<img id="runlogo" src="'.base_url().'/assets/SavingsUpload/Business/'.$businessid.'/'.$logo.'" style="width: 100%;">';
                }else{
                  echo '<img src="https://cdn.savingssites.com/logo-green.png" style="width: 100%;">';
                } ?>
                   
                </div>
                 <h2><?= $zone_name?></h2>
      </div>
      <!-- sidebar-search  -->
      <div class="sidebar-menu" id="sidebar-menu">
        <ul>
          <li class="sidebar-dropdown">
            <a href="javascript:void(0)">
              <i class="fa fa-shopping-cart"></i>
              <span>Business Information</span>
            
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="businessshorturl" type="businessdashboard" page="businessshorturl">Business Short URL</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="businessdetail" type="businessdashboard" page="businessdetail">Business Detail</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="dealreport" type="businessdashboard" page="dealreport">Deals Sell Report</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="businessbidrank" type="businessdashboard" page="businessbidrank">AD Placement Bid</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="singlemultilogin" type="businessdashboard" page="singleusermultiplelogin">User Multiple Login</a></li>
               
              </ul>
            </div>
          </li>
           <li class="sidebar-dropdown zonedetail">
            <a href="javascript:void(0)">
              <i class="fa fa-info" aria-hidden="true"></i>
              <span>Business Manager</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" type="businessdashboard" id="zonecreatesubuser" page="zonecreatesubuser">Create Manager
                  </a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" type="businessdashboard" id="zoneshowsubuser" page="zoneshowsubuser">VIew Manager</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a href="javascript:void(0)">
              <i class="far fa-gem"></i>
              <span>Advertisement</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" type="businessdashboard" id="makenewadvertisement" page="makenewadvertisement">Make New Advertisement</a>
                </li>
                <li>
                  <a href="javascript:void(0)" type="businessdashboard" class="sidemenu" id="viewads" page="viewads">View Advertisements</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a href="javascript:void(0)">
              <i class="far fa-gem"></i>
              <span>Business Deals</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="javascript:void(0)" type="businessdashboard" class="sidemenu" id="create_deal" page="create_deal">Create Deal</a>
                </li>
                <li>
                  <a href="javascript:void(0)" type="businessdashboard" class="sidemenu" id="viewdeals" page="viewdeals">View Deals</a>
                </li>

              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a href="javascript:void(0)">
              <i class="far fa-gem"></i>
              <span>Business SNAP</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="javascript:void(0)" type="businessdashboard" class="sidemenu" id="add_business_snap" page="add_business_snap">Set SNAP Filters</a>
                </li>
                <li>
                  <a href="javascript:void(0)" type="businessdashboard" class="sidemenu" id="show_business_snap" page="show_business_snap">Show SNAP Detail</a>
                </li>
                <li>
                  <a href="javascript:void(0)" type="businessdashboard" class="sidemenu" id="claim_business_snap" page="claim_business_snap">Claimed SNAP Deal Detail</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a href="javascript:void(0)">
              <i class="far fa-gem"></i>
              <span>Business Order</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="javascript:void(0)" type="businessdashboard" class="sidemenu" id="orderapproval" page="orderapproval">Order Approval</a>
                </li>
                <li>
                  <a href="javascript:void(0)" type="businessdashboard" class="sidemenu" id="orderstatus" page="orderstatus">Order Status</a>
                </li>

              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a href="javascript:void(0)">
              <i class="far fa-gem"></i>
              <span>EveryDay Spc.Food</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="javascript:void(0)" type="businessdashboard" class="sidemenu" id="everydayfoodspecial" page="everydayfoodspecial">Daily Specials Recordings</a>
                </li>
              </ul>
            </div>
          </li>
          
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
