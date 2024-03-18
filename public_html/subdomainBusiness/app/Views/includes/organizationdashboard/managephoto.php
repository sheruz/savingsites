<input type="hidden" name="zoneid" id="zoneid" value="<?=$zoneid;?>" />
<input type="hidden" name="orgnid" id="orgnid" value="<?=$org_id;?>" />
<input type="hidden" name="orgzoneid" id="orgzoneid" value="<?=$fromzoneid;?>" />
<input type="hidden" name="org_id" id="org_id" value="<?=$org_id;?>" />
<?php if(($organization_status==1 || $group_id==4)){?>		
  <div class="main_content_outer"> 
    <div class="content_container">
    <?php if($fromzoneid!='0'){?>
      <div class="spacer"></div>
        <div class="manage-photo-heading">
          <div class="main main-large main-100">
            
          </div>
        </div>
      </div>

<?php }?>
  <div id="container_tab_content" class="container_tab_content manage-photo">
    <ul id="tabs-nav">
      <li class="active"><a href="#tab1">Add Photo</a></li>
      <li><a href="#tab2">Photos</a></li>
    </ul>
    <div class="tabs managephoto">
      <div id="tabs-content">
        <div id="tab1" class="tab-content bv_mange_photos" style="display: none;">
          <div class="top-title">
            <h2>Add Photo</h2>
            <hr class="center-diamond">
          </div>
          <div class ="row">
            <span style=" color: #454cad; margin-bottom: 18px; text-align: center; font-weight: bolder;font-size: 15px;">First pick a category, and then upload the image.<br>Add category for your organization if category is not available. </span>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div style="width: 100%;padding:0px 60px 0px 0px;" id="showdiv" class="myclass">
                <label for="allcategories" class="fleft w_150 " style="margin-top:20px">Category Name</label>
                <select id="allcategories" name="allcategories" class="w_315 " style="margin-top:10px"></select>
              </div>
            </div>
            
          <div class="col-md-6"> 
            <form name="frm_banner" id="add_banner_forzone" method="post" enctype="multipart/form-data" action="javascript:void(0);" class="uploader">
              <input id="imgfileorg" onchange="loadFile(event)" type="file" name="imgfileorg" accept="image/*">       
              <input type="hidden" name="uploadedInput" id="uploadedInputorg" value="" />  
              <label for="imgfileorg" id="file-drag">
              <img id="file-image" src="#" alt="Preview" class="hidden">
              <div id="start">
                <img src="https://savingssites.com/assets/images/picture.png" style="width: 65px;">
                <div>Browse Files to upload</div>
                <div id="notimage" class="hidden">Please select an image</div>
                <span id="file-upload-btn" class="btn btn-primary">Browse Files</span>
              </div>
              <script>
              jQuery( document ).ready(function() {
                jQuery('.btn-primary').on('click',function(){
                jQuery('div #showdiv').removeClass('myclass');
                });
              });
              </script>
              <div id="response" class="hidden">
                <div id="messages"></div>
                <progress class="progress" id="file-progress" value="0">
                  <span>0</span>%
                </progress>
              </div>
              </label>
          </div>
        </div>
        <div>
          <img id="output" class="org_image_output" style="width: 300px;"/>
        </div>
        <input type="button" onclick="save_org_photo()" name="Save" value="Save" class="bttn zone-upload-submit cus-btn">
      </form>
    </div>
    
    <!-- Tab 2(org photo view cat wise) Start -->
    <div id="tab2" class="tab-content" style="display: none;">
      <div class="form-group">
        <div id="photo_tab" class="drag_drop_col">
          <div class="top-title">
            <h2>Photos</h2>
            <p><p>Drag and Drop Images To Change Photo Position</p></p>
            <hr class="center-diamond">
          </div>
          <div class="row">
            <div class="col-lg-3"></div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="allcategories1" class="fleft w_150 ">Category Name :</label>
                  <select id="allcategories1" name="allcategories1" onchange="view_org_photo();"></select>
                </div>
              </div>
              <div class="col-lg-3"></div>
          </div>
          <div class="row">
            <div class="col-lg-2"></div>
              <div class="col-lg-8" id="orgimagelist">
                
              </div>
              <div class="col-lg-2"></div>
          </div>
        </div>
        <div id="banner_details" style="display:none; margin-top:10px;"></div>
        <div id="org_photo_details" style="display:none; margin-top:10px;"></div>
        <?php /*?><div id="banner_list" style="margin-top:10px;">
        <div id="contentRight" >
          <ul>
            <?php if(!empty($all_banner)) { ?>
              <?php foreach($all_banner as $ab){ 
                $banner_path=!empty($ab['zone_id']) ? $ab['zone_id'] : "default";
              ?>
              <li id="banner_<?=$ab['id']?>" >
                <span class="dragdropimage"><img src="../../uploads/banner/<?php echo $banner_path;?>/<?=$ab['image_name']?>" width="220px"/></span>
                <div style="margin-top:5px;">
                  <button id="<?=$ab['id']?>" class="editgrp" onclick="edit_banner(<?=$ab['id']?>,<?=$zone_id?>,'<?=$banner_path?>')">Edit</button>
                  <button id="<?=$ab['id']?>" class="deletegrp" onclick="delete_banner(<?=$ab['id']?>,<?=$zone_id?>,'<?=$banner_path?>','<?=$ab['image_name']?>')">Delete</button>
                </div>
              </li>
            <? } }
              else
              {
            ?>
            <li>No Banner Found.</li>
          <?php	} ?>
          </ul>
        </div>
        </div><?php */?>
      </div>
    </div>
    <!-- Tab 2 End -->
    </div></div>
  </div>
</div>
</div>
<?php } else if($organization_status==-1 && $group_id==8){?>
  <div class="main_content_outer"> 
    <div class="content_container">
      <div class="container_tab_header">Manage Photo</div>
      <div style="font-size:20px; line-height:25px; color:red;">Your organization is currently deactivated. Please contact your Zone Owner for more details.</div>
    </div>
  </div>
<?php } ?>
</div>