<div class="page-wrapper main-area toggled ranks_sponser">
	<div class="container">
		<div class="row">
			<div class="top-title">
        		<h2> My Zone Businesses </h2>
        		<hr class="center-diamond">
      		</div>
			<input type="hidden" value="<?= $loginzoneid; ?>"  id="loginzoneid"/>
			<div style="text-align: right;width: 100%;padding-right: 80px;">Re Arrange Business By Bid: <button type="button" class="btn btn-info" id="rearrangebusiness">Re-Arrange</button></div>
			<div class="col-sm-12">
         		<div class="view_non_temp_business bv_draggable_list" id="view_sponsored_business" >
         		<?php if($all_sponsored_business_details){
         			$i=1;
         			echo "<ul id='sortable'>";
         			foreach ($all_sponsored_business_details as $ordered_business) { ?>
         				<li class='draggable_div' style='position:relative;' id="<?php echo $ordered_business['business_id'];  ?>">
         					<p><?php echo $ordered_business['name'] ?></p>
         				 	<button class='counter' title='sponsor Order' ><?php echo $i; ?></button>
         				</li>
         		<?php $i++; }
         			echo "</ul>";
         			} else{ ?>
         			<div class="container_tab_header" id="not_found">No Sponsor Business Found</div>
         		<?php } ?>
         		</div>
         	</div>
		</div>
	</div>
 