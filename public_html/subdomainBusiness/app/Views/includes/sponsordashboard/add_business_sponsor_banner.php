<style>
	.select2-selection{
		height: 50px !important;
	}
</style>
<div class="page-wrapper main-area toggled emailformatpage">
	<div class="container">
		<div class="row">
	    	<div class="top-title">
        		<h2> Sponsor</h2>
        		<p>Sponsor banner defined this page, Define sponsor used in email format</p>
        		<hr class="center-diamond">
      		</div>
		</div>
		<div class="row">
			<div id="container_tab_content" class="container_tab_content"> 
			<form id="businesssponserForm" enctype="multipart/form-data" action="" method="post"> 
				<div class="container">
					<div class="row">
						<div class="col-md-4">Select Businessess</div>
						<div class="col-md-8">
							<select class="form-control" id="sponsorbusinessid" multiple>
								<option value="">Select Business</option>
								<?php foreach ($busArr as $k => $v) {
									echo '<option value="'.$v->id.'">'.$v->name.'</option>';
								}
								?>
							</select>
						</div>
					</div><br>
					<div class="row">
						<div class="col-md-4">Select Banner</div>
						<div class="col-md-8">
							<input type="file" id="bannerfile" name="bannerfile" value="" class="form-control" />
						</div>
					</div><br>
					<div class="row">
						<div class="col-md-12">
							<input type="submit" name="buttonsubmit" class="addbusinesssponsorbanner btn" value="Save" class="cus-btn">
						</div>
					</div>
				</div> 
			</form>  
		</div>
	</div>
</div>
 