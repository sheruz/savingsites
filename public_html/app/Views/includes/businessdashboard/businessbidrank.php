<style>
   .bithide{
  width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    background: #fff;
}
</style>
<div class="page-wrapper main-area toggled">
   <div class="container">
    <div class="row" style=" margin-bottom: 80px;">
     

     
      <div class="container" id="createdealdiv">
          <!-- MultiStep Form -->
<div class="viewads" id="grad1">
   <div class="row justify-content-center mt-0">
      <div class="col-sm-6 col-md-12 text-center">
         <div class="card">
            <input type="hidden" id="ad_id" name="ad_id" value="-1"/>
            <input type="hidden" id="adid" name="adid" value="-1"/>
            <input type="hidden" id="business_id" name="business_id" value="<?php echo $businessid?>"/>
            <input type="hidden" id="businessid" name="businessid" value="<?php echo $businessid; ?>"/>           
            <input type="hidden" id="pagesidebar" name="pagesidebar" value="<?php echo $pagesidebar;?>"/>            
            <input type="hidden" id="business_name" name="business_name" value=""/>
            <input type="hidden" id="zoneid" name="zoneid" value="<?php echo $zone_id; ?>"/>           
            <input type="hidden" id="fromzoneid" name="fromzoneid" value="<?php echo $zone_id;?>"/>            
            <input type="hidden" name="uploadedInput"  id="uploadedInput" value="" /><br />
            <input type="hidden" name="multiuploadedInput"  id="multiuploadedInput" value="" />
            <input type="hidden" id="docs_pdf" name="docs_pdf" />
            <label id="docs_pdf_foodmenu" name="docs_pdf_foodmenu"></label>
             <input type="hidden" id="ad_starttime" name="ad_starttime" class="w_100"  value="12:00 am" style="margin-top: 10px;" />    
            <input type="hidden" id="ad_stoptime" name="ad_stoptime" class="w_100"  value="11:59 pm" />
            <h2><strong>Bid Payment</strong></h2>
            <p>More you pay, More you touch the top rank</p>
            <div class="row">
               <div class="col-md-12 mx-0">
                  <div id="msform">
                     <fieldset>
                        <div class="form-card">
                           <div class="row">
                              <div class="col-md-4">
                                 <label for="name">Enter Bid Amount</label><br>
                                 <span style="color:red;">(Minimum Bid Amount is 30$)</span>
                              </div>
                              <div class="col-md-8">
                                 <input type="number" id="bitamount" value="30" name="bitamount" autocomplete="off">
                              </div>
                           </div>
                        </div>
                        <input type="hidden" id="payzoneid" value="<?= $zoneid; ?>" />
                        <input type="hidden" id="paybusid" value="<?= $businessid; ?>"/>
                        <input type="hidden" id="paybusname" value="<?= $business->name; ?>"/>
                        <input type="hidden" id="user_type" value="businessbid"/>
                        <?php if($paypal_info['paypal_url'] != ''){ ?>
                        <form name="_xclick " action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
                           <input type="hidden" name="cmd" value="_xclick">
                           <input type="hidden" name="business" value="<?php echo $paypal_info['paypal_url'] ?>">
                           <input type="hidden" name="currency_code" value="USD">
                           <input type="hidden" id="return_data" name="return" value="<?= base_url();?>/thankyou/<?= $zoneid ?>?bid_amount=10&busid=<?= $businessid;  ?>&zoneid=<?= $zoneid;  ?>&business_name=<?= $business->name;?>&user_type=business"> 
                           <input type="hidden" name="cancel_return" value=""> 
                           <input type="hidden" name="item_name" value="Savingssites Order">
                           <input type="hidden" id="paypalamount" name="amount" value="30">
                           <input type="image"  border="0" name="submit" onerror="this.style.display='none'"/ > 
                        </form>
                        <?php } ?>
                     </fieldset>
                  </div>
               </div>
            </div>
         </div>
         <div id="bidhidediv" class="hide">
            <?php 
               if(isset($_GET['pay']) && $_GET['pay'] == 1){
                  echo '<h1>Thank you</h1><h3>You are Bid Successfully</h3>';
               }else{
                  echo '<h3>You Have Already  Bid, try next month</h3>';
               }
            ?>
         </div>
      </div>
    </div>
  </div>
</div>
</div>
