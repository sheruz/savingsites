<div id="editAdfromshowad"> 

      <input type="hidden" id="foodimage" value=""/>
      <input type="hidden" id="iseditad" value="0"/>
      <input type="hidden" id="iszoneid" value="<?=$zoneid?>"/>
      <input type="hidden" id="ad_id_fromshowad" name="ad_id_fromshowad" value="-1"/>
      <input type="hidden" id="bus_id_againest_advertisement" name="bus_id_againest_advertisement" value=""/>
      <input type="hidden" id="ad_business_fromshowad" name="ad_business_fromshowad" value=""/>
      <input type="hidden" id="bustype" value=""/>
      <input type="hidden" id="duplicate_business" value=""/>			<!-- Added on 10/6/14-->
      
      <br/>
      <h3>Advertisement Data</h3>
      <br/>
      <p><font color="#FF0000">*</font> fields are mandatory</p>
      <label for="ad_name_fromshowad" style="width:150px; float:left; display:block; padding-right:10px;">Upload File for Presentation on Deemand</label>
      <input type="file" id="docx" name="docx" onchange="return upload_Image('docx','<?php echo site_url("dashboards/upload_docs/docx/businesses_form22");?>','businesses_form22');"/>
      <p>Allowed  formats : (<?php echo strtoupper('docx|doc|pdf');?>) &nbsp;Max Size : ( 1 MB)</p>
      <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
      <div id="logo_image22">
        <input type="hidden" id="docs_pdf" name="docs_pdf" />
      </div>
      <p id="docs_pdf_show" style="display:none;">
        <label for="ad_name_fromshowad" style="width:150px; float:left; display:block; padding-right:10px;">Upload File</label>
        <label id="docs_pdf_1" name="docs_pdf_1"></label>
      </p>
      <p style="display:none;">
        <label for="ad_name_fromshowad" style="width:150px; float:left; display:block; padding-right:10px;">Deal Title</label>
        <input type="text" id="ad_name_fromshowad" name="ad_name_fromshowad"/>
      </p>
      <p>
        <label for="search_engine_title" style="width:150px; float:left; display:block; padding-right:10px;">Deal Title</label>
        <input type="text" id="ad_name_search_engine_title" name="ad_name_search_engine_title" style="width:550px !important; float:left;" onblur="get_search_engine_title(this);"/>
      </p>
      <p> <span style="margin-left:160px;" id="search_engine_title_display" name="search_engine_title_display"></span> </p>
      <p>
        <label for="ad_code_fromshowad" style="width:150px; float:left; display:block; padding-right:10px;">Offer Code</label>
        <input type="text" id="ad_code_fromshowad" name="ad_code_fromshowad" style="width:550px !important;"/>
      </p>
      <p>
        <label for="ad_startdatetime_fromshowad" style="width:150px; float:left; display:block; padding-right:10px;">Start Date Time</label>
        <input type="text" id="ad_startdatetime_fromshowad" name="ad_startdatetime_fromshowad" style="width:550px !important;"/>
      </p>
      <p>
        <label for="ad_stopdatetime_fromshowad" style="width:150px; float:left; display:block; padding-right:10px;">Stop Date Time</label>
        <input type="text" id="ad_stopdatetime_fromshowad" name="ad_stopdatetime_fromshowad" style="width:550px !important;"/>
      </p>
      <!-- date time custom -->
      <div id="ad_cat" >
        <p>
             <b>Select multiple categories and multiple sub categories by holding the "Ctrl" key and a left click on the mouse.</b>
        </p>
        <p>
          <label for="ad_category_fromshowad" style="width:150px; float:left; display:block; padding-right:10px;">Category</label>
          <select id="ad_category_fromshowad" name="ad_category_fromshowad" onchange="business_cat()" multiple="multiple" size="10">
            <!--<option value="0"> --- Select Category --- </option>-->
            <? foreach ($category_list1 as $category) { ?>
                
                <option class='optioncategory' value=<?php echo $category['id']?><?php if($category['id']=='-99'){?> disabled="disabled" <?php } ?>><?php echo $category['name']?> </option>
            <? }?>
          </select>
        </p>
      </div>
      

      <div class="food_icon_image" style="display:none;"> <a href="javascript:void(0);" title="american" class="food_icon_image_normal checkclass" rel="1"><img src="../../assets/images/food_icons/white/american.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="asian" class="food_icon_image_normal checkclass" rel="2"><img src="../../assets/images/food_icons/white/asian.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="bakery" class="food_icon_image_normal checkclass" rel="3"><img src="../../assets/images/food_icons/white/bakery.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="banquet" class="food_icon_image_normal checkclass" rel="4"><img src="../../assets/images/food_icons/white/banquet.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="bbq" class="food_icon_image_normal checkclass" rel="5"><img src="../../assets/images/food_icons/white/bbq.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="catering" class="food_icon_image_normal checkclass" rel="6"><img src="../../assets/images/food_icons/white/catering.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="chicken" class="food_icon_image_normal checkclass" rel="7"><img src="../../assets/images/food_icons/white/chicken.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="chinese" class="food_icon_image_normal checkclass" rel="8"><img src="../../assets/images/food_icons/white/chinese.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="coffee" class="food_icon_image_normal checkclass" rel="9"><img src="../../assets/images/food_icons/white/coffee.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="convenience" class="food_icon_image_normal checkclass" rel="10"><img src="../../assets/images/food_icons/white/convinence.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="deli" class="food_icon_image_normal checkclass" rel="11"><img src="../../assets/images/food_icons/white/deli.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="delivery" class="food_icon_image_normal checkclass" rel="12"><img src="../../assets/images/food_icons/white/delivery.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="diners" class="food_icon_image_normal checkclass" rel="13"><img src="../../assets/images/food_icons/white/diners.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="fastfood" class="food_icon_image_normal checkclass" rel="14"><img src="../../assets/images/food_icons/white/fastfood.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="fine_dining" class="food_icon_image_normal checkclass" rel="15"><img src="../../assets/images/food_icons/white/fine_dining.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="fish" class="food_icon_image_normal checkclass" rel="16"><img src="../../assets/images/food_icons/white/fish.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="food_trucks" class="food_icon_image_normal checkclass" rel="17"><img src="../../assets/images/food_icons/white/food_trucks.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="french" class="food_icon_image_normal checkclass" rel="18"><img src="../../assets/images/food_icons/white/french.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="fusion" class="food_icon_image_normal checkclass" rel="19"><img src="../../assets/images/food_icons/white/fusion.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="greek" class="food_icon_image_normal checkclass" rel="20"><img src="../../assets/images/food_icons/white/greek.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="grocery" class="food_icon_image_normal checkclass" rel="21"><img src="../../assets/images/food_icons/white/grocery.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="indian" class="food_icon_image_normal checkclass" rel="22"><img src="../../assets/images/food_icons/white/indian.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="italian" class="food_icon_image_normal checkclass" rel="23"><img src="../../assets/images/food_icons/white/italian.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="japanese" class="food_icon_image_normal checkclass" rel="24"><img src="../../assets/images/food_icons/white/japanese.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="market" class="food_icon_image_normal checkclass" rel="25"><img src="../../assets/images/food_icons/white/market.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="meat" class="food_icon_image_normal checkclass" rel="26"><img src="../../assets/images/food_icons/white/meat.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="mexican" class="food_icon_image_normal checkclass" rel="27"><img src="../../assets/images/food_icons/white/mexican.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="no-reserve" class="food_icon_image_normal checkclass" rel="28"><img src="../../assets/images/food_icons/white/no-reserve.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="organic" class="food_icon_image_normal checkclass" rel="29"><img src="../../assets/images/food_icons/white/organic.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="others" class="food_icon_image_normal checkclass" rel="30"><img src="../../assets/images/food_icons/white/others.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="pizza" class="food_icon_image_normal checkclass" rel="31"><img src="../../assets/images/food_icons/white/pizza.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="pizza_cook" class="food_icon_image_normal checkclass" rel="32"><img src="../../assets/images/food_icons/white/pizza-cook.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="reserve_suggest" class="food_icon_image_normal checkclass" rel="33"><img src="../../assets/images/food_icons/white/reserve_suggest.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="reserved" class="food_icon_image_normal checkclass" rel="34"><img src="../../assets/images/food_icons/white/reserved.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="salad" class="food_icon_image_normal checkclass" rel="35"><img src="../../assets/images/food_icons/white/salads.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="seafood" class="food_icon_image_normal checkclass" rel="36"><img src="../../assets/images/food_icons/white/seafood.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="sportbar" class="food_icon_image_normal checkclass" rel="37"><img src="../../assets/images/food_icons/white/sportsbar.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="steak" class="food_icon_image_normal checkclass" rel="38"><img src="../../assets/images/food_icons/white/streak.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="desserts" class="food_icon_image_normal checkclass" rel="39"><img src="../../assets/images/food_icons/white/subs.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="sushi" class="food_icon_image_normal checkclass" rel="40"><img src="../../assets/images/food_icons/white/sushi.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="take-out" class="food_icon_image_normal checkclass" rel="41"><img src="../../assets/images/food_icons/white/takeaway.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="thai" class="food_icon_image_normal checkclass" rel="42"><img src="../../assets/images/food_icons/white/thai.png" height="30" alt=""/></a> <a href="javascript:void(0);" title="veg" class="food_icon_image_normal checkclass" rel="43"><img src="../../assets/images/food_icons/white/veg.png" height="30" alt=""/></a> </div>
      <br clear="all" />
      <div class="food_menu" style="display:none;">
        <label for="ad_name_fromshowad" style="width:150px; float:left; display:block; padding-right:10px;">Upload File for Menu</label>
        <input type="file" id="docx_foodmenu" name="docx_foodmenu" onchange="return upload_Image('docx_foodmenu','<?php echo site_url("dashboards/upload_docs_foodmenu/docx_foodmenu/businesses_form22");?>','businesses_form22');"/>
        <p>Allowed  formats : (<?php echo strtoupper('docx|doc|pdf');?>) &nbsp;Max Size : ( 1 MB)</p>
        <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
        <div id="logo_image222">
          <input type="hidden" id="docs_foodmenu" name="docs_foodmenu" />
        </div>
        <p id="docs_foodmenu_show" style="display:none;">
          <label for="ad_name_fromshowad" style="width:150px; float:left; display:block; padding-right:10px;">Upload File</label>
          <label id="docs_pdf_foodmenu" name="docs_pdf_foodmenu"></label>
        </p>
      </div>
      <div id="ad_subcategory_fromshowad1" style="display:none"> </div>
      <div style="clear:both;"></div>
      
      <p>
        <label for="ad_text_fromshowad">Ad Details</label>
        <textarea id="ad_text_fromshowad"  name="anish"></textarea>
        <?php //echo display_ckeditor($ckeditor_anish); ?> 
       </p>
       
      <p style="display:none;">
        <label for="text_message_fromshowad" style="width:150px; float:left; display:block; padding-right:10px;">Text Message</label>
        <textarea rows="10" cols="45" style="width: 425px; height: 150px" id="text_message_fromshowad" name="text_message_fromshowad"></textarea>
      </p>
      <?=form_close()?>
      <button style="margin-left:160px;" onclick="saveAdfromshowad($(this).prev('form'))">Update</button>
      <button <?php /*?>onclick="CancelAdEdit()"<?php */?> onclick="cancel_add_edit($(this).prev('form'))">Back</button>
    </div>