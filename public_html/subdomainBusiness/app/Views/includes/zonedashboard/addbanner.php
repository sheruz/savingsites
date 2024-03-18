<div class="page-wrapper main-area toggled banner-add">
	<div class="container">
    <div class="row">
      <div class="top-title">
        <h2> Add Banner</h2>
        <hr class="center-diamond">
      </div>
  </div>

<div class="row ban-row">

        <div class="col-md-6">
                          <form name="frm_banner" id="add_banner_forzone" method="post" enctype="multipart/form-data"  action="javascript:void(0);" class="uploader">
          <input id="imgfile" onchange="loadFile(event)" type="file" name="imgfile" accept="image/*" />
          <div class="row">
            <div class="col-md-12">          
              <label for="imgfile" id="file-drag">
            <img id="file-image" src="#" alt="Preview" class="hidden">
            <div id="start">
              <img src="https://cdn.savingssites.com/picture.png" style="width: 65px;">
              <div>Drop your image here or Browse Files</div>
              <div id="notimage" class="hidden">Please select an image</div>
              <span id="file-upload-btn" class="btn btn-primary">Browse Files</span>
            </div>
            <div id="response" class="hidden">
              <div id="messages"></div>
              <progress class="progress" id="file-progress" value="0">
                <span>0</span>%
              </progress>
            </div>
          </label></div>
          </div>
        </form>
        </div>
        <div class="col-md-6">
          <div class="row">
            
              <div class="col-md-12">

              

<div class="filter">
  <div class="filter__container">
    <div class="filter__list">
      <div class="filter__item filter__item_is-active">
        <label class="filter__label filter__label_internet" for="internet">Status</label>
        <div class="filter__input input input_toggle input_theme_light">
          <input class="input__source" id="internet" type="checkbox" name="filter-toggle" checked="checked"/>
          <label class="input__label" for="internet"></label>
        </div>
      </div>
    </div>
  </div>
</div>
              </div>
             
             
              <div class="col-md-12" style="    margin-bottom: 15px;">
                 <label class="no-label">Banner Link:</label>
                <input type="text" name="set_banner" class="form-control" placeholder="Please use http:// or www before on url Link">
                  <!-- <span class="bv_url_links">(Please use http:// or www before on url Link)</span> -->
                   </div>
                  
              <div class="col-md-12">
                <label class="no-label">Banner Link:</label>
                <select multiple data-placeholder="Add Link">
    <option>Directory</option>
    <option selected>Business Search</option>
    <option>Peekaboo</option>
    <option>Dining</option>
    <option>Webinar</option>
</select>

<!-- dribbble -->
<a class="dribbble" href="https://dribbble.com/shots/5112850-Multiple-select-animation-field" target="_blank"><img src="https://cdn.dribbble.com/assets/dribbble-ball-1col-dnld-e29e0436f93d2f9c430fde5f3da66f94493fdca66351408ab0f96e2ec518ab17.png" alt=""></a>
              </div>

              <div class="col-md-12">
                <input type="submit" name="Submit" value="Submit" class="bttn pull-left">
                <input type="submit" name="back" value="Back" class="bttn pull-right">
              </div>
            
            
          </div>
        </div>
    </div>
</div>
</div>

