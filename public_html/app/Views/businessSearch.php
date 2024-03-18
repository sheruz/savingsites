   <?=$this->extend("layout/businessmaster")?>
<?=$this->section("pageTitle")?>
Savings Sites Business Search
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
<section class="top_list_area">
   <div class="container-fluid header-list-items">
      <div class="row hide_on_mobile parent child">
         <ul>
            <?php foreach ($combinefood as $k => $v) { 
               $category=explode('#',$k);
               ?>
               <li class="show-list" catid="<?= $category[1]; ?>"><?= $category[0]; ?></li>
            
         <?php } ?>
         </ul>
      <?php 
         foreach($combinefood as $k => $v){
            $count =0;
            $category=explode('#',$k);
            foreach ($v as $k1 => $v1) {
               $subcat_arr = explode('#@#',$k1);
               if($count != '0'){
                  $padding = 'padding:40px;';
               }else{
                  $padding = '';
               }
               ?>
               <div style="<?= $padding; ?>" class="list-show showcategory_<?= $category[1]; ?>">
               <div class="col-one">
               <?php 
                  if($count == '0'){
                     echo '  <div><a class="show_ads_specific_category" href="javascript:void(0);" rel="'.$category[1].'" id="'.$category[1].'">Show all Deals within this Panel!</a></div>';
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
               <?php
            }
         }
       ?>
   
      </div>
      <div class="row hide_on_desktop">
         <div class="col-sm-12">
            <div class="container_cat">
               <div class="mobile_view">
                  <select class="dropdown_select_cat">
                     <option class="fooditem" data-catid="1">
                        Restaurants
                     </option>
                     <option class="fooditem" data-catid="3">
                        B 2 B
                     </option>
                     <option class="fooditem" data-catid="6">
                        Contractors
                     </option>
                     <option class="fooditem" data-catid="7">
                        Education
                     </option>
                     <option class="fooditem" data-catid="8">
                        Events
                     </option>
                     <option class="fooditem" data-catid="9">
                        Health
                     </option>
                     <option class="fooditem" data-catid="10">
                        Home &amp; You
                     </option>
                     <option class="fooditem" data-catid="11">
                        Financial
                     </option>
                     <option class="fooditem" data-catid="12">
                        Medical
                     </option>
                  </select>
                  <select class="sub_mob_populate">
                     <option class="show_ads_specific_category" href="javascript:void(0);" data-catid="1" rel="1" id="1">Types of Businesses  </option>
                     <option disabled="true" class="sub_heading_cat">By Ethnicity</option>
                     <option data-catid="22" rel="22" id="22">American [221]</option>
                     <option data-catid="44" rel="44" id="44">Asian
                        [4]
                     </option>
                     <option data-catid="49" rel="49" id="49">European [9]</option>
                     <option data-catid="45" rel="45" id="45">Other Ethinic [3]</option>
                     <option disabled="true" class="sub_heading_cat">By Food Types</option>
                     <option data-catid="15" rel="15" id="15">Pizza/Italian [1]</option>
                     <option disabled="true" class="sub_heading_cat">By Type Of Service</option>
                     <option data-catid="40" rel="40" id="40">Bar &amp; Grill/Pub [2]</option>
                  </select>
               </div>
            </div>
         </div>
<div class="col-md-12">        
    <ul class="mobile-ul-li ">
            <li class="search-container">
               <div id="search_box" style="background:none;">
                  <div id="search_input_box">
                     <input class="search_cont form-control" type="text" placeholder="Search by Business Name" name="business-name"/>
                     <a class="search_cont_but form-control businessNameSearch" style=""><i class="fa fa-search"></i></a>
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
<section class="search_area">
   <div class="header-top" id="header">
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
                              <a href="#" class="sortopen btn top-btn">  Sort Options <i class="fa fa-times-circle"></i></a>
                              <div id="area-category" class="sortarea categoryview directorybanner">
                                 <div class="hsbannermain exht cat-banner-main">
                                    <input type="hidden" class="selectedfiltere">
                                    <ul class="search-wrapper">
                                       <li class="dropdown sortby">
                                          <a href="#" class="btn top-btn" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-sort-amount-desc"></i> Sort By</a>
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
                                       <li class="dropdown dropdown1">
                                          <a href="javascript:void(0);" class="showfavorite favbus btn top-btn clicksnapsignup" data-target="#login-box" data-toggle="modal"><i class="fa fa-heart menu-icon red"></i>&nbsp;Saved Favs!</a>
                                       </li>
                                       <li class="dropdown dropdown2">
                                          <a class="btn dropdown-toggle  top-btn" data-toggle="dropdown" href="#"><i class="fa fa-sort-alpha-asc menu-icon green"></i>&nbsp; Alpha (A-Z)</a>
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
                                       <li class="search-container">
                                          <div id="search_box">
                                             <div id="search_input_box">
                                                <input class="search_cont form-control search_business" data-search="businessname"  type="text" placeholder="Search by Business Name" name="business-name"/>
                                                <a class="search_cont_but form-control businessNameSearch" style=""><i class="fa fa-search"></i></a>
                                             </div>
                                          </div>
                                       </li>
                                       <li class="viewFilters">
                                          <div class="container">
                                             <ul>
                                                <li>
                                                   <p class="filterviewtext">Deals Per Row </p>
                                                </li>
                                                <li> 
                                                   <a href="javascript:return void(0);" data-view="compact" class="theme-btn active gridlist">[2]</a> 
                                                </li>
                                                <li> 
                                                   <a href="javascript:return void(0);"   data-view="fourgrid"  class="gridviewfour theme-btn gridlist">[4] </a> 
                                                </li>
                                             </ul>
                                          </div>
                                       </li>
              <li class="align-center hide_on_mobile">
            <input type="hidden" id="total_post" value="" />
            <input type="hidden" id="searchtype" value="" typeset="show_ads_specific_category" />
            <div class="pagination hide">
               <ul class="pagination_count">
                  
               </ul>
            </div>
            <div class="miles">
               <select class="miles_count">
                  <option value="">Select Miles</option>
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
         </li>
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
<section>
   <div class="container">
      <div class="row">
         <div class="col-md-12">
                          <div class="align-center hide_on_desktop">
            <input type="hidden" id="total_post" value="" />
            <input type="hidden" id="searchtype" value="" typeset="show_ads_specific_category" />
            <div class="pagination hide">
               <ul class="pagination_count">
                  
               </ul>
            </div>
                        <div class="miles">
               <select class="miles_count">
                  <option value="">Select Miles</option>
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
      </div>
   </div>
</section>
<section class="order_list_area second_view"> <!---second_view third_view fourth_view--->
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