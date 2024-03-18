<div class="page-wrapper main-area toggled">
  <div class="container">
    <div class="row" style=" margin-bottom: 80px;">



      <div class="container" id="createdealdiv">
        <!-- MultiStep Form -->
        <div class="viewads" id="grad1">
          <div class="row justify-content-center mt-0">
            <div class="col-sm-6 col-md-12 text-center">
              <div class="card">
                <input type="hidden" id="ad_id" name="ad_id" value="-1" />
                <input type="hidden" id="adid" name="adid" value="-1" />
                <input type="hidden" id="business_id" name="business_id" value="<?php echo $businessid; ?>" />
                <input type="hidden" id="businessid" name="businessid" value="<?php echo $businessid; ?>" />
                <input type="hidden" id="pagesidebar" name="pagesidebar" value="<?php echo $pagesidebar; ?>" />
                <input type="hidden" id="business_name" name="business_name" value="" />
                <input type="hidden" id="zoneid" name="zoneid" value="<?php echo $zone_id; ?>" />
                <input type="hidden" id="fromzoneid" name="fromzoneid" value="<?php echo $zone_id; ?>" />
                <input type="hidden" name="uploadedInput" id="uploadedInput" value="" /><br />
                <input type="hidden" name="multiuploadedInput" id="multiuploadedInput" value="" />
                <input type="hidden" id="docs_pdf" name="docs_pdf" />
                <label id="docs_pdf_foodmenu" name="docs_pdf_foodmenu"></label>
                <input type="hidden" id="ad_starttime" name="ad_starttime" class="w_100" value="12:00 am" style="margin-top: 10px;" />
                <input type="hidden" id="ad_stoptime" name="ad_stoptime" class="w_100" value="11:59 pm" />
                <h2><strong>Make New Advertisement</strong></h2>
                <p>The advertisements you create in four easy steps will be visible on the Deals Page. You can also generate a shareable link to share your deals on social media.</p>
                <div class="row">
                  <div class="col-md-12 mx-0">
                    <form id="msform">
                      <!-- progressbar -->
                      <ul id="progressbar">
                        <li class="active" id="account"><strong>Ad Information</strong></li>
                        <li id="personal"><strong>Advertisement Categories</strong></li>
                        <li id="payment"><strong>Advertisement Photos</strong></li>
                        <li id="social"><strong>Social Media Sharing</strong></li>
                        <!-- <li id="confirm"><strong>Other Information</strong></li> -->
                      </ul>
                      <!-- fieldsets -->
                      <fieldset>
                        <div class="form-card">
                          <h2 class="fs-title">Ad Information</h2>
                          <div class="form-area">
                            <ul id="tabs-nav">
                              <li class="active"><a href="#tab02">Ad editor</a></li>
                            </ul>
                            <div id="tab02" class="tab-content">
                              <span class="fleft dis_block">
                                <textarea id="stater_ad_message" name="stater_ad_message">
                                   <p align="center" class="MsoNormal" style="text-align: center;"><b><span  style="font-size: 18.0pt; color: #1F497D;">We have not had a chance to post all our offers in the system-<br><br>Please Contact Us for Our Offer!</span></b><br><br><br><span style="color:#000; font-size:20px">If you would like SavingsSites to contact the business on your behalf to ask them to post their offer, </span><span style="font-size:18px"><a href="#starter-ad-popup" style="text-decoration: underline;" class="starter_ad_click"><span style="color:red">click here</span></a></span></p>
                                 </textarea>
                                <? //= display_ckeditor($ckeditor_staterad); 
                                ?>
                              </span>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <label for="name">Start Date Time</label>
                              <input autocomplete="off" type="text" id="ad_startdatetime" name="ad_startdatetime" placeholder="Start Date Time">
                            </div>
                            <div class="col-md-6">
                              <label for="name">Stop Date Time</label>
                              <input type="text" id="ad_stopdatetime" name="ad_stopdatetime" placeholder="Stop Date Time" autocomplete="off">
                            </div>
                            <!-- <div class="col-md-12">
                                 <label for="name">Deal Restriction</label>
                                 <textarea class="form-control form-control-sm mb-3" id="deal_restriction" rows="3"></textarea>
                                 <span id="text200">200 characters left</span>
                              </div> -->
                          </div>
                        </div>
                        <input type="button" name="next" class="next action-button cus-btn" value="Next Step" />
                      </fieldset>
                      <fieldset>
                        <div class="form-card">
                          <p>The sub-categories marked with 'Ads present in this sub-category' means that there are some ads present within those sub-categories in the business.
                            If the ads created with those sub-categories then the newly created ad will be considered as 'Inactive Advertisement'. Inactive ads are viewable under Inactive Advertisement Tab in 'View Advertisements' section.
                          </p>
                          <div class="col-md-12">
                            <label for="name">Category *</label>
                            <table class="" id="categoryTable" width="700px" border="1" cellspacing="0" cellpadding="0" style="margin-top:10px; margin-bottom:0; overflow:scroll;">
                              <tbody>
                                <tr>
                                  <td style="font-weight: 700;color: #fff;background-color: #5346a2;"><input checked class="optioncategory" data-id="Restaurants" id="ad_category_fromshowad" name="ad_category_fromshowad" type="checkbox" value="1" style="margin: 0 10px;">Restaurants</td>
                                </tr>
                              </tbody>
                            </table>
                            <div>
                              <label for="name" class="answer">Show Sub-Categories Images</label>
                              <label class="switch">
                                <input type="checkbox" checked id="subcatimagebutton" value="1">
                                <span class="slider round" id="subcatimagecheck"></span>
                              </label>
                            </div>
                            <label for="name" class="answer">Sub-Categories</label>
                            <?php
                            foreach ($subcatnew as $k => $v) {
                              echo '<div class="category_div"><ul>';
                              echo '<li>' . $k . '</li>';
                              foreach ($v as $k1 => $v1) {
                                echo '<li><input class="optiondcheckbox" type="checkbox" name="subcat[]" value="' . $v1['subsubid'] . '"/>' . $v1['subsubname'] . '</li>';
                              }
                              echo '</ul></div>';
                            }
                            ?>
                            <table class="display responsive-table answer" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th scope="col" style="text-align: center;">We Deliver</th>
                                  <th scope="col">Show reservation for this</th>
                                  <!-- <th scope="col">Show menu tab for this ad?</th> -->
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>
                                    <div class="food_menu">
                                      <input class="wdeliver" type="radio" data-zoneid="213" name="deliver" id="yes" value="1" style="position: relative;" onclick="show2();"> Yes
                                      <input type="radio" data-zoneid="213" name="deliver" id="no" value="0" checked="checked" style="    position: relative;margin-left: 20px;" onclick="show1();"> No
                                    </div>


                                  </td>
                                  <td><input type="checkbox" value="1" name="showreservation" id="showreservation" style="margin-top: 10px;"></td>
                                  <!-- <td><input type="checkbox" value="1" name="showmenutab" id="showmenutab" style="margin-top: 10px;"></td> -->
                                </tr>
                              </tbody>
                            </table>
                            <div class="showonyes hide" id="div1">
                              <label>What is the furthest number of miles from your Restaurant that you deliver?</label>
                              <input type="text" name="miles" class="miles_estimate" placeholder="Number of Miles:">
                              <label>Delivery Charges</label>
                              <input type="text" name="deliveryCharges" class="deliveryCharges" placeholder="delivery Charges:">
                            </div>

                          </div>
                        </div>
                        <input type="button" name="previous" class="previous action-button-previous cus-btn" value="Previous" />
                        <input type="button" name="next" class="next action-button cus-btn" value="Next Step" />
                      </fieldset>
                      <fieldset>
                        <div class="form-card">
                          <main class="main_full">

                            <div class="container">
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="panel">
                                    <h2>Advertisement Photo</h2>
                                    <div class="button_outer">
                                      <div class="btn_upload">
                                        <input type="file" id="card_img" onchange="loadFile(event)" name="imgfile" accept="image/*">Upload Image
                                      </div>
                                      <div class="processing_bar"></div>
                                      <div class="success_box"></div>
                                    </div>
                                    <p>Uploaded photo will show in directory page.</p>
                                  </div>
                                  <div style="width: 100%;" id="showdiv">
                                    <img id="output" class="hide" style="width: 100%;max-height: 300px;">
                                    <div id="show_banner">

                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-6">

                                  <div class="panel">
                                    <h2>Additional Photos</h2>
                                    <div class="button_outer">
                                      <div class="btn_upload">
                                        <input type="file" id="upload_file" name="imgfile" accept="image/*">
                                        Upload Image
                                      </div>
                                      <div class="processing_bar"></div>
                                      <div class="success_box"></div>
                                    </div>
                                    <p>Additional photos will show in directory page photos section.</p>
                                  </div>
                                  <div style="width: 100%;" id="showdiv">
                                    <div id="show_bannermulti">
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </main>
                        </div>
                        <input type="button" name="previous" class="previous action-button-previous cus-btn" value="Previous" />
                        <input type="button" name="next" class="next action-button cus-btn" value="Next Step" />
                      </fieldset>
                      <fieldset>
                        <div class="form-card social-share">
                          <div class="row">
                            <div class="col-md-6">
                              <label>Deal Title</label>
                              <input type="text" name="search_engine_title" id="search_engine_title">
                              <span class="genarate_url">Generate Deal Title</span>
                            </div>
                            <div class="col-md-6">
                              <label>Short Description</label>
                              <input type="text" name="short_description" id="short_description">
                            </div>
                          </div>


                        </div>
                        <input type="button" name="previous" class="previous action-button-previous cus-btn" value="Previous" />
                        <input type="button" id="create_ad" name="finish" class="finish action-button cus-btn" value="Finish" />
                      </fieldset>
                      <!-- <fieldset>
                        <div class="form-card cus-box">
                           <p class="form-group-row">
                              <label for="video_fromshowad" class="fleft w_200">You tube video url</label>
                              <input type="text" class="fleft" id="video_presentation" name="video_presentation" onblur="youtubeUrlValidation($(this).val())" value="">
                           </p>
                           <p class="form-group-row" >
                              <label for="textmeoffertext" class="fleft w_200">Text Me This Offer text<br /></label>
                              <input type="hidden" value="" id="bus_name" />
                              <textarea class="fleft" rows="3" cols="45" id="textmeoffertext" onblur="text_me()" name="textmeoffertext" ></textarea>

               

               <div id="characterLeft3" style="color:#000" class="max-char-text bolt"></div>

              </p>  
                        </div>
                        <input type="button" name="previous" class="previous action-button-previous cus-btn" value="Previous"/>
                        <input type="button" id="create_ad" name="finish" class="finish action-button cus-btn" value="Finish"/>
                     </fieldset> -->
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<script type="text/javascript">
  $('#ad_startdatetime').datetimepicker();
  $('#ad_stopdatetime').datetimepicker();
</script>