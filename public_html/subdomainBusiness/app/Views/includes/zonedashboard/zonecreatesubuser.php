<?php
	$id = $firstname = $lastname = $email = $username = $password = $zipcodesassign = '';
	$dataArr = [];
	$checked = 'checked';
	$buttontext = 'Save';
	$heading_text = 'Create Zone Sub User';
	if(count($businessrankbid) > 0){
		$id = $businessrankbid[0]['id'];
		$firstname = $businessrankbid[0]['firstname'];
		$lastname = $businessrankbid[0]['lastname'];
		$email = $businessrankbid[0]['email'];
		$username = $businessrankbid[0]['username'];
		$password = $businessrankbid[0]['password'];
		$data = isset($businessrankbid[0]['data'])?$businessrankbid[0]['data']:'';
		$zipcodesassign = isset($businessrankbid[0]['zipcodesassign'])?$businessrankbid[0]['zipcodesassign']:'';
		if($data != ''){
			$dataArr = unserialize($data);
		}
		$buttontext = 'Update';
		$heading_text = 'Update Zone Sub User';
	}
?>
<input type="hidden" id="selectedzipcodes" value="<?= $zipcodesassign; ?>"/>
<div class="page-wrapper main-area toggled create_deal">
	<div class="container">
    	<div class="row" style=" margin-bottom: 80px;">
			<div class="container">
				<input type="hidden" id="subusereditid" value="<?= $id; ?>"/>
        		<div class="row">
        			<div class="col-md-12">
            			<div class="top-title">
              				<h2> <?=  $heading_text ?></h2>
              				<hr class="center-diamond">
            			</div>
        			</div>
        			<div class="row">
        				<div class="col-md-6">
        					<input type="hidden" id="subusertypeway" value="zonedashboard" />
        					<div class="form_col">
                  				<label for="fname">First Name<i class="required">*</i></label>
                  				<input name="fname" type="text" id="fname"  class="form-control" value="<?= $firstname; ?>" placeholder="Enter a First Name"/>
                  			</div>	
                  			<div class="form_col">
                  				<label for="lname">Last Name<i class="required">*</i></label>
                  				<input name="lname" type="text" id="lname" class="form-control" value="<?= $lastname; ?>" placeholder="Enter a Last Name"/>
                  			</div>
                  			<div class="form_col">
                  				<label for="email">Email<i class="required">*</i></label>
                  				<input name="email" type="text" id="email" class="form-control" value="<?= $email; ?>" placeholder="Enter a Email"/>
                  			</div>		
        					<div class="form_col">
                  				<label for="confirmemail">Confirm Email<i class="required">*</i></label>
                  				<input name="email" type="text" id="confirmemail" class="form-control" value="<?= $email; ?>" placeholder="Enter Confirm a Email"/>
                  			</div>
                  		</div>
        				<div class="col-md-6">
        					<div class="form_col">
                  				<label for="zoneusername">Username<i class="required">*</i></label>
                  				<input name="email" type="text" id="zoneusername" class="form-control" value="<?= $username ?>" placeholder="Enter a Username"/>
                  			</div>
                  			<div class="form_col">
                  				<label for="zonepassword">Password<i class="required">*</i></label>
                  				<input name="email" type="password" id="zonepassword" class="form-control" value="<?= $password; ?>" placeholder="Enter a Password"/>
                  			</div>
                  			<div class="form_col">
                  				<label for="confirmpassword">Confirm Password<i class="required">*</i></label>
                  				<input name="email" type="password" id="zoneconfirmpassword" class="form-control" value="<?= $password; ?>" placeholder="Enter a Confirm Password"/>
                  			</div>
                  			<div class="form_col">
                  				<label for="confirmpassword">Zip Codes (Leave Blank to show all)</label>
                  				<select multiple name="email" type="password" id="zonesubuserzipcodes" class="form-control">
                  					<?php 
                  						if($zipcodesassign != ''){
                  							$explodeZipArr = explode(',', $zipcodesassign);
                  							foreach ($explodeZipArr as $k => $v) {
                  								echo '<option value='.$v.'>'.$v.'</option>';
                  							}
                  						}
                  					?>
                  				</select>
                  			</div>	
                  			<div class="form_col">
                  				<label for="confirmpassword">&nbsp;</label>
                  				<button id="save_subuser" type="button" class="btn btn-info"><?= $buttontext; ?></button>
                  			</div>			
        				</div>
        			</div>
        			<br><br><br>
        			<div class="row">
        				<div class="col-md-3">
        					<div><input type=checkbox <?php if(in_array('zoneseetings',$dataArr)){echo $checked;} ?> childsub="zonesettingssub" ids="zoneseetings" id="zoneseetings"/> Zone Settings</div>
        					<ul>
        						<li><input type=checkbox <?php if(in_array('zs1',$dataArr)){echo $checked;} ?> class="zonesettingssub" id="zs1"/> Zone Details</li>
        						<li><input type=checkbox <?php if(in_array('zs2',$dataArr)){echo $checked;} ?>  class="zonesettingssub" id="zs2" /> Email Format</li>
        						<li><input type=checkbox <?php if(in_array('zs3',$dataArr)){echo $checked;} ?>  class="zonesettingssub" id="zs3" /> Refer Link Generate</li>
        						<li><input type=checkbox <?php if(in_array('zs4',$dataArr)){echo $checked;} ?>  class="zonesettingssub" id="zs4" /> Payment Settings</li>
        						<li><input type=checkbox <?php if(in_array('zs7',$dataArr)){echo $checked;} ?>  class="zonesettingssub" id="zs7" /> Twilio Account Settings</li>
        						<li><input type=checkbox <?php if(in_array('zs5',$dataArr)){echo $checked;} ?>  class="zonesettingssub" id="zs5" /> Donation Claiming Report</li>
        						<li><input type=checkbox <?php if(in_array('zs6',$dataArr)){echo $checked;} ?>  class="zonesettingssub" id="zs6" /> Organization Fee Percentage Report</li>
        					</ul>
        				</div>
        				<div class="col-md-3">
        					<div><input type=checkbox <?php if(in_array('zonesubuser',$dataArr)){echo $checked;} ?> childsub="zonesubusersub" ids="zonesubuser" id="zonesubuser"/> Zone Sub User's</div>
        					<ul>
        						<li><input type=checkbox <?php if(in_array('zsuser1',$dataArr)){echo $checked;} ?> class="zonesubusersub" id="zsuser1"/> Create Sub Users</li>
        						<li><input type=checkbox <?php if(in_array('zsuser2',$dataArr)){echo $checked;} ?>  class="zonesubusersub" id="zsuser2"/> View Sub Users</li>
        					</ul>
        				</div>
        				<div class="col-md-3">
        					<div><input type=checkbox <?php if(in_array('zonecategories',$dataArr)){echo $checked;} ?> childsub="zonecategoriessub" ids="zonecategories" id="zonecategories"/> Categories</div>
        					<ul>
        						<li><input type=checkbox <?php if(in_array('zc1',$dataArr)){echo $checked;} ?> class="zonecategoriessub" id="zc1" /> Manage Categories</li>
        					</ul>
        				</div>
        				<div class="col-md-3">
        					<div><input type=checkbox <?php if(in_array('zonebusiness',$dataArr)){echo $checked;} ?> childsub="zonebuainesssub" ids="zonebusiness" id="zonebusiness"/> Businesses</div>
        					<ul>
        						<li><input type=checkbox <?php if(in_array('zab1',$dataArr)){echo $checked;} ?> class="zonebuainesssub" id="zab1"/> Add Business</li>
        						<li><input type=checkbox <?php if(in_array('zab2',$dataArr)){echo $checked;} ?>  class="zonebuainesssub" id="zab2" /> My Zone Business</li>
        						<li><input type=checkbox <?php if(in_array('zab7',$dataArr)){echo $checked;} ?>  class="zonebuainesssub" id="zab7" /> Communication Method</li>
        						<li><input type=checkbox <?php if(in_array('zab3',$dataArr)){echo $checked;} ?>  class="zonebuainesssub" id="zab3" /> Rank Business</li>
        						<li><input type=checkbox <?php if(in_array('zab4',$dataArr)){echo $checked;} ?>  class="zonebuainesssub" id="zab4" /> Rank Business Sub Category</li>
        						<li><input type=checkbox <?php if(in_array('zab5',$dataArr)){echo $checked;} ?>  class="zonebuainesssub" id="zab5" /> Business Users</li>
        						<li><input type=checkbox <?php if(in_array('zab6',$dataArr)){echo $checked;} ?>  class="zonebuainesssub" id="zab6" /> Business Bid Rank</li>
        					</ul>
        				</div>
        			</div>
        			<div class="row">
        				<div class="col-md-3">
        					<div><input type=checkbox <?php if(in_array('zoneadvertisement',$dataArr)){echo $checked;} ?> childsub="zoneadvertisementsub" ids="zoneadvertisement" id="zoneadvertisement"/> Advertisement</div>
        					<ul>
        						<li><input type=checkbox <?php if(in_array('zma1',$dataArr)){echo $checked;} ?> class="zoneadvertisementsub" id="zma1"/> Make new Advertisement</li>
        						<li><input type=checkbox <?php if(in_array('zma2',$dataArr)){echo $checked;} ?> class="zoneadvertisementsub" id="zma2" /> View Advertisement</li>
        					</ul>
        				</div>
        				<div class="col-md-3">
        					<div><input type=checkbox <?php if(in_array('zonebusinessdeals',$dataArr)){echo $checked;} ?> childsub="zonebusinesssub" ids="zonebusinessdeals" id="zonebusinessdeals"/> Business Deals</div>
        					<ul>
        						<li><input type=checkbox <?php if(in_array('zcd1',$dataArr)){echo $checked;} ?> class="zonebusinesssub" id="zcd1" /> Create Deal</li>
        						<li><input type=checkbox <?php if(in_array('zcd2',$dataArr)){echo $checked;} ?> class="zonebusinesssub" id="zcd2" /> View Deal</li>
        						<li><input type=checkbox <?php if(in_array('zcd3',$dataArr)){echo $checked;} ?> class="zonebusinesssub" id="zcd3" /> Deals Sell Report</li>
        						<li><input type=checkbox <?php if(in_array('zcd4',$dataArr)){echo $checked;} ?> class="zonebusinesssub" id="zcd4" /> Business Deals Email Report</li>
        						<li><input type=checkbox <?php if(in_array('zcd5',$dataArr)){echo $checked;} ?> class="zonebusinesssub" id="zcd5" /> Business Deals IVR Report</li>
        						<li><input type=checkbox <?php if(in_array('zcd6',$dataArr)){echo $checked;} ?> class="zonebusinesssub" id="zcd6" /> Business Deal Approval DPA Report</li>
        					</ul>
        				</div>
        				<div class="col-md-3">
        					<div><input type=checkbox <?php if(in_array('zoneorganization',$dataArr)){echo $checked;} ?> childsub="zoneorganizationsub" ids="zoneorganization" id="zoneorganization"/> Organization</div>
        					<ul>
        						<li><input type=checkbox <?php if(in_array('zco1',$dataArr)){echo $checked;} ?> class="zoneorganizationsub" id="zco1" /> Create Organization</li>
        						<li><input type=checkbox <?php if(in_array('zco2',$dataArr)){echo $checked;} ?> class="zoneorganizationsub" id="zco2" /> View Organization</li>
        						<li><input type=checkbox <?php if(in_array('zco3',$dataArr)){echo $checked;} ?> class="zoneorganizationsub" id="zco3" /> Organization users</li>
        						<li><input type=checkbox <?php if(in_array('zco4',$dataArr)){echo $checked;} ?> class="zoneorganizationsub" id="zco4" /> Organization Fee Report</li>
        					</ul>
        				</div>
        				<div class="col-md-3">
        					<div><input type=checkbox <?php if(in_array('zoneeverydayspecial',$dataArr)){echo $checked;} ?> childsub="zoneeverydayspecialsub" ids="zoneeverydayspecial" id="zoneeverydayspecial"/> All Business EveryDay Spc.Food</div>
        					<ul>
        						<li><input type=checkbox <?php if(in_array('zes1',$dataArr)){echo $checked;} ?> class="zoneeverydayspecialsub" id="zes1"/> Daily Specials Recordings</li>
        					</ul>
        				</div>
        			</div>
        		</div>
        	</div>
  		</div>
	</div>
</div>
