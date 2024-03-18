<?php
	$id = $firstname = $lastname = $email = $username = $password = '';
	$dataArr = [];
	$checked = 'checked';
	$buttontext = 'Save';
	if(count($businessrankbid) > 0){
		$id = $businessrankbid[0]['id'];
		$firstname = $businessrankbid[0]['firstname'];
		$lastname = $businessrankbid[0]['lastname'];
		$email = $businessrankbid[0]['email'];
		$username = $businessrankbid[0]['username'];
		$password = $businessrankbid[0]['password'];
		$data = isset($businessrankbid[0]['data'])?$businessrankbid[0]['data']:'';
		if($data != ''){
			$dataArr = unserialize($data);
		}
		$buttontext = 'Update';
	}
?>
<input type="hidden" name="zoneid" value="<?= $zoneid;?>">
<input type="hidden" name="zonename" value="<?= $zone_name;?>">
<input type="hidden" name="from_zoneid" value="<? $fromzoneid;?>">
<input type="hidden" name="approval" value="<?= $approval['approval']?>">
<input type="hidden" name="from_zoneid" id="from_zoneid" value="<?=$group_id;?>">
<input type="hidden" name="businessid" id="businessid" value="<?=$businessid;?>">
<input type="hidden" name="business_first_password_change" id="business_first_password_change" value="<?=$business_first_password_change;?>">
<div class="page-wrapper main-area toggled create_deal">
	<div class="container">
    	<div class="row" style=" margin-bottom: 80px;">
			<div class="container">
				<input type="hidden" id="subusereditid" value="<?= $id; ?>"/>
        		<div class="row">
        			<div class="col-md-12">
            			<div class="top-title">
              				<h2> Create Business Subuser</h2>
              				<p>You can create subusers who have limited access and can work on your behalf.</p>
              				<hr class="center-diamond">
            			</div>
        			</div>
        			<div class="row">
        				<div class="col-md-6">
        					<input type="hidden" id="subusertypeway" value="business" />
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
                  						
        				</div>
        			</div>
        			<br><br><br>
        			<div class="row">
        				<div class="col-md-4">
        					<div><input type=checkbox <?php if(in_array('zoneseetings',$dataArr)){echo $checked;} ?> childsub="zonesettingssub" ids="zoneseetings" id="zoneseetings"/>Business Information</div>
        					<ul>
        						<li><input type=checkbox <?php if(in_array('zs1',$dataArr)){echo $checked;} ?> class="zonesettingssub" id="zs1"/> Business Details</li>
        						<li><input type=checkbox <?php if(in_array('zs2',$dataArr)){echo $checked;} ?>  class="zonesettingssub" id="zs2" /> Deals Sell Report</li>
        						<li><input type=checkbox <?php if(in_array('zs3',$dataArr)){echo $checked;} ?>  class="zonesettingssub" id="zs3" /> Bid Payments</li>
        						<li><input type=checkbox <?php if(in_array('zs4',$dataArr)){echo $checked;} ?>  class="zonesettingssub" id="zs4" /> User Multiple Logins</li>
        					</ul>
        				</div>
        				<div class="col-md-4">
        					<div><input type=checkbox <?php if(in_array('zonesubuser',$dataArr)){echo $checked;} ?> childsub="zonesubusersub" ids="zonesubuser" id="zonesubuser"/> Business Subusers</div>
        					<ul>
        						<li><input type=checkbox <?php if(in_array('zsuser1',$dataArr)){echo $checked;} ?> class="zonesubusersub" id="zsuser1"/> Create Subusers</li>
        						<li><input type=checkbox <?php if(in_array('zsuser2',$dataArr)){echo $checked;} ?>  class="zonesubusersub" id="zsuser2"/> View Subusers</li>
        					</ul>
        				</div>
        				<div class="col-md-4">
        					<div><input type=checkbox <?php if(in_array('zoneadvertisement',$dataArr)){echo $checked;} ?> childsub="zoneadvertisementsub" ids="zoneadvertisement" id="zoneadvertisement"/> Advertisement</div>
        					<ul>
        						<li><input type=checkbox <?php if(in_array('zma1',$dataArr)){echo $checked;} ?> class="zoneadvertisementsub" id="zma1"/> Make new Advertisement</li>
        						<li><input type=checkbox <?php if(in_array('zma2',$dataArr)){echo $checked;} ?> class="zoneadvertisementsub" id="zma2" /> View Advertisements</li>
        					</ul>
        				</div>
        			</div>
        			<div class="row">
        				<div class="col-md-4">
        					<div><input type=checkbox <?php if(in_array('zonebusinessdeals',$dataArr)){echo $checked;} ?> childsub="zonebusinesssub" ids="zonebusinessdeals" id="zonebusinessdeals"/> Business Deals</div>
        					<ul>
        						<li><input type=checkbox <?php if(in_array('zcd1',$dataArr)){echo $checked;} ?> class="zonebusinesssub" id="zcd1" /> Create Deal</li>
        						<li><input type=checkbox <?php if(in_array('zcd2',$dataArr)){echo $checked;} ?> class="zonebusinesssub" id="zcd2" /> View Deals</li>
        					</ul>
        				</div>
        				<div class="col-md-4">
        					<div><input type=checkbox <?php if(in_array('zoneorganization',$dataArr)){echo $checked;} ?> childsub="zoneorganizationsub" ids="zoneorganization" id="zoneorganization"/> Business Orders</div>
        					<ul>
        						<li><input type=checkbox <?php if(in_array('zco1',$dataArr)){echo $checked;} ?> class="zoneorganizationsub" id="zco1" /> Order Approvals</li>
        						<li><input type=checkbox <?php if(in_array('zco2',$dataArr)){echo $checked;} ?> class="zoneorganizationsub" id="zco2" /> Order Status</li>
        					</ul>
        				</div>
        				<div class="col-md-4">
        					<div><input type=checkbox <?php if(in_array('zoneeverydayspecial',$dataArr)){echo $checked;} ?> childsub="zoneeverydayspecialsub" ids="zoneeverydayspecial" id="zoneeverydayspecial"/> All Business EveryDay Spc.Food</div>
        					<ul>
        						<li><input type=checkbox <?php if(in_array('zes1',$dataArr)){echo $checked;} ?> class="zoneeverydayspecialsub" id="zes1"/> Daily Specials Recordings</li>
        					</ul>
        				</div>
        			</div>
        			<div class="form_col text-center">
          				<label for="confirmpassword">&nbsp;</label>
          				<button id="save_subuser" type="button" class="btn btn-info"><?= $buttontext; ?></button>
      				</div>
        		</div>
        	</div>
  		</div>
	</div>
</div>
