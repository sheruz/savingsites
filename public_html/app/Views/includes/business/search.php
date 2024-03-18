<div class="bv_header_breadcrumb"> <h1>Restaurants</h1></div>
<a href="#" class="sortopen btn top-btn">  Sort Options <i class="fa fa-times-circle"></i></a>
<div id="area-category" class="sortarea categoryview directorybanner background_style">
  <div class="hsbannermain exht cat-banner-main">
  <?php if(count($_GET) == 2){ 
          if(@$_GET['redemptionvalue']){
            $val = $_GET['redemptionvalue'];
            $filtername = 'redemptionvalue';
          }else if(@$_GET['businessaplhaname']){
            $val = $_GET['businessaplhaname'];
            $filtername = 'businessaplhaname';
          }else if(@$_GET['cat-id']){
            $val = $_GET['cat-id'];
            $filtername = 'cat-id';
          }        
        }else{
          $filtername = '';
          $val = '';
        }
  ?>
    <input type="hidden" class="selectedfiltere" data-filter='<?= $filtername ?>' value="<?= $val; ?>">
    <ul class="search-wrapper">
      <li class="dropdown sortby">
        <a href="#" class="btn top-btn" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-sort-amount-desc"></i> Sort By</a>
        <div class="dropdown-menu dropdown-menu-right text-left">
          <h4 class="dropdown-header">Sort By Cash Certificate Offers</h4>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item pboo-filter" data-search="redemptionvalue" data-filter="redemption_high" href="javascript:void(0);">Redemption Value: High to Low</a>
          <a class="dropdown-item pboo-filter"  data-search="redemptionvalue"  data-filter="redemption_low" href="javascript:void(0);">Redemption Value: Low to High</a>
          <a class="dropdown-item pboo-filter"  data-search="redemptionvalue"  data-filter="deal_price_high" href="javascript:void(0);">Pay Business Deal Price: High to Low</a>
          <a class="dropdown-item pboo-filter"  data-search="redemptionvalue"   data-filter="deal_price_low" href="javascript:void(0);">Pay Business Deal Price Low to High</a> 
          <!-- <a class="dropdown-item pboo-filter"  data-search="redemptionvalue"  data-filter="high to low" href="javascript:void(0);">Net Savings: High to Low</a>
          <a class="dropdown-item pboo-filter"  data-search="redemptionvalue"  data-filter="low to high" href="javascript:void(0);">Net Savings: Low to High</a> -->
          <a class="dropdown-item pboo-filter"  data-search="redemptionvalue"  data-filter="a-z" href="javascript:void(0);">Business Name: A to Z</a>
          <a class="dropdown-item pboo-filter"  data-search="redemptionvalue" data-filter="z-a" href="javascript:void(0);">Business Name: Z to A</a>
        </div>
      </li>
      
      <li class="dropdown dropdown1">
      <?php if(empty($userid)) {   ?>
        <a href="javascript:void(0);" class="favbus btn top-btn clicksnapsignup" data-target="#login-box" data-toggle="modal"><i class="fa fa-heart menu-icon red"></i>&nbsp;Saved Favs!</a>
      <?php }else{?>
        <a href="javascript:void(0);" class="favbus btn top-btn show_favorites_ads" ><i class="fa fa-heart menu-icon red"></i>&nbsp;Saved Favs!</a>
        <?php } ?>
      </li> 
      
      <li class="dropdown dropdown2">
        <a class="btn dropdown-toggle  top-btn" data-toggle="dropdown" href="#"><i class="fa fa-sort-alpha-asc menu-icon green"></i>&nbsp; Alpha (A-Z)</a>
          <ul class="dropdown-menu w300">
            <li style="list-style:none;">
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

                <hr/>
                <p style="text-align:center;">
                  Click Button to Activate Search!
                </p>
              </div>
            </li>
          </ul>
      </li>

      <li class="search-container">                                
        <div id="search_box" style="background:none;">
          <div id="search_input_box">
            <input class="search_cont form-control" data-search="businessname"  type="text" placeholder="Search by Business Name" name="business-name"/>
            <a class="search_cont_but form-control businessNameSearch" style=""><i class="fa fa-search"></i></a>
          </div>
        </div> 
      </li>

      <li class="viewFilters">
        <div class="container">           
          <ul>
            <li><p class="filterviewtext">Deals Per Row Viewable:</p></li>
         <!--      <li> 
                <a href="javascript:return void(0);" data-view="full" class="theme-btn"> [1]</a> 
              </li> -->
            <li> 
              <a href="javascript:return void(0);" data-view="compact" class="theme-btn active">[2]</a> 
            </li>
            <li> 
              <a href="javascript:return void(0);"   data-view="grid"  class="gridview theme-btn ">[3]</a> 
            </li>
            <li> 
              <a href="javascript:return void(0);"   data-view="fourgrid"  class="gridviewfour theme-btn">[4] </a> 
            </li>
          </ul>
        </div>
      </li>
    </ul>
    
    <ul class="searched_param"></ul>
  </div>
</div>


 


