<div class="page-wrapper main-area toggled create_deal">
	<div class="container">
    <div class="row" style=" margin-bottom: 80px;">
      <div class="top-title">
        <h2> View Deals</h2>
        <hr class="center-diamond">
        <p>The deals created by all business are listed below:</p>
      </div>

      <table class="display responsive-table datatable-all" cellspacing="0" width="100%" id="makenewad"> 
        <thead>
          <tr>
            <th scope="col">Business Name</th>
            <th scope="col">Contact Name</th>
            <th scope="col">Contact Email</th>
            <th scope="col">phone Number</th>
            <th scope="col">ZipCode</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($businessArr as $k => $v) { ?>
          <tr>
            <td><?= $v['name']; ?><br>(<?= $v['id']; ?>)</td>
            <td><?= $v['contactfirstname'].' '.$v['contactlastname']; ?></th>
            <td><?= $v['contactemail']; ?></th>
            <td><?= $v['phone']; ?></th>
            <td><?= $v['zip_code']; ?></th>
            <td>
              <span class="adddeal cus-solid-blue tab-view-btn" busid="<?= $v['businessid'];?>" busname="<?= $v['name']; ?>" zoneid="<?= $zone_id; ?>">+ Add Deal </span>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <div class="container hide" id="createdealdiv">
        <div class="row">
          <div class="col-md-12">
            <p id="closedeal">Close <i class="fa fa-window-close" aria-hidden="true"></i></p>
            <div class="top-title">
              <h2> Create Deals</h2>
              <hr class="center-diamond">
              <p>Deal Certificate Selection</p>
              <p>Choose one of the preset options below to begin creating your deal certificate.</p>
              
            </div>
            <form name="auctioncreate" method="post" class="auctioncreate" enctype="multipart/form-data"  action="">
              <div class="form-control row">
                <div class="col-sm-12">
                  <table class="deal_option">
                    <tr class="tbl_head"> 
                      <th>Preset<br/> Option</th>               
                      <th>Redemption <br/>Value</th>
                      <th>Discounted Price<br/> Paid Business</th>
                      <th>Maximum Number Of Certificates <br/> Offered</th>
                      <th>Donation Claiming Fee</th>
                    </tr>
                    <?php  foreach ($pbcashcert as $key ) {  ?> 
                    <tr>    
                      <td><input type="radio" name="deal" class="sortlisttags" <?php  if(@$editdata[0]['selected_deal'] == $key['id']){ echo 'checked';   } ?>    data-id="<?php echo $key['id'] ?>"  >           
                      </td>            
                      <td ><?php echo '$'.$key['dealRedemption'] ?></td>
                      <td><?php echo '$'.$key['discountedPrice'] ?></td>
                      <td><?php echo $key['numberOfDeals'] ?></td>
                      <td><?php echo  '$'.$key['donationClaimingFee'] ?></td>
                    </tr>
                  <?php } ?>
                </table>
              </div>
              <div class="col-sm-5"></div>
            </div>
            
            <div class="form-control row divided">
              <div class="col-sm-6 left_col">
                <div class="peekaboo_cat" <?php if(@$_GET['mode'] != 'edit'){ echo 'style="display: none;"' ; } ?>>
                  <div class="form_col">
                    <label for="id_contact">Business Name<i class="required">*</i></label>
                    <p>The business name associated with this certificate.</p>
                    <input name="company_name"  readonly type="text" class="comment" id="company_name" value="<?php //echo $common['sub_header_name_from_zone']['name']; ?>" size="50" />
                  </div>

                  <div class="form_col radio-label  " <?php if(@$_GET['mode'] == 'edit'){ echo 'style="display: none;"' ; } ?>>
                    <label for="Start Date">Do you want your deal to go live now?<i class="required">*</i></label> 
                    <p>Your deal will  not be visible on the deals web page  until you tell us to make  it visible.</p> 
                    <label for="yes" class="left-label"> <input type="radio" class="businessstatus" name="live_status" value="yes">Yes</label> 
                    <label for="no" class="right-label"><input type="radio" class="businessstatus" name="live_status" value="no">No</label>            
                  </div><br/>
                </div>

                <div class="deal_wraper" style="display: none;">
                  <div class="form_col" >
                    <label for="Deal length">Length of Time to Display your Deal.<i class="required">*</i></label> 
                    <p>How long do you want your deal to be available on the deals web page?</p>   
                    <input  type="text"   class=""   class="" value="30"  disabled='disabled' id=""  />
                  </div>

                  <div class="form_col">
                    <label  class="deallengthtext peekaboo_start_date">Time Delay to Display your Deal.<i class="required">*</i></label> 
                    <p class="deallengthtext peekaboo_start_date">How many days do you want to wait  before your deal to be available on the deals web page?</p><label class="startdatetext timelength" for="Start Date">Deal Start Date<i class="required">*</i></label>
                    <p class="startdatetext timelength">The date you want this deal to be visible on the deals web page.</p> 
                    <input name="start_date" type="datetime-local" class="comment" id="start_date" value="">
                  </div> 
                  
                  <div class="form_col">
                    <label for="End Date">Deal End Date<i class="required">*</i></label>
                    <p>The date you want this deal to be end no longer be available to the public.</p> 
                    <input name="end_date" type="datetime-local"  class="comment " id="end_date" value="">          
                  </div> 

                  <div class="form_col">
                    <label for="Redeemption Value">Deal Certificates Available for purchase<i class="required">*</i></label>
                    <p>The Maximum number of required non-expiring certificates you agree to sell within the 30 days.</p>
                    <label>MAX #</label>
                    <input  type="number" style="width:100px" class="comment redemption" name="numberofconsolation" class="numberconsoval noofconsolation_textbox" <?php    //if(@$editdata[0]['numberofconsolation'] == '-1'){ echo 'disabled="disabled"';  }  ?> value="<?php    //if(@$editdata[0]['numberofconsolation'] != '-1'){ echo  trim($editdata[0]['numberofconsolation']);  }else{ echo " "; }   ?>"  id="max_sold_per_auction"  />
                    <span class="bv_or">OR</span>
                    <input type="checkbox" id="unlimited_value" name="numberofconsolation"  <?php //echo ($editdata[0]['numberofconsolation'] == '-1') ? 'checked' :'' ?> >
                    <label for="unlimited_value">Unlimited Certificates</label>    
                  </div>
                  
                  <input name="nobypass" id="nobypass" type="hidden" max="99" maxlength="90" class="comment nobypass" id="nobypass" value="0" />  

                  <div class="form_col post_title_col"  >
                    <label for="Page Title">Page Title <i class="required">*</i></label>
                    <p>This is what others will see when you share your deal on social media.</p>
                    <input name="page_title" type="text"  class="comment" id="page_title" value="<?php  if(@$editdataresponse == 1){ echo $editdata[0]['page_title'];   } ?>" size="10" />
                  </div>
                </div>
              </div>
              
              <div class="col-sm-6 right_col" <?php if(@$_GET['mode'] != 'edit'){ echo 'style="display: none;"' ; } ?>>
                <div class="form_col">
                  <label for="Redeemption Value">Redemption Value($)<i class="required">*</i></label>
                  <p>The value of goods or services provided to your patrons.</p>
                  <input name="buy_price_decrease_by" type="number"  required <?php  //if($common['usergroup']->group_id != '4'){ echo 'readonly'; } ?>   class="comment redemption" id="buy_price_decrease" value="<?php  //if(@$editdataresponse == 1){ echo $editdata[0]['buy_price_decrease_by'];   } ?>" placeholder="$ 60" size="10" />
                  <input name="redemption_val" type="hidden"  id="redemption_val" value=""/>
                </div>

                <div class="form_col">
                  <label for="Publisher Value">Publisher Fee(<?php echo '$'; ?>)</label><br/>
                  <input name="publisher_fee" type="number"  class="comment publisher_fee" id="publisher_fee"  value="<?php  //if(@$editdataresponse == 1){ echo $editdata[0]['publisher_fee'];   } ?>"  size="10"/>
                </div> 

                <div class="form-form_col">
                  <label for="Starting Price">Discounted Price Paid to the Business($)<i class="required">*</i></label>
                  <input name="low_limit_price" type="number"  required class="comment low_limit_price" id="low_limit_price" value="<?php if(@$editdataresponse == 1){    echo  $editdata[0]['low_limit_price'];  }   ?>  " size="10" > 
                </div>

                <div class="form_col">
                  <label for="card_img">Deal Image upload</label>
                  <p>The image you want the public to see for this deal.</p>

                  <div class="deal_upload_pic">

                           <div class="form-group">
        <label for="card_img" class="attachment">
          <div class="row btn-file">
            <div class="btn-file__preview"></div>
            <div class="btn-file__actions">
              <div class="btn-file__actions__item col-xs-12 text-center">
                <div class="btn-file__actions__item--shadow">
                  <i class="fa fa-plus fa-lg fa-fw" aria-hidden="true"></i>
                  <div class="visible-xs-block"></div>
                  Select file
                </div>
              </div>
            </div>
          </div>
          <input class="comment" name="card_img" type="file" id="card_img">
        </label>
      </div>
                    <input type="hidden" name="uploadedInput" id="uploadedInput" value="" />
                    <input type="hidden" name="zone_id" value="<?= $zone_id; ?>">
                    <input type="hidden" name="business_id" id="business_id" value="">
                    <input type="hidden" name="cat_id" id="cat_id" value="0">
                    <input type="hidden" name="subcatID" id="subcatID" value="0">
                    <span style="display:none;right: 240px;" id="spinner"><img src="<?php echo base_url() ?>assets/images/loading.gif"></span>
                    <div id="show_banner" style="width: 300px;position: relative;"></div>
                    <div style="width: 300px;position: relative;">
                      <img src=""  id="output"/>
                    </div>

                    <span class="error_img_msg" style="color:red;"></span>
                  </div>
                </div>

                <div class="form_col">
                  <label for="Deal Description">Deal Description<i class="required">*</i></label>
                  <p>A brief explanation of your deals.</p>
                  <input name="deal_description" required type="text"  class="comment" id="deal_description" value="<?php  if(@$editdataresponse == 1){ echo $editdata[0]['deal_description'];   } ?>     " placeholder="Enter a brief explanation of your deals." maxlength="70" />
                  <br/><span id="deal_description_feedback"></span>
                </div>

                <div class="form_col">
                  <label for="Meta Description">Meta Description <i class="required">*</i></label>
                  <p>This information helps search engines find your deal.</p>
                  <textarea name="meta_description" class="meta_description" rows="5" cols="5" placeholder="Enter single words separated by commas that are descriptive of your deal."><?php  if(@$editdataresponse == 1){ echo $editdata[0]['meta_description'];   } ?> </textarea>
                </div>

                <div class="form_col ">
                  <label for="Seller">Status<i class="required">*</i></label> <br/>
                  <select name="status" id="status">
                    <option value=''>Select value</option>
                    <option value="Live"  <?php  if(@$editdataresponse == 1){ if($editdata[0]['status'] == 'Live'){ echo 'selected="selected"'; }   }else{  echo 'selected="selected"';} ?> >Active</option>
                    <option value='Public' <?php  if(@$editdataresponse == 1){ if($editdata[0]['status'] == 'Public'){ echo 'selected="selected"'; }   } ?>  >In-Active  </option> 
                  </select>
                </div> 
              </div>
            </div>

            <div class="form-control row footer_btn" <?php if(@$_GET['mode'] != 'edit'){ echo 'style="display: none;"' ; } ?>>
              <div>
                <div class="col-sm-12">
                  <span id="deal_description_link"></span>
                  <div class="form-control2 row btn_row">
                    <div class="col-sm-12">
                      <p class="text" style="display:none;">
                        <label for="id_contact">Upload Gift Certificate<i class="required">*</i><br/>
                          <span>(*.jpg,*.gif,*.png format only) Better display size 600px X 400px</span></label>
                          <?php //if($data['image']){ ?>
                            <img src="<?php //echo UPLOAD_THUMB_IMG_DIR.$data['image']?>" />
                          <?php //}?>
                          <input name="image1" type="file" id="image1" value="<?php //echo ($_FILES['image1']['tmp_name']);?>" size="30" maxlength="30">
                      </p>

                      <p class="text" style="display:none;">
                        <label for="id_contact">Image 1<br/>
                          <span>(*.jpg,*.gif,*.png format only) Better display size 600px X 400px</span></label>
                          <?php //if($data['image2']){?>
                          <img src="<?php //echo UPLOAD_THUMB_IMG_DIR.$data['image2']?>" />&nbsp;&nbsp;<a href="index.php?page=productmanagement&pagetype=addproducts&product_id=<?php //echo $_GET['product_id']?>&delete=image&imagename2=<?php //echo $data['image2']?>"><img src="admin/images/delete.gif" alt="delete" border="0" /></a>
                          <?php //}?>
                          <input name="image2" type="file" id="image2" value="<?php //echo ($_FILES['image2']['tmp_name']);?>" size="30" maxlength="30">
                      </p>

                      <p class="text" style="display:none;">
                        <label for="id_contact">Image 2<br/>
                          <span>(*.jpg,*.gif,*.png format only) Better display size 600px X 400px</span></label>
                          <?php //if($data['image3']){ ?>
                            <img src="<?php //echo UPLOAD_THUMB_IMG_DIR.$data['image3']?>" />&nbsp;&nbsp;<a href="index.php?page=productmanagement&pagetype=addproducts&product_id=<?php //echo $_GET['product_id']?>&delete=image&imagename3=<?php //echo $data['image3']?>"><img src="admin/images/delete.gif" alt="delete" border="0" /></a>
                          <?php //} ?>
                          <input name="image3" type="file" id="image3" value="<?php //echo ($_FILES['image3']['tmp_name']);?>" size="30" maxlength="30">
                      </p>

                      <p class="textarea" style="display:none;">
                        <label for="message" style="float:none;">Technical Description<i class="required">*</i></label>
                        <?php 
                        //if($_POST['tech_description']){$message_body2= $_POST['tech_description'];}else{ $message_body2= $data['tech_description'];}
                        ?>
                      </p>

                      <p class="textarea" style="display:none;">
                        <label for="message" style="float:none;">Other Description<i class="required">*</i></label>
                        <?php //if($_POST['other_description']){$other_description= $_POST['other_description'];}else{ $other_description= $data['other_description'];}
                        ?>
                      </p>
                      
                      <input type="hidden" name="member_type" value="<?= $login_type;?>" />
                      <input type="hidden" name="login_type" value="<?= $login_type;?>" />
                      <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'];?>" />
                      
                      <div class="row text-center">
                        <div class="col-sm-4">
                          <input type="button" name="" id="reset" value="RESET" class="button_large cus-solid-blue cus-btn" >
                        </div>
                        <div class="col-sm-4">
                          <input type="button" name="Submit" id="preview_auction" value="Preview Deal" class="button_large cus-solid-blue cus-btn" onclick="">
                        </div>
                        <div class="col-sm-4">
                          <input type="button" name="Submit" id="submitMessage" value="SAVE CHANGES" class="button_large cus-solid-blue cus-btn" >
                        </div>
                      </div>

                      <input name="mode" type="hidden"  value="<?php //echo $mode; ?>">
                      <input name="product_id" type="hidden" value="<?php //echo $_GET['productid']; ?>">
                    </div>
                  </div>
                </div> 
              </div> 
            </div>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

