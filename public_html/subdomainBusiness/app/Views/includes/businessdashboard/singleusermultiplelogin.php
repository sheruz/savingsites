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
            <h2><strong>Multiple Login Single User</strong></h2>
            <p>When a user logs in using the same phone number and email, there's no need to log in again when accessing other branches, be it as a resident, business, organization, visitor, or employee.</p>
            <div class="row">
               <div class="col-md-12 mx-0">
                  <div id="msform">
                     <fieldset>
                        <div class="form-card" style="height: 210px;">
                           <ul>
                              <?= $buttonhtml; ?>
                           </ul>  
                        </div>
                        <input type="hidden" id="payzoneid" value="<?= $zoneid; ?>" />
                        <input type="hidden" id="paybusid" value="<?= $businessid; ?>"/>
                        <input type="hidden" id="paybusname" value="<?= $business->name; ?>"/>
                        <input type="hidden" id="user_type" value="businessbid"/>
                        
                     </fieldset>
                  </div>
               </div>
            </div>
         </div>
      </div>
    </div>
  </div>
</div>
</div>
