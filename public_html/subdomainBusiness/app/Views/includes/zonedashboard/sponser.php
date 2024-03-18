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
			<div class="container_tab_header"> Add Sponsor Banner Detail</div>
			<div id="container_tab_content" class="container_tab_content">     
    			<div class="keysform">
    				<form id="sponserForm" enctype="multipart/form-data" action="" method="post">
        			<p class="form-group-row">
                		<label for="username" class="fleft w_100 m_top_0i cus-user">Sponsor Banner :</label> 
                		<input type="file" name="file" value="">
                	</p>
			    	<p class="form-group-row">
                		<label for="text" class="fleft w_100 m_top_0i cus-user">Sponsor Text : </label>
                		<textarea name="text" class="sponsertext"></textarea>
                	</p>
                	<p class="form-group-row">
                		<label for="username" class="fleft w_100 m_top_0i cus-user">Status : </label>
                		<select name="status" class="status">
                			<option value="2" selected>De activated</option>
                			<option value="1">Activated</option>
                		</select>
                	</p>
               		<input type="submit" name="buttonsubmit" class="buttonsubmitsponser btn" value="Save" class="cus-btn">
               </div>
            </div>

            <div class="container_tab_header"> Show Sponsor Banner Detail</div>
            <div id="container_tab_content" class="container_tab_content">        
            	<div id="container">
            		<div class="row">
            			<div class="col-md-12">
            				<table class="" id="sponsertable">
            					<tr>
            						<th>Banner Position</th>
            						<th>Sponsor Banner</th>
            						<th>Sponsor Text</th>
            						<th>Status</th>
            						<th>Action</th>
            					</tr>
            					<?php 
            					if(count($businessArr) > 0){
            						foreach ($businessArr as $k => $v) {
            							if($v['sponseractive'] == 1){
            								$select = '<select ids='.$v['id'].' name="status" class="statuseditchange"><option value="1" selected>Activated</option><option value="2">De activated</option></select>';
            							}else if($v['sponseractive'] == 2){
            								$select = '<select ids='.$v['id'].' name="status" class="statuseditchange"><option value="1">Activated</option><option value="2" selected>De activated</option></select>';
            							}
            							echo '<tr><td>'.$v['counter'].'</td><td><img style="width:250px;max-height:250px;" src="'.$amazonurl.'/'.$v['image'].'"/></td><td>'.$v['text'].'</td><td>'.$select.'</td><td><i class="fa fa-edit"></i> <i class="fa fa-trash"></i></td></tr>';
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
 