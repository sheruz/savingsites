<?=$this->extend("layout/master")?>

<?=$this->section("pageTitle")?>
  Savings Sites
<?=$this->endSection()?>
<?=$this->section("content")?>
<section class="section section-sm cus-bg-default text-md-left">
  <div class="container-fluid">
    <div class="row justify-content-center align-items-xl-center">
      <div class="outerofferdiv">
        <div class="outerofferdiv">
          <input type="hidden" id="user_id" value="<?= $user_id; ?>">
          <input type="hidden" id="residentshareurl" value="<?= $residentshareurl; ?>">
          <div class="tab_span">
            <div class="tab_span_head nav nav-pills">
              <div id="tab_6" class="tab_6 tabspan_single tabmyaccount update_profile nav-item selected_tab" style="cursor:pointer;">
                <span type="userupdate" class="zoneMyAccount inner_tabspan_single nav-link active">
                    <i class="fa fa-wrench" aria-hidden="true"></i>Update Profile</span>
              </div>
              <div id="tab_12" class="tab_12 tabspan_single tabmyaccount get_peekabooauctions nav-item" style="cursor:pointer;">
                <div class="sidebar-menu" id="sidebar-menu">
                  <ul>
                    <li class="sidebar-dropdown">
                      <a href="javascript:void(0)">
                        <i class="fa fa-delicious"></i>
                        <span>Deals</span>
                      </a>
                      <div class="sidebar-submenu">
                        <ul>
                          <li>
                            <span type="claimdeal" class="zoneMyAccount inner_tabspan_single nav-link"><i class="fa fa-delicious" aria-hidden="true"></i>Claimed Deals</span>
                          </li>
                          <li>
                            <span type="claimdealsend" class="zoneMyAccount inner_tabspan_single nav-link"><i class="fa fa-delicious" aria-hidden="true"></i>Send Gift Deals</span>
                          </li>
                        </ul>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
              <!-- <div id="tab_13" class="tab_13 tabspan_single tabrefer_code nav-item" style="cursor:pointer;">
                <span type="refergenlink" class="zoneMyAccount inner_tabspan_single nav-link"><i class="fa fa-link" aria-hidden="true"></i>Refer Link Generate</span>
              </div> -->
              <div id="tab_13" class="tab_13 tabspan_single tabrefer_code nav-item" style="cursor:pointer;">
                <span type="dealrefergenlink" class="zoneMyAccount inner_tabspan_single nav-link"><i class="fa fa-link" aria-hidden="true"></i>Deal Refer Link</span>
              </div>
              <div id="tab_13" class="tab_13 tabspan_single tabrefer_code nav-item" style="cursor:pointer;">
                <span type="refergenlinkQR" class="zoneMyAccount inner_tabspan_single nav-link"><i class="fa fa-link" aria-hidden="true"></i>QR Code</span>
              </div>
              <div id="tab_13" class="tab_13 tabspan_single tabrefer_code nav-item" style="cursor:pointer;">
                <span type="subscribebusiness" class="zoneMyAccount inner_tabspan_single nav-link"><i class="fa fa-link" aria-hidden="true"></i>Add Fav Business By Sub-Category</span>
              </div>
              <div id="tab_13" class="tab_13 tabspan_single tabrefer_code nav-item" style="cursor:pointer;">
                <span type="editsubscribebusiness" class="zoneMyAccount inner_tabspan_single nav-link"><i class="fa fa-link" aria-hidden="true"></i>Edit Fav Business By Sub-Category</span>
              </div>
              <div id="tab_13" class="tab_13 tabspan_single tabrefer_code nav-item" style="cursor:pointer;">
                <span type="showsubscribebusiness" class="zoneMyAccount inner_tabspan_single nav-link"><i class="fa fa-link" aria-hidden="true"></i>Show Fav Subscribed Business</span>
              </div>
              <div id="tab_13" class="tab_13 tabspan_single tabrefer_code nav-item" style="cursor:pointer;">
                <span type="manyusersinglelogin" class="zoneMyAccount inner_tabspan_single nav-link"><i class="fa fa-link" aria-hidden="true"></i>User Multiple Login</span>
              </div
              ><div id="tab_13" class="tab_13 tabspan_single tabrefer_code nav-item" style="cursor:pointer;">
                <span type="addsnaptime" class="zoneMyAccount inner_tabspan_single nav-link"><i class="fa fa-link" aria-hidden="true"></i>Add Snap time</span>
              </div>
              <div id="tab_13" class="tab_13 tabspan_single tabrefer_code nav-item" style="cursor:pointer;">
                <span type="showsnapuser" class="zoneMyAccount inner_tabspan_single nav-link"><i class="fa fa-link" aria-hidden="true"></i>Show Snap time</span>
              </div>
              <div id="tab_13" class="tab_13 tabspan_single tabrefer_code nav-item" style="cursor:pointer;">
                <span type="claimedsnapdeal" class="zoneMyAccount inner_tabspan_single nav-link"><i class="fa fa-link" aria-hidden="true"></i>Claimed Snap Deal</span>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <!-- jQuery Code (to Show Modal on Page Load) -->

  <!--Modal HTML-->
 <div id="myModal" class="modal fade" tabindex="-1">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Free $5 Approval Status <i title="Resident user click on free $5 on deal page, Email send to business approval of deal, status of approval approve, reject, pending show on modal" class="fa fa-circle-info showfree5info"></i></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Business Name</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody id="visitid">
                      <tr>
                        <td></td>
                        <td></td>
                      </tr>
                    </tbody>
                  </table>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary dontshowmodalfree5" data-bs-dismiss="modal">Don't show again </button>
              </div>
          </div>
      </div>
  </div> 

<div id="free5modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Free $5 Approval Status</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                It seems like you're describing a scenario involving a deal page where a resident user clicks on a free $5 offer, triggering an email to the business for approval. The status of approval (approve, reject, pending) should then be displayed on a modal. Here's a step-by-step breakdown of how you might implement this:<br><br>

1. <b>User Clicks on Free $5 Offer</b>: When a resident user clicks on the free $5 offer on the deal page, it triggers an event to initiate the approval process.<br><br>

2. <b>Email Sent to Business</b>: An email is automatically generated and sent to the business notifying them of the deal request. The email should contain details of the deal and a link to review/approve/reject it.<br><br>

3. <b>Approval Status Tracking</b>: The system should track the approval status of the deal. Initially, the status would be set to "Pending".<br><br>

4. <b>Modal Display</b>: When the business clicks on the link provided in the email, it should open a modal window displaying the details of the deal along with options to approve, reject, or leave it pending.<br><br>

5. <b>Re-arranging Modal Options</b>:<br>
    - <b>Approve</b>: This option confirms the acceptance of the deal by the business. Upon approval, the status of the deal changes to "Approved".<br>
    - <b>Reject</b>: This option signifies that the business does not accept the deal. Upon rejection, the status of the deal changes to "Rejected".<br>
    - <b>Pending</b>: This option allows the business to postpone the decision for later review. The status remains "Pending".<br><br>

6. <b>Status Update Handling</b>: Depending on the option chosen by the business (approve, reject, or pending), the system updates the status of the deal accordingly.<br><br>

7. <b>User Notification</b>: After the business makes a decision (approve, reject, or pending), the user should receive an email notification informing them of the outcome of their deal request.<br><br>

8. <b>Display Status to User</b>: On the deal page, the user should be able to see the current status of their deal request (e.g., "Approved", "Rejected", or "Pending").<br><br>

By following these steps, you can create a system that allows resident users to request deals, businesses to review and respond to these requests, and both parties to track the status of the deals effectively.
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

