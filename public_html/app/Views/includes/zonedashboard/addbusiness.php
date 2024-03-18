<div class="page-wrapper main-area toggled addbuss">
	<div class="container">
    <div class="row">
            <div class="top-title">
        <h2> Create New Business</h2>
         <hr class="center-diamond">
      </div>
      <span class="red">(*)These fields are required </span>
      <div class="row">

      <form id="businessForm" action="business.php" method="post">
        
        <fieldset>
          <div class="row">
        <div class="col-md-6">
            <label for="name">Business Name:<span class="red">*</span></label>
          <input type="text" id="biz_name" name="biz_name">
        </div>
        <div class="col-md-6">
          <label for="name">Motto/Slogan:</label>
          <input type="text" id="biz_moto" name="biz_moto">
        </div>
        </div>

        <div class="row">
        <div class="col-md-6">
          <label for="name">About Us:</label>
          <input type="text" id="biz_about" name="biz_about">
        </div>

        <div class="col-md-6">
          <label for="name">Contact Email:<span class="red">*</span></label>
          <input type="email" id="biz_mail" name="biz_mail">
        </div>
        </div>

          <div class="row">
        <div class="col-md-6">
          <label for="name">Contact First Name:<span class="red">*</span></label>
          <input type="text" id="biz_firstname" name="biz_firstname">
        </div>
        <div class="col-md-6">
          <label for="name">Contact Last Name:<span class="red">*</span></label>
          <input type="text" id="biz_lastname" name="biz_lastname">
        </div>
        </div>

         <div class="row">
        <div class="col-md-6">
          <label for="name">Street Address:</label>
          <input type="text" id="biz_address" name="biz_address">
        </div>
        <div class="col-md-6">
          <label for="name">City:</label>
          <input type="text" id="biz_city" name="biz_city">
        </div>
        </div>

        <div class="row">
        <div class="col-md-6">
          <label for="name">State:</label>
          <select id="biz_state" class="biz_state select2">
          <?php
            foreach ($state_list as $k => $v) {
            echo '<option value="'.$k.'">'.$v.'</option>';
              
            }
          ?>
        </select>
        </div>
        <div class="col-md-6">
          <label for="name">Zip Code:<span class="red">*</span></label>
          <input type="text" id="biz_zip" name="biz_zip">
        </div>
        </div>

         <div class="row">
        <div class="col-md-6">
          <label for="name">Phone Number:<span class="red">*</span></label>
          <input type="text" id="cell_phone" name="cell_phone">
        </div>
        <div class="col-md-6">
          <label for="name">Alternative Phone Number:</label>
          <input type="text" id="cell_phonealternate" name="cell_phonealternate">
        </div>
        </div>

         <div class="row">
        <div class="col-md-6">
          <label for="name">Website:</label>
          <input type="text" id="biz_website" name="biz_website">
        </div>
        <div class="col-md-6">
          <label for="name">Business Type:</label>
          <select id="business_is_restaurant">
            <option value="1">Restaurant</option>
            <option value="0">Non Restaurant</option>
          </select>
        </div>
        </div>
<div class="row buss-head"><h3>Business Advertiser Details</h3></div>
        <div class="row">
        <div class="col-md-12 col-lg-5">
          <label for="name">Username:</label>
          <input type="text" id="biz_username" name="biz_username">
        </div>
        <div class="col-md-12 col-lg-5">
          <label for="name">Password:<span class="red">*</span></label>
          <input type="text" id="biz_password" name="biz_password"  placeholder="Specify Password">
          <span class="red">Case sensitive, combination of 5-18 letters, numbers and special characters (!, @, #, $, %, &)</span>
         
        </div>
        <div class="col-md-12 col-lg-2">
           <button id="create_generate_password" class="cus-btn" type="button">Generate Password</button>
        </div>
        </div>

        <div class="row buss-head"><h3>Business Advertisement Details</h3></div>
        <div class="row" style="display: none;">
          <div class="col-md-12">
            <label for="biz_mode" class="fleft w_200 m_top_0i">Business Mode</label>
            <input type="radio" name="biz_mode" id="biz_mode_normal" value="1" checked="checked">Non Business Opportunity Providers
          </div>
        </div>


      














        <div class="row">




        <div class="col-md-4">
          <label for="name">Business Advertisement Details</label>
          <select id="biz_type" class="fleft w_315">
    <option value="2">Viewable Free Trial</option>
    <option value="1">Viewable Paid</option>
      </select>
        </div>
        <div class="col-md-4">
          <label for="name">Main Category:</label>
            <select class="w_315" id="main_category">
            <option class="normal" value="1">Restaurants </option>
          </select>
        </div>

          <div class="col-md-4">
          <label for="name">
          <ul class="cus-form-list">
            <li>Subcategories :</li>
            <li style="text-align: right;">Select All <input type="checkbox" id="subcat"/></li>
          </ul>

           </label>

            <select class="w_315" id="sub_category" multiple>
            <option class="normal" value="1"> American </option>
          </select>
        </div>

        </div>

        <div class="row">
        <div class="col-md-12">
          <label for="name">Starter Ad:<span class="red">*</span></label>
         <span class="fleft dis_block">                      
                      <textarea id="stater_ad_message" name="stater_ad_message" >
                        <p align="center" class="MsoNormal" style="text-align: center;"><b><span  style="font-size: 18.0pt; color: #1F497D;">We have not had a chance to post all our offers in the system-<br><br>Please Contact Us for Our Offer!</span></b><br><br><br><span style="color:#000; font-size:20px">If you would like SavingsSites to contact the business on your behalf to ask them to post their offer, </span><span style="font-size:18px"><a href="#starter-ad-popup" style="text-decoration: underline;" class="starter_ad_click"><span style="color:red">click here</span></a></span></p>
                      </textarea>
                      <?//= display_ckeditor($ckeditor_staterad); ?> 
                    </span>
        </div>

        <div class="row middle-row">
        <div class="col-md-6">
          <label for="name">Start Date Time</label>
            <input type="text" id="ad_startdatetime" name="ad_startdatetime" placeholder="Start Date Time" autocomplete="off">
        </div>
        <div class="col-md-6">
          <label for="name">Stop Date Time</label>
            <input type="text" id="ad_stopdatetime" name="ad_stopdatetime" placeholder="Stop Date Time" autocomplete="off">
        </div>
        </div>

        <div class="row" style="margin-top:20px;">
        <div class="col-md-12 d-none delivery">
          <label for="name">What is the furthest<br> number of miles from your Restaurant that you deliver?</label>
          <input type="text" name="miles" id="estimated_mile" value=" " placeholder="Number of Miles: "  />
        </div>
        </div>

        <div class="row">
        <div class="col-md-6 d-none delivery">
          <label for="name">Delivery Charges</label>
          <input type="number" name="deliveryCharges" class="deliveryCharges" id="deliveryCharges" placeholder="delivery Charges:">
        </div>
        <div class="col-md-6 d-none delivery">
          <label for="name">Delivery Time Period</label>
         <select name="deliveryTime" id="deliveryTime">
                      <option value="">Select the Delivery Time</option>
                      <?php for ($i = 0; $i <= 120; $i+=10) { ?>
                          <option value="<?php  echo $i; ?>"><?php  echo $i; ?> Minutes</option>   
                      <?php }  ?>  
                    </select>
        </div>
      </div>
        
        
        <div class="row">
                  <div class="col-md-6" id="image_upload_div">
          <label for="name">Upload Greetings(mp3, wav)</label>
       <!--    <input style="max-width: 100%!important;margin-right: 7px;" type="file" id="file" name="file" class="w_536"  value="" title="Greeting Format Must be MP3,WAV" onchange="javascript:uploadFile()"/>  -->
       <div class="form-group">
        <label for="fileField" class="attachment">
          <div class="row btn-file">
            <div class="btn-file__preview"></div>
            <div class="btn-file__actions">
              <div class="btn-file__actions__item col-xs-12 text-center">
                <div class="btn-file__actions__item--shadow">
                  <i class="fa fa-plus fa-lg fa-fw" aria-hidden="true"></i>
                  <div class="visible-xs-block"></div>
                  Select file
                </div>
              </div>
            </div>
          </div>
          <input name="file" type="file" id="fileField">
        </label>
      </div>
        </div>


         <div class="col-md-6">
          <label for="name">ServiceNumber(Amazon Contact number):</label>
          <input type="number" id="ServiceNumber" name="ServiceNumber">
        </div>

        </div>

<!--         <div class="row">
                    <div class="col-md-12">
          <label for="name">We Deliver :</label>
           <ul>
               <li>  
                <p>
                 <label for="test1" class="test1"> <input type="radio" id="yes" name="radio-group" class="delivery_check">
                 Yes</label>
                    </p>
                </li>
               <li>
                  <p>
                    <label for="test2" class="test2"><input type="radio" id="no" name="radio-group" class="delivery_uncheck" checked>
                     No</label>
                        </p>
               </li>
           </ul>
        </div>
        </div> -->
        <div class="row toggle-yesno">
          <div class="col-md-12">
            <label for="name">We Deliver :</label>
            <ul>
              <input type="checkbox" id="toggle" value="0">
            </ul>
          </div>
        </div>

        <div class="row delivery_hide" style="display: none;margin-top: 20px;">
          <div class="col-md-6">
            <label for="miles" class="fleft w_200">What is the furthest number of miles from your Restaurant that you deliver?  </label>
            <input type="text" name="miles" id="estimated_mile" value=" " placeholder="Number of Miles: "  /> <br/>
          </div>
          <div class="col-md-3">
            <label for="miles" class="fleft w_200">Delivery Charges  </label>
            <input type="text" name="deliveryCharges" class="deliveryCharges" placeholder="delivery Charges:">
          </div>
          <div class="col-md-3">
            <label for="miles" class="fleft w_200">Delivery Time Period  </label>
            <select name="deliveryTime" id="deliveryTime">
              <option value="">Select the Delivery Time</option>
              <?php for ($i = 0; $i <= 120; $i+=10) { ?>
                <option value="<?php  echo $i; ?>"><?php  echo $i; ?> Minutes</option>   
              <?php }  ?>  
            </select>
          </div>
        </div>
 </fieldset>
       
       <div class="submit_btn">
        <button type="button" id="create_business" class="cus-btn">Create Business</button>
        <button type="button" id="reset" class="cus-btn">Reset</button>
        </div>
        
       </form>

      </div>
      
  
		</div>
	</div>
</div>
<script type="text/javascript">
  $('#ad_startdatetime').datetimepicker();
  $('#ad_stopdatetime').datetimepicker();
</script>
