<div class="page-wrapper main-area toggled emailformatpage">
	<div class="container">
		<div class="row">
	    	<div class="top-title">
        		<h2>Show Business Sponsor Banner</h2>
        		<p>Sponsor banner saved, Show on this page</p>
        		<hr class="center-diamond">
      		</div>
		</div>
		<div class="row">
			
			

  
            <div id="container_tab_content" class="container_tab_content">        
            	<div id="container">
            		<div class="row">
            			<div class="col-md-12">
            				<table class="" id="sponsertable">
            					<tr>
            						<th>Business Name</th>
            						<th>Sponsor Banner</th>
            						<th>Action</th>
            					</tr>
            					<?php 
            					if(count($busArr) > 0){
            						foreach ($busArr as $k => $v) {
            							echo '<tr><td>'.$v->businessname.'</td><td><img style="width:250px;max-height:250px;" src="'.$amazonurl.'/'.$v->image.'"/></td><td><i class="fa fa-edit"></i> <i class="fa fa-trash"></i></td></tr>';
            						}
            					}
            					?>
            				</table>
            			</div>
            		</div>
            	</div> 
	        </div>
	</div>
   </div>
</div>
 