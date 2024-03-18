<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<div class="page-wrapper savings toggled">
  <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
<i class="fa fa-arrow-right" aria-hidden="true"></i>
  </a>
  <nav id="sidebar" class="sidebar-wrapper organizationdashboard">
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
              <span>Organization Information</span>
            
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="organizationdetail" type="organizationdashboard" page="organizationdetail">Organization Information</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="managephoto" type="organizationdashboard" page="managephoto">Manage Photo</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="organizationfeereport" type="organizationdashboard" page="organizationfeereport">Monthly Earning Report</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="multisinglelogin" type="organizationdashboard" page="singleusermultiplelogin">User Multiple Login</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a href="javascript:void(0)">
              <i class="fa fa-info" aria-hidden="true"></i>
              <span>Webinar Information</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="webinar_information" type="organizationdashboard" page="webinar_information">Enter Webinar Information</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="webinar_details1" type="organizationdashboard" page="webinar_details1">View Webinar Information</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a href="javascript:void(0)">
              <i class="fa fa-users" aria-hidden="true"></i>
              <span>Interest Groups</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="create_interest_group" type="organizationdashboard" page="create_interest_group">New Interest Group</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="view_interest_group" type="organizationdashboard" page="view_interest_group">View Interest Group</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a href="javascript:void(0)">
              <i class="fa fa-money" aria-hidden="true"></i>
              <span>Payment</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="jotform" type="organizationdashboard" page="jotform">View Form</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="payment_list" type="organizationdashboard" page="payment_list">Payment Details</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="pboo_credit_order" type="organizationdashboard" page="pboo_credit_order">Pboo Credit Order</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="transfer_pboo_credit" type="organizationdashboard" page="transfer_pboo_credit">Transfer Pboo Credit</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="spreadsheet_download" type="organizationdashboard" page="spreadsheet_download">Certificate Beneficiary Spreadsheet</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a href="javascript:void(0)">
             <i class="fa fa-filter" aria-hidden="true"></i>
              <span>Category</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="new_category" type="organizationdashboard" page="new_category">Suggest New Category</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="view_category_subcategory" type="organizationdashboard" page="view_category_subcategory">View All Categories</a>
                </li>
              </ul>
            </div>
          </li>
          <!-- <li class="sidebar-dropdown">
            <a href="javascript:void(0)">
              <i class="fa fa-calendar" aria-hidden="true"></i>
              <span>Events Calendar</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                   <a href="javascript:void(0)" class="sidemenu" onclick="organization_calendar()" id="newcategory" type="organizationdashboard" page="newcategory">View Event Dashboard</a>
                </li>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="calendaremailhistory" type="organizationdashboard" page="calendaremailhistory">View Email History</a>
                </li>
              </ul>
            </div>
          </li> -->
          <li class="sidebar-dropdown">
            <a href="javascript:void(0)">
              <i class="fa fa-bell-o" aria-hidden="true"></i>
              <span>Announcements</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="new_announcement" type="organizationdashboard" page="new_announcement">Create Announcement</a>
                </li>
                 <li>
                  <a href="javascript:void(0)" class="sidemenu" id="view_announcement" type="organizationdashboard" page="view_announcement">View Announcements</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a href="javascript:void(0)">
             <i class="fa fa-bullhorn" aria-hidden="true"></i>
              <span>Alexa Announcements</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="new_broadcast" type="organizationdashboard" page="new_broadcast">Create/Update</a>
                </li>
                 <li>
                  <a href="javascript:void(0)" class="sidemenu" id="view_broadcast" type="organizationdashboard" page="view_broadcast">View Announcements</a>
                </li>
              </ul>
            </div>
          </li>
          <!------extra files---->
           <!-- <li class="sidebar-dropdown">
            <a href="javascript:void(0)">
              <i class="far fa-gem"></i>
              <span>no side bar data files</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="javascript:void(0)" class="sidemenu" id="new_broadcast" type="organizationdashboard" page="new_broadcast">Create/Update</a>
                </li>
                 <li>
                  <a href="javascript:void(0)" class="sidemenu" id="view_broadcast" type="organizationdashboard" page="view_broadcast">View Announcements</a>
                </li>
              </ul>
            </div>
          </li> -->
        </ul>
      </div>
      <!-- sidebar-menu  -->
    </div>
