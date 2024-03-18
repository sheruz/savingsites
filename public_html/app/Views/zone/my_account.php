<?=$this->extend("layout/master")?>

<?=$this->section("pageTitle")?>
  Savings Sites
<?=$this->endSection()?>
  
<?=$this->section("content")?>
<section class="section section-sm cus-bg-default text-md-left">
  <div class="container-fluid">
    <div class="row justify-content-center align-items-xl-center">
        <div class="outerofferdiv">
          <div class="outerofferdiv"><input type="hidden" id="user_id" value="2500675">
            <div class="tab_span">
              <div class="tab_span_head nav nav-pills">
                <div id="tab_6" class="tab_6 tabspan_single tabmyaccount update_profile nav-item selected_tab" style="cursor:pointer;">
                  <span type="userupdate" class="zoneMyAccount inner_tabspan_single nav-link active">
                    <i class="fa fa-wrench" aria-hidden="true"></i>Update Profile</span>
                </div>
                <div id="tab_12" class="tab_12 tabspan_single tabmyaccount get_peekabooauctions nav-item" style="cursor:pointer;">
                  <span type="claimdeal" class="zoneMyAccount inner_tabspan_single nav-link"><i class="fa fa-delicious" aria-hidden="true"></i>Claimed Deals</span>
                </div>
                <div id="tab_13" class="tab_13 tabspan_single tabrefer_code nav-item" style="cursor:pointer;">
                  <span type="refergenlink" class="zoneMyAccount inner_tabspan_single nav-link"><i class="fa fa-link" aria-hidden="true"></i>Refer Link Generate</span>
                </div>
              </div>
              <div id="myaccountbodyData" class="myaccountbodyData " style="background: #fff; border: 1px solid #ddd; border-radius: 1px; padding: 0px;"></div>
            </div>
          </div>
        </div>
  
    </div>
  </div>
</section>
  <div class="modal certificate_view" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <p>Modal body text goes here.</p>
        </div>
     </div>
    </div>
  </div>
<style type="text/css">
@media (max-width: 480px){
  li.werweriul{
  display: none;
}
ul.list-inline.user-menu.topheaderimages {
    margin-left: 61px;
}
}
</style>
<?=$this->endSection()?>

