<?=$this->extend("layout/master")?>

<?=$this->section("pageTitle")?>
  Sponsor Registration | Savingssites
<?=$this->endSection()?>
<?=$this->section("content")?>

<section class="section section-sm bg-default text-md-left saving_business_reg">
	<div class="container">
   		<div class="row ">      
      		<div class="col-lg-12 col-md-12 col-sm-12">
        		<h2 class="white">Register as a Business Sponsor</h2>
        		<p class="form-group-row">
          			<span class="required-div" style="color:red"><font size="2">* Required Fields</font></span>
        		</p>
        		
        		<form id="registration-form" name="registration-form" method="post">
          			<input type="hidden" name="zoneId" value="<?php echo $zoneid?>">
          			<div class="row">
          				<div class="col-lg-6">
                			<table width="100%" border="0" cellspacing="0" cellpadding="5">
                            	<tr>
              						<td width="100%">
              							<label for="fname">First Name <span style="color:red">*</span></label>
                						<input type="text" class="validate[required]" name="fname" id="fname" value="" onchange="put_name();" />
              						</td>
              					</tr>
              					<tr>
              						<td width="100%">
              							<label for="email">Your Contact Email<span style="color:red">*</span></label><small>(not shared)</small>
                						<input type="text" class="validate[required,custom[email]]" name="uemail" id="uemail" value="" />
               						</td>
             					</tr>	
            					<tr>
              						<td width="100%">
              							<label for="email">Gender<span style="color:red">*</span></label> 
                						<select class="" name="gender" id="gender" style="height: 48px;">
                  							<option value="">Choose Gender</option>
                  							<option value="1">Male</option>
                  							<option value="2">Female</option>
                  							<option value="3">Other</option>
                						</select>
              						</td>
            					</tr>
            					<tr>
              						<td width="100%">
              							<label for="fname">Username<span style="color:red">*</span></label>
                						<input type="text" class="" name="username" id="sponserusername" />
              						</td>
              					</tr>
              					<tr>
              						<td width="100%">
                						<label for="password">Password <span style="color:red">*</span></label><small>Case sensitive, any combination of 5 to 18 letters, numbers and special characters (!, @, #, $, %, &)</small>
                						<input type="password" class="validate[required]" name="password" id="password" value="" />
                					</td>
           						</tr>
            					<tr>
              						<td width="100%">
              							<label for="cpassword">Confirm Password <span style="color:red">*</span></label>
                						<input type="password" class="validate[required,confirm[password]]" name="cpassword" id="cpassword" value="" />
              						</td>
              					</tr>
           					</table>
              			</div>
             			
             			<div class="col-lg-6">
            				<table width="100%" border="0" cellspacing="0" cellpadding="5">
            					<tr>
              						<td width="100%">
              							<label for="lname">Last Name <span style="color:red">*</span></label>
                						<input type="text" class="validate[required]" name="lname" id="lname" value="" onchange="put_name();"/>
              						</td>
              					</tr>
             					<tr>
              						<td width="100%">
                						<label for="name">10 digit Phone #<span style="color:red">*</span></label><small>This is your Personal/Proffesional Phone</small> 
                						<input type="text" class="validate[required]" name="name" id="phone_user" value=""/>
              						</td>
          						</tr>
           						<tr>
              						<td width="100%">
              							<label for="phone">Street Address<span style="color:red">*</span></label>
                						<input type="text" class="validate[required]" name="user_address" id="sponser_user_address" value="" />
              						</td>
              					</tr>
              					<tr>
              						<td width="100%">
              							<label for="selstate">State <span style="color:red">*</span></label>
                 						<select class="" name="selstate" id="selstate" style="height: 49px; onchange="getCity()">
                  							<option value="-1">--Select State--</option>
                							<?php if(!empty($get_all_states)){
                        						foreach($get_all_states as $val){?>
                  									<option value="<?php echo $val['state_id']; ?>"><?php echo $val['state_name']; ?></option>
                							<?php } }?>
                						</select>
              						</td>
            					</tr>
            					<tr>
              						<td width="100%">
              							<label for="selcity" style="margin-bottom: 25px;">City <span style="color:red">*</span></label>
                						<select class="" name="selcity" id="selcity" style="height: 49px;" onchange="getZone()">
                  							<option value="-1">--Select City--</option>
                						</select>
              						</td>
            					</tr>
              					<tr>
              						<td width="100%">
              							<label for="email">Postal Code<span style="color:red">*</span></label> 
                						<select class="" style="height: 49px;" name="postalcode" id="postalcode" onchange="hide_table();">
                  							<option value="-1">--Select Zip Code--</option>
                  							<?php if(!empty($all_claimed_zip)){
                    						foreach($all_claimed_zip as $val){?>
                      							<option value="<?= $val->zip; ?>"><?= $val->zip; ?></option>
                  							<?php } }?>
                						</select>
              						</td>
            					</tr>
          					</table>
        				</div>
      				</div>
					<table width="100%" border="0" cellspacing="0" cellpadding="5">
            			<?php if(empty($zoneid)){?>
            			<tr>
              				<td style="font-weight:bold; font-size:19px;" colspan="2"> INITIAL ADVERTISING DIRECTORY</td>
            			</tr>     
            			<tr>
              				<td width="100%"><label for="selstate">State <span style="color:red">*</span></label>
                 				<select class="" name="selstate" id="selstate" style="height: 32px; width: 164px;" onchange="getCity()">
                  					<option value="-1">--Select State--</option>
                					<?php if(!empty($get_all_states)){
                        			foreach($get_all_states as $val){?>
                  						<option value="<?php echo $val['state_id']; ?>"><?php echo $val['state_name']; ?></option>
                					<?php } }?>
                				</select>
              				</td>
            			</tr>
            			<tr>
              				<td width="100%">
              					<label for="selcity">City <span style="color:red">*</span></label>
                				<select class="" name="selcity" id="selcity" style="height: 32px; width: 164px;" onchange="getZone()">
                  					<option value="-1">--Select City--</option>
                				</select>
              				</td>
            			</tr>
            			<tr>
              				<td width="100%">
              					<label for="zone">Directory<span style="color:red">*</span></label>
                				<select id="selzone" style="height: 32px; width: 164px;" onchange="getZip()">
                  					<option value="-1">--Select Directory--</option>
                				</select>
              				</td>
         				</tr>
           				<?php } ?>
            			<tr>
              				<td valign="top">&nbsp;</td>
              				<td colspan="2">
              					<input type="button" name="button" id="save_sponsor_user" value="Register" class="btn btn-primary" />
                				<input type="reset" name="button2" id="button2" value="Reset" class="btn btn-secondary" />
              				</td>
            			</tr>
          			</table>
        		</form>
      		<br/>
      	</div>
    </div>  
  </div>
</section>   
<?=$this->endSection()?>