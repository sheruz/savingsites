<?=$this->extend("layout/master")?>

<?=$this->section("pageTitle")?>
  Home | Savingssites
<?=$this->endSection()?>
  
<?=$this->section("content")?>
<?=$this->include("includes/modals")?>
<?=$this->include("includes/home/home_slider")?>
<section class="section section-sm bg-default text-md-left about-view" style="display: none;"></section>
<section class="section section-sm bg-default text-md-left benefits-view" style="display: none;"></section>
<section>
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div id="area-organization" class="toggle-container organization-view"></div>
        <div id="area-grocerystore" class="toggle-container grocerystore-view"></div> 
      </div>
    </div>
  </div>
</section>
<?php if(isset($zone_pref_setting) && $zone_pref_setting[0]['auto_approve_offers_announcements']!=1){?>
  <?php if(isset($zone_pref_setting) && $zone_pref_setting[0]['auto_approve_offers_announcements']!=1){?>
    <div id="area-highschoolsports" class="highschoolsports_div" style="display:none"></div>
  <?php }?>
      <span id="calendar_view">   
        <div id="area-calendar" style="height:400;display:none" class="eventcalandar calendar_bluetheme_view">  
          <a href="javascript:void(0)"><img id="restore_calendar" src="https://cdn.savingssites.com/plus.png" width="42" height="42" alt="plus" style="position:relative;z-index:999999;float:right;margin-right:-10px;margin-top:-10px" onclick="show_calendar_div('org','area-calendar','area-calendar_collapse')" />
          </a>
        </div>
      </span>
      <div id="area-organization" class="organization_div" style="display:none"></div>
  <?php } ?>

<?=$this->endSection()?>