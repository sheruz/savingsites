<input type="hidden" id="businessid" name="businessid" value="<?php echo $businessid;?>"/><input type="hidden" id="zoneid" name="zoneid" value="<?php echo $zoneid;?>"/>



       

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

                <input type="hidden" name="biz_approval" id="biz_approval" value=""/>

                   <span style="color:red">(*)These fields are required </span> 

                    <p class="form-group-row">

                      <label for="email" class="fleft w_200">Business Name<span style="color:red">*</span></label>

                      <input type="text" id="biz_name" name="biz_name" class="w_536"  value="" placeholder="Specify Business Name"/>

                      <div id="error_contact_name"></div>

                    </p>

                    <p class="form-group-row">

                      <label for="biz_motto" class="fleft w_200">Motto/Slogan</label>

                      <textarea id="biz_motto" name="biz_motto" class="w_536" ></textarea>

                    </p>

                    <p class="form-group-row">

                      <label for="biz_about" class="fleft w_200">About Us<br /> <span style="color:red">An “About Us” menu tab will only show on your site if your business fills in About Us contents here; otherwise an About Us menu tab will not appear on your site: </span></label>

                      <textarea id="biz_about" name="biz_about" class="w_536" ></textarea>

                    </p>

                    <p class="form-group-row">

                      <label for="biz_email" class="fleft w_200">Contact Email</label>

                      <input type="text" id="biz_email" name="biz_email" class="w_536" value="" />

                        <div id="error_contact_email"></div>



                    </p>

                    <div style="margin-left: 200px;display:none;  background-color: wheat; height: 25px; border-radius: 7px;width: 245px;"id="email_notice" >

                    <span style="color:red;  margin-left: 12px;"/> Please enter valid Email address </span>

                    <div id="error_contact_email"></div>

                    </div>

                    <p class="form-group-row">

                      <label for="biz_first_name" class="fleft w_200">Contact First Name<span style="color:red">*</span></label>

                      <input type="text" id="biz_first_name" name="biz_first_name" class="w_536 biz_full_name" value="" />

                       <div id="error_contact_first_name"></div>

                     

                     

                    </p>

                    <p class="form-group-row">

                      <label for="biz_last_name" class="fleft w_200">Contact Last Name<span style="color:red">*</span></label>

                      <input type="text" id="biz_last_name" name="biz_last_name" class="w_536 biz_full_name"  value="" />

                        <div id="error_contact_last_name"></div>

                    </p>

                    

                    <p class="form-group-row">

                      <label for="biz_address_1" class="fleft w_200">Street Address</label>

                      <textarea id="biz_address_1" name="biz_address_1" class="w_536" ></textarea>



                    </p>

                    <p class="form-group-row">

                  <label for="biz_street_2" class="fleft w_200">Mailing Address<br />(if different)</label>

                      <textarea id="biz_street_2" name="biz_street_2" class="w_536" ><?=$addressdata->street_address_2?></textarea>

                    </p>

                    <p class="form-group-row" style="display:none;">

                      <label for="biz_address_2" class="fleft w_200">Street Address 2</label>

                      <textarea id="biz_address_2" name="biz_address_2" class="w_536" ></textarea>



                    </p>

                    <p class="form-group-row">

                      <label for="biz_city" class="fleft w_200">City</label>

                      <input type="text" id="biz_city" name="biz_city" class="w_536" value="" />



                    </p>

                    <p class="form-group-row">

                      <label for="biz_zip_code" class="fleft w_200">Zip Code:</label>

                      <input type="text" id="biz_zip_code" name="biz_zip_code" class="w_536" value="<?php if($addressdata->zip_code == -1){echo "Please provide zip";}else{ echo $addressdata->zip_code; }?>" onchange="zip_to_zone1(this.value);return false;"/>              

                      <div id="error_contact_zipcode"></div>

                    </p>



                    <p class="form-group-row">

                      <label for="address" class="fleft w_200">State</label>

                      <?= form_dropdown("biz_state", $state_list, '', 'id="biz_state"');?>



                    </p>

                    <p class="form-group-row">

                      <label for="biz_phone" class="fleft w_200">Phone Number<span style="color:red">*</span></label>

                      <input type="text" id="biz_phone" name="biz_phone" class="w_536"  value="" placeholder="Enter # (e.g. 555-XXX-XXXX)"/>

                       <div id="error_contact_phone"></div>



                    </p>

                    <p class="form-group-row">

                      <label for="biz_website" class="fleft w_200">Website</label>

                      <input type="text" id="biz_website" name="biz_website" class="w_536"  value="" />



                    </p>

                    <p class="form-group-row">

                    <label for="restaurant_type" class="fleft w_200">Business Type</label>

                    <select id="restaurant_type" class="fleft w_315">

                      <option value="1">Restaurant</option>

                      <option value="0">Non Restaurant</option>

                    </select>

                  </p>

                    <p class="form-group-row" style="display:none;">

                      <label for="biz_sic" class="fleft w_200">SIC Code</label>

                      <input type="text" id="biz_sic" name="biz_sic" class="w_536"  value="" />



                    </p>

                    <p class="form-group-row" style="">

                    <div id="status_reason">

                      <label for="biz_note" class="fleft w_200" style="  margin-top: 0px;">Status Changing Reason</label>

                      <div id="biz_note" name="biz_note" class="w_536" style=" margin-top: 35px; width:55%; margin-left:200px; font-size:15px; min-height:20px"></div>

                     </div>

                    </p>

                    

                   <div class="page-subheading">Business Owner Information:</div>

                    <p class="form-group-row">

                      <label for="biz_username" class="fleft w_200">Username</label>

                      <input type="text" id="biz_username" name="biz_username" class="w_536"  value="" readonly="readonly" style="background-color:#CCC;color:#666;"/>



                    </p>

                    

                    <p class="form-group-row">

                      <label for="biz_password" class="fleft w_200">Password</label>

                      <input type="text" id="biz_password" name="biz_password" class="w_536"  value="" readonly="readonly" style="background-color:#CCC;color:#666;"/>



                    </p>

                    

                    <p id="error_contactbiz_name">

                    </p>

                    <p id="error_contactbiz_email">

                    </p>

                    <p id="error_contactbiz_first_name">

                    </p>

                    <p id="error_contactbiz_last_name">

                    </p>

                    <p id="error_contactbiz_phone">

                    </p>

                    <p class="form-group-row">

                      <label for="button_save">

                        <button id="edit_update_non_temp_business" class="m_left_200" type="button" data-businesstype="<?=$business_type?>" data-businesstypebycategory="<?=$business_type_by_category?>" data-businesszone="<?=$business_zone?>">Update Business</button>

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

        <script type="text/javascript">

		    $(function (){  

            $("#biz_phone").mask('999-999-9999',{placeholder:' '});

         });

		 setTimeout(function () {

				var approval =$('#biz_approval').val();

				if(approval != 1  && approval != -1){

					$('#status_reason').hide();

				}

			}, 1000);

			

		$('#biz_email').focusout(function(){

          $('#biz_email').filter(function(){

              var email=$('#biz_email').val();

              // var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
              var emailReg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

            	if( !emailReg.test(email)){

				$('#email_notice').slideDown();

				//$('#email_notice').fadeOut(6000);

				$('#biz_email').focus();

				//$('#email_notice').fadeToggle();

				}else{

					$('#email_notice').slideUp('slow');

				} 

             })

          });

		</script>