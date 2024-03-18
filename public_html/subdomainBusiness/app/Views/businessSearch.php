<?=$this->extend("layout/businessmaster")?>
<?=$this->section("pageTitle")?>
<?= $loginzonenamenew; ?> Deals | Savingssites
<?=$this->endSection()?>
<?=$this->section("businesscontent")?>
<?=$this->include("includes/modals")?>
<style>.hide{
   display: none;
}</style>
<section id="ss-slider" class="" ></section>
<style>
   @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap');
</style>
<input type="hidden" id="urlsubcat" value="<?= $urlsubcat; ?>"/>
<input type="hidden" id="amazonurl" value="<?= $amazonurl; ?>"/>
<input type="hidden" value="<?= $pagesidebar;?>" class="pagesidebar" id="pagesidebar"/>
<input type="hidden" value="<?= $user_snap_settings;?>" class="user_snap_settings" id="user_snap_settings"/>
<input type="hidden" value="" class="googlelatdealpage" id="googlelatdealpage"/>
<input type="hidden" value="" class="googlelngdealpage" id="googlelngdealpage"/>




<section class="topslider sectionzonediv" style="background-color: grey;display: none;">
   <div class="container">
      <div class="row sec-1">
         <div class="row topicons">
            <div class="col-md-4">
               <div class="boxex setheight">
                  <span class="top_icon"><img src="https://cdn.savingssites.com/Circled1.png"></span>
                  <b>Save by Giving! Give by Saving!</b>
                  <p>Deal Example: Pay business only $30 for $60 value! To access that $30 discount, and support your favorite nonprofit, you only pay a small part of the $30 discount now.</p>
                  <span class="bottom_icon"><span class="videomodal1">Explainer Video ></span><a href="#"><img vtype="1" class="videomodal" src="https://cdn.savingssites.com/VideoButton.png"></a></span>
               </div>
            </div>
            <div class="col-md-4">
               <div class="boxex">
                  <span class="top_icon"><img src="https://cdn.savingssites.com/Circled2.png"></span>
                  <b>Free $5 Extra for 1st Use!</b>
                  <p>Every business has a FREE $5 button for 1st time use of its deal! Click as many businesses Free $5 buttons as you like to save an extra $5 for each!</p>
                  <span class="bottom_icon"><span class="videomodal1">Explainer Video ></span><a href="#"><img  vtype="2" class="videomodal" src="https://cdn.savingssites.com/VideoButton.png"></a></span>
               </div>
            </div>
            <div class="col-md-4">
               <div class="boxex">
                  <span class="top_icon"><img src="https://cdn.savingssites.com/Circled3.png"></span>
                  <b>Activities, Events, and More!</b>
                  <p>Freely search for fun activities and events. Hosted by municipalities, schools, nonprofits and businesses!</p>
                  <span class="bottom_icon"><span class="videomodal1">Explainer Video ></span><a href="#"><img  vtype="3" class="videomodal" src="https://cdn.savingssites.com/VideoButton.png"></a></span>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<br>
<section class="top_list_area">
   <input type="hidden" id="refdealuser" value="<?= $dealsuserid; ?>"/>
<input type="hidden" id="referdealid" value="<?= $referdealid; ?>"/>
   <div class="container-fluid header-list-items">
      <div class="row hide_on_mobile parent child">
<div class="container sublist">
         <ul class="cus-ul">
            <?php 
            $sr = 0;
            foreach ($combinefood as $k => $v) {
               $sr++; 
               $category=explode('#',$k);
               if($sr == 1){

                  $clss = 'activelist';
               }else{
                  $clss = '';
               }

               ?>
               <li class="show-list <?= $clss; ?> catid<?= $category[1]; ?>" catid="<?= $category[1]; ?>" titlecat="<?= $category[0];?>"><span class="liss"><?= $category[0]; ?></span></li>

            
         <?php } ?>
            <li class="show-list1 btn--shockwaveremove  is-active"  catid="12" titlecat="Grocery Specials"><span class="liss" style="position: relative;top: 11px;font-size: 15px;">
               <a href="<?= base_url();?>/groceryStore" target="_blank">Grocery Specials</a></span></li>
          <div class="container">
      <?php 
         foreach($combinefood as $k => $v){ 
            $category=explode('#',$k);    
            echo '  <div class="hide maincategory showmaincat'.$category[1].'"><a class="show_ads_specific_category" href="javascript:void(0);" rel="'.$category[1].'" id="'.$category[1].'">Show all Deals within this Panel!</a></div>';
                  

               
            $count =0;
            foreach ($v as $k1 => $v1) {
               $subcat_arr = explode('#@#',$k1);
               if($count != '0'){
                  // $padding = 'padding:40px;';
               }else{
                  $padding = '';
               }
               ?>

               <div style="<?= $padding; ?>" class="list-show showcategory_<?= $category[1]; ?>">
               <div class="col-one">
               <?php 
                  if($count == '0'){
                     //echo '  <div><a class="show_ads_specific_category" href="javascript:void(0);" rel="'.$category[1].'" id="'.$category[1].'">Show all Deals within this Panel!</a></div>';
                  }
                  if(is_string($v1)){
                        $sub_category=explode('#',$v1); 
                        echo '<a class="show_ads_specific_sub_category" href="javascript:void(0);" rel="'.$sub_category[1].'" id="'.$sub_category[1].'">'.$sub_category[0].''.$sub_category[2].'</a>'; 
                  }
               ?>
               <?php 
                  if($subcat_arr[0] != '' && $subcat_arr[0] > 0){
                     // echo '<h2>'.$subcat_arr[0].'</h2>';
                  }
               ?>
               <?php 
                  if(is_array($v1)){ ?>
                     <div class="deals_sub_cat"> 
                        <?php  foreach ($v1 as $k2 => $v2) {
                           $sub_category=explode('#',$v2);
                        ?>
                           <a class="show_ads_specific_sub_category" href="javascript:void(0);" rel="<?php echo $sub_category[1];?>" id="<?php echo $sub_category[1];?>"><?php echo $sub_category[0]; ?><?php echo $sub_category[2]; ?></a>
                        <?php } ?>
                     </div>
               <?php   }
               $count++;
               ?>
               </div>
              
               </div> 
               <?php } 
         }
       ?>
    </div>
         </ul>
</div>

   
      </div>
      <div class="row hide_on_desktop">
         <div class="col-sm-12">
            <div class="container_cat">
               <div class="mobile_view">
                  <select class="dropdown_select_cat round left">
                  <?php foreach ($combinefood as $k => $v) { 
                     $category=explode('#',$k);?>
                        <option class="show-list" value="<?= $category[1]; ?>" titlecat="<?= $category[0];?>"><span class="liss"><?= $category[0]; ?></span></option>
                     <?php } ?>
                  </select>
                  <select class="sub_mob_populate round left">
                  </select>
               </div>
            </div>
         </div>
<div class="col-md-12">        
    <ul class="mobile-ul-li ">
            <li class="search-container header-list-items">
               <div id="search_box" style="background:none;">
                  <div id="search_input_box" class="backgroundfff">
                     <a href="#" class="sortopen btn top-btn round1 left">Find & Sort</a>

                     <!-- <a href="#" class="sortopen btn top-btn">Find Sort Options<i class="fa fa-hand-o-down" aria-hidden="true"></i></a> -->
                  </div>
               </div>
            </li>
            <li class="dropdown dropdown1">
               <?php if(empty($userid)) {   ?>
               <a href="javascript:void(0);" class="showfavorite favbus btn top-btn clicksnapsignup" data-target="#login-box" data-toggle="modal"><i class="fa fa-heart menu-icon red"></i>&nbsp;Saved Favs!</a>
               <?php }else{?>
               <a href="javascript:void(0);" class="favbus btn top-btn show_favorites_ads" ><i class="fa fa-heart menu-icon red"></i>&nbsp;Saved Favs!</a>
               <?php } ?>
            </li>
         </ul></div>
      </div>
   </div>
</section>
<section class="search_area hide_on_mobile">
   <div class="header-top 11" id="header">
      <div class="container">
         <div class="row justify-content-center align-items-xl-center">
            <div class="col-12 col-lg-12">
               <ul class="zipform" id="zipform">
                  <li>
                     <form action="#" id="claim">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="bv_header_breadcrumb">
                                 <h1>Restaurants</h1>
                              </div>
                              <a href="#" class="sortopen btn top-btn">Sort Options<i class="fa fa-hand-o-down" aria-hidden="true"></i></a>
                              <div id="area-category" class="122 sortarea categoryview directorybanner">
                                 <div class="hsbannermain exht cat-banner-main">
                                    <input type="hidden" class="selectedfiltere">
                                    <ul class="search-wrapper">
                                    <div class="row">
                                       <div class="col-md-3">
                                       <li class="dropdown sortby">
                                          <a href="#" class="btn top-btn" id="sortenoption" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-sort-amount-desc"></i> Sort Digital Deals</a>
                                          <div class="dropdown-menu dropdown-menu-right text-left">
                                             <h4 class="dropdown-header">Sort By Cash Certificate Offers</h4>
                                             <div class="dropdown-divider"></div>
                                             <a class="dropdown-item pboo-filter" data-search="redemptionvalue" data-filter="redemption_high" href="javascript:void(0);">Cert Value: High to Low</a>
                                             <a class="dropdown-item pboo-filter"  data-search="redemptionvalue"  data-filter="redemption_low" href="javascript:void(0);">Cert Value: Low to High</a>
                                             <a class="dropdown-item pboo-filter"  data-search="redemptionvalue"  data-filter="deal_price_high" href="javascript:void(0);">Pay Business Deal Price: High to Low</a>
                                             <a class="dropdown-item pboo-filter"  data-search="redemptionvalue"   data-filter="deal_price_low" href="javascript:void(0);">Pay Business Deal Price Low to High</a> 
                                             <!-- <a class="dropdown-item pboo-filter"  data-search="redemptionvalue"  data-filter="high to low" href="javascript:void(0);">Net Savings: High to Low</a>
                                             <a class="dropdown-item pboo-filter"  data-search="redemptionvalue"  data-filter="low to high" href="javascript:void(0);">Net Savings: Low to High</a> -->
                                             <a class="dropdown-item pboo-filter"  data-search="redemptionvalue"  data-filter="a-z" href="javascript:void(0);">Business Name: A to Z</a>
                                             <a class="dropdown-item pboo-filter"  data-search="redemptionvalue" data-filter="z-a" href="javascript:void(0);">Business Name: Z to A</a>
                                             <a class="dropdown-item pboo-filter"  data-search="redemptionvalue"  data-filter="deal_left_high" href="javascript:void(0);">Deals Left: High to Low</a>
                                             <a class="dropdown-item pboo-filter"  data-search="redemptionvalue" data-filter="deal_left_low" href="javascript:void(0);">Deals Left: Low to High</a>
                                          </div>
                                       </li>
                                       </div>
                                       <div class="col-md-3">
                                       <li class="dropdown dropdown1">
                                          <a href="javascript:void(0);" class="showfavorite favbus btn top-btn clicksnapsignup" data-target="#login-box" data-toggle="modal"><i class="fa fa-heart menu-icon red"></i>&nbsp;Saved Favs!</a>
                                       </li>
                                       </div>
                                       <div class="col-md-3">
                                       <li class="dropdown dropdown2">
                                          <a class="btn dropdown-toggle  top-btn atozfilteroption" data-toggle="dropdown" href="#"><i class="fa fa-sort-alpha-asc menu-icon green"></i>&nbsp; Alpha (A-Z)</a>
                                          <ul class="dropdown-menu w300">
                                             <li>
                                                <div class="fullmenu">
                                                   <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="" class="show_all_ads">All</a>
                                                   <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="A" class="show_all_ads">A</a>
                                                   <a style="" href="javascript:void(0);" data-search="businessaplhaname"   rel="B" class="show_all_ads">B</a>
                                                   <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="C" class="show_all_ads">C</a>
                                                   <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="D" class="show_all_ads">D</a>
                                                   <a style="" href="javascript:void(0);" data-search="businessaplhaname"   rel="E" class="show_all_ads">E</a>
                                                   <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="F" class="show_all_ads">F</a>
                                                   <a style="" href="javascript:void(0);" data-search="businessaplhaname"   rel="G" class="show_all_ads">G</a>
                                                   <a style="" href="javascript:void(0);" data-search="businessaplhaname"  data-search="businessname"  rel="H" class="show_all_ads">H</a>
                                                   <a style="" href="javascript:void(0);" data-search="businessaplhaname"   rel="I" class="show_all_ads">I</a>
                                                   <a style="" href="javascript:void(0);" data-search="businessaplhaname"   rel="J" class="show_all_ads">J</a>
                                                   <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="K" class="show_all_ads">K</a>
                                                   <a style="" href="javascript:void(0);" data-search="businessaplhaname"   rel="L" class="show_all_ads">L</a>
                                                   <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="M" class="show_all_ads">M</a>
                                                   <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="N" class="show_all_ads">N</a>
                                                   <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="O" class="show_all_ads">O</a>
                                                   <a style="" href="javascript:void(0);" data-search="businessaplhaname"   rel="P" class="show_all_ads">P</a>
                                                   <a style="" href="javascript:void(0);" data-search="businessaplhaname"   rel="Q" class="show_all_ads">Q</a>
                                                   <a style="" href="javascript:void(0);" data-search="businessaplhaname" rel="R" class="show_all_ads">R</a>
                                                   <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="S" class="show_all_ads">S</a>
                                                   <a style="" href="javascript:void(0);" data-search="businessaplhaname"   rel="T" class="show_all_ads">T</a>
                                                   <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="U" class="show_all_ads">U</a>
                                                   <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="V" class="show_all_ads">V</a>
                                                   <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="W" class="show_all_ads">W</a>
                                                   <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="X" class="show_all_ads">X</a>
                                                   <a style="" href="javascript:void(0);" data-search="businessaplhaname"   rel="Y" class="show_all_ads">Y</a>
                                                   <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="Z" class="show_all_ads">Z</a>
                                                   <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="1" class="show_all_ads">123</a>
                                             
                                                </div>
                                             </li>
                                          </ul>
                                       </li>
                                       </div>

                                         <div class="col-md-3">
                                          <li class="search-container">
                                             <div id="search_box">
                                                <div id="search_input_box">
                                                   <input class="search_cont form-control search_business" data-search="businessname"  type="text" placeholder="Search by Business Name" name="business-name"/>
                                                   <a class="search_cont_but form-control businessNameSearch" style=""><i class="fa fa-search"></i></a>
                                                </div>                                            
                                             </div>
                                             <div class="searchInputResults"></div>

                                          </li>
                                       </div>


                                    </div>
                                    <div class="row m-30">
                                       <div class="col-md-3">
                                       <li class="viewFilters">
                                          <div class="container">
                                             <ul>
                                                <li>
                                                   <p class="filterviewtext">Deals Per Row </p>
                                                </li>
                                                <li> 
                                                   <a href="javascript:return void(0);" data-view="compact" class="theme-btn gridlist">[2]</a> 
                                                </li>
                                                <li> 
                                                   <a href="javascript:return void(0);"   data-view="fourgrid"  class="gridviewfour active theme-btn gridlist">[4] </a> 
                                                </li>
                                             </ul>
                                          </div>
                                       </li>
                                       </div>
                                       <div class="col-md-3">              <li class="align-center hide_on_mobile">
                                          <input type="hidden" id="total_post" value="" />
                                          <input type="hidden" id="searchtype" value="" typeset="show_ads_specific_category" />
                                          <div class="pagination hide">
                                             <ul class="pagination_count">
                                                
                                             </ul>
                                          </div>

                                          
                                       </li></div>
                                       <div class="col-md-3">
                                       <div class="miles">
                                          <select class="miles_count">
                                             <option value="">Miles from Me</option>
                                             <option value="1">1 Miles</option>
                                             <option value="2">2 Miles</option>
                                             <option value="3">3 Miles</option>
                                             <option value="4">4 Miles</option>
                                             <option value="5">5 Miles</option>
                                             <option value="6">6 Miles</option>
                                             <option value="7">7 Miles</option>
                                             <option value="8">8 Miles</option>
                                             <option value="9">9 Miles</option>
                                             <option value="10">10+ Miles</option>
                                          </select>

                                       </div>
                                       </div>
                                       <div class="col-md-3">                                          <div id="imgIcon" class="hide imgIcon"> 
                                          SNAP ALL
                                          <?php 
                                             if($user_snap_settings == 1){
                                                echo '<img src="https://cdn.savingssites.com/icon-2.png" alt="Miles Icon" class="miles-icon">';
                                             }else{
                                                echo '<img src="https://cdn.savingssites.com/snap-off.png" alt="Miles Icon" class="miles-icon">';
                                             }
                                          ?>
                                       </div></div>
                                    </div>
                                    <div class="row hide">
                                       <div class="col-md-3">                                          
                                          <div id="imgIcon" class="imgIcon"><span class="addressstoretodealpage">grain market,back side arora palace ludhiana </span> <i class="locationmodal fa fa-angle-down"></i></div>
                                       </div>  
                                    </div>
                                 </ul>

                                    <ul class="searched_param"></ul>
                                 </div>
                              </div>
                              <div class="  ">
                                 <div class="container">
                                    <div class="row align-items-center">
                                       <div id="foodModal" class="modal fade" role="dialog">
                                          <div class="modal-dialog">
                                             <div class="modal-content">
                                                <button type="button" class="close modal_close_btn" data-dismiss="modal">&times;</button>      
                                                <div class="modal-body">
                                                   <iframe width="100%" height="400" src="https://www.youtube-nocookie.com/embed/USZAofevitM"></iframe>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </form>
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</section>

<section class="search_area hide_on_desktop">
   <div id="header">
      <div class="container sectiondivfull section-full-div">
         <div class="row justify-content-center align-items-xl-center">
            <div class="col-12 col-lg-12">
               <ul class="zipform" id="zipform">
                  <li>
                     <form action="#" id="claim">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="bv_header_breadcrumb">
                                 <h1>Restaurants</h1>
                              </div>
                                 
                              <div id="area-category" class="121 sortarea categoryview directorybanner">
                                 <div class="hsbannermain exht cat-banner-main">
                                    <input type="hidden" class="selectedfiltere">
                                    <ul class="search-wrapper">
                                    <div class="row">
                                       <div class="col-md-12">
                                       <li class="search-container">
                                          <div id="search_box">
                                             <div id="search_input_box">
                                                <input class="search_cont form-control search_business" data-search="businessname"  type="text" placeholder="Enter business name and search" name="business-name"/>
                                                <a class="search_cont_but form-control businessNameSearch" style=""><i class="fa fa-search"></i></a>
                                             </div>
                                          </div>
                                       </li>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-md-6 mobiledealviewsection" style="margin-top:10px;">
                                          <li class="dropdown dropdown1 backgroundfff">
                                             <a href="javascript:void(0);" class="showfavorite favbus btn top-btn clicksnapsignup left" data-target="#login-box" data-toggle="modal"><i class="fa fa-heart menu-icon red"></i>&nbsp;See all of your saved favorites!</a>
                                          </li>
                                       </div>
                                       <div class="col-md-6 mobiledealviewsection">
                                          <div class="miles" style="margin:0px !important;">
                                             <select class="miles_count mobilemilescount round left">
                                                <option value="">All businesses from me by miles:</option>
                                                <option value="1">1 Miles</option>
                                                <option value="2">2 Miles</option>
                                                <option value="3">3 Miles</option>
                                                <option value="4">4 Miles</option>
                                                <option value="5">5 Miles</option>
                                                <option value="6">6 Miles</option>
                                                <option value="7">7 Miles</option>
                                                <option value="8">8 Miles</option>
                                                <option value="9">9 Miles</option>
                                                <option value="10">10+ Miles</option>
                                             </select>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-md-6 mobiledealviewsection">
                                          <li class="dropdown sortby backgroundfff section-full-div">
                                             <a href="#" class="btn top-btn round1 left" id="sortenoption" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-sort-amount-desc"></i> Sort deals by alpha, values and more</a>
                                             <div class="dropdown-menu dropdown-menu-right text-left">
                                                <h4 class="dropdown-header">Sort By Cash Certificate Offers</h4>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item pboo-filter" data-search="redemptionvalue" data-filter="redemption_high" href="javascript:void(0);">Cert Value: High to Low</a>
                                                <a class="dropdown-item pboo-filter"  data-search="redemptionvalue"  data-filter="redemption_low" href="javascript:void(0);">Cert Value: Low to High</a>
                                                <a class="dropdown-item pboo-filter"  data-search="redemptionvalue"  data-filter="deal_price_high" href="javascript:void(0);">Pay Business Deal Price: High to Low</a>
                                                <a class="dropdown-item pboo-filter"  data-search="redemptionvalue"   data-filter="deal_price_low" href="javascript:void(0);">Pay Business Deal Price Low to High</a> 
                                            
                                                <a class="dropdown-item pboo-filter"  data-search="redemptionvalue"  data-filter="a-z" href="javascript:void(0);">Business Name: A to Z</a>
                                                <a class="dropdown-item pboo-filter"  data-search="redemptionvalue" data-filter="z-a" href="javascript:void(0);">Business Name: Z to A</a>
                                                <a class="dropdown-item pboo-filter"  data-search="redemptionvalue"  data-filter="deal_left_high" href="javascript:void(0);">Deals Left: High to Low</a>
                                                <a class="dropdown-item pboo-filter"  data-search="redemptionvalue" data-filter="deal_left_low" href="javascript:void(0);">Deals Left: Low to High</a>
                                             </div>
                                          </li>
                                       </div> 
                                       <div class="col-md-6 mobiledealviewsection">                                          
                                          <div id="imgIcon" class="imgIcon backgroundfff" style="margin: 0px !important;padding: 5px 0px;">For subcategory SNAP status login:
                                          <?php if(empty($userid)){
                                             echo '<img src="https://cdn.savingssites.com/snap-off-black.png" alt="Miles Icon" class="miles-icon">';
                                          }else{
                                             if($user_snap_settings == 1){
                                                echo '<img src="https://cdn.savingssites.com/icon-2.png" alt="Miles Icon" class="miles-icon">';
                                             }else{
                                                echo '<img src="https://cdn.savingssites.com/snap-off.png" alt="Miles Icon" class="miles-icon">';
                                             }  
                                          }
                                          ?>
                                          </div>
                                       </div>
                                       
                                    </div>
                                    <div class="row">
                                       <div class="col-md-12 mobiledealviewsection"> 
                                          <li class="align-center">
                                             <input type="hidden" id="total_post" value="" />
                                             <input type="hidden" id="searchtype" value="" typeset="show_ads_specific_category" />
                                             <div class="pagination hide backgroundfff">
                                                <ul class="pagination_count mobilemilescount"></ul>
                                             </div>
                                          </li>
                                       </div>
                                       <div class="col-md-6 mobiledealviewsection hide">
                                          <li class="dropdown dropdown2 backgroundfff">
                                             <a class="btn dropdown-toggle  top-btn atozfilteroption" data-toggle="dropdown" href="#"><i class="fa fa-sort-alpha-asc menu-icon green"></i>&nbsp; Alpha (A-Z)</a>
                                             <ul class="dropdown-menu w300">
                                                <li>
                                                   <div class="fullmenu">
                                                      <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="" class="show_all_ads">All</a>
                                                      <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="A" class="show_all_ads">A</a>
                                                      <a style="" href="javascript:void(0);" data-search="businessaplhaname"   rel="B" class="show_all_ads">B</a>
                                                      <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="C" class="show_all_ads">C</a>
                                                      <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="D" class="show_all_ads">D</a>
                                                      <a style="" href="javascript:void(0);" data-search="businessaplhaname"   rel="E" class="show_all_ads">E</a>
                                                      <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="F" class="show_all_ads">F</a>
                                                      <a style="" href="javascript:void(0);" data-search="businessaplhaname"   rel="G" class="show_all_ads">G</a>
                                                      <a style="" href="javascript:void(0);" data-search="businessaplhaname"  data-search="businessname"  rel="H" class="show_all_ads">H</a>
                                                      <a style="" href="javascript:void(0);" data-search="businessaplhaname"   rel="I" class="show_all_ads">I</a>
                                                      <a style="" href="javascript:void(0);" data-search="businessaplhaname"   rel="J" class="show_all_ads">J</a>
                                                      <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="K" class="show_all_ads">K</a>
                                                      <a style="" href="javascript:void(0);" data-search="businessaplhaname"   rel="L" class="show_all_ads">L</a>
                                                      <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="M" class="show_all_ads">M</a>
                                                      <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="N" class="show_all_ads">N</a>
                                                      <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="O" class="show_all_ads">O</a>
                                                      <a style="" href="javascript:void(0);" data-search="businessaplhaname"   rel="P" class="show_all_ads">P</a>
                                                      <a style="" href="javascript:void(0);" data-search="businessaplhaname"   rel="Q" class="show_all_ads">Q</a>
                                                      <a style="" href="javascript:void(0);" data-search="businessaplhaname" rel="R" class="show_all_ads">R</a>
                                                      <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="S" class="show_all_ads">S</a>
                                                      <a style="" href="javascript:void(0);" data-search="businessaplhaname"   rel="T" class="show_all_ads">T</a>
                                                      <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="U" class="show_all_ads">U</a>
                                                      <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="V" class="show_all_ads">V</a>
                                                      <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="W" class="show_all_ads">W</a>
                                                      <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="X" class="show_all_ads">X</a>
                                                      <a style="" href="javascript:void(0);" data-search="businessaplhaname"   rel="Y" class="show_all_ads">Y</a>
                                                      <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="Z" class="show_all_ads">Z</a>
                                                      <a style="" href="javascript:void(0);" data-search="businessaplhaname"  rel="1" class="show_all_ads">123</a>
                                                   </div>
                                                </li>
                                             </ul>
                                          </li>
                                       </div>
                                       
                                    </div>


                                      
                                      
                                 
                                      
                                    </div>
                                
                                    






                                    </ul>

                                 
                                 </div>
                              </div>
                             
                           </div>
                        </div>
                     </form>
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</section>

<!-- <button type="button" class="btn btn-primary btn-grocry"><a href="groceryStore" style="color: white;" target="_blank">Grocery Store</a></button>   -->


<section class="order_list_area fourth_view"> <!---second_view third_view fourth_view--->
   <ul id="myTab" style="border: none;" class="nav nav-tabs">

   </ul>
   <div class="container">
      <div class="row" id="appendtwocolumndiv"></div>
         <div class="row align-middle">
         <div class="col-md-12 col-sm-12 align-center">
            <div class="pagination">
               <ul class="pagination_count">
                  
               </ul>
            </div>
         </div>
   </div>
   </div>

</section>
<div class="modal audiorapper" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="audiomodal">
   <div class="modal-dialog" role="document">

      <div class="modal-content content">       
         <h2><center class="headertitlenew" id="headertitle">abc</center></h2>         
         <div class="modal-body">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         <div class="banner">
  <img id="imagemodal" src="https://cdn.savingssites.com/citystreet.jpg?w=800&auto=compress" alt="">
  <h3>
   <center id="middleheading">wonderful Monday</center>
   <center id="middleheadingpdf">wonderful Monday</center>
  </h3>
  <div class="bottomContent">
         <!-- <div class="icon bottomExpand"></div> -->
         <div class="progressBar">
            <div class="timer">
               <span class="currentTime">00:00</span>
               <span class="endTime">0NaN:0NaN</span>
            </div>
            <div class="barTimer"><span class="progress"></span></div>
         </div>
         <audio id="modalaudiosrc" src="" controls></audio>
            <!-- <div class="player">
               <div class="icon prev swiper-button-prev prev-track" onclick="prevTrack()" tabindex="0" role="button" aria-label="Previous slide"></div>
            <div class="btnPlay">
               <div class="playpause-track" onclick="playpauseTrack()"><i class="fa fa-play-circle fa-5x"></i></div>
            </div>
            <div class="icon next swiper-button-next next-track" onclick="nextTrack()" tabindex="0" role="button" aria-label="Next slide"></div>
            <div class="slider_container">
                     <div class="current-time">00:00</div>
                     <input type="range" min="1" max="100" value="0" class="seek_slider" onchange="seekTo()">
                     <div class="total-duration">00:00</div>
                  </div>
          </div> -->


      </div>
      </div>
            <!-- <audio id="audio_data" controls autoplay></audio> -->
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
   const slider = document.querySelector('.parent');
   let mouseDown = false;
   let startX, scrollLeft;
   
   let startDragging = function (e) {
      mouseDown = true;
      startX = e.pageX - slider.offsetLeft;
      scrollLeft = slider.scrollLeft;
   };
   
   let stopDragging = function (event) {
      mouseDown = false;
   };
   
   slider.addEventListener('mousemove', (e) => {
      e.preventDefault();
      if(!mouseDown) { return; }
      const x = e.pageX - slider.offsetLeft;
      const scroll = x - startX;
      slider.scrollLeft = scrollLeft - scroll;
   });
   
   // Add the event listeners
   slider.addEventListener('mousedown', startDragging, false);
   slider.addEventListener('mouseup', stopDragging, false);
   slider.addEventListener('mouseleave', stopDragging, false);
</script>
<?=$this->endSection()?>
<!-- 
<script type="text/javascript">
$(document).ready(function(){
$('.show-list').each(function(i){
    if($(this).is('.open')){
      $(".bv_header_breadcrumb h1").text(i);
    }else{
      $(".bv_header_breadcrumb h1").text("resturent");
    }
});
});
</script> -->