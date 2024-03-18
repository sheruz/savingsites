<style>
	.accordion-toggle span:before {
		/* symbol for "opening" panels */
		font-family: 'FontAwesome';   /* essential for enabling glyphicon */
		content: "\f107";    /* adjust as needed, taken from bootstrap.css */
		float: left;        /* adjust as needed */
		color: #fff;          /* adjust as needed */
		font-style: normal;
		position: absolute;
		left: 10px;
		font-size: 18px;
		top: 12px;
	}
	.accordion-toggle.collapsed span:before {
		/* symbol for "collapsed" panels */
		content: "\f106";       /* adjust as needed, taken from bootstrap.css */
	}
	.accordion-toggle{
		cursor: pointer;
	}

</style>



<input type="hidden" name="user_all_info" value='<?php echo json_encode($user_info); ?>'>

<?php
 

$numItems = count($adlist);
$count = 0;


   function check_file($filename){

							
							$file_headers = get_headers($filename,1);
 

 
							$urlpars = parse_url($filename);

							$ext = array('png', 'jpg', 'jpeg', 'gif'); 

 	                        $img_extension = pathinfo($filename, PATHINFO_EXTENSION);	

							if($file_headers[0] == 'HTTP/1.0 404 Not Found'){
							      
							}else if(!file_exists($_SERVER['DOCUMENT_ROOT'].$urlpars['path'])){

							} else if($urlpars['scheme'] != 'https' && $urlpars['scheme'] != 'http'){


							}else if(!in_array($img_extension, $ext)){

							}   else {
							   return 1;
							}
					}


foreach ($adlist as $ad) {

	$peekaboorandval="";
	$peekaboorandval=rand();

	$share_ad_id=(empty($ad['deal_title']))? $ad['adid'] : $ad['deal_title'];

	// $getRestaurentUser = $this->ad->getResturentUser($ad['bs_id']);
	// $getRestaurantOfferDetails = array();
	// if ($getRestaurentUser) {
	// 	$getRestaurantOfferDetails = $this->diningmodel->getBusinessDiningOfferDetails($ad['bs_id']);
	// }
	// $getTimeSlotBookingStaatus = $this->ad->getTimeSlotBookingStatus($ad['bs_id'],1);
	

					        	if (!empty($ad['bus_image'])) {			

										$image_arrs = explode(',',$ad['bus_image']);

				 
										foreach ($image_arrs as $key => $img){ 
											// Open file
				 
											$handle = @check_file(base_url().'uploads/businessphoto/'. $ad['bs_id'] .'/'.$img);
											// Check if not file exists
									 
											
											if(!$handle){
												unset($image_arrs[$key]);
											}
										}	

						      		$handle2 = @check_file(base_url().'uploads/businessphoto/'. $ad['bs_id'] .'/'.$image_arrs[0]);
										// Check if file exists
										if(!$handle2){
											$dealImage = '';
										}
										else{
										$dealImage = base_url().'uploads/businessphoto/'. $ad['bs_id'] .'/'. $image_arrs[0];

										}



									}


				                 	// removing the blank images from array 
				                  	$file_extensions = array('jpg','jpeg','png' , 'gif');
										foreach ($image_arrs as $key => $img){ 
															// Open file
								 
												$handle = @check_file(base_url().'uploads/businessphoto/'. $ad['bs_id'] .'/'.$img);
												// Check if not file exists
									

												$img_extension = pathinfo($img, PATHINFO_EXTENSION);		
												
												if(!$handle){
													unset($image_arrs[$key]);
												}else if(!in_array($img_extension, $file_extensions)){
					                               unset($image_arrs[$key]);
												}
											}	


								// finding the advertisment image is empty or not					  
								$advertismentImage = @$ad['adtext'];
		                        
		                        if(@$advertismentImage){

								preg_match( '@src="([^"]+)"@' , $advertismentImage, $match );

								$src_sliderimages = array_pop($match);
								
								$imagesizedata = @check_file($src_sliderimages);  

						    	}





?>


	<section data-busid="<?php echo $ad['bs_id'] ?>" data-adid="<?php echo $ad['adid'] ?>" class="offer-outer-contest section section-sm bg-default text-md-left" style="padding-bottom: 0;">

		<!-- New design start -->
		<div class="container">
			<div class="row justify-content-center align-items-center">
				<div class="col-12 col-xl-6 col-lg-6 col-md-8 col-sm-12 mobile_view">
					<div class="business-logo">
						<?php
						if (!empty($ad['bs_logo'])) {
						?>

						<img src="<?php echo $ad['bs_logo'] ?>" style="padding-bottom: 25px;"/>
						<?php } else {
						?>
						<h6 class="text-center">
							<strong><?php echo $ad['bs_name'] ?></strong></h6>

						<?php } ?>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="offers-bdr s" style="border-bottom-left-radius: 0;border-bottom-right-radius: 0;border-bottom-width: 0;" >
						<div class="row justify-content-center align-items-center">
							<div class="col-12 col-xl-3 col-lg-3 col-md-3 col-sm-6 mobile_view">
								<?php
								if (!empty($ad['peekaboolist'])) {
								?>
								<div class="pboo-ad">
									<div class="owl-carousel owl-theme" data-center="true" data-autoplay="true" data-nav="true">
										<?php $count = 0;
										foreach ($ad['peekaboolist'] as $ra) {
										?>
										<div class="item">
											<div class="pboo-ad-wrapper fdgdf">
												<div class="text-center"><img src="<?php echo base_url() ?>assets/images/logos/pboo1.png" /></div>
												<!--                 <table>
												<tr>
												<td>Redemption Value <a class="pkbpop1" href="#" data-title="Title" data-content="Some Description<br>Some other description" data-toggle="modal" data-target="#pbkPop1"><i class="fa fa-info-circle"></i></a></td>
												<td style="text-align: center;">$<?php echo  number_format($ra['buy_price_decrease_by'],2)?></td>
												</tr>
												<tr>
												<td>Pay when Serviced <a class="pkbpop1" href="#" data-toggle="modal" data-target="#consulwinner"><i class="fa fa-info-circle"></i></a></td>
												<td style="text-align: center;">$33</td>
												</tr>
												<tr>
												<td>ORG Donation Fee <a class="pkbpop1" href="#" data-toggle="modal" data-target="#pbkPop12" data-title="Title" data-content="Some Description<br>Some other description"><i class="fa fa-info-circle"></i></a></td>
												<td style="text-align: center;">$<?php echo  number_format($ra['publisher_fee'],2)?></td>
												</tr>
												</table> -->

												<table>
													<tr>
														<td>Redemption Value </td>
														<td style="text-align: end;">$<?php echo  number_format($ra['buy_price_decrease_by'],2) ?>
															<a class="pkbpop1" href="#" data-title="Title" data-content="Some Description<br>Some other description" data-toggle="modal" data-target="#pbkPop1"><img class="img-responsive" src="<?php echo base_url() ?>/assets/stylesheets/images/info-icon-27.png"/></a></td>
													</tr>
													<tr>
														<td>Pay when Serviced </a></td>
														<td style="text-align: end;">$10.00<a class="pkbpop1" href="#" data-toggle="modal" data-target="#consulwinner"><img class="img-responsive" src="<?php echo base_url() ?>/assets/stylesheets/images/info-icon-27.png"/></td>
													</tr>
													<tr>
														<td>ORG Donation Fee </a></td>
														<td style="text-align: end;">$<?php echo  number_format($ra['publisher_fee'],2) ?><a class="pkbpop1" href="#" data-toggle="modal" data-target="#pbkPop12" data-title="Title" data-content="Some Description<br>Some other description"><img class="img-responsive" src="<?php echo base_url() ?>/assets/stylesheets/images/info-icon-27.png"/></td>
													</tr>
														<tr>
														<td>Net Savings </a></td>	 
														<?php    $savings = @$ra['buy_price_decrease_by'] -  @$ra['current_price'] - @$ra['publisher_fee']  ?>
														<td style="text-align: end;">$<?php echo  number_format($savings,2) ?><a class="pkbpop1" href="#" data-toggle="modal" data-target="#pbkPop12" data-title="Title" data-content="Some Description<br>Some other description"><img class="img-responsive" src="<?php echo base_url() ?>assets/stylesheets/images/info-icon-27.png"/></td>
													</tr>

													<tr>
														<td>Max # of Cash Certs </td>
														<td style="text-align: end;">

															<!-- <?=!empty($numberofconsolation) ? '$' : ''; ?><?php echo  $numberofconsolation; ?> -->
															<?php if($ra['numberofconsolation']!='' && $ra['numberofconsolation']!=0){ echo $ra['numberofconsolation']; } else { echo "No Cap"; } ?>

															<a class="pkbpop1" href="#" data-toggle="modal" data-target="#pbkPop12" data-title="Title" data-content="Some Description<br>Some other description"><img class="img-responsive" src="<?php echo base_url() ?>/assets/stylesheets/images/info-icon-27.png"/></a></td>
													</tr>
												</table>
												<div class="text-center">
													<!-- <a data-snap-status="<?php echo $ad['snap_status']; ?>" data-adid="<?php echo $ad['adid'] ?>" data-type="2" data-from="snap_status_change_from_claim" data-createdby-id="<?php echo $ad['bs_id'] ?>" data-user-id="<?= $user_id ?>" data-zone-id="<?= $zone ?>" href="javascript:void(0)" target="_blank" class="btn btn-primary snap_status_change_from_claim">Donate & Claim Now!</a> -->

														<a data-userid="<?= $ad['user_member_data']->user_id ?>" data-fname="<?php echo $ad['useremail']['first_name'] ?>"  data-email="<?php echo $ad['useremail']['email'] ?>" data-company="<?php echo $ad['company_name'] ?>" data-lname="<?php echo $ad['useremail']['last_name'] ?>"  data-snap-status="<?php echo $ad['snap_status']; ?>" data-adid="<?php echo $ad['adid'] ?>" data-type="<?php echo $ad['bs_type'] ?>" data-aucid="<?php echo $ad['peekaboolist'][$count]['auc_id'] ?>" data-from="snap_status_change_from_claim" data-createdby-id="<?php echo $ad['bs_id'] ?>" data-user-id="<?= $user_id ?>" data-zone-id="<?= $zone ?>" href="javascript:void(0)"  class="test btn btn-primary snap_status_change_from_claim">Donate & Claim Now!</a>


												</div>
												<div class="text-center">
													<a class="full_details" href="javascript:void(0)" data-adid="<?php echo $ad['adid'] ?>" style="text-decoration: underline;">Full Details</a></div>
											</div>
										</div>
										<?php  $count++; }  ?>

									</div>

								</div>
								<?php } else {
								?>
 
								<div class="col-8 col-xl-3 col-lg-3 col-md-3 col-sm-6">
									<div class="">
										<div class="" data-center="true" data-autoplay="true" data-nav="true">
											<div class="">
												<div class="">
													<div class="text-center"><img class="support_img" src="http://savingssites.com/assets/businessSearch/images/support_orgs.jpg" /></div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php } ?>
							</div>
							<div class="col-4 col-xl-3 col-lg-3 col-md-4 col-sm-6 text-center">
								<?php
								if (!empty($user_id)) {
								?>

								<div class="snapdiv snapdiv<?php echo $ad['adid'] ?>">
									<?php
									if ($ad['snap_status'] == 1) {
									?>

									<a class="toggle-on-off-img on emailnoticepopup mobile_hide" style="cursor: pointer;" data-target="#email_notice_pop_up_modal" data-toggle="modal" data-adid="<?php echo $ad['adid'] ?>" data-busid="<?php echo $ad['bs_id'] ?>" data-userid="<?php echo $user_id ?>"><img data-on="images/turn-on.png" data-off="<?=$link_path ?>assets/directory/images/turn-off.png" src="<?=$link_path ?>assets/directory/images/turn-on.png" class="for-img-shadow"/></a>

									<a class="toggle-on-off-img on emailnoticepopup mobile_view" style="cursor: pointer;" data-target="#email_notice_pop_up_modal" data-toggle="modal" data-adid="<?php echo $ad['adid'] ?>" data-busid="<?php echo $ad['bs_id'] ?>" data-userid="<?php echo $user_id ?>"><img data-on="images/turn-on-mobile.png" data-off="<?=$link_path ?>assets/directory/images/turn-off-mobile.png" src="<?=$link_path ?>assets/directory/images/turn-on-mobile.png" class="for-img-shadow"/></a>

									<span class="snappop" style="cursor: pointer;" data-toggle="modal" data-target="#snapPop9">
										<i class="fa fa-info-circle"></i></span>

									<?php } else {
									?>
									<a class="toggle-on-off-img on emailnoticepopup mobile_hide" style="cursor: pointer;" data-target="#email_notice_pop_up_modal" data-toggle="modal" data-adid="<?php echo $ad['adid'] ?>" data-busid="<?php echo $ad['bs_id'] ?>" data-userid="<?php echo $user_id ?>" ><img data-on="images/turn-on.png" data-off="<?=$link_path ?>assets/directory/images/turn-off.png" src="<?=$link_path ?>assets/directory/images/turn-off.png" class="for-img-shadow"/></a>

									<a class="toggle-on-off-img on emailnoticepopup mobile_view" style="cursor: pointer;" data-target="#email_notice_pop_up_modal" data-toggle="modal" data-adid="<?php echo $ad['adid'] ?>" data-busid="<?php echo $ad['bs_id'] ?>" data-userid="<?php echo $user_id ?>"><img data-on="images/turn-on-mobile.png" data-off="<?=$link_path ?>assets/directory/images/turn-off-mobile.png" src="<?=$link_path ?>assets/directory/images/turn-off-mobile.png" class="for-img-shadow"/></a>

									<span class="snappop" style="cursor: pointer;" data-toggle="modal" data-target="#snapPop9">
										<i class="fa fa-info-circle"></i></span>

									<?php } ?>
										<a href="javascript:void(0);" class="snaptogglecog" data-toggle="popover" data-trigger="hover" data-placement="right" data-adid="<?php echo $ad['adid'] ?>" data-busid="<?php echo $ad['bs_id'] ?>" data-userid="<?php echo $user_id ?>">
										<i class="fa fa-filter"></i></a>
								</div>
								<?php } else { ?>
								<div class="snapdiv">
									<a class="toggle-on-off-img on clicksnapsignup mobile_hide" data-target="#login-box" data-toggle="modal" style="cursor: pointer;"><img data-on="images/turn-on.png" data-off="<?=$link_path ?>assets/directory/images/turn-off.png" src="<?=$link_path ?>assets/directory/images/turn-off.png" class="for-img-shadow" data-target="login-box" data-toggle="modal"/></a>

									<a class="toggle-on-off-img on clicksnapsignup mobile_view"><img data-on="images/turn-on-mobile.png" data-off="<?=$link_path ?>assets/directory/images/turn-off-mobile.png" src="<?=$link_path ?>assets/directory/images/turn-off-mobile.png" class="for-img-shadow" data-target="login-box" data-toggle="modal"/></a>
									<span class="snappop" style="cursor: pointer;" data-toggle="modal" data-target="#snapPop9">
										<i class="fa fa-info-circle"></i></span>
										<a href="javascript:void(0);" class="snaptogglecog-login" data-toggle="popover" data-trigger="hover" data-placement="right" data-title="Opt-in status - Login">
										<i class="fa fa-filter"></i></a>
									<div class="webui-popover-content">	
										<ul class="dropdown-menu">
												<li>
												<a class="dropdown-item toggle-btn-pop loginTextChange" href="javascript:void(0);" data-toggle="modal" data-target="#login-box" id="neighbors_login" title="neighbour_login">Residents</a></li>
												<li>
														<a class="dropdown-item toggle-btn-pop loginTextChange" href="javascript:void(0);" data-toggle="modal" data-target="#login-box" id="businesses_login" title="businesses_login">Businesses</a></li>
												<li>
													<a class="dropdown-item toggle-btn-pop loginTextChange" href="javascript:void(0);" data-toggle="modal" data-target="#login-box" id="organisations_login" title="organisations_login">Orgs/Schools/City</a></li>
										</ul>					
									</div>
								</div>
								<?php } ?>
							</div>
							<div class="col-12 col-xl-6 col-lg-6 col-md-8 col-sm-12 desktop_view">
								<div class="business-logo heading_center">
									<?php
									if (!empty($ad['bs_logo'])) {
									?>

									<img src="<?php echo $ad['bs_logo'] ?>"/>
									<?php } else {
									?>
									<h6 class="text-center">
										<strong><?php echo $ad['bs_name'] ?></strong></h6>

									<?php } ?>
								</div>
							</div>
							<div class="col-8 col-xl-3 col-lg-3 col-md-3 col-sm-12 desktop_view">
								<?php
								if (!empty($ad['fullview'])) {
								?>
								<div class="pboo-ad">
									<div class="owl-carousel owl-theme" data-center="true" data-autoplay="true" data-nav="true">
										<?php $count = 0;
										foreach ($ad['fullview'] as $ra) {
										?>
										<div class="item">
											<div class="pboo-ad-wrapper">
												<div class="text-center"> <p><b>Give by Saving!</b></p></div>
											    <table>
													<tr>
														<td>Redemption Value </td>
														<td style="text-align: end;">$<?php echo  number_format($ra['buy_price_decrease_by'],2) ?>
															<a class="pkbpop1" href="#" data-title="Title" data-content="Some Description<br>Some other description" data-toggle="modal" data-target="#pbkPop1"><img class="img-responsive" src="<?php echo base_url() ?>/assets/stylesheets/images/info-icon-27.png"/></a></td>
													</tr>
													<tr>
														<td>Price to Pay Business </td>
														<td style="text-align: end;">$10.00
															<a class="pkbpop1" href="#" data-toggle="modal" data-target="#consulwinner"><img class="img-responsive" src="<?php echo base_url() ?>/assets/stylesheets/images/info-icon-27.png"/></a></td>
													</tr>
													<tr>
														<td>ORG Donate & Claim </td>
														<td style="text-align: end;">$<?php echo  number_format($ra['publisher_fee'],2) ?>
															<a class="pkbpop1" href="#" data-toggle="modal" data-target="#pbkPop12" data-title="Title" data-content="Some Description<br>Some other description"><img class="img-responsive" src="<?php echo base_url() ?>/assets/stylesheets/images/info-icon-27.png"/></a></td>
													</tr>
														<tr>
														<td>Net Savings </a></td>	 
														<?php    $savings = @$ra['buy_price_decrease_by'] -  @$ra['current_price'] - @$ra['publisher_fee']  ?>
														<td style="text-align: end;">$<?php echo  number_format($savings,2) ?><a class="pkbpop1" href="#" data-toggle="modal" data-target="#pbkPop12" data-title="Title" data-content="Some Description<br>Some other description"><img class="img-responsive" src="<?php echo base_url() ?>assets/stylesheets/images/info-icon-27.png"/></td>
													</tr>
													
													<tr>
														<td>Max # of Cash Certs </td>
														<td style="text-align: end;">
															<!-- <?=!empty($numberofconsolation) ? '$' : ''; ?><?php echo  $numberofconsolation; ?> -->

															<?php if($ra['numberofconsolation']!='' && $ra['numberofconsolation']!=0){ echo $ra['numberofconsolation']; } else { echo "No Cap"; } ?>

															<a class="pkbpop1" href="#" data-toggle="modal" data-target="#pbkPop12" data-title="Title" data-content="Some Description<br>Some other description"><img class="img-responsive" src="<?php echo base_url() ?>/assets/stylesheets/images/info-icon-27.png"/></a></td>
													</tr>
												</table>
												<div class="text-center">
													<!-- <a data-snap-status="<?php echo $ad['snap_status']; ?>" data-adid="<?php echo $ad['adid'] ?>" data-type="2" data-from="snap_status_change_from_claim" data-createdby-id="<?php echo $ad['bs_id'] ?>" data-user-id="<?= $user_id ?>" data-zone-id="<?= $zone ?>" href="javascript:void(0)" target="_blank" class="btn btn-primary snap_status_change_from_claim">Donate & Claim Now!</a> -->

													<a data-userid="<?= $ad['user_member_data']->user_id ?>" data-fname="<?php echo $ad['useremail']['first_name'] ?>"  data-email="<?php echo $ad['useremail']['email'] ?>" data-company="<?php echo $ad['company_name'] ?>" data-lname="<?php echo $ad['useremail']['last_name'] ?>"  data-snap-status="<?php echo $ad['snap_status']; ?>" data-adid="<?php echo $ad['adid'] ?>" data-type="<?php echo $ad['bs_type'] ?>" data-aucid="<?php echo $ad['peekaboolist'][$count]['auc_id'] ?>" data-from="snap_status_change_from_claim" data-createdby-id="<?php echo $ad['bs_id'] ?>" data-user-id="<?= $user_id ?>" data-zone-id="<?= $zone ?>" href="javascript:void(0)"  class="test btn btn-primary snap_status_change_from_claim">Donate & Claim Now!</a>




												</div>
												<div class="text-center">
													<a class="full_details" href="javascript:void(0)" data-adid="<?php echo $ad['adid'] ?>" style="text-decoration: underline;">Full Details</a></div>
											</div>
										</div>
										<?php $count++;  }   ?>

									</div>

								</div>
								<?php } else {
								?>

								<div class="col-8 col-xl-3 col-lg-3 col-md-3 col-sm-6">
									<div class="">
										<div class="" data-center="true" data-autoplay="true" data-nav="true">
											<div class="">
												<div class="">
													<div class="text-center"><img class="support_img" src="http://savingssites.com/assets/businessSearch/images/support_orgs.jpg" /></div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
		<!-- New design end -->
	</section>
	<section class="section bg-default text-md-left">
		<div class="container">
			<?php
			if (!empty($ad['peekaboolist'])) {
				$style1 = " border-bottom-width:0; ";
				$style2 = "";
			} else {
				$style1 = "";
				$style2 = " border-bottom: 1px solid #ddd; ";
			}
			?>
			<div class="row row-50 justify-content-center align-items-xl-center main" style="border-top-width:0;<?php echo $style1; ?>">
				<div class="col-sm-12">

					<div style="<?php echo $style2; ?>" class="offers" id="offers">
						<div class="tabs-custom tabs-vertical tabs-line tabs-menu" id="tabs-3-1" data-adid="<?php echo $ad['adid'] ?>" style=" border-bottom-width:0;border-top-width:0;">
							<ul class="nav nav-tabs mobile_hide">
								<li class="nav-item" role="presentation">
									<a class="nav-link offertab active" href="#tabs-1-<?php echo $ad['adid'] ?>" data-toggle="tab" style="border:1px solid #deece6;">
										<i class="fa fa-gift"></i> Offers</a></li>
								<?php
								if ($ad['bus_image']) {
								?>
								<li class="nav-item" role="presentation">
									<a class="nav-link" href="#tabs-2-<?php echo $ad['adid'] ?>" data-toggle="tab">
										<i class="fa fa-picture-o"></i> Photos  (<?php
                                         $textImage =  0 ;                                      
                                          if(@$imagesizedata){  $textImage = count($ad['adtext']); }  
										if ($ad['bus_image'] !='') {

											   echo count($image_arrs) + $textImage;     
											}else if(@$advertismentImage){
									
                                    	   echo sum(count($image_arrs) + $textImage);
                                    	   }else {
											echo 0; }; 
										?>)
									</a></li>
								<?php } ?>
								<?php
								if (!empty($ad['video_file'])) {
								?>
								<li class="nav-item" role="presentation">
									<a class="nav-link" href="#tabs-3-<?php echo $ad['adid'] ?>" data-toggle="tab">
										<i class="fa fa-video-camera"></i> Videos</a></li>
								<?php } ?>

								<?php
								if (empty($user_id)) {
								?>
								<li class="nav-item" role="presentation">
									<a class="nav-link clicksnapsignup" data-target="#login-box" data-toggle="modal">
										<i class="fa fa-comment-o"></i> Comments</a></li>
								<?php } else {
								?>
								<li class="nav-item" role="presentation">
									<a class="nav-link comment-sec" href="#tabs-18-<?php echo $ad['adid'] ?>" data-toggle="tab" data-adid="<?php echo $ad['adid'] ?>">
										<i class="fa fa-comment-o"></i> Comments</a></li>
								<?php } ?>
								<?php
								if (empty($user_id)) {
								?>
								<li class="nav-item" role="presentation">
									<a class="nav-link clicksnapsignup" data-target="#login-box" data-toggle="modal">
										<i class="fa fa-share-alt"></i> Share</a></li>
								<?php } else {
								?>
								<li class="nav-item" role="presentation">
									<a class="nav-link share-sec" href="#tabs-19-<?php echo $ad['adid'] ?>" data-toggle="tab" data-adid="<?php echo $ad['adid'] ?>">
										<i class="fa fa-share-alt"></i> Share</a></li>
								<?php } ?>


								<?php
								if (empty($user_id)) {
								?>
								<li class="nav-item" role="presentation">
									<a class="nav-link clicksnapsignup" data-target="#login-box" data-toggle="modal">
										<i class="fa fa-heart"></i> Add Favorite</a></li>
								<?php } else {
								?>
								<li class="nav-item" role="presentation">
									<a class="nav-link ad-menu-favorite" href="#tabs-4-<?php echo $ad['adid'] ?>" data-toggle="tab" data-adid="<?php echo $ad['adid'] ?>">
										<i class="fa fa-heart"></i> Add Favorite</a></li>
								<?php } ?>
								<?php
								if ($ad['bs_type'] ==1 /*&& empty($ad['selectMenu'])*/) {
								?>
								<?php
								if ($ad['reservationdetail']['menutab_status']==1) {
								?>
								<?php
								if (!empty($ad['selectMenu']) && $ad['selectMenu']['create_type'] == 1) {
								?>
								<li class="nav-item" role="presentation">
									<a class="nav-link " href="#tabs-5-<?php echo $ad['adid'] ?>" data-id="<?=$ad['adid'] ?>" data-businessId = "<?= $ad['bs_id'] ?>" data-toggle="tab">
										<i class="fa fa-list"></i> Our Menu</a></li>
								<?php } else {
								?>
								<li class="nav-item" role="presentation">
									<a class="nav-link show_food_menu" href="#tabs-5-<?php echo $ad['adid'] ?>" data-id="<?=$ad['adid'] ?>" data-businessId = "<?= $ad['bs_id'] ?>" data-toggle="tab">
										<i class="fa fa-list"></i> Our Menu</a></li>
								<?php }} } ?>
								<?php
								if ($ad['bs_type'] ==1 /*&& empty($ad['selectMenu'])*/) {
								?>
								<?php
								if ($ad['reservationdetail']['menutab_status']==1) {
								?>
								<?php
								if (!empty($ad['selectMenu']) && $ad['selectMenu']['create_type'] == 1) {
								?>
								<li class="nav-item" role="presentation">
									<a class="nav-link " href="#tabs-15-<?php echo $ad['adid'] ?>" data-id="<?=$ad['adid'] ?>" data-businessId = "<?= $ad['bs_id'] ?>" data-toggle="tab">
										<i class="fa fa-cutlery"></i> Online Ordering</a></li>
								<?php } else {
								?>
								<li class="nav-item" role="presentation">
									<a class="nav-link" href="#tabs-15-<?php echo $ad['adid'] ?>" data-id="<?=$ad['adid'] ?>" data-businessId = "<?= $ad['bs_id'] ?>" data-toggle="tab">
										<i class="fa fa-cutlery"></i> Online Ordering</a></li>
								<?php }} } ?>
								<?php
								if ($ad['bs_type'] ==1) {
								?>
								<?php
								if ($ad['reservationdetail']['reservation_status']==1) {
								?>
								<?php
								if (empty($user_id)) {
								?>
								<li class="nav-item" role="presentation">
									<a class="nav-link clicksnapsignup" data-target="#login-box" data-toggle="modal">
										<i class="fa fa-cutlery"></i> Reservations</a></li>
								<?php } else {
								?>
								<li class="nav-item" role="presentation">
									<a class="nav-link show_reservation" href="#tabs-7-<?php echo $ad['adid'] ?>" data-id="<?=$ad['adid'] ?>" data-businessId = "<?= $ad['bs_id'] ?>" data-ssUserId = "<?= $user_id ?>" data-UserId = "<?= $getRestaurentUser->id ?>"data-toggle="tab">
										<i class="fa fa-cutlery"></i> Reservations</a></li>
								<?php } ?>
								<?php } ?>
								<?php } ?>
								<?php
								if (empty($user_id)) {
								?>
								<li class="nav-item" role="presentation">
									<a class="nav-link clicksnapsignup" data-target="#login-box" data-toggle="modal">
										<i class="fa fa-truck"></i> New Mover</a></li>
								<?php } else {
								?>
								<li class="nav-item" role="presentation">
									<a class="nav-link " href="#tabs-13-<?php echo $ad['adid'] ?>" data-toggle="tab">
										<i class="fa fa-truck"></i> New Mover</a></li>
								<?php } ?>
								<li class="nav-item" role="presentation">
									<a class="nav-link" href="#tabs-9-<?php echo $ad['adid'] ?>" data-toggle="tab">
										<i class="fa fa-envelope"></i> Email Offer</a></li>
								<li class="nav-item" role="presentation">
									<a class="nav-link" href="#tabs-10-<?php echo $ad['adid'] ?>" data-toggle="tab">
										<i class="fa fa-mobile"></i> Text Offer</a></li>
								<?php
								if (strlen($ad['aboutus'])!=0) {
								?>
								<li class="nav-item" role="presentation">
									<a class="nav-link" href="#tabs-12-<?php echo $ad['adid'] ?>" data-toggle="tab">
										<i class="fa fa-info"></i> About Us</a></li>
								<?php  } ?>
								<li class="nav-item" role="presentation"style=" border-bottom:1px solid #e1e1e1;">
									<a class="nav-link" href="#tabs-11-<?php echo $ad['adid'] ?>" data-toggle="tab">
										<i class="fa fa-phone"></i> Contact Us</a></li>
							</ul>
							<div class="mobile_view">
								<p style="text-align: center;margin-bottom: 0;text-transform: uppercase;">
									<strong>All Menu Tabs</strong></p>
								<div class="selectdiv">
									<select class="mb10 form-control btn-primary" id="tab_selector">
										<option value="0" class="gift offertab">Offers</option>
										<?php
										if ($ad['bus_image']) {
										?>
										<option value="1" class="picture phototab">Photos (<?php
										if ($ad['bus_image'] !='') {
											 echo count(explode(',',$ad['bus_image']));} else {
											echo 0;}; ?>)</option>
										<?php } ?>
										<?php
										if (!empty($ad['video_file'])) {
										?>
										<option value="2" class="videos">Videos</option>
										<?php } ?>
										<?php
										if (empty($user_id)) {
										?>
										<option value="12" class="gift clicksnapsignup commentstab">Comments</option>
										<?php } else {
										?>
										<option value="12" class="gift comment-sec commentstab">Comments</option>
										<?php } ?>
										<?php
										if (empty($user_id)) {
										?>
										<option value="13" class="gift clicksnapsignup sharetab">Share</option>
										<?php } else {
										?>
										<option value="13" class="gift share-sec">Share</option>
										<?php } ?>
										<?php
										if (empty($user_id)) {
										?>
										<option value="3" class="heart clicksnapsignup favoritetab">Add Favorite</option>
										<?php } else {
										?>
										<option value="3" class="heart ad-menu-favorite favoritetab">Add Favorite</option>
										<?php } ?>
										<?php
										if ($ad['bs_type'] ==1 ) {
										?>
										<?php
										if ($ad['reservationdetail']['menutab_status']==1) {
										?>
										<?php
										if (!empty($ad['selectMenu']) && $ad['selectMenu']['create_type'] == 1) {
										?>
										<option value="4"  class="list">Our Menu</option>
										<?php } else {
										?>
										<option value="4" class="show_food_menu list" >Our Menu</option>
										<?php }} } ?>
										<?php
										if ($ad['bs_type'] ==1 ) {
										?>
										<?php
										if ($ad['reservationdetail']['menutab_status']==1) {
										?>
										<?php
										if (!empty($ad['selectMenu']) && $ad['selectMenu']['create_type'] == 1) {
										?>
										<option value="12"  class="list">Online Ordering</option>
										<?php } else {
										?>
										<option value="12" class="list" >Online Ordering</option>
										<?php }} } ?>
										<?php
										if ($ad['bs_type'] ==1) {
										?>
										<?php
										if ($ad['reservationdetail']['reservation_status']==1) {
										?>
										<?php
										if (empty($user_id)) {
										?>
										<option value="5" class="cutlery clicksnapsignup reservationsTab">Reservations</option>
										<?php } else {
										?>
										<option value="5" class="cutlery show_reservation reservationsTab">Reservations</option>
										<?php } ?>
										<?php } ?>
										<?php } ?>
										<?php
										if (empty($user_id)) {
										?>
										<option value="7" class="truck clicksnapsignup movertab">New Mover</option>
										<?php } else {
										?>
										<option value="7" class="truck movertab">New Mover</option>
										<?php } ?>
										<option value="8" class="envelope emailoffertab">Email Offer</option>
										<option value="9" class="mobile textoffertab">Text Offer</option>
										<?php
										if (strlen($ad['aboutus'])!=0) {
										?>
										<option value="10" class="about aboutustab">About Us</option>
										<?php  } ?>
										<option value="11" class="phone contactustab">Contact Us</option>
									</select>
								</div>
							</div>
							<div class="tab-content">
								<div class="tab-pane fade show active" id="tabs-1-<?php echo $ad['adid'] ?>">
									<div>
										<div class="panel-heading" style="padding: 0;">

											<div class="text-center " id="desc"><?php echo $ad['deal_description'] ?></div>
										</div>
										<div class="panel-body text-center " id="desc_img" style="padding: 0;">

											<?php echo $ad['adtext'] ?>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="tabs-2-<?php echo $ad['adid'] ?>">
									<div>
										<div class="panel-heading" style="padding: 0;">
											<h4 class="text-center">
												Gallery
											</h4>
										</div>

										<div class="panel-body gallery" style="padding: 0;">
											<div class="row">
													<?php
												 
												if (!empty($ad['bus_image'])) {
												 
													$image_arr_count = count($image_arr);

													foreach($image_arrs as $image_arrs){
														 ?>
														 	<div class="col-6 col-xl-3 col-lg-3 col-sm-4"><img src="http://savingssites.com/uploads/businessphoto/<?php echo $ad['bs_id'] ?>/<?php echo $image_arrs ?>"></div>

														 <?php 
													}


												  } 


												  if(@$imagesizedata){  ?> 
                                                     <div class="col-6 col-xl-3 col-lg-3 col-sm-4"> <?php echo  $ad['adtext']; ?></div>
												<?php } ?>

											</div>
										</div>

									</div>
								</div>
								<div class="tab-pane fade" id="tabs-3-<?php echo $ad['adid'] ?>">
									<div>
										<?php
										if ($ad['video_file']!='') {
											$arr_video_file = explode('?v=', $ad['video_file']);
											$delimeter = $arr_video_file[1];
										?>
										<div class="panel-heading" style="padding: 0;">
											<h4 class="text-center">
												Videos
											</h4>
										</div>
										<div class="panel-body" style="padding: 0;">
											<div class="video-custom text-center">
												<iframe class="embed-responsive-item" allowfullscreen="" src="https://www.youtube.com/embed/<?php echo $delimeter; ?>" frameborder="0" height="500">
												</iframe>

											</div>
										</div>
										<?php } ?>
									</div>
								</div>
								<?php
								if (!empty($user_id)) {
									$get_ad_to_favourites = $this->ad->get_ad_to_favourites($ad['adid'], $user_id);
									if ($get_ad_to_favourites) {
								?>
								<div class="tab-pane fade favorites-tab" id="tabs-4-<?php echo $ad['adid'] ?>">
									<p class="text-center favorite-caption">Click on the below button to remove this Offer from your Favorites List.</p>
									<p class="text-center">

										<a title="Bookmark this Offer" href="javascript:void(0);" class="btn btn-primary btn-large ad_favorite" rel="1" data-adid="<?php echo $ad['adid'] ?>" data-busid="<?php echo $ad['bs_id'] ?>" data-UserId = "<?= $user_id ?>">
											<i class="fa fa-heart"></i><span class="favorite-value"> Remove Favorite<span></a>
									</p>
								</div>
								<?php } else {
								?>
								<div class="tab-pane fade favorites-tab" id="tabs-4-<?php echo $ad['adid'] ?>">
									<p class="text-center favorite-caption">Click on the below button to add this Offer to your Favorites List.</p>
									<p class="text-center">

										<a title="Bookmark this Offer" href="javascript:void(0);" class="btn btn-primary btn-large ad_favorite" rel="0" data-adid="<?php echo $ad['adid'] ?>" data-busid="<?php echo $ad['bs_id'] ?>" data-UserId = "<?= $user_id ?>">
											<i class="fa fa-heart"></i><span class="favorite-value"> Add Favorite<span></a>
									</p>
								</div>
								<?php } } else {
								?>
								<div class="tab-pane fade favorites-tab" id="tabs-4-<?php echo $ad['adid'] ?>">
									<p class="text-center favorite-caption">Click on the below button to add this Offer to your Favorites List.</p>
									<p class="text-center">

										<a title="Bookmark this Offer" href="javascript:void(0);" class="btn btn-primary btn-large ad_favorite" rel="0" data-adid="<?php echo $ad['adid'] ?>" data-busid="<?php echo $ad['bs_id'] ?>" data-UserId = "<?= $user_id ?>">
											<i class="fa fa-heart"></i><span class="favorite-value"> Add Favorite<span></a>
									</p>
								</div>
								<?php } ?>
								<div class="tab-pane fade" id="tabs-5-<?php echo $ad['adid'] ?>">
									<div>
										<div class="panel-body gallery" style="padding: 0;">
											<div class="row">
												<?php
												if (!empty($ad['selectMenu']) && $ad['selectMenu']['create_type'] == 1) {
													$path_info = pathinfo($ad['selectMenu']['image']);
													$ext =  $path_info['extension'];
													if ($ext == 'pdf') {
												?>
												<iframe src="<?php echo base_url()."restaurantMenuMaker/".$ad['selectMenu']['image']; ?>#zoom=50" width="1000" height="1000" style="" frameborder="0"></iframe>
												<?php } else {
												?>
												<img src="<?php echo base_url()."restaurantMenuMaker/".$ad['selectMenu']['image']; ?>"/>
												<?php } } else {
												?>

												<iframe id="" src="<?php echo base_url()."restaurantMenuMaker/".$ad['selectMenu']['image']; ?>" width="1000" height="400"></iframe>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
								<div style="display: none;" class="tab-pane fade" id="tabs-6-<?php echo $ad['adid'] ?>">
									<div>
										<div class="panel-heading" style="padding: 0;">
											<h4 class="text-center">Mapquest</h4>
										</div>
										<div class="panel-body col-md-offset-2 col-xs-offset-1" style="padding: 0;">
											<div id="admaps1818">
											</div>
											<div class="route hide-for-print form-group">
												<input type="text" name="route" id="map_location_<?php echo $ad['adid'] ?>" class="route form-control" placeholder="Address">
												<br>
												<input type="button" name="calcRoute" class="calcRoute direction_button form-controll" data-ad-id="1818" data-latitude="" data-longitude="" value="Show Directions" destination="kolkata-700049" endlocation="1818">
											</div>
											<div id="directions-admaps1818">
											</div>
											<div class="warnings_panel1818">
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="tabs-15-<?php echo $ad['adid'] ?>">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="text-center">
												Our Menu
											</h4>
										</div>
										<div class="panel-body gallery">
											<ul class="galleryList">
												<?php
												/*    echo "<pre>";
												print_r($ad['menuCategoryList']);
												echo "</pre>";
												echo "<pre>";
												print_r($ad['menuSubcategoryList']);
												echo "</pre>";*/
												if (!empty($ad['menuCategoryList'])) {
													foreach ($ad['menuCategoryList'] as $menudata) {
														echo '<li><div class="imgContainer"><img src="'.base_url().'restaurantMenuMaker/'.$menudata['image'].'" /><div class="overlay-container"><h4>'.$menudata['content'].'</h4></div></div></li>';

													}

												} else {
													echo "No Menu available for this business";
												}


												?>
											</ul>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="tabs-13-<?php echo $ad['adid'] ?>">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="text-center">
												Welcome<br>Free for New Movers:
											</h4>
										</div>
										<div class="panel-body">
											<div class="textmeoffer_div ">
												<div class="row">
													<div class="col-sm-12 text-center">
														<p class="text-center">Get 3 FREE Peekaboo peeking credits, (up to $1.50 value), to get deeply discounted, non-expiring, cash certificates, that save you money and help your favorite local Org! </p>
														<p class="text-center">In the future Savings Sites will email or text you discount offers of this business only if their offer meets your "time availability" and "minimum discount requirement" SNAP Filters!</p>
														<p class="text-center">
															<a data-snap-status="<?php echo $ad['snap_status']; ?>" data-adid="<?php echo $ad['adid'] ?>" data-type="2" data-from="" data-createdby-id="<?php echo $ad['bs_id'] ?>" data-user-id="<?= $user_id ?>" data-zone-id="<?= $zone ?>" href="#" class="btn btn-primary moversfreecredit">Freely give me a $1.50 in Credits &amp; Filtered Offers!</a></p>
														<?php
														$phonenumber = str_replace("-","",$ad['bs_phone']);
														?>

													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="tab-pane fade" id="tabs-7-<?php echo $ad['adid'] ?>">
									<div>
										<div class="panel-heading" style="padding: 0;">
											<h4 class="text-center">Select Date &amp; Time for your Reservation</h4>
										</div>
										<div class="panel-body col-md-offset-2 text-center col-xs-offset-1" style="padding: 0;">
												<?php
												if (!empty($user_id)) {
												?>
											 <a  href="<?php echo base_url() ?>/snapDining/booktable/<?=$zone ?>/<?php echo $ad['bs_id'] ?>?noofperson=2&userId=<?php echo $user_id  ?>&time=06:00pm&searchDate=07/08/2021"><button class="test btn btn-primary "  >Click to Reserve</button></a>
											 <?php 
                                                  }else{  ?>
                   
 												<a  href="<?php echo base_url() ?>/snapDining/dining/<?=$zone ?>"><button class="test btn btn-primary " >Click to Reserve</button></a>

                                                <?php   }
											 ?>

										</div>
									</div>
								</div>

								<div class="tab-pane fade" id="tabs-18-<?php echo $ad['adid'] ?>">
									<div>
										<div class="comments-section">
											<h6 class="commentBubble text-center">
												<strong>Comments</strong></h6>
											<div class=" text-center">
												<?php
												if (!empty($user_id)) {
												?>
												<a href="javasvript:void(0);" id="confirmCommentuser" data-target="#add_comment" data-toggle="modal" data-busid="<?php echo $ad['bs_id'] ?>" data-userid="<?php echo $user_id ?>" data-zoneid="<?php echo $zoneid ?>">Add</a> |
												<a href="javascript:void(0);" id="view_comment" data-target="#view_all_comment_modal" data-toggle="modal" data-busid="<?php echo $ad['bs_id'] ?>">View</a>
												<?php } else {
												?>
												<a href="javasvript:void(0);" class="clicksnapsignup" data-target="#login-box" data-toggle="modal">Add</a> |
												<a href="javascript:void(0);" class="clicksnapsignup" data-target="#login-box" data-toggle="modal">View</a>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>

								<div class="tab-pane fade" id="tabs-19-<?php echo $ad['adid'] ?>">
									<div>
										<div class="comments-section text-center">
<div class="addthis_inline_share_toolbox_4edp" data-url="<?=base_url('/short_url/index.php?deal_title='.$ad['deal_title']) ?>" data-title="<?=stripslashes(urldecode($ad['bs_name'])) ?>"></div>

											
										</div>
									</div>
								</div>

								<div class="tab-pane fade" id="tabs-8-<?php echo $ad['adid'] ?>">

									<?php
									if ($getRestaurantOfferDetails['status'] == 1) {
									?>
									<div class="panel panel-default">
										<div class="panel-body snapTab">
											<div class="row">
												<div class="col-sm-3">
													<img src="<?=base_url() ?>assets/snapdining/theme/purple/images/logo.png">
												</div>
												<div class="col-sm-9">
													<ul>
														<li style="color: black;">Before Ordering Show Discount % in Emailed Reservation Confirmation!</li>
														<li style="color: black;">You can combine Peekaboo Discounted Cash Certificates too---but no others!</li>
														<li style="color: black;">Discount % is per reservation hour:</li>
													</ul>
												</div>
												<div class="col-sm-12">
													<table class="snapTable">
														<thead>
															<th></th>
															<th>Monday</th>
															<th>Tuesday</th>
															<th>Wednesday</th>
															<th>Thusday</th>
															<th>Friday</th>
															<th>Saturday</th>
															<th>Sunday</th>
														</thead>
														<tbody>
															<?php
															foreach ($restaurantTimeList as $key => $value) {
															?>
															<tr>
																<th><?= date('g:i A', strtotime($value)) ?></th>

																<td><?php echo isset($getRestaurantOfferDetails[2][$key]) ? $getRestaurantOfferDetails[2][$key] : 0 ?>%</td>
																<td><?php echo isset($getRestaurantOfferDetails[3][$key]) ? $getRestaurantOfferDetails[3][$key] : 0 ?>%</td>
																<td><?php echo isset($getRestaurantOfferDetails[4][$key]) ? $getRestaurantOfferDetails[4][$key] : 0 ?>%</td>
																<td><?php echo isset($getRestaurantOfferDetails[5][$key]) ? $getRestaurantOfferDetails[5][$key] : 0 ?>%</td>
																<td><?php echo isset($getRestaurantOfferDetails[6][$key]) ? $getRestaurantOfferDetails[6][$key] : 0 ?>%</td>
																<td><?php echo isset($getRestaurantOfferDetails[7][$key]) ? $getRestaurantOfferDetails[7][$key] : 0 ?>%</td>
																<td><?php echo isset($getRestaurantOfferDetails[1][$key]) ? $getRestaurantOfferDetails[1][$key] : 0 ?>%</td>
															</tr>
															<?php } ?>

														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
									<?php } else {
									?>
									<p style="text-align: center;color: red;">This Restaurnt does not provide any offer right now.</p>
									<?php } ?>

								</div>
								<div class="tab-pane fade" id="tabs-9-<?php echo $ad['adid'] ?>">
									<div>
										<div class="panel-heading" style="padding: 0;">
											<h4 class="text-center">Email Me This Offer</h4>
										</div>

										<div class="" style="padding: 0;">
											<div class="row">
												<div class="col-sm-12">

													<?php
													if (!empty($user_id)) {
														$display = 'none'; ?>
													<p class="text-center">If you're logged in the offer is emailed to the email address used when registered.</p>
													<div id="response_get_<?=$ad['adid'] ?>" style="margin-left:193px;margin-bottom:11px;color:green;"></div>
													<input type="text" style="display:<?=$display?>" name="name" id="name_email_<?=$ad['adid'] ?>" value="<?=(!$this->session->userdata('get_email') ? '' : $this->session->userdata('get_email')) ?>" class="textfield input_emailoffer form-control" required="">
													<p class="text-center">
														<a href="javascript:void(0);" class="btn btn-primary current_email_button_new" id="<?=$ad['adid'] ?>">Email Me</a></p>
													<?php
												} else {
													?>
													<p class="text-center">You must be Registered and Logged-In to have Discount Offers Emailed to You!</p>
													<?php
													$display = '';
												} ?>



												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="tabs-10-<?php echo $ad['adid'] ?>">
									<div>
										<div class="panel-heading" style="padding: 0;">
											<h4 class="text-center">
												Text Me This Offer
											</h4>
										</div>
										<div class="panel-body" style="padding: 0;">
											<div class="textmeoffer_div ">
												<form id="text_me_offer_<?php echo $ad['adid'] ?>" class="post textmeoffer" method="post" enctype="multipart/form-data">
													<div class="row">
														<div class="col-sm-12 text-center">
															<p class="text-center">If you're logged in, this offer will be sent by text to the phone number you used when registering.</p>
															<p class="text-center">
																<input type="hidden" name="" class="addid" value="<?php echo $ad['adid'] ?>">
																<a href="#" class="btn btn-primary">Text Me</a></p>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="tabs-12-<?php echo $ad['adid'] ?>">
									<div>
										<div class="panel-body" style="padding: 0;">
											<div class="textmeoffer_div ">
												<div class="row">
													<div class="col-sm-12 text-center">
														<h5 class="text-center"><?php print_r($ad['aboutus']); ?></h5>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="tabs-11-<?php echo $ad['adid'] ?>">
									<div>
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="contact-section">
													<div class="row">
														<div class="col-sm-12">
															<h4 class="">Contact Us</h4></div>
														<div class="col-md-6">
															<address>
																<?php
																if (!empty($ad['bs_streetaddress1'])) {
																?>
																<i class="fa fa-map-marker"></i> <?php echo $ad['bs_streetaddress1'] ?>,<br/>
																<?php } ?>
																<i class="fa fa-map-marker"></i> <?php
																if (!empty($ad['bs_city'])) {
																?> <?php echo $ad['bs_city'] ?>,<?php } ?> <?php
																if (!empty($ad['bs_state'])) {
																?><?php echo $ad['bs_state'] ?>,<?php } ?> <?php
																if (!empty($ad['bs_zipcode'])) {
																?><?php echo $ad['bs_zipcode'] ?>,<?php } ?><br/>
																<?php
																if (!empty($ad['bs_phone']))
																	:
																if (strpos($ad['bs_phone'],'-') !== true)
																	:
																$number = preg_replace("/^1?(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3", $ad['bs_phone']);
																?>

																<i class="fa fa-phone"></i> <?php echo $number; ?>

																<?php else
																	: ?>
																<i class="fa fa-phone"></i> <?php echo $ad['bs_phone']; ?>
																<?php endif; ?>
																<?php endif;
																?>
															</address>
														</div>
														<div class="col-md-6">
															<a href="javascript:void(0) ;" class="contact_submission" data-fname="<?=$ad['useremail']['first_name']; ?>" data-lname="<?=$ad['useremail']['last_name']; ?>" data-email="<?=$ad['bs_contactemail']; ?>" data-uemail="<?=$ad['useremail']['email']; ?>" data-busname="<?=stripslashes(urldecode($ad['bs_name'])) ?>" data-adid="<?php echo $ad['adid'] ?>" data-phone="<?=$ad['useremail']['phone']; ?>">
																<i class="fa fa-envelope-o"></i> Email Us</a><br>

															<?php
															if ($ad['websitevisibility']==1) {
																if (!empty($ad['bs_website'])) {
																	$wblink=(strpos($ad['bs_website'],'http://') === false)?'http://'.$ad['bs_website']:$ad['bs_website'];  // add 04.02.2013
																	$wblink = ($wblink == 'http://') ? "" : $wblink ;
																	echo("<a href='".$wblink."'><i class='fa fa-share-square-o'></i> Visit Our Website</a><br>");
																}
															} ?>
															<a href="<?=base_url('/short_url/index.php?deal_title='.$ad['deal_title']) ?>">
																<i class="fa fa-bookmark"></i> Bookmark Our Ad</a>
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
			</div>
		</div>
	</section>

<?php
if (!empty($ad['peekaboolist'])) {
?>

<section class="section section-sm bg-default text-md-left" style="padding-top: 0;">
	<div class="container">
		<div class="row row-50 justify-content-center align-items-xl-center">
			<div class="col-sm-12">
				<div class="pboo-bdr dffdg">
					<div class="row row-50 justify-content-center align-items-xl-center">
						<div class="col-sm-12" style="text-align: center;margin-bottom:20px;display: none;" >
							<img  src="<?=$link_path ?>assets/directory/images/Pboo-Frame.jpg" >
						</div>
						<div class="sortby col-sm-12 desktop_view">
							
						</div>

					 
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</section>
</div>
<?php } ?>

<!-- <div class="text-center block block-pd-sm">
<div class="container">
<div class="row">
<div class="col-md-12  col-sm-12 text-center">
<div class="block-bg-theme divider">
<img src="<?=$link_path?>assets/directory/images/separator_new.png">
</div>
</div>
</div>
</div>
</div> -->
<?php
if (++$count === $numItems) {} else {
?>
<section class="text-center block section section-sm block-bg-theme offers-separator">
	<div class="container">
		<div class="row">
			<div class="col-md-12  col-sm-12 text-center">
				<div class="block-bg-theme">
					<img src="<?=$link_path ?>assets/directory/images/separator_new.png">
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
</section>
<!-- Adding peekaboo modal by krishanu start -->

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="ads11-<?php echo $peekaboorandval; ?>">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">

				<h4 class="modal-title text-center" style="width:100%" id="myModalLabel">

					<?php echo $ad['peekaboolist'][0]['company_name']; ?>
				</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">
						&times;
					</span>
				</button>
			</div>
			<div class="modal-body">
				<address>
					<?php
					if (!empty($ad['bs_streetaddress1'])) {
					?>
					<p  class="text-center"> <?php echo $ad['bs_streetaddress1'] ?></p>
					<?php } ?>
					<p  class="text-center"> <?php
					if (!empty($ad['bs_city'])) {
					?> <?php echo $ad['bs_city'] ?>,<?php } ?> <?php
					if (!empty($ad['bs_state'])) {
					?><?php echo $ad['bs_state'] ?>,<?php } ?> <?php
					if (!empty($ad['bs_zipcode'])) {
					?><?php echo $ad['bs_zipcode'] ?>,<?php } ?></p>
					<p  class="text-center">(P) <?php
					if (!empty($ad['bs_phone']))
						:
					if (strpos($ad['bs_phone'],'-') !== true)
						:
					$number = preg_replace("/^1?(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3", $ad['bs_phone']);
					?>

						<?php echo $number; ?>

						<?php else
							: ?>
						<?php echo $ad['bs_phone']; ?>
						<?php endif; ?>
						<?php endif;
						?>  |
						<a href="javascript:void(0) ;" class="contact_submission" data-fname="<?=$ad['useremail']['first_name']; ?>" data-lname="<?=$ad['useremail']['last_name']; ?>" data-email="<?=$ad['bs_contactemail']; ?>" data-uemail="<?=$ad['useremail']['email']; ?>" data-busname="<?=stripslashes(urldecode($ad['bs_name'])) ?>" data-adid="<?php echo $ad['adid'] ?>" data-phone="<?=$ad['useremail']['phone']; ?>">
							<b>Email Us</b></a></p>
				</address>
				<p class="text-center" style="margin: 0;font-size:14px;">
				<p class="text-center" style="margin: 0;font-size:14px;">
					<?php
					if ($ad['websitevisibility']==1) {
						if (!empty($ad['bs_website'])) {
							$wblink=(strpos($ad['bs_website'],'http://') === false)?'http://'.$ad['bs_website']:$ad['bs_website'];
							$wblink = ($wblink == 'http://') ? "" : $wblink ;
							echo("<a href='".$wblink."'><i class='fa fa-share-square-o'></i> Visit Our Website</a><br>");
						}
					} ?>
					<a href="<?=base_url('/short_url/index.php?deal_title='.$ad['deal_title']) ?>">
						<i class="fa fa-bookmark"></i> Bookmark</a>
					<!-- <a href="javascript:void(0) ;">Direct URL /</a>
					<a href="javascript:void(0) ;"> Hours</a> -->
				</p>
				<div class="text-center" style="margin:10px auto 0;">
					<div align="center" class="text-center">
						<div class="jssocials-share jssocials-share-facebook">
							<a target="_blank" href="javascript:void(0);" class="jssocials-share-link addthis_button_facebook">
								<i class="fa fa-facebook jssocials-share-logo"></i></a>
						</div>
						<div class="jssocials-share jssocials-share-twitter">
							<a target="_blank" href="javascript:void(0);" title="Social Icons" style="width:auto" class="jssocials-share-link addthis_button_twitter">
								<i class="fa fa-twitter jssocials-share-logo"></i></a>
						</div>
						<div class="jssocials-share jssocials-share-pinterest">
							<a target="_blank" href="javascript:void(0);" class="jssocials-share-link addthis_button_pinterest_share">
								<i class="fa fa-pinterest jssocials-share-logo"></i></a>
						</div>
						<div class="jssocials-share jssocials-share-linkedin">
							<a target="_blank" href="javascript:void(0);" class="jssocials-share-link addthis_button_linkedin">
								<i class="fa fa-linkedin jssocials-share-logo"></i></a>
						</div>
						<div class="jssocials-share jssocials-share-compact">
							<a target="_blank" href="javascript:void(0);" class="jssocials-share-link addthis_button_compact">
								<i class="fa fa-plus jssocials-share-logo"></i></a>
						</div>
					</div>
					<div align="center" class="text-center addthis_toolbox addthis_default_style addthis_rounded_style addthis_32x32_style" addthis:url="" addthis:title="cr7 1 1">
						<div class="clear"></div>
						<!-- EDITED ON 2.4.15-->
						<!-- <div classs="col-md-12 col-sm-12 col-xs-12 col-lg-12" style="text-align: center;display: inline-block;">
						<a class="addthis_button_facebook_like at300b" fb:like:layout="button_count" style="margin-top: 5px;"><div class="fb-like fb_iframe_widget" data-layout="button_count" data-show_faces="false" data-share="true" data-action="like" data-width="90" data-height="25" data-font="arial" data-href="http://savingssites.com/cr7-1-1" data-send="false" style="height: 25px;" fb-xfbml-state="rendered" fb-iframe-plugin-query="action=like&amp;app_id=172525162793917&amp;container_width=0&amp;font=arial&amp;height=25&amp;href=http%3A%2F%2Fsavingssites.com%2Fcr7-1-1&amp;layout=button_count&amp;locale=en_US&amp;sdk=joey&amp;send=false&amp;share=true&amp;show_faces=false&amp;width=90"><span style="vertical-align: bottom; width: 104px; height: 20px;"><iframe name="f19c047d43540b" width="90px" height="25px" frameborder="0" allowtransparency="true" allowfullscreen="true" scrolling="no" title="fb:like Facebook Social Plugin" src="https://www.facebook.com/v2.6/plugins/like.php?action=like&amp;app_id=172525162793917&amp;channel=http%3A%2F%2Fstaticxx.facebook.com%2Fconnect%2Fxd_arbiter%2Fr%2FiPrOY23SGAp.js%3Fversion%3D42%23cb%3Df26ff6ac9b647d%26domain%3Dsavingssites.com%26origin%3Dhttp%253A%252F%252Fsavingssites.com%253A19547%252Ff103fbd3aa1fc04%26relation%3Dparent.parent&amp;container_width=0&amp;font=arial&amp;height=25&amp;href=http%3A%2F%2Fsavingssites.com%2Fcr7-1-1&amp;layout=button_count&amp;locale=en_US&amp;sdk=joey&amp;send=false&amp;share=true&amp;show_faces=false&amp;width=90" style="border: none; visibility: visible; width: 104px; height: 20px;" class=""></iframe></span></div></a>
						<a class="addthis_button_tweet at300b"><div class="tweet_iframe_widget twt_like" style="width: 62px; height: 25px;"><span><iframe id="twitter-widget-0" scrolling="no" frameborder="0" allowtransparency="true" class="twitter-share-button twitter-share-button-rendered twitter-tweet-button" title="Twitter Tweet Button" src="http://platform.twitter.com/widgets/tweet_button.3748f7cda49448f6c6f7854238570ba0.en.html#dnt=false&amp;id=twitter-widget-0&amp;lang=en&amp;original_referer=http%3A%2F%2Fsavingssites.com%3A19547%2Fsavings_sites%2Fzone%2Fsourav%2F&amp;size=m&amp;text=%0A%09%09%20cr7%201%201&amp;time=1482555838591&amp;type=share&amp;url=http%3A%2F%2Fsavingssites.com%2Fcr7-1-1%23.WF4BvcTm7D4.twitter" style="position: static; visibility: visible; width: 61px; height: 20px;" data-url="http://savingssites.com/cr7-1-1#.WF4BvcTm7D4.twitter"></iframe></span></div></a>
						<span style="margin-top:5px;">
						<iframe scrolling="no" frameborder="0" class="buffer-button" src="http://widgets.bufferapp.com/button/?id=76af1b9452bdf3a8&amp;url=http%3A%2F%2Fsavingssites.com%2Fzone%2F1%2F1152%2Fcr7-1-1&amp;text=sourav&amp;count=horizontal&amp;placement=button&amp;utm_source=http%3A%2F%2Fsavingssites.com%3A19547%2Fsavings_sites%2Fzone%2Fsourav%2F&amp;utm_medium=buffer_button&amp;utm_campaign=buffer" style="border: none; width: 92px; height: 20px;"></iframe>
						</span>
						</div> -->
						<!-- AddThis Button END -->
						<div class="atclear"></div>
					</div>
					<!-- Adthis buffer scheduling -->
				</div>
			</div>
		</div>
	</div>
</div>
<!-- adding peekaboo modal by krishanu end -->


<?php } ?>

<div id="peekaboo_popup" tabindex="-1" class="modal fade" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Before you Peek at Low Hidden Price...</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<p style="text-align:left;">You received 3 free peeks when registering. You will receive 3 additional free credits when you claim the cash certificate. Businesses may also give free peeks when redeeming cash certificates.</p>
				<p style="text-align:left;">Peeking at the Hidden Price requires using only 1 peeking credit. Claiming the cash certificate requires 3 peeks. When you claim a discounted cash certificate the number of credits, if less than 3, will be debited from your account. If your account has at least 1 credit to peek but doesn’t have 3 credits then 60 cents per credit will be added to the Sales/Org Donation Fee. Once you click button will have 10 seconds to bypass or stop the auction by buying.</p>
				<p>
					<input type="submit" class="btn btn-primary" id="proceed_pekekaboo" name="proceed" value="Peek Now"/>
					<input type="hidden" class="put_user"  value=""/>
					<input type="hidden" class="auc_id"  value=""/>
				</p>
			</div>

			<div class="modal-footer" hidden="true">
				<div class="text-right jointsubmit-btn">


				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?=$link_path ?>assets/businessSearch/js/script.js?v=<?php echo microtime(true); ?>"> </script>

<style>.ui-tabs .ui-tabs-nav .ui-tabs-anchor .fa{
		font-size: 18px;
	padding-bottom: 5px
	}</style>
<style xmlns="http://www.w3.org/1999/html">.selected{
		background-color: #069
	}.food_icon_image a{
		display: block;
	float: left;
	margin: 2px
	}.food_icon_image_normal img{
		margin: 1px
	}.food_icon_image_selected img{
		border: 1px solid #FFF
	}</style>
<style type="text/css">#star_v ul.star{
		LIST-STYLE: none;
	MARGIN: 0;
	PADDING: 0;
	WIDTH: 80px;
	HEIGHT: 20px;
	LEFT: 10px;
	TOP: -5px;
	POSITION: relative;
	FLOAT: left;
	BACKGROUND: url('assets/images/stars.gif') repeat-x;
	CURSOR: pointer
	}#star_v li{
		PADDING: 0;
	MARGIN: 0;
	FLOAT: left;
	DISPLAY: block;
	WIDTH: 85px;
	HEIGHT: 20px;
	TEXT-DECORATION: none;
	text-indent: -9000px;
	Z-INDEX: 20;
	POSITION: absolute;
	PADDING: 0;
	left: 0
	}#star_v li.curr{
		BACKGROUND: url('assets/images/stars.gif') left 25px;
	FONT-SIZE: 1px
	}#star_v div.user{
		LEFT: 15px;
	POSITION: relative;
	FLOAT: left;
	FONT-SIZE: 13px;
	FONT-FAMILY: Arial;
	COLOR: #888
	}.star_label{
		float: left
	}.star_label li{
		margin: 1px 0 3px
	}#star_v{
		float: left
	}.back_color{
		min-height: 16px
	}business-map a{
		background: url('assets/images/map_marker.png');
	width: 30px;
	height: 34px
	}.addthis{
		margin-top: 7px;
	padding-left: 336px;
	display: block
	}.map_style{
		width: auto;
	height: 400px
	}.adtab_text_small{
		font-size: 12px;
	text-align: center;
	font-weight: normal
	}.ui-tabs .full-size-tab.ui-tabs-nav li a{
		padding: .5em .5em
	}.tabspanel_minheight{
		min-height: 250px;
	overflow: hidden
	}.adtabs-style .ui-widget-content{
		border: none!important;
	min-height: 250px
	}.input_tellfriend{
		width: 205px;
	height: 25px
	}.tellfriend_div{
		margin-left: 100px;
	margin-top: 15px;
	width: 400px;
	background-color: #E2DFC1!important;
	height: 420px;
	border-radius: 20px;
	box-shadow: 10px 10px 5px #888
	}.ui-tabs .ui-tabs-panel{
		padding: 10px 0
	}.direction_button{
		width: 110px;
	height: 35px;
	border-radius: 8px;
	margin-left: 5px;
	background-color: beige
	}.popup_certificate_area{
		float: left
	}.popup_certificate_area img{
		max-width: 100%
	}.popup_certificate_heading_top{
		top: 0;
	background: #eee;
	width: 100%;
	color: #212121;
	text-transform: uppercase;
	padding: 5px 4px;
	display: table;
	text-align: center;
	height: 30px
	}.popup_certificate_heading_top.headingin_popup{
		width: 200px;
	height: auto
	}.popup_certificate_heading_top span{
		display: table-cell;
	vertical-align: middle
	}.popup_certificate_heading_bottom{
		bottom: -1px;
	text-transform: uppercase
	}.popup_certificate_heading_bottom a{
		display: block;
	padding: 8px 2px;
	z-index: 1;
	border: 1px solid #ccc;
	color: #e92d00;
	text-decoration: none;
	text-align: center
	}.popup_certificate_heading_bottom a::before{
		background-image: linear-gradient(to bottom,rgba(255,255,255,0.6) 0,rgba(255,255,255,0.95) 100%);
	background-repeat: repeat-x;
	content: "";
	height: 100%;
	left: 0;
	position: absolute;
	top: 0;
	width: 100%;
	z-index: -1
	}.peekaboo_popup{
		float: left;
	top: 11%;
	margin-top: 12px
	}.peekaboo_popup_all{
		width: 55%;
	left: 15%;
	top: 10%;
	height: 500px;
	overflow-x: hidden;
	overflow-y: scroll
	}.other-details{
		margin-top: 15px;
	margin-left: 20px
	}.other-details p{
		margin-bottom: 10px
	}.current-asking-link a{
		background: #e92d00;
	text-decoration: none;
	color: #fff;
	text-align: center;
	display: block;
	padding: 5px;
	border-radius: 5px;
	box-shadow: 0 2px 3px #888;
	margin-left: 15px;
	margin-right: 15px
	}.current-asking-link a span{
		font-weight: bold;
	line-height: 16px
	}.current-asking-link a:hover{
		background: #333
	}.link-icons{
		margin-top: 15px;
	margin-left: 38px
	}.link-icons a{
		display: block;
	margin-bottom: 10px;
	text-decoration: none;
	color: #333
	}.link-icons a span img{
		vertical-align: middle
	}.auction-id{
		color: #e92d00;
	padding: 10px;
	border-bottom: 1px solid #666;
	text-align: center
	}.peekaboo_popup_inner{
		border-radius: 5px;
	overflow: hidden
	}.extrapadb.new2.extrain_popup{
		height: auto;
	width: 250px
	}.extrapadb.new2{
		font-weight: 400;
	font-size: 12px;
	margin-top: 3px;/*padding:5px!important;*/
	line-height: 16px;
	font-family: "Raleway",-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif
	}</style>
<script type="text/javascript">
	var addthis_config = {
		"data_track_addressbar": false,
		services_overlay: 'facebook,twitter,email,print,more'
	};
	var script = "http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-52c142af0e6e234c";
	if (window.addthis) {
		window.addthis = null;
		window._adr = null;
		window._atc = null;
		window._atd = null;
		window._ate = null;
		window._atr = null;
		window._atw = null;
	}
	$.getScript(script);
	$('a.admaps').click(function() {
		var ad_id = $(this).attr('rel');
		var smsBox = $('.map_' + ad_id).attr('href');
		$(smsBox).toggle('slow');
		return false;
	});

	$(document).ready(function() {

		$(".full_details").click(function(e) {
			e.preventDefault();
			var adid = $(this).attr('data-adid');
			var section = ".pboosection-" + adid ;
			$('html,body').animate({
				scrollTop: $(section).offset().top},
			'slow');
		});

	});
setTimeout(function() {

                $.getScript( "https://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5f4e93cfce690c19&async=1" )
  .done(function( script, textStatus ) {
    addthis.init(); 
        addthis.layers.refresh();

            }, 1000);
            
  })


 
$(".pagination a").eq(0).attr('href',  '?per-post-onpage=1');
$( ".footer-pagination .pagination a:nth-child(0)" ).attr('href',  '?per-post-onpage=1');


 $("a[rel=next]").remove();
 
 $(' .pagination').paginate({
  perPage: 10, 
  useHashLocation: true, 
  autoScroll:false,         
});
 
</script>

<style type="text/css">
	
nav.paginate-pagination.paginate-pagination-0 ul li {
    width: 50%;
}

nav.paginate-pagination.paginate-pagination-0 ul {
    display: flex;
}
a.page.page-next {
    display: block;
    right: -26px;
    top: 0px;
    font-size: 29px;
    border: 1px solid #eee;
    padding: 7px 7px 12px;
    border-radius: 0px 5px 5px 0px;
    border-left: none;
    line-height: 15px;
}
a.page.page-prev {
    display: block;
    left: -28px;
    top: 0px;
    font-size: 29px;
    border: 1px solid #eee;
    padding: 7px 7px 12px;
    border-radius: 5px 0px 0px 5px;
    border-right: none;
    line-height: 15px;
}
a.page{display: none;}
.headpgination{position: relative;}
</style>