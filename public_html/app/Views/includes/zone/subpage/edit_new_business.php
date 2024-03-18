<input type="hidden" id="businessid" name="businessid" value="<?php echo $business_id;?>"/><input type="hidden" id="zoneid" name="zoneid" value="<?php echo $zoneid;?>"/>

       
        <div id="tabs-1_x" class="form-group">
        	<div class="form-group ">
            <div class="container_tab_header">Edit Business<span id="back_to_business"  data-businesstype="<?=$business_type?>" data-businesstypebycategory="<?=$business_type_by_category?>" data-businesszone="<?=$business_zone?>" style="float:right; text-decoration:underline; cursor:pointer;">Back to Business</span></div>
            	<div class="container_tab_header success" style="background-color:#859731; display:none;"><strong>You Successfully Updated The Business.</strong></div>
                <div class="container_tab_header failure" style="background-color:#d01b13; display:none;">Sorry! Try Again Later.</div>
                <form id="update_business_form" class="form-validate" name="update_business_form" method="post" action="">
                <input type="hidden" id="userid" name="userid" value=""/>
				
                <input type="hidden" name="biz_id" id="biz_id" value="<?=$business_id?>"/>
                <input type="hidden" name="biz_zone_id" id="biz_zone_id" value="<?=$zoneid?>"/>
                <input type="hidden" name="biz_addsetting_id" id="biz_addsetting_id" value=""/>
                <input type="hidden" name="biz_address_id" id="biz_address_id" value=""/>
                <input type="hidden" name="biz_user_id" id="biz_user_id" value=""/>
                <input type="hidden" name="biz_business_type" id="biz_business_type" value="<?=$business_type?>"/>
                <input type="hidden" name="biz_business_type_by_category" id="biz_business_type_by_category" value="<?=$business_type_by_category?>"/>
                <input type="hidden" name="biz_business_zone" id="biz_business_zone" value="<?=$business_zone?>"/>
                    
                    <p class="form-group-row">
                      <label for="email" class="fleft w_200">Business Name</label>
                      <input type="text" id="biz_name" name="biz_name" class="w_300"  value="" placeholder="Specify Business Name"/>
                    </p>
                    <p class="form-group-row">
                      <label for="biz_motto" class="fleft w_200">Motto/Slogan</label>
                      <textarea id="biz_motto" name="biz_motto" class="w_300" ></textarea>
                    </p>
                    <p class="form-group-row">
                      <label for="biz_email" class="fleft w_200">Contact Email</label>
                      <input type="text" id="biz_email" name="biz_email" class="w_300" value="" />

                    </p>
                    <p class="form-group-row">
                      <label for="biz_first_name" class="fleft w_200">Contact First Name</label>
                      <input type="text" id="biz_first_name" name="biz_first_name" class="w_300 biz_full_name" value="" />

                    </p>
                    <p class="form-group-row">
                      <label for="biz_last_name" class="fleft w_200">Contact Last Name</label>
                      <input type="text" id="biz_last_name" name="biz_last_name" class="w_300 biz_full_name"  value="" />

                    </p>
                    
                    <p class="form-group-row">
                      <label for="biz_address_1" class="fleft w_200">Street Address 1</label>
                      <textarea id="biz_address_1" name="biz_address_1" class="w_300" ></textarea>

                    </p>
                    <p class="form-group-row">
                      <label for="biz_address_2" class="fleft w_200">Street Address 2</label>
                      <textarea id="biz_address_2" name="biz_address_2" class="w_300" ></textarea>

                    </p>
                    <p class="form-group-row">
                      <label for="biz_city" class="fleft w_200">City</label>
                      <input type="text" id="biz_city" name="biz_city" class="w_300" value="" />

                    </p>
                    <p class="form-group-row">
                      <label for="address" class="fleft w_200">State</label>
                      <?= form_dropdown("biz_state", $state_list, '', 'id="biz_state"');?>

                    </p>
                    <p class="form-group-row">
                      <label for="biz_phone" class="fleft w_200">Phone Number</label>
                      <input type="text" id="biz_phone" name="biz_phone" class="w_300"  value="" placeholder="Enter # (e.g. 555-XXX-XXXX)"/>

                    </p>
                    <p class="form-group-row">
                      <label for="biz_website" class="fleft w_200">Website</label>
                      <input type="text" id="biz_website" name="biz_website" class="w_300"  value="" />

                    </p>
                    <p class="form-group-row">
                      <label for="biz_sic" class="fleft w_200">SIC Code</label>
                      <input type="text" id="biz_sic" name="biz_sic" class="w_300"  value="" />

                    </p>
                    
                    Business Owner Information:
                    <p class="form-group-row">
                      <label for="biz_username" class="fleft w_200">Username</label>
                      <input type="text" id="biz_username" name="biz_username" class="w_300"  value="" readonly="readonly" style="background-color:#CCC;color:#666;"/>

                    </p>
                    
                    <p class="form-group-row">
                      <label for="biz_password" class="fleft w_200">Password</label>
                      <input type="text" id="biz_password" name="biz_password" class="w_300"  value="" readonly="readonly" style="background-color:#CCC;color:#666;"/>

                    </p>
                     
                    <p class="form-group-row">
                      <label for="button_save">
                        <button id="edit_update_new_business" class="m_left_200" type="button" data-businesstype="<?=$business_type?>" data-businesstypebycategory="<?=$business_type_by_category?>" data-businesszone="<?=$business_zone?>">Update Business</button>
                      </label>
                    </p>
                    <div class="spacer"></div>
                    <div class="container_tab_header success" style="background-color:#859731; display:none;">You Successfully Updated The Business.</div>
                	<div class="container_tab_header failure" style="background-color:#d01b13; display:none;">Sorry! Try Again Later.</div>
                    <div class="spacer"></div>
              	</form>
                <!--<div class="container_tab_header success" style="background-color:#859731; display:none;"><strong>You Successfully Created The Business.</strong></div>
                <div class="container_tab_header failure" style="background-color:#d01b13; display:none;">Sorry! Try Again Later.</div>-->
              </div>

        </div>