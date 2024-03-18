<div class="page-wrapper main-area toggled viewdeals">
   <div class="container">
    <input type="hidden" id="businessid" name="businessid" value="<?php echo $businessid;?>"/>
      <div class="row" style=" margin-bottom: 80px;">
         <div class="top-title">
            <h2>Donation Claiming Report</h2>
            <hr class="center-diamond">
            <p>The deals sold by all business are listed below:</p>
            <button class="dt-button" tabindex="0" id="rescheduleall" aria-controls="table_id" type="button"><span><a class="a" href="/downloadcsv">Download CSV</a></span></button>
          </div>
          <div class="row">
            <div class="col-md-3">
              <input autocomplete="off" type="date" id="dstartdate" name="startdate" placeholder="Start Date">
            </div>
            <div class="col-md-3">
              <input type="date" id="dstopdate" name="stopdate" placeholder="Stop Date" autocomplete="off">
            </div>
            <div class="col-md-3">
              <input type="button" name="go" value="Search" id="dsearch">
            </div>
          </div>
         <table class="display responsive-table datatable-all" cellspacing="0" width="100%" id="managecat">
            <thead>
               <tr>
                  <th scope="col">Business Name</th>
                  <th scope="col">User Name</th>
                  <th scope="col">User Phone</th>
                  <th scope="col">Deal Id</th>
                  <th scope="col">Deal Name</th>
                  <th scope="col">Deal price</th>
                  <th scope="col">Donation Claiming Fee</th>
                  <th scope="col">Purchased At</th>
                  <th scope="col" style="width: 30%;">Action</th>
               </tr>
            </thead>
            <tbody id="claimdata">
              <?php foreach ($purchasedealArr as $k => $v) {
                 echo '<tr>
                   <td>'.$v['company_name'].'</td>
                   <td>'.$v['first_name'].' '.$v['last_name'].'</td>
                   <td>'.$v['phone'].'</td>
                   <td>'.$v['dealId'].'</td>
                   <td>'. $v['deal_title'].'</td>
                   <td>'. $v['amountPurchased'].'</td>
                   <td>'. $v['publisher_fee'].'</td>
                   <td>'. $v['purchasedAt'].'</td>
                   <td width="13%"><span class="showdealdetail cus-solid-prpl" busid="'.$v['busId'].'" zone_id="'.$v['zoneId'].'" dealmeta="'.$v['id'].'">Detail</span>
                   </td>
                 </tr>';
                } 
              ?>
            </tbody>
         </table>
         <div class="container hide" id="createdealdiv">
        <div class="row">
          <div class="col-md-12">
             <p id="closedeal">Close <i class="fa fa-window-close" aria-hidden="true"></i></p>
            <div class="top-title">
              <h2>Deal Detail</h2>
              <hr class="center-diamond">
            </div>
            <div class="form-control row">
             <div class="col-md-4">
              <div style="width:80%;margin:auto ;">
                
                <img id="image" src=""/>
              </div>
             </div>
             <div class="col-md-4">
                <p>Deal Id : <span id="dealid"></span><p> 
                <p>Deal Title : <span id="dealtitle"></span></p> 
                <p>Deal Description : <span id="dealdesc"></span></p> 
                <p>Deal Start Date : <span id="dealstart"></span></p>  
                <p>Deal End Date : <span id="dealend"></span></p> 
                <p>Cert Value : <span id="certval"></span></p> 
                <p>Deal Creation Date : <span id="dealcreation"></span></p>  
                <p>Deal Auction Type : <span id="auctiontype"></span></p>  
                <p>Deal Status : <span id="status"></span></p>  
             </div>
             <div class="col-md-4">
                <p>Deal Publisher Fee : <span id="publisher_fee"></span></p>  
                <p>Deal Seller Fee : <span id="seller_fee"></span></p>  
                <p>Deal Price : <span id="price"></span></p>  
                <p>Deal Purchased Date : <span id="PurchasedAt"></span></p>  
                <p>Deal Amount : <span id="dealamount"></span></p>  
                <p>Deal Discount : <span id="disamount"></span></p>  
                <p>Deal Actual Price : <span id="actualprice"></span></p> 
             </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="top-title">
              <h2>User Detail</h2>
            </div>
            <div class="form-control row">
              <div class="col-md-12">
                <p>User Name : <span id="username"></span></p> 
                <p>Address : <span id="add"></span></p> 
                <p>Email : <span id="email"></span></p>
                <p>Phone : <span id="phone"></span></p> 
                <!-- <p>User Type : <span id="user_type"></span></p>  -->
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
   </div>
</div>