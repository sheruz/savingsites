<style>
   .bithide{
  width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    background: #fff;
}
</style>
<div class="page-wrapper main-area toggled">
	<div class="container">
    	<div class="row" style=" margin-bottom: 80px;">
     		<div class="container" id="createdealdiv">
        		<div class="viewads">
   					<div class="row justify-content-center mt-0">
    					<div class="col-sm-6 col-md-12 text-center">
        					<div class="card">
            					<h2><strong>Business short Url</strong></h2>
            					<p>A business short url show below.</p>
            					<div class="row">
               						<div class="col-md-12 mx-0">
                  						<div id="msform">
                  							<fieldset>
                           						<div class="form-card">
                              						<div class="row">
                                 						<div class="col-md-2">
                                    						<label for="name">Short Url : </label><br>
                                 						</div>
                                 						<div class="col-md-4">
                                    						<div class="busiessshorturl showshorturl"> 
                                    							<?= $businessshorturl;?>
                                    						</div>
                                    						<input type="text" class="busiessshorturl hide editshorturl" id="shorturlchange" value="<?= $businessshorturl;?>"/>
                                 						</div>
                                 						<div class="col-md-6">
                                 							<i link="<?= $buinessshareurl.'/'.$businessshorturl;?>"class="fa fa-copy copyshorturl float"></i>
                                 							<i link="<?= $buinessshareurl.'/'.$businessshorturl;?>"class="fa fa-edit editshorturlicon float"></i>
                                 							<button type="button" class="btn btn-success updateshorturl hide float width50">Update</button>
                                 						</div>
                              						</div>
                           						</div>
                         					</fieldset>   
                         				</div>
               						</div>
            					</div>
         					</div>
      					</div>
    				</div>
  				</div>
			</div>
		</div>
	</div>
</div>