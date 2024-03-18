<div class="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="zoneresultmodal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">			
			<h2><center id="headertitle">Zone Detail</center></h2>			
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div id="zonedetaildiv">
								<p id="zonename"></p>
								<p id="zoneuser"></p>
								<p id="zonepass"></p>
							</div>
							<div id="zipexistsdiv">
								<div class="mb-3 mt-3">
									<label for="comment">Username:</label>
      								<input type="text" disabled class="form-control" id="genusername">
      								<br>
      								<label for="comment">Zip:</label>
      								<textarea class="form-control existszip" rows="5" name="text"></textarea>
      								<br>
      								<button type="button" id="reassign" class="btn btn-primary ">Re Assign</button>
      							</div>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="snapPop9category">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #198754;color: #fff;">
        <h4 class="modal-title" id="myModalLabel">Update Category</h4>
        <button type="button" class="close closeupdate" id="category_close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
          <input type="text" name="category" class="form-control divset" id="updateimagecategory" placeholder="Update Category">
        </div>
      </div> 
      <div style="background: #198754;color: #fff;">
        <button type="button" class="btn btn-success updatecategory">Update</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="imagepreview">
 	<div class="modal-dialog" role="document">
		<div class="modal-content">
    	<div class="modal-body">
      	<h4 class="modal-title" id="myModalLabel">Preview Image</h4>
        <button type="button" class="close closeprev" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <div class="col-md-12">
          <img style="width: 100%;" id="previmg" src=""/>
        </div>
      </div> 
    </div>
  </div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="snapPop9">
 	<div class="modal-dialog" role="document">
   	<div class="modal-content">
      <div class="modal-header" style="background: #198754;color: #fff;">
        <h4 class="modal-title" id="myModalLabel">Update Image</h4>
        <button type="button" class="close closeupdate" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        	<div class="col-md-6">
          	<input type="hidden" name="update" value="1" />
          	<input type="hidden" id="imageID" name="imageid" value="1" />
          	<select style="width: 100%;" class="form-control divset" id="updatecategory" name="imagecategory">
            	<option value>Select Image Category</option> 
          	</select>
        	</div>
        	<div class="col-md-6">
          	<input style="width: 100%;" type="file" id="image" class="form-control divset" name="image[]" multiple placeholder="Upload Image">
        	</div>
        	<div class="col-md-12">
          	<img style="width: 100%;" id="updateprev" src=""/>
        	</div>
        	<div class="col-md-12" id="preview">
          	<img style="width: 100%;" id="updateprev" src=""/>
        	</div>
        	<div class="col-md-12"></div>
      	</form>
     	</div> 
			<div style="background: #198754;color: #fff;">
      	<button type="button" class="btn btn-success divset1" id="updateImage">Update</button>
      </div>
   	</div>
  </div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="snapPop9catsub">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #198754;color: #fff;">
        <h4 class="modal-title" id="myModalLabel">Update Image</h4>
        <button type="button" class="close closeupdate" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
          <div class="col-md-6">
            <input style="width: 100%;" type="file" id="scrapcatimage" class="form-control" name="scrapcatimage[]" multiple placeholder="Upload Image">
            <input type="hidden" id="scrapcategoryinput" value=""/>
            <input type="hidden" id="scrapsubcategoryinput" value=""/>
          </div>
          <div class="col-md-12">
            <img style="width: 100%;" id="updateprevcatsub" src=""/>
          </div>
          <div class="col-md-12" id="previewscrap">
            <img style="width: 100%;" id="updateprevcatsub" src=""/>
          </div>
          <div class="col-md-12"></div>
        </form>
      </div> 
      <div style="background: #198754;color: #fff;">
        <button type="button" class="btn btn-success divset1" id="updatecatsubImage">Update</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="emailhistorymodal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #198754;color: #fff;">
        <h4 class="modal-title" id="emailhistorydetail">Add Email Detail</h4>
        <button type="button" class="close closeupdate" id="email_close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="emailid"/>
        <div class="row">
          <div class="col-md-4">
            <label>Categories of Emails</label>
          </div> 
          <div class="col-md-8">
            <select class="form-control" id="emailcategory">
              <option value>Select One</option>
              <option value="Health/Safety">Health/Safety</option>
              <option value="Recreation/Activities/Events">Recreation/Activities/Events</option>
              <option value="Planning/ New Development">Planning/ New Development</option>
            </select>
          </div> 
        </div><br>
        <div class="row">
          <div class="col-md-4">
            <label>Emails Address</label>
          </div> 
          <div class="col-md-8">
            <input type="email" class="form-control" id="email" placeholder="Enter Email Address">
          </div> 
        </div><br>
        <div class="row">
          <div class="col-md-4">
            <label>Emails Content</label>
          </div> 
          <div class="col-md-8">
            <textarea id="emaildetail" class="form-control" style="height: 160px !important;"></textarea>
          </div> 
        </div>
      </div> 
      <div style="background: #198754;color: #fff;">
        <button type="button" class="btn btn-success saveemaildata">Save</button>
      </div>
    </div>
  </div>
</div>