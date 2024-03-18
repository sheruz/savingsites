<?php helper('form'); ?>
<div class="page-wrapper main-area toggled">
	<div class="container">
    <div class="row">
        <ul id="tabs-nav">
    <li><a href="#tab1">Zone Information</a></li>
    <li><a href="#tab2">Update Information</a></li>
    <li><a href="#tab3">Change Password</a></li>
    <li><a href="#tab5">Zone Logo</a></li>
    <li><a href="#tab6">Theme Color</a></li>
    <li><a href="#tab8">Discounts</a></li>
  </ul> 
    </div>
		<div class="row">
			<div class="tabs">

  <div id="tabs-content">
    <div id="tab1" class="tab-content">
       <div class="top-title">
        <h2>Zone Information</h2>
        <hr class="center-diamond">
      </div>
      <table>
        <thead>
          <tr>
            <th>Zone Name</th>
            <th><?= $zone_name?></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td data-column="First Name">Zone Owner</td>
            <td data-column="Last Name"><?= htmlentities(urldecode($zone_owner->first_name))?><?= htmlentities(urldecode($zone_owner->last_name)) ?>
            </td>
          </tr>

          <tr>
            <td data-column="First Name">Total Businesses</td>
            <td data-column="Last Name"><?=$total_business[0]['countbus']?></td>
          </tr>
          <?php if(!empty($total_ads)){ ?>
          <tr>
            <td data-column="First Name">Total Ads</td>
            <td data-column="Last Name"><?=$total_ads[0]['countad']?></td>
          </tr>

          <tr>
            <td data-column="First Name">Active Ads</td>
            <td data-column="Last Name"><?=$active_realad[0]['countad']?></td>
	        </tr>

          <tr>
            <td data-column="First Name">Inactive Ads</td>
            <td data-column="Last Name"><?=$inactive_realad[0]['countad']?></td>
	        </tr>
          <?php } ?>

          <tr>
            <td data-column="First Name">Zone Url</td>
            <td data-column="Last Name"><a target="_blank" href="<?=base_url();?>" style="color:#000;"><?=base_url();?></a>
            </td>
	        </tr>
        </tbody>
      </table>
    </div>

    <div id="tab2" class="tab-content">
        <div class="top-title">
        <h2>Update Zone Owner Information</h2>
         <hr class="center-diamond">
      </div>
      <div class="row">
        <div class="col-md-6 bv_align_center">
          <img src="https://cdn.savingssites.com/pexels-mati.jpg">
        </div>
        <div class="col-md-6 bv_zonetest_col">
          <div class="form-group center-block-table1 cus-zone-form">
            <div class="row">
              <div class="col-md-6">
              <p class="form-group-row">
                  <label for="username" class="fleft w_100 m_top_0i cus-user">Username : <b><?=$zone_owner->username?></b> </label>
                </p>

              </div>
              <div class="col-md-6">
            <p style="color:red" class="req-field">(*)These fields are required </p> 
              
                <input type="hidden" id="zone_id" name="zone_id" value="<?=$zone_id; ?>"/>
                <input type="hidden" id="userid" name="userid" value="<?=$zone_owner->id; ?>"/>
                <input type="hidden" id="username" name="username" value="<?=$zone_owner->username; ?>"/>

              </div>
            </div>
  
             <div class="row">
                  <div class="col-md-12">
                <p class="form-group-row">
                  <label for="email" class="fleft w_100">Email<span style="color:red">*</span></label>
                  <input type="text" id="jform_Email" name="jform_Email" class="w_300"  value="<?=$zone_owner->email?>" />
                </p>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                  <p class="form-group-row">
                  <label for="firstname" class="fleft w_100">First Name<span style="color:red">*</span></label>
                  <input type="text" id="jform_Firstname" name="jform_Firstname" class="w_300"  value="<?=$zone_owner->first_name?>" />
                </p>
                  </div>
                  <div class="col-md-6">

                <p class="form-group-row">
                  <label for="lastname" class="fleft w_100">Last Name<span style="color:red">*</span></label>
                  <input type="text" id="jform_Lastname" name="jform_Lastname" class="w_300" value="<?=$zone_owner->last_name?>" />
                </p>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">

                <p class="form-group-row">
                  <label for="phone" class="fleft w_100">Phone<span style="color:red">*</span></label>
                  <input type="text" id="jform_Phone" name="jform_Phone" class="w_300" value="<?=$zone_owner->phone?>" />
                </p>

                  </div>
                  <div class="col-md-6">
                    <p class="form-group-row">
                  <label for="address" class="fleft w_100">Address<span style="color:red">*</span></label>
                  <input type="text" id="jform_Address" name="jform_Address" class="w_300"  value="<?=$zone_owner->Address?>" />
                </p>
                  </div>
                </div>


                <div class="row">
                  <div class="col-md-6">
                <p class="form-group-row">
                  <label for="city" class="fleft w_100">City<span style="color:red">*</span></label>
                  <input type="text" id="jform_City" name="jform_City" class="w_300"  value="<?=$zone_owner->City?>" />
                </p>
                  </div>
                  <div class="col-md-6">
                <p class="form-group-row">
                  <label for="lastname" class="fleft w_100">State<span style="color:red">*</span></label>
                  <?= form_dropdown("State", $state_list, (!empty($zone_owner->State_Code) ? $zone_owner->State_Code : ''), 'id="jform_State" style="width:316px;"');?>
                </p>
                  </div>
                </div>


                <div class="row">
                  <div class="col-md-12">
                <p class="form-group-row">
                  <label for="zip1" class="fleft w_100">Zip<span style="color:red">*</span></label>
                  <input type="text" id="jform_Zip" name="jform_Zip" class="w_300"  value="<?=$zone_owner->Zip?>" />
                </p>
                  </div>
                </div>




                <p class="form-group-row  btn_new">
                  <label for="zip1">
                    <button onclick="UpdateProfile();return false;" class="m_left_100 cus-btn" name="update_profile">Update</button>
                  </label>
                </p>
              
            </div>
          </div>
        </div>
      </div>
      
      <div id="tab3" class="tab-content">
        <div class="top-title">
          <h2>Change Password</h2>
          <hr class="center-diamond">
        </div>
        <div class="row">
          <div class="col-md-6 change-pass-left">
            <h2>Passwords must contain:</h2>
            <li><i class="fa fa-check" aria-hidden="true"></i> Case sensitive</li>
            <li><i class="fa fa-check" aria-hidden="true"></i> Combination of 10-18 letters</li>
            <li><i class="fa fa-check" aria-hidden="true"></i> At least 1 Numbers (0,9)</li>
            <li><i class="fa fa-check" aria-hidden="true"></i> Special characters (!, @, #, $, %, &)</li>
          </div>
          <div class="col-md-6">
          <div class="form-group center-block-table cus-change-pass">
            <form id="user-form-password" class="form-validate fleft" enctype="multipart/form-data" name="adminForm" method="post" action="">
              <p>
                <label for="current_pass" class="fleft w_150">Current Password</label>
                <input type="password" class="w_300" id="current_pass" name="current_pass"  value="" />
              </p>
              
              <p>
                <label for="new_pass" class="fleft w_150">New Password</label>
                <input type="password" class="w_300" id="new_pass" name="new_pass"  value="" />
              </p>

              <p>
                <label for="confirm_pass" class="fleft w_150">Confirm Password</label>
                <input type="password" class="w_300" id="confirm_pass" name="confirm_pass"  value="" />
              </p>

              <p>
                <label for="zip1">
                  <button class="m_left_150 cus-btn" onclick="UpdatePassword();return false;">Update</button>
                </label>
              </p>
            </form>
            <div class="testingServer fleft new">
              <div class="message">
                
              </div>
            </div>
          </div>
        </div>
      
        </div>
      </div>
      
      <div id="tab5" class="tab-content">
       <div class="top-title">
          <h2>Zone Logo</h2>
          <hr class="center-diamond">
        </div>
        <form name="frm_banner" id="add_banner_forzone" method="post" enctype="multipart/form-data"  action="javascript:void(0);" class="uploader">
          <input id="imgfile" onchange="loadFile(event)" type="file" name="imgfile" accept="image/*" />
          <div class="row">
            <div class="col-md-6">          
              <label for="imgfile" id="file-drag">
            <img id="file-image" src="#" alt="Preview" class="hidden">
            <div id="start">
              <img src="https://cdn.savingssites.com/picture.png" style="width: 65px;">
              <div>Drop your image here or Browse Files</div>
              <div id="notimage" class="hidden">Please select an image</div>
              <span id="file-upload-btn" class="btn btn-primary">Browse Files</span>
            </div>
            <div id="response" class="hidden">
              <div id="messages"></div>
              <progress class="progress" id="file-progress" value="0">
                <span>0</span>%
              </progress>
            </div>
          </label></div>
            <div class="col-md-6">

          <div style="width: 100%;" id="showdiv">
            
            <img id="output" style="width: 100%;" class="hide">
            <div id="show_banner">
              <?php if(!empty($check_zone_logo[0]['image_name'])): ?>
                <!--<img src="https://cdn.savingssites.com/<?//=$check_zone_logo[0]['id']?>/<?//=$check_zone_logo[0]['image_name'];?>" style="width: 100%;">   -->
                <img src="https://cdn.savingssites.com/<?=$check_zone_logo[0]['image_name'];?>" style="width: 50%;">
              <?php endif; ?>
            </div>
          </div>
            </div>
          </div>

        <input type="submit" name="Submit" value="Submit" class="bttn zone-upload-submit cus-btn">
        </form>
      </div>

      <div id="tab6" class="tab-content">
       <div class="top-title">
        <h2>Theme Color</h2>
         <hr class="center-diamond">
      </div>
        <div class="theme_chang">
          <b>Select theme color for your site</b>:<br />
          <select id="themeChange" onchange="changeTheme()">
           <option <?php if ($theme_color->theme_color=="purple"){echo 'selected="selected"';} ?> value="purple">Fun Purple</option>

            <option <?php if ($theme_color->theme_color=="brown"){echo 'selected="selected"';} ?> value="brown">Cozy Brown</option>

            <option <?php if ($theme_color->theme_color=="green"){echo 'selected="selected"';} ?> value="green">Save Green</option>

            <option <?php if ($theme_color->theme_color=="blue"){echo 'selected="selected"';} ?> value="blue">Old Glory</option>
          </select>
          <p class="error_msg"></p>
        </div>
      </div> 
      
      <div id="tab8" class="tab-content">  
       <div class="top-title">
        <h2>Discounts</h2>
         <hr class="center-diamond">
      </div>   
        <div class="form-group center-block-table">
          <form action="" method="post">
            <div class="row" style="align-items: center;">

            <?php if($discountrate && $discountrate != '[]' ){ foreach (json_decode($discountrate) as $value) { ?>
              <div class="col-md-10 dynamic-field" id="dynamic-field-1">
                <div class="row" >                       
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="field" class="hidden-md">Discount(%)</label>
                      <input type="text" id="field" class="form-control" value="<?php echo $value->key ?>" name="field[]" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Number of Orders</label>
                      <input type="text" class="form-control" value="<?php echo $value->value ?>" name="order[]">
                    </div>
                  </div>
                </div>
              </div>
            <?php  } 
              }else{  ?>
                <div class="col-md-12 col-lg-10 dynamic-field" id="dynamic-field-1">
                  <div class="row" >                       
                    <div class="col-md-12 col-lg-6 ">
                      <div class="form-group">
                        <label for="field" class="hidden-md">Discount(%)</label>
                        <input type="text" id="field" class="form-control" name="field[]" />
                      </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                      <div class="form-group">
                        <label>Number of Orders</label>
                        <input type="text" class="form-control" name="order[]">
                      </div>
                    </div>
                  </div>
                </div>
            <?php  } ?>
              <div class="col-md-12 col-lg-2 mt-30 append-buttons">
                <div class="clearfix">
                  <button type="button" id="add-button" class="btn btn-secondary float-left text-uppercase shadow-sm"><i class="fa fa-plus fa-fw"></i>
                  </button>
                  <button type="button" id="remove-button" class="btn btn-secondary float-left text-uppercase ml-1" ><i class="fa fa-minus fa-fw"></i>
                  </button>
                </div>
              </div>
            </div>
            <input type="hidden" name="zoneid" class="zoneid" value="<?php echo $zone_id; ?>" >
            <input type="button" name="buttonAdd" value="Submit" class="buttonAdd cus-btn">
          </form>    
        </div>
      </div>



    </div> 
  </div>
</div>
</div>
</div>