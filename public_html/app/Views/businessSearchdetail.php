<?=$this->extend("layout/businessdetailmaster")?>
<?=$this->section("pageTitle")?>
Savings Sites Business Search
<?=$this->endSection()?>
<?=$this->section("businessdetailcontent")?>
<?=$this->include("includes/modals")?>
<style>.hide{
   display: none;
}</style>
<style>
   @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap');
</style>
<?php 
   // $sponsor_business_id=0;
   // if($business_sponsored_status[0]->id){
   //    $sponsor_business_id=$business_sponsored_status[0]->id;
   // }
   
   // $zone_id      = (int)$zoneid;
   // $business_id  = (int)$busid;
   // $logo         = $common['sub_header_name_from_zone']['logo'];
   // $condition_1  = $common['approval']['approval'] ;   
   // $condition_2  = $common['usergroup']->group_id ;       
   // $userid=$common['sub_header_name_from_zone']['business_owner_id'];
   // if($common['from_zoneid']!=''){
   //    $business_id_ra=$common['sub_header_name_from_zone']['id'];
   // }else{
   //    $business_id_ra=$business_id;
   // }
   
   function check_file($filename){
      // $file_headers = get_headers($filename,1);
      // $urlpars = parse_url($filename);
      // $ext = array('png', 'jpg', 'jpeg', 'gif'); 
      // $img_extension = pathinfo($filename, PATHINFO_EXTENSION);   
      // if($file_headers[0] == 'HTTP/1.0 404 Not Found'){

      // }else if(!file_exists($_SERVER['DOCUMENT_ROOT'].$urlpars['path'])){

      // } else if($urlpars['scheme'] != 'https' && $urlpars['scheme'] != 'http'){

      // }else if(!in_array($img_extension, $ext)){

      // }   else {
         return 1;
      // }
   }
?>

<link rel="stylesheet" type="text/css" href="https://savingssites.com/assets/businessSearch/css/custom.css?v=<?php echo rand(); ?>">
<!-- <link rel="stylesheet" type="text/css" href="https://savingssites.com/assets/businessSearch/css/style.css?v=1648728312.7515"> -->
dem here 
<section id="bv_deal_grid" class="list_view_third cus-offer">
   <p style="text-align: center;"><span style="font-size: 25px;font-weight: bold;text-align: center;font-family: 'general_sansbold';color: #01519a;" desc="<?= $busdata[0]['history'];?>"><u id="historybusinessdetail">Our History</u></span></p>
   <input type="hidden" id="get_zoneid" value="<?= $zoneid ?>"/>
   <div class="container" bis_skin_checked="1" >
      <div class="row justify-content-center align-items-xl-center " bis_skin_checked="1">
         <div class="col-12 col-lg-12 col-md-12" bis_skin_checked="1">
            <h2 class="amaging_haeding"><?=$zone_name?>   is Proud to Support Local Non-Profits!</h2>
         </div>
      </div>
      <div class="row justify-content-center align-items-xl-center">
         <?php foreach($deals as $deals) { ?>
         <div class="col-xl-3 col-md-3 col-lg-3 haveoffer">
            <h3 class="featured-title"><?= $deals['deal_title'] ?></h3>
            <div class="owl-slider sq-price">
               <img class="owl-image" src="<?= base_url(); ?>/assets/SavingsUpload/Business/<?= $business_id ?>/<?= $deals['card_img']; ?>" alt="">
               <table>
                  <tbody>
                     <tr>
                        <td>Cert Value: </td>
                        <td style="text-align: end;">$<?= $deals['buy_price_decrease_by']; ?>
                           <a class="pkbpop1" href="#" data-title="Title" data-content="Some Description<br>Some other description" data-toggle="modal" data-target="#pbkPop1">
                              <img class="img-responsive" src="https://savingssites.com/assets/stylesheets/images/info-icon-27.png">
                           </a>
                        </td>
                     </tr>
                     <tr>
                        <td>Pay Bus: </td>
                        <td style="text-align: end;">
                           <?php if ($deals['current_price']) {
                                 echo '$'. number_format($deals['current_price'],2);
                              }else{
                                 echo "N/A";
                              }  
                           ?>
                           <a class="pkbpop1" href="#" data-toggle="modal" data-target="#pay_bus_deal">
                              <img class="img-responsive" src="https://savingssites.com/assets/stylesheets/images/info-icon-27.png">
                           </a>
                        </td>
                     </tr>
                     <tr>
                        <td>Deals Left: </td>
                        <td style="text-align: end;">
                           <?php if($deals['numberofconsolation'] <= '0' && $deals['numberofconsolation'] != -1){   
                                 echo "<span style='color:red;font-weight: 700;font-size: 11px;'>SOLD OUT</span>";  
                              }elseif(
                                 $deals['numberofconsolation'] == -1){ echo "Unlimited"; 
                              }else { 
                                 echo  @$deals['numberofconsolation'] ;
                              } 
                           ?>
                           <a class="pkbpop1" href="#" data-toggle="modal" data-target="#org_fee" data-title="Title" data-content="Some Description<br>Some other description">
                              <img class="img-responsive" src="https://savingssites.com/assets/stylesheets/images/info-icon-27.png">
                           </a>
                        </td>
                     </tr>
                  </tbody>
               </table>
               <div class="addtocart">
               <?php 
                  echo "<span data_busid='".$business_id."' data-id='".$deals['dealid']."' item-name='".$deals['company_name']."' data-userid='".$userid."' data-zone='".$zone_id."' class='addtocart'>Add Deal to Cart</span><br>"; 
               ?>
               </div>
            </div>
      </div>
      <?php } ?>
   </div></div>
</section>

<?php 

   if($countTotalImage != 0){
      echo '<h2 class="amaging_haeding">Our Gallery</h2> 
               <section class="gallery-view">
                  <main class="gallery gallery__content--flow">';
      foreach ($busimages as $busimages) {
         if(isset($deals['card_img']) && $deals['card_img'] != ''){
            // echo '<a href='.base_url().'/assets/SavingsUpload/Business/'. $business_id .'/'.$deals['card_img'].'>
            //          <img src='.base_url().'/assets/SavingsUpload/Business/'. $business_id .'/'.$deals['card_img'].'>
            //       </a>';

            // echo "<img src='https://savingssites.com/assets/SavingsUpload/businessdetail/667/Tuesday-Lunch-Special-7-250px.jpg'>";
         } 
         if(isset($busimages['auctionimg']) && $busimages['auctionimg'] != ''){ 
            // echo '<a href='.base_url().'uploads/businessphoto/'. $busid .'/'.$busimages['auctionimg'].'> 
               // <img src='.base_url().'uploads/businessphoto/'. $busid .'/'.$busimages['auctionimg'].'>
            // </a>';
         }
         if(isset($busimages['adtext']) && $busimages['adtext'] != ''){ 
            // echo '<a href='.base_url().'/assets/SavingsUpload/Business/'. $busid .'/'.$busimages['auctionimg'].'> 
            //    <img src='.base_url().'/assets/SavingsUpload/Business/'. $busid .'/'.$busimages['auctionimg'].'>
            // </a>';
            // echo '<a href="'.$src.'">'.$busimages['adtext'].'</a>';
         } 
         /*business multi photo*/
       
         if(isset($busimages['galleryimage']) && $busimages['galleryimage']){ 
            foreach ($busimages['galleryimage'] as   $busimages['galleryimage']) {
               if($busimages['galleryimage'] != ''){
                  echo '<figure><img src='.base_url().'/assets/SavingsUpload/Business/'. $busid .'/'.$busimages['galleryimage'].'></figure>';
               }  
            }   
         }
     

           
                       
         /*business multi photo*/
      }
      echo '</main>
            </section>';
   }
       
?>
<!----565 videos start--->
<section id="bv_grid_videos">
                            <div class="container" bis_skin_checked="1" >
                                <div class="row justify-content-center align-items-xl-center" bis_skin_checked="1">

                                    <h2>Free Short Notice Alert Program Deals!</h2>
                                    <div class="col-sm-12 grid_row" style="padding: 12px 130px;" bis_skin_checked="1">
                                    
                                        <div class="col-12 col-lg-4 col-md-12 left_col_wraper video_col" bis_skin_checked="1">
                                            <iframe width="100%" height="315" src="https://www.youtube.com/embed/R4p89ui30yk"></iframe>
                                        </div>

                                        <div class="col-12 col-lg-4 col-md-12 left_col_wraper desc " bis_skin_checked="1">
                                            
                                            <p style="text-align: left;">Our Business submits deals to Savings Sites and only if the deals meet all 3 of your SNAP Filters does Savings Sites email you the deal.</p>

                                            <p>SNAP Filters: </p>
                               
                                            <p>(A) Your Minimum Discount Percentage Required.</p>
                                            <p>(B) Your Available Days of the Week to use deals.</p>
                                            <p>(C) Your Available Time of the Day to use deals.</p>

                                            <p style="text-align: left;">Simply Click SNAP Off <img src="<?= base_url(); ?>/assets/businessSearch/images/icon-1.png"> to SNAP On <img src="<?= base_url() ?>/assets/businessSearch/images/icon-2.png"> <br/>and set Your SNAP Filters.</p>
                                        </div>
                                       
                                        <div class="col-12 col-lg-4 col-md-12 left_col_wraper snapstatus" bis_skin_checked="1">
                                            <div class="icon_snap off">
                                                
                                                           <?php
                                if (!empty($newuserid)) {
                                ?>

                                <div class="snapdiv snapdiv">
                                    <?php
                                    if ($ad['snap_status'] == 1) {
                                    ?>

                                    <a class="toggle-on-off-img on emailnoticepopup mobile_hide" style="cursor: pointer;" data-target="#email_notice_pop_up_modal" data-toggle="modal" data-adid="<?php echo $adsdataid; ?>" data-busid="<?php  echo $business_id; ?>" data-userid="<?php echo $newuserid ?>"><img data-on="images/turn-on.png" data-off="<?=$base_url ?>assets/directory/images/turn-off.png" src="<?=$base_url ?>assets/directory/images/turn-on.png" class="for-img-shadow"/></a>

                                    <a class="toggle-on-off-img on emailnoticepopup mobile_view" style="cursor: pointer;" data-target="#email_notice_pop_up_modal" data-toggle="modal" data-adid="<?php echo $adsdataid; ?>" data-busid="<?php  echo $business_id; ?>" data-userid="<?php echo $newuserid ?>"><img data-on="images/turn-on-mobile.png" data-off="<?=$base_url ?>assets/directory/images/turn-off-mobile.png" src="<?=$base_url ?>assets/directory/images/turn-on-mobile.png" class="for-img-shadow"/></a>

                                    <span class="snappop" style="cursor: pointer;" data-toggle="modal" data-target="#snapPop9">
                                        <i class="fa fa-info-circle"></i></span>

                                    <?php } else {
                                    ?>
                                    <a class="toggle-on-off-img on emailnoticepopup mobile_hide" style="cursor: pointer;" data-target="#email_notice_pop_up_modal" data-toggle="modal" data-adid="<?php echo $adsdataid; ?>" data-busid="<?php  echo $business_id; ?>" data-userid="<?php echo $newuserid ?>" ><img data-on="images/icon_snapoff.png" data-off="<?=$base_url ?>/assets/directory/images/icon_snapoff.png" src="<?=$base_url ?>/assets/directory/images/icon_snapoff.png" class="for-img-shadow"/></a>

                                    <a class="toggle-on-off-img on emailnoticepopup mobile_view" style="cursor: pointer;" data-target="#email_notice_pop_up_modal" data-toggle="modal" data-adid="<?php echo $adsdataid; ?>" data-busid="<?php  echo $business_id; ?>" data-userid="<?php echo $newuserid ?>"><img data-on="images/turn-on-mobile.png" data-off="<?=$base_url ?>/assets/directory/images/icon_snapoff.png" src="<?=$base_url ?>/assets/directory/images/icon_snapoff.png" class="for-img-shadow"/></a>

                                    <span class="snappop" style="cursor: pointer;" data-toggle="modal" data-target="#snapPop9">
                                        <i class="fa fa-info-circle"></i></span>

                                    <?php } ?>


                                         
                                </div>
                                <?php } else { ?>
                                <div class="snapdiv ss1">
                                    <a class="toggle-on-off-img on clicksnapsignup mobile_hide" data-target="#login-box" data-toggle="modal" style="cursor: pointer;"><img style="width: auto !important;" data-on="images/icon_snapoff.png" data-off="<?= base_url() ?>/assets/directory/images/turn-off.png" src="<?=base_url() ?>/assets/directory/images/icon_snapoff.png" class="for-img-shadow" data-target="login-box" data-toggle="modal"/></a>

                                    <a class="toggle-on-off-img on clicksnapsignup mobile_view"><img data-on="images/turn-on-mobile.png" data-off="<?= base_url() ?>/assets/directory/images/icon_snapoff.png" src="<?= base_url() ?>/assets/directory/images/turn-off-mobile.png" class="for-img-shadow" data-target="login-box" data-toggle="modal"/></a>
                                    <span class="snappop" style="cursor: pointer;" data-toggle="modal" data-target="#snapPop9">
                                        <i class="fa fa-info-circle"></i></span>
                                      
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
                                         <?php
                                        if (!empty($newuserid)) {
                                
                                            if ($ad['snap_status'] == 1) {
                                               ?>
                                                 <h3 style="font-weight: bold;font-size: 20px;margin-top: 15px;">
                                                        Good Job!
                                                      <br/>Your SNAP is ON!

                                                    </h3>
                                               <?php 

                                             }else{
                                                ?>
                                               <h3 style="font-weight: bold;font-size: 20px;margin-top: 15px;">
                                                Click SNAP now! <br/>
                                                    Change Red to Green!
                                                    </h3>
                                                <?php 
                                             }   

                                          }else{ ?>
                                         <h3 style="font-weight: bold;font-size: 20px;margin-top: 15px;">Click SNAP now! <br/>
                                                    Change Red to Green!
                                                    </h3>                                         <?php  }
                                      ?>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
</section>
<!----565 videos start--->


<section id="bv_grid_favorite">
   <div class="container" bis_skin_checked="1" >
                                <div class="row justify-content-center align-items-xl-center" bis_skin_checked="1">

                                    <h2><?=$zone_name?> Favorite Status</h2>
                                    <div class="col-sm-12 grid_row" style="padding: 30px 130px;background: #fff;text-align: center;font-size: 16px;font-weight: bold;" bis_skin_checked="1">                                       
                                        <div class="col-12 col-lg-12 col-md-12 left_col_wraper" bis_skin_checked="1">
   <?php if (!empty($newuserid)) {
      $get_ad_to_favourites = $this->ads->get_ad_to_favourites($adsdataid, $newuserid);
      if ($get_ad_to_favourites) {
   ?>
         <p>Thank you for making <?php echo $busdata[0]['name']; ?>  a fovourite!   <i class="fa fa-heart" style="color: red;"></i><br/>
         <a title="Bookmark this Offer" href="javascript:void(0);" class="btn btn-primary btn-large ad_favorite ad_fav" rel="1" data-adid="<?php echo $adsdataid; ?>" data-busid="<?php  echo $business_id; ?>" data-UserId = "<?= $newuserid ?>">
         <i class="fa fa-heart"></i> </a>
         <?php echo $busdata[0]['name'] ?> deals will be right there for you!</p>
         <p>Then when you use the <a href="javascript:void(0);" class="favbus btn top-btn  "><i class="fa fa-heart menu-icon red"></i>&nbsp;Saved Favs!</a>  button <?=$zone_name?> will be right there for you! </p>
         <p>Current Status <i class="fa fa-heart" style="color: red;" ></i> </p>
      <?php } else { ?>
         <p>We're Sad! The <?=$zone_name?> Favorite Heart is empty <i class="fa fa-heart-o" style="color: red;"></i><br/>
            Please show your love by filing it up with a click to solid red:
            <a title="Bookmark this Offer" href="javascript:void(0);" class="btn btn-primary btn-large ad_favorite ad_fav_new " rel="0" data-adid="<?php echo $adsdataid; ?>" data-busid="<?php  echo $business_id; ?>" data-UserId = "<?= $newuserid ?>">
               <i class="fa fa-heart" aria-hidden="true"></i> </a></p>
               <p>Then when you use the  button <?=$zone_name?> will be right there for you! </p>
               <p>Current Status <i class="fa fa-heart-o" style="color: red;" ></i> </p>
      <?php } } else {?>
         <p>We're Sad! The <?=$zone_name?> Favorite Heart is empty <i class="fa fa-heart-o" style="color: red;"></i><br/>
            Please show your love by filing it up with a click to solid red:
            <a title="Login to add business to favourite" href="javascript:void(0);" aria-hidden="true"  data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Login to add business to favourite" data-original-title="Login to add business to favourite" class="btn btn-primary btn-large ad_favorite ad_fav_data ad_fav_new cus_btn_login" rel="0" data-adid="<?php echo $adsdataid; ?>" data-busid="<?php  echo $business_id; ?>" data-UserId = "<?= $userid ?>">
               <i class="fa fa-heart" style="color: red;"></i> </a></p>
               <p>Then when you use the  button <?=$zone_name?> will be right there for you! </p>
               <p>Current Status <i class="fa fa-heart-o" style="color: red;" ></i> </p>
      <?php } ?>
         </div>
      </div>
      </div>
   </div>
</section>

<!---Section Contact us Stat ----->
<section id="contact_info">
                            <div class="container" bis_skin_checked="1" >
                                <div class="row justify-content-center align-items-xl-center" bis_skin_checked="1">
                                    <div class="col-sm-12" bis_skin_checked="1">
                                        <h2 class="heading">Contact Us</h2>
                                        <div class="col-12 col-lg-4 col-md-12 left_col_wraper" bis_skin_checked="1">
                                            
                                            <div class="address">
                                                <div  class="adress_col"><i class="fa fa-map-marker"></i> 
                                                <h3>Address</h3>
                                                   <p> <?php echo $busdata[0]['street_address_1'] ?> <br/>  <?php echo $busdata[0]['street_address_2'] ?> </p></div>


                                                
                                            </div>
                                        </div>


                                        <div class="col-12 col-lg-4 col-md-12 left_col_wraper" bis_skin_checked="1">
                                            
                                            <div class="address">
  

                                                <div class="phn_col"><i class="fa fa-phone"></i> 
                                                <h3>Phone Number</h3>
                                                    <p><a href="tel:<?php echo $busdata[0]['phone'] ?>"><?php echo $busdata[0]['phone'] ?></a> </p></div>

                                                
                                            </div>
                                        </div>


                                        <div class="col-12 col-lg-4 col-md-12 left_col_wraper" bis_skin_checked="1">
                                            
                                            <div class="address">
                                 

                                                <div class="email_col"><i class="fa fa-envelope-o"></i> 
                                                    <h3>Email Us</h3>
                                                    <p><a href="maitto:<?php echo $busdata[0]['contactemail'] ?>"><?php echo $busdata[0]['contactemail'] ?></a></p></div>
                                                
                                            </div>
                                        </div>                                                                                
                            
                                    </div>
                                </div>
                            </div>
</section>
 
 







<?=$this->endSection()?>