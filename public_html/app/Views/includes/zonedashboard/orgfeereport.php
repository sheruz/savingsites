<div class="page-wrapper main-area toggled viewdeals">
   <div class="container">
    <input type="hidden" id="businessid" name="businessid" value="<?php echo $businessid;?>"/>
      <div class="row" style=" margin-bottom: 80px;">
         <div class="top-title">
            <h2>Organization Fee Percentage Report</h2>
            <hr class="center-diamond">
            <p>Below you can adjust the donation percentage given to favorited nonprofits</p>
            <table class="display responsive-table">
              <tr>
                <td>Favorite Nonprofit Percentage</td>
                <td><input type="number" id="nonper" value="<?= $nonfavper; ?>"/><i style="background: black;color: #fff;padding: 6px;width:10%;" class="fa fa-percent"></i></td>
                <td><button type="button" class="btn btn-info" id="updatepernfav">Update</button></td>
              </tr>
            </table>
         </div>
         <table class="display responsive-table datatable-all" cellspacing="0" width="100%" id="managecat">
            <thead>
               <tr>
                  <th scope="col">Organization Name</th>
                  <th scope="col">User Name</th>
                  <th scope="col">User Phone</th>
                  <th scope="col">User Email</th>
                  <th scope="col">Organization Fee(%)</th>
                  <th scope="col" style="width: 30%;">Action</th>
               </tr>
            </thead>
            <tbody>
              <?php foreach ($purchasedealArr as $k => $v) {
                if($v['fee_per'] > 0){
                  $fee_per = $v['fee_per'];
                }else{
                  $fee_per = 20;
                }
                 echo '<tr>
                   <td>'. $v['name'].'</td>
                   <td>'.$v['first_name'].' '.$v['last_name'].'</td>
                   <td>'.$v['phone'].'</td>
                   <td>'. $v['email'].'</td>
                   <td><input style="width:70%;float:left;" type="number" class="orgfeeper" value="'.$fee_per.'"/><i style="background: black;color: #fff;padding: 6px;width:30%;" class="fa fa-percent"></i></td>
                   <td width="13%"><span class="updateperdetail cus-solid-prpl" zone_id="'.$v['Zone_ID'].'" userid="'.$v['user_id'].'" orgid="'.$v['id'].'">Update</span>
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