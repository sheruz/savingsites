<div class="page-wrapper main-area toggled myzonebusinesses">
  <div class="container">
    <div class="row" style=" margin-bottom: 80px;">
      <div class="top-title">
        <h2> My Zone Businesses </h2>
        <p>Displays the businesses currently available in this zone</p>
        <hr class="center-diamond">
      </div>
      <div class="container_filter bv_trial_biz" id="trial_biz">
        <div align="" class="bus_search_tbntc_active">
          <select class="selectoption" id="catoption">
            <option value="name">Name</option>
            <option value="category">Category</option>
            <option value="subcategory">SubCategories</option>
          </select>
          <input type="text" id="text_bus_search" name="text_bus_search" placeholder="Search Name ..." style="width: 260px; display: none;">
          <select class="categorylist" style="display: inline-block;" id="selectcatsubcat">
            <option value="0">Select Category</option>
            <option value="2">Auto Buy/Srvc</option>
            <option value="3">B 2 B</option>
            <option value="4">Clothing</option>
            <option value="6">Contractors</option>
            <option value="7">Education</option>
            <option value="8">Events</option>
            <option value="11">Financial</option>
            <option value="9">Health</option>
            <option value="10">Home &amp; You</option>
            <option value="12">Medical</option>
            <option value="1">Restaurants</option>
            <option value="13">Travel &amp; Lodging</option>
          </select>
          <button class="btn-sm  btn_bus_search_by_names" type="button" id="searcatsubcats">Search</button>
          <select name="bus_search_results" id="bus_search_results" style="width: 100px;">
            <option value="contains">Contains</option>
            <option value="startwith">Starts With </option>
          </select>
          <select name="bus_search_by_alphabet" id="bus_search_by_alphabet">
            <option value="-1">By Alphabetical Order</option>
            <option value="all">ALL</option>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
            <option value="E">E</option>
            <option value="F">F</option>
            <option value="G">G</option>
            <option value="H">H</option>
            <option value="I">I</option>
            <option value="J">J</option>
            <option value="K">K</option>
            <option value="L">L</option>
            <option value="M">M</option>
            <option value="N">N</option>
            <option value="O">O</option>
            <option value="P">P</option>
            <option value="Q">Q</option>
            <option value="R">R</option>
            <option value="S">S</option>
            <option value="T">T</option>
            <option value="U">U</option>
            <option value="V">V</option>
            <option value="W">W</option>
            <option value="X">X</option>
            <option value="Y">Y</option>
            <option value="Z">Z</option>
          </select>
          <button class="btn-sm businesscheck" id="search_business" type="button" style="">Search</button>
        </div>
        <div class="bus_search_tbntc_deactive" style="display:none;">
          <input type="text" id="text_bus_search_tbntc_deactive" name="text_bus_search_tbntc_deactive" placeholder="Direct search by business name, phone " style="width:260px;">
          <button class="btn-sm" id="btn_bus_search_by_name_tbntc_deactive" type="button">Search</button>
          <strong>Search Your Businesses </strong>
          <select name="select_bus_search_tbntc_deactive" id="select_bus_search_tbntc_deactive">
            <option value="-1">By Alphabetical Order</option>
            <option value="all">ALL</option>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
            <option value="E">E</option>
            <option value="F">F</option>
            <option value="G">G</option>
            <option value="H">H</option>
            <option value="I">I</option>
            <option value="J">J</option>
            <option value="K">K</option>
            <option value="L">L</option>
            <option value="M">M</option>
            <option value="N">N</option>
            <option value="O">O</option>
            <option value="P">P</option>
            <option value="Q">Q</option>
            <option value="R">R</option>
            <option value="S">S</option>
            <option value="T">T</option>
            <option value="U">U</option>
            <option value="V">V</option>
            <option value="W">W</option>
            <option value="X">X</option>
            <option value="Y">Y</option>
            <option value="Z">Z</option>
          </select>
          <button class="btn-sm" id="btn_bus_search_by_alphabet_tbntc_deactive" type="button">Search</button>
        </div>
      </div>
    </div>
    <div class="row" style="position: relative;">
      <!-- <button class="down_data">Download Data</button> -->
      <table class="display responsive-table datatable-all" cellspacing="0" width="100%" id="myzonebusinesstable">
        <thead>
          <tr>
            <th scope="col">Business Id</th>
            <th scope="col">Business Name</th>
            <th scope="col">Contact Name</th>
            <th scope="col">Telephone</th>
            <th scope="col" style="width: 15%;">Zip Code</th>
            <th scope="col" style="width: 20%;">Action</th>
            <!-- <th scope="col">Select/Deselect All <input type="checkbox"></th> -->
          </tr>
        </thead>
        <tbody id="myzonebusinesdata"> <?php foreach ($businessArr as $bk => $bv) { ?> <tr>
            <th> <?= $bv->id; ?> </th>
            <td> <?= $bv->name; ?> </td>
            <td> <?= $bv->contactfirstname.' '.$bv->contactlastname; ?> </td>
            <td> <?= $bv->phone; ?> </td>
            <td> <?= $bv->zip_code; ?> </td>
            <td> <?php if($bv->busadid){ ?> <a href="
                      <?= base_url();?>/Zonedashboard/viewads/
                      <?= $zone_id; ?>?page=viewads&busid=
                      <?= $bv->id; ?>" class="tab_icon green" target="_blank">
                <b> AD</b>
              </a>
              <span>
                <i class="fa fa-id-card editdealpge" busid="
                        <?= $bv->id; ?>" aria-hidden="true">
                </i>
              </span>
              <a href="javascript:void(0)" class="tab_icon red">
                <i busid="
                        <?= $bv->id; ?>" class="fa fa-trash deletebuisness" aria-hidden="true">
                </i>
              </a> <?php }
             ?>
            </td>
            <!-- <td><input type="checkbox"></td><?= $bv->name; ?> -->
          </tr> <?php } ?> </tbody>
      </table>
    </div>
    <div class="container hide" id="createdealdiv" style="position: absolute;top: 65%;left: 20%;">
      <div class="row">
        <div class="col-md-12">
          <p id="closedeal">Close <i class="fa fa-window-close" aria-hidden="true"></i>
          </p>
          <div id="tab1" class="tab-content">
            <div class="top-title">
              <h2> Update Business Detail</h2>
              <hr class="center-diamond">
            </div>
            <div id="help_shot" class="container_tab_header header-default-message bv_help_shot" margin-top:10px;>
              <p>Update your business details on this page. Click the Save button to submit your changes.</p>
            </div> <?php //foreach ($businessArr as $bk => $bv){ //echo "<pre>";print_r($bv); ?> 
            <input type="hidden" id="biz_address_id" value="
                        <?//=$bv->addressid?>" />
            <input type="hidden" id="biz_owner_id" value="
                          <?//=$bv->businessownerid?>" />
                          <input type="hidden" name="businessid" id="businessid" value="<?//=$bv->id;?>">
            <input type="hidden" id="biz_zone_ids" name="biz_zone_ids" value="
                            <?= $zoneid;?>" /> <?php //} ?> <div class="row">
              <div class="col-lg-6">
                <p class="form-group-row busines_col">
                  <label for="email" class="fleft w_200">Business Name <span style="color:red">*</span>
                  </label>
                  <input type="text" id="biz_name" name="biz_name" class="w_53601" value=" " />
                <div id="error_contact_name"></div>
                </p>
                <p class="form-group-row">
                  <label for="restaurant_type" class="fleft w_200">Business Type</label>
                  <select id="restaurant_type" class="fleft w_315">
                    <option value="1" selected="selected">Restaurant</option>
                    <option value="0" selected="selected">Non Restaurant</option>
                  </select>
                </p>
                <p class="form-group-row">
                  <label for="biz_motto" class="fleft w_200">Motto/Slogan</label>
                  <textarea id="biz_motto" name="biz_motto" class="w_53601">
                                    <?//=stripslashes($business->motto)?>
                                  </textarea>
                </p>
                <p class="form-group-row">
                  <label for="biz_about" class="fleft w_200">About Us <br />
                  </label>
                  <textarea id="biz_about" name="biz_about" class="w_53601">
                                    <?//=stripslashes($business->aboutus)?>
                                  </textarea>
                </p>
                <p class="form-group-row">
                  <label for="biz_contact_email" class="fleft w_200">Contact Email <span style="color:red">*</span>
                  </label>
                  <input type="text" id="biz_contact_email" name="biz_contact_email" class="w_53601" value="
                                    <?//=$adsemail;?>" />
                <div id="error_contact_email"></div>
                </p>
                <div style="margin-left: 200px;display:none;  background-color: wheat; height: 25px; border-radius: 7px;width: 245px;" id="email_notice">
                  <span style="color:red;  margin-left: 12px;" /> Please enter valid Email address </span>
                </div>
                <p class="form-group-row">
                  <label for="biz_contactfirstname" class="fleft w_200">Contact First Name <span style="color:red">*</span>
                  </label>
                  <input type="text" id="biz_contactfirstname" name="biz_contactfirstname" class="w_53601" value="
                                    <?//=$adsfirstname?>" />
                <div id="error_contact_firstname"></div>
                </p>
                <p class="form-group-row">
                  <label for="biz_contactlastname" class="fleft w_200">Contact Last Name <span style="color:red">*</span>
                  </label>
                  <input type="text" id="biz_contactlastname" name="biz_contactlastname" class="w_53601" value="
                                      <?//=$adslastname?>" />
                <div id="error_contact_lastname"></div>
                </p>
                <p class="form-group-row" style="display:none">
                  <label for="biz_contactfullname" class="fleft w_200">Contact Full Name <span style="color:red">*</span>
                  </label>
                  <input type="text" id="biz_contactfullname" name="biz_contactfullname" class="w_53601" value="
                                        <?//=$adsfirstname.' '.$adslastname?>" />
                <div id="error_contact_fullname"></div>
                </p>
                <p class="form-group-row">
                  <label for="biz_street_1" class="fleft w_200">Street Address <span style="color:red">*</span>
                  </label>
                  <textarea id="biz_street_1" name="biz_street_1" class="w_53601">
                                          <?//=$adsaddress_1?>
                                        </textarea>
                <div id="error_contact_address"></div>
                </p>
              </div>
              <div class="col-lg-6">
                <p class="form-group-row">
                  <label for="biz_street_2" class="fleft w_200">Mailing Address (if different)</label>
                  <textarea id="biz_street_2" name="biz_street_2" class="w_53601"></textarea>
                </p>
                <p class="form-group-row">
                  <label for="biz_city" class="fleft w_200">City </span>
                  </label>
                  <input type="text" id="biz_city" name="biz_city" class="w_53601" value="
                                        <?//=$adscity?>" />
                <div id="error_city"></div>
                </p>
                <p class="form-group-row">
                  <label for="biz_zip_code" class="fleft w_200">Zip Code:</label>
                  <select class=" " name="postalcode" id="postalcode">
                    <option value="-1">--Select Zip Code--</option>
                    <option selected id="postalcode" value=" ">
                      <?= isset($adszip_code); ?>
                    </option>
                  </select>
                </p>
                <p class="form-group-row">
                  <label for="biz_about" class="fleft w_200">History <br />
                  </label>
                  <textarea id="biz_history" name="biz_history" class="w_53601"></textarea>
                </p>
               <p>
                  <label for="biz_phone" class="fleft w_200">Phone Number (shows in ads) <span style="color:red">*</span>
                  </label>
                  <input type="text" id="biz_phone" name="biz_phone" class="w_53601" value="
                                          <?//=$adsphone;?>" placeholder="Enter # (e.g. 555-XXX-XXXX)" />
                </p>
                <p class="form-group-row">
                  <label for="atbiz_phone" class="fleft w_200">Alternative Phone Number</label>
                  <input type="text" id="albiz_phone" name="albiz_phone" class="w_536" value="
                                            <?php if(!empty($alternate_phone)) echo $alternate_phone;?>" placeholder="Enter # (e.g. 555-XXX-XXXX )" />
                </p>
                <p class="form-group-row">
                  <label for="biz_website" class="fleft w_200">Website</label>
                  <input type="text" id="biz_website" name="biz_website" class="w_53601" value=" " />
                </p>
                <p class="form-group-row">
                  <label for="biz_sic" class="fleft w_200">ServiceNumber(Amazon Contact number)</label>
                  <input style="height:40px;" type="number" id="service_number" name="service_number" class="w_53601" value="
                                                <?//=$adsservice_number?>" />
                </p>
              </div>
            </div>
            <div style="display: none;">
              <p class="form-group-row">
                <label for="city" class="fleft w_200  m_top_0i">Business Presentation</label>
                <input type="checkbox" name="biz_audio_presentation" id="biz_audio_presentation" value="
                                                          <?//=$adsaudio_presentation?>" <? //if($adsaudio_presentation==1){ echo 'checked';} ?> />MP3 Audio <input type="checkbox" name="biz_video_presentation" id="biz_video_presentation" value="
                                                            <?//=$adsvideo_presentation?>" <? //if($adsvideo_presentation==1){ echo 'checked';} ?> />You Tube Video
              </p>
            </div>
            <div style="display: none;">
              <label for="biz_type" style="display:none;">Business Type:</label>
              <select id="biz_type" name="biz_type" style="display:none;float: right;margin-right: 34px;width: 306px;margin-top: 10px">
                <option value="1" <?php //if($business_type['approval']==1) echo 'selected'?>>Active Paid </option>
                <option value="-1" <?php //if($business_type['approval']==-1) echo 'selected'?>>Deactive Paid </option>
                <option value="2" <?php //if($business_type['approval']==2) echo 'selected'?>>Active Trial </option>
                <option value="-2" <?php //if($business_type['approval']==-2) echo 'selected'?>>Deactive Trial </option>
              </select>
              <label for="peration_hours" class="fleft w_200">Operation Hours:</label>
              <br />
              <h5 style="margin-left: 188px;"></h5>
            </div>
            <div style="display: none;">
              <br>
              <label for="new_pass" class="fleft w_200">Appointment: </label>
              <textarea id="business_appointment" class="" value="">
                                                              <?//= isset($operation[0]['business_appointment'])?$operation[0]['business_appointment']:''; ?>
                                                            </textarea>
              <br />
              <label for="new_pass" class="fleft w_200">Monday: </label>
              <input type="hidden" id="monday_active" class="active_days" value="" />
              </p>
              <div <?php if(!empty($zone_owner)){echo 'style="display:block;"';}else{echo 'style="display:none;"';}?>>
                <label for="business_owner" style="width:150px; float:left; display:block; padding-right:10px;">Business Owner:</label>
                <select style="width:300px;" name="business_owner" id="business_owner" onchange="create_bus_owner(this.value);return false;">
                  <option value="-1">--- Create New Account---</option>
                </select>
                <br />
                <div style="display:none;" id="new_user_detail">
                  <label for="userName" style="width:150px; float:left; display:block; padding-right:10px;">Username:</label>
                  <input style="width:300px;" class="fleft w_150" id="userName" name="userName" />
                  <br />
                  <label for="password" style="width:150px; float:left; display:block; padding-right:10px;">Password:</label>
                  <input style="width:300px;" class="fleft w_150" id="password" name="password" />
                  <br />
                </div>
              </div>
              <br />
              <br clear="all" /> <?=form_close()?>
              <!--<button onclick="saveBusinessInfo();" style="margin-left:200px;" id="save_business_info" name="save_business_info">Save</button>-->
              <button onclick="saveBusinessInfo();" style="margin-left:200px;" id="save_business_info" name="save_business_info">Save</button> <?php //if($condition_1!=3){ ?> <div>
                <h4 class="cus-business-h4">Any changes does not effect your Peekaboo account.To change <span style="cursor:pointer; color:red" onclick="peekaboo_access_button('login')">click here</span>
                </h4>
              </div> <?php // } ?>
            </div>
            <div class="col-md-12">
              <button class="fright w_200 cus-btn" type="button" id="update_business">Update Business</button>
            </div>

    </div>
  </div>
</div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
        // setTimeout(function(){
        // var table = $('#myzonebusinesstable').DataTable({ 
        //         select: false,
        //         "columnDefs": [{
        //             className: "Name", 
        //             "targets":[0],
        //             "visible": false,
        //             "searchable":false
        //         }]
        //     });}, 200);
        // });
</script>