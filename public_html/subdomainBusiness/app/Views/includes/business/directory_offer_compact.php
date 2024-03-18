<input type="hidden" name="user_all_info" value='<?php echo json_encode($user_info); ?>'>
<style>
	.favaddon{
		display: none;
	}
	#DataTables_Table_0 tr:last-child .favaddon{
		display: block;
	}
</style>
<?php  
 	if($fileview == 'grid'){
		$class = 'list_view_third';
	}else if($fileview == 'fourgrid'){
		$class = 'list_view_four';
	}else if($fileview == 'compact'){
		$class = 'list_view_two';
	}
?>
<div id="singleOffer"></div>
<section class="section section-sm bg-default text-md-left featured  <?php echo $class  ?>" style="padding-bottom: 0;">
   	<div class="container">
        <div class="row align-items-center">
 		<?php 
 			$numItems = count($adlist);
			$count = 0;$nav=0;
			
			function check_file($filename){
				$file_headers = get_headers($filename,1);
 				$urlpars = parse_url($filename);
				$ext = array('png', 'jpg', 'jpeg', 'gif'); 
				$img_extension = pathinfo($filename, PATHINFO_EXTENSION);	
				if($file_headers[0] == 'HTTP/1.0 404 Not Found'){
				}else if(!file_exists($_SERVER['DOCUMENT_ROOT'].$urlpars['path'])){
				}else if($urlpars['scheme'] != 'https' && $urlpars['scheme'] != 'http'){
				}else if(!in_array($img_extension, $ext)){
				}else { return 1; }
			}
			foreach ($adlist as $ad) {
				$nav++;
				$dealImage = '';
				$peekaboorandval="";
				$peekaboorandval=rand();
				$share_ad_id=(empty($ad['deal_title']))? $ad['adid'] : $ad['deal_title'];
				$showtablebutton=isset($ad['noofperson'])? $ad['noofperson'] : '';
				if($showtablebutton > 0){
					$reserveclass = 'reserveButton';
				}else{
					$reserveclass = '';
				}
				// $getRestaurentUser = $this->Ads_model->getResturentUser($ad['bs_id']);
				// $getRestaurantOfferDetails = array();
				
				// if ($getRestaurentUser) {
				// 	$getRestaurantOfferDetails = $this->diningmodel->getBusinessDiningOfferDetails($ad['bs_id']);
				// }
				
				if (!empty($ad['bus_image'])) {			
 					$image_arrs = explode(',',$ad['bus_image']);
 					foreach ($image_arrs as $key => $img){ 
						// Open file
		 				$handle = @check_file(base_url().'uploads/businessphoto/'. $ad['bs_id'] .'/'.$img);
		 				if(!$handle){
							unset($image_arrs[$key]);
						}
					}	
 					$handle2 = @check_file(base_url().'uploads/businessphoto/'. $ad['bs_id'] .'/'.$image_arrs[0]); // Check if file exists
				 	if(!$handle2){
						$dealImage = '';
					}else{
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
				
				if(empty($dealImage)){ $dealImage = $ad['bs_logo']; } 
				if(empty($dealImage) && empty($ad['peekaboolist'])){
					$dealImage = base_url().'uploads/ckeditor/OurDealsComingSoon-1.png';
				}
  				if (!empty($ad['peekaboolist']) && empty($dealImage)) {
					if(@$ad['bs_commonimage']){
						$handle2 = @check_file(base_url().$ad['bs_commonimage']);
						// Check if file exists
						if(!$handle2){
							$dealImage = base_url().'https://cdn.savingssites.com/support_orgs.jpg';
						}else{
							$dealImage = base_url().$ad['bs_commonimage'];
						}
					}
				}
				$deal_img = array();
				if (!empty($ad['peekaboolist'])) {
					foreach($ad['peekaboolist'] as $deal){
						if ($deal['card_img']) {
							$check_img = @check_file(base_url().'uploads/zone_mobile_resizeupload/'.$zone.'/'.$deal['card_img']);
							if ($check_img) {
								array_push($deal_img,$deal['card_img']);
							}
						}
					}
				}
				
				$advertismentImage = @$ad['adtext'];
                if(@$advertismentImage){
					preg_match( '@src="([^"]+)"@' , $advertismentImage, $match );
					$src_sliderimages = array_pop($match);
					$imagesizedata = @check_file($src_sliderimages);  
				}
		?>
		<div class="col-xl-6 col-md-6 col-lg-6 offerscolss <?php  if(!empty($ad['peekaboolist'])){ echo "haveoffer"; }else{ echo "has_offer";  } ?>   ">
			<div class="mk ">
            	<div class="offer-grid-item <?= $reserveclass; ?>" data-fname="<?= isset($ad['useremail']['first_name'])?$ad['useremail']['first_name']:''; ?>"  data-email="<?= isset($ad['useremail']['email'])?$ad['useremail']['email']:''; ?>" data-company="<?= isset($ad['company_name'])?$ad['company_name']:''; ?>" data-lname="<?=  isset($ad['useremail']['last_name'])?$ad['useremail']['last_name']:''; ?>"  data-busid="<?php echo $ad['bs_id'] ?>" data-adid="<?php echo $ad['adid'] ?>" id="mainOffer-<?php echo $ad['adid'] ?>">
	            	<div class="row" id="mkp">
	               		<div class="col-md-10 col-sm-9">
		               		<h3 class="featured-title">
 								<a class="pkbpop" href="#" data-title="Title" data-content="Some Description<br>Some other description" data-toggle="modal" data-target="#pbkPop0002">
 									<img class="img-responsive" src="<?php echo base_url() ?>assets/stylesheets/images/info-icon-27.png" >
 								</a>
		               			<?php if (!empty($user_id)) {   ?>
									<span class="snapdiv snapdiv<?php echo $ad['adid'] ?>">
									<?php if ($ad['snap_status'] == 1) { ?>
									   	<a class="toggle-on-off-img on emailnoticepopup" style="cursor: pointer;" data-target="#email_notice_pop_up_modal" data-toggle="modal" data-adid="<?php echo $ad['adid'] ?>" data-busid="<?php echo $ad['bs_id'] ?>" data-userid="<?php echo $user_id ?>">
									   		<img data-on="images/snap-on.png" data-off="<?=$link_path ?>assets/businessSearch/images/turn-on.png" src="https://cdn.savingssites.com/snap-on.png" class="for-img-shadow"/>
									   	</a>
									<?php } else { ?>
									   	<a class="toggle-on-off-img on emailnoticepopup" style="cursor: pointer;" data-target="#email_notice_pop_up_modal" data-toggle="modal" data-adid="<?php echo $ad['adid'] ?>" data-busid="<?php echo $ad['bs_id'] ?>" data-userid="<?php echo $user_id ?>" >
									   		<img data-on="images/turn-on.png" data-off="<?=$link_path ?>assets/directory/images/snap-off.png" src="https://cdn.savingssites.com/snap-off.png" class="for-img-shadow"/>
									   	</a>
									<?php } ?>
									</span>
								<?php } else { ?>
									<span class="snapdiv">
										<a href="javascript:void(0);" aria-hidden="true"  data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Snap is Turned OFF. Login to turn it ON" data-original-title="SNAP">
											<img src="https://cdn.savingssites.com/snap-off.png" style="width: 25px;">
										</a>
									</span>
								<?php } ?>
								<div class="bv_share_icon">
									<div class="addthis_inline_share_toolbox_pwty" data-url="<?=base_url('/short_url/index.php?deal_title='.$ad['deal_title']).'?'.time() ?>" data-title="<?=stripslashes(urldecode($ad['bs_name'])) ?>" data-media="<?= base_url(); ?>/uploads/ckeditor/1561612/online-942408_960_720.jpg"></div>
									<i class="fa fa-share-alt" aria-hidden="true"></i>
								</div>
								<?php echo $ad['bs_name'] ?></h3>
		               	</div>
		               	<div class="col-md-2 col-sm-3">
		               		<div class="offer-services">
								<ul class="list-inline">	
									<li>
                    <a target="_blank" href="<?php echo base_url().'business/businessdetail/'.$ad['bs_id'].'/'.$zone ?>" class="cus-btn-home"><i class="fa fa-home" aria-hidden="true"></i></a>
                  </li>			   
								</ul>
		          </div>
		        </div>
		        <div class="col-md-6">
							<div class="offer_heart01 cus-fav-icon">
								<a class="pkbpop" href="#" data-title="Title" data-content="Some Description<br>Some other description" data-toggle="modal" data-target="#favourite">
									<img class="img-responsive" src="<?php echo base_url() ?>assets/stylesheets/images/info-icon-27.png" >
								</a>
							<?php if (!empty($user_id)) {
								$get_ad_to_favourites = $this->ad->get_ad_to_favourites($ad['adid'], $user_id);
								if ($get_ad_to_favourites) {
							?>
								<div class="tab-pane fade89 favorites-tab" id="tabs-4-<?php echo $ad['adid'] ?>">
									<p class="text-center">
										<a title="Bookmark this Offer" href="javascript:void(0);" class="btn btn-primary btn-large ad_favorite ad_fav" rel="1" data-adid="<?php echo $ad['adid'] ?>" data-busid="<?php echo $ad['bs_id'] ?>" data-UserId = "<?= $user_id ?>">
											<i class="fa fa-heart"></i><span class="favorite-value"> Remove Favorite<span></a>
									</p>
								</div>
							<?php } else { ?>
								<div class="tab-pane fade89 favorites-tab" id="tabs-4-<?php echo $ad['adid'] ?>">
									<p class="text-center">
										<a title="Bookmark this Offer" href="javascript:void(0);" class="btn btn-primary btn-large ad_favorite ad_fav_new" rel="0" data-adid="<?php echo $ad['adid'] ?>" data-busid="<?php echo $ad['bs_id'] ?>" data-UserId = "<?= $user_id ?>">
											<i class="fa fa-heart-o" aria-hidden="true"></i><span class="favorite-value"> Add Favorite<span></a>
									</p>
								</div>
							<?php } } else { ?>
								<div class="tab-pane fade89 favorites-tab" id="tabs-4-<?php echo $ad['adid'] ?>">
									<p class="text-center">
										<a title="FAVORITES" href="javascript:void(0);" aria-hidden="true"  data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Login to add business to favourite" data-original-title="FAVORITES" class="btn btn-primary btn-large ad_favorite ad_fav_data ad_fav_new" rel="0" data-adid="<?php echo $ad['adid'] ?>" data-busid="<?php echo $ad['bs_id'] ?>" data-UserId = "<?= $user_id ?>">
											<i class="fa fa-heart-o"></i><span class="favorite-value"> Add Favorite<span></a>
									</p>
								</div>
							<?php } ?>
						</div>
		        <div class="owl-slider sq-price">
		        <?php if(count($image_arrs) > 1) {    ?>
			      	<div class="carousel0001 owl-carousel">
							<?php if($imagesizedata){   ?>
                <div class="item dsfs">
					     	<?php  echo $ad['adtext'] ?>
					      </div>
					    <?php  } 
			        	$i = 0;
			          foreach($image_arrs as $img){
			            $dealsImage = base_url().'uploads/businessphoto/'. $ad['bs_id'] .'/'. $img;
			            $handleImagedeal = @check_file($dealsImage);
			            if(@$handleImagedeal){   ?>
                    <div class="item dsf" style="background-image: url('<?php echo $dealsImage ?>');">
					          </div>
			            <?php }
			              $i++;
			          }
			          if ($deal_img) {
			          	foreach($deal_img as $deal_img){ ?>
			           		<div class="item"   style="background-image: url('<?php echo base_url().'uploads/zone_mobile_resizeupload/'. $zone.'/'. $deal_img ?>');">
					          </div>
			          <?php  } } ?>               
			        </div>
			        <?php }else if($ad['adtext']){  ?>
							<div class="carousel0001 owl-carousel">	
              
                
                <?php   if(@$dealImage){  ?>
					        <div class="item" style="background-image: url('<?php echo $dealImage ?>');"></div>
                <?php  }
									if ($deal_img) {
			            	foreach($deal_img as $deal_img){ ?>
			               	<div class="item"  style="background-image: url('<?php echo base_url().'uploads/zone_mobile_resizeupload/'.$zone.'/'. $deal_img ?>');">
			                </div>
			                <?php  }
			                    } ?>
					      </div>


			                      <?php  }elseif($deal_img){

			                      					 foreach($deal_img as $deal_img){ ?>
			                        			  			<div class="item" style="background-image: url('<?php echo base_url().'uploads/zone_mobile_resizeupload/'.$zone.'/'. $deal_img ?>');" >
					                              			<!-- <img class="owl-image   bv_carasoual k" src="<?php echo base_url().'uploads/zone_mobile_resizeupload/'.$zone.'/'. $deal_img ?>" alt=""> -->
					                           				</div>
			                        			<?php  }

			                      }else{	                        	

			                        	echo '<div class="owl-image im_owl_image" style=" background: url('.$dealImage.')"></div>';
											}
									?>
			                    </div>
								<div class="none-sq-price"><p>ONLY SPONSORS OFFERS SHOW WHEN PAGE LOADS To See All Offers, Use 1 of the 4 Search Options</p></div>

                              <?php    if($order_online == 1) {

                              if($user_id){  ?>
                                <p class="center"><a   <?php if ($_REQUEST['embed'] == 1) { echo 'target="_blank"';  }    ?>   href="<?=$link_path ?>order-online/<?= $zone ?>/<?php echo $ad['bs_id'] ?>" class="btn btn-primary" style="width:auto;font-size: 12px;">Order Now</a></p>
                                <?php }else{ ?>
                                    
                                   	    <p class="center"><a data-toggle="modal"  data-target="#login-box" id="neighbors_login" title="neighbour_login"  href="" class="btn btn-primary dropdown-item toggle-btn-pop loginTextChange" style="width:auto;font-size: 12px;">Order Now</a></p>


                                <? }  }else{    ?>
                              
                                <div class="addthis_inline_share_toolbox_4edp" data-url="<?=base_url('/short_url/index.php?deal_title='.$ad['deal_title']) ?>" data-title="<?=stripslashes(urldecode($ad['bs_name'])) ?>"></div>

                                <?php }  ?>
							</div>
		               		<div class="col-md-6 bv_grig_six">
		               			
		                        
		                        <?php  
								if (!empty($ad['peekaboolist'])) {
								?>
								<div class="pboo-ad">
									<div class="owl-carousel owl-theme mk-slid" data-center="true" data-autoplay="true" data-nav="true">
										<?php
										$count = 0;
										foreach ($ad['peekaboolist'] as $ra) {

										?>
										<div class="item">
											<div class="pboo-ad-wrapper <?= $reserveclass; ?>">
												<div class="business-logo text-center">
													<h6 class="text-center">
														<!-- <strong>Give By Saving!</strong> -->
													</h6>
												</div>
												 <br/>
												<table>
													<tr>
														<td>Cert Value: </td>
														<td style="text-align: end;">$<?php echo  number_format($ra['buy_price_decrease_by'],2) ?>
															<a class="pkbpop1" href="#" data-title="Title" data-content="Some Description<br>Some other description" data-toggle="modal" data-target="#pbkPop1"><img class="img-responsive" src="<?php echo base_url() ?>assets/stylesheets/images/info-icon-27.png"/></a></td>
													</tr>
													<tr>
														<td>Pay Bus: </a></td>
														<td style="text-align: end;">
															<!-- $10.00 --> 

															<?php if ($ra['current_price']) {
									                    		echo '$'. number_format($ra['current_price'],2);
									                    	}else{
									                    		echo "N/A";
									                    	}  ?>
															<a class="pkbpop1" href="#" data-toggle="modal" data-target="#pay_bus_deal"><img class="img-responsive" src="<?php echo base_url() ?>assets/stylesheets/images/info-icon-27.png"/></td>
													</tr>
												<!-- 	<tr>

														<td>Donation/Claim Fee</a></td>
														<td style="text-align: end;">$<?php echo  number_format($ra['publisher_fee'],2) ?><a class="pkbpop1" href="#" data-toggle="modal" data-target="#org_fee" data-title="Title" data-content="Some Description<br>Some other description"><img class="img-responsive" src="<?php echo base_url() ?>assets/stylesheets/images/info-icon-27.png"/></td>
													</tr> -->
														<?php      $savings = @$ra['buy_price_decrease_by'] -  @$ra['current_price'] - @$ra['publisher_fee']  ?>

												<!-- 	<tr <?php if($count == 0){ echo "class='sortsaving'"; }  ?> data-sort ="<?php echo $savings ?>"  >
														<td class="net_save">Net Savings </a></td>	 
													
														 
														<td class="savingval net_save"  style="text-align: end;">$<?php echo  number_format($savings,2) ?><a class="pkbpop1" href="#" data-toggle="modal" data-target="#pbkPop12" data-title="Title" data-content="Some Description<br>Some other description"><img class="img-responsive" src="<?php echo base_url() ?>assets/stylesheets/images/info-icon-27.png"/></td>
													</tr>
 -->


													
													<tr>
														<td>Deals Left: </td>
														<td style="text-align: end;">
															<?php	
 

													     if(trim($ra['numberofconsolation']) <= '0' && $ra['numberofconsolation'] != -1){   echo "<span style='color:red;font-weight: 700;font-size: 11px;'>SOLD OUT</span>";  }elseif($ra['numberofconsolation'] == -1){ echo "Unlimited"; }else {

													    	echo  @$ra['numberofconsolation'] ;
													    } ?>

															<a class="pkbpop1" href="#" data-toggle="modal" data-target="#deals_remaining" data-title="Title" data-content="Some Description<br>Some other description"><img class="img-responsive" src="<?php echo base_url() ?>assets/stylesheets/images/info-icon-27.png"/></a>
														</td>
													</tr>
												</table>
												<div class="text-center">	




                                              <?php 	     if(trim($ra['numberofconsolation']) <= '0' && $ra['numberofconsolation'] != -1){  ?> 
                                                    <br/>
												  <a data-userid="<?= $ad['user_member_data']->user_id ?>" data-fname="<?php echo $ad['useremail']['first_name'] ?>"  data-email="<?php echo $ad['useremail']['email'] ?>" data-company="<?= isset($ad['company_name'])?$ad['company_name']:''; ?>" data-lname="<?php echo $ad['useremail']['last_name'] ?>"  data-snap-status="<?php echo $ad['snap_status']; ?>" data-adid="<?php echo $ad['adid'] ?>" data-type="<?php echo $ad['bs_type'] ?>" data-aucid="<?php echo $ad['peekaboolist'][$count]['auc_id'] ?>" data-from="snap_status_change_from_claim" data-createdby-id="<?php echo $ad['bs_id'] ?>" data-user-id="<?= $user_id ?>" data-zone-id="<?= $zone ?>" href="javascript:void(0)"  class="test btn btn-primary  soldout_btn"  >More Deals Coming Soon </a> 


											 <?php } else if($ra['numberofconsolation'] == -1 || trim($ra['numberofconsolation']) >= '0' ) {  

											            $credit_to_pay = $peekaboocredits['totalcredits'];
											            $creditStatus = 'deduc';
											             $credit_to_pays = 0;
                                                        if($credit_to_pay <= 3){
                                                        	  $totalCredit =  3 - $credit_to_pay ;
															  $credit_to_pays = $totalCredit*0.5;
															  $creditStatus = 'paid';
															 }
                                                  
                                                     $total_cost = number_format($credit_to_pays+$ra['publisher_fee'],"2",".","");
 
											 ?>


                                                <br/>


<div class="offer_heart s1">

	<a class="pkbpop" href="#" data-title="Title" data-content="Some Description<br>Some other description" data-toggle="modal" data-target="#favourite"><img class="img-responsive" src="<?php echo base_url() ?>assets/stylesheets/images/info-icon-27.png" ></a>

<?php 
if (!empty($user_id)) {
									$get_ad_to_favourites = $this->ad->get_ad_to_favourites($ad['adid'], $user_id);
									if ($get_ad_to_favourites) {
								?>
								<div class="tab-pane fade89 favorites-tab" id="tabs-4-<?php echo $ad['adid'] ?>">
									
									<p class="text-center">

										<a title="Bookmark this Offer" href="javascript:void(0);" class="btn btn-primary btn-large ad_favorite ad_fav" rel="1" data-adid="<?php echo $ad['adid'] ?>" data-busid="<?php echo $ad['bs_id'] ?>" data-UserId = "<?= $user_id ?>">
											<i class="fa fa-heart"></i><span class="favorite-value"> Remove Favorite<span></a>
									</p>
								</div>
								<?php } else {
								?>
								<div class="tab-pane fade89 favorites-tab" id="tabs-4-<?php echo $ad['adid'] ?>">
									
									<p class="text-center">

										<a title="Bookmark this Offer" href="javascript:void(0);" class="btn btn-primary btn-large ad_favorite ad_fav_new" rel="0" data-adid="<?php echo $ad['adid'] ?>" data-busid="<?php echo $ad['bs_id'] ?>" data-UserId = "<?= $user_id ?>">
											<i class="fa fa-heart-o" aria-hidden="true"></i><span class="favorite-value"> Add Favorite<span></a>
									</p>
								</div>
								<?php } } else {
								?>
								<div class="tab-pane fade89 favorites-tab" id="tabs-4-<?php echo $ad['adid'] ?>">
									
									<p class="text-center">
										<a title="FAVORITES" href="javascript:void(0);" aria-hidden="true"  data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Login to add business to favourite" data-original-title="FAVORITES" class="btn btn-primary btn-large ad_favorite ad_fav_data ad_fav_new" rel="0" data-adid="<?php echo $ad['adid'] ?>" data-busid="<?php echo $ad['bs_id'] ?>" data-UserId = "<?= $user_id ?>">
											<i class="fa fa-heart-o"></i><span class="favorite-value"> Add Favorite<span></a>
									</p>
								</div>
								<?php } ?>
</div>
                                                
                                                 <?php    if (!empty($user_id)) {     if(@$get_paypal_info['paypal_url'] != ''){ ?>

											 		<form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
														<input type="hidden" name="cmd" value="_xclick">
														<input type="hidden" name="business" value="<?php echo $get_paypal_info['paypal_url'] ?>">
														<input type="hidden" name="currency_code" value="USD">
														<input type="hidden" name="notify_url" value="<?php echo base_url(); ?>zone/thankyou/<?php echo $ad['bs_id'] ?>/<?= $zone ?>?UserId=<?= $user_id ?>&Amount=<?php echo  $total_cost; ?>&creditStatus=<?php echo $creditStatus ?>&AucId=<?php echo $ad['peekaboolist'][$count]['deal_id'] ?>&token=<?php  echo(rand(10,100)) ?>"> 

														<input type="hidden" name="return" value="<?php echo base_url(); ?>zone/thankyou/<?php echo $ad['bs_id'] ?>/<?= $zone ?>?UserId=<?= $user_id ?>&Amount=<?php echo  $total_cost; ?>&creditStatus=<?php echo $creditStatus ?>&AucId=<?php echo $ad['peekaboolist'][$count]['deal_id'] ?>&token=<?php  echo(rand(10,100)) ?>"> 

														<input type="hidden" name="cancel_return" value=""> 
														<input type="hidden" name="item_name" value="<?php echo $ad['bs_name'] ?>">
														<input type="hidden" name="amount" value="<?php echo  $total_cost; ?>">
														<input type="image" class="<?php echo $class  ?>"  border="0" name="submit" onerror="this.style.display='none'"/> 
													</form>

													   <?php } 
													}else{ echo "<span class='cus_btn_login' style='color:red'>Donate & Claim Now!</span>"; } ?>

											 

													    <?php } ?>
															
															<?php   echo "<span data_busid='".$ad['bs_id']."' data-id='".$ad['peekaboolist'][$count]['deal_id']."' item-name='".$ad['bs_name']."' data-userid='".$user_id."' data-zone='".$zone."' class='addtocart' style='display:none;color:red'>Add Deal to Cart</span><br>"; 
                            		
																if($showtablebutton != ''){
																	if(isset($ad['catidnew']) && $ad['catidnew'] == 1){ ?>
																			<button onclick="gettablebookedb(<?= $ad['bs_id']; ?>)" id="gettablebookedb" type="button" class="gettablebookedb btn btn-danger" style='padding: 10px 23px;'> Reserve A Table</button>
															<?php } } ?>






                            		



 
													    	
												</div>
												
											</div>
										</div>
										<?php  $count++; 
										 } ?>

									</div>

								</div>
								<?php } else {
								?>
								<div class="text-center"><img class="support_img s2" src="https://cdn.savingssites.com/support_orgs.jpg" /></div>
								<div class="offer_heart">

								<a class="pkbpop" href="#" data-title="Title" data-content="Some Description<br>Some other description" data-toggle="modal" data-target="#favourite"><img class="img-responsive" src="<?php echo base_url() ?>assets/stylesheets/images/info-icon-27.png" ></a>
								<button onclick="gettablebookedb(<?= $ad['bs_id']; ?>)" id="gettablebookedb" type="button" class="gettablebookedb btn btn-danger" style="padding: 10px 23px;"> Reserve A Table</button>

							<?php 
							if (!empty($user_id)) {
									$get_ad_to_favourites = $this->ad->get_ad_to_favourites($ad['adid'], $user_id);
									if ($get_ad_to_favourites) {
								?>
								<div class="tab-pane fade89 favorites-tab" id="tabs-4-<?php echo $ad['adid'] ?>">
									
									<p class="text-center">

										<a title="Bookmark this Offer" href="javascript:void(0);" class="btn btn-primary btn-large ad_favorite ad_fav" rel="1" data-adid="<?php echo $ad['adid'] ?>" data-busid="<?php echo $ad['bs_id'] ?>" data-UserId = "<?= $user_id ?>">
											<i class="fa fa-heart"></i><span class="favorite-value"> Remove Favorite<span></a>
									</p>
								</div>
								<?php } else {
								?>
								<div class="tab-pane fade89 favorites-tab" id="tabs-4-<?php echo $ad['adid'] ?>">
									
									<p class="text-center">

										<a title="Bookmark this Offer" href="javascript:void(0);" class="btn btn-primary btn-large ad_favorite ad_fav_new" rel="0" data-adid="<?php echo $ad['adid'] ?>" data-busid="<?php echo $ad['bs_id'] ?>" data-UserId = "<?= $user_id ?>">
											<i class="fa fa-heart-o" aria-hidden="true"></i><span class="favorite-value"> Add Favorite<span></a>
									</p>
								</div>
								<?php } } else {
								?>
								<div class="tab-pane fade89 favorites-tab" id="tabs-4-<?php echo $ad['adid'] ?>">
									
									<p class="text-center">
										<a title="FAVORITES" href="javascript:void(0);" aria-hidden="true"  data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Login to add business to favourite" data-original-title="FAVORITES" class="btn btn-primary btn-large ad_favorite ad_fav_data ad_fav_new" rel="0" data-adid="<?php echo $ad['adid'] ?>" data-busid="<?php echo $ad['bs_id'] ?>" data-UserId = "<?= $user_id ?>">
											<i class="fa fa-heart-o"></i><span class="favorite-value"> Add Favorite<span></a>
									</p>
								</div>
								<?php } ?>
</div>
								<?php } ?>
		               		</div>
	
		               	
		               		<div class="col-md-12 col-sm-2 text-right" >

		               		<div class="addthis_inline_share_toolbox_4edp"  data-url="<?=base_url('/short_url/index.php?deal_title='.$ad['deal_title']) ?>" data-title="<?=stripslashes(urldecode($ad['bs_name'])) ?>"></div>

		               			<?php   if ($_REQUEST['embed'] == 1) { ?>
                       
                         	<a target="_blank" href="<?php echo base_url() ?>zone/my_deal/<?= $zone ?>/<?php echo $ad['bs_id'] ?>/<?php echo $ad['adid'] ?>" ><img src="https://cdn.savingssites.com/multimedia.png" style="width:20px;"></a></div>


                       <?php  } else{   
                       	$service_number = (isset($ad['service_number']) && $ad['service_number'] > 0)?$ad['service_number']:0;
                       	$business_owner_id = isset($ad['business_owner_id'])?$ad['business_owner_id']:0;
                       	if(isset($ad['catidnew']) && $ad['catidnew'] == 1){
                       		$foodhide = 'nohide';
                       	}else{
                       		$foodhide = 'hide';
                       	}
                       	?>
                       	<span onclick='getmodalopen(<?= $service_number; ?>,<?= $ad['bs_id']; ?>,<?= $business_owner_id; ?>,"<?= $ad['bs_name']; ?>")' class='<?= $foodhide; ?> foor_order_savings'><img src='https://www.foodordersavings.com/img/logo_head.png'></span>
                       	<?php 
                       		if(@$ad['selectMenu']['image']){ ?>
								<a href="<?php echo base_url() ?>/restaurantMenuMaker/<?php echo $ad['selectMenu']['image'] ?>" target="_blank" class="cus-food-pdf">
								</a> 
							<?php  }  ?>
						</div>
		               	<?php } ?>
		               		
		               		</div>
		               		
	               		</div>
               		</div>
               	</div>
               	

			<?php } ?>

			
 
   <?php  

 


    if(count($adlist) == 0 ){ ?>
<div class="col-sm-12 text-center"> <h5 style="color: red"> No Place found. Please try again.</h5></div>

   <?php } ?>


	<?php   if ($_REQUEST['embed'] == 1) { ?>
 <style type="text/css">
 	 .lisit , .offer-services{display: none;}
   .mobile-view_ddropdown  {visibility: hidden;}
 </style>
	<?php } ?>

        </div>
         <?php  if (isset($links)) { ?>
               <div class="footer-pagination"> <?php  echo $links ?></div>
            <?php  } ?>
    </div>
</section>

<div id="login_loadings" style="  display: none;  top: 136%;position: absolute;left: 0;right: 0;z-index: 99999; "> <img id="loading1" src="https://cdn.savingssites.com/loading.gif" width="50" height="50" alt="loading" ></div>


<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="cart_modal_checkout">
	<div class="modal-dialog modal-xl" role="document">	
		<div class="modal-content">
			<div class="modal-header">
				<h4 style="color:#fff;font-weight: 700;">Item Added</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="text-align: center;">
				<button class="btn btn-info incart">Continue Shopping</button>
				<button class="btn btn-success checkout">Checkout</button>
			</div>
			<div class="modal-footer">
				<div id="favfooterdiv">
					
				</div>
			</div>
		</div>
	</div>
</div>
<script>
   $(".carousel0001").owlCarousel({
    autoplay: false,
     lazyLoad: true,
     loop: true,
     margin: 20,
      /*
     animateOut: 'fadeOut',
     animateIn: 'fadeIn',
     */
     responsiveClass: true,
     autoHeight: false,
     autoplayTimeout: 7000,
     smartSpeed: 800,
	 navText:["<div class='nav-btn prev-slide'></div>","<div class='nav-btn next-slide'></div>"],
     nav: true,
     responsive: {
       0: {
         items: 1
       },
   
       600: {
         items: 1
       },
   
       1024: {
         items: 1
       },
   
       1366: {
         items: 1
       }
     }
   });
   
   $("#carousel2,#carousel02,#carousel01").owlCarousel({
     autoplay: false,
     lazyLoad: true,
     loop: true,
     margin: 20,
      /*
     animateOut: 'fadeOut',
     animateIn: 'fadeIn',
     */
     responsiveClass: true,
     autoHeight: false,
     autoplayTimeout: 7000,
     smartSpeed: 800,
	 navText:["<div class='nav-btn prev-slide'></div>","<div class='nav-btn next-slide'></div>"],
     nav: true,
     responsive: {
       0: {
         items: 1
       },
   
       600: {
         items: 1
       },
   
       1024: {
         items: 1
       },
   
       1366: {
         items: 1
       }
     }
   });
   $(".mk-slid").owlCarousel({
     autoplay: false,
     lazyLoad: true,
     loop: true,
     margin: 20,
      /*
     animateOut: 'fadeOut',
     animateIn: 'fadeIn',
     */
     responsiveClass: true,
     autoHeight: true,
     autoplayTimeout: 7000,
     smartSpeed: 800,
	 navText:["<div class='nav-btn prev-slide'></div>","<div class='nav-btn next-slide'></div>"],
     nav: true,
     responsive: {
       0: {
         items: 1
       },
   
       600: {
         items: 1
       },
   
       1024: {
         items: 1
       },
   
       1366: {
         items: 1
       }
     }
   });
$('.none-sq-price').addClass('hide');
$('.change-price1').on('click',
  function(e) { 
  	e.preventDefault();     
    $(this).parents('#mkp').find('.sq-price').toggleClass('hide');
     $(this).parents('#mkp').find('.none-sq-price').toggleClass('hide');
  }
);

setTimeout(function() {

                $.getScript( "https://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5f4e93cfce690c19&async=1" )
  .done(function( script, textStatus ) {
    addthis.init(); 
        addthis.layers.refresh();

            }, 1000);
            
  })
jQuery(".haveoffer").each(function(){
  $val =  $(this).find(".owl-item.active .sortsaving").attr("data-sort");
  $(this).attr("data-sort",$val);
})


 
$(document).on('click', ".pagination li a", function(event) {
    	event.preventDefault();
			var page_url = $(this).attr('href');
			ajaxlist(page_url);
			
});

	function ajaxlist(page_url = false)
		{
			var search_key = $("#search_key").val();
			
			var dataString = 'search_key=' + search_key;
			var base_url = '<?php echo site_url('products/index_ajax/') ?>';
			
			if(page_url == false) {
				var page_url = base_url;
			}
			
			$.ajax({
				type: "POST",
				url: page_url,
				data: dataString,
				success: function(response) {
					console.log(response);
					$("#ajaxContent").html(response);
				}
			});
		}

    $(".pagination a").eq(0).attr('href',  '?per-post-onpage=1');
    $( ".footer-pagination .pagination a:nth-child(0)" ).attr('href',  '?per-post-onpage=1');

$("a[rel=next]").remove();

     // Adds event listener for the buttons
     //        $(document).unbind().on('click', '.paginate-pagination   .page', function(e) {
     //            e.preventDefault();

              
     //            var page = $(this).data('page');

     //            var paginateParent = $(this).parents('.paginate-pagination').data('parent');

            
     //            console.log(page);
     //            page = $('.paginate' ).data('paginate').switchPage(page);
                  
 
               
     //        });

$('.pagination').paginate({
  perPage: 10, 
  useHashLocation: false, 
  autoScroll:false,     

});
 

 $("span.cus_btn_login").click(function(){
  alert("Please Login!");
});

$('.addtocart').click(function(){
	dataId = $(this).attr('data-id');
  dataUSerid = $(this).attr('data-userid');
  dataZone = $(this).attr('data-zone');
  itemname = $(this).attr('item-name'); 
  data_busid = $(this).attr('data_busid'); 
	$.ajax({
		type: "POST",
		url: '<?php echo base_url()."businessSearch/addCart/" ?>',
		data: {'dealid':dataId, 'dataUSerid' :dataUSerid , 'dataZone': dataZone, 'itemname':itemname,'busid':data_busid},
		dataType:'json',
		beforeSend: function() {
    	$('#login_loadings').css('display','inline-block');
      $( "body" ).prepend( '<div class="modal-backdrop fade show"></div>' );
		},
		success: function(response) {
			if(response > 0){
				$('#cartcount').html(response);
				$('#cartcount').removeClass('hide');
			}
			$('#cart_modal_checkout').modal('show');
			$('#login_loadings').css('display','none');
		}
	});
	
});
	function gettablebookedb(businessId){
		var baseUrl = '<?= base_url(); ?>';
		cookie = $.cookie('user_id');
        if(typeof cookie === 'undefined' || cookie === null){
            alert("Please Login to book restaurants!");
            return false;
        }
        var zone_id = $('input[name="zoneid"]').val();  
       	var noofperson = $('#noOfPerson option:selected').val();
        var userId = $('input[name="user_id"]').val();  
        var time = $('#time option:selected').text();
        var searchDate = $('#datepicker1').val();
        time = time.replace(/\s/g, '');
		window.location.href = baseUrl+'snapDining/booktable/'+zone_id+'/'+businessId+'?noofperson='+noofperson+'&userId='+userId+'&time='+time+'&searchDate='+searchDate;	
	}
	function addnotes($this){
		var userid = $this.closest('tr').attr('userid');
		var businessid = $this.closest('tr').attr('businessId');
		var title = $this.closest('tr').find('.title').val();
		var desc = $this.closest('tr').find('.desc').val();
		var busname = $this.closest('tr').find('.busname').html();
		var fav_res = '';
		var via = "businesspage";
		if(title == '' || title == undefined || title == null){
			alert("please insert Favorite Title");
			return false;
		}
		$.ajax({
            type: "POST",
            url: "<?=base_url('/Online_delivery/save_notes');?>",
            dataType: "json",
            data:{'restaurant':businessid,'title':title,'desc':desc,'userid':userid,'fav_res':fav_res,'via':via},
            beforeSend: function() {
              $("#loading").show();
            },
            complete: function() {
              $("#loading").hide();
            },
            success: function(r){
				var html = '<tr userid="'+userid+'" businessId="'+businessid+'"><td class="busname">'+busname+'</td><td class="fav_id"></td><td class="tdtitle"><input type="text" class="title"/></td><td class="tddesc"><input type="text" class="desc"/></td><td class="favaddon"><i style="font-size:22px;" class="fa fa-plus" onclick="addnotes($(this))"></i></td></tr>';
				if(r.type == 'success'){
					$this.closest('tr').find('.fav_id').html('Fav#'+r.data);
              		$this.closest('tr').find('.tdtitle').html(title);
              		$this.closest('tr').find('.tddesc').html(desc);
              		// $this.closest('tr').find('.favaddon').html('123');
              		$this.closest('tr').after(html);
              	}else{
              		alert("Item Already Exists.");
              	}      
            }
        });
	}	

	function getmodalopen(serviceno, businessId,userId,businessname){
		var userId = '<?= $user_id;?>';
		var zone_id = $('input[name="zoneid"]').val(); 
		var check = check_mail_send(userId,businessId);
		if(serviceno != 0){
    		$('#servicenohead').html('<a href="tel:+'+serviceno+'" class="Blondie">Call Restaurant Now</a>');
    	}else{
    		$('#servicenohead').html('FO$ is faster, easier, more accurate,<br> and saves both you and the restaurant money!<br><br> Ask this business to use FO$! Well\'ll add 50 cents to your cash certificate account,by clicking button!<br> (Limit 50 cents added per restaurant)');
    		$('#servicenohead').css('color','#000');
    		if(userId != ''){
    			if(check == 0 || check == '' || check == null){
					$('#servicenohead').append("<br><button zone_id="+zone_id+"  userid="+userId+" businessId="+businessId+" businessname="+businessname+" style='background:#267dff;' type='button' class='sendmail btn btn-info'>Click for 50 cents</button>");
				}
			}else{
				$('#servicenohead').append("<br><button zone_id="+zone_id+"  userid="+userId+" businessId="+businessId+" businessname="+businessname+" style='background:#267dff;' type='button' class='btn btn-info'>Login to get 50 cents</button>");
			}
    	}
		
		var html = '';



		<?php if ($user_id) { ?>

			var base_url = '<?= base_url(); ?>';
			$.ajax({
	        	type: "POST",
	        	url: base_url + "BusinessSearch/getfavres",
	        	dataType:'json',
	        	data: {'userId' :userId,'businessId' :businessId},
	        	success: function (e) {
	        		if(e.length > 0){
	        			$.each(e, function (k, v) {
	        				html += '<tr>';
	        				html += '<td>'+businessname+'</td>';
	        				html += '<td>Fav#'+v.id+'</td>';
	        				html += '<td>'+v.fav_title+'</td>';
	        				html += '<td>'+v.fav_note+'</td>';
	        				html += '</tr>';
	    				});
	    				html += '<tr userid="'+userId+'" businessId="'+businessId+'"><td class="busname">'+businessname+'</td><td class="fav_id"></td><td class="tdtitle"><input type="text" class="title"/></td><td class="tddesc"><input type="text" class="desc"/></td><td class="favaddon"><i style="font-size:22px;" class="fa fa-plus" onclick="addnotes($(this))"></i></td></tr>';
	    				$('#showfavnotes').html(html);
	        		}else{
	        			$('#showfavnotes').html('<tr userid="'+userId+'" businessId="'+businessId+'"><td class="busname">'+businessname+'</td><td class="fav_id"></td><td class="tdtitle"><input type="text" class="title"/></td><td class="tddesc"><input type="text" class="desc"/></td><td class="favaddon"><i style="font-size:22px;" class="fa fa-plus" onclick="addnotes($(this))"></i></td></tr>');	
	        		}
	        	}
	    	});
	    	$('#favfooterdiv').html('<button type="button" class="btn btn-info"><a target="_blank" href='+base_url+'online_delivery/favourites/'+zone_id+'/'+businessId+'>Edit Favorites</a></button>');

		<?php }else{  ?>

			$('#showfavnotes').html('<tr><td colspan="5" style="text-align:center;">Login to see your favorites</td></tr>');


		<?php }  ?>

 			




		
	}

	$(document).on('click','.sendmail', function(){
		var userId = $(this).attr('userid');
		var businessId = $(this).attr('businessid');
		var businessname = $(this).attr('businessname');
		var zone_id = $(this).attr('zone_id');
		$.ajax({
	       	type: "POST",
	        url: base_url + "BusinessSearch/sendEmail",
	        dataType:'json',
	        data: {'userId' :userId,'businessId' :businessId,'businessname' :businessname,'zone_id' :zone_id},
	        success: function (e) {
	    		    		
	        }
	    });		
	})
	
	$(document).on('click','.incart', function(){
		$('#cart_modal_checkout').modal('hide');
	});
	
	$(document).on('click','.checkout', function(){
		var baseUrl = '<?= base_url(); ?>';
		var zone_id = $('input[name="zoneid"]').val();
		window.location.href = baseUrl+'businessSearch/cart/'+zone_id;	
	});
	
	function check_mail_send(userId,businessId){
		var res = 0;
		$.ajax({
	       	type: "POST",
	        url: base_url + "BusinessSearch/checkEmail",
	        dataType:'json',
	        async:false,
	        data: {'userId' :userId,'businessId' :businessId},
	        success: function (e) {
	    		    res = e.data;		
	        }
	    });	
	    return res;
	}

 $("input.list_view_third").attr();
 
 
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