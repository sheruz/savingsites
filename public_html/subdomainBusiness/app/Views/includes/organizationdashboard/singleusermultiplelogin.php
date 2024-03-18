<input type="hidden" name="zoneid" id="zoneid" value="<?=$zoneid;?>" />
<input type="hidden" name="orgnid" id="orgnid" value="<?=$org_id;?>" />
<input type="hidden" name="orgzoneid" id="orgzoneid" value="<?=$fromzoneid;?>" />
<input type="hidden" name="org_id" id="org_id" value="<?=$org_id;?>" />
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
            <label id="docs_pdf_foodmenu" name="docs_pdf_foodmenu"></label>
             <input type="hidden" id="ad_starttime" name="ad_starttime" class="w_100"  value="12:00 am" style="margin-top: 10px;" />    
            <input type="hidden" id="ad_stoptime" name="ad_stoptime" class="w_100"  value="11:59 pm" />
            <h2><strong>Multiple Login Single User</strong></h2>
            <div class="row">
               <div class="col-md-12 mx-0">
                  <div id="msform">
                     <fieldset>
                        <div class="form-card" style="height: 210px;">
                           <ul>
                             <?= $buttonhtml; ?>
                           </ul>  
                        </div>
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
