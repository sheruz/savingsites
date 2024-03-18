<div class="page-wrapper main-area toggled ranks_sponser">
	<div class="container">
		<div class="row">
			<div class="top-title">
        		<h2>Rank Business Subcategory</h2>
        		<p>Rank your business subcategories for the deals page.</p>
        		<hr class="center-diamond">
        		<?php if(count($subcatnew)> 0){?>
        		   <input type="hidden" id="subcatnew" value="<?= $subcatnew ?>"/>
        	    <?php }?>
      		</div>
			<input type="hidden" value="<?= $loginzoneid; ?>"  id="loginzoneid"/>
			<div style="text-align: right;width: 100%;padding-right: 80px;">Re Arrange Sub Categories Business By Bid: <button type="button" class="btn btn-info" id="rearrangesubbusiness">Re-Arrange</button></div>
			<div class="col-sm-12">
        		<div class="view_non_temp_business bv_draggable_list" id="view_sponsored_business" >
        			<ul id="sortable1">
        				<?php 
        					if(count($all_sponsored_business_subcat) > 0){
        						$i = 0;
        						foreach ($all_sponsored_business_subcat as $k => $v) {
        							$i++;
	        						if(count($subcatnew)> 0){
	        							echo '<li class="draggable_div1" zone_id="'.$zoneid.'" subcat="'.$subcatnew.'" style="position:relative;list-style:none;" businessid ="'.$v['business_id'].'"  data-adid="'.$v['adid'].'" id="'.$v['business_id'].'"><p>'.$v['name'].'</p> <button class="counter" title="sponsor Order">'.$i.'</button></li>';
	        						}
        						}
        					}

        				?>
        			</ul>
        		</div>
  			</div>
		</div>
	</div>
</div>
 