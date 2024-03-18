<!------login form --->

<div  class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="login-box2">
	<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">						
			<h4 class="modal-title" id="myModalLabel">
					<i class="fa-solid fa-user"></i>
					<span id="login_type_name">Residents Login</span>
				</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
			</div>
		<div class="modal-body">
			<form id="loginForm" class="post" method="post" action="#">
						<input type="hidden" id="userzone" value="<?=$zoneid?>"/>
						<input type="hidden" id="peekaboouser" value="<?=$user_id?>"/>
				<?php $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
					$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
				?>
				<input type="hidden" name="visitorUrl" id="visitorUrl" class="visitorUrl" value="<?=$url?>">
				<input type="hidden" id="pageName" class="pageName" name="pageName">
				<input type="hidden" id="from_where_login" value="<?=$zoneid?>"/>
				<input type="hidden" name="snap_signup_bs_id" id="snap_signup_bs_id" value='' />
				<input type="hidden" name="snap_signup_ad_id" id="snap_signup_ad_id" value='' />
				<input type="hidden" name="snap_zone_id_login" id="snap_zone_id_login" value='' />
				<input type="hidden" name="snap_signup_type" id="snap_signup_type" value='' />
				<input type="hidden" name="snap_signup_offer_type" id="snap_signup_offer_type" value='' />
				<input type="hidden" name="rating_value" id="rating_value" value='' />
				<label id="username_label_name" for="name" class="label">User Name/Email address used when registering</label>
				<input type="text" name="login_email" id="login_email" value="" class="textfield form-control" required/>
				<label for="email" class="label">Password:</label>
				<input type="password" name="login_password" id="login_password" value="" class="textfield form-control" required/><br />
				<input type="button" name="submit1" id="header_login" value="Login" class="button btn login-submit"/>
				</form> 
				<div class="clear"></div>   
 				<p><div class="igsignup" id="forgot_password_limk"></div></p>  
 				<div class="fbloginresident_user">
					<!-- fb login -->
					<fb:login-button  data-size="large"
  						scope="public_profile,email"
  						onlogin="checkLoginState();">
					</fb:login-button>
					<!-- google login  data-onsuccess="onGoogleSignIn"-->
					<div class="g-signin2" ></div>
	 			
 				</div>
		</div> <!---modal body end -->
	<div class="neigbour-sucess d-block modal-footer"></div>
	</div>
</div>
</div>
<!-- For Registration -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="service_modal_div02">
	<div class="modal-dialog modal-xl" role="document">	
		<div class="modal-content">
			<div class="modal-header">
				<h4 style="color:#fff;font-weight: 700;">Food Order Savings</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<h4 class="bodytitle">Your Favorites</h4>
				<table class="table table-bordered pretty dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            		<thead>
              			<tr role="row">
              				<th>Restaurant</th>
              				<th>Favorite Id</th>
              				<th>Favorite Title</th>
              				<th>Favorite Notes</th>
              				<th>Action</th>
              			</tr>
            		</thead>
            		<tbody id="showfavnotes"></tbody>
          		</table>
			</div>
			<div class="modal-footer">
				<div id="favfooterdiv">
					
				</div>
			</div>
		</div>
	</div>
</div>
<div id="emailnoticesignupform02" class="modal fade"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="overflow: scroll;">
	<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">						
			<h4 class="modal-title" id="myModalLabel">
				<img src="https://i.ibb.co/XXhgyjW/signup-1.png" width="40" style="vertical-align:middle;margin-right:15px;float:left">Residents Registration Form
		        <input type="hidden" id="refer_code" value="<?php echo $refer_code; ?>" />
			</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body f10" id="emailnoticesignupform_content">
			<section class="body_part">
				<div class="innersize1k"> 
					<h4 style="font-size:14px; margin-top:6px;color:#000000;line-height: 20px;">Your information is not given to municipality, non-profit orgs, or businesses. Only restaurants of your choice will be provided delivery information. <a onclick="more_benifit('showdiv');" style="text-decoration:underline; cursor:pointer;">More Benefits.</a></h4>
					<div class="more_benifit_show" style="display:none;">
					<p style="margin-top:15px;">
						<strong>Municipal Protection:</strong><br />Because SavingsSites allows municipalities to freely email their residents and businesses from our server, this insulates the municipality from having to make public any email addresses collected, as many municipalities are forced to disclose email addresses under laws such as Open Public Record Act and Freedom of Information Act and Sunshine Laws.
					</p>
					<p style="margin-top:10px;">
						<strong>Targeted Information:</strong><br />The SavingsSites system also enables the businesses and organizations to create "INTEREST GROUPS" so you only receive information and only see events in the Events calendar on topics you select!
					</p>
					<p style="margin-top:10px;">
						<strong>Short Notice Alert Program (SNAP):</strong><br />Enjoy the benefits of your favorite businesses (SNAP) program to get substantially discounted specials, close-outs, perishables, and overruns not advertised. Professionals and contractors want their calendars filled, so they too will announce short notice deeply discounted offers. Many restaurants will seek to fill up their tables and offer deep discounts. Remember, Savings Sites does the emailing/texting and your information is not disclosed to the businesses.  
					</p>
					<span onclick="more_benifit('hidediv')"><img src="<?=base_url()?>assets/images/arrow-up.gif" style="width: 36px;margin-left: 48%; cursor:pointer;" /></span>
				</div>
				<form id="ratingsignupForm" class="" method="post" action="javascript:void(0);"  enctype="multipart/form-data">
					<?php   if(@$refferalcode){  ?>
        				<input type="hidden" name="refferalcode" value="<?php echo $refferalcode; ?>" />
     				<?php } ?>
					<div class="body_part_inner noticeformarea"> <small>Required where indicated <span class="red">*</span></small> <br />
						<div class="form-container">
      						<div class="row">
      							<div class="col-sm-6">
									<p><span class="label_left">
									<label>First Name<span class="red">*</span>:</label></span>
        							<span class="input_right">
										<input name="first_name" id="first_name" type="text" required class="form-control" />
									</span>
    								</p>
								</div>
								
								<div class="col-sm-6">
									<p><span class="label_left">
										<label>Last Name<span class="red">*</span>:</label>
										</span><span class="input_right">
										<input name="last_name" id="last_name" type="text" required class="form-control"/></span>
									</p>
								</div>
								
								<div class="col-sm-12">
									<p> <span class="label_left">
										<label> User Name<span class="red">*</span>:</label>
										</span> <span class="input_right">
										<input name="username" id="emailnotice_username" type="text" onchange="username_verification($(this).val());" required class="form-control" />
										</span>
										<small>This can be a name other than your real name that is used for Blog Posts or if you choose to have your User Name posted as a Peekaboo Auction Winner (Must be between 6-12 characters):</small>
									</p>	
								</div>
        						
        						<div class="col-sm-12">
									<p> <span class="label_left">
										<label>Email<span class="red">*</span>:</label>
										</span> <span class="input_right">
										<input name="emailnotice_email" id="emailnotice_email" onchange="email_verification($(this).val());" type="text" required class="form-control" />
									</p>
								</div>

      							<div class="col-sm-12">
									<p><span class="label_left">
										<label>Postal Address<span class="red">*</span>:</label>
										</span><span class="input_right">
										<input name="postal_address" id="postal_address" type="text" required class="form-control" /></span>
									</p>
								</div>
								
								<div class="col-sm-12">
     								<p> <span class="label_left">
										<label>Additional Restaurant Delivery Instructions (Optional) </label>
										</span> <span class="input_right">
										<input name="additionalDelivery" id="additionalDelivery" type="text" onblur="" class="form-control" /></span>    
									</p>
   	 							</div>

   	 							<div class="col-sm-6">
									<p><span class="label_left">
										<label>Street Addres<span class="red">*</span>:</label>
										</span><span class="input_right">
										<input name="street_address" id="street_address" type="text" required class="form-control"/></span>
									</p>
								</div>
								
								<div class="col-sm-6">
									<p><span class="label_left">
										<label>City<span class="red">*</span>:</label>
										</span><span class="input_right">
										<input name="city" id="city" type="text" required class="form-control" /></span>
									</p>
								</div>
								
								<div class="col-sm-6">
									<p><span class="label_left">
										<label>State<span class="red">*</span>:</label>
										</span><span class="input_right">
										<input name="state" id="state" type="text" required class="form-control"/></span>
									</p>
								</div>
								
								<div class="col-sm-6">
									<p><span class="label_left">
										<label>Zip Code<span class="red">*</span>:</label>
										</span><span class="input_right">
										<input name="zip_code" id="zip_code" type="text" required class="form-control" />
										</span>
									</p>
								</div>
								
								<div class="col-sm-12">
     								<p> <span class="label_left">
										<label>Telephone: (Home Phone) If you only have cell phone enter cell here and below.</label></span> <span class="input_right">
										<input name="telephone" id="telephone" type="text" onblur="" class="form-control" />
									</p>
    							</div>
  								<div class="col-sm-10">
									<p>
										<span class="label_left">
											<label>Cell Phone<span class="red">*</span>:</label>
										</span>
										<span class="input_right">
											<input name="cell_phone" id="cell_phone" type="text" onblur="" class="form-control" required autocomplete="off">
										</span>
										<span id="cell_phone_not" style="font-weight:bold; color:#F41525;display:block; text-align:center; display:none;"></span>
										<span id="cell_phone_available" style="font-weight:bold; color:#008040;display:block; text-align:center; display:none;"></span>
									</p>
								</div>
								<div class="col-sm-2">
									<span class="label_left" style="margin-top:12px;">
										<label>&nbsp;</label>
									</span>
									<button style="height:50px" type="button" class="btn btn-info" id="multiplePhone">+</button>
								</div>
    							
    							<div class="col-sm-6">
									<p> <span class="label_left">
										<label>Password<span class="red">*</span>:</label>
										</span> <span class="input_right">
										<input name="password" id="emailnotice_password" type="password" onfocusout="checkPwd()" required class="form-control"/>
										<span class="alerttextmaroon_label" style="color:red"> </span> </span> 
									</p>
								</div>
								
								<div class="col-sm-6">
									<p> <span class="label_left">
										<label>Retype Password<span class="red">*</span>:</label>
										</span> <span class="input_right">
										<input name="retype_password" id="retype_password" type="password" required class="form-control"/></span> 
									</p>
								</div>
    							
    							<div class="col-sm-6">
									<p> <span class="label_left">
										<label>Enter Refer Code Here:</label>
										</span> <span class="input_right">
										<input name="refer_code" id="refer_code" type="text" value='<?php echo $refer_code; ?>' class="form-control"/>
										</span> 
									</p>
								</div>
							</div>
						</div>
						
						<div class="form-container">
							<div class="row">
								<div class="col-sm-12">
									<p>
										<small><strong>Needed with ID to redeem cash certificates:</strong></small><br>
										<small class="label_left">When you are logged in the calendar will show you only events based upon categories that you are interested in. </small>
									</p>
								</div>
							</div>
						</div>
						
						<div id="globalDefaultSelectionBox" style="display: none;padding-top: 20px;">
							<div class="row">
								<div class="col-sm-12">
									<div class="form-container">
										<h3>SNAP Email Filters -- You Control Your Flow of Offers!</h3>
										<div class="snapMinmumPercentage">
											<div>
												<p style="margin-bottom: 5px;">Modify (SNAP) filters in the resident admin dashboard for all businesses; or go to Deals page query businesses, and just click the SNAP image for your desired Businesses! </p>
											</div>
										</div>
									</div>
								</div>
								
								<!-- For time reservation -->	
								<div style="display: none;" class="col-sm-12">
									<div class="form-container">
										<div class="row">
											<div class="col-sm-12">
												<strong>Indicate below the days and times of day you're available to use the offer:</strong>
											</div>
											<div style="clear: both"></div>
											<div class="col-sm-12">
												<div class="row snaptimecolumn" style="margin-top: 26px;">		<div class="col-sm-3 col-xs-6 hidden-xs" style="height:40px;"></div>
													<div class="col-sm-3 col-xs-6" style="height:40px;"><div class="any-time" style="margin-left: 61%; position: absolute; width: 100px; margin-top: -24px;"><input type="checkbox" name="snapStartTime[]" class="snapStartTimeRegistration" value="0" id="snapStartTimeRegistrationDefault" onchange="globalSnapAnyRegistratioan(this)">&nbsp;<span>Any time</span></div>am<br></div>
													<div class="col-sm-3 col-xs-6 hidden-xs" style="height:40px;">pm</div>
													<div class="col-sm-3 col-xs-6 hidden-xs" style="height:40px;">pm</div>
													<div class="col-sm-3 col-xs-6"></div>
												</div>
												<div class="col-sm-12" id="snapMessage"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<!-- next section -->
					<input type="hidden" name="ad_id" value="<?= isset($ad_id)?$ad_id:'';?>" />
					<input type="hidden" name="offer_type" value="<?= isset($offer_type)?$offer_type:'';?>" />
					<input type="hidden" name="createdby_id" value="<?= isset($createdby_id)?$createdby_id:'';?>" />
					<input type="hidden" name="zone_id" value="<?= isset($zone_id)?$zone_id:'';?>" />
					<input type="hidden" name="type" value="<?= isset($type)?$type:'';?>" />
					<div class="submitbox" style="padding-right: 20px;text-align: center;text-align: center;float:none;">
						<input type="submit" class="signup_button btn btn-default" value="Submit" />
					</div>
				</form>
			</div>
		</section>
	</div> <!---modal body end -->
	<div class="neigbour-sucess d-block modal-footer"></div>
	</div>
</div>
</div>

<!------employee register form --->
<div id="employee_registration" class="modal fade"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="overflow: scroll;">
	<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">						
			<h4 class="modal-title" id="myModalLabel">
				Empolyee Registration
			</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body f10" id="emailnoticesignupform_content">
			<section class="body_part">
				<div class="innersize1k"> 
				<form id="ratingsignupForms" class="" method="post" action="javascript:void(0);"  enctype="multipart/form-data">
					<?php   if(@$refferalcode){  ?>
        				<input type="hidden" name="refferalcode" value="<?php echo $refferalcode ; ?>" />
     				<?php } ?>
					 <div class="body_part_inner noticeformarea"> <small>Required where indicated <span class="red">*</span></small> <br /><br>
						<div class="form-container">
      						<p> <span class="label_left">
								<input type="hidden" name="user_type" value="15">
								<label> User Name<span class="red">*</span>:</label>
								</span> <span class="input_right">
									<!-- <input name="username" id="emailnotice_username" type="text" onchange="username_verification($(this).val());" required class="form-control" /> -->
								</span>
								<input type="hidden" name="usernamevalidation" id="usernamevalidation" value="" />
								<small>This can be a name other than your real name that is used for Blog Posts or if you choose to have your User Name posted as a Peekaboo Auction Winner (Must be between 6-12 characters):</small>
							</p>
						</div>

						<div class="form-container">
							<p> 
      							<span class="label_left">
									<label>Email<span class="red">*</span>:</label>
								</span> 
        						<span class="input_right">
									<!-- <input name="emailnotice_email" id="emailnotice_email" onchange="email_verification($(this).val());" type="text" required class="form-control" /> -->
									<input type="hidden" name="emailvalidation" id="emailvalidation" value=""/>
								</span>
							</p>
						</div>
						
						<div class="form-container">
							<p> 
      							<span class="label_left">
									<label>Telephone: (Home Phone) If you only have cell phone enter cell here and below.</label>
								</span> 
								<span class="input_right">
									<input name="emailnotice_phone" id="emailnotice_phone" type="text" onblur="" class="form-control" />
								</span> 
							</p>
						</div>
						
						<div class="form-container">
							<p> 
								<span class="label_left">
									<label>Additional Restaurant Delivery Instructions (Optional)</label>
								</span> 
								<span class="input_right">
									<input name="additionalDelivery" id="additionalDelivery" type="text" onblur="" class="form-control" />
								</span> 
							</p>
						</div>
						
						<div class="form-container">
							<div class="row">
								<div class="col-sm-12">
									<p>
										<span class="label_left">
											<label>Cell Phone:</label>
										</span>
										<span class="input_right">
											<input name="cell_phone" id="cell_phone" type="text" onblur="" class="form-control">
										</span>
									</p>
								</div>
							</div>
						</div>
						
						<div class="form-container">
							<div class="row">
								<div class="col-sm-6">
									<p> 
      									<span class="label_left">
											<label>Password<span class="red">*</span>:</label>
										</span> 
        								<span class="input_right">
											<input name="password" id="emailnotice_password" type="password" onfocusout="checkPwd()" required class="form-control"/>
										</span> 
									</p>
								</div>
								<div class="col-sm-6">
									<p> 
      									<span class="label_left">
											<label>Retype Password<span class="red">*</span>:</label>
										</span> 
        								<span class="input_right">
											<input name="retype_password" id="retype_password" type="password" required class="form-control"/>
										</span> 
									</p>
								</div>
							</div>
						</div>
						
						<div class="form-container">
							<div class="row">
								<div class="col-sm-6">
									<p>
      									<span class="label_left">
											<label>First Name<span class="red">*</span>:</label>
										</span>
        								<span class="input_right">
											<input name="first_name" id="first_name" type="text" required class="form-control" />
										</span>
									</p>
								</div>
								<div class="col-sm-6">
									<p>
      									<span class="label_left">
											<label>Last Name<span class="red">*</span>:</label>
										</span>
        								<span class="input_right">
											<input name="last_name" id="last_name" type="text" required class="form-control"/>
										</span>
									</p>
								</div>
								<div class="col-sm-12">
									<p>
										<small><strong>Needed with ID to redeem cash certificates:</strong></small><br>
										<small class="label_left">When you are logged in the calendar will show you only events based upon categories that you are interested in.</small>
									</p>
								</div>
							</div>
						</div>		
						
						<div id="globalDefaultSelectionBox" style="display: none;padding-top: 20px;">
							<div class="row">
								<div class="col-sm-12">
									<div class="form-container">
										<h3>SNAP Email Filters -- You Control Your Flow of Offers!</h3>
										<div class="snapMinmumPercentage">
											<div>
												<p style="margin-bottom: 5px;">Modify (SNAP) filters in the resident admin dashboard for all businesses; or go to Deals page query businesses, and just click the SNAP image for your desired Businesses! </p>
											</div>
										</div>
									</div>
								</div>
								
								<!-- For time reservation -->	
								<div style="display: none;" class="col-sm-12">
									<div class="form-container">
										<div class="row">
											<div class="col-sm-12">
												<strong>Indicate below the days and times of day you're available to use the offer:</strong>
											</div>
											<div style="clear: both"></div>
											<div class="col-sm-12">
												<div class="row snaptimecolumn" style="margin-top: 26px;">		<div class="col-sm-3 col-xs-6 hidden-xs" style="height:40px;"></div>
													<div class="col-sm-3 col-xs-6" style="height:40px;"><div class="any-time" style="margin-left: 61%; position: absolute; width: 100px; margin-top: -24px;"><input type="checkbox" name="snapStartTime[]" class="snapStartTimeRegistration" value="0" id="snapStartTimeRegistrationDefault" onchange="globalSnapAnyRegistratioan(this)">&nbsp;<span>Any time</span></div>am<br></div>
													<div class="col-sm-3 col-xs-6 hidden-xs" style="height:40px;">pm</div>
													<div class="col-sm-3 col-xs-6 hidden-xs" style="height:40px;">pm</div>
													<div class="col-sm-3 col-xs-6"></div>
												</div>
												<div class="col-sm-12" id="snapMessage"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<!-- next section -->
					<input type="hidden" name="ad_id" value="<?php //echo $ad_id;?>" />
					<input type="hidden" name="offer_type" value="<?php //echo $offer_type;?>" />
					<input type="hidden" name="createdby_id" value="<?php //echo $createdby_id;?>" />
					<input type="hidden" name="zone_id" value="<?php // echo $zone_id;?>" />
					<input type="hidden" name="type" value="<?php //echo $type;?>" />
					<div class="submitbox" style="padding-right: 20px;text-align: center;text-align: center;float:none;">
						<input type="submit" class="signup_button btn btn-default" value="Submit" />
					</div>
				</form>
			</div>
		</section>
	</div> <!---modal body end -->
	<div class="neigbour-sucess d-block modal-footer"></div>
	</div>
</div>
</div>

<!------visitor register form --->
<div id="visitor_registration02" class="modal fade"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="overflow: scroll;">
	<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">						
			<h4 class="modal-title" id="myModalLabel">
				<img src="https://i.ibb.co/XXhgyjW/signup-1.png" width="40" style="vertical-align:middle;margin-right:15px;float:left">
				Visitor Registration
			</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body f10" id="emailnoticesignupform_content">
			<section class="body_part">
				<div class="innersize1k"> 
				<form id="ratingsignupForms" class="" method="post" action="javascript:void(0);"  enctype="multipart/form-data">
					<?php   if(@$refferalcode){  ?>
        				<input type="hidden" name="refferalcode" value="<?php echo $refferalcode ; ?>" />
     				<?php } ?>
					 <div class="body_part_inner noticeformarea"> <small>Required where indicated <span class="red">*</span></small> <br /><br>
						<div class="form-container">
      						<p> <span class="label_left">
								<input type="hidden" name="user_type" value="15">
								<label> User Name<span class="red">*</span>:</label>
								</span> <span class="input_right">
									<!-- <input name="username" id="emailnotice_username" type="text" onchange="username_verification($(this).val());" required class="form-control" /> -->
								</span>
								<input type="hidden" name="usernamevalidation" id="usernamevalidation" value="" />
								<small>This can be a name other than your real name that is used for Blog Posts or if you choose to have your User Name posted as a Peekaboo Auction Winner (Must be between 6-12 characters):</small>
							</p>
						</div>

						<div class="form-container">
							<p> 
      							<span class="label_left">
									<label>Email<span class="red">*</span>:</label>
								</span> 
        						<span class="input_right">
									<!-- <input name="emailnotice_email" id="emailnotice_email" onchange="email_verification($(this).val());" type="text" required class="form-control" /> -->
									<input type="hidden" name="emailvalidation" id="emailvalidation" value=""/>
								</span>
							</p>
						</div>
						
						<div class="form-container">
							<p> 
      							<span class="label_left">
									<label>Telephone: (Home Phone) If you only have cell phone enter cell here and below.</label>
								</span> 
								<span class="input_right">
									<input name="emailnotice_phone" id="emailnotice_phone" type="text" onblur="" class="form-control" />
								</span> 
							</p>
						</div>
						
						<div class="form-container">
							<div class="row">
								<div class="col-sm-12">
									<p>
										<span class="label_left">
											<label>Cell Phone:</label>
										</span>
										<span class="input_right">
											<input name="cell_phone" id="cell_phone" type="text" onblur="" class="form-control">
										</span>
									</p>
								</div>
							</div>
						</div>
						
						<div class="form-container">
							<div class="row">
								<div class="col-sm-6">
									<p> 
      									<span class="label_left">
											<label>Password<span class="red">*</span>:</label>
										</span> 
        								<span class="input_right">
											<input name="password" id="emailnotice_password" type="password" onfocusout="checkPwd()" required class="form-control"/>
										</span> 
									</p>
								</div>
								<div class="col-sm-6">
									<p> 
      									<span class="label_left">
											<label>Retype Password<span class="red">*</span>:</label>
										</span> 
        								<span class="input_right">
											<input name="retype_password" id="retype_password" type="password" required class="form-control"/>
										</span> 
									</p>
								</div>
							</div>
						</div>
						
						<div class="form-container">
							<div class="row">
								<div class="col-sm-6">
									<p>
      									<span class="label_left">
											<label>First Name<span class="red">*</span>:</label>
										</span>
        								<span class="input_right">
											<input name="first_name" id="first_name" type="text" required class="form-control" />
										</span>
									</p>
								</div>
								<div class="col-sm-6">
									<p>
      									<span class="label_left">
											<label>Last Name<span class="red">*</span>:</label>
										</span>
        								<span class="input_right">
											<input name="last_name" id="last_name" type="text" required class="form-control"/>
										</span>
									</p>
								</div>
								<div class="col-sm-12">
									<p>
										<small><strong>Needed with ID to redeem cash certificates:</strong></small><br>
										<small class="label_left">When you are logged in the calendar will show you only events based upon categories that you are interested in.</small>
									</p>
								</div>
							</div>
						</div>		
						
						<div id="globalDefaultSelectionBox" style="display: none;padding-top: 20px;">
							<div class="row">
								<div class="col-sm-12">
									<div class="form-container">
										<h3>SNAP Email Filters -- You Control Your Flow of Offers!</h3>
										<div class="snapMinmumPercentage">
											<div>
												<p style="margin-bottom: 5px;">Modify (SNAP) filters in the resident admin dashboard for all businesses; or go to Deals page query businesses, and just click the SNAP image for your desired Businesses! </p>
											</div>
										</div>
									</div>
								</div>
								
								<!-- For time reservation -->	
								<div style="display: none;" class="col-sm-12">
									<div class="form-container">
										<div class="row">
											<div class="col-sm-12">
												<strong>Indicate below the days and times of day you're available to use the offer:</strong>
											</div>
											<div style="clear: both"></div>
											<div class="col-sm-12">
												<div class="row snaptimecolumn" style="margin-top: 26px;">		<div class="col-sm-3 col-xs-6 hidden-xs" style="height:40px;"></div>
													<div class="col-sm-3 col-xs-6" style="height:40px;"><div class="any-time" style="margin-left: 61%; position: absolute; width: 100px; margin-top: -24px;"><input type="checkbox" name="snapStartTime[]" class="snapStartTimeRegistration" value="0" id="snapStartTimeRegistrationDefault" onchange="globalSnapAnyRegistratioan(this)">&nbsp;<span>Any time</span></div>am<br></div>
													<div class="col-sm-3 col-xs-6 hidden-xs" style="height:40px;">pm</div>
													<div class="col-sm-3 col-xs-6 hidden-xs" style="height:40px;">pm</div>
													<div class="col-sm-3 col-xs-6"></div>
												</div>
												<div class="col-sm-12" id="snapMessage"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<!-- next section -->
					<input type="hidden" name="ad_id" value="<?php //echo $ad_id;?>" />
					<input type="hidden" name="offer_type" value="<?php //echo $offer_type;?>" />
					<input type="hidden" name="createdby_id" value="<?php //echo $createdby_id;?>" />
					<input type="hidden" name="zone_id" value="<?php // echo $zone_id;?>" />
					<input type="hidden" name="type" value="<?php //echo $type;?>" />
					<div class="submitbox" style="padding-right: 20px;text-align: center;text-align: center;float:none;">
						<input type="submit" class="signup_button btn btn-default" value="Submit" />
					</div>
				</form>
			</div>
		</section>
	</div> <!---modal body end -->
	<div class="neigbour-sucess d-block modal-footer"></div>
	</div>
</div>
</div>





<!-- Grocery login form modal by anchal end -->
<div id="visitor_registration02" class="modal fade"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="overflow: scroll;">
	<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">						
			<h4 class="modal-title" id="myModalLabel">
				<img src="https://i.ibb.co/XXhgyjW/signup-1.png" width="40" style="vertical-align:middle;margin-right:15px;float:left">
				Visitor Registration
			</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body f10" id="emailnoticesignupform_content">
			<section class="body_part">
				<div class="innersize1k"> 
				<form id="ratingsignupForms" class="" method="post" action="javascript:void(0);"  enctype="multipart/form-data">
					<?php   if(@$refferalcode){  ?>
        				<input type="hidden" name="refferalcode" value="<?php echo $refferalcode ; ?>" />
     				<?php } ?>
					 <div class="body_part_inner noticeformarea"> <small>Required where indicated <span class="red">*</span></small> <br /><br>
						<div class="form-container">
      						<p> <span class="label_left">
								<input type="hidden" name="user_type" value="15">
								<label> User Name<span class="red">*</span>:</label>
								</span> <span class="input_right">
									<!-- <input name="username" id="emailnotice_username" type="text" onchange="username_verification($(this).val());" required class="form-control" /> -->
								</span>
								<input type="hidden" name="usernamevalidation" id="usernamevalidation" value="" />
								<small>This can be a name other than your real name that is used for Blog Posts or if you choose to have your User Name posted as a Peekaboo Auction Winner (Must be between 6-12 characters):</small>
							</p>
						</div>

						<div class="form-container">
							<p> 
      							<span class="label_left">
									<label>Email<span class="red">*</span>:</label>
								</span> 
        						<span class="input_right">
									<!-- <input name="emailnotice_email" id="emailnotice_email" onchange="email_verification($(this).val());" type="text" required class="form-control" /> -->
									<input type="hidden" name="emailvalidation" id="emailvalidation" value=""/>
								</span>
							</p>
						</div>
						
						<div class="form-container">
							<p> 
      							<span class="label_left">
									<label>Telephone: (Home Phone) If you only have cell phone enter cell here and below.</label>
								</span> 
								<span class="input_right">
									<input name="emailnotice_phone" id="emailnotice_phone" type="text" onblur="" class="form-control" />
								</span> 
							</p>
						</div>
						
						<div class="form-container">
							<div class="row">
								<div class="col-sm-12">
									<p>
										<span class="label_left">
											<label>Cell Phone:</label>
										</span>
										<span class="input_right">
											<input name="cell_phone" id="cell_phone" type="text" onblur="" class="form-control">
										</span>
									</p>
								</div>
							</div>
						</div>
						
						<div class="form-container">
							<div class="row">
								<div class="col-sm-6">
									<p> 
      									<span class="label_left">
											<label>Password<span class="red">*</span>:</label>
										</span> 
        								<span class="input_right">
											<input name="password" id="emailnotice_password" type="password" onfocusout="checkPwd()" required class="form-control"/>
										</span> 
									</p>
								</div>
								<div class="col-sm-6">
									<p> 
      									<span class="label_left">
											<label>Retype Password<span class="red">*</span>:</label>
										</span> 
        								<span class="input_right">
											<input name="retype_password" id="retype_password" type="password" required class="form-control"/>
										</span> 
									</p>
								</div>
							</div>
						</div>
						
						<div class="form-container">
							<div class="row">
								<div class="col-sm-6">
									<p>
      									<span class="label_left">
											<label>First Name<span class="red">*</span>:</label>
										</span>
        								<span class="input_right">
											<input name="first_name" id="first_name" type="text" required class="form-control" />
										</span>
									</p>
								</div>
								<div class="col-sm-6">
									<p>
      									<span class="label_left">
											<label>Last Name<span class="red">*</span>:</label>
										</span>
        								<span class="input_right">
											<input name="last_name" id="last_name" type="text" required class="form-control"/>
										</span>
									</p>
								</div>
								<div class="col-sm-12">
									<p>
										<small><strong>Needed with ID to redeem cash certificates:</strong></small><br>
										<small class="label_left">When you are logged in the calendar will show you only events based upon categories that you are interested in.</small>
									</p>
								</div>
							</div>
						</div>		
						
						<div id="globalDefaultSelectionBox" style="display: none;padding-top: 20px;">
							<div class="row">
								<div class="col-sm-12">
									<div class="form-container">
										<h3>SNAP Email Filters -- You Control Your Flow of Offers!</h3>
										<div class="snapMinmumPercentage">
											<div>
												<p style="margin-bottom: 5px;">Modify (SNAP) filters in the resident admin dashboard for all businesses; or go to Deals page query businesses, and just click the SNAP image for your desired Businesses! </p>
											</div>
										</div>
									</div>
								</div>
								
								<!-- For time reservation -->	
								<div style="display: none;" class="col-sm-12">
									<div class="form-container">
										<div class="row">
											<div class="col-sm-12">
												<strong>Indicate below the days and times of day you're available to use the offer:</strong>
											</div>
											<div style="clear: both"></div>
											<div class="col-sm-12">
												<div class="row snaptimecolumn" style="margin-top: 26px;">		<div class="col-sm-3 col-xs-6 hidden-xs" style="height:40px;"></div>
													<div class="col-sm-3 col-xs-6" style="height:40px;"><div class="any-time" style="margin-left: 61%; position: absolute; width: 100px; margin-top: -24px;"><input type="checkbox" name="snapStartTime[]" class="snapStartTimeRegistration" value="0" id="snapStartTimeRegistrationDefault" onchange="globalSnapAnyRegistratioan(this)">&nbsp;<span>Any time</span></div>am<br></div>
													<div class="col-sm-3 col-xs-6 hidden-xs" style="height:40px;">pm</div>
													<div class="col-sm-3 col-xs-6 hidden-xs" style="height:40px;">pm</div>
													<div class="col-sm-3 col-xs-6"></div>
												</div>
												<div class="col-sm-12" id="snapMessage"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<!-- next section -->
					<input type="hidden" name="ad_id" value="<?php //echo $ad_id;?>" />
					<input type="hidden" name="offer_type" value="<?php //echo $offer_type;?>" />
					<input type="hidden" name="createdby_id" value="<?php //echo $createdby_id;?>" />
					<input type="hidden" name="zone_id" value="<?php // echo $zone_id;?>" />
					<input type="hidden" name="type" value="<?php //echo $type;?>" />
					<div class="submitbox" style="padding-right: 20px;text-align: center;text-align: center;float:none;">
						<input type="submit" class="signup_button btn btn-default" value="Submit" />
					</div>
				</form>
			</div>
		</section>
	</div> <!---modal body end -->
	<div class="neigbour-sucess d-block modal-footer"></div>
	</div>
</div>
</div>

<!-- Grocery login end -->

<!-------Login modal------->

<!-- Snap Filters Banner Modal -->
<div id="snap_filter" class="residentdemo modal popup-design fade" role="dialog" >
	<div class="modal-dialog " role="document">
    	<div class="modal-content">
            <div class="modal-header">
                <h4>FREE Short Notice Alert Program Deals!<br>With SNAP Filters that Kill Junk Offers!</h4>
               	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="mk-left">
                <iframe src="https://www.youtube.com/embed/R4p89ui30yk" width="100%" height="auto"></iframe>
                <div class="modal-body">
                    <p style="text-align: left;">Businesses submit to Savings Sites a massive number of Deals. But only if the Deals meet all your SNAP Filters do we email you businesses deals; maintaining your privacy!</p>
                    <b style="text-align: left;">SNAP Filters:</b>
                    <p style="text-align: left;">(A) Your Minimum Discount Percentage % Required!</p>
                    <p style="text-align: left;">(B) Your Availability: The Days & Times of the Day that you can use Deals!</p>
                    <p style="text-align: center;"> You can even set different SNAP Filters for each Business!</p>
                    <p style="text-align: left;"> Choose your favorite businesses and click their SNAP OFF <img src="<?php echo base_url()  ?>/assets/businessSearch/images/snap-off.png"> to SNAP ON <img src="<?php echo base_url()  ?>/assets/businessSearch/images/snap-on.png"> and set SNAP Filters!</p> 
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Snap Filters Banner Modal -->

<div class="modal fade  peekboo-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="pbkPop0002">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Short Notice Alert Program (SNAP) Deals</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="list-inline">
                    <li>SNAP OFF: <img src="<?= base_url(); ?>/assets/businessSearch/images/snap-off.png" style="width:24px;"/></li>
                    <li>SNAP ON: <img src="<?= base_url(); ?>/assets/businessSearch/images/snap-on.png" style="width:24px;"/></li>
                </ul>
                <br />
                
                <p style="text-align: left;"><strong>SNAP Filters <img style="width:24px;" src="<?=base_url() ?>/assets/businessSearch/images/turn-on-2.png"/></strong> <span style="margin-left:15px;">(a) Minimum Discount</span> <span style="margin-left:15px;">(b) Days of Week</span><span style="margin-left:15px;">(c) Time of Day</span></p>
                
                <p style="text-align: left;">All your filters must be met! Your email address is protected as we email you, not business</p>
            </div>
        </div>
    </div>
</div>



		<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="bussiness_btn_work">

			<div class="modal-dialog" role="document">

				<div class="modal-content">

					<div class="modal-header">

						

						<h4 class="modal-title" id="myModalLabel">

							How it Works

						</h4>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

							<span aria-hidden="true">

								&times;

							</span>

						</button>

					</div>

					<div class="modal-body">

                      <p><span class="count">1</span><span class="count_des">Businesses give Great Deals because nonprofits and Municipality promotes Deals Absolutely Free. </span></p>

                      <p><span class="count">2</span><span class="count_des">Support your favorite local nonprofit! Pay a small part of discount. Get an even lower cost the more you buy.</span></p>

                      <p><span class="count">3</span><span class="count_des">You don’t pay business its deeply discounted price until you’re serviced! No expiration!</span></p>


					</div>

				</div>

			</div>

		</div>


		<!----Business How it Work Popup End ----->




		<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="foodModal">

			<div class="modal-dialog" role="document">

				<div class="modal-content">

					<div class="modal-header">

						

						<h4 class="modal-title" id="myModalLabel">

							Deals Video

						</h4>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

							<span aria-hidden="true">

								&times;

							</span>

						</button>

					</div>

					<div class="modal-body">

<iframe width="100%" height="400" src="https://www.youtube-nocookie.com/embed/USZAofevitM"></iframe>


					</div>

				</div>

			</div>

		</div>


<div class="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="ss-show">

    <div class="modal-dialog">

        <div class="modal-content">

        

            <div class="modal-body" id="view_all_comment02">
                 <button type="button" class="close" data-dismiss="modal">×</button>   

               <li>Businesses give Great Deals because we cut their costs by many thousands; then we, nonprofits, and municipality promote them absolutely free!</li>
               <li>You claim a deal by paying just a small part of the discount to support your favorite local nonprofit!</li>
               <li>You don’t pay business its deeply discounted price until you’re serviced! No expiration!</li>

            </div>

            <div class="modal-footer" hidden="true">

                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            </div>

        </div>

    </div>

</div>

	<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="pbkPop1">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4>Redemption Value</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Buyers pay seller --  <strong>at the time of purchase</strong>--the deal price to obtain the <strong>REDEMPTION VALUE</strong> of the discounted cash certificate.  </p>
					<p><strong>EXAMPLE</strong>: You pay the business $75 deal price to receive $100 <strong>REDEMPTION VALUE.</strong> </p>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="pay_bus_deal">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4>DEAL PRICE</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">
								&times;
							</span>
						</button>
					</div>
					<div class="modal-body">
					<p>The <strong>DEAL PRICE</strong> is simply the discounted price paid to the business at the time of service to obtain the redemption value. You can simply click the button <button class="btn btn-primary"><i></i>Claim Deal Price Now !</button> and obtain the deal price at any time if discounted cash certificates remain! </p>
					<p> <strong> DEAL PRICE DECREASES:</strong> If you choose to Play Peekaboo the <strong>DEAL PRICE</strong> keeps <i><b>going down</b></i> every time anyone clicks the <strong> EYES</strong> to see what the decreasing hidden <strong>DEAL PRICE</strong> is! When you registered you received 10 free peeking credits to peek at the hidden <strong> DEAL PRICE</strong>. Click the <strong>Play Peekaboo</strong> button for details on the substantial compensation package for the winner.</p>
					</div>
				</div>
			</div>
	</div>
	<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="deals_remaining">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4>REMAINING DISCOUNTED CASH CERTIFICATES</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">
								&times;
							</span>
						</button>
					</div>
					<div class="modal-body">
					<p>Businesses only provide Directory Publisher with a limited number of discounted cash certificates. This
                       number is the current number of cash certificates remaining. Grab one before they are gone. If there are no cash certificates left, add yourself to the businesses email list, so you know when it starts a new Peekaboo Auction. Under “Full Reverse Auction Details” select “New Auction Alerts.”</p>
					</div>
				</div>
			</div>
	</div>
	<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="favourite">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Add business to Favorite</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p><strong>Quickly Access Your Favorites</strong></p>
					<p>Add business to “FAVORITES” by clicking the heart outline to make it solid red:    
						Then this business will be listed when you click the sorting button:
					</p>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade dfsdfs" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="email_notice_pop_up_modal"> 
		<div class="modal-dialog">
			<div class="modal-content">		            
				<div class="modal-header">						
					<h4 class="modal-title pull-left change_title" id="myModalLabel">Snap alert</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
				</div>
				<div class="modal-body text-center" id="email_notice_pop_up">

		                <p>Processing...</p>

		            </div>

		            <div class="modal-footer" hidden="true">

		                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

		            </div>

		        </div>

		    </div>

		</div>


<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="cart_modal_checkout">
	<div class="modal-dialog modal-xl" role="document">	
		<div class="modal-content">
			<div class="modal-header">
				<h4 style="color:#fff;font-weight: 700;">Item Added</h4>
				<button id="closecartmodal" type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="text-align: center;">
				<button class="btn btn-shoping incart">Continue Shopping</button>
				<button class="btn btn-checkout checkout">Checkout</button>
			</div>
			<div class="modal-footer">
				<div id="favfooterdiv">
					
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="cart_modal_checkout_empty">
	<div class="modal-dialog modal-xl" role="document">	
		<div class="modal-content">
<!-- 			<div class="modal-header">
				<h4 style="font-weight: 700;">Cart Empty</h4>
				<button id="closecartmodal" type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span  class="close" aria-hidden="true">&times;</span>
				</button>
			</div> -->
			<div class="modal-body" style="text-align: center;">
				<p>Your Cart is Empty<br>Add something to make me happy :) </p>
				<button class="btn btn-success checkout"><a href="<?= base_url(); ?>/businessSearch/search/<?= $zone_id; ?>">Back to Business Search Page</a></button>
			</div>
<!-- 			<div class="modal-footer">
				<div id="favfooterdiv">
					
				</div>
			</div> -->
		</div>
	</div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="business_first_password">
	<div class="modal-dialog modal-xl" role="document" style="max-width: 82% !important;">	
		<div class="modal-content">
			<div class="modal-body" style="text-align: center;">
				<div>
       		<div class="top-title">
        		<h2> Change Password</h2>
         		<hr class="center-diamond">
      		</div>
          <div id="help_shot" class="container_tab_header header-default-message bv_help_shot" margin-top:10px;>
          	<p>To update the password fill up required and then click on the "Update".</p>
          </div>
          <div class="form-group center-block-table">
            <div class="row">
              <div class="col-md-6 change-pass-left">
            	<h2>Passwords must contain:</h2>
            	<li><i class="fa fa-check" aria-hidden="true"></i> Case sensitive</li>
            	<li><i class="fa fa-check" aria-hidden="true"></i> Combination of 10-18 letters</li>
            	<li><i class="fa fa-check" aria-hidden="true"></i> At least 1 Numbers (0,9)</li>
            	<li><i class="fa fa-check" aria-hidden="true"></i> Special characters (!, @, #, $, %, &amp;)</li>
            	</div>
             	<div class="col-lg-6">
  							<form id="user-form-password" class="form-validate cus-form-bussness-tab2  center-block-table cus-change-pass" enctype="multipart/form-data" name="adminForm" method="post" action="">
  								<p>
  									<label for="current_pass" class="fleft w_150">Current Password<span style="color:red;">*</span></label>
  									<input type="password" class="w_400" id="bcurrent_pass" name="current_pass"  value=""  />
  								</p>
  								<p>
  									<label for="new_pass" class="fleft w_150">New Password<span style="color:red;">*</span></label>
  									<input type="password" class="w_400" id="bnew_pass" name="new_pass"  value=""  />
  								</p>
  								<p>
  									<label for="confirm_pass" class="fleft w_150">Confirm Password<span style="color:red;">*</span></label>
  									<input type="password" class="w_400" id="bconfirm_pass" name="confirm_pass"  value="" />
  								</p>
  								<p>
  									<label for="zip1">
  										<button onclick="UpdateBusinessPassword();return false;" class="m_left_150 cus-btn" type="button">Update</button>
  									</label>
  								</p>
  							</form>
              </div>
            </div>
          </div>
        </div>
			</div>
		</div>
	</div>
</div>


<div  class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="auctionpreview">
	<div class="peekaboo_popup_inner">
		<div class="popup_certificate_area">
         	<div class="bv_auction_heading">
          		<span class="ui-dialog-title bv_title" id="ui-dialog-title-dialog">Deal Preview</span>
          		<span class="bv_close"><i class="fa fa-close"></i></span>
          	</div>
          	<div class="popup_certificate_heading_top"><span id="popup">'Cue Barbecue<br></span></div>
			<div>
				<img src="https://savingssites.com//assets/images/CashCertDeals.png" title="Gift Certificate" alt="Gift Certificate" style="width:250px;">
			</div>
			<div class="popup_certificate_heading_bottom"></div>
		</div>
		
		<div class="other-details false_case">
			<p id="first" style="margin: 0 0 0px; padding-bottom: 0px;"><b>Redemption Value: $60</b></p>
			<p id="second" style="margin: 0 0 0px; padding-bottom: 0px;"><b>Initial Asking Price: $30</b></p>
			<p id="third" style="margin: 0 0 0px; padding-bottom: 0px;"><b>Start Date: 10/21/2022</b><br><b>End Date: 11/20/2022</b></p>
			<p></p>
		</div>
	</div>
</div>


<div class="modal fade" id="about-modal" tabindex="-1" role="dialog" aria-labelledby="about-modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
       <h4 class="modal-title" id="myModalLabel">
		About
		</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body row">
        <div class="col-12 col-lg-12 col-md-12">
		<li>1.Businesses give Great Deals because nonprofits and <b>Municipality</b> promotes Deals <b>A</b>bsolutely Free. </li>
	</div>

     <div class="col-12 col-lg-12 col-md-12">
		<li>2.You claim a deal by paying just a small part of the discount to support your favorite local nonprofit!</li>
	</div>

     <div class="col-12 col-lg-12 col-md-12">
		<li>3.You don’t pay business its deeply discounted price until you’re serviced! No expiration!</li>
	</div>	
      </div>
 
    </div>
  </div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="pub_contact">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">						
				<h4 class="modal-title" id="myModalLabel">Publisher Contact</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="publisher">
					<?php   echo '<strong>' . $zone_owner->first_name . ' ' .$zone_owner->last_name. '</strong><br/>'; 
						if(!empty($zone_owner->City)){
							echo 'City: '.$zone_owner->City.'<br/>';
						} 
						if(!empty($zone_owner->State_Code && $zone_owner->State_Code != -1) )
							echo 'State Code: '.$zone_owner->State_Code.'<br/>';
						
						if(!empty($zone_owner->Zip)) echo 'Zip: '.$zone_owner->Zip.'<br/>';
						
						if(!empty($zone_owner->cell_phone)) echo 'Mobile: '.$$zone_owner->cell_phone.'<br/> ';
						
						if(!empty($zone_owner->email)) echo ' Email: '.$zone_owner->email.'<br/>';
						
						if(!empty($zone_owner->URL)) echo 'Website: '.$zone_owner->URL.'<br/>';
					?>
				</div> 
				<div class="announcements">
					<h5>Announcements</h5>
					<?php if(!empty($announcements)){ ?>
						<div id="multilines">
							<div class="container">
								<ul class="newsticker">
								<?php foreach($announcements as $announcement){ 
									echo '<li><strong>'.$announcement['title'].'</strong> from <strong>'.$announcement['name'].'</strong><br/>'.$announcement['announcement'].'</li>';
								} ?>
								</ul>
								<div class="controls"> <a class="prev-button" href="#">Prev</a> - <a class="next-button" href="#">Next</a> - <a class="stop-button" href="#">Stop</a> - <a class="start-button" href="#">Start</a> 
								</div>
							</div>
						</div>
					<?php }else {
						echo '<strong>No new Announcements</strong>';
					} ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="loadorganization">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">						
				<h4 class="modal-title" id="myModalLabel">Non Profit Organizations</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<ul>
				<?php if(isset($nonprofitorg) && count($nonprofitorg) != 0){ 
					foreach ($nonprofitorg as $value) { 
						echo '<li class="nonorganizationlist"><p>'.$value['name'].'</p></li>';
				 	} 
				} ?>
				</ul>
			
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>
<div class="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="popmodalbusiness">
	<div class="modal-dialog" role="document">
		<?php 
		if(isset($businessid)){
			$busid = $businessid;	
		}else{
			$busid = '';	
		}

		?>
	<a href="<?= base_url(); ?>/businessdashboard/businessdetail/<?= $busid; ?>/<?= $zoneid; ?>?page=businessbidrank">	<div class="modal-content">
<!-- 			<div class="modal-header">						
				<h4 class="modal-title" id="myModalLabel">Bid Start Today</h4>
				
					<span aria-hidden="true">&times;</span>
				</button>
			</div> -->
			<div class="modal-body">
				<h2>Bid Now!</h2>
				<p>Click on bid now button to <br>rank your business on top <br>and Earn Profit.</p>
				<button class="btn btn-success">Bid Now</button>
			</div>
		
		</div>
	</a>
	</div>
</div>

<div class="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="loadbusinessaddress">
	<div class="modal-dialog" role="document">
		<div class="modal-content">						
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<img src="https://i.ibb.co/Zzqrytn/home-address.png">
				<h4 class="modal-title" id="myModalLabelbus">Business Address</h4>
				<div id="baddress"></div>
			</div>
		</div>
	</div>
</div>

<div class="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="editorgimages">
	<div class="modal-dialog" role="document">
		<div class="modal-content">						
			<div class="modal-body" id="orgdataimages">
			</div>
		</div>
	</div>
</div>

<div class="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="editorgwebinar">
	<div class="modal-dialog" role="document">
		<div class="modal-content">						
			<div class="modal-body" id="orgdatawebinar">
			</div>
		</div>
	</div>
</div>

<div class="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="businesshistory">
	<div class="modal-dialog" role="document">
		<div class="modal-content">			
			<h2><center>Business History</center></h2>			
			<div class="modal-body" id="businesshistorydetaildata">
			</div>
		</div>
	</div>
</div>

<div class="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="businessoperation">
	<div class="modal-dialog" role="document">
		<div class="modal-content">			
			<h2><center>Hours Of Operation</center></h2>			
			<div class="modal-body" id="businessoperationdata">
			</div>
		</div>
	</div>
</div>

<div class="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="orginterestgroup">
	<div class="modal-dialog" role="document">
		<div class="modal-content">			
			<h2><center id="headertitle">Update Interest Group</center></h2>			
			<div class="modal-body" id="orginterestgroupdata">
			</div>
		</div>
	</div>
</div>
<div class="modal" id="videomodalzonepage">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">						
				<h4 class="modal-title" style="color: #000;font-weight: 700;">Save by Giving! Give by Saving!</h4>
				<button type="button" style="background:transparent;color: #000;" class="close videomodalzonepageclose" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<!-- <video width="100%" id="myvideo1" controls class="videoplay">
  							<source src="https://cdn.savingssites.com/box1.mp4" type="video/mp4">
							</video> -->
							<iframe scrolling="no" frameborder="0" style="width:100%; height: 337px; border:0;" src="https://app.knowmia.com/Qwfp/e"; allowfullscreen=""></iframe>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal" id="videomodalzonepage1">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">						
				<h4 class="modal-title" id="myModalLabel" style="color: #000;font-weight: 700;">Free $5 Extra for 1st Use!</h4>
				<button type="button" style="background:transparent;color: #000;" class="close videomodalzonepageclose" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<!-- <video width="100%" id="myvideo2" controls class="videoplay">
  							<source src="https://cdn.savingssites.com/box2.mp4" type="video/mp4">
							</video> -->
							<iframe scrolling="no" frameborder="0" style="width:100%; height: 337px; border:0;" src="https://app.knowmia.com/luC1/e"; allowfullscreen=""></iframe>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal" id="videomodalzonepage2">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">						
				<h4 class="modal-title" id="myModalLabel" style="color: #000;font-weight: 700;">Activities, Events, and More!</h4>
				<button type="button" style="background: transparent;color: #000;" class="close videomodalzonepageclose" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<!-- <video width="100%" id="myvideo3" controls class="videoplay">
  							<source src="https://cdn.savingssites.com/box3.mp4" type="video/mp4">
							</video> -->
							<iframe scrolling="no" frameborder="0" style="width:100%; height: 337px; border:0;" src="https://app.knowmia.com/1kVk/e"; allowfullscreen=""></iframe>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>