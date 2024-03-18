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
              <span>Zone Dashboard</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <!-- <li>
                  <a href="javascript:void(0)" class="sidemenu" id="zoneannualdetail" page="zoneannualdetail">Zone Detail
                  </a>
                </li> -->
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="zoneinfo" page="zoneinfo">Zone Reports
                  </a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="zoneinfoadd" page="zoneinfoadd">Zone Add Section</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="zoneinfoedit" page="zoneinfoedit">Zone View Section</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown zonedetail">
            <a href="javascript:void(0)">
              <i class="fa fa-info" aria-hidden="true"></i>
              <span>Zone Settings</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="zoneinformation" page="zoneinformation">Zone Details
                  </a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="emailFormat" page="emailFormat">Email Format</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="sponser" page="sponser">Sponsor Banner</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="groceryspecial" page="groceryspecial">Grocery Special</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="referlinkgenerate" page="referlinkgenerate">Refer Link Generate</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="paypal_as" page="paypal_as">Payment Settings</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="twilioAccount" page="twilioAccount">Twilio Account Settings</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="publisherdealreport" page="publisherdealreport">Donation Claiming Report</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="orgfeereport" page="orgfeereport">Organization Fee Percentage Report</a>
                </li>

                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="emaildetailserver" page="emaildetailserver">Insert Server Email Detail</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="showemaildetailserver" page="showemaildetailserver">Show Server Email</a>
                </li>
              </ul>
            </div>
          </li>

          <li class="sidebar-dropdown zonedetail">
            <a href="javascript:void(0)">
              <i class="fa fa-info" aria-hidden="true"></i>
              <span>Zone Publisher Manager</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="zonecreatesubuser" page="zonecreatesubuser">Create Publisher Manager
                  </a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="zoneshowsubuser" page="zoneshowsubuser">View Publisher Manager</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a href="javascript:void(0)">
              <i class="fa fa-shopping-cart"></i>
              <span>Categories</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="managecategories"  page="managecategories"> Manage All Categories</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a href="javascript:void(0)">
              <i class="fa fa-shopping-cart"></i>
              <span>Businesses</span>
            
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="addbusiness" page="addbusiness"> Add Business
                  </a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="myzonebusiness" page="myzonebusiness"> My Zone Businesses</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="communicationmethod" page="communicationmethod"> Communication Method</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="ranksponsorrestaurants"  page="ranksponsorrestaurants">Rank  Business</a>
                </li>
                 <li>
                  <a href="javascript:void(0)" class="sidemenunew" page="ranksponsorsubcat" id="ranksponsorsubcat">Rank Business Sub Category</a>
                  <div class="threestep-subsub <?= $hide; ?>">    
                  <?php $data = $subdata; 
                    foreach($data as $data){
                      echo '<a href="javascript:void(0);" class="order_category_business" id="order_category_business" data-id="'.$data['id'].'">'.$data['name'].'</a>';
                    }
                  ?>
                  </div>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="businessusers" page="businessusers">Business Users</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="businessbidrank" page="businessbidrank">Business Bid Rank</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="pendingbusinessbid" page="pendingbusinessbid">Pending Business Bid</a>
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
                  <a href="javascript:void(0)" class="sidemenu" id="makenewadvertisement" page="makenewadvertisement">Make New Advertisement</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="viewads" page="viewads">View Advertisements</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a href="javascript:void(0)">
              <i class="far fa-gem"></i>
              <span> Business Deals</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="create_deal" page="create_deal">Create Deal</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="viewdeals" page="viewdeals">View Deals</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="dealreport" page="dealreport">Deals Sell Report</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="dealemailreport" page="dealemailreport">Business Deal Email Report</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="dealivrreport" page="dealivrreport">Business Deal IVR Report</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="dealsapprovaldpareport" page="dealsapprovaldpareport">Business Deal Approval DPA Report</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a href="javascript:void(0)">
              <i class="far fa-gem"></i>
              <span> Organization</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="add_organization" page="add_organization">Create Organization</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="view_organization" page="view_organization">View organizations</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="organization_users" page="organization_users">Organization Users</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="organizationfeereport" page="organizationfeereport">Organization Fee Report</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown hide">
            <a href="javascript:void(0)">
              <i class="far fa-gem"></i>
              <span> Banner</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="addbanner" page="addbanner">Add Banner</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="managebanner" page="managebanner">Manage Banners</a>
                </li>

              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a href="javascript:void(0)">
              <i class="far fa-gem"></i>
              <span>All Business EveryDay Spc.Food</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="everydayfoodspecial" page="everydayfoodspecial">Daily Specials Recordings</a>
                </li>
              </ul>
            </div>
          </li>

          <li class="sidebar">
            <a href="<?=base_url() ?>/home/publisherTOS">
              <i class="far fa-gem"></i>
              <span>Publisher Terms Of Service</span>
            </a>
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
